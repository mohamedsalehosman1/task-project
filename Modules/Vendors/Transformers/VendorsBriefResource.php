<?php

namespace Modules\Vendors\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorsBriefResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->getImage(),
            'description' => $this->description,
            'address' => $this->address,
            'lat' => $this->lat,
            'long' => $this->long,
            'rate' => (float) $this->rate,
            'distance' => 0,
            'is_favourite' => user() ? $this->isFavored : false,
            'has_offer' => (bool) $this->offers->count(),
        ];

        if (request("lat") != "null" && request("long") != "null" && !is_null(request("lat")) && !is_null(request("long")) && !is_null($this->lat) && !is_null($this->long)) {
            $data['distance'] = (int) round(calc(request("lat"), request("long"), $this->lat, $this->long, 'K'), 2);
        }


        return $data;
    }
}
