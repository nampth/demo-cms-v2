<?php

namespace App\Traits\Role;

trait RoleUserTrait
{
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }
}
