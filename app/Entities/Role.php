<?php

namespace LaravelACL\Entities;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Authorization\Traits\RolePermissionsTrait;

class Role extends Model
{
    use RolePermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'label',
    ];

    public static function getChecked(User $user)
    {
        return self::all()->each(function ($role) use ($user) {
            $role->check = $user->roles->contains($role);
        });
    }
}