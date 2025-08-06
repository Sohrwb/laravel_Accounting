<?php

namespace Database\Seeders;


use App\Models\Investment;
use Illuminate\Database\Seeder;

class InvestmentsTableSeeder extends Seeder
{
    public function run()
    {
        Investment::create([
            'user_id' => 1,
            'amount' => 500000,
            'month' =>  1
        ]);
    }
}
