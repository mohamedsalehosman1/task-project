<?php

namespace Modules\Vendors\Transformers;

use App\Http\Resources\ImagesResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Products\Transformers\ProductResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $code = $this->verification;
        $r_code = ResetPasswordCode::where('username', $this->phone)->first();
        if ($code) {
            $userCode = $code->code;
        } elseif ($r_code) {
            $userCode = $r_code->code;
        } else {
            $userCode = '';
        }
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'description' => $this->description,
            'code' => $userCode,
            'rate' => (float) $this->rate,
            'image' => $this->getImage(),
            'banners' => $this->getBanners(),
            'device_token' => (string) $this->device_token,
            'address' => $this->address,
            'lat' => $this->lat,
            'long' => $this->long,
            'reset_token' => (string) $this->reset_token,
            'verified' => $this->hasVerifiedPhone(),
            'verified_at' => Carbon::parse($this->phone_verified_at)->format('d/m/Y H:i'),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
        ];

        if (request("lat") != "null" && request("long") != "null" && !is_null(request("lat")) && !is_null(request("long")) && !is_null($this->lat) && !is_null($this->long)) {
            $data['distance'] = (int) round(calc(request("lat"), request("long"), $this->lat, $this->long, 'K'), 2);
        }

        return $data;
    }
}
