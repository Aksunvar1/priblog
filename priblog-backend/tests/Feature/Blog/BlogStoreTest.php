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

    /**
     * @dataProvider validationDataProvider
     */
    public function testBlogStoreWithParams(array $data, int $status, string $message = '')
    {
        /** @var User $user */
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $response = $this->withToken($token)
            ->withHeader('Accept','application/json')
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
                    'title' => 'test title',
                    'content' => 'testing content for the blog create endpoint',
                ],
                201,
            ],
            [
                [
                    'content' => 'testing content for the blog create endpoint',
                ],
                422,
                'The title field is required.',
            ],
            [
                [
                    'title' => 'test title',
                ],
                422,
                'The content field is required.',
            ],
            [
                [
                    'title' => 123555,
                    'content' => 'testing content for the blog create endpoint',
                ],
                422,
                'The title field must be a string.',
            ],
            [
                [
                    'title' => 'test title',
                    'content' => 123,
                ],
                422,
                'The content field must be a string.',
            ],
        ];
    }
}
