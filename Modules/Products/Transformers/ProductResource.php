<?php
namespace Modules\Products\Transformers;

use Google\Service\Datastore\Avg;

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
        if($this->max_amount > 0){
            $this->available = true;
        }
        else{
            $this->available = false;
        }
        return array_merge(parent::toArray($request), [
            'company_name'          => $this->company_name,
            'service_provider_name' => $this->vendor->name ?? null,
            'description'           => $this->description,
            'quantity'              => $this->max_amount,
            'status'                => $this->status,
            'pay_type'              => $this->pay_type,
            'base_preparation_time' => $this->base_preparation_time,
'available'             => $this->available,
            'active'                => $this->active,
            'addresses'             => $this->addresses->map(function ($address) {
                return [
                    'id'        => $address->id,
                    'range'     => $address->pivot->range,
                    'name'      => $address->name ?? null, // أو أي عمود عندك في جدول العناوين
                    'latitude'  => $address->pivot->latitude,
                    'longitude' => $address->pivot->longitude,
                ];
            }),
            'working_hours'         => $this->workingHours->map(function ($workingHours) {
                return [
                    'id'   => $workingHours->id,
                    'day'  => $workingHours->day ?? null,
                    'from' => $workingHours->from,
                    'to'   => $workingHours->to,
                ];
            }),

            'images'                => $this->images,
        ]);
    }
}
