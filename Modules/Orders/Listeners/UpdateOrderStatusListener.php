<?php

namespace Modules\Orders\Listeners;

use App\Enums\OrderStatusEnum;
use App\Services\NotificationsService;
use Modules\Accounts\Entities\Admin;
use Modules\Accounts\Entities\User;
use Modules\Deliveries\Entities\Delivery;
use Modules\Orders\Events\DeliveryFeeEvent;
use Modules\Orders\Events\DeliveryOrderEvent;
use Modules\Orders\Events\OrderRefundEvent;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Events\UserOrderEvent;
use Modules\Orders\Events\WorkerOrderEvent;
use Modules\Workers\Entities\Worker;

class UpdateOrderStatusListener
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
     * @param UpdateOrderStatusEvent $event
     * @return void
     */
    public function handle(UpdateOrderStatusEvent $event)
    {

        $order = $event->order;
        $status = $order->status;

        // // fire the event delivery order
        // DeliveryOrderEvent::dispatch($order);

        // // fire the event worker order
        // WorkerOrderEvent::dispatch($order);

        // fire the event user order
        UserOrderEvent::dispatch($order);


        if ($status == OrderStatusEnum::inproccess->value) {

            // notify the user that order is accepted
            $subject = ["orders::orderNotifications.accepted.user.subject"];
            $body = ["orders::orderNotifications.accepted.user.body", ['id' => $order->id]];
            $this->service->handleNotification(OrderStatusEnum::inproccess->value, $order->user, $subject, $body, $order);
        } elseif ($status == OrderStatusEnum::shipped->value) {

            // notify the user that order is deliveredToLaundry
            $subject = ["orders::orderNotifications.deliveredToLaundry.user.subject", ['id' => $order->id]];
            $body = ["orders::orderNotifications.deliveredToLaundry.user.body", ['id' => $order->id]];
            $this->service->handleNotification(OrderStatusEnum::shipped->value, $order->user, $subject, $body, $order);
        } elseif ($status == OrderStatusEnum::deliverd->value) {

            // notify the user that order is delivered
            $subject = ["orders::orderNotifications.deliveredByClient.user.subject", ['id' => $order->id]];
            $body = ["orders::orderNotifications.deliveredByClient.user.body", ['id' => $order->id]];
            $this->service->handleNotification(OrderStatusEnum::deliverd->value, $order->user, $subject, $body, $order);
        } elseif ($status == OrderStatusEnum::cancelled->value) {

            // make the order total refunded to user
            event(new OrderRefundEvent($order));

            $userClass = get_class(auth()->user());

            // notify the user that order is cancelled
            $types = [
                User::class => 'user',
                Admin::class => 'admin',
            ];

            $subject = ["orders::orderNotifications.cancelled.subject"];
            $type = trans("orders::orderNotifications.user-types.{$types[$userClass]}");

            if (is_null($order->reason)) {
                $body = ["orders::orderNotifications.cancelled.body", ['id' => $order->id, 'type' => $type]];
            } else {
                $reason = \Lang::has("orders::orderNotifications.cancelled.reasons.{$order->reason}") ?
                    trans("orders::orderNotifications.cancelled.reasons.{$order->reason}", [], $order->user->preferred_locale) :
                    $order->reason;

                $body = ["orders::orderNotifications.cancelled.body_reason", ['id' => $order->id, 'reason' => $reason, 'type' => $type]];
            }

            unset($types[$userClass]);

            foreach ($types as $type) {
                if ($type == 'worker') {
                    $workers = $order->washer->workers()->isActive()->get();
                    foreach ($workers as $worker) {
                        $this->service->handleNotification(OrderStatusEnum::cancelled->value, $worker, $subject, $body, $order);
                    }
                } elseif ($type == 'delivery') {
                    $delivery = $order->pickup_delivery_id ? $order->pickupDelivery : $order->returnDelivery;

                    if ($delivery) {
                        $this->service->handleNotification(OrderStatusEnum::cancelled->value, $delivery, $subject, $body, $order);
                    }
                } else {
                    $this->service->handleNotification(OrderStatusEnum::cancelled->value, $order->$type, $subject, $body, $order);
                }
            }
        }
    }
}
