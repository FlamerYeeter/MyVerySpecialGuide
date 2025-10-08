@extends('layouts.includes')

@section('content')


  <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/jobs" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back to Job Matches</span>
      </a>
    </div>
  </div>

  <!-- Green Info Box -->
  <div class="bg-green-100 border-l-4 border-green-500 text-green-800 max-w-5xl mx-auto mt-6 p-4 rounded">
    <p class="font-medium">The content shown here gives more detailed information about the job.</p>
    <p class="text-sm text-gray-700">(Ang nakikitang nilalaman dito ay mas detalyadong impormasyon tungkol sa trabaho.)</p>
  </div>

  <!-- Gray Info Box -->
  <div class="border max-w-5xl mx-auto bg-white mt-4 p-4 rounded shadow-sm">
    <p class="text-gray-700 text-sm">
      Click the “Apply” button to go to the application form for this job. <br>
      <span class="italic text-gray-500">(-I-click ang Apply button upang mapunta sa application form para sa trabahong ito.)</span>
    </p>
  </div>

  <!-- Job Details Section -->
  <section class="max-w-5xl mx-auto mt-10 px-4">
    <div class="flex flex-col items-center">
      <img src="/images/ipetclub.png" alt="iPet Club" class="w-40 h-40 object-contain mb-4">

      <div class="flex space-x-4 mb-6">
        <button class="bg-pink-500 text-white px-6 py-2 rounded hover:bg-pink-600 transition">Apply</button>
        <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Saved</button>
      </div>
    </div>

    <!-- Job Info -->
    <div class="bg-white rounded-lg p-6 shadow-sm">
      <h2 class="text-2xl font-bold text-gray-800">Pet Care Assistant</h2>
      <div class="flex items-center text-gray-600 text-sm space-x-3 mt-2">
        <span class="flex items-center space-x-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
          </svg>
          <span>iPet Club</span>
        </span>
        <span class="flex items-center space-x-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657A8 8 0 116.343 5.343a8 8 0 0111.314 11.314z" />
          </svg>
          <span>Taguig City, Metro Manila</span>
        </span>
        <span class="flex items-center space-x-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Part time</span>
        </span>
      </div>

      <div class="mt-5">
        <h3 class="font-semibold text-gray-700">Industry & Work Environment</h3>
        <div class="flex flex-wrap gap-2 mt-2">
          <span class="bg-gray-100 text-xs px-3 py-1 rounded">Healthcare</span>
          <span class="bg-gray-100 text-xs px-3 py-1 rounded">Quiet</span>
        </div>
      </div>

      <div class="mt-5">
        <h3 class="font-semibold text-gray-700">Job Description:</h3>
        <ul class="list-disc list-inside text-gray-700 text-sm mt-2 space-y-1">
          <li>Helps take care of animals by making sure they are safe, clean, and happy.</li>
          <li>Supports the team by feeding pets, keeping their spaces tidy, and giving them attention.</li>
          <li>Helps pets stay healthy and comfortable, while also giving them kindness and companionship.</li>
        </ul>
      </div>

      <div class="mt-5">
        <h3 class="font-semibold text-gray-700">Required Skills</h3>
        <div class="flex flex-wrap gap-2 mt-2">
          <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">Organization</span>
          <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">Cleaning</span>
          <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">Following Instructions</span>
        </div>
      </div>

      <div class="mt-5">
        <h3 class="font-semibold text-gray-700">Job Fit Level & Potential</h3>
        <div class="flex flex-wrap gap-2 mt-2">
          <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded">Excellent Fit</span>
          <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">High Potential</span>
        </div>
      </div>

      <p class="text-xs text-gray-500 mt-4">Posted 4d ago</p>
    </div>
  </section>

</div>


@endsection