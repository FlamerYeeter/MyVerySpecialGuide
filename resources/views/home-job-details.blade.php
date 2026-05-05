@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

@php
    $job_id = request('job_id') ?? request('id') ?? '';
@endphp

<!-- Skip to main content link -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50 focus:outline-none focus:ring-2 focus:ring-blue-300">Skip to main content</a>

<div class="bg-slate-50 flex flex-col flex-1 min-h-0">
    <div id="page-loading-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white/95 transition-opacity duration-300" aria-live="polite">
        <div class="text-center">
            <div class="h-14 w-14 rounded-full border-4 border-blue-200 border-t-blue-700 animate-spin mx-auto" aria-hidden="true"></div>
            <p class="mt-4 text-base font-semibold text-slate-900">Loading content…</p>
        </div>
    </div>

    <!-- BACK BUTTON -->
    <nav class="bg-sky-50 border-b border-sky-100 py-4 px-6 sm:px-10 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('job.matches') }}"
               class="inline-flex items-center gap-3 text-blue-700 font-semibold text-base sm:text-lg hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
               aria-label="Go back to job listings">
                <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png" alt="" aria-hidden="true"/>
                <span>Back to job listings</span>
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
                             class="w-20 h-20 rounded-xl border border-slate-300 object-cover hidden"
                             alt="Company logo">

                        <div id="job-logo-fallback"
                             class="w-20 h-20 bg-sky-100 rounded-xl flex items-center justify-center border border-slate-200">
                            <img src="https://img.icons8.com/fluency/48/organization.png" alt="Organization icon" aria-hidden="true"/>
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
                    <button id="apply-now-btn"
                       class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white px-10 py-5 rounded-2xl font-bold text-2xl hover:from-blue-700 hover:to-blue-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 ring-4 ring-blue-300 ring-opacity-30"
                       aria-label="Apply Now - Main Action"
                       onclick="openAuthModal()">
                        <img src="https://img.icons8.com/fluency/32/ffffff/rocket.png" alt="" aria-hidden="true"/>
                        <span>Apply Now</span>
                    </button>

                    <button type="button" onclick="openAuthModal()" class="inline-flex items-center justify-center gap-3 rounded-full border border-blue-700 bg-transparent px-8 py-4 text-lg font-bold text-blue-700 shadow-lg transition hover:bg-blue-700 hover:text-white hover:shadow-xl active:scale-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                            aria-label="Save this job - requires login">
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
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="job-description-content" aria-label="Read job description aloud">🔊</button>
                    </div>
                    <div id="job-description-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-a:text-blue-700 prose-a:underline">
                        <p class="text-gray-500 italic">No job description provided yet.</p>
                    </div>
                </section>

                <!-- WHY JOIN US -->
                <section id="box-why-join" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Why join us?</h2>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="why-join-content" aria-label="Read why join us aloud">🔊</button>
                    </div>
                    <div id="why-join-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-a:text-blue-700 prose-a:underline">
                        <p class="text-gray-500 italic">No information provided yet.</p>
                    </div>
                </section>

                <!-- KEY RESPONSIBILITIES -->
                <section id="box-key-resp" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Key responsibilities</h2>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="key-responsibilities-content" aria-label="Read key responsibilities aloud">🔊</button>
                    </div>
                    <div id="key-responsibilities-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-li:text-base">
                        <p class="text-gray-500 italic">No responsibilities listed yet.</p>
                    </div>
                </section>

                <!-- WORKING ENVIRONMENT -->
                <section id="box-working-env" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Working environment</h2>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="working-environment-content" aria-label="Read working environment aloud">🔊</button>
                    </div>
                    <div id="working-environment-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold">
                        <p class="text-gray-500 italic">No working environment details provided yet.</p>
                    </div>
                </section>

                <!-- Accessibility & Support Requirements  -->
                <section id="box-accessibility" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h2 class="text-2xl font-bold text-slate-900">Accessibility & support requirements</h2>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="box-accessibility" aria-label="Read accessibility requirements aloud">🔊</button>
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
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="qualifications-content" aria-label="Read qualifications aloud">🔊</button>
                    </div>
                    <div id="qualifications-content" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-4 prose prose-headings:text-lg prose-headings:font-bold prose-li:text-base">
                        <p class="text-gray-500 italic">No qualifications information provided yet.</p>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN - SIDEBAR -->
            <div class="space-y-8">

                <!-- ABOUT THIS ROLE -->
                <aside class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Job overview</h3>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="box-about-role" aria-label="Read job overview aloud">🔊</button>
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
                <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Skills needed</h3>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="box-skills" aria-label="Read skills needed aloud">🔊</button>
                    </div>
                    <div id="skills-container" class="flex flex-wrap gap-3">
                        <span id="skills-placeholder" class="text-gray-500 italic">No skills available yet.</span>
                    </div>
                </section>

                <!-- HIRING MANAGER -->
                <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Hiring manager</h3>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="box-hiring-manager" aria-label="Read hiring manager aloud">🔊</button>
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
                <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-sm">
                    <div class="flex justify-between items-start mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Contact details</h3>
                        <button class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110" data-target="box-contact" aria-label="Read contact details aloud">🔊</button>
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

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/building.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <span id="contact-industry" class="text-lg">Not specified</span>
                        </div>

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/link.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <a id="company-website" href="#" target="_blank" class="text-lg text-blue-700 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                <span id="company-website-text">No website available</span>
                            </a>
                        </div>

                        <div class="flex gap-3 items-start">
                            <img src="https://img.icons8.com/color/24/map.png" alt="" aria-hidden="true" class="w-6 h-6 flex-shrink-0 mt-1"/>
                            <a id="company-map" href="#" target="_blank" class="text-lg text-blue-700 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                                <span id="company-map-text">Google Maps</span>
                            </a>
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </main>

    <!-- AUTHENTICATION MODAL -->
    <div id="auth-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-t-3xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Apply for this Job</h2>
                    <button onclick="closeAuthModal()" class="text-white hover:text-blue-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-blue-100 mt-2">Please log in in or create an account to continue</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div class="text-center mb-6">
                    <p class="text-gray-600">To apply for this position, you need to be logged in to your account.</p>
                </div>

                <!-- Login Button -->
                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                   class="w-full inline-flex items-center justify-center gap-3 bg-blue-700 text-white px-6 py-4 rounded-2xl font-semibold text-lg hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 shadow-md transition">
                    <img src="https://img.icons8.com/fluency/24/ffffff/login-rounded-right.png" alt="" aria-hidden="true"/>
                    <span>Log In</span>
                </a>

                <!-- Sign Up Button -->
                <a href="{{ route('register') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                   class="w-full inline-flex items-center justify-center gap-3 bg-green-600 text-white px-6 py-4 rounded-2xl font-semibold text-lg hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 shadow-md transition">
                    <img src="https://img.icons8.com/fluency/24/ffffff/add-user-male.png" alt="" aria-hidden="true"/>
                    <span>Create Account</span>
                </a>

                <!-- Alternative Actions -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 mb-3">Or continue as guest</p>
                    <button onclick="closeAuthModal()"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm underline focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded">
                        Browse jobs without applying
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>
function hideLoadingOverlay() {
    const overlay = document.getElementById('page-loading-overlay');
    if (!overlay) return;
    overlay.classList.add('opacity-0');
    window.setTimeout(() => overlay.remove(), 300);
}

