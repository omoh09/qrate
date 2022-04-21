<?php

namespace App\Notifications;

use App\Http\Resources\CommentResource;
use App\Post;
use App\Artworks;
use App\Comments;
use Illuminate\Bus\Queueable;
use App\Http\Resources\MiniPostResource;
use Illuminate\Notifications\Notification;
use App\Http\Resources\MiniArtworkResource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentNotification extends Notification
{
    use Queueable;

    public $model;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comments $model)
    {
        $this->model = $model;
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
        if($this->model->owner instanceof Artworks){
            return [
                'message' => $this->model->user->name.', commented on your artwork',
                'type' => 'notification',
                'artworks' => CommentResource::make($this->model)
            ];
        }
        if($this->model->owner instanceof Post){
            return [
                'message' => $this->model->user->name.', commented on your post',
                'type' => 'notification',
                'post' => CommentResource::make($this->model)
            ];
        }
        return [
            'message' => 'new comment by '. $this->model->user->name,
            'type' => 'notification',
            'comment' => CommentResource::make($this)
        ];
    }
}
