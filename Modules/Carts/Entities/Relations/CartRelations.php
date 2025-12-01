<?php


namespace Modules\Carts\Entities\Relations;


use Modules\Carts\Entities\CartItem;

trait CartRelations
{

    public function cartable()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
