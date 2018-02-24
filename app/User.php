<?php

namespace App;

use App\Balance;
use App\Historic;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function getSender($sender)
    {
        return $this->where("name", "LIKE", "%$sender%")
            ->orWhere('email', $sender)
            ->get()
            ->first();

    }

}