@extends('layouts.includes')

@section('content')


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

    <!-- Application Decision -->
    <div class="flex items-center gap-3 bg-red-100 border border-red-300 rounded-full px-6 py-3">
      <span class="text-xl font-semibold text-red-800">
        Decision: Not Hired
      </span>
    </div>

    <!-- Support Level -->
    <div class="flex items-center gap-3 bg-green-100 border border-green-300 rounded-full px-6 py-3">
      <span class="text-xl font-semibold text-green-800">
        Support Level: Full Support
      </span>
    </div>

  </div>

  <!-- Greeting -->
  <p class="font-semibold text-gray-800 text-2xl mb-6">
    Hello Juan,
  </p>

  <!-- Message -->
  <p class="text-2xl text-gray-700 leading-loose mb-6">
    Thank you for applying for the <strong>Kitchen Helper</strong> position at
    <strong>Shakey’s Taguig City</strong>.
  </p>

  <p class="text-2xl text-gray-700 leading-loose mb-6">
    We reviewed your application carefully. At this time, we have chosen
    another applicant for this role.
  </p>

  <p class="text-2xl text-gray-700 leading-loose mb-8">
    Please do not feel discouraged. You did well by applying.
    We encourage you to apply again in the future.
  </p>

  <!-- Closing -->
  <p class="text-2xl text-gray-800 font-medium mt-10">
    Kind regards,<br>
    <span class="font-semibold text-blue-800">
      Shakey’s Taguig City Hiring Team
    </span>
  </p>
</div>




@endsection