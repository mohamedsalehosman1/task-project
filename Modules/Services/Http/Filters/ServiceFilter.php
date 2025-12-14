<?php

namespace Modules\Services\Http\Filters;

use App\Http\Filters\BaseFilters;

class ServiceFilter extends BaseFilters
{

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'vendor',
        'main_service',
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
     * Filter the query by a given vendor.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function vendor($value)
    {
        if ($value) {
            return $this->builder->where(function ($q) use ($value) {
                return $q->whereHas("vendorServices", function ($qu) use ($value) {
                    return $qu->whereVendorId($value);
                });
            });
        }

        return $this->builder;
    }



    /**
     * Filter The query by main service.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */


    protected function mainService($value)
    {
        if ($value) {
            return $this->builder->parentService();
        }
        return $this->builder;
    }


}
