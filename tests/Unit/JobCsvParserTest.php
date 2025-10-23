<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\JobCsvParser;

class JobCsvParserTest extends TestCase
{
    public function test_missing_file_returns_null()
    {
        $parser = new JobCsvParser(__DIR__ . '/nonexistent_postings.csv');
        $this->assertNull($parser->findJobById('1'));
    }

    public function test_find_job_by_index_and_header()
    {
        $tmp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test_postings.csv';
        $content = "job_id,title,company,location\n";
        $content .= "100,Test Job,Acme,Nowhere\n";
        $content .= "101,Other Job,Globex,Someplace\n";
        file_put_contents($tmp, $content);

        $parser = new JobCsvParser($tmp);
        $found = $parser->findJobById('100');
        $this->assertIsArray($found);
        $this->assertEquals('Test Job', $found['title']);

        // by zero-based index (1 -> second row)
        $found2 = $parser->findJobById('1');
        $this->assertIsArray($found2);
        // index 1 should map to second data row (101)
        $this->assertEquals('101', $found2['job_id']);

        @unlink($tmp);
    }
}