document.addEventListener("DOMContentLoaded", () => {

    function speakText(text) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text);
            speechSynthesis.speak(utterance);
        } else {
            alert('Text-to-speech not supported in this browser.');
        }
    }

    function addSkill(skill) {
        const skillsContainerEl = document.getElementById("skills-container");
        if (!skillsContainerEl) return;
        const placeholder = document.getElementById('skills-placeholder');
        if (placeholder) placeholder.remove();

        const span = document.createElement("span");
        span.className = "inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-base font-semibold rounded-full whitespace-nowrap";
        span.textContent = skill;
        span.setAttribute('role', 'listitem');
        skillsContainerEl.appendChild(span);
    }

    // Set up skills container with proper ARIA attributes
    const skillsContainer = document.getElementById("skills-container");
    if (skillsContainer) {
        skillsContainer.setAttribute('role', 'list');
    }

    // Try to load job details from query param or injected server variable
    const injectedJobId = @json($job_id);
    async function loadJobDetails(jobId) {
        if (!jobId) return;
        try {
            const res = await fetch('/db/get-job-details.php?job_id=' + encodeURIComponent(jobId), { credentials: 'same-origin' });
            const data = await res.json();
            if (!data || !data.success) {
                console.warn('No job data returned', data);
                return;
            }
            const job = data.job || {};
            const company = data.company || {};

            // Header
            const titleEl = document.getElementById('job-title');
            if (titleEl && job.job_role) titleEl.textContent = job.job_role;
            const companyEl = document.getElementById('company-name');
            if (companyEl) companyEl.textContent = company.official_name || job.company_name_from_job || 'Company';

            // Meta
            const locEl = document.getElementById('job-location');
            if (locEl) locEl.textContent = job.address || company.address || 'Location';
            const postDateEl = document.getElementById('job-post-date');
            if (postDateEl) postDateEl.textContent = job.job_post_date || job.job_post_date || '';
            const typeEl = document.getElementById('job-type');
            if (typeEl) typeEl.textContent = job.job_type || 'Work type';

            // Description-like fields (may be arrays or text)
            function renderRich(targetId, value) {
                const el = document.getElementById(targetId);
                if (!el) return;
                el.innerHTML = '';
                if (!value) {
                    el.innerHTML = '<p class="text-gray-500 italic">No information provided yet.</p>';
                    return;
                }
                if (Array.isArray(value)) {
                    value.forEach(item => {
                        const p = document.createElement('p');
                        p.innerHTML = item;
                        el.appendChild(p);
                    });
                } else {
                    const p = document.createElement('p');
                    p.innerHTML = value;
                    el.appendChild(p);
                }
            }

            renderRich('job-description-content', job.job_description || job.job_description_html || '');
            renderRich('why-join-content', job.why_join_us || '');
            renderRich('key-responsibilities-content', job.key_responsibilities || '');
            renderRich('working-environment-content', job.working_environment || '');
            renderRich('qualifications-content', job.qualifications || '');

            // Sidebar details
            const appliedCountEl = document.getElementById('applied-count');
            const openingsEl = document.getElementById('openings-count');
            const capacityBar = document.getElementById('capacity-bar');
            const applied = (job.applied_count || job.applied || 0);
            const openings = (job.openings || job.employee_capacity || 0) || 0;
            if (appliedCountEl) appliedCountEl.textContent = String(applied);
            if (openingsEl) openingsEl.textContent = String(openings || 0);
            if (capacityBar) {
                const pct = openings > 0 ? Math.min(100, Math.round((applied / openings) * 100)) : (applied > 0 ? 100 : 0);
                capacityBar.style.width = pct + '%';
                capacityBar.setAttribute('aria-valuenow', String(pct));
            }

            const applyBeforeEl = document.getElementById('apply-before');
            if (applyBeforeEl) applyBeforeEl.textContent = job.apply_before || '—';
            const jobPostedDateSidebar = document.getElementById('job-posted-date');
            if (jobPostedDateSidebar) jobPostedDateSidebar.textContent = job.job_post_date || '—';
            const jobTypeSidebar = document.getElementById('job-type-sidebar');
            if (jobTypeSidebar) jobTypeSidebar.textContent = job.job_type || '—';

            // Skills
            const skillsContainerEl = document.getElementById('skills-container');
            if (skillsContainerEl) {
                skillsContainerEl.innerHTML = '';
                const skills = job.skills || job.skills_list || job.skills || [];
                if (Array.isArray(skills) && skills.length) {
                    skills.forEach(s => {
                        const span = document.createElement('span');
                        span.className = 'inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-base font-semibold rounded-full whitespace-nowrap';
                        span.textContent = s;
                        span.setAttribute('role', 'listitem');
                        skillsContainerEl.appendChild(span);
                    });
                } else {
                    const placeholder = document.createElement('span');
                    placeholder.id = 'skills-placeholder';
                    placeholder.className = 'text-gray-500 italic';
                    placeholder.textContent = 'No skills available yet.';
                    skillsContainerEl.appendChild(placeholder);
                }
            }

            // Managers
            const managersList = document.getElementById('managers-list');
            if (managersList) {
                managersList.innerHTML = '';
                const managers = job.managers || [];
                if (Array.isArray(managers) && managers.length) {
                    managers.forEach(m => {
                        const li = document.createElement('li');
                        li.className = 'flex items-center gap-3 py-2';
                        li.innerHTML = `<div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden"><i class="ri-user-line text-gray-400 text-xl"></i></div><span class="font-medium text-base text-gray-800">${m.full_name || (m.FIRST_NAME ? (m.FIRST_NAME + ' ' + (m.LAST_NAME||'')) : 'Manager')}</span>`;
                        managersList.appendChild(li);
                    });
                } else {
                    managersList.innerHTML = `<li class="flex items-center gap-3 py-2"><div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden"><i class="ri-user-line text-gray-400 text-xl"></i></div><span class="font-medium text-base text-gray-800">No manager assigned</span></li>`;
                }
            }

            // Contact / company info
            const contactAddress = document.getElementById('contact-address');
            if (contactAddress) contactAddress.textContent = job.address || company.address || 'Location not provided';
            const contactPhone = document.getElementById('contact-phone');
            if (contactPhone) {
                if (job.phone || company.contact_number) {
                    contactPhone.href = 'tel:' + encodeURIComponent(job.phone || company.contact_number);
                    contactPhone.textContent = job.phone || company.contact_number;
                } else {
                    contactPhone.href = 'tel:';
                    contactPhone.textContent = 'Not available';
                }
            }
            const contactEmail = document.getElementById('contact-email');
            if (contactEmail) {
                if (job.email || company.email) {
                    contactEmail.href = 'mailto:' + (job.email || company.email);
                    contactEmail.textContent = job.email || company.email;
                } else {
                    contactEmail.href = 'mailto:';
                    contactEmail.textContent = 'No email';
                }
            }
            const contactIndustry = document.getElementById('contact-industry');
            if (contactIndustry) contactIndustry.textContent = company.industry || 'Not specified';

            const websiteLink = document.getElementById('company-website');
            const websiteText = document.getElementById('company-website-text');
            if (websiteLink && websiteText) {
                if (job.website_link) {
                    websiteLink.href = job.website_link;
                    websiteText.textContent = job.website_link;
                } else if (company.official_name && company.website) {
                    websiteLink.href = company.website;
                    websiteText.textContent = company.website;
                } else {
                    websiteLink.href = '#';
                    websiteText.textContent = 'No website available';
                }
            }

            const mapLink = document.getElementById('company-map');
            const mapText = document.getElementById('company-map-text');
            if (mapLink && mapText) {
                if (job.map_link) {
                    mapLink.href = job.map_link;
                    mapText.textContent = 'Google Maps';
                } else {
                    mapLink.href = '#';
                    mapText.textContent = 'Google Maps';
                }
            }

            // Logo
            const logoImg = document.getElementById('job-logo-img');
            const logoFallback = document.getElementById('job-logo-fallback');
            const logoSrc = company.logo || job.company_image_data_uri || null;
            if (logoImg && logoSrc) {
                logoImg.src = logoSrc;
                logoImg.classList.remove('hidden');
                if (logoFallback) logoFallback.classList.add('hidden');
            }

        } catch (err) {
            console.error('Failed to load job details', err);
        }
    }

    // prefer server-injected job id, fallback to URL param
    const urlParams = new URLSearchParams(window.location.search);
    const jobIdFromUrl = urlParams.get('job_id') || urlParams.get('id') || '';
    const effectiveJobId = injectedJobId || jobIdFromUrl || '';
    if (effectiveJobId) loadJobDetails(effectiveJobId).finally(() => hideLoadingOverlay());
    else hideLoadingOverlay();

});

// Modal functions
function openAuthModal() {
    const modal = document.getElementById('auth-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeAuthModal() {
    const modal = document.getElementById('auth-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('auth-modal');
    if (event.target === modal) {
        closeAuthModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAuthModal();
    }
});
</script>

@endsection