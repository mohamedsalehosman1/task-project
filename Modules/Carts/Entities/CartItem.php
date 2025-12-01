<?php

namespace Modules\Carts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Carts\Entities\Relations\CartItemRelations;

class CartItem extends Model
{
    use HasFactory, CartItemRelations;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];


public function product()
{
    return $this->belongsTo(\Modules\Products\Entities\Product::class);
}

}
