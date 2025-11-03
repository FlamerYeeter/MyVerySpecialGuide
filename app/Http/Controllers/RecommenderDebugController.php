<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecommenderDebugController extends Controller
{
    /**
     * Call the external FastAPI recommender and render a debug page.
     *
     * @param Request $request
     * @param int $userId
     */
    public function debug(Request $request, $userId = null)
    {
        $base = env('PY_RECOMMENDER_URL', 'http://127.0.0.1:8001');

        // Accept either a route param or a query param (form submits use ?userId=)
        if (empty($userId)) {
            $userId = $request->query('userId', null);
        }

        // If no userId provided, show a light-weight instructions page and example endpoint
        if ($userId === null || $userId === '') {
            return view('recommender_debug', [
                'userId' => null,
                'error' => null,
                'response' => null,
                'raw' => null,
                'endpoint' => rtrim($base, '/') . '/recommend/{userId}',
            ]);
        }

        $url = rtrim($base, '/') . '/recommend/' . urlencode($userId);

        try {
            $resp = Http::timeout(10)->get($url);
        } catch (\Throwable $e) {
            $error = 'Request failed: ' . $e->getMessage();
            return view('recommender_debug', [
                'userId' => $userId,
                'error' => $error,
                'response' => null,
                'raw' => null,
                'endpoint' => $url,
            ]);
        }

        $raw = $resp->body();
        $json = null;
        if ($resp->successful()) {
            try {
                $json = $resp->json();
            } catch (\Throwable $e) {
                // parse failed
                $json = null;
            }
        }

        return view('recommender_debug', [
            'userId' => $userId,
            'error' => $resp->successful() ? null : ('Upstream returned status ' . $resp->status()),
            'response' => $json,
            'raw' => $raw,
            'endpoint' => $url,
        ]);
    }
}
