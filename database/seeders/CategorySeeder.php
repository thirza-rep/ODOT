<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik',       'description' => 'Perangkat elektronik dan gadget'],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman'],
            ['name' => 'Pakaian',           'description' => 'Baju, celana, dan aksesoris fashion'],
            ['name' => 'Kesehatan',         'description' => 'Produk kesehatan dan kecantikan'],
            ['name' => 'Alat Tulis',        'description' => 'Peralatan tulis dan kantor'],
            ['name' => 'Rumah Tangga',      'description' => 'Peralatan dan perlengkapan rumah tangga'],
            ['name' => 'Olahraga',          'description' => 'Peralatan dan perlengkapan olahraga'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                array_merge($category, ['slug' => Str::slug($category['name'])])
            );
        }
    }
}
