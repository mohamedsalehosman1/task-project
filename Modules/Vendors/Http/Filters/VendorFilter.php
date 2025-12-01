<?php

namespace Modules\Vendors\Http\Filters;

use App\Http\Filters\BaseFilters;
use DB;

class VendorFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'search',
        'email',
        'phone',
        'filter',
        'nearest',
        'highRate',
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
     * search in vendor.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function search($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('name', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query to include users by email.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function email($value)
    {
        if ($value) {
            return $this->builder->where('email', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query to include users by phone.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function phone($value)
    {
        if ($value) {
            return $this->builder->where('phone', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function nearest($value)
    {
        $lat = request('lat');
        $long = request('long');

        if ($value && $lat && $long) {
            $this->builder->select("*")
                ->selectRaw('( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( `long` ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) ) AS distance')
                ->orderBy('distance', 'asc');
        }

        return $this->builder;
    }


    /**
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function highRate($value)
    {
        if ($value) {
            $this->builder->select('vendors.*', DB::raw('SUM(rates.value) as total_rating'))
                ->leftJoin('rates', 'vendors.id', '=', 'rates.vendor_id')
                ->groupBy('vendors.id')
                ->orderByDesc('total_rating');
        }

        return $this->builder;
    }

    /**
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function filter($value)
    {
        if ($value == 'highRate') {
            $this->highRate($value);
        } elseif ($value == 'nearest') {
            $this->nearest($value);
        }

        return $this->builder;
    }






}
