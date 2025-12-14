<?php

namespace Modules\Advertisements\Entities\Scopes;

use Carbon\Carbon;

trait AdvertisementScopes
{

    // Define the scope to select expired advertisements
    public function scopeExpire($query, $flag = true)
    {
        $currentDate = Carbon::now();
        return $query->where('end_at', $flag ? '<' : '>', $currentDate)
            ->when(!$flag, fn ($q) => $q->orWhere("defined", false));
    }


    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeDefined($query)
    {
        return $query->where('defined', true);
    }

    public function scopeValidVendor($query)
    {
        return $query->whereHas('vendor');
    }

}
