<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Apply Assessment</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 5s ease-in-out infinite; }
    .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
    .animate-float-fast { animation: float 2.5s ease-in-out infinite; }
  </style>
</head>
<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">
  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot"
       class="hidden sm:block fixed left-6 top-1/3 w-28 lg:w-36 opacity-90 animate-float-slow z-0">
  <img src="image/obj7.png" alt="Triangle Mascot"
       class="fixed left-1 sm:left-4 md:left-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-20 md:w-28 opacity-90 animate-float-medium z-0">
  <img src="image/obj3.png" alt="Blue Mascot"
       class="hidden sm:block fixed right-6 top-1/4 w-28 lg:w-36 opacity-90 animate-float-fast z-0">
  <img src="image/obj8.png" alt="Twin Mascot"
       class="hidden sm:block fixed right-6 bottom-24 w-28 lg:w-36 opacity-90 animate-float-medium z-0">

  <!-- Back Button -->
  <button
    class="fixed left-3 top-3 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-2xl flex items-center gap-2 sm:gap-3 text-base sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="window.location.href='{{ route('') }}'">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
      class="w-4 h-4 sm:w-6 sm:h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </button>

  <!-- Main Container -->
  <div class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden mt-20 sm:mt-24 md:mt-28">

    <!-- Title -->
    <h2 class="text-3xl font-bold text-[#E2B100] flex items-center gap-3 mb-8">
      Assessment Details 
      <span>⭐</span>
    </h2>

    <!-- What this is about -->
    <h3 class="text-xl font-bold text-[#1C64F2] mb-2">What this is about</h3>
    <p class="text-gray-800 leading-relaxed mb-8">
      This is your COPM (Canadian Occupational Performance Measure) Assessment.
      It helps us understand what activities are important to you and how confident
      you feel doing them — especially things related to work and independence.
    </p>

    <!-- What you will do -->
    <h3 class="text-xl font-bold text-[#1C64F2] mb-3">What you will do</h3>
    <ul class="list-disc ml-6 space-y-1 text-gray-800 mb-8">
      <li>You'll talk with our therapist about what you do every day — like working, taking care of yourself, or doing hobbies.</li>
      <li>You’ll share which activities are easy for you and which ones are harder.</li>
      <li>There are no right or wrong answers — this is just about you.</li>
    </ul>

    <!-- Time -->
    <h3 class="text-xl font-bold text-[#1C64F2] mb-1 flex items-center gap-2">
      <span>🚀</span> How long it takes:
    </h3>
    <p class="text-gray-800 mb-8">
      About <span class="font-semibold">20–30 minutes.</span>
    </p>

    <!-- Why this is important -->
    <h3 class="text-xl font-bold text-[#1C64F2] mb-2">Why this is important?</h3>
    <p class="text-gray-800 leading-relaxed mb-8">
      Your answers help us understand your skills and find the best way to help you get ready for work.  
      We’ll use this to support your goals and make a plan that’s right for you.
    </p>

    <!-- Apply Button -->
    <form id="applyForm">
      <button type="button" id="applyBtn"
              class="bg-[#7BD5C7] hover:bg-[#68c5b6] transition text-white font-semibold px-8 py-3 rounded-lg mx-auto block">
        Apply for Therapist Assessment
      </button>
    </form>
  </div>

  <!-- ================= THERAPIST ASSESSMENT MODAL ================= -->
  <div id="assessmentModal"
       class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-2xl w-full mx-4 relative">
      <!-- Close Button Top -->
      <button id="closeModalBtn"
              class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-3xl font-bold">&times;</button>

      <!-- Modal Header -->
      <div class="flex items-center gap-3 mb-6">
        <i class="ri-file-text-line text-[#2563EB] text-4xl"></i>
        <h2 class="text-2xl font-bold text-[#1E3A8A]">Notice: Assessment Scheduling</h2>
      </div>

      <!-- Modal Content -->
      <p class="text-lg text-gray-800 font-semibold mb-4">
        Thank you for applying for a job readiness assessment!
      </p>

      <p class="text-gray-700 text-base mb-4 leading-relaxed">
        A <span class="font-semibold text-[#1E3A8A]">licensed therapist</span> will review your request and
        <span class="font-semibold text-[#1E3A8A]">contact you shortly to schedule your assessment.</span>
      </p>

      <p class="text-gray-800 font-semibold mt-6 mb-2">Please note:</p>
      <ul class="list-disc pl-6 text-gray-700 space-y-2 text-base">
        <li>The <span class="font-semibold">assessment must be completed</span> before you can proceed with your <span class="font-semibold">job application</span>.</li>
        <li>You will receive a <span class="font-semibold">notification or email</span> with the date and time of your assessment once it is confirmed.</li>
      </ul>

      <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
        <i class="ri-progress-line text-[#2563EB] text-2xl mt-1"></i>
        <p class="text-gray-700 text-base leading-relaxed">
          You can view the status of your applied assessment anytime on the <span class="font-semibold text-[#1E3A8A]">Assessment Progress</span> page.
        </p>
      </div>

      <div class="mt-6 flex items-center gap-2 text-[#2563EB] italic">
        <i class="ri-calendar-event-line text-xl"></i>
        <span class="text-base">Please keep an eye on your messages or email for further updates.</span>
      </div>

      <!-- Close Button Bottom -->
        <a href="{{ route('') }}" class="block h-full"></a>
      <div class="mt-8 text-right">
        <button id="okModalBtn"
                class="bg-[#2563EB] hover:bg-[#1E40AF] text-white font-bold px-6 py-3 rounded-lg text-lg transition-all">
          Okay, Got It
          
        </button>
      </div>
    </div>
  </div>

  <script>
    const applyBtn = document.getElementById('applyBtn');
    const modal = document.getElementById('assessmentModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const okModalBtn = document.getElementById('okModalBtn');

    // Show modal when Apply button is clicked
    applyBtn.addEventListener('click', () => {
      modal.classList.remove('hidden');
    });

    // Close modal
    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    okModalBtn.addEventListener('click', () => modal.classList.add('hidden'));

    // Close modal when clicking outside content
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.add('hidden');
    });
  </script>

</body>
</html>
  