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

    .workexp-card.selected {
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
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('registereducation') }}'">
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
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Info Text -->
                <div class="flex-1 text-left">
                    <p class="font-medium text-sm sm:text-base leading-relaxed">
                        Please fill in your school and work information. This helps us recommend suitable programs and
                        opportunities that match your experience.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Ilagay ang iyong impormasyon tungkol sa paaralan at trabaho. Makakatulong ito upang
                        mairerekomenda namin ang mga programang tugma sa iyong karanasan.)
                    </p>
                </div>
            </div>

            <!-- Audio Button -->
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-lg sm:text-xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none">
                🔊
            </button>
        </div>

        <!-- Form Section -->
        <form class="mt-10 max-w-3xl mx-auto">

            <!-- School Name -->
            <div class="mt-8 text-left px-2 sm:px-2">
                <label for="school_name" class="font-semibold text-base sm:text-lg flex items-center gap-2">
                    Name of your school
                    <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </label>

                <p class="text-gray-600 italic text-sm sm:text-base mb-1">
                    (Pangalan ng iyong paaralan)
                </p>

                <input id="school_name" name="school_name" type="text" placeholder="School Name"
                    class="w-full border border-gray-300 rounded-lg p-3 sm:p-4 text-sm sm:text-base 
           focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none transition-all duration-200" />
            </div>

            <!-- Certificates -->
            <div class="mt-8 text-left px-2 sm:px-2">
                <!-- Main Label -->
                <label for="certs" class="font-semibold text-base sm:text-lg flex items-center gap-2">
                    Do you have any certificates or special trainings?
                    <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </label>

                <!-- Translation -->
                <p class="text-gray-600 italic text-sm sm:text-base mb-2">
                    (May mga certificate o special training ka ba?)
                </p>

                <!-- Text Input -->
                <input id="certs" name="certs" type="text"
                    placeholder="List your certificates or trainings (e.g. NC II, TESDA, etc.)"
                    class="w-full border border-gray-300 rounded-lg p-3 sm:p-4 text-sm sm:text-base 
           focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none 
           transition-all duration-200 mb-4" />

                <!-- File Upload -->
                <div
                    class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="font-medium text-gray-800 text-sm sm:text-base">Upload your certificates (optional)
                        </p>
                        <p class="text-gray-600 italic text-xs sm:text-sm">(I-upload ang iyong certificate o larawan
                            nito)</p>
                    </div>

                    <label for="cert_file"
                        class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium 
             px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
                        📁 Choose File
                    </label>

                    <input id="cert_file" name="cert_file" type="file" accept=".jpg, .jpeg, .png, .pdf"
                        class="hidden">
                </div>
            </div>

            <!-- Work Experience Header -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Work Experience</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">Have you worked before?</p>
                    <button class="text-gray-500 text-2xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Nakapagtrabaho ka na dati?)</p>
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

            <!-- Cards -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">
                <!-- Card 1 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkTypeChoice(this,'paid')">
                    <button
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow text-sm">🔊</button>
                    <img src="image/jobexp1.png" alt="paid job" class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Yes, I have had a paid job</h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Oo, nagkaroon ako ng trabahong may
                        bayad)
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkTypeChoice(this,'volunteer')">
                    <button
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow text-sm">🔊</button>
                    <img src="image/jobexp2.png" alt="volunteer job"
                        class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Yes, I have done volunteer work</h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Oo, nakapag volunteer work ako)</p>
                </div>

                <!-- Card 3 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkTypeChoice(this,'internship')">
                    <button
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow text-sm">🔊</button>
                    <img src="image/jobexp3.png" alt="internship" class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">I have done internship or job training
                    </h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Nag internship o job training ako)
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkTypeChoice(this,'none')">
                    <button
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow text-sm">🔊</button>
                    <img src="image/jobexp4.png" alt="no job experience"
                        class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">No, this would be my first time</h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Hindi, ito ang magiging unang beses
                        ko)
                    </p>
                </div>
            </div>

            <!-- Hidden input for work type (collected by register.js) -->
            <input id="work_type" type="hidden" value="" />



            <!-- Next Button -->
            <div class="flex flex-col items-center justify-center mt-10 sm:mt-12 mb-6 sm:mb-8 space-y-4">
                <div id="schoolError" class="text-red-600 text-sm mb-2"></div>
                <button id="schoolNext" type="button"
                    class="bg-[#2E2EFF] text-white text-lg font-semibold px-20 sm:px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
                    Next →
                </button>
                <p class="text-gray-600 text-sm mt-2 text-center">
                    Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page Your
                    Qualifications<br>
                    <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>
        </form>
    </div>

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
            } catch (e) {
                console.error('selectWorkTypeChoice error', e);
            }
        }
    </script>

    <script src="{{ asset('js/register.js') }}"></script>

</body>

</html>
