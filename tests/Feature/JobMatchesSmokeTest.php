<?php

namespace Tests\Feature;

use Tests\TestCase;

class JobMatchesSmokeTest extends TestCase
{
    /** @test */
    public function blade_file_and_public_artifacts_exist()
    {
        $blade = base_path('resources/views/job-matches.blade.php');
        $this->assertFileExists($blade, 'job-matches.blade.php should exist');

        $best = public_path('best_weights.json');
        $this->assertFileExists($best, 'public/best_weights.json should exist (optimizer output)');

        $rescored = public_path('recommendations_rescored.json');
        $this->assertFileExists($rescored, 'public/recommendations_rescored.json should exist (rescored recommendations)');
    }
}
