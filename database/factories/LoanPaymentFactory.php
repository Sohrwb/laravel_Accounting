<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanPayment>
 */
class LoanPaymentFactory extends Factory
{
    protected $model = \App\Models\LoanPayment::class;

    public function definition()
    {
        // باید loan_id مشخص باشه، اینجا فقط نمونه بدون loan_id میده
        return [
            'loan_id' => \App\Models\Loan::inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(100000, 1000000),
            'payment_date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'installment_number' => $this->faker->numberBetween(1, 12),
            'due_date' => $this->faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'is_paid' => $this->faker->boolean(70), // 70% احتمال پرداخت شده
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
