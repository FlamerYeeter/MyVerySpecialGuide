@extends('layouts.includes')

@section('content')
<div class="font-sans bg-white text-gray-800">

  <!-- HEADER BANNER -->
    <br>
  <section class="bg-green-600 flex flex-col md:flex-row items-center justify-center py-10 text-center md:text-left">
    <img src="/images/target-icon.png" alt="Goals Icon" class="h-24 mx-auto md:mx-8">
    <div>
      <h2 class="text-3xl font-bold text-black">Goals & Progress</h2>
      <p class="text-gray-700">Track your career goals and improve your skill gap step by step</p>
    </div>
  </section>

  <!-- STATS SECTION -->
  <section class="py-10 px-8 grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <div class="border rounded-xl text-center shadow-sm py-8">
      <div class="flex justify-center mb-3">
        <img src="/images/icon-progress.png" alt="" class="h-10">
      </div>
      <h3 class="text-3xl font-bold text-blue-600">1</h3>
      <p class="font-semibold mt-1">In Progress</p>
      <p class="text-xs text-gray-500">(Kasalukuyang ginagawa)</p>
    </div>

    <div class="border rounded-xl text-center shadow-sm py-8">
      <div class="flex justify-center mb-3">
        <img src="/images/icon-completed.png" alt="" class="h-10">
      </div>
      <h3 class="text-3xl font-bold text-green-500">1</h3>
      <p class="font-semibold mt-1">Completed</p>
      <p class="text-xs text-gray-500">(Mga natapos)</p>
    </div>

    <div class="border rounded-xl text-center shadow-sm py-8">
      <div class="flex justify-center mb-3">
        <img src="/images/icon-percentage.png" alt="" class="h-10">
      </div>
      <h3 class="text-3xl font-bold text-blue-500">75%</h3>
      <p class="font-semibold mt-1">Overall Progress</p>
      <p class="text-xs text-gray-500">(Kabuuang Progreso)</p>
    </div>
  </section>

  <!-- CAREER GOALS SECTION -->
  <section class="max-w-5xl mx-auto bg-white border rounded-2xl shadow-md p-8 mb-16">
    <div class="flex items-center space-x-2 mb-6">
      <span class="text-yellow-400 text-xl">⭐</span>
      <h3 class="font-bold text-lg">Your Career Goals</h3>
      <img src="/images/sound-icon.png" class="h-5" alt="Sound">
    </div>

    <!-- GOAL 1 -->
    <div class="border rounded-xl p-6 mb-6">
      <div class="flex justify-between items-start">
        <h4 class="font-semibold text-gray-800">Learn Pet Grooming Techniques</h4>
        <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-medium">In Progress</span>
      </div>
      <p class="text-sm text-gray-600 mt-2">
        Develop expertise in essential pet grooming techniques including cutting, styling, and bathing.
      </p>
      <div class="mt-4">
        <p class="text-sm text-gray-500 mb-1">Progress <span class="text-xs">(Pagbuti ng Kakayahan)</span></p>
        <div class="w-full bg-gray-200 h-2 rounded-full">
          <div class="bg-green-400 h-2 rounded-full w-1/2"></div>
        </div>
        <p class="text-right text-sm text-gray-700 mt-1">50%</p>
      </div>
      <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600">
        View Details
      </button>
      <p class="text-xs text-gray-500 mt-1">(Pindutin ang “View Details” upang makita ang buong impormasyon)</p>
    </div>

    <!-- GOAL 2 -->
    <div class="border rounded-xl p-6">
      <div class="flex justify-between items-start">
        <h4 class="font-semibold text-gray-800">Learn Customer Service Skills</h4>
        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">Completed</span>
      </div>
      <p class="text-sm text-gray-600 mt-2">
        Develop strong communication and customer interaction skills for hospitality and retail environments.
      </p>
      <div class="mt-4">
        <p class="text-sm text-gray-500 mb-1">Progress <span class="text-xs">(Pagbuti ng Kakayahan)</span></p>
        <div class="w-full bg-gray-200 h-2 rounded-full">
          <div class="bg-green-500 h-2 rounded-full w-full"></div>
        </div>
        <p class="text-right text-sm text-gray-700 mt-1">100%</p>
      </div>
      <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600">
        View Details
      </button>
      <p class="text-xs text-gray-500 mt-1">(Pindutin ang “View Details” upang makita ang buong impormasyon)</p>
    </div>
  </section>

</div>
@endsection
