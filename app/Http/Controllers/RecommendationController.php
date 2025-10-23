<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use App\Jobs\GenerateRecommendations;

class RecommendationController extends Controller
{
    /**
     * Accept a Firestore-like profile JSON and return hybrid recommendations.
     * POST /api/recommendations/user
     */
    public function userRecommendations(Request $request)
    {
        $profile = $request->json()->all();
        $uid = $request->input('uid') ?? ($profile['uid'] ?? 'anonymous');

        // sanitize uid for file paths
        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $uid ?: 'anonymous');
        $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');

        // TTL for cached results (seconds). If cached file is recent, return it immediately.
        $cacheTtl = 60 * 60; // 1 hour
        try {
            // If cache exists and is fresh, return immediately
            if (file_exists($cachePath) && (time() - filemtime($cachePath) < $cacheTtl)) {
                $raw = @file_get_contents($cachePath);
                $json = json_decode($raw, true);
                if ($json !== null) {
                    return response()->json($json);
                }
            }

            // If stale or missing cache: dispatch background job to generate recommendations
            // but return cached file immediately if present
            if (file_exists($cachePath)) {
                // return stale cache while job regenerates in background
                $raw = @file_get_contents($cachePath);
                $json = json_decode($raw, true);
                // dispatch the job asynchronously
                GenerateRecommendations::dispatch($uid, $profile);
                if ($json !== null) {
                    return response()->json($json);
                }
            }

            // No cache exists: dispatch job and return 202 Accepted with placeholder
            GenerateRecommendations::dispatch($uid, $profile);
            return response()->json(['status' => 'scheduled', 'message' => 'Recommendation generation scheduled.'], 202);
        } catch (\Exception $e) {
            Log::error('Recommendation exception: ' . $e->getMessage());
            return response()->json(['error' => 'exception', 'message' => $e->getMessage()], 500);
        }
    }
}
