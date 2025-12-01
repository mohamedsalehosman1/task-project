<?php

namespace Modules\Vendors\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Products\Transformers\ProductBreifResource;
use Modules\Products\Transformers\ProductResource;
use Modules\Services\Transformers\ServiceSelectResource;
use Modules\Services\Transformers\ServicesResource;

class VendorDetailsResource extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'description' => $this->description,
            'rate' => (float) $this->rate,
            'is_favourite' => user() ? $this->isFavored : false,
            'address' => $this->address,
            'lat' => $this->lat,
            'long' => $this->long,
            'has_offer' => (bool) $this->offers->count(),
            'services'=> ServiceSelectResource::collection($this->services()->get()),
            'image' => $this->getImage(),
            'banners' => $this->getBanners(),
            'reviews' => RatesResource::collection($this->rates()->latest()->take(15)->get()),
            'products' => ProductBreifResource::collection($this->products)

        ];

        if (request("lat") != "null" && request("long") != "null" && !is_null(request("lat")) && !is_null(request("long")) && !is_null($this->lat) && !is_null($this->long)) {
            $distance = (float) round(calc(request("lat"), request("long"), $this->lat, $this->long, 'K'), 2);
            $data['distance'] = (int) $distance;
            $data['time'] = $this->distanceTime($distance);
        }

        return $data;
    }
}
