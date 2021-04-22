<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Orchid\Platform\Models\User as Authenticatable;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /* This overrides that in the parents class so watch out!
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    */
}
