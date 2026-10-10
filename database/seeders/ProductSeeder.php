<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /** 6 kategori x 9 produk = 54 produk realistis (harga dalam Rupiah). */
    public function run(): void
    {
        $catalog = [
            'Elektronik' => [
                ['Logitech M331 Silent Mouse Wireless', 289000],
                ['Xiaomi Redmi Buds 5 Earbuds Bluetooth', 399000],
                ['Anker PowerCore Power Bank 10000mAh', 349000],
                ['JBL Go 3 Speaker Bluetooth Portable', 599000],
                ['Baseus Charger GaN 65W 3 Port', 429000],
                ['TP-Link Archer C6 Router WiFi AC1200', 459000],
                ['Logitech K380 Keyboard Bluetooth Multi-Device', 549000],
                ['Samsung EVO Select MicroSD 128GB', 189000],
                ['SanDisk Ultra Flair Flashdisk USB 3.0 64GB', 99000],
            ],
            'Fashion Pria' => [
                ['Kaos Polos Cotton Combed 30s Hitam', 59000],
                ['Kemeja Flanel Lengan Panjang Kotak', 139000],
                ['Jaket Hoodie Fleece Navy', 189000],
                ['Celana Chino Slim Fit Khaki', 169000],
                ['Celana Jeans Slim Stretch Biru Dongker', 229000],
                ['Sepatu Sneakers Kanvas Putih', 249000],
                ['Topi Baseball Cotton Hitam', 49000],
                ['Ikat Pinggang Kulit Sintetis Hitam', 79000],
                ['Tas Ransel Laptop 15 Inch Waterproof', 199000],
            ],
            'Rumah Tangga' => [
                ['Rice Cooker Digital 1.8 Liter', 399000],
                ['Blender Kaca 1.5 Liter 2 Jar', 329000],
                ['Set Panci Stainless Steel 5 Pcs', 459000],
                ['Wajan Teflon Anti Lengket 24 cm', 119000],
                ['Kipas Angin Berdiri 16 Inch', 289000],
                ['Setrika Listrik 350 Watt', 129000],
                ['Dispenser Air Meja Hot & Normal', 449000],
                ['Lampu LED Bulb 12 Watt Isi 4', 59000],
                ['Set Piring Melamin 12 Pcs', 149000],
            ],
            'Olahraga' => [
                ['Matras Yoga TPE 6mm Anti Slip', 129000],
                ['Dumbbell Vinyl 5 Kg Sepasang', 179000],
                ['Sepatu Lari Pria Ringan Mesh', 349000],
                ['Botol Minum Tumbler 1 Liter', 89000],
                ['Jump Rope Skipping Bearing', 49000],
                ['Resistance Band Set 5 Level', 99000],
                ['Bola Futsal Size 4', 159000],
                ['Raket Badminton Carbon Set 2 Pcs', 249000],
                ['Sarung Tangan Gym Pria', 69000],
            ],
            'Buku & Alat Tulis' => [
                ['Buku Tulis Sidu 38 Lembar Isi 10', 39000],
                ['Pulpen Gel Pilot G2 0.5mm Isi 3', 54000],
                ['Stabilo Boss Highlighter 4 Warna', 45000],
                ['Notebook A5 Hardcover Dotted', 69000],
                ['Kalkulator Ilmiah Casio fx-991ID CW', 299000],
                ['Buku Clean Code - Robert C. Martin', 345000],
                ['Map Plastik Clear Holder 40 Lembar', 35000],
                ['Stapler HD-10 + Isi Staples', 29000],
                ['Papan Ujian Akrilik A4', 39000],
            ],
            'Kecantikan & Perawatan' => [
                ['Facial Wash Gentle Cleanser 100ml', 45000],
                ['Sunscreen Gel SPF 50 PA++++ 50ml', 89000],
                ['Pelembap Wajah Ceramide 50g', 109000],
                ['Sampo Anti Ketombe 340ml', 52000],
                ['Sabun Mandi Cair 900ml', 39000],
                ['Pasta Gigi Whitening 190g', 25000],
                ['Deodoran Roll On 50ml', 28000],
                ['Hair Serum Vitamin E 100ml', 59000],
                ['Lip Balm SPF 15 4g', 35000],
            ],
        ];

        foreach ($catalog as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->firstOrFail();

            foreach ($items as [$name, $price]) {
                Product::factory()->create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'price' => $price,
                    'is_active' => true,
                    'stock' => fake()->numberBetween(5, 150),
                ]);
            }
        }

        // Beberapa produk dibuat habis / nonaktif agar scope active() & inStock() terlihat efeknya
        Product::inRandomOrder()->take(4)->update(['stock' => 0]);
        Product::inRandomOrder()->take(2)->update(['is_active' => false]);
    }
}
