@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">


    <!--PAAYOS NLANG DIN UNG ITSURA AND BACK END GOIZZZ-->
    <!-- Back Button -->
    <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
        <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
            <a href="/jobmatches"
                class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Jobs</span>
            </a>
        </div>
    </div>

    <!-- Saved Jobs Overview -->
    <section class="max-w-6xl mx-auto mt-10 px-6">

        <!-- Overview Card -->
        <div
            class="border-4 border-blue-300 bg-blue-50 rounded-3xl shadow-md p-10 flex flex-col sm:flex-row items-center sm:items-start sm:space-x-8 space-y-6 sm:space-y-0">

            <!-- Icon -->
            <div
                class="flex items-center justify-center bg-white border-2 border-yellow-300 p-6 rounded-2xl shadow-sm flex-shrink-0">
                <img src="https://img.icons8.com/color/96/star--v1.png" alt="Saved Jobs Icon" class="h-16 w-16">
            </div>

            <!-- Text + Button -->
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-3xl font-extrabold text-blue-700 mb-3 tracking-wide">
                    Your Saved Jobs
                </h2>
                <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                    These are the jobs you’ve saved for later. You can look at them again and apply when you’re ready!
                </p>

                <div class="flex justify-center sm:justify-start">
                    <button
                        class="flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white text-xl font-bold px-10 py-4 rounded-2xl shadow-lg transition-all duration-200 focus:ring-4 focus:ring-green-400 focus:outline-none">
                        <img src="https://img.icons8.com/fluency/48/bookmark-ribbon.png" alt="Saved Jobs Icon"
                            class="h-8 w-8">
                        No Saved Jobs Yet
                    </button>
                </div>
            </div>
        </div>

       {{--<!-- Job List Container -->
        <div class="mt-10 space-y-8">

            <!-- Job Card -->
            <div
                class="bg-white border-2 border-blue-200 rounded-1xl shadow-lg p-8 flex flex-col lg:flex-row justify-between items-start gap-8 hover:scale-[1.01] transition-transform duration-300">

                <!-- Left: Logo + Info -->
                <div class="flex items-start gap-6 w-full lg:w-2/3">

                    <!-- Flag -->
                    {{-- <button
                        class="flag-btn text-gray-400 text-4xl font-bold focus:outline-none hover:text-red-500 transition-all duration-300 self-start mt-2"
                        title="Report or Flag Job">
                        <i class="ri-flag-line"></i>
                    </button> --}}

                    <!-- Company Logo -->
                   {{-- <div class="flex-shrink-0">
                        @if (!empty($company->logo))
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                                class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-2 border-gray-300 object-cover shadow-sm">
                        @else
                            <div
                                class="w-28 h-28 sm:w-32 sm:h-32 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                                <i class="ri-building-4-fill text-[#1E40AF] text-5xl sm:text-6xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Job Info -->
                    {{-- <div class="flex flex-col justify-center flex-1">
                        <h3 class="font-bold text-2xl text-gray-800 leading-tight">Shakey’s Service Crew</h3>

                        <p class="text-base sm:text-lg text-gray-600 mt-2 flex items-center gap-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location Icon"
                                class="w-5 h-5 sm:w-6 sm:h-6">
                            Eastwood • Taguig City, PH
                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span
                                class="border border-[#2563EB] text-[#2563EB] text-sm sm:text-base px-4 py-2 rounded-md font-semibold">Full-Time</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Buttons + Progress -->
                <div class="flex flex-col items-center lg:items-end w-full lg:w-1/3 mt-4 lg:mt-0">

                    <!-- Assessment Button -->
                    {{-- <button
                        class="bg-[#FFAC1D] text-white text-base sm:text-lg font-bold rounded-lg px-8 py-3 w-full sm:w-[360px] mb-4 hover:bg-[#D78203] transition-all duration-200 text-center shadow-md">
                        Apply for Therapist Job Readiness Assessment
                    </button> --}}

                    <!-- Action Buttons -->
                    {{--  <div class="flex flex-wrap justify-center lg:justify-end gap-4 mb-4">
                        <button
                            class="bg-[#55BEBB] text-white font-semibold px-8 py-3 text-base rounded-lg hover:bg-[#399f96] transition-all w-[110px] shadow-md">
                            Details
                        </button>
                        <button
                            class="bg-[#2563EB] text-white font-semibold px-8 py-3 text-base rounded-lg hover:bg-[#1b3999] transition-all w-[110px] shadow-md">
                            Apply
                        </button>
                    </div>

                    <!-- Progress -->
                    <div class="w-full sm:w-[360px]">
                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-[#88BF02] w-1/2 rounded-full"></div>
                        </div>
                        <p class="text-sm sm:text-base text-gray-600 font-semibold mt-2 text-center lg:text-right">
                            <span class="font-semibold text-black">5 applied</span> of 10 capacity
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section> --}}





    <!-- Job Cards -->
    <div class="max-w-4xl mx-auto mt-8 px-4 space-y-8">
        @if (empty($savedJobs))
            <div class="bg-yellow-50 border border-yellow-200 rounded p-6 text-center text-gray-600">You have no saved jobs
                yet.</div>
        @else
            @foreach ($savedJobs as $job)
                @php
                    // JobCsvParser returns lowercase header keys; support both shapes
                    $title = $job['title'] ?? ($job['job_title'] ?? ($job['job_id'] ?? 'Untitled Job'));
                    $company = $job['company'] ?? ($job['company_name'] ?? '');
                    $location = $job['location'] ?? '';
                    $description =
                        $job['description'] ??
                        ($job['job_description'] ?? ($job['raw']['job_description'] ?? '' ?? ''));
                    $jobId = $job['job_id'] ?? (($job['job_id'] = $job['row_index'] ?? null) ?? ($job['job_id'] ?? ''));
                @endphp
                <div class="border border-gray-300 rounded-lg p-6 flex justify-between items-start shadow-sm">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $title }}</h3>
                        @if ($company)
                            <p class="text-gray-600 text-sm">{{ $company }}</p>
                        @endif
                        @if ($location)
                            <p class="text-gray-500 text-sm mt-1">{{ $location }}</p>
                        @endif

                        <p class="text-sm text-gray-700 mt-3">{{ Str::limit(strip_tags($description), 220) }}</p>
                    </div>

                    <div class="flex flex-col items-end space-y-4">
                        <img src="{{ asset('image/jobexp3.png') }}" alt="logo" class="w-20 h-20 object-contain">
                        <div class="flex space-x-2">
                            <a href="{{ route('job.details', ['job_id' => $jobId]) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition">View
                                Details</a>
                            <form method="POST" action="{{ route('my.job.applications.remove') }}" class="inline-block">
                                @csrf
                                <input type="hidden" name="job_id" value="{{ $jobId }}">
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
    </div>

@endsection
