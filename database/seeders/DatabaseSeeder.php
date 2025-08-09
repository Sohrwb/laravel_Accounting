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
          
        ]);


        // چند تا کاربر واقعی از دیتابیس بگیر
        $users = \App\Models\User::all();

        // چند ماه نمونه از سال 1403 (مثلا ماه‌های 1 تا 6)
        $months = [1, 2, 3, 4, 5, 6];

        foreach ($users as $user) {
            foreach ($months as $month) {
                // سرمایه گذاری برای هر کاربر در هر ماه
                \App\Models\Investment::factory()->create([
                    'user_id' => $user->id,
                    'month' => $month,
                    'amount' => rand(100000, 1000000),
                ]);

                // اگر بخوای وام هم بسازی
                $loan = \App\Models\Loan::factory()->create([
                    'user_id' => $user->id,
                    'start_date' => now()->subMonths(rand(1, 12))->format('Y-m-d'),
                    'end_date' => now()->addMonths(rand(1, 12))->format('Y-m-d'),
                    'installments_count' => rand(3, 12),
                    'amount' => rand(5000000, 10000000),
                    'remaining_amount' => rand(0, 5000000),
                    'is_paid' => rand(0, 1),
                ]);

                // ایجاد چند قسط برای این وام
                for ($i = 1; $i <= $loan->installments_count; $i++) {
                    \App\Models\LoanPayment::factory()->create([
                        'loan_id' => $loan->id,
                        'installment_number' => $i,
                        'amount' => intdiv($loan->amount, $loan->installments_count),
                        'due_date' => now()->addMonths($i)->format('Y-m-d'),
                        'is_paid' => (bool)rand(0, 1),
                        'payment_date' => (bool)rand(0, 1) ? now()->subDays(rand(1, 30))->format('Y-m-d') : null,
                    ]);
                }
            }
        }
    }
}
