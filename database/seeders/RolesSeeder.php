<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'programmer', 'guard_name' => 'api']);
        Role::create(['name' => 'manager', 'guard_name' => 'api']);
    }
}
