<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: School & Work Information</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Floating animations */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 5s ease-in-out infinite; }
    .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
    .animate-float-fast { animation: float 2.5s ease-in-out infinite; }

    /* visual for selected work-type card */
    .workexp-card.selected {
      border-color: #2563eb;
      box-shadow: 0 8px 20px rgba(37,99,235,0.12);
      transform: translateY(-4px);
    }
  </style>
</head>

<body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot"
    class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0">

  <img src="image/obj7.png" alt="Triangle Mascot"
    class="fixed left-2 sm:left-6 lg:left-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0">

  <img src="image/obj3.png" alt="Blue Mascot"
    class="fixed right-2 sm:right-6 lg:right-8 top-1/4 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-fast z-0">

  <img src="image/obj8.png" alt="Twin Mascot"
    class="fixed right-2 sm:right-6 lg:right-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0">

  <!-- Back Button -->
  <button
    class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center gap-2 hover:bg-blue-600 transition z-10 shadow-md active:scale-95"
    onclick="window.location.href='{{ route('registereducation') }}'">
    Back
  </button>

  <!-- Main Container -->
  <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

    <!-- Header -->
    <div class="text-center mt-8">
      <h1 class="text-2xl font-semibold text-black mb-4">Create An Account</h1>
      <img src="image/obj6.png" alt="Pink Stone Object" class="mx-auto w-24 h-24 mb-4">
    </div>

    <!-- Section Header -->
    <div class="flex flex-col items-start text-left max-w-xl mx-auto">
      <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2">
        Your Qualifications
        <span class="text-gray-600 italic text-base">(Iyong Kwalipikasyon)</span>
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
      </h2>

      <!-- Instruction -->
      <p class="mt-6 text-gray-700 text-[14px] leading-snug flex items-start gap-2">
        Please type your information inside the box. The text with a ⭐ star must be filled in.
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </p>
      
      <p class="mt-1 text-[13px] text-gray-500 italic border-b-2 border-blue-500 pb-1 w-full">
        (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may ⭐ bituin ay dapat sagutan.)
      </p>
    </div>

    <!-- Form -->
    <form class="mt-8 max-w-xl mx-auto">

      <!-- School Name -->
      <div class="max-w-xl mx-auto mt-8 text-left">
        <label class="font-semibold text-sm flex items-center gap-1">
          Name of your school
          <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </label>
        <p class="text-gray-500 italic text-[13px]">Pangalan ng iyong paaralan</p>
        <input id="school_name" type="text" placeholder="School Name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
        <p class="text-gray-500 text-xs mt-2">
          Type your school name (example: <span class="font-semibold">University of Makati</span>).
        </p>
      </div>

      <!-- Certificates and Training -->
      <div class="max-w-xl mx-auto mt-8 text-left">
        <label class="font-semibold text-sm flex items-center gap-1">
          Do you have any certificates or special trainings?
          <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </label>
        <p class="text-gray-500 italic text-[13px]">May mga certificates o special training ka ba?</p>
        <input id="certs" type="text" placeholder="Certificates or Trainings" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
        <p class="text-gray-500 text-xs mt-2">
          Type your certificate or special training you have (example: <span class="font-semibold">
            Food Safety Training, Computer Skills Certificate</span>).
        </p>
      </div>

      <!-- Work Information -->
      <div class="mt-8">
        <h2 class="text-xl font-semibold">Work Experience</h2>

        <div class="mt-4">
          <p class="text-base font-medium leading-snug flex items-center gap-1.5">
            <span>Have worked before?</span>
            <button type="button" class="text-gray-500 text-lg hover:scale-110 transition-transform">🔊</button>
          </p>
          <p class="mt-1 text-[15px] text-gray-500 italic leading-snug">(Nakapagtrabaho ka na dati?)</p>
        </div>
      </div>

      <div class="flex items-center gap-2 mt-8">
        <p class="font-medium">Choose from the pictures provided and click your answer.</p>
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </div>
      <p class="mt-2 text-[13px] text-gray-500 italic">(Pumili mula sa mga larawan at pindutin ang iyong sagot)</p>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

        <!-- Card 1 -->
        <div class="bg-white p-4 rounded-xl shadow h-[380px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workexp-card" onclick="selectWorkTypeChoice(this,'paid')">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
          <img src="image/jobexp1.png" alt="paid job" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Yes, I have had a paid job</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Oo, nagkaroon ako ng trabahong may bayad)</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-4 rounded-xl shadow h-[380px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workexp-card" onclick="selectWorkTypeChoice(this,'volunteer')">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
          <img src="image/jobexp2.png" alt="volunteer job" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Yes, I have done volunteer work</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Oo, nakapag volunteer work ako)</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-4 rounded-xl shadow h-[380px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workexp-card" onclick="selectWorkTypeChoice(this,'internship')">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
          <img src="image/jobexp3.png" alt="internship" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">I have done internship or job training</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Nag internship o job training ako)</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-4 rounded-xl shadow h-[380px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workexp-card" onclick="selectWorkTypeChoice(this,'none')">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
          <img src="image/jobexp4.png" alt="no job experience" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">No, this would be my first time</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Hindi, ito ang magiging unang beses ko)</p>
        </div>
      </div>

      <!-- Hidden input for work type (collected by register.js) -->
      <input id="work_type" type="hidden" value="" />

      <!-- Small inline helper to toggle selection and write the value -->
      <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_school_workinfo.blade.php
        function selectWorkTypeChoice(el, value) {
          try {
            document.querySelectorAll('.workexp-card').forEach(c => c.classList.remove('selected'));
            if (el && el.classList) el.classList.add('selected');
            const hidden = document.getElementById('work_type');
            if (hidden) hidden.value = value || '';
            const err = document.getElementById('schoolError');
            if (err) err.textContent = '';
          } catch (e) { console.error('selectWorkTypeChoice error', e); }
        }
      </script>

      <!-- Next Button -->
      <div class="flex flex-col items-center justify-center mt-12 mb-8 space-y-4">
        <div id="schoolError" class="text-red-600 text-sm mb-2"></div>
        <button id="schoolNext" type="button" class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
          Next →
        </button>
        <p class="text-gray-600 text-sm">
          Click <span class="text-blue-500 font-medium">“Next”</span> to move to the next page Your Qualifications
        </p>
        <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Next” upang lumipat sa susunod na pahina)</p>
      </div>
    </form>
  </div>

  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
