@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Hero Section -->
    <section class="bg-[#FCD34D] flex items-center justify-center py-16 px-6 sm:px-12 lg:px-20">
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
            <img src="https://img.icons8.com/ios-filled/50/1E3A8A/search--v1.png" alt="Search Icon" class="w-10 h-10">
            Filter Jobs
        </h3>

        <!-- Filter Form -->
        <form method="GET" class="w-full space-y-6">
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
                    <select name="growth_potential" onchange="this.form.submit()"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200 pr-12">
                        <option value="">Select Job Type</option>
                        <option value="High Potential"
                            {{ request('growth_potential') == 'High Potential' ? 'selected' : '' }}>Full-Time</option>
                        <option value="Medium Potential"
                            {{ request('growth_potential') == 'Medium Potential' ? 'selected' : '' }}>Part-Time
                        </option>
                        <option value="Medium Potential"
                            {{ request('growth_potential') == 'Medium Potential' ? 'selected' : '' }}>Contract
                        </option>
                         <option value="Medium Potential"
                            {{ request('growth_potential') == 'Medium Potential' ? 'selected' : '' }}>Program
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
                    <select name="work_environment" onchange="this.form.submit()"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200 pr-12">
                        <option value="">Select Environment</option>
                        <option value="Quiet" {{ request('work_environment') == 'Friendly Team' ? 'selected' : '' }}>Friendly Team</option>
                        <option value="Busy" {{ request('work_environment') == 'Buddy Helper' ? 'selected' : '' }}>Buddy Helper</option>
                        <option value="Busy" {{ request('work_environment') == 'Simple Instructions' ? 'selected' : '' }}>Simple Instructions</option>
                        <option value="Busy" {{ request('work_environment') == 'Safe and Light Work' ? 'selected' : '' }}>Safe and Light Work</option>
                        <option value="Busy" {{ request('work_environment') == 'No Heavy Lifting/No Pharmacy Task' ? 'selected' : '' }}>No Heavy Lifting/No Pharmacy Task</option>
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
                        type="text"
                        value="{{ request('location') }}"
                        placeholder="City or area (e.g. Taguig City)"
                        class="w-full appearance-none px-6 py-4 rounded-2xl bg-white border-4 border-blue-600 text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200"
                    />
                </div>

                <!-- Search Bar -->
                <div class="relative w-full sm:col-span-2 md:col-span-3">
                <label class="block text-lg font-semibold text-[#1E3A8A] mb-2">Search Job Title</label>
                <div class="relative">
                    <!-- Give the input extra right padding so text never sits under the button -->
                    <input id="searchJobTitle" type="text" name="search" value="{{ request('search') }}" placeholder="Search by job title (e.g. Sales Assistant, Barista)"
                        class="w-full appearance-none px-6 pr-20 py-4 rounded-2xl bg-white border-4 border-blue-600 
                        text-gray-800 text-lg font-semibold shadow-lg hover:border-blue-700 
                        focus:ring-4 focus:ring-blue-300 focus:outline-none transition-all duration-200" />

                    <!-- Clickable search button positioned inside the input area -->
                    <button id="searchBtn" type="button" aria-label="Search"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center bg-white border-2 border-blue-600 rounded-full text-blue-600 hover:bg-blue-50 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            </div>
        </form>

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

                                    <a href="#" class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">Why this job match you?</a>
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
                                    <button class="bg-[#55BEBB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#47a4a1] transition">Details</button>
                                    <button class="bg-[#2563EB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#1e4fc5] transition">Apply</button>
                                    <button class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">Save</button>
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
        <script>

        const data = {
        user_id: localStorage.getItem('user_id')
        };

        fetch('/db/get-jobs.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (!result.success || !result.jobs.length) {
            document.getElementById('job-container').innerHTML = 
                '<p class="text-center text-3xl text-gray-600">No job postings available at the moment.</p>';
            return;
            }
            const container = document.getElementById('job-container');
            const count_matches = document.getElementById('all-matches');

            // Update the total count first
            count_matches.innerHTML = 'All Matches (' + result.jobs.length + ')';

            result.jobs.forEach(job => {
            
            // Calculate progress barS width
            const progress = job.openings > 0 ? (job.applied / job.openings) * 100 : 0;

            const cardHTML = `
        <div class="bg-white border-4 border-blue-300 rounded-3xl shadow-xl p-10 mb-10 max-w-[90rem] mx-auto hover:shadow-2xl transition-all duration-300">
            <!-- Top Section -->
            <div class="flex flex-col lg:flex-row justify-between items-start gap-10">
                <!-- Left: Company Info -->
                <div class="flex items-start gap-6">
                    <!-- Company Logo -->
                    <div class="w-36 h-36 rounded-3xl border-4 border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden">
                        <img src="${escapeHtml(job.logo)}" alt="${escapeHtml(job.company_name)} logo" class="w-full h-full object-cover">
                    </div>
                    <!-- Company Details -->
                    <div>
                        <h2 class="text-4xl font-extrabold text-gray-900 mb-2">${escapeHtml(job.job_role)}</h2>
                        <p class="text-2xl text-gray-800 font-semibold mb-2">${escapeHtml(job.company_name)}</p>
                        <p class="flex items-center text-xl text-gray-700 gap-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location" class="w-6 h-6">
                            ${escapeHtml(job.address)}
                        </p>
                    </div>
                </div>
                <!-- Why It Matches -->
                <a href="#" class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center whitespace-nowrap">
                    Why this job matches you?
                </a>
            </div>

            <hr class="my-8 border-gray-300">

            <!-- Description -->
            <div>
                <h3 class="text-3xl font-bold text-[#1E40AF] mb-4">Job Description</h3>
                <p class="text-gray-800 text-2xl leading-relaxed max-w-6xl">
                    ${escapeHtml(job.description).replace(/\n/g, '<br>')}
                </p>
            </div>

            <!-- Skills Section -->
            ${job.skills && job.skills.length > 0 ? `
            <div class="mt-8">
                <h3 class="text-3xl font-bold text-[#1E40AF] mb-4">Required Skills you will Use</h3>
                <div class="flex flex-wrap gap-4">
                    ${job.skills.map(skill => 
                    `<span class="bg-blue-200 text-blue-900 text-lg font-semibold px-5 py-2 rounded-full">${escapeHtml(skill)}</span>`
                    ).join('')}
                </div>
            </div>` : ''}

            <!-- Job Type -->
            <div class="mt-8">
                <h3 class="text-3xl font-bold text-[#1E40AF] mb-4">Job Type</h3>
                <div class="flex flex-wrap gap-4">
                    <span class="border-2 border-[#2563EB] text-[#2563EB] text-lg px-6 py-2 rounded-md font-bold bg-blue-50">
                        ${escapeHtml(job.job_type)}
                    </span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-10 w-full">
                <p class="text-xl font-semibold text-gray-800 mb-2 text-center">Number of Applicants</p>
                <div class="h-5 bg-gray-200 rounded-md overflow-hidden">
                    <div class="h-full bg-[#88BF02]" style="width: ${progress}%;"></div>
                </div>
                <p class="text-lg text-gray-700 mt-2 text-center">
                    <strong>${job.applied} applied</strong> out of ${job.openings} openings
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap justify-center gap-6 mt-10">
                <button onclick="location.href='job-details?id=${job.id}'"
                        class="bg-[#55BEBB] text-white text-xl font-bold rounded-md px-10 py-4 hover:bg-[#47a4a1] transition">
                    📝 See Details
                </button>
                <button onclick="location.href='apply.php?id=${job.id}'"
                        class="bg-[#2563EB] text-white text-xl font-bold rounded-md px-10 py-4 hover:bg-[#1e4fc5] transition">
                    🚀 Apply Now
                </button>
                <button onclick="saveJob(${job.id})"
                        class="bg-[#008000] text-white text-xl font-bold rounded-md px-10 py-4 hover:bg-[#006400] transition">
                    💾 Save
                </button>
            </div>
        </div>`;
            container.innerHTML += cardHTML;
            });
        })
        .catch(err => {
            console.error('Error loading jobs:', err);
            document.getElementById('job-container').innerHTML = 
            '<p class="text-center text-red-600 text-2xl">Failed to load jobs. Please try again later.</p>';
        });

        // Helper function to prevent XSS
        function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
        }

        // Save Job function (optional)
        function saveJob(jobId) {
        alert('Job ID ' + jobId + ' saved!');
        // Implement actual save logic here
        }
        </script>
        <!-- Instruction Section Wrapper -->
        <div class="space-y-8">

            <!-- Apply Button Instruction -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-3xl border-l-8 border-[#2563EB] p-8 shadow-lg">
                <div class="flex items-start gap-4">

                    <div
                        class="flex items-center justify-center bg-white w-16 h-16 rounded-full shadow-md border-4 border-[#2563EB] overflow-hidden">
                        <img src="https://img.icons8.com/color/96/medical-doctor.png" alt="Therapist Icon"
                            class="w-10 h-10 object-contain">
                    </div>

                    <div>
                         <p class="text-xl text-gray-900 font-semibold leading-snug">
                            Click the <span class="text-[#55BEBB] font-bold">“Apply”</span> button to apply for 
                            the job.
                        </p>
                        <p class="text-base text-gray-700 italic mt-2">
                            (Pindutin ang <span class="font-semibold text-[#55BEBB]">“Apply”</span> upang mag apply sa trabaho.)
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
                                                        <button class="bg-[#55BEBB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#47a4a1] transition">Details</button>
                                                        <button class="bg-[#2563EB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#1e4fc5] transition">Apply</button>
                                                        <button class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">Save</button>
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

                                                        <a href="#" class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">Why this job match you?</a>
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
                                                        <button class="bg-[#55BEBB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#47a4a1] transition">Details</button>
                                                        <button class="bg-[#2563EB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#1e4fc5] transition">Apply</button>
                                                        <button class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">Save</button>
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
        <script type="module">
            // Re-score job cards using the user's Firestore profile (if available)
            (async function() {
                try {
                    // Firebase removed: do not attempt to read client Firestore profile.
                    // Use server-side Oracle-backed recommendations. If you have a server session,
                    // the server will personalize by session user; otherwise recommendations may be global.
                    let profile = null;
                    try {
                        // in Oracle mode we do not fetch a client profile
                        profile = null;
                    } catch (e) {
                        profile = null;
                    }

                    if (!profile) {
                        // continue: server calls below will send empty profile and rely on server session
                    }
                    // Normalize profile fields
                    const jobPrefs = [];
                    try {
                        const jp1 = profile?.jobPreferences?.jobpref1 || profile?.jobPreferences?.jobpref_1 || profile?.jobpref1;
                        const jp2 = profile?.jobPreferences?.jobpref2 || profile?.jobpref2;
                        if (jp1) JSON.parse(jp1).forEach(x => jobPrefs.push(String(x).toLowerCase()));
                        if (jp2) JSON.parse(jp2).forEach(x => jobPrefs.push(String(x).toLowerCase()));
                    } catch (e) {
                        /* ignore parse */
                    }
                    const skills = [];
                    try {
                        if (profile?.skills?.skills_page1) JSON.parse(profile?.skills?.skills_page1).forEach(x => skills
                            .push(String(x).toLowerCase()));
                    } catch (e) {}
                    try {
                        if (profile?.skills?.skills_page2) JSON.parse(profile?.skills?.skills_page2).forEach(x => skills
                            .push(String(x).toLowerCase()));
                    } catch (e) {}
                    const workplace = (profile?.workplace?.workplace_choice || '').toLowerCase();
                    const support = (profile?.supportNeed?.support_choice || '').toLowerCase();

                    // iterate job cards and compute new score, store numeric value on element for sorting
                    const scored = [];
                    document.querySelectorAll('.job-card').forEach(card => {
                        try {
                            const title = (card.dataset.title || '').toLowerCase();
                            const desc = (card.dataset.description || '').toLowerCase();
                            // server-provided content score (0-100) if available
                            const serverContent = parseFloat(card.dataset.contentScore || card.dataset
                                .contentscore || '0') || 0;
                            // fallback: use data-match-percent or visible badge base
                            const datasetMatchPct = parseInt(card.dataset.matchPercent || card.dataset
                                .matchpercent || '0') || 0;
                            let base = serverContent || datasetMatchPct || (parseInt(card.querySelector(
                                '.js-match-badge')?.textContent || '0') || 0);
                            // compute boosts from user profile
                            let boost = 0;
                            jobPrefs.forEach(p => {
                                if (!p) return;
                                const pp = String(p).toLowerCase();
                                if (title.includes(pp) || desc.includes(pp)) boost += 20;
                            });
                            skills.forEach(s => {
                                if (!s) return;
                                const ss = String(s).toLowerCase();
                                if (title.includes(ss) || desc.includes(ss)) boost += 10;
                            });
                            if (workplace && desc.includes(workplace)) boost += 12;
                            if (support && desc.includes(support)) boost += 6;
                            const final = Math.min(100, Math.max(0, Math.round(base + boost)));
                            const badge = card.querySelector('.js-match-badge');
                            // Preserve raw display if present, and include computed max if provided
                            const rawMatch = card.dataset.rawMatch || card.getAttribute('data-raw-match') ||
                                card.dataset.rawmatch || '';
                            const computedScore = card.dataset.computedScore || card.getAttribute(
                                'data-computed-score') || '';
                            const computedMax = card.dataset.computedMax || card.getAttribute(
                                'data-computed-max') || '';
                            let rawDisplayText = '';
                            if (rawMatch) rawDisplayText = ` (raw: ${rawMatch})`;
                            if (!rawDisplayText && computedScore) rawDisplayText =
                                ` (computed: ${computedScore}${computedMax ? ' / ' + computedMax : ''})`;
                            if (badge) badge.innerHTML = final + '% Match' +
                                '<small class="text-xs text-gray-500">' + rawDisplayText + '</small>';
                            card.dataset.personalScore = String(final);
                            scored.push({
                                card,
                                score: final
                            });
                        } catch (e) {
                            console.error('rescore error', e);
                        }
                    });

                    // Reorder DOM: place job cards in descending order of personal score
                    if (scored.length > 1) {
                        const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                        if (container) {
                            // sort scored array
                            scored.sort((a, b) => b.score - a.score);
                            // remove existing nodes and re-append in order
                            scored.forEach(s => {
                                container.appendChild(s.card);
                            });
                        }
                    }

                    // Also request server-side hybrid recommendations (collaborative + content)
                    try {
                        // If server already rendered per-user recommendations, skip client-side hybrid replacement
                        if (window.__SERVER_RECO_LOADED) {
                            console.debug(
                                'job-matches: server-rendered per-user recommendations present; skipping client hybrid replacement'
                            );
                            return;
                        }
                        // Global debug for hybrid recommender
                        window.__HYBRID_RECO_DEBUG = window.__HYBRID_RECO_DEBUG || {
                            events: [],
                            lastRecs: null
                        };

                        function hdbg(ev, payload) {
                            try {
                                window.__HYBRID_RECO_DEBUG.events.push({
                                    when: Date.now(),
                                    ev,
                                    payload
                                });
                            } catch (e) {};
                            try {
                                console.debug('hybrid-reco:', ev, payload);
                            } catch (e) {}
                        }
                        hdbg('request_start', {
                            url: '{{ url('/api/recommendations/user') }}',
                            uid: profile?.uid || profile?.userId || profile?.user_id || ''
                        });
                        const resp = await fetch('{{ url('/api/recommendations/user') }}', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            // ask server to force generation/sync when possible for immediate results
                            body: JSON.stringify(Object.assign({
                                uid: profile?.uid || profile?.userId || profile?.user_id || '',
                                force: true
                            }, profile))
                        });
                        hdbg('request_done', {
                            status: resp.status,
                            statusText: resp.statusText
                        });
                        // helper: normalize server response into an array of recommendation objects
                        async function normalizeRecsFromResponse(response) {
                            const data = await response.json();
                            hdbg('normalize_response_raw', {
                                sample: (Array.isArray(data) ? data.slice(0, 5) : Object.keys(data || {})
                                    .slice(0, 10))
                            });
                            if (Array.isArray(data)) return data;
                            if (data && typeof data === 'object') {
                                const vals = Object.values(data);
                                const arrVal = vals.find(v => Array.isArray(v));
                                if (arrVal) return arrVal;
                                const keys = Object.keys(data || {});
                                if (keys.length > 0 && Array.isArray(data[keys[0]])) return data[keys[0]];
                            }
                            return [];
                        }

                        if (resp.status === 202) {
                            console.info('Hybrid recommender scheduled; polling for results...');
                            hdbg('scheduled_polling_start', {
                                maxAttempts: 10,
                                delayMs: 3000
                            });
                            // Poll a few times for generated recommendations
                            const maxAttempts = 10;
                            const delayMs = 3000;
                            let attempts = 0;
                            let recs = [];
                            while (attempts < maxAttempts) {
                                attempts++;
                                await new Promise(r => setTimeout(r, delayMs));
                                try {
                                    hdbg('poll_attempt', {
                                        attempt: attempts
                                    });
                                    const pollResp = await fetch('{{ url('/api/recommendations/user') }}', {
                                        method: 'POST',
                                        credentials: 'same-origin',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify(Object.assign({
                                            uid: profile?.uid || profile?.userId || profile?.user_id ||
                                                ''
                                        }, profile))
                                    });
                                    hdbg('poll_response', {
                                        attempt: attempts,
                                        status: pollResp.status
                                    });
                                    if (pollResp.ok) {
                                        recs = await normalizeRecsFromResponse(pollResp);
                                        hdbg('poll_got_recs', {
                                            attempt: attempts,
                                            recCount: recs.length
                                        });
                                        break;
                                    }
                                } catch (e) {
                                    hdbg('poll_error', {
                                        attempt: attempts,
                                        error: String(e)
                                    });
                                    console.debug('Poll attempt failed', e);
                                }
                            }
                            if (recs.length === 0) {
                                hdbg('no_recs_after_polling');
                                console.warn('No recommendations received after polling.');
                            } else {
                                hdbg('got_recs', {
                                    recCount: recs.length
                                });
                                window.__HYBRID_RECO_DEBUG.lastRecs = recs;
                                // If the server returned a fresh recommendation set, rebuild the job list
                                (function renderRecs(recsArr) {
                                    try {
                                        const container = document.querySelector(
                                            '.container.mx-auto.mt-8.px-4.space-y-6');
                                        if (!container) return;
                                        // Build new HTML: header + cards
                                        let out = '';
                                        // Render up to 50 recommendations to avoid overly long pages
                                        recsArr.slice(0, 50).forEach((r, idx) => {
                                            const jid = String(r.job_id ?? ('p' + idx));
                                            const title = escapeHtml(String(r.Title || r.title || r
                                                .job_title || r.job_description || 'Untitled Job'));
                                            const company = escapeHtml(String(r.Company || r.company || r
                                                .company_name || ''));
                                            let rawMatchVal = Number(r.hybrid_score ?? r.content_score ?? r
                                                .match_score ?? 0) || 0;
                                            let matchPercent = 0;
                                            if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math
                                                .round(rawMatchVal * 100);
                                            else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent =
                                                Math.round(rawMatchVal * 20);
                                            else matchPercent = Math.round(rawMatchVal);
                                            const why = escapeHtml(String((r.job_description || r
                                                .description || '').substring(0, 400)));
                                            const industry = escapeHtml(String(r.industry || ''));
                                            const workEnv = escapeHtml(String(r.work_environment || ''));
                                            const fit = escapeHtml(String(r.fit_level || ''));
                                            const growth = escapeHtml(String(r.growth_potential || ''));
                                            const salary = escapeHtml(String(r.salary ?? '-'));
                                            const deadline = escapeHtml(String(r.deadline ?? ''));
                                            out += `
                                    <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${escapeHtml(String(r.location || ''))}" data-fit-level="${fit}" data-content-score="${escapeHtml(String(r.content_score ?? r.computed_score ?? 0))}" data-raw-match="${escapeHtml(String(rawMatchVal))}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                                        <div class="flex-1 pr-6">
                                            <h3 class="text-lg font-bold">${title}</h3>
                                            <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${matchPercent}% Match <small class="text-xs text-gray-500">(raw: ${escapeHtml(String(rawMatchVal))})</small></span></div>
                                            ${ company ? `<p class="text-sm text-gray-700 font-medium">${company}</p>` : '' }
                                            <p class="text-gray-600 mt-2 text-sm">${why}</p>
                                            <div class="flex gap-2 text-xs mt-2">
                                                ${ industry ? `<span class="bg-gray-100 px-2 py-1 rounded">${industry}</span>` : '' }
                                                ${ workEnv ? `<span class="bg-gray-100 px-2 py-1 rounded">${workEnv}</span>` : '' }
                                            </div>
                                            <div class="flex gap-2 mt-2">
                                                ${ fit ? `<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">${fit}</span>` : '' }
                                                ${ growth ? `<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">${growth}</span>` : '' }
                                            </div>
                                            <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                            <p class="text-xs text-gray-400 mt-1">Salary: ${salary} ${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                        </div>
                                        <div class="flex items-center gap-3 mt-4 md:mt-0">
                                            <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">View Details</a>
                                            <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="job_id" value="${jid}">
                                                <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                `;
                                        });
                                        container.innerHTML = out;
                                    } catch (e) {
                                        console.error('renderRecs error', e);
                                    }
                                })(recs);
                            }
                        } else if (resp.ok) {
                            const recs = await normalizeRecsFromResponse(resp);
                            hdbg('immediate_recs', {
                                count: recs.length
                            });
                            window.__HYBRID_RECO_DEBUG.lastRecs = recs;
                            // Rebuild the job list from fresh recommendations so stale server-rendered list is replaced
                            (function renderRecsImmediate(recsArr) {
                                try {
                                    const container = document.querySelector(
                                        '.container.mx-auto.mt-8.px-4.space-y-6');
                                    if (!container) return;
                                    let out = '';
                                    recsArr.slice(0, 50).forEach((r, idx) => {
                                        const jid = String(r.job_id ?? ('p' + idx));
                                        const title = escapeHtml(String(r.Title || r.title || r.job_title ||
                                            r.job_description || 'Untitled Job'));
                                        const company = escapeHtml(String(r.Company || r.company || r
                                            .company_name || ''));
                                        let rawMatchVal = Number(r.hybrid_score ?? r.content_score ?? r
                                            .match_score ?? 0) || 0;
                                        let matchPercent = 0;
                                        if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math
                                            .round(rawMatchVal * 100);
                                        else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent = Math
                                            .round(rawMatchVal * 20);
                                        else matchPercent = Math.round(rawMatchVal);
                                        const why = escapeHtml(String((r.job_description || r.description ||
                                            '').substring(0, 400)));
                                        const industry = escapeHtml(String(r.industry || ''));
                                        const workEnv = escapeHtml(String(r.work_environment || ''));
                                        const fit = escapeHtml(String(r.fit_level || ''));
                                        const growth = escapeHtml(String(r.growth_potential || ''));
                                        const salary = escapeHtml(String(r.salary ?? '-'));
                                        const deadline = escapeHtml(String(r.deadline ?? ''));
                                        out += `
                                <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${escapeHtml(String(r.location || ''))}" data-fit-level="${fit}" data-content-score="${escapeHtml(String(r.content_score ?? r.computed_score ?? 0))}" data-raw-match="${escapeHtml(String(rawMatchVal))}" class="job-card bg-white border border-gray-300 rounded-xl p-6 flex justify-between items-center">
                                                        <div>
                                                            <h3 class="text-lg font-semibold text-gray-800">${title}</h3>
                                                            ${ company ? `<p class="text-gray-600">${company}</p>` : '' }
                                                            <p class="text-sm text-gray-500 mb-2">${escapeHtml(String(r.location || ''))}</p>
                                                            <div class="flex gap-2 text-xs text-gray-700 mb-3">
                                                                ${ industry ? `<span class="bg-gray-100 px-3 py-1 rounded-md">${industry}</span>` : '' }
                                                                ${ workEnv ? `<span class="bg-gray-100 px-3 py-1 rounded-md">${workEnv}</span>` : '' }
                                                            </div>
                                                            <p class="text-sm text-gray-700">${why}</p>
                                                            <div class="flex gap-2 mt-3 text-xs">
                                                                ${ fit ? `<span class="bg-[#D1FFD6] text-green-800 px-3 py-1 rounded-md">⭐ ${fit}</span>` : '' }
                                                                ${ growth ? `<span class="bg-[#E6E9FF] text-[#4F46E5] px-3 py-1 rounded-md">📈 ${growth}</span>` : '' }
                                                            </div>
                                                            <p class="text-xs text-gray-500 mt-3">${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                                        </div>
                                                        <div class="flex flex-col items-end space-y-3">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" class="w-16 h-16" alt="logo">
                                                            <div class="flex gap-2">
                                                                <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="bg-[#007BFF] text-white px-4 py-2 rounded-md text-sm">View Details</a>
                                                                <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="job_id" value="${jid}">
                                                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm">Save</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                                    </div>
                            `;
                                    });
                                    container.innerHTML = out;
                                } catch (e) {
                                    console.error('renderRecsImmediate error', e);
                                }
                            })(recs);
                        } else {
                            hdbg('request_error', {
                                status: resp.status
                            });
                            console.warn('Hybrid recommender error', resp.status);
                        }
                    } catch (e) {
                        hdbg('request_exception', {
                            error: String(e)
                        });
                        console.debug('Hybrid recommender failed', e);
                    }
                } catch (err) {
                    console.debug('rescore aborted', err);
                }
            })();

            // Poll the hybrid recommender periodically so the job list stays up-to-date.
            (function() {
                try {
                    // small helper to avoid XSS when injecting server-provided fields
                    const escapeHtml = (str) => {
                        if (str === null || str === undefined) return '';
                        return String(str)
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;')
                            .replace(/'/g, '&#39;');
                    };
                    const pollIntervalMs = 20000; // 20s
                    let lastHash = null;
                    async function pollOnce() {
                        if (window.__SERVER_RECO_LOADED) {
                            // Avoid replacing server-rendered per-user results
                            console.debug(
                                'job-matches: server-rendered per-user recommendations present; skipping poll replace'
                            );
                            return;
                        }
                        try {
                            // attempt to read client profile if available
                            let profile = null;
                            try {
                                // Firebase removed: do not import or query client profile; rely on server instead
                                profile = null;
                            } catch (e) {
                                /* ignore */
                            }
                            const body = profile ? Object.assign({
                                            uid: profile?.uid || profile?.userId || profile?.user_id || ''
                            }, profile) : {};
                            const resp = await fetch('{{ url('/api/recommendations/user') }}', {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(Object.assign(body, {
                                    force: false
                                }))
                            });
                            if (!resp.ok && resp.status !== 202) return;
                            const json = await resp.json().catch(() => null);
                            if (!json) return;
                            // normalize to array
                            let recs = [];
                            if (Array.isArray(json)) recs = json;
                            else if (json && typeof json === 'object') {
                                const vals = Object.values(json).filter(v => Array.isArray(v));
                                if (vals.length > 0) recs = vals[0];
                                else recs = Object.keys(json).map(k => json[k]);
                            }
                            const hash = JSON.stringify(recs.slice(0, 50));
                            if (hash !== lastHash) {
                                lastHash = hash;
                                try {
                                    window.__HYBRID_RECO_DEBUG = window.__HYBRID_RECO_DEBUG || {};
                                    window.__HYBRID_RECO_DEBUG.lastRecs = recs;
                                } catch (e) {}
                                // rebuild DOM similar to server-render replacement
                                try {
                                    const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                                    if (!container) return;
                                    let out = '';
                                    recs.slice(0, 50).forEach((r, idx) => {
                                        const jid = String(r.job_id ?? ('p' + idx));
                                        const title = escapeHtml(String(r.Title || r.title || r.job_title || r
                                            .job_description || 'Untitled Job'));
                                        const company = escapeHtml(String(r.Company || r.company || r
                                            .company_name || ''));
                                        let rawMatchVal = Number(r.hybrid_score ?? r.content_score ?? r
                                            .match_score ?? 0) || 0;
                                        let matchPercent = 0;
                                        if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math.round(
                                            rawMatchVal * 100);
                                        else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent = Math
                                            .round(rawMatchVal * 20);
                                        else matchPercent = Math.round(rawMatchVal);
                                        const why = escapeHtml(String((r.job_description || r.description || '')
                                            .substring(0, 400)));
                                        const industry = escapeHtml(String(r.industry || ''));
                                        const workEnv = escapeHtml(String(r.work_environment || ''));
                                        const fit = escapeHtml(String(r.fit_level || ''));
                                        const growth = escapeHtml(String(r.growth_potential || ''));
                                        const salary = escapeHtml(String(r.salary ?? '-'));
                                        const deadline = escapeHtml(String(r.deadline ?? ''));
                                        out += `
                                <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${escapeHtml(String(r.location || ''))}" data-fit-level="${fit}" data-content-score="${escapeHtml(String(r.content_score ?? r.computed_score ?? 0))}" data-raw-match="${escapeHtml(String(rawMatchVal))}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                                    <div class="flex-1 pr-6">
                                        <h3 class="text-lg font-bold">${title}</h3>
                                        <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${matchPercent}% Match <small class="text-xs text-gray-500">(raw: ${escapeHtml(String(rawMatchVal))})</small></span></div>
                                        ${ company ? `<p class="text-sm text-gray-700 font-medium">${company}</p>` : '' }
                                        <p class="text-gray-600 mt-2 text-sm">${why}</p>
                                        <div class="flex gap-2 text-xs mt-2">
                                            ${ industry ? `<span class="bg-gray-100 px-2 py-1 rounded">${industry}</span>` : '' }
                                            ${ workEnv ? `<span class="bg-gray-100 px-2 py-1 rounded">${workEnv}</span>` : '' }
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            ${ fit ? `<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">${fit}</span>` : '' }
                                            ${ growth ? `<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">${growth}</span>` : '' }
                                        </div>
                                        <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                        <p class="text-xs text-gray-400 mt-1">Salary: ${salary} ${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                    </div>
                                    <div class="flex items-center gap-3 mt-4 md:mt-0">
                                            <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">View Details</a>
                                            <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="job_id" value="${jid}">
                                                <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">Save</button>
                                            </form>
                                    </div>
                                </div>
                            `;
                                    });
                                    container.innerHTML = out;
                                } catch (e) {
                                    console.error('rebuild DOM error', e);
                                }
                            }
                        } catch (e) {
                            console.debug('pollOnce error', e);
                        }
                    }
                    pollOnce();
                    setInterval(pollOnce, pollIntervalMs);
                } catch (e) {
                    console.debug('polling setup failed', e);
                }
            })();
        </script>
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
    @endsection
