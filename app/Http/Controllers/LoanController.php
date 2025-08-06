<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user')->latest()->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $users = User::all();
        return view('loans.create', compact('users'));
    }

public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|integer|min:100000',
        'installments_count' => 'required|integer|min:1',
        'start_date' => 'required|date',
        'user_id' => 'required|exists:users,id',
    ]);

    // محاسبه تاریخ پایان
    $endDate = \Carbon\Carbon::parse($request->start_date)->addMonths($request->installments_count - 1);

    // ایجاد وام
    $loan = Loan::create([
        'user_id' => $request->user_id,
        'amount' => $request->amount,
        'installments_count' => $request->installments_count,
        'start_date' => $request->start_date,
        'end_date' => $endDate,
        'is_paid' => false,
    ]);

    // ایجاد اقساط
    $installmentAmount = floor($request->amount / $request->installments_count);
    $start = \Carbon\Carbon::parse($request->start_date);

    for ($i = 0; $i < $request->installments_count; $i++) {
        LoanPayment::create([
            'loan_id' => $loan->id,
            'amount' => $installmentAmount,
            'due_date' => $start->copy()->addMonths($i),
            'is_paid' => false,
        ]);
    }

    return redirect()->route('loans.index')->with('success', 'وام با اقساط با موفقیت ثبت شد.');
}




    public function show(Loan $loan)
    {
        $loan->load('payments');
        return view('loans.show', compact('loan'));
    }
}
