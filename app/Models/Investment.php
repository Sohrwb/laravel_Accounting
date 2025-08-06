<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['user_id', 'amount', 'month'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
