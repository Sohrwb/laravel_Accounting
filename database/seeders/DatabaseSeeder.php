<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Investment;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Transaction;
use App\Models\Point;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FamiliesTableSeeder::class,
            UsersTableSeeder::class,
            LoansTableSeeder::class,
            LoanPaymentsTableSeeder::class,
            TransactionsTableSeeder::class,
        ]);

        $users = User::all();
        $months = [1, 2, 3, 4, 5, 6]; // ماه‌های مختلف

        foreach ($users as $user) {
            $totalInvestment = 0;

            foreach ($months as $month) {
                // سرمایه‌گذاری همان ماه
                $investment = Investment::factory()->create([
                    'user_id' => $user->id,
                    'month' => $month,
                    'amount' => rand(100000, 1000000),
                ]);
                $totalInvestment += $investment->amount;

                // تراکنش سرمایه‌گذاری
                Transaction::factory()->create([
                    'user_id' => $user->id,
                    'type' => 'investment',
                    'amount' => $investment->amount,
                    'date' => now()->setMonth($month)->toDateString(),
                    'loan_id' => null,
                ]);

                // ساخت وام برای همان ماه
                $loan = Loan::factory()->create([
                    'user_id' => $user->id,
                    'start_date' => now()->setMonth($month)->subMonths(rand(1, 3))->format('Y-m-d'),
                    'end_date' => now()->setMonth($month)->addMonths(rand(3, 6))->format('Y-m-d'),
                    'installments_count' => rand(3, 12),
                    'amount' => rand(5000000, 10000000),
                    'remaining_amount' => rand(0, 5000000),
                    'is_paid' => rand(0, 1),
                ]);

                // اقساط وام برای همان وام
                for ($i = 1; $i <= $loan->installments_count; $i++) {
                    $dueDate = now()->setMonth($month)->addMonths($i);

                    $loanPayment = LoanPayment::factory()->create([
                        'loan_id' => $loan->id,
                        'installment_number' => $i,
                        'amount' => intdiv($loan->amount, $loan->installments_count),
                        'due_date' => $dueDate->format('Y-m-d'),
                        'is_paid' => (bool)rand(0, 1),
                        'payment_date' => (bool)rand(0, 1) ? now()->subDays(rand(1, 30))->format('Y-m-d') : null,
                    ]);

                    // تراکنش قسط وام
                    Transaction::factory()->create([
                        'user_id' => $user->id,
                        'type' => 'loan_payment',
                        'amount' => $loanPayment->amount,
                        'date' => $loanPayment->payment_date ?? $dueDate->toDateString(),
                        'loan_id' => $loan->id,
                    ]);
                }
            }

            // به‌روزرسانی total_investment در جدول users
            $user->update(['total_investment' => $totalInvestment]);

            // ساخت یا به‌روزرسانی امتیاز بر اساس total_investment ضربدر 2.5
            Point::updateOrCreate(
                ['user_id' => $user->id],
                ['points' => intval($totalInvestment * 2.5)]
            );
        }
    }
}
