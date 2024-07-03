<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant;
    public $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Tenant $tenant, Payment $payment)
    {
        $this->tenant = $tenant;
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rent Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rent-reminder',
            with: [
                'tenantName' => $this->tenant->user->name,
                'propertyAddress' => $this->tenant->property->address,
                'roomNumber' => $this->tenant->room->room_number,
                'rentAmount' => $this->payment->amount,
                'dueDate' => $this->payment->due_date->format('M d, Y'),
            ]
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
