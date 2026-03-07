<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class TtsController extends Controller
{
    /**
     * Generate TTS audio via Azure Cognitive Services (REST) and return a cached URL.
     * Requires AZURE_TTS_KEY and AZURE_TTS_REGION in .env
     */
    public function generate(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string|max:5000',
            'lang' => 'nullable|string|max:10',
            'voice' => 'nullable|string|max:200',
        ]);

        $text = $data['text'];
        $lang = $data['lang'] ?? 'en-US';
        $voice = $data['voice'] ?? 'en-US-AvaMultilingualNeural';

        $key = env('AZURE_TTS_KEY');
        $region = env('AZURE_TTS_REGION');
        if (!$key || !$region) {
            return response()->json(['error' => 'TTS not configured (set AZURE_TTS_KEY and AZURE_TTS_REGION)'], 422);
        }

        $endpoint = "https://{$region}.tts.speech.microsoft.com/cognitiveservices/v1";

        $ssml = "<speak version='1.0' xml:lang='{$lang}'><voice xml:lang='{$lang}' name='{$voice}'>".
                 htmlentities($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').
                 "</voice></speak>";

        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $key,
            'Content-Type' => 'application/ssml+xml',
            'X-Microsoft-OutputFormat' => 'audio-16khz-128kbitrate-mono-mp3',
            'User-Agent' => 'MyVerySpecialGuide-TTS',
        ])->withBody($ssml, 'application/ssml+xml')->post($endpoint);

        if ($response->successful()) {
            $hash = substr(sha1($text . '|' . $voice), 0, 16);
            $filename = "tts/{$hash}.mp3";
            Storage::disk('public')->put($filename, $response->body());
            $url = Storage::disk('public')->url($filename);
            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'TTS request failed', 'details' => $response->body()], 500);
    }
}
