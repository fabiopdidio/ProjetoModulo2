<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmailToUser extends Mailable
{
    use Queueable, SerializesModels;

    /*Create a new message instance.*/
    public $name;
    public $limit;
    public $plan;

    public function __construct($name, $limit, $plan)
    {
        $this->name = $name;
        $this->limit = $limit ?? 0;;
        $this->plan = $plan;
    }

    /*Get the message envelope.*/
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem vindo ao TrainSys',
        );
    }

    /* Get the message content definition.*/
    public function content(): Content
    {
        return new Content(
            html: 'emails.welcomeUser',

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

