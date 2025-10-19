@extends('layouts.includes')

@section('content')
@php
    $csv_path = public_path('data job posts.csv');
    $job = null;
    $job_id = request('job_id');
    if ($job_id !== null && file_exists($csv_path)) {
        if (($handle = fopen($csv_path, 'r')) !== false) {
            $header = fgetcsv($handle);
            $cols = array_map(function($h){ return trim($h); }, $header ?: []);
            // same inference helpers as job-matches
            $infer_fit_level = function(string $text) {
                $t = strtolower($text);
                $excellent = ['excellent', 'perfect', 'highly suitable', 'highly qualified', 'strong match', 'ideal'];
                foreach ($excellent as $k) { if (strpos($t, $k) !== false) return 'Excellent Fit'; }
                $good = ['good fit', 'good', 'suitable', 'appropriate', 'fit'];
                foreach ($good as $k) { if (strpos($t, $k) !== false) return 'Good Fit'; }
                return '';
            };
            $infer_growth_potential = function(string $text) {
                $t = strtolower($text);
                $high = ['promotion', 'career growth', 'growth', 'advance', 'development', 'opportunity', 'career advancement', 'leadership'];
                foreach ($high as $k) { if (strpos($t, $k) !== false) return 'High Potential'; }
                $medium = ['entry level', 'entry-level', 'trainee', 'starter', 'mid-level'];
                foreach ($medium as $k) { if (strpos($t, $k) !== false) return 'Medium Potential'; }
                return '';
            };
            $infer_work_environment = function(string $text) {
                $t = strtolower($text);
                $quiet = ['quiet', 'calm', 'low noise', 'private', 'peaceful', 'indoor quiet'];
                foreach ($quiet as $k) { if (strpos($t, $k) !== false) return 'Quiet'; }
                $busy = ['busy', 'fast-paced', 'high energy', 'crowd', 'bustling', 'active environment'];
                foreach ($busy as $k) { if (strpos($t, $k) !== false) return 'Busy'; }
                return '';
            };

            $i = 0;
            while (($row = fgetcsv($handle)) !== false) {
                if ($i == intval($job_id)) {
                    $assoc = array_combine($cols, $row) ?: [];
                    $textForInference = trim(($assoc['JobDescription'] ?? '') . ' ' . ($assoc['JobRequirment'] ?? '') . ' ' . ($assoc['jobpost'] ?? ''));
                    $inferred_fit = $infer_fit_level($textForInference);
                    $inferred_growth = $infer_growth_potential($textForInference);
                    $inferred_env = $infer_work_environment($textForInference);
                    $job = [
                        'title' => $assoc['Title'] ?? $assoc['jobpost'] ?? '',
                        'company' => $assoc['Company'] ?? '',
                        'job_description' => $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? '',
                        'job_requirement' => $assoc['JobRequirment'] ?? $assoc['RequiredQual'] ?? '',
                        'location' => $assoc['Location'] ?? '',
                        'salary' => $assoc['Salary'] ?? '',
                        'start_date' => $assoc['StartDate'] ?? '',
                        'deadline' => $assoc['Deadline'] ?? '',
                        'announcement_code' => $assoc['AnnouncementCode'] ?? '',
                        'fit_level' => $assoc['fit_level'] ?? $assoc['FitLevel'] ?? $inferred_fit,
                        'growth_potential' => $assoc['growth_potential'] ?? $assoc['GrowthPotential'] ?? $inferred_growth,
                        'work_environment' => $assoc['work_environment'] ?? $assoc['WorkEnvironment'] ?? $inferred_env ?? ($assoc['Location'] ?? ''),
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
      <a href="{{ route('job.matches') }}" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back to Job Matches</span>
      </a>
    </div>
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
        <h2 class="text-2xl font-bold text-gray-800">{{ $job['title'] ?: $job['job_description'] }}</h2>
        @if(!empty($job['company']))
          <p class="text-sm text-gray-700 font-medium">{{ $job['company'] }}</p>
        @endif
         <div class="flex items-center text-gray-600 text-sm space-x-3 mt-2">
            @if(!empty($job['location']))
            <span class="bg-gray-100 text-xs px-3 py-1 rounded">{{ $job['location'] }}</span>
          @endif
          @if(!empty($job['start_date']))
            <span class="bg-gray-100 text-xs px-3 py-1 rounded">Starts: {{ $job['start_date'] }}</span>
          @endif
         </div>
         <div class="mt-5">
           <h3 class="font-semibold text-gray-700">Job Description:</h3>
          <p class="text-gray-700 text-sm mt-2">{{ $job['job_description'] }}</p>
         </div>
         <div class="mt-5">
           <h3 class="font-semibold text-gray-700">Resume Example:</h3>
          <p class="text-gray-600 text-sm mt-2">{{ $job['job_requirement'] }}</p>
         </div>
         <div class="mt-5">
           <h3 class="font-semibold text-gray-700">Job Fit Level & Potential</h3>
           <div class="flex flex-wrap gap-2 mt-2">
            {{-- no direct fit/growth data in CSV; show placeholders if available --}}
            @if(!empty($job['announcement_code']))
              <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded">Code: {{ $job['announcement_code'] }}</span>
            @endif
            @if(!empty($job['salary']))
              <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">Salary: {{ $job['salary'] }}</span>
            @endif
           </div>
         </div>
        <p class="text-xs text-gray-500 mt-4">Deadline: {{ $job['deadline'] ?? '-' }}</p>
       </div>
     </section>
   @else
    <div class="max-w-5xl mx-auto mt-10 px-4">
      <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded">
        No job details found. Please select a job from <a href="{{ route('job.matches') }}" class="underline text-blue-600">Job Matches</a>.
      </div>
    </div>
  @endif

<!-- Ensure global Firebase config is present and require login for actions on this page -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
  <script>
    @auth
      window.__SERVER_AUTH = true;
    @else
      window.__SERVER_AUTH = false;
    @endauth
  </script>
  <script type="module">
    (async function(){
      try {
        const mod = await import("{{ asset('js/job-application-firebase.js') }}");
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
        // signed-in users proceed; no further client setup required here
      } catch (err) {
        console.error('Auth guard failed on job details', err);
      }
    })();
</script>
@endsection