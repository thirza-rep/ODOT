<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::where('code', 'PST')->first();

        $products = [
            // Elektronik
            ['category' => 'Elektronik', 'name' => 'Earphone Bluetooth TWS',       'cost_price' => 45,    'sell_price' => 75,    'quantity' => 50],
            ['category' => 'Elektronik', 'name' => 'Charger Fast Charging 20W',    'cost_price' => 35,    'sell_price' => 55,    'quantity' => 80],
            ['category' => 'Elektronik', 'name' => 'Kabel USB-C 1 Meter',          'cost_price' => 8,     'sell_price' => 15,    'quantity' => 200],
            ['category' => 'Elektronik', 'name' => 'Power Bank 10000mAh',          'cost_price' => 85,    'sell_price' => 130,   'quantity' => 35],

            // Makanan & Minuman
            ['category' => 'Makanan & Minuman', 'name' => 'Kopi Arabika 250gr',    'cost_price' => 25,    'sell_price' => 42,    'quantity' => 60],
            ['category' => 'Makanan & Minuman', 'name' => 'Teh Celup Box isi 25',  'cost_price' => 5,     'sell_price' => 8.5,   'quantity' => 150],
            ['category' => 'Makanan & Minuman', 'name' => 'Mie Instan Box isi 40', 'cost_price' => 90,    'sell_price' => 115,   'quantity' => 25],
            ['category' => 'Makanan & Minuman', 'name' => 'Air Mineral 600ml',     'cost_price' => 1.5,   'sell_price' => 3,     'quantity' => 500],
            ['category' => 'Makanan & Minuman', 'name' => 'Snack Keripik 200gr',   'cost_price' => 8,     'sell_price' => 12,    'quantity' => 100],

            // Pakaian
            ['category' => 'Pakaian', 'name' => 'Kaos Polos Cotton 30s',           'cost_price' => 25,    'sell_price' => 45,    'quantity' => 120],
            ['category' => 'Pakaian', 'name' => 'Celana Jeans Slim Fit',           'cost_price' => 80,    'sell_price' => 150,   'quantity' => 40],
            ['category' => 'Pakaian', 'name' => 'Hoodie Basic',                     'cost_price' => 65,    'sell_price' => 120,   'quantity' => 30],
            ['category' => 'Pakaian', 'name' => 'Topi Baseball Cap',               'cost_price' => 15,    'sell_price' => 30,    'quantity' => 75],

            // Kesehatan
            ['category' => 'Kesehatan', 'name' => 'Masker Medis Box isi 50',       'cost_price' => 15,    'sell_price' => 25,    'quantity' => 200],
            ['category' => 'Kesehatan', 'name' => 'Hand Sanitizer 500ml',          'cost_price' => 18,    'sell_price' => 28,    'quantity' => 90],
            ['category' => 'Kesehatan', 'name' => 'Vitamin C 1000mg isi 30',       'cost_price' => 35,    'sell_price' => 55,    'quantity' => 60],

            // Alat Tulis
            ['category' => 'Alat Tulis', 'name' => 'Pulpen Gel 0.5mm',             'cost_price' => 2,     'sell_price' => 4.5,   'quantity' => 300],
            ['category' => 'Alat Tulis', 'name' => 'Buku Tulis A5 isi 50 lembar',  'cost_price' => 3,     'sell_price' => 5.5,   'quantity' => 250],
            ['category' => 'Alat Tulis', 'name' => 'Pensil Mekanik 0.7mm',         'cost_price' => 5,     'sell_price' => 10,    'quantity' => 150],

            // Rumah Tangga
            ['category' => 'Rumah Tangga', 'name' => 'Sabun Cuci Piring 800ml',    'cost_price' => 8,     'sell_price' => 13,    'quantity' => 120],
            ['category' => 'Rumah Tangga', 'name' => 'Tissue Box 250 lembar',      'cost_price' => 7,     'sell_price' => 12,    'quantity' => 180],
            ['category' => 'Rumah Tangga', 'name' => 'Lampu LED 12 Watt',          'cost_price' => 12,    'sell_price' => 22,    'quantity' => 100],

            // Olahraga
            ['category' => 'Olahraga', 'name' => 'Botol Minum Sport 750ml',        'cost_price' => 15,    'sell_price' => 30,    'quantity' => 80],
            ['category' => 'Olahraga', 'name' => 'Skipping Rope / Tali Loncat',    'cost_price' => 12,    'sell_price' => 25,    'quantity' => 45],
            ['category' => 'Olahraga', 'name' => 'Handuk Microfiber',              'cost_price' => 20,    'sell_price' => 38,    'quantity' => 55],
        ];

        foreach ($products as $data) {
            $category = Category::where('name', $data['category'])->first();

            Product::firstOrCreate(
                ['name' => $data['name']],
                [
                    'category_id' => $category?->id,
                    'branch_id'   => $branch?->id,
                    'sku'         => Product::generateSku(strtoupper(substr($data['category'], 0, 3))),
                    'cost_price'  => $data['cost_price'],
                    'sell_price'  => $data['sell_price'],
                    'quantity'    => $data['quantity'],
                    'min_stock'   => 5,
                    'is_active'   => true,
                ]
            );
        }
    }
}
