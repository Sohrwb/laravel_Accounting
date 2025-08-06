<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $guarded = [];

    protected $hidden = ['password'];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function point()
    {
        return $this->hasOne(Point::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function sentPointTransfers()
    {
        return $this->hasMany(PointTransfer::class, 'from_user_id');
    }

    public function receivedPointTransfers()
    {
        return $this->hasMany(PointTransfer::class, 'to_user_id');
    }
}
