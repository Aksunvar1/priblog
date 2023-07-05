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

    /**
     * @dataProvider validationDataProvider
     */
    public function testCommentStoreWithParams(array $data, int $status, string $message = '')
    {
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $response = $this->withToken($token)
            ->withHeader('Accept', 'application/json')
            ->post(self::$url, $data);
        $response->assertStatus($status);
        if ($response->getStatusCode() != 201) {
            $this->assertSame($message, $response->json()['message']);
        }
    }

    public static function validationDataProvider(): array
    {
        return [
            [
                [
                    'blog_id' => 1,
                    'comment' => 'testing comment for the comment create endpoint',
                ],
                201,
            ],
            [
                [
                    'comment' => 'testing comment for the comment create endpoint',
                ],
                422,
                'The blog id field is required.',
            ],
            [
                [
                    'blog_id' => 999,
                    'comment' => 'testing comment for the comment create endpoint',
                ],
                422,
                'The selected blog id is invalid.',
            ],
            [
                [
                    'blog_id' => 1,
                ],
                422,
                'The comment field is required.',
            ],
            [
                [
                    'blog_id' => 1,
                    'comment' => 123123,
                ],
                422,
                'The comment field must be a string.',
            ],
        ];
    }
}
