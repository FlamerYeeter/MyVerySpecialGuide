@extends('layouts.includes')

@section('content')

<!--PAAYOS NLANG DIN UNG ITSURA AND BACK END GOIZZZ-->
<!-- Back Button -->
<div class="bg-yellow-400 mt-6 py-8 px-6">
  <a href="/job-details" class="flex items-center space-x-3 text-blue-900 text-3xl font-semibold hover:underline">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span>Back</span>
  </a>
</div>

  <!-- Saved Jobs Overview -->
  <div class="max-w-4xl mx-auto mt-8 px-4">
    <div class="border border-blue-300 bg-white rounded-lg p-6 flex items-start space-x-4">
      <div class="bg-green-100 p-3 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2L14.09 8.26L20.97 8.27L15.45 12.14L17.54 18.4L12 14.53L6.46 18.4L8.55 12.14L3.03 8.27L9.91 8.26L12 2Z" />
        </svg>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-blue-600">Your Saved Jobs</h2>
        <p class="text-sm text-gray-600">Jobs you have saved for later review and application</p>
        <div class="mt-3">
          <button class="bg-green-700 text-white px-4 py-1 rounded-md text-sm font-medium">
            2 Saved Jobs
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Job Cards -->
  <div class="max-w-4xl mx-auto mt-8 px-4 space-y-8">
    @if(empty($savedJobs))
      <div class="bg-yellow-50 border border-yellow-200 rounded p-6 text-center text-gray-600">You have no saved jobs yet.</div>
    @else
      @foreach($savedJobs as $job)
        @php
          // JobCsvParser returns lowercase header keys; support both shapes
          $title = $job['title'] ?? $job['job_title'] ?? $job['job_id'] ?? 'Untitled Job';
          $company = $job['company'] ?? $job['company_name'] ?? '';
          $location = $job['location'] ?? '';
          $description = $job['description'] ?? $job['job_description'] ?? ($job['raw']['job_description'] ?? '') ?? '';
          $jobId = $job['job_id'] ?? ($job['job_id'] = $job['row_index'] ?? null) ?? ($job['job_id'] ?? '');
        @endphp
        <div class="border border-gray-300 rounded-lg p-6 flex justify-between items-start shadow-sm">
          <div>
            <h3 class="font-semibold text-lg">{{ $title }}</h3>
            @if($company)<p class="text-gray-600 text-sm">{{ $company }}</p>@endif
            @if($location)<p class="text-gray-500 text-sm mt-1">{{ $location }}</p>@endif

            <p class="text-sm text-gray-700 mt-3">{{ Str::limit(strip_tags($description), 220) }}</p>
          </div>

          <div class="flex flex-col items-end space-y-4">
            <img src="{{ asset('image/jobexp3.png') }}" alt="logo" class="w-20 h-20 object-contain">
            <div class="flex space-x-2">
              <a href="{{ route('job.details', ['job_id' => $jobId]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition">View Details</a>
              <form method="POST" action="{{ route('my.job.applications.remove') }}" class="inline-block">
                @csrf
                <input type="hidden" name="job_id" value="{{ $jobId }}">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium">Remove</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    @endif

  </div>
</div>

@endsection