<?php

namespace Modules\Advertisements\Entities\Helpers;

use Carbon\Carbon;
use Modules\Advertisements\Transformers\AdvertisementsResource;
use Modules\Vendors\Entities\Vendor;

trait AdvertisementHelpers
{

    /**
     * The advertisement image url.
     *
     */
    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }


    /**
     * @return int
     * @throws \Exception
     */
    public function getDurationAttribute()
    {
        $to = Carbon::parse($this->end_at);
        $from = Carbon::parse($this->start_at);
        $diff_in_days = $to->diffInDays($from);
        return $diff_in_days;
    }


    /**
     *
     * @return bool
     */
    public function isActive()
    {
        if ($this->active == 1) {
            return true;
        }
        return false;
    }


    /**
     *
     * @return bool
     */
    public function isExpired()
    {
        if (!$this->end_at->isFuture()) {
            return true;
        }
    }


    /**
     * Get the resource for coupon.
     *
     * @return AdvertisementsResource
     */
    public function getResource()
    {
        return new AdvertisementsResource($this);
    }


    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getType()
    {
        return __("vendors::vendors.singular");
    }

    public function getTypeAttribute()
    {
        return 'vendor';
    }

    public function getTargetAttribute()
    {
        if ($vendor = Vendor::find($this->vendor_id)){
            return "<a href='{$vendor->id}'>{$vendor->name}</a>";
        }
        return trans("Product not found");
    }
}
