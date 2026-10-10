<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun uji untuk 3 role (password semuanya: password)
        User::create(['name' => 'Admin Toko', 'email' => 'admin@toko.test', 'password' => 'password', 'role' => User::ROLE_ADMIN, 'email_verified_at' => now()]);
        User::create(['name' => 'Editor Toko', 'email' => 'editor@toko.test', 'password' => 'password', 'role' => User::ROLE_EDITOR, 'email_verified_at' => now()]);
        User::create(['name' => 'User Biasa', 'email' => 'user@toko.test', 'password' => 'password', 'role' => User::ROLE_USER, 'email_verified_at' => now()]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
