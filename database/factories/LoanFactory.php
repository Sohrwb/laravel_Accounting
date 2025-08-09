<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    protected $model = \App\Models\Loan::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $installmentsCount = $this->faker->numberBetween(3, 12);
        $endDate = (clone $startDate)->modify("+{$installmentsCount} months");

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'name' => $this->faker->sentence(3),
            'amount' => $totalAmount = $this->faker->numberBetween(1000000, 10000000),
            'remaining_amount' => $totalAmount,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'installments_count' => $installmentsCount,
            'is_paid' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

