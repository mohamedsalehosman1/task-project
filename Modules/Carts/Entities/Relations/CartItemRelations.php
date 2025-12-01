<?php


namespace Modules\Carts\Entities\Relations;

use Modules\Carts\Entities\Cart;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;

trait CartItemRelations
{
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

}
