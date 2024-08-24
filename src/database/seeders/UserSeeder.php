<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superuser = User::create([
            'username'       => 'oscaradm',
            'fullname'       => ucwords(strtolower('Oscar Web Admin User')),
            'email'          => 'admin.oscarjakarta10@gmail.com',
            'api_token'      => Str::random(100),
            'password'       => bcrypt('os123car456'),
            'active'         => (int)1,
        ]);

        $superuser->assignRole('opsweb');

        $admin = User::create([
            'username'       => 'adminjak01',
            'fullname'       => ucwords(strtolower('Oscar Web Admin Jakarta 1')),
            'email'          => 'admin.oscarjak001@gmail.com',
            'api_token'      => Str::random(100),
            'password'       => bcrypt('os123car456'),
            'active'         => (int)1,
        ]);

        $admin->assignRole('admin');

        $userOne = User::create([
            'username'       => 'testuser1',
            'fullname'       => ucwords(strtolower('Oscar Web Jakarta')),
            'email'          => 'testuseroscarjak1@gmail.com',
            'api_token'      => Str::random(100),
            'password'       => bcrypt('userjkt1'),
            'active'         => (int)1,
        ]);

        $userOne->assignRole('user');

        $userTwo = User::create([
            'username'       => 'testuser2',
            'fullname'       => ucwords(strtolower('Oscar Web Jakarta')),
            'email'          => 'testuseroscarjak2@gmail.com',
            'api_token'      => Str::random(100),
            'password'       => bcrypt('userjkt1'),
            'active'         => (int)1,
        ]);

        $userTwo->assignRole('user');
    }
}
