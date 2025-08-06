<?php


namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        Transaction::create([
            'user_id' => 1,
            'type' => 'investment',
            'amount' => 500000,
            'date' => now()->format('Y-m-d'),
            'loan_id' => null
        ]);

        Transaction::create([
            'user_id' => 1,
            'type' => 'loan_payment',
            'amount' => 200000,
            'date' => now()->format('Y-m-d'),
            'loan_id' => 1
        ]);
    }
}
