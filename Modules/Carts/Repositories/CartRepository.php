<?php

namespace Modules\Carts\Repositories;

use Exception;
use Modules\Contracts\CrudRepository;

class CartRepository implements CrudRepository
{
    private $cart;

    public function setUser($user)
    {
        $this->cart = $user->cart ?? $user->cart()->create();
        return $this;
    }

    public function all()
    {
        return $this->cart;
    }

    public function create($data)
    {
        $data = collect($data);

        $this->cart->items()->updateOrCreate(
            $data->only('product_id')->toArray(),
            $data->only('quantity')->toArray()
        );

        return $this->cart->load('items.product'); // تحميل العناصر مع المنتج مثلاً
    }

    public function delete($productIds)
    {
        $this->cart->items()->whereIn('product_id', $productIds)->delete();
        return $this->cart;
    }

    public function destroyAllCart()
    {
        $this->cart->items()->delete();
        return $this->cart;
    }
    public function find($model)
{
    return null;
}

public function update($model, $data)
{
    return null;
}

}
