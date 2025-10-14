<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\LaravelPdf\Facades\Pdf;

class EticketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $pdfPath;

    public function __construct($transaction, $pdfPath = null)
    {
        $this->transaction = $transaction;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('customer.tiket.etiketemail')
            ->subject('E-Ticket Anda - ' . $this->transaction->code)
            ->attach($this->pdfPath, [
                'as' => 'E-Ticket-' . $this->transaction->code . '.pdf',
                'mime' => 'application/pdf',
            ])
            ->with([
                'transaction' => $this->transaction,
            ]);
    }
}
