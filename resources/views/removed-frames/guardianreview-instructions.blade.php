@extends('layouts.includes')

@section('content')

<!-- Back Button -->
<div class="bg-blue-500 mt-6 py-8 px-6">
  <a href="/job-details" class="flex items-center space-x-3 text-black text-3xl font-semibold hover:underline">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span>Back</span>
  </a>
</div>
<!-- Overview -->
 <!-- NOTE: Kayo na maglagay ng mga images dyan mga ante -->
  <section class="max-w-5xl mx-auto mt-8 px-4">
    <div class="bg-gray-100 rounded-lg p-6 shadow-sm">
      <div class="flex items-center space-x-2 mb-2">
        <img src="{{ asset('image/lightbulb.png') }}" class="w-5 h-5" alt="Info Icon">
        <h2 class="text-lg font-semibold text-gray-800">Overview: Your Important Role</h2>
      </div>
      <p class="text-gray-700 text-sm leading-relaxed">
        As a guardian, you play a crucial role in guiding the user toward suitable employment opportunities. The Guardian Review system allows you to carefully evaluate job suggestions, ensuring they match the user’s abilities, preferences, and support needs before they can apply.
      </p>
    </div>
  </section>

  <!-- Important to Know -->
  <section class="max-w-5xl mx-auto mt-6 px-4">
    <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-6 shadow-sm">
      <div class="flex items-center space-x-2 mb-2">
        <img src="{{ asset('image/warning.png') }}" class="w-5 h-5" alt="Warning Icon">
        <h2 class="text-lg font-semibold text-gray-800">Important to Know</h2>
      </div>
      <p class="text-gray-700 text-sm leading-relaxed">
        The user can only apply to jobs that you have approved. This safety measure ensures that every application is for a position you’ve carefully reviewed and believe is appropriate. Jobs you flag will not be visible in their application options.
      </p>
    </div>
  </section>

  <!-- How the Review System Works -->
  <section class="max-w-5xl mx-auto mt-6 px-4">
    <div class="bg-gray-100 rounded-lg p-6 shadow-sm">
      <div class="flex items-center space-x-2 mb-2">
        <img src="{{ asset('image/lightbulb.png') }}" class="w-5 h-5" alt="Lightbulb Icon">
        <h2 class="text-lg font-semibold text-gray-800">How the Review System Works</h2>
      </div>
      <div class="flex justify-center items-center space-x-4 mt-4">
        <img src="{{ asset('image/step1.png') }}" alt="Step 1" class="w-24 h-24 rounded-lg shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <img src="{{ asset('image/step2.png') }}" alt="Step 2" class="w-24 h-24 rounded-lg shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <img src="{{ asset('image/step3.png') }}" alt="Step 3" class="w-24 h-24 rounded-lg shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <img src="{{ asset('image/step4.png') }}" alt="Step 4" class="w-24 h-24 rounded-lg shadow-sm">
      </div>
    </div>
  </section>

  <!-- Understanding Your Decision Options -->
  <section class="max-w-5xl mx-auto mt-6 px-4 mb-12">
    <div class="bg-gray-100 rounded-lg p-6 shadow-sm">
      <div class="flex items-center space-x-2 mb-3">
        <img src="{{ asset('image/lightbulb.png') }}" class="w-5 h-5" alt="Info Icon">
        <h2 class="text-lg font-semibold text-gray-800">Understanding Your Decision Options</h2>
      </div>

      <div class="flex items-start space-x-3 mb-4">
        <img src="{{ asset('image/approved.png') }}" alt="Check Icon" class="w-12 h-12">
        <div>
          <p class="font-semibold text-gray-800">Approve Job</p>
          <p class="text-sm text-gray-700 leading-relaxed">
            Select this when you believe the job is suitable and the user is ready to apply.
            The job will appear in their “Approved Jobs” list and they can then submit an application.
          </p>
        </div>
      </div>

      <div class="flex items-start space-x-3">
        <img src="{{ asset('image/flagged.png') }}" alt="Flag Icon" class="w-12 h-12">
        <div>
          <p class="font-semibold text-gray-800">Flag as Not Suitable</p>
          <p class="text-sm text-gray-700 leading-relaxed">
            Choose this if the job has concerns that make it inappropriate at this time.
            The job will be hidden from the user and they cannot apply. You can reconsider this decision later.
          </p>
        </div>
      </div>
    </div>
  </section>

</div>
@endsection