<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Kaos Polos Oversized',
                'brand' => 'Barang Karung',
                'description' => 'Kaos polos oversized yang nyaman dan trendy',
                'price' => 79000,
                'original_price' => 99000,
                'discount_percentage' => 20,
                'image' => 'img/baju-img/polo1.png',
                'stock' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Hoodie Champion Hitam',
                'brand' => 'Champion',
                'description' => 'Hoodie berkualitas tinggi dari Champion',
                'price' => 210000,
                'original_price' => 300000,
                'discount_percentage' => 30,
                'image' => 'img/baju-img/polo2.png',
                'stock' => 25,
                'is_active' => true
            ],
            [
                'name' => 'Kemeja Flanel Kotak',
                'brand' => 'Barang Karung',
                'description' => 'Kemeja flanel dengan motif kotak yang stylish',
                'price' => 95000,
                'original_price' => 120000,
                'discount_percentage' => 21,
                'image' => 'img/baju-img/polo3.png',
                'stock' => 30,
                'is_active' => true
            ],
            [
                'name' => 'Jaket Denim Vintage',
                'brand' => 'Levi\'s',
                'description' => 'Jaket denim vintage yang timeless',
                'price' => 180000,
                'original_price' => 250000,
                'discount_percentage' => 28,
                'image' => 'img/baju-img/hoodie1.png',
                'stock' => 15,
                'is_active' => true
            ],
            [
                'name' => 'Jaket Denim Vintage',
                'brand' => 'Levi\'s',
                'description' => 'Jaket denim vintage yang timeless',
                'price' => 180000,
                'original_price' => 250000,
                'discount_percentage' => 28,
                'image' => 'img/baju-img/hoodie2.png',
                'stock' => 20,
                'is_active' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
