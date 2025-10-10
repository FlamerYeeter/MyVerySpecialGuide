@extends('layouts.includes')

@section('content')
@php
    $csv_path = public_path('resume_job_matching_dataset.csv');
    $job = null;
    $job_id = request('job_id');
    if ($job_id !== null && file_exists($csv_path)) {
        if (($handle = fopen($csv_path, 'r')) !== false) {
            $header = fgetcsv($handle);
            $i = 0;
            while (($row = fgetcsv($handle)) !== false) {
                if ($i == intval($job_id)) {
                    $job = [
                        'job_description' => $row[0],
                        'resume' => $row[1],
                        'match_score' => $row[2],
                        'industry' => $row[3] ?? '',
                        'fit_level' => $row[4] ?? '',
                        'growth_potential' => $row[5] ?? '',
                        'work_environment' => $row[6] ?? '',
                        // Add more fields if your CSV has them
                    ];
                    break;
                }
                $i++;
            }
            fclose($handle);
        }
    }
@endphp

  <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/jobs" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back to Job Matches</span>
      </a>
    </div>
  </div>

  <!-- Green Info Box -->
  <div class="bg-green-100 border-l-4 border-green-500 text-green-800 max-w-5xl mx-auto mt-6 p-4 rounded">
    <p class="font-medium">The content shown here gives more detailed information about the job.</p>
    <p class="text-sm text-gray-700">(Ang nakikitang nilalaman dito ay mas detalyadong impormasyon tungkol sa trabaho.)</p>
  </div>

  <!-- Gray Info Box -->
  <div class="border max-w-5xl mx-auto bg-white mt-4 p-4 rounded shadow-sm">
    <p class="text-gray-700 text-sm">
      Click the “Apply” button to go to the application form for this job. <br>
      <span class="italic text-gray-500">(-I-click ang Apply button upang mapunta sa application form para sa trabahong ito.)</span>
    </p>
  </div>

  <!-- Job Details Section -->
  @if($job)
    <section class="max-w-5xl mx-auto mt-10 px-4">
      <div class="flex flex-col items-center">
        <img src="/images/ipetclub.png" alt="iPet Club" class="w-40 h-40 object-contain mb-4">
        <div class="flex space-x-4 mb-6">
          <a href="{{ route('job.application.1', ['job_id' => $job_id]) }}" class="bg-pink-500 text-white px-6 py-2 rounded hover:bg-pink-600 transition">Apply</a>
          <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Saved</button>
        </div>
      </div>
      <div class="bg-white rounded-lg p-6 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800">{{ $job['job_description'] }}</h2>
        <div class="flex items-center text-gray-600 text-sm space-x-3 mt-2">
          @if($job['industry'])
            <span class="bg-gray-100 text-xs px-3 py-1 rounded">{{ $job['industry'] }}</span>
          @endif
          @if($job['work_environment'])
            <span class="bg-gray-100 text-xs px-3 py-1 rounded">{{ $job['work_environment'] }}</span>
          @endif
        </div>
        <div class="mt-5">
          <h3 class="font-semibold text-gray-700">Job Description:</h3>
          <p class="text-gray-700 text-sm mt-2">{{ $job['job_description'] }}</p>
        </div>
        <div class="mt-5">
          <h3 class="font-semibold text-gray-700">Resume Example:</h3>
          <p class="text-gray-600 text-sm mt-2">{{ $job['resume'] }}</p>
        </div>
        <div class="mt-5">
          <h3 class="font-semibold text-gray-700">Job Fit Level & Potential</h3>
          <div class="flex flex-wrap gap-2 mt-2">
            @if($job['fit_level'])
              <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded">{{ $job['fit_level'] }}</span>
            @endif
            @if($job['growth_potential'])
              <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">{{ $job['growth_potential'] }}</span>
            @endif
          </div>
        </div>
        <p class="text-xs text-gray-500 mt-4">Match Score: {{ $job['match_score'] }}</p>
      </div>
    </section>
  @else
    <div class="max-w-5xl mx-auto mt-10 px-4">
      <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded">
        No job details found. Please select a job from <a href="{{ route('job.matches') }}" class="underline text-blue-600">Job Matches</a>.
      </div>
    </div>
  @endif

@endsection