<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function makeUser(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    public function test_guest_diarahkan_ke_login_saat_buka_admin(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_user_biasa_ditolak_di_admin(): void
    {
        $this->actingAs($this->makeUser('user'))->get('/admin')->assertForbidden();
    }

    public function test_admin_boleh_masuk_admin(): void
    {
        $this->actingAs($this->makeUser('admin'))->get('/admin')->assertOk();
    }

    public function test_user_biasa_tidak_boleh_buat_post(): void
    {
        $this->actingAs($this->makeUser('user'))->get('/posts/create')->assertForbidden();
    }

    public function test_editor_boleh_buat_post(): void
    {
        $editor = $this->makeUser('editor');

        $this->actingAs($editor)
            ->post('/posts', ['title' => 'Promo Akhir Tahun', 'body' => 'Diskon besar-besaran untuk semua kategori.'])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', ['title' => 'Promo Akhir Tahun', 'user_id' => $editor->id]);
    }

    public function test_editor_tidak_boleh_edit_post_milik_orang_lain(): void
    {
        $post = Post::factory()->create(['user_id' => $this->makeUser('admin')->id]);

        $this->actingAs($this->makeUser('editor'))
            ->put("/posts/{$post->id}", ['title' => 'Diubah', 'body' => 'Isi yang diubah paksa.'])
            ->assertForbidden();
    }

    public function test_editor_boleh_hapus_post_miliknya_sendiri(): void
    {
        $editor = $this->makeUser('editor');
        $post = Post::factory()->create(['user_id' => $editor->id]);

        $this->actingAs($editor)->delete("/posts/{$post->id}")->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_admin_boleh_hapus_post_siapa_saja(): void
    {
        $post = Post::factory()->create(['user_id' => $this->makeUser('editor')->id]);

        $this->actingAs($this->makeUser('admin'))->delete("/posts/{$post->id}")->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
