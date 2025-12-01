<?php

namespace Modules\Orders\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Addresses\Entities\Address;
use Modules\Deliveries\Entities\Delivery;
use Modules\Items\Entities\Item;
use Modules\Orders\Entities\OrderItem;
use Modules\Orders\Entities\OrderTax;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Accounts\Entities\User;
use Modules\Orders\Entities\OrderVendor;
use Modules\Orders\Entities\OrderVendorItem;
use Modules\Services\Entities\Service;
use Modules\Taxes\Entities\Tax;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Scopes\NotBlockedScope;
use Modules\Vendors\Entities\Vendor;

trait OrderRelations
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class)->withTrashed();
    }


    /**
     * @return HasMany
     */
    public function orderTaxes(): HasMany
    {
        return $this->hasMany(OrderTax::class);
    }

    /**
     * @return BelongsToMany
     */
    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class, "order_taxes")->withTrashed();
    }


    // public function items(): BelongsToMany
    // {
    //     return $this->belongsToMany(OrderItem::class, "order_items")->withTrashed();
    // }


    public function orderVendors()
    {
        return $this->hasMany(OrderVendor::class);
    }

    public function items()
    {
        return $this->hasMany(OrderVendorItem::class);
    }

    public function rates() {
        return $this->morphMany(Rate::class, 'rateable');
    }

}
