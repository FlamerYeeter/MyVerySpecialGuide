@extends('layouts.includes')

@section('content')

<!--PAAYOS NLANG DIN UNG ITSURA AND BACK END GOIZZZ-->
    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>
  <!-- Saved Jobs Overview -->
  <div class="max-w-4xl mx-auto mt-8 px-4">
    <div class="border border-blue-300 bg-blue-50 rounded-lg p-6 flex items-start space-x-4">
      <div class="bg-green-100 p-3 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2L14.09 8.26L20.97 8.27L15.45 12.14L17.54 18.4L12 14.53L6.46 18.4L8.55 12.14L3.03 8.27L9.91 8.26L12 2Z" />
        </svg>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-blue-600">Your Saved Jobs</h2>
        <p class="text-sm text-gray-600">Jobs you have saved for later review and application</p>
        <div class="mt-3">
          <button class="bg-green-700 text-white px-4 py-1 rounded-md text-sm font-medium">
            2 Saved Jobs
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Job Cards -->
  <div class="max-w-4xl mx-auto mt-8 px-4 space-y-8">

    <!-- Job 1 -->
    <div class="border border-gray-300 rounded-lg p-6 flex justify-between items-start shadow-sm">
      <div>
        <h3 class="font-semibold text-lg">Pet Care Assistant</h3>
        <p class="text-gray-600 text-sm">iPet Club</p>
        <p class="text-gray-500 text-sm mt-1">Taguig City, Metro Manila</p>

        <div class="flex flex-wrap gap-2 mt-2">
          <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">Healthcare</span>
          <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">Quiet</span>
        </div>

        <p class="text-sm text-gray-700 mt-3">Help feed animals, clean spaces, and provide companionship.</p>

        <div class="flex flex-wrap gap-2 mt-3">
          <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Organization</span>
          <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Cleaning</span>
          <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Following Instructions</span>
        </div>

        <div class="flex flex-wrap gap-2 mt-3">
          <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.04 3.18a1 1 0 00.95.69h3.356c.969 0 1.371 1.24.588 1.81l-2.715 1.97a1 1 0 00-.364 1.118l1.04 3.18c.3.921-.755 1.688-1.54 1.118L10 13.348l-2.946 2.145c-.785.57-1.84-.197-1.54-1.118l1.04-3.18a1 1 0 00-.364-1.118L3.475 8.607c-.783-.57-.38-1.81.588-1.81h3.356a1 1 0 00.95-.69l1.04-3.18z" />
            </svg>
            Excellent Fit
          </span>
          <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3v4a1 1 0 001 1h12a1 1 0 001-1V3H3zm0 6v8a1 1 0 001 1h12a1 1 0 001-1V9H3z" />
            </svg>
            High Potential
          </span>
        </div>

        <p class="text-xs text-gray-500 mt-3">4d ago</p>
      </div>

      <div class="flex flex-col items-end space-y-4">
        <img src="/images/ipetclub-logo.png" alt="iPet Club" class="w-20 h-20 object-contain">
        <div class="flex space-x-2">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition">
            View Details
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            Saved
          </button>
        </div>
      </div>
    </div>

    <!-- Job 2 -->
    <div class="border border-gray-300 rounded-lg p-6 flex justify-between items-start shadow-sm">
      <div>
        <h3 class="font-semibold text-lg">Kitchen Helper</h3>
        <p class="text-gray-600 text-sm">KFC</p>
        <p class="text-gray-500 text-sm mt-1">Makati City, Metro Manila</p>

        <div class="flex flex-wrap gap-2 mt-2">
          <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">Hospitality</span>
          <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">Busy</span>
        </div>

        <p class="text-sm text-gray-700 mt-3">Supports the cooks and staff by keeping the kitchen clean and organized.</p>

        <div class="flex flex-wrap gap-2 mt-3">
          <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Organization</span>
          <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Cleaning</span>
          <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-medium">Following Instructions</span>
        </div>

        <div class="flex flex-wrap gap-2 mt-3">
          <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.04 3.18a1 1 0 00.95.69h3.356c.969 0 1.371 1.24.588 1.81l-2.715 1.97a1 1 0 00-.364 1.118l1.04 3.18c.3.921-.755 1.688-1.54 1.118L10 13.348l-2.946 2.145c-.785.57-1.84-.197-1.54-1.118l1.04-3.18a1 1 0 00-.364-1.118L3.475 8.607c-.783-.57-.38-1.81.588-1.81h3.356a1 1 0 00.95-.69l1.04-3.18z" />
            </svg>
            Good Fit
          </span>
          <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3v4a1 1 0 001 1h12a1 1 0 001-1V3H3zm0 6v8a1 1 0 001 1h12a1 1 0 001-1V9H3z" />
            </svg>
            Medium Potential
          </span>
        </div>

        <p class="text-xs text-gray-500 mt-3">23h ago</p>
      </div>

      <div class="flex flex-col items-end space-y-4">
        <img src="/images/kfc-logo.png" alt="KFC" class="w-20 h-20 object-contain">
        <div class="flex space-x-2">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition">
            View Details
          </button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            Saved
          </button>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection