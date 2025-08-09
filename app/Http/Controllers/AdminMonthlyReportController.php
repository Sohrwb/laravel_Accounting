<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminMonthlyReportController extends Controller
{
    public function index()
    {
       $loansByMonth = Loan::select(
    DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_year"),
    DB::raw('SUM(amount) as total_loans')
)
->groupBy('month_year')
->orderBy('month_year')
->get();

$transactionsByMonth = Transaction::select(
    DB::raw("DATE_FORMAT(date, '%Y-%m') as month_year"),
    DB::raw("SUM(CASE WHEN type = 'investment' THEN amount ELSE 0 END) as total_investment"),
    DB::raw("SUM(CASE WHEN type = 'loan_payment' THEN amount ELSE 0 END) as total_installments")
)
->groupBy('month_year')
->orderBy('month_year', 'desc')
->get();

// ادغام با کلید month_year
$combinedData = $transactionsByMonth->map(function ($transaction) use ($loansByMonth) {
    $loan = $loansByMonth->where('month_year', $transaction->month_year)->first();
    return [
        'month_year' => $transaction->month_year,
        'total_loans' => $loan ? $loan->total_loans : 0,
        'total_investment' => $transaction->total_investment,
        'total_installments' => $transaction->total_installments,
        'total_input' => ($transaction->total_investment + $transaction->total_installments) - ($loan ? $loan->total_loans : 0),
    ];
});

return view('admin.months.index', compact('combinedData'));


    }

    public function show($month)
    {
        $transactions = Transaction::where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), $month)
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.months.show', compact('transactions', 'month'));
    }
}
