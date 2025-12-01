<?php


namespace Modules\Products\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Addresses\Entities\Region;
use Modules\Offers\Entities\Offer;
use Modules\Offers\Entities\OfferProduct;
use Modules\Products\Entities\Material;
use Modules\Products\Entities\ProductVariance;
use Modules\Services\Entities\Service;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Vendor;

trait ProductRelations
{

    /**
     * Get the vendor that owns the ProductRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }


    /**
     * Get the service that owns the ProductRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get all of the productVariances for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function productVariances(): HasMany
    // {
    //     return $this->hasMany(ProductVariance::class);
    // }

    public function rates() {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function offer()
    {
        return $this->hasOne(OfferProduct::class);
    }
public function region()
    {
        return $this->belongsTo(Region::class);
    }
    /**
     * Get all of the materials for the ProductRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function materials(): HasMany
    // {
    //     return $this->hasMany(Material::class);
    // }

}
