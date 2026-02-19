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
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
        }
        /* Make workexp cards animate like workyr cards */
        .workexp-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.25s ease, border 0.2s ease;
            will-change: transform, box-shadow;
        }
        .workexp-card:hover {
            transform: translateY(-4px);
        }
        .workexp-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
        }
        .workexp-card.disabled,
        .workyr-card.disabled {
            opacity: 0.45;
            pointer-events: none;
            filter: grayscale(0.05);
        }
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
    }
    </style>
    <!-- <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workinfo.blade.php
        // Multi-select toggle: clicking a card toggles its selected state and updates #work_type
        function selectWorkTypeChoice(el, value) {
            try {
                const hidden = document.getElementById('work_type');
                // read existing array (allow JSON or CSV fallback)
                let arr = [];
                if (hidden && hidden.value) {
                    try {
                        arr = JSON.parse(hidden.value || '[]');
                        if (!Array.isArray(arr)) arr = [];
                    } catch (e) {
                        // fallback to comma separated
                        arr = (hidden.value || '').split(',').map(s => s.trim()).filter(Boolean);
                    }
                }

                const val = value || (el && el.dataset && el.dataset.value) || '';
                if (!val) return;

                // toggle visual state on this card
                if (el && el.classList) el.classList.toggle('selected');
                const isSelected = el && el.classList && el.classList.contains('selected');

                if (isSelected) {
                    if (!arr.includes(val)) arr.push(val);
                } else {
                    arr = arr.filter(x => x !== val);
                }

                if (hidden) hidden.value = JSON.stringify(arr);

                // clear any related error text (some pages use different ids)
                const err = document.getElementById('schoolError') || document.getElementById('workExpError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectWorkTypeChoice error', e);
            }
        }

        // initialize card states from hidden #work_type value (JSON preferred, CSV fallback)
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const hidden = document.getElementById('work_type');
                if (!hidden) return;
                let arr = [];
                if (hidden.value) {
                    try { arr = JSON.parse(hidden.value || '[]'); } catch (e) { arr = (hidden.value || '').split(',').map(s => s.trim()).filter(Boolean); }
                }
                // ensure array unique
                arr = Array.from(new Set(arr || []));
                document.querySelectorAll('.workexp-card').forEach(c => {
                    const v = c.dataset && c.dataset.value ? c.dataset.value : null;
                    if (v && arr.includes(v)) c.classList.add('selected');
                    else c.classList.remove('selected');
                });
                // write cleaned JSON back to hidden so downstream code sees canonical format
                hidden.value = JSON.stringify(arr);
            } catch (e) {
                console.warn('init work_type failed', e);
            }
        });
    </script> -->
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
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registereducation') }}')">
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
                <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                    data-tts-en="Continue setting up your profile" data-tts-tl="Ituloy ang pag-set up ng iyong profile"
                    aria-label="Play audio for header">🔊</button>
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
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Info Text -->
                <div class="flex-1">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        Please share your work experience information. This helps us understand the kind of work you’ve
                        done before and identify roles or opportunities where your skills and background will be most
                        valued.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Ilagay ang iyong impormasyon tungkol sa karanasan sa trabaho. Makakatulong ito upang maunawaan
                        namin ang uri ng mga gawaing iyong nagawa na at matukoy ang mga posisyon o oportunidad na
                        babagay sa
                        iyong kasanayan at karanasan.)
                    </p>
                    <p class="text-black-700 text-[16px] font-medium sm:text-sm mt-4 leading-relaxed">
                        Even if you haven’t worked before, you can still share volunteer work, school activities, or
                        other experiences that helped you develop your skills.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Kahit wala ka pang pormal na trabaho, maaari mong ilagay ang mga karanasang boluntaryo,
                        gawain sa paaralan, o iba pang aktibidad na nakatulong sa iyong paghubog ng kasanayan.)
                    </p>
                </div>
            </div>

            <!-- Audio Button -->
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-lg sm:text-xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                data-tts-en="Please share your work experience information. This helps us understand the kind of work you’ve done before and identify roles or opportunities where your skills and background will be most valued."
                data-tts-tl="Ilagay ang iyong impormasyon tungkol sa karanasan sa trabaho. Makakatulong ito upang maunawaan namin ang uri ng mga gawaing iyong nagawa na at matukoy ang mga posisyon o oportunidad na babagay sa iyong kasanayan at karanasan."
                aria-label="Play audio for information note">
                🔊
            </button>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">

            <!-- Work Experience Section -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">

                <!-- Work Experience Title -->
                <div class="flex items-center justify-center sm:justify-start gap-3 mb-3">
                    <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Work Experience</h2>
                </div>

                <!-- Question Box -->
                <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 rounded-lg px-4 py-4 shadow-sm">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-2">
                        <p class="text-lg sm:text-xl font-semibold text-gray-800 text-center sm:text-left">
                            Have you worked before?
                        </p>
                        <button type="button" class="text-blue-600 text-2xl hover:scale-110 transition-transform focus:outline-none tts-btn"
                            title="Play audio" data-tts-en="Have you worked before?"
                            data-tts-tl="Nakapagtrabaho ka na dati?" aria-label="Play audio for question">
                            🔊
                        </button>
                    </div>
                    <p class="text-gray-600 italic text-base sm:text-lg mt-1">
                        (Nakapagtrabaho ka na dati?)
                    </p>
                </div>

                <!-- Instruction -->
                <div class="mt-8">
                    <div
                        class="flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-start gap-2">
                        <p class="text-gray-800 font-medium text-base sm:text-lg leading-snug">
                            Choose from the pictures provided and click your answer.
                        </p>
                        <button type="button"
                        class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="Choose from the pictures provided and click your answer."
                        data-tts-tl="Pumili mula sa mga larawan at pindutin ang iyong sagot"
                        aria-label="Play audio for instruction">🔊</button>
                    </div>
                    <p class="text-gray-600 italic text-sm sm:text-base mt-1">
                        (Pumili mula sa mga larawan at pindutin ang iyong sagot)
                    </p>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">
                <!-- Card 1 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    data-value="paid" onclick="selectWorkTypeChoice(this,'paid')">
                     <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Yes, I have had a paid job" data-tts-tl="Oo, nagkaroon ako ng trabahong may bayad"
                        aria-label="Play audio for 1-2 years option">🔊</button>
                    <img src="image/jobexp1.png" alt="paid job" class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Yes, I have had a paid job</h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Oo, nagkaroon ako ng trabahong may
                        bayad)
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    data-value="volunteer" onclick="selectWorkTypeChoice(this,'volunteer')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Yes, I have done volunteer work" data-tts-tl="Oo, nakapag volunteer work ako"
                        aria-label="Play audio for 1-2 years option">🔊</button>
                    <img src="image/jobexp2.png" alt="volunteer job" class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Yes, I have done volunteer work</h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Oo, nakapag volunteer work ako)</p>
                </div>

                <!-- Card 3 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    data-value="internship" onclick="selectWorkTypeChoice(this,'internship')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="I have done internship or job training" data-tts-tl="Nag internship o job training ako"
                        aria-label="Play audio for 1-2 years option">🔊</button>
                    <img src="image/jobexp3.png" alt="internship" class="w-full h-36 object-contain rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">I have done internship or job training
                    </h3>
                    <p class="text-[13px] text-gray-600 italic text-center mt-2">(Nag internship o job training ako)
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="workexp-card bg-white p-5 rounded-2xl hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    data-value="none" onclick="selectWorkTypeChoice(this,'none')">
                   <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="No, this would be my first time" data-tts-tl="Hindi, ito ang magiging unang beses ko"
                        aria-label="Play audio for 1-2 years option">🔊</button>
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

            <!-- Work Experience Question 
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">

                <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 rounded-lg px-4 py-4 shadow-sm">
                    <div
                       class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-2">
                        <p class="text-lg sm:text-xl font-semibold text-gray-800 text-center sm:text-left">
                            If you have worked before, how long did you work there?
                        </p>
                        <button type="button"
                            class="text-blue-600 text-2xl hover:scale-110 transition-transform tts-btn"
                            data-tts-en="If you have worked before, how long did you work there?"
                            data-tts-tl="Kung may karanasan ka sa trabaho, gaano ka katagal nagtrabaho doon?"
                            aria-label="Play audio for work experience question">🔊</button>
                    </div>
                    <p class="text-gray-600 italic text-base sm:text-lg mt-1">
                        (Kung may karanasan ka sa trabaho, gaano ka katagal nagtrabaho doon?)
                    </p>
                </div> -->

                <!-- Instruction 
                <div class="mt-8">
                    <div
                        class="flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-start gap-2">
                        <p class="text-gray-800 font-medium text-base sm:text-lg leading-snug">
                            Choose from the pictures provided and click your answer.
                        </p>
                        <button type="button"
                            class="text-blue-600 text-2xl hover:scale-110 transition-transform tts-btn"
                            data-tts-en="Choose from the pictures provided and click your answer."
                            data-tts-tl="Pumili mula sa mga larawan at pindutin ang iyong sagot"
                            aria-label="Play audio for instruction">🔊</button>
                    </div>
                    <p class="text-gray-600 italic text-sm sm:text-base mt-1">
                        (Pumili mula sa mga larawan at pindutin ang iyong sagot)
                    </p>
                </div>

            </div> -->

            <!-- Work Years Cards 
            <div
                class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">
             
                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, 'lt1')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Less than 1 year" data-tts-tl="Mas mababa sa 1 taon"
                        aria-label="Play audio for Less than 1 year option">🔊</button>
                    <img src="image/workyr1.png" alt="less 1 yr"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Less than 1 year</h3>
                </div>

            
                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, '1-2')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="1 to 2 years" data-tts-tl="1 hanggang 2 taon"
                        aria-label="Play audio for 1-2 years option">🔊</button>
                    <img src="image/workyr2.png" alt="1-2 yrs"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">1-2 years</h3>
                </div>

            
                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, 'gt3')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="More than 3 years" data-tts-tl="Mahigit 3 taon"
                        aria-label="Play audio for More than 3 years option">🔊</button>
                    <img src="image/workyr3.png" alt="more than 3 yrs"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">More than 3 years</h3>
                </div>
            </div>  -->

            <!-- top-level typed start year removed per UX request — per-job start_year remains editable -->
        <!-- Upload Work Exp Certificate -->
            <div class="mt-8 text-left px-2 sm:px-4">
                        <label class="font-semibold text-base sm:text-lg flex items-center gap-2">
                            Please upload your Work Experience Certificate.
                            <button type="button"
                                class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                                data-tts-en="Please upload your Work Experience Certificate."
                                data-tts-tl="Paki-upload ang iyong Certificate ng Work Experience.">🔊</button>
                        </label>

                        <p class="text-black-600 text-sm sm:text-base mt-4 mb-2">
                           Upload your work experience certificate as supporting proof.
                        </p>

                        <p class="text-gray-600 italic text-sm sm:text-base mb-2">
                            (I-upload ang iyong certificate ng karanasan sa trabaho bilang karagdagang patunay.)
                        </p>

                        <!-- Per-entry certificates are used now. Top-level upload removed. -->
                        <!-- Shared preview modal (used by per-entry view buttons) -->
                        <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
                        <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
                            <button id="closeModalBtn" type="button" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
                            <div id="modalContent" class="p-2 text-center"></div>
                        </div>
                        </div>

            <!-- Experiences Section -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Experiences</h2>
                <div id="job_experiences_container" class="space-y-4 mt-4"></div>
                <template id="job_exp_template">
                    <div
                        class="job_exp_item bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 ease-in-out mt-3">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold text-blue-800 text-sm sm:text-base">Work Experience</h4>
                            <button type="button"
                                class="remove-job text-[#A21A1A] text-xs sm:text-sm bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg font-medium transition-colors duration-200">
                                Remove
                            </button>
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Job Title -->
                            <div class="flex flex-col">
                                <label for="job_title" class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Job
                                    Title</label>
                                <input id="job_title" name="job_title"
                                    class="job_title w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="e.g. Kitchen Helper"/>
                            </div>

                            <!-- Company Name -->
                            <div class="flex flex-col">
                                <label for="company_name"
                                    class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input id="company_name" name="company_name"
                                    class="company_name w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="e.g., McDonald's or University of Makati"/>
                            </div>

                            <!-- Work Year -->
                            <div class="flex flex-col">
                                <label for="job_work_year"
                                    class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Work Year</label>
                                <!-- Make this editable per-job so each experience can record its own start year. -->
                                <input id="job_work_year" name="job_work_year" type="text" maxlength="4" inputmode="numeric"
                                    placeholder="e.g. 2004"
                                    class="job_work_year w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200" />
                            </div>

                            <!-- Job Description  -->
                            <div class="sm:col-span-2 flex flex-col">
                                <label for="job_description"
                                    class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Job Description</label>
                                <textarea id="job_description" name="job_description"
                                    class="job_description w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm h-20 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="What you did (e.g. cleaned tables, organized shelves)">
                         </textarea>
                            </div>
                            <!-- Per-entry upload for Work Experience certificate -->
                            <div class="sm:col-span-2 mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Upload Certificate <span class="text-red-600">(required)</span>
                                </label>
                                <p class="text-gray-600 italic text-xs sm:text-sm mb-2 job_cert_hint">Accepted: .jpg .jpeg .png .pdf — Max 5MB</p>
                                <div class="job_cert_display"></div>
                                <label class="inline-block mt-2 bg-[#2E2EFF] text-white px-3 py-2 rounded-md cursor-pointer">
                                    📁 Choose File
                                    <input type="file" accept=".jpg,.jpeg,.png,.pdf" class="job_cert_file hidden" required />
                                </label>
                                <input type="hidden" class="job_cert_data" value="" />
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Add Another Work Exp Button  -->
                <div class="mt-4 text-center">
                    <button id="addJobBtn" type="button"
                        class="bg-[#2E2EFF] text-white font-medium text-xs sm:text-base px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-600 transition inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another Work Experience
                    </button>
                </div>

                <input id="work_experiences" type="hidden" value="[]" />
                <input id="work_years" type="hidden" value="" />

                <!-- Next Button -->
                <div class="flex flex-col items-center justify-center mt-6 mb-6 space-y-3 px-2">
                    <div id="workExpError" class="text-red-600 text-sm text-center"></div>
                    <button id="workExpNext" type="button"
                        class="bg-[#2E2EFF] text-white text-sm sm:text-lg font-semibold px-10 sm:px-16 md:px-20 py-2 sm:py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md">
                        Next →
                    </button>
                    <p class="text-gray-600 text-[11px] sm:text-sm mt-2 text-center leading-snug">
                        Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page<br>
                        <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na
                            pahina)</span>
                    </p>
                </div>
        </form>
    </div>

    <!-- Small inline helper to toggle selection and write the value -->
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workinfo.blade.php
        // Make work experience multi-selectable. Store selections as a JSON array in #work_type
        function selectWorkTypeChoice(el, value) {
            try {
                const hidden = document.getElementById('work_type');
                if (!hidden) return;

                // read current selections (array). Accept JSON or comma-separated string for backwards compatibility.
                let current = [];
                try {
                    const v = hidden.value || '';
                    if (!v) current = [];
                    else if (v.trim().startsWith('[')) current = JSON.parse(v);
                    else current = String(v).split(',').map(s => s.trim()).filter(Boolean);
                } catch (e) { current = []; }

                const val = String(value || (el && el.dataset && el.dataset.value) || '');

                if (!val) return;

                // Special handling for "none" (first-time) choice:
                if (val === 'none') {
                    // if toggling off "none"
                    if (el.classList.contains('selected')) {
                        el.classList.remove('selected');
                        current = current.filter(x => x !== 'none');
                        // re-enable other cards
                        document.querySelectorAll('.workexp-card').forEach(c => c.classList.remove('disabled'));
                    } else {
                        // selecting "none": clear other selections and disable other cards
                        document.querySelectorAll('.workexp-card.selected').forEach(c => c.classList.remove('selected'));
                        document.querySelectorAll('.workexp-card').forEach(c => {
                            if (c.getAttribute('data-value') !== 'none') c.classList.add('disabled');
                            else c.classList.remove('disabled');
                        });
                        el.classList.add('selected');
                        current = ['none'];
                    }
                } else {
                    // selecting a normal work-type card: if "none" present, remove it and re-enable cards first
                    if (current.includes('none')) {
                        current = current.filter(x => x !== 'none');
                        const noneCard = document.querySelector('.workexp-card[data-value="none"]');
                        if (noneCard) noneCard.classList.remove('selected');
                        document.querySelectorAll('.workexp-card').forEach(c => c.classList.remove('disabled'));
                    }

                    // toggle this card
                    if (el && el.classList) {
                        if (el.classList.contains('selected')) {
                            el.classList.remove('selected');
                            current = current.filter(x => x !== val);
                        } else {
                            el.classList.add('selected');
                            if (!current.includes(val)) current.push(val);
                        }
                    } else {
                        if (current.includes(val)) current = current.filter(x => x !== val);
                        else current.push(val);
                    }
                }

                // write back as JSON array for consistency
                try { hidden.value = JSON.stringify(current); } catch (e) { hidden.value = (current || []).join(','); }

                // Clear any top-level errors
                const err = document.getElementById('workExpError') || document.getElementById('schoolError');
                if (err) err.textContent = '';

                // adjust dependent UI (work-years & experiences) after change
                updateWorkExpState();

            } catch (e) {
                console.error('selectWorkTypeChoice error', e);
            }
        }
    // Keeps work-years cards, job experience inputs and Add-button in sync with the "none" selection.
    function updateWorkExpState() {
        try {
            const hidden = document.getElementById('work_type');
            const addBtn = document.getElementById('addJobBtn');
            const container = document.getElementById('job_experiences_container');
            const workyrHidden = document.getElementById('work_years');
            const workyrCards = document.querySelectorAll('.workyr-card');

            let noneSelected = false;
            try {
                const v = hidden ? (hidden.value || '') : '';
                const arr = v && v.trim().startsWith('[') ? JSON.parse(v) : (v ? String(v).split(',').map(s=>s.trim()).filter(Boolean) : []);
                noneSelected = Array.isArray(arr) && arr.includes('none');
            } catch (e) { noneSelected = false; }

            if (noneSelected) {
                // disable work-year cards and clear any selection
                workyrCards.forEach(c => { c.classList.add('disabled'); c.classList.remove('selected'); });

                // set coded work_years to 'none' so downstream logic knows
                if (workyrHidden) workyrHidden.value = 'none';

                // clear job experience entries and show one disabled empty entry
                if (container) {
                    container.innerHTML = '';
                    const tpl = document.getElementById('job_exp_template');
                    if (tpl) {
                        const node = tpl.content.firstElementChild.cloneNode(true);
                        // disable inputs and hide remove button
                        node.querySelectorAll('input, textarea, button').forEach(el => {
                            try { el.disabled = true; } catch (e) {}
                            if (el.classList && el.classList.contains('remove-job')) el.style.display = 'none';
                        });
                        container.appendChild(node);
                    }
                }

                // disable Add button
                if (addBtn) { addBtn.disabled = true; addBtn.classList.add('opacity-50','cursor-not-allowed'); }

            } else {
                // enable work-year cards
                workyrCards.forEach(c => c.classList.remove('disabled'));

                // reset coded work_years if it was 'none'
                if (workyrHidden && workyrHidden.value === 'none') workyrHidden.value = '';

                // ensure at least one editable job entry exists
                if (container) {
                    if (!container.children.length) {
                        const tpl = document.getElementById('job_exp_template');
                        if (tpl) {
                            const node = tpl.content.firstElementChild.cloneNode(true);
                            node.querySelectorAll('input, textarea, button').forEach(el => { try { el.disabled = false; } catch (e) {} });
                            container.appendChild(node);
                        }
                    } else {
                        // enable inputs in existing entries
                        container.querySelectorAll('input, textarea, button').forEach(el => {
                            try { el.disabled = false; } catch (e) {}
                            if (el.classList && el.classList.contains('remove-job')) el.style.display = '';
                        });
                    }
                }

                if (addBtn) { addBtn.disabled = false; addBtn.classList.remove('opacity-50','cursor-not-allowed'); }
            }
        } catch (e) {
            console.warn('updateWorkExpState error', e);
        }
    }

        // initialize visual selection from hidden value (if any)
        document.addEventListener('DOMContentLoaded', function() {
                try {
                    const hidden = document.getElementById('work_type');
                    if (!hidden) return;
                    let current = [];
                    try {
                        const v = hidden.value || '';
                        if (!v) current = [];
                        else if (v.trim().startsWith('[')) current = JSON.parse(v);
                        else current = String(v).split(',').map(s => s.trim()).filter(Boolean);
                    } catch (e) { current = []; }

                    if (Array.isArray(current) && current.length) {
                        document.querySelectorAll('.workexp-card').forEach(card => {
                            const val = card.getAttribute('data-value');
                            if (val && current.includes(val)) card.classList.add('selected');
                        });
                    }
                } catch (e) { console.warn('workexp init failed', e); }

                const workExpNextBtn = document.getElementById('workExpNext');
                if (workExpNextBtn) {
                    workExpNextBtn.addEventListener('click', function() {
                        try {
                            const errorEl = document.getElementById('workExpError');
                            if (errorEl) errorEl.textContent = '';

                            // parse work_type hidden to detect "none"
                            const wt = document.getElementById('work_type');
                            let workTypeArr = [];
                            try {
                                const v = wt ? (wt.value || '') : '';
                                if (v && v.trim().startsWith('[')) workTypeArr = JSON.parse(v);
                                else workTypeArr = v ? String(v).split(',').map(s=>s.trim()).filter(Boolean) : [];
                            } catch (e) { workTypeArr = []; }

                            // If user chose "none", allow proceed without further required fields
                            const noneSelected = Array.isArray(workTypeArr) && workTypeArr.includes('none');

                            // If not 'none', validate selections/entries
                            if (!noneSelected) {
                                // require at least one workexp card selected
                                const selectedWorkExpCards = document.querySelectorAll(".workexp-card.selected");
                                if (!selectedWorkExpCards || selectedWorkExpCards.length === 0) {
                                    if (errorEl) errorEl.textContent = 'Please answer whether you have worked before.';
                                    const firstCard = document.querySelector('.workexp-card');
                                    if (firstCard) { firstCard.scrollIntoView({behavior:'smooth', block:'center'}); }
                                    return;
                                }

                                // work-year selection is optional now; do not block progression if not selected

                                // require at least one non-empty job experience entry, but allow progression
                                // when entries are read-only (restore-only) or saved in hidden/localStorage
                                const jobItems = Array.from(document.querySelectorAll('#job_experiences_container .job_exp_item'));
                                let nonEmptyCount = 0;
                                for (const item of jobItems) {
                                    const anyInput = Array.from(item.querySelectorAll('input, textarea')).some(inp => {
                                        try { if (inp.disabled) return false; } catch (e) {}
                                        const v = (inp.value || '').trim();
                                        return v.length > 0;
                                    });
                                    if (anyInput) nonEmptyCount++;
                                }

                                // If no visible non-empty inputs, attempt fallbacks:
                                // - if all inputs are readonly/disabled (restore-only), allow
                                // - if hidden #work_experiences contains saved entries, allow
                                // - if localStorage has job/work_experiences, allow
                                if (nonEmptyCount === 0) {
                                    const allInputs = Array.from(document.querySelectorAll('#job_experiences_container .job_exp_item input, #job_experiences_container .job_exp_item textarea'));
                                    const allReadonly = allInputs.length > 0 && allInputs.every(inp => inp.readOnly || inp.disabled);

                                    let hiddenHas = false;
                                    try {
                                        const hiddenJobs = document.getElementById('work_experiences');
                                        if (hiddenJobs && hiddenJobs.value) {
                                            const parsed = JSON.parse(hiddenJobs.value || '[]');
                                            if (Array.isArray(parsed) && parsed.length > 0) hiddenHas = true;
                                        }
                                    } catch (e) { hiddenHas = false; }

                                    let storageHas = false;
                                    try {
                                        const raw = localStorage.getItem('work_experiences') || localStorage.getItem('job_experiences');
                                        if (raw) {
                                            const parsed = JSON.parse(raw || '[]');
                                            if (Array.isArray(parsed) && parsed.length > 0) storageHas = true;
                                        }
                                    } catch (e) { storageHas = false; }

                                    if (!(allReadonly || hiddenHas || storageHas)) {
                                        if (errorEl) errorEl.textContent = 'Please add at least one previous work experience.';
                                        const jobTop = document.getElementById('job_experiences_container') || document.getElementById('workExpNext');
                                        if (jobTop) jobTop.scrollIntoView({behavior:'smooth', block:'center'});
                                        return;
                                    }
                                }
                            }

                            // Additional validation: if not 'none', require certificate for each filled job entry
                            if (!noneSelected) {
                                const jobItemsForCert = Array.from(document.querySelectorAll('#job_experiences_container .job_exp_item'));
                                for (const item of jobItemsForCert) {
                                    const jobTitle = item.querySelector('.job_title')?.value?.trim() || '';
                                    const companyName = item.querySelector('.company_name')?.value?.trim() || '';
                                    const workYear = item.querySelector('.job_work_year')?.value?.trim() || '';
                                    const jobDescription = item.querySelector('.job_description')?.value?.trim() || '';
                                    const hasAny = jobTitle || companyName || workYear || jobDescription;
                                    if (hasAny) {
                                        let certObj = null;
                                        try { const raw = item.querySelector('.job_cert_data')?.value || ''; if (raw) certObj = JSON.parse(raw); } catch(e) { certObj = null; }
                                        if (!certObj) {
                                            if (errorEl) errorEl.textContent = 'Please upload the certificate for each work experience you entered.';
                                            try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                            return;
                                        }
                                    }
                                }
                            }

                            // Passed validation (or noneSelected). Save and redirect.
                            // Save selected work experience cards
                            const selectedWorkExpCards = document.querySelectorAll(".workexp-card.selected");
                            const selectedWorkExpValues = [];
                            for (let i = 0; i < selectedWorkExpCards.length; i++) {
                                const card = selectedWorkExpCards[i];
                                const value = card.getAttribute("data-value") || "";
                                if (value) selectedWorkExpValues.push(value);
                            }
                            localStorage.setItem("selected_work_experience", JSON.stringify(selectedWorkExpValues));

                            // Save selected work year if any
                            const selectedCard = document.querySelector(".workyr-card.selected");
                            if (selectedCard) {
                                const onclickAttr = selectedCard.getAttribute("onclick") || '';
                                const match = onclickAttr.match(/selectWorkYearsChoice\(this,\s*'([^']+)'\)/);
                                if (match && match[1]) {
                                    const workYearValue = match[1];
                                    localStorage.setItem("selected_work_year", workYearValue);
                                    console.log("Selected work year saved:", workYearValue);
                                } else {
                                    // fallback to hidden value
                                    const wyHidden = document.getElementById('work_years');
                                    if (wyHidden && wyHidden.value) localStorage.setItem("selected_work_year", wyHidden.value);
                                }
                            } else {
                                // if none selected, ensure work_year cleared in storage
                                if (!noneSelected) localStorage.removeItem("selected_work_year");
                            }

                            // collect job experiences (only include entries with data)
                            const jobExperiences = [];
                            document.querySelectorAll('#job_experiences_container .job_exp_item').forEach(item => {
                                const jobTitle = item.querySelector('.job_title')?.value?.trim() || '';
                                const companyName = item.querySelector('.company_name')?.value?.trim() || '';
                                const workYear = item.querySelector('.job_work_year')?.value?.trim() || '';
                                const jobDescription = item.querySelector('.job_description')?.value?.trim() || '';
                                let certObj = null;
                                try { const raw = item.querySelector('.job_cert_data')?.value || ''; if (raw) certObj = JSON.parse(raw); } catch(e) { certObj = null; }
                                if (jobTitle || companyName || workYear || jobDescription || certObj) {
                                    jobExperiences.push({
                                        title: jobTitle,
                                        company: companyName,
                                        year: workYear,
                                        description: jobDescription,
                                        certificate: certObj || undefined
                                    });
                                }
                            });
                            localStorage.setItem('job_experiences', JSON.stringify(jobExperiences));
                            console.log('✅ Job experiences saved:', jobExperiences);

                            // navigate
                            window.location.href = '{{ route("registerworkplace") }}';
                        } catch (err) {
                            console.error('workExpNext error', err);
                        }
                    });
                }
            });
    </script>
    <script>
        document.getElementById('workplaceNext').addEventListener('click', function() {
            window.location.href = '{{ route("registerworkplace") }}';
        });
    </script>
    <script>
        // modal close handlers (shared preview)
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const modal = document.getElementById('fileModal');
                const modalContent = document.getElementById('modalContent');
                const closeBtn = document.getElementById('closeModalBtn');
                function hideModal(){ try{ if(modal) modal.classList.add('hidden'); if(modalContent) modalContent.innerHTML=''; }catch(e){} }
                if (closeBtn) closeBtn.addEventListener('click', function(e){ e.preventDefault(); hideModal(); });
                if (modal) modal.addEventListener('click', function(e){ if (e.target === modal) hideModal(); });
                document.addEventListener('keydown', function(e){ if (e.key === 'Escape') hideModal(); });
            } catch (err) { console.warn('modal bind failed', err); }
        });
    </script>
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workexpinfo.blade.php
        // Helper to compute an approximate start year from a duration code OR accept a 4-digit year
        function getWorkYearStart(code) {
            const now = new Date().getFullYear();
            const k = (code || '').toString();
            if (!k) return '';
            if (/^\d{4}$/.test(k)) return k; // already a year
            switch (k) {
                case 'lt1': return String(now); // started this year
                case '1-2': return String(now - 1); // approx 1 year ago
                case 'gt3': return String(now - 4); // approx 4 years ago
                case 'none': return '';
                default: return '';
            }
        }

        function selectWorkYearsChoice(el, value) {
            try {
                document.querySelectorAll('.workyr-card').forEach(c => c.classList.remove('selected'));
                if (el && el.classList) el.classList.add('selected');
                const hidden = document.getElementById('work_years');
                if (hidden) hidden.value = value || '';

                // Note: selecting a duration card sets the coded duration only (stored in #work_years).
                // It does NOT overwrite the typed start year field. If the user entered a year in
                // #work_start_year, that input is authoritative for job entry start years.

                const err = document.getElementById('workExpError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectWorkYearsChoice error', e);
            }
        }
    </script>
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workexpinfo.blade.php
        (function() {
            const container = document.getElementById('job_experiences_container');
            const tpl = document.getElementById('job_exp_template');
            const hidden = document.getElementById('work_experiences');

            function parseHidden() {
                try {
                    return JSON.parse(hidden.value || '[]');
                } catch (e) {
                    return [];
                }
            }

            function writeHidden(arr) {
                try {
                    hidden.value = JSON.stringify(arr || []);
                } catch (e) {
                    hidden.value = '[]';
                }
            }

            function buildEntry(item) {
                const node = tpl.content.firstElementChild.cloneNode(true);
                if (item) {
                    node.querySelector('.job_title').value = item.title || '';
                    node.querySelector('.job_description').value = item.description || '';
                    node.querySelector('.company_name').value = item.company || '';
                }
                // set the job_work_year (start year) from the item if present; do NOT auto-populate from the
                // top-level typed year or duration cards. The typed `#work_start_year` is independent and
                // will be saved as a section-level field, but it should not overwrite per-job fields here.
                try {
                    if (item && item.start_year && /^\d{4}$/.test(String(item.start_year))) {
                        const wyInput = node.querySelector('.job_work_year');
                        if (wyInput) wyInput.value = String(item.start_year);
                    }
                } catch (e) { /* ignore */ }
                // remove handler
                node.querySelector('.remove-job').addEventListener('click', function() {
                    node.remove();
                    syncHiddenFromUI();
                });
                // update hidden when inputs change
                node.querySelectorAll('input').forEach(inp => {
                    inp.addEventListener('input', debounce(syncHiddenFromUI, 150));
                });
                // per-entry certificate upload handling
                try {
                    const fileInput = node.querySelector('.job_cert_file');
                    const display = node.querySelector('.job_cert_display');
                    const hiddenCert = node.querySelector('.job_cert_data');
                    const hint = node.querySelector('.job_cert_hint');

                    function renderCertFromData(obj) {
                        try {
                            if (!display) return;
                            if (!obj || !obj.name) { display.innerHTML = ''; if (hint) hint.style.display = ''; return; }
                            const icon = (obj.type === 'pdf') ? '📄' : '🖼️';
                            const name = obj.name.length > 60 ? obj.name.slice(0,57)+'...' : obj.name;
                            display.innerHTML = `<div class="flex flex-wrap items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm"><span class="text-2xl">${icon}</span><span class="truncate max-w-[160px] sm:max-w-[240px]">${name}</span><div class="flex gap-2"><button type="button" class="view-cert bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View</button><button type="button" class="remove-cert-entry bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove</button></div></div>`;
                            if (hint) hint.style.display = 'none';
                        } catch (e) { console.warn('renderCertFromData', e); }
                    }

                    if (fileInput) {
                        fileInput.addEventListener('change', async function(){
                            const f = this.files && this.files[0]; if (!f) return;
                            const ext = String((f.name||'').split('.').pop()||'').toLowerCase();
                            if (!['jpg','jpeg','png','pdf'].includes(ext)) { alert('Invalid file type'); this.value=''; return; }
                            if (f.size > 5*1024*1024) { alert('File too large'); this.value=''; return; }
                            try {
                                const r = new FileReader();
                                r.onload = function(evt) {
                                    try {
                                        const data = evt.target.result;
                                        const obj = { name: f.name, type: ext, data };
                                        if (hiddenCert) hiddenCert.value = JSON.stringify(obj);
                                        renderCertFromData(obj);
                                        syncHiddenFromUI();
                                    } catch (e) { console.warn(e); }
                                };
                                r.readAsDataURL(f);
                            } catch (e) { console.warn('read cert failed', e); }
                        });
                    }

                    // delegation for view/remove buttons inside this node
                    if (display) {
                        display.addEventListener('click', function(ev){
                            const t = ev.target;
                            if (t && t.classList && t.classList.contains('view-cert')) {
                                try {
                                    const raw = hiddenCert ? hiddenCert.value : '';
                                    const obj = raw ? JSON.parse(raw) : null;
                                    if (obj && obj.data) {
                                        const modal = document.getElementById('fileModal');
                                        const mc = document.getElementById('modalContent');
                                        if (modal && mc) {
                                            mc.innerHTML = `<h3 class="font-semibold mb-2">${obj.name}</h3>`;
                                            if (['jpg','jpeg','png'].includes(obj.type)) mc.innerHTML += `<img src="${obj.data}" class="max-h-[70vh] mx-auto rounded-lg"/>`;
                                            else if (obj.type === 'pdf') mc.innerHTML += `<iframe src="${obj.data}" class="w-full h-[70vh] rounded-lg border" title="${obj.name}"></iframe>`;
                                            modal.classList.remove('hidden');
                                        }
                                    }
                                } catch (e) { console.warn(e); }
                            } else if (t && t.classList && t.classList.contains('remove-cert-entry')) {
                                try {
                                    if (hiddenCert) hiddenCert.value = '';
                                    renderCertFromData(null);
                                    // clear file input
                                    if (fileInput) fileInput.value = '';
                                    syncHiddenFromUI();
                                } catch (e) { console.warn(e); }
                            }
                        });
                    }

                    // if item already contains certificate info, populate
                    try {
                        if (item && (item.certificate || item.cert)) {
                            const obj = item.certificate || item.cert;
                            if (hiddenCert) hiddenCert.value = JSON.stringify(obj);
                            renderCertFromData(obj);
                        }
                    } catch (e) { /* ignore */ }
                } catch (e) { console.warn('per-entry cert binding failed', e); }
                return node;
            }

            function syncHiddenFromUI() {
                const arr = [];
                // select direct child entry blocks reliably (avoid invalid selectors like "> div")
                Array.from(container.children).forEach(block => {
                    const title = block.querySelector('.job_title')?.value?.trim() || '';
                    const description = block.querySelector('.job_description')?.value?.trim() || '';
                    const company = block.querySelector('.company_name')?.value?.trim() || '';
                    const start_year = block.querySelector('.job_work_year')?.value?.trim() || '';
                    // include certificate data if present
                    let certObj = null;
                    try { const raw = block.querySelector('.job_cert_data')?.value || ''; if (raw) certObj = JSON.parse(raw); } catch(e) { certObj = null; }
                    // only include if any field present or certificate present
                    if (title || description || company || start_year || certObj) arr.push({
                        title,
                        description,
                        company,
                        start_year: start_year || undefined,
                        certificate: certObj || undefined
                    });
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
                return function() {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, arguments), wait);
                };
            }

            // Add button (guarded) — only bind if button exists
            const _addJobBtn = document.getElementById('addJobBtn');
            if (_addJobBtn && typeof _addJobBtn.addEventListener === 'function') {
                _addJobBtn.addEventListener('click', function() {
                    addJob();
                });
            }

            // Expose renderer for register.js autofill
            window.renderWorkExperiencesFromArray = function(arr) {
                clearAndRenderFromArray(Array.isArray(arr) ? arr : []);
                writeHidden(arr || []);
            };

            // Expose a synchronous sync helper so external scripts can force the hidden input to be updated
            // (useful to ensure latest textarea/input values are flushed before a save action)
            window.syncWorkExperiencesFromUI = syncHiddenFromUI;

            // On load: if hidden has data (from autofill/local draft) render it; otherwise create one empty entry
            document.addEventListener('DOMContentLoaded', function() {
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

    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.tts-btn');
            const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
            let preferredEnglishVoice = null;
            let preferredTagalogVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName)
                    || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
                    || null;
                preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName)
                    || availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name))
                    || null;
            }

            function chooseVoiceForLang(langCode) {
                if (!availableVoices.length) return null;
                langCode = (langCode || '').toLowerCase();
                let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                if (candidates.length) return pickBest(candidates);
                candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
                if (candidates.length) return pickBest(candidates);
                return availableVoices[0];
            }

            function pickBest(list) {
                let preferred = list.filter(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
                if (preferred.length) return preferred[0];
                return list[0];
            }

            function stopSpeaking() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
                if (currentBtn) {
                    currentBtn.classList.remove('speaking');
                    currentBtn.removeAttribute('aria-pressed');
                    currentBtn = null;
                }
            }

            buttons.forEach(function(btn) {
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');

                btn.addEventListener('click', function() {
                    const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                    const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                    if (!textEn && !textTl) return;

                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
                        stopSpeaking();
                        return;
                    }

                    stopSpeaking();

                    setTimeout(function() {
                        if (!window.speechSynthesis) return;

                        function voiceFor(langHint) {
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                                    if (preferredTagalogVoice) return preferredTagalogVoice;
                                    return chooseVoiceForLang('tl');
                                }
                                if (hint.startsWith('en')) {
                                    if (preferredEnglishVoice) return preferredEnglishVoice;
                                    return chooseVoiceForLang('en');
                                }
                            }
                            return preferredEnglishVoice || chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
                        }

                        const seq = [];
                        if (textEn) {
                            const uEn = new SpeechSynthesisUtterance(textEn);
                            uEn.lang = 'en-US';
                            const v = voiceFor('en');
                            if (v) uEn.voice = v;
                            seq.push(uEn);
                        }
                        if (textTl) {
                            const uTl = new SpeechSynthesisUtterance(textTl);
                            uTl.lang = 'tl-PH';
                            const v2 = voiceFor('tl');
                            if (v2) uTl.voice = v2;
                            seq.push(uTl);
                        }

                        if (!seq.length) return;

                        seq[0].onstart = function() {
                            btn.classList.add('speaking');
                            btn.setAttribute('aria-pressed', 'true');
                            currentBtn = btn;
                        };

                        for (let i = 0; i < seq.length; i++) {
                            const ut = seq[i];
                            ut.onerror = function() {
                                if (btn) btn.classList.remove('speaking');
                                if (btn) btn.removeAttribute('aria-pressed');
                                currentBtn = null;
                            };
                            if (i < seq.length - 1) {
                                ut.onend = function() { window.speechSynthesis.speak(seq[i + 1]); };
                            } else {
                                ut.onend = function() {
                                    if (btn) btn.classList.remove('speaking');
                                    if (btn) btn.removeAttribute('aria-pressed');
                                    currentBtn = null;
                                };
                            }
                        }

                        window.speechSynthesis.speak(seq[0]);
                    }, 50);
                });

                btn.addEventListener('keydown', function(ev) {
                    if (ev.key === 'Enter' || ev.key === ' ') {
                        ev.preventDefault();
                        btn.click();
                    }
                });
            });

            window.addEventListener('beforeunload', function() { if (window.speechSynthesis) window.speechSynthesis.cancel(); });
            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function() { populateVoices(); };
            }
        });
    </script>

