<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class ValidacionCita extends Mailable
{
    public $cita;
    public $motivo;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cita, $motivo)
    {
        $this->cita = $cita;
        $this->motivo = $motivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('adminTemplate.mails.validacioncita')->subject("Informe reserva de cita odontologica");
    }
}


