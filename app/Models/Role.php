<?php

namespace App\Models;

use App\Traits\Role\RolePermissionTrait;
use App\Traits\Role\RoleUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    use RoleUserTrait;
    use RolePermissionTrait;

    protected $fillable = ['name', 'default_redirect', 'description'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('H:i:s d/m/Y');
    }
}
