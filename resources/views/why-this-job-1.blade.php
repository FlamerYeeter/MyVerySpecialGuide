@extends('layouts.includes')

@section('content')
<div class="font-sans bg-white text-gray-800">

<!-- Filter Form -->
    <section class="bg-pink-500 py-7 mt-4">
        <div class="container mx-auto px-4">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/brain.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-black">Why this Job and How to Get There?</h2>
                        <p class="text-sm text-black">Discover how your unique skills and interests align with this job role</p>
                        <p class="text-sm text-black">and learn the step-by-step path to achieve your aspirations </p>
                    </div>
                </div>
        </div>
    </section>
  
  <!-- Job Roles Section -->
  <section class="max-w-4xl mx-auto mt-10 mb-16 px-4">
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex items-center mb-6 space-x-3">
        <img src="{{ asset('image/matchedjob.png') }}" alt="Job Icon" class="w-8 h-8">
        <h3 class="text-xl font-semibold text-gray-800">Your Matched Job Roles</h3>
        <button class="text-blue-600 hover:text-blue-800">🔊</button>
      </div>

      @if(!empty($approvedJobs) && is_array($approvedJobs) && count($approvedJobs) > 0)
        @foreach($approvedJobs as $job)
          <div class="bg-white shadow rounded-xl border mb-8">
            <div class="p-6">
              <div class="flex justify-between items-center">
        <h4 class="font-semibold text-lg">{{ $job['assoc']['title'] ?? ($job['assoc']['job_title'] ?? 'Untitled Job') }}</h4>
        @php
          // Normalize match score to a 0-100 percent for display.
          $rawMatch = $job['match_score'] ?? null;
          $displayMatch = $job['assoc']['fit_level'] ?? 'Matched';
          $matchPercent = null;
          if (is_numeric($rawMatch)) {
            $m = floatval($rawMatch);
            if ($m > 0 && $m <= 1.01) {
              $matchPercent = round($m * 100);
            } elseif ($m > 0 && $m <= 5.0) {
              $matchPercent = round($m * 20);
            } else {
              $matchPercent = round($m);
            }
            $displayMatch = $matchPercent . '% Match';
          } elseif (!empty($rawMatch) && is_string($rawMatch)) {
            $displayMatch = $rawMatch;
          }
        @endphp
        <span class="text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full font-medium">{{ $displayMatch }}</span>
              </div>

              <p class="text-sm mt-2 text-gray-600 font-medium">Match Score</p>
              <div class="w-full bg-gray-200 h-3 rounded-full mt-1">
                <div class="bg-green-400 h-3 rounded-full" style="width: {{ $matchPercent !== null ? intval($matchPercent) . '%' : '50%' }}"></div>
              </div>
              <p class="text-right text-sm font-semibold mt-1">{{ $matchPercent !== null ? intval($matchPercent) . '%' : ($job['match_score'] ?? 'N/A') }}</p>

              <!-- Matching Skills -->
              <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Your Matching Skills</p>
                <div class="flex flex-wrap gap-3">
                  @if(!empty($job['matching_skills']) && is_array($job['matching_skills']))
                    @foreach($job['matching_skills'] as $skill)
                      <span class="bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium">{{ $skill }}</span>
                    @endforeach
                  @else
                    <span class="text-sm text-gray-500">No specific matching skills identified.</span>
                  @endif
                </div>
              </div>

              <!-- View Details -->
              <div class="mt-4 flex items-center justify-between">
                <a href="{{ route('job.application.review1', ['job_id' => $job['job_id']]) }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 rounded-lg transition inline-block">View Details</a>
                <img src="/images/sound-icon.png" alt="Audio" class="w-6 h-6">
              </div>
              <p class="text-xs text-gray-500 mt-1">(Click "View Details" to see full information)</p>
            </div>
          </div>
        @endforeach
      @else
        <div class="bg-white rounded-xl border p-6">
          <p class="text-gray-700">No guardian-approved jobs were found yet. Once a guardian approves jobs you will see them listed here along with the matching skills highlighted by the recommendation algorithm.</p>
        </div>
      @endif

    </div>
  </section>
</div>
@endsection