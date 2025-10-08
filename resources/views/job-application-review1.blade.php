@extends('layouts.includes')

@section('content')


    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/job-details" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>

  <!-- Applying For -->
  <section class="max-w-5xl mx-auto mt-8 px-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Applying for</h2>
    <div class="border-2 border-blue-200 bg-white rounded-lg p-4 flex items-center space-x-4 shadow-sm">
      <img src="/images/ipetclub.png" alt="iPet Club" class="w-20 h-20 object-contain">
      <div>
        <h3 class="text-xl font-semibold text-gray-800">[[Placeholder Job Title]]</h3>
        <p class="text-sm text-gray-700">[[Placeholder Name of Company]]</p>
        <p class="text-sm text-gray-500">[[Placeholder Address]]</p>
        <p class="text-sm text-gray-500">[[Part-Time or Full Time]]</p>
      </div>
    </div>
  </section>

  <!-- Review Application -->
  <section class="max-w-5xl mx-auto mt-8 px-4 mb-16">
    <h2 class="text-xl font-semibold text-gray-800 mb-1">Review Your Application</h2>
    <p class="text-sm text-gray-600 mb-6">Please review all information carefully before submitting. You can edit any section if needed.</p>

    <!-- Personal Information -->
    <div class="bg-white border rounded-lg p-6 mb-8 shadow-sm">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
        <a href="/job-application" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
      </div>
      <div class="space-y-2 text-sm text-gray-700">
        <p><span class="font-medium text-gray-800">Full Name:</span> Juan Dela Cruz</p>
        <p><span class="font-medium text-gray-800">Email Address:</span> juan.delacruz@gmail.com</p>
        <p><span class="font-medium text-gray-800">Phone Number:</span> +63 917 123 4567</p>
        <p><span class="font-medium text-gray-800">Date of Birth:</span> March 15, 1995</p>
        <p><span class="font-medium text-gray-800">Gender:</span> Male</p>
        <p><span class="font-medium text-gray-800">Address:</span> 123 Sampaguita Street, Barangay San Antonio, Taguig City, Metro Manila 1634</p>
      </div>
    </div>

    <!-- Work Experience -->
    <div class="bg-white border rounded-lg p-6 shadow-sm">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Work Experience</h3>
        <a href="/job-application-step2" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
      </div>
      <div class="border border-blue-100 rounded-lg p-4">
        <p class="font-medium text-gray-800">Pet Sitter</p>
        <p class="text-sm text-gray-700">Pet Pro Services</p>
        <p class="text-xs text-gray-500 mt-1">June 2024 - June 2025</p>
        <p class="text-sm text-gray-700 mt-2">
          Provided pet care services for various clients including feeding, walking, and basic grooming. 
          Developed strong relationships with both pets and owners, ensuring high-quality care and peace of mind.
        </p>
      </div>
    </div>

    <!-- Next Button -->
    <div class="flex justify-end mt-8">
      <button type="button" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
        Next
      </button>
    </div>
  </section>

</div>

@endsection