<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Work Experience Information</title>
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

    .workyr-card.selected {
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
    onclick="window.location.href='{{ route('registerschoolworkinfo') }}'">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span class="text-base sm:text-lg font-medium">Back</span>
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
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
      </h2>

      <!-- Instruction -->
      <p class="mt-6 text-gray-700 text-[14px] leading-snug flex items-start gap-2">
        Please type your information inside the box. The text with a ⭐ star must be filled in.
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </p>

      <p class="mt-1 text-[13px] text-gray-500 italic border-b-2 border-blue-500 pb-1 w-full">
        (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may ⭐ bituin ay dapat sagutan.)
      </p>
    </div>

    <!-- Work Experience Question -->
    <div class="mt-6 max-w-xl mx-auto">
      <p class="text-base font-medium leading-snug flex items-center gap-1.5">
        <span>If you have worked before, how long did you worked there?</span>
        <button class="text-gray-500 text-lg hover:scale-110 transition-transform">🔊</button>
      </p>
      <p class="mt-1 text-[15px] text-gray-500 italic leading-snug">
        (Kung may karanasan ka sa trabaho, gaano ka katagal nagtrabaho doon?)
      </p>
    </div>

    <div class="flex items-center gap-2 mt-6 max-w-xl mx-auto">
      <p class="font-medium">Choose from the pictures provided and click your answer.</p>
      <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
    </div>
    <p class="mt-2 text-[13px] text-gray-500 italic max-w-xl mx-auto">
      (Pumili mula sa mga larawan at pindutin ang iyong sagot)
    </p>

    <!-- Work years selection (kept) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 max-w-xl mx-auto">
      <!-- Card 1 -->
      <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workyr-card" onclick="selectWorkYearsChoice(this,'lt1')">
        <button
          class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
        <img src="image/workyr1.png" alt="less 1 yr" class="w-full rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">Less than 1 year</h3>
      </div>

      <!-- Card 2 -->
      <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workyr-card" onclick="selectWorkYearsChoice(this,'1-2')">
        <button
          class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
        <img src="image/workyr2.png" alt="1-2 yrs" class="w-full rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">1-2 years</h3>
      </div>

      <!-- Card 3 -->
      <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workyr-card" onclick="selectWorkYearsChoice(this,'gt3')">
        <button
          class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
        <img src="image/workyr3.png" alt="more than 3 yrs" class="w-full rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">More than 3 years</h3>
      </div>

      <!-- Card 4 -->
      <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative workyr-card" onclick="selectWorkYearsChoice(this,'none')">
        <button
          class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
        <img src="image/workyr4.png" alt="no experience" class="w-full rounded-md mb-4">
        <h3 class="text-blue-600 font-semibold text-center">None</h3>
      </div>
    </div>

    <!-- Dynamic Job Experiences list -->
    <div class="mt-8 max-w-xl mx-auto">
      <label class="font-semibold text-sm">Job Experiences</label>
      <p class="text-gray-500 italic text-[13px]">Add one or more previous jobs. Each entry will be saved as an item in your workExperience array in Firestore.</p>

      <!-- Container where job entries will be appended -->
      <div id="job_experiences_container" class="space-y-4 mt-4">
        <!-- The first entry will be rendered by JS on load (or by autofill) -->
      </div>

      <!-- Template for new job entries -->
      <template id="job_exp_template">
        <div class="bg-white p-4 rounded-lg border border-red-400" style="border-width:2px;">
          <div class="flex justify-between items-start gap-2">
            <h4 class="font-semibold">Job Experience</h4>
            <div class="flex items-center gap-2">
              <button type="button" class="remove-job text-red-600 bg-red-100 px-2 py-1 rounded">Remove</button>
            </div>
          </div>
          <div class="mt-3 grid grid-cols-1 gap-3">
            <div>
              <label class="text-sm font-medium">Job Title</label>
              <input class="job_title mt-1 w-full border border-gray-300 rounded-md px-3 py-2" placeholder="e.g. Kitchen Helper" />
            </div>
            <div>
              <label class="text-sm font-medium">Job Description</label>
              <input class="job_description mt-1 w-full border border-gray-300 rounded-md px-3 py-2" placeholder="What you did (e.g. cleaned tables, organized shelves)" />
            </div>
            <div>
              <label class="text-sm font-medium">Company Name</label>
              <input class="company_name mt-1 w-full border border-gray-300 rounded-md px-3 py-2" placeholder="e.g., McDonald's or University of Makati" />
            </div>
          </div>
        </div>
      </template>

      <!-- Hidden JSON storing the job experience array -->
      <input id="work_experiences" type="hidden" value="[]" />
      <!-- Hidden selected work years -->
      <input id="work_years" type="hidden" value="" />

      <!-- Add button -->
      <div class="mt-6 text-center">
        <button id="addJobBtn" type="button" class="bg-blue-500 text-white font-medium px-6 py-2 rounded-md hover:bg-blue-600 transition">
          <span class="text-xl mr-2">➕</span> Add Another Job Experience
        </button>
      </div>
    </div>

    <!-- Next Button -->
    <div class="text-center mt-12">
      <div id="workExpError" class="text-red-600 text-sm mb-2"></div>
      <button id="workExpNext" type="button" class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
        Next →
      </button>
      <p class="text-gray-700 text-sm mt-3">
        Click <span class="text-blue-500 font-medium">“Next”</span> to move to the next page Your Qualifications
      </p>
      <p class="text-gray-500 italic text-[13px]">
        (Pindutin ang “Next” upang lumipat sa susunod na pahina)
      </p>
    </div>

  </div>

  <script>
    // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workexpinfo.blade.php
    function selectWorkYearsChoice(el, value) {
      try {
        document.querySelectorAll('.workyr-card').forEach(c => c.classList.remove('selected'));
        if (el && el.classList) el.classList.add('selected');
        const hidden = document.getElementById('work_years');
        if (hidden) hidden.value = value || '';
        const err = document.getElementById('workExpError');
        if (err) err.textContent = '';
      } catch (e) { console.error('selectWorkYearsChoice error', e); }
    }
  </script>
  <script>
    // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workexpinfo.blade.php
    (function () {
      const container = document.getElementById('job_experiences_container');
      const tpl = document.getElementById('job_exp_template');
      const hidden = document.getElementById('work_experiences');

      function parseHidden() {
        try { return JSON.parse(hidden.value || '[]'); } catch (e) { return []; }
      }
      function writeHidden(arr) {
        try { hidden.value = JSON.stringify(arr || []); } catch (e) { hidden.value = '[]'; }
      }

      function buildEntry(item) {
        const node = tpl.content.firstElementChild.cloneNode(true);
        if (item) {
          node.querySelector('.job_title').value = item.title || '';
          node.querySelector('.job_description').value = item.description || '';
          node.querySelector('.company_name').value = item.company || '';
        }
        // remove handler
        node.querySelector('.remove-job').addEventListener('click', function () {
          node.remove();
          syncHiddenFromUI();
        });
        // update hidden when inputs change
        node.querySelectorAll('input').forEach(inp => {
          inp.addEventListener('input', debounce(syncHiddenFromUI, 150));
        });
        return node;
      }

      function syncHiddenFromUI() {
        const arr = [];
        container.querySelectorAll('> div').forEach(block => {
          const title = block.querySelector('.job_title')?.value?.trim() || '';
          const description = block.querySelector('.job_description')?.value?.trim() || '';
          const company = block.querySelector('.company_name')?.value?.trim() || '';
          // only include if any field present
          if (title || description || company) arr.push({ title, description, company });
        });
        writeHidden(arr);
      }

      function addJob(item) {
        const entry = buildEntry(item || {});
        container.appendChild(entry);
        syncHiddenFromUI();
      }

      function clearAndRenderFromArray(arr) {
        container.innerHTML = '';
        (arr || []).forEach(it => addJob(it));
        if ((arr || []).length === 0) addJob(); // make one empty row by default
      }

      // Simple debounce helper
      function debounce(fn, wait) {
        let t;
        return function () { clearTimeout(t); t = setTimeout(() => fn.apply(this, arguments), wait); };
      }

      // Add button
      document.getElementById('addJobBtn').addEventListener('click', function () { addJob(); });

      // Expose renderer for register.js autofill
      window.renderWorkExperiencesFromArray = function (arr) { clearAndRenderFromArray(Array.isArray(arr) ? arr : []); writeHidden(arr || []); };

      // On load: if hidden has data (from autofill/local draft) render it; otherwise create one empty entry
      document.addEventListener('DOMContentLoaded', function () {
        try {
          const arr = parseHidden();
          if (Array.isArray(arr) && arr.length) clearAndRenderFromArray(arr);
          else addJob();
        } catch (e) {
          console.warn('job experiences init failed', e);
          addJob();
        }
      });
    })();
  </script>
  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
