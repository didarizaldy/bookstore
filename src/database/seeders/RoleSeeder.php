<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions_admin = [
            'bankacc',
            'basket',
            'checkout',
            'paid',
            'category',
            'shipping',
        ];

        $superuser = Role::create([
            'name' => 'opsweb',
            'guard_name' => 'web'
        ]);

        $superuser->givePermissionTo(Permission::all());

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        foreach ($permissions_admin as $permission) {
            $admin->givePermissionTo($permission);
        };

        Role::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);
    }
}
