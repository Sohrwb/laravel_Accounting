<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanPaymentController extends Controller
{
    public function index()
    {
        $loanPayments = LoanPayment::with(['loan.user'])->latest()->get();
        return view('loan-payments.index', compact('loanPayments'));
    }

    public function create()
    {
        $loans = Loan::all();
        return view('loan-payments.create', compact('loans'));
    }


    public function pay(LoanPayment $payment)
    {
        if ($payment->is_paid) {
            return back()->with('warning', 'این قسط قبلاً پرداخت شده است.');
        }

        DB::transaction(function () use ($payment) {
            // علامت‌گذاری قسط به عنوان پرداخت‌شده
            $payment->update([
                'is_paid' => true,
                'payment_date' => now(),
            ]);

            // بررسی اینکه آیا همه اقساط پرداخت شده‌اند
            $loan = $payment->loan;
            $allPaid = $loan->loanPayments()->where('is_paid', false)->count() === 0;

            if ($allPaid) {
                $loan->update(['is_paid' => true]);
            }

            // ثبت تراکنش پرداخت قسط
            Transaction::create([
                'user_id' => $loan->user_id,
                'loan_id' => $loan->id,
                'amount' => $payment->amount,
                'type' => 'loan_payment',
                'date' => now(),
            ]);
        });

        return back()->with('success', 'قسط با موفقیت پرداخت شد.');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date'
        ]);

        LoanPayment::create($data);

        return redirect()->route('loan-payments.index');
    }
}
