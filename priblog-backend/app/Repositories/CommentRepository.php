<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\BaseRepository\BaseEloquentRepository;
use App\Repositories\BaseRepository\Traits\ThrowsHttpExceptions;
use App\Repositories\Contracts\CommentRepositoryContract;

class CommentRepository extends BaseEloquentRepository implements CommentRepositoryContract
{
    use ThrowsHttpExceptions;

    protected $model = Comment::class;

    protected array $relationships = [
        'user',
        'blog',
    ];
}
