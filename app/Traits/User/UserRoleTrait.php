<?php

namespace App\Traits\User;

trait UserRoleTrait
{
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class);
    }
}
