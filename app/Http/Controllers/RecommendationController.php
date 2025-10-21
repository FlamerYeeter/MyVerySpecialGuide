<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

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

        $tmpPath = storage_path('app/tmp_reco_users_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $uid) . '.json');
        try {
            file_put_contents($tmpPath, json_encode([$uid => $profile], JSON_UNESCAPED_UNICODE));

            $python = 'python';
            $script = base_path('tools/generate_recommendations.py');
            $input = base_path('public/postings.csv');

            $cmd = [$python, $script, '--input', $input, '--print-per-user', '--users', $tmpPath, '--top', '50', '--alpha', '0.6', '--neighbors', '5'];
            $process = new Process($cmd);
            $process->setTimeout(120);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('Recommendation generator failed: ' . $process->getErrorOutput());
                return response()->json(['error' => 'generator_failed', 'detail' => $process->getErrorOutput()], 500);
            }

            $out = $process->getOutput();
            $json = json_decode($out, true);
            if ($json === null) {
                return response()->json(['error' => 'invalid_output', 'raw' => $out], 500);
            }

            return response()->json($json);
        } catch (\Exception $e) {
            Log::error('Recommendation exception: ' . $e->getMessage());
            return response()->json(['error' => 'exception', 'message' => $e->getMessage()], 500);
        } finally {
            @unlink($tmpPath);
        }
    }
}
