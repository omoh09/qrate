<?php

namespace App\Notifications;

use App\Http\Resources\MiniArtworkResource;
use App\Likes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArtworkLikedNotification extends Notification
{
    use Queueable;

    /**
     * @var Likes
     */
    private $model;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Likes $like)
    {
        $this->model = $like;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'message' => $this->model->user->name.', liked your artwork',
            'type' => 'like',
            'artworks' => MiniArtworkResource::make($this->model->owner)
        ];
    }
}
