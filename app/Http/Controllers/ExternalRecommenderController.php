<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalRecommenderController extends Controller
{
    /**
     * Proxy to the external Python recommender service and return the two lists.
     */
    public function index($userId)
    {
        $pythonUrl = config('app.recommender_url', 'http://127.0.0.1:8001');
        $resp = Http::get(rtrim($pythonUrl, '/') . "/recommend/{$userId}");

        if ($resp->failed()) {
            return response()->json(['error' => 'Failed to fetch recommendations from external service'], 500);
        }

        $data = $resp->json();

        return response()->json([
            'content_based' => $data['content_based'] ?? [],
            'collaborative' => $data['collaborative'] ?? [],
        ]);
    }
}
