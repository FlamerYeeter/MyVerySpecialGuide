@extends('layouts.includes')

@section('content')

<!-- HEADER BANNER: NOTE AAYUSIN KO PA MAMAYA -->
    <br>
  <section class="bg-blue-500 flex flex-col md:flex-row items-center justify-center py-10 text-center md:text-left">
    <img src="/images/target-icon.png" alt="Goals Icon" class="h-24 mx-auto md:mx-8">
    <div>
      <h2 class="text-3xl font-bold text-black">Guardian Review</h2>
      <p class="text-gray-700">Discover how your unique skills and interests align with this job role</p>
      <p class="text-gray-700">and learn the step-by-step path to achieve your aspirations</p>
    </div>

  @push('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', function(){
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

    document.querySelectorAll('.approve-btn').forEach(btn => {
      btn.addEventListener('click', function(e){
        const jobId = this.getAttribute('data-jobid');
        const feedback = document.getElementById('feedback-' + jobId)?.value || '';
        this.disabled = true;
        postAction('/api/guardian/jobs/' + encodeURIComponent(jobId) + '/approve', { feedback }).then(resp => {
          if (resp && resp.success) {
            const el = document.getElementById('job-card-' + jobId);
            if (el) el.remove();
          } else {
            alert('Approve failed');
            this.disabled = false;
          }
        }).catch(err => { console.error(err); alert('Approve error'); this.disabled = false; });
      });
    });

    document.querySelectorAll('.flag-btn').forEach(btn => {
      btn.addEventListener('click', function(e){
        const jobId = this.getAttribute('data-jobid');
        const feedback = document.getElementById('feedback-' + jobId)?.value || '';
        this.disabled = true;
        postAction('/api/guardian/jobs/' + encodeURIComponent(jobId) + '/flag', { feedback }).then(resp => {
          if (resp && resp.success) {
            const el = document.getElementById('job-card-' + jobId);
            if (el) el.remove();
          } else {
            alert('Flag failed');
            this.disabled = false;
          }
        }).catch(err => { console.error(err); alert('Flag error'); this.disabled = false; });
      });
    });
  });
  </script>
  @endpush
  </section>

  <!-- Instructions Button -->
  <div class="flex justify-start mt-6 ml-8">
    <button class="bg-blue-500 text-white px-6 py-2 rounded-md font-medium hover:bg-blue-600 transition">
      Click to View Instructions
    </button>
  </div>

  <!-- Tabs -->
  <div class="flex justify-start mt-6 space-x-2 text-sm font-medium">
    <button class="bg-gray-200 px-4 py-2 rounded-md">Pending Review</button>
    <button class="px-4 py-2 rounded-md hover:bg-gray-100">Approved Job</button>
    <button class="px-4 py-2 rounded-md hover:bg-gray-100">Flagged Job</button>
  </div>

  <!-- Pending Review -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    @php
        // Read CSV and approvals then render jobs that are pending (not approved and not flagged)
        $csv_path = public_path('data job posts.csv');
        $jobs = [];
        if (file_exists($csv_path) && ($h = fopen($csv_path, 'r')) !== false) {
            $header = fgetcsv($h);
            $cols = array_map(function($x){ return trim($x); }, $header ?: []);
            $i = 0;
            while (($row = fgetcsv($h)) !== false) {
                $assoc = array_combine($cols, $row) ?: [];
                $title = $assoc['Title'] ?? $assoc['jobpost'] ?? '';
                $company = $assoc['Company'] ?? '';
                $desc = $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? $assoc['jobpost'] ?? '';
                // small heuristic score: proportion of keywords (example)
                $keywords = ['hands', 'routine', 'team', 'entry', 'support', 'clean', 'wash', 'prepare'];
                $cnt = 0; foreach ($keywords as $k) { if (stripos($desc, $k) !== false) $cnt++; }
                $match_score = min(100, intval( round(($cnt / max(1, count($keywords))) * 100) ));
                $jobs[] = [
                    'job_id' => $i,
                    'title' => $title,
                    'company' => $company,
                    'location' => $assoc['Location'] ?? '',
                    'hours' => $assoc['Duration'] ?? $assoc['Term'] ?? '',
                    'match_score' => $match_score,
                    'why' => $assoc['JobDescription'] ?? '',
                    'raw' => $assoc,
                ];
                $i++;
            }
            fclose($h);
        }

        // load approvals
        $approvals_path = storage_path('app/guardian_job_approvals.json');
        $guardianApprovals = [];
        if (file_exists($approvals_path)) $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: [];

    // filter pending: not approved and not flagged
    $pending = array_values(array_filter($jobs, function($j) use ($guardianApprovals) {
      $id = (string)$j['job_id'];
      if (isset($guardianApprovals[$id])) {
        $st = $guardianApprovals[$id]['status'] ?? '';
        return $st !== 'approved' && $st !== 'flagged';
      }
      return true;
    }));
    // sort pending by match_score desc so highest match appears first
    usort($pending, function($a, $b){
      $aa = isset($a['match_score']) ? intval($a['match_score']) : 0;
      $bb = isset($b['match_score']) ? intval($b['match_score']) : 0;
      return $bb <=> $aa;
    });
    $pendingCount = count($pending);
    @endphp

    <h3 class="text-lg font-bold text-yellow-600 mb-4">Pending Review: {{ $pendingCount }}</h3>

    @foreach($pending as $p)
      <div id="job-card-{{ $p['job_id'] }}" class="border-2 border-yellow-400 rounded-2xl p-6 bg-yellow-50/20 shadow-sm mb-6">
        <div class="flex justify-between items-start">
          <div class="flex items-center space-x-2">
            <img src="/images/job-icon.png" class="w-6 h-6" alt="Job Icon">
            <h4 class="text-lg font-semibold">{{ $p['title'] ?: 'Untitled Job' }}</h4>
          </div>
          <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pending Review</span>
        </div>

        <div class="mt-4">
          <span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">{{ $p['match_score'] }}% Match</span>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-4 mt-4 text-sm">
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Company Name:</span> {{ $p['company'] }}</div>
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Location:</span> {{ $p['location'] }}</div>
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Hours:</span> {{ $p['hours'] }}</div>
        </div>

        <div class="bg-gray-100 rounded-lg mt-6 p-4">
          <div class="flex items-center space-x-2 mb-2"><img src="/images/lightbulb-icon.png" class="w-5 h-5" alt="Idea Icon"><h5 class="font-semibold text-gray-800">Why this Job Matches</h5></div>
          <p class="text-sm text-gray-700">{{ Str::limit($p['why'], 400) }}</p>
        </div>

        <div class="bg-yellow-100 rounded-lg mt-6 p-4">
          <div class="flex items-center space-x-2 mb-2"><img src="/images/feedback-icon.png" class="w-5 h-5" alt="Feedback Icon"><h5 class="font-semibold text-gray-800">Add your Feedback (Optional)</h5></div>
          <textarea id="feedback-{{ $p['job_id'] }}" class="w-full rounded-md border border-gray-300 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="Share your thoughts about this job suggestion" rows="3"></textarea>
        </div>

        <div class="flex justify-start space-x-3 mt-6">
          <a href="{{ route('user.review') }}?job_id={{ $p['job_id'] }}" class="bg-blue-500 text-white px-5 py-2 rounded-md text-sm hover:bg-blue-600 transition">View Details</a>
          <button data-jobid="{{ $p['job_id'] }}" class="approve-btn bg-green-600 text-white px-5 py-2 rounded-md text-sm hover:bg-green-700 transition">Approve Job</button>
          <button data-jobid="{{ $p['job_id'] }}" class="flag-btn bg-yellow-500 text-white px-5 py-2 rounded-md text-sm hover:bg-yellow-600 transition">Flag as Not Suitable</button>
        </div>
      </div>
    @endforeach
  </div>
</div>
<br>
@endsection