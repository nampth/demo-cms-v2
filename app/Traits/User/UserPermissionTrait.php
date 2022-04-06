<?php

namespace App\Traits\User;

use App\Models\Permission;

trait UserPermissionTrait
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }
}
