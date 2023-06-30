<?php

namespace App\Http\Services;

use App\Filters\BlogFilters;
use App\Http\Requests\Blog\BlogRequest;
use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;

class BlogService
{
    public function __construct(private readonly BlogRepositoryContract $blogRepository)
    {
    }

    public function list(BlogRequest $request)
    {
        $filter = app(BlogFilters::class);
        $filter->setFilters($request->all());

        $this->blogRepository->parseRequest($request->validated());
        $this->blogRepository
            ->withFilters($filter)
            ->with([
                'user',
                'comments',
            ]);

        return $this->blogRepository->getAll(['*']);
    }

    /**
     * @throws Throwable
     */
    public function store(BlogStoreRequest $request): ?Model
    {
        return $this->blogRepository->transaction(function () use ($request, &$blog) {
            /** @var Blog $blog */
            $blog = $this->blogRepository
                ->create($request->validated());

            return $blog->loadMissing([
                'user',
                'comments',
            ]);
        });
    }

    public function show(Request $request, int $blogId): ?Model
    {
        $this->blogRepository->parseRequest($request->all());

        $blog = $this->blogRepository
            ->getById($blogId);

        abort_if(! $blog, 404);

        return $blog
            ->loadMissing([
                'user',
                'comments',
            ]);
    }

    public function update(BlogUpdateRequest $request, $blog): ?Model
    {
        $this->blogRepository->update($blog, $request->validated());

        return $blog
            ->loadMissing([
                'user',
                'comments',
            ])
            ->refresh();
    }

    public function delete(Blog $blog): ?bool
    {
        return $this->blogRepository->delete($blog);
    }
}
