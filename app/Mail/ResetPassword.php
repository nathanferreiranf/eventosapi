<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $inscrito;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inscrito)
    {
        $this->inscrito = $inscrito;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.resetPassword')->with([
            'inscrito' => $this->inscrito,
        ]);
    }
}
