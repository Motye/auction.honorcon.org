<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class Outbid extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $seat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $seat)
    {
        $this->user = $user;
        $this->seat = $seat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.outbid', ['seat' => $this->seat])->subject('You have been outbid!');
    }
}
