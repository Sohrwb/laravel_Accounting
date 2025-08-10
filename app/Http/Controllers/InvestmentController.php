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

    //--------------/ ADMIN /---------------------------[  نمایش فرم سرمایه گزاری ها  ]-----------------------------------------------

    public function index()
    {
        $investments = Investment::with('user')->latest()->get();
        return view('investments.index', compact('investments'));
    }

    //-----------------------------------------[  ساخت سرمایه جدید برای کاربر  ]-----------------------------------------------

    public function create(User $user)
    {
        $currentMonth = now()->month;
        $users = User::where('family_id', $user->family_id)->get();

        $investments = Investment::where('month', $currentMonth)
            ->select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('user_id')
            ->pluck('total_amount', 'user_id');

        $selectedUserId = $user->id;

        return view('investments.create', compact(
            'users',
            'investments',
            'currentMonth',
            'selectedUserId'
        ));
    }

    //-----------------------------------------[  نمایش فرم سرمایه گزاری کاربر  ]-----------------------------------------------

    public function show(User $user)
    {
        $investments = Investment::where('user_id', $user->id)->get();
        return view('investments.show', compact('investments'));
    }

    //-----------------------------------------[  ذخیره مقادیر سرمایه  ]-----------------------------------------------

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'month'  => ['required', 'integer', 'between:1,12'],
        ]);

        // 1. ثبت سرمایه‌گذاری
        $investment = Investment::create([
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'month' => $validated['month'],
        ]);

        // 2. افزایش سرمایه کل کاربر
        $user = User::find($validated['user_id']);
        $user->increment('total_investment', $validated['amount']);

        // 3. ثبت تراکنش
        Transaction::create([
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'type' => 'investment',
            'date' => now(),
        ]);


        return redirect()->back()->with('success', 'سرمایه‌گذاری با موفقیت ثبت شد');
    }
}
