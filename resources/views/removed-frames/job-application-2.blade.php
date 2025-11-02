@extends('layouts.includes')

@section('content')


<!-- Back Button -->
<div class="bg-yellow-400 mt-6 py-8 px-6">
  <a href="/job-details" class="flex items-center space-x-3 text-blue-900 text-3xl font-semibold hover:underline">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span>Back</span>
  </a>
</div>

  <section class="max-w-5xl mx-auto mt-8 px-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Applying for</h2>
    @php
  $csv_path = public_path('postings.csv');
        $job = null;
        $job_id = request('job_id');
        if ($job_id !== null && file_exists($csv_path)) {
        if (($handle = fopen($csv_path, 'r')) !== false) {
        $header = fgetcsv($handle);
        if ($header === false) { fclose($handle); }
        $cols = array_map(function($h){ return trim($h); }, $header ?: []);
        $numCols = count($cols);
        $i = 0;
        $maxRows = 5000;
        while (($row = fgetcsv($handle)) !== false) {
          if ($numCols > 0) {
            if (count($row) < $numCols) $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
            elseif (count($row) > $numCols) $row = array_slice($row, 0, $numCols);
            if (count($row) !== $numCols) { $i++; continue; }
          }
          if ($i >= $maxRows) break;
          if ($i == intval($job_id)) {
            $assoc = $numCols ? (array_combine($cols, $row) ?: []) : [];
                        $job = [
                            'title' => $assoc['Title'] ?? $assoc['jobpost'] ?? '',
                            'company' => $assoc['Company'] ?? '',
                            'location' => $assoc['Location'] ?? '',
                            'job_description' => $assoc['JobDescription'] ?? $assoc['JobRequirment'] ?? '',
                        ];
                        break;
                    }
                    $i++;
                }
                fclose($handle);
            }
        }
    @endphp
    <div class="border-2 border-blue-200 bg-white rounded-lg p-4 flex items-center space-x-4 shadow-sm">
      <img src="/images/ipetclub.png" alt="Job" class="w-20 h-20 object-contain">
      <div>
        <h3 class="text-xl font-semibold text-gray-800">{{ $job['title'] ?? 'Job Title' }}</h3>
        <p class="text-sm text-gray-700">{{ $job['company'] ?? '' }}</p>
        <p class="text-sm text-gray-500">{{ $job['location'] ?? '' }}</p>
        <p class="text-sm text-gray-500">{{ Str::limit($job['job_description'] ?? '', 180) }}</p>
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
        <h3 class="font-semibold text-xl text-gray-800 mb-4">Education</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Highest Educational Attainment <span class="text-red-500">*</span></label>
            <select id="education_attainment" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
              <option></option>
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
        <h3 class="font-semibold text-xl text-gray-800 mb-4">Skills & Certifications</h3>
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
        <h3 class="font-semibold text-xl text-gray-800 mb-4">Required Documents</h3>
        <!-- Upload Box -->
        <div class="mb-8">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Resume/CV <span class="text-red-500">*</span>
          </label>

      <!-- Clickable Upload Area (the input sits on top, invisible) -->
      <div
        id="uploadBox"
        class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition flex flex-col items-center justify-center bg-white"
        aria-hidden="false"
      >
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4-4l-4 4m0 0l4 4m-4-4h12" />
        </svg>

        <p class="text-gray-600 font-medium">Click to upload your resume</p>
        <p class="text-xs text-gray-400 mt-1">PDF, DOC, or DOCX (Max 5MB)</p>

        <!-- Invisible file input placed absolutely so clicks hit it -->
        <input
          id="resumeUpload"
          type="file"
          accept=".pdf,.doc,.docx"
          class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
          aria-label="Upload resume"
        />
      </div>

      <!-- File name / error messages -->
      <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
      <p id="fileError" class="text-sm text-red-600 mt-1 hidden"></p>
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
      const json = JSON.stringify(data);
      sessionStorage.setItem('jobApplication_step2', json);
      localStorage.setItem('jobApplication_step2', json);
    } catch (err) {
      console.warn('storage not available', err);
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

<!-- Autofill education/skills from Firestore user profile -->
{{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
<script type="module">
import { getUserProfile, isSignedIn, signInWithServerToken } from "{{ asset('js/job-application-firebase.js') }}";

@auth
  window.__SERVER_AUTH = true;
@else
  window.__SERVER_AUTH = false;
@endauth

async function autofillEducation() {
  try {
    const profile = await getUserProfile();
    if (!profile) return;
    const school = profile.schoolWorkInfo || {};
    const skills = profile.skills || {};
    if (school.school_name) document.getElementById('school_name').value = school.school_name;
    if (school.certs) document.getElementById('certifications').value = school.certs;
    if (skills.skills_page1) {
      // try to parse if stored as JSON string
      try {
        const arr = JSON.parse(skills.skills_page1);
        document.getElementById('relevant_skills').value = Array.isArray(arr) ? arr.join(', ') : skills.skills_page1;
      } catch(e) {
        document.getElementById('relevant_skills').value = skills.skills_page1;
      }
    }
  } catch (err) {
    console.warn('Autofill education failed', err);
  }
}

// Page-level auth guard: redirect to login if not signed in
(async function(){
  try {
    // try to sign-in the client using a server-issued custom token (will be no-op if not available)
    try { await signInWithServerToken("{{ route('firebase.token') }}"); } catch(e) { console.debug('signInWithServerToken failed', e); }
    const signed = await isSignedIn(3000);
    if (!signed) {
      if (window.__SERVER_AUTH) {
        console.info('Auth guard: server session present, not redirecting');
        document.addEventListener('DOMContentLoaded', autofillEducation);
        return;
      }
      const current = window.location.pathname + window.location.search;
      window.location.href = 'login?redirect=' + encodeURIComponent(current);
      return;
    }
    document.addEventListener('DOMContentLoaded', autofillEducation);
  } catch (err) {
    console.error('Auth check failed', err);
    document.addEventListener('DOMContentLoaded', autofillEducation);
  }
})();
</script>
