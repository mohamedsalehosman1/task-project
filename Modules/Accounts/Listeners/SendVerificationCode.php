<?php

namespace Modules\Accounts\Listeners;

use Illuminate\Support\Facades\Storage;
use Modules\Accounts\Events\VerificationCreated;


class SendVerificationCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param VerificationCreated $event
     * @return void
     */
    public function handle(VerificationCreated $event)
    {
        if (!$event->verification->parentable->hasVerifiedPhone()) {
            $event->verification->parentable->sendSmsVerificationNotification($event->verification->username, $event->verification->code);
        }

        /* @deprecated */
        Storage::disk('public')->append(
            'verification.txt',
            "The verification code for phone {$event->verification->username} is {$event->verification->code} generated at " . now()->toDateTimeString() . "\n"
        );
    }
}
