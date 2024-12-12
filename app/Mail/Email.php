<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;
    public $mail_params;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_params)
    {
        $this->mail_params=$mail_params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        
        $mail_build= $this->subject('JobTrading')
                    ->view('mails.messagesend');
        
        if( array_key_exists("attaches", $this->mail_params) && is_array($this->mail_params["attaches"])){
            $attach = storage_path("tmp_email/".$this->mail_params["attaches"][0]);
            
            if( is_file($attach) ){
                $mail_build->attach($attach);
            }else{
                throw new \Exception("Archivo $attach no Existe");
            }
        }  
        return $mail_build;
    }

}