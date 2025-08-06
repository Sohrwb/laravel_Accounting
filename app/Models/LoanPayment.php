<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    protected $guarded = [];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
