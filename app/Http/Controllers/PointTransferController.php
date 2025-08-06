<?php
namespace App\Http\Controllers;

use App\Models\PointTransfer;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointTransferController extends Controller
{
    public function index()
    {
        $transfers = PointTransfer::with(['fromUser', 'toUser'])->latest()->get();
        return view('point-transfers.index', compact('transfers'));
    }

    public function create()
    {
        $users = User::all();
        return view('point-transfers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'from_user_id' => 'required|exists:users,id',
            'to_user_id' => 'required|exists:users,id|different:from_user_id',
            'amount' => 'required|numeric|min:1',
        ]);

        $fromPoint = Point::where('user_id', $data['from_user_id'])->first();

        if (!$fromPoint || $fromPoint->amount < $data['amount']) {
            return back()->withErrors(['amount' => 'موجودی امتیاز کافی نیست.']);
        }

        // کم کردن امتیاز
        $fromPoint->decrement('amount', $data['amount']);

        // اضافه کردن به دریافت‌کننده
        Point::updateOrCreate(
            ['user_id' => $data['to_user_id']],
            ['amount' => DB::raw('amount + ' . $data['amount'])]
        );

        PointTransfer::create($data);

        return redirect()->route('point-transfers.index');
    }
}
