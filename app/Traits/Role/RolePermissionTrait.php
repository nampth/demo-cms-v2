<?php


namespace App\Traits\Role;

use App\Models\Permission;

trait RolePermissionTrait
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}
