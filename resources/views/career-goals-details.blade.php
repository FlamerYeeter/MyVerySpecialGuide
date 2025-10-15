@extends('layouts.includes')

@section('content')
<div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/job-details" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back to Goals and Progress</span>
      </a>
    </div>
  </div>

  <!-- Career Goal Header -->
  <div class="max-w-5xl mx-auto mt-8 bg-white shadow rounded-lg p-6 border">
    <div class="flex justify-between items-start">
      <div class="flex items-center space-x-3">
        <img src="/images/pet-icon.png" class="w-6 h-6" alt="Pet Icon">
        <h2 class="font-semibold text-lg">Learn Pet Grooming Techniques</h2>
      </div>
      <span class="bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded-full">In Progress</span>
    </div>

    <p class="mt-3 text-gray-600 text-sm">
      Develop expertise in essential pet grooming techniques including cutting, styling, and bathing.
    </p>

    <!-- Progress Bar -->
    <div class="mt-5">
      <div class="flex justify-between text-sm text-gray-500 mb-1">
        <span>Progress</span>
        <span>50%</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-2">
        <div class="bg-green-500 h-2 rounded-full w-1/2"></div>
      </div>
    </div>

    <!-- Dates -->
    <div class="mt-5 flex justify-between bg-gray-50 border rounded-lg p-3 text-sm text-gray-500">
      <p>Created Date: <span class="font-medium text-gray-700">Aug 1, 2025</span></p>
      <p>Target Date: <span class="font-medium text-gray-700">Aug 30, 2025</span></p>
    </div>
  </div>

  <!-- Milestones -->
  <div class="max-w-5xl mx-auto mt-8 p-6 bg-white shadow rounded-lg border">
    <div class="flex items-center space-x-3 mb-5">
      <img src="/images/milestone-icon.png" class="w-6 h-6" alt="">
      <h3 class="text-lg font-semibold">Milestones & Timeline</h3>
    </div>

    <!-- Completed Milestone -->
    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg mb-4 p-4">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">Introduction to Grooming Basics</h4>
        <span class="text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm">Completed</span>
      </div>
      <p class="text-gray-600 text-sm mt-2">
        Learn the proper use of grooming tools, safe pet handling, and brushing.
      </p>
      <p class="text-xs text-gray-500 mt-2">Date Completed: <span class="font-medium">Aug 9, 2025</span></p>
    </div>

    <!-- Completed Milestone -->
    <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg mb-4 p-4">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">Master Bathing & Drying Techniques</h4>
        <span class="text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm">Completed</span>
      </div>
      <p class="text-gray-600 text-sm mt-2">
        Practice bathing methods for different coat types, trimming, and drying safely.
      </p>
      <p class="text-xs text-gray-500 mt-2">Date Completed: <span class="font-medium">Aug 16, 2025</span></p>
    </div>

    <!-- In Progress Milestone -->
    <div class="border-l-4 border-yellow-400 bg-yellow-50 rounded-r-lg mb-4 p-4">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">Cutting, Styling, and Advanced Grooming</h4>
        <span class="text-yellow-700 bg-yellow-100 px-3 py-1 rounded-full text-sm">In Progress</span>
      </div>
      <p class="text-gray-600 text-sm mt-2">
        Master trimming, breed styles, and creative finishes.
      </p>
      <p class="text-xs text-gray-500 mt-2">Date Completed: —</p>
    </div>

    <!-- Pending Milestone -->
    <div class="border-l-4 border-gray-400 bg-gray-50 rounded-r-lg p-4">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">Final Assessment</h4>
        <span class="text-gray-700 bg-gray-200 px-3 py-1 rounded-full text-sm">Pending</span>
      </div>
      <p class="text-gray-600 text-sm mt-2">
        Perform a full grooming session independently and get feedback from mentor.
      </p>
      <p class="text-xs text-gray-500 mt-2">Date Completed: —</p>
    </div>
  </div>

</div>
@endsection
