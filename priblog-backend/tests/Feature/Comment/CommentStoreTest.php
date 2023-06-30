<?php

namespace Tests\Feature\Comment;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentStoreTest extends TestCase
{
    use DatabaseMigrations;

    private static string $url;

    public static function setUpBeforeClass(): void
    {
        self::$url = '/api/comments/';
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        \Http::preventStrayRequests();
    }

    public function test_create_user_and_create_comment()
    {
        $data = [
            'blog_id' => 1,
            'comment' => 'testing comment for the comment create endpoint',
        ];
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $this->withToken($token)
            ->post(self::$url, $data)
            ->assertSuccessful()->assertJsonStructure([
                'data' => [
                    'user_id',
                    'blog_id',
                    'comment',
                ],
            ]);
    }

    public function test_cant_access_without_token()
    {
        $data = [
            'blog_id' => 1,
            'comment' => 'testing comment for the comment create endpoint',
        ];
        $this->post(self::$url, $data)
            ->assertRedirectToRoute('login');
    }
}
