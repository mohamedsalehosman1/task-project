<?php

namespace Modules\Orders\Notifications;

use App\Channels\CustomerOneSignalChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Orders\Entities\Order;
use NotificationChannels\OneSignal\OneSignalMessage;

class CustomerNewOrderNotification extends Notification
{
    use Queueable;

    private Order $order;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getSendType(): string
    {
        return 'text';
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->order['id'];
    }

    /**
     * @return string
     */
    public function getModelType(): string
    {
        return 'order';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [CustomerOneSignalChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable): OneSignalMessage
    {
        return OneSignalMessage::create()
            ->setSubject(trans('orders::orderNotifications.pending.subject'))
            ->setBody(trans('orders::orderNotifications.pending.body'))
            ->setData('model_type', $this->getModelType())
            ->setData('model_id', $this->getModelId());
    }
}
