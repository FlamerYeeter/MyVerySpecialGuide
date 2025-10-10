@extends('layouts.includes')

@section('content')

<!-- NOTE: THIS IS STILL IN PROGRESS, I'M NOT SURE PANO AANUHIN YAN -->
    <!-- Back Button -->
  <section class="bg-yellow-400 py-10 mt-4">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center space-x-4 mb-6">
                <img src="{{ asset('images/job-search.png') }}" class="w-20 h-20"> <!-- will export the image -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">My Job Applications</h2>
                    <p class="text-sm text-gray-800">Track your application progress and manage your job applications</p>
                </div>
            </div>
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

  <!-- Search and Filters -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    <div class="bg-white border rounded-lg shadow-sm p-4 flex items-center justify-between">
      <div class="flex items-center w-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor" class="w-5 h-5 text-gray-400">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 21l-5.2-5.2m0 0A7.5 7.5 0 105.8 5.8a7.5 7.5 0 0010 10z" />
        </svg>
        <input type="text" placeholder="Search applications by job title or company"
          class="ml-2 w-full border-none focus:ring-0 text-sm text-gray-700 placeholder-gray-400">
      </div>
      <div class="flex items-center space-x-3">
        <select class="border rounded-lg px-3 py-2 text-sm">
          <option>All Status</option>
        </select>
        <select class="border rounded-lg px-3 py-2 text-sm">
          <option>All Time</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Job Application 1 -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    <div class="border rounded-lg bg-white shadow-sm">
      <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800">Pet Care Assistant</h3>
        <p class="text-sm text-gray-600">iPet Club • Taguig City, Metro Manila</p>
        <p class="text-sm text-gray-600 mt-1">
          <span class="inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 9h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z" />
            </svg>
            Applied: Aug 25, 2025
          </span>
        </p>
      </div>

      <!-- Progress -->
      <div class="bg-cyan-50 px-6 py-4 border-t">
        <h4 class="font-semibold text-gray-800 mb-3">Application Progress</h4>
        <div class="flex justify-between text-center text-sm text-gray-600 mb-4">
          <div>
            <div class="text-green-600">✔️</div>
            <p class="font-medium">Application Submitted</p>
            <p>Aug 25</p>
          </div>
          <div>
            <div>⭕</div>
            <p class="font-medium">Initial Review</p>
          </div>
          <div>
            <div>⭕</div>
            <p class="font-medium">Initial Processing</p>
          </div>
          <div>
            <div>⭕</div>
            <p class="font-medium">Final Review</p>
          </div>
          <div>
            <div>⭕</div>
            <p class="font-medium">Decision</p>
          </div>
        </div>

        <div class="flex justify-between items-center">
          <button class="bg-red-200 text-red-800 px-4 py-2 rounded hover:bg-red-300 text-sm">
            Withdraw Application
          </button>
          <p class="text-xs text-gray-500">Last update: 2 hours ago</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Job Application 2 -->
  <div class="max-w-5xl mx-auto mt-6 px-4 mb-10">
    <div class="border rounded-lg bg-white shadow-sm">
      <div class="p-4 flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">Cashier</h3>
          <p class="text-sm text-gray-600">McDonald’s • Taguig City, Metro Manila</p>
          <p class="text-sm text-gray-600 mt-1">
            <span class="inline-flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8 7V3m8 4V3m-9 9h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z" />
              </svg>
              Applied: Aug 15, 2025
            </span>
          </p>
        </div>
        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full font-medium">Not selected</span>
      </div>

      <div class="bg-cyan-50 px-6 py-4 border-t">
        <h4 class="font-semibold text-gray-800 mb-3">Application Progress</h4>
        <div class="flex justify-between text-center text-sm text-gray-600 mb-4">
          <div>
            <div class="text-green-600">✔️</div>
            <p class="font-medium">Application Submitted</p>
            <p>Aug 15</p>
          </div>
          <div>
            <div class="text-green-600">✔️</div>
            <p class="font-medium">Initial Review</p>
            <p>Aug 18</p>
          </div>
          <div>
            <div class="text-green-600">✔️</div>
            <p class="font-medium">Initial Processing</p>
            <p>Aug 22</p>
          </div>
          <div>
            <div class="text-green-600">✔️</div>
            <p class="font-medium">Final Review</p>
            <p>Aug 24</p>
          </div>
          <div>
            <div class="text-red-500">✖️</div>
            <p class="font-medium text-red-500">Decision</p>
            <p>Aug 25</p>
          </div>
        </div>

        <div class="flex justify-between items-center">
          <button class="bg-green-200 text-green-800 px-4 py-2 rounded hover:bg-green-300 text-sm">
            View Feedback
          </button>
          <p class="text-xs text-gray-500">Last update: 3 days ago</p>
        </div>
      </div>
    </div>
  </div>

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
