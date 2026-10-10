<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'user_id' => User::factory(),
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(5)),
            'body' => implode("\n\n", fake()->paragraphs(3)),
            'published_at' => now(),
        ];
    }
}
