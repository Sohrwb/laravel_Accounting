<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
