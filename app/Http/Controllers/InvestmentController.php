<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class InvestmentController extends Controller
{

    public function index()
    {
        $investments = Investment::with('user')->latest()->get();
        return view('investments.index', compact('investments'));
    }

    public function create(User $user)
    {
        $users = User::where('family_id', $user->family_id)->get(); // یا هر محدودیتی که داری

        $currentMonth = Jalalian::now()->getMonth(); // عدد ماه شمسی فعلی

        // تمام سرمایه‌گذاری‌های ماه فعلی
        $currentMonth = now()->month;

// جمع مبلغ پرداخت‌شده برای هر کاربر در ماه جاری
$investments = Investment::where('month', $currentMonth)
    ->select('user_id', DB::raw('SUM(amount) as total_amount'))
    ->groupBy('user_id')
    ->pluck('total_amount', 'user_id'); // خروجی: [user_id => total_amount]
// کلیدها بر اساس user_id برای دسترسی سریع

        return view('investments.create', compact('users', 'currentMonth', 'investments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
            'month' => 'required',
        ]);

        Investment::create($data);

        Transaction::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'type' => 'investment',
            'date' => now(),
        ]);

        return redirect()->back();
    }
}
