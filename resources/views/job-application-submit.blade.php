@extends('layouts.includes')
@section('content')

    <!-- Info -->
    {{-- <div class="text-center mt-3 text-sm underline text-gray-600">
        <a href="#" class="hover:text-blue-600 font-medium">Click to know about the navigation buttons above</a>
        <p class="italic text-xs">(pindutin upang malaman ang tungkol sa navigation buttons sa taas)</p>
    </div> --}}

    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/job-application-review2" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>

  <!-- Applying For -->
  <section class="max-w-5xl mx-auto mt-8 px-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Applying for</h2>
    @php
  $csv_path = public_path('postings.csv');
        $job = null;
        $job_id = request('job_id');
    if ($job_id !== null && file_exists($csv_path)) {
      if (($handle = fopen($csv_path, 'r')) !== false) {
        $header = fgetcsv($handle);
        if ($header === false) { fclose($handle); }
        $cols = array_map(function($h){ return trim($h); }, $header ?: []);
        $numCols = count($cols);
      $i = 0;
      $maxRows = 5000;
      while (($row = fgetcsv($handle)) !== false) {
          if ($numCols > 0) {
            if (count($row) < $numCols) $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
            elseif (count($row) > $numCols) $row = array_slice($row, 0, $numCols);
            if (count($row) !== $numCols) { $i++; continue; }
          }
          if ($i >= $maxRows) break;
          if ($i == intval($job_id)) {
            $assoc = $numCols ? (array_combine($cols, $row) ?: []) : [];
                        $job = [
                            'title' => $assoc['Title'] ?? $assoc['jobpost'] ?? '',
                            'company' => $assoc['Company'] ?? '',
                            'location' => $assoc['Location'] ?? '',
                            'job_description' => $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? '',
                            'type' => $assoc['Type'] ?? '',
                        ];
                        break;
                    }
                    $i++;
                }
                fclose($handle);
      if (!empty($rowFound)) {
        $map = [];
        if (is_array($headers)) {
          $flipped = @array_flip($headers);
          if (is_array($flipped)) $map = array_change_key_case($flipped);
        }
        $get = function($names) use ($rowFound, $map) {
          foreach ((array)$names as $n) {
            $k = strtolower(trim($n));
            if (is_array($map) && array_key_exists($k, $map)) {
              $idx = $map[$k];
              if (is_array($rowFound) && array_key_exists($idx, $rowFound)) return $rowFound[$idx];
            }
          }
          return '';
        };
        $title = $get(['title','jobtitle','job_title','position','job name']) ?: $title;
        $company = $get(['company','companyname','employer']) ?: $company;
        $location = $get(['location','address','city']) ?: $location;
      }
            }
        }
    @endphp

    <div class="border-2 border-blue-200 bg-white rounded-lg p-4 flex items-center space-x-4 shadow-sm">
      <img src="/images/ipetclub.png" alt="Job" class="w-20 h-20 object-contain">
      <div>
        <h3 class="text-xl font-semibold text-gray-800">{{ $job['title'] ?? 'Job Title' }}</h3>
        <p class="text-sm text-gray-700">{{ $job['company'] ?? '' }}</p>
        <p class="text-sm text-gray-500">{{ $job['location'] ?? '' }}</p>
        <p class="text-sm text-gray-500">{{ $job['type'] ?? '' }}</p>
      </div>
    </div>
  </section>

  <!-- Submit Application -->
  <section class="max-w-5xl mx-auto mt-8 px-4 mb-16">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Submit Application</h2>

    <!-- Confirmation box -->
    <div class="bg-green-100 border border-green-300 rounded-lg p-6 text-gray-800">
      <h3 class="font-semibold text-green-900 mb-2">Final Confirmation</h3>
      <p class="text-sm text-gray-700 mb-3">
        By submitting this application, you confirm that all information provided is accurate and complete.
      </p>

      <div class="flex items-start space-x-2">
        <input type="checkbox" id="confirmation" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded">
        <label for="confirmation" class="text-xs text-gray-600">
          I confirm that all information provided is accurate and I agree to the
          <a href="#" class="underline text-blue-600">terms and conditions</a>.
        </label>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end mt-8">
      <button id="finalSubmit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition font-medium">
        Submit Application
      </button>
    </div>
  </section>

