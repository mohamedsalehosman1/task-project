<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Addresses\Entities\Address;

class ProductAddress extends Model
{
    use HasFactory;

    protected $table = 'product_addresses';

    protected $fillable = [
        'product_id',
        'address_id',
        'range',
        'latitude',
        'longitude',
    ];

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // العلاقة مع العنوان
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
