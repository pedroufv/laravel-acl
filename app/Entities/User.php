<?php

namespace Ancora\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Larapacks\Authorization\Traits\UserRolesTrait;

class User extends Authenticatable
{
    use Notifiable, UserRolesTrait;

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
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    /**
     * Add role on payload
     *
     * @return array
     */
    public function customClaims()
    {
        return [
            'role' => $this->isAdministrator() ? 'admin' :  'user',
        ];
    }
}
