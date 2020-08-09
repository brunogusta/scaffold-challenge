<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $link;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $name)
    {
      $this->link = $link;
      $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')->view('emails.resend-confirmation-email');
    }
}
