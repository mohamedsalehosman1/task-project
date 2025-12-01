<?php


namespace Modules\Orders\Entities\Observers;


use Modules\Orders\Entities\Order;
use Modules\Orders\Events\NewOrderEvent;

class NewOrderObserver
{
    public function created(Order $order)
    {
        event(new NewOrderEvent($order->user->name, $order));
    }

}
