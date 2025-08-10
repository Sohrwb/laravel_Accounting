<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Investment;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Point;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FamiliesTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        $users = User::all();
        $months = [1, 2, 3, 4, 5, 6];

        foreach ($users as $user) {
            $totalInvestment = 0;

            foreach ($months as $month) {
                // سرمایه‌گذاری
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
                ]);

                // وام + اقساطش
                $loan = Loan::factory()->create([
                    'user_id' => $user->id,
                    'start_date' => now()->setMonth($month)->subMonths(rand(1, 3))->format('Y-m-d'),
                    'end_date' => now()->setMonth($month)->addMonths(rand(3, 6))->format('Y-m-d'),
                ]);

                // تراکنش پرداخت اقساط وام
                foreach ($loan->payments as $payment) {
                    Transaction::factory()->create([
                        'user_id' => $user->id,
                        'type' => 'loan_payment',
                        'amount' => $payment->amount,
                        'date' => $payment->payment_date ?? $payment->due_date,
                        'loan_id' => $loan->id,
                    ]);
                }
            }

            // به‌روزرسانی سرمایه کل
            $user->update(['total_investment' => $totalInvestment]);

            // امتیاز
            Point::updateOrCreate(
                ['user_id' => $user->id],
                ['points' => intval($totalInvestment * 2.5)]
            );
        }
    }
}
