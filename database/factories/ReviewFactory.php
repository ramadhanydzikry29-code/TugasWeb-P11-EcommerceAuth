<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->randomElement([
                'Barang sesuai deskripsi, pengiriman cepat.',
                'Kualitas bagus untuk harganya.',
                'Packing rapi, recommended seller.',
                'Sesuai ekspektasi, akan beli lagi.',
                'Lumayan, tapi pengiriman agak lama.',
            ]),
        ];
    }
}
