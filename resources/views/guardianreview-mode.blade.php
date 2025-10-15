@extends('layouts.includes')

@section('content')

<!-- Back Button -->
  <div class="bg-blue-500 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="{{ route('job.matches') }}" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline"> <!-- ayusin nlang route neto -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>

  <!-- Guardian Review Mode Section -->
  <section class="max-w-4xl mx-auto mt-8 bg-gray-100 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-2">
      <img src="/images/shield-icon.png" alt="Shield Icon" class="w-5 h-5">
      <h2 class="text-lg font-semibold text-gray-700">Guardian Review Mode</h2>
    </div>
    <p class="text-sm text-gray-700 leading-relaxed">
      This detailed view helps you make an informed decision. Review all aspects of the job, including match
      analysis, potential concerns, and support available. Your feedback is valuable in helping us provide better job matches.
    </p>
  </section>

  <!-- Job Card -->
  <section class="max-w-4xl mx-auto mt-6 border-2 border-yellow-400 bg-yellow-50/30 rounded-2xl p-6">

    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center">
      <div class="flex items-center space-x-2">
        <img src="/images/job-icon.png" alt="Job Icon" class="w-6 h-6">
        <h3 class="text-lg font-semibold">Kitchen Helper</h3>
      </div>

      <div class="flex space-x-2">
        <button class="bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-700 transition">Approve Job</button>
        <button class="bg-yellow-500 text-white text-sm px-4 py-2 rounded-md hover:bg-yellow-600 transition">Flag as Not Suitable</button>
        <span class="bg-yellow-200 text-yellow-800 text-sm px-4 py-2 rounded-full">Pending Review</span>
      </div>
    </div>

    <!-- Match -->
    <div class="mt-4">
      <span class="bg-green-200 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">90% Match</span>
    </div>

    <!-- Details -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
      <div class="bg-gray-100 px-3 py-2 rounded-md">
        <span class="font-semibold">Company Name:</span> KFC
      </div>
      <div class="bg-gray-100 px-3 py-2 rounded-md">
        <span class="font-semibold">Location:</span> Taguig City
      </div>
      <div class="bg-gray-100 px-3 py-2 rounded-md">
        <span class="font-semibold">Hours:</span> Part-time
      </div>
    </div>
  </section>

  <!-- Why this Job Matches -->
  <section class="max-w-4xl mx-auto mt-6 bg-gray-100 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-2">
      <img src="/images/lightbulb-icon.png" alt="Lightbulb Icon" class="w-5 h-5">
      <h4 class="font-semibold text-gray-700">Why this Job Matches</h4>
    </div>

    <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2">
      <li><span class="font-semibold">Hands-On Work Skills:</span> Juan excels at practical, hands-on tasks. This position involves washing dishes, preparing vegetables, and organizing – all activities that align with his strengths in following clear, physical task sequences.</li>
      <li><span class="font-semibold">Structured Routines:</span> The kitchen follows predictable daily routines with clear checklists and procedures. Juan thrives in environments with consistent structures and step-by-step instructions, which this role provides.</li>
      <li><span class="font-semibold">Team Environment:</span> Juan is described as cooperative and helpful. The kitchen team works collaboratively, and his willingness to support others makes him a valuable team member in a busy food service setting.</li>
    </ul>
  </section>

  <!-- Potential Concerns -->
  <section class="max-w-4xl mx-auto mt-6 bg-yellow-50 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-2">
      <img src="/images/warning-icon.png" alt="Warning Icon" class="w-5 h-5">
      <h4 class="font-semibold text-gray-700">Potential Concerns & How they are Addressed</h4>
    </div>

    <p class="text-sm font-semibold text-gray-700">Physical Demands</p>
    <p class="text-sm text-gray-700 mt-1">
      The role requires standing for extended periods and lifting items up to 20 lbs. Juan may need to build stamina for physical tasks.
    </p>

    <div class="bg-green-100 border-l-4 border-green-500 p-4 mt-3 rounded-md text-sm text-gray-700">
      <p><span class="font-semibold text-green-800">How it is Addressed:</span></p>
      <p class="mt-1">
        Regular breaks are scheduled every 2 hours. Heavy lifting is done in pairs or with assistance.
        The employer provides ergonomic mats for standing stations and allows sitting breaks as needed.
        Physical stamina will build naturally over time.
      </p>
    </div>
  </section>

  <!-- Feedback Box -->
  <section class="max-w-4xl mx-auto mt-6 bg-yellow-50 rounded-xl p-6">
    <div class="flex items-center space-x-2 mb-3">
      <img src="/images/feedback-icon.png" alt="Feedback Icon" class="w-5 h-5">
      <h4 class="font-semibold text-gray-700">Add your Feedback (Optional)</h4>
    </div>
    <textarea
      placeholder="Share your thoughts about this job suggestion"
      class="w-full rounded-md border border-gray-300 p-3 text-sm text-gray-600 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none bg-white"
      rows="3"></textarea>
  </section>

  <div class="h-20"></div>
</div>

@endsection