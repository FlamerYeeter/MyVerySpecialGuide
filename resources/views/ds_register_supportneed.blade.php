<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Support Need</title>
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

    /* visual for selected support card */
    .support-card.selected {
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
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('registerworkexpinfo') }}'">
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
                Continue setting up your profile
                <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
            </h2>
            <p
                class="mt-2 text-gray-700 italic text-sm sm:text-base md:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ituloy ang pag-set up ng iyong profile)
            </p>
        </div>

        <!-- Information Note -->
        <div
            class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <div class="flex-1">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        Please share what kind of support would help you at work. This helps us
                        understand your needs and connect you with workplaces that can provide
                        the right guidance or adjustments.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Ibahagi kung anong uri ng tulong ang makakatulong sa iyo sa trabaho.
                        Makakatulong ito upang maunawaan namin ang iyong pangangailangan at
                        maihanap ang mga lugar ng trabaho na kayang magbigay ng tamang gabay o
                        tulong.)
                    </p>
                </div>
            </div>

            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200">
                🔊
            </button>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
            <!-- Support Need Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class= "text-xl sm:text-3xl font-bold text-blue-700 mb-2">Support I Need</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">
                        What kind of support would help you at work? (Select all that apply)
                        <button type="button"
                            class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                    </p>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">
                    (Ano klaseng tulong ang makakatulong sa iyo sa trabaho? Piliin lahat ng naaangkop na kakayahan na
                    meron ka)
                </p>
            </div>

            <!-- Instruction -->
            <div class="mt-6 text-center sm:text-left px-1 sm:px-4">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="text-xs sm:text-base font-medium text-gray-800">Choose from the pictures provided and
                        click
                        your answer.</p>
                    <button type="button"
                        class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-[10px] sm:text-sm text-gray-600 italic mt-1">(Pumili mula sa mga larawan at pindutin ang
                    iyong sagot)</p>
            </div>

            <!-- Support Need Cards -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

                <!-- Card 1 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl min-h-[340px] flex flex-col justify-between 
              transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 
              cursor-pointer relative text-center support-card"
                    onclick="selectSupportChoice(this, 'coach')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition"
                        aria-label="Play audio for Job coach option">🔊</button>
                    <div>
                        <img src="image/support1.png" alt="job coach" class="w-full rounded-md mb-4">
                        <h3 class="text-blue-600 font-semibold text-center">Job coach/guide to help me learn</h3>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl min-h-[340px] flex flex-col justify-between
              transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 
              cursor-pointer relative text-center support-card"
                    onclick="selectSupportChoice(this, 'instructions')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition"
                        aria-label="Play audio for Written instructions option">🔊</button>
                    <div>
                        <img src="image/support2.png" alt="written instruction" class="w-full rounded-md mb-4">
                        <h3 class="text-blue-600 font-semibold text-center">Written instructions</h3>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl min-h-[340px] flex flex-col justify-between
              transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 
              cursor-pointer relative text-center support-card"
                    onclick="selectSupportChoice(this, 'independently')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition"
                        aria-label="Play audio for Work independently option">🔊</button>
                    <div>
                        <img src="image/support3.png" alt="work independently" class="w-full rounded-md mb-4">
                        <h3 class="text-blue-600 font-semibold text-center">I can work independently</h3>
                    </div>
                </div>

                <!-- Other -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl min-h-[340px] flex flex-col justify-between
              transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 
              cursor-pointer relative text-center support-card"
                    data-value="other" onclick="selectSupportChoice(this,'other')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition"
                        aria-label="Play audio for Other option">🔊</button>

                    <div class="flex flex-col flex-grow justify-center">
                        <h3 id="support_other_label" class="text-blue-600 font-semibold text-center mb-2">Other</h3>
                        <p class="mt-3 text-sm text-justify">
                            Type your answer inside the box if not in the choices
                        </p>
                        <p class="text-[13px] text-gray-600 italic mt-1 mb-3 text-justify">
                            (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
                        </p>

                        <label for="support_other_text" class="sr-only">Type your other answer here</label>
                        <input id="support_other_text" name="support_other_text" type="text"
                            aria-labelledby="support_other_label" placeholder="Type your answer here"
                            class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>
                </div>
            </div>



            <!-- Hidden Input for Support Choice -->
            <input id="support_choice" type="hidden" value="" />

            <!-- Inline helper to toggle visual selection and set hidden value -->
            <script>
                // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_supportneed.blade.php
                function selectSupportChoice(el, value) {
                    try {
                        document.querySelectorAll('.support-card').forEach(c => c.classList.remove('selected'));
                        if (el && el.classList) el.classList.add('selected');
                        const hidden = document.getElementById('support_choice');
                        if (hidden) hidden.value = value || '';
                        if (value === 'other') {
                            const other = document.getElementById('support_other_text');
                            if (other) other.focus();
                        }
                        const err = document.getElementById('supportError');
                        if (err) err.textContent = '';
                    } catch (e) {
                        console.error('selectSupportChoice error', e);
                    }
                }
            </script>

            <!-- Next Button -->
            <div class="w-full flex flex-col items-center justify-center mt-12 mb-8">
                <div id="supportError" class="text-red-600 text-sm mb-2"></div>
                <button id="supportNext" type="button"
                    class="bg-[#2E2EFF] text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
                    onclick="window.location.href='{{ route('registerworkplace') }}'">
                    Next →
                </button>
                <p class="text-gray-600 text-sm mt-2 text-center">
                    Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page Working
                    Environment<br>
                    <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>

    </div>
    </form>
    </div>

    <script src="{{ asset('js/register.js') }}"></script>

</body>

</html>
