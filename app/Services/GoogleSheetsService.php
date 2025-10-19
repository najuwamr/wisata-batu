<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsService
{
    protected $client;
    protected $sheetsService;
    protected $driveService;
    protected $folderId;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('Selecta Transaction Sync');
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->addScope([
            Drive::DRIVE,
            Drive::DRIVE_FILE,
            Drive::DRIVE_METADATA,
            Sheets::SPREADSHEETS,
        ]);

        $client->setAccessType('offline');

        $this->client = $client;
        $this->driveService = new Drive($client);
        $this->sheetsService = new Sheets($client);
        $this->folderId = config('services.google.drive_folder_id');
    }

    // ✅ Getter untuk SheetsService
    public function getSheetsService()
    {
        return $this->sheetsService;
    }

    // ✅ Getter untuk DriveService
    public function getDriveService()
    {
        return $this->driveService;
    }

    // ✅ Getter untuk Client
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Menambahkan transaksi berstatus paid ke spreadsheet
     */
    public function addPaidTransaction($transaction)
    {
        $paidDate = $transaction->status === 'paid'
            ? ($transaction->updated_at ?? now())
            : now();

        $year = $paidDate->format('Y');
        $month = $paidDate->format('F Y');

        $spreadsheetId = $this->getOrCreateYearlySpreadsheet($year);
        $this->getOrCreateMonthlySheet($spreadsheetId, $month);

        $transaction->load('transactionDetails.ticket');

        $rows = [];
        $detailCount = $transaction->transactionDetails->count();

        foreach ($transaction->transactionDetails as $index => $detail) {
            $displayTotal = ($index === $detailCount - 1)
                ? 'Rp' . number_format($transaction->total_price, 0, ',', '.')
                : '';

            $rows[] = [
                $transaction->code,
                $transaction->created_at->format('Y-m-d'),
                $transaction->tanggal_kedatangan->format('Y-m-d'),
                $detail->ticket->name ?? 'N/A',
                $detail->quantity ?? 1,
                'Rp' . number_format($detail->subtotal, 0, ',', '.'),
                ucfirst($transaction->status),
                $displayTotal,
            ];
        }

        $body = new ValueRange(['values' => $rows]);
        $params = ['valueInputOption' => 'RAW'];

        $this->sheetsService->spreadsheets_values->append(
            $spreadsheetId,
            $month . '!A:H',
            $body,
            $params
        );

        return [
            'spreadsheet_id' => $spreadsheetId,
            'sheet_name' => $month,
            'rows_added' => count($rows),
        ];
    }

    /**
     * Dapatkan atau buat spreadsheet tahunan
     */
    protected function getOrCreateYearlySpreadsheet($year)
    {
        $fileName = "Transactions {$year}";

        $existingFile = $this->findFileInFolder($fileName);
        if ($existingFile) {
            return $existingFile->getId();
        }

        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName,
            'mimeType' => 'application/vnd.google-apps.spreadsheet',
            'parents' => [$this->folderId],
        ]);

        $file = $this->driveService->files->create($fileMetadata, ['fields' => 'id']);
        $spreadsheetId = $file->id;

        $this->setupInitialSheet($spreadsheetId);

        return $spreadsheetId;
    }

    /**
     * Dapatkan atau buat sheet bulanan
     */
    protected function getOrCreateMonthlySheet($spreadsheetId, $monthName)
    {
        $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $monthName) {
                return true;
            }
        }

        $requests = [
            new Sheets\Request([
                'addSheet' => [
                    'properties' => ['title' => $monthName]
                ]
            ])
        ];

        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

        $this->addHeaderToSheet($spreadsheetId, $monthName);
        return true;
    }

    /**
     * Tambahkan header ke sheet
     */
    protected function addHeaderToSheet($spreadsheetId, $sheetName)
    {
        $headers = [[
            'Kode Transaksi',
            'Tanggal Pesan',
            'Tanggal Kedatangan',
            'Tiket',
            'Qty',
            'Subtotal',
            'Status',
            'Total',
        ]];

        $body = new ValueRange(['values' => $headers]);
        $params = ['valueInputOption' => 'RAW'];

        $this->sheetsService->spreadsheets_values->update(
            $spreadsheetId,
            $sheetName . '!A1:H1',
            $body,
            $params
        );

        $this->formatHeader($spreadsheetId, $sheetName);
    }

    /**
     * Format header (bold + warna abu)
     */
    protected function formatHeader($spreadsheetId, $sheetName)
    {
        $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
        $sheetId = collect($spreadsheet->getSheets())
            ->first(fn($s) => $s->getProperties()->getTitle() === $sheetName)
            ?->getProperties()->getSheetId();

        if (!$sheetId) return;

        $requests = [
            new Sheets\Request([
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 0,
                        'endRowIndex' => 1,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => ['bold' => true],
                            'backgroundColor' => ['red' => 0.9, 'green' => 0.9, 'blue' => 0.9],
                        ]
                    ],
                    'fields' => 'userEnteredFormat(textFormat,backgroundColor)',
                ]
            ])
        ];

        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }

    /**
     * Hapus sheet default
     */
    protected function setupInitialSheet($spreadsheetId)
    {
        $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
        $firstSheetId = $spreadsheet->getSheets()[0]->getProperties()->getSheetId();

        $requests = [
            new Sheets\Request([
                'deleteSheet' => ['sheetId' => $firstSheetId]
            ])
        ];

        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);

        $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }

    /**
     * Cari file berdasarkan nama di folder Drive target
     */
    protected function findFileInFolder($fileName)
    {
        $query = "name='{$fileName}' and trashed=false";
        if ($this->folderId) {
            $query .= " and '{$this->folderId}' in parents";
        }

        $response = $this->driveService->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name)',
        ]);

        $files = $response->getFiles();
        return count($files) > 0 ? $files[0] : null;
    }
}
