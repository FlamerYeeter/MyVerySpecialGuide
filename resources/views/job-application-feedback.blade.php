@extends('layouts.includes')

@section('content')


    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/my-job-applications" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>
<!-- Main Content -->
  <div class="max-w-4xl mx-auto px-4 py-10 space-y-8">


<!--PAAYOS NLANG UNG FORMAT THOMAS AH -->
    <!-- Application Summary Card -->
    <div class="border border-red-300 rounded-lg p-6 shadow-sm">
      <h2 class="font-semibold text-gray-800">Cashier</h2>
      <p class="text-sm text-gray-600 mt-1">McDonald’s • Taguig City, Metro Manila</p>
      <div class="flex items-center text-sm text-gray-600 mt-2 space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m2 9H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v11a2 2 0 01-2 2z" />
        </svg>
        <span>Applied: Aug 15, 2025</span>
      </div>

      <button class="mt-4 bg-red-100 text-red-600 px-4 py-2 rounded-md text-sm font-medium border border-red-200">
        Application Not Selected
      </button>
    </div>

    <!-- Feedback Message -->
    <div class="border border-gray-200 rounded-lg p-6 shadow-sm">
      <h3 class="font-semibold text-gray-800 mb-4">Application Feedback</h3>

      <p class="font-semibold text-red-600 mb-2">Dear Juan,</p>
      <p class="text-sm text-red-800 leading-relaxed mb-4">
        Thank you for your interest in the Cashier position at McDonald’s Taguig City.
        We appreciate the time and effort you invested in your application and the review process.
      </p>

      <p class="text-sm text-red-800 leading-relaxed mb-4">
        After careful review of your application and consideration of all candidates, we have decided
        to move forward with other applicants whose experience and qualifications more closely align
        with our current requirements for this role.
      </p>

      <p class="text-sm text-red-800 leading-relaxed mb-4">
        We encourage you to continue developing your skills and experience, and we would welcome
        future applications from you as you grow professionally.
      </p>

      <p class="text-sm text-gray-800 font-semibold mt-6">
        Best regards,<br>
        <span class="text-gray-900 font-bold">McDonald’s Taguig City Hiring Team</span>
      </p>
    </div>

  </div>
</div>
@endsection