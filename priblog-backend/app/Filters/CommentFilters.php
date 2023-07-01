<?php

namespace app\Filters;

use App\Filters\BaseFilter\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

class CommentFilters extends QueryFilters
{
    public function filterByUserId($filter): Builder
    {
        return $this->builder->where('comments.user_id', $filter);
    }
    public function filterByBlogId($filter): Builder
    {
        return $this->builder->where('comments.blog_id', $filter);
    }

    protected function mandatoryFilters(): ?Builder
    {
        return null;
    }
}
