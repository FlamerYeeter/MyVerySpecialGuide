<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RecommendationService;
use App\Services\FirestoreAdminService;
use App\Services\JobCsvParser;

class RecommendationServiceTest extends TestCase
{
    /**
     * Basic integration-style unit test that mocks FirestoreAdminService
     * and uses a small extract from postings.csv via JobCsvParser.
     */
    public function test_generate_recommendations_with_mocked_firestore()
    {
        // Prepare a small jobs set by reading first N rows from postings.csv
        $parser = new JobCsvParser();
        $jobs = [];
        $max = 30;
        for ($i = 0; $i < $max; $i++) {
            $assoc = $parser->findJobById($i);
            if ($assoc === null) break;
            // derive a stable id
            $jobId = isset($assoc['job_id']) && $assoc['job_id'] !== '' ? (string)$assoc['job_id'] : 'row_' . $i;
            $jobs[$jobId] = [
                'title' => $assoc['title'] ?? ($assoc['job_title'] ?? ''),
                'description' => $assoc['job_description'] ?? ($assoc['description'] ?? ''),
                'skills' => $assoc['skills'] ?? ($assoc['required_skills'] ?? ''),
                'company' => $assoc['company'] ?? ($assoc['company_name'] ?? ''),
                'industry' => $assoc['industry'] ?? '',
                'experience_level' => $assoc['experience_level'] ?? '',
                'location' => $assoc['location'] ?? '',
            ];
        }

        // Ensure we have some jobs to test with
        $this->assertNotEmpty($jobs, 'No jobs loaded from postings.csv; ensure the CSV exists and has rows');

        // Build a simple user profile that prefers data/analytics
        $user = [
            'resume_text' => 'Experienced data analyst with SQL, Python and Excel',
            'skills' => ['sql','python','excel'],
            'industry_preference' => 'tech',
        ];

        // Build synthetic interactions to exercise CF: user applied to first job
        $jobIds = array_keys($jobs);
        $interactions = [];
        $uid = 'test-user-1';
        if (!empty($jobIds)) {
            $interactions[] = ['userId' => $uid, 'jobId' => $jobIds[0], 'type' => 'apply'];
            // similar users who applied to job0 also applied to job1
            $interactions[] = ['userId' => 'other1', 'jobId' => $jobIds[0], 'type' => 'apply'];
            if (isset($jobIds[1])) {
                $interactions[] = ['userId' => 'other1', 'jobId' => $jobIds[1], 'type' => 'apply'];
            }
        }

        // Create a mock FirestoreAdminService and bind into container
        $mock = $this->createMock(FirestoreAdminService::class);
        $mock->method('getUser')->willReturn($user);
        $mock->method('listJobs')->willReturn($jobs);
        $mock->method('listInteractions')->willReturn($interactions);

        $this->app->instance(FirestoreAdminService::class, $mock);

        /** @var RecommendationService $svc */
        $svc = $this->app->make(RecommendationService::class);
        $results = $svc->generate($uid, 10);

        $this->assertIsArray($results, 'Expected recommendations array');
        $this->assertNotEmpty($results, 'Expected at least one recommendation');

        // Ensure the recommended items contain expected keys
        $first = $results[0];
        $this->assertArrayHasKey('id', $first);
        $this->assertArrayHasKey('title', $first);
        $this->assertArrayHasKey('score', $first);

        // If CF worked, jobIds[1] should be recommended (because other1 applied to both 0 and 1)
        if (isset($jobIds[1])) {
            $ids = array_map(function($r){ return (string)$r['id']; }, $results);
            $this->assertContains($jobIds[1], $ids, 'CF did not include expected co-applied job in recommendations');
        }
    }
}
