@extends('layouts.includes')

@section('content')


    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/job-application-2" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
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
        <a id="edit-step1" href="{{ route('job.application.1') }}" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
      </div>
      <div class="space-y-2 text-sm text-gray-700">
        <p><span class="font-medium text-gray-800">Full Name:</span> <span id="rv_full_name">-</span></p>
        <p><span class="font-medium text-gray-800">Email Address:</span> <span id="rv_email">-</span></p>
        <p><span class="font-medium text-gray-800">Phone Number:</span> <span id="rv_phone">-</span></p>
        <p><span class="font-medium text-gray-800">Date of Birth:</span> <span id="rv_dob">-</span></p>
        <p><span class="font-medium text-gray-800">Gender:</span> <span id="rv_gender">-</span></p>
        <p><span class="font-medium text-gray-800">Address:</span> <span id="rv_address">-</span></p>
      </div>
    </div>

    <!-- Work Experience -->
    <div class="bg-white border rounded-lg p-6 shadow-sm">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Work Experience</h3>
        <a id="edit-step1-2" href="{{ route('job.application.1') }}" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
      </div>
      <div class="border border-blue-100 rounded-lg p-4">
        <p class="font-medium text-gray-800" id="rv_job_title">-</p>
        <p class="text-sm text-gray-700" id="rv_company">-</p>
        <p class="text-xs text-gray-500 mt-1" id="rv_work_dates">-</p>
        <p class="text-sm text-gray-700 mt-2" id="rv_work_desc">-</p>
      </div>
    </div>

    <!-- Next Button -->
    <div class="flex justify-end mt-8">
      <button type="button" id="toReview2" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
        Next
      </button>
    </div>

    <script>
    (function(){
      // load step1 and step2
      const step1 = JSON.parse(sessionStorage.getItem('jobApplication_step1') || '{}');
      const step2 = JSON.parse(sessionStorage.getItem('jobApplication_step2') || '{}');

      // populate personal
      document.getElementById('rv_full_name').textContent = (step1.first_name || '') + ' ' + (step1.last_name || '');
      document.getElementById('rv_email').textContent = step1.email || '-';
      document.getElementById('rv_phone').textContent = step1.phone_number || '-';
      document.getElementById('rv_dob').textContent = step1.date_of_birth || '-';
      document.getElementById('rv_gender').textContent = step1.gender || '-';
      document.getElementById('rv_address').textContent = step1.address || '-';

      // populate work experience
      document.getElementById('rv_job_title').textContent = step1.job_title || '-';
      document.getElementById('rv_company').textContent = step1.company_employer || '-';
      const sd = step1.start_date || '';
      const ed = step1.end_date || '';
      document.getElementById('rv_work_dates').textContent = sd || ed ? (sd + (ed ? ' - ' + ed : '')) : '-';
      document.getElementById('rv_work_desc').textContent = step1.job_description || '-';

      // Next => Review 2 (preserve job_id)
      document.getElementById('toReview2').addEventListener('click', function(){
        const jobId = "{{ request('job_id') }}";
        const base = "{{ route('job.application.review2') }}";
        const nextUrl = jobId ? base + '?job_id=' + encodeURIComponent(jobId) : base;
        window.location.href = nextUrl;
      });

      // Edit links: ensure they include job_id if present
      const jobId = "{{ request('job_id') }}";
      if (jobId) {
        const edit1 = document.getElementById('edit-step1');
        const edit1b = document.getElementById('edit-step1-2');
        if (edit1) edit1.href = "{{ route('job.application.1') }}" + '?job_id=' + encodeURIComponent(jobId);
        if (edit1b) edit1b.href = "{{ route('job.application.1') }}" + '?job_id=' + encodeURIComponent(jobId);
      }
    })();
    </script>
  </section>

</div>

@endsection