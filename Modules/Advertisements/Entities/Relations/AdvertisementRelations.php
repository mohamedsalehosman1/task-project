<?php

namespace Modules\Advertisements\Entities\Relations;

use Modules\Vendors\Entities\Vendor;

trait AdvertisementRelations
{
    /**
     * Get the Advertisement's vendor.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
