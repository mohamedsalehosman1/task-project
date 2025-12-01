<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product'=> $this->product->name,
            'color'=> $this->color->name,
            'size'=> $this->size->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}
