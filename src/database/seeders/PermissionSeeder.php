<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'bankacc',
            'basket',
            'checkout',
            'paid',
            'category',
            'shipping',
            'permissions',
            'roles',
            'users'
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                [
                    'name'            => $permission,
                    'guard_name'      => 'web',
                    'created_at'      => now()
                ]
            ]);
        }
    }
}
