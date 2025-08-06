<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    protected $fillable = ['loan_id', 'amount', 'payment_date'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
