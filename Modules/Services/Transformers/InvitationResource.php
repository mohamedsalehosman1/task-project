<?php

namespace Modules\Services\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
{
    /**
     * تحويل المورد إلى مصفوفة (Array).
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'event_type' => $this->event_type,
            'groom_name' => $this->groom_name,
            'bride_name' => $this->bride_name,
            'event_details' => [ // تجميع تفاصيل التاريخ والمكان
                'date' => $this->event_date,
                'time' => $this->event_time,
                'location_text' => $this->location_text,
                'location_url' => $this->location_url,
            ],
           'design_elements' => [
    'quran_verse'     => $this->quran_verse,
    'image_url'       => $this->getFirstMediaUrl('main_photo'),
    'invitation_text' => $this->invitation_text,
],

            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // تنسيق التاريخ
        ];
    }
}
