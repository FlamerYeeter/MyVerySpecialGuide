@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
            <div class="flex items-center space-x-2">
                <img src="image/logo.png" alt="Logo" class="w-16 h-16 object-contain">
                <h1 class="text-2xl font-bold text-blue-700">MyVerySpecialGuide</h1>
            </div>
            <nav class="mt-3 md:mt-0 space-x-3">
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Job Matches</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Goals & Progress</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Why This Job & How to Get There</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Guardian Review</button>
            </nav>
            <div class="relative mt-3 md:mt-0">
                <button class="border px-3 py-1 rounded-full text-sm">Profile ▾</button>
            </div>
        </div>
    </header>

    <!-- Info -->
    <div class="text-center mt-3 text-sm underline text-gray-600">
        <a href="#" class="hover:text-blue-600 font-medium">Click to know about the navigation buttons above</a>
        <p class="italic text-xs">(pindutin upang malaman ang tungkol sa navigation buttons sa taas)</p>
    </div>

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

  <!-- Job Info -->
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

  <!-- Job Application -->
  <section class="max-w-5xl mx-auto mt-8 px-4 mb-16">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Job Application</h2>
    <p class="text-sm text-gray-600 mb-6">
      Fill out the form below to apply for this position. All required fields are marked with an asterisk (<span class="text-red-500">*</span>).
    </p>

    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-8">

      <!-- Education -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Education</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Highest Educational Attainment <span class="text-red-500">*</span></label>
            <select class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
              <option>Select</option>
              <option>High School Graduate</option>
              <option>Vocational/Technical</option>
              <option>College Undergraduate</option>
              <option>College Graduate</option>
              <option>Post-Graduate</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">School Name</label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Course/Program (if applicable)</label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Year Graduated</label>
            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
        </div>
      </div>

      <!-- Skills & Certifications -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Skills & Certifications</h3>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Relevant Skills</label>
            <textarea class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400"
              placeholder="List skills relevant to this job (e.g. animal care, cleaning, customer service)"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Certifications</label>
            <textarea class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400"
              placeholder="List any certifications, training programs, you've completed (e.g. Pet First Aid and CPR Certification – American Red Cross, 2023)"></textarea>
          </div>
        </div>
      </div>

      <!-- Required Documents -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Required Documents</h3>
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Resume/CV <span class="text-red-500">*</span></label>
          <label class="w-full border-2 border-dashed rounded-lg flex flex-col items-center justify-center py-10 cursor-pointer hover:bg-gray-100 transition">
            <svg class="w-8 h-8 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0l-4 4m4-4l4 4m5 4v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2" />
            </svg>
            <p class="text-gray-600 text-sm">Click to upload your resume</p>
            <p class="text-xs text-gray-400">PDF, DOC, or DOCX (Max 5MB)</p>
            <input type="file" name="resume" class="hidden" accept=".pdf,.doc,.docx">
          </label>
        </div>
      </div>

      <!-- Submit -->
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
          Review & Submit
        </button>
      </div>

    </form>
  </section>

</div>
@endsection
