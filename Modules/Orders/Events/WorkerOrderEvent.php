<?php

namespace Modules\Orders\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Modules\Orders\Transformers\OrderBreifResource;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class WorkerOrderEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels ;

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
            new PrivateChannel('worker-channel.' . $this->order->vendor_id)
        ];
    }


    public function broadcastWith()
    {
        return [
            'message' => trans('orders::orderNotifications.pending.driver.subject', ['id' => $this->order->id]),
            'order' => new OrderBreifResource($this->order)
        ];
    }


    public function broadcastAs()
    {
        return 'worker-order-event';
    }
}
