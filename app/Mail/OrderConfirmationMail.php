<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $orderDetails;
    public $totalPrice;

    public function __construct($orderDetails, $totalPrice)
    {
        $this->orderDetails = $orderDetails;
        $this->totalPrice = $totalPrice;
    }

    public function build()
    {
        return $this->from('imsanjay.tech@gmail.com')
                    ->subject('Order Confirmation')
                    ->view('emails.index') // Corrected to match the file name
                    ->with([
                        'orderDetails' => $this->orderDetails,
                        'totalPrice' => $this->totalPrice,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.index',
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
