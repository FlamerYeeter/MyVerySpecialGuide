@extends('layouts.app')

@section('content')
<main role="main" class="overflow-x-hidden">
<section class="bg-sky-50" role="region" aria-labelledby="hero-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 py-12 sm:py-16">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_1fr] lg:items-center">
            <div class="space-y-6 text-center lg:text-left">

                <h1 id="hero-heading" class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-slate-900">
                    Welcome to <span class="text-blue-700">EmpowerPath</span>
                </h1>

                <p class="max-w-2xl text-lg sm:text-xl leading-8 text-slate-800">
                   We believe everyone deserves the chance to work, grow, and shine. At the <span class="font-semibold text-blue-700 underline decoration-2 underline-offset-2"> Down Syndrome Work Society 
                    </span> , we open doors for people with Down syndrome to share their talents and build brighter futures.
                </p>

                <div class="grid gap-4 sm:grid-cols-2">
                    <a href="#job-search" class="inline-flex items-center justify-center rounded-full bg-blue-700 px-5 py-3 text-white text-sm font-semibold shadow-sm transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Search jobs
                    </a>
                    <a href="#support" class="inline-flex items-center justify-center rounded-full border border-blue-700 bg-white px-5 py-3 text-blue-700 text-sm font-semibold shadow-sm transition hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Learn how we help
                    </a>
                </div>
            </div>

            <div class="flex justify-center">
                <img src="{{ asset('image/img1.png') }}" alt="Illustration of people working together with support and growth" class="w-full max-w-3xl rounded-3xl shadow-2xl" loading="lazy">
            </div>
        </div>
    </div>
</section>

