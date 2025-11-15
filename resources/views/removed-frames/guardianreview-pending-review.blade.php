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

  
  {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}

  <script>
  document.addEventListener('DOMContentLoaded', function(){
    function postAction(url, body) {
      const b = body ? Object.assign({}, body) : {};
      const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      };
      if (b.idToken) {
        headers['Authorization'] = 'Bearer ' + b.idToken;
        // also leave idToken in body only if needed by server; controller accepts either
        delete b.idToken;
      }
      return fetch(url, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(b || {})
      }).then(async r => {
        const text = await r.text();
        try {
          const json = text ? JSON.parse(text) : {};
          if (r.ok) return json;
          return Object.assign({ status: r.status }, json);
        } catch (e) {
          return { status: r.status, body: text };
        }
      });
    }

        document.querySelectorAll('.approve-btn').forEach(btn => {
      btn.addEventListener('click', function(e){
        const jobId = this.getAttribute('data-jobid');
        const feedback = document.getElementById('feedback-' + jobId)?.value || '';
        this.disabled = true;
        // include optional uid target if present in page URL or from firebase auth
        (async function(){
            let uidTarget = new URLSearchParams(window.location.search).get('uid') || '';
            let idToken = '';
            try {
                const mod = await import("{{ asset('js/job-application-firebase.js') }}");
                if (!uidTarget && mod && typeof mod.getCurrentUserUid === 'function') uidTarget = await mod.getCurrentUserUid();
                try { const user = (await import('https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js')).getAuth().currentUser; if (user && typeof user.getIdToken === 'function') idToken = await user.getIdToken(); } catch(e) {}
            } catch(e) { /* ignore */ }
            const body = { feedback };
            if (uidTarget) body.uid = uidTarget;
            if (idToken) body.idToken = idToken;
            postAction('{{ url('/api/guardian/jobs') }}' + '/' + encodeURIComponent(jobId) + '/approve', body).then(resp => {
          console.debug('approve resp', resp);
          if (resp && resp.success) {
            const el = document.getElementById('job-card-' + jobId);
            if (el) el.remove();
          } else {
            const msg = (resp && (resp.message || resp.error || resp.body)) ? (resp.message || resp.error || resp.body) : 'Approve failed';
            alert(msg);
            this.disabled = false;
          }
            }).catch(err => { console.error(err); alert('Approve error: ' + String(err)); this.disabled = false; });
        })();
      });
    });

        document.querySelectorAll('.flag-btn').forEach(btn => {
      btn.addEventListener('click', function(e){
        const jobId = this.getAttribute('data-jobid');
        const feedback = document.getElementById('feedback-' + jobId)?.value || '';
        this.disabled = true;
        (async function(){
            let uidTarget = new URLSearchParams(window.location.search).get('uid') || '';
            let idToken = '';
            try {
                const mod = await import("{{ asset('js/job-application-firebase.js') }}");
                if (!uidTarget && mod && typeof mod.getCurrentUserUid === 'function') uidTarget = await mod.getCurrentUserUid();
                try { const user = (await import('https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js')).getAuth().currentUser; if (user && typeof user.getIdToken === 'function') idToken = await user.getIdToken(); } catch(e) {}
            } catch(e) { /* ignore */ }
            const body = { feedback };
            if (uidTarget) body.uid = uidTarget;
            if (idToken) body.idToken = idToken;
            postAction('{{ url('/api/guardian/jobs') }}' + '/' + encodeURIComponent(jobId) + '/flag', body).then(resp => {
          console.debug('flag resp', resp);
          if (resp && resp.success) {
            const el = document.getElementById('job-card-' + jobId);
            if (el) el.remove();
          } else {
            const msg = (resp && (resp.message || resp.error || resp.body)) ? (resp.message || resp.error || resp.body) : 'Flag failed';
            alert(msg);
            this.disabled = false;
          }
            }).catch(err => { console.error(err); alert('Flag error: ' + String(err)); this.disabled = false; });
        })();
      });
    });
  });
  </script>
  </section>

  <!-- Instructions Button -->
  <div class="flex justify-start mt-6 ml-8">
    <a href="{{ route('guardianreview.instructions') }}" class="bg-blue-500 text-white px-6 py-2 rounded-md font-medium hover:bg-blue-600 transition">Click to View Instructions</a>
  </div>

  <!-- Tabs -->
  <div class="flex justify-start mt-6 space-x-2 text-sm font-medium">
    <a href="{{ route('guardianreview.pending') }}" class="bg-gray-200 px-4 py-2 rounded-md">Pending Review</a>
    <a href="{{ route('guardianreview.approved') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Approved Job</a>
    <a href="{{ route('guardianreview.flagged') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Flagged Job</a>
  </div>

  <!-- Pending Review -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    @php
  // Build jobs using per-user recommendation cache (storage/app/reco_user_<safeUid>.json)
  // Prefer per-user cache tied to firebase UID. Resolve UID from multiple places for reliability:
  // Auth::user()->firebase_uid, session keys, request query/input, cookies, or explicit safe_uid param.
  $jobs = [];
  $recommendations = [];
  $uid = null;
  try { $uid = Auth::user()->firebase_uid ?? null; } catch (\Exception $e) { $uid = null; }
  // Try common session keys
  if (empty($uid)) {
    try { $uid = session('firebase_uid') ?? session('uid') ?? null; } catch (\Exception $e) { /* ignore */ }
  }
  // Try request query or input
  if (empty($uid)) {
    $uid = request()->query('uid', request()->input('uid', null));
  }
  // Try cookies
  if (empty($uid)) {
    $uid = request()->cookie('firebase_uid') ?? request()->cookie('uid') ?? null;
  }
  // Accept a pre-safe uid parameter if present
  if (empty($uid)) {
    $uid = request()->query('safe_uid', null);
  }
  // If caller passed a full filename like 'reco_user_<safe>.json', extract the safe portion
  if (!empty($uid) && preg_match('/^reco_user_(.+)\.json$/i', $uid, $m)) {
    $uid = $m[1];
  }
  // If we have no uid, do not show global recommendations (per-user-only policy)
  if (!empty($uid)) {
    // make a filesystem-safe uid (match earlier safe-uid behavior)
    $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', (string) $uid);
    $userRecoPath = storage_path('app/reco_user_' . $safeUid . '.json');
    if (file_exists($userRecoPath)) {
      $cacheKey = 'reco_user_file_' . md5($userRecoPath . '|' . @filemtime($userRecoPath));
      $decoded = cache()->remember($cacheKey, 120, function() use ($userRecoPath) {
        $json = @file_get_contents($userRecoPath);
        $rows = json_decode($json, true) ?: [];
        return is_array($rows) ? $rows : [];
      });

      // Normalize decoded shapes: some generators produce { uid: [recs] } maps
      if (is_array($decoded)) {
        // If it's a map keyed by UID and contains our UID, prefer that
        if (isset($decoded[$uid]) && is_array($decoded[$uid])) {
          $rows = $decoded[$uid];
        } else {
          // If top-level is an array of recommendations, use it
          $isList = array_values($decoded) === $decoded;
          if ($isList) $rows = $decoded;
          else {
            // If it's a map with single value that is an array, use that
            $vals = array_values($decoded);
            $arrVal = null;
            foreach ($vals as $v) { if (is_array($v)) { $arrVal = $v; break; } }
            $rows = is_array($arrVal) ? $arrVal : [];
          }
        }

        if (is_array($rows) && count($rows) > 0) {
          foreach ($rows as $index => $row) {
            // Normalize common fields but preserve raw payload under 'raw'
            $title = trim($row['title'] ?? $row['Title'] ?? $row['job_title'] ?? '');
            $company = trim($row['company'] ?? $row['Company'] ?? $row['company_name'] ?? '');
            $job_description = trim($row['job_description'] ?? $row['JobDescription'] ?? $row['description'] ?? '');
            $hours = trim($row['formatted_work_type'] ?? $row['Duration'] ?? $row['Term'] ?? $row['Hours'] ?? '');
            $match = $row['match_score'] ?? $row['computed_score'] ?? $row['content_score'] ?? 0;
            if (is_numeric($match) && $match > 0 && $match <= 1.01) $match = $match * 100;

            // Find a canonical job_id from common keys used across generators
            $possibleIdKeys = ['job_id','JobID','id','jobId','JobId','id_job','posting_id','postingId','position_id','positionId','external_id','externalId'];
            $foundId = null;
            foreach ($possibleIdKeys as $k) {
              if (isset($row[$k]) && strlen((string)$row[$k]) > 0) { $foundId = (string)$row[$k]; break; }
            }
            // Compute a deterministic fallback id when the generator does not supply one.
            // This uses stable fields (title, company, location/description) so both pages
            // can reproduce the same id independently.
            $titleFallback = trim($row['title'] ?? $row['Title'] ?? $row['job_title'] ?? '');
            $companyFallback = trim($row['company'] ?? $row['Company'] ?? $row['company_name'] ?? '');
            $descFallback = trim($row['job_description'] ?? $row['JobDescription'] ?? $row['description'] ?? '');
            if ($foundId) {
                $jid = $foundId;
            } else {
                $jid = md5(($titleFallback ?: $descFallback) . '|' . $companyFallback . '|' . ($row['location'] ?? ''));
            }

            $jobs[] = [
              'job_id' => $jid,
              // Preserve the full title or full job description from the per-user JSON
              'title' => $title ?: ($job_description ?: 'Untitled Job'),
              'company' => $company,
              'location' => $row['location'] ?? '',
              'hours' => $hours,
              'match_score' => intval(round(floatval($match))),
              'why' => $job_description,
              'raw' => $row,
            ];
          }
        }
        // Make recommendations available in the same variable used by job-matches so sorting/filtering is consistent
        $recommendations = $jobs;
      }
    }
  }
  // Ensure $recommendations is at least an empty array when not found
  $recommendations = $recommendations ?? [];
  // If $jobs remains empty, we intentionally DO NOT fall back to global recommendations.json or CSV.
    // small industry keyword mapping reused from job-matches
    $industryKeywords = [
      'Healthcare' => ['health', 'nurse', 'doctor', 'clinic', 'hospital', 'patient', 'medical', 'therapist', 'pharmacy', 'caregiver', 'care'],
      'Retail' => ['retail','store','sales','cashier','shop','merchandis','customer service','stock','merchandise','associate'],
      'Food Service' => ['cook','chef','restaurant','food','barista','kitchen','waiter','waitress','server','catering'],
      'Education' => ['teacher','education','school','instructor','tutor','teacher aide','educator','classroom'],
      'Hospitality' => ['hotel','hospitality','front desk','housekeeping','concierge','lodging','guest'],
      'Manufacturing' => ['manufactur','assembly','production','factory','warehouse','operator','machinist','plant'],
      'Transportation' => ['driver','delivery','truck','transport','logistic','courier','van driver','bus driver'],
      'Cleaning' => ['clean','janitor','housekeeping','custodian','sanitation','cleaner'],
      'Office' => ['office','admin','administrative','reception','clerical','data entry','secretary'],
      'Construction' => ['construction','builder','carpenter','laborer','site','construction worker','foreman','excavator'],
      'Creative' => ['designer','creative','graphic','artist','illustrator','photograph','copywriter','content'],
      'Packing' => ['packag','packer','fulfillment','picker','warehouse','shipping'],
      'Other' => []
    ];

    // simple helpers (lightweight) - used when falling back to CSV
    $infer_fit_level = function(string $text) {
      $t = strtolower($text);
      $excellent = ['excellent', 'perfect', 'highly suitable', 'highly qualified', 'strong match', 'ideal'];
      foreach ($excellent as $k) { if (strpos($t, $k) !== false) return 'Excellent Fit'; }
      $good = ['good fit', 'good', 'suitable', 'appropriate', 'fit'];
      foreach ($good as $k) { if (strpos($t, $k) !== false) return 'Good Fit'; }
      return '';
    };

    // Global fallbacks (public recommendations.json / postings.csv) removed.
    // This view intentionally uses per-user recommendation files only (storage/app/reco_user_<uid>.json).

        // load approvals map
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

    // Normalize fields for display and scoring so this page matches job-matches behavior
    foreach ($pending as $k => $job) {
        $title = trim(strval($job['title'] ?? $job['raw']['title'] ?? $job['raw']['Title'] ?? ''));
        $job_description = trim(strval($job['why'] ?? $job['raw']['job_description'] ?? $job['raw']['JobDescription'] ?? $job['raw']['description'] ?? ''));
    // Use the raw job description as title if title missing (do not truncate)
    if ($title === '') {
      $title = $job_description ?: 'Untitled Job';
    }
        $company = trim(strval($job['company'] ?? $job['raw']['company'] ?? $job['raw']['Company'] ?? $job['raw']['company_name'] ?? ''));

        // compute raw/computed scores if present and normalize to 0-100
        $rawContentValue = $job['raw']['content_score'] ?? $job['raw']['computed_score'] ?? $job['raw']['match_score'] ?? ($job['match_score'] ?? 0);
        $computedMax = $job['raw']['computed_max_score'] ?? $job['raw']['computed_max'] ?? null;
        // normalize fractional values (0-1) to 0-100
        if (is_numeric($rawContentValue) && $rawContentValue > 0 && $rawContentValue <= 1.01) $rawContentValue = $rawContentValue * 100;
        $normContent = is_numeric($rawContentValue) ? round(floatval($rawContentValue), 2) : 0;

        // update the pending item with normalized fields used later in template
        $pending[$k]['title'] = $title;
        $pending[$k]['company'] = $company;
        $pending[$k]['match_score'] = intval(round(floatval($job['match_score'] ?? $normContent ?? 0)));
        $pending[$k]['content_score'] = $normContent;
        $pending[$k]['computed_score'] = $job['raw']['computed_score'] ?? null;
        $pending[$k]['computed_max_score'] = $computedMax;
    }

    // Sort using the same comparator as job-matches: prefer computed/content/hybrid then match_score
    usort($pending, function($a, $b) {
        $getRaw = function($x) {
            if (isset($x['content_score']) && $x['content_score'] !== null) return floatval($x['content_score']);
            if (isset($x['computed_score']) && $x['computed_score'] !== null) return floatval($x['computed_score']);
            return floatval($x['match_score'] ?? 0);
        };
        $norm = function($val) {
            if ($val > 0 && $val <= 1.01) return $val * 100.0;
            return $val;
        };
        $aScore = $norm($getRaw($a));
        $bScore = $norm($getRaw($b));
        return $bScore <=> $aScore;
    });
    $pendingCount = count($pending);
    // simple server-side pagination
    $perPage = 10;
    $page = max(1, intval(request()->query('page', 1)));
    $totalPages = max(1, (int) ceil($pendingCount / $perPage));
    if ($page > $totalPages) $page = $totalPages;
    $start = ($page - 1) * $perPage;
    $paged = array_slice($pending, $start, $perPage);
    @endphp

  <h3 class="text-lg font-bold text-yellow-600 mb-4">Pending Review: {{ $pendingCount }} &middot; Page {{ $page }} of {{ $totalPages }}</h3>

  @if(app()->environment('local'))
    @php
      $debugPath = isset($safeUid) ? storage_path('app/reco_user_' . $safeUid . '.json') : null;
      $debugExists = $debugPath ? file_exists($debugPath) : false;
      $debugCount = is_array($jobs) ? count($jobs) : 0;
    @endphp
    <div class="mb-4 p-3 bg-gray-50 border rounded text-xs text-gray-600">
      Debug: per-user reco path: <code>{{ $debugPath ?? 'n/a' }}</code> • exists: <strong>{{ $debugExists ? 'yes' : 'no' }}</strong> • loaded jobs: <strong>{{ $debugCount }}</strong>
    </div>
  @endif

  <script>
    // Signal to client-side scripts that server rendered per-user recommendations are present
    window.__SERVER_RECO_LOADED = @json(!empty($jobs) && count($jobs) > 0);
    window.__SERVER_RECO_SAFEUID = @json($safeUid ?? null);
    // Provide the actual recommendations payload to the client so scripts can render
    // the exact per-user data even when the server did not pre-render the HTML.
    window.__SERVER_RECO_PAYLOAD = @json(array_values($recommendations ?? []));
  </script>

  @foreach($paged as $p)
    @php
    // Normalize fields so guardian view shows the same information as job-matches
    $raw = is_array($p['raw'] ?? null) ? $p['raw'] : [];
    $title = trim($p['title'] ?? $raw['title'] ?? $raw['Title'] ?? $raw['job_title'] ?? '');
    $desc = trim($p['why'] ?? $raw['job_description'] ?? $raw['JobDescription'] ?? $raw['description'] ?? '');
    if ($title === '') {
      if (preg_match('/^(.{1,140}?)(?:\.|\n| needed with| needed| required with| required|:| - )/i', $desc, $m)) {
        $title = trim($m[1]);
      } else {
        $title = Str::limit($desc, 120);
      }
    }
    $company = trim($p['company'] ?? $raw['company'] ?? $raw['Company'] ?? $raw['company_name'] ?? '');
    $location = $p['location'] ?? $raw['location'] ?? '';
    $hours = $p['hours'] ?? $raw['hours'] ?? $raw['formatted_work_type'] ?? $raw['Duration'] ?? $raw['Term'] ?? '';
    $match_score = intval(round(floatval($p['match_score'] ?? $raw['match_score'] ?? $raw['computed_score'] ?? 0)));
    $skills_desc = $raw['skills_desc'] ?? $p['skills_desc'] ?? '';
    @endphp
    <div id="job-card-{{ $p['job_id'] }}" class="border-2 border-yellow-400 rounded-2xl p-6 bg-yellow-50/20 shadow-sm mb-6" data-content-score="{{ number_format(($match_score ?? 0)/100, 3) }}">
        <div class="flex justify-between items-start">
          <div class="flex items-center space-x-2">
            <img src="/images/job-icon.png" class="w-6 h-6" alt="Job Icon">
            <h4 class="text-lg font-semibold">{{ $title ?: 'Untitled Job' }}</h4>
          </div>
          <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pending Review</span>
        </div>

          <div class="mt-4">
          <span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">{{ $match_score }}% Match</span>
          {{-- debug job id for comparison with job-matches --}}
          <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: {{ $p['job_id'] }}</span>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-4 mt-4 text-sm">
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Company Name:</span> {{ $company }}</div>
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Location:</span> {{ $location }}</div>
          <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Hours:</span> {{ $hours }}</div>
        </div>

        <div class="bg-gray-100 rounded-lg mt-6 p-4">
          <div class="flex items-center space-x-2 mb-2"><img src="/images/lightbulb-icon.png" class="w-5 h-5" alt="Idea Icon"><h5 class="font-semibold text-gray-800">Why this Job Matches</h5></div>
          {{-- Show full job description verbatim so page matches per-user JSON exactly --}}
          <p class="text-sm text-gray-700">{{ $desc }}</p>
        </div>

        <div class="bg-yellow-100 rounded-lg mt-6 p-4">
          <div class="flex items-center space-x-2 mb-2"><img src="/images/feedback-icon.png" class="w-5 h-5" alt="Feedback Icon"><h5 class="font-semibold text-gray-800">Add your Feedback (Optional)</h5></div>
          <textarea id="feedback-{{ $p['job_id'] }}" class="w-full rounded-md border border-gray-300 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="Share your thoughts about this job suggestion" rows="3"></textarea>
        </div>

        <div class="flex justify-start space-x-3 mt-6">
          <a href="{{ route('job.details') }}?job_id={{ $p['job_id'] }}" class="bg-blue-500 text-white px-5 py-2 rounded-md text-sm hover:bg-blue-600 transition">View Details</a>
          <button data-jobid="{{ $p['job_id'] }}" class="approve-btn bg-green-600 text-white px-5 py-2 rounded-md text-sm hover:bg-green-700 transition">Approve Job</button>
          <button data-jobid="{{ $p['job_id'] }}" class="flag-btn bg-yellow-500 text-white px-5 py-2 rounded-md text-sm hover:bg-yellow-600 transition">Flag as Not Suitable</button>
        </div>
      </div>
    @endforeach

    {{-- Pagination controls --}}
    <div class="flex items-center justify-center space-x-2 mt-6">
      @php
        $baseUrl = request()->url();
      @endphp
      @if($page > 1)
        <a href="{{ $baseUrl }}?page={{ $page - 1 }}" class="px-3 py-1 bg-gray-200 rounded-md">&laquo; Prev</a>
      @else
        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-md">&laquo; Prev</span>
      @endif
      <span class="px-3 py-1 bg-white rounded-md">Page {{ $page }} / {{ $totalPages }}</span>
      @if($page < $totalPages)
        <a href="{{ $baseUrl }}?page={{ $page + 1 }}" class="px-3 py-1 bg-gray-200 rounded-md">Next &raquo;</a>
      @else
        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-md">Next &raquo;</span>
      @endif
    </div>
  
  @push('scripts')
  <script>
    // expose guardian approvals for client-side use (boosting / badges)
    window.__GUARDIAN_APPROVALS = {!! json_encode($guardianApprovals ?? []) !!};
  </script>
  <script type="module">
  // After auth is resolved, request per-user hybrid recommendations and replace pending list
  (async function(){
      try {
          const mod = await import("{{ asset('js/job-application-firebase.js') }}");
      await mod.ensureInit?.();
      let profile = null;
      try {
  try { /* firebase.token removed */ } catch(e) { console.debug('signInWithServerToken (guardian) failed', e); }
        profile = await mod.getUserProfile();
      } catch(e) { console.debug('no profile from firebase module', e); }
          if (!profile) return; // nothing to do

            // If server already rendered per-user recommendations, skip client-side replacement
            if (window.__SERVER_RECO_LOADED) {
                console.debug('guardian: server-rendered per-user recommendations present; skipping client replace');
                return;
            }

            const resp = await fetch('{{ url('/api/recommendations/user') }}', {
              method: 'POST',
              credentials: 'same-origin',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify(Object.assign({ uid: profile.uid || profile.userId || profile.user_id || '' }, profile))
          });
          // If server provided a payload, prefer it and avoid calling the hybrid API.
          let first = [];
          if (window.__SERVER_RECO_PAYLOAD && Array.isArray(window.__SERVER_RECO_PAYLOAD) && window.__SERVER_RECO_PAYLOAD.length > 0) {
            first = window.__SERVER_RECO_PAYLOAD;
          } else {
            if (!resp.ok) { console.warn('Hybrid recommender error', resp.status); return; }
            const data = await resp.json();
            const keys = Object.keys(data || {});
            if (keys.length === 0) return;
            first = data[keys[0]] || [];
          }
          // build new pending elements and replace existing list
          const container = document.querySelector('.max-w-5xl.mx-auto.mt-10.px-4');
          if (!container) return;
          // remove current listing children until the pagination (keep pagination area if present)
          // simple approach: clear and re-render header + items
          const headerHtml = container.querySelector('h3')?.outerHTML || '';
          container.innerHTML = headerHtml + '<div id="reco-list" class="mt-4"></div>';
          const list = container.querySelector('#reco-list');
      first.slice(0, 50).forEach((r, idx) => {
        // Reproduce server's canonical id logic: prefer job_id-like keys, otherwise deterministic md5-like fallback.
        // We can't run md5 easily here without a lib, so if server supplied a job_id use it; otherwise fall back to 'p'+idx
        const jid = String(r.job_id || r.JobID || r.id || r.jobId || r.external_id || ('p' + idx));
        // Render the title/company/why using the raw fields from the per-user JSON without truncation
        const title = r.Title || r.title || r.job_title || r.job_description || 'Untitled Job';
        const company = r.Company || r.company || r.company_name || '';
        const match = Math.round((Number(r.hybrid_score ?? r.content_score ?? r.match_score ?? 0) || 0) * ((Number(r.hybrid_score) > 1) ? 1 : 100));
        const why = r.job_description || r.description || '';
              const card = document.createElement('div');
              card.className = 'border-2 border-yellow-400 rounded-2xl p-6 bg-yellow-50/20 shadow-sm mb-6';
              card.innerHTML = `
                  <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-2">
                      <img src="/images/job-icon.png" class="w-6 h-6" alt="Job Icon">
                      <h4 class="text-lg font-semibold">${escapeHtml(title)}</h4>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pending Review</span>
                  </div>
                  <div class="mt-4"><span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${match}% Match</span></div>
                  <div class="mt-4 grid grid-cols-3 gap-4 mt-4 text-sm">
                    <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Company Name:</span> ${escapeHtml(company)}</div>
                    <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Location:</span> ${escapeHtml(r.location || '')}</div>
                    <div class="bg-gray-100 p-2 rounded-md"><span class="font-semibold">Hours:</span> ${escapeHtml(r.hours || '')}</div>
                  </div>
                  <div class="bg-gray-100 rounded-lg mt-6 p-4"><div class="flex items-center space-x-2 mb-2"><img src="/images/lightbulb-icon.png" class="w-5 h-5" alt="Idea Icon"><h5 class="font-semibold text-gray-800">Why this Job Matches</h5></div><p class="text-sm text-gray-700">${escapeHtml(why)}</p></div>
                  <div class="bg-yellow-100 rounded-lg mt-6 p-4"><div class="flex items-center space-x-2 mb-2"><img src="/images/feedback-icon.png" class="w-5 h-5" alt="Feedback Icon"><h5 class="font-semibold text-gray-800">Add your Feedback (Optional)</h5></div><textarea id="feedback-${jid}" class="w-full rounded-md border border-gray-300 p-3 text-sm" placeholder="Share your thoughts about this job suggestion" rows="3"></textarea></div>
                  <div class="flex justify-start space-x-3 mt-6"><a href="/job-details?job_id=${encodeURIComponent(jid)}" class="bg-blue-500 text-white px-5 py-2 rounded-md text-sm hover:bg-blue-600 transition">View Details</a><button data-jobid="${jid}" class="approve-btn bg-green-600 text-white px-5 py-2 rounded-md text-sm hover:bg-green-700 transition">Approve Job</button><button data-jobid="${jid}" class="flag-btn bg-yellow-500 text-white px-5 py-2 rounded-md text-sm hover:bg-yellow-600 transition">Flag as Not Suitable</button></div>
              `;
              list.appendChild(card);
          });
      return; // done rendering payload or hybrid results
      } catch(e) { console.debug('guardian per-user reco failed', e); }
  })();
  </script>
  @endpush
  <!-- Ensure Firebase client is signed-in (attempt server-backed sign-in + logging) -->
  <script type="module">
  (async function(){
    try {
      const mod = await import("{{ asset('js/job-application-firebase.js') }}");
      const logger = await import("{{ asset('js/client-logger.js') }}");
      try {
    <!-- firebase.token removed -->
      } catch(e) {
        console.debug('guardian signInWithServerToken failed', e);
        try { logger.sendClientLog('debug', 'guardian signInWithServerToken failed', { error: String(e) }); } catch(_) {}
      }
      const signed = await mod.isSignedIn(7000);
      console.debug('guardian auth guard: isSignedIn ->', signed);
      try {
        if (mod && typeof mod.debugAuthLogging === 'function') window.__unsubAuthLog = mod.debugAuthLogging();
      } catch(e) { console.warn('guardian debugAuthLogging failed', e); }
      // Do not redirect on guardian page; just ensure client has an ID token if possible
      if (!signed) {
        if (window.__SERVER_AUTH) {
          try { logger.sendClientLog('info', 'guardian auth guard: server session present, not signed-in client'); } catch(_) {}
        } else {
          try { logger.sendClientLog('info', 'guardian auth guard: client not signed-in and no server session'); } catch(_) {}
        }
      }
    } catch(err) {
      console.error('guardian auth guard failed', err);
      try { (await import("{{ asset('js/client-logger.js') }}")).sendClientLog('error', 'guardian auth guard failed', { error: String(err) }); } catch(_) {}
    }
  })();
  </script>
  </div>
</div>
<br>
@endsection