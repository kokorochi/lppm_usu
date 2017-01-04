<?php

namespace App;

use App\ModelSDM\Lecturer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nidn', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function auths()
    {
        return $this->hasMany(Auths::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'nidn', 'employee_card_serial_number');
    }
}
