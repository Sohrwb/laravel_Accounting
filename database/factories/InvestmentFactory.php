<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvestmentFactory extends Factory
{
    protected $model = \App\Models\Investment::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(100000, 1000000),
            'month' => $this->faker->numberBetween(1, 12),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
