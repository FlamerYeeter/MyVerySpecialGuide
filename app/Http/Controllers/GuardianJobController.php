<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GuardianJobController extends Controller
{
    // Return the approvals map (for guardian UI)
    public function list(Request $request)
    {
        $path = storage_path('app/guardian_job_approvals.json');
        $data = [];
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $data = json_decode($json, true) ?: [];
        }
        return response()->json(['success' => true, 'approvals' => $data]);
    }

    // Approve a job by id (job_id or dataIndex). Stores feedback and metadata.
    public function approve(Request $request, $jobId)
    {
        return $this->setStatus($request, $jobId, 'approved');
    }

    // Flag a job as not suitable
    public function flag(Request $request, $jobId)
    {
        return $this->setStatus($request, $jobId, 'flagged');
    }

    private function setStatus(Request $request, $jobId, $status)
    {
        // ensure simple job id string
        $key = (string)$jobId;
        $path = storage_path('app/guardian_job_approvals.json');
        $map = [];
        if (file_exists($path)) {
            $map = json_decode(file_get_contents($path), true) ?: [];
        }
        $map[$key] = [
            'status' => $status,
            'feedback' => (string)$request->input('feedback', ''),
            'actioned_by' => auth()->id() ? (string)auth()->id() : '',
            'actioned_at' => now()->toIso8601String(),
        ];
        // best-effort write
        try {
            file_put_contents($path, json_encode($map, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            return response()->json(['error' => 'write_failed', 'message' => $e->getMessage()], 500);
        }
        return response()->json(['success' => true, 'approval' => $map[$key]]);
    }
}
