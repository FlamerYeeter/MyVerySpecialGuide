@extends('layouts.app')

@section('content')
<main role="main" class="overflow-x-hidden">
<section class="bg-sky-50" role="region" aria-labelledby="hero-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 py-12 sm:py-16">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_1fr] lg:items-center">
            <div class="space-y-6 text-center lg:text-left">

                <h1 id="hero-heading" class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-slate-900 leading-tight">
                    Welcome to <span class="text-blue-700">EmpowerPath</span>
                </h1>

                <p class="max-w-2xl text-xl sm:text-2xl leading-relaxed text-slate-800">
                   Everyone deserves a chance to work and shine. We help people with Down syndrome find great jobs and build great futures.
                </p>

                <div class="grid gap-4 sm:grid-cols-2">
                    <a href="#job-search" class="inline-flex items-center justify-center rounded-full bg-blue-700 px-8 py-4 text-white text-lg font-bold shadow-lg transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Search jobs
                    </a>
                    <a href="#support" class="inline-flex items-center justify-center rounded-full border-2 border-blue-700 bg-white px-8 py-4 text-blue-700 text-lg font-bold shadow-lg transition hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
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
                <p class="text-base font-bold uppercase tracking-widest text-blue-700">Easy job search</p>
                <h2 id="job-search-heading" class="text-4xl sm:text-5xl font-bold text-slate-900 mt-2">Find a job that fits you</h2>
                <p class="max-w-2xl text-lg sm:text-xl text-slate-800 leading-relaxed mt-3">Find jobs from companies that are hiring right now. Your next great job could be waiting for you!</p>

                <div class="rounded-3xl bg-sky-50 border border-sky-200 p-6 shadow-sm">
                    <div class="rounded-2xl bg-blue-700/5 border-2 border-blue-200 p-6 mb-6">
                        <p class="text-base font-bold text-blue-900">Three easy steps:</p>
                        <ol class="mt-4 space-y-3 text-lg text-slate-800">
                            <li class="rounded-xl bg-white px-5 py-4 shadow-sm font-semibold">1. Write the job you want</li>
                            <li class="rounded-xl bg-white px-5 py-4 shadow-sm font-semibold">2. Pick your city</li>
                            <li class="rounded-xl bg-white px-5 py-4 shadow-sm font-semibold">3. Click Search jobs</li>
                        </ol>
                    </div>

                    <form method="GET" action="{{ route('home') }}" class="space-y-5" novalidate>
                        <div class="space-y-3">
                            <label for="job-title" class="block text-lg font-bold text-slate-900">What job do you want?</label>
                            <div class="relative">
                                <img src="https://img.icons8.com/ios-filled/20/search--v1.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                                <input id="job-title" name="job-title" type="text" autocomplete="off" placeholder="Service Crew, Barista..." class="w-full rounded-2xl border-2 border-slate-300 bg-white px-12 py-4 text-lg text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="job-title-help job-title-suggestions">
                                <div id="job-title-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-48 overflow-y-auto hidden z-10">
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Service Crew">Service Crew</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Barista">Barista</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Kitchen Helper">Kitchen Helper</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Housekeeping">Housekeeping</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Food Runner">Food Runner</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 last:border-b-0" data-value="Front Desk">Front Desk</button>
                                </div>
                            </div>
                            <p id="job-title-help" class="text-base text-slate-600">Type a job or pick one from the list.</p>
                        </div>

                        <div class="space-y-3">
                            <label for="location" class="block text-lg font-bold text-slate-900">Where do you want to work?</label>
                            <div class="relative">
                                <img src="https://img.icons8.com/ios-filled/20/marker.png" alt="" aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400">
                                <input id="location" name="location" type="text" autocomplete="off" placeholder="Taguig City, Manila..." class="w-full rounded-2xl border-2 border-slate-300 bg-white px-12 py-4 text-lg text-slate-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" aria-describedby="location-help location-suggestions">
                                <div id="location-suggestions" class="absolute top-full left-0 right-0 mt-2 rounded-2xl border border-slate-300 bg-white shadow-lg max-h-48 overflow-y-auto hidden z-10">
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Taguig City">Taguig City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Mandaluyong City">Mandaluyong City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Makati City">Makati City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Pasig City">Pasig City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 border-b border-slate-200 last:border-b-0" data-value="Quezon City">Quezon City</button>
                                    <button type="button" class="suggestion-item w-full text-left px-4 py-2.5 text-sm hover:bg-blue-50 last:border-b-0" data-value="Paranaque City">Paranaque City</button>
                                </div>
                            </div>
                            <p id="location-help" class="text-base text-slate-600">Type a city or pick one from the list.</p>
                        </div>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-700 px-8 py-4 text-base font-semibold text-white shadow-lg transition hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
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

