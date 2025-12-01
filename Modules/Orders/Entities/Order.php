<?php

namespace Modules\Orders\Entities;

use App\Enums\OrderStatusEnum;
use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Database\factories\OrderFactory;
use Modules\Orders\Entities\OrderHelper;
use Modules\Orders\Entities\Relations\OrderRelations;
use Modules\Orders\Entities\Scopes\OrderGlobalScope;
use Modules\Orders\Entities\Scopes\OrderScopes;

class Order extends Model
{
    use OrderRelations, OrderHelper, Filterable, HasFactory, OrderScopes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'address_id',

        'subtotal',
        'tax',
        'total',


        'invoice_id',
        'payment_id',

        'status',
        'reason',
        'is_refunded',
        'rate'
    ];

    protected $with = [
        "user",
        "address",
        "orderTaxes",
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new OrderGlobalScope());
    // }


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return OrderFactory::new();
    }


    /**
     * Get the resource for order.
     *
     * @return \Modules\Orders\Transformers\OrderBreifResource
     */
    public function getResource()
    {
        return  new \Modules\Orders\Transformers\OrderBreifResource($this);
    }
    public function vendorItems()
{
    return $this->hasMany(\Modules\Orders\Entities\OrderVendorItem::class);
}
public function vendor()
{
    return $this->hasOneThrough(
        \Modules\Vendors\Entities\Vendor::class,
        \Modules\Orders\Entities\OrderVendor::class,
        'order_id',   // المفتاح في order_vendors
        'id',         // المفتاح في vendors
        'id',         // المفتاح في orders
        'vendor_id'   // المفتاح في order_vendors
    );
}
}
