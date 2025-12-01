<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Items\Entities\Item;
use Modules\Orders\Entities\Relations\OrderVendorItemsRelations;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;
use Modules\Services\Entities\Service;
use Modules\Sizes\Entities\Size;

class OrderVendorItem extends Model
{
    use HasFactory,OrderVendorItemsRelations;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'order_vendor_id',
        'product_id',
        'size_id',
        'color_id',
        'quantity',
        'delivery_longitude',
        'delivery_latitude',
        'delivery_date',
        'delivery_time',
        'price',
        ];



    // protected $with = [
    //     'service',
    //     'item',
    // ];






}
