<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class InvestmentController extends Controller
{

    public function index()
    {
        $investments = Investment::with('user')->latest()->get();
        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        $users = User::all();
        return view('investments.create', compact('users'));
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

        return redirect()->route('investments.index');
    }
}
