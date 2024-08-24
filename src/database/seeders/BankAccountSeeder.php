<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bankaccount = [
            [
                'bank_code'     => '002',
                'bank_name'     => 'BRI',
                'account_name'  => 'PT. Oscar Wawasan Biru Jaya',
                'account_code'  => '8123817459135920',
                'active'        => 1,
                'created_by'    => 'admin',
            ],
            [
                'bank_code'     => '008',
                'bank_name'     => 'Mandiri',
                'account_name'  => 'PT. Oscar Wawasan Biru Jaya',
                'account_code'  => '81238174591359123',
                'active'        => 1,
                'created_by'    => 'admin',
            ],
            [
                'bank_code'     => '009',
                'bank_name'     => 'BNI',
                'account_name'  => 'PT. Oscar Wawasan Biru Jaya',
                'account_code'  => '81238174591352222',
                'active'        => 1,
                'created_by'    => 'admin',
            ]
        ];

        BankAccount::insert($bankaccount);
    }
}
