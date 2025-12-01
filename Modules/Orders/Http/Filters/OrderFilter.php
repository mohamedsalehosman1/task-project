<?php

namespace Modules\Orders\Http\Filters;

use App\Enums\OrderStatusEnum;
use App\Http\Filters\BaseFilters;

class OrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'id',
        'status',
        'filter'
    ];

    /**
     * Filter the query by a given id.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function id($value)
    {
        if ($value) {
            return $this->builder->where('id', $value);
        }
        return $this->builder;
    }

    /**
     * Filter the query by a given id.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */

    protected function status($value)
    {
        if ($value && gettype($value) == "string") {
            $value = explode(",", $value);
            return $this->builder->whereIn("status", $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given status.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */

    protected function filter($value)
    {
        if ($value) {
            if($value == 'current'){
                return $this->builder->whereIn("status", [OrderStatusEnum::OnwayToClient->value , OrderStatusEnum::OnwayToLaundry->value]);
            }elseif($value == 'cancelled'){
                return $this->builder->whereIn("status", [OrderStatusEnum::Cancelled->value]);
            }
        }

        return $this->builder;
    }


}
