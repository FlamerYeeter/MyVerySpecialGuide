{{--Will move to the company folder tas route niyo ng maayos yan Thomas--}}
{{--gagawin kong responsive mamaya--}}

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notice of Application Status</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* prefer local Calibri if available, with sensible fallbacks */
    @font-face {
      font-family: 'CalibriLocal';
      src: local('Calibri'), local('Calibri Regular');
      font-weight: normal;
      font-style: normal;
    }

    /* Force Calibri for the notice */
    body {
      font-family: 'CalibriLocal', 'Calibri', 'Segoe UI', Arial, sans-serif !important;
    }
  </style>
</head>
<body class="bg-[#ffffff] flex flex-col items-center justify-center min-h-screen p-6">
  <div class="bg-[#fff0c8] rounded-2xl max-w-2xl w-full shadow-lg p-10">
    <!-- Title -->
    <h1 class="text-center text-2xl font-sans text-black mb-6">Notice of Application Status</h1>

    <!-- Icon -->
    <div class="flex justify-center mb-4">
      <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 112 0v2a1 1 0 11-2 0v-2zm0-8a1 1 0 112 0v6a1 1 0 11-2 0V5z" clip-rule="evenodd" />
        </svg>
      </div>
    </div>

    <!-- Message -->
    <p class="text-center text-gray-800 mb-8">
      Dear Applicant,<br>
      We regret to inform you that your recent Company Representative Registration has been rejected after
      careful review by our Admin Team.
    </p>

    <!-- Reason -->
    <div class="mb-6">
      <h2 class="font-semibold text-yellow-600 flex items-center mb-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.518 11.6A2 2 0 0116.518 18H3.482a2 2 0 01-1.743-3.301l6.518-11.6zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-7a1 1 0 00-.993.883L9 7v4a1 1 0 001.993.117L11 11V7a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        Reason for Rejection
      </h2>
      <p class="text-gray-700 text-sm">
        Your application did not meet one or more of the required criteria for approval. This decision was made
        because the information or documents submitted did not fully confirm your identity as an authorized
        Company Representative.
      </p>
    </div>

    <!-- Re-application Guidelines -->
    <div class="border border-green-400 bg-green-50 p-4 rounded-md mb-6">
      <h3 class="text-green-700 font-semibold text-sm flex items-center mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-600" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd" />
        </svg>
        RE-APPLICATION GUIDELINES
      </h3>
      <p class="text-xs text-green-700 mb-3">
        If you wish to re-apply, please follow the steps below to ensure that your information is properly verified and
        confirmed as a legitimate company representative:
      </p>

      <div class="bg-white p-4 rounded-lg border border-gray-200 text-sm">
        <p><span class="font-semibold">Step 1:</span> Review your information — ensure your name, position, and company details match official records.</p>
        <p class="mt-2"><span class="font-semibold">Step 2:</span> Obtain company authorization — secure a signed letter confirming you are an approved company representative.</p>
        <p class="mt-2"><span class="font-semibold">Step 3:</span> Prepare required documents — valid ID, company permit/profile, and authorization letter.</p>
        <p class="mt-2"><span class="font-semibold">Step 4:</span> Submit re-application — log in to the Company Module, select “Create Account”, and wait for Admin Approval.</p>
        <p class="mt-2"><span class="font-semibold">Step 5:</span> Complete registration — once approved, provide remaining company details and submit your final registration.</p>
      </div>
    </div>

    <!-- Important Reminders -->
    <div class="text-sm text-gray-700 mb-8">
      <h4 class="text-yellow-600 font-semibold flex items-center mb-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.518 11.6A2 2 0 0116.518 18H3.482a2 2 0 01-1.743-3.301l6.518-11.6zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-7a1 1 0 00-.993.883L9 7v4a1 1 0 001.993.117L11 11V7a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        Important Reminders
      </h4>
      <ul class="list-disc list-inside text-sm text-gray-800 space-y-1">
        <li>Only verified and authorized company representatives are permitted to register.</li>
        <li>Incomplete, inaccurate, or unverified applications will not be accepted.</li>
        <li>Admin approval is required before accessing or completing full company registration.</li>
        <li>For any concerns, please contact the Admin Office or email 
          <a href="mailto:JuanDelacruzDS@admin.com" class="text-blue-600 underline">JuanDelacruzDS@admin.com</a>.
        </li>
      </ul>
    </div>
  </div>

  <!-- Done Button -->
  <div class="mt-6 flex justify-end">
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-2 rounded-md font-medium">
      Done
    </button>
  </div>
</body>
</html>
