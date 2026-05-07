@extends('layouts.includes')

@section('content')

@php
  // Attempt to load application and its feedback from Oracle (best-effort)
  $application = null;
  $feedback = null;
  $appId = request('application_id') ?? request('id') ?? null;
  if (!empty($appId)) {
    try {
      $oraclePath = base_path('public/db/oracledb.php');
      if (file_exists($oraclePath)) {
        require_once $oraclePath; // provides getOracleConnection()
        $conn = getOracleConnection();
        if ($conn) {
          $sql = "SELECT A.ID, A.JOB_POSTING_ID, A.COMPANY_ID, A.GUARDIAN_ID, A.FIRST_NAME, A.LAST_NAME, A.EMAIL, A.CREATED_AT, JP.COMPANY_NAME, JP.JOB_ROLE
                FROM MVSG.APPLICATIONS A
                LEFT JOIN MVSG.JOB_POSTINGS JP ON JP.ID = A.JOB_POSTING_ID
                WHERE A.ID = :aid";
          $stid = oci_parse($conn, $sql);
          oci_bind_by_name($stid, ':aid', $appId);
          @oci_execute($stid);
          $row = @oci_fetch_assoc($stid);
          @oci_free_statement($stid);
          if ($row) {
            $application = $row;
            // try to fetch job_capacity feedback for this user+job
            $jid = $application['JOB_POSTING_ID'] ?? null;
            $uid = $application['GUARDIAN_ID'] ?? null;
            if (!empty($jid) && !empty($uid)) {
              $q2 = "SELECT STATUS, ROLE, CATEGORY_LEVEL, HR_DECISION, OVERALL_SUMMARY, UPDATED_AT FROM MVSG.JOB_CAPACITY WHERE JOB_POSTING_ID = :jid AND USER_ID = :uid";
              $s2 = oci_parse($conn, $q2);
              oci_bind_by_name($s2, ':jid', $jid);
              oci_bind_by_name($s2, ':uid', $uid);
              @oci_execute($s2);
              $fb = @oci_fetch_assoc($s2);
              @oci_free_statement($s2);
              if ($fb) $feedback = $fb;
              // Fallback: if no user-specific row found, try to get latest FINAL_RECOMMENDATION for the job
              if (empty($feedback) && !empty($jid)) {
                $q3 = "SELECT STATUS, ROLE, CATEGORY_LEVEL, HR_DECISION, OVERALL_SUMMARY, UPDATED_AT FROM (SELECT * FROM MVSG.JOB_CAPACITY WHERE JOB_POSTING_ID = :jid2 AND (OVERALL_SUMMARY IS NOT NULL OR HR_DECISION IS NOT NULL) ORDER BY UPDATED_AT DESC) WHERE ROWNUM = 1";
                $s3 = oci_parse($conn, $q3);
                // bind as string/number depending on type
                oci_bind_by_name($s3, ':jid2', $jid);
                @oci_execute($s3);
                $fb2 = @oci_fetch_assoc($s3);
                @oci_free_statement($s3);
                if ($fb2) $feedback = $fb2;
              }
            }
          }
          @oci_close($conn);
        }
      }
    } catch (\Throwable $e) {
      // ignore — page will show fallback messaging
    }
  }
@endphp


<main class="overflow-x-hidden flex flex-col flex-1 min-h-0">

