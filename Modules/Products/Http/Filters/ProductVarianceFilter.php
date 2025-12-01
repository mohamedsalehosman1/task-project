<?php

namespace Modules\Products\Http\Filters;

use App\Http\Filters\BaseFilters;

class ProductVarianceFilter extends BaseFilters
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
        'service',
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
        if ($value) {
            $this->vendor = $value;
            return $this->builder->whereHas("prices", function ($q) use ($value) {
                return $q->whereHas("vendorService", function ($qu) use ($value) {
                    return $qu->whereVendorId($value);
                });
            });
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given service.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function service($value)
    {
        if ($value) {
            return $this->builder->whereHas("prices", function ($q) use ($value) {
                return $q->whereHas("vendorService", function ($qu) use ($value) {
                    return $qu->whereServiceId($value)->when($this->vendor, fn($que) => $que->wherevendorId($this->vendor));
                });
            });
        }

        return $this->builder;
    }

}
