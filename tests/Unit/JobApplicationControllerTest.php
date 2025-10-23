<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\JobApplicationController;

class JobApplicationControllerTest extends TestCase
{
    public function testGetJobFromCsvAndFieldConversion()
    {
    // Prepare a small CSV file in storage
    $base = dirname(__DIR__, 2); // project root
    $csvPath = $base . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'testing_postings.csv';
        $rows = [
            ['job_id','title','company','location','description'],
            ['100','Cashier','McTest','Test City','Handle cash'],
            ['101','Cook','McTest','Test City','Cook food'],
        ];
        $fp = fopen($csvPath, 'w');
        foreach ($rows as $r) { fputcsv($fp, $r); }
        fclose($fp);

        // Temporarily copy CSV to public/postings.csv so controller's getJobFromCsv (which uses public_path) finds it
        // We'll call getJobFromCsv by constructing the controller and using reflection
        $ctrl = new JobApplicationController();

        $ref = new \ReflectionClass($ctrl);
        $method = $ref->getMethod('getJobFromCsv');
        $method->setAccessible(true);

        // Monkeypatch public_path via closure? Instead, temporarily copy file to public/postings.csv
        // To avoid destroying a developer's existing public/postings.csv, back it up if present and restore after the test
        $publicCsv = $base . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'postings.csv';
        $backup = null;
        if (file_exists($publicCsv)) {
            $backup = $publicCsv . '.bak_' . uniqid();
            copy($publicCsv, $backup);
        }
        copy($csvPath, $publicCsv);

        $job = $method->invoke($ctrl, '100');
        $this->assertIsArray($job);
        $this->assertEquals('Cashier', $job['title']);
        $this->assertEquals('McTest', $job['company']);

        // Test Firestore field conversion (phpValueToFirestoreField)
        $method2 = $ref->getMethod('phpValueToFirestoreField');
        $method2->setAccessible(true);
        $field = $method2->invoke($ctrl, 123);
        $this->assertArrayHasKey('integerValue', $field);
        $this->assertEquals('123', $field['integerValue']);

        // clean up
        @unlink($csvPath);
        @unlink($publicCsv);
        // restore original postings.csv if we backed it up
        if (!empty($backup) && file_exists($backup)) {
            copy($backup, $publicCsv);
            @unlink($backup);
        }
    }
}
