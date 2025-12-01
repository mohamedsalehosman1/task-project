<?php

namespace Modules\Carts\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductVarainceResource;

class CartItemBreifResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $product = $this->product;
        return [
            'id' =>$product->id,
            'name' =>  translations($product, 'name'),
            'localized_name' => $product->name,
            'quantity' => (int) $this->quantity,
            'price' => (float) $product->price,
            'cover' => $product->cover,
            'is_deleted' => (bool) $product->deleted_at  ,
            // 'varainces' => new ProductVarainceResource($this->productVariance),
        ];
    }
}
