<?php

namespace App\Providers;

use App\Repositories\BlogRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Contracts\BlogRepositoryContract;
use App\Repositories\Contracts\CommentRepositoryContract;
use Illuminate\Support\ServiceProvider;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RepositoryBinderProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(BlogRepositoryContract::class, BlogRepository::class);
        $this->app->bind(CommentRepositoryContract::class, CommentRepository::class);
    }
}
