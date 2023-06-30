<?php

namespace App\Http\Services;

use App\Filters\CommentFilters;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;

class CommentService
{
    public function __construct(private readonly CommentRepositoryContract $commentRepository)
    {
    }

    public function list(CommentRequest $request)
    {
        $filter = app(CommentFilters::class);
        $filter->setFilters($request->all());

        $this->commentRepository->parseRequest($request->validated());
        $this->commentRepository
            ->withFilters($filter)
            ->with([
                'user',
                'comments',
            ]);

        return $this->commentRepository->getAll(['*']);
    }

    /**
     * @throws Throwable
     */
    public function store(CommentStoreRequest $request): ?Model
    {
        return $this->commentRepository->transaction(function () use ($request, &$comment) {
            /** @var Comment $comment */
            $comment = $this->commentRepository
                ->create($request->validated());

            return $comment->loadMissing([
                'user',
                'comments',
            ]);
        });
    }

    public function show(Request $request, int $commentId): ?Model
    {
        $this->commentRepository->parseRequest($request->all());

        $comment = $this->commentRepository
            ->getById($commentId);

        abort_if(! $comment, 404);

        return $comment
            ->loadMissing([
                'user',
                'comments',
            ]);
    }

    public function update(CommentUpdateRequest $request, $comment): ?Model
    {
        $this->commentRepository->update($comment, $request->validated());

        return $comment
            ->loadMissing([
                'user',
                'comments',
            ])
            ->refresh();
    }

    public function delete(Comment $comment): ?bool
    {
        return $this->commentRepository->delete($comment);
    }
}
