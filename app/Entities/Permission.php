<?php

namespace LaravelACL\Entities;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Authorization\Traits\PermissionRolesTrait;

class Permission extends Model
{
    use PermissionRolesTrait;

    public static function getGroupedAndChecked(Role $role = null)
    {
        return self::all()->mapToGroups(function ($permission) use ($role) {
            $exploded = explode('.', $permission->name);
            $key = count($exploded) > 2 ? $exploded[1]: 'general';
            $permission->nick = count($exploded) > 2 ? $exploded[2] : $exploded[1];

            if($role)
                $permission->check = $role->permissions->contains($permission);

            return [__('general.'.$key) => $permission];
        });
    }
}