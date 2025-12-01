<?php

namespace Modules\Products\Http\Filters;

use App\Http\Filters\BaseFilters;

class ProductFilter extends BaseFilters
{
    private $vendor;


    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'description',
        'vendor',
        'service_id',
        'color_ids',
        'size_ids',
        'min_price',
        'max_price',
        'rate',
        'filter'
    ];


    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function filter($value)
    {
        if ($value == 'recommended') {
            return $this->builder->whereIsRecommended(true);
        } elseif ($value == 'top_selling') {
            return $this->builder->orderByDesc('count_of_sold');
        } elseif ($value == 'flash_sale') {
            return $this->builder->whereHas('offer');
        } elseif ($value == 'for_you') {
            return $this->builder->inRandomOrder(user() ? (user()->id + today()->dayOfWeek) : today()->dayOfWeek);
        }
        return $this->builder;
    }
    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('name', "%$value%");
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
            return $this->builder->where('description', 'like', "%$value%");
        }
        return $this->builder;
    }

    /**
     * Filter the query by a given vendor.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */

    protected function vendor($value)
    {
        return $this->builder;
    }

    /**
     * Filter the query by a given service.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function serviceId($value)
    {
        return $this->builder->whereServiceId($value);
    }

    protected function colorIds($values)
    {

        if (!is_array($values)) {
            $values = explode(',', $values);
        }
        return $this->builder->whereHas('productVariances', function ($query) use ($values) {
            $query->whereIn('color_id', $values);
        });
    }

    protected function sizeIds($values)
    {

        if (!is_array($values)) {
            $values = explode(',', $values);
        }
        return $this->builder->whereHas('productVariances', function ($query) use ($values) {
            $query->whereIn('size_id', $values);
        });
    }

    protected function minPrice($value)
    {
        return $this->builder->where('price', '>=', $value);
    }

    protected function maxPrice($value)
    {
        return $this->builder->where('price', '<=', $value);
    }

    protected function rate($value)
    {
        return $this->builder->whereHas('rates', function ($query) use ($value) {
            $query->havingRaw('AVG(value) >= ?', [$value]);
        });
    }
}
