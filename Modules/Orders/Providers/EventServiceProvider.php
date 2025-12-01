<?php

namespace Modules\Orders\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Orders\Events\CustomerNewOrderEvent;
use Modules\Orders\Events\CustomerUpdateOrderEvent;
use Modules\Orders\Events\ReCalculateOrderEvent;
use Modules\Orders\Listeners\CustomerNewOrderListener;
use Modules\Orders\Listeners\CustomerUpdateOrderListener;
use Modules\Orders\Listeners\ReCalculateOrderListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CustomerNewOrderEvent::class => [
            CustomerNewOrderListener::class,
        ],

        CustomerUpdateOrderEvent::class => [
            CustomerUpdateOrderListener::class,
        ],

        ReCalculateOrderEvent::class => [
            ReCalculateOrderListener::class,
        ],
    ];
}
