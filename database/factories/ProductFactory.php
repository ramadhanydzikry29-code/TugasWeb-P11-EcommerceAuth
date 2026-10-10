<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'sku' => 'SKU-' . fake()->unique()->numerify('######'),
            'name' => Str::title($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('####'),
            'description' => 'Produk original bergaransi toko. ' . fake()->sentence(10),
            'price' => fake()->numberBetween(25, 900) * 1000,
            'stock' => fake()->numberBetween(0, 150), // sebagian 0 -> demo scope inStock
            'is_active' => fake()->boolean(92),
        ];
    }
}
