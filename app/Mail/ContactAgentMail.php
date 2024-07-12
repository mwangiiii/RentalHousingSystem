<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\House;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactAgentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $house;
    public $hunter;

    /**
     * Create a new message instance.
     *
     * @param House $house
     * @param User $hunter
     */
    public function __construct(House $house, User $hunter)
    {
        $this->house = $house;
        $this->hunter = $hunter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Agent Mail')
                    ->view('emails.contact-agent')
                    ->with([
                        'house' => $this->house,
                        'hunter' => $this->hunter,
                    ]);
    }
}
