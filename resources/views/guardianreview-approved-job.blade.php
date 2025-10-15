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
  </section>


  <!-- Tabs -->
  <div class="flex justify-center mt-6 space-x-2 text-sm font-medium">
    <button class="px-4 py-2 rounded-md hover:bg-gray-100">Pending Review</button>
    <button class="bg-gray-200 px-4 py-2 rounded-md">Approved Job</button>
    <button class="px-4 py-2 rounded-md hover:bg-gray-100">Flagged Job</button>
  </div>

  <!-- Pending Review -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    <h3 class="text-lg font-bold text-green-600 mb-4">Approved Job: 1</h3>

    <!-- Job Card -->
    <div class="border-2 border-green-400 rounded-2xl p-6 bg-green-50/20 shadow-sm">
      <div class="flex justify-between items-start">
        <div class="flex items-center space-x-2">
          <img src="/images/job-icon.png" class="w-6 h-6" alt="Job Icon">
          <h4 class="text-lg font-semibold">Kitchen Helper</h4>
        </div>
        <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
          Approved
        </span>
      </div>

      <!-- Match Percentage -->
      <div class="mt-4">
        <span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">
          90% Match
        </span>
      </div>

      <!-- Job Info -->
      <div class="grid grid-cols-3 gap-4 mt-4 text-sm">
        <div class="bg-gray-100 p-2 rounded-md">
          <span class="font-semibold">Company Name:</span> KFC
        </div>
        <div class="bg-gray-100 p-2 rounded-md">
          <span class="font-semibold">Location:</span> Taguig City
        </div>
        <div class="bg-gray-100 p-2 rounded-md">
          <span class="font-semibold">Hours:</span> Part-time
        </div>
      </div>

      <!-- Why This Job Matches -->
      <div class="bg-gray-100 rounded-lg mt-6 p-4">
        <div class="flex items-center space-x-2 mb-2">
          <img src="/images/lightbulb-icon.png" class="w-5 h-5" alt="Idea Icon">
          <h5 class="font-semibold text-gray-800">Why this Job Matches</h5>
        </div>
        <ul class="list-disc pl-5 text-sm space-y-1">
          <li>Hands-On Work Skills</li>
          <li>Structured Routines</li>
          <li>Team Environment</li>
        </ul>
      </div>

      <!-- Feedback Section -->
      <div class="bg-blue-100 rounded-lg mt-6 p-4">
        <div class="flex items-center space-x-2 mb-2">
          <img src="/images/feedback-icon.png" class="w-5 h-5" alt="Feedback Icon">
          <h5 class="font-semibold text-gray-800">Your Feedback</h5>
        </div>
        <textarea
          class="w-full rounded-md border border-gray-300 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
          placeholder="Share your thoughts about this job suggestion"
          rows="3">[Placeholder Text to be Integrated]</textarea>
        <div class="flex items-center space-x-2 mb-2">
          <h6 class="font-semibold text-gray-500 text-xs italic">— Submitted by [Name] on [Date]</h6>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-start space-x-3 mt-6">
        <button class="bg-blue-500 text-white px-5 py-2 rounded-md text-sm hover:bg-blue-600 transition">
          View Details
        </button>
        <button class="bg-green-600 text-white px-5 py-2 rounded-md text-sm hover:bg-green-700 transition">
          Edit Feedback
        </button>
        <button class="bg-red-500 text-white px-5 py-2 rounded-md text-sm hover:bg-yellow-600 transition">
          Remove Approval
        </button>
      </div>
    </div>
  </div>
</div>
<br>
@endsection