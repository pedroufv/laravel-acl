<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Authorization\Traits\RolePermissionsTrait;

class Role extends Model
{
    use RolePermissionsTrait;
}