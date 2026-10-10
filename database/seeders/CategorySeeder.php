<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Elektronik' => 'Gadget dan aksesoris elektronik',
            'Fashion Pria' => 'Pakaian dan perlengkapan pria',
            'Rumah Tangga' => 'Peralatan dapur dan rumah',
            'Olahraga' => 'Perlengkapan olahraga dan kebugaran',
            'Buku & Alat Tulis' => 'Buku, alat tulis, dan perlengkapan belajar',
            'Kecantikan & Perawatan' => 'Skincare dan perawatan tubuh',
        ] as $name => $desc) {
            Category::create(['name' => $name, 'slug' => Str::slug($name), 'description' => $desc]);
        }
    }
}
