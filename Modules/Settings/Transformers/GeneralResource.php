<?php

namespace Modules\Settings\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;
use Modules\Taxes\Entities\Tax;

class GeneralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => Settings::get('name:' . app()->getLocale()),
            'description' => Settings::locale(app()->getLocale())->get('description'),
            'logo' => app_logo(),
            'latitude' => Settings::get('latitude'),
            'longitude' => Settings::get('longitude'),
            'android_version' => Settings::get('android_version'),
            'ios_version' => Settings::get('ios_version'),
            'delivery_fee' => Settings::get('delivery_fee'),
            'tax_percent' => (float) Tax::active()->sum('percentage'),
            'raduis' => (float) Settings::get('radius', 3000),
            "unreadNotificationsCount" => user() ? user()->unreadNotifications()->count() : 0,
        ];
    }
}
