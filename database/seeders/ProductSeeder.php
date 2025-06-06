<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Membuat atau memperbarui data produk iPhone...');

        $products = [
            [
                'name' => 'iPhone 16 Pro Max',
                'description' => 'Titanium. Begitu kuat. Begitu ringan. Begitu Pro. iPhone 15 Pro adalah iPhone pertama yang didesain dengan titanium sekelas industri dirgantara.',
                'price' => 22500000,
                'stock' => 50,
                'image' => 'products/Iphone 16 Series.jpg'
            ],
            [
                'name' => 'iPhone 14 Pro Max',
                'description' => 'Layar Super Retina XDR 6,1 inci. Sistem kamera ganda canggih untuk foto yang lebih baik dalam pencahayaan apa pun.',
                'price' => 11500000,
                'stock' => 80,
                'image' => 'products/iphone 14.jpg'
            ],
            [
                'name' => 'iPhone SE',
                'description' => 'Chip A15 Bionic secepat kilat dan 5G super cepat. Kekuatan baterai besar dan kamera bintang dalam desain 4,7 inci yang tangguh.',
                'price' => 7500000,
                'stock' => 120,
                'image' => 'products/Iphone.jpg'
            ],
        ];

        foreach ($products as $productData) {
            // Menggunakan firstOrCreate untuk mencegah duplikasi berdasarkan slug
            Product::firstOrCreate(
                ['slug' => Str::slug($productData['name'])], // Kondisi pencarian: cari produk dengan slug ini
                $productData // Data yang akan dibuat jika tidak ditemukan
            );
        }

        $this->command->info('Data produk iPhone berhasil dibuat atau sudah ada.');
    }
}
