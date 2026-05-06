@extends('layouts.includes')

@section('content')

    <style>
        .tts-btn.speaking {
            background-color: #2563eb !important;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
            transform: scale(1.03);
        }
        .tts-btn {
            padding: 0.4rem 0.5rem;
            border-radius: 9999px;
            transition: transform 0.2s ease;
        }
        @media (min-width: 640px) {
            .tts-btn {
                padding: 0.5rem 0.6rem;
                font-size: 1rem;
            }
        }
        @media (min-width: 1024px) {
            .tts-btn {
                padding: 0.55rem 0.6rem;
                font-size: 1.125rem;
            }
        }
    </style>

    <!-- NOTE: THIS IS STILL IN PROGRESS, I'M NOT SURE PANO AANUHIN YAN -->

    <!-- Hero Section -->
    <section class="bg-sky-50 py-12 sm:py-16" role="region" aria-labelledby="hero-heading">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 text-center">

            <p class="text-base font-bold uppercase tracking-widest text-blue-700">
                Your applications
            </p>

            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 mt-2" id="hero-heading">
                Job Applications
            </h1>

            <div class="mx-auto max-w-2xl">
                <p class="text-lg sm:text-xl text-slate-700 mt-4">
                    Track and manage all your job applications in one place. View progress, withdraw applications, and get feedback.
                </p>
                <div class="mt-6 inline-flex items-center justify-center gap-3">
                    <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-2.5 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    aria-label="Read hero section aloud"
                    onclick="speakText(document.getElementById('tts-hero').textContent)">

                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                </div>
            </div>

            <!-- COUNT BUTTON -->
            <div class="mt-6">
                <button type="button" id="applicationsCountBtn"
                    aria-label="Applications count"
                    class="inline-flex items-center justify-center gap-3 rounded-full bg-blue-700 px-8 py-4 text-white text-lg font-bold shadow-lg hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
                    <img src="https://img.icons8.com/ios-filled/50/D22B2B/briefcase.png" class="w-6 h-6" alt="" aria-hidden="true">
                    <span id="applicationsCountText" role="status" aria-live="polite">Loading...</span>
                </button>
            </div>
            <div class="mt-4">
                <p id="applicationsOverviewCountText" class="text-sm sm:text-base text-slate-700">Loading application overview…</p>
            </div>

            <div class="pt-6">
                <a href="/job-matches"
                    class="inline-flex items-center gap-3 rounded-full border-2 border-blue-200 bg-white px-6 py-3 text-blue-700 font-semibold shadow-sm transition hover:bg-blue-50 hover:border-blue-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">

                    <!-- Icons8 Back Icon -->
                    <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png"
                        alt=""
                        aria-hidden="true"
                        class="w-5 h-5">

                    <span>Back to jobs</span>
                </a>
            </div>

        </div>
        <div id="tts-hero" class="sr-only">Your applications. My Job Applications. Track and manage all your job applications in one place. View progress, withdraw applications, and get feedback.</div>
    </section>

    <!-- Search and Filter Section -->
    <section class="bg-white rounded-3xl shadow-lg p-6 mb-8 max-w-6xl mx-auto" role="form" aria-labelledby="filter-heading">
        <h2 id="filter-heading" class="text-2xl font-bold text-gray-900 mb-6 text-center">Filter Your Applications</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search Input -->
            <div class="relative">
                <label for="appSearchInput" class="block text-sm font-medium text-gray-700 mb-1">Search Applications</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 6.65a7.5 7.5 0 010 10.6z" />
                        </svg>
                    </div>
                    <input id="appSearchInput" type="text" placeholder="e.g. Software Engineer" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" aria-describedby="search-help">
                </div>
                <p id="search-help" class="mt-1 text-sm text-gray-500">Enter job title, company, or location</p>
            </div>

            <!-- Status Dropdown -->
            <div class="relative">
                <label for="appStatusSelect" class="block text-sm font-medium text-gray-700 mb-1">Application Status</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <select id="appStatusSelect" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" aria-describedby="status-help">
                        <option value="" disabled selected hidden>Status</option>
                        <option value="pending">Pending</option>
                        <option value="reviewed">Under Review</option>
                        <option value="feedback">Feedback</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <p id="status-help" class="mt-1 text-sm text-gray-500">Filter by application status</p>
            </div>

            <!-- Date Dropdown -->
            <div class="relative">
                <label for="appDateSelect" class="block text-sm font-medium text-gray-700 mb-1">Date Applied</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <select id="appDateSelect" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" aria-describedby="date-help">
                        <option value="" disabled selected hidden>Date</option>
                        <option value="today">Today</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="all_time">All Time</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <p id="date-help" class="mt-1 text-sm text-gray-500">Filter by application date</p>
            </div>
        </div>
        <div class="text-center mt-6">
            <button id="filterBtn" class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">Apply Filters</button>
        </div>
        <div class="text-center mt-4">
            <button class="tts-btn bg-gray-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-700 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2" data-tts-en="Filter your applications. Search by job title, company, or location. Filter by status and date applied." data-tts-tl="I-filter ang iyong mga aplikasyon. Maghanap ayon sa titulo ng trabaho, kumpanya, o lokasyon. I-filter ayon sa status at petsa ng aplikasyon." data-target="tts-filter">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M13.5 4.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM9 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM12 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>
                Listen to Filter Options
            </button>
        </div>
    </section>

        <!-- Job Applications List -->
        <section class="bg-white py-12 sm:py-16" id="job-applications" role="region" aria-labelledby="applications-heading">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 id="applications-heading" class="text-2xl sm:text-3xl font-bold text-slate-900">Your applications</h2>
                    <p class="mt-2 text-sm sm:text-base text-slate-600">Review your job applications and track their progress.</p>
                </div>
                 <button type="button"
                class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-2.5 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                aria-label="Read applications section aloud"
                onclick="speakText(
                    document.getElementById('applications-heading').textContent + '. ' + 
                    document.getElementById('applications-description').textContent
                )">

                <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                Listen
            </button>
            </div>
            <div id="applicationsList" class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 grid gap-10 lg:grid-cols-1">
                <p class="col-span-1 text-center text-slate-600 text-base">Loading applications...</p>
            </div>
            <div id="applications-description" class="sr-only">Your applications section. Review your job applications and track their progress.</div>
        </section>

        <script>
        function speakText(text) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(text);
                window.speechSynthesis.speak(utterance);
            }
        }
        </script>

        <script>
        (function(){
            const container = document.getElementById('applicationsList');
            const searchInput = document.getElementById('appSearchInput');
            const dateSelect = document.getElementById('appDateSelect');
            const statusSelect = document.getElementById('appStatusSelect');

            const esc = s => String(s === null || s === undefined ? '' : s)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');

            let allApps = [];

            // Normalize job-capacity status strings into canonical short values
            function normalizeStatus(raw) {
                try {
                    const s = (raw || '').toString().toLowerCase();
                    if (!s) return 'pending';
                    if (s.indexOf('pend') !== -1) return 'pending';
                    if (s.indexOf('feed') !== -1 || s.indexOf('feedback') !== -1) return 'feedback';
                    if (s.indexOf('review') !== -1 || s.indexOf('screen') !== -1 || s.indexOf('shortlist') !== -1 || s.indexOf('shortlisted') !== -1) return 'reviewed';
                    if (s.indexOf('withdraw') !== -1 || s.indexOf('cancel') !== -1) return 'withdrawn';
                    if (s.indexOf('hire') !== -1 || s.indexOf('placed') !== -1 || s.indexOf('accepted') !== -1) return 'hired';
                    return s;
                } catch (e) { return (raw || '').toString(); }
            }

            function tryParseDate(v){
                if (!v) return null;
                let d = new Date(v);
                if (!isNaN(d.getTime())) return d;
                const m = v.match(/(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})/);
                if (m){
                    return new Date(Number(m[1]), Number(m[2]) - 1, Number(m[3]));
                }
                // Handle formats like "11-JAN-26" or "11-JAN-2026" (day-monthAbbrev-year)
                const m2 = v.match(/^(\d{1,2})[-\/ ]([A-Za-z]{3,})[-\/ ](\d{2,4})/);
                if (m2){
                    const day = Number(m2[1]);
                    const mon = m2[2].toLowerCase().slice(0,3);
                    const monthMap = { jan:0, feb:1, mar:2, apr:3, may:4, jun:5, jul:6, aug:7, sep:8, oct:9, nov:10, dec:11 };
                    const rawYear = Number(m2[3]);
                    const year = rawYear < 100 ? (2000 + rawYear) : rawYear;
                    const monthIdx = monthMap[mon] !== undefined ? monthMap[mon] : 0;
                    return new Date(year, monthIdx, day);
                }
                return null;
            }

                        // Dynamic version of buildCard that overrides visual progress based on `status`
                        function buildCardDynamic(a){
                            const dateApplied = (function(){
                                if (!a || !a.created_at) return 'Unknown';
                                const d = tryParseDate(a.created_at);
                                return d ? esc(formatNiceDate(d)) : esc(a.created_at || 'Unknown');
                            })();

                            const statusRaw = normalizeStatus((a && a.status) ? a.status : 'pending');
                            const isPending = statusRaw === 'pending';
                            const isReview = statusRaw === 'reviewed';
                            const isFeedback = statusRaw === 'feedback';

                            // Determine which steps are checked/completed based on status
                            const submittedChecked = isPending || isReview || isFeedback;
                            const reviewChecked = isReview || isFeedback;
                            const feedbackChecked = isFeedback;

                            const submittedIconClass = submittedChecked ? 'w-12 h-12 flex items-center justify-center rounded-full border-4 border-green-500 bg-white shadow-md' : 'w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white';
                            const submittedLabelClass = submittedChecked ? 'mt-3 text-green-700 font-semibold text-sm' : 'mt-3 text-gray-600 text-xs sm:text-sm';

                            const reviewIconClass = reviewChecked ? 'w-12 h-12 flex items-center justify-center rounded-full border-4 border-green-500 bg-white shadow-md' : 'w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white';
                            const reviewLabelClass = reviewChecked ? 'mt-3 text-green-700 font-semibold text-sm' : 'mt-3 text-gray-600 text-xs sm:text-sm';

                            const feedbackIconClass = feedbackChecked ? 'w-12 h-12 flex items-center justify-center rounded-full border-4 border-green-500 bg-white shadow-md' : 'w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white';
                            const feedbackLabelClass = feedbackChecked ? 'mt-3 text-green-700 font-semibold text-sm' : 'mt-3 text-gray-600 text-xs sm:text-sm';

                            const conn1Class = reviewChecked ? 'h-1 w-full sm:w-12 bg-green-400' : 'h-1 w-full sm:w-12 bg-gray-300';
                            const conn2Class = feedbackChecked ? 'h-1 w-full sm:w-12 bg-green-400' : 'h-1 w-full sm:w-12 bg-gray-300';

                            const checkSvg = `<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6 text-green-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"3\" d=\"M5 13l4 4L19 7\" /></svg>`;
                            const submittedInnerSvg = submittedChecked ? checkSvg : '';
                            const reviewInnerSvg = reviewChecked ? checkSvg : '';
                            const feedbackInnerSvg = feedbackChecked ? checkSvg : '';

                            return `\n<div class="bg-white border-4 border-green-200 rounded-3xl shadow-lg overflow-hidden">\n  <div class="p-6">\n    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">${esc(a.job_role || 'Job Role')}</h3>\n    <p class="mt-2 text-lg sm:text-xl font-semibold text-gray-800">${esc(a.company_name || 'Company Name')}</p>\n  \n  <p class="mt-2 text-sm sm:text-base text-gray-700 flex items-center gap-2">\n      <img src=\"https://img.icons8.com/color/48/marker--v1.png\" class=\"w-6 h-6\"/>\n      ${esc(a.job_address || 'Location')}\n    </p>\n    <p class="mt-2 text-sm sm:text-base text-gray-700 flex items-center gap-2">\n      <img src=\"https://img.icons8.com/color/48/calendar--v1.png\" class=\"w-6 h-6\"/>\n      <span>Date Applied: ${dateApplied}</span>\n    </p>\n  </div>\n\n  <div class="bg-green-50 border-t-4 border-green-300 px-4 sm:px-8 py-6 sm:py-8">\n    <h2 class="text-base sm:text-lg lg:text-xl font-semibold text-gray-900 text-center mb-6">Application Progress</h2>\n    <div class="flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-between w-full max-w-full sm:max-w-3xl mx-auto gap-4 sm:gap-2">\n      <div class=\"flex flex-col items-center\">\n        <div class=\"${submittedIconClass}\">\n          ${submittedInnerSvg}\n        </div>\n        <p class=\"${submittedLabelClass}\">Application Submitted</p>\n        <p class=\"text-xs text-gray-500\">${dateApplied}</p>\n      </div>\n      <div class=\"${conn1Class}\"></div>\n      <div class=\"flex flex-col items-center\">\n        <div class=\"${reviewIconClass}\">\n          ${reviewInnerSvg}\n        </div>\n        <p class=\"${reviewLabelClass}\">Under Review</p>\n      </div>\n      <div class=\"${conn2Class}\"></div>\n      <div class=\"flex flex-col items-center\">\n        <div class=\"${feedbackIconClass}\">\n          ${feedbackInnerSvg}\n        </div>\n        <p class=\"${feedbackLabelClass}\">Feedback</p>\n      </div>\n          <div class=\"flex flex-col items-center opacity-40\">\n          </div>\n    </div>\n    <div class=\"text-center mt-10\"><p class=\"text-gray-600 text-xs sm:text-sm\">Last update: ${dateApplied}</p></div>\n  </div>\n</div>`;
                        }
            // Format a Date or date-string into "Month day, Year" (e.g. January 11, 2026)
            function formatNiceDate(v){
                if (!v) return 'Unknown';
                const d = (v instanceof Date) ? v : tryParseDate(v);
                if (!d) return esc(v || 'Unknown');
                const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
            }

            function buildCard(a){
                const dateApplied = (function(){
                    if (!a || !a.created_at) return 'Unknown';
                    const d = tryParseDate(a.created_at);
                    return d ? esc(formatNiceDate(d)) : esc(a.created_at || 'Unknown');
                })();
                return `\n<div class="bg-white border-4 border-green-200 rounded-3xl shadow-lg overflow-hidden">\n  <div class="p-6">\n    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">${esc(a.job_role || 'Job Role')}</h3>\n    <p class="mt-2 text-lg sm:text-xl font-semibold text-gray-800">${esc(a.company_name || 'Company Name')}</p>\n  \n  <p class="mt-2 text-sm sm:text-base text-gray-700 flex items-center gap-2">\n      <img src="https://img.icons8.com/color/48/marker--v1.png" class="w-6 h-6"/>\n      ${esc(a.job_address || 'Location')}\n    </p>\n    <p class="mt-2 text-sm sm:text-base text-gray-700 flex items-center gap-2">\n      <img src="https://img.icons8.com/color/48/calendar--v1.png" class="w-6 h-6"/>\n      <span>Date Applied: ${dateApplied}</span>\n    </p>\n  </div>\n\n  <div class="bg-green-50 border-t-4 border-green-300 px-4 sm:px-8 py-6 sm:py-8">\n    <h2 class="text-base sm:text-lg lg:text-xl font-semibold text-gray-900 text-center mb-6">Application Progress</h2>\n    <div class="flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-between w-full max-w-full sm:max-w-3xl mx-auto gap-4 sm:gap-2">\n      <div class="flex flex-col items-center">\n        <div class="w-12 h-12 flex items-center justify-center rounded-full border-4 border-green-500 bg-white shadow-md">\n          <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6 text-green-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"3\" d=\"M5 13l4 4L19 7\" />\n          </svg>\n        </div>\n        <p class=\"mt-3 text-green-700 font-semibold text-sm\">Application Submitted</p>\n        <p class=\"text-xs text-gray-500\">${dateApplied}</p>\n      </div>\n      <div class=\"h-1 w-full sm:w-12 bg-green-400\"></div>\n      <div class=\"flex flex-col items-center opacity-40\">\n        <div class=\"w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white\"></div>\n        <p class=\"mt-3 text-gray-600 text-xs sm:text-sm\">Under Review</p>\n      </div>\n      <div class=\"h-1 w-full sm:w-12 bg-gray-300\"></div>\n      <div class=\"flex flex-col items-center opacity-40\">\n        <div class=\"w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white\"></div>\n        <p class=\"mt-3 text-gray-600 text-xs sm:text-sm\">Feedback</p>\n      </div>\n          <div class=\"flex flex-col items-center opacity-40\">\n          </div>\n    </div>\n    <div class=\"text-center mt-10\"><p class=\"text-gray-600 text-xs sm:text-sm\">Last update: ${dateApplied}</p></div>\n  </div>\n</div>`;
            }

            function renderFiltered(){
                const q = (searchInput && searchInput.value || '').trim().toLowerCase();
                const dateFilter = dateSelect ? dateSelect.value : 'all_time';
                const statusFilter = statusSelect ? statusSelect.value : '';

                let apps = allApps.slice();

                if (q) {
                    apps = apps.filter(a => {
                        const hay = ((a.job_role||'') + ' ' + (a.company_name||'') + ' ' + (a.job_address||'') + ' ' + (a.email||'')).toLowerCase();
                        return hay.indexOf(q) !== -1;
                    });
                }

                if (dateFilter && dateFilter !== 'all_time'){
                    const now = new Date();
                    apps = apps.filter(a => {
                        const d = tryParseDate(a.created_at);
                        if (!d) return false;
                        const diff = now.getTime() - d.getTime();
                        if (dateFilter === 'today'){
                            return d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth() && d.getDate() === now.getDate();
                        } else if (dateFilter === 'this_week'){
                            return diff <= 7 * 24 * 3600 * 1000;
                        } else if (dateFilter === 'this_month'){
                            return diff <= 31 * 24 * 3600 * 1000;
                        }
                        return true;
                    });
                }

                // Filter by status if selected
                if (statusFilter) {
                    const sf = statusFilter.toLowerCase();
                    apps = apps.filter(a => normalizeStatus(a.status) === sf);
                }

                if (!apps || apps.length === 0){
                    const q = (searchInput && searchInput.value || '').trim().toLowerCase();
                    const dateFilter = dateSelect ? dateSelect.value : 'all_time';
                    const statusFilter = statusSelect ? statusSelect.value : '';
                    const noFilters = !q && dateFilter === 'all_time' && !statusFilter;
                    if (noFilters && allApps.length === 0) {
                        container.innerHTML = `
                            <div class="col-span-1 bg-blue-50 border-2 border-blue-200 rounded-2xl p-8 sm:p-12 text-center">
                                <div class="mb-4 text-5xl" aria-hidden="true">📋</div>
                                <p class="text-lg sm:text-xl font-bold text-gray-900 mb-2">No application yet</p>
                                <p class="text-slate-600">Start applying to jobs to see your applications here.</p>
                            </div>`;
                    } else {
                        container.innerHTML = `
                            <div class="col-span-1 bg-blue-50 border-2 border-blue-200 rounded-2xl p-8 sm:p-12 text-center">
                                <div class="mb-4 text-5xl" aria-hidden="true">📋</div>
                                <p class="text-lg sm:text-xl font-bold text-gray-900 mb-2">No applications match your filters</p>
                                <p class="text-slate-600">Try adjusting your search or filter criteria.</p>
                            </div>`;
                    }
                    return;
                }

                container.innerHTML = apps.map(a => buildCardDynamic(a)).join('');

                // Insert status badges into rendered cards (post-process to avoid editing the JS template string)
                (function(){
                    const nodes = Array.from(container.children || []);
                    for (let i = 0; i < apps.length && i < nodes.length; i++){
                        try{
                            const app = apps[i] || {};
                            const node = nodes[i];
                            const p6 = node.querySelector('.p-6');
                                if (p6){
                                    // create/insert withdraw button next to job role by wrapping the h3
                                    try {
                                        const h3 = p6.querySelector('h3');
                                        if (h3) {
                                            const wrapper = document.createElement('div');
                                            wrapper.className = 'flex flex-col sm:flex-row items-start justify-between w-full gap-3';
                                            const clonedH3 = h3.cloneNode(true);

                                            // Button container (withdraw + feedback)
                                            const btnWrap = document.createElement('div');
                                            btnWrap.className = 'flex flex-wrap items-center justify-start sm:justify-end gap-2';

                                            const btn = document.createElement('button');
                                            btn.type = 'button';
                                            btn.className = 'withdraw-btn bg-red-50 text-red-700 hover:bg-red-100 px-3 py-2 rounded-full text-sm font-semibold border border-red-200';
                                            btn.setAttribute('data-app-id', String(app.id || ''));
                                            btn.textContent = 'Withdraw';

                                            const fb = document.createElement('a');
                                            fb.href = '/job-application-feedback?application_id=' + encodeURIComponent(String(app.id || ''));
                                            fb.className = 'bg-blue-600 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-blue-700';
                                            fb.textContent = 'View Application Feedback';

                                            btnWrap.appendChild(btn);
                                            btnWrap.appendChild(fb);

                                            wrapper.appendChild(clonedH3);
                                            wrapper.appendChild(btnWrap);
                                            p6.insertBefore(wrapper, h3);
                                            p6.removeChild(h3);
                                        }
                                    } catch (wrapErr) {
                                        // ignore wrapper errors
                                    }

                                    const badge = document.createElement('p');
                                    badge.className = 'mt-3';
                                    const statusRaw = (app && app.status) ? String(app.status).toLowerCase() : 'pending';
                                    // Color mapping: Pending = Gray, Under Review = Yellow, Feedback = Green
                                    let statusClass = 'bg-gray-100 text-gray-800';
                                    if (statusRaw === 'pending') statusClass = 'bg-gray-100 text-gray-800';
                                    else if (statusRaw === 'reviewed' || statusRaw.indexOf('review') !== -1) statusClass = 'bg-yellow-100 text-yellow-800';
                                    else if (statusRaw === 'feedback') statusClass = 'bg-green-100 text-green-800';
                                    const label = (app && app.status) ? (app.status.charAt(0).toUpperCase() + app.status.slice(1)) : 'Pending';
                                    badge.innerHTML = '<span class="inline-block px-4 py-2 rounded-full text-sm font-semibold text-lg ' + statusClass + '">Status: ' + esc(label) + '</span>';
                                    // Insert the badge after the job role wrapper (before the company name) when possible
                                    if (p6.children.length >= 2){
                                        p6.insertBefore(badge, p6.children[1]);
                                    } else {
                                        p6.appendChild(badge);
                                    }
                                }
                        } catch (e) {
                            // ignore insertion errors
                        }
                    }
                })();
            }

            async function fetchAndRender(){
                try{
                    console.log('Starting fetch for applications');
                    container.innerHTML = '<p class="col-span-1 text-center text-slate-600 text-base">Loading applications…</p>';
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
                    // include credentials so same-origin session cookie is sent to the API
                    const res = await fetch('/db/get-applications.php', { signal: controller.signal, credentials: 'same-origin' });
                    clearTimeout(timeoutId);
                    console.log('Fetch response:', res);
                    const j = await res.json();
                    console.log('JSON response:', j);
                    if (!j || !j.success){
                        container.innerHTML = `
                            <div class="col-span-1 bg-red-50 border-2 border-red-200 rounded-2xl p-8 sm:p-12 text-center">
                                <div class="mb-4 text-5xl" aria-hidden="true">❌</div>
                                <p class="text-lg sm:text-xl font-bold text-red-900 mb-2">Failed to load applications</p>
                                <p class="text-red-600">${esc((j && j.error) || 'Please try again later.')}</p>
                            </div>`;
                        return;
                    }
                        allApps = j.applications || [];
                        // update hero count button
                        const btnTextEl = document.getElementById('applicationsCountText');
                        const overviewCountEl = document.getElementById('applicationsOverviewCountText');
                        const totalApps = allApps.length;
                        const countText = totalApps === 0 ? 'No applications yet' : `${totalApps} Application${totalApps !== 1 ? 's' : ''}`;
                        if (btnTextEl) {
                            btnTextEl.textContent = countText;
                        }
                        if (overviewCountEl) {
                            overviewCountEl.textContent = totalApps === 0 ? 'No applications yet' : `Application overview: ${countText}`;
                        }
                        renderFiltered();
                }catch(err){
                    console.error('load applications error', err);
                    let errorMsg = 'Please try again later.';
                    if (err.name === 'AbortError') {
                        errorMsg = 'Request timed out. Please check your connection.';
                    }
                    container.innerHTML = `
                        <div class="col-span-1 bg-red-50 border-2 border-red-200 rounded-2xl p-8 sm:p-12 text-center">
                            <div class="mb-4 text-5xl" aria-hidden="true">❌</div>
                            <p class="text-lg sm:text-xl font-bold text-red-900 mb-2">Error loading applications</p>
                            <p class="text-red-600">${errorMsg}</p>
                        </div>`;
                }
            }

            if (searchInput){
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter'){
                        e.preventDefault();
                        renderFiltered();
                    }
                });
            }
            if (dateSelect){
                dateSelect.addEventListener('change', () => renderFiltered());
            }
            if (statusSelect){
                statusSelect.addEventListener('change', () => renderFiltered());
            }
            const filterBtn = document.getElementById('filterBtn');
            if (filterBtn){
                filterBtn.addEventListener('click', () => renderFiltered());
            }

            // Delegated handler for Withdraw buttons (asks confirmation, calls PHP endpoint)
            container.addEventListener('click', async (ev) => {
                try {
                    const btn = ev.target.closest ? ev.target.closest('.withdraw-btn') : null;
                    if (!btn) return;
                    const appId = btn.getAttribute('data-app-id') || btn.dataset.appId;
                    if (!appId) return;
                    const ok = window.confirm('Are you sure to withdraw your application?');
                    if (!ok) return;
                    btn.disabled = true; btn.classList.add('opacity-50');
                    try {
                        const res = await fetch('/db/withdraw_application.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ application_id: appId })
                        });
                        const j = await res.json().catch(() => null);
                            if (j && j.success){
                            // if server deleted the application, remove it from local list
                            if (j.deleted) {
                                allApps = (allApps || []).filter(a => String(a.id) !== String(appId));
                                renderFiltered();
                                return;
                            }
                            // update local model and re-render (fallback)
                            allApps = (allApps || []).map(a => { if (String(a.id) === String(appId)) a.status = (j.status || 'withdrawn'); return a; });
                            renderFiltered();
                        } else {
                            // If server returned allowed_statuses, offer a sensible retry
                            if (j && Array.isArray(j.allowed_statuses) && j.allowed_statuses.length){
                                const allowed = j.allowed_statuses.slice();
                                const prefs = ['CANCELLED','CANCEL','WITHDRAWN','RETRACTED','REMOVED'];
                                let pick = null;
                                for (const p of prefs){
                                    const found = allowed.find(a => String(a).toUpperCase() === p);
                                    if (found){ pick = found; break; }
                                }
                                if (pick){
                                    const ok2 = window.confirm('Database only allows status values: ' + allowed.join(', ') + "\n\nUse '"+pick+"' to withdraw instead?");
                                    if (ok2){
                                        // retry with chosen status
                                        try {
                                            const r2 = await fetch('/db/withdraw_application.php', {
                                                method: 'POST',
                                                headers: { 'Content-Type': 'application/json' },
                                                body: JSON.stringify({ application_id: appId, status: pick })
                                            });
                                            const j2 = await r2.json().catch(() => null);
                                            if (j2 && j2.success){
                                                allApps = (allApps || []).map(a => { if (String(a.id) === String(appId)) a.status = (j2.status || pick); return a; });
                                                renderFiltered();
                                                return;
                                            } else {
                                                alert('Update failed: ' + (j2 && (j2.error || JSON.stringify(j2))) );
                                            }
                                        } catch (e2) {
                                            alert('Network error while retrying withdraw');
                                        }
                                    }
                                } else {
                                    alert('Update failed. Allowed statuses: ' + allowed.join(', '));
                                }
                            } else {
                                // show detailed error when available
                                let detail = 'Failed to withdraw application';
                                if (j) {
                                    if (j.error) detail = j.error;
                                    else if (j.oci && (j.oci.message || j.oci['message'])) detail = j.oci.message || j.oci['message'];
                                    else if (j.oci) detail = JSON.stringify(j.oci);
                                }
                                alert(detail);
                            }
                            console.error('withdraw error', j);
                            btn.disabled = false; btn.classList.remove('opacity-50');
                        }
                    } catch (e) {
                        alert('Network error while withdrawing application');
                        btn.disabled = false; btn.classList.remove('opacity-50');
                        console.error(e);
                    }
                } catch (outer) {
                    // ignore
                }
            });

            fetchAndRender();
        })();
        </script>

        <!-- TTS: Web Speech API handler (same behavior as Job Matches) -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = Array.from(document.querySelectorAll('.tts-btn'));
                const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
                const preferredTagalogVoiceName = 'fil-PH-RosaNeural';
                let preferredEnglishVoice = null;
                let preferredTagalogVoice = null;
                let currentBtn = null;
                let availableVoices = [];

                function populateVoices() {
                    availableVoices = window.speechSynthesis.getVoices() || [];
                    preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName) ||
                        availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) || null;
                    preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName) ||
                        availableVoices.find(v => /rosa|blessica|fil-?ph|filipino|tagalog/i.test(v.name)) || null;
                }

                function chooseVoiceForLang(langCode) {
                    if (!availableVoices.length) return null;
                    langCode = (langCode || '').toLowerCase();
                    let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                    if (candidates.length) return candidates[0];
                    candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
                    if (candidates.length) return candidates[0];
                    return availableVoices[0];
                }

                function stopSpeaking() {
                    if (window.speechSynthesis) {
                        window.speechSynthesis.cancel();
                    }
                    if (currentBtn) {
                        currentBtn.classList.remove('speaking');
                        currentBtn.removeAttribute('aria-pressed');
                        currentBtn = null;
                    }
                }

                buttons.forEach(function(btn) {
                    btn.setAttribute('role', 'button');
                    btn.setAttribute('tabindex', '0');

                    btn.addEventListener('click', function(event) {
                        event.preventDefault();
                        event.stopPropagation();
                        const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                        const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                        if (!textEn && !textTl) return;

                        if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
                            stopSpeaking();
                            return;
                        }

                        stopSpeaking();

                        setTimeout(function() {
                            if (!window.speechSynthesis) return;

                            function voiceFor(langHint) {
                                if (langHint) {
                                    const hint = (langHint || '').toLowerCase();
                                    if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                                        if (preferredTagalogVoice) return preferredTagalogVoice;
                                        return chooseVoiceForLang('tl');
                                    }
                                    if (hint.startsWith('en')) {
                                        if (preferredEnglishVoice) return preferredEnglishVoice;
                                        return chooseVoiceForLang('en');
                                    }
                                }
                                return preferredEnglishVoice || chooseVoiceForLang('en') ||
                                    (availableVoices.length ? availableVoices[0] : null);
                            }

                            const seq = [];
                            if (textEn) {
                                const uEn = new SpeechSynthesisUtterance(textEn);
                                uEn.lang = 'en-US';
                                const v = voiceFor('en');
                                if (v) uEn.voice = v;
                                seq.push(uEn);
                            }
                            if (textTl) {
                                const uTl = new SpeechSynthesisUtterance(textTl);
                                uTl.lang = 'fil-PH';
                                const v2 = voiceFor('tl');
                                if (v2) uTl.voice = v2;
                                seq.push(uTl);
                            }
                            if (!seq.length) return;

                            seq[0].onstart = function() {
                                btn.classList.add('speaking');
                                btn.setAttribute('aria-pressed', 'true');
                                currentBtn = btn;
                            };

                            for (let i = 0; i < seq.length; i++) {
                                const ut = seq[i];
                                ut.onerror = function() {
                                    if (btn) btn.classList.remove('speaking');
                                    if (btn) btn.removeAttribute('aria-pressed');
                                    currentBtn = null;
                                };
                                if (i < seq.length - 1) {
                                    ut.onend = function() {
                                        window.speechSynthesis.speak(seq[i + 1]);
                                    };
                                } else {
                                    ut.onend = function() {
                                        if (btn) btn.classList.remove('speaking');
                                        if (btn) btn.removeAttribute('aria-pressed');
                                        currentBtn = null;
                                    };
                                }
                            }

                            window.speechSynthesis.speak(seq[0]);
                        }, 50);
                    });

                    btn.addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter' || ev.key === ' ') {
                            ev.preventDefault();
                            ev.stopPropagation();
                            btn.click();
                        }
                    });
                });

                window.addEventListener('beforeunload', function() {
                    if (window.speechSynthesis) window.speechSynthesis.cancel();
                });

                if (window.speechSynthesis) {
                    populateVoices();
                    window.speechSynthesis.onvoiceschanged = function() {
                        populateVoices();
                    };
                }
            });
        </script>




    <!-- Ã¢Å“â€“Ã¯Â¸Â -->
    @php
        $csv_path = public_path('resume_job_matching_dataset.csv');
        $savedJobs = $savedJobs ?? [];
        $jobs = [];
        if (file_exists($csv_path)) {
            if (($handle = fopen($csv_path, 'r')) !== false) {
                $header = fgetcsv($handle);
                $i = 0;
                while (($row = fgetcsv($handle)) !== false) {
                    if (in_array($i, $savedJobs)) {
                        $jobs[] = [
                            'id' => $i,
                            'job_description' => $row[0],
                            'resume' => $row[1],
                            'match_score' => $row[2],
                            'industry' => $row[3] ?? '',
                            'fit_level' => $row[4] ?? '',
                            'growth_potential' => $row[5] ?? '',
                            'work_environment' => $row[6] ?? '',
                        ];
                    }
                    $i++;
                }
                fclose($handle);
            }
        }
    @endphp

    <!--Saved Jobs
     <div class="max-w-5xl mx-auto mt-10 px-4">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Saved Jobs</h2>
        @if (empty($jobs))
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded text-center">
                You have no saved jobs yet.
            </div>
@else
    @foreach ($jobs as $job)
    <div class="border rounded-lg bg-white shadow-sm mb-8">
                    <div class="p-4 flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $job['job_description'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $job['resume'] }}</p>
                            <div class="flex gap-2 text-xs mt-2">
                                @if ($job['industry'])
    <span class="bg-gray-100 px-2 py-1 rounded">{{ $job['industry'] }}</span>
    @endif
                                @if ($job['work_environment'])
    <span class="bg-gray-100 px-2 py-1 rounded">{{ $job['work_environment'] }}</span>
    @endif
                            </div>
                            <div class="flex gap-2 mt-2">
                                @if ($job['fit_level'])
    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $job['fit_level'] }}</span>
    @endif
                                @if ($job['growth_potential'])
    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">{{ $job['growth_potential'] }}</span>
    @endif
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Match Score: {{ $job['match_score'] }}</p>
                        </div>
                        <div class="flex flex-col gap-2 mt-4 md:mt-0">
                            <a href="{{ route('job.details', ['job_id' => $job['id']]) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-center">
                                View Details
                            </a>
                            <form method="POST" action="{{ route('my.job.applications.remove') }}">
                                @csrf
                                <input type="hidden" name="job_id" value="{{ $job['id'] }}">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-center">Remove</button>
                            </form>
                        </div>
                    </div>
                </div> -->
    @endforeach
    @endif
    </div>
    </div>
@endsection

<!-- Require sign-in on My Job Applications page -->
{{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
{{-- <script type="module">
  (async function(){
    try {
      const mod = await import("{{ asset('js/job-application-firebase.js') }}");
      const signed = await mod.isSignedIn(2500);
      if (!signed) {
        if (window.__SERVER_AUTH) {
          console.info('Auth guard: server session present, not redirecting');
        } else {
          const current = window.location.pathname + window.location.search;
          window.location.href = 'login?redirect=' + encodeURIComponent(current);
          return;
        }
      }
    } catch (err) {
      console.error('Auth guard failed on my-job-applications', err);
    }
  })();
</script> --}}


