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

class CommentController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(CommentRequest $request): JsonResponse
    {
        $blogService = app(CommentService::class);
        $this->authorize('viewAny', Comment::class);
        $blogs = $blogService->list($request);

        return CommentResource::collection($blogs)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CommentStoreRequest $request): JsonResponse
    {
        $blogService = app(CommentService::class);
        $this->authorize('create', Comment::class);

        $store = $blogService->store($request);

        return CommentResource::make($store)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function show(CommentRequest $request, int $blogId): JsonResponse
    {
        $blogService = app(CommentService::class);
        $blog = $blogService->show($request, $blogId);
        $this->authorize('view', $blog);

        return CommentResource::make($blog)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function update(CommentUpdateRequest $request, int $blogId): JsonResponse
    {
        $blogService = app(CommentService::class);
        $blog = $blogService->show($request, $blogId);
        $this->authorize('update', $blog);

        $update = $blogService->update($request, $blog);

        return CommentResource::make($update)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Request $request, int $blogId): JsonResponse
    {
        $blogService = app(CommentService::class);
        $blog = $blogService->show($request, $blogId);
        $this->authorize('delete', $blog);

        $result = $blogService->delete($blog);

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
