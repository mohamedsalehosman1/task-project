<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Orders\Entities\Relations\OrderVendorRelations;
use Modules\Vendors\Entities\Vendor;

class OrderVendor extends Model
{
    use HasFactory,OrderVendorRelations;

    protected $fillable = [
        'subtotal',
        'tax',
        'total',
        'order_id',
        'vendor_id'

    ];

// Modules\Orders\Entities\OrderVendor.php

public function vendor()
{
    return $this->belongsTo(\Modules\Vendors\Entities\Vendor::class);
}

}
