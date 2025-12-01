<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Addresses\Entities\Address;

class UserProductAddress extends Model
{
    use HasFactory;

    protected $table = 'product_addresses';

    protected $fillable = [
        'user_product_id',
        'address_id',
        'latitude',
        'longitude',
    ];

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(UserProduct::class);
    }
 public function userproductAddresses()
    {
        return $this->hasMany(\Modules\Products\Entities\ProductAddress::class);
    }

    // العلاقة مع العنوان
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
