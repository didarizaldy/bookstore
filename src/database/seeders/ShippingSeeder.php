<?php

namespace Database\Seeders;

use App\Models\Shipping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipping::create([
            'id_user' => 3,
            'receiver_name' => 'Taylor Otwell',
            'tag' => 'Kantor',
            'address' => 'Jl. Medan Merdeka Barat No.9 2, RT.2/RW.3, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110',
            'notes' => 'taruh depan satpam aja pak',
            'maps' => 'https://maps.app.goo.gl/CUyWWGg5yCY9XXf86',
            'phone' => '6281210000001',
            'created_by' => 'blackr0ck',
        ]);

        Shipping::create([
            'id_user' => 3,
            'receiver_name' => 'Larry Fink',
            'address' => 'Komplek Kemendikbudristek Gedung A, Jl. Jenderal Sudirman Lantai 2, Senayan, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270',
            'phone' => '6281210000002',
            'created_by' => 'blackr0ck',
        ]);
    }
}
