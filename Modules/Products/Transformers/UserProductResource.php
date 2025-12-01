<?php
namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'cover' => $this->cover ?? '',
            'old_price' => $this->old_price ?? 0,
            'price' => $this->price ?? 0,
            'company_name' => $this->company_name ?? null,
            'service_provider_name' => $this->user_service_name ?? null,
            'description' => $this->description ?? null,
'phone'=>$this->phone,
            'addresses' => $this->addresses?->map(function ($address) {
    return [
        'id' => $address->id,
        'name' => $address->name ?? null,
        'latitude' => $address->pivot->latitude,
        'longitude' => $address->pivot->longitude,
    ];
}) ?? [],


            'images' => $this->images ?? [],
        ];
    }
}
