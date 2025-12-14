<?php

namespace Modules\Advertisements\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementsResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->getImage(),
            'isVendorExists' => (bool) $this->vendor ,
            'vendor' => $this->vendor?->name ,
            'vendor_id' => $this->vendor?->id ,
        ];
    }
}
