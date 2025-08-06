<?php

namespace Database\Seeders;


use App\Models\Loan;
use Illuminate\Database\Seeder;

class LoansTableSeeder extends Seeder
{
    public function run()
    {
        Loan::create([
            'user_id' => 1,
            'amount' => 1200000,
            'remaining_amount' => 1200000,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(6)->format('Y-m-d'),
            'installments_count' => 6,
            'is_paid' => false
        ]);
    }
}
