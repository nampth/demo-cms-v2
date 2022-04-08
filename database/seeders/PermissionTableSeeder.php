<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')
        ->insert([
            [
                'name' => ADMIN_DASHBOARD,
                'description' => 'Admin dashboard'
            ],
            [
                'name' => ADMIN_USER_MANAGEMENT,
                'description' => 'Admin manages users'
            ],
            [
                'name' => ADMIN_ROLE_MANAGEMENT,
                'description' => 'Admin manages roles'
            ],
            [
                'name' => ADMIN_PERMISSION_MANAGEMENT,
                'description' => 'Admin manages permissions'
            ]
        ]);

    }
}
