<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::withoutEvents(function () {
            User::factory()->count(3)->create()
                ->each(function (User $user) {
                    Blog::factory()->create([
                        'user_id' => $user->id,
                    ])->each(function (Blog $blog) use ($user) {
                        Comment::factory()->create([
                            'user_id' => $user->id,
                            'blog_id' => $blog->id,
                        ]);
                    });
                });
        });
    }
}