<section id="job-search" class="bg-white py-12 sm:py-16" role="region" aria-labelledby="job-search-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div class="space-y-4">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-blue-700">Easy job search</p>
                <h2 id="job-search-heading" class="text-3xl sm:text-4xl font-bold text-slate-900">Find a job that fits you</h2>
                <p class="max-w-2xl text-base text-slate-800 leading-7">Search jobs from companies hiring now—your next opportunity could be waiting for you!</p>

                <div class="rounded-3xl bg-sky-50 border border-sky-200 p-6 shadow-sm">
                    <div class="rounded-2xl bg-blue-700/5 border border-blue-100 p-4 mb-6">
                        <p class="text-sm font-semibold text-blue-900">Simple steps for everyone</p>
                        <ol class="mt-3 space-y-2 text-sm text-slate-800">
                            <li class="rounded-xl bg-white px-4 py-3 shadow-sm">1. Write the job title you want.</li>
                            <li class="rounded-xl bg-white px-4 py-3 shadow-sm">2. Choose the city or area.</li>
                            <li class="rounded-xl bg-white px-4 py-3 shadow-sm">3. Press Search jobs.</li>
                        </ol>
                    </div>

                    <form method="GET" action="{{ route('home') }}" class="space-y-5" novalidate>
                        <div class="space-y-2">
                            <label for="job-title" class="block text-sm font-semibold text-slate-900">Job title or role</label>
                            <div class="relative">
                                <img src="https://img.icons8.com/ios-filled/20/search--v1.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                                <input id="job-title" name="job-title" type="text" autocomplete="off" placeholder="e.g. Service Crew, Barista" class="w-full rounded-2xl border border-slate-300 bg-white px-12 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="job-title-help job-title-suggestions">
                                <div id="job-title-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-48 overflow-y-auto hidden z-10">
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Service Crew">Service Crew</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Barista">Barista</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Kitchen Helper">Kitchen Helper</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Housekeeping">Housekeeping</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Food Runner">Food Runner</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 last:border-b-0" data-value="Front Desk">Front Desk</button>
                                </div>
                            </div>
                            <p id="job-title-help" class="text-sm text-slate-600">Type the job role you'd like to apply for or choose from suggestions.</p>
                        </div>

                        <div class="space-y-2">
                            <label for="location" class="block text-sm font-semibold text-slate-900">City or area</label>
                            <div class="relative">
                                <img src="https://img.icons8.com/ios-filled/20/marker.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                                <input id="location" name="location" type="text" autocomplete="off" placeholder="e.g. Taguig City" class="w-full rounded-2xl border border-slate-300 bg-white px-12 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="location-help location-suggestions">
                                <div id="location-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-48 overflow-y-auto hidden z-10">
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Taguig City">Taguig City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Mandaluyong City">Mandaluyong City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Makati City">Makati City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Pasig City">Pasig City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Quezon City">Quezon City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 last:border-b-0" data-value="Paranaque City">Paranaque City</button>
                                </div>
                            </div>
                            <p id="location-help" class="text-sm text-slate-600">Enter the place where you'd like to work or choose from suggestions.</p>
                        </div>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-700 px-5 py-3 text-base font-semibold text-white shadow-lg transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            <img src="https://img.icons8.com/ios-filled/20/ffffff/search.png" alt="" aria-hidden="true">
                            Search jobs
                        </button>
                    </form>
                    <script>
                        const jobInput = document.getElementById('job-title');
                        const jobSuggestions = document.getElementById('job-title-suggestions');
                        const locationInput = document.getElementById('location');
                        const locationSuggestions = document.getElementById('location-suggestions');
                        
                        function toggleSuggestions(input, container) {
                            if (input.value.length > 0 || document.activeElement === input) {
                                container.classList.remove('hidden');
                            } else {
                                container.classList.add('hidden');
                            }
                        }
                        
                        jobInput.addEventListener('focus', () => toggleSuggestions(jobInput, jobSuggestions));
                        jobInput.addEventListener('input', () => toggleSuggestions(jobInput, jobSuggestions));
                        jobInput.addEventListener('blur', () => setTimeout(() => jobSuggestions.classList.add('hidden'), 200));
                        
                        locationInput.addEventListener('focus', () => toggleSuggestions(locationInput, locationSuggestions));
                        locationInput.addEventListener('input', () => toggleSuggestions(locationInput, locationSuggestions));
                        locationInput.addEventListener('blur', () => setTimeout(() => locationSuggestions.classList.add('hidden'), 200));
                        
                        document.querySelectorAll('#job-title-suggestions .suggestion-item').forEach(btn => {
                            btn.addEventListener('click', (e) => {
                                e.preventDefault();
                                jobInput.value = btn.dataset.value;
                                jobSuggestions.classList.add('hidden');
                            });
                        });
                        
                        document.querySelectorAll('#location-suggestions .suggestion-item').forEach(btn => {
                            btn.addEventListener('click', (e) => {
                                e.preventDefault();
                                locationInput.value = btn.dataset.value;
                                locationSuggestions.classList.add('hidden');
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="rounded-[2rem] bg-gradient-to-br from-sky-100 to-white p-6 shadow-xl flex items-center justify-center min-h-[420px]">
                <img src="{{ asset('image/herosection.png') }}" alt="People with Down syndrome working together in a friendly workplace" class="w-full max-w-xl h-[360px] rounded-[1.75rem] object-cover shadow-lg" loading="lazy">
            </div>
        </div>
    </div>
</section>

<section id="support" class="bg-slate-50 py-12 sm:py-16" role="region" aria-labelledby="support-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-blue-700">Why EmpowerPath</p>
            <h2 id="support-heading" class="text-3xl sm:text-4xl font-bold text-slate-900">Support that is kind, clear, and helpful</h2>
            <p class="text-base text-slate-700 leading-7">We make job search easier and provide friendly support for people with Down syndrome and their families.</p>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <article class="rounded-[1.75rem] border border-blue-100 bg-white p-6 shadow-sm">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <span class="text-xl">🤝</span>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Friendly guidance</h3>
                <p class="text-slate-700 leading-7">Clear instructions and easy steps help you find the right job with confidence.</p>
            </article>
            <article class="rounded-[1.75rem] border border-blue-100 bg-white p-6 shadow-sm">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <span class="text-xl">🌟</span>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Safe workplaces</h3>
                <p class="text-slate-700 leading-7">Jobs are shared from caring companies that value respect, skills, and positive teamwork.</p>
            </article>
            <article class="rounded-[1.75rem] border border-blue-100 bg-white p-6 shadow-sm">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <span class="text-xl">📘</span>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Easy support</h3>
                <p class="text-slate-700 leading-7">If you need help, our team is ready to answer questions in a kind and patient way.</p>
            </article>
        </div>
    </div>
</section>

<section class="bg-white py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-4">
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-blue-700">Featured jobs</p>
                <h2 id="featured-jobs-heading" class="text-3xl font-bold text-slate-900">Jobs hiring now</h2>
            </div>
            <button class="inline-flex items-center justify-center rounded-full border border-blue-700 bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Show more jobs
            </button>
        </div>
        <div class="mt-8 grid gap-5 lg:grid-cols-3" role="list">
            <a href="#" class="block rounded-[1.75rem] border border-slate-200 bg-sky-50 p-6 shadow-sm cursor-pointer transition duration-300 hover:shadow-lg hover:bg-blue-100 hover:border-blue-300 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="rounded-2xl bg-white p-3 shadow-sm">
                        <img src="https://img.icons8.com/fluency/48/organization.png" alt="Company icon" class="h-10 w-10">
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">Job Role</h3>
                        <p class="text-sm text-slate-600">Company not specified • Location not specified</p>
                    </div>
                </div>
                <div class="mt-5 flex items-center justify-between">
                    <span class="rounded-full bg-blue-700/10 px-3 py-1 text-sm font-medium text-blue-700">Work type</span>
                    <!-- Time posted -->
                    <span class="text-sm text-slate-600">Date not specified</span>
                </div>
            </a>
            <a href="#" class="block rounded-[1.75rem] border border-slate-200 bg-sky-50 p-6 shadow-sm cursor-pointer transition duration-300 hover:shadow-lg hover:bg-blue-100 hover:border-blue-300 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="rounded-2xl bg-white p-3 shadow-sm">
                        <img src="https://img.icons8.com/fluency/48/organization.png" alt="Company icon" class="h-10 w-10">
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">Job Role</h3>
                        <p class="text-sm text-slate-600">Company not specified • Location not specified</p>
                    </div>
                </div>
                <div class="mt-5 flex items-center justify-between">
                    <span class="rounded-full bg-blue-700/10 px-3 py-1 text-sm font-medium text-blue-700">Work type</span>
                    <!-- Time posted -->
                    <span class="text-sm text-slate-600">Date not specified</span>
                </div>
            </a>
            <a href="#" class="block rounded-[1.75rem] border border-slate-200 bg-sky-50 p-6 shadow-sm cursor-pointer transition duration-300 hover:shadow-lg hover:bg-blue-100 hover:border-blue-300 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="rounded-2xl bg-white p-3 shadow-sm">
                        <img src="https://img.icons8.com/fluency/48/organization.png" alt="Company icon" class="h-10 w-10">
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">Job Role</h3>
                        <p class="text-sm text-slate-600">Company not specified • Location not specified</p>
                    </div>
                </div>
                <div class="mt-5 flex items-center justify-between">
                    <span class="rounded-full bg-blue-700/10 px-3 py-1 text-sm font-medium text-blue-700">Work type</span>
                    <!-- Time posted -->
                    <span class="text-sm text-slate-600">Date not specified</span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="bg-blue-800 py-14 sm:py-16" role="region" aria-labelledby="employer-cta-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="rounded-[2rem] bg-white/10 p-6 shadow-2xl ring-1 ring-white/10 sm:p-10 backdrop-blur-md">
            <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="space-y-4 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-200">For employers</p>
                    <h2 id="employer-cta-heading" class="text-3xl sm:text-4xl font-bold">Hire from a community that cares</h2>
                    <p class="max-w-2xl text-base leading-7 text-slate-200">Share your job opening and connect with motivated, caring applicants from the Down syndrome community today.</p>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
                        <a href="#" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3.5 text-base font-semibold text-blue-800 shadow-xl transition hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                            Get started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection