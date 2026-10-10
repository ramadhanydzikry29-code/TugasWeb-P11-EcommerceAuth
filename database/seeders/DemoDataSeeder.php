<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::active()->get();
        $customers = User::factory(10)->create(); // role default: user
        $admin = User::where('email', 'admin@toko.test')->first();
        $editor = User::where('email', 'editor@toko.test')->first();

        // Orders + order items
        foreach ($customers as $customer) {
            foreach (range(1, rand(1, 3)) as $i) {
                $order = Order::create([
                    'user_id' => $customer->id,
                    'code' => 'ORD-' . strtoupper(Str::random(8)),
                    'status' => collect(['pending', 'paid', 'shipped', 'completed'])->random(),
                    'total' => 0,
                    'shipping_address' => fake()->address(),
                ]);

                $total = 0;
                foreach ($products->random(rand(1, 4)) as $product) {
                    $qty = rand(1, 3);
                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $product->price,
                    ]);
                    $total += $qty * $product->price;
                }
                $order->update(['total' => $total]);
            }

            // Reviews (1 user hanya boleh 1 review per produk)
            foreach ($products->random(3) as $product) {
                Review::factory()->create(['user_id' => $customer->id, 'product_id' => $product->id]);
            }
        }

        // Posts: 3 milik editor, 2 milik admin
        Post::factory(3)->create(['user_id' => $editor->id]);
        Post::factory(2)->create(['user_id' => $admin->id]);
    }
}
