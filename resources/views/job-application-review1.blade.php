@extends('layouts.includes')

@section('content')
    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

<!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/jobapplication1"
      class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back to Job Application</span>
    </a>
  </div>
</div>


    <!-- Applying For -->
    <section class="max-w-6xl mx-auto mt-14 px-6">
        <h2 class="text-4xl font-extrabold text-[#1E40AF] mb-10 text-center">You Are Applying For</h2>
        @php
            // safe access: use data_get to avoid errors when $job is null / not an array
            $job = $job ?? null;
            $jobTitle = data_get($job, 'title', 'Unknown Job');
            $jobCompany = data_get($job, 'company', 'Unknown Company');
            $jobAddress = data_get($job, 'location', 'Unknown Location');
            $jobType = data_get($job, 'type', 'Unknown Description');
        @endphp

        <div
            class="bg-[#F0F9FF] border-[3px] border-[#1E40AF] rounded-3xl p-10 flex flex-col sm:flex-row items-center gap-10 shadow-lg">
            <!-- Company Logo / Placeholder -->
            <div class="flex items-center justify-center">
                @if (!empty($company->logo))
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                        class="w-36 h-36 rounded-2xl border-2 border-gray-300 object-cover">
                @else
                    <div class="w-36 h-36 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                        <i class="ri-building-4-fill text-[#1E40AF] text-7xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex flex-col justify-center leading-snug text-center sm:text-left max-w-3xl">
                <h3 class="text-4xl font-extrabold text-black">{{ $jobTitle }}</h3>
                <p class="text-gray-700 text-2xl font-semibold mt-2">{{ $jobCompany }}</p>
                <p class="text-gray-600 text-xl mt-1">{{ $jobAddress }}</p>
                <p class="text-gray-600 text-lg mt-3 leading-relaxed">{{ $jobType }}</p>
                <!-- Job Description ito dapat dba? -->
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto p-10 space-y-14">

        <!-- ================= REVIEW PAGE ================= -->
        <div class="mt-14">
            <h2 class="text-4xl font-bold text-[#1E40AF] text-center mb-10">Review Your Information</h2>
            <p class="text-gray-700 text-2xl mb-12 text-center leading-relaxed max-w-5xl mx-auto">
                Please review all information carefully before submitting. You can edit any section if needed.
            </p>

            <!-- PERSONAL INFORMATION -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative">
                <button onclick="editSection('personal')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-lg">
                    <p><span class="font-semibold">First Name:</span> <span id="rev-firstname"></span></p>
                    <p><span class="font-semibold">Last Name:</span> <span id="rev-lastname"></span></p>
                    <p class="sm:col-span-2"><span class="font-semibold">Email:</span> <span id="rev-email"></span></p>
                    <p><span class="font-semibold">Age:</span> <span id="rev-age"></span></p>
                    <p><span class="font-semibold">Phone Number:</span> <span id="rev-phone"></span></p>
                    <p class="sm:col-span-2"><span class="font-semibold">Complete Address:</span> <span
                            id="rev-address"></span></p>
                </div>
            </div>

            <!-- EDUCATION + CERTIFICATIONS -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('education')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Education & Certifications
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-lg">
                    <p><span class="font-semibold">Highest Attainment:</span> <span id="rev-education-level"></span></p>
                    <p><span class="font-semibold">School Name:</span> <span id="rev-school"></span></p>
                    <p><span class="font-semibold">Course/Program:</span> <span id="rev-course"></span></p>
                    <p><span class="font-semibold">Year Graduated:</span> <span id="rev-year"></span></p>
                </div>

                <div class="mt-6">
                    <h4 class="text-2xl font-semibold text-[#1E40AF] mb-2">Certifications</h4>
                    <ul id="rev-cert-list" class="list-disc list-inside text-lg space-y-1"></ul>
                </div>
            </div>

            <!-- SKILLS -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('skills')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Skills</h3>
                <div id="rev-skills-container" class="flex flex-wrap gap-3 text-lg"></div>
            </div>

            <!-- WORK EXPERIENCE -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('work')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Work Experience</h3>
                <div id="rev-work-container" class="space-y-6 text-lg"></div>
            </div>

            <!-- REQUIRED DOCUMENTS -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('docs')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Required Documents</h3>
                <ul id="rev-doc-list" class="list-disc list-inside text-lg space-y-1"></ul>
            </div>

            <!-- FINAL CONFIRMATION INFO BOX -->
            <div id=""
                class="border-l-4 border-green-500 bg-green-100 rounded-2xl p-8 shadow-md mt-8 max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-green-700 mb-4">Final Confirmation</h3>
                <p class="text-[18px] text-green-800 mb-4">
                    By submitting this application, you confirm that all information provided is accurate and complete.
                </p>
                <label class="flex items-center gap-2 text-green-800 text-lg">
                    <input type="checkbox" id="confirmCheck" class="w-5 h-5">
                    I confirm that all information provided is accurate and I agree to the
                    <a href="#" class="underline text-green-900">terms and conditions</a>.
                </label>
            </div>

            <!-- FINAL SUBMIT BUTTON -->
            <div class="flex justify-center mt-6">
                <button type="button" id="reviewSubmitBtn"
                    class="bg-[#1E40AF] text-white text-3xl font-bold px-16 py-6 rounded-2xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition disabled:opacity-50"
                    disabled>
                    Submit Application
                </button>
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
            // Enable submit button only when checkbox is checked
            const confirmCheck = document.getElementById('confirmCheck');
            const submitBtn = document.getElementById('reviewSubmitBtn');

            confirmCheck.addEventListener('change', () => {
                submitBtn.disabled = !confirmCheck.checked;
            });

            submitBtn.addEventListener('click', () => {
                alert('Application submitted successfully!');
                // document.getElementById('applicationForm').submit();
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


    {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
        <script type="module">
            import {
                signInWithServerToken
            } from "{{ asset('js/job-application-firebase.js') }}";
            (function() {
                // Guard: require signed-in user before rendering review values
                async function guardAndInit() {
                    try {
                        try {
                            await signInWithServerToken("{{ route('firebase.token') }}");
                        } catch (e) {
                            console.debug('signInWithServerToken failed', e);
                        }
                        const mod = await import('{{ asset('js/job-application-firebase.js') }}');
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

                        // load step1 and step2 (prefer sessionStorage, fallback to localStorage)
                        const step1 = JSON.parse(sessionStorage.getItem('jobApplication_step1') || localStorage.getItem(
                            'jobApplication_step1') || '{}');
                        const step2 = JSON.parse(sessionStorage.getItem('jobApplication_step2') || localStorage.getItem(
                            'jobApplication_step2') || '{}');

                        // small DOM guard helper
                        const setText = (id, value) => {
                            const el = document.getElementById(id);
                            if (!el) return;
                            el.textContent = value;
                        };

                        // populate personal
                        setText('rv_full_name', ((step1.first_name || '') + ' ' + (step1.last_name || '')).trim() ||
                            '-');
                        setText('rv_email', step1.email || '-');
                        setText('rv_phone', step1.phone_number || '-');
                        setText('rv_dob', step1.date_of_birth || '-');
                        setText('rv_gender', step1.gender || '-');
                        setText('rv_address', step1.address || '-');

                        // populate work experience
                        setText('rv_job_title', step1.job_title || '-');
                        setText('rv_company', step1.company_employer || '-');
                        const sd = step1.start_date || '';
                        const ed = step1.end_date || '';
                        // fix precedence: ensure (sd || ed) is evaluated for the ternary
                        setText('rv_work_dates', (sd || ed) ? (sd + (ed ? ' - ' + ed : '')) : '-');
                        setText('rv_work_desc', step1.job_description || '-');

                        // Next => Review 2 (preserve job_id)
                        document.getElementById('toReview2').addEventListener('click', function() {
                            const jobId = "{{ request('job_id') }}";
                            const base = "{{ route('job.application.review2') }}";
                            const nextUrl = jobId ? base + '?job_id=' + encodeURIComponent(jobId) : base;
                            window.location.href = nextUrl;
                        });

                        // Edit links: ensure they include job_id if present
                        const jobId = "{{ request('job_id') }}";
                        if (jobId) {
                            const edit1 = document.getElementById('edit-step1');
                            const edit1b = document.getElementById('edit-step1-2');
                            if (edit1) edit1.href = "{{ route('job.application.1') }}" + '?job_id=' +
                                encodeURIComponent(jobId);
                            if (edit1b) edit1b.href = "{{ route('job.application.1') }}" + '?job_id=' +
                                encodeURIComponent(jobId);
                        }
                    } catch (err) {
                        console.error('Auth guard or review init failed', err);
                    }
                }
                guardAndInit();
            })();
        </script>
    </section>

    </div>
@endsection
