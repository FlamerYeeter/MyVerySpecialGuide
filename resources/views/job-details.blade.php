@extends('layouts.includes')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    @php
        $job = null;
        $job_id = request('job_id') ?? request('id') ?? '';
    @endphp

<!-- Skip to main content link -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50 focus:outline-none focus:ring-2 focus:ring-blue-300">Skip to main content</a>

<div class="bg-slate-50 flex flex-col flex-1 min-h-0">

    <!-- BACK BUTTON -->
    <nav class="bg-sky-50 border-b border-sky-100 py-4 px-6 sm:px-10 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('job.matches') }}"
               class="inline-flex items-center gap-3 text-blue-700 font-semibold text-base sm:text-lg hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
               aria-label="Go back to jobs">
                <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png" alt="" aria-hidden="true"/>
                <span>Back to jobs</span>
            </a>
        </div>
    </nav>

    <!-- JOB HEADER -->
    <main id="main-content" class="max-w-7xl mx-auto w-full px-6 sm:px-10 lg:px-12 py-8 sm:py-10">

        <!-- HEADER CARD -->
        <article class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm mb-8">

            <div class="flex flex-col lg:flex-row justify-between gap-8 items-start lg:items-center">


                <!-- COMPANY & JOB INFO -->
                <div class="flex items-start gap-5 flex-1">

                    <!-- LOGO -->
                    <div class="flex-shrink-0">
                        <img id="job-logo-img"
                             src=""
                             alt="Company Logo"
                             class="w-24 h-24 rounded-xl border border-gray-300 object-cover hidden">

                        <div id="job-logo-fallback"
                             class="w-24 h-24 flex items-center justify-center rounded-xl border-4 border-gray-300 bg-gray-50">
                            <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                        </div>
                    </div>

                    <!-- JOB DETAILS -->
                    <div class="flex-1 min-w-0">
                        <h1 id="job-title" class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                            Job Role
                        </h1>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-lg text-slate-700">
                                <span class="font-semibold" id="company-name">Company</span>
                            </div>

                            <div class="flex flex-wrap gap-4 text-lg text-slate-600">
                                <div class="flex items-center gap-2">
                                    <img src="https://img.icons8.com/color/24/marker.png" alt="" aria-hidden="true" class="w-6 h-6"/>
                                    <span id="job-location">Location</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <img src="https://img.icons8.com/color/24/time.png" alt="" aria-hidden="true" class="w-6 h-6"/>
                                    <span id="job-post-date">Posted date</span>
                                </div>

                                <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold text-base" id="job-type">
                                    Work type
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
                    <button id="apply-now-btn" href="{{ url('/job-application-1') . '?job_id=' . urlencode($job_id) }}"
                       class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-10 py-5 rounded-2xl font-bold text-2xl hover:from-blue-700 hover:to-blue-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 ring-4 ring-blue-300 ring-opacity-30"
                       aria-label="Apply Now - Main Action">
                        <img src="https://img.icons8.com/fluency/32/ffffff/rocket.png" alt="" aria-hidden="true"/>
                        <span>Apply Now</span>
                    </button>

                    <button onclick="saveJob('{{ $job_id }}', this)" type="button" data-job-id="{{ $job_id }}" class="inline-flex items-center justify-center gap-3 rounded-full border border-blue-700 bg-transparent px-8 py-4 text-lg font-bold text-blue-700 shadow-lg transition hover:bg-blue-700 hover:text-white hover:shadow-xl active:scale-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                            aria-label="Save this job">
                        <img src="https://img.icons8.com/fluency/24/1E40AF/bookmark-ribbon.png" alt="" aria-hidden="true"/>
                        <span>Save job</span>
                    </button>
                </div>

            </div>
        </article>

        <!-- CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT COLUMN - MAIN CONTENT -->
            <div class="lg:col-span-2 space-y-8">

                <!-- JOB DESCRIPTION -->
                <section id="box-job-desc" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Job description</h2>
                         <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('job-description-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="job-description-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-a:text-blue-700 prose-a:underline">
                        <p class="text-gray-500 italic">No job description provided yet.</p>
                    </div>
                </section>

                <!-- WHY JOIN US -->
                <section id="box-why-join" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Why join us?</h2>
                         <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('why-join-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="why-join-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-a:text-blue-700 prose-a:underline">
                        <p class="text-gray-500 italic">No information provided yet.</p>
                    </div>
                </section>

                <!-- KEY RESPONSIBILITIES -->
                <section id="box-key-resp" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Key responsibilities</h2>
                          <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('key-responsibilities-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="key-responsibilities-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-li:text-base">
                        <p class="text-gray-500 italic">No responsibilities listed yet.</p>
                    </div>
                </section>

                <!-- WHO WE ARE LOOKING FOR -->
                <section id="box-looking-for" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Who we are looking for</h2>
                          <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('looking-for-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="looking-for-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-li:text-base">
                        <p class="text-gray-500 italic">No information provided yet.</p>
                    </div>
                </section>

                <!-- WORKING ENVIRONMENT -->
                <section id="box-working-env" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Working environment</h2>
                          <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('working-environment-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="working-environment-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold">
                        <p class="text-gray-500 italic">No working environment details provided yet.</p>
                    </div>
                </section>

                <!-- Accessibility & Support Requirements  -->
                <section id="box-accessibility" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Accessibility & support requirements</h2>
                       <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('accessibility-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-li:text-base">
                        <!-- Section Description -->
                        <p class="text-sm text-gray-600 mb-4">
                            This section helps you understand the workplace conditions, communication methods, and available support 
                            to determine if the job is suitable for your needs.
                        </p>
    
                        <!-- Communication Requirements -->
                        <div>
                            <h5 class="font-semibold text-black mb-2">Communication requirements</h5>
                            <ul id="communication-list" class="list-disc list-inside space-y-1">
                                <li class="text-gray-700 italic">No information provided.</li>
                            </ul>
                        </div>

                        <!-- Sensory Requirements -->
                        <div>
                            <h5 class="font-semibold text-black mb-2">Sensory requirements</h5>
                            <ul id="sensory-list" class="list-disc list-inside space-y-1">
                                <li class="text-gray-700 italic">No information provided.</li>
                            </ul>
                        </div>

                        <!-- Cognitive Level Requirements -->
                        <div>
                            <h5 class="font-semibold text-black mb-2">Cognitive level requirements</h5>
                            <ul id="cognitive-list" class="list-disc list-inside space-y-1">
                                <li class="text-gray-700 italic">No information provided.</li>
                            </ul>
                        </div>

                        <!-- Accommodation Availability -->
                        <div>
                            <h5 class="font-semibold text-black mb-2">Accommodation availability</h5>
                            <ul id="accommodation-list" class="list-disc list-inside space-y-1">
                                <li class="text-gray-700 italic">No information provided.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- QUALIFICATIONS -->
                <section id="box-qualifications" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Qualifications</h2>
                        <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('qualifications-content').textContent)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="qualifications-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-li:text-base">
                        <p class="text-gray-500 italic">No qualifications information provided yet.</p>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN - SIDEBAR -->
            <div class="space-y-8">

                <!-- ABOUT THIS ROLE / JOB OVERVIEW -->
                <aside id="box-about-role" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Job overview</h3>
                                  <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('box-about-role').innerText)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>

                    <div class="space-y-5">
                        <!-- Capacity Progress -->
                        <div>
                            <p class="text-sm font-semibold text-slate-600 mb-2">Applications received</p>
                            <div class="w-full bg-slate-200 h-3 rounded-full">
                                <div id="capacity-bar" class="bg-blue-600 h-3 rounded-full w-0 transition-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Applications received progress"></div>
                            </div>
                            <p class="text-base font-semibold text-slate-900 mt-2">
                                <span id="applied-count">0</span> of <span id="openings-count">0</span> positions filled
                            </p>
                        </div>

                        <!-- Details -->
                        <div class="border-t border-slate-200 pt-5 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-base font-medium text-slate-600">Apply before:</span>
                                <span id="apply-before" class="font-semibold text-slate-900">—</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-base font-medium text-slate-600">Posted:</span>
                                <span id="job-posted-date" class="font-semibold text-slate-900">—</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-base font-medium text-slate-600">Work type:</span>
                                <span id="job-type-sidebar" class="font-semibold text-slate-900">—</span>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- REQUIRED SKILLS -->
                <section id="box-skills" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Skills needed</h3>
                         <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('box-skills').innerText)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>
                    <div id="skills-container" class="flex flex-wrap gap-3">
                        <span id="skills-placeholder" class="text-gray-500 italic">No skills available yet.</span>
                    </div>
                </section>

                <!-- HIRING MANAGER -->
                <section id="box-hiring-manager" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Hiring manager</h3>
                          <button type="button"
            class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
            aria-label="Read hiring manager section aloud"
            onclick="speakText(document.getElementById('box-hiring-manager').innerText)">
            
            <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
            Listen
        </button>
                    </div>

                    <!-- Managers list: only show names -->
                    <div id="managers-list-container">
                        <ul id="managers-list" class="list-none p-0 m-0">
                            <li class="flex items-center gap-3 py-2">
                                <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden">
                                    <i class="ri-user-line text-gray-400 text-xl"></i>
                                </div>
                                <span id="manager-name" class="font-medium text-base text-gray-800">No manager assigned</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- CONTACT DETAILS -->
                <section id="box-contact" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Contact details</h3>
                          <button type="button"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    onclick="speakText(document.getElementById('box-contact').innerText)">
                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
                    </div>

                    <div class="space-y-4 text-slate-700">

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/marker.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <span id="contact-address" class="text-lg">Location not provided</span>
                        </div>

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/phone.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <a id="contact-phone" href="tel:" class="text-lg hover:text-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">Not available</a>
                        </div>

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/new-post.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <a id="contact-email" href="mailto:" class="text-lg hover:text-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">No email</a>
                        </div>

                        {{-- <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/building.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <span id="contact-industry" class="text-lg">Not specified</span>
                        </div> --}}

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/link.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <a id="company-website" href="#" target="_blank" class="text-lg text-blue-700 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                <span id="company-website-text">No website available</span>
                            </a>
                        </div>

                        {{-- <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/map.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <a id="company-map" href="#" target="_blank" class="text-lg text-blue-700 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                <span id="company-map-text">Google Maps</span>
                            </a>
                        </div> --}}

                    </div>
                </section>

            </div>
        </div>
    </main>

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
        function updateSaveButtonState(button, saved) {
            if (!button) return;
            button.classList.toggle('border-blue-700', !saved);
            button.classList.toggle('bg-transparent', !saved);
            button.classList.toggle('text-blue-700', !saved);
            button.classList.toggle('hover:bg-blue-700', !saved);
            button.classList.toggle('hover:text-white', !saved);
            button.classList.toggle('border-transparent', saved);
            button.classList.toggle('bg-emerald-600', saved);
            button.classList.toggle('text-white', saved);
            button.classList.toggle('hover:bg-emerald-700', saved);
            button.setAttribute('aria-pressed', saved ? 'true' : 'false');
            const label = button.querySelector('span');
            if (label) {
                label.textContent = saved ? 'Saved' : 'Save job';
            }
        }

        function saveJob(jobId, button) {
            if (!jobId || !button) return;
            const savedKey = 'savedJobIds';
            const savedJobs = JSON.parse(localStorage.getItem(savedKey) || '[]');
            const existingIndex = savedJobs.indexOf(jobId);
            const willSave = existingIndex === -1;
            const nextSaved = willSave ? [...savedJobs, jobId] : savedJobs.filter(id => id !== jobId);
            localStorage.setItem(savedKey, JSON.stringify(nextSaved));
            updateSaveButtonState(button, willSave);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const jobId = '{{ $job_id }}';
            const saveButton = document.querySelector('button[data-job-id="' + jobId + '"]');
            if (jobId && saveButton) {
                const savedJobs = JSON.parse(localStorage.getItem('savedJobIds') || '[]');
                updateSaveButtonState(saveButton, savedJobs.includes(jobId));
            }

            document.querySelectorAll('.tts-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    let text = '';
                    if (this.dataset.target) {
                        const target = document.getElementById(this.dataset.target);
                        if (target) {
                            text = target.textContent || target.innerText || '';
                        }
                    } else if (this.dataset.text) {
                        text = this.dataset.text;
                    }
                    if (text.trim()) {
                        speakText(text.trim());
                    }
                });
            });
        });

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

        // Try parse various date formats into a JS Date
        function tryParseDate(v){
            if (!v) return null;
            let d = new Date(v);
            if (!isNaN(d.getTime())) return d;
            const m = String(v).match(/(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})/);
            if (m){
                return new Date(Number(m[1]), Number(m[2]) - 1, Number(m[3]));
            }
            const m2 = String(v).match(/^(\d{1,2})[-\/ ]([A-Za-z]{3,})[-\/ ](\d{2,4})/);
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

        // Format date as "Month day, Year" or return original fallback
        function formatNiceDate(v){
            if (!v) return '-';
            const d = (v instanceof Date) ? v : tryParseDate(v);
            if (!d) return safeText(v, '-');
            const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
        }

        function formatNiceDateOrOriginal(v){
            if (!v) return '-';
            const d = tryParseDate(v);
            return d ? formatNiceDate(d) : safeText(v, '-');
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
                    // Accessibility & support
                    comp_req: asArray(payload.comp_req ?? payload.COMP_REQ ?? payload.COMP_REQS ?? []),
                    sensor_req: asArray(payload.sensor_req ?? payload.SENSOR_REQ ?? []),
                    cog_lvl_req: asArray(payload.cog_lvl_req ?? payload.COG_LVL_REQ ?? []),
                    accom_avail: asArray(payload.accom_avail ?? payload.ACCOM_AVAIL ?? payload.ACCOMMODATION_AVAIL ?? []),
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

                // Accessibility lists helper
                function populateList(id, values) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    if (!values || values.length === 0) {
                        el.innerHTML = '<li class="text-gray-700 italic">No information provided.</li>';
                        return;
                    }
                    // ensure array of strings
                    const arr = Array.isArray(values) ? values : [values];
                    el.innerHTML = arr.map(x => '<li>' + String(x) + '</li>').join('\n');
                }

                populateList('communication-list', j.comp_req);
                populateList('sensory-list', j.sensor_req);
                populateList('cognitive-list', j.cog_lvl_req);
                populateList('accommodation-list', j.accom_avail);

                // Counts & progress
                const openings = parseInt(j.openings) || 0;
                const applied = parseInt(j.applied) || 0;
                const capEl = document.getElementById('openings-count');
                const appliedEl = document.getElementById('applied-count');
                const bar = document.getElementById('capacity-bar');
                if (capEl) capEl.textContent = applied;
                if (appliedEl) appliedEl.textContent = applied;
                if (bar) {
                    const pct = openings > 0 ? Math.min(100, Math.round((applied / openings) * 100)) : 0;
                    bar.style.width = pct + '%';
                    bar.setAttribute('aria-valuenow', String(pct));
                }

                // Dates & type
                const applyBeforeEl = document.getElementById('apply-before');
                const jobPostDateEl = document.getElementById('job-posted-date');
                const jobTypeSidebarEl = document.getElementById('job-type-sidebar');
                const jobTypeEl = document.getElementById('job-type');
                
                if (applyBeforeEl) applyBeforeEl.textContent = j.apply_before ? formatNiceDateOrOriginal(j.apply_before) : '—';
                if (jobPostDateEl) jobPostDateEl.textContent = j.job_post_date ? formatNiceDateOrOriginal(j.job_post_date) : '—';
                if (jobTypeSidebarEl) jobTypeSidebarEl.textContent = safeText(j.job_type, '—');
                if (jobTypeEl) jobTypeEl.textContent = safeText(j.job_type, 'Work type');

                // Skills
                const skillsContainer = document.getElementById('skills-container');
                if (skillsContainer) {
                    skillsContainer.innerHTML = '';
                    if (j.skills && j.skills.length) {
                        j.skills.forEach(s => {
                            const span = document.createElement('span');
                            span.className = 'inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-base font-semibold rounded-full whitespace-nowrap';
                            span.textContent = s;
                            span.setAttribute('role', 'listitem');
                            skillsContainer.appendChild(span);
                        });
                    } else {
                        const placeholder = document.createElement('span');
                        placeholder.id = 'skills-placeholder';
                        placeholder.className = 'text-gray-500 italic';
                        placeholder.textContent = 'No skills available yet.';
                        skillsContainer.appendChild(placeholder);
                    }
                }

                // Job positions (element may be removed)
                const posEl = document.getElementById('job-positions');
                if (posEl) {
                    if (j.job_positions && j.job_positions.length) {
                        posEl.textContent = j.job_positions.join(', ');
                    } else {
                        posEl.textContent = 'No Job Position Input';
                    }
                }

                // Managers: show names-only list (prefer array `j.managers`)
                function escapeHtml(s) {
                    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                }

                const managersListEl = document.getElementById('managers-list');
                if (Array.isArray(j.managers) && j.managers.length) {
                    managersListEl.innerHTML = j.managers.map(m => {
                        const full = (m.full_name ?? ((m.first_name || '') + ' ' + (m.last_name || ''))).trim() || m.FIRST_NAME || '';
                        return '<li class="flex items-center gap-3 py-2">' +
                            '<div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden">' +
                                '<i class="ri-user-line text-gray-400 text-xl"></i>' +
                            '</div>' +
                            '<span class="font-medium text-base text-gray-800">' + escapeHtml(full) + '</span>' +
                        '</li>';
                    }).join('\n');

                    // keep first manager in #manager-name for backward compatibility
                    const first = j.managers[0];
                    const firstFull = (first.full_name ?? ((first.first_name || '') + ' ' + (first.last_name || ''))).trim() || first.FIRST_NAME || '';
                    const mgrNameEl = document.getElementById('manager-name');
                    if (mgrNameEl) mgrNameEl.textContent = '';
                } else if (payload.manager) {
                    const m = payload.manager;
                    const full = (typeof m === 'string') ? m : ((m.full_name ?? ((m.first_name || '') + ' ' + (m.last_name || ''))).trim() || m.FIRST_NAME || '');
                    if (managersListEl) managersListEl.innerHTML = '<li class="flex items-center gap-3 py-2">' +
                        '<div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden">' +
                            '<i class="ri-user-line text-gray-400 text-xl"></i>' +
                        '</div>' +
                        '<span class="font-medium text-base text-gray-800">' + escapeHtml(full) + '</span>' +
                    '</li>';
                }

                // Contact details
                if (j.address) {
                    const addrEl = document.getElementById('contact-address');
                    if (addrEl) addrEl.textContent = j.address;
                }
                if (j.phone) {
                    const phoneEl = document.getElementById('contact-phone');
                    if (phoneEl) {
                        phoneEl.href = 'tel:' + encodeURIComponent(j.phone);
                        phoneEl.textContent = j.phone;
                    }
                }
                if (j.email) {
                    const emailEl = document.getElementById('contact-email');
                    if (emailEl) {
                        emailEl.href = 'mailto:' + j.email;
                        emailEl.textContent = j.email;
                    }
                }
                if (j.company && j.company.industry) {
                    const indEl = document.getElementById('contact-industry');
                    if (indEl) indEl.textContent = j.company.industry;
                }

                // website & map
                const websiteA = document.getElementById('company-website');
                const websiteText = document.getElementById('company-website-text');
                if (j.website_link && websiteA && websiteText) {
                    websiteA.href = j.website_link;
                    websiteText.textContent = j.website_link;
                } else if (j.company && (j.company.website || j.company.website_link) && websiteA && websiteText) {
                    const w = j.company.website || j.company.website_link;
                    websiteA.href = w;
                    websiteText.textContent = w;
                } else if (websiteA) {
                    websiteA.style.display = 'none';
                }
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
<script>
function speakText(text) {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        speechSynthesis.speak(utterance);
    } else {
        alert('TTS not supported in this browser');
    }
}

</script>
@endsection
