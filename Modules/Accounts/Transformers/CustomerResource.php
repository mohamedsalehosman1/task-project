<?php

namespace Modules\Accounts\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laracasts\Presenter\Exceptions\PresenterException;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Orders\Entities\Order;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     * @throws PresenterException
     */
public function toArray($request)
{
    $unreadNotificationsCount = $this->unreadNotifications()->count();
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
        'email' => $this->email,
        'phone' => $this->phone,
        'region_id' => $this->region_id,
        'address_id' => $this->address_id,
        'region_name' => $this->region?->name,
        'address_name' => $this->address?->name,
        'preferred_locale' => $this->preferred_locale,
        'un_read_notifications_count' => $unreadNotificationsCount,
        'avatar' => $this->getAvatar(),
        'device_token' => (string) $this->device_token,
        'order_notification' => (bool) $this->order_notification,
        'reset_token' => (string) $this->reset_token,
        'phone_verified' => $this->hasVerifiedPhone(),
        'code' => $userCode,
    ];

    // ✅ عدد العناصر في الكارت
    $cartItemsCount = 0;
    if ($this->cart) {
        $cartItemsCount = $this->cart->items()->count();
    }
    $data['cart_items_count'] = $cartItemsCount;

    return $data;
}

}
