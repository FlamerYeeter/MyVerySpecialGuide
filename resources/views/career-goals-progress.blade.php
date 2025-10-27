@extends('layouts.includes')

@section('content')

<div class="font-sans bg-white text-gray-800">

  <!-- HEADER BANNER -->
   <!--
    <br>
  <section class="bg-green-600 flex flex-col md:flex-row items-center justify-center py-10 text-center md:text-left">
    <img src="{{ asset('image/targeticon.png') }}" alt="Goals Icon" class="h-24 mx-auto md:mx-8">
    <div>
      <h2 class="text-3xl font-bold text-black">Goals & Progress</h2>
      <p class="text-gray-700">Track your career goals and improve your skill gap step by step</p>
    </div>
  </section>
-->
  <!-- NOTE: THIS IS STILL IN PROGRESS, I'M NOT SURE PANO AANUHIN YAN -->
    <!-- Filter Form -->
    <section class="bg-green-500 py-7 mt-4">
        <div class="container mx-auto px-4">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/targeticon.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-blue-800">Goals & Progress</h2>
                        <p class="text-sm text-gray-600">Track your career goals and improve your skill gap step by step</p>
                    </div>
                </div>
        </div>
    </section>

  <!-- STATS SECTION -->
     <!-- Progress Summary -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6 text-center relative">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-sky-500" title="Play narration">
                🔊
            </button>
            <div class="flex justify-center mb-3">
              <img src="{{ asset('image/progress.png') }}" alt="" class="h-10">
            </div>
            <h3 class="text-3xl font-bold text-sky-500">1</h3>
            <p class="text-gray-600 font-medium">In Progress</p>
            <p class="text-xs text-gray-400">(Kasalukuyang ginagawa)</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center relative">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-sky-500" title="Play narration">
                🔊
            </button>
            <div class="flex justify-center mb-3">
              <img src="{{ asset('image/completed.png') }}" alt="" class="h-10">
            </div>
            <h3 class="text-3xl font-bold text-sky-500">1</h3>
            <p class="text-gray-600 font-medium">Completed</p>
            <p class="text-xs text-gray-400">(Mga natapos)</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center relative">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-sky-500" title="Play narration">
                🔊
            </button>
            <div class="flex justify-center mb-3">
              <img src="{{ asset('image/overall.png') }}" alt="" class="h-10">
            </div>
            <h3 class="text-3xl font-bold text-sky-500">75%</h3>
            <p class="text-gray-600 font-medium">Overall Progress</p>
            <p class="text-xs text-gray-400">(Kabuuang Progreso)</p>
        </div>
    </section>
<br>

    <!-- Career Goals -->
    <section class="max-w-5xl mx-auto mt-8 mb-12 bg-white rounded-lg shadow p-6">
        <div class="flex items-center space-x-2 mb-4">
            <span class="text-lg font-semibold">⭐ Your Career Goals</span>
            <button class="text-gray-500 hover:text-gray-700">
                🔊
            </button>
        </div>

        <!-- Goal 1 -->
        <div class="border rounded-lg p-5 mb-6 relative">
            <div class="flex justify-between items-center">
                <h4 class="font-semibold">Learn Pet Grooming Techniques</h4>
                <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm">In Progress</span>
            </div>
            <p class="text-sm text-gray-600 mt-2">
                Develop expertise in essential pet grooming techniques including cutting, styling, and bathing.
            </p>

            <p class="text-xs text-gray-500 mt-3">Progress (Pagbuti ng Kakayanan)</p>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                <div class="bg-green-400 h-2.5 rounded-full" style="width: 50%"></div>
            </div>
            <p class="text-right text-xs text-gray-500 mt-1">50%</p>

            <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 text-sm">View Details</button>
            <p class="text-xs text-gray-400 mt-1">(Pindutin ang “View Details” upang makita ang buong impormasyon)</p>

            <button class="absolute bottom-3 right-3 text-gray-400 hover:text-sky-500" title="Play narration">
                🔊
            </button>
        </div>

        <!-- Goal 2 -->
        <div class="border rounded-lg p-5 relative">
            <div class="flex justify-between items-center">
                <h4 class="font-semibold">Learn Customer Service Skills</h4>
                <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm">Completed</span>
            </div>
            <p class="text-sm text-gray-600 mt-2">
                Develop strong communication and customer interaction skills for hospitality and retail environments.
            </p>

            <p class="text-xs text-gray-500 mt-3">Progress (Pagbuti ng Kakayanan)</p>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                <div class="bg-green-400 h-2.5 rounded-full" style="width: 100%"></div>
            </div>
            <p class="text-right text-xs text-gray-500 mt-1">100%</p>

            <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 text-sm">View Details</button>
            <p class="text-xs text-gray-400 mt-1">(Pindutin ang “View Details” upang makita ang buong impormasyon)</p>

            <button class="absolute bottom-3 right-3 text-gray-400 hover:text-sky-500" title="Play narration">
                🔊
            </button>
        </div>
    </section>

</div>
@endsection
