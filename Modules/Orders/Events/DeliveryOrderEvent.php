<?php

namespace Modules\Orders\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;
use Modules\Orders\Transformers\OrderBreifResource;

class DeliveryOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */

    public function broadcastOn()
    {
        return [
            new Channel('delivery-channel')
        ];
    }


    public function broadcastWith()
    {
        return [
            'message' => trans('orders::orderNotifications.pending.delivery.subject', ['id' => $this->order->id]),
            'order' => new OrderBreifResource($this->order)
        ];
    }


    public function broadcastAs()
    {
        return 'delivery-order-event';
    }
}
