@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Hero Section -->
    <section class="bg-[#FCD34D] flex items-center justify-center py-16 px-6 sm:px-12 lg:px-20 rounded-b-3xl">
        <div class="flex flex-col lg:flex-row items-center justify-center text-center lg:text-left gap-10 max-w-5xl w-full">

            <div class="flex-shrink-0 flex justify-center">
                <img src="{{ asset('image/jobsicon.png') }}" alt="Job Search Icon" class="w-32 sm:w-40 lg:w-52">
            </div>

            <!-- Text Content -->
            <div class="flex flex-col items-center lg:items-start">
                <h1 class="text-5xl sm:text-4xl lg:text-5xl font-extrabold text-[#1E40AF] drop-shadow-md">
                    Job Recommended For You
                </h1>
                <p class="text-2xl text-gray-800 mt-4 italic font-medium">
                    (Mga Trabahong Para sa Iyo)
                </p>
            </div>

        </div>
    </section>

    <section class="max-w-6xl mx-auto mt-12 px-6">
        <!-- Title -->
        <h3
            class="text-5xl sm:text-4xl font-extrabold text-[#1E3A8A] mb-8 text-center tracking-wide flex items-center justify-center gap-3">
            <!-- <img src="https://img.icons8.com/ios-filled/50/1E3A8A/search--v1.png" alt="Search Icon" class="w-10 h-10"> -->
            Filter Jobs
        </h3>

                <!-- Instruction -->
        <div class="mt-12 bg-blue-50 border-l-8 border-blue-500 rounded-2xl p-6 text-center shadow-md">
            <p class="text-xl font-bold text-[#1E3A8A] mb-2 flex items-center justify-center gap-2">
                <img src="https://img.icons8.com/color/48/compass--v1.png" alt="Compass Icon" class="w-7 h-7">
                How to use the filter:
            </p>
            <p class="text-lg text-gray-800 font-medium leading-relaxed">
                Click the dropdowns above and choose what you like — the system will show jobs that match your choice.
            </p>
            <p class="text-base text-gray-600 italic mt-1">
                (Piliin ang mga opsyon sa itaas. Ipapakita ng system ang mga trabahong akma sa iyong pinili.)
            </p>
        </div>


        <!-- Filter Form -->
        <form method="GET" class="mt-8 w-full space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
                <!-- Filter Dropdown (Industry) -->
                {{-- <div class="relative w-full">
                    <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Industry</label>
                    <select name="industry"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200 pr-12">
                        <option value="">Select Industry</option>
                        <option value="Healthcare" {{ request('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare
                        </option>
                        <option value="Retail" {{ request('industry') == 'Retail' ? 'selected' : '' }}>Retail
                        </option>
                        <option value="Food Service" {{ request('industry') == 'Food Service' ? 'selected' : '' }}>Food
                            Service
                        </option>
                        <option value="Education" {{ request('education') == 'Education' ? 'selected' : '' }}>Education
                        </option>
                        <option value="Hospitality" {{ request('hospitality') == 'Hospitality' ? 'selected' : '' }}>
                            Hospitality
                        </option>
                        <option value="Manufacturing" {{ request('industry') == 'Manufacturing' ? 'selected' : '' }}>
                            Manufacturing
                        </option>
                        <option value="Transportation" {{ request('industry') == 'Transportation' ? 'selected' : '' }}>
                            Transportation
                        </option>
                        <option value="Cleaning" {{ request('industry') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                        <option value="Office" {{ request('office') == 'Office' ? 'selected' : '' }}>Office</option>
                        <option value="Construction" {{ request('industry') == 'Construction' ? 'selected' : '' }}>
                            Construction
                        </option>
                        <option value="Creative"{{ request('creative') == 'Creative' ? 'selected' : '' }}>Creative</option>
                        <option value="Packing" {{ request('industry') == 'Packing' ? 'selected' : '' }}>Packing</option>
                        <option value="Other" {{ request('other') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-blue-600 absolute right-5 top-[70%] transform -translate-y-1/2 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </div> --}}

                <!-- Job Fit Level -->
                {{-- <div class="relative w-full">
                    <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Job Fit Level</label>
                    <select name="fit_level" onchange="this.form.submit()"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200 pr-12">
                        <option value="">Select Level</option>
                        <option value="Excellent Fit" {{ request('fit_level') == 'Excellent Fit' ? 'selected' : '' }}>
                            Excellent Fit</option>
                        <option value="Good Fit" {{ request('fit_level') == 'Good Fit' ? 'selected' : '' }}>Good Fit
                        </option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-blue-600 absolute right-5 top-[70%] transform -translate-y-1/2 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </div> --}}

                <!-- Job Type -->
                <div class="relative w-full">
                    <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Job Type</label>
                    <select name="growth_potential" id="job-type"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200 pr-12">
                        <option value="">Select Job Type</option>
                        <option value="Full-Time"
                            {{ request('growth_potential') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                        <option value="Part-Time"
                            {{ request('growth_potential') == 'Part-Time' ? 'selected' : '' }}>Part-Time
                        </option>
                        <option value="Contract"
                            {{ request('growth_potential') == 'Contract' ? 'selected' : '' }}>Contract
                        </option>
                         <option value="Program"
                            {{ request('growth_potential') == 'Program' ? 'selected' : '' }}>Program
                        </option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-blue-600 absolute right-5 top-[70%] transform -translate-y-1/2 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Work Environment -->
                <div class="relative w-full">
                    <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Work Environment</label>
                    <select name="work_environment" id="work-env"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200 pr-12">
                        <option value="">Select Environment</option>
                        <option value="Friendly Team" {{ request('work_environment') == 'Friendly Team' ? 'selected' : '' }}>Friendly Team</option>
                        <option value="Buddy Helper" {{ request('work_environment') == 'Buddy Helper' ? 'selected' : '' }}>Buddy Helper</option>
                        <option value="Simple Instructions" {{ request('work_environment') == 'Simple Instructions' ? 'selected' : '' }}>Simple Instructions</option>
                        <option value="Safe and Light Work" {{ request('work_environment') == 'Safe and Light Work' ? 'selected' : '' }}>Safe and Light Work</option>
                        <option value="No Heavy Lifting/No Pharmacy Task" {{ request('work_environment') == 'No Heavy Lifting/No Pharmacy Task' ? 'selected' : '' }}>No Heavy Lifting/No Pharmacy Task</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-blue-600 absolute right-5 top-[70%] transform -translate-y-1/2 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Location (textbox) -->
                <div class="relative w-full">
                    <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Location</label>
                    <input
                        name="location"
                        id = "address-location"
                        type="text"
                        value="{{ request('location') }}"
                        placeholder="City or area (e.g. Taguig City)"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200"
                    />
                </div>

                <!-- Search Bar -->
                <div class="mt-4 relative w-full sm:col-span-2 md:col-span-3">
                <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Search Job Title</label>
                <div class="relative">
                    <!-- Give the input extra right padding so text never sits under the button -->
                    <input id="searchJobTitle" type="text" name="search" value="{{ request('search') }}" placeholder="Search by job title (e.g. Sales Assistant, Barista)"
                        class="w-full appearance-none px-6 pr-20 py-4 rounded-2xl bg-white border-4 border-blue-600 
                        text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 
                        focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200" />

                    <!-- Clickable search button positioned inside the input area -->
                    <button id="searchBtn" type="button" aria-label="Search"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center bg-white rounded-full text-blue-600 hover:bg-blue-50 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            </div>
        </form>

    <!-- Evaluation metrics: show Accuracy / Precision / Recall / F1 if available -->
    {{-- <section class="mx-6 sm:mx-12 lg:mx-20 mt-8">
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                <div class="text-sm text-gray-500">Accuracy</div>
                <div id="accuracyVal" class="mt-2 text-2xl font-bold text-gray-900">
                    {{ isset($display['accuracy']) && $display['accuracy'] !== null ? $display['accuracy'] . '%' : 'N/A' }}
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                <div class="text-sm text-gray-500">Precision</div>
                <div id="precisionVal" class="mt-2 text-2xl font-bold text-gray-900">
                    {{ isset($display['precision']) && $display['precision'] !== null ? $display['precision'] . '%' : 'N/A' }}
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                <div class="text-sm text-gray-500">Recall</div>
                <div id="recallVal" class="mt-2 text-2xl font-bold text-gray-900">
                    {{ isset($display['recall']) && $display['recall'] !== null ? $display['recall'] . '%' : 'N/A' }}
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                <div class="text-sm text-gray-500">F1 Score</div>
                <div id="f1Val" class="mt-2 text-2xl font-bold text-gray-900">
                    {{ isset($display['f1']) && $display['f1'] !== null ? $display['f1'] . '%' : 'N/A' }}
                </div>
            </div>
        </div>

        @if(empty($display['accuracy']) && empty($display['precision']) && empty($display['recall']) && empty($display['f1']))
            <p id="metricsHint" class="text-center text-sm text-gray-500 mt-4">No evaluation metrics found. Drop a file named <code>public/eval_metrics.json</code> with accuracy/precision/recall/f1 or counts (tp/tn/fp/fn) to display results.</p>
        @endif
    </section> --}}

        <!-- location filter removed per request -->
        <!-- Filter is automatic now: selects will submit the form on change -->
        <script>
            // Auto-submit filter selectors (robust): if selects are outside the form or rendered later,
            // this will read their values and navigate to the same route with updated query params.
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const selectNames = ['industry', 'fit_level', 'growth_potential', 'work_environment'];
                    const selects = [];
                    selectNames.forEach(name => document.querySelectorAll('select[name="' + name + '"]').forEach(s =>
                        selects.push(s)));
                    if (!selects.length) return;
                    let submitTimeout = null;
                    const applyFilters = () => {
                        const params = new URLSearchParams(window.location.search || '');
                        selectNames.forEach(name => {
                            const el = document.querySelector('select[name="' + name + '"]');
                            if (!el) return;
                            const v = el.value;
                            if (v === null || v === '') params.delete(name);
                            else params.set(name, v);
                        });
                        // reset to first page when filters change
                        params.set('page', '1');
                        const newUrl = window.location.pathname + (params.toString() ? ('?' + params.toString()) :
                            '');
                        // navigate
                        window.location.href = newUrl;
                    };
                    selects.forEach(s => s.addEventListener('change', function() {
                        if (submitTimeout) clearTimeout(submitTimeout);
                        submitTimeout = setTimeout(applyFilters, 120);
                    }));
                } catch (e) {
                    console.debug('filter auto-submit setup failed', e);
                }
            });
        </script>

    </section>
                <!-- Auto-fetch Oracle-backed recommendations (debug route uid=7).
                     Server-side attempt first for faster first paint / SEO; if that fails, fall back to client-side fetch. -->
                @php
                    // Obtain hybrid recommendations server-side for faster first paint.
                    $oracleRecs = null;
                    // Resolve a uid: prefer explicit query param, then auth, else default to 2 for local testing
                    $uid = request()->get('uid') ?: (auth()->check() ? auth()->id() : null);
                    if (!$uid) $uid = 2;

                    // 1) Try the internal debug HTTP route first
                    try {
                        $resp = \Illuminate\Support\Facades\Http::timeout(5)->get(url('/debug/oracle-recs') . '?uid=' . urlencode($uid) . '&top_n=12');
                        if ($resp->successful()) {
                            $oracleRecs = $resp->json();
                        }
                    } catch (\Throwable $e) {
                        $oracleRecs = null;
                    }

                    // 2) If that failed, try executing the runner script server-side to produce the same JSON
                    if (empty($oracleRecs)) {
                        try {
                            $runner = base_path('tools/run_oracle_recommender.php');
                            $cmd = PHP_BINARY . ' ' . escapeshellarg($runner) . ' uid=' . escapeshellarg($uid) . ' top_n=12';
                            $out = @shell_exec($cmd);
                            if ($out) {
                                $j = @json_decode($out, true);
                                if (is_array($j)) $oracleRecs = $j;
                            }
                        } catch (\Throwable $e) {
                            $oracleRecs = null;
                        }
                    }

                    // Prefer hybrid results only. Force the page to treat recommendations as a single blended list.
                    $hybridRecs = is_array($oracleRecs) ? ($oracleRecs['hybrid'] ?? []) : [];
                    $contentRecs = [];
                    $collabRecs = [];

                    // helper to resolve logo from multiple possible fields
                    $resolveLogo = function ($r) {
                        if (empty($r) || !is_array($r)) return null;
                        $candidates = ['logo','logo_url','company_logo','company_logo_url','image','company_logo_url_small'];
                        foreach ($candidates as $k) {
                            if (!empty($r[$k])) return $r[$k];
                        }
                        // nested company object
                        if (isset($r['company']) && is_array($r['company']) && !empty($r['company']['logo'])) return $r['company']['logo'];
                        // sometimes company metadata is flattened
                        if (!empty($r['company_logo_small'])) return $r['company_logo_small'];
                        return null;
                    };

                    // helper to render skill / tag chips (server-side fallback for client renderTags)
                    $renderTags = function ($skills) {
                        $arr = [];
                        if (is_array($skills)) {
                            $arr = $skills;
                        } else {
                            $txt = is_string($skills) ? $skills : '';
                            // split on comma, pipe, semicolon
                            $parts = preg_split('/[,\|;]+/', $txt);
                            $arr = array_filter(array_map('trim', $parts));
                        }
                        $out = '';
                        foreach ($arr as $t) {
                            if ($t === '') continue;
                            $safe = e($t);
                            $out .= "<span class=\"bg-blue-100 text-blue-700 text-lg font-semibold px-5 py-2 rounded-md\">{$safe}</span> ";
                        }
                        return $out;
                    };
                @endphp

                <div id="client-job-list" class="mt-6 space-y-4">
                    @if (!empty($hybridRecs) && is_array($hybridRecs) && count($hybridRecs) > 0)
                        @foreach ($hybridRecs as $idx => $r)
                            @php
                                if ($idx >= 12) { $hide = 'hidden rec-hidden rec-content'; } else { $hide = ''; }
                                $title = e($r['title'] ?? $r['job_title'] ?? $r['Title'] ?? 'Untitled');
                                $companyName = e($r['company'] ?? $r['company_name'] ?? $r['Company'] ?? '');
                                $location = e($r['location'] ?? $r['city'] ?? $r['CITY'] ?? '');
                                $desc = e(substr($r['description'] ?? $r['job_description'] ?? '', 0, 400));
                                $skills = $r['required_skills'] ?? $r['skills'] ?? '';
                                $logoUrl = $resolveLogo($r);
                            @endphp

                            <div class="relative bg-white border-2 border-blue-200 rounded-3xl shadow-lg p-10 mb-6 transition-transform hover:scale-[1.02] {{ $hide }}">
                                <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
                                    <div class="flex items-start gap-6">
                                        <div class="flex items-center gap-4">
                                            <button class="flag-btn text-gray-400 text-5xl focus:outline-none hover:text-red-500 transition-all duration-300"><i class="ri-flag-line"></i></button>
                                            <div class="flex-shrink-0">
                                                @if ($logoUrl)
                                                    <img src="{{ $logoUrl }}" alt="Company Logo" class="w-32 h-32 rounded-2xl border-4 border-gray-300 object-cover" />
                                                @else
                                                    <div class="w-32 h-32 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                                                        <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <h3 class="font-bold text-3xl text-gray-900">{!! $title !!}</h3>
                                            <p class="text-gray-700 text-2xl font-medium mt-2">{!! $companyName !!}</p>
                                            <p class="text-gray-600 text-lg mt-1 flex items-center gap-2">@if($location)<img src="https://img.icons8.com/color/48/marker--v1.png" class="w-6 h-6"/> <span>{!! $location !!}</span>@endif</p>

                                            <div class="flex flex-wrap gap-3 mt-3">@php echo $renderTags($skills); @endphp</div>
                                        </div>
                                    </div>

                                    <a href="/whythisjob?job_id={{ urlencode($r['id'] ?? $r['job_id'] ?? $r['ID'] ?? '') }}" class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">Why this job matches you?</a>
                                </div>

                                <p class="text-gray-700 text-xl mt-8 leading-relaxed max-w-4xl">{!! $desc !!}</p>

                                <div class="flex flex-wrap gap-3 mt-6">@php echo $renderTags($skills); @endphp</div>

                                <div class="flex flex-wrap gap-3 mt-8">
                                    <span class="border border-[#2563EB] text-[#2563EB] text-lg px-5 py-2 rounded-md font-semibold">Full-Time</span>
                                    <span class="border border-[#88BF02] text-[#88BF02] text-lg px-5 py-2 rounded-md font-semibold">Full Support</span>
                                    <span class="border border-[#F89596] text-[#F89596] text-lg px-5 py-2 rounded-md font-semibold">Excellent Fit</span>
                                </div>

                                <div class="flex justify-end mt-10">
                                    <button class="bg-[#FFAC1D] text-white text-lg font-bold rounded-md px-10 py-3 w-[480px] hover:bg-[#D78203] transition text-center">Apply for Therapist Job Readiness Assessment</button>
                                </div>

                                <div class="flex justify-end flex-wrap gap-4 mt-4">
                                    <a href="/job-details?job_id={{ urlencode($r['id'] ?? $r['job_id'] ?? $r['ID'] ?? '') }}" class="px-10 py-3 inline-flex items-center justify-center bg-[#55BEBB] text-white text-lg font-bold rounded-md w-[150px] hover:bg-[#47a4a1] transition">Details</a>
                                    <a href="/job-application-1?job_id={{ urlencode($r['id'] ?? $r['job_id'] ?? $r['ID'] ?? '') }}" class="px-10 py-3 inline-flex items-center justify-center bg-[#2563EB] text-white text-lg font-bold rounded-md w-[150px] hover:bg-[#1e4fc5] transition">Apply</a>
                                    <button onclick="saveJob('{{ $r['id'] ?? $r['job_id'] ?? $r['ID'] ?? '' }}', this)" class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">Save</button>
                                </div>
                            </div>
                        @endforeach

                        @if (count($hybridRecs) > 12)
                            <div class="text-center mb-6">
                                <button id="show-more-content" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-md border">Show more</button>
                            </div>
                        @endif
                        @else
                            {{-- <p class="text-sm text-gray-500 mb-6">No hybrid recommendations available.</p> --}}
                        @endif

                    {{-- Collaborative section removed — page now shows only Hybrid results --}}
                </div>

                <script>
                    // Show-more buttons: reveal hidden recs in each section
                    document.addEventListener('DOMContentLoaded', function() {
                        const showMoreContent = document.getElementById('show-more-content');
                        if (showMoreContent) {
                            showMoreContent.addEventListener('click', function() {
                                document.querySelectorAll('.rec-hidden.rec-content').forEach(el => el.classList.remove('hidden'));
                                showMoreContent.style.display = 'none';
                            });
                        }
                        const showMoreCollab = document.getElementById('show-more-collab');
                        if (showMoreCollab) {
                            showMoreCollab.addEventListener('click', function() {
                                document.querySelectorAll('.rec-hidden.rec-collab').forEach(el => el.classList.remove('hidden'));
                                showMoreCollab.style.display = 'none';
                            });
                        }
                    });
                </script>

                {{-- Client-side fallback: only run if server-side fetch didn't produce results --}}
                @if (empty($oracleRecs))
                    <script>
                        (function() {
                            try {
                                const key = 'auto_oracle_recs_triggered_' + window.location.pathname;
                                if (sessionStorage.getItem(key)) return;
                                sessionStorage.setItem(key, '1');
                                if (!window.__SERVER_AUTH && !(location.hostname === 'localhost' || location.hostname === '127.0.0.1')) return;
                                const listEl = document.getElementById('client-job-list');
                                const statusEl = document.getElementById('btn-generate-status');
                                if (statusEl) statusEl.textContent = 'Auto-generating recommendations...';

                                fetch('{{ url('/debug/oracle-recs') }}?uid=7')
                                    .then(async r => {
                                        if (!r.ok) throw new Error('HTTP ' + r.status);
                                        return r.json();
                                    })
                                    .then(data => { /* If server-side failed, it's okay to re-use client rendering as a fallback. */
                                        if (!data) return;
                                        // reload page if server-side failed but client succeeded to get faster paint next time
                                        try { location.reload(); } catch (e) {}
                                    })
                                    .catch(err => {
                                        console.debug('oracle recs client fallback failed', err);
                                        if (statusEl) statusEl.textContent = 'Auto-generation failed: ' + String(err);
                                    });
                            } catch (e) { console.debug('fallback error', e); }
                        })();
                    </script>
                @endif
            </div>
                    </svg>
                </div>
            </div>
        </form>

        <!-- Instruction 
        <div class="mt-12 bg-blue-50 border-l-8 border-blue-500 rounded-2xl p-6 text-center shadow-md">
            <p class="text-xl font-bold text-[#1E3A8A] mb-2 flex items-center justify-center gap-2">
                <img src="https://img.icons8.com/color/48/compass--v1.png" alt="Compass Icon" class="w-7 h-7">
                How to use the filter:
            </p>
            <p class="text-lg text-gray-800 font-medium leading-relaxed">
                Click the dropdowns above and choose what you like — the system will show jobs that match your choice.
            </p>
            <p class="text-base text-gray-600 italic mt-1">
                (Piliin ang mga opsyon sa itaas. Ipapakita ng system ang mga trabahong akma sa iyong pinili.)
            </p>
        </div> -->

        <!-- location filter removed per request -->
        <!-- Filter is automatic now: selects will submit the form on change -->
        <script>
            // Auto-submit filter selectors (robust): if selects are outside the form or rendered later,
            // this will read their values and navigate to the same route with updated query params.
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const selectNames = ['industry', 'fit_level', 'growth_potential', 'work_environment'];
                    const selects = [];
                    selectNames.forEach(name => document.querySelectorAll('select[name="' + name + '"]').forEach(s =>
                        selects.push(s)));
                    if (!selects.length) return;
                    let submitTimeout = null;
                    const applyFilters = () => {
                        const params = new URLSearchParams(window.location.search || '');
                        selectNames.forEach(name => {
                            const el = document.querySelector('select[name="' + name + '"]');
                            if (!el) return;
                            const v = el.value;
                            if (v === null || v === '') params.delete(name);
                            else params.set(name, v);
                        });
                        // reset to first page when filters change
                        params.set('page', '1');
                        const newUrl = window.location.pathname + (params.toString() ? ('?' + params.toString()) :
                            '');
                        // navigate
                        window.location.href = newUrl;
                    };
                    selects.forEach(s => s.addEventListener('change', function() {
                        if (submitTimeout) clearTimeout(submitTimeout);
                        submitTimeout = setTimeout(applyFilters, 120);
                    }));
                } catch (e) {
                    console.debug('filter auto-submit setup failed', e);
                }
            });
        </script>

    </section>

    <!-- Match Notice -->
    <!--
                                    <div class="container mx-auto mt-6 px-4">
                                        <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg">
                                            <p class="text-gray-800 font-medium flex items-center">
                                                💡 These jobs match your skills and preferences!
                                            </p>
                                            <p class="italic text-sm text-gray-600">(Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan!)</p>
                                        </div>
                                -->

    @php
        // Try to load evaluation metrics from public/eval_metrics.json
        $evalPath = public_path('eval_metrics.json');
        $eval = [];
        if (file_exists($evalPath)) {
            $eval = json_decode(@file_get_contents($evalPath), true) ?: [];
        }

        // Normalize common metric keys and/or compute from counts when available
        $metrics = [
            'accuracy' => null,
            'precision' => null,
            'recall' => null,
            'f1' => null,
        ];

        // If file already contains metrics directly, prefer them
        foreach (['accuracy', 'precision', 'recall', 'f1', 'f1_score'] as $k) {
            if (isset($eval[$k])) {
                $normalized = $eval[$k];
                if (is_numeric($normalized)) {
                    $metrics[$k === 'f1_score' ? 'f1' : $k] = floatval($normalized);
                }
            }
        }

        // Accept some alternate key names
        if (isset($eval['F1'])) {
            $metrics['f1'] = is_numeric($eval['F1']) ? floatval($eval['F1']) : $metrics['f1'];
        }
        if (isset($eval['Precision'])) {
            $metrics['precision'] = is_numeric($eval['Precision'])
                ? floatval($eval['Precision'])
                : $metrics['precision'];
        }
        if (isset($eval['Recall'])) {
            $metrics['recall'] = is_numeric($eval['Recall']) ? floatval($eval['Recall']) : $metrics['recall'];
        }
        if (isset($eval['Accuracy'])) {
            $metrics['accuracy'] = is_numeric($eval['Accuracy']) ? floatval($eval['Accuracy']) : $metrics['accuracy'];
        }

        // Handle a common format where eval_metrics.json contains a `metrics` array (per-model)
        $perModelMetrics = [];
        if (isset($eval['metrics']) && is_array($eval['metrics']) && count($eval['metrics']) > 0) {
            foreach ($eval['metrics'] as $m) {
                if (!is_array($m)) {
                    continue;
                }
                $modelName = $m['model'] ?? ($m['name'] ?? 'model');
                $a = isset($m['accuracy']) && is_numeric($m['accuracy']) ? floatval($m['accuracy']) : null;
                $p = isset($m['precision']) && is_numeric($m['precision']) ? floatval($m['precision']) : null;
                $r = isset($m['recall']) && is_numeric($m['recall']) ? floatval($m['recall']) : null;
                $f = null;
                if (isset($m['f1']) && is_numeric($m['f1'])) {
                    $f = floatval($m['f1']);
                }
                if ($f === null && isset($m['f1_score']) && is_numeric($m['f1_score'])) {
                    $f = floatval($m['f1_score']);
                }
                // convert fractional to percent for display later
                $convert = function ($v) {
                    if ($v === null) {
                        return null;
                    }
                    $n = floatval($v);
                    return $n > 0 && $n <= 1.01 ? $n * 100.0 : $n;
                };
                $perModelMetrics[] = [
                    'model' => (string) $modelName,
                    'accuracy' => is_numeric($a) ? round($convert($a), 2) : null,
                    'precision' => is_numeric($p) ? round($convert($p), 2) : null,
                    'recall' => is_numeric($r) ? round($convert($r), 2) : null,
                    'f1' => is_numeric($f) ? round($convert($f), 2) : null,
                ];
            }
        }

        // If no explicit hybrid model exists, compute a simple hybrid (mean across models)
        $hasHybrid = false;
        foreach ($perModelMetrics as $m) {
            if (isset($m['model']) && strtolower($m['model']) === 'hybrid') {
                $hasHybrid = true;
                break;
            }
        }
        if (!$hasHybrid && count($perModelMetrics) > 0) {
            $sum = ['accuracy' => 0.0, 'precision' => 0.0, 'recall' => 0.0, 'f1' => 0.0];
            $cnt = ['accuracy' => 0, 'precision' => 0, 'recall' => 0, 'f1' => 0];
            foreach ($perModelMetrics as $m) {
                foreach (['accuracy', 'precision', 'recall', 'f1'] as $k) {
                    if (isset($m[$k]) && is_numeric($m[$k])) {
                        $sum[$k] += floatval($m[$k]);
                        $cnt[$k]++;
                    }
                }
            }
            $hybrid = ['model' => 'hybrid'];
            $any = false;
            foreach (['accuracy', 'precision', 'recall', 'f1'] as $k) {
                if ($cnt[$k] > 0) {
                    $hybrid[$k] = round($sum[$k] / $cnt[$k], 2);
                    $any = true;
                } else {
                    $hybrid[$k] = null;
                }
            }
            if ($any) {
                // prepend hybrid so it appears first
                array_unshift($perModelMetrics, $hybrid);
            }
        }

        // Compute a context-aware metric if not present: weighted blend of known models
        $hasContext = false;
        foreach ($perModelMetrics as $m) {
            if (isset($m['model']) && strtolower($m['model']) === 'context_aware') {
                $hasContext = true;
                break;
            }
        }
        if (!$hasContext && count($perModelMetrics) > 0) {
            // default weights (adjustable): favor collaborative signals slightly
            $weightsMap = [
                'content_based' => 0.3,
                'user_cf' => 0.4,
                'item_cf' => 0.3,
            ];
            $sumMetrics = ['accuracy' => 0.0, 'precision' => 0.0, 'recall' => 0.0, 'f1' => 0.0];
            $sumWeights = ['accuracy' => 0.0, 'precision' => 0.0, 'recall' => 0.0, 'f1' => 0.0];
            foreach ($perModelMetrics as $m) {
                $modelKey = strtolower($m['model'] ?? '');
                $w = $weightsMap[$modelKey] ?? 0.0;
                foreach (['accuracy', 'precision', 'recall', 'f1'] as $k) {
                    if ($w > 0 && isset($m[$k]) && is_numeric($m[$k])) {
                        $sumMetrics[$k] += floatval($m[$k]) * $w;
                        $sumWeights[$k] += $w;
                    }
                }
            }
            $ctx = ['model' => 'context_aware'];
            $anyCtx = false;
            foreach (['accuracy', 'precision', 'recall', 'f1'] as $k) {
                if ($sumWeights[$k] > 0) {
                    $ctx[$k] = round($sumMetrics[$k] / $sumWeights[$k], 2);
                    $anyCtx = true;
                } else {
                    $ctx[$k] = null;
                }
            }
            if ($anyCtx) {
                // put context-aware first so it's visible
                array_unshift($perModelMetrics, $ctx);
            }
        }
// If counts are provided, compute metrics: accept many variants for keys
$getCount = function ($keys) use ($eval) {
    foreach ((array) $keys as $k) {
        if (isset($eval[$k]) && is_numeric($eval[$k])) {
            return floatval($eval[$k]);
        }
    }
    // nested counts object
    if (isset($eval['counts']) && is_array($eval['counts'])) {
        foreach ((array) $keys as $k) {
            if (isset($eval['counts'][$k]) && is_numeric($eval['counts'][$k])) {
                return floatval($eval['counts'][$k]);
            }
        }
    }
    return null;
};

$tp = $getCount(['tp', 'TP', 'true_positive', 'truePositives', 'true_positive_count']);
$tn = $getCount(['tn', 'TN', 'true_negative', 'trueNegatives', 'true_negative_count']);
$fp = $getCount(['fp', 'FP', 'false_positive', 'falsePositives', 'false_positive_count']);
$fn = $getCount(['fn', 'FN', 'false_negative', 'falseNegatives', 'false_negative_count']);

if (
    ($metrics['precision'] === null ||
        $metrics['recall'] === null ||
        $metrics['f1'] === null ||
        $metrics['accuracy'] === null) &&
    ($tp !== null || $tn !== null || $fp !== null || $fn !== null)
) {
    // compute where possible
    if ($tp !== null && $fp !== null) {
        $metrics['precision'] = $tp + $fp > 0 ? $tp / ($tp + $fp) : 0.0;
    }
    if ($tp !== null && $fn !== null) {
        $metrics['recall'] = $tp + $fn > 0 ? $tp / ($tp + $fn) : 0.0;
    }
    if ($metrics['precision'] !== null && $metrics['recall'] !== null) {
        $p = $metrics['precision'];
        $r = $metrics['recall'];
        $metrics['f1'] = $p + $r > 0 ? (2 * $p * $r) / ($p + $r) : 0.0;
    }
    if ($tp !== null && $tn !== null && $fp !== null && $fn !== null) {
        $metrics['accuracy'] = ($tp + $tn) / max(1, $tp + $tn + $fp + $fn);
    }
}

// Convert to percentages for display if values look fractional (0-1)
$display = [];
foreach (['accuracy', 'precision', 'recall', 'f1'] as $k) {
            $v = $metrics[$k];
            if ($v === null) {
                $display[$k] = null;
                continue;
            }
            if (is_numeric($v)) {
                $num = floatval($v);
                if ($num > 0 && $num <= 1.01) {
                    $num = $num * 100.0;
                }
                $display[$k] = round($num, 2);
            } else {
                $display[$k] = null;
            }
        }
    @endphp

    <!-- Evaluation metrics block removed to avoid Blade parsing issues (was wrapped in a Blade comment containing Blade directives). Re-enable carefully if needed. -->


    <!-- Therapist Assessment Notice 
    <section
        class="bg-gradient-to-r from-[#FFEDD5] to-[#FEF3C7] mx-6 sm:mx-12 lg:mx-20 rounded-2xl p-8 mt-8 shadow-lg border-l-8 border-[#F59E0B]">
        <div class="flex items-start gap-6">

            <div
                class="flex items-center justify-center bg-white w-20 h-20 rounded-full shadow-md border-4 border-[#FBBF24] overflow-hidden">
                <img src="https://img.icons8.com/color/96/medical-doctor.png" alt="Therapist Icon"
                    class="w-12 h-12 object-contain">
            </div>

            <div class="text-gray-800">
                <h2 class="text-2xl font-bold text-[#92400E]">Therapist Job Readiness Assessment Required</h2>
                <p class="text-lg mt-2 leading-relaxed">
                    Before you can apply for a job, you first need to complete a
                    <span class="font-semibold text-[#B45309]">Therapist Assessment</span>.
                    This helps our therapists understand your readiness, comfort level,
                    and strengths for your chosen job. It ensures that every opportunity
                    is the right fit — so you can work with confidence and joy.
                </p>
                <p class="text-base italic text-gray-700 mt-2">
                    (Bago mag-apply sa trabaho, kailangan munang dumaan sa pagsusuri ng therapist
                    upang malaman kung ikaw ay handa na at akma sa trabahong gusto mo.)
                </p>
            </div>
        </div>
    </section> -->

    <!-- Job Match Notice -->
    <section class="bg-[#10B981] text-white mx-6 sm:mx-12 lg:mx-20 rounded-2xl p-8 mt-8 shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

            <div class="flex items-center gap-3 text-center sm:text-left">
                <div
                    class="flex items-center justify-center bg-white w-12 h-12 rounded-full shadow-md border-4 border-[#0EA5E9] overflow-hidden">
                    <img src="image/bulb.png" alt="Bulb Icon" class="w-8 h-8 object-contain">
                </div>

                <div>
                    <p class="text-2xl font-bold">Jobs Matched to Your Skills & Preferences</p>
                    <p class="text-base italic mt-1">
                        (Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan!)
                    </p>
                </div>
            </div>
            <div
                class="inline-flex items-center gap-2 rounded-full px-6 py-2 text-lg font-semibold text-white border-2 border-white bg-[#10B981]">
                <img src="https://img.icons8.com/emoji/48/star-emoji.png" alt="Star icon" class="w-7 h-7" />

                <!-- Text -->
                <span id='all-matches'>All Matches (🔃)</span>
            </div>
    </section>

    <!-- Recommended Job Section -->
            <section class="bg-[#E8F3FF] px-14 sm:px-12 lg:px-20 py-12 rounded-none">
                <h2 class="text-3xl font-bold text-[#1E3A8A] mb-2">Recommended Job</h2>
                <p class="text-gray-600 mb-6 text-lg">
                    Recommended companies based on application history, preferences, and recent platform activity.
              </p>
       <!--Job Card -->
       <div id="job-container" class="space-y-10"></div>

       <style>
       /* Saved button styling: gray background and disable hover change */
       .save-btn.saved {
           background-color: #9CA3AF !important; /* tailwind gray-400 */
           color: #ffffff !important;
           border-color: #9CA3AF !important;
           cursor: default !important;
       }
       .save-btn.saved:hover {
           background-color: #9CA3AF !important;
       }
       .save-btn.saved:disabled {
           opacity: 1 !important;
       }
       </style>
<script>
// Expose Laravel-authenticated user id to client JS (null when not authenticated)
window.LARAVEL_USER_ID = @json(auth()->check() ? auth()->id() : null);

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Function to load jobs based on current filters
function loadJobs() {
    const data = {
        // prefer server-side authenticated id when available (immediate after register/login)
        user_id: (typeof window !== 'undefined' && window.LARAVEL_USER_ID) ? String(window.LARAVEL_USER_ID) : localStorage.getItem('user_id'),
        title: document.getElementById('searchJobTitle').value.trim(),
        location: document.getElementById('address-location').value.trim(),
        work_environment: document.getElementById('work-env').value.trim(),
        job_type: document.querySelector('select[name="growth_potential"]').value
    };

    fetch('/db/get-jobs.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        const container = document.getElementById('job-container');
        const count_matches = document.getElementById('all-matches');
        container.innerHTML = '';

        if (!result.success || !result.jobs.length) {
            count_matches.innerHTML = 'All Matches (0)';
            container.innerHTML = '<p class="text-center text-3xl text-gray-600">No job postings available at the moment.</p>';
            return;
        }

        count_matches.innerHTML = 'All Matches (' + result.jobs.length + ')';

        // Ensure we have an up-to-date list of the requesting user's applications
        // so that client-side `user_applied` reflects deletions made elsewhere.
        const userIdForApps = (typeof window !== 'undefined' && window.LARAVEL_USER_ID) ? String(window.LARAVEL_USER_ID) : localStorage.getItem('user_id');
        const appliedSet = new Set();
        const fetchApps = userIdForApps ? fetch('/db/get-applications.php?guardian_id=' + encodeURIComponent(userIdForApps), { credentials: 'same-origin' }).then(r => r.json()).then(j => {
            if (j && j.success && Array.isArray(j.applications)) {
                j.applications.forEach(a => { if (a.job_posting_id) appliedSet.add(String(a.job_posting_id)); });
            }
        }).catch(() => {/* ignore */}) : Promise.resolve();

        fetchApps.then(() => {
            result.jobs.forEach(job => {
                // override job.user_applied from fresh applications data (clear when not present)
                try { job.user_applied = appliedSet.has(String(job.id)); } catch (e) { /* ignore */ }
                
            const progress = job.openings > 0 ? (job.applied / job.openings) * 100 : 0;
            // determine whether Apply should be disabled
            const now = new Date();
            let applyBefore = null;
            try { if (job.apply_before) applyBefore = new Date(job.apply_before); } catch (e) { applyBefore = null; }
            const isPastDeadline = applyBefore instanceof Date && !isNaN(applyBefore) && applyBefore.getTime() < now.getTime();
            const openingsNum = job.openings ? Number(job.openings) : 0;
            const appliedNum = job.applied ? Number(job.applied) : 0;
            // Disable Apply only when the requesting user already applied for this job.
            const userApplied = !!job.user_applied;
            const applyDisabled = userApplied;
            const applyBtnClass = applyDisabled ? 'bg-gray-400 text-white text-xl font-bold rounded-md px-10 py-4 cursor-not-allowed transition' : 'bg-[#2563EB] text-white text-xl font-bold rounded-md px-10 py-4 hover:bg-[#1e4fc5] transition';
            const applyBtnAttr = applyDisabled ? 'disabled' : `onclick="location.href='/job-application-1?job_id=${encodeURIComponent(job.id)}'"`;
            const applyBtnText = applyDisabled ? '🚫 Applied' : '🚀 Apply Now';

            const cardHTML = `
            <div data-job-id="${job.id}" class="bg-white border-4 border-blue-300 rounded-3xl shadow-xl p-10 mb-10 max-w-[90rem] mx-auto hover:shadow-2xl transition-all duration-300">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-10">
                    <div class="flex items-start gap-6">
                        <div class="w-36 h-36 rounded-3xl border-4 border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden">
                            <img src="${escapeHtml(job.logo)}" alt="${escapeHtml(job.company_name)} logo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h2 class="text-4xl font-extrabold text-gray-900 mb-2">${escapeHtml(job.job_role)}</h2>
                            <p class="text-2xl text-gray-800 font-semibold mb-2">${escapeHtml(job.company_name)}</p>
                            <p class="flex items-center text-xl text-gray-700 gap-2">
                                <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location" class="w-6 h-6">
                                ${escapeHtml(job.address)}
                            </p>
                        </div>
                    </div>
                <a href="/whythisjob?job_id=${encodeURIComponent(job.id)}" class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">Why this job matches you?</a>
                </div>

                <hr class="my-8 border-gray-300">

                <div>
                    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4">Job Description</h3>
                    <p class="text-gray-800 text-2xl leading-relaxed max-w-6xl">
                        ${escapeHtml(job.description).replace(/\n/g, '<br>')}
                    </p>
                </div>

                ${job.skills && job.skills.length > 0 ? `
                <div class="mt-8">
                    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4">Required Skills</h3>
                    <div class="flex flex-wrap gap-4">
                        ${job.skills.map(skill => `<span class="bg-blue-200 text-blue-900 text-lg font-semibold px-5 py-2 rounded-full">${escapeHtml(skill)}</span>`).join('')}
                    </div>
                </div>` : ''}

                <div class="mt-8">
                    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4">Job Type</h3>
                    <div class="flex flex-wrap gap-4">
                        <span class="border-2 border-[#2563EB] text-[#2563EB] text-lg px-6 py-2 rounded-md font-bold bg-blue-50">
                            ${escapeHtml(job.job_type)}
                        </span>
                    </div>
                </div>

                <div class="mt-10 w-full">
                    <p class="text-xl font-semibold text-gray-800 mb-2 text-center">Number of Applicants</p>
                    <div class="h-5 bg-gray-200 rounded-md overflow-hidden">
                        <div class="h-full bg-[#88BF02]" style="width: ${progress}%;"></div>
                    </div>
                    <p class="text-lg text-gray-700 mt-2 text-center">
                        <strong>${job.applied} applied</strong> out of ${job.openings} openings
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-6 mt-10">
                    <button onclick="location.href='/job-details?job_id=${encodeURIComponent(job.id)}'" class="bg-[#55BEBB] text-white text-xl font-bold rounded-md px-10 py-4 hover:bg-[#47a4a1] transition">
                        📝 See Details
                    </button>
                    <button ${applyBtnAttr} class="${applyBtnClass}" title="${applyDisabled ? 'You already applied' : 'Apply for this job'}">
                        ${applyBtnText}
                    </button>
                    <button onclick="saveJob('${job.id}', this)" class="bg-[#008000] save-btn text-white text-xl font-bold rounded-md px-10 py-4 hover:bg-[#006400] transition" data-job-id="${job.id}">
                        💾 Save
                    </button>
                </div>
            </div>`;
            container.innerHTML += cardHTML;
        });
        });

        //loadSavedState();

        // Fetch saved jobs after rendering so saved state persists across reloads
        fetch('/db/saved-jobs.php', {
            method: 'GET',
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        }).then(r => r.json()).then(j => {
            if (j && j.success && Array.isArray(j.saved)) {
                const savedSet = new Set(j.saved.map(s => String(s.job_id)));
                savedSet.forEach(jid => {
                    // target the save button directly (it carries the data-job-id)
                    const saveBtn = document.querySelector('.save-btn[data-job-id="' + jid + '"]');
                    if (!saveBtn) return;
                    try {
                        saveBtn.disabled = true;
                        saveBtn.innerText = 'Saved';
                        saveBtn.classList.add('saved');
                        const parent = saveBtn.closest('[data-job-id]');
                        if (parent) parent.dataset.saved = '1';
                    } catch (e) { /* ignore DOM update errors */ }
                });
            }
        }).catch(err => {
            console.debug('Could not fetch saved jobs', err);
        });

        // Update evaluation metrics in the DOM if returned by the API
        try {
            const em = result.eval_metrics || result.evalMetrics || null;
            if (em) {
                const fmt = (v) => {
                    if (v === null || v === undefined) return 'N/A';
                    const n = Number(v);
                    if (isNaN(n)) return 'N/A';
                    const pct = (n > 0 && n <= 1.01) ? (n * 100) : n;
                    return Math.round(pct * 100) / 100 + '%';
                };
                const accEl = document.getElementById('accuracyVal');
                const precEl = document.getElementById('precisionVal');
                const recEl = document.getElementById('recallVal');
                const f1El = document.getElementById('f1Val');
                if (accEl) accEl.textContent = fmt(em.accuracy);
                if (precEl) precEl.textContent = fmt(em.precision);
                if (recEl) recEl.textContent = fmt(em.recall);
                if (f1El) f1El.textContent = fmt(em.f1);
                // hide the hint if any metric is present
                const hint = document.getElementById('metricsHint');
                if (hint) {
                    const any = (em.accuracy !== null && em.accuracy !== undefined) || (em.precision !== null && em.precision !== undefined) || (em.recall !== null && em.recall !== undefined) || (em.f1 !== null && em.f1 !== undefined);
                    hint.style.display = any ? 'none' : '';
                }
            }
        } catch (e) {
            console.debug('Error updating metrics', e);
        }
    })
    .catch(err => {
    debugger;
        console.error('Error loading jobs:', err);
        document.getElementById('job-container').innerHTML = '<p class="text-center text-red-600 text-2xl">Failed to load jobs. Please try again later.</p>';
    });
}

// Load jobs on page load
document.addEventListener('DOMContentLoaded', () => loadJobs());

// Save a job for later (calls public/db/save-job.php). Expects server session auth.
function saveJob(jobId, btn) {
    if (!jobId) return alert('Missing job id');
    const el = btn || document.querySelector('[data-job-id="' + jobId + '"] .save-btn') || null;
    try { if (el) el.disabled = true; } catch(e){}
    const body = { job_id: String(jobId) };
    fetch('/db/save-job.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
    }).then(r => r.json()).then(j => {
        if (!j) throw new Error('No response');
        if (j.success) {
            if (el) {
                try {
                    el.disabled = true;
                    el.innerText = 'Saved';
                    el.classList.add('saved');
                    // mark parent container for easy lookup
                    const parent = el.closest('[data-job-id]');
                    if (parent) parent.dataset.saved = '1';
                } catch (e) { /* ignore UI update errors */ }
            }
            return;
        }
        // handle unauthenticated
        if (j.message && (j.message === 'Not authenticated (missing session user_id)' || j.error === 'Not authenticated')) {
            window.location.href = '/login';
            return;
        }
        alert('Failed to save job: ' + (j.message || JSON.stringify(j)));
        if (el) el.disabled = false;
    }).catch(err => {
        console.error('saveJob error', err);
        alert('Failed to save job. Try again.');
        if (el) el.disabled = false;
    });
}

// Search on Enter key press for text inputs
['searchJobTitle', 'address-location'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                loadJobs();
            }
        });
    }
});

