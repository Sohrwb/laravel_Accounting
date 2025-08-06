<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransfer extends Model
{
    protected $guarded = [];
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
