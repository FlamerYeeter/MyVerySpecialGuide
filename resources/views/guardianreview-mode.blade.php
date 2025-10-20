@extends('layouts.includes')

@section('content')

<!-- Back Button -->
  <div class="bg-blue-500 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="{{ route('job.matches') }}" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline"> <!-- ayusin nlang route neto -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>

  <!-- Guardian Review Mode Section -->
  <section class="max-w-4xl mx-auto mt-8 bg-gray-100 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-2">
      <img src="/images/shield-icon.png" alt="Shield Icon" class="w-5 h-5">
      <h2 class="text-lg font-semibold text-gray-700">Guardian Review Mode</h2>
    </div>
    <p class="text-sm text-gray-700 leading-relaxed">
      This detailed view helps you make an informed decision. Review all aspects of the job, including match
      analysis, potential concerns, and support available. Your feedback is valuable in helping us provide better job matches.
    </p>
  </section>

  <!-- Job Card -->
  @php
    $job = null;
    $jobId = request('job_id');
    $csv_path = public_path('data job posts.csv');
    if ($jobId !== null && file_exists($csv_path) && ($h = fopen($csv_path, 'r')) !== false) {
        $header = fgetcsv($h);
        $cols = array_map(function($h){ return trim($h); }, $header ?: []);
        $i = 0;
        while (($row = fgetcsv($h)) !== false) {
            if ($i == intval($jobId)) {
                $assoc = array_combine($cols, $row) ?: [];
                $title = $assoc['Title'] ?? $assoc['jobpost'] ?? '';
                $company = $assoc['Company'] ?? '';
                $location = $assoc['Location'] ?? '';
                $hours = $assoc['Duration'] ?? $assoc['Term'] ?? '';
                $desc = $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? $assoc['jobpost'] ?? '';
                // simple match score reused from pending page
                $keywords = ['hands', 'routine', 'team', 'entry', 'support', 'clean', 'wash', 'prepare'];
                $cnt = 0; foreach ($keywords as $k) { if (stripos($desc, $k) !== false) $cnt++; }
                $match_score = min(100, intval( round(($cnt / max(1, count($keywords))) * 100) ));
                $job = compact('title','company','location','hours','desc','match_score','assoc');
                break;
            }
            $i++;
        }
        fclose($h);
    }

    // load guardian approval for this job if present
    $approval = null;
    $approvals_path = storage_path('app/guardian_job_approvals.json');
    if (file_exists($approvals_path)) {
        $map = json_decode(file_get_contents($approvals_path), true) ?: [];
        if ($jobId !== null && isset($map[(string)$jobId])) $approval = $map[(string)$jobId];
    }
  @endphp

  <section class="max-w-4xl mx-auto mt-6 border-2 border-yellow-400 bg-yellow-50/30 rounded-2xl p-6">
    @if($job)
    <div class="flex flex-wrap justify-between items-center">
      <div class="flex items-center space-x-2">
        <img src="/images/job-icon.png" alt="Job Icon" class="w-6 h-6">
        <h3 class="text-lg font-semibold">{{ $job['title'] }}</h3>
      </div>

      <div class="flex space-x-2 items-center">
        <button id="approve-btn" data-jobid="{{ $jobId }}" class="bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-700 transition">Approve Job</button>
        <button id="flag-btn" data-jobid="{{ $jobId }}" class="bg-yellow-500 text-white text-sm px-4 py-2 rounded-md hover:bg-yellow-600 transition">Flag as Not Suitable</button>
        <span class="bg-yellow-200 text-yellow-800 text-sm px-4 py-2 rounded-full">{{ $approval['status'] ?? 'Pending Review' }}</span>
      </div>
    </div>

    <div class="mt-4">
      <span id="match-badge" class="bg-green-200 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $job['match_score'] }}% Match</span>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
      <div class="bg-gray-100 px-3 py-2 rounded-md"><span class="font-semibold">Company Name:</span> {{ $job['company'] }}</div>
      <div class="bg-gray-100 px-3 py-2 rounded-md"><span class="font-semibold">Location:</span> {{ $job['location'] }}</div>
      <div class="bg-gray-100 px-3 py-2 rounded-md"><span class="font-semibold">Hours:</span> {{ $job['hours'] }}</div>
    </div>
    @else
      <div class="p-6">Job not found. Go back to <a href="{{ route('guardianreview.pending') }}">Pending Review</a>.</div>
    @endif
  </section>

  <!-- Why this Job Matches -->
  <section class="max-w-4xl mx-auto mt-6 bg-gray-100 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-2">
      <img src="/images/lightbulb-icon.png" alt="Lightbulb Icon" class="w-5 h-5">
      <h4 class="font-semibold text-gray-700">Why this Job Matches</h4>
    </div>
    @if($job)
      <p class="text-sm text-gray-700 leading-relaxed">{{ $job['desc'] }}</p>
    @else
      <p class="text-sm text-gray-700 leading-relaxed">No description available.</p>
    @endif
  </section>

  <!-- Potential Concerns -->
  <section class="max-w-4xl mx-auto mt-6 bg-yellow-50 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-2">
      <img src="/images/warning-icon.png" alt="Warning Icon" class="w-5 h-5">
      <h4 class="font-semibold text-gray-700">Potential Concerns & How they are Addressed</h4>
    </div>

    <p class="text-sm font-semibold text-gray-700">Physical Demands</p>
    <p class="text-sm text-gray-700 mt-1">
      The role requires standing for extended periods and lifting items up to 20 lbs. Juan may need to build stamina for physical tasks.
    </p>

    <div class="bg-green-100 border-l-4 border-green-500 p-4 mt-3 rounded-md text-sm text-gray-700">
      <p><span class="font-semibold text-green-800">How it is Addressed:</span></p>
      <p class="mt-1">
        Regular breaks are scheduled every 2 hours. Heavy lifting is done in pairs or with assistance.
        The employer provides ergonomic mats for standing stations and allows sitting breaks as needed.
        Physical stamina will build naturally over time.
      </p>
    </div>
  </section>

  <!-- Feedback Box -->
  <section class="max-w-4xl mx-auto mt-6 bg-yellow-50 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-3">
      <img src="/images/feedback-icon.png" alt="Feedback Icon" class="w-5 h-5">
      <h4 class="font-semibold text-gray-700">Add your Feedback (Optional)</h4>
    </div>
    <textarea id="guardian-feedback" placeholder="Share your thoughts about this job suggestion" class="w-full rounded-md border border-gray-300 p-3 text-sm text-gray-600 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none bg-white" rows="3">{{ $approval['feedback'] ?? '' }}</textarea>
  </section>

  @push('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', function(){
    const jobId = '{{ $jobId }}';
    const approveBtn = document.getElementById('approve-btn');
    const flagBtn = document.getElementById('flag-btn');
    const feedbackEl = document.getElementById('guardian-feedback');

    function postAction(url, body) {
      return fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(body || {})
      }).then(r => r.json());
    }

    if (approveBtn) approveBtn.addEventListener('click', function(){
      const fb = feedbackEl?.value || '';
      approveBtn.disabled = true;
      postAction('/api/guardian/jobs/' + encodeURIComponent(jobId) + '/approve', { feedback: fb }).then(resp => {
        if (resp && resp.success) {
          document.getElementById('match-badge').textContent = (resp.approval?.status === 'approved' ? '{{ $job['match_score'] }}% Match' : document.getElementById('match-badge').textContent);
          // show status
          approveBtn.classList.add('opacity-70');
          flagBtn.classList.add('opacity-40');
          location.reload();
        } else {
          alert('Approve failed');
          approveBtn.disabled = false;
        }
      }).catch(e=>{ alert('Approve failed'); approveBtn.disabled = false; console.error(e); });
    });

    if (flagBtn) flagBtn.addEventListener('click', function(){
      const fb = feedbackEl?.value || '';
      flagBtn.disabled = true;
      postAction('/api/guardian/jobs/' + encodeURIComponent(jobId) + '/flag', { feedback: fb }).then(resp => {
        if (resp && resp.success) {
          location.reload();
        } else {
          alert('Flag failed');
          flagBtn.disabled = false;
        }
      }).catch(e=>{ alert('Flag failed'); flagBtn.disabled = false; console.error(e); });
    });
  });
  </script>
  @endpush

  <div class="h-20"></div>
</div>

@endsection