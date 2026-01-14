@extends('layouts.includes')

@section('content')

    <!-- NOTE: THIS IS STILL IN PROGRESS, I'M NOT SURE PANO AANUHIN YAN -->
    <!-- Back Button -->
    <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
        <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
            <a href="/job-matches"
                class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                    class="w-8 h-8 sm:w-10 sm:h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Jobs</span>
            </a>
        </div>
    </div>

    <!-- HERO SECTION -->
    <section class="bg-[#D78203] py-10 text-center shadow-md rounded-b-3xl">
        <div class="flex flex-col items-center justify-center">
            <img src="{{ asset('image/my-job-app.png') }}" alt="Brain Icon" class="w-24 h-24 mb-3 animate-bounce-slow">
            <h2 class="text-4xl font-extrabold text-white tracking-wide drop-shadow-md">
                My Job Application
            </h2>
            <p class="text-lg text-white/90 mt-2 max-w-2xl">
                Track your application progress and manage your job applications
            </p>
        </div>
    </section>

    <!-- APPLICATION STATS -->
    <section class="max-w-6xl mx-auto mt-10 px-6 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
        <div class="bg-[#FFF6E5] border-4 border-[#FFD27F] rounded-3xl shadow-md p-6">
            <img src="https://img.icons8.com/emoji/48/hourglass-not-done.png" alt="Pending Icon" class="mx-auto mb-2">
            <h3 class="text-4xl font-extrabold text-[#D78203]"><span id="statPendingCount">-</span></h3>
            <p class="text-lg font-semibold text-gray-800 mt-1">In Progress</p>
        </div>

        <div class="bg-[#E9FFE9] border-4 border-[#8BE18B] rounded-3xl shadow-md p-6">
            <img src="https://img.icons8.com/emoji/48/check-mark-emoji.png" alt="Review Icon" class="mx-auto mb-2">
            <h3 class="text-4xl font-extrabold text-[#1F8B24]"><span id="statReviewedCount">-</span></h3>
            <p class="text-lg font-semibold text-gray-800 mt-1">Under Review</p>
        </div>

        <div class="bg-[#E8F3FF] border-4 border-[#7FBFFF] rounded-3xl shadow-md p-6">
            <img src="https://img.icons8.com/emoji/48/file-folder-emoji.png" alt="Applications Icon" class="mx-auto mb-2">
            <h3 class="text-4xl font-extrabold text-[#007BFF]"><span id="statTotalCount">-</span></h3>
            <p class="text-lg font-semibold text-gray-800 mt-1">Total Applications</p>
        </div>
    </section>

    <!-- SEARCH & FILTER  -->
    <section class="max-w-6xl mx-auto mt-10 px-6">
        <div
            class="bg-white border-4 border-blue-200 rounded-3xl shadow-md p-6 
              flex flex-col sm:flex-row items-center justify-between gap-4">

            <!-- Search Input -->
            <div
                class="flex items-center border-2 border-gray-300 rounded-full px-4 py-3 
                w-full sm:max-w-lg bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 mr-3" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 6.65a7.5 7.5 0 010 10.6z" />
                </svg>
                <input id="appSearchInput" type="text" placeholder="Search your application"
                    class="w-full bg-transparent text-lg focus:outline-none text-gray-700 font-medium">
            </div>

            <!-- Dropdowns -->
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">

                <!-- Status Dropdown -->
                <div class="relative w-full sm:w-48">
                    <select id="appStatusSelect"
                        class="appearance-none bg-blue-100 text-blue-800 px-5 py-3 rounded-full text-lg font-semibold
        shadow-sm hover:bg-blue-200 transition w-full
        border-0 outline-none focus:outline-none focus-visible:outline-none focus:ring-0">
                        <option value="" selected>Status</option>
                        <option value="pending">Pending</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Date Dropdown -->
                <div class="relative w-full sm:w-48">
                    <select id="appDateSelect"
                        class="appearance-none bg-blue-100 text-blue-800 px-5 py-3 rounded-full text-lg
                       font-semibold shadow-sm hover:bg-blue-200 transition 
                       w-full focus:outline-none focus:ring-0 border-none focus-visible:outline-none">
                        <option value="" selected>Date</option>
                        <option value="today">Today</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="all_time">All Time</option>
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

        <!-- JOB APPLICATIONS LIST -->
        <section class="max-w-6xl mx-auto mt-8 px-6 mb-16">
                <div id="applicationsList" class="space-y-8">
                        <div class="text-center text-gray-500 py-8">Loading applications…</div>
                </div>
        </section>

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
                return `\n<div class="bg-white border-4 border-green-200 rounded-3xl shadow-lg overflow-hidden">\n  <div class="p-6">\n    <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">${esc(a.job_role || 'Job Role')}</h3>\n    <p class="mt-2 text-lg text-gray-700">${esc(a.company_name || 'Company Name')}</p>\n    <p class="mt-2 text-lg text-gray-700 flex items-center gap-2">\n      <img src="https://img.icons8.com/color/48/marker--v1.png" class="w-6 h-6"/>\n      ${esc(a.job_address || 'Location')}\n    </p>\n    <p class="mt-4 text-base text-gray-700 flex items-center gap-2">\n      <img src="https://img.icons8.com/color/48/calendar--v1.png" class="w-6 h-6"/>\n      <span>Date Applied: ${dateApplied}</span>\n    </p>\n  </div>\n\n  <div class="bg-green-50 border-t-4 border-green-300 px-8 py-10">\n    <h2 class="text-xl font-semibold text-black text-center mb-10">Application Progress</h2>\n    <div class="flex items-center justify-between w-full max-w-3xl mx-auto">\n      <div class="flex flex-col items-center">\n        <div class="w-12 h-12 flex items-center justify-center rounded-full border-4 border-green-500 bg-white shadow-md">\n          <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6 text-green-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"3\" d=\"M5 13l4 4L19 7\" />\n          </svg>\n        </div>\n        <p class=\"mt-3 text-green-700 font-semibold text-sm\">Application Submitted</p>\n        <p class=\"text-xs text-gray-500\">${dateApplied}</p>\n      </div>\n      <div class=\"h-1 w-12 bg-green-400\"></div>\n      <div class=\"flex flex-col items-center opacity-40\">\n        <div class=\"w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white\"></div>\n        <p class=\"mt-3 text-gray-600 text-sm\">Under Review</p>\n      </div>\n      <div class=\"h-1 w-12 bg-gray-300\"></div>\n      <div class=\"flex flex-col items-center opacity-40\">\n        <div class=\"w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white\"></div>\n        <p class=\"mt-3 text-gray-600 text-sm\">Under Training</p>\n      </div>\n      <div class=\"h-1 w-12 bg-gray-300\"></div>\n      <div class=\"flex flex-col items-center opacity-40\">\n        <div class=\"w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white\"></div>\n        <p class=\"mt-3 text-gray-600 text-sm\">Decision</p>\n      </div>\n    </div>\n    <div class=\"text-center mt-10\"><p class=\"text-gray-600 text-sm\">Last update: ${dateApplied}</p></div>\n  </div>\n</div>`;
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
                    apps = apps.filter(a => ((a.status || '').toLowerCase()) === sf);
                }

                if (!apps || apps.length === 0){
                    container.innerHTML = `<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded text-center">No applications match your filters.</div>`;
                    return;
                }

                container.innerHTML = apps.map(a => buildCard(a)).join('');

                // Insert status badges into rendered cards (post-process to avoid editing the JS template string)
                (function(){
                    const nodes = Array.from(container.children || []);
                    for (let i = 0; i < apps.length && i < nodes.length; i++){
                        try{
                            const app = apps[i] || {};
                            const node = nodes[i];
                            const p6 = node.querySelector('.p-6');
                            if (p6){
                                const badge = document.createElement('p');
                                badge.className = 'mt-2';
                                badge.innerHTML = '<span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Status: ' + esc(app.status || 'Pending') + '</span>';
                                if (p6.children.length >= 2){
                                    p6.insertBefore(badge, p6.children[2]);
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
                    container.innerHTML = '<div class="text-center text-gray-500 py-8">Loading applications…</div>';
                    const res = await fetch('/db/get-applications.php');
                    const j = await res.json();
                    if (!j || !j.success){
                        container.innerHTML = `<div class="p-6 text-center text-red-600">${esc((j && j.error) || 'Failed to load applications')}</div>`;
                        return;
                    }
                        allApps = j.applications || [];
                        // update stat cards
                        (function updateStats(apps){
                            const total = apps.length || 0;
                            const pending = apps.filter(a => ((a.status||'').toLowerCase()) === 'pending').length;
                            const reviewed = apps.filter(a => ((a.status||'').toLowerCase()) === 'reviewed').length;
                            const elTotal = document.getElementById('statTotalCount');
                            const elPending = document.getElementById('statPendingCount');
                            const elReviewed = document.getElementById('statReviewedCount');
                            if (elTotal) elTotal.textContent = total;
                            if (elPending) elPending.textContent = pending;
                            if (elReviewed) elReviewed.textContent = reviewed;
                        })(allApps);
                        renderFiltered();
                }catch(err){
                    container.innerHTML = `<div class="p-6 text-center text-red-600">Error loading applications</div>`;
                    console.error('load applications error', err);
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

            fetchAndRender();
        })();
        </script>




    <!-- âœ–ï¸ -->
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
