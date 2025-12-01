<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Transformers\UserResource;
use Modules\Addresses\Transformers\AddressesResource;
use Modules\Deliveries\Transformers\DeliveryBriefResource;
use Modules\Vendors\Transformers\VendorsBriefResource;

class OrderBreifResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'user_name' => $this->user->name,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'address' => new AddressesResource($this->whenLoaded("address")),
            'items' => OrderItemsResource::collection($this->whenLoaded("items")),
        ];

        return $data;
    }
}
