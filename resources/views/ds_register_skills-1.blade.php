<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta charset="UTF-8">
  <title>Registration: Skills</title>
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

    .skills-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
  </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

  <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-1 sm:left-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-1 sm:left-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-1 sm:right-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-1 sm:right-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">

  <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-blue-600 text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('registerworkplace') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-3 h-3 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug">
                Set Up Your Profile
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
            <h2
                class="text-lg sm:text-2xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-2 flex-wrap">
                Continue setting up your account
                <button class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
            </h2>
            <p
                class="mt-2 text-gray-700 italic text-sm sm:text-base md:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ituloy ang pag-set up ng iyong account)
            </p>
        </div>

               <!-- Information Section -->
        <div
            class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        The skills you select here help us understand what you’re good at and what kind of work you might enjoy or excel in. 
        This will also guide us in finding the right opportunities that fit your strengths.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Ang mga kakayahang iyong pipiliin dito ay makatutulong upang malaman namin kung saan ka magaling 
        at anong klaseng trabaho ang babagay sa iyo. Makakatulong din ito upang mahanap ang mga oportunidad na akma sa iyong lakas.)
                    </p>
                </div>
            </div>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
            <!-- Skills Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class= "text-xl sm:text-3xl font-bold text-blue-700 mb-2">Your Skills</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">
                        What skills do you have? (Select all that apply)
                        <button
                            class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                    </p>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">
                    (Ano ang kakayahan na meron ka? Piliin lahat ng naaangkop na kakayahan na meron ka)
                </p>
            </div>

            <!-- Instruction -->
            <div class="mt-6 text-center sm:text-left px-1 sm:px-4">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="text-xs sm:text-base font-medium text-gray-800">Choose from the pictures provided and
                        click
                        your answer.</p>
                    <button class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-[10px] sm:text-sm text-gray-600 italic mt-1">(Pumili mula sa mga larawan at pindutin ang
                    iyong sagot)</p>
            </div>

         <!-- Cards Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">


          <!-- Card 1 -->
          <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card" data-value="Good at talking to people" onclick="toggleSkills1Choice(this,'Good at talking to people')">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill1.png" alt="talking to people" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Good at talking to people</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Magaling makipag-usap sa tao)</p>
          </div>

          <!-- Card 2 -->
          <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card" data-value="Using Computer" onclick="toggleSkills1Choice(this,'Using Computer')">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill2.png" alt="using computer" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Using Computer</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Paggamit ng computer)</p>
          </div>

          <!-- Card 3 -->
          <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card" data-value="Organizing things" onclick="toggleSkills1Choice(this,'Organizing things')">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill3.png" alt="organize" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Organizing things</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Pag-ayos ng mga bagay)</p>
          </div>

          <!-- Card 4 -->
          <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card" data-value="Working with others" onclick="toggleSkills1Choice(this,'Working with others')">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill4.png" alt="work with others" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Working with others</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Pakikipagtulungan sa iba)</p>
          </div>

          <!-- Card 5 -->
          <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card" data-value="Art and creativity" onclick="toggleSkills1Choice(this,'Art and creativity')">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill5.png" alt="creativity" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Art and creativity</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Sining at pagiging malikhain)</p>
          </div>

          <!-- Card 6 -->
          <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card" data-value="Helping people" onclick="toggleSkills1Choice(this,'Helping people')">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill6.png" alt="help people" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Helping people</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Pagtulong sa kapwa)</p>
          </div>
        </div>

        <input id="skills_page1" type="hidden" value="[]" />

        <div class="w-full flex flex-col justify-center items-center text-center mt-10 mb-8">
            <p class="text-gray-700 font-medium mb-4">
                More options in the next page
            </p>
            
            <div class="flex flex-col items-center justify-center">
                <div id="skills1Error" class="text-red-600 text-sm mb-2"></div>
                <button id="skills1Next" class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
                onclick="window.location.href='{{ route('registerskills2') }}'">
                    Next →
                </button>
                <p class="text-gray-600 text-sm mt-3 max-w-md text-center">
                    Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
                    <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>
        </div>

        <!-- ensure shared register logic is available so the Next button is handled and autofill runs -->
        <script src="{{ asset('js/register.js') }}"></script>

        <!-- existing toggleSkills1Choice + init script relies on register.js being present earlier -->
        <script>
          // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_skills-1.blade.php
          // Toggle handler for multi-select skills on page 1
          function toggleSkills1Choice(el, value) {
            try {
              const hidden = document.getElementById('skills_page1');
              if (!hidden) return;
              let arr = [];
              try { arr = JSON.parse(hidden.value || '[]'); } catch (e) { arr = []; }
              const idx = arr.indexOf(value);
              if (idx === -1) {
                arr.push(value);
                if (el && el.classList) el.classList.add('selected');
              } else {
                arr.splice(idx, 1);
                if (el && el.classList) el.classList.remove('selected');
              }
              hidden.value = JSON.stringify(arr);
              // focus "other" input when selected
              if (value === 'other') {
                const other = document.getElementById('skills1_other_text');
                if (other && arr.indexOf('other') !== -1) other.focus();
              }
              const err = document.getElementById('skills1Error');
              if (err) err.textContent = '';
            } catch (e) {
              console.error('toggleSkills1Choice error', e);
            }
          }

          // On load: pre-select cards based on hidden input (useful for autofill/local drafts)
          document.addEventListener('DOMContentLoaded', function () {
            try {
              const hidden = document.getElementById('skills_page1');
              if (!hidden) return;
              let arr = [];
              try { arr = JSON.parse(hidden.value || '[]'); } catch (e) { arr = []; }
              if (!Array.isArray(arr)) arr = [];
              document.querySelectorAll('.skills-card[data-value]').forEach(c => {
                try {
                  const v = c.getAttribute('data-value');
                  if (v && arr.indexOf(v) !== -1) c.classList.add('selected');
                  else c.classList.remove('selected');
                } catch (e) { /* ignore */ }
              });
              // if 'other' preselected, focus its input
              if (arr.indexOf('other') !== -1) {
                const other = document.getElementById('skills1_other_text');
                if (other) other.focus();
              }
            } catch (e) {
              console.warn('skills_page1 init failed', e);
            }
          });
        </script>
      </div>
    </div>
  </form>
  </div>
<
  </body>
</html>