</body>

</html>

<script>
// Restore work experience form state when user returns to this page.
// This runs immediately if the document has already loaded.
(function() {
    function doRestore() {
        try {
            // Work type: accept multiple possible storage keys used in this app.
            const hiddenWorkType = document.getElementById('work_type');
            const rawWork = localStorage.getItem('work_type') || localStorage.getItem('selected_work_experience') || localStorage.getItem('selected_work_experience') || (hiddenWorkType ? hiddenWorkType.value : '');
            let workArr = [];
            if (rawWork) {
                try {
                    workArr = String(rawWork).trim().startsWith('[') ? JSON.parse(rawWork) : String(rawWork).split(',').map(s=>s.trim()).filter(Boolean);
                } catch (e) { workArr = []; }
            }
            // normalize and write back
            workArr = Array.isArray(workArr) ? Array.from(new Set(workArr)) : [];
            if (hiddenWorkType) hiddenWorkType.value = JSON.stringify(workArr);
            document.querySelectorAll('.workexp-card').forEach(c => {
                try {
                    const v = c.dataset && c.dataset.value ? c.dataset.value : '';
                    if (v && workArr.includes(v)) c.classList.add('selected'); else c.classList.remove('selected');
                    if (workArr.includes('none')) {
                        if (v !== 'none') c.classList.add('disabled');
                    } else {
                        c.classList.remove('disabled');
                    }
                } catch (e) {}
            });

            // Work years: accept legacy key 'selected_work_year' or 'work_years'
            const hiddenWorkYears = document.getElementById('work_years');
            const rawYears = localStorage.getItem('work_years') || localStorage.getItem('selected_work_year') || (hiddenWorkYears ? hiddenWorkYears.value : '');
            if (rawYears) {
                try { if (hiddenWorkYears) hiddenWorkYears.value = rawYears; } catch (e) {}
                document.querySelectorAll('.workyr-card').forEach(c => {
                    try {
                        // prefer data-value; fallback to parsing onclick handler for codes like 'lt1', '1-2', 'gt3'
                        let dv = '';
                        if (c.dataset && c.dataset.value) dv = c.dataset.value;
                        else {
                            const onclickAttr = c.getAttribute('onclick') || '';
                            const m = onclickAttr.match(/selectWorkYearsChoice\(this,\s*'([^']+)'\)/);
                            if (m && m[1]) dv = m[1];
                        }
                        if (dv === rawYears) c.classList.add('selected'); else c.classList.remove('selected');
                    } catch (e) {}
                });
            }

            // Job experiences: accept 'work_experiences' or legacy 'job_experiences'
            const hiddenJobs = document.getElementById('work_experiences');
            const rawJobs = localStorage.getItem('work_experiences') || localStorage.getItem('job_experiences') || (hiddenJobs ? hiddenJobs.value : '');
            if (rawJobs) {
                let arr = [];
                try { arr = JSON.parse(rawJobs || '[]'); } catch (e) { arr = []; }
                if (Array.isArray(arr) && arr.length) {
                    // map legacy 'year' -> 'start_year' so the renderer fills the per-job Work Year input
                    arr = arr.map(it => {
                        if (it && !it.start_year && (it.year || it.y)) {
                            try { return Object.assign({}, it, { start_year: it.year || it.y }); } catch (e) { return it; }
                        }
                        return it;
                    });
                    if (window.renderWorkExperiencesFromArray) {
                        try { window.renderWorkExperiencesFromArray(arr); } catch (e) { console.warn('renderWorkExperiencesFromArray failed', e); }
                    } else {
                        try { if (hiddenJobs) hiddenJobs.value = JSON.stringify(arr); } catch (e) {}
                        try { if (window.syncWorkExperiencesFromUI) window.syncWorkExperiencesFromUI(); } catch (e) {}
                    }
                }
            }

            // ensure dependent UI state updates
            try { if (typeof updateWorkExpState === 'function') updateWorkExpState(); } catch (e) {}

        } catch (e) { console.warn('workexp restore failed', e); }
    }

    if (document.readyState === 'loading') window.addEventListener('DOMContentLoaded', doRestore);
    else doRestore();
})();
</script>
