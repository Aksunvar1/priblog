<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'blog_id' => $this->resource->blog_id,
            'user_id' => $this->resource->user_id,
            'comment' => $this->resource->comment,
            'created_at' => $this->resource->created_at,
            'user' => $this->whenLoaded('user', function () {
                return UserResource::make($this->resource->user);
            }),
            'blog' => $this->whenLoaded('blog', function () {
                return BlogResource::make($this->resource->blog);
            }),
        ];
    }
}
