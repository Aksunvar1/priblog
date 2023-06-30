<?php

namespace Tests\Feature\Blog;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BlogStoreTest extends TestCase
{
    use DatabaseMigrations;

    private static string $url;

    public static function setUpBeforeClass(): void
    {
        self::$url = '/api/blogs/';
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        \Http::preventStrayRequests();
    }

    public function test_create_user_and_create_blog()
    {
        $data = [
            'title' => 'test title',
            'content' => 'testing content for the blog create endpoint',
        ];
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $this->withToken($token)
            ->post(self::$url, $data)
            ->assertSuccessful()->assertJsonStructure([
                'data' => [
                    'user_id',
                    'title',
                    'content',
                ],
            ]);
    }

    public function test_cant_access_without_token()
    {
        $data = [
            'title' => 'test title',
            'content' => 'testing content for the blog create endpoint',
        ];
        $this->post(self::$url, $data)
            ->assertRedirectToRoute('login');
    }
}
