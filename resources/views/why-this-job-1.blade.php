@extends('layouts.includes')

@section('content')
<div class="font-sans bg-white text-gray-800">

  <!-- HEADER BANNER: NOTE AAYUSIN KO PA MAMAYA -->
    <br>
  <section class="bg-pink-500 flex flex-col md:flex-row items-center justify-center py-10 text-center md:text-left">
    <img src="/images/target-icon.png" alt="Goals Icon" class="h-24 mx-auto md:mx-8">
    <div>
      <h2 class="text-3xl font-bold text-black">Why this Job?</h2>
      <p class="text-gray-700">Discover how your unique skills and interests align with this job role</p>
      <p class="text-gray-700">and learn the step-by-step path to achieve your aspirations</p>
    </div>
  </section>
  
   <!-- Job Roles Section -->
  <section class="max-w-4xl mx-auto mt-10 mb-16 px-4">
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex items-center mb-6 space-x-3">
        <img src="/images/job-icon.png" alt="Job Icon" class="w-8 h-8">
        <h3 class="text-xl font-semibold text-gray-800">Your Matched Job Roles</h3>
        <img src="/images/sound-icon.png" alt="Speaker" class="w-6 h-6 ml-auto">
      </div>

      <!-- Job Card 1 -->
      <div class="bg-white shadow rounded-xl border mb-8">
        <div class="p-6">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-lg">Kitchen Helper</h4>
            <span class="text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full font-medium">Excellent Match</span>
          </div>

          <p class="text-sm mt-2 text-gray-600 font-medium">Match Score</p>
          <div class="w-full bg-gray-200 h-3 rounded-full mt-1">
            <div class="bg-green-400 h-3 rounded-full w-[90%]"></div>
          </div>
          <p class="text-right text-sm font-semibold mt-1">90%</p>

          <!-- Matching Skills -->
          <div class="bg-gray-50 p-4 rounded-lg mt-4">
            <p class="text-sm font-medium text-gray-700 mb-2">Your Matching Skills</p>
            <div class="flex flex-wrap gap-3">
              <span class="bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium">Cleaning</span>
              <span class="bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium">Following Instructions</span>
              <span class="bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium">Working with others</span>
            </div>
          </div>

          <!-- View Details -->
          <div class="mt-4 flex items-center justify-between">
            <button class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 rounded-lg transition">
              View Details
            </button>
            <img src="/images/sound-icon.png" alt="Audio" class="w-6 h-6">
          </div>
          <p class="text-xs text-gray-500 mt-1">
            (Pindutin ang <a href="#" class="text-blue-500 underline">"View Details"</a> upang makita ang buong impormasyon)
          </p>
        </div>
      </div>

      <!-- Job Card 2 -->
      <div class="bg-white shadow rounded-xl border">
        <div class="p-6">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-lg">Pet Care Assistant</h4>
            <span class="text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full font-medium">Great Match</span>
          </div>

          <p class="text-sm mt-2 text-gray-600 font-medium">Match Score</p>
          <div class="w-full bg-gray-200 h-3 rounded-full mt-1">
            <div class="bg-green-400 h-3 rounded-full w-[50%]"></div>
          </div>
          <p class="text-right text-sm font-semibold mt-1">50%</p>

          <!-- Matching Skills -->
          <div class="bg-gray-50 p-4 rounded-lg mt-4">
            <p class="text-sm font-medium text-gray-700 mb-2">Your Matching Skills</p>
            <div class="flex flex-wrap gap-3">
              <span class="bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium">Organization</span>
              <span class="bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium">Following Instructions</span>
            </div>
          </div>

          <!-- View Details -->
          <div class="mt-4 flex items-center justify-between">
            <button class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 rounded-lg transition">
              View Details
            </button>
            <img src="/images/sound-icon.png" alt="Audio" class="w-6 h-6">
          </div>
          <p class="text-xs text-gray-500 mt-1">
            (Pindutin ang <a href="#" class="text-blue-500 underline">"View Details"</a> upang makita ang buong impormasyon)
          </p>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection