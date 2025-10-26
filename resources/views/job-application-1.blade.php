@extends('layouts.includes')

@section('content')


<!-- Back Button -->
<div class="bg-yellow-400 mt-6 py-8">
  <div class="max-w-5xl mx-auto px-6">
    <a href="/job-details" class="flex items-center space-x-3 text-blue-900 text-3xl font-semibold hover:underline w-fit">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="2.5" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back</span>
    </a>
  </div>
</div>



  <!-- Job Info Card -->
  <section class="max-w-5xl mx-auto mt-8 px-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Applying for</h2>
    @php
        // reuse job-details CSV parsing to show the selected job on the application page
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

  <!-- Application Form -->
  <section class="max-w-5xl mx-auto mt-8 px-4 mb-16">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Job Application</h2>
    <p class="text-sm text-gray-600 mb-6">
      Fill out the form below to apply for this position. All required fields are marked with an asterisk (<span class="text-red-500">*</span>).
    </p>

    <form id="jobApplicationForm" class="space-y-8">
      @csrf
      <input type="hidden" id="user_id" value="user1234">

      <!-- Personal Information -->
      <div class="border-t pt-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
            <input type="text" id="first_name" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
            <input type="text" id="last_name" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
            <input type="email" id="email" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
            <input type="tel" id="phone_number" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Complete Address <span class="text-red-500">*</span></label>
            <textarea id="address" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
            <input type="date" id="date_of_birth" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Gender</label>
            <select id="gender" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
              <option></option>
              <option>Male</option>
              <option>Female</option>
              <option>Prefer not to say</option>
            </select>
          </div>
        </div>
      </div>
<br>
      <!-- Work Experience -->
      <div class="border-t pt-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Work Experience</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Job Title</label>
            <input type="text" id="job_title" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Company/Employer</label>
            <input type="text" id="company_employer" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" id="start_date" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" id="end_date" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Job Description</label>
            <textarea id="job_description" class="w-full border rounded-lg px-3 py-2 focus:ring-blue-300 focus:border-blue-400" placeholder="Describe your responsibilities, skills, and achievements"></textarea>
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

    {{-- Replaced the previous module-based script with a plain script that always runs --}}
    <script>
		(function () {
			// Helper: safely read request('job_id') from blade into JS
			const jobId = "{{ request('job_id') ?? '' }}";

			// attach handler when DOM is ready
			document.addEventListener('DOMContentLoaded', function () {
				const form = document.getElementById('jobApplicationForm');
				if (!form) return;

				form.addEventListener('submit', function (e) {
					e.preventDefault(); // stop default POST that adds _token to URL

					// collect form values (keep in sync with your inputs)
					const data = {
						user_id: document.getElementById('user_id') ? document.getElementById('user_id').value : 'user1234',
						first_name: (document.getElementById('first_name') || {}).value || '',
						last_name: (document.getElementById('last_name') || {}).value || '',
						email: (document.getElementById('email') || {}).value || '',
						phone_number: (document.getElementById('phone_number') || {}).value || '',
						address: (document.getElementById('address') || {}).value || '',
						date_of_birth: (document.getElementById('date_of_birth') || {}).value || '',
						gender: (document.getElementById('gender') || {}).value || '',
						job_title: (document.getElementById('job_title') || {}).value || '',
						company_employer: (document.getElementById('company_employer') || {}).value || '',
						start_date: (document.getElementById('start_date') || {}).value || '',
						end_date: (document.getElementById('end_date') || {}).value || '',
						job_description: (document.getElementById('job_description') || {}).value || ''
					};

        // Save to sessionStorage and localStorage so page 2 / review pages can access it
        try {
          const json = JSON.stringify(data);
          sessionStorage.setItem('jobApplication_step1', json);
          localStorage.setItem('jobApplication_step1', json);
        } catch (err) {
          // storage may be disabled; ignore but still redirect
          console.warn('storage not available', err);
        }

					// Build next URL and redirect to Job Application 2 with job_id preserved
					const base = "{{ route('job.application.2') }}";
					const nextUrl = jobId ? base + '?job_id=' + encodeURIComponent(jobId) : base;
					window.location.href = nextUrl;
				});
			});
		})();
	</script>

<!-- Ensure global Firebase config is present and autofill profile for signed-in users -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
<script type="module">
  import { getUserProfile, isSignedIn } from "{{ asset('js/job-application-firebase.js') }}";

  (async function(){
    try {
      console.debug('job-application-1: waiting for auth resolution (7s)');
      const signed = await isSignedIn(7000);
      console.debug('job-application-1: isSignedIn ->', signed);
      if (!signed) {
        // Not signed in — redirect to login preserving return URL
        const current = window.location.pathname + window.location.search;
        window.location.href = 'login?redirect=' + encodeURIComponent(current);
        return;
      }
      const profile = await getUserProfile();
      if (profile) {
        if (profile.first_name) document.getElementById('first_name').value = profile.first_name;
        if (profile.last_name) document.getElementById('last_name').value = profile.last_name;
        if (profile.email) document.getElementById('email').value = profile.email;
        if (profile.phone) document.getElementById('phone_number').value = profile.phone;
        if (profile.address) document.getElementById('address').value = profile.address;
      }
    } catch (err) {
      console.warn('autofill/profile init failed', err);
    }
    })();
</script>

<!-- Ensure global Firebase config is present and autofill profile for logged-in users -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
<script type="module">
  import { getUserProfile, isSignedIn } from "{{ asset('js/job-application-firebase.js') }}";

  async function autofillProfile() {
    try {
      const profile = await getUserProfile();
      if (!profile) return;
      const personal = profile.personalInfo || {};
      const school = profile.schoolWorkInfo || {};
      const guardian = profile.guardianInfo || {};
      const skills = profile.skills || {};
      const work = profile.workExperience || {};

      if (personal.first) document.getElementById('first_name').value = personal.first;
      if (personal.last) document.getElementById('last_name').value = personal.last;
      if (personal.email) document.getElementById('email').value = personal.email;
      if (guardian.guardian_phone) document.getElementById('phone_number').value = guardian.guardian_phone;
      if (school.school_name) document.getElementById('address').value = school.school_name;
      try {
        const we = JSON.parse(work.work_experiences || '[]');
        if (we && we.length) {
          const first = we[0];
          if (first.title) document.getElementById('job_title').value = first.title;
          if (first.company) document.getElementById('company_employer').value = first.company;
          if (first.description) document.getElementById('job_description').value = first.description;
        }
      } catch(e) {}
    } catch (err) {
      console.warn('Autofill failed', err);
    }
  }

  (async function(){
    try {
      const signed = await isSignedIn(3000);
      if (!signed) {
        const current = window.location.pathname + window.location.search;
        window.location.href = 'login?redirect=' + encodeURIComponent(current);
        return;
      }
      document.addEventListener('DOMContentLoaded', autofillProfile);
    } catch (err) {
      console.error('Auth check failed', err);
      document.addEventListener('DOMContentLoaded', autofillProfile);
    }
  })();
</script>

@endsection
