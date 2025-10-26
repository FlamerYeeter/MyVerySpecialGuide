@extends('layouts.includes')

@section('content')


  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Recommended For You</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-[#F3FAFF]">

  <!-- HEADER NAV -->
  <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-2">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" class="w-8 h-8" alt="logo">
        <h1 class="text-lg font-bold text-[#007BFF]">MyVerySpecialGuide</h1>
      </div>

      <nav class="flex items-center space-x-3">
        <button class="bg-[#007BFF] text-white font-medium px-5 py-2 rounded-md">Jobs</button>
        <button class="border border-[#007BFF] text-[#007BFF] font-medium px-5 py-2 rounded-md">Goals & Progress</button>
        <button class="border border-[#007BFF] text-[#007BFF] font-medium px-5 py-2 rounded-md">Why this Job & How to Get there</button>
        <button class="border border-[#007BFF] text-[#007BFF] font-medium px-5 py-2 rounded-md">Guardian Review</button>
      </nav>

      <div>
        <button class="border border-gray-300 px-4 py-2 rounded-md">Profile ▾</button>
      </div>
    </div>
  </header>

  <!-- SUBTEXT -->
  <div class="text-center mt-4 text-sm">
    <a href="#" class="text-[#007BFF] font-medium underline">Click to know about the navigation bar</a>
    <p class="text-gray-500 text-xs">(pindutin upang malaman ang tungkol sa navigation bar)</p>
  </div>

  <!-- JOB RECOMMENDED HEADER -->
  <section class="bg-yellow-400 py-10 mt-4">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('job.matches') }}">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/logo.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Job Recommended For You</h2>
                        <p class="text-sm text-gray-600 italic">(Mga Trabahong Para sa Iyo)</p>
                    </div>
                </div>
            </form>
        </div>
    </section>

  <!-- FILTER -->
  <section class="max-w-6xl mx-auto mt-8 px-6">
    <h3 class="text-lg font-semibold mb-3">Filter</h3>

    <div class="flex flex-wrap gap-3 mb-3">
      <button class="border border-gray-300 px-5 py-2 rounded-md hover:border-blue-400">Industry ▾</button>
      <button class="border border-gray-300 px-5 py-2 rounded-md hover:border-blue-400">Job Fit Level ▾</button>
      <button class="border border-gray-300 px-5 py-2 rounded-md hover:border-blue-400">Growth Potential ▾</button>
      <button class="border border-gray-300 px-5 py-2 rounded-md hover:border-blue-400">Work Environment ▾</button>
    </div>

    <p class="text-sm text-gray-600">
      Click the dropdown arrow above, look at the list, and choose the option you want, the system will show jobs that match what you picked.
    </p>
    <p class="text-xs text-gray-500 italic">(I-click ang dropdown arrow sa itaas, tingnan ang listahan, at piliin ang gusto mong option...)</p>
  </section>

  <!-- JOB MATCH SECTION -->
  <section class="max-w-6xl mx-auto mt-10 bg-[#DFF7F5] rounded-md p-6">
    <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
      💡 Jobs Matched to Your Skills & Preferences
    </h4>
    <p class="text-sm italic text-gray-600">(Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan)</p>

    <div class="mt-4">
      <button class="bg-[#00BFA6] text-white font-medium px-6 py-2 rounded-md">All Matches (2)</button>
    </div>
  </section>

  <!-- JOB INFO -->
  <section class="max-w-6xl mx-auto mt-10 px-6">
    <div class="bg-white p-4 border border-gray-300 rounded-md mb-5">
      <p class="text-sm">Click the <a href="#" class="text-[#007BFF] underline">“View Details”</a> button to view more information about the Job.</p>
      <p class="text-xs text-gray-500 italic">(Pindutin ang button na “View Details” para makita ang karagdagang impormasyon...)</p>
    </div>

    <div class="bg-white p-4 border border-gray-300 rounded-md mb-8">
      <a href="#" class="text-[#007BFF] font-medium underline">Saved Jobs</a>
      <p class="text-sm">Click the “Save” button on any job listing to keep it for later.</p>
      <p class="text-xs text-gray-500 italic">(I-click ang “Save” button sa anumang job listing upang mai-save ito...)</p>
    </div>
  </section>

  <!-- JOB CARDS -->
  <section class="max-w-6xl mx-auto px-6 space-y-8 mb-20">

    <!-- JOB CARD 1 -->
    <div class="bg-white border border-gray-300 rounded-xl p-6 flex justify-between items-center">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">Pet Care Assistant</h3>
        <p class="text-gray-600">iPet Club</p>
        <p class="text-sm text-gray-500 mb-2">Taguig City, Metro Manila</p>
        <div class="flex gap-2 text-xs text-gray-700 mb-3">
          <span class="bg-gray-100 px-3 py-1 rounded-md">Healthcare</span>
          <span class="bg-gray-100 px-3 py-1 rounded-md">Quiet</span>
        </div>
        <p class="text-sm text-gray-700">Help feed animals, clean spaces, and provide companionship.</p>

        <div class="flex gap-2 mt-3 text-xs">
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Organization</span>
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Cleaning</span>
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Following Instructions</span>
        </div>

        <div class="flex gap-2 mt-3 text-xs">
          <span class="bg-[#D1FFD6] text-green-800 px-3 py-1 rounded-md">⭐ Excellent Fit</span>
          <span class="bg-[#E6E9FF] text-[#4F46E5] px-3 py-1 rounded-md">📈 High Potential</span>
        </div>

        <p class="text-xs text-gray-500 mt-3">4d ago</p>
      </div>

      <div class="flex flex-col items-end space-y-3">
        <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" class="w-16 h-16" alt="iPet logo">
        <div class="flex gap-2">
          <button class="bg-[#007BFF] text-white px-4 py-2 rounded-md text-sm">View Details</button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm">Saved</button>
        </div>
      </div>
    </div>

    <!-- JOB CARD 2 -->
    <div class="bg-white border border-gray-300 rounded-xl p-6 flex justify-between items-center">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">Kitchen Helper</h3>
        <p class="text-gray-600">KFC</p>
        <p class="text-sm text-gray-500 mb-2">Makati City, Metro Manila</p>
        <div class="flex gap-2 text-xs text-gray-700 mb-3">
          <span class="bg-gray-100 px-3 py-1 rounded-md">Hospitality</span>
          <span class="bg-gray-100 px-3 py-1 rounded-md">Busy</span>
        </div>
        <p class="text-sm text-gray-700">Supports the cooks and staff by keeping the kitchen clean and organized.</p>

        <div class="flex gap-2 mt-3 text-xs">
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Organization</span>
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Cleaning</span>
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Following Instructions</span>
        </div>

        <div class="flex gap-2 mt-3 text-xs">
          <span class="bg-[#D1FFD6] text-green-800 px-3 py-1 rounded-md">⭐ Good Fit</span>
          <span class="bg-[#E6E9FF] text-[#4F46E5] px-3 py-1 rounded-md">📈 Medium Potential</span>
        </div>

        <p class="text-xs text-gray-500 mt-3">23h ago</p>
      </div>

      <div class="flex flex-col items-end space-y-3">
        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/b/bf/KFC_logo.svg/800px-KFC_logo.svg.png" class="w-16 h-16" alt="KFC logo">
        <div class="flex gap-2">
          <button class="bg-[#007BFF] text-white px-4 py-2 rounded-md text-sm">View Details</button>
          <button class="bg-[#A3E635] text-white px-4 py-2 rounded-md text-sm">Save</button>
        </div>
      </div>
    </div>

  </section>

</body>
</html>



@endsection