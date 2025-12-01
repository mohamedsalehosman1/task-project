<?php

namespace Modules\Vendors\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RatesResource extends JsonResource
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
            'user' => (String) $this->user->name ?? null,
            'user_image' => (String) $this->user->getAvatar(),
            'comment' => (string) $this->comment,
            'value' => (Integer) $this->value,
            'human_date' => $this->created_at->diffForHumans(now() , null , false, 2),
            'created_at' => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
