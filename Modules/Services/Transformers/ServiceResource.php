<?php

namespace Modules\Services\Transformers;

use Modules\Products\Transformers\ProductBreifResource;


class ServiceResource extends ServiceBriefResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            "products" => ProductBreifResource::collection($this->products)
        ]);
    }
}