<section id="support" class="bg-slate-50 py-14 sm:py-20" role="region" aria-labelledby="support-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="text-center max-w-3xl mx-auto space-y-6">
            <p class="text-base font-bold uppercase tracking-widest text-blue-700">Why EmpowerPath</p>
            <h2 id="support-heading" class="text-4xl sm:text-5xl font-bold text-slate-900 mb-2">We guide you every step</h2>
            <p class="text-lg sm:text-xl text-slate-700 leading-relaxed">Looking for a job can feel hard. We make it simple, kind, and easy to understand for people with Down syndrome and their families.</p>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            <article class="rounded-[1.75rem] border-2 border-blue-100 bg-white p-7 shadow-md">
                <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100">
                    <img src="https://img.icons8.com/fluency/64/handshake.png" alt="Handshake icon" class="h-10 w-10">
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Clear and simple</h3>
                <p class="text-lg text-slate-700 leading-relaxed">We use easy words and clear steps so you can feel confident and comfortable moving forward.</p>
            </article>
            <article class="rounded-[1.75rem] border-2 border-blue-100 bg-white p-7 shadow-md">
                <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100">
                    <img src="https://img.icons8.com/fluency/64/star.png" alt="Star icon" class="h-10 w-10">
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Kind workplaces</h3>
                <p class="text-lg text-slate-700 leading-relaxed">We find jobs from companies that treat people with respect and care about a happy workplace.</p>
            </article>
            <article class="rounded-[1.75rem] border-2 border-blue-100 bg-white p-7 shadow-md">
                <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100">
                    <img src="https://img.icons8.com/fluency/64/help.png" alt="Help icon" class="h-10 w-10">
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Friendly support</h3>
                <p class="text-lg text-slate-700 leading-relaxed">If you have a question, we are here to help in a patient and caring way.</p>
            </article>
        </div>
    </div>
</section>

<section class="bg-white py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-3">
                <p class="text-base font-bold uppercase tracking-widest text-blue-700">Featured jobs</p>
                <h2 id="featured-jobs-heading" class="text-4xl font-bold text-slate-900">Jobs hiring now</h2>
            </div>
            <a href="{{ route('hiringjobs') }}" class="inline-flex items-center justify-center rounded-full bg-blue-700 px-8 py-3.5 text-base font-bold text-white shadow-lg transition hover:bg-blue-800 hover:shadow-xl active:scale-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Show more jobs
            </a>
        </div>
        <div class="mt-8 grid gap-6 lg:grid-cols-3" role="list">
            <a href="#" class="block rounded-[1.75rem] border-2 border-slate-200 bg-white p-7 shadow-md cursor-pointer transition duration-300 hover:shadow-xl hover:bg-blue-50 hover:border-blue-400 hover:-translate-y-2">
                <div class="flex items-center gap-5">
                    <div class="rounded-2xl bg-blue-50 p-4 shadow-sm">
                        <img src="https://img.icons8.com/fluency/48/organization.png" alt="Company icon" class="h-12 w-12">
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">Job Role</h3>
                        <p class="text-base text-slate-600">Company • Location</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="rounded-full bg-blue-100 px-5 py-2.5 text-base font-bold text-blue-700">Work type</span>
                    <!-- Time posted -->
                    <span class="text-sm text-slate-600">Posted date</span>
                </div>
            </a>
            <a href="#" class="block rounded-[1.75rem] border-2 border-slate-200 bg-white p-7 shadow-md cursor-pointer transition duration-300 hover:shadow-xl hover:bg-blue-50 hover:border-blue-400 hover:-translate-y-2">
                <div class="flex items-center gap-5">
                    <div class="rounded-2xl bg-blue-50 p-4 shadow-sm">
                        <img src="https://img.icons8.com/fluency/48/organization.png" alt="Company icon" class="h-12 w-12">
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">Job Role</h3>
                        <p class="text-base text-slate-600">Company • Location</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="rounded-full bg-blue-100 px-5 py-2.5 text-base font-bold text-blue-700">Work type</span>
                    <!-- Time posted -->
                    <span class="text-sm text-slate-600">Posted date</span>
                </div>
            </a>
            <a href="#" class="block rounded-[1.75rem] border-2 border-slate-200 bg-white p-7 shadow-md cursor-pointer transition duration-300 hover:shadow-xl hover:bg-blue-50 hover:border-blue-400 hover:-translate-y-2">
                <div class="flex items-center gap-5">
                    <div class="rounded-2xl bg-blue-50 p-4 shadow-sm">
                        <img src="https://img.icons8.com/fluency/48/organization.png" alt="Company icon" class="h-12 w-12">
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">Job Role</h3>
                        <p class="text-base text-slate-600">Company • Location</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="rounded-full bg-blue-100 px-5 py-2.5 text-base font-bold text-blue-700">Work type</span>
                    <!-- Time posted -->
                    <span class="text-sm text-slate-600">Posted date</span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="bg-blue-800 py-14 sm:py-16" role="region" aria-labelledby="employer-cta-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="rounded-[2rem] bg-white/10 p-6 shadow-2xl ring-1 ring-white/10 sm:p-10 backdrop-blur-md">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="space-y-4 text-white max-w-2xl">
                    <p class="text-base font-bold uppercase tracking-widest text-sky-200">For employers</p>
                    <h2 id="employer-cta-heading" class="text-4xl sm:text-5xl font-bold mt-2">Hire from a caring community</h2>
                    <p class="text-lg leading-relaxed text-sky-100 mt-4">Share a job opening. Connect with motivated and caring workers from the Down syndrome community.</p>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 mt-6 justify-center">
                        <a href="#" class="inline-flex items-center justify-center rounded-full bg-white px-10 py-4 text-lg font-bold text-blue-800 shadow-xl transition hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
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