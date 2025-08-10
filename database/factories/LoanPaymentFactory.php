<?php

namespace Database\Factories;

use App\Models\LoanPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanPaymentFactory extends Factory
{
    protected $model = LoanPayment::class;

    public function definition()
    {
        return [
            'loan_id' => null,
            'installment_number' => 1,
            'amount' => 0,
            'due_date' => now()->format('Y-m-d'),
            'is_paid' => false,
            'payment_date' => null,
        ];
    }
}
