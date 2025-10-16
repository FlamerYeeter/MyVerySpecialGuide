<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Education</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Floating animation */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 5s ease-in-out infinite; }
    .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
    .animate-float-fast { animation: float 2.5s ease-in-out infinite; }

    /* Selected education card styling */
    .education-card.selected {
      border-color: #2563eb;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
      transform: translateY(-5px);
    }
  </style>
</head>

<body class="bg-white flex justify-center items-center min-h-screen p-6 relative overflow-auto">

  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot" class="fixed left-4 top-1/3 w-24 sm:w-28 opacity-80 animate-float-slow z-0">
  <img src="image/obj7.png" alt="Triangle Mascot" class="fixed left-4 bottom-24 w-24 sm:w-28 opacity-80 animate-float-medium z-0">
  <img src="image/obj3.png" alt="Blue Mascot" class="fixed right-4 top-1/4 w-24 sm:w-28 opacity-80 animate-float-fast z-0">
  <img src="image/obj8.png" alt="Twin Mascot" class="fixed right-4 bottom-24 w-24 sm:w-28 opacity-80 animate-float-medium z-0">

     <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-blue-600 text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('registeradminapprove') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

  <!-- Main Container -->
  <div class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

    <!-- Header -->
    <div class="text-center mt-4">
      <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Create an Account</h1>
      <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-32 md:w-36 mb-6">
      <h2 class="text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-3 flex-wrap">
        Continue setting up your account
        <button class="text-2xl hover:scale-110 transition-transform">🔊</button>
      </h2>
      <p class="mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
        (Ituloy ang pag-set up ng iyong account)
      </p>         
    </div>
    <!-- Information Note -->
    <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm">
      <div class="flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
        </svg>
        <div>
          <p class="font-medium text-sm sm:text-base">
            Please select your highest education level. This helps us recommend suitable programs, job opportunities, and training that match your background.
          </p>
          <p class="italic text-gray-600 text-[13px] mt-1">
            (Pumili ng iyong pinakamataas na natapos na antas ng edukasyon. Makakatulong ito upang mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay na tumutugma sa iyong kaalaman.)
          </p>
        </div>
      </div>
    </div>
<!-- Education Question -->
<div class="mt-10 text-center sm:text-left px-4">
  <h3 class="text-2xl sm:text-3xl font-bold text-blue-700 mb-3">Education</h3>
  <div class="flex flex-col sm:flex-row items-center sm:items-baseline justify-center sm:justify-start gap-2">
    <p class="text-lg sm:text-xl font-medium text-gray-800">
      What is your highest education?
    </p>
    <button class="text-gray-500 text-2xl hover:scale-110 transition-transform">🔊</button>
  </div>
  <p class="text-gray-600 italic text-sm sm:text-base mt-1">
    (Ano ang pinakamataas mong natapos na grade o taon sa school?)
  </p>
</div>

<!-- Instruction -->
<div class="mt-8 text-center sm:text-left px-4">
  <div class="flex flex-col sm:flex-row items-center sm:items-baseline justify-center sm:justify-start gap-2">
    <p class="text-base sm:text-lg font-medium text-gray-800">
      Choose from the pictures provided and click your answer.
    </p>
    <button class="text-gray-500 text-2xl hover:scale-110 transition-transform">🔊</button>
  </div>
  <p class="text-[13px] sm:text-sm text-gray-600 italic mt-1">
    (Pumili mula sa mga larawan at pindutin ang iyong sagot)
  </p>
</div>
    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 px-4">
      
      <!-- Card 1 -->
      <div class="education-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative education-card
      flex flex-col justify-between" onclick="selectEducationChoice(this, 'Elementary')">
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
        <img src="image/educ1.png" alt="elementary" class="w-full h-48 object-contain rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">Elementary</h3>
      </div>

      <!-- Card 2 -->
      <div class="education-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative education-card
      flex flex-col justify-between" onclick="selectEducationChoice(this, 'Highschool')">
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
        <img src="image/educ3.png" alt="highschool" class="w-full h-48 object-contain rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">Highschool</h3>
      </div>

      <!-- Card 3 -->
      <div class="education-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative education-card
     flex flex-col justify-between" onclick="selectEducationChoice(this, 'College')">
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
        <img src="image/educ2.png" alt="college" class="w-full h-48 object-contain rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">College</h3>
      </div>

      <!-- Card 4 -->
      <div class="education-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative education-card
    flex flex-col justify-between" onclick="selectEducationChoice(this, 'Vocational/Training')">
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
        <img src="image/educ4.png" alt="vocational" class="w-full h-48 object-contain rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">Vocational/Training</h3>
      </div>

      <!-- Other -->
      <div class="education-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative education-card
       flex flex-col justify-between col-span-1 sm:col-span-2 lg:col-span-1" onclick="selectEducationChoice(this, 'other')">
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
        <h3 class="text-blue-600 font-semibold text-center mb-2">Other</h3>
        <p class="text-sm text-center text-gray-700 mt-2">Type your answer inside the box if not in the choices</p>
        <p class="text-xs text-gray-500 italic mt-1 mb-3 text-center">(Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)</p>
        <input id="edu_other_text" type="text" placeholder="Type your answer here" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>
    </div>

    <!-- Next Button -->
    <div class="flex flex-col items-center justify-center mt-12 mb-8 space-y-4">
      <div id="educError" class="text-red-600 text-sm mb-2"></div>
      <button id="educNext" type="button" class="bg-blue-500 text-white text-lg font-semibold px-20 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md"
       onclick="window.location.href='{{ route('registerworkexpinfo') }}'">
        Next →
      </button>
      <p class="text-gray-600 text-sm mt-2 text-center">
        Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
        <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
      </p>
    </div>

  </div>

</body>
</html>


  <script src="{{ asset('js/register.js') }}"></script>
  <!-- Make selectEducationChoice available globally for inline onclick handlers -->
  <script>
    // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_education.blade.php
    function selectEducationChoice(el, value) {
      try {
        document.querySelectorAll('.education-card').forEach(c => c.classList.remove('selected'));
        if (el && el.classList) el.classList.add('selected');
        const hidden = document.getElementById('edu_level');
        if (hidden) hidden.value = value || '';
        if (value === 'other') {
          const other = document.getElementById('edu_other_text');
          if (other) other.focus();
        }
        const err = document.getElementById('educError');
        if (err) err.textContent = '';
      } catch (e) {
        console.error('selectEducationChoice error', e);
      }
    }
  </script>
