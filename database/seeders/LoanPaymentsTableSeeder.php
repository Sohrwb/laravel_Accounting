<?php

namespace Database\Seeders;

use App\Models\LoanPayment;
use Illuminate\Database\Seeder;

class LoanPaymentsTableSeeder extends Seeder
{
    public function run()
    {
        LoanPayment::create([
            'loan_id' => 1,
            'amount' => 200000,
            'payment_date' => now()->format('Y-m-d'),
            'due_date' => now()->addMonth()
        ]);
    }
}
