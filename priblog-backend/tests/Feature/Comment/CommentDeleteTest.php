<?php

namespace Tests\Feature\Comment;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentDeleteTest extends TestCase
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

    public function test_create_user_and_create_comment_and_delete()
    {
        $data = [
            'blog_id' => 1,
            'comment' => 'test comment',
        ];
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withToken($token)
            ->post(self::$url, $data);

        $response->assertSuccessful()->assertJsonStructure([
            'data' => [
                'blog_id',
                'user_id',
                'comment',
            ],
        ]);

        $blogId = $response->json()['data']['id'];
        $this->withToken($token)
            ->delete(self::$url.$blogId)
            ->assertSuccessful();
    }

    public function test_cant_access_without_token()
    {
        $this->delete(self::$url.'1')
            ->assertRedirectToRoute('login');
    }
}
