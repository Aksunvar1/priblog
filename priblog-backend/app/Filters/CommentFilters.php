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
}
