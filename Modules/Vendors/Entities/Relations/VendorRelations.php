<?php


namespace Modules\Vendors\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Accounts\Entities\Admin;
use Modules\Accounts\Entities\Verification;
use Modules\Offers\Entities\Offer;
use Modules\Orders\Entities\Order;
use Modules\Products\Entities\Product;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\VendorService;
use Modules\Vendors\Entities\Rate;
use Modules\Workers\Entities\Worker;

trait VendorRelations
{

    /**
     * Get the Vendor's verification.
     */
    public function verification(): MorphOne
    {
        return $this->morphOne(Verification::class, 'parentable');
    }


    /**
     * Get the admin associated with the VendorRelations
     *
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }



    public function orders()
    {
        return $this->belongsToMany(Order::class , 'order_vendors');
    }

    public function rates() {
        return $this->morphMany(Rate::class, 'rateable');
    }

    /**
     * The services that belong to the VendorRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'vendor_services');
    }


    /**
     * Get all of the offers for the VendorRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }


    /**
     * Get all of the products for the VendorRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
