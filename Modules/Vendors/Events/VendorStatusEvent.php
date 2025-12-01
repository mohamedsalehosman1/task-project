<?php

namespace Modules\Vendors\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Vendors\Entities\Vendor;

class VendorStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Vendor
     */
    public Vendor $Vendor;
    public $status;

    /**
     * Create a new event instance.
     *
     * @param Vendor $Vendor
     */
    public function __construct(Vendor $Vendor , $status = null)
    {
        $this->Vendor = $Vendor;
        $this->status = $status;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
