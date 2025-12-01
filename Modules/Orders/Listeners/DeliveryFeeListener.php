<?php

namespace Modules\Orders\Listeners;

use App\Enums\NotificationTypesEnum;
use App\Enums\TransactionTypeEnum;
use App\Services\NotificationsService;
use App\Services\PaymentGateways\MyfatoorahService;
use Modules\Orders\Events\CustomerNewOrderEvent;
use Modules\Orders\Events\DeliveryFeeEvent;
use Modules\Orders\Events\OrderRefundEvent;

class DeliveryFeeListener
{
    private $notificationService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationsService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param CustomerNewOrderEvent $event
     * @return void
     */
    public function handle(DeliveryFeeEvent $event)
    {
        $order = $event->order;
        $delivery = $order->return_delivery_id ? $order->returnDelivery : $order->pickupDelivery;

        $delivery->transactions()->create([
            "amount" => $amount = $order->delivery_fee / 2,
            "type" => TransactionTypeEnum::Deposit->value,
        ]);

        $delivery->balance += $amount;
        $delivery->save();

        $subject = ["orders::orderNotifications.pickedFromClient.delivery.subject", ['id' => $order->id]];
        $body = ["orders::orderNotifications.pickedFromClient.user.body", ["amount" => $amount]];
        $this->notificationService->handleNotification(NotificationTypesEnum::WalletTransaction->value, $delivery, $subject, $body, $order);
    }
}

