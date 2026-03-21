<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    /* OCR Loading Spinner */
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .ocr-spinner {
      border: 4px solid #e5e7eb;
      border-top: 4px solid #2E2EFF;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
    }
    .ocr-loading-container {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background-color: #f0f4ff;
        border: 1px solid #2E2EFF;
        border-radius: 8px;
        margin-top: 12px;
        width: 100%;
        box-sizing: border-box;
    }
    .ocr-loading-text {
      font-size: 14px;
      color: #1e40af;
      font-weight: 500;
    }

    /* Layout & Typography improvements */
    .main-container h1 { font-size: clamp(1.6rem, 3.6vw, 2.8rem); line-height: 1.05; }
    .main-container h2, .main-container h3 { font-size: clamp(1.05rem, 2.2vw, 1.4rem); }
    .main-container .text-gray-600.italic { font-size: 0.92rem; }
    .main-container .bg-white.rounded-2xl { padding: 1.25rem; }
    .main-container .upload-error { font-size: 0.92rem; }
    /* Make TTS buttons consistent */
    .tts-btn { padding: 0.55rem 0.6rem; border-radius: 9999px; }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        body { font-size: 15px; }
        .main-container { padding: 0.6rem; }
        .main-container h1 { text-align: center; margin-bottom: 0.5rem; }
        .main-container h3 { text-align: center; }
        /* make labels and helper text slightly larger for readability */
        .main-container label, .main-container p, .main-container .text-gray-600 { font-size: 15px; }
        /* Ensure TTS buttons are touch-friendly */
        .tts-btn { padding: 0.6rem; font-size: 1.05rem; }
        /* Ensure inputs stretch and maintain balanced padding */
        .main-container input[type="text"],
        .main-container input[type="email"],
        .main-container input[type="tel"],
        .main-container input[type="date"],
        .main-container input[type="number"],
        .main-container input[type="password"],
        .main-container select,
        .main-container textarea { font-size: 15px; padding: 0.6rem 0.75rem; }
    }
    
    /* Section card consistency */
    .main-container .section-card {
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 0.75rem;
        min-height: 360px;
        padding: 1.25rem; 
    }
    /* Slightly smaller on medium screens */
    @media (max-width: 1024px) {
        .main-container .section-card { min-height: 320px; }
    }
    /* On small screens make section cards match the instruction blue card size */
    @media (max-width: 640px) {
        .main-container .section-card { min-height: 300px; padding: 0.9rem; }
        /* make section cards visually wider on small screens to use more horizontal space; keep info-card at original size */
        .main-container .section-card {
            width: calc(100% + 2rem);
            max-width: none;
            margin-left: -1rem;
            margin-right: -1rem;
        }
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

<body class="bg-white flex justify-center sm:items-center items-start min-h-screen p-4 sm:p-6 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-2 sm:left-6 lg:left-10 top-1/3 w-20 sm:w-28 md:w-32 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-2 sm:left-6 lg:left-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-2 sm:right-6 lg:right-10 top-1/4 w-20 sm:w-28 md:w-32 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-2 sm:right-6 lg:right-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-32 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-2 top-2 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl flex items-center gap-2 sm:gap-3 text-sm sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registereducation') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

  <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-4">
            <h1
                class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Set Up Your Profile</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">
            <h2
                class="relative flex flex-wrap items-center justify-center gap-3 text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold">
                <span class="block mx-auto max-w-[82%] sm:max-w-none md:max-w-[85%] text-center md:pr-2 ">Let’s continue setting up your profile</span>
                <button type="button" class="ml-2 md:ml-3 text-sm sm:text-2xl bg-[#1E40AF] text-white p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn md:absolute md:right-3 md:top-1/2 md:-translate-y-1/2"
                    data-tts-en="Let’s continue setting up your profile" data-tts-tl="Ipagpatuloy natin ang pag-set up ng iyong profile"
                    aria-label="Play audio for header">🔊</button>
            </h2>
            <p
                class="mt-2 sm:mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ipagpatuloy natin ang pag-set up ng iyong profile)
            </p>
        </div>

            <div class="main-container mt-10 space-y-8 text-center sm:text-left mx-auto w-full max-w-6xl px-4 sm:px-0">

            <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-6">
                <div class="text-left px-2 sm:px-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-blue-600 flex items-center justify-between gap-2">
                    Have you done any work or jobs before?
                    </h2>
                    <p class="text-gray-700 italic text-md mt-2">
                    (Nakapagtrabaho ka na ba o nagkaroon ka na ba ng anumang trabaho dati?)
                    </p>
                </div>
                <!-- Audio Button -->
                <button type="button" 
                    class="bg-[#1E40AF] hover:bg-blue-700 text-white p-2 sm:p-3 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400"
                    data-tts-en="Have you done any work or jobs before? Choose the option from the images below that best describes your work experience." 
                    data-tts-tl="Nakapagtrabaho ka na ba o nagkaroon ka na ba ng anumang trabaho dati? Piliin ang opsyon mula sa mga larawan sa ibaba na pinakaangkop na naglalarawan ng iyong karanasan sa trabaho."
                    aria-label="Play audio for question">
                    🔊
                </button>
                </div>

                <!-- Instruction Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8 shadow border border-blue-100 mb-10 max-w-3xl mx-auto sm:mx-0">
                <p class="text-base sm:text-lg font-medium text-gray-800 leading-relaxed">
                    Choose the option from the images below that best describes your 
                    <span class="text-blue-700 font-semibold">work experience</span>.
                </p>
                <div class="border-t border-gray-200 my-4"></div>
                <p class="text-sm sm:text-base text-gray-700 italic">
                    (Piliin ang opsyon mula sa mga larawan sa ibaba na pinakaangkop na naglalarawan ng iyong 
                    <span class="font-semibold text-blue-700">karanasan sa trabaho</span>.)
                </p>
                </div>

                <!-- Options -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-4xl mx-auto">

                <!-- Have Experience-->
                <div class="workexp-card bg-white border border-gray-200 p-6 rounded-2xl hover:bg-blue-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 cursor-pointer relative text-center"
                    data-value="paid" onclick="selectWorkTypeChoice(this,'paid')">

                    <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow text-sm tts-btn"
                    data-tts-en="Yes, I have worked before"
                    data-tts-tl="Oo, nakapagtrabaho na ako dati">
                    🔊
                    </button>

                    <img src="image/jobexp1.png"
                    alt="paid job"
                    class="w-full h-44 object-contain mb-5">

                    <h3 class="text-lg font-semibold text-blue-700">
                    Yes, I have worked before
                    </h3>
                    <p class="text-sm text-gray-600 italic mt-2">
                    (Oo, nakapagtrabaho na ako dati)
                    </p>

                </div>

                <!-- No Experience -->
                <div class="workexp-card bg-white border border-gray-200 p-6 rounded-2xl hover:bg-blue-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 cursor-pointer relative text-center"
                    data-value="none" onclick="selectWorkTypeChoice(this,'none')">

                    <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow text-sm tts-btn"
                    data-tts-en="No, this would be my first time"
                    data-tts-tl="Hindi, ito ang magiging unang beses ko">
                    🔊
                    </button>

                    <img src="image/jobexp4.png"
                    alt="no job experience"
                    class="w-full h-44 object-contain mb-5">

                    <h3 class="text-lg font-semibold text-blue-700">
                    No, this would be my first time
                    </h3>
                    <p class="text-sm text-gray-600 italic mt-2">
                    (Hindi, ito ang magiging unang beses ko)
                    </p>

                </div>

                </div>

            </div>
            </div>

                {{-- <!-- Card 2 -->
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
                </div> --}}

            <div
            class="info-card mt-6 sm:mt-8 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md relative">

              <!-- Desktop Audio Button -->
                <button type="button" aria-label="Play audio for info section"
                    class="hidden sm:block absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
                         text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
                            focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="If you have worked before, please type your job title,company name and location, start and end year, and a short description of what you did in your job below. If you do not have any work experience yet, 
                            it’s okay to leave this section blank. Everyone starts somewhere!"
                            data-tts-tl="Kung ikaw ay nakapagtrabaho na, ilagay ang posisyon sa trabaho, pangalan at lokasyon ng kumpanya, taon ng pagsisimula at pagtatapos, at maikling paglalarawan ng iyong trabaho sa ibaba.
                                         Kung wala ka pang karanasan sa trabaho, okay lang na iwanang blangko ang bahaging ito..">
                            🔊
                </button>

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pr-4 sm:pr-16"> 
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 flex-shrink-0 mt-0.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-base sm:text-lg text-gray-700 font-bold leading-relaxed">
                        If you have worked before, please type your job title,company name and location, start and end year, and a short description of what you did in your job below. 
                        If you do not have any work experience yet, it’s okay to leave this section blank. Everyone starts somewhere!
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Kung ikaw ay nakapagtrabaho na, ilagay ang posisyon sa trabaho, pangalan at lokasyon ng kumpanya, taon ng pagsisimula at pagtatapos, at maikling paglalarawan ng iyong trabaho sa ibaba.
                         Kung wala ka pang karanasan sa trabaho, okay lang na iwanang blangko ang bahaging ito.)
                    </p>
                
                 <!-- Mobile Audio Button -->
                    <div class="mt-3 flex justify-center sm:hidden">
                        <button type="button" aria-label="Play audio for info section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                            transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                                data-tts-en="If you have worked before, please type your job title,company name and location, start and end year, and a short description of what you did in your job below. If you do not have any work experience yet, 
                                it’s okay to leave this section blank. Everyone starts somewhere!"
                            data-tts-tl="Kung ikaw ay nakapagtrabaho na, ilagay ang posisyon sa trabaho, pangalan at lokasyon ng kumpanya, taon ng pagsisimula at pagtatapos, at maikling paglalarawan ng iyong trabaho sa ibaba.
                                         Kung wala ka pang karanasan sa trabaho, okay lang na iwanang blangko ang bahaging ito.">
                            🔊
                    </button>
                </div>
            </div>
        </div>
    </div>




                <!-- Shared preview modal (used by per-entry view buttons) -->
                <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
                <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
                    <button id="closeModalBtn" type="button" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
                    <div id="modalContent" class="p-2 text-center"></div>
                </div>
                </div>

                <!-- Experiences Section -->
                <div id="experiences_section" class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200 mt-12 hidden">

                        <div class="mb-3 flex items-start justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-blue-600">Work Experiences</h3>
                                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Add all your work experiences)</p>
                            </div>
                            <button type="button" class="hidden sm:inline-block bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-md tts-btn" data-tts-en="Add details about your work experiences. You can add multiple entries." data-tts-tl="Maglagay ng impormasyon tungkol sa iyong mga karanasan sa trabaho." aria-label="Play audio for work experiences">🔊</button>
                        </div>

                    <div id="job_experiences_container" class="space-y-6"></div>
                    <template id="job_exp_template">                                    

                        <div class="job_exp_item bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-sm text-gray-600 italic">Fill in one entry per work experience</div>
                                <button type="button"
                                    class="remove-job text-[#A21A1A] text-xs sm:text-sm bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg font-medium transition-colors duration-200">
                                    Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Job Title -->
                                <div>
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/briefcase.png" alt="Job title icon" class="w-5 h-5" />
                                        Job Title
                                    </label>
                                    <input 
                                        list="job-title-options"
                                        id="job_title"
                                        name="job_title"
                                        class="job_title w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800"
                                        placeholder="Select or type your job (e.g. Kitchen Helper)"
                                    />
                                    <datalist id="job-title-options">
                                        <option value="Customer Assistant">
                                        <option value="Merchandising Assistant">
                                        <option value="Stockroom Helper">
                                        <option value="Office Helper">
                                        <option value="Service Crew">
                                        <option value="Store Utility / Cleaner">
                                        <option value="Front Desk Helper">
                                        <option value="Housekeeping Assistant">
                                    </datalist>
                                </div>
                                <!-- Company Name -->
                                <div>
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/company.png" alt="Company icon" class="w-5 h-5" />
                                        Company Name
                                    </label>
                                    <input id="company_name" name="company_name"
                                        class="company_name w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800"
                                        placeholder="e.g., McDonald's"/>
                                </div>

                                <!-- Company Location -->
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/map-pin.png" alt="Location icon" class="w-5 h-5" />
                                        Company Location
                                    </label>
                                    <input type="text"
                                        class="company_location w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800"
                                        placeholder="e.g., Taguig City">
                                </div>

                                <!-- Work Period -->
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/calendar.png" alt="Calendar icon" class="w-5 h-5" />
                                        Work Period
                                    </label>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <!-- Start -->
                                        <div>
                                            <p class="text-xs text-gray-600 mb-2">Start</p>
                                            <div class="flex gap-2">
                                                <select class="job_start_month w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                                    <option>Month</option>
                                                    <option>January</option><option>February</option><option>March</option>
                                                    <option>April</option><option>May</option><option>June</option>
                                                    <option>July</option><option>August</option><option>September</option>
                                                    <option>October</option><option>November</option><option>December</option>
                                                </select>
                                                <input type="text" placeholder="Year"
                                                    class="job_start_year w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                            </div>
                                        </div>

                                        <!-- End -->
                                        <div>
                                            <p class="text-xs text-gray-600 mb-2">End</p>
                                            <div class="flex gap-2">
                                                <select class="job_end_month w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                                    <option>Month</option>
                                                    <option>January</option><option>February</option><option>March</option>
                                                    <option>April</option><option>May</option><option>June</option>
                                                    <option>July</option><option>August</option><option>September</option>
                                                    <option>October</option><option>November</option><option>December</option>
                                                </select>
                                                <input type="text" placeholder="Year / Present"
                                                    class="job_end_year w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Description  -->
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/document.png" alt="Document icon" class="w-5 h-5" />
                                        Job Description
                                    </label>
                                    <textarea id="job_description" name="job_description"
                                        class="job_description w-full border border-gray-300 rounded-lg p-3 h-20 resize-none focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800"
                                        placeholder="What you did (e.g. cleaned tables, organized shelves)">
                                    </textarea>
                                </div>

                                <!-- Upload Instruction -->
                                <div class="md:col-span-2 mt-6">
                                    <div class="flex items-center justify-between gap-3">
                                        <label class="font-semibold text-gray-800 text-base sm:text-lg flex items-center gap-2">
                                            <span>Please upload your Work Certificate.</span>
                                        </label>

                                        <button type="button"
                                            class="bg-[#1E40AF] hover:bg-blue-700 text-white p-2 sm:p-3 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400"
                                            data-tts-en="Please upload your work certificate as proof of your previous job."
                                            data-tts-tl="Paki-upload ang work certificate bilang patunay ng iyong nakaraang trabaho."
                                            aria-label="Play audio for upload instructions">
                                            🔊
                                        </button>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-black-700 text-sm sm:text-base mt-4 mb-2 leading-relaxed">
                                        Please upload your work certificate as proof of your previous job.
                                    </p>

                                    <p class="text-gray-600 italic text-sm sm:text-base mt-1">
                                        (Paki-upload ang work certificate bilang patunay ng iyong nakaraang trabaho.)
                                    </p>
                                </div>
                        
                                <!-- Per-entry upload for Work Experience certificate -->
                                <div class="md:col-span-2 mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5">
                                    <div class="flex flex-col gap-3">
                                        <div class="sm:flex sm:items-start sm:justify-between gap-4">
                                            <div class="flex-1 min-w-0">
                                                <label class="text-gray-700 text-md flex items-center gap-2">
                                                    Upload an image or PDF of your Certificates.<span class="font-semibold italic text-sm sm:text-md text-red-600">*required</span>
                                                </label>
                                                <p class="text-gray-700 italic text-md mt-1 leading-relaxed">
                                                    (Mag-upload ng larawan o PDF ng iyong Certificates)
                                                </p>
                                                <p class="text-gray-600 text-md mt-4 leading-relaxed">
                                                    Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b>
                                                </p>

                                                <!-- Display uploaded file + OCR progress here -->
                                                <div class="job_cert_display mt-3"></div>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <label class="inline-flex items-center justify-center w-full sm:w-auto mt-2 cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
                                                    📁 Choose File / Pumili ng File
                                                    <input type="file" accept=".jpg,.jpeg,.png,.pdf" class="job_cert_file hidden" required />
                                                </label>
                                            </div>
                                        </div>

                                        <input type="hidden" class="job_cert_data" value="" />
                                    </div>
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
                </div>

                <input id="work_type" type="hidden" value="[]" />
                <input id="work_experiences" type="hidden" value="[]" />
                <input id="work_years" type="hidden" value="" />

                <!-- Next Button -->
                <div class="flex flex-col items-center justify-center mt-6 mb-6 space-y-3 px-2">
                    <div id="workExpError" class="text-red-600 text-sm text-center"></div>
                    <button id="workExpNext" type="button"
                        class="w-full sm:w-auto bg-[#2E2EFF] text-white text-lg sm:text-2xl font-semibold px-6 sm:px-16 md:px-28 py-3 sm:py-4 rounded-2xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-300">
                        Next →
                    </button>
                    <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
                        Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue <br class="hidden sm:block">
                       <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
                    </p>
                </div>
        </form>


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
            const experiencesSection = document.getElementById('experiences_section');

            let noneSelected = false;
            let paidSelected = false;
            try {
                const v = hidden ? (hidden.value || '') : '';
                const arr = v && v.trim().startsWith('[') ? JSON.parse(v) : (v ? String(v).split(',').map(s=>s.trim()).filter(Boolean) : []);
                noneSelected = Array.isArray(arr) && arr.includes('none');
                paidSelected = Array.isArray(arr) && arr.includes('paid');
            } catch (e) { noneSelected = false; paidSelected = false; }

            // Show/hide experiences section based on selection
            if (experiencesSection) {
                if (paidSelected && !noneSelected) {
                    experiencesSection.classList.remove('hidden');
                } else {
                    experiencesSection.classList.add('hidden');
                }
            }

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
                                if (addBtn && typeof addBtn.click === 'function') {
                                    // Use the existing Add button handler so the entry is built with all event bindings
                                    try { addBtn.click(); }
                                    catch (e) {
                                        // fallback to naive clone if click() fails
                                        if (tpl) {
                                            const node = tpl.content.firstElementChild.cloneNode(true);
                                            node.querySelectorAll('input, textarea, button').forEach(el => { try { el.disabled = false; } catch (e) {} });
                                            container.appendChild(node);
                                        }
                                    }
                                } else {
                                    if (tpl) {
                                        const node = tpl.content.firstElementChild.cloneNode(true);
                                        node.querySelectorAll('input, textarea, button').forEach(el => { try { el.disabled = false; } catch (e) {} });
                                        container.appendChild(node);
                                    }
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

                    // Initialize experiences section visibility
                    updateWorkExpState();
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

                            // Additional validation: ensure per-entry month/year ranges are valid
                            const jobItemsAll = Array.from(document.querySelectorAll('#job_experiences_container .job_exp_item'));
                            const today = new Date();
                            for (const item of jobItemsAll) {
                                const jt = item.querySelector('.job_title')?.value?.trim() || '';
                                const cn = item.querySelector('.company_name')?.value?.trim() || '';
                                const jd = item.querySelector('.job_description')?.value?.trim() || '';
                                const sm = item.querySelector('.job_start_month')?.value?.trim() || '';
                                const sy = item.querySelector('.job_start_year')?.value?.trim() || '';
                                const em = item.querySelector('.job_end_month')?.value?.trim() || '';
                                const ey = item.querySelector('.job_end_year')?.value?.trim() || '';
                                const hasAny = jt || cn || jd || sm || sy || em || ey;
                                if (!hasAny) continue; // skip empty rows

                                // if any part of the period is provided, require start month+year and end month+year (or 'Present')
                                if (sm || sy || em || ey) {
                                    // start must have month and 4-digit year
                                    if (!/^[1-9]$|^1[0-2]$/.test(String(sm)) || !/^\d{4}$/.test(String(sy))) {
                                        if (errorEl) errorEl.textContent = 'Please provide a valid start month and 4-digit start year for each experience.';
                                        try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                        return;
                                    }
                                    // end may be 'Present' (case-insensitive) or month+4-digit year
                                    const eyRaw = String(ey || '').trim();
                                    const endIsPresent = /^present$/i.test(eyRaw) || eyRaw === '' && em === '';
                                    if (!endIsPresent) {
                                        if (!/^[1-9]$|^1[0-2]$/.test(String(em)) || !/^\d{4}$/.test(String(eyRaw))) {
                                            if (errorEl) errorEl.textContent = 'Please provide a valid end month and 4-digit end year (or "Present").';
                                            try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                            return;
                                        }
                                    }

                                    // compare dates
                                    try {
                                        const sDate = new Date(Number(sy), Number(sm) - 1, 1);
                                        const eDate = endIsPresent ? today : new Date(Number(eyRaw), Number(em) - 1, 1);
                                        if (isNaN(sDate.getTime()) || isNaN(eDate.getTime())) {
                                            if (errorEl) errorEl.textContent = 'Invalid dates entered for work experience.';
                                            try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                            return;
                                        }
                                        if (sDate > eDate) {
                                            if (errorEl) errorEl.textContent = 'Start date must be before or equal to end date for each experience.';
                                            try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                            return;
                                        }
                                        // do not allow end date in the future (unless 'Present')
                                        if (!endIsPresent && eDate > today) {
                                            if (errorEl) errorEl.textContent = 'End date cannot be in the future. Use "Present" if still working.';
                                            try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                            return;
                                        }
                                    } catch (e) {
                                        if (errorEl) errorEl.textContent = 'Invalid date range for a work experience.';
                                        try { item.scrollIntoView({behavior:'smooth', block:'center'}); } catch (e) {}
                                        return;
                                    }
                                }
                            }

                            // collect job experiences (only include entries with data)
                            const jobExperiences = [];
                            document.querySelectorAll('#job_experiences_container .job_exp_item').forEach(item => {
                                const jobTitle = item.querySelector('.job_title')?.value?.trim() || '';
                                const companyName = item.querySelector('.company_name')?.value?.trim() || '';
                                const start_month = item.querySelector('.job_start_month')?.value?.trim() || '';
                                const start_year = item.querySelector('.job_start_year')?.value?.trim() || '';
                                const end_month = item.querySelector('.job_end_month')?.value?.trim() || '';
                                const end_year = item.querySelector('.job_end_year')?.value?.trim() || '';
                                const jobDescription = item.querySelector('.job_description')?.value?.trim() || '';
                                let certObj = null;
                                try { const raw = item.querySelector('.job_cert_data')?.value || ''; if (raw) certObj = JSON.parse(raw); } catch(e) { certObj = null; }
                                if (jobTitle || companyName || start_month || start_year || end_month || end_year || jobDescription || certObj) {
                                    jobExperiences.push({
                                        title: jobTitle,
                                        company: companyName,
                                        start_month: start_month || undefined,
                                        start_year: start_year || undefined,
                                        end_month: end_month || undefined,
                                        end_year: end_year || undefined,
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
                    // populate per-entry start/end month/year when available
                    if (item) {
                        if (item.start_month) {
                            const sm = node.querySelector('.job_start_month'); if (sm) sm.value = String(item.start_month);
                        }
                        if (item.start_year) {
                            const sy = node.querySelector('.job_start_year'); if (sy) sy.value = String(item.start_year);
                        }
                        if (item.end_month) {
                            const em = node.querySelector('.job_end_month'); if (em) em.value = String(item.end_month);
                        }
                        if (item.end_year) {
                            const ey = node.querySelector('.job_end_year'); if (ey) ey.value = String(item.end_year);
                        }
                    }
                } catch (e) { /* ignore */ }
                // remove handler
                node.querySelector('.remove-job').addEventListener('click', function() {
                    node.remove();
                    syncHiddenFromUI();
                });
                // update hidden when inputs/selects change
                node.querySelectorAll('input, select, textarea').forEach(inp => {
                    inp.addEventListener('input', debounce(syncHiddenFromUI, 150));
                    inp.addEventListener('change', debounce(syncHiddenFromUI, 150));
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
                            display.innerHTML = `<div class="flex flex-wrap items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm"><span class="text-2xl">${icon}</span><span class="truncate max-w-[160px] sm:max-w-[240px]">${name}</span>
                                                 <div class="flex gap-2"><button type="button" class="view-cert bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
                                                <button type="button" class="remove-cert-entry bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button></div></div>`;
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
                                r.onload = async function(evt) {
                                    try {
                                        const data = evt.target.result;
                                        const obj = { name: f.name, type: ext, data };
                                        if (hiddenCert) hiddenCert.value = JSON.stringify(obj);
                                        renderCertFromData(obj);
                                        syncHiddenFromUI();

                                        // Attempt OCR autofill: POST to server OCR endpoint and map fields
                                        try {
                                            if (!display) return;
                                            // Create and show loading indicator
                                            const loadingId = `ocr-loading-${Date.now()}`;
                                            const loadingDiv = document.createElement('div');
                                            loadingDiv.className = 'ocr-loading-container';
                                            loadingDiv.id = loadingId;
                                            loadingDiv.innerHTML = `
                                                <div class="ocr-spinner"></div>
                                                <span class="ocr-loading-text">Processing OCR... Please wait</span>
                                            `;
                                            display.appendChild(loadingDiv);

                                            const resp = await fetch('/db/ocr-validation.php', {
                                                method: 'POST',
                                                headers: { 'Content-Type': 'application/json' },
                                                body: JSON.stringify({ type: 'certificate_proof', ocr_data: data })
                                            });
                                            const json = await resp.json();
                                            // remove loading
                                            try { const ld = display.querySelector('.ocr-loading-container'); if (ld) ld.remove(); } catch(e){}
                                            if (json && json.status && json.data && json.data.ai_data) {
                                                const ai = json.data.ai_data || {};
                                                // Map OCR fields into job entry fields
                                                const title = ai.cert_name || ai.name || ai.title || '';
                                                const issuer = ai.issued_by || ai.issued_by_org || ai.issuer || ai.company || '';
                                                const dateCompleted = ai.date_completed || ai.date || ai.issued_date || '';
                                                const descParts = [];
                                                if (ai.first_name || ai.last_name) descParts.push('Name: ' + [ai.first_name, ai.last_name].filter(Boolean).join(' '));
                                                if (ai.diagnosis) descParts.push(ai.diagnosis);
                                                if (ai.type_of_disability) descParts.push(ai.type_of_disability);
                                                if (ai.summary) descParts.push(ai.summary);
                                                const desc = descParts.join('; ');

                                                try {
                                                    const jt = node.querySelector('.job_title');
                                                    const cn = node.querySelector('.company_name');
                                                    const jd = node.querySelector('.job_description');
                                                    const em = node.querySelector('.job_end_month');
                                                    const ey = node.querySelector('.job_end_year');
                                                    if (title && jt && !jt.value) jt.value = title;
                                                    if (issuer && cn && !cn.value) cn.value = issuer;
                                                    if (desc && jd && !jd.value) jd.value = (jd.value ? jd.value + '\n' + desc : desc);

                                                    // parse YYYY-MM-DD or YYYY-MM
                                                    if (dateCompleted && ey) {
                                                        const m = String(dateCompleted).match(/^(\d{4})(?:-?(\d{2}))?(?:-?(\d{2}))?/);
                                                        if (m) {
                                                            const y = m[1];
                                                            const mon = m[2] ? String(Number(m[2])) : '';
                                                            ey.value = y;
                                                            if (em && mon) em.value = mon;
                                                        }
                                                    }
                                                    syncHiddenFromUI();
                                                } catch (e) { console.warn('apply ocr mapping failed', e); }
                                            }
                                        } catch (e) {
                                            console.warn('OCR request failed', e);
                                        } finally {
                                            try { const s = display.querySelector('.ocr-loading-container'); if (s) s.remove(); } catch(e){}
                                        }

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
                    const start_month = block.querySelector('.job_start_month')?.value?.trim() || '';
                    const start_year = block.querySelector('.job_start_year')?.value?.trim() || '';
                    const end_month = block.querySelector('.job_end_month')?.value?.trim() || '';
                    const end_year = block.querySelector('.job_end_year')?.value?.trim() || '';
                    // include certificate data if present
                    let certObj = null;
                    try { const raw = block.querySelector('.job_cert_data')?.value || ''; if (raw) certObj = JSON.parse(raw); } catch(e) { certObj = null; }
                    // only include if any field present or certificate present
                    if (title || description || company || start_year || start_month || end_year || end_month || certObj) arr.push({
                        title,
                        description,
                        company,
                        start_month: start_month || undefined,
                        start_year: start_year || undefined,
                        end_month: end_month || undefined,
                        end_year: end_year || undefined,
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

            // Use event delegation to handle both static and dynamically added buttons
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.tts-btn');
                if (!btn) return;
                
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');

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

            // Handle keydown for accessibility on any .tts-btn
            document.addEventListener('keydown', function(e) {
                if ((e.key === 'Enter' || e.key === ' ') && e.target.classList.contains('tts-btn')) {
                    e.preventDefault();
                    e.target.click();
                }
            });

            // Initialize static buttons on page load
            document.querySelectorAll('.tts-btn').forEach(function(btn) {
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');
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
