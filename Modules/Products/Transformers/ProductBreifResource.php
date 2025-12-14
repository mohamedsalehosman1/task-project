<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'name' => translations($this, 'name'),
            'localized_name' => $this->name,
            'cover' => $this->cover,
            'old_price' => (float) $this->old_price,
            'price' => (float) $this->price,
            'offer_price' => (float) $this->offerPrice,
            'has_offer' => (bool) $this->offerPrice,
            'count_of_sold' => (int) $this->count_of_sold,
            'made_in' => (string) $this->made_in,
            'is_recommended' => (bool) $this->is_recommended,
            'is_favourite' => user() ? $this->isFavored : false,
            "rate" => round($this->rates()->avg('value'), 1),
            "rate_count" => $this->rates()->count(),
        ];
    }
}
