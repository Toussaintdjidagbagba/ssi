<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class Recu extends Mailable
{
    use Queueable, SerializesModels;
 
    public $data;
    public $subject;
    public $view;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $subject, $view)
    {
        //
        $this->data = $data;
        $this->subject = $subject;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        	    ->view($this->view, $this->data);
        //return $this->from("emmanueldjidagbagba@gmail.com") 
                    //->subject("Message via le SMTP Google")
                    //->view('emails.message-google'); 
    }
}
