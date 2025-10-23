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
  </section>


  <!-- Tabs -->
  <div class="flex justify-center mt-6 space-x-2 text-sm font-medium">
    <button class="px-4 py-2 rounded-md hover:bg-gray-100">Pending Review</button>
    <button class="px-4 py-2 rounded-md hover:bg-gray-100">Approved Job</button>
    <button class="bg-gray-200 px-4 py-2 rounded-md">Flagged Job</button>
  </div>

  <!-- Pending Review -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    @php
        // Reuse same CSV loader and approvals map; filter for flagged
        $csv_path = public_path('postings.csv');
        $cache_key = 'postings_csv_' . md5($csv_path . '|' . @filemtime($csv_path));
        $jobs = cache()->remember($cache_key, 600, function() use ($csv_path) {
            $out = [];
            if (!file_exists($csv_path) || ($h = @fopen($csv_path, 'r')) === false) return $out;
            $header = fgetcsv($h);
            if ($header === false) { fclose($h); return $out; }
            $cols = array_map(function($x){ return trim($x); }, $header);
            $numCols = count($cols);
            if ($numCols === 0) { fclose($h); return $out; }
            $i = 0; $maxRows = 5000;
            while (($row = fgetcsv($h)) !== false) {
                if (count($row) < $numCols) $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
                elseif (count($row) > $numCols) $row = array_slice($row, 0, $numCols);
                if (count($row) !== $numCols) continue;
                $assoc = array_combine($cols, $row) ?: [];
                if ($i >= $maxRows) break;
                $title = trim($assoc['title'] ?? $assoc['jobtitle'] ?? '');
                $company = trim($assoc['company_name'] ?? $assoc['company'] ?? '');
                $desc = trim($assoc['description'] ?? '');
                $hours = trim($assoc['formatted_work_type'] ?? $assoc['Duration'] ?? $assoc['Term'] ?? '');
                if ($hours === '' && preg_match('/Expected hours:\s*([^\r\n]+)/i', $desc, $m)) $hours = trim($m[1]);
                if (empty($title)) {
                    $firstLine = preg_split('/[\r\n]+/', $desc)[0] ?? '';
                    if (preg_match('/([^.?!]+[.?!])/u', $firstLine, $m2)) { $title = trim($m2[1]); }
                    else $title = trim(implode(' ', array_slice(preg_split('/\s+/', $firstLine), 0, 8)));
                    if ($title === '') $title = 'Untitled Job';
                }
                $out[] = ['job_id'=>$i,'title'=>$title,'company'=>$company,'location'=>trim($assoc['location'] ?? ''),'hours'=>$hours,'match_score'=>0,'why'=>$desc,'raw'=>$assoc];
                $i++;
            }
            fclose($h);
            return $out;
        });

    // Attempt Firestore-backed approvals when uid query param provided
    $guardianApprovals = [];
    $uidParam = request()->query('uid');
    if (!empty($uidParam)) {
      try {
        $fs = app(\App\Http\Controllers\GuardianJobController::class)->fetchApprovalsFromFirestore($uidParam);
        if (is_array($fs)) $guardianApprovals = $fs;
      } catch (\Throwable $e) {
        logger()->warning('Firestore fetch failed in flagged view: ' . $e->getMessage());
      }
    }
    if (empty($guardianApprovals)) {
      $approvals_path = storage_path('app/guardian_job_approvals.json');
      if (file_exists($approvals_path)) $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: [];
    }

        $flagged = array_values(array_filter($jobs, function($j) use ($guardianApprovals) {
            $id = (string)$j['job_id'];
            return isset($guardianApprovals[$id]) && (($guardianApprovals[$id]['status'] ?? '') === 'flagged');
        }));
        usort($flagged, function($a,$b){ return intval($b['match_score'] ?? 0) <=> intval($a['match_score'] ?? 0); });
        $total = count($flagged);
        $perPage = 10; $page = max(1,intval(request()->query('page',1))); $lastPage = max(1,(int)ceil($total/$perPage));
        if ($page > $lastPage) $page = $lastPage;
        $start = ($page - 1) * $perPage; $paged = array_slice($flagged, $start, $perPage);
    @endphp

    <h3 class="text-lg font-bold text-red-600 mb-4">Flagged Job: {{ $total }} · Page {{ $page }} / {{ $lastPage }}</h3>

    @foreach($paged as $p)
      <div id="job-card-{{ $p['job_id'] }}" class="border-2 border-red-400 rounded-2xl p-6 bg-red-50/20 shadow-sm mb-6">
        <div class="flex justify-between items-start">
          <div class="flex items-center space-x-2">
            <img src="/images/job-icon.png" class="w-6 h-6" alt="Job Icon">
            <h4 class="text-lg font-semibold">{{ $p['title'] }}</h4>
          </div>
          <span class="bg-red-200 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Flagged</span>
        </div>
        <div class="mt-4 flex items-center"><span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">{{ $p['match_score'] }}% Match</span></div>
        <div class="mt-4 grid grid-cols-3 gap-4 mt-4 text-sm">
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Company Name:</span> {{ $p['company'] }}</div>
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Location:</span> {{ $p['location'] }}</div>
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Hours:</span> {{ $p['hours'] }}</div>
        </div>
        <div class="bg-gray-100 rounded-lg mt-6 p-4"><p class="text-sm text-gray-700">{{ Str::limit($p['why'], 400) }}</p></div>
      </div>
    @endforeach

    <div class="flex items-center justify-center space-x-2 mt-6">
      @if($page>1) <a href="{{ request()->url() }}?page={{ $page-1 }}" class="px-3 py-1 bg-gray-200 rounded-md">&laquo; Prev</a> @endif
      <span class="px-3 py-1 bg-white rounded-md">Page {{ $page }} / {{ $lastPage }}</span>
      @if($page<$lastPage) <a href="{{ request()->url() }}?page={{ $page+1 }}" class="px-3 py-1 bg-gray-200 rounded-md">Next &raquo;</a> @endif
    </div>
  </div>
</div>
<br>
@endsection