<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCommentPostNotification extends Notification
{
    use Queueable;

    /** @var Array $data */
    public $data = [];
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Un nouveau commentaire a été ajouté sur l\'article "' . $this->data['post_title'] . '"')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line(
                        $this->data['username_comment']
                        . ' a ajouté un nouveau commentaire sur l\'article ' .
                        $this->data['post_title']
                    )
                    ->action('Voir l\'article', url('/posts/' . $this->data['post_id']));
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
            //
        ];
    }
}
