@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    @php
        $job = null;
        $job_id = request('job_id') ?? request('id') ?? '';
    @endphp


    <!-- Back Button -->
    <div class="bg-yellow-400 w-full py-6 px-6 sm:px-10 lg:px-24">
        <div class="flex justify-start items-center space-x-3 max-w-[1600px] mx-auto">
            <a href="{{ route('job.matches') }}"
                class="flex items-center space-x-3 text-[#1E40AF] font-bold text-xl sm:text-3xl hover:underline focus:outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-10 h-10 sm:w-8 sm:h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Jobs</span>
            </a>
        </div>
    </div>

    <!-- GREEN NOTE -->
    <div class="bg-green-100 border-[4px] border-green-400 rounded-lg p-5 mt-14 mx-4 sm:mx-10">
        <div class="flex items-center gap-6">
            <img src="{{ asset('image/bulb.png') }}" alt="Lightbulb Icon"
                class="w-8 h-8 sm:w-12 sm:h-12 object-contain flex-shrink-0">

            <!-- Text Section -->
            <div class="flex flex-col justify-center leading-snug">
                <p class="text-2xl sm:text-2xl font-semibold text-black">
                    The content shown here gives more detailed information about the job.
                </p>
                <p class="mt-2 italic text-gray-700 text-xl">
                    (Ang nakikitang nilalaman dito ay mas detalyadong impormasyon tungkol sa trabaho.)
                </p>
            </div>
        </div>
    </div>

    <!-- APPLY NOTE -->
    <div class="bg-gray-50 border-[4px] border-gray-300 rounded-lg p-5 mt-8 mx-4 sm:mx-10">
        <div class="flex items-center gap-6">
            <!-- Info Icon -->
            <i class="ri-information-line text-[#1E40AF] text-[2.8rem] sm:text-[2.8rem] flex-shrink-0"></i>

            <!-- Text Content -->
            <div class="flex flex-col justify-center leading-snug">
                <p class="text-2xl sm:text-2xl text-black font-semibold">
                    Click the <span class="text-blue-600 font-bold">“Back to Jobs”</span> button to go back to the 
                    displayed hiring jobs.
                </p>
                <p class="mt-2 italic text-gray-700 text-xl">
                    (Pindutin ang Back to Jobs button upang bumalik muli at makita ang mga hiring na trabaho.)
                </p>
            </div>
        </div>
    </div>

    <!-- JOB DETAILS SECTION -->
    <div class="mt-16 mx-4 sm:mx-10 my-8">
        <h2 class="text-5xl font-extrabold text-[#1E40AF] mb-6 text-center">Job Details</h2>

        <!-- Job Header -->
        <div
            class="mt-12 bg-[#F0F9FF] border-[2px] border-[#1E40AF] rounded-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-10 bg-white shadow-sm">

            <!-- Company Logo -->
            <div class="flex items-center justify-center sm:justify-start w-full sm:w-auto">
                {{-- Always render both; server may provide a URL but client fetch will override with blob/data-uri --}}
                <img id="job-logo-img"
                     src="{{ !empty($company->logo) ? asset('storage/' . $company->logo) : '' }}"
                     alt="Company Logo"
                     class="w-24 h-24 rounded-xl border border-gray-300 object-cover {{ empty($company->logo) ? 'hidden' : '' }}">

                <div id="job-logo-fallback"
                     class="w-24 h-24 flex items-center justify-center rounded-xl border-4 border-gray-300 bg-gray-50 {{ empty($company->logo) ? '' : 'hidden' }}">
                    <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                </div>
            </div>

            <!-- Job Information -->
            <div class="flex flex-col items-center sm:items-start text-center sm:text-left flex-grow">
                <h3 id="job-title" class="text-2xl sm:text-3xl font-bold text-black">Pet Care Assistant</h3>
               <p id="job-location" class="mt-2 flex items-center text-xl text-gray-700 gap-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location" class="w-6 h-6">
                            BGC, Taguig City, Metro Manila
                        </p>
                        </div>
        </div>

        <!-- JOB INFO GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">

            <!-- LEFT CONTENT -->
            <div class="col-span-2 space-y-6">
                <div id="box-job-description" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Job Description</h4>
                    <div id="job-description-content" class="text-gray-700"></div>
                </div>

                <div id="box-why-join" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Why Join Us?</h4>
                    <div id="why-join-content" class="text-gray-700"></div>
                </div>

                <div id="box-key-resp" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Key Responsibilities</h4>
                    <div id="key-responsibilities-content" class="text-gray-700"></div>
                </div>

                <div id="box-looking-for" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Who we are Looking for</h4>
                    <div id="looking-for-content" class="text-gray-700"></div>
                </div>

                <div id="box-working-env" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Working Environment</h4>
                    <div id="working-environment-content" class="text-gray-700"></div>
                </div>

                <div id="box-qualifications" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Qualifications</h4>
                    <div id="qualifications-content" class="text-gray-700"></div>
                </div>
            </div>

            

            <!-- RIGHT COLUMN -->
            <div class="space-y-6">

                <!-- About this role -->
                <div id="box-about-role" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-3">About this Role</h4>
                    <div class="h-5 bg-gray-200 mb-2">
                        <div id="capacity-bar" class="h-5 bg-[#88BF02] w-0"></div>
                    </div>
                    <p class="text-lg font-semibold mb-3">
                        <span id="applied-count" class="text-black">0 applied</span>
                        <span class="text-gray-600"> of </span>
                        <span id="openings-count" class="text-gray-600 font-semibold">0 capacity</span>
                    </p>
                    <div class="grid grid-cols-2 gap-y-2 text-base">
                        <p class="text-gray-500 font-medium">Apply Before</p>
                        <p id="apply-before" class="text-right text-gray-800 font-semibold">-</p>

                        <p class="text-gray-500 font-medium">Job Posted On</p>
                        <p id="job-post-date" class="text-right text-gray-800 font-semibold">-</p>

                        <p class="text-gray-500 font-medium">Job Type</p>
                        <p id="job-type" class="text-right text-gray-800 font-semibold">-</p>
                    </div>
                </div>

                <!-- Required Skills -->
                <div id="box-skills" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg font-bold text-black mb-3">Required Skills</h4>
                    <div id="skills-container" class="flex flex-wrap gap-4"></div>
                </div>

                <!-- Job Positions -->
                <div id="box-positions" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Job Positions</h4>
                    <p id="job-positions" class="text-left text-gray-800 font-semibold">No Job Position Input</p>
                </div>

                <!-- Job Program -->
                <div id="box-program" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Job Program</h4>
                    <p class="text-[#88BF02] border border-[#88BF02] px-3 py-1 rounded-md font-semibold inline-block">Love
                        ’Em Down</p>
                </div>

                <div id="box-hiring-manager" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Hiring Manager</h4>
                    <div class="flex items-center gap-3">
                        <div id="manager-avatar" class="w-12 h-12 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden">
                            <i class="ri-user-line text-gray-400 text-2xl"></i>
                        </div>

                        <!-- Name and Title -->
                        <div class="flex flex-col">
                            <p id="manager-name" class="font-medium text-base text-gray-800">John Carlo Garcia</p>
                            <p id="manager-role" class="text-gray-500 text-xs">Human Resources Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                                <div id="box-contact" class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Contact Details</h4>
                    <p id="contact-address" class="text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-map-pin-line text-black text-lg"></i>
                        Lot 8 Blk W-39E Quezon Avenue, cor Jose Abad Santos St., Quezon City, Metro Manila
                    </p>
                    <p id="contact-phone" class="mt-2 text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-phone-line text-black text-lg"></i> +63 5587 1234
                    </p>
                    <p id="contact-email" class="mt-2 text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-mail-line text-black text-lg"></i> Juan.Carl@shakeys.com
                    </p>
                    <p id="contact-industry" class="mt-2  text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-building-4-line text-black text-lg"></i> Restaurant
                    </p>
                    <a id="company-website" href="#" target="_blank" class="mt-2  text-blue-500 text-sm flex items-center gap-4 hover:underline">
                        <i class="ri-link text-black text-lg"></i> <span id="company-website-text">https://www.shakeyspizza.ph/</span>
                    </a>
                    <a id="company-map" href="#" target="_blank" class="mt-2  text-blue-500 text-sm flex items-center gap-4 hover:underline">
                        <i class="ri-map-2-line text-black text-lg"></i> <span id="company-map-text">Google Maps</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- BACK TO TOP BUTTON -->
    <button id="backToTopBtn"
        class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
        onclick="scrollToTop()" aria-label="Back to top">

        <!-- Up Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>

        <span>Back to Top</span>
    </button>

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

