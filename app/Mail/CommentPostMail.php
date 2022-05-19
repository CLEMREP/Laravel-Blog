<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Array $data */
    public $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hello@laravel-blog.fr')
                    ->subject('Un nouveau commentaire a été ajouté sur "' . $this->data['post_title'] . '"')
                    ->markdown('emails.CommentPostMailMarkdown');
    }
}
