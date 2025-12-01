<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Colors\Entities\Color;
use Modules\Colors\Transformers\ColorResource;
use Modules\Sizes\Transformers\SizesResource;

class ProductVarainceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'color' => ColorResource::make($this->color),
            'size' => SizesResource::make($this->size),
            'quantity' => $this->quantity
        ];
    }
}
