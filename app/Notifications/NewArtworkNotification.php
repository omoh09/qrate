<?php

namespace App\Notifications;

use App\Artworks;
use App\Http\Resources\MiniArtworkResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewArtworkNotification extends Notification
{
    use Queueable;

    public $artwork;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Artworks $artwork)
    {
        $this->artwork = $artwork;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return arrayp
     */
    public function via($notifiable)
    {
        return $notifiable->notification_on ? ['database','mail'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hi there')
                    ->subject('New Artwork')
                    ->line('new artwork uploaded by '.$this->artwork->user->name)
                    ->action('vew artwork', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'new artwork by '.$this->artwork->user->name,
            "type" => 'notification',
            'artwork' => MiniArtworkResource::make($this->artwork)
        ];
    }
}
