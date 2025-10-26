@extends('layouts.includes')

@section('content')

<!-- NOTE: THIS IS STILL IN PROGRESS, I'M NOT SURE PANO AANUHIN YAN -->
    <!-- Filter Form -->
    <section class="bg-yellow-400 py-7 mt-4">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('job.matches') }}">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/my-job-app.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-blue-800">My Job Applications</h2>
                        <p class="text-sm text-gray-600">Track your application progress and manage your job applications</p>
                    </div>
                </div>
            </form>
        </div>
    </section>

  <!-- Application Stats -->
  <div class="max-w-5xl mx-auto mt-10 px-4 flex justify-between text-center">
    <div class="w-1/3 border rounded-lg py-4 bg-white shadow-sm">
      <h3 class="text-3xl font-bold text-blue-600">1</h3>
      <p class="text-sm text-gray-700 font-medium">Pending Review</p>
    </div>
    <div class="w-1/3 border rounded-lg py-4 bg-white shadow-sm">
      <h3 class="text-3xl font-bold text-green-600">0</h3>
      <p class="text-sm text-gray-700 font-medium">Under Review</p>
    </div>
    <div class="w-1/3 border rounded-lg py-4 bg-white shadow-sm">
      <h3 class="text-3xl font-bold text-pink-600">2</h3>
      <p class="text-sm text-gray-700 font-medium">Total Applications</p>
    </div>
  </div>

  <!-- SEARCH & FILTER -->
  <section class="max-w-6xl mx-auto mt-10 px-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 flex-grow max-w-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 6.65a7.5 7.5 0 010 10.6z" />
        </svg>
        <input type="text" placeholder="Search applications by job title or company" class="ml-2 w-full focus:outline-none text-sm">
      </div>

      <div class="flex gap-3">
        <button class="border border-[#007BFF] text-[#007BFF] px-4 py-2 rounded-md flex items-center gap-2">
          All Status ▾
        </button>
        <button class="border border-[#007BFF] text-[#007BFF] px-4 py-2 rounded-md flex items-center gap-2">
          All Time ▾
        </button>
      </div>
    </div>
  </section>


    <!-- JOB APPLICATION CARD 1 -->
  <section class="max-w-6xl mx-auto mt-8 px-4">
    <div class="border border-gray-300 rounded-md shadow-sm mb-8">
      <div class="p-5">
        <h3 class="text-lg font-semibold text-gray-800">Pet Care Assistant</h3>
        <p class="text-gray-600">iPet Club • Taguig City, Metro Manila</p>
        <p class="flex items-center text-sm text-gray-700 mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10m-10 4h10m-6 4h6m-10 0h.01M4 21h16a2 2 0 002-2V7a2 2 0 00-2-2h-1V3m-14 2v16a2 2 0 002 2z" />
          </svg>
          Applied: Aug 25, 2025
        </p>
      </div>

      <div class="bg-[#C7F9F1] p-6 border-t border-gray-300">
        <h4 class="text-gray-800 font-medium mb-4">Application Progress</h4>
        <div class="flex justify-between text-center">
          <div>
            <div class="text-green-600 text-2xl"><b>✓</b></div>
            <p class="text-sm text-gray-700 font-medium mt-1">Application Submitted</p>
            <p class="text-xs text-gray-600 mt-1">Aug 25</p>
          </div>
          <div><div class="text-gray-400 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Initial Review</p></div>
          <div><div class="text-gray-400 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Initial Processing</p></div>
          <div><div class="text-gray-400 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Final Review</p></div>
          <div><div class="text-gray-400 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Decision</p></div>
        </div>

        <div class="mt-6 flex justify-between items-center">
          <button class="bg-[#FFB4B4] text-[#6B0000] px-4 py-2 rounded-md text-sm font-medium">Withdraw Application</button>
          <p class="text-xs text-gray-500">Last update: 2 hours ago</p>
        </div>
      </div>
    </div>

 <div class="border border-gray-300 rounded-md shadow-sm mb-10">
  <div class="p-5">
    <!-- HEADER -->
    <div class="flex justify-between items-start">
      <div>
        <!-- Job Title + Status Badge -->
        <div class="flex items-center gap-3">
          <h3 class="text-lg font-semibold text-gray-800">Cashier</h3>
          <span class="bg-[#FDDCDC] text-[#9B1C1C] px-3 py-1 rounded-md text-xs font-medium">
            Not selected
          </span>
        </div>
            <p class="text-gray-600">McDonald’s • Taguig City, Metro Manila</p>
            <p class="flex items-center text-sm text-gray-700 mt-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10m-10 4h10m-6 4h6m-10 0h.01M4 21h16a2 2 0 002-2V7a2 2 0 00-2-2h-1V3m-14 2v16a2 2 0 002 2z" />
              </svg>
              Applied: Aug 15, 2025
            </p>
          </div>
        </div>
      </div>

      <div class="bg-[#C7F9F1] p-6 border-t border-gray-300">
        <h4 class="text-gray-800 font-medium mb-4">Application Progress</h4>
        <div class="flex justify-between text-center">
          <div>
            <div class="text-green-600 text-2xl"><b>✓</b></div>
            <p class="text-sm text-gray-700 font-medium mt-1">Application Submitted</p>
            <p class="text-xs text-gray-600 mt-1">Aug 15</p>
          </div>
          <div><div class="text-green-600 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Initial Review</p><p class="text-xs text-gray-600">Aug 18</p></div>
          <div><div class="text-green-600 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Initial Processing</p><p class="text-xs text-gray-600">Aug 22</p></div>
          <div><div class="text-green-600 text-2xl"><b>✓</b></div><p class="text-sm text-gray-600 mt-1">Final Review</p><p class="text-xs text-gray-600">Aug 24</p></div>
          <div><div class="text-red-500 text-2xl"><b>✓</b></div><p class="text-sm text-red-500 mt-1">Decision</p><p class="text-xs text-gray-600">Aug 25</p></div>
        </div>

        <div class="mt-6 flex justify-between items-center">
          <button class="bg-[#B7F3C5] text-[#046C32] px-4 py-2 rounded-md text-sm font-medium">View Feedback</button>
          <p class="text-xs text-gray-500">Last update: 3 days ago</p>
        </div>
      </div>
    </div>
  </section>


  <!-- ✖️ -->
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

  <div class="max-w-5xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">Saved Jobs</h2>
    @if(empty($jobs))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded text-center">
            You have no saved jobs yet.
        </div>
    @else
        @foreach($jobs as $job)
            <div class="border rounded-lg bg-white shadow-sm mb-8">
                <div class="p-4 flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $job['job_description'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $job['resume'] }}</p>
                        <div class="flex gap-2 text-xs mt-2">
                            @if($job['industry'])
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $job['industry'] }}</span>
                            @endif
                            @if($job['work_environment'])
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $job['work_environment'] }}</span>
                            @endif
                        </div>
                        <div class="flex gap-2 mt-2">
                            @if($job['fit_level'])
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $job['fit_level'] }}</span>
                            @endif
                            @if($job['growth_potential'])
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
            </div>
        @endforeach
    @endif
  </div>
</div>
@endsection

<!-- Require sign-in on My Job Applications page -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
<script type="module">
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
</script>
