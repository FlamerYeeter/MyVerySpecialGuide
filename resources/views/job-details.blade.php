@extends('layouts.includes')

@section('content')
@php
  $csv_path = public_path('postings.csv');
  $job = null;
  $job_id = request('job_id');

  // First prefer precomputed recommendations.json if present (job-matches may be using it)
  $json_path = public_path('recommendations.json');
  if ($job_id !== null && file_exists($json_path)) {
    $rows = json_decode(@file_get_contents($json_path), true) ?: [];
    // Try to find by explicit job_id field (string/int) or by array index
    foreach ($rows as $idx => $r) {
      if (isset($r['job_id']) && (string)$r['job_id'] === (string)$job_id) {
        $job = [
          'title' => trim($r['Title'] ?? $r['title'] ?? '') ?: (strlen(trim($r['job_description'] ?? '')) ? Str::limit($r['job_description'], 80) : 'Untitled Job'),
          'company' => trim($r['Company'] ?? $r['company'] ?? ''),
          'job_description' => $r['job_description'] ?? $r['description'] ?? '',
          'job_requirement' => $r['resume'] ?? $r['job_requirement'] ?? '',
          'location' => $r['location'] ?? '',
          'hours' => $r['formatted_work_type'] ?? $r['hours'] ?? '',
          'salary' => $r['salary'] ?? $r['Salary'] ?? null,
          'start_date' => $r['original_listed_time'] ?? null,
          'deadline' => $r['deadline'] ?? null,
          'announcement_code' => $r['announcement_code'] ?? '',
          'job_posting_url' => $r['job_posting_url'] ?? '',
          'application_url' => $r['application_url'] ?? '',
          'fit_level' => $r['fit_level'] ?? '',
          'growth_potential' => $r['growth_potential'] ?? '',
          'work_environment' => $r['work_environment'] ?? '',
        ];
        break;
      }
      // also allow numeric index match when JSON uses array positions as job ids
      if ((string)$idx === (string)$job_id) {
        $r = $rows[$idx];
        $job = [
          'title' => trim($r['Title'] ?? $r['title'] ?? '') ?: (strlen(trim($r['job_description'] ?? '')) ? Str::limit($r['job_description'], 80) : 'Untitled Job'),
          'company' => trim($r['Company'] ?? $r['company'] ?? ''),
          'job_description' => $r['job_description'] ?? $r['description'] ?? '',
          'job_requirement' => $r['resume'] ?? $r['job_requirement'] ?? '',
          'location' => $r['location'] ?? '',
          'hours' => $r['formatted_work_type'] ?? $r['hours'] ?? '',
          'salary' => $r['salary'] ?? $r['Salary'] ?? null,
          'start_date' => $r['original_listed_time'] ?? null,
          'deadline' => $r['deadline'] ?? null,
          'announcement_code' => $r['announcement_code'] ?? '',
          'job_posting_url' => $r['job_posting_url'] ?? '',
          'application_url' => $r['application_url'] ?? '',
          'fit_level' => $r['fit_level'] ?? '',
          'growth_potential' => $r['growth_potential'] ?? '',
          'work_environment' => $r['work_environment'] ?? '',
        ];
        break;
      }
    }
  }

  // If not found in recommendations.json, fall back to CSV parsing
  if ($job === null && $job_id !== null && file_exists($csv_path)) {
    if (($handle = fopen($csv_path, 'r')) !== false) {
            $header = fgetcsv($handle);
            $cols = array_map(function($h){ return trim($h); }, $header ?: []);
            $numCols = count($cols);
            if ($numCols === 0) { fclose($handle); return; }
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
      $maxRows = 5000;
      while (($row = fgetcsv($handle)) !== false) {
        if (count($row) < $numCols) {
          $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
        } elseif (count($row) > $numCols) {
          $row = array_slice($row, 0, $numCols);
        }
        if (count($row) !== $numCols) continue;
        if ($i >= $maxRows) break;
        // Build associative row and try to match by explicit job_id-like columns first
        $assoc = array_combine($cols, $row) ?: [];
        $found = false;
        // normalize keys to lower for lookup
        $normRow = [];
        foreach ($assoc as $k => $v) { $normRow[strtolower(preg_replace('/[^a-z0-9]+/i', '_', trim((string)$k)))] = $v; }
        $candidateJobId = null;
        if (isset($normRow['job_id'])) $candidateJobId = (string) $normRow['job_id'];
        elseif (isset($normRow['jobid'])) $candidateJobId = (string) $normRow['jobid'];
        elseif (isset($normRow['id'])) $candidateJobId = (string) $normRow['id'];
        // If provided job_id matches a field in the row, select this row. Otherwise, fall back to numeric index match.
        if ($candidateJobId !== null && (string)$job_id !== '' && (string)$candidateJobId === (string)$job_id) {
            $found = true;
        } elseif (is_numeric($job_id) && intval($job_id) === $i) {
            $found = true;
        }
        if ($found) {
                    $textForInference = trim(($assoc['JobDescription'] ?? '') . ' ' . ($assoc['JobRequirment'] ?? '') . ' ' . ($assoc['jobpost'] ?? ''));
                    $inferred_fit = $infer_fit_level($textForInference);
                    $inferred_growth = $infer_growth_potential($textForInference);
                    $inferred_env = $infer_work_environment($textForInference);
          // Robust field extraction with multiple header fallbacks
          $title = trim($assoc['title'] ?? $assoc['Title'] ?? $assoc['jobpost'] ?? $assoc['job_title'] ?? '');
          $company = trim($assoc['company_name'] ?? $assoc['Company'] ?? $assoc['Employer'] ?? '');
          $description = trim($assoc['description'] ?? $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? $assoc['jobpost'] ?? '');
          $requirement = trim($assoc['job_requirement'] ?? $assoc['JobRequirment'] ?? $assoc['RequiredQual'] ?? $assoc['skills_desc'] ?? '');
          $location = trim($assoc['location'] ?? $assoc['Location'] ?? $assoc['City'] ?? '');
          // hours: prefer formatted_work_type (Full-time/Part-time) or Duration/Term, or parse 'Expected hours' from description
          $hours = trim($assoc['formatted_work_type'] ?? $assoc['Duration'] ?? $assoc['Term'] ?? $assoc['Hours'] ?? '');
          if ($hours === '') {
            if (preg_match('/Expected hours:\s*([^\r\n]+)/i', $description, $m)) {
              $hours = trim($m[1]);
            }
          }
          // salary: prefer normalized or max/min
          $salary = $assoc['normalized_salary'] ?? $assoc['max_salary'] ?? $assoc['Salary'] ?? '';
          $start_date = $assoc['StartDate'] ?? $assoc['original_listed_time'] ?? '';
          $deadline = $assoc['Deadline'] ?? $assoc['expiry'] ?? $assoc['closed_time'] ?? '';
          $announcement_code = $assoc['AnnouncementCode'] ?? $assoc['announcement_code'] ?? '';
          $job_posting_url = $assoc['job_posting_url'] ?? $assoc['job_posting_url'] ?? $assoc['job_posting_link'] ?? '';
          $application_url = $assoc['application_url'] ?? $assoc['application_url'] ?? '';

          $job = [
            'title' => $title ?: ($description ? Str::limit($description, 80) : 'Untitled Job'),
            'company' => $company,
            'job_description' => $description,
            'job_requirement' => $requirement,
            'location' => $location,
            'hours' => $hours,
            'salary' => $salary,
            'start_date' => $start_date,
            'deadline' => $deadline,
            'announcement_code' => $announcement_code,
            'job_posting_url' => $job_posting_url,
            'application_url' => $application_url,
            'fit_level' => $assoc['fit_level'] ?? $assoc['FitLevel'] ?? $inferred_fit,
            'growth_potential' => $assoc['growth_potential'] ?? $assoc['GrowthPotential'] ?? $inferred_growth,
            'work_environment' => $assoc['work_environment'] ?? $assoc['WorkEnvironment'] ?? $inferred_env ?? $location,
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
              @php
                // Try Firestore approvals when uid param provided, else fall back to local file
                $guardianApprovals = [];
                $uidParam = request()->query('uid');
                if (!empty($uidParam)) {
                    try { $fs = app(\App\Http\Controllers\GuardianJobController::class)->fetchApprovalsFromFirestore($uidParam); if (is_array($fs)) $guardianApprovals = $fs; } catch (\Throwable $e) { logger()->warning('Firestore fetch failed in job-details: ' . $e->getMessage()); }
                }
                if (empty($guardianApprovals)) { $approvals_path = storage_path('app/guardian_job_approvals.json'); if (file_exists($approvals_path)) $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: []; }
                $isApproved = false; $isFlagged = false; $approvalRec = null;
                $jid = (string)$job_id;
                if (isset($guardianApprovals[$jid])) { $approvalRec = $guardianApprovals[$jid]; $st = $approvalRec['status'] ?? ''; if ($st === 'approved') $isApproved = true; if ($st === 'flagged') $isFlagged = true; }
              @endphp

              @if($isApproved)
                <a href="{{ route('job.application.1', ['job_id' => $job_id]) }}" class="bg-pink-500 text-white px-6 py-2 rounded hover:bg-pink-600 transition">Apply</a>
              @else
                <button class="bg-gray-300 text-gray-700 px-6 py-2 rounded" disabled title="This job is pending guardian approval">Apply (Pending Guardian)</button>
              @endif

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
         <p class="text-gray-700 text-sm mt-2">{{ $job['job_description'] ?? $job['description'] ?? '' }}</p>
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
         @if($approvalRec)
           <div class="mt-4 p-3 border rounded bg-gray-50">
             <div class="text-sm font-semibold">Guardian Review Status: <span class="inline-block px-2 py-1 rounded text-white {{ $isApproved ? 'bg-green-600' : ($isFlagged ? 'bg-red-600' : 'bg-yellow-600') }}">{{ $approvalRec['status'] ?? 'pending' }}</span></div>
             <div class="text-xs text-gray-600 mt-1">Actioned by: {{ $approvalRec['actioned_by'] ?? '-' }} &middot; At: {{ $approvalRec['actioned_at'] ?? '-' }}</div>
             @if(!empty($approvalRec['feedback']))<div class="mt-2 text-sm">Feedback: {{ Str::limit($approvalRec['feedback'], 500) }}</div>@endif
           </div>
         @endif
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