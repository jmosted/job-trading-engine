<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailOfferRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $offer;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->user=$content->user;
        $this->offer=$content->offer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->subject('Solicitud de aceptación de oferta de trabajo')
                    ->view('emails.offerequest');
    }

}