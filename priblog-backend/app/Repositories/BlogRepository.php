<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\BaseRepository\BaseEloquentRepository;
use App\Repositories\BaseRepository\Traits\ThrowsHttpExceptions;
use App\Repositories\Contracts\BlogRepositoryContract;

class BlogRepository extends BaseEloquentRepository implements BlogRepositoryContract
{
    use ThrowsHttpExceptions;

    protected $model = Blog::class;

    protected array $relationships = [
        'user',
        'comments',
    ];
}
