@extends('layouts.includes')

@section('content')


    <!-- Filter Form -->
    <section class="bg-yellow-400 py-10 mt-4">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('job.matches') }}">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('images/job-search.png') }}" class="w-20 h-20">
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
        if (file_exists($json_path)) {
            $json = file_get_contents($json_path);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                // Use computed_score if available and preserve structure expected by view
                foreach ($decoded as $row) {
                    $recommendations[] = [
                        'job_description' => $row['job_description'] ?? '',
                        'resume' => $row['resume'] ?? '',
                        'match_score' => $row['match_score'] ?? ($row['computed_score'] ?? 0),
                        'computed_score' => $row['computed_score'] ?? null,
                        'industry' => $row['industry'] ?? '',
                        'fit_level' => $row['fit_level'] ?? '',
                        'growth_potential' => $row['growth_potential'] ?? '',
                        'work_environment' => $row['work_environment'] ?? '',
                    ];
                }
            }
        } else {
            // Fallback: read CSV using header names from "data job posts.csv"
            $csv_path = public_path('data job posts.csv');
            if (file_exists($csv_path)) {
                if (($handle = fopen($csv_path, 'r')) !== false) {
                    $header = fgetcsv($handle);
                    // normalize header keys (trim)
                    $cols = array_map(function($h){ return trim($h); }, $header ?: []);

                    // inference helpers
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

                    while (($row = fgetcsv($handle)) !== false) {
                        // create associative row by header
                        $assoc = array_combine($cols, $row) ?: [];
                        $textForInference = trim(($assoc['JobDescription'] ?? '') . ' ' . ($assoc['JobRequirment'] ?? '') . ' ' . ($assoc['jobpost'] ?? ''));
                        $inferred_fit = $infer_fit_level($textForInference);
                        $inferred_growth = $infer_growth_potential($textForInference);
                        $inferred_env = $infer_work_environment($textForInference);
                        $recommendations[] = [
                            // prefer explicit header names, fallback to some common variants
                            'title' => $assoc['Title'] ?? $assoc['jobpost'] ?? '',
                            'company' => $assoc['Company'] ?? '',
                            'job_description' => $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? $assoc['jobpost'] ?? '',
                            'job_requirement' => $assoc['JobRequirment'] ?? $assoc['RequiredQual'] ?? '',
                            'location' => $assoc['Location'] ?? '',
                            'salary' => $assoc['Salary'] ?? '',
                            'start_date' => $assoc['StartDate'] ?? '',
                            'deadline' => $assoc['Deadline'] ?? '',
                            'announcement_code' => $assoc['AnnouncementCode'] ?? '',
                            // keep legacy keys used later in view
                            'resume' => $assoc['JobRequirment'] ?? $assoc['RequiredQual'] ?? '',
                            'match_score' => $assoc['IT'] ?? null,
                            'computed_score' => null,
                            'industry' => $assoc['Company'] ?? '',
                            // prefer CSV-provided fields if present; otherwise use inferred values
                            'fit_level' => $assoc['fit_level'] ?? $assoc['FitLevel'] ?? $inferred_fit,
                            'growth_potential' => $assoc['growth_potential'] ?? $assoc['GrowthPotential'] ?? $inferred_growth,
                            'work_environment' => $assoc['work_environment'] ?? $assoc['WorkEnvironment'] ?? $inferred_env ?? ($assoc['Location'] ?? ''),
                        ];
                    }
                    fclose($handle);
                }
            }
        }

        // Apply keyword-based filtering (if any filters selected)
        $filtered = [];
        foreach ($recommendations as $job) {
            $show = true;
            if (request('industry')) {
                $keyword = strtolower(request('industry'));
                if (strpos(strtolower($job['job_description']), $keyword) === false &&
                    strpos(strtolower($job['resume']), $keyword) === false) {
                    $show = false;
                }
            }
            if (request('fit_level') && (!isset($job['fit_level']) || !strlen($job['fit_level']) || strtolower($job['fit_level']) != strtolower(request('fit_level')))) {
                $show = false;
            }
            if (request('growth_potential') && (!isset($job['growth_potential']) || !strlen($job['growth_potential']) || strtolower($job['growth_potential']) != strtolower(request('growth_potential')))) {
                $show = false;
            }
            if (request('work_environment') && (!isset($job['work_environment']) || !strlen($job['work_environment']) || strtolower($job['work_environment']) != strtolower(request('work_environment')))) {
                $show = false;
            }
            if ($show) $filtered[] = $job;
        }

        // Sort by computed_score if available, else by match_score desc
        usort($filtered, function($a, $b) {
            $aScore = isset($a['computed_score']) && $a['computed_score'] !== null ? $a['computed_score'] : floatval($a['match_score'] ?? 0);
            $bScore = isset($b['computed_score']) && $b['computed_score'] !== null ? $b['computed_score'] : floatval($b['match_score'] ?? 0);
            return $bScore <=> $aScore;
        });

        // Pagination logic (10 jobs per page)
        $page = max(1, intval(request('page', 1)));
        $perPage = 10;
        $total = count($filtered);
        $recommendations = array_slice($filtered, ($page - 1) * $perPage, $perPage);
        $lastPage = ceil($total / $perPage);
    @endphp

    <div class="container mx-auto mt-8 px-4 space-y-6">
        @if(empty($recommendations))
            <div class="bg-yellow-100 p-6 rounded-xl text-center text-gray-600">
                No job recommendations found. Please upload <b>data job posts.csv</b> to <b>public/</b> folder (or generate recommendations.json).
            </div>
        @else
            @foreach($recommendations as $idx => $job)
                <div class="bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">{{ $job['title'] ?: $job['job_description'] }}</h3>
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
                        <a href="{{ route('job.details', ['job_id' => ($page - 1) * $perPage + $idx]) }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            View Details
                        </a>
                        <form method="POST" action="{{ route('my.job.applications') }}">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ ($page - 1) * $perPage + $idx }}">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Saved</button>
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
@endsection