<!-- HERO HEADER (MATCHED STYLE) -->
<section class="bg-sky-50 py-12 sm:py-16 border-b border-sky-100" role="region" aria-labelledby="hero-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 text-center">

        <p class="text-base font-bold uppercase tracking-widest text-blue-700">
            Application Status
        </p>

        <h1 id="hero-heading" class="text-4xl sm:text-5xl font-extrabold text-slate-900 mt-2">
            Application Feedback
        </h1>

        <div class="mx-auto max-w-2xl">
            <p class="text-lg sm:text-xl text-slate-700 mt-4">
                Check the result of your job application and see feedback from the company.
            </p>

            <!-- TTS BUTTON -->
            <div class="mt-6 inline-flex items-center justify-center">
                <button type="button"
                    onclick="speakText(document.getElementById('tts-hero').textContent)"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-2.5 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                    aria-label="Read application feedback aloud">

                    <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                    Listen
                </button>
            </div>
        </div>

        <!-- BACK BUTTON (MATCHED STYLE + CENTERED) -->
        <div class="pt-6 flex justify-center">
            <a href="/my-job-applications"
                class="inline-flex items-center gap-3 rounded-full border-2 border-blue-200 bg-white px-6 py-3 text-blue-700 font-semibold shadow-sm transition hover:bg-blue-50 hover:border-blue-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">

                <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png"
                    alt="" aria-hidden="true"
                    class="w-5 h-5">

                <span>Back to applications</span>
            </a>
        </div>

    </div>

    <!-- Hidden TTS -->
    <div id="tts-hero" class="sr-only">
        Application Feedback. Check the result of your job application and see feedback from the company.
    </div>
</section>

<!-- MAIN CONTENT -->
<div class="max-w-4xl mx-auto px-4 py-10">

    <!-- FEEDBACK CARD -->
    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-sm">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <img src="https://img.icons8.com/ios-filled/50/2563eb/document.png"
                    alt="Application document icon"
                    class="w-10 h-10">

                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">
                    Your Result
                </h2>
            </div>

            <!-- TTS -->
            <button type="button"
                onclick="speakText(document.getElementById('tts-feedback').textContent)"
                class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-4 py-2 text-white font-semibold shadow hover:bg-blue-800 transition focus:ring-4 focus:ring-blue-300"
                aria-label="Read feedback aloud">

                <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
            </button>
        </div>

        <!-- STATUS BADGES -->
        <div class="flex flex-wrap gap-3 mb-8">

            <!-- Decision -->
            <div class="rounded-full px-5 py-2 text-sm sm:text-base font-semibold bg-red-50 border border-red-200 text-red-700">
                Decision: {{ $feedback['HR_DECISION'] ?? 'No decision yet' }}
            </div>

            <!-- Support Level -->
            <div class="rounded-full px-5 py-2 text-sm sm:text-base font-semibold bg-green-50 border border-green-200 text-green-700">
                Support Level: {{ $feedback['CATEGORY_LEVEL'] ?? 'Pending' }}
            </div>

        </div>

        <!-- FEEDBACK TEXT -->
        <div id="tts-feedback" class="text-slate-700 text-lg sm:text-xl leading-relaxed space-y-5">

            @if ($feedback && (trim(($feedback['HR_DECISION'] ?? '') . ($feedback['OVERALL_SUMMARY'] ?? '')) !== ''))

                @if (!empty($feedback['OVERALL_SUMMARY']))
                    <p class="whitespace-pre-line">
                        {{ $feedback['OVERALL_SUMMARY'] }}
                    </p>
                @else

                    <p>
                        Thank you for applying for the
                        <strong>{{ $application['JOB_ROLE'] ?? 'the position' }}</strong>
                        at <strong>{{ $application['COMPANY_NAME'] ?? '' }}</strong>.
                    </p>

                    @if (!empty($feedback['HR_DECISION']))
                        <p>
                            Decision:
                            <strong>{{ $feedback['HR_DECISION'] }}</strong>
                        </p>
                    @endif

                    @if (!empty($feedback['ROLE']))
                        <p>
                            Role noted:
                            <strong>{{ $feedback['ROLE'] }}</strong>
                        </p>
                    @endif

                    <p>
                        Thank you for applying. We will contact you with next steps if applicable.
                    </p>

                @endif

            @else
                <p class="italic text-gray-500">
                    Feedback has not been provided by the company yet. Please check back later.
                </p>
            @endif

        </div>

    </div>

</div>


<!-- TTS SCRIPT -->
<script>
function speakText(text) {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        speechSynthesis.speak(utterance);
    }
}
</script>

</main>




@endsection