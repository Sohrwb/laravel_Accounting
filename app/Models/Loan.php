<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'remaining_amount',
        'start_date',
        'end_date',
        'installments_count',
        'is_paid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }
 

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class, 'loan_id');
    }



    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
