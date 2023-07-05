<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentRequest;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Services\CommentService;
use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CommentController extends Controller
{
    public function __construct(private readonly CommentService $commentService)
    {
    }

    /**
     * @throws AuthorizationException
     */
    public function index(CommentRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Comment::class);
        $comments = $this->commentService->list($request);

        return CommentResource::collection($comments)
            ->response();
    }

    /**
     * @throws AuthorizationException|Throwable
     */
    public function store(CommentStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Comment::class);

        $store = $this->commentService->store($request);

        return CommentResource::make($store)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function show(CommentRequest $request, int $commentId): JsonResponse
    {
        $comment = $this->commentService->show($request, $commentId);
        $this->authorize('view', $comment);

        return CommentResource::make($comment)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function update(CommentUpdateRequest $request, int $commentId): JsonResponse
    {
        $comment = $this->commentService->show($request, $commentId);
        $this->authorize('update', $comment);

        $update = $this->commentService->update($request, $comment);

        return CommentResource::make($update)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Request $request, int $commentId): JsonResponse
    {
        /** @var Comment $comment */
        $comment = $this->commentService->show($request, $commentId);
        $this->authorize('delete', $comment);

        $result = $this->commentService->delete($comment);

        if ($result) {
            return response()
                ->json(['message' => 'deleted successfully'])
                ->setStatusCode(200);
        }

        return response()
            ->json(['message' => 'delete exception'])
            ->setStatusCode(500);
    }
}
