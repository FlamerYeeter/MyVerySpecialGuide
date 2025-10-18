@extends('layouts.includes')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    {{-- <header class="bg-white shadow-sm py-4">
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
    </header> --}}

    <!-- Info -->
    {{-- <div class="text-center mt-3 text-sm underline text-gray-600">
        <a href="#" class="hover:text-blue-600 font-medium">Click to know about the navigation buttons above</a>
        <p class="italic text-xs">(pindutin upang malaman ang tungkol sa navigation buttons sa taas)</p>
    </div> --}}

    <!-- Back Button -->
  <div class="bg-yellow-400 mt-6 py-4">
    <div class="max-w-5xl mx-auto px-4 flex items-center space-x-2">
      <a href="/job-application-review2" class="flex items-center space-x-2 text-gray-800 font-medium hover:underline">
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
        <p class="text-sm text-gray-500">[[Address]]</p>
        <p class="text-sm text-gray-500">[[Part time or Full Time]]</p>
      </div>
    </div>
  </section>

  <!-- Submit Application -->
  <section class="max-w-5xl mx-auto mt-8 px-4 mb-16">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Submit Application</h2>

    <!-- Confirmation box -->
    <div class="bg-green-100 border border-green-300 rounded-lg p-6 text-gray-800">
      <h3 class="font-semibold text-green-900 mb-2">Final Confirmation</h3>
      <p class="text-sm text-gray-700 mb-3">
        By submitting this application, you confirm that all information provided is accurate and complete.
      </p>

      <div class="flex items-start space-x-2">
        <input type="checkbox" id="confirmation" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded">
        <label for="confirmation" class="text-xs text-gray-600">
          I confirm that all information provided is accurate and I agree to the
          <a href="#" class="underline text-blue-600">terms and conditions</a>.
        </label>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end mt-8">
      <button id="finalSubmit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition font-medium">
        Submit Application
      </button>
    </div>
  </section>

</div>

<script type="module">
import { submitJobApplication } from '/js/job-application-firebase.js';

document.getElementById('finalSubmit').addEventListener('click', async function() {
    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Submitting...';

    const step1 = JSON.parse(sessionStorage.getItem('jobApplication_step1') || '{}');
    const step2 = JSON.parse(sessionStorage.getItem('jobApplication_step2') || '{}');

    // combine
    const payload = {
      submitted_at: new Date().toISOString(),
      ...step1,
      ...step2,
      job_id: "{{ request('job_id') ?? '' }}",
      source: 'web'
    };

    try {
      await submitJobApplication(payload);
      // clear saved steps
      sessionStorage.removeItem('jobApplication_step1');
      sessionStorage.removeItem('jobApplication_step2');
      // redirect to matches or a confirmation page
      window.location.href = "{{ route('job.matches') }}";
    } catch (err) {
      console.error(err);
      alert('Failed to submit application. Please try again.');
      btn.disabled = false;
      btn.textContent = 'Submit Application';
    }
});
</script>
@endsection
