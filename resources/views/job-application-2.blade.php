

  <!-- Job Info -->@extends('layouts.includes')

@section('content')


    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/job-application-1" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Back</span>
      </a>
    </div>
  </div>
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

    <form id="jobApplicationForm2" class="space-y-8">

      <!-- Education -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Education</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Highest Educational Attainment <span class="text-red-500">*</span></label>
            <select id="education_attainment" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
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
            <input type="text" id="school_name" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Course/Program (if applicable)</label>
            <input type="text" id="course_program" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Year Graduated</label>
            <input type="text" id="year_graduated" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
        </div>
      </div>

      <!-- Skills & Certifications -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Skills & Certifications</h3>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Relevant Skills</label>
            <textarea id="relevant_skills" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400"
              placeholder="List skills relevant to this job (e.g. animal care, cleaning, customer service)"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Certifications</label>
            <textarea id="certifications" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400"
              placeholder="List any certifications, training programs, you've completed (e.g. Pet First Aid and CPR Certification – American Red Cross, 2023)"></textarea>
          </div>
        </div>
      </div>

      <!-- Required Documents -->
      <div class="border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-4">Required Documents</h3>
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Resume/CV <span class="text-red-500">*</span></label>
          <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" class="w-full">
        </div>
      </div>

      <!-- Submit -->
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
          Review & Submit
        </button>
      </div>

    </form>
    <script>
document.getElementById('jobApplicationForm2').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
      education_attainment: document.getElementById('education_attainment').value,
      school_name: document.getElementById('school_name').value,
      course_program: document.getElementById('course_program').value,
      year_graduated: document.getElementById('year_graduated').value,
      relevant_skills: document.getElementById('relevant_skills').value,
      certifications: document.getElementById('certifications').value,
      // resume file handling can be implemented later
    };

    try {
      sessionStorage.setItem('jobApplication_step2', JSON.stringify(data));
    } catch (err) {
      console.warn('sessionStorage not available', err);
    }

    // preserve job_id when redirecting
    let jobId = "{{ request('job_id') }}";
    let nextUrl = jobId ? "{{ route('job.application.review1') }}?job_id=" + encodeURIComponent(jobId) : "{{ route('job.application.review1') }}";
    window.location.href = nextUrl;
});
</script>
  </section>

</div>
@endsection
