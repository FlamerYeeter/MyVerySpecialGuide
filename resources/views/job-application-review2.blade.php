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

    <!-- Education (populated from step2) -->
    <div class="bg-white border rounded-lg p-6 mb-8 shadow-sm">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Education</h3>
        <a id="edit-step2" href="{{ route('job.application.2') }}" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
      </div>
      <div class="space-y-2 text-sm text-gray-700">
        <p><span class="font-medium text-gray-800">Highest Education:</span> <span id="rv_education_attainment">-</span></p>
        <p><span class="font-medium text-gray-800">School:</span> <span id="rv_school_name">-</span></p>
        <p><span class="font-medium text-gray-800">Course/Program:</span> <span id="rv_course_program">-</span></p>
        <p><span class="font-medium text-gray-800">Year Graduated:</span> <span id="rv_year_graduated">-</span></p>
      </div>
    </div>

    <!-- Skills & Certifications -->
    <div class="bg-white border rounded-lg p-6 mb-8 shadow-sm">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Skills & Certifications</h3>
        <a id="edit-step2-skills" href="{{ route('job.application.2') }}" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
      </div>

      <div class="text-sm text-gray-700 space-y-3">
        <div>
          <p class="font-medium text-gray-800 mb-2">Relevant Skills</p>
          <div id="rv_skills" class="flex flex-wrap gap-2"></div>
        </div>

        <div>
          <p class="font-medium text-gray-800 mb-2">Certifications</p>
          <div id="rv_certs" class="text-gray-700"></div>
        </div>
      </div>
    </div>

    <!-- Uploaded Documents -->
    <div class="bg-white border rounded-lg p-6 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Uploaded Documents</h3>
            <a id="edit-step2-docs" href="{{ route('job.application.2') }}" class="text-gray-600 bg-gray-100 px-3 py-1 rounded text-sm hover:bg-gray-200">Edit</a>
        </div>
        <div id="rv_documents" class="bg-green-100 border border-green-300 rounded-lg p-4">
            <p class="text-sm text-gray-500 italic">No documents uploaded yet.</p>
        </div>
    </div>

    <!-- Next Button -->
    <div class="flex justify-end mt-8">
      <button type="button" id="toSubmit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
        Next
      </button>
    </div>

    <script>
  (function(){
    // load step2
    const step2 = JSON.parse(sessionStorage.getItem('jobApplication_step2') || '{}');

    // populate education
    document.getElementById('rv_education_attainment').textContent = step2.education_attainment || '-';
    document.getElementById('rv_school_name').textContent = step2.school_name || '-';
    document.getElementById('rv_course_program').textContent = step2.course_program || '-';
    document.getElementById('rv_year_graduated').textContent = step2.year_graduated || '-';

    // populate skills (as chips)
    const skillsNode = document.getElementById('rv_skills');
    const skillsText = step2.relevant_skills || '';
    if (skillsText.trim()) {
      skillsText.split(',').map(s => s.trim()).filter(Boolean).forEach(s => {
        const span = document.createElement('span');
        span.className = 'bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium';
        span.textContent = s;
        skillsNode.appendChild(span);
      });
    } else {
      skillsNode.textContent = '-';
    }

    // populate certifications (newline)
    const certsNode = document.getElementById('rv_certs');
    certsNode.textContent = step2.certifications || '-';

    // documents (if filename saved in step2)
    const docsNode = document.getElementById('rv_documents');
    if (step2.resume_filename) {
      docsNode.innerHTML = '<p class="text-sm font-medium text-gray-800">' + step2.resume_filename + '</p><p class="text-xs text-gray-600">Uploaded</p>';
    }

    // Edit links include job_id if present
    const jobId = "{{ request('job_id') }}";
    if (jobId) {
      const edit2 = document.getElementById('edit-step2');
      const edit2skills = document.getElementById('edit-step2-skills');
      const edit2docs = document.getElementById('edit-step2-docs');
      if (edit2) edit2.href = "{{ route('job.application.2') }}" + '?job_id=' + encodeURIComponent(jobId);
      if (edit2skills) edit2skills.href = "{{ route('job.application.2') }}" + '?job_id=' + encodeURIComponent(jobId);
      if (edit2docs) edit2docs.href = "{{ route('job.application.2') }}" + '?job_id=' + encodeURIComponent(jobId);
    }

    document.getElementById('toSubmit').addEventListener('click', function(){
      const jobId = "{{ request('job_id') }}";
      const base = "{{ route('job.application.submit') }}";
      const nextUrl = jobId ? base + '?job_id=' + encodeURIComponent(jobId) : base;
      window.location.href = nextUrl;
    });
  })();
</script>
  </section>

</div>
@endsection
