<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id_category' => 'AGM',
                'name' => 'Agama',
            ],
            [
                'id_category' => 'BIO',
                'name' => 'Biografi',
            ],
            [
                'id_category' => 'BE',
                'name' => 'Bisnis Ekonomi',
            ],
            [
                'id_category' => 'BUKA',
                'name' => 'Buku Anak',
            ],
            [
                'id_category' => 'DSGN',
                'name' => 'Desain',
            ],
            [
                'id_category' => 'FSAS',
                'name' => 'Fiksi Sastra',
            ],
            [
                'id_category' => 'PLSPY',
                'name' => 'Filsafat',
            ],
            [
                'id_category' => 'FOTO',
                'name' => 'Fotografi',
            ],
            [
                'id_category' => 'GA',
                'name' => 'Game Aktivitas',
            ],
            [
                'id_category' => 'HKM',
                'name' => 'Hukum',
            ],
            [
                'id_category' => 'HUM',
                'name' => 'Humor',
            ],
            [
                'id_category' => 'KLRG',
                'name' => 'Keluarga',
            ],
            [
                'id_category' => 'COMIC',
                'name' => 'Komik',
            ],
            [
                'id_category' => 'COMTEC',
                'name' => 'Komputer Teknologi',
            ],
            [
                'id_category' => 'OTHER',
                'name' => 'Lain lain',
            ],
            [
                'id_category' => 'MED',
                'name' => 'Medis',
            ],
            [
                'id_category' => 'NONFIK',
                'name' => 'Nonfiksi Anak Remaja',
            ],
            [
                'id_category' => 'SPRT',
                'name' => 'Olahraga',
            ],
            [
                'id_category' => 'EDU',
                'name' => 'Pendidikan',
            ],
            [
                'id_category' => 'FILS',
                'name' => 'Pengembangan Diri',
            ],
            [
                'id_category' => 'ANIM',
                'name' => 'Perawatan Hewan Peliharaan',
            ],
            [
                'id_category' => 'POET',
                'name' => 'Puisi',
            ],
            [
                'id_category' => 'SCNCE',
                'name' => 'Sains',
            ],
            [
                'id_category' => 'LTRT',
                'name' => 'Sastra',
            ],
            [
                'id_category' => 'SHOW',
                'name' => 'Seni Pertunjukan',
            ],
            [
                'id_category' => 'ART',
                'name' => 'Seni Rupa',
            ],
            [
                'id_category' => 'SOC',
                'name' => 'Sosial',
            ],
            [
                'id_category' => 'TEENL',
                'name' => 'Teenlit',
            ],
            [
                'id_category' => 'TECH',
                'name' => 'Teknik',
            ],
            [
                'id_category' => 'TRVL',
                'name' => 'Travel',
            ],
            [
                'id_category' => 'COOK',
                'name' => 'Masak',
            ]
        ];

        ProductCategory::insert($categories);
    }
}
