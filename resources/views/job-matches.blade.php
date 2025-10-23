@extends('layouts.includes')

@section('content')


    <!-- Filter Form -->
    <section class="bg-yellow-400 py-10 mt-4">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('job.matches') }}">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/logo.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Job Recommended For You</h2>
                        <p class="text-sm text-gray-600 italic">(Mga Trabahong Para sa Iyo)</p>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <select name="industry" class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                        <option value="">Industry</option>
                        <option value="Healthcare" {{ request('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare
                        </option>
                        <option value="Retail" {{ request('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                        <option value="Food Service" {{ request('industry') == 'Food Service' ? 'selected' : '' }}>Food Service
                        </option>
                        <option value="Education" {{ request('industry') == 'Education' ? 'selected' : '' }}>Education
                        </option>
                        <option value="Hospitality" {{ request('industry') == 'Hospitality' ? 'selected' : '' }}>Hospitality
                        </option>
                        <option value="Manufacturing" {{ request('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing
                        </option>
                        <option value="Transportation" {{ request('industry') == 'Transportation' ? 'selected' : '' }}>Transportation
                        </option>
                        <option value="Cleaning" {{ request('industry') == 'Cleaning' ? 'selected' : '' }}>Cleaning
                        </option>
                        <option value="Office" {{ request('industry') == 'Office' ? 'selected' : '' }}>Office
                        </option>
                        <option value="Construction" {{ request('industry') == 'Construction' ? 'selected' : '' }}>Construction
                        </option>
                        <option value="Creative" {{ request('industry') == 'Creative' ? 'selected' : '' }}>Creative
                        </option>
                        <option value="Packing" {{ request('industry') == 'Packing' ? 'selected' : '' }}>Packing
                        </option>
                        <option value="Other" {{ request('industry') == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    <select name="fit_level" class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                        <option value="">Job Fit Level</option>
                        <option value="Excellent Fit" {{ request('fit_level') == 'Excellent Fit' ? 'selected' : '' }}>
                            Excellent Fit</option>
                        <option value="Good Fit" {{ request('fit_level') == 'Good Fit' ? 'selected' : '' }}>Good Fit
                        </option>
                    </select>
                    <select name="growth_potential" class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                        <option value="">Growth Potential</option>
                        <option value="High Potential" {{ request('growth_potential') == 'High Potential' ? 'selected' : '' }}>
                            High Potential</option>
                        <option value="Medium Potential" {{ request('growth_potential') == 'Medium Potential' ? 'selected' : '' }}>
                            Medium Potential</option>
                    </select>
                    <select name="work_environment" class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                        <option value="">Work Environment</option>
                        <option value="Quiet" {{ request('work_environment') == 'Quiet' ? 'selected' : '' }}>Quiet</option>
                        <option value="Busy" {{ request('work_environment') == 'Busy' ? 'selected' : '' }}>Busy</option>
                    </select>
                    <!-- location filter removed per request -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg ml-2">Filter</button>
                </div>
                <p class="text-center text-xs mt-3 italic text-gray-600">(i-click ang dropdown arrow sa itaas...)</p>
            </form>
        </div>
    </section>

    <!-- Match Notice -->
    <div class="container mx-auto mt-6 px-4">
        <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-gray-800 font-medium flex items-center">
                💡 These jobs match your skills and preferences!
            </p>
            <p class="italic text-sm text-gray-600">(Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan!)</p>
        </div>

        <div class="mt-4 flex flex-col md:flex-row md:space-x-4">
            <div class="bg-white p-4 rounded-lg shadow w-full md:w-1/2">
                <h3 class="text-blue-600 font-semibold">Saved Jobs</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Click the “Save” button on any job listing to keep it for later. <br>
                    <span class="italic text-xs">(-I-click ang Save button sa anumang job listing upang mai-save ito para sa susunod.)</span>
                </p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow w-full md:w-1/2 mt-4 md:mt-0">
                <p class="text-sm text-gray-600">
                    Click the “View Details” button to view more information about the Job. <br>
                    <span class="italic text-xs">(-I-click ang button na “View Details” para makita ang karagdagang impormasyon tungkol sa trabaho.)</span>
                </p>
            </div>
        </div>
        <br>
        <div class="flex items-center gap-3 mt-4 md:mt-0">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">All Matches</button>
        </div>
    </div>

    <!-- Job Cards -->
    @php
        // Try to load precomputed recommendations (generated by tools/generate_recommendations.py)
        $json_path = public_path('recommendations.json');
        $recommendations = [];

        // Inference helpers and industry keyword mapping (shared by JSON and CSV loaders)
        $infer_fit_level = function(string $text) {
            $t = strtolower($text);
            $excellent = ['excellent', 'perfect', 'highly suitable', 'highly qualified', 'strong match', 'ideal'];
            foreach ($excellent as $k) { if (strpos($t, $k) !== false) return 'Excellent Fit'; }
            $good = ['good fit', 'good', 'suitable', 'appropriate', 'fit'];
            foreach ($good as $k) { if (strpos($t, $k) !== false) return 'Good Fit'; }
            return '';
        };

        $infer_growth_potential = function(string $text) {
            $t = strtolower($text);
            $high = ['promotion', 'career growth', 'growth', 'advance', 'development', 'opportunity', 'career advancement', 'leadership'];
            foreach ($high as $k) { if (strpos($t, $k) !== false) return 'High Potential'; }
            $medium = ['entry level', 'entry-level', 'trainee', 'starter', 'mid-level'];
            foreach ($medium as $k) { if (strpos($t, $k) !== false) return 'Medium Potential'; }
            return '';
        };

        $infer_work_environment = function(string $text) {
            $t = strtolower($text);
            $quiet = ['quiet', 'calm', 'low noise', 'private', 'peaceful', 'indoor quiet', 'office', 'cubicle'];
            foreach ($quiet as $k) { if (strpos($t, $k) !== false) return 'Quiet'; }
            $busy = ['busy', 'fast-paced', 'high energy', 'crowd', 'bustling', 'active environment', 'outdoor', 'warehouse', 'floor'];
            foreach ($busy as $k) { if (strpos($t, $k) !== false) return 'Busy'; }
            return '';
        };

        // basic industry keyword lists used for filtering when an industry is selected
        $industryKeywords = [
            'Healthcare' => ['health', 'nurse', 'doctor', 'clinic', 'hospital', 'patient', 'medical', 'therapist', 'pharmacy', 'caregiver', 'care'],
            'Retail' => ['retail','store','sales','cashier','shop','merchandis','customer service','stock','merchandise','associate'],
            'Food Service' => ['cook','chef','restaurant','food','barista','kitchen','waiter','waitress','server','catering'],
            'Education' => ['teacher','education','school','instructor','tutor','teacher aide','educator','classroom'],
            'Hospitality' => ['hotel','hospitality','front desk','housekeeping','concierge','lodging','guest'],
            'Manufacturing' => ['manufactur','assembly','production','factory','warehouse','operator','machinist','plant'],
            'Transportation' => ['driver','delivery','truck','transport','logistic','courier','van driver','bus driver'],
            'Cleaning' => ['clean','janitor','housekeeping','custodian','sanitation','cleaner'],
            'Office' => ['office','admin','administrative','reception','clerical','data entry','secretary'],
            'Construction' => ['construction','builder','carpenter','laborer','site','construction worker','foreman','excavator'],
            'Creative' => ['designer','creative','graphic','artist','illustrator','photograph','copywriter','content'],
            'Packing' => ['packag','packer','fulfillment','picker','warehouse','shipping'],
            'Other' => []
        ];

        if (file_exists($json_path)) {
            // Cache parsed JSON keyed by file mtime so repeated requests are fast
            $cacheKey = 'recommendations_json_' . md5($json_path . '|' . @filemtime($json_path));
            $decoded = cache()->remember($cacheKey, 600, function() use ($json_path) {
                $json = @file_get_contents($json_path);
                $rows = json_decode($json, true) ?: [];
                return is_array($rows) ? $rows : [];
            });

            if (is_array($decoded)) {
                foreach ($decoded as $index => $row) {
                    $title = $row['title'] ?? $row['Title'] ?? $row['job_title'] ?? '';
                    $company = $row['company'] ?? $row['Company'] ?? '';
                    $job_description = $row['job_description'] ?? $row['JobDescription'] ?? $row['description'] ?? '';
                    $job_requirement = $row['job_requirement'] ?? $row['resume'] ?? $row['JobRequirment'] ?? $row['RequiredQual'] ?? '';
                    $location = $row['location'] ?? $row['Location'] ?? '';
                    $salary = $row['salary'] ?? $row['Salary'] ?? '';
                    $deadline = $row['deadline'] ?? $row['Deadline'] ?? '';
                    $announcement_code = $row['announcement_code'] ?? $row['AnnouncementCode'] ?? '';

                    // prefer computed_score and computed_max_score if present from the generator
                    $computedScore = $row['computed_score'] ?? $row['computed_score_normalized'] ?? null;
                    $computedMax = $row['computed_max_score'] ?? $row['computed_max'] ?? null;

                    // if industry is not provided, infer from title/description using industry keywords
                    $industryVal = $row['industry'] ?? '';
                    if (empty($industryVal)) {
                        $combinedText = strtolower($title . ' ' . $job_description);
                        foreach ($industryKeywords as $ikey => $kwlist) {
                            foreach ($kwlist as $kw) {
                                if (strpos($combinedText, $kw) !== false) { $industryVal = $ikey; break 2; }
                            }
                        }
                    }

                    // extract hours: prefer formatted_work_type, fallback to Duration/Term/Hours, or parse from description
                    $hours = trim($row['formatted_work_type'] ?? $row['Duration'] ?? $row['Term'] ?? $row['Hours'] ?? '');
                    if ($hours === '') {
                        if (preg_match('/Expected hours:\s*([^\r\n]+)/i', $job_description, $m)) {
                            $hours = trim($m[1]);
                        }
                    }

                    $recommendations[] = [
                        'job_id' => isset($row['job_id']) ? intval($row['job_id']) : intval($index),
                        'title' => $title,
                        'company' => $company,
                        'job_description' => $job_description,
                        'job_requirement' => $job_requirement,
                        'resume' => $job_requirement,
                        'match_score' => $row['match_score'] ?? ($computedScore ?? 0),
                        'computed_score' => $computedScore,
                        'computed_max_score' => $computedMax,
                        'industry' => $row['industry'] ?? '',
                        'fit_level' => $row['fit_level'] ?? '',
                        'growth_potential' => $row['growth_potential'] ?? '',
                        'work_environment' => $row['work_environment'] ?? '',
                        'location' => $location,
                        'salary' => $salary,
                        'deadline' => $deadline,
                        'announcement_code' => $announcement_code,
                        'hours' => $hours,
                    ];
                }
            }
        } else {
            // Fallback: read CSV using header names from "postings.csv" (new dataset)
                $csv_path = public_path('postings.csv');
            if (file_exists($csv_path)) {
                $cacheKey = 'recommendations_csv_' . md5($csv_path . '|' . @filemtime($csv_path));
                $csvRows = cache()->remember($cacheKey, 600, function() use ($csv_path) {
                    $out = [];
                        if (($handle = fopen($csv_path, 'r')) !== false) {
                        $header = fgetcsv($handle);
                        if ($header === false) { fclose($handle); return $out; }
                        $cols = $header ? array_map('trim', $header) : [];
                        $numCols = count($cols);
                        if ($numCols === 0) { fclose($handle); return $out; }
                        $maxRows = 5000;

                        while (($row = fgetcsv($handle)) !== false) {
                            if ($numCols > 0) {
                                if (count($row) < $numCols) $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
                                elseif (count($row) > $numCols) $row = array_slice($row, 0, $numCols);
                                if (count($row) !== $numCols) continue;
                            }
                            if ($maxRows-- <= 0) break;
                            $assoc = $numCols ? (array_combine($cols, $row) ?: []) : [];
                            $out[] = $assoc;
                        }
                        fclose($handle);
                    }
                    return $out;
                });

                // inference helpers (kept outside cache since cheap)
                $infer_fit_level = function(string $text) {
                    $t = strtolower($text);
                    $excellent = ['excellent', 'perfect', 'highly suitable', 'highly qualified', 'strong match', 'ideal'];
                    foreach ($excellent as $k) { if (strpos($t, $k) !== false) return 'Excellent Fit'; }
                    $good = ['good fit', 'good', 'suitable', 'appropriate', 'fit'];
                    foreach ($good as $k) { if (strpos($t, $k) !== false) return 'Good Fit'; }
                    return '';
                };

                $infer_growth_potential = function(string $text) {
                    $t = strtolower($text);
                    $high = ['promotion', 'career growth', 'growth', 'advance', 'development', 'opportunity', 'career advancement', 'leadership'];
                    foreach ($high as $k) { if (strpos($t, $k) !== false) return 'High Potential'; }
                    $medium = ['entry level', 'entry-level', 'trainee', 'starter', 'mid-level'];
                    foreach ($medium as $k) { if (strpos($t, $k) !== false) return 'Medium Potential'; }
                    return '';
                };

                $infer_work_environment = function(string $text) {
                    $t = strtolower($text);
                    $quiet = ['quiet', 'calm', 'low noise', 'private', 'peaceful', 'indoor quiet'];
                    foreach ($quiet as $k) { if (strpos($t, $k) !== false) return 'Quiet'; }
                    $busy = ['busy', 'fast-paced', 'high energy', 'crowd', 'bustling', 'active environment'];
                    foreach ($busy as $k) { if (strpos($t, $k) !== false) return 'Busy'; }
                    return '';
                };

                $i = 0;
                foreach ($csvRows as $assoc) {
                    $assoc = is_array($assoc) ? $assoc : [];
                    // Map all requested postings.csv columns into the recommendation object
                    $title = $assoc['title'] ?? $assoc['jobtitle'] ?? '';
                    $company = $assoc['company_name'] ?? $assoc['company'] ?? '';
                    $description = $assoc['description'] ?? '';
                    $skills_desc = $assoc['skills_desc'] ?? '';

                    // Basic content-based scoring (server-side): keyword density from title/description/skills
                    $textForScoring = trim($title . ' ' . $description . ' ' . $skills_desc);
                    $tokens = preg_split('/\W+/', strtolower($textForScoring));
                    $tokens = array_filter($tokens, function($t){ return strlen($t) > 2; });
                    $totalTokens = max(1, count($tokens));
                    $unique = array_unique($tokens);
                    // weight skills more heavily
                    $skillsTokens = preg_split('/\W+/', strtolower($skills_desc));
                    $skillsTokens = array_filter($skillsTokens, function($t){ return strlen($t) > 2; });
                    $skillCount = count($skillsTokens);
                    // score = unique token ratio + skill weight
                    $scoreBase = count($unique) / $totalTokens;
                    $skillBoost = min(1.5, $skillCount / max(1, min(50, $totalTokens)) );
                    $contentScore = round(($scoreBase * 0.7 + $skillBoost * 0.3) * 100, 2);

                    // Inference helpers
                    $inferred_fit = $infer_fit_level($description . ' ' . $skills_desc);
                    $inferred_growth = $infer_growth_potential($description . ' ' . $skills_desc);
                    $inferred_env = $infer_work_environment($description . ' ' . $skills_desc);

                    // try to infer industry from title/description if posting_domain/industry missing
                    $industryInf = $assoc['posting_domain'] ?? $assoc['industry'] ?? '';
                    if (empty($industryInf)) {
                        $combined = strtolower($title . ' ' . $description);
                        foreach ($industryKeywords as $ikey => $kwlist) {
                            foreach ($kwlist as $kw) {
                                if (strpos($combined, $kw) !== false) { $industryInf = $ikey; break 2; }
                            }
                        }
                    }

                    $recommendations[] = [
                        'job_id' => $assoc['job_id'] ?? $i,
                        'company_name' => $company,
                        // compatibility: existing template expects 'company'
                        'company' => $company,
                        'company_id' => $assoc['company_id'] ?? ($assoc['companyId'] ?? null),
                        'title' => $title,
                        // keep both 'description' and 'job_description' for compatibility
                        'description' => $description,
                        'job_description' => $description,
                        'skills_desc' => $skills_desc,
                        'max_salary' => $assoc['max_salary'] ?? null,
                        'min_salary' => $assoc['min_salary'] ?? null,
                        'med_salary' => $assoc['med_salary'] ?? null,
                        'normalized_salary' => $assoc['normalized_salary'] ?? null,
                        'salary' => $assoc['max_salary'] ?? $assoc['normalized_salary'] ?? null,
                        'pay_period' => $assoc['pay_period'] ?? null,
                        'location' => $assoc['location'] ?? null,
                        'views' => $assoc['views'] ?? null,
                        'applies' => $assoc['applies'] ?? null,
                        'formatted_work_type' => $assoc['formatted_work_type'] ?? $assoc['work_type'] ?? null,
                        'hours' => $hours,
                        'original_listed_time' => $assoc['original_listed_time'] ?? null,
                        'listed_time' => $assoc['listed_time'] ?? null,
                        'remote_allowed' => $assoc['remote_allowed'] ?? null,
                        'job_posting_url' => $assoc['job_posting_url'] ?? null,
                        'application_url' => $assoc['application_url'] ?? null,
                        'application_type' => $assoc['application_type'] ?? null,
                        'expiry' => $assoc['expiry'] ?? null,
                        'closed_time' => $assoc['closed_time'] ?? null,
                        'formatted_experience_level' => $assoc['formatted_experience_level'] ?? null,
                        'posting_domain' => $assoc['posting_domain'] ?? null,
                        'sponsored' => $assoc['sponsored'] ?? null,
                        'work_type' => $assoc['work_type'] ?? null,
                        'currency' => $assoc['currency'] ?? null,
                        'compensation_type' => $assoc['compensation_type'] ?? null,
                        'announcement_code' => $assoc['announcement_code'] ?? '',
                        'zip_code' => $assoc['zip_code'] ?? null,
                        'fips' => $assoc['fips'] ?? null,
                        'match_score' => $assoc['match_score'] ?? null,
                        'computed_score' => null,
                        'industry' => $industryInf,
                        'fit_level' => $assoc['formatted_experience_level'] ?? $inferred_fit,
                        'growth_potential' => $inferred_growth,
                        'work_environment' => $inferred_env,
                        'content_score' => $contentScore,
                    ];
                    $i++;
                }
            }
        }

        // Load guardian approvals (local storage file) and apply keyword-based filtering (if any filters selected)
        $approvals_path = storage_path('app/guardian_job_approvals.json');
        $guardianApprovals = [];
        if (file_exists($approvals_path)) {
            $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: [];
        }


        // Helper: return true if job is approved (string job_id or numeric index)
        $isJobApproved = function($job) use ($guardianApprovals) {
            $id = isset($job['job_id']) ? (string)$job['job_id'] : null;
            if ($id !== null && isset($guardianApprovals[$id]) && isset($guardianApprovals[$id]['status']) && $guardianApprovals[$id]['status'] === 'approved') return true;
            // also check dataIndex style keys if present
            if (isset($job['__dataIndex'])) {
                $di = (string)$job['__dataIndex'];
                if (isset($guardianApprovals[$di]) && isset($guardianApprovals[$di]['status']) && $guardianApprovals[$di]['status'] === 'approved') return true;
            }
            return false;
        };

    // Apply filters (industry via keyword lists, fit_level, growth, work_environment)
    $filtered = [];
    $selectedIndustry = request('industry') ? trim(request('industry')) : '';
        foreach ($recommendations as $job) {
            $show = true;
            if ($selectedIndustry) {
                // If job has an explicit industry string, compare directly; otherwise match against keyword lists
                $jobIndustry = strtolower(trim($job['industry'] ?? ''));
                if ($jobIndustry === strtolower($selectedIndustry)) {
                    // ok
                } else {
                    $kwMatched = false;
                    $needleText = strtolower(($job['job_description'] ?? $job['title'] ?? '') . ' ' . ($job['title'] ?? ''));
                    $kwList = $industryKeywords[$selectedIndustry] ?? [];
                    foreach ($kwList as $kw) { if (strpos($needleText, $kw) !== false) { $kwMatched = true; break; } }
                    if (!$kwMatched) $show = false;
                }
            }
            // location filtering removed per request
            if (request('fit_level') && (!isset($job['fit_level']) || strlen(trim($job['fit_level'])) === 0 || strtolower($job['fit_level']) != strtolower(request('fit_level')))) {
                $show = false;
            }
            if (request('growth_potential') && (!isset($job['growth_potential']) || strlen(trim($job['growth_potential'])) === 0 || strtolower($job['growth_potential']) != strtolower(request('growth_potential')))) {
                $show = false;
            }
            if (request('work_environment') && (!isset($job['work_environment']) || strlen(trim($job['work_environment'])) === 0 || strtolower($job['work_environment']) != strtolower(request('work_environment')))) {
                $show = false;
            }
            if ($show) $filtered[] = $job;
        }

        // Do NOT enforce guardian approval here: show all jobs even if guardian has not approved yet
        // (this keeps the public job list comprehensive). Previously the code filtered out jobs when
        // any guardian approvals existed; we intentionally leave $filtered intact so all jobs appear.

        // Extract unique job titles and companies for a brief summary displayed above the list
        // Use the filtered set so the summary reflects current filters
        $allTitles = [];
        $allCompanies = [];
        foreach ($filtered as $r) {
            $t = trim((string)($r['title'] ?? $r['job_description'] ?? ''));
            $c = trim((string)($r['company'] ?? $r['company_name'] ?? ''));
            if ($t !== '') $allTitles[] = $t;
            if ($c !== '') $allCompanies[] = $c;
        }
        $uniqueTitles = array_values(array_slice(array_unique($allTitles), 0, 200));
        $uniqueCompanies = array_values(array_slice(array_unique($allCompanies), 0, 200));

        // Sort by computed/content/hybrid score if available (normalize all scores to 0-100), else by match_score desc
        usort($filtered, function($a, $b) {
            $getRaw = function($x) {
                if (isset($x['content_score']) && $x['content_score'] !== null) return floatval($x['content_score']);
                if (isset($x['computed_score']) && $x['computed_score'] !== null) return floatval($x['computed_score']);
                return floatval($x['match_score'] ?? 0);
            };
            $norm = function($val) {
                // if value looks like 0-1 fraction, scale to 0-100
                if ($val > 0 && $val <= 1.01) return $val * 100.0;
                return $val;
            };
            $aScore = $norm($getRaw($a));
            $bScore = $norm($getRaw($b));
            return $bScore <=> $aScore;
        });

        // Pagination
        $page = max(1, intval(request('page', 1)));
        $perPage = 10;
        $total = count($filtered);
        $recommendations = array_slice($filtered, ($page - 1) * $perPage, $perPage);
        $lastPage = max(1, (int)ceil($total / $perPage));
    @endphp

    <div class="container mx-auto mt-8 px-4 space-y-6">
        {{-- Quick summary: show number of unique job titles and companies extracted from recommendations --}}
        <div class="bg-white p-4 rounded-lg shadow mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold">Jobs Summary</h4>
                    <p class="text-sm text-gray-600">Found <strong>{{ count($uniqueTitles) }}</strong> unique titles and <strong>{{ count($uniqueCompanies) }}</strong> unique companies in the current dataset.</p>
                </div>
                <div class="text-sm text-gray-500">
                    <a href="#titles-list" class="underline">View titles</a> · <a href="#companies-list" class="underline">View companies</a>
                </div>
            </div>

            <div id="titles-list" class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
                @foreach(array_slice($uniqueTitles, 0, 30) as $t)
                    <span class="px-2 py-1 bg-gray-100 rounded">{{ Str::limit($t, 50) }}</span>
                @endforeach
            </div>
            <div id="companies-list" class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
                @foreach(array_slice($uniqueCompanies, 0, 30) as $c)
                    <span class="px-2 py-1 bg-gray-100 rounded">{{ Str::limit($c, 50) }}</span>
                @endforeach
            </div>
        </div>
        @if(empty($recommendations))
            <div class="bg-yellow-100 p-6 rounded-xl text-center text-gray-600">
                No job recommendations found. Please upload <b>postings.csv</b> to the <b>public/</b> folder (or generate recommendations.json).
            </div>
        @else
            @foreach($recommendations as $idx => $job)
                @php $job_dom_id = 'job_'.$job['job_id'] ?? ('p'.($page - 1) * $perPage + $idx); @endphp
                @php
                    // raw content/match scores (preserve original for display)
                    $rawContentValue = $job['content_score'] ?? $job['computed_score'] ?? $job['match_score'] ?? 0;
                    $computedMaxScore = $job['computed_max_score'] ?? $job['computed_max'] ?? null;
                    // normalized content score (0-100) for boosting/sorting
                    $normContent = $rawContentValue;
                    if (is_numeric($normContent) && $normContent > 0 && $normContent <= 1.01) $normContent = $normContent * 100.0;
                    $contentAttr = round(floatval($normContent), 2);

                    // Determine a display title: prefer explicit title, then try to extract a short title from job_description
                    $rawTitle = trim(strval($job['title'] ?? ''));
                    if ($rawTitle === '') {
                        $desc = trim(strval($job['job_description'] ?? $job['description'] ?? ''));
                        // try to capture a short headline before keywords like 'needed', 'required', ':' or sentence end
                        if (preg_match('/^(.{1,140}?)(?:\.|\n| needed with| needed| required with| required|:| - )/i', $desc, $m)) {
                            $rawTitle = trim($m[1]);
                        } else {
                            // fallback to the first 120 chars of description
                            $rawTitle = Str::limit($desc, 120);
                        }
                    }

                    // company fallback: check multiple fields commonly used in the CSV/JSON
                    $companyName = trim(strval($job['company'] ?? $job['company_name'] ?? $job['Company'] ?? ''));
                    $titleShort = Str::limit($rawTitle, 120);
                    // raw match value (preserve original for display). Normalize for percent display
                    $rawMatchVal = $job['match_score'] ?? $job['computed_score'] ?? 0;
                    $matchPercent = 0;
                    $rawMatchDisplay = $rawMatchVal;
                    // if computed_max_score present, include it in raw display for clarity
                    if (!empty($computedMaxScore)) {
                        // show computed_score / computed_max_score format when available
                        if (is_numeric($rawMatchDisplay) && is_numeric($computedMaxScore)) {
                            $rawMatchDisplay = (string)$rawMatchDisplay . ' (max: ' . (string)$computedMaxScore . ')';
                        }
                    }
                    if (is_numeric($rawMatchVal)) {
                        $m = floatval($rawMatchVal);
                        if ($m > 0 && $m <= 1.01) {
                            $matchPercent = round($m * 100);
                            $rawMatchDisplay = $m; // show fractional
                        } elseif ($m > 0 && $m <= 5.0) {
                            // treat 0-5 point scale as out of 5
                            $matchPercent = round($m * 20);
                            $rawMatchDisplay = $m . '/5';
                        } else {
                            $matchPercent = round($m);
                            $rawMatchDisplay = $m;
                        }
                    }
                @endphp
                <div id="{{ $job_dom_id }}" data-job-id="{{ $job['job_id'] ?? (($page - 1) * $perPage + $idx) }}" data-title="{{ e($titleShort) }}" data-company="{{ e($companyName) }}" data-description="{{ e(Str::limit($job['job_description'], 400)) }}" data-location="{{ e($job['location']) }}" data-fit-level="{{ e($job['fit_level'] ?? '') }}" data-content-score="{{ $contentAttr }}" data-raw-content="{{ e($rawContentValue) }}" data-match-percent="{{ $matchPercent }}" data-raw-match="{{ e($rawMatchDisplay) }}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                    <div class="flex-1 pr-6">
                        <h3 class="text-lg font-bold">{{ $titleShort }}</h3>
                        <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">{{ $matchPercent }}% Match <small class="text-xs text-gray-500">(raw: {{ $rawMatchDisplay }})</small></span></div>
                        @if(!empty($job['company']))
                          <p class="text-sm text-gray-700 font-medium">{{ $job['company'] }}</p>
                        @endif
                        <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($job['job_description'], 220) }}</p>
                         <div class="flex gap-2 text-xs mt-2">
                            @if($job['industry'])
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $job['industry'] }}</span>
                            @endif
                            @if($job['work_environment'])
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $job['work_environment'] }}</span>
                            @endif
                        </div>
                        <div class="flex gap-2 mt-2">
                            @if($job['fit_level'])
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $job['fit_level'] }}</span>
                            @endif
                            @if($job['growth_potential'])
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">{{ $job['growth_potential'] }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            Salary: {{ $job['salary'] ?? '-' }} @if($job['deadline']) • Deadline: {{ $job['deadline'] }} @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3 mt-4 md:mt-0">
                        @php
                            $jid = (string)($job['job_id'] ?? (($page - 1) * $perPage + $idx));
                            $approval = $guardianApprovals[$jid] ?? null;
                        @endphp

                        @if(!empty($guardianApprovals))
                            @if($approval && (($approval['status'] ?? '') === 'approved'))
                                <span class="px-3 py-1 rounded text-xs bg-green-100 text-green-800 font-semibold">Approved by guardian</span>
                            @elseif($approval && (($approval['status'] ?? '') === 'flagged'))
                                <span class="px-3 py-1 rounded text-xs bg-red-100 text-red-800 font-semibold">Flagged by guardian</span>
                            @else
                                <a href="{{ route('guardianreview.pending') }}?job_id={{ $jid }}" id="guardian-badge-{{ $jid }}" title="Open guardian review for this job" class="px-3 py-1 rounded text-xs bg-yellow-100 text-yellow-800 font-semibold">Pending guardian review</a>
                                @if(Auth::check() && optional(Auth::user())->role === 'guardian')
                                    {{-- Guardian users should still use the guardian review pages for approve/flag actions; link provided above --}}
                                @else
                                    <a href="{{ route('guardianreview.pending') }}" class="text-sm text-gray-700 underline">Ask guardian to review</a>
                                @endif
                            @endif
                        @endif

                        <a href="{{ route('job.details', ['job_id' => $job['job_id'] ?? (($page - 1) * $perPage + $idx)]) }}"
                           class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">
                            View Details
                        </a>
                        <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $job['job_id'] ?? (($page - 1) * $perPage + $idx) }}">
                            <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">
                                Saved
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                @if($page > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" class="px-4 py-2 bg-blue-100 rounded-l hover:bg-blue-200">Previous</a>
                @endif
                <span class="px-4 py-2 bg-white border-t border-b">{{ $page }} / {{ $lastPage }}</span>
                @if($page < $lastPage)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" class="px-4 py-2 bg-blue-100 rounded-r hover:bg-blue-200">Next</a>
                @endif
            </div>
        @endif
    </div>
</div>
<!-- Ensure user is signed-in before taking actions like Apply or Save -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
    <script>
        @auth
            window.__SERVER_AUTH = true;
        @else
            window.__SERVER_AUTH = false;
        @endauth
    </script>
    <script type="module">
    (async function(){
        try {
            const mod = await import("{{ asset('js/job-application-firebase.js') }}");
            const logger = await import("{{ asset('js/client-logger.js') }}");
            // Attempt server-backed sign-in (makes Firebase ID token available to the page)
            try {
                await mod.signInWithServerToken("{{ route('firebase.token') }}");
            } catch(e) { console.debug('job-matches signInWithServerToken failed', e); try { logger.sendClientLog('debug', 'job-matches signInWithServerToken failed', { error: String(e) }); } catch(_) {} }
            const signed = await mod.isSignedIn(7000);
            console.debug('job-matches auth guard: isSignedIn ->', signed);
            if (!signed) {
                if (window.__SERVER_AUTH) {
                    console.info('job-matches: server session present, not redirecting');
                    try { logger.sendClientLog('info', 'job-matches auth guard: server session present', {}); } catch(_) {}
                    return;
                }
                const current = window.location.pathname + window.location.search;
                try { logger.sendClientLog('info', 'job-matches auth guard: redirecting to login', { redirect: current }); } catch(_) {}
                window.location.href = 'login?redirect=' + encodeURIComponent(current);
                return;
            }
        } catch (err) {
            console.error('job-matches auth guard failed', err);
            try { (await import("{{ asset('js/client-logger.js') }}")).sendClientLog('error', 'job-matches auth guard failed', { error: String(err) }); } catch(_) {}
        }
    })();
    </script>
    <script>
        // expose guardian approvals to client-side renderer
        window.__GUARDIAN_APPROVALS = {!! json_encode($guardianApprovals ?? []) !!};
        function escapeHtml(s) { if (!s) return ''; return String(s).replace(/[&<>"]+/g, function(ch){ return {'&':'&amp;','<':'&lt;','>':'&gt;', '"':'&quot;'}[ch]; }); }
    </script>
    <script type="module">
        // Also request server-side hybrid recommendations (collaborative + content)
        try {
            const resp = await fetch('/api/recommendations/user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(profile)
            });
            if (resp.ok) {
                const data = await resp.json();
                const keys = Object.keys(data || {});
                if (keys.length > 0) {
                    const first = data[keys[0]] || [];
                    // render the returned recommendations into the container (replace server-side list)
                    const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                    if (container) {
                        container.innerHTML = '';
                        // create cards
                        first.forEach((r, idx) => {
                            const jid = String(r.job_id || ('p' + idx));
                            const approval = window.__GUARDIAN_APPROVALS && window.__GUARDIAN_APPROVALS[jid];
                            const approvedBadge = approval && approval.status === 'approved' ? '<span class="px-3 py-1 rounded text-xs bg-green-100 text-green-800 font-semibold">Approved by guardian</span>' : (approval && approval.status === 'flagged' ? '<span class="px-3 py-1 rounded text-xs bg-red-100 text-red-800 font-semibold">Flagged by guardian</span>' : '<span class="px-3 py-1 rounded text-xs bg-yellow-100 text-yellow-800 font-semibold">Pending guardian review</span>');

                            const title = r.Title || r.title || r.job_title || '';
                            const company = r.Company || r.company_name || r.company || '';
                            const desc = (r.job_description || r.description || '').substring(0, 400);
                            // normalize returned score into percent and keep raw display string
                            const rawS = r.hybrid_score ?? r.content_score ?? r.user_score ?? r.match_score ?? 0;
                            const rawNum = Number(rawS);
                            let matchPct = 0;
                            let rawDisplay = rawS;
                            if (!isNaN(rawNum)) {
                                if (rawNum > 0 && rawNum <= 1.01) { matchPct = Math.round(rawNum * 100); rawDisplay = rawNum; }
                                else if (rawNum > 0 && rawNum <= 5.01) { matchPct = Math.round(rawNum * 20); rawDisplay = rawNum + '/5'; }
                                else { matchPct = Math.round(rawNum); rawDisplay = rawNum; }
                            }

                            const card = document.createElement('div');
                            card.className = 'job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start';
                            card.setAttribute('data-job-id', jid);
                            // expose raw values as data attributes for later client-side rescoring
                            card.setAttribute('data-raw-match', String(rawDisplay));
                            card.setAttribute('data-raw-content', String(r.content_score ?? r.computed_score ?? r.match_score ?? ''));
                            card.setAttribute('data-match-percent', String(matchPct));
                            card.setAttribute('data-computed-score', String(r.computed_score ?? ''));
                            card.setAttribute('data-computed-max', String(r.computed_max_score ?? r.computed_max ?? ''));
                            card.innerHTML = `
                                <div class="flex-1 pr-6">
                                    <h3 class="text-lg font-bold">${escapeHtml(title) || escapeHtml(desc)}</h3>
                                    <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${matchPct}% Match <small class="text-xs text-gray-500">(raw: ${escapeHtml(String(rawDisplay))})</small></span></div>
                                    ${company ? `<p class="text-sm text-gray-700 font-medium">${escapeHtml(company)}</p>` : ''}
                                    <p class="text-gray-600 mt-2 text-sm">${escapeHtml(desc)}</p>
                                </div>
                                <div class="flex items-center gap-3 mt-4 md:mt-0">
                                    <div>${approvedBadge}</div>
                                    <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">View Details</a>
                                    <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="job_id" value="${escapeHtml(jid)}">
                                        <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">Saved</button>
                                    </form>
                                </div>
                            `;
                            container.appendChild(card);
                        });
                    }
                }
            } else {
                console.warn('Hybrid recommender error', resp.status);
            }
        } catch(e) {
            console.debug('Hybrid recommender failed', e);
        }
    </script>
    <script type="module">
    (async function(){
        try {
            const mod = await import("{{ asset('js/job-application-firebase.js') }}");
            console.debug('Auth guard: waiting for sign-in resolution (7s)');
            try {
                await mod.signInWithServerToken("{{ route('firebase.token') }}");
            } catch (e) { console.debug('signInWithServerToken failed', e); }
            const signed = await mod.isSignedIn(7000);
            console.debug('Auth guard: isSignedIn ->', signed);
            try {
                if (mod && typeof mod.debugAuthLogging === 'function') {
                    // start auth state logging (returns unsubscribe function)
                    window.__unsubAuthLog = mod.debugAuthLogging();
                }
            } catch (e) {
                console.warn('debugAuthLogging invocation failed', e);
            }
            if (!signed) {
                // if server has a session, assume the user is already authenticated via backend and skip client redirect
                if (window.__SERVER_AUTH) {
                    console.info('Auth guard: server session present, not redirecting');
                    return;
                }
                // if still not signed after waiting, redirect to login
                const current = window.location.pathname + window.location.search;
                console.info('Auth guard: not signed, redirecting to login');
                window.location.href = 'login?redirect=' + encodeURIComponent(current);
                return;
            }
        } catch (err) {
            console.error('Auth guard failed on job matches', err);
        }
    })();

    // Guardian approve/flag handlers (AJAX) - require authentication
    function postAction(url, body) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(body || {})
        }).then(r => r.json());
    }

    // Approve/flag actions are only available in the Guardian Review pages; no handlers here.
</script>
<script type="module">
// Re-score job cards using the user's Firestore profile (if available)
(async function(){
    try {
        const mod = await import("{{ asset('js/job-application-firebase.js') }}");
        await mod.ensureInit?.();
        // get profile (uses getUserProfile in module)
        let profile = null;
        try { profile = await mod.getUserProfile(); } catch(e) { console.debug('no profile from firebase module', e); }

        if (!profile) return;
        // Normalize profile fields
        const jobPrefs = [];
        try {
            const jp1 = profile.jobPreferences?.jobpref1 || profile.jobPreferences?.jobpref_1 || profile.jobpref1;
            const jp2 = profile.jobPreferences?.jobpref2 || profile.jobpref2;
            if (jp1) JSON.parse(jp1).forEach(x=>jobPrefs.push(String(x).toLowerCase()));
            if (jp2) JSON.parse(jp2).forEach(x=>jobPrefs.push(String(x).toLowerCase()));
        } catch(e) { /* ignore parse */ }
        const skills = [];
        try { if (profile.skills?.skills_page1) JSON.parse(profile.skills.skills_page1).forEach(x=>skills.push(String(x).toLowerCase())); } catch(e) {}
        try { if (profile.skills?.skills_page2) JSON.parse(profile.skills.skills_page2).forEach(x=>skills.push(String(x).toLowerCase())); } catch(e) {}
        const workplace = (profile.workplace?.workplace_choice || '').toLowerCase();
        const support = (profile.supportNeed?.support_choice || '').toLowerCase();

        // iterate job cards and compute new score, store numeric value on element for sorting
        const scored = [];
                document.querySelectorAll('.job-card').forEach(card => {
            try {
                const title = (card.dataset.title || '').toLowerCase();
                const desc = (card.dataset.description || '').toLowerCase();
                // server-provided content score (0-100) if available
                        const serverContent = parseFloat(card.dataset.contentScore || card.dataset.contentscore || '0') || 0;
                        // fallback: use data-match-percent or visible badge base
                        const datasetMatchPct = parseInt(card.dataset.matchPercent || card.dataset.matchpercent || '0') || 0;
                        let base = serverContent || datasetMatchPct || (parseInt(card.querySelector('.js-match-badge')?.textContent || '0') || 0);
                // compute boosts from user profile
                let boost = 0;
                jobPrefs.forEach(p => { if (!p) return; const pp = String(p).toLowerCase(); if (title.includes(pp) || desc.includes(pp)) boost += 20; });
                skills.forEach(s => { if (!s) return; const ss = String(s).toLowerCase(); if (title.includes(ss) || desc.includes(ss)) boost += 10; });
                if (workplace && desc.includes(workplace)) boost += 12;
                if (support && desc.includes(support)) boost += 6;
                const final = Math.min(100, Math.max(0, Math.round(base + boost)));
                const badge = card.querySelector('.js-match-badge');
                // Preserve raw display if present, and include computed max if provided
                const rawMatch = card.dataset.rawMatch || card.getAttribute('data-raw-match') || card.dataset.rawmatch || '';
                const computedScore = card.dataset.computedScore || card.getAttribute('data-computed-score') || '';
                const computedMax = card.dataset.computedMax || card.getAttribute('data-computed-max') || '';
                let rawDisplayText = '';
                if (rawMatch) rawDisplayText = ` (raw: ${rawMatch})`;
                if (!rawDisplayText && computedScore) rawDisplayText = ` (computed: ${computedScore}${computedMax ? ' / ' + computedMax : ''})`;
                if (badge) badge.innerHTML = final + '% Match' + '<small class="text-xs text-gray-500">' + rawDisplayText + '</small>';
                card.dataset.personalScore = String(final);
                scored.push({ card, score: final });
            } catch(e) { console.error('rescore error', e); }
        });

        // Reorder DOM: place job cards in descending order of personal score
        if (scored.length > 1) {
            const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
            if (container) {
                // sort scored array
                scored.sort((a,b) => b.score - a.score);
                // remove existing nodes and re-append in order
                scored.forEach(s => {
                    container.appendChild(s.card);
                });
            }
        }

        // Also request server-side hybrid recommendations (collaborative + content)
        try {
            const resp = await fetch('/api/recommendations/user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(profile)
            });
            if (resp.ok) {
                const data = await resp.json();
                const keys = Object.keys(data || {});
                if (keys.length > 0) {
                    const first = data[keys[0]] || [];
                    // map job_id -> hybrid_score
                    const scoreMap = {};
                    first.forEach(r => { scoreMap[String(r.job_id)] = Number(r.hybrid_score ?? r.user_score ?? 0); });
                    // apply scores and reorder DOM
                    const scoredHybrid = [];
                    document.querySelectorAll('.job-card').forEach(card => {
                        const jid = String(card.dataset.jobId || card.getAttribute('data-job-id'));
                        const s = scoreMap[jid] !== undefined ? scoreMap[jid] : 0;
                        card.dataset.hybridScore = String(s);
                        scoredHybrid.push({ card, score: s });
                    });
                    scoredHybrid.sort((a,b)=> b.score - a.score);
                    const container2 = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                    if (container2) scoredHybrid.forEach(x=> container2.appendChild(x.card));
                }
            } else {
                console.warn('Hybrid recommender error', resp.status);
            }
        } catch(e) {
            console.debug('Hybrid recommender failed', e);
        }
    } catch(err) { console.debug('rescore aborted', err); }
})();
</script>
@endsection
