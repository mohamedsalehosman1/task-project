<?php

namespace Modules\Products\Transformers;

use Modules\Services\Transformers\ServiceBriefResource;
use Modules\Vendors\Transformers\RatesResource;
use Modules\Vendors\Transformers\VendorsBriefResource;

class ProductResource extends ProductBreifResource
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
            'varainces' => ProductVarainceResource::collection($this->productVariances),
            'vendor' => VendorsBriefResource::make($this->vendor),
            'service' => ServiceBriefResource::make($this->service),
            'rates' => RatesResource::collection($this->rates()->latest()->take(2)->get()),
            'images' =>  $this->images,
            'materials' => $this->materials()->pluck("material")
        ]);
    }
}
