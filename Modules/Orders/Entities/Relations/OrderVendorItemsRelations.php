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
use Modules\Colors\Entities\Color;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderVendor;
use Modules\Orders\Entities\OrderVendorItem;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;
use Modules\Services\Entities\Service;
use Modules\Sizes\Entities\Size;
use Modules\Taxes\Entities\Tax;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Scopes\NotBlockedScope;
use Modules\Vendors\Entities\Vendor;

trait OrderVendorItemsRelations
{



    /**
     * Get the service that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    public function orderVendor()
    {
        return $this->belongsTo(OrderVendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariance()
    {
        return $this->belongsTo(ProductVariance::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
