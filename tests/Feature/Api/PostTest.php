<?php

namespace Tests\Feature\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    private const GUARD = 'sanctum';

    /**
     * Create a token for the given user.
     */
    private function createTokenForUser(User $user): string
    {
        return $user->createToken('Test Token')->plainTextToken;
    }


    /**
     * Get all posts.
     */
    public function test_get_all_posts(): void
    {
        // Get a token for the user
        $user = User::factory()->create();
        $token = $this->createTokenForUser($user);

        // Send a GET request to the API with the token
        $response = $this->getJson('/api/v1/posts', ['Authorization' => "Bearer {$token}"]);

        $response->assertStatus(200);
    }


    /**
     * Test getting all posts without a token.
     */
    public function test_fail_get_all_posts(): void
    {
        $user = User::factory()->create();

        // No token is provided here to simulate unauthorized access
        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(401);
    }



    /**
     * Test getting a post by its ID.
     */
    public function test_get_post_by_id(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $this->actingAs($user,  self::GUARD);

        //Get a token for the user
        $token = $this->createTokenForUser($user);

        // Send a GET request to the API with the token
        $response = $this->getJson("/api/v1/posts/{$post->id}", [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertJsonFragment([
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }


    /**
     * Test getting a post by its ID without a token.
     */

    public function test_fail_get_post_by_id(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        // Send a GET request to the API without a token
        $response = $this->getJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(401);
    }



    /**
     * Test updating a post.
     */
    public function test_update_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $this->actingAs($user, self::GUARD);

        // Get a token for the user
        $token = $this->createTokenForUser($user);

        // Send a PUT request to the API with the token
        $response = $this->putJson("/api/v1/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertJsonFragment([
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ]);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ]);
    }

    /**
     * Test deleting a post.
     */
    public function test_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $this->actingAs($user, self::GUARD);

        // Get a token for the user
        $token = $this->createTokenForUser($user);

        // Send a DELETE request to the API with the token
        $response = $this->deleteJson("/api/v1/posts/{$post->id}", [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /**
     * Test deleting a post that does not exist.
     */

    public function test_delete_nonexistent_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, self::GUARD);

        $response = $this->deleteJson('/api/v1/posts/999999');

        $response->assertNotFound();
    }

    /**
     * Test creating a post.
     */
    public function test_create_post(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, self::GUARD);

        // Get a token for the user
        $token = $this->createTokenForUser($user);

        // Send a POST request to the API with the token
        $response = $this->postJson('/api/v1/posts', [
            'title' => 'New Title',
            'content' => 'New Content',
            'user_id' => $user->id
        ], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'title' => 'New Title',
            'content' => 'New Content',
        ]);
    }


    /**
     * Test creating a post without a token.
     */
    public function test_fail_create_post(): void
    {
        $user = User::factory()->create();

        // No token is provided here to simulate unauthorized access
        $response = $this->postJson('/api/v1/posts', [
            'title' => 'New Title',
            'content' => 'New Content',
            'user_id' => $user->id
        ]);

        $response->assertStatus(401);
    }
}
