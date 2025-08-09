<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory
{
    protected $model = Point::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // محاسبه مجموع سرمایه کاربر
        $totalInvestment = $user->investments()->sum('amount');

        return [
            'user_id' => $user->id,
            'points' => $totalInvestment * 2.5,
        ];
    }
}
