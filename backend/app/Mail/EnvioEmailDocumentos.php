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

    public $data;
   

    /**
     * Create a new message instance.
     */
    public function __construct($dados)
    {
        $this->data = $dados;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
            from: new Address($this->data['fromEmail'], $this->data['fromName']),
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
                'message' => $this->data['message'],
            ]
        );
    }
}
