<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Carts\Entities\CartItem;

class ProductBreifResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
          $user = auth()->user();

        $inCart = false;

        if ($user && $user->cart) {
            $inCart = CartItem::where('cart_id', $user->cart->id)
                ->where('product_id', $this->id)
                ->exists();
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cover' => $this->cover,
            'old_price' => (float) $this->old_price,
            'price' => (float) $this->price,
            'in_cart' => $inCart,

        ];
    }
}
