<?php

namespace App\Notifications;

use App\Models\Hit;
use App\Models\Scan;
use App\Models\Trigger;
use App\Models\TriggerType;
use App\Models\Watcher;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HitNotify extends Notification
{
    use Queueable;

    /**
     * @var Hit
     */
    private $hit;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Hit $hit)
    {
        $this->hit = $hit;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $scan = $this->hit->{Hit::REL_SCAN};
        $watcher = $this->hit->{Hit::REL_SCAN}->{Scan::REL_WATCHER};
        $trigger = $this->hit->{Hit::REL_TRIGGER};
        $triggerType = $this->hit->{Hit::REL_TRIGGER_TYPE};

        return (new MailMessage)
            ->subject(sprintf('Watcher %s has a hit!', $watcher->{Watcher::COL_NAME}))
            ->line(sprintf('Watcher %s has a hit!', $watcher->{Watcher::COL_NAME}))
            ->line(sprintf(
                'You have placed a trigger on the value __%s__ of type __%s__. That value is now __%s__!',
                $trigger->{Trigger::COL_VALUE_TO_MATCH},
                $triggerType->{TriggerType::COL_NAME},
                $scan->{Scan::COL_VALUE} !== '' ? $scan->{Scan::COL_VALUE} : 'empty'
            ))
            ->action('Take me there!', $watcher->{Watcher::COL_URL})
            ->salutation('Cheers, Heimdall');
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
            //
        ];
    }
}
