<?php
namespace App\Services;

class JobCsvParser
{
    protected $path;

    public function __construct($path = null)
    {
        $this->path = $path ?: public_path('postings.csv');
    }

    /**
     * Find a job row by job_id (header column) or by 0-based index.
     * Returns associative array of header => value, or null if not found.
     */
    public function findJobById($jobId)
    {
        if (!$jobId) return null;

        if (!file_exists($this->path)) {
            $this->safeLog('warning', 'JobCsvParser: postings.csv not found', ['path' => $this->path]);
            return null;
        }

        if (($handle = @fopen($this->path, 'r')) === false) {
            $this->safeLog('warning', 'JobCsvParser: failed to open postings.csv', ['path' => $this->path]);
            return null;
        }

        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);
            $this->safeLog('warning', 'JobCsvParser: postings.csv missing header or empty file', ['path' => $this->path]);
            return null;
        }

        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = $row;
        }
        fclose($handle);

        // Build lowercase header->index map
        $map = [];
        if (is_array($headers)) {
            foreach ($headers as $i => $hn) {
                if (!is_string($hn)) continue;
                $map[strtolower(trim($hn))] = $i;
            }
        }

        $rowFound = null;

        // Try to match job_id header
        $jobIdCol = null;
        if (!empty($map) && array_key_exists('job_id', $map)) {
            $jobIdCol = $map['job_id'];
        }

        foreach ($rows as $i => $r) {
            if ($jobIdCol !== null && is_array($r) && array_key_exists($jobIdCol, $r) && strval($r[$jobIdCol]) === strval($jobId)) {
                $rowFound = $r; break;
            }
            if (is_numeric($jobId) && intval($jobId) === $i) {
                $rowFound = $r; break;
            }
        }

        if (empty($rowFound)) {
            $this->safeLog('info', 'JobCsvParser: job not found in postings.csv', ['job_id' => $jobId, 'path' => $this->path]);
            return null;
        }

        // Build assoc by headers (use empty string for missing headers)
        $assoc = [];
        $numCols = count($headers);
        for ($i = 0; $i < $numCols; $i++) {
            $key = is_string($headers[$i]) ? strtolower(trim($headers[$i])) : 'col_' . $i;
            $assoc[$key] = array_key_exists($i, $rowFound) ? $rowFound[$i] : '';
        }

        return $assoc;
    }

    protected function safeLog($level, $message, $context = [])
    {
        // prefer logger() helper if available (Laravel), otherwise fallback to error_log
        try {
            if (function_exists('logger')) {
                logger()->{$level}($message, $context);
                return;
            }
        } catch (\Throwable $e) {
            // fallthrough to error_log
        }
        $ctx = json_encode($context);
        error_log(strtoupper($level) . ': ' . $message . ' ' . $ctx);
    }

}
