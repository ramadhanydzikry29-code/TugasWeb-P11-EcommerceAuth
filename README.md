# TugasWeb-P11-EcommerceAuth

**Tugas Rutin 11 — E-Commerce DB + Secure Auth (Laravel)**
##Nama: Dzikry Ramadhany 
##NIM: 4251250008 
##Universitas Negeri Medan (FMIPA) 
##Mata kuliah: Pemrograman Web

## Fitur
**Bagian A — Database & Eloquent**
- 7 tabel e-commerce + FK constraints: `categories`, `products`, `carts`, `orders`, `order_items`, `reviews`, `posts` (+ kolom `role` di `users`)
- Seeder + factory: 6 kategori, 54 produk realistis, 10 customer, order, review, post
- Model + relationships; scope `active()`, `inStock()`, `priceBetween()` di `Product`
- 5 query Tinker: lihat `docs/TINKER.md`

**Bagian B — Auth & Security**
- Laravel Breeze (login / register / logout)
- Multi-role `admin` / `editor` / `user` + middleware kustom `RoleMiddleware` (alias `role`)
- `PostPolicy`: admin edit/hapus semua post, editor hanya post miliknya, user tidak boleh
- Route protection: `/admin` (admin), `/posts/create|edit` (admin & editor), `/products` & `/posts` (login)
- Bonus: demo eager loading (`/admin/demo/eager`), Filament (opsional, lihat bawah)

## Akun uji (password: `password`)
| Role | Email |
|---|---|
| admin | admin@toko.test |
| editor | editor@toko.test |
| user | user@toko.test |

## Instalasi
```bash
composer create-project laravel/laravel TugasWeb-P11-EcommerceAuth
cd TugasWeb-P11-EcommerceAuth
# 1. salin isi folder overlay ini ke root project (timpa app/Models/User.php)
# 2. atur .env -> DB_CONNECTION=mysql, DB_DATABASE=tugasweb_p11 (buat DB di phpMyAdmin)
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate:fresh --seed
php artisan serve
```

### Edit manual (2 tempat)
1. `bootstrap/app.php` — daftarkan alias middleware:
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```
2. `routes/web.php` — tambahkan sebelum baris `require __DIR__.'/auth.php';`:
```php
require __DIR__.'/shop.php';
```

## Struktur penting
```
app/Http/Middleware/RoleMiddleware.php
app/Policies/PostPolicy.php
app/Http/Controllers/{Post,Product,Admin}Controller.php
app/Models/*
database/{migrations,factories,seeders}
routes/shop.php
resources/views/{posts,products,admin}
tests/Feature/RoleAccessTest.php
docs/TINKER.md
```

## Testing
Otomatis: `php artisan test --filter=RoleAccessTest`
Manual (incognito 2 role): login admin di jendela biasa, login user di jendela incognito, lalu bandingkan akses `/admin`, `/posts/create`, edit/hapus post.

| URL | guest | user | editor | admin |
|---|---|---|---|---|
| /admin | redirect login | 403 | 403 | 200 |
| /posts/create | redirect login | 403 | 200 | 200 |
| edit/hapus post orang lain | login | 403 | 403 | 200 |
| edit/hapus post sendiri | login | 403 | 200 | 200 |

## Bonus: Filament (opsional)
```bash
composer require filament/filament
php artisan filament:install --panels
php artisan make:filament-user
```
