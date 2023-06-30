<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogRequest;
use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Services\BlogService;
use App\Models\Blog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(BlogRequest $request): JsonResponse
    {
        $blogService = app(BlogService::class);
        $this->authorize('viewAny', Blog::class);
        $blogs = $blogService->list($request);

        return BlogResource::collection($blogs)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function store(BlogStoreRequest $request): JsonResponse
    {
        $blogService = app(BlogService::class);
        $this->authorize('create', Blog::class);

        $store = $blogService->store($request);

        return BlogResource::make($store)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function show(BlogRequest $request, int $blogId): JsonResponse
    {
        $blogService = app(BlogService::class);
        $blog = $blogService->show($request, $blogId);
        $this->authorize('view', $blog);

        return BlogResource::make($blog)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function update(BlogUpdateRequest $request, int $blogId): JsonResponse
    {
        $blogService = app(BlogService::class);
        $blog = $blogService->show($request, $blogId);
        $this->authorize('update', $blog);

        $update = $blogService->update($request, $blog);

        return BlogResource::make($update)
            ->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Request $request, int $blogId): JsonResponse
    {
        $blogService = app(BlogService::class);
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
