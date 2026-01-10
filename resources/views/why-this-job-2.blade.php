@extends('layouts.includes')

@section('content')


<!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/job-matches"
      class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back to Jobs</span>
    </a>
  </div>
</div>

<!-- HERO SECTION -->
<section class="bg-pink-400 py-10 text-center shadow-md rounded-b-3xl">
  <div class="flex flex-col items-center justify-center">
    <img src="{{ asset('image/brain.png') }}" alt="Brain Icon" 
         class="w-24 h-24 mb-3 animate-bounce-slow">
    <h2 class="text-4xl font-extrabold text-white tracking-wide drop-shadow-md">
      Why This Job Match You?
    </h2>
    <p class="text-lg text-white/90 mt-2 max-w-2xl">
      Discover how your unique skills and interests align with this job role.  
    </p>
  </div>
</section>


<!-- Main Content Container -->
<section class="max-w-8xl mx-auto mt-16 mb-20 px-8 space-y-10">

  @php
    $job = $job ?? null;
   // call why-this-job.php server-side so the page is rendered with matches immediately
    $jobId = $job['assoc']['id'] ?? ($job['id'] ?? request()->get('job_id') ?? request()->query('job_id'));
    // Resolve uid robustly: explicit query param -> guardian_id param -> session -> auth user
    $uid = request()->query('user_id')
       ?? request()->get('user_id')
       ?? request()->query('guardian_id')
       ?? request()->get('guardian_id')
       ?? null;

    // If still empty, try to read from the authenticated user object (many apps store guardian_id on user)
    if (empty($uid) && auth()->check()) {
      $user = auth()->user();
      // try common properties in order
      $uid = data_get($user, 'guardian_id') ?: data_get($user, 'guardian') ?: data_get($user, 'id') ?: null;
    }

    // Local Blade diagnostics for UID resolution (visible to devs)
    $local_debug = [
      'query_user_id' => request()->query('user_id'),
      'query_guardian_id' => request()->query('guardian_id'),
      'session_guardian_id' => session('guardian_id'),
      'session_user_id' => session('user_id'),
      'auth_check' => auth()->check(),
      'auth_id' => auth()->id(),
      'resolved_uid' => $uid
    ];

    $whyData = null;
    if ($jobId) {
        try {
            $script = base_path('public/db/why-this-job.php');
            if (file_exists($script)) {
                // Use an internal HTTP request (forward cookies) instead of include so the script
                // runs in its own PHP context and can read Laravel session/cookie data reliably.
                $whyUrl = rtrim(config('app.url', url('/')), '/') . '/db/why-this-job.php?job_id=' . urlencode($jobId);
                $whyUrl .= '&user_id=' . urlencode($uid ?? '');
                $ch = curl_init($whyUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                // forward current request cookies so the PHP script can access Laravel session if needed
                if (!empty($_COOKIE)) {
                    $cookiePairs = [];
                    foreach ($_COOKIE as $k => $v) {
                        $cookiePairs[] = $k . '=' . rawurlencode($v);
                    }
                    curl_setopt($ch, CURLOPT_COOKIE, implode('; ', $cookiePairs));
                }
                // accept JSON
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
                $resp = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($resp && $httpCode >= 200 && $httpCode < 300) {
                    $whyData = json_decode($resp, true);
                } else {
                    // fallback: try include if HTTP call failed (keeps prior behavior)
                    $origGet = $_GET;
                    $_GET['job_id'] = (string)$jobId;
                    $_GET['user_id'] = $uid ? (string)$uid : '';
                    ob_start();
                    include $script;
                    $r = ob_get_clean();
                    $_GET = $origGet;
                    if ($r) $whyData = json_decode($r, true);
                }
            } else {
                // fallback to HTTP request (uses configured app url)
                $whyUrl = rtrim(config('app.url', url('/')), '/') . '/db/why-this-job.php?job_id=' . urlencode($jobId);
                $whyUrl .= '&user_id=' . urlencode($uid ?? '');
                $ch = curl_init($whyUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                if (!empty($_COOKIE)) {
                    $cookiePairs = [];
                    foreach ($_COOKIE as $k => $v) {
                        $cookiePairs[] = $k . '=' . rawurlencode($v);
                    }
                    curl_setopt($ch, CURLOPT_COOKIE, implode('; ', $cookiePairs));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
                $resp = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($resp && $httpCode >= 200 && $httpCode < 300) $whyData = json_decode($resp, true);
            }
        } catch (\Throwable $e) {
            $whyData = null;
        }
    }
    $jobTitle = $job['assoc']['title'] ?? ($job['assoc']['job_title'] ?? 'Untitled Job');
    if (!empty($whyData['job_title'])) $jobTitle = $whyData['job_title'];
    $company = $job['assoc']['company'] ?? '';
    $jobDescription = $job['job_description'] ?? '';
    if (!empty($whyData['job_description'])) $jobDescription = $whyData['job_description'];
    $matched_skills = $whyData['matches']['skills'] ?? [];
    $matched_workplace = $whyData['matches']['workplace'] ?? [];
    $matched_pref = $whyData['matches']['job_preference'] ?? [];
    $matched_certs = $whyData['matches']['certificates'] ?? [];
    $jobSkills = is_array($job['assoc']['skills'] ?? null) ? $job['assoc']['skills'] : (is_array($job['skills'] ?? null) ? $job['skills'] : []);
    $matchPercent = null;
    if (isset($job['match_score']) && is_numeric($job['match_score'])) {
        $m = floatval($job['match_score']);
        if ($m > 0 && $m <= 1.01) $matchPercent = round($m * 100);
        elseif ($m > 0 && $m <= 5.0) $matchPercent = round($m * 20);
        else $matchPercent = round($m);
    }
    // derive consolidated 'who we are looking for' from whyData
    // Aggregate multiple possible sources into a consolidated list: job field, qualifications, profiles, matches
    $whoWeAreLookingFor = [];
    if (!empty($whyData)) {
      if (!empty($whyData['what_we_are_looking_for'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['what_we_are_looking_for']);
      if (!empty($whyData['what_we_are_looking_for']) && is_string($whyData['what_we_are_looking_for'])) $whoWeAreLookingFor[] = $whyData['what_we_are_looking_for'];
      if (!empty($whyData['job']['what_we_are_looking_for'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['job']['what_we_are_looking_for']);
      if (!empty($whyData['job']['qualifications'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['job']['qualifications']);
      if (!empty($whyData['what_we_are_looking_for'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['what_we_are_looking_for']);
      if (!empty($whyData['profiles']['what_we_are_looking_for'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['profiles']['what_we_are_looking_for']);
      if (!empty($whyData['profiles']['qualifications'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['profiles']['qualifications']);
      // matches['qualifications'] may contain arrays with 'value'
      if (!empty($whyData['matches']['qualifications'])) {
        foreach ((array)$whyData['matches']['qualifications'] as $it) {
          if (is_array($it)) $whoWeAreLookingFor[] = $it['value'] ?? ($it['profile_value'] ?? ($it['user_value'] ?? null));
          else $whoWeAreLookingFor[] = $it;
        }
      }
      // fallback: top-level 'qualifications' if the endpoint provided it
      if (!empty($whyData['qualifications'])) $whoWeAreLookingFor = array_merge($whoWeAreLookingFor, (array)$whyData['qualifications']);
    }

    // Normalize: split strings containing commas/newlines and trim
    $expanded = [];
    foreach ($whoWeAreLookingFor as $item) {
      if (!is_string($item)) { $item = (string)$item; }
      $item = trim($item);
      if ($item === '') continue;
        // split multi-line / semicolon-separated strings (do NOT split on commas)
        if (preg_match('/[\r\n;]/', $item)) {
            $parts = preg_split('/[\r\n;]+/', $item);
        foreach ($parts as $p) {
          $p = trim($p);
          if ($p !== '') $expanded[] = $p;
        }
      } else {
        $expanded[] = $item;
      }
    }
    $whoWeAreLookingFor = array_values(array_unique($expanded));
    if (empty($whoWeAreLookingFor)) $whoWeAreLookingFor = null;
  @endphp

  <!-- Job card for selected job -->
  <div class="bg-yellow-100 border-4 border-yellow-300 rounded-3xl shadow-lg p-8 space-y-4 transition hover:shadow-2xl">
    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('image/nameofjob.png') }}" alt="Job Icon" class="w-12 h-12">
        <h3 id="jobTitle" class="text-3xl font-extrabold text-blue-900">{{ $jobTitle }}</h3>
      </div>
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
        <span class="text-lg bg-green-200 text-green-900 px-4 py-1 rounded-full font-semibold shadow">
          {{ $matchPercent !== null ? ($matchPercent . '% Match for You') : 'Matched' }}
        </span>
        <span class="text-lg bg-green-300 text-green-900 px-4 py-1 rounded-full font-semibold shadow">
          {{ $matchPercent !== null && $matchPercent >= 75 ? 'Excellent Match' : ($matchPercent !== null && $matchPercent >= 50 ? 'Good Match' : 'Potential Match') }}
        </span>
      </div>
    </div>

    <h4 class="text-2xl font-bold text-blue-900 mt-4">Why this Job Matches You 💡</h4>
    @php $whySentence = $job['why_sentence'] ?? null; @endphp
    @if($whySentence)
      <div class="text-lg text-gray-800 italic mb-3">{{ $whySentence }}</div>
    @endif

    <div class="bg-white rounded-2xl p-4 border-2 border-blue-100 text-lg text-gray-800">
      @if($jobDescription)
        <p>{{ $jobDescription }}</p>
      @else
        <p>This job was recommended because it aligns with your skills and preferences.</p>
      @endif
    </div>
    
    <!-- Matched Profile Items (from why-this-job.php) -->
    <div class="bg-white rounded-2xl p-4 border-2 border-yellow-100 text-lg text-gray-800 mt-6">
      <h5 class="text-xl font-semibold text-blue-900 mb-3">Matched Profile Items</h5>
      {{-- Perfect matches (both Job and User) --}}
      @if(!empty($whyData['perfect_matches']))
        <div class="mb-4 p-3 bg-green-50 border border-green-100 rounded">
          <p class="font-semibold text-gray-700">Perfect Matches</p>
          <div class="mt-2 flex flex-wrap gap-2">
                @foreach($whyData['perfect_matches'] as $type => $arr)
                  @foreach($arr as $pm)
                    @php
                      $val = $pm['value'] ?? '';
                      $uval = $pm['user_value'] ?? null;
                    @endphp
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">{{ $val }}
                      @if(!empty($uval) && (string)($uval) !== (string)($val))
                        <small class="text-gray-500 ml-2">{{ $uval }}</small>
                      @endif
                    </span>
                  @endforeach
                @endforeach
          </div>
        </div>
      @endif
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <p class="font-medium text-gray-700">Skills</p>
          <div class="mt-2 matched-skills-list">
            @if(!empty($matched_skills))
            @foreach($matched_skills as $it)
              @php $v = is_array($it) ? ($it['value'] ?? ($it['profile_value'] ?? ($it['user_value'] ?? ''))) : $it; @endphp
              <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium inline-block mr-2 mb-2">{{ $v }}</span>
            @endforeach
          @else
            <div class="text-sm text-gray-500">No matches found.</div>
          @endif
          </div>
        </div>
        <div>
          <p class="font-medium text-gray-700">Workplace / Environment</p>
          <div class="mt-2 matched-workplace-list">
            @if(!empty($matched_workplace))
            @foreach($matched_workplace as $it)
              @php $v = is_array($it) ? ($it['value'] ?? '') : $it; @endphp
              <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium inline-block mr-2 mb-2">{{ $v }}</span>
            @endforeach
          @else
            <div class="text-sm text-gray-500">No matches found.</div>
          @endif
          </div>
        </div>
        <div>
          <p class="font-medium text-gray-700">Job Preferences / Positions</p>
          <div class="mt-2 matched-preference-list">
            @if(!empty($matched_pref))
            @foreach($matched_pref as $it)
              @php $v = is_array($it) ? ($it['value'] ?? '') : $it; @endphp
              <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium inline-block mr-2 mb-2">{{ $v }}</span>
            @endforeach
          @else
            <div class="text-sm text-gray-500">No matches found.</div>
          @endif
          </div>
        </div>
        <div>
          <p class="font-medium text-gray-700">Certificates / Experience</p>
          <div class="mt-2 matched-cert-list">
          @if(!empty($matched_certs))
            @foreach($matched_certs as $c)
              @php
                $certRow = is_array($c) && isset($c['matched_cert']) ? $c['matched_cert'] : (is_array($c) ? $c : null);
                $label = $certRow['NAME'] ?? $certRow['ISSUED_BY'] ?? $certRow['WHAT_LEARNED'] ?? ($c['value'] ?? '');
              @endphp
              <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium inline-block mr-2 mb-2">{{ $label }}</span>
            @endforeach
          @else
            <div class="text-sm text-gray-500">No matches found.</div>
          @endif
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- What is this Job Card (Matched to Possible Section Size) -->
<div class="bg-blue-100 border-4 border-blue-300 rounded-3xl shadow-lg p-12 transition hover:shadow-2xl hover:scale-[1.015] duration-300">
  <div class="flex flex-col sm:flex-row sm:items-center mb-8 space-y-3 sm:space-y-0 sm:space-x-5">
    <img src="{{ asset('image/whatisthisjob.png') }}" alt="Info" class="w-14 h-14">
    <div>
      <h4 class="text-4xl font-extrabold text-blue-900">What is this Job?</h4>
      <span class="text-xl text-gray-700 italic block mt-2">(Ano ang Trabahong Ito?)</span>
    </div>
  </div>

  <div class="bg-white rounded-3xl border-2 border-blue-200 p-10 text-xl text-gray-800 leading-relaxed shadow-inner">
    <p class="text-blue-900 font-medium text-2xl mb-4">Job Overview</p>
    @if(!empty($jobDescription))
      <p>{{ $jobDescription }}</p>
    @else
      <p class="text-gray-600">No job description provided.</p>
    @endif

    <hr class="my-8 border-blue-200">

    <p class="text-blue-900 font-medium text-2xl mb-4">Ideal for You If...</p>
    @if(!empty($whoWeAreLookingFor))
      @if(is_array($whoWeAreLookingFor))
        <ul class="list-disc ml-6 space-y-2">
          @foreach($whoWeAreLookingFor as $it)
            <li>{{ $it }}</li>
          @endforeach
        </ul>
      @else
        <p>{{ $whoWeAreLookingFor }}</p>
      @endif
    @else
      <p class="text-gray-600 italic mt-3">No information on who we are looking for was provided.</p>
    @endif
  </div>
</div>

  <!-- Possible You Will Do in this Job -->
<div class="bg-green-100 border-4 border-green-300 rounded-3xl shadow-xl p-12 transition hover:shadow-2xl hover:scale-[1.015] duration-300">
  <div class="flex flex-col sm:flex-row sm:items-center mb-8 space-y-3 sm:space-y-0 sm:space-x-5">
    <img src="{{ asset('image/checkmark.png') }}" alt="Check" class="w-14 h-14">
    <div>
      <h4 class="text-4xl font-extrabold text-green-900">Possible You Will Do in this Job</h4>
      <span class="text-xl text-gray-700 italic block">(Mga Posibleng Gawin sa Trabahong Ito)</span>
    </div>
  </div>

  <div class="bg-white rounded-3xl border-2 border-green-200 p-10 text-xl text-gray-800 leading-relaxed shadow-inner">
    <p class="text-green-900 font-semibold text-2xl mb-6">🧾 Sample Preview Tasks</p>

    <ul class="list-disc ml-6 space-y-6">
      <li>
        <strong>Assist with Daily Tasks:</strong> Help in preparing, cleaning, and organizing the workspace.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Tumulong sa paghahanda, paglilinis, at pag-aayos ng lugar ng trabaho.)</span>
      </li>
      <li>
        <strong>Support the Team:</strong> Work with other staff to ensure smooth and efficient operations.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Makipagtulungan sa mga kasamahan para sa maayos na daloy ng trabaho.)</span>
      </li>
      <li>
        <strong>Maintain Equipment:</strong> Ensure tools, utensils, and materials are in good condition.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Siguraduhing maayos ang mga gamit at kagamitan bago at matapos gamitin.)</span>
      </li>
      <li>
        <strong>Follow Safety Procedures:</strong> Apply safety and hygiene practices while working.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Sundin ang mga patakaran sa kaligtasan at kalinisan.)</span>
      </li>
    </ul>

    <div class="mt-10 text-center">
      <p class="text-gray-700 italic text-base">*This is a sample preview only — actual tasks will be provided by experts.*</p>
    </div>
  </div>

  <!-- Images -->
  <div class="flex justify-center gap-8 mt-12 flex-wrap">
    <!-- Placeholder with icon -->
    <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 1</span>
    </div>

    <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 2</span>
    </div>

    <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 3</span>
    </div>

      <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 4</span>
    </div>
  </div>
</div>
</section>

<!-- BACK TO TOP BUTTON -->
<button id="backToTopBtn"
  class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
  onclick="scrollToTop()" aria-label="Back to top">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
    stroke="currentColor" stroke-width="3">
    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
  </svg>
  <span>Back to Top</span>
</button>


<script>
       // Show/hide the Back to Top button
      const backToTopBtn = document.getElementById("backToTopBtn");
         window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove("hidden");
                } else {
                backToTopBtn.classList.add("hidden");
                }
              });

        // Smooth scroll to top
            function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
  </script>



<!-- Firebase client removed: job-application-firebase.js is intentionally not loaded.
     Matching and rendering use server-provided data from /db/why-this-job.php. -->
<!-- hidden server-side job/guardian fallback for client -->
<div id="whyThisJobData"
     data-job-id="{{ $job['assoc']['id'] ?? $job['id'] ?? $job['job_id'] ?? request()->get('job_id') ?? '' }}"
     data-guardian-id="{{ $uid ?? request()->get('user_id') ?? request()->query('user_id') ?? '' }}"
     style="display:none;"></div>
@php
  // remove client-side duplicate fetch: keep the script section but skip client fetch when server provided data exists
  $skipClientFetch = !empty($whyData);
@endphp

@endsection

@section('scripts')
<script>
  (function(){
    try {
      const serverVar = @json($job['assoc']['id'] ?? $job['id'] ?? $job['job_id'] ?? null);
      const el = document.getElementById('whyThisJobData');
      const dataJob = el && el.dataset && el.dataset.jobId ? String(el.dataset.jobId) : null;
      const urlParams = new URLSearchParams(window.location.search);
      const urlJob = urlParams.get('job_id') || urlParams.get('id');
      const JOB_ID = serverVar || dataJob || urlJob;
      if (!JOB_ID) return;

      // derive guardian/user id from data attribute or querystring fallbacks
      const dataUid = el && el.dataset && el.dataset.guardianId ? String(el.dataset.guardianId) : null;
      const urlUser = urlParams.get('user_id') || urlParams.get('guardian_id') || urlParams.get('uid');
      const USER_ID = dataUid || urlUser || null;

      // attach to global for other scripts if needed
      if (USER_ID) window.__mvsg_guardian_id = USER_ID;

      let url = '/db/why-this-job.php?job_id=' + encodeURIComponent(JOB_ID);
      if (window.__mvsg_guardian_id) url += '&user_id=' + encodeURIComponent(window.__mvsg_guardian_id);

      fetch(url, { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
          if (!data) {
            console.debug('why-this-job returned empty response', data);
            return;
          }
          // allow responses that don't include an explicit "success" boolean
          if (data.success === false) {
            console.debug('why-this-job indicated failure', data);
            return;
          }
          console.debug('why-this-job response', data);
          const jt = data.job_title || (data.job && (data.job.job_role || data.job.job_title));
          if (jt) {
            const h = document.getElementById('jobTitle');
            if (h) h.textContent = jt;
          }

          const m = data.matches || {};

          const renderList = (elSelector, items) => {
            const container = document.querySelector(elSelector);
            if (!container) return;
            container.innerHTML = '';
            if (!items || items.length === 0) {
              container.innerHTML = '<div class="text-sm text-gray-500">No matches found.</div>';
              return;
            }
            items.forEach(it => {
              const v = (typeof it === 'string') ? it : (it.value || it.profile_value || it.user_value || '');
              const div = document.createElement('div');
              div.className = 'inline-block mr-2 mb-2';
              div.innerHTML = '<span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium">' + String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;') + '</span>';
              container.appendChild(div);
            });
          };

          renderList('.matched-skills-list', m.skills);
          renderList('.matched-workplace-list', m.workplace);
          renderList('.matched-preference-list', m.job_preference);

          const certs = (m.certificates || []).map(c => {
            const certRow = c.matched_cert || c.matched_certificates || c.matchedCert || c;
            if (certRow && (certRow.NAME || certRow.ISSUED_BY || certRow.WHAT_LEARNED)) {
              return (certRow.NAME || certRow.ISSUED_BY || certRow.WHAT_LEARNED);
            }
            return c.value || '';
          });
          renderList('.matched-cert-list', certs);

          const summary = document.querySelector('.matched-summary');
          if (summary) {
            const counts = [ (m.skills||[]).length, (m.workplace||[]).length, (m.job_preference||[]).length, (m.certificates||[]).length ];
            summary.textContent = 'Found ' + counts.reduce((a,b)=>a+b,0) + ' matching items across Skills, Workplace, Preferences and Certificates.';
          }
        })
        .catch(e => console.debug('why-this-job fetch failed', e));
    } catch(e) { console.debug('why-this-job init failed', e); }
  })();
</script>
@endsection