<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        return view('transactions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:investment,loan_payment',
            'date' => 'required|date'
        ]);

        Transaction::create($data);

        return redirect()->route('transactions.index');
    }

    public function userTransactions($user_id)
    {
        $transactions = Transaction::where('user_id', $user_id)->latest()->get();
        return view('transactions.user', compact('transactions'));
    }
}
