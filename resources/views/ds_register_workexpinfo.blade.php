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

            <!-- Work Experience Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">

                <!-- Question Box -->
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
                </div>

                <!-- Instruction -->
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

            </div>

            <!-- Work Years Cards -->
            <div
                class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">
                <!-- Card 1 -->
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

                <!-- Card 2 -->
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

                <!-- Card 3 -->
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

                <!-- Card 4 -->
                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, 'none')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="None" data-tts-tl="Wala" aria-label="Play audio for None option">🔊</button>
                    <img src="image/workyr4.png" alt="no experience"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">None</h3>
                </div>
            </div>

            <!-- top-level typed start year removed per UX request — per-job start_year remains editable -->

            <!-- Experiences Section -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Experiences</h2>
                <p class="text-gray-600 italic mt-4 text-base sm:text-lg">Add one or more previous work experience.</p>
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
                                    placeholder="e.g. Kitchen Helper" />
                            </div>

                            <!-- Company Name -->
                            <div class="flex flex-col">
                                <label for="company_name"
                                    class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input id="company_name" name="company_name"
                                    class="company_name w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="e.g., McDonald's or University of Makati" />
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

                            <!-- Job Description -->
                            <div class="sm:col-span-2 flex flex-col">
                                <label for="job_description"
                                    class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Job Description</label>
                                <textarea id="job_description" name="job_description"
                                    class="job_description w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm h-20 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="What you did (e.g. cleaned tables, organized shelves)">
                         </textarea>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- ADD for the backend+ When the user selects a work year (e.g. “1–2 years”), that choice should be copied
                    to the first Job Experience entry automatically. -->
                <!-- When the user adds another Job Experience, the selected work year should still be remembered
                    and included (renewed) in the newly added section. -->


                <input id="work_experiences" type="hidden" value="[]" />
                <input id="work_years" type="hidden" value="" />

                <!-- Add Another Work Exp Button -->
                <div class="mt-6 text-center">
                    <button id="addJobBtn" type="button"
                        class="bg-[#2E2EFF] text-white font-medium text-xs sm:text-base px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-600 transition inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another Job Experience
                    </button>
                </div>
                <!-- Next Button -->
                <div class="flex flex-col items-center justify-center mt-10 mb-6 space-y-3 px-2">
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

                // toggle the clicked card visually
                if (el && el.classList) {
                    if (el.classList.contains('selected')) {
                        el.classList.remove('selected');
                        // remove value
                        current = current.filter(x => x !== value);
                    } else {
                        el.classList.add('selected');
                        // add value if not present
                        if (!current.includes(value)) current.push(value);
                    }
                } else {
                    // fallback behavior: if no element passed, just toggle in array
                    if (current.includes(value)) current = current.filter(x => x !== value);
                    else current.push(value);
                }

                // write back as JSON array for consistency
                try { hidden.value = JSON.stringify(current); } catch (e) { hidden.value = (current || []).join(','); }

                const err = document.getElementById('workExpError') || document.getElementById('schoolError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectWorkTypeChoice error', e);
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

                // Get only selected work experience cards
                const selectedWorkExpCards = document.querySelectorAll(".workexp-card.selected");
                const selectedWorkExpValues = [];

                for (let i = 0; i < selectedWorkExpCards.length; i++) {
                
                    const card = selectedWorkExpCards[i];
                    const value = card.getAttribute("data-value") || "";
                    if (value) {
                        selectedWorkExpValues.push(value);
                    }
                }

                // Save only selected values to localStorage
                localStorage.setItem("selected_work_experience", JSON.stringify(selectedWorkExpValues));
                const selectedCard = document.querySelector(".workyr-card.selected");
                debugger;
                if (selectedCard) {
                    const onclickAttr = selectedCard.getAttribute("onclick");
                    const match = onclickAttr.match(/selectWorkYearsChoice\(this,\s*'([^']+)'\)/);
                    if (match && match[1]) {
                        const workYearValue = match[1];
                        localStorage.setItem("selected_work_year", workYearValue);
                        console.log("Selected work year saved:", workYearValue);
                    }
                } else {
                    console.log("No work year selected.");
                }

                });
            }
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
                    // only include if any field present
                    if (title || description || company || start_year) arr.push({
                        title,
                        description,
                        company,
                        start_year: start_year || undefined
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

            // Add button
            document.getElementById('addJobBtn').addEventListener('click', function() {
                addJob();
            });

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
            const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            let preferredVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredVoice = availableVoices.find(v => v.name === preferredVoiceName) ||
                    availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) ||
                    null;
            }

            function chooseVoiceForLang(langCode) {
                if (!availableVoices.length) return null;
                langCode = (langCode || '').toLowerCase();
                let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                if (candidates.length) return pickBest(candidates);
                candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i
                    .test(v.name));
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
                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn ===
                        btn) {
                        stopSpeaking();
                        return;
                    }
                    stopSpeaking();
                    setTimeout(function() {
                        if (!window.speechSynthesis) return;

                        function voiceFor(langHint) {
                            if (preferredVoice) return preferredVoice;
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint
                                    .includes('tagalog')) {
                                    return chooseVoiceForLang('tl');
                                }
                                return chooseVoiceForLang(langHint);
                            }
                            return chooseVoiceForLang('en') || (availableVoices.length ?
                                availableVoices[0] : null);
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
                                ut.onend = function() {
                                    window.speechSynthesis.speak(seq[i + 1]);
                                };
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

            window.addEventListener('beforeunload', function() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });
            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function() {
                    populateVoices();
                };
            }
        });
    </script>

</body>

</html>
