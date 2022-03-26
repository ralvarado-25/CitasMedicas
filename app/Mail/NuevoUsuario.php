<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class NuevoUsuario extends Mailable
{
    public $user;
    public $pass;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user, $pass)
    {
        $this->user=$user;
        $this->pass=$pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('adminTemplate.mails.nuevousuario')->subject("Bienvenido a Dentalife");
    }
}


