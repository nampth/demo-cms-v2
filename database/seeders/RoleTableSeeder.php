<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin_user = new Role();
        $role_admin_user->name = USER_ROLE_ADMIN;
        $role_admin_user->default_redirect = '/backend/admin/dashboard';
        $role_admin_user->description = 'Administrator';
        $role_admin_user->save();

        $role_admin_user->permissions()->attach(Permission::where('name', ADMIN_DASHBOARD)->first());
        $role_admin_user->permissions()->attach(Permission::where('name', ADMIN_USER_MANAGEMENT)->first());
        $role_admin_user->permissions()->attach(Permission::where('name', ADMIN_ROLE_MANAGEMENT)->first());
        $role_admin_user->permissions()->attach(Permission::where('name', ADMIN_PERMISSION_MANAGEMENT)->first());

    }
}