<script type="module">
    (function () {
        const jobId = {!! json_encode((string)$job_id) !!};
        if (!jobId) return;

        // Try current project's endpoint first, fallback to api/get-job-details.php
        // Call the working endpoint directly (use `id` param that the endpoint expects)
        const endpoints = [
            '/db/get-job-details.php?id=' + encodeURIComponent(String(jobId))
        ];

        function safeText(v, fallback = '-') {
            if (v === null || v === undefined || v === '') return fallback;
            return String(v);
        }

        function asArray(v) {
            if (!v) return [];
            if (Array.isArray(v)) return v;
            if (typeof v === 'string') {
                // try JSON list
                try {
                    const parsed = JSON.parse(v);
                    if (Array.isArray(parsed)) return parsed;
                } catch (e) {}
                // comma separated fallback
                return v.split(',').map(x => x.trim()).filter(Boolean);
            }
            return [v];
        }

        function setHtml(id, val) {
            const el = document.getElementById(id);
            if (!el) return;
            if (!val || (Array.isArray(val) && val.length === 0) ) {
                el.innerHTML = '<span class="text-gray-500">No information provided</span>';
                return;
            }
            if (Array.isArray(val)) {
                el.innerHTML = '<ul class="list-disc pl-5">' + val.map(x => '<li>' + String(x) + '</li>').join('') + '</ul>';
            } else {
                el.innerHTML = String(val).replace(/\n/g, '<br/>');
            }
        }

        async function tryFetch(url) {
            try {
                const res = await fetch(url, { credentials: 'same-origin' });
                const text = await res.text();
                if (!res.ok) throw new Error('Fetch failed: ' + res.status + ' ' + text.slice(0,200));
                const json = JSON.parse(text);
                return json;
            } catch (err) {
                console.debug('[job-details] fetch failed for', url, err);
                return null;
            }
        }

        async function fetchJob() {
            try {
                let json = null;
                for (const u of endpoints) {
                    json = await tryFetch(u);
                    if (json) break;
                }
                if (!json) throw new Error('All job endpoints failed');

                // If endpoint returns wrapper { success: true, job: {...} } prefer job
                const payload = json.job ? json.job : (json.data ? json.data : json);

                // Normalize fields across possible backends
                const j = {
                    id: payload.id ?? payload.ID ?? payload.job_id ?? payload.jobId ?? null,
                    title: payload.title ?? payload.job_role ?? payload.role ?? payload.job_title ?? payload.JOB_ROLE ?? '',
                    job_description: payload.job_description ?? payload.description ?? payload.JOB_DESCRIPTION ?? '',
                    why_join_us: payload.why_join_us ?? payload.why_join ?? payload.WHY_JOIN_US ?? '',
                    key_responsibilities: payload.key_responsibilities ?? payload.key_responsibility ?? payload.KEY_RESPONSIBILITIES ?? '',
                    who_we_are_looking_for: payload.what_we_are_looking_for ?? payload.who_we_are_looking_for ?? payload.WHAT_WE_ARE_LOOKING_FOR ?? '',
                    working_environment: payload.working_environment ?? payload.WORKING_ENVIRONMENT ?? '',
                    qualifications: payload.qualifications ?? payload.QUALIFICATIONS ?? '',
                    address: payload.address ?? (payload.company && payload.company.address) ?? payload.ADDRESS ?? '',
                    phone: payload.phone ?? payload.contact_number ?? payload.PHONE ?? '',
                    email: payload.email ?? payload.job_email ?? payload.EMAIL ?? '',
                    website_link: payload.website_link ?? (payload.company && payload.company.website_link) ?? payload.WEBSITE_LINK ?? '',
                    map_link: payload.map_link ?? payload.MAP_LINK ?? '',
                    job_type: payload.job_type ?? payload.JOB_TYPE ?? '',
                    job_post_date: payload.job_post_date ?? payload.JOB_POST_DATE ?? payload.posted_at ?? '',
                    apply_before: payload.apply_before ?? payload.APPLY_BEFORE ?? '',
                    openings: payload.openings ?? payload.employee_capacity ?? payload.EMPLOYEE_CAPACITY ?? 0,
                    applied: payload.applied ?? payload.applied_count ?? 0,
                    skills: asArray(payload.skills ?? payload.required_skills ?? payload.SKILLS ?? payload.REQUIRED_SKILLS ?? []),
                    job_positions: asArray(payload.job_positions ?? payload.positions ?? payload.JOB_POSITIONS ?? payload.POSITIONS ?? []),
                    company: payload.company ?? {
                        id: payload.company_id ?? payload.COMPANY_ID ?? null,
                        name: payload.company_name_official ?? payload.COMPANY_OFFICIAL_NAME ?? payload.company_name ?? payload.COMPANY_NAME ?? payload.company_name_from_job ?? ''
                    },
                    managers: payload.managers ?? payload.manager ?? payload.managers_list ?? []
                };

                // Company image detection
                const possibleImage = payload.company_image ?? payload.company_image_data_uri ?? payload.company.logo ?? (payload.company && (payload.company.logo || payload.company.COMPANY_IMAGE || payload.company.COMPANY_PROOF)) ?? null;
                j.company_image = possibleImage;

                // Header
                document.getElementById('job-title').textContent = safeText(j.title, 'Untitled Job');

                // Location
                const jobLocationEl = document.getElementById('job-location');
                if (j.address) {
                    // replace trailing text child (keeps icon)
                    if (jobLocationEl && jobLocationEl.lastChild) {
                        jobLocationEl.lastChild.textContent = ' ' + j.address;
                    } else if (jobLocationEl) {
                        jobLocationEl.textContent = j.address;
                    }
                }

                // Logo
                const imgEl = document.getElementById('job-logo-img');
                const fallback = document.getElementById('job-logo-fallback');
                if (j.company_image && imgEl) {
                    // if it's already a data URI or absolute URL use directly
                    imgEl.src = j.company_image;
                    imgEl.classList.remove('hidden');
                    if (fallback) fallback.style.display = 'none';
                } else if (imgEl && fallback) {
                    imgEl.classList.add('hidden');
                    fallback.style.display = 'flex';
                }

                // Left column content
                setHtml('job-description-content', j.job_description);
                setHtml('why-join-content', j.why_join_us);
                setHtml('key-responsibilities-content', j.key_responsibilities);
                setHtml('looking-for-content', j.who_we_are_looking_for);
                setHtml('working-environment-content', j.working_environment);
                setHtml('qualifications-content', j.qualifications);

                // Counts & progress
                const openings = parseInt(j.openings) || 0;
                const applied = parseInt(j.applied) || 0;
                const capEl = document.getElementById('openings-count');
                const appliedEl = document.getElementById('applied-count');
                const bar = document.getElementById('capacity-bar');
                if (capEl) capEl.textContent = openings + ' capacity';
                if (appliedEl) appliedEl.textContent = applied + ' applied';
                if (bar) {
                    const pct = openings > 0 ? Math.min(100, Math.round((applied / openings) * 100)) : 0;
                    bar.style.width = pct + '%';
                }

                // Dates & type
                document.getElementById('apply-before').textContent = safeText(j.apply_before, '-');
                document.getElementById('job-post-date').textContent = safeText(j.job_post_date, '-');
                document.getElementById('job-type').textContent = safeText(j.job_type, '-');

                // Skills
                const skillsContainer = document.getElementById('skills-container');
                skillsContainer.innerHTML = '';
                if (j.skills && j.skills.length) {
                    j.skills.forEach(s => {
                        const span = document.createElement('span');
                        span.className = 'text-[#2563EB] border border-[#2563EB] text-sm font-semibold px-3 py-1 rounded-md';
                        span.textContent = s;
                        skillsContainer.appendChild(span);
                    });
                } else {
                    skillsContainer.innerHTML = '<span class="text-gray-500">No skills listed</span>';
                }

                // Job positions
                const posEl = document.getElementById('job-positions');
                if (j.job_positions && j.job_positions.length) {
                    posEl.textContent = j.job_positions.join(', ');
                } else {
                    posEl.textContent = 'No Job Position Input';
                }

                // Hiring manager: prefer first in managers array, else check payload.manager
                let mgr = null;
                if (Array.isArray(j.managers) && j.managers.length) {
                    mgr = j.managers[0];
                } else if (payload.manager) {
                    mgr = payload.manager;
                }
                if (mgr) {
                    const fullName = mgr.full_name ?? ((mgr.first_name || '') + ' ' + (mgr.last_name || '')) ?? mgr.FIRST_NAME ?? '';
                    document.getElementById('manager-name').textContent = safeText(fullName, 'Hiring Manager');
                    document.getElementById('manager-role').textContent = safeText(mgr.role ?? mgr.ROLE ?? '', '');
                    if (mgr.avatar || mgr.avatar_url || mgr.avatarUrl) {
                        const img = document.createElement('img');
                        img.src = mgr.avatar || mgr.avatar_url || mgr.avatarUrl;
                        img.alt = 'Manager';
                        img.className = 'w-full h-full object-cover';
                        const avatarHolder = document.getElementById('manager-avatar');
                        avatarHolder.innerHTML = '';
                        avatarHolder.appendChild(img);
                    }
                }

                // Contact details
                if (j.address) {
                    const addrEl = document.getElementById('contact-address');
                    if (addrEl && addrEl.lastChild) addrEl.lastChild.textContent = ' ' + j.address;
                }
                if (j.phone) {
                    const phoneEl = document.getElementById('contact-phone');
                    if (phoneEl && phoneEl.lastChild) phoneEl.lastChild.textContent = ' ' + j.phone;
                }
                if (j.email) {
                    const emailEl = document.getElementById('contact-email');
                    if (emailEl && emailEl.lastChild) emailEl.lastChild.textContent = ' ' + j.email;
                }
                if (j.company && j.company.industry) {
                    const indEl = document.getElementById('contact-industry');
                    if (indEl && indEl.lastChild) indEl.lastChild.textContent = ' ' + j.company.industry;
                }

                // website & map
                const websiteA = document.getElementById('company-website');
                const websiteText = document.getElementById('company-website-text');
                if (j.website_link) {
                    websiteA.href = j.website_link;
                    websiteText.textContent = j.website_link;
                } else if (j.company && (j.company.website || j.company.website_link)) {
                    const w = j.company.website || j.company.website_link;
                    websiteA.href = w;
                    websiteText.textContent = w;
                } else {
                    websiteA.style.display = 'none';
                }

                const mapA = document.getElementById('company-map');
                if (j.map_link) {
                    mapA.href = j.map_link;
                    document.getElementById('company-map-text').textContent = 'Open in maps';
                } else {
                    mapA.style.display = 'none';
                }

            } catch (err) {
                console.warn('Job fetch error', err);
                const fallback = '<span class="text-gray-500">Unable to load details. Check console/network for fetch response.</span>';
                ['job-description-content','why-join-content','key-responsibilities-content','looking-for-content','working-environment-content','qualifications-content'].forEach(id=>{
                    const el = document.getElementById(id);
                    if (el && !el.innerHTML.trim()) el.innerHTML = fallback;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchJob);
    })();
</script>

    {{-- <script type="module">
        (async function() {
            try {
                const mod = await import("{{ asset('js/job-application-firebase.js') }}");
                console.debug('Auth guard: waiting for sign-in resolution (7s)');
                const signed = await mod.isSignedIn(7000);
                console.debug('Auth guard: isSignedIn ->', signed);
                if (!signed) {
                    if (window.__SERVER_AUTH) {
                        console.info('Auth guard: server session present, not redirecting');
                        return;
                    }
                    const current = window.location.pathname + window.location.search;
                    console.info('Auth guard: not signed, redirecting to login');
                    window.location.href = 'login?redirect=' + encodeURIComponent(current);
                    return;
                }
                // signed-in users proceed; no further client setup required here
            } catch (err) {
                console.error('Auth guard failed on job details', err);
            }
        })();
    </script> --}}
@endsection
