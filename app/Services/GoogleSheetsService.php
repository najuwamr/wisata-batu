<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    protected $client;
    protected $sheetsService;
    protected $driveService;
    protected $folderId;

    public function __construct()
    {
        try {
            $client = new Client();
            $client->setApplicationName('Selecta Transaction Sync');

            $credPath = storage_path('app/google/credentials.json');
            if (!file_exists($credPath)) {
                throw new \Exception("Credentials file not found at: {$credPath}");
            }

            $client->setAuthConfig($credPath);
            $client->addScope([
                Drive::DRIVE,
                Drive::DRIVE_FILE,
                Sheets::SPREADSHEETS,
            ]);

            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            // Set API key jika ada (opsional tapi bisa membantu)
            if (config('services.google.api_key')) {
                $client->setDeveloperKey(config('services.google.api_key'));
            }

            // Load token dari storage
            $tokenPath = storage_path('app/google/token.json');
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);

                // Refresh token jika expired
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                    } else {
                        // Token tidak valid, hapus dan minta authorize ulang
                        unlink($tokenPath);
                        throw new \Exception("Token invalid. Please authorize via: " . url('/google/auth'));
                    }
                }
            }
            // Jika token belum ada, tidak throw error di sini
            // Biar bisa dipanggil untuk generate auth URL

            $this->client = $client;
            $this->driveService = new Drive($client);
            $this->sheetsService = new Sheets($client);
            $this->folderId = config('services.google.drive_folder_id');

            Log::info('GoogleSheetsService initialized successfully');
        } catch (\Exception $e) {
            Log::error('GoogleSheetsService initialization failed: ' . $e->getMessage());
            throw $e;
        }
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
     * Generate authorization URL untuk OAuth
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Authorize dengan code dari OAuth callback
     */
    public function authorize($authCode)
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);

        if (array_key_exists('error', $accessToken)) {
            throw new \Exception('Error fetching access token: ' . join(', ', $accessToken));
        }

        $tokenPath = storage_path('app/google/token.json');
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($accessToken));

        return $accessToken;
    }

    /**
     * Cek apakah sudah terauthorize
     */
    public function isAuthorized()
    {
        $tokenPath = storage_path('app/google/token.json');
        if (!file_exists($tokenPath)) {
            return false;
        }

        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $this->client->setAccessToken($accessToken);

        return !$this->client->isAccessTokenExpired();
    }

    /**
     * Menambahkan transaksi berstatus paid ke spreadsheet
     */
    public function addPaidTransaction($transaction)
    {
        // Cek authorization dulu
        if (!$this->isAuthorized()) {
            throw new \Exception("Not authorized. Please visit: " . url('/google/auth'));
        }

        try {
            // Pastikan transaction punya updated_at
            $paidDate = $transaction->status === 'paid'
                ? ($transaction->updated_at ?? now())
                : now();

            $year = $paidDate->format('Y');
            $month = $paidDate->format('F Y');

            Log::info("Adding transaction to spreadsheet", [
                'transaction_code' => $transaction->code,
                'year' => $year,
                'month' => $month
            ]);

            $spreadsheetId = $this->getOrCreateYearlySpreadsheet($year);
            $this->getOrCreateMonthlySheet($spreadsheetId, $month);

            // Eager load relasi
            $transaction->load('transactionDetail.ticket');

            $rows = [];
            $detailCount = $transaction->transactionDetail->count();

            if ($detailCount === 0) {
                Log::warning("Transaction has no details", ['code' => $transaction->code]);
                return [
                    'spreadsheet_id' => $spreadsheetId,
                    'sheet_name' => $month,
                    'rows_added' => 0,
                ];
            }

            foreach ($transaction->transactionDetail as $index => $detail) {
                // Total hanya ditampilkan di baris terakhir
                $displayTotal = ($index === $detailCount - 1)
                    ? 'Rp' . number_format($transaction->total_price, 0, ',', '.')
                    : '';

                $rows[] = [
                    $transaction->code ?? 'N/A',
                    $transaction->created_at ? $transaction->created_at->format('Y-m-d') : 'N/A',
                    $transaction->tanggal_kedatangan ? $transaction->tanggal_kedatangan->format('Y-m-d') : 'N/A',
                    $detail->ticket->name ?? 'N/A',
                    $detail->quantity ?? 1,
                    'Rp' . number_format($detail->subtotal ?? 0, 0, ',', '.'),
                    ucfirst($transaction->status ?? 'unknown'),
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

            Log::info("Transaction added successfully", [
                'spreadsheet_id' => $spreadsheetId,
                'rows_added' => count($rows)
            ]);

            return [
                'spreadsheet_id' => $spreadsheetId,
                'sheet_name' => $month,
                'rows_added' => count($rows),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to add paid transaction: ' . $e->getMessage(), [
                'transaction_code' => $transaction->code ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Dapatkan atau buat spreadsheet tahunan
     */
    protected function getOrCreateYearlySpreadsheet($year)
    {
        try {
            $fileName = "Transactions {$year}";

            $existingFile = $this->findFileInFolder($fileName);
            if ($existingFile) {
                Log::info("Found existing spreadsheet", ['file_id' => $existingFile->getId()]);
                return $existingFile->getId();
            }

            Log::info("Creating new spreadsheet", ['file_name' => $fileName]);

            $fileMetadata = new Drive\DriveFile([
                'name' => $fileName,
                'mimeType' => 'application/vnd.google-apps.spreadsheet',
                'parents' => [$this->folderId],
            ]);

            $file = $this->driveService->files->create($fileMetadata, ['fields' => 'id']);
            $spreadsheetId = $file->id;

            $this->setupInitialSheet($spreadsheetId);

            Log::info("Spreadsheet created", ['spreadsheet_id' => $spreadsheetId]);

            return $spreadsheetId;
        } catch (\Exception $e) {
            Log::error('Failed to get or create yearly spreadsheet: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Dapatkan atau buat sheet bulanan
     */
    protected function getOrCreateMonthlySheet($spreadsheetId, $monthName)
    {
        try {
            $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();

            foreach ($sheets as $sheet) {
                if ($sheet->getProperties()->getTitle() === $monthName) {
                    Log::info("Sheet already exists", ['sheet_name' => $monthName]);
                    return true;
                }
            }

            Log::info("Creating new sheet", ['sheet_name' => $monthName]);

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
        } catch (\Exception $e) {
            Log::error('Failed to get or create monthly sheet: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tambahkan header ke sheet
     */
    protected function addHeaderToSheet($spreadsheetId, $sheetName)
    {
        try {
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

            Log::info("Header added to sheet", ['sheet_name' => $sheetName]);
        } catch (\Exception $e) {
            Log::error('Failed to add header: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format header (bold + warna abu)
     */
    protected function formatHeader($spreadsheetId, $sheetName)
    {
        try {
            $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
            $sheetId = collect($spreadsheet->getSheets())
                ->first(fn($s) => $s->getProperties()->getTitle() === $sheetName)
                ?->getProperties()->getSheetId();

            if (!$sheetId) {
                Log::warning("Sheet ID not found for formatting", ['sheet_name' => $sheetName]);
                return;
            }

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
        } catch (\Exception $e) {
            Log::error('Failed to format header: ' . $e->getMessage());
            // Jangan throw error, header tetap bisa digunakan meskipun tidak terformat
        }
    }

    /**
     * Hapus sheet default
     */
    protected function setupInitialSheet($spreadsheetId)
    {
        try {
            $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();

            if (empty($sheets)) {
                Log::warning("No sheets found to delete");
                return;
            }

            $firstSheetId = $sheets[0]->getProperties()->getSheetId();

            $requests = [
                new Sheets\Request([
                    'deleteSheet' => ['sheetId' => $firstSheetId]
                ])
            ];

            $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);

            $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            Log::info("Initial sheet setup completed");
        } catch (\Exception $e) {
            Log::error('Failed to setup initial sheet: ' . $e->getMessage());
            // Jangan throw error, spreadsheet masih bisa digunakan dengan sheet default
        }
    }

    /**
     * Cari file berdasarkan nama di folder Drive target
     */
    protected function findFileInFolder($fileName)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Failed to find file in folder: ' . $e->getMessage());
            throw $e;
        }
    }
}