// Search on Job Type / Work Environment change or button click
document.getElementById('searchBtn')?.addEventListener('click', loadJobs);
document.getElementById('work-env')?.addEventListener('change', loadJobs);
document.querySelector('select[name="growth_potential"]')?.addEventListener('change', loadJobs);
</script>

        <!-- Instruction Section Wrapper -->
        <div class="mt-8 space-y-8">

            <!-- Apply Button Instruction -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-3xl border-l-8 border-[#2563EB] p-8 shadow-lg">
                <div class="flex items-start gap-4">

                    <div
    class="flex items-center justify-center bg-white w-16 h-16 rounded-full shadow-md border-4 border-[#2563EB] overflow-hidden">
    <img src="https://img.icons8.com/color/96/resume.png" alt="Application Icon"
        class="w-10 h-10 object-contain">
</div>

                    <div>
                         <p class="text-xl text-gray-900 font-semibold leading-snug">
                            Click the <span class="text-[#2563EB] font-bold">“Apply”</span> button to apply for 
                            the job.
                        </p>
                        <p class="text-base text-gray-700 italic mt-2">
                            (Pindutin ang <span class="font-semibold text-[#2563EB]">“Apply”</span> upang mag apply sa trabaho.)
                    </div>
                </div>
            </div>

            <!-- Details Instruction -->
            <div
                class="bg-gradient-to-r from-[#E0F7F6] to-[#C6F0EF] rounded-3xl border-l-8 border-[#55BEBB] p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div
                        class="flex items-center justify-center bg-white w-16 h-16 rounded-full shadow-md border-4 border-[#55BEBB] overflow-hidden">
                        <img src="https://img.icons8.com/color/96/info--v1.png" alt="Info Icon"
                            class="w-10 h-10 object-contain">
                    </div>

                    <div>
                        <p class="text-xl text-gray-900 font-semibold leading-snug">
                            Click the <span class="text-[#55BEBB] font-bold">“Details”</span> button to learn more about
                            this job.
                        </p>
                        <p class="text-base text-gray-700 italic mt-2">
                            (Pindutin ang <span class="font-semibold text-[#55BEBB]">“Details”</span> upang makita ang
                            karagdagang impormasyon tungkol sa trabaho.)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Saved Jobs Box -->
            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-3xl border-l-8 border-green-500 p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div
                        class="flex items-center justify-center bg-white w-16 h-16 rounded-full shadow-md border-4 border-green-500 overflow-hidden">
                        <img src="https://img.icons8.com/color/96/save-as.png" alt="Saved Jobs Icon"
                            class="w-10 h-10 object-contain">
                    </div>

                    <div>
                        <a href="#" class="text-green-700 font-bold text-2xl hover:underline">Saved Jobs</a>
                        <p class="text-lg text-gray-900 mt-3 leading-snug">
                            Click <span class="text-green-700 font-bold">“Save”</span> on any job listing to keep it for
                            later.
                        </p>
                        <p class="text-base text-gray-700 italic mt-2">
                            (Pindutin ang <span class="font-semibold text-green-700">“Save”</span> button sa anumang
                            trabaho upang mai-save ito para sa susunod.)
                        </p>
                    </div>
                </div>
            </div>


            <!-- BACK TO TOP BUTTON -->
            <button id="backToTopBtn"
                class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
                onclick="scrollToTop()" aria-label="Back to top">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
                <span>Back to Top</span>
            </button>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    // Select all buttons with exact text "Apply for Therapist Assessment"
                    const openModalBtns = Array.from(document.querySelectorAll("button"))
                        .filter(btn => btn.textContent.trim() === "Apply for Therapist Job Readiness Assessment");

                    const modal = document.getElementById("assessmentModal");
                    const closeModalBtn = document.getElementById("closeModalBtn");
                    const okModalBtn = document.getElementById("okModalBtn");

                    // Open modal when button is clicked
                    openModalBtns.forEach(btn => {
                        btn.addEventListener("click", () => {
                            modal.classList.remove("hidden");
                            modal.classList.add("flex"); // Ensure it's visible and centered
                        });
                    });

                    // Close modal when clicking "X" or "OK"
                    [closeModalBtn, okModalBtn].forEach(btn => {
                        btn.addEventListener("click", () => {
                            modal.classList.add("hidden");
                            modal.classList.remove("flex");
                        });
                    });

                    // Close modal when clicking outside of it
                    modal.addEventListener("click", (e) => {
                        if (e.target === modal) {
                            modal.classList.add("hidden");
                            modal.classList.remove("flex");
                        }
                    });
                });
            </script>


            <!-- Flag Toggle Script -->
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const flagButtons = document.querySelectorAll(".flag-btn");

                    if (!flagButtons.length) {
                        console.warn("⚠️ No .flag-btn elements found.");
                        return;
                    }

                    flagButtons.forEach((button) => {
                        const icon = button.querySelector("i");

                        button.addEventListener("click", () => {
                            const isFlagged = icon.classList.contains("ri-flag-fill");

                            // Toggle between outlined and filled flag icons
                            icon.classList.toggle("ri-flag-fill", !isFlagged);
                            icon.classList.toggle("ri-flag-line", isFlagged);

                            // Toggle color
                            button.classList.toggle("text-red-500", !isFlagged);
                            button.classList.toggle("text-gray-400", isFlagged);
                        });
                    });
                });
            </script>

            <!-- Back to Top Button Script -->
            <script>
                // Show/hide the Back to Top button
                const backToTopBtn = document.getElementById("backToTopBtn");
                window.addEventListener("scroll", () => {
                    if (window.scrollY > 300) {
                        backToTopBtn.classList.remove("hidden");
                    } else {
                        backToTopBtn.classList.add("hidden");
                    }
                });

                // Smooth scroll to top
                function scrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                }
            </script>



            <!-- Job Cards -->
            @php
                // defensive fallbacks used by scoring logic to avoid undefined variable errors
                if (!isset($recommendations)) {
                    $recommendations = [];
                }
                if (!isset($description)) {
                    $description = '';
                }
                if (!isset($skills_desc)) {
                    $skills_desc = '';
                }
                if (!isset($hours)) {
                    $hours = '';
                }
                // We intentionally only display per-user recommendations (storage/app/reco_user_<safeUid>.json).
                // The server-side preference (above) populated $recommendations when a per-user cache exists.
                // Do NOT fall back to global `public/recommendations.json` or `public/postings.csv` here.
                // If no per-user recommendations were found, $recommendations will remain an empty array and
                // the page will show a friendly message instructing users how to produce per-user recommendations.

                // Load guardian approvals (local storage file) and apply keyword-based filtering (if any filters selected)
                $approvals_path = storage_path('app/guardian_job_approvals.json');
                $guardianApprovals = [];
                if (file_exists($approvals_path)) {
                    $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: [];
                }

                // Helper: return true if job is approved (string job_id or numeric index)
                $isJobApproved = function ($job) use ($guardianApprovals) {
                    $id = isset($job['job_id']) ? (string) $job['job_id'] : null;
                    if (
                        $id !== null &&
                        isset($guardianApprovals[$id]) &&
                        isset($guardianApprovals[$id]['status']) &&
                        $guardianApprovals[$id]['status'] === 'approved'
                    ) {
                        return true;
                    }
                    // also check dataIndex style keys if present
                    if (isset($job['__dataIndex'])) {
                        $di = (string) $job['__dataIndex'];
                        if (
                            isset($guardianApprovals[$di]) &&
                            isset($guardianApprovals[$di]['status']) &&
                            $guardianApprovals[$di]['status'] === 'approved'
                        ) {
                            return true;
                        }
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
                            $needleText = strtolower(
                                ($job['job_description'] ?? ($job['title'] ?? '')) . ' ' . ($job['title'] ?? ''),
                            );
                            $kwList = $industryKeywords[$selectedIndustry] ?? [];
                            foreach ($kwList as $kw) {
                                if (strpos($needleText, $kw) !== false) {
                                    $kwMatched = true;
                                    break;
                                }
                            }
                            if (!$kwMatched) {
                                $show = false;
                            }
                        }
                    }
                    // location filtering removed per request
                    if (
                        request('fit_level') &&
                        (!isset($job['fit_level']) ||
                            strlen(trim($job['fit_level'])) === 0 ||
                            strtolower($job['fit_level']) != strtolower(request('fit_level')))
                    ) {
                        $show = false;
                    }
                    if (
                        request('growth_potential') &&
                        (!isset($job['growth_potential']) ||
                            strlen(trim($job['growth_potential'])) === 0 ||
                            strtolower($job['growth_potential']) != strtolower(request('growth_potential')))
                    ) {
                        $show = false;
                    }
                    if (
                        request('work_environment') &&
                        (!isset($job['work_environment']) ||
                            strlen(trim($job['work_environment'])) === 0 ||
                            strtolower($job['work_environment']) != strtolower(request('work_environment')))
                    ) {
                        $show = false;
                    }
                    if ($show) {
                        $filtered[] = $job;
                    }
                }

                // Do NOT enforce guardian approval here: show all jobs even if guardian has not approved yet
                // (this keeps the public job list comprehensive). Previously the code filtered out jobs when
                // any guardian approvals existed; we intentionally leave $filtered intact so all jobs appear.

                // Extract unique job titles and companies for a brief summary displayed above the list
                // Use the filtered set so the summary reflects current filters
                $allTitles = [];
                $allCompanies = [];
                foreach ($filtered as $r) {
                    $t = trim((string) ($r['title'] ?? ($r['job_description'] ?? '')));
                    $c = trim((string) ($r['company'] ?? ($r['company_name'] ?? '')));
                    if ($t !== '') {
                        $allTitles[] = $t;
                    }
                    if ($c !== '') {
                        $allCompanies[] = $c;
                    }
                }
                $uniqueTitles = array_values(array_slice(array_unique($allTitles), 0, 200));
                $uniqueCompanies = array_values(array_slice(array_unique($allCompanies), 0, 200));

                // Sort by computed/content/hybrid score if available (normalize all scores to 0-100), else by match_score desc
                // Attempt to load best ensemble weights (produced by tools/optimize_weights.py)
                $bestWeightsPath = public_path('best_weights.json');
                $bestWeights = [];
                if (file_exists($bestWeightsPath)) {
                    $bestWeights = json_decode(@file_get_contents($bestWeightsPath), true) ?: [];
                }

                // If best weights present, compute an ensemble_score for each job using mins/maxs stored in bestWeights
                if (
                    !empty($bestWeights) &&
                    isset($bestWeights['best']['weights']) &&
                    isset($bestWeights['score_columns'])
                ) {
                    $bw = $bestWeights['best']['weights'];
                    $mins = $bestWeights['mins'] ?? [];
                    $maxs = $bestWeights['maxs'] ?? [];
                    foreach ($filtered as &$fj) {
                        $total = 0.0;
                        foreach ($bestWeights['score_columns'] as $col) {
                            // try to find a matching value in the job entry
                            $raw = null;
                            if (isset($fj[$col])) {
                                $raw = $fj[$col];
                            } elseif (isset($fj[str_replace('_score', '', $col)])) {
                                $raw = $fj[str_replace('_score', '', $col)];
                            } elseif (isset($fj['content_score']) && $col === 'content_score') {
                                $raw = $fj['content_score'];
                            } elseif (isset($fj['computed_score']) && $col === 'computed_score') {
                                $raw = $fj['computed_score'];
                            } elseif (isset($fj['match_score']) && $col === 'match_score') {
                                $raw = $fj['match_score'];
                            }
                            $raw = is_numeric($raw) ? floatval($raw) : 0.0;
                            $lo = isset($mins[$col]) ? floatval($mins[$col]) : 0.0;
                            $hi = isset($maxs[$col]) ? floatval($maxs[$col]) : 1.0;
                            $norm = $hi > $lo ? ($raw - $lo) / ($hi - $lo) : 0.0;
                            $w = isset($bw[$col]) ? floatval($bw[$col]) : 0.0;
                            $total += $norm * $w;
                        }
                        $fj['ensemble_score'] = $total;
                    }
                    unset($fj);
                }

                usort($filtered, function ($a, $b) {
                    $getRaw = function ($x) {
                        // prefer ensemble_score if available
                        if (isset($x['ensemble_score']) && $x['ensemble_score'] !== null) {
                            return floatval($x['ensemble_score']);
                        }
                        if (isset($x['content_score']) && $x['content_score'] !== null) {
                            return floatval($x['content_score']);
                        }
                        if (isset($x['computed_score']) && $x['computed_score'] !== null) {
                            return floatval($x['computed_score']);
                        }
                        return floatval($x['match_score'] ?? 0);
                    };
                    $norm = function ($val) {
                        // if value looks like 0-1 fraction, scale to 0-100
                        if ($val > 0 && $val <= 1.01) {
                            return $val * 100.0;
                        }
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
                $lastPage = max(1, (int) ceil($total / $perPage));
            @endphp

            <script>
                // Signal to client-side scripts that server rendered per-user recommendations are present
                window.__SERVER_RECO_LOADED = @json(!empty($recommendations) && count($recommendations) > 0);
            </script>

            <div class="max-w-6xl mx-auto px-6 space-y-8 mb-20">
                <!-- Simplified client-side recommendation container -->
                {{-- <div id="jobs-container" class="bg-white p-6 rounded-xl text-center text-gray-600">
                    <p id="reco-info" class="mb-3">Personalized job recommendations will appear here.</p>
                    <p class="text-sm mb-4">This page is now simplified to render recommendations client-side.</p>
                    <button id="btn-generate-recs" class="bg-blue-500 text-white px-4 py-2 rounded">Generate recommendations now</button>
                    <p id="btn-generate-status" class="text-xs text-gray-600 mt-2"></p>
                </div> --}}

                <!-- Auto-fetch Oracle-backed recommendations (debug route uid=7) -->
                <script>
                    (function() {
                        try {
                            // Only run once per page session
                            const key = 'auto_oracle_recs_triggered_' + window.location.pathname;
                            if (sessionStorage.getItem(key)) return;
                            sessionStorage.setItem(key, '1');

                            // Simple guard: only attempt when server auth is assumed or in local env
                            if (!window.__SERVER_AUTH && !(location.hostname === 'localhost' || location.hostname === '127.0.0.1')) {
                                // still allow manual generation via button
                                return;
                            }

                            const listEl = document.getElementById('client-job-list');
                            const statusEl = document.getElementById('btn-generate-status');
                            if (statusEl) statusEl.textContent = 'Auto-generating recommendations...';

                            fetch('{{ url('/debug/oracle-recs') }}?uid=7')
                                .then(async r => {
                                    if (!r.ok) {
                                        const txt = await r.text().catch(() => null);
                                        throw new Error('HTTP ' + r.status + ' ' + r.statusText + ' ' + (txt || ''));
                                    }
                                    return r.json();
                                })
                                .then(data => {
                                    // Expect controller to return { uid, collab: [...], content: [...] }
                                    let contentRecs = [];
                                    let collabRecs = [];
                                    let hybridRecs = [];
                                    if (data && Array.isArray(data.content)) contentRecs = data.content;
                                    if (data && Array.isArray(data.collab)) collabRecs = data.collab;
                                    if (data && Array.isArray(data.hybrid)) hybridRecs = data.hybrid;

                                    // Fallback compatibility: older single-array responses
                                    if ((contentRecs.length === 0 && collabRecs.length === 0)) {
                                        // try older shapes
                                        if (Array.isArray(data)) collabRecs = data;
                                        else if (data && Array.isArray(data.results)) collabRecs = data.results;
                                        else if (data && Array.isArray(data.data)) collabRecs = data.data;
                                        else {
                                            for (const k of Object.keys(data || {})) {
                                                if (Array.isArray(data[k])) { collabRecs = data[k]; break; }
                                            }
                                        }
                                    }

                                    if (statusEl) statusEl.textContent = 'Recommendations ready — rendering.';
                                    const esc = s => s === null || s === undefined ? '' : String(s)
                                        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\"/g, '&quot;');

                                    // Build sectioned HTML using the provided list templates
                                    let out = '';

                                    // If hybrid results are returned prefer rendering them first
                                    if (hybridRecs && hybridRecs.length > 0) {
                                        hybridRecs.slice(0, 50).forEach((r, idx) => {
                                            const jid = String(r.id ?? r.job_id ?? ('h' + idx));
                                            const title = esc(r.title || r.Title || r.job_title || 'Untitled');
                                            const company = esc(r.company || r.company_name || r.Company || '');
                                            const location = esc(r.location || r.city || r.CITY || '');
                                            const desc = esc((r.description || r.job_description || '').substring(0, 400));
                                            const skills = r.required_skills || r.skills || r.REQUIRED_SKILLS || '';

                                            out += `
                                                <div class="relative bg-white border-2 border-green-200 rounded-3xl shadow-lg p-10 mb-6 transition-transform hover:scale-[1.02]">
                                                    <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
                                                        <div class="flex items-start gap-6">
                                                            <div class="flex items-center gap-4">
                                                                <button class="flag-btn text-gray-400 text-5xl focus:outline-none hover:text-red-500 transition-all duration-300"><i class="ri-flag-line"></i></button>
                                                                <div class="flex-shrink-0">
                                                                    <div class="w-32 h-32 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                                                                        <i class="ri-building-4-fill text-[#15803D] text-6xl"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h3 class="font-bold text-3xl text-gray-900">${title}</h3>
                                                                <p class="text-gray-700 text-2xl font-medium mt-2">${company}</p>
                                                                <p class="text-gray-600 text-lg mt-1 flex items-center gap-2">${location ? `<img src=\"https://img.icons8.com/color/48/marker--v1.png\" class=\"w-6 h-6\"/> <span>${location}</span>` : ''}</p>

                                                                <div class="flex flex-wrap gap-3 mt-3">${renderTags(skills)}</div>
                                                            </div>
                                                        </div>

                                                        <a href="#" class="text-[#15803D] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">Why this hybrid match?</a>
                                                    </div>

                                                    <p class="text-gray-700 text-xl mt-8 leading-relaxed max-w-4xl">${desc}</p>

                                                    <div class="flex flex-wrap gap-3 mt-6">${renderTags(skills)}</div>

                                                    <div class="flex flex-wrap gap-3 mt-8">
                                                        <span class="border border-[#15803D] text-[#15803D] text-lg px-5 py-2 rounded-md font-semibold">Hybrid Match</span>
                                                        <span class="border border-[#2563EB] text-[#2563EB] text-lg px-5 py-2 rounded-md font-semibold">Content ${r.content_score ?? ''}</span>
                                                        <span class="border border-[#88BF02] text-[#88BF02] text-lg px-5 py-2 rounded-md font-semibold">Collab ${r.collab_score ?? ''}</span>
                                                    </div>

                                                    <div class="flex justify-end mt-10">
                                                        <button class="bg-[#FFAC1D] text-white text-lg font-bold rounded-md px-10 py-3 w-[480px] hover:bg-[#D78203] transition text-center">Apply for Therapist Job Readiness Assessment</button>
                                                    </div>

                                                    <div class="flex justify-end flex-wrap gap-4 mt-4">
                                                        <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="px-10 py-3 inline-flex items-center justify-center bg-[#55BEBB] text-white text-lg font-bold rounded-md w-[150px] hover:bg-[#47a4a1] transition">Details</a>
                                                        <a href="/job-application-1?job_id=${encodeURIComponent(jid)}" class="px-10 py-3 inline-flex items-center justify-center bg-[#2563EB] text-white text-lg font-bold rounded-md w-[150px] hover:bg-[#1e4fc5] transition">Apply</a>
                                                        <button onclick="saveJob('${jid}', this)" class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">Save</button>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                    } else {
                                        // Header for Content-based
                                        out += `<div class="text-left"><h4 class="text-2xl font-bold mb-3">Content-based (Experts)</h4></div>`;
                                        if (contentRecs && contentRecs.length > 0) {
                                        contentRecs.slice(0, 50).forEach((r, idx) => {
                                            const jid = String(r.id ?? r.job_id ?? ('c' + idx));
                                            const title = esc(r.title || r.Title || r.job_title || 'Untitled');
                                            const company = esc(r.company || r.company_name || r.Company || '');
                                            const location = esc(r.location || r.city || r.CITY || '');
                                            const desc = esc((r.description || r.job_description || '').substring(0, 400));
                                            const skills = r.required_skills || r.skills || r.REQUIRED_SKILLS || '';

                                            out += `
                                                <div class="relative bg-white border-2 border-blue-200 rounded-3xl shadow-lg p-10 mb-6 transition-transform hover:scale-[1.02]">
                                                    <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
                                                        <div class="flex items-start gap-6">
                                                            <div class="flex items-center gap-4">
                                                                <button class="flag-btn text-gray-400 text-5xl focus:outline-none hover:text-red-500 transition-all duration-300"><i class="ri-flag-line"></i></button>
                                                                <div class="flex-shrink-0">
                                                                    <div class="w-32 h-32 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                                                                        <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <h3 class="font-bold text-3xl text-gray-900">${title}</h3>
                                                                <p class="text-gray-700 text-2xl font-medium mt-2">${company}</p>
                                                                <p class="text-gray-600 text-lg mt-1 flex items-center gap-2">${location ? `<img src=\\"https://img.icons8.com/color/48/marker--v1.png\\" class=\\"w-6 h-6\\"/> <span>${location}</span>` : ''}</p>

                                                                <div class="flex flex-wrap gap-3 mt-3">${renderTags(skills)}</div>
                                                            </div>
                                                        </div>

                                                        <a href="/whythisjob?job_id=${encodeURIComponent(jid)}" class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">Why this job matches you?</a>
                                                    </div>

                                                    <p class="text-gray-700 text-xl mt-8 leading-relaxed max-w-4xl">${desc}</p>

                                                    <div class="flex flex-wrap gap-3 mt-6">${renderTags(skills)}</div>

                                                    <div class="flex flex-wrap gap-3 mt-8">
                                                        <span class="border border-[#2563EB] text-[#2563EB] text-lg px-5 py-2 rounded-md font-semibold">Full-Time</span>
                                                        <span class="border border-[#88BF02] text-[#88BF02] text-lg px-5 py-2 rounded-md font-semibold">Full Support</span>
                                                        <span class="border border-[#F89596] text-[#F89596] text-lg px-5 py-2 rounded-md font-semibold">Excellent Fit</span>
                                                    </div>

                                                    <div class="flex justify-end mt-10">
                                                        <button class="bg-[#FFAC1D] text-white text-lg font-bold rounded-md px-10 py-3 w-[480px] hover:bg-[#D78203] transition text-center">Apply for Therapist Job Readiness Assessment</button>
                                                    </div>

                                                    <div class="flex justify-end flex-wrap gap-4 mt-4">
                                                        <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="px-10 py-3 inline-flex items-center justify-center bg-[#55BEBB] text-white text-lg font-bold rounded-md w-[150px] hover:bg-[#47a4a1] transition">Details</a>
                                                        <a href="/job-application-1?job_id=${encodeURIComponent(jid)}" class="px-10 py-3 inline-flex items-center justify-center bg-[#2563EB] text-white text-lg font-bold rounded-md w-[150px] hover:bg-[#1e4fc5] transition">Apply</a>
                                                        <button onclick="saveJob('${jid}', this)" class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">Save</button>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                    } else {
                                        out += `<p class="text-sm text-gray-500 mb-6">No content-based recommendations available.</p>`;
                                    }

                                    // Collaborative header
                                        // collaborative section suppressed in favor of hybrid-only listing
                                    if (collabRecs && collabRecs.length > 0) {
                                        collabRecs.slice(0, 50).forEach((r, idx) => {
                                            const jid = String(r.job_id ?? r.id ?? ('p' + idx));
                                            const title = esc(r.title || r.Title || r.job_title || 'Untitled');
                                            const company = esc(r.company || r.company_name || r.Company || '');
                                            const location = esc(r.location || r.city || r.CITY || '');
                                            const desc = esc((r.description || r.job_description || '').substring(0, 300));
                                            const skills = r.required_skills || r.skills || r.REQUIRED_SKILLS || '';

                                            out += `
                                                <div class="bg-white border-2 border-blue-100 rounded-none shadow-lg p-8 flex flex-col lg:flex-row justify-between items-start gap-8 hover:scale-[1.01] transition-all">
                                                    <div class="flex items-center gap-5 w-full lg:w-2/3">
                                                        <button class="flag-btn text-gray-400 text-5xl font-bold focus:outline-none hover:text-red-500 transition-all duration-300"><i class="ri-flag-line"></i></button>
                                                        <div class="flex-shrink-0">
                                                            <div class="w-32 h-32 flex items-center justify-center rounded-2xl border-2 border-gray-300 bg-gray-50">
                                                                <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-bold text-2xl text-gray-800">${title}</h3>
                                                            <p class="text-lg text-gray-600 mt-2 flex items-center gap-2">${location ? `<img src=\\"https://img.icons8.com/color/48/marker--v1.png\\" class=\\"w-6 h-6\\"/> <span>${location}</span>` : ''}</p>
                                                            <div class="flex flex-wrap gap-2 mt-2">${renderTags(skills)}</div>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col items-center lg:items-end w-full lg:w-1/3 mt-4 lg:mt-0">
                                                        <button class="bg-[#FFAC1D] text-white text-lg font-bold rounded-md px-10 py-3 w-[365px] mb-4 hover:bg-[#D78203] transition text-center">Apply for Therapist Job Readiness Assessment</button>
                                                        <div class="flex gap-4 mb-4">
                                                            <button class="bg-[#55BEBB] text-white font-bold px-8 py-3 text-lg rounded-lg hover:bg-[#399f96] transition-all w-[110px]">Details</button>
                                                            <button class="bg-[#2563EB] text-white font-bold px-8 py-3 text-lg rounded-lg hover:bg-[#1b3999] transition-all w-[110px]">Apply</button>
                                                            <button class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 hover:bg-[#006400] transition w-[110px]">Save</button>
                                                        </div>
                                                        <div class="w-full sm:w-[360px]">
                                                            <div class="h-3 bg-gray-200 rounded-none overflow-hidden"><div class="h-full bg-[#88BF02] w-1/2 rounded-none"></div></div>
                                                            <p class="text-sm text-gray-500 font-semibold mt-2 text-center lg:text-right"><span class="font-semibold text-black">5 applied</span> of 10 capacity</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                    } else {
                                        // no collaborative block — hybrid-only listing
                                    }

                                    if (listEl) listEl.innerHTML = out;
                                })
                                .catch(err => {
                                    console.debug('oracle recs fetch failed', err);
                                    if (statusEl) statusEl.textContent = 'Auto-generation failed: ' + String(err);
                                });
                        } catch (e) {
                            console.debug('auto oracle recs script error', e);
                        }
                    })();
                </script>
            </div>
        </div>


<script>
(function(){
  // Lightweight client-side search for job listings
  function qs(sel){ return Array.from(document.querySelectorAll(sel || '')); }
  function getCandidates(){
    const nodes = [];
    qs('#job-container > div').forEach(n=>nodes.push(n));
    qs('#client-job-list > div').forEach(n=>nodes.push(n));
    qs('.job-card').forEach(n=>nodes.push(n));
    qs('[data-job-id]').forEach(n=>nodes.push(n));
    return Array.from(new Set(nodes));
  }

  function normalizeText(node){
    try {
      const title = node.dataset && (node.dataset.title || node.dataset.jobTitle) ? (node.dataset.title || node.dataset.jobTitle) : '';
      const company = node.dataset && (node.dataset.company) ? node.dataset.company : '';
      const desc = node.dataset && (node.dataset.description) ? node.dataset.description : '';
      const fallback = node.innerText || node.textContent || '';
      return (title + ' ' + company + ' ' + desc + ' ' + fallback).toLowerCase();
    } catch(e){
      return (node.innerText || node.textContent || '').toLowerCase();
    }
  }

  function applySearch(term){
    const t = String(term || '').trim().toLowerCase();
    const candidates = getCandidates();
    let visible = 0;
    candidates.forEach(node=>{
      if(!node) return;
      const hay = normalizeText(node);
      const ok = t === '' ? true : hay.indexOf(t) !== -1;
      node.style.display = ok ? '' : 'none';
      if(ok) visible++;
    });

    const countEl = document.getElementById('all-matches');
    if(countEl){
      const total = getCandidates().length || 0;
      try { countEl.textContent = `All Matches (${visible} / ${total})`; } catch(e){}
    }
    return visible;
  }

  function debounce(fn, ms){ let t; return function(...a){ clearTimeout(t); t = setTimeout(()=>fn.apply(this,a), ms); }; }

  document.addEventListener('DOMContentLoaded', ()=>{
    // CORRECT selector: use the input id added in the template
    const input = document.getElementById('searchJobTitle');
    if(!input) return;

    // Prevent the native form submit (Enter) and run client-side filter instead
    const form = input.closest('form');
    if(form){
      form.addEventListener('submit', (ev)=>{
        ev.preventDefault();
        applySearch(input.value);
      });
    }
    // wire up the clickable search icon/button
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
      searchBtn.addEventListener('click', () => {
        applySearch(input.value);
      });
    }
    // Debounced live filter while typing
    const handler = debounce(()=>applySearch(input.value), 160);
    input.addEventListener('input', handler);

    // Also handle Enter explicitly (prevents submit in some browsers)
    input.addEventListener('keydown', (e)=>{
      if(e.key === 'Enter'){
        e.preventDefault();
        applySearch(input.value);
      }
    });

    // initial run if URL contains search param
    const urlQ = new URLSearchParams(window.location.search || '').get('search') || '';
    if(urlQ && urlQ.trim().length) {
      input.value = urlQ;
      applySearch(urlQ);
    }
  });
})();
</script>
<script>
(function(){
  function toNum(v){ if (v===undefined || v===null || v==='' ) return null; const n = Number(v); return isNaN(n)?null:n; }

  function gatherFromSourceObj(j){
    return {
      id: j.id ?? j.job_id ?? j.ID ?? null,
      content_score: toNum(j.content_score ?? j.CONTENT_SCORE ?? j.contentScore),
      collab_score: toNum(j.collab_score ?? j.COLLAB_SCORE ?? j.collabScore),
      computed_score: toNum(j.computed_score ?? j.computedScore ?? j.computed),
      debug_content_matches: toNum(j.debug_content_matches ?? j.debugContentMatches ?? j.CONTENT_MATCHES ?? j.MATCH_COUNT),
      debug_collab_count: toNum(j.debug_collab_count ?? j.debugCollabCount ?? j.COLLAB_COUNT),
      debug_max_co: toNum(j.debug_max_co ?? j.debugMaxCo ?? j.DEBUG_MAX_CO)
    };
  }

  async function fetchAndLogFromAPI(){
    try {
      const uid = window.userId || window.user_id || null;
      const url = uid ? `/db/get-jobs.php?user_id=${encodeURIComponent(uid)}` : '/db/get-jobs.php';
      const resp = await fetch(url, { credentials: 'same-origin' });
      const body = await resp.json();
      if (!body || !Array.isArray(body.jobs)) {
        console.warn('Hybrid-score-logger: API returned no jobs', body);
        return false;
      }
      const rows = body.jobs.map(j => gatherFromSourceObj(j));
      if (rows.length) {
        console.groupCollapsed(`Hybrid scores (from API) — ${rows.length} jobs`);
        console.table(rows.map(r => ({
          id: r.id,
          content: r.content_score,
          collab: r.collab_score,
          computed: r.computed_score,
          debug_content_matches: r.debug_content_matches,
          debug_collab_count: r.debug_collab_count,
          debug_max_co: r.debug_max_co
        })));
        console.groupEnd();
        return true;
      }
      return false;
    } catch (err) {
      console.warn('Hybrid-score-logger: API fetch failed', err);
      return false;
    }
  }

  function gatherAndLogScores(){
    const rows = [];

    // 1) Prefer any in-memory jobs array
    if (Array.isArray(window.jobs) && window.jobs.length) {
      window.jobs.forEach(j=> rows.push(gatherFromSourceObj(j)));
    }

    // 2) Scan DOM data-* attributes (covers server and client rendered cards)
    document.querySelectorAll('[data-job-id]').forEach(el=>{
      const id = el.dataset.jobId || el.getAttribute('data-job-id') || null;
      const content = el.dataset.contentScore ?? el.getAttribute('data-content-score');
      const collab  = el.dataset.collabScore  ?? el.getAttribute('data-collab-score');
      const computed = el.dataset.computedScore ?? el.getAttribute('data-computed-score');
      const dbgContent = el.dataset.debugContentMatches ?? el.getAttribute('data-debug-content-matches') ?? el.getAttribute('data-content-matches');
      const dbgCollab  = el.dataset.debugCollabCount ?? el.getAttribute('data-debug-collab-count') ?? el.getAttribute('data-collab-count');
      const dbgMax     = el.dataset.debugMaxCo ?? el.getAttribute('data-debug-max-co') ?? el.getAttribute('data-max-co');

      if (!rows.some(r => String(r.id) === String(id))) {
        rows.push({
          id: id,
          content_score: toNum(content),
          collab_score: toNum(collab),
          computed_score: toNum(computed),
          debug_content_matches: toNum(dbgContent),
          debug_collab_count: toNum(dbgCollab),
          debug_max_co: toNum(dbgMax)
        });
      }
    });

    if (rows.length) {
      console.groupCollapsed(`Hybrid scores — ${rows.length} jobs`);
      console.table(rows.map(r => ({
        id: r.id,
        content: r.content_score,
        collab: r.collab_score,
        computed: r.computed_score,
        debug_content_matches: r.debug_content_matches,
        debug_collab_count: r.debug_collab_count,
        debug_max_co: r.debug_max_co
      })));
      console.groupEnd();
      return;
    }

    // fallback: call API to get authoritative scores
    fetchAndLogFromAPI().then(found => {
      if (!found) console.info('Hybrid-score-logger: no job scores found locally or from API.');
    });
  }

  // initial log on DOM ready
  document.addEventListener('DOMContentLoaded', () => {
    gatherAndLogScores();
    window.logHybridScores = gatherAndLogScores;
  });

  // Keyboard quick-log: Ctrl+Shift+L
  window.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 'l') {
      gatherAndLogScores();
    }
  });

  // Auto-log when DOM changes
  const observer = new MutationObserver(() => gatherAndLogScores());
  observer.observe(document.body, { childList: true, subtree: true });

  console.info('Hybrid-score-logger loaded — press Ctrl+Shift+L or call logHybridScores() to re-print scores.');
})();
</script>
    @endsection
