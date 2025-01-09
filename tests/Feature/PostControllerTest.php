<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_post()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->postJson('/api/posts', [
            'title' => 'My New Post',
            'content' => 'Content of the post',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'title', 'content']);
    }

    /** @test */
    public function it_gets_all_posts()
    {
        Post::factory()->count(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    /** @test */
    public function it_gets_a_post_by_id()
    {
        $post = Post::factory()->create();
        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertJson(['id' => $post->id]);
    }

    /** @test */
    public function it_updates_a_post()
    {
        // Create a user
        $user = User::factory()->create();

        // Acting as the authenticated user
        $this->actingAs($user, 'sanctum');

        $post = Post::factory()->create();

        $response = $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['title' => 'Updated Title']);
    }

    /** @test */
    public function it_deletes_a_post()
    {
        // Create a user
        $user = User::factory()->create();

        // Acting as the authenticated user
        $this->actingAs($user, 'sanctum');

        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Delete successful']);
    }
}