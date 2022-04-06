<?php

namespace App\Models;

use App\Traits\User\CreatedByUserTrait;
use App\Traits\User\UserPermissionTrait;
use App\Traits\User\UserRoleTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use UserRoleTrait;
    use UserPermissionTrait;
    use CreatedByUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'status',
        'org_id',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checkRoles($roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        if (!$this->hasAnyRole($roles)) {
            auth()->logout();
            abort(404);
        }
    }

    public function hasAnyRole($roles)
    {
        return (bool)$this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
        return (bool)$this->roles()->where('name', $role)->first();
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('H:i:s d/m/Y');
    }

}
