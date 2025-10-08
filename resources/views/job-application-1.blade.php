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
        <span>Back to Job Details</span>
      </a>
    </div>
  </div>

  <!-- Job Info Card -->
  <section class="max-w-5xl mx-auto mt-8 px-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Applying for</h2>
    <div class="border-2 border-blue-200 bg-white rounded-lg p-4 flex items-center space-x-4 shadow-sm">
      <img src="/images/ipetclub.png" alt="iPet Club" class="w-20 h-20 object-contain">
      <div>
        <h3 class="text-xl font-semibold text-gray-800">[[Placeholder Job Title]]</h3>
        <p class="text-sm text-gray-700">[[Placeholder Name of Company]]</p>
        <p class="text-sm text-gray-500">[[Address]]</p>
        <p class="text-sm text-gray-500">[[Part time or Full Time]]</p>
      </div>
    </div>
  </section>

  <!-- Application Form -->
  <section class="max-w-5xl mx-auto mt-8 px-4 mb-16">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Job Application</h2>
    <p class="text-sm text-gray-600 mb-6">
      Fill out the form below to apply for this position. All required fields are marked with an asterisk (<span class="text-red-500">*</span>).
    </p>

    <form action="#" method="POST" class="space-y-8">

      <!-- Personal Information -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Personal Information</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
            <input type="email" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
            <input type="tel" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Complete Address <span class="text-red-500">*</span></label>
            <textarea class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
            <input type="date" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Gender</label>
            <select class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
              <option>Select</option>
              <option>Male</option>
              <option>Female</option>
              <option>Prefer not to say</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Work Experience -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Work Experience</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Job Title</label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Company/Employer</label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Job Description</label>
            <textarea class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400" placeholder="Describe your responsibilities, skills, and achievements"></textarea>
          </div>
        </div>
        <div class="flex justify-center">
            <button type="button" class="mt-3 text-sm text-gray-600 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">
                + Add Another Work Experience
            </button>
        </div>
      </div>

      <!-- Continue Button -->
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
          Continue
        </button>
      </div>

    </form>
  </section>

</div>
@endsection
