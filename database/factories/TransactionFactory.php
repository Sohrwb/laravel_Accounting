<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = \App\Models\Transaction::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['investment', 'loan_payment']);
        $loanId = null;

        if ($type === 'loan_payment') {
            $loan = \App\Models\Loan::inRandomOrder()->first();
            $loanId = $loan?->id; // با ? می‌گه اگر null بود ارور نده
        }

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'type' => $type,
            'amount' => $this->faker->numberBetween(100000, 1000000),
            'date' => $this->faker->date(),
            'loan_id' => $loanId,
        ];

    }
}
