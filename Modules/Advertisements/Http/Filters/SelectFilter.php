<?php

namespace Modules\Advertisements\Http\Filters;

use App\Http\Filters\BaseFilters;

class SelectFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'description',
        'vendor',
        'selected_id',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query by a given description.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function description($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('description', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given vendor id.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function vendor($value)
    {
        if ($value) {
            return $this->builder->where('vendor_id', $value);
        }

        return $this->builder;
    }

}
