<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $installmentsCount = $this->faker->numberBetween(3, 12);
        $endDate = (clone $startDate)->modify("+{$installmentsCount} months");

        $totalAmount = $this->faker->numberBetween(5_000_000, 10_000_000);
        $installmentAmount = round($totalAmount / $installmentsCount);
        $paidInstallments = $this->faker->numberBetween(0, $installmentsCount);
        $remainingAmount = max($totalAmount - ($paidInstallments * $installmentAmount), 0);

        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->sentence(3),
            'amount' => $totalAmount,
            'remaining_amount' => $remainingAmount,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'installments_count' => $installmentsCount,
            'is_paid' => $remainingAmount == 0,
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Loan $loan) {
            $installmentAmount = round($loan->amount / $loan->installments_count);

            // انتخاب تصادفی اقساط پرداخت‌شده
            $paidInstallmentsIndexes = collect(range(1, $loan->installments_count))
                ->random(rand(0, $loan->installments_count))
                ->all();

            $totalPaid = 0;

            for ($i = 1; $i <= $loan->installments_count; $i++) {
                $isPaid = in_array($i, $paidInstallmentsIndexes);
                $paymentDate = $isPaid ? now()->subDays(rand(1, 30))->format('Y-m-d') : null;

                if ($isPaid) {
                    $totalPaid += $installmentAmount;
                }

                \App\Models\LoanPayment::factory()->create([
                    'loan_id' => $loan->id,
                    'installment_number' => $i,
                    'amount' => $installmentAmount,
                    'due_date' => now()->addMonths($i)->format('Y-m-d'),
                    'is_paid' => $isPaid,
                    'payment_date' => $paymentDate,
                ]);
            }

            // آپدیت remaining_amount و is_paid واقعی
            $loan->update([
                'remaining_amount' => max($loan->amount - $totalPaid, 0),
                'is_paid' => $totalPaid >= $loan->amount,
            ]);
        });
    }
}
