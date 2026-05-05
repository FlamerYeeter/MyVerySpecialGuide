@extends('layouts.app')

@section('content')

<div id="page-loading-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white/95 transition-opacity duration-300">
    <div class="text-center">
        <div class="h-14 w-14 rounded-full border-4 border-blue-200 border-t-blue-700 animate-spin mx-auto" aria-hidden="true"></div>
        <p class="mt-4 text-base font-semibold text-slate-900">Loading content…</p>
    </div>
</div>

<div class="bg-slate-50 flex flex-col flex-1 min-h-0">

<!-- HERO SEARCH -->
<section class="bg-sky-50 py-12 sm:py-16 border-b border-sky-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">

        <div class="text-center space-y-6 mb-12">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900">
                Find a <span class="text-blue-700">perfect job</span> for you
            </h1>

            <p class="text-xl sm:text-2xl text-slate-800 max-w-3xl mx-auto leading-relaxed">
                Search inclusive jobs from companies that support growth and opportunities.
            </p>
        </div>

        <!-- SEARCH CARD -->
        <form id="job-search-form" class="rounded-[2rem] bg-white border border-sky-200 shadow-sm p-6 sm:p-10 space-y-6">

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">

                <!-- Job -->
                <div class="space-y-3">
                    <label class="text-xl font-semibold text-slate-900">Job title or role</label>
                    <div class="relative">
                        <img src="https://img.icons8.com/ios-filled/20/search--v1.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                        <input id="job-title" name="job-title" type="text" autocomplete="off" placeholder="e.g. Service Crew" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-12 py-4 text-lg text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="job-title-help job-title-suggestions">
                        <div id="job-title-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-64 overflow-y-auto hidden z-10">
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Service Crew">Service Crew</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Barista">Barista</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Kitchen Helper">Kitchen Helper</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Housekeeping">Housekeeping</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Food Runner">Food Runner</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 last:border-b-0" data-value="Front Desk">Front Desk</button>
                        </div>
                    </div>
                    <p id="job-title-help" class="text-base text-slate-700 font-medium">Type the job you want or pick from our list.</p>
                </div>

                <!-- Location -->
                <div class="space-y-3">
                    <label class="text-xl font-semibold text-slate-900">City or area</label>
                    <div class="relative">
                        <img src="https://img.icons8.com/ios-filled/20/marker.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                        <input id="location" name="location" type="text" autocomplete="off" placeholder="e.g. Taguig City" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-12 py-4 text-lg text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="location-help location-suggestions">
                        <div id="location-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-64 overflow-y-auto hidden z-10">
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Taguig City">Taguig City</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Mandaluyong City">Mandaluyong City</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Makati City">Makati City</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Pasig City">Pasig City</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Quezon City">Quezon City</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 last:border-b-0" data-value="Paranaque City">Paranaque City</button>
                        </div>
                    </div>
                    <p id="location-help" class="text-base text-slate-700 font-medium">Type the city where you want to work or pick from our list.</p>
                </div>

                <!-- Work Type -->
                <div class="space-y-3">
                    <label class="text-xl font-semibold text-slate-900">Work type</label>
                    <div class="relative">
                        <img src="https://img.icons8.com/ios-filled/20/briefcase.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                        <input id="work-type" name="work-type" type="text" autocomplete="off" placeholder="Full-time / Part-time" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-12 py-4 text-lg text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="work-type-help work-type-suggestions">
                        <div id="work-type-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-64 overflow-y-auto hidden z-10">
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Full-time">Full-time</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Part-time">Part-time</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Contract">Contract</button>
                        </div>
                    </div>
                    <p id="work-type-help" class="text-base text-slate-700 font-medium">Select the type of employment you're looking for.</p>
                </div>

                <!-- Environment -->
                <div class="space-y-3">
                    <label class="text-xl font-semibold text-slate-900">Work environment</label>
                    <div class="relative">
                        <img src="https://img.icons8.com/ios-filled/20/search--v1.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                        <input id="environment" name="environment" type="text" autocomplete="off" placeholder="Friendly and kind" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-12 py-4 text-lg text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="environment-help environment-suggestions">
                        <div id="environment-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-64 overflow-y-auto hidden z-10">
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Friendly team">A friendly and kind team</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Supportive environment">People who help you</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Inclusive workplace">Everyone is welcome</button>
                            <button type="button" class="suggestion-item w-full text-left px-4 py-3.5 text-base hover:bg-blue-50 last:border-b-0" data-value="Positive atmosphere">Happy place to work</button>
                        </div>
                    </div>
                    <p id="environment-help" class="text-base text-slate-700 font-medium">Pick a workplace that feels good to you.</p>
                </div>
            </div>

            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-700 px-6 py-3.5 text-base font-semibold text-white shadow-lg transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <img src="https://img.icons8.com/ios-filled/20/ffffff/search.png" alt="" aria-hidden="true">
                Search jobs
            </button>

        </form>

        <div id="search-tags" class="hidden max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 mt-6">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-widest text-slate-500 mb-3">Search tags</p>
                <div id="search-tags-list" class="flex flex-wrap gap-2"></div>
            </div>
        </div>

        <script>
            const suggestionFields = [

                {
                    input: document.getElementById('job-title'),
                    container: document.getElementById('job-title-suggestions'),
                },
                {
                    input: document.getElementById('location'),
                    container: document.getElementById('location-suggestions'),
                },
                {
                    input: document.getElementById('work-type'),
                    container: document.getElementById('work-type-suggestions'),
                },
                {
                    input: document.getElementById('environment'),
                    container: document.getElementById('environment-suggestions'),
                },
            ];

            function filterSuggestions(input, container) {
                const query = input.value.trim().toLowerCase();
                const suggestions = Array.from(container.querySelectorAll('.suggestion-item'));

                let visibleCount = 0;
                suggestions.forEach(item => {
                    const value = item.dataset.value.toLowerCase();
                    const match = query === '' || value.includes(query);
                    item.style.display = match ? 'block' : 'none';
                    if (match) visibleCount += 1;
                });

                if (visibleCount > 0 && (query.length > 0 || document.activeElement === input)) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }

            suggestionFields.forEach(({ input, container }) => {
                input.addEventListener('focus', () => filterSuggestions(input, container));
                input.addEventListener('input', () => filterSuggestions(input, container));
                input.addEventListener('blur', () => setTimeout(() => container.classList.add('hidden'), 200));

                container.querySelectorAll('.suggestion-item').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        input.value = btn.dataset.value;
                        container.classList.add('hidden');
                    });
                });
            });

            const searchForm = document.getElementById('job-search-form');
            const searchTagsContainer = document.getElementById('search-tags');
            const searchTagsList = document.getElementById('search-tags-list');
            const searchFields = [
                { id: 'job-title', label: 'Job' },
                { id: 'location', label: 'Location' },
                { id: 'work-type', label: 'Work type' },
                { id: 'environment', label: 'Environment' },
            ];

            function renderSearchTags() {
                searchTagsList.innerHTML = '';
                const tags = searchFields
                    .map(field => ({
                        input: document.getElementById(field.id),
                        label: field.label,
                    }))
                    .filter(({ input }) => input && input.value.trim().length > 0)
                    .map(({ input, label }) => ({
                        value: input.value.trim(),
                        label,
                        input,
                    }));

                if (tags.length === 0) {
                    searchTagsContainer.classList.add('hidden');
                    return;
                }

                tags.forEach(tag => {
                    const pill = document.createElement('button');
                    pill.type = 'button';
                    pill.className = 'inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-200';
                    pill.innerHTML = `<span>${tag.label}: ${tag.value}</span><span aria-hidden="true">×</span>`;
                    pill.addEventListener('click', () => {
                        tag.input.value = '';
                        renderSearchTags();
                    });
                    searchTagsList.appendChild(pill);
                });

                searchTagsContainer.classList.remove('hidden');
            }

            async function fetchAndRenderJobs(params = {}) {
                const container = document.getElementById('job-results-list');
                const countEl = document.getElementById('results-count');
                const loadMoreBtn = document.getElementById('load-more-btn');
                if (!container) return;
                container.innerHTML = '<div class="py-8 text-center col-span-3">Loading jobs…</div>';
                const qs = new URLSearchParams();
                qs.set('limit', params.limit || 10);
                const title = params.title !== undefined ? params.title : (document.getElementById('job-title')||{}).value || '';
                const location = params.location !== undefined ? params.location : (document.getElementById('location')||{}).value || '';
                const job_type = params.job_type !== undefined ? params.job_type : (document.getElementById('work-type')||{}).value || '';
                const work_environment = params.work_environment !== undefined ? params.work_environment : (document.getElementById('environment')||{}).value || '';
                if (title) qs.set('title', title);
                if (location) qs.set('location', location);
                if (job_type) qs.set('job_type', job_type);
                if (work_environment) qs.set('work_environment', work_environment);

                try {
                    const res = await fetch('/db/get-jobs.php?' + qs.toString(), { credentials: 'same-origin' });
                    const data = await res.json();
                    if (!data || !data.success || !Array.isArray(data.jobs)) {
                        container.innerHTML = '<div class="py-8 text-center col-span-3 text-slate-600">No jobs found.</div>';
                        if (countEl) countEl.textContent = 'Showing 0 of 0 results';
                        return;
                    }
                    const jobs = data.jobs;
                    container.innerHTML = '';
                    if (jobs.length === 0) {
                        container.innerHTML = '<div class="py-8 text-center col-span-3 text-slate-600">No jobs match your search.</div>';
                    } else {
                        jobs.forEach(job => {
                            const art = document.createElement('article');
                            art.className = 'group rounded-[1.75rem] bg-white border-2 border-slate-200 p-7 shadow-md flex flex-col md:flex-row md:items-center justify-between gap-6 transition duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-blue-400 hover:bg-blue-50 cursor-pointer';

                            const left = document.createElement('div');
                            left.className = 'flex items-center gap-5 flex-1';

                            const logoWrap = document.createElement('div');
                            logoWrap.className = 'rounded-2xl bg-blue-50 p-4 shadow-sm';
                            const logo = document.createElement('img');
                            logo.src = job.logo || job.company_image_data_uri || 'https://via.placeholder.com/150?text=Logo';
                            logo.alt = job.company_name || 'Company logo';
                            logo.className = 'w-16 h-16 rounded-2xl object-cover';
                            logoWrap.appendChild(logo);

                            const info = document.createElement('div');
                            const h3 = document.createElement('h3');
                            h3.className = 'text-3xl font-bold text-slate-900';
                            h3.textContent = job.job_role || 'Job Role';
                            const pmeta = document.createElement('p');
                            pmeta.className = 'text-lg text-slate-700 font-medium mt-2';
                            pmeta.textContent = (job.company_name || 'Company') + ' • ' + (job.address || 'Location');
                            const pdate = document.createElement('p');
                            pdate.className = 'text-sm text-slate-500 mt-2';
                            pdate.textContent = job.apply_before ? ('Apply by ' + job.apply_before) : (job.posted_date ? job.posted_date : '');
                            info.appendChild(h3); info.appendChild(pmeta); info.appendChild(pdate);

                            left.appendChild(logoWrap); left.appendChild(info);

                            const right = document.createElement('div');
                            right.className = 'flex flex-col sm:flex-row sm:items-center gap-4 md:flex-shrink-0';
                            const type = document.createElement('span');
                            type.className = 'rounded-full bg-blue-100 px-5 py-3 text-base font-bold text-blue-700 text-center';
                            type.textContent = job.job_type || 'Work type';
                            const view = document.createElement('a');
                            view.className = 'inline-flex items-center justify-center rounded-full bg-blue-700 px-8 py-4 text-lg font-bold text-white shadow-lg transition hover:bg-blue-800 hover:shadow-xl active:scale-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600';
                            view.href = '/job-details' + (job.id ? ('?job_id=' + encodeURIComponent(job.id)) : '');
                            view.textContent = 'View job';
                            right.appendChild(type); right.appendChild(view);

                            art.appendChild(left); art.appendChild(right);
                            container.appendChild(art);
                        });
                    }
                    if (countEl) countEl.textContent = 'Showing ' + jobs.length + ' of ' + jobs.length + ' results';
                    // show load more if more likely available
                    if (loadMoreBtn) loadMoreBtn.style.display = 'inline-flex';
                } catch (err) {
                    console.error(err);
                    container.innerHTML = '<div class="py-8 text-center col-span-3 text-red-600">Error loading jobs.</div>';
                }
            }

            searchForm.addEventListener('submit', (event) => {
                event.preventDefault();
                renderSearchTags();
                const title = (document.getElementById('job-title') || {}).value || '';
                const location = (document.getElementById('location') || {}).value || '';
                const workType = (document.getElementById('work-type') || {}).value || '';
                const environment = (document.getElementById('environment') || {}).value || '';
                const url = new URL(window.location);
                if (title) url.searchParams.set('title', title); else url.searchParams.delete('title');
                if (location) url.searchParams.set('location', location); else url.searchParams.delete('location');
                if (workType) url.searchParams.set('job_type', workType); else url.searchParams.delete('job_type');
                if (environment) url.searchParams.set('work_environment', environment); else url.searchParams.delete('work_environment');
                history.pushState({}, '', url);
                fetchAndRenderJobs({ limit: 10, title: title, location: location, job_type: workType, work_environment: environment });
                const jobListSection = document.querySelector('#job-search + section, section.py-12');
                if (jobListSection) {
                    jobListSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        </script>

    </div>
</section>

<!-- JOB LIST -->
<section class="py-12 sm:py-16 pb-0">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">

        <!-- HEADER -->
        <div class="flex justify-between items-end mb-8">
            <div class="space-y-4">
                <p class="text-sm font-semibold uppercase tracking-widest text-blue-700">
                    Hiring now
                </p>
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900">Available jobs</h2>
            </div>

            <p id="results-count" class="text-lg text-slate-700 font-medium">Showing 0 of 0 results</p>
        </div>

        <!-- JOB CARDS (loaded via JS) -->
        <div class="space-y-5">
            <div id="job-results-list" class="space-y-5">
                <div class="py-8 text-center col-span-3">Loading jobs…</div>
            </div>
        </div>

        <!-- SIMPLE PAGINATION / LOAD MORE -->
        <div class="text-center mt-12 space-y-6">
            <p class="text-xl text-slate-800 font-medium">&nbsp;</p>
            <button id="load-more-btn" type="button" class="rounded-full bg-blue-700 px-10 py-4 text-lg text-white font-semibold hover:bg-blue-800 focus:ring-2 focus:ring-blue-600 transition" style="display:none">Load more jobs</button>
        </div>

    </div>
</section>

    <section class="bg-blue-800 flex-1"></section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const title = params.get('title') || '';
    const location = params.get('location') || '';
    const job_type = params.get('job_type') || '';
    const work_environment = params.get('work_environment') || '';
    if (title && document.getElementById('job-title')) document.getElementById('job-title').value = title;
    if (location && document.getElementById('location')) document.getElementById('location').value = location;
    if (job_type && document.getElementById('work-type')) document.getElementById('work-type').value = job_type;
    if (work_environment && document.getElementById('environment')) document.getElementById('environment').value = work_environment;

    if (typeof fetchAndRenderJobs === 'function') {
        fetchAndRenderJobs({ limit: 10, title: title, location: location, job_type: job_type, work_environment: work_environment });
    }

    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        let currentLimit = 10;
        loadMoreBtn.addEventListener('click', function() {
            currentLimit += 10;
            fetchAndRenderJobs({ limit: currentLimit, title: title, location: location, job_type: job_type, work_environment: work_environment });
        });
    }
});
</script>

<script>
    const loadingOverlay = document.getElementById('page-loading-overlay');
    const removeOverlay = () => {
        if (!loadingOverlay) return;
        loadingOverlay.classList.add('opacity-0');
        loadingOverlay.style.pointerEvents = 'none';
        window.setTimeout(() => {
            loadingOverlay.remove();
        }, 300);
    };

    if (document.readyState === 'complete') {
        removeOverlay();
    } else {
        window.addEventListener('load', removeOverlay);
    }
</script>

@endsection