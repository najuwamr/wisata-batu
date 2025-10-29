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

            if (config('services.google.api_key')) {
                $client->setDeveloperKey(config('services.google.api_key'));
            }

            $tokenPath = storage_path('app/google/token.json');
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);

                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                    } else {
                        unlink($tokenPath);
                        throw new \Exception("Token invalid. Please authorize via: " . url('/google/auth'));
                    }
                }
            }

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

    public function getSheetsService()
    {
        return $this->sheetsService;
    }

    public function getDriveService()
    {
        return $this->driveService;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

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

    public function addPaidTransaction($transaction)
    {
        if (!$this->isAuthorized()) {
            throw new \Exception("Not authorized. Please visit: " . url('/google/auth'));
        }

        try {
            $transaction->load(['transactionDetail.ticket', 'transactionDetail.tiket_promo.promo', 'customer']);

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

            $rows = [];
            $details = $transaction->transactionDetail;
            $detailCount = $details->count();

            if ($detailCount === 0) {
                Log::warning("Transaction has no details", ['code' => $transaction->code]);
                return [
                    'spreadsheet_id' => $spreadsheetId,
                    'sheet_name' => $month,
                    'rows_added' => 0,
                ];
            }

            $customer = $transaction->customer;

            foreach ($details as $index => $detail) {
                $ticket = $detail->ticket;
                $promo = $detail->promo;

                $rows[] = [
                    $transaction->code ?? 'N/A',
                    $transaction->created_at ? $transaction->created_at->format('Y-m-d') : 'N/A',
                    $transaction->tanggal_kedatangan ? $transaction->tanggal_kedatangan->format('Y-m-d') : 'N/A',
                    $ticket ? $ticket->name : 'N/A',
                    $detail->quantity ?? 1,
                    $ticket ? ('Rp' . number_format($ticket->price, 0, ',', '.')) : 'Rp0',
                    $promo ? $promo->name : '-',
                    $promo && isset($promo->discount_percent) ? ($promo->discount_percent . '%') : '-',
                    'Rp' . number_format($detail->subtotal ?? 0, 0, ',', '.'),
                    ucfirst($transaction->status ?? 'unknown'),
                    $index === ($detailCount - 1) ? ('Rp' . number_format($transaction->total_price ?? 0, 0, ',', '.')) : '',
                    $customer ? $customer->name : '-',
                    $customer ? $customer->email : '-',
                    $customer ? $customer->telephone : '-',
                ];
            }

            $body = new ValueRange(['values' => $rows]);
            $params = ['valueInputOption' => 'USER_ENTERED'];

            $range = $month . '!A:N';

            $result = $this->sheetsService->spreadsheets_values->append(
                $spreadsheetId,
                $range,
                $body,
                $params
            );

            Log::info("Transaction added successfully", [
                'spreadsheet_id' => $spreadsheetId,
                'sheet_name' => $month,
                'rows_added' => count($rows),
                'updated_range' => $result->getUpdates()->getUpdatedRange()
            ]);

            return [
                'spreadsheet_id' => $spreadsheetId,
                'sheet_name' => $month,
                'rows_added' => count($rows),
                'updated_range' => $result->getUpdates()->getUpdatedRange()
            ];
        } catch (\Exception $e) {
            Log::error('Failed to add paid transaction: ' . $e->getMessage(), [
                'transaction_code' => $transaction->code ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function getOrCreateYearlySpreadsheet($year)
    {
        try {
            $fileName = "Transaksi {$year}";
            $existingFile = $this->findFileInFolder($fileName);

            if ($existingFile) {
                Log::info("Found existing spreadsheet", ['id' => $existingFile->getId()]);
                return $existingFile->getId();
            }

            Log::info("Creating new spreadsheet", ['name' => $fileName]);

            $fileMetadata = new Drive\DriveFile([
                'name' => $fileName,
                'mimeType' => 'application/vnd.google-apps.spreadsheet',
            ]);

            if ($this->folderId) {
                $fileMetadata->setParents([$this->folderId]);
            }

            $file = $this->driveService->files->create($fileMetadata, ['fields' => 'id']);
            $spreadsheetId = $file->id;

            Log::info("Spreadsheet created", ['id' => $spreadsheetId]);

            $this->setupInitialSheet($spreadsheetId);

            return $spreadsheetId;
        } catch (\Exception $e) {
            Log::error('Failed to get or create yearly spreadsheet: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getOrCreateMonthlySheet($spreadsheetId, $monthName)
    {
        try {
            $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();

            foreach ($sheets as $sheet) {
                if ($sheet->getProperties()->getTitle() === $monthName) {
                    Log::info("Sheet already exists", ['sheet' => $monthName]);
                    return true;
                }
            }

            Log::info("Creating new sheet", ['sheet' => $monthName]);

            $requests = [
                new Sheets\Request([
                    'addSheet' => [
                        'properties' => [
                            'title' => $monthName,
                            'gridProperties' => [
                                'frozenRowCount' => 1,
                            ]
                        ]
                    ]
                ])
            ];

            $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);

            $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            $this->addHeaderToSheet($spreadsheetId, $monthName);

            Log::info("Sheet created successfully", ['sheet' => $monthName]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to get or create monthly sheet: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function addHeaderToSheet($spreadsheetId, $sheetName)
    {
        try {
            $headers = [[
                'Kode Transaksi',
                'Tanggal Pesan',
                'Tanggal Kedatangan',
                'Tiket',
                'Qty',
                'Harga',
                'Nama Promo',
                'Diskon',
                'Subtotal',
                'Status',
                'Total',
                'Nama',
                'Email',
                'No. WA',
            ]];

            $body = new ValueRange(['values' => $headers]);
            $params = ['valueInputOption' => 'RAW'];

            $this->sheetsService->spreadsheets_values->update(
                $spreadsheetId,
                $sheetName . '!A1:N1',
                $body,
                $params
            );

            Log::info("Header added to sheet", ['sheet' => $sheetName]);

            $this->formatHeader($spreadsheetId, $sheetName);
        } catch (\Exception $e) {
            Log::error('Failed to add header: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function formatHeader($spreadsheetId, $sheetName)
    {
        try {
            $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
            $sheetId = null;

            foreach ($spreadsheet->getSheets() as $sheet) {
                if ($sheet->getProperties()->getTitle() === $sheetName) {
                    $sheetId = $sheet->getProperties()->getSheetId();
                    break;
                }
            }

            if ($sheetId === null) {
                Log::warning("Sheet not found for formatting", ['sheet' => $sheetName]);
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
                                'backgroundColor' => [
                                    'red' => 0.2,
                                    'green' => 0.4,
                                    'blue' => 0.6,
                                ],
                                'textFormat' => [
                                    'bold' => true,
                                    'fontSize' => 11,
                                    'foregroundColor' => [
                                        'red' => 1.0,
                                        'green' => 1.0,
                                        'blue' => 1.0,
                                    ],
                                    'fontFamily' => 'Arial',
                                ],
                                'horizontalAlignment' => 'CENTER',
                                'verticalAlignment' => 'MIDDLE',
                            ],
                        ],
                        'fields' => 'userEnteredFormat(backgroundColor,textFormat,horizontalAlignment,verticalAlignment)',
                    ],
                ]),

                new Sheets\Request([
                    'updateDimensionProperties' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'dimension' => 'ROWS',
                            'startIndex' => 0,
                            'endIndex' => 1,
                        ],
                        'properties' => ['pixelSize' => 35],
                        'fields' => 'pixelSize',
                    ],
                ]),

                new Sheets\Request([
                    'autoResizeDimensions' => [
                        'dimensions' => [
                            'sheetId' => $sheetId,
                            'dimension' => 'COLUMNS',
                            'startIndex' => 0,
                            'endIndex' => 14,
                        ],
                    ],
                ]),

                new Sheets\Request([
                    'updateBorders' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => 0,
                            'endRowIndex' => 1,
                        ],
                        'top' => [
                            'style' => 'SOLID',
                            'width' => 1,
                            'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                        ],
                        'bottom' => [
                            'style' => 'SOLID_MEDIUM',
                            'width' => 2,
                            'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                        ],
                        'left' => [
                            'style' => 'SOLID',
                            'width' => 1,
                            'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                        ],
                        'right' => [
                            'style' => 'SOLID',
                            'width' => 1,
                            'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                        ],
                        'innerVertical' => [
                            'style' => 'SOLID',
                            'width' => 1,
                            'color' => ['red' => 0, 'green' => 0, 'blue' => 0],
                        ],
                    ],
                ]),
            ];

            $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest(['requests' => $requests]);
            $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            Log::info("Header formatted successfully", ['sheet' => $sheetName]);
        } catch (\Exception $e) {
            Log::error('Failed to format header: ' . $e->getMessage());
        }
    }

    protected function setupInitialSheet($spreadsheetId)
    {
        try {
            $spreadsheet = $this->sheetsService->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();

            if (empty($sheets)) {
                Log::info("No sheets to delete");
                return;
            }

            $firstSheetId = $sheets[0]->getProperties()->getSheetId();

            $requests = [
                new Sheets\Request([
                    'deleteSheet' => ['sheetId' => $firstSheetId]
                ])
            ];

            $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest(['requests' => $requests]);
            $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            Log::info("Default sheet deleted");
        } catch (\Exception $e) {
            Log::error('Failed to setup initial sheet: ' . $e->getMessage());
        }
    }

    protected function findFileInFolder($fileName)
    {
        try {
            $query = "name='{$fileName}' and mimeType='application/vnd.google-apps.spreadsheet' and trashed=false";

            if ($this->folderId) {
                $query .= " and '{$this->folderId}' in parents";
            }

            $response = $this->driveService->files->listFiles([
                'q' => $query,
                'fields' => 'files(id, name)',
                'pageSize' => 10,
            ]);

            $files = $response->getFiles();

            if (count($files) > 0) {
                Log::info("File found", ['name' => $fileName, 'id' => $files[0]->getId()]);
                return $files[0];
            }

            Log::info("File not found", ['name' => $fileName]);
            return null;
        } catch (\Exception $e) {
            Log::error('Failed to find file in folder: ' . $e->getMessage());
            throw $e;
        }
    }
}
