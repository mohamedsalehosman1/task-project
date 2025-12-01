<?php

namespace Modules\Orders\Listeners;

use App\Enums\NotificationTypesEnum;
use App\Enums\OrderStatusEnum;
use App\Services\NotificationsService;
use Modules\Orders\Events\CustomerNewOrderEvent;
use Modules\Orders\Events\WorkerOrderEvent;

class CustomerNewOrderListener
{
    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationsService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param CustomerNewOrderEvent $event
     * @return void
     */
  public function handle(CustomerNewOrderEvent $event)
{
    $order = $event->order;

    $subject = ["orders::orderNotifications.pending.user.subject"];
    $body = ["orders::orderNotifications.pending.user.body"];
    $this->service->handleNotification(
        NotificationTypesEnum::General->value,
        $order->user,
        $subject,
        $body,
        $order
    );

    // إرسال إشعار لكل vendor
    $vendor_subject = ["orders::orderNotifications.pending.vendor.subject", ['id' => $order->id]];
    $vendor_body = ["orders::orderNotifications.pending.vendor.body", ['id' => $order->id]];

    foreach ($order->orderVendors as $orderVendor) {
        $this->service->handleNotification(
            NotificationTypesEnum::General->value,
            $orderVendor->vendor,
            $vendor_subject,
            $vendor_body,
            $order
        );
    }
}

}

