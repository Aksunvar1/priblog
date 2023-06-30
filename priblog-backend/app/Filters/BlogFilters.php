<?php

namespace app\Filters;

use App\Filters\BaseFilter\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

class BlogFilters extends QueryFilters
{
    public function filterByUserId($filter): Builder
    {
        return $this->builder->where('blogs.user_id', $filter);
    }

    protected function mandatoryFilters(): ?Builder
    {
        return null;
    }
}
