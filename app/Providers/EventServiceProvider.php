<?php

namespace App\Providers;

use App\Events\OtpRegister;
use App\Events\OtpSent;
use App\Listeners\OtpSentListener;
use App\Listeners\SendSmsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Accounts\Events\ResetPasswordCreated;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Listeners\SendResetPasswordCode;
use Modules\Accounts\Listeners\SendVerificationCode;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Listeners\UpdateOrderStatusListener;
use Modules\Washers\Events\WasherStatusEvent;
use Modules\Washers\Listeners\WasherStatusListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        VerificationCreated::class => [
            SendVerificationCode::class,
        ],

        ResetPasswordCreated::class => [
            SendResetPasswordCode::class,
        ],
        OtpSent::class => [
            OtpSentListener::class
        ],

        OtpRegister::class => [
            SendSmsListener::class
        ],

        WasherStatusEvent::class => [
            WasherStatusListener::class
        ],

        UpdateOrderStatusEvent::class => [
            UpdateOrderStatusListener::class
        ],


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
