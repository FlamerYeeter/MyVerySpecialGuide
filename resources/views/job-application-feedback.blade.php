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
              $q2 = "SELECT STATUS, ROLE, CATEGORY_LEVEL, FINAL_RECOMMENDATION, HR_DECISION, UPDATED_AT FROM MVSG.JOB_CAPACITY WHERE JOB_POSTING_ID = :jid AND USER_ID = :uid";
              $s2 = oci_parse($conn, $q2);
              oci_bind_by_name($s2, ':jid', $jid);
              oci_bind_by_name($s2, ':uid', $uid);
              @oci_execute($s2);
              $fb = @oci_fetch_assoc($s2);
              @oci_free_statement($s2);
              if ($fb) $feedback = $fb;
              // Fallback: if no user-specific row found, try to get latest FINAL_RECOMMENDATION for the job
              if (empty($feedback) && !empty($jid)) {
                $q3 = "SELECT STATUS, ROLE, CATEGORY_LEVEL, FINAL_RECOMMENDATION, HR_DECISION, UPDATED_AT FROM (SELECT * FROM MVSG.JOB_CAPACITY WHERE JOB_POSTING_ID = :jid2 AND FINAL_RECOMMENDATION IS NOT NULL ORDER BY UPDATED_AT DESC) WHERE ROWNUM = 1";
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


    <!-- Back Button -->
    <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
        <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
            <a href="/my-job-applications"
                class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                    class="w-8 h-8 sm:w-10 sm:h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back</span>
            </a>
        </div>
    </div>

<!-- Main Content -->
  <div class="max-w-4xl mx-auto px-4 py-10 space-y-8">

<!-- Feedback Message -->
<div class="bg-blue-50 border border-blue-200 rounded-3xl p-10 shadow-lg max-w-6xl mx-auto">

  <!-- Header -->
  <div class="flex items-center gap-4 mb-6">
    <img 
      src="https://img.icons8.com/ios-filled/50/2563eb/document.png" 
      alt="Application document icon"
      class="w-12 h-12"
    />
    <h3 class="font-semibold text-blue-800 text-3xl">
      Application Feedback
    </h3>
  </div>

  <!-- Status & Support Labels -->
  <div class="flex flex-wrap gap-5 mb-10">
    <!-- Application Decision (use HR_DECISION only) -->
    <div class="flex items-center gap-3 rounded-full px-6 py-3" style="background: #fff6f6; border: 1px solid #fecaca;">
      <span class="text-xl font-semibold text-red-800">
        Decision: {{ $feedback['HR_DECISION'] ?? 'No decision yet' }}
      </span>
    </div>

    <!-- Support Level (use CATEGORY_LEVEL only; show Pending when null) -->
    <div class="flex items-center gap-3 rounded-full px-6 py-3" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
      <span class="text-xl font-semibold text-green-800">
        Support Level: {{ $feedback['CATEGORY_LEVEL'] ?? 'Pending' }}
      </span>
    </div>

  </div>

  <!-- Greeting -->
  <p class="font-semibold text-gray-800 text-2xl mb-6">
    Hello {{ $application['FIRST_NAME'] ?? 'Applicant' }},
  </p>

  <!-- Message -->
  @if ($feedback && (trim(($feedback['HR_DECISION'] ?? '') . ($feedback['FINAL_RECOMMENDATION'] ?? '')) !== ''))
    <p class="text-2xl text-gray-700 leading-loose mb-6">
      Thank you for applying for the <strong>{{ $application['JOB_ROLE'] ?? 'the position' }}</strong> at
      <strong>{{ $application['COMPANY_NAME'] ?? '' }}</strong>.
    </p>

    @if (!empty($feedback['HR_DECISION']))
      <p class="text-2xl text-gray-700 leading-loose mb-6">
        We reviewed your application carefully. Decision: <strong>{{ $feedback['HR_DECISION'] }}</strong>.
      </p>
    @endif

    @if (!empty($feedback['ROLE']))
      <p class="text-2xl text-gray-700 leading-loose mb-6">Role noted: <strong>{{ $feedback['ROLE'] }}</strong></p>
    @endif

    <p class="text-2xl text-gray-700 leading-loose mb-8">Thank you for applying. We will contact you with next steps if applicable.</p>
  @else
    <p class="text-2xl text-gray-700 leading-loose mb-6">Feedback has not been provided by the company yet. Please check back later.</p>
  @endif

  <!-- Closing -->
  <p class="text-2xl text-gray-800 font-medium mt-10">
    Kind regards,<br>
    <span class="font-semibold text-blue-800">
      {{ $application['COMPANY_NAME'] ?? $application['COMPANY_NAME'] ?? 'Hiring Team' }} Hiring Team
    </span>
  </p>
</div>




@endsection