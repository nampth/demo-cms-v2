<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->username = 'nampth100';
        $admin->name = 'System Admin';
        $admin->email = 'nampth100@gmail.com';
        $admin->status = USER_STATUS_ACTIVE;
        $admin->password = bcrypt('!!YoWh4tUpB0ys');
        $admin->save();
        $admin->roles()->attach(Role::where('name', USER_ROLE_ADMIN)->first());

    }
}
