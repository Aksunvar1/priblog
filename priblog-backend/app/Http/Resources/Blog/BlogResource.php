<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'title' => $this->resource->title,
            'user_id' => $this->resource->user_id,
            'content' => $this->resource->content,
            'created_at' => $this->resource->created_at,
            'user' => $this->whenLoaded('user', function () {
                return UserResource::make($this->resource->user);
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return CommentResource::collection($this->resource->comments);
            }),
        ];
    }
}