</div>

<!-- Ensure global Firebase config is present for the module -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
<script type="module">
import { submitJobApplication, isSignedIn, signInWithServerToken } from "{{ asset('js/job-application-firebase.js') }}";

// Page-level guard: redirect unauthenticated users immediately and attach handler for signed-in users
(async function(){
  try {
    try { await signInWithServerToken("{{ route('firebase.token') }}"); } catch(e) { console.debug('signInWithServerToken failed', e); }
    const signed = await isSignedIn(3000);
    if (!signed) {
      const current = window.location.pathname + window.location.search;
            window.location.href = 'login?redirect=' + encodeURIComponent(current);
      return;
    }

    // attach handler after confirming signed-in
    document.getElementById('finalSubmit').addEventListener('click', async function() {
      const btn = this;
      btn.disabled = true;
      const originalText = btn.textContent;
      btn.textContent = 'Submitting...';

      const step1 = JSON.parse(sessionStorage.getItem('jobApplication_step1') || '{}');
      const step2 = JSON.parse(sessionStorage.getItem('jobApplication_step2') || '{}');

      // combine
      const payload = {
        submitted_at: new Date().toISOString(),
        ...step1,
        ...step2,
        job_id: "{{ request('job_id') ?? '' }}",
        source: 'web'
      };

      try {
        // Ensure user confirmed the terms
        const confirmed = document.getElementById('confirmation') && document.getElementById('confirmation').checked;
        if (!confirmed) {
          alert('Please confirm that the information you provided is accurate before submitting.');
          btn.disabled = false;
          btn.textContent = originalText;
          return;
        }

        const result = await submitJobApplication(payload);
        // clear saved steps
        sessionStorage.removeItem('jobApplication_step1');
        sessionStorage.removeItem('jobApplication_step2');
        try {
          localStorage.removeItem('jobApplication_step1');
          localStorage.removeItem('jobApplication_step2');
        } catch(e){}

        // show quick success feedback then redirect
        btn.textContent = 'Submitted ✓';
        setTimeout(() => {
          window.location.href = "{{ route('job.matches') }}";
        }, 900);

      } catch (err) {
        console.error('Submit application error', err);
        const msg = (err && err.message) ? err.message : '';
        if (msg && msg.toLowerCase().includes('not signed in')) {
          const current = window.location.pathname + window.location.search;
          window.location.href = 'login?redirect=' + encodeURIComponent(current);
          return;
        }
        alert('Failed to submit application. Please try again.');
        btn.disabled = false;
        btn.textContent = originalText;
      }
    });

  } catch (err) {
    console.error('Auth guard failed', err);
    // As a fallback attach the handler but let it check again on submit
    document.getElementById('finalSubmit').addEventListener('click', async function() {
      const btn = this; btn.disabled = true; const originalText = btn.textContent; btn.textContent = 'Submitting...';
      const step1 = JSON.parse(sessionStorage.getItem('jobApplication_step1') || '{}');
      const step2 = JSON.parse(sessionStorage.getItem('jobApplication_step2') || '{}');
      try {
        const payload = { submitted_at: new Date().toISOString(), ...step1, ...step2, job_id: "{{ request('job_id') ?? '' }}", source: 'web' };
        const result = await submitJobApplication(payload);
        sessionStorage.removeItem('jobApplication_step1');
        sessionStorage.removeItem('jobApplication_step2');
        btn.textContent = 'Submitted ✓';
        setTimeout(() => { window.location.href = "{{ route('job.matches') }}"; }, 900);
      } catch (e) { alert('Failed to submit application. Please try again.'); btn.disabled = false; btn.textContent = originalText; }
    });
  }
})();
</script>
@endsection
