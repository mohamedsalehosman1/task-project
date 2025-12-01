<?php

namespace Modules\Vendors\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
class VendorRequestNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $vendor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $vendor)
    {
        $this->title = $title;
        $this->message = $message;
        $this->vendor = $vendor;
    }


    public function vendorImage()
    {
        return $this->vendor->getImage();
    }

    public function vendorName()
    {
        return $this->vendor->name;
    }

    public function vendorID()
    {
        return $this->vendor->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'id' => $this->vendorID(),
            'name' => $this->vendorName(),
            'image' => $this->vendorImage(),
            'model' => $this->vendor->getMorphClass(),
            'url' => route('dashboard.vendors.show', $this->vendorID()),
        ];
    }
}
