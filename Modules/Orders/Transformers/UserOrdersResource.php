<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Transformers\UserResource;
use Modules\Addresses\Transformers\AddressesResource;
use Modules\Deliveries\Transformers\DeliveryBriefResource;
use Modules\Vendors\Transformers\VendorsBriefResource;

class UserOrdersResource extends JsonResource
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
            'parent_status' => $this->parentStatus,
            'status' => $this->status,

            'distance' => (float) $this->distance,
            'is_express' => (bool) $this->is_express,
            'is_delivered_by_client' => (bool) $this->is_delivered_by_client,

            'subTotal' => (float) $this->subtotal,
            'deliveryFee' => (float) $this->delivery_fee,
            'discount' => (float) $this->discount,
            'tax' => (float) $this->tax,
            'total' => (float) $this->total,

            'user' => new UserResource($this->whenLoaded("user")),
            'address' => new AddressesResource($this->whenLoaded("address")),
            'vendor' => new VendorsBriefResource($this->whenLoaded("vendor")),
            'pickup_delivery' => new DeliveryBriefResource($this->whenLoaded("pickupDelivery")),
            'return_delivery' => new DeliveryBriefResource($this->whenLoaded("returnDelivery")),
            'taxes' => OrderTaxesResource::collection($this->whenLoaded("orderTaxes")),
            'items' => OrderItemsResource::collection($this->whenLoaded("orderItems")),

            'reason' => $this->reason,
            'datetime' => $this->datetime ?? null,

            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'updated_at_formatted' => $this->updated_at->diffForHumans(),
        ];

        $data['direction'] = '';

        if ($this->pickup) {
            $data['direction'] = 'pickup';
        }

        if ($this->return) {
            $data['direction'] = 'return';
        }

        return $data;
    }
}
