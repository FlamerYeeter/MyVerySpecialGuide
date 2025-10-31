<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JobCsvParser;
use App\Services\FirestoreAdminService;

class ImportPostingsToFirestore extends Command
{
    protected $signature = 'import:postings {--path= : Path to postings CSV} {--limit=0 : Limit number of rows to import (0 = all)}';
    protected $description = 'Import jobs from public/postings.csv into Firestore jobs collection';

    public function handle()
    {
        $path = $this->option('path') ?: public_path('postings.csv');
        $limit = intval($this->option('limit') ?: 0);

        $this->info("Importing postings from: {$path}");
        if (!file_exists($path)) {
            $this->error('Postings CSV not found: ' . $path);
            return 1;
        }

        $fs = app(FirestoreAdminService::class);
        $handle = fopen($path, 'r');
        if ($handle === false) {
            $this->error('Failed to open CSV');
            return 1;
        }
        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);
            $this->error('Empty CSV or missing header');
            return 1;
        }
        $rowIndex = 0;
        $imported = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $assoc = [];
            for ($i = 0; $i < count($headers); $i++) {
                $key = strtolower(trim($headers[$i] ?? 'col_' . $i));
                $assoc[$key] = array_key_exists($i, $row) ? $row[$i] : '';
            }

            // Determine docId: prefer job_id column if present, otherwise use generated id
            $docId = null;
            if (!empty($assoc['job_id'])) $docId = (string)$assoc['job_id'];
            else $docId = 'csv_' . $rowIndex;

            // Normalize some common fields for Firestore storage
            $jobData = [];
            $jobData['title'] = $assoc['title'] ?? ($assoc['job_title'] ?? ($assoc['position'] ?? ''));
            $jobData['description'] = $assoc['job_description'] ?? ($assoc['description'] ?? '');
            $jobData['company'] = $assoc['company'] ?? ($assoc['company_name'] ?? $assoc['employer'] ?? '');
            $jobData['location'] = $assoc['location'] ?? ($assoc['city'] ?? '');
            $jobData['skills'] = !empty($assoc['skills_desc']) ? array_values(array_filter(array_map('trim', preg_split('/[,;|]+/', $assoc['skills_desc'])))) : []; 
            $jobData['industry'] = $assoc['industry'] ?? '';
            $jobData['experience_level'] = $assoc['experience_level'] ?? ($assoc['experience'] ?? '');
            $jobData['posted_at'] = $assoc['posted_at'] ?? $assoc['created_at'] ?? null;
            $jobData['raw'] = $assoc; // keep raw row for debugging

            $ok = $fs->upsertJob($docId, $jobData);
            if ($ok) {
                $this->info("Imported job doc={$docId}");
                $imported++;
            } else {
                $this->error("Failed import job doc={$docId}");
            }

            $rowIndex++;
            if ($limit > 0 && $rowIndex >= $limit) break;
        }
        fclose($handle);
        $this->info("Finished. Imported {$imported} jobs.");
        return 0;
    }
}
