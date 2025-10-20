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
                foreach ($decoded as $index => $row) {
                    // normalize keys coming from generate_recommendations.py which may use Title/Company vs title/company
                    $title = $row['title'] ?? $row['Title'] ?? $row['job_title'] ?? '';
                    $company = $row['company'] ?? $row['Company'] ?? '';
                    $job_description = $row['job_description'] ?? $row['JobDescription'] ?? $row['description'] ?? '';
                    $job_requirement = $row['job_requirement'] ?? $row['resume'] ?? $row['JobRequirment'] ?? $row['RequiredQual'] ?? '';
                    $location = $row['location'] ?? $row['Location'] ?? '';
                    $salary = $row['salary'] ?? $row['Salary'] ?? '';
                    $deadline = $row['deadline'] ?? $row['Deadline'] ?? '';
                    $announcement_code = $row['announcement_code'] ?? $row['AnnouncementCode'] ?? '';

                    $recommendations[] = [
                        'job_id' => isset($row['job_id']) ? intval($row['job_id']) : intval($index),
                        'title' => $title,
                        'company' => $company,
                        'job_description' => $job_description,
                        'job_requirement' => $job_requirement,
                        'resume' => $job_requirement,
                        'match_score' => $row['match_score'] ?? ($row['computed_score'] ?? 0),
                        'computed_score' => $row['computed_score'] ?? null,
                        'industry' => $row['industry'] ?? '',
                        'fit_level' => $row['fit_level'] ?? '',
                        'growth_potential' => $row['growth_potential'] ?? '',
                        'work_environment' => $row['work_environment'] ?? '',
                        'location' => $location,
                        'salary' => $salary,
                        'deadline' => $deadline,
                        'announcement_code' => $announcement_code,
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

                    $i = 0;
                    while (($row = fgetcsv($handle)) !== false) {
                        // create associative row by header
                        $assoc = array_combine($cols, $row) ?: [];
                        $textForInference = trim(($assoc['JobDescription'] ?? '') . ' ' . ($assoc['JobRequirment'] ?? '') . ' ' . ($assoc['jobpost'] ?? ''));
                        $inferred_fit = $infer_fit_level($textForInference);
                        $inferred_growth = $infer_growth_potential($textForInference);
                        $inferred_env = $infer_work_environment($textForInference);
                        $recommendations[] = [
                            'job_id' => $i,
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
                        $i++;
                    }
                    fclose($handle);
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

        // Finally, enforce guardian approval: only include jobs that are approved
        // If no approvals exist, show nothing to DS users (safe default). Guardians/admins can still view via guardian pages.
        $approvedFiltered = [];
        foreach ($filtered as $job) {
            if ($isJobApproved($job)) $approvedFiltered[] = $job;
        }
        $filtered = $approvedFiltered;

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
                @php $job_dom_id = 'job_'.$job['job_id'] ?? ('p'.($page - 1) * $perPage + $idx); @endphp
                <div id="{{ $job_dom_id }}" data-job-id="{{ $job['job_id'] ?? (($page - 1) * $perPage + $idx) }}" data-title="{{ e($job['title']) }}" data-company="{{ e($job['company']) }}" data-description="{{ e($job['job_description']) }}" data-location="{{ e($job['location']) }}" data-fit-level="{{ e($job['fit_level'] ?? '') }}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                    <div class="flex-1 pr-6">
                        <h3 class="text-lg font-bold">{{ $job['title'] ?: $job['job_description'] }}</h3>
                        <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">{{ intval($job['match_score'] ?? 0) }}% Match</span></div>
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
                let base = parseInt(card.querySelector('.js-match-badge')?.textContent || '0') || 0;
                // boost if job title/desc contains any job pref keyword
                let boost = 0;
                jobPrefs.forEach(p => { if (title.includes(p) || desc.includes(p)) boost += 15; });
                // boost for skill mention
                skills.forEach(s => { if (title.includes(s) || desc.includes(s)) boost += 8; });
                // boost for workplace match
                if (workplace && desc.includes(workplace)) boost += 10;
                // small boost for support choice matching some keywords
                if (support && desc.includes(support)) boost += 5;
                let final = Math.min(100, Math.max(0, base + boost));
                const badge = card.querySelector('.js-match-badge');
                if (badge) badge.textContent = final + '% Match';
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
    } catch(err) { console.debug('rescore aborted', err); }
})();
</script>
@endsection
