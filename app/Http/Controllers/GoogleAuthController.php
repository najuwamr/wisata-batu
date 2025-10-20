<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetsService;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirect()
    {
        $service = new GoogleSheetsService();
        $authUrl = $service->getAuthUrl();

        return redirect($authUrl);
    }

    /**
     * Handle OAuth callback
     */
    public function callback(Request $request)
    {
        try {
            $code = $request->get('code');

            if (!$code) {
                return response()->json([
                    'success' => false,
                    'message' => 'No authorization code received'
                ], 400);
            }

            $service = new GoogleSheetsService();
            $token = $service->authorize($code);

            return response()->json([
                'success' => true,
                'message' => 'Authorization successful! Token saved.',
                'token_path' => storage_path('app/google/token.json')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Authorization failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
