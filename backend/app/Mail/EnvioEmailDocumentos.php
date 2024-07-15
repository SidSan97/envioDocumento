<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnvioEmailDocumentos extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $email;
    public $assunto;
    public $msg;

    /**
     * Create a new message instance.
     */
    public function __construct($nome, $email, $assunto, $msg)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->assunto = $assunto;
        $this->msg = $msg;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->assunto,
            from: new Address($this->email, $this->nome),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.envioDocumento',
            with: [
                'message' => $this->msg,
            ]
        );
    }
}
