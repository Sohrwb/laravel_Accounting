<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
      protected $guarded = [];

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
