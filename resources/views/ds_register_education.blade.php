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

    .education-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
            /* light blue */
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
        onclick="window.location.href='{{ route('registeradminapprove') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1
                class="text-xl sm:text-3xl md:text-5xl font-extrabold text-blue-700 mb-2 sm:mb-3 drop-shadow-md leading-snug">
                Set Up Your Profile</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-16 sm:w-24 md:w-36 mb-3 sm:mb-6">
            <h2
                class="text-base sm:text-xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-2 flex-wrap">
                Continue setting up your account
                <button class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
            </h2>
            <p
                class="mt-2 sm:mt-3 text-gray-700 italic text-xs sm:text-sm md:text-lg border-b-4 border-blue-500 inline-block pb-1 sm:pb-2 px-2">
                (Ituloy ang pag-set up ng iyong account)
            </p>
        </div>

        <!-- Information Note -->
        <div
            class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-3 sm:p-5 md:p-6 mt-6 shadow-sm text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-start gap-2 sm:gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        Please select your highest education level. This helps us recommend suitable programs, job
                        opportunities, and training that match your background.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Pumili ng iyong pinakamataas na natapos na antas ng edukasyon. Makakatulong ito upang
                        mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay na tumutugma sa iyong
                        kaalaman.)
                    </p>
                </div>
            </div>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
            <!-- Education Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Education</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">What is your highest education?</p>
                    <button class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Ano ang pinakamataas mong natapos na grade o
                    taon
                    sa school?)</p>
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

                <!-- Card Template -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Elementary')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/educ1.png" alt="elementary"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">Elementary</h3>
                </div>

                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Highschool')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/educ3.png" alt="highschool"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">Highschool</h3>
                </div>

                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'College')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/educ2.png" alt="college"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">College</h3>
                </div>

                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Vocational/Training')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/educ4.png" alt="vocational"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">Vocational/Training</h3>
                </div>

                <!-- Other Option -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl transition cursor-pointer relative flex flex-col justify-between text-center col-span-1 sm:col-span-2 lg:col-span-1"
                    onclick="selectEducationChoice(this, 'other')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <h3 class="text-blue-600 font-semibold mb-2 text-sm sm:text-lg">Other</h3>
                    <p class="text-xs sm:text-sm text-gray-700 mt-1">Type your answer inside the box if not in the
                        choices
                    </p>
                    <p class="text-[10px] sm:text-xs text-gray-500 italic mt-1 mb-2">(Isulat ang sagot sa loob ng kahon
                        kung
                        wala sa pagpipilian)</p>
                    <input id="edu_other_text" type="text" placeholder="Type your answer here"
                        class="w-full border border-gray-300 rounded-lg p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>
            </div>

            <!-- Hidden input for education level (collected by register.js) -->
            <input id="edu_level" type="hidden" value="" />

            <!-- Next Button -->
            <div class="flex flex-col items-center justify-center mt-10 mb-6 space-y-3 px-2">
                <div id="educError" class="text-red-600 text-sm text-center"></div>
                <button id="educNext" type="button"
                    class="bg-blue-500 text-white text-sm sm:text-lg font-semibold px-10 sm:px-16 md:px-20 py-2 sm:py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md"
                    onclick="window.location.href='{{ route('registerschoolworkinfo') }}'">
                    Next →
                </button>
                <p class="text-gray-600 text-[11px] sm:text-sm mt-2 text-center leading-snug">
                    Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
                    <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>
        </form>
    </div>

    <!-- Small inline helper to toggle selection and write the value -->
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_education.blade.php
        function selectEducationChoice(el, value) {
            try {
                // remove selected class from all cards
                document.querySelectorAll('.education-card').forEach(c => c.classList.remove('selected'));

                // add selected class to clicked card
                if (el && el.classList) el.classList.add('selected');

                // set hidden input value
                const hidden = document.getElementById('edu_level');
                if (hidden) hidden.value = value || '';

                // if "other", focus the other text input
                if (String(value).toLowerCase() === 'other') {
                    const other = document.getElementById('edu_other_text');
                    if (other) other.focus();
                }

                // clear any error text
                const err = document.getElementById('educError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectEducationChoice error', e);
            }
        }
    </script>
    <script src="{{ asset('js/register.js') }}"></script>

  </body>
</html>
