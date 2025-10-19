<?php

// app/Observers/TransactionObserver.php
namespace App\Observers;

use App\Models\Transaction;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    protected $sheetsService;

    public function __construct(GoogleSheetsService $sheetsService)
    {
        $this->sheetsService = $sheetsService;
    }

    /**
     * Handle transaction updated event
     */
    public function updated(Transaction $transaction)
    {
        // Cek jika status berubah menjadi paid
        if ($transaction->isDirty('status') && $transaction->status === 'paid') {
            try {
                $result = $this->sheetsService->addPaidTransaction($transaction);

                Log::info('Transaction synced to Google Sheets', [
                    'transaction_id' => $transaction->id,
                    'spreadsheet_id' => $result['spreadsheet_id'],
                    'sheet_name' => $result['sheet_name'],
                ]);

                // Simpan metadata sync ke database
                $transaction->update([
                    'synced_to_sheets' => true,
                    'spreadsheet_id' => $result['spreadsheet_id'],
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to sync transaction to Google Sheets', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Handle transaction created event dengan status paid
     */
    public function created(Transaction $transaction)
    {
        if ($transaction->status === 'paid') {
            try {
                $result = $this->sheetsService->addPaidTransaction($transaction);

                Log::info('New paid transaction synced to Google Sheets', [
                    'transaction_id' => $transaction->id,
                    'spreadsheet_id' => $result['spreadsheet_id'],
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to sync new transaction to Google Sheets', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
