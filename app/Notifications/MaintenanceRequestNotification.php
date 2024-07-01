<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class MaintenanceRequestNotification extends Notification
{
    use Queueable;

    protected $description;
    protected $fromNumber;

    /**
     * Create a new notification instance.
     */
    public function __construct($description, $fromNumber)
    {
        $this->description = $description;
        $this->fromNumber = $fromNumber;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['vonage'];
    }

    /**
     * Get the text representation of the notification.
     */
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
                    ->content("New maintenance request: {$this->description}")
                    ->from($this->fromNumber);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
