<?php

namespace Modules\Accounts\Http\Filters;

use App\Http\Filters\BaseFilters;

class RateFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'washer',
    ];


    /**
     * Filter the query to include users by washer.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function washer($value)
    {
        if ($value) {
            return $this->builder->whereWasherId($value);
        }

        return $this->builder;
    }
}
