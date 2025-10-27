@extends('layouts.includes')

@section('content')
<!-- Back Button -->
<div class="bg-green-500 mt-6 py-8 px-6">
  <a href="/job-details" class="flex items-center space-x-3 text-blue-900 text-3xl font-semibold hover:underline">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span>Back to Goals & Progress</span>
  </a>
</div>

  <!-- Career Goal Header -->
  <div class="max-w-5xl mx-auto mt-8 bg-white shadow rounded-lg p-6 border">
    <div class="flex justify-between items-start">
      <div class="flex items-center space-x-3">
        <img src="{{ asset('image/targeticon.png') }}" class="w-6 h-6" alt="Pet Icon">
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
    <!-- Sound Icon -->
      <button class="ml-3 text-blue-600 hover:text-blue-800">
        🔊
      </button>
  </div>

 <!-- Milestones Section -->
  <div class="max-w-5xl mx-auto mt-10">
    <div class="flex items-center space-x-2">
      <img src="{{ asset('image/milestone.png') }}" class="w-6 h-6" alt="icon">
      <h3 class="text-lg font-semibold text-gray-800">Milestones & Timeline</h3>
      <button class="text-blue-600 hover:text-blue-800">🔊</button>
    </div>

    <!-- Completed -->
    <div class="border border-green-400 bg-green-50 p-5 rounded-xl mt-4 relative">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Introduction to Grooming Basics
        </h4>
        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Completed</span>
      </div>
      <p class="text-gray-700 text-sm mt-2">
        Learn the proper use of grooming tools, practice safe pet handling, and build skills through basic bathing and brushing.
      </p>
      <p class="text-sm text-gray-600 mt-2">Date Completed: <strong>Aug 9, 2025</strong></p>
      <button class="absolute bottom-3 right-3 text-blue-600 hover:text-blue-800">🔊</button>
    </div>

    <div class="border border-green-400 bg-green-50 p-5 rounded-xl mt-4 relative">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Master Bathing & Drying Techniques
        </h4>
        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Completed</span>
      </div>
      <p class="text-gray-700 text-sm mt-2">
        Practice proper bathing for different coat types, use various drying methods, and safely perform ear cleaning and nail trimming.
      </p>
      <p class="text-sm text-gray-600 mt-2">Date Completed: <strong>Aug 16, 2025</strong></p>
      <button class="absolute bottom-3 right-3 text-blue-600 hover:text-blue-800">🔊</button>
    </div>

    <!-- In Progress -->
    <div class="border border-yellow-400 bg-yellow-50 p-5 rounded-xl mt-4 relative">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
          </svg>
          Cutting, Styling, and Advanced Grooming
        </h4>
        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">In Progress</span>
      </div>
      <p class="text-gray-700 text-sm mt-2">
        Master scissoring and clipping, practice trims, apply breed styles, refine full-body grooming, and add creative finishes.
      </p>
      <p class="text-sm text-gray-600 mt-2">Date Completed:</p>
      <button class="absolute bottom-3 right-3 text-blue-600 hover:text-blue-800">🔊</button>
    </div>

    <!-- Pending -->
    <div class="border border-gray-300 bg-gray-50 p-5 rounded-xl mt-4 mb-10 relative">
      <div class="flex justify-between items-center">
        <h4 class="font-semibold text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
          </svg>
          Final Assessment
        </h4>
        <span class="bg-gray-300 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full">Pending</span>
      </div>
      <p class="text-gray-700 text-sm mt-2">
        Perform a full grooming session independently and get feedback from trainer/mentor.
      </p>
      <p class="text-sm text-gray-600 mt-2">Date Completed:</p>
      <button class="absolute bottom-3 right-3 text-blue-600 hover:text-blue-800">🔊</button>
    </div>

  </div>

</div>
@endsection
