<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EticketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct($transaction, $pdf)
    {
        $this->transaction = $transaction;
        $this->pdf = $pdf;
    }  

    /**
     * Build the email structure.
     */
    public function build()
    {
        return $this->subject('E-Ticket - ' . $this->transaction->code)
            ->view('emails.eticket-text')
            ->with([
                'transaction' => $this->transaction,
            ])
            ->attachData($this->pdf, 'e-ticket-' . $this->transaction->code . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
