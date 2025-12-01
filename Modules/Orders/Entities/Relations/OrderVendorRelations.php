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
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderVendor;
use Modules\Orders\Entities\OrderVendorItem;
use Modules\Services\Entities\Service;
use Modules\Taxes\Entities\Tax;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Scopes\NotBlockedScope;
use Modules\Vendors\Entities\Vendor;

trait OrderVendorRelations
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(OrderVendorItem::class);
    }


}
