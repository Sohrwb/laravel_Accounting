<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FamiliesTableSeeder::class,
            UsersTableSeeder::class,
            InvestmentsTableSeeder::class,
            PointsTableSeeder::class,
            LoansTableSeeder::class,
            LoanPaymentsTableSeeder::class,
            TransactionsTableSeeder::class,
            PointTransfersTableSeeder::class,
        ]);
    }
}
