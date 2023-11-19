<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeed extends Seeder
{
    public function run(): void
    {
        $roles = ['admin','company','user'];
        foreach ($roles as $role) {
            Role::create(['name' => $role,'guard_name' => 'web']);
        }
    }
}
