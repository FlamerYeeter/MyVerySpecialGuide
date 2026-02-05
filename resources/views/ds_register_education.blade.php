<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Education</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Floating animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float-slow {
            animation: float 5s ease-in-out infinite;
        }

        .animate-float-medium {
            animation: float 3.5s ease-in-out infinite;
        }

        .animate-float-fast {
            animation: float 2.5s ease-in-out infinite;
        }

        .education-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
            /* light blue */
        }

        .tts-btn.speaking {
            background-color: #2563eb !important;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
            transform: scale(1.03);
        }
    </style>
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
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registeradminapprove') }}')">
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
                Continue setting up your profile
                <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                    data-tts-en="Continue setting up your profile" data-tts-tl="Ituloy ang pag-set up ng iyong profile"
                    aria-label="Play audio for header">🔊</button>
            </h2>
            <p
                class="mt-2 sm:mt-3 text-gray-700 italic text-xs sm:text-sm md:text-lg border-b-4 border-blue-500 inline-block pb-1 sm:pb-2 px-2">
                (Ituloy ang pag-set up ng iyong profile)
            </p>
        </div>

        <!-- Information Note -->
        <div
            class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 sm:p-5 md:p-6 mt-6 shadow-sm">
            <!-- Audio Button -->
            <button type="button" aria-label="Play audio for information note"
                class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-[#1E40AF] hover:bg-blue-700 text-white 
           text-base sm:text-m p-2 sm:p-3 rounded-full shadow-md transition-transform 
           hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                data-tts-en="Please select your highest education level. This helps us recommend suitable programs, job opportunities, and training that match your background."
                data-tts-tl="Pumili ng iyong pinakamataas na natapos na antas ng edukasyon. Makakatulong ito upang mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay na tumutugma sa iyong kaalaman.">
                🔊
            </button>

            <!-- Content -->
            <div class="flex flex-col sm:flex-row items-start gap-2 sm:gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <div class="flex-1 pr-10"> <!-- padding-right to avoid overlap with button -->
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        Please select your highest education level and fill in your school information. This helps us
                        recommend suitable
                        programs, job opportunities, and training that match your background.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Pumili ng iyong pinakamataas na natapos na antas ng edukasyon at ilagay ang impormasyon ng
                        iyong paaralan.
                        Makakatulong ito upang mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay
                        na tumutugma
                        sa iyong kaalaman.)
                    </p>
                </div>
            </div>
        </div>

        <form id="educationForm" class="mt-10 max-w-3xl mx-auto" novalidate>
            @csrf
            <!-- Education Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Education</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="text-lg sm:text-xl font-semibold text-gray-800 mt-2">What is your highest education?</p>
                    <button type="button"
                        class="mt-2 text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="What is your highest education?"
                        data-tts-tl="Ano ang pinakamataas mong natapos na grade o taon sa school?"
                        aria-label="Play audio for question">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Ano ang pinakamataas mong natapos na grade o
                    taon
                    sa school?)</p>
            </div>

            <!-- Instruction -->
            <div class="mt-8 text-center sm:text-left px-1 sm:px-4">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="text-gray-800 font-medium text-base sm:text-lg leading-snug">Choose from the pictures
                        provided and
                        click
                        your answer.</p>
                    <button type="button"
                        class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="Choose from the pictures provided and click your answer."
                        data-tts-tl="Pumili mula sa mga larawan at pindutin ang iyong sagot"
                        aria-label="Play audio for instruction">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Pumili mula sa mga larawan at pindutin ang
                    iyong sagot)</p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

                <!-- Card Template -->

                <!-- Card 1 -->
                <div id="ElementaryAudioBtn"
                    class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Elementary')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Elementary" data-tts-tl="Elementary"
                        aria-label="Play audio for Elementary option">🔊</button>
                    <img src="image/educ1.png" alt="elementary"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Elementary</h3>
                </div>

                <!-- Card 2 -->
                <div id="HighSchoolAudioBtn"
                    class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Highschool')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Highschool" data-tts-tl="Highschool"
                        aria-label="Play audio for Highschool option">🔊</button>
                    <img src="image/educ3.png" alt="highschool"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Highschool</h3>
                </div>

                <!-- Card 3 -->
                <div id="CollegeAudioBtn"
                    class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'College')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="College" data-tts-tl="College"
                        aria-label="Play audio for College option">🔊</button>
                    <img src="image/educ2.png" alt="college"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">College</h3>
                </div>

                <!-- Card 4 -->
                <div id="VocationalAudioBtn"
                    class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Vocational/Training')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Vocational or Training" data-tts-tl="Vocational o Pagsasanay"
                        aria-label="Play audio for Vocational option">🔊</button>
                    <img src="image/educ4.png" alt="vocational"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Vocational/Training</h3>
                </div>

                <!-- Other Option -->
                <div id="otherEducation"
                    class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'other')">

                    <!-- Audio Button -->
                    <button type="button" aria-label="Play audio for Other option"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm transition-transform hover:scale-110 tts-btn"
                        data-tts-en="Other, Type your answer inside the box if not in the choices"
                        data-tts-tl="Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian"
                        aria-label="Play audio for other option">🔊
                    </button>

                    <!-- Label -->
                    <label for="edu_other_text" id="edu_other_label"
                        class="block text-blue-600 font-semibold mb-2 text-sm sm:text-lg cursor-pointer">
                        Other
                    </label>

                    <!-- Description -->
                    <p class="mt-6 text-sm text-justify">
                        Type your answer inside the box if not in the choices
                    </p>
                    <p class="text-[13px] text-gray-600 italic mt-1 mb-3 text-justify">
                        (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
                    </p>

                    <!-- Input -->
                    <input id="review_other" name="edu_other_text" type="text" aria-labelledby="edu_other_label"
                        placeholder="Type your answer here"
                        class="w-full border border-gray-300 rounded-lg p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                </div>
            </div>

            <!-- Hidden input for education level (collected by register.js) -->
            <input id="edu_level" name="edu_level" type="hidden" value="" />


            <!-- School Name -->
            <div class="text-left px-2 sm:px-4 mt-16">
                <label for="school_name" class="font-semibold text-base sm:text-lg flex items-center gap-2">
                    Name of your school
                    <button type="button" aria-label="Play audio for Other option"
                        class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="Name of your school" data-tts-tl="Pangalan ng iyong paaralan"
                        aria-label="Play audio for other option">🔊
                    </button>
                </label>

                <p class="text-gray-600 italic text-sm sm:text-base mb-1">
                    (Pangalan ng iyong paaralan)
                </p>



                <input id="school_name" name="school_name" type="text" placeholder="School Name"
                    class="w-full border border-gray-300 rounded-lg p-3 sm:p-4 text-sm sm:text-base 
           focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none transition-all duration-200" />
            </div>

            <!-- Certificates -->
            <div class="mt-8 text-left px-2 sm:px-4">
                <label for="certs" class="font-semibold text-base sm:text-lg flex items-center gap-2">
                    Do you have any certificates or special trainings?
                    <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="Do you have any certificates or special trainings?"
                        data-tts-tl="May mga certificate o special training ka ba?"
                        aria-label="Play audio for other option">🔊</button>
                </label>

                <p class="text-gray-600 italic text-sm sm:text-base mb-2">(May mga certificate o special training ka
                    ba?)</p>

                <div class="flex items-center gap-6 mt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" id="certYes" name="certs" value="yes"
                            class="text-blue-600 focus:ring-blue-400 w-5 h-5" />
                        <span class="text-gray-800 text-sm sm:text-base">Yes</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" id="certNo" name="certs" value="no"
                            class="text-blue-600 focus:ring-blue-400 w-5 h-5" />
                        <span class="text-gray-800 text-sm sm:text-base">No</span>
                    </label>
                </div>

                <!-- dynamic certificates section (initially hidden) -->
                <div id="cert_section" class="hidden mt-6">
                    <input id="certificates" name="certificates" type="hidden" value="[]" />

                    <!-- Upload cert/training file -->
                    <div class="mt-8 text-left px-2 sm:px-4">
                        <label class="font-semibold text-base sm:text-lg flex items-center gap-2">
                            Please upload your Certificates/Trainings.
                            <button type="button"
                                class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                                data-tts-en="Please upload your Certificates/Trainings."
                                data-tts-tl="Paki-upload ang iyong mga certificate at training documents.">🔊</button>
                        </label>

                        <p class="text-black-600 text-sm sm:text-base mt-4 mb-2">
                           Please upload your certificates and training documents to verify your skills, knowledge, and completed trainings.
                        </p>

                        <p class="text-gray-600 italic text-sm sm:text-base mb-2">
                            (Paki-upload ang iyong mga certificate at training documents upang ma-verify ang iyong mga kasanayan at natapos na pagsasanay.)
                        </p>

                        

                        <div id="certs_container" class="space-y-4"></div>

                        <template id="cert_template">
                            <div class="cert_item mt-8 bg-white border border-gray-200 rounded-lg p-4 sm:p-5">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-semibold text-[#1E40AF] text-base sm:text-lg">Certificate /
                                        Training
                                        Details</h3>
                                    <button type="button"
                                        class="remove-cert text-[#A21A1A] text-xs sm:text-sm bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg font-medium">Remove</button>
                                </div>

                                <p class="text-gray-600 italic text-xs sm:text-sm mb-4">I-type ang impormasyon tungkol
                                    sa
                                    certificate o training.</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                    <div class="sm:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <img src="https://img.icons8.com/fluency/24/document.png"
                                                alt="Certificate icon" class="w-5 h-5" />
                                            Name of Certificate / Training
                                        </label>
                                        <input type="text" name="certificate_name"
                                            class="certificate_name w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                            placeholder="e.g. Food Safety Training" readonly/>
                                        <p class="italic text-xs text-gray-500 mt-1">(Pangalan ng training o
                                            certificate)
                                        </p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <img src="https://img.icons8.com/fluency/24/company.png"
                                                alt="Organization icon" class="w-5 h-5" />
                                            Issued By
                                        </label>
                                        <input type="text" name="issued_by"
                                            class="issued_by w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                            placeholder="e.g. TESDA, Training Center" readonly/>
                                        <p class="italic text-xs text-gray-500 mt-1">(Sino ang nagbigay ng training)
                                        </p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <img src="https://img.icons8.com/fluency/24/calendar.png"
                                                alt="Calendar icon" class="w-5 h-5" />
                                            Date Completed
                                        </label>
                                        <input type="date" name="date_completed"
                                            class="date_completed w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" readonly/>
                                        <p class="italic text-xs text-gray-500 mt-1">(Petsa kung kailan natapos)</p>
                                    </div>

                                    <div hidden>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <img src="https://img.icons8.com/fluency/24/idea.png" alt="Idea icon"
                                                class="w-5 h-5" />
                                            What did you learn?
                                        </label>
                                        <input type="text" name="training_description"
                                            class="training_description w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                            placeholder="e.g. How to clean, serve food, follow rules" />
                                        <p class="italic text-xs text-gray-500 mt-1">(Maikling paliwanag ng natutunan)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="mt-6 text-center mb-8">
                            <button id="addCertBtn" type="button"
                                class="bg-[#2E2EFF] text-white font-medium text-xs sm:text-base px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-600 transition inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Another Certificate / Training
                            </button>
                        </div>
                    </div>


                    <script>
                        (function() {
                            const fileInput = document.getElementById('cert_file');
                            const labelEl = document.getElementById('certLabel');
                            const hintEl = document.getElementById('certHint');
                            const fileDisplay = document.getElementById('fileDisplay');
                            const modal = document.getElementById('fileModal');
                            const modalContent = document.getElementById('modalContent');
                            const closeModal = document.getElementById('closeModalBtn');

                            const original = labelEl ? labelEl.textContent : '';
                            let fileURL = null;
                            let fileExt = null;

                            if (!fileInput || !labelEl) return;

                            fileInput.addEventListener('change', function() {
                                const f = this.files && this.files[0];
                                if (!f) {
                                    resetDisplay();
                                    return;
                                }

                                // Keep previously uploaded file URL for memory cleanup
                                if (fileURL) URL.revokeObjectURL(fileURL);
                                fileURL = URL.createObjectURL(f);

                                const name = f.name || '';
                                fileExt = name.split('.').pop().toLowerCase();
                                let icon = '';

                                if (['jpg', 'jpeg', 'png'].includes(fileExt)) icon = '🖼️';
                                else if (fileExt === 'pdf') icon = '📄';
                                else icon = '📁';

                                const max = 60;
                                const displayName = name.length > max ? name.slice(0, max - 3) + '...' : name;

                                labelEl.textContent = "File Uploaded:";
                                labelEl.setAttribute('title', name);
                                if (hintEl) hintEl.style.display = 'none';

                                // Display file info and buttons
                                fileDisplay.innerHTML = `
                            <div class="flex flex-wrap items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm">
                                <span class="text-2xl">${icon}</span>
                                <span class="truncate max-w-[160px] sm:max-w-[240px]">${displayName}</span>
                                <div class="flex gap-2">
                                <button id="viewFileBtn" type="button" class="bg-[#2E2EFF] hover:bg-blue-600 font-medium text-white text-xs px-3 py-1 rounded-md transition">View / Tingnan</button>
                                <button id="removeFileBtn" type="button" class="bg-[#D20103] hover:bg-red-600 font-medium text-white text-xs px-3 py-1 rounded-md transition">Remove / Alisin</button>
                                </div>
                            </div>
                            `;

                                // View button — opens preview modal
                                document.getElementById('viewFileBtn').addEventListener('click', () => {
                                    openModal(fileURL, fileExt);
                                });

                                // Remove button — clears uploaded file manually
                                document.getElementById('removeFileBtn').addEventListener('click', () => {
                                    resetDisplay();
                                    fileInput.value = '';
                                    if (fileURL) {
                                        URL.revokeObjectURL(fileURL);
                                        fileURL = null;
                                    }
                                });
                                // Persist this selection into the education-specific list (and mirror into shared key for compatibility)
                                try {
                                    const reader = new FileReader();
                                    reader.onload = function() {
                                        try {
                                            const eduKey = LS_KEY;
                                            const sharedKey = SHARED_PROOF_KEY;
                                            // update education-specific key
                                            try {
                                                const rawEdu = localStorage.getItem(eduKey);
                                                const arrEdu = rawEdu ? JSON.parse(rawEdu) : [];
                                                arrEdu.push({ name: name, type: fileExt, data: reader.result });
                                                localStorage.setItem(eduKey, JSON.stringify(arrEdu));
                                            } catch(e) { console.warn('persist edu cert failed', e); }

                                            // also append into the shared proofs array for backward compatibility
                                            try {
                                                const rawShared = localStorage.getItem(sharedKey);
                                                const arrShared = rawShared ? JSON.parse(rawShared) : [];
                                                arrShared.push({ name: name, type: fileExt, data: reader.result });
                                                localStorage.setItem(sharedKey, JSON.stringify(arrShared));
                                            } catch(e) { /* non-fatal */ }

                                            // refresh shared list UI if available
                                            if (typeof window.showFileList === 'function') window.showFileList(JSON.parse(localStorage.getItem(sharedKey) || '[]'));
                                            if (typeof window.hideFileInfo === 'function') window.hideFileInfo();
                                            const fileuploadSection = document.getElementById('fileuploadSection'); if (fileuploadSection) fileuploadSection.style.display = 'block';
                                        } catch (e) { console.warn('persist cert_file failed', e); }
                                    };
                                    reader.readAsDataURL(f);
                                } catch (e) { console.warn('persist cert_file setup failed', e); }
                            });

                            // Open modal preview 
                            function openModal(url, ext) {
                                modal.classList.remove('hidden');
                                modalContent.innerHTML = '';

                                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                                    const img = document.createElement('img');
                                    img.src = url;
                                    img.alt = "Uploaded Image";
                                    img.className = "max-h-[80vh] max-w-full object-contain rounded-lg";
                                    modalContent.appendChild(img);
                                } else if (ext === 'pdf') {
                                    const iframe = document.createElement('iframe');
                                    iframe.src = url;
                                    iframe.className = "w-full h-[80vh] rounded-lg border-0";
                                    modalContent.appendChild(iframe);
                                } else {
                                    modalContent.innerHTML = `
                                <p class="text-gray-700 text-center"> This file type cannot be previewed.<br>
                                (Hindi maaaring i-preview ang uri ng file na ito.)
                            </p>`;
                                }
                            }

                            // Close modal by clicking outside
                            modal.addEventListener('click', (e) => {
                                if (e.target === modal) {
                                    modal.classList.add('hidden');
                                    modalContent.innerHTML = '';
                                }
                            });

                            // Reset uploaded file display (only triggered by Remove button)
                            function resetDisplay() {
                                labelEl.textContent = original;
                                labelEl.removeAttribute('title');
                                if (hintEl) hintEl.style.display = '';
                                if (fileDisplay) fileDisplay.innerHTML = '';
                            }
                            // Toggle file upload enable/disable based on certs radio
                            try {
                                const certButtonEl = document.getElementById('cert_file_button');
                                const radios = document.querySelectorAll('input[name="certs"]');
                                const toggleFile = (val) => {
                                    try {
                                        if (!fileInput) return;
                                        if (String(val).toLowerCase() === 'no') {
                                            // clear any chosen file and hide preview
                                            fileInput.value = '';
                                            resetDisplay();
                                            fileInput.disabled = true;
                                            if (certButtonEl) {
                                                certButtonEl.classList.add('opacity-50');
                                                certButtonEl.classList.add('pointer-events-none');
                                                certButtonEl.setAttribute('aria-disabled', 'true');
                                            }
                                        } else {
                                            fileInput.disabled = false;
                                            if (certButtonEl) {
                                                certButtonEl.classList.remove('opacity-50');
                                                certButtonEl.classList.remove('pointer-events-none');
                                                certButtonEl.removeAttribute('aria-disabled');
                                            }
                                        }
                                    } catch (e) {
                                        console.debug('cert toggle error', e);
                                    }
                                };
                                radios.forEach(r => r.addEventListener('change', (ev) => toggleFile(ev.target.value)));
                                // initialise based on current selection
                                const sel = document.querySelector('input[name="certs"]:checked');
                                if (sel) toggleFile(sel.value);
                            } catch (e) {
                                console.debug('certs radio bind failed', e);
                            }
                        })();
                    </script>
                </div>

                <!-- Next Button -->
                <div class="flex flex-col items-center justify-center mt-10 mb-6 space-y-3 px-2">
                    <div id="educError" class="text-red-600 text-sm text-center"></div>
                    <button id="educNext" type="button"
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

    <!-- 🔹 Modal (Shared for uploads preview) -->
    <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
    <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
        <button id="closeModalBtn" type="button" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
        <div id="modalContent" class="p-2 text-center"></div>
    </div>
    </div>
    <script>
        // Modal close handlers: close button, outside click, and Escape key
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const modal = document.getElementById('fileModal');
                const modalContent = document.getElementById('modalContent');
                const closeBtn = document.getElementById('closeModalBtn');

                function hideModal() {
                    try {
                        if (modal) modal.classList.add('hidden');
                        if (modalContent) modalContent.innerHTML = '';
                    } catch (e) {}
                }

                if (closeBtn) closeBtn.addEventListener('click', function(e) { e.preventDefault(); hideModal(); });

                if (modal) modal.addEventListener('click', function(e) {
                    // clicking on backdrop should close
                    if (e.target === modal) hideModal();
                });

                // Escape key closes modal
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') hideModal();
                });
            } catch (err) {
                console.warn('modal handlers failed to bind', err);
            }
        });
    </script>

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


                // clear any error text
                const err = document.getElementById('educError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectEducationChoice error', e);
            }
        }
    </script>
    <script src="{{ asset('js/register.js') }}"></script>

    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.tts-btn');
            const preferredEnglishVoiceName =
                'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
            let preferredEnglishVoice = null;
            let preferredTagalogVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName) ||
                    availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) ||
                    null;
                preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName) ||
                    availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name)) ||
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
                if (window.speechSynthesis) {
                    window.speechSynthesis.cancel();
                }
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
                    // nothing to speak
                    if (!textEn && !textTl) return;

                    // If same button clicked while speaking, stop
                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn ===
                        btn) {
                        stopSpeaking();
                        return;
                    }

                    // Stop any existing speech then speak new text(s)
                    stopSpeaking();

                    // Small timeout to ensure previous utterance canceled
                    setTimeout(function() {
                        if (!window.speechSynthesis) return;

                        // Helper to pick voice for a given language (or selected by user)
                        function voiceFor(langHint) {
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint
                                    .includes('tagalog')) {
                                    if (preferredTagalogVoice) return preferredTagalogVoice;
                                    return chooseVoiceForLang('tl');
                                }
                                if (hint.startsWith('en')) {
                                    if (preferredEnglishVoice) return preferredEnglishVoice;
                                    return chooseVoiceForLang('en');
                                }
                            }
                            return preferredEnglishVoice || chooseVoiceForLang('en') || (
                                availableVoices.length ? availableVoices[0] : null);
                        }

                        // Build utterances sequence: English first (if any), then Tagalog
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

                        // Attach lifecycle handlers to the sequence
                        seq[0].onstart = function() {
                            btn.classList.add('speaking');
                            btn.setAttribute('aria-pressed', 'true');
                            currentBtn = btn;
                        };

                        // chain subsequent utterances
                        for (let i = 0; i < seq.length; i++) {
                            const ut = seq[i];
                            ut.onerror = function() {
                                if (btn) btn.classList.remove('speaking');
                                if (btn) btn.removeAttribute('aria-pressed');
                                currentBtn = null;
                            };
                            if (i < seq.length - 1) {
                                ut.onend = function() {
                                    // speak next
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

                        // start sequence
                        window.speechSynthesis.speak(seq[0]);
                    }, 50);
                });

                // also allow Enter/Space to trigger
                btn.addEventListener('keydown', function(ev) {
                    if (ev.key === 'Enter' || ev.key === ' ') {
                        ev.preventDefault();
                        btn.click();
                    }
                });
            });

            // Stop speech when navigating away or reloading
            window.addEventListener('beforeunload', function() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });
            // populate voices now or when they change
            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function() {
                    populateVoices();
                };
            }

            // No preview UI: when voices are populated we attempt to use the preferred Microsoft AvaMultilingual voice
        });
    </script>
    <script>
        (function() {
            const fileInput = document.getElementById("proof");
            const fileInfo = document.getElementById("proofFileInfo");
            const modal = document.getElementById("fileModal");
            const modalContent = document.getElementById("modalContent");
            const closeModal = document.getElementById("closeModalBtn");
            const hintEl = document.getElementById("proofHint");
            const fileuploadSection = document.getElementById("fileuploadSection");

            const LS_KEY = "uploadedCertificates_education"; // education-specific key: array of {name,type,data}
            const SHARED_PROOF_KEY = "uploadedProofs_proof"; // legacy/shared proofs (kept for compatibility)
            const MAX_BYTES = 5 * 1024 * 1024; // 5MB per file

            function readFileAsDataURL(file) {
                return new Promise((resolve, reject) => {
                    const r = new FileReader();
                    r.onerror = () => reject(new Error("file read error"));
                    r.onload = () => resolve(r.result);
                    r.readAsDataURL(file);
                });
            }

            function getFileType(name) {
                return String(name || "").split(".").pop().toLowerCase();
            }

            window.loadSavedProofs = function() {
                try {
                    const raw = localStorage.getItem(LS_KEY);
                    let arr = [];
                    if (raw) arr = JSON.parse(raw) || [];

                    // Prevent admin uploads from leaking into Education list:
                    // if admin page has saved names, exclude them here.
                    const adminProofName = localStorage.getItem('admin_uploaded_proof_name');
                    const adminMedName = localStorage.getItem('admin_uploaded_med_name');
                    const adminNames = [];
                    if (adminProofName) adminNames.push(String(adminProofName));
                    if (adminMedName) adminNames.push(String(adminMedName));
                    if (adminNames.length && Array.isArray(arr)) {
                        arr = arr.filter(it => !(it && it.name && adminNames.includes(String(it.name))));
                    }
                    return arr;
                } catch (e) {
                    return [];
                }
            }

            window.saveProofs = function(list) {
                try {
                    localStorage.setItem(LS_KEY, JSON.stringify(list || []));
                } catch (e) {
                    console.warn("saveProofs failed", e);
                }
            }

            window.hideFileInfo = function() {
                if (!fileInfo) return;
                fileInfo.classList.add("hidden");
                fileInfo.innerHTML = "";
                if (hintEl) hintEl.style.display = "";
            }

            window.openModalPreview = function(name, dataUrl, type) {
                if (!modal || !modalContent) return;
                modalContent.innerHTML = `<h3 class="font-semibold mb-2">${name}</h3>`;
                if (["jpg", "jpeg", "png"].includes(type)) {
                    modalContent.innerHTML +=
                        `<img src="${dataUrl}" alt="${name}" class="max-h-[70vh] mx-auto rounded-lg shadow" />`;
                } else if (type === "pdf") {
                    modalContent.innerHTML +=
                        `<iframe src="${dataUrl}" class="w-full h-[70vh] rounded-lg border" title="${name}"></iframe>`;
                } else {
                    modalContent.innerHTML += `<p class="text-gray-700">Preview not available for this file type.</p>`;
                }
                modal.classList.remove("hidden");
            }

            window.showFileList = function(list) {
                if (!fileInfo) return;
                if (!Array.isArray(list) || !list.length) {
                    hideFileInfo();
                    return;
                }
                if (hintEl) hintEl.style.display = "none";
                fileInfo.classList.remove("hidden");

                const html = list.map((f, idx) => {
                    const icon = f.type === "pdf" ? "📄" : "🖼️";
                    const name = (f.name || "").length > 70 ? (f.name || "").slice(0, 67) + "..." : f.name;
                    return `
            <div class="w-full bg-white rounded-lg border shadow-sm p-3 mb-3 flex items-center justify-between gap-4" data-idx="${idx}">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="text-3xl">${icon}</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm text-gray-700 truncate">${name}</div>
                        <div class="text-xs text-gray-500 mt-1">${(f.type || '').toUpperCase()}</div>
                    </div>
                </div>
                <div class="flex gap-2 ml-4">
                    <button data-action="view" data-idx="${idx}" type="button" class="view-file bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
                    <button data-action="remove" data-idx="${idx}" type="button" class="remove-file bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button>
                </div>
            </div>
            `;
                }).join("");
                fileInfo.style.display = "block";
                fileInfo.style.overflowX = "visible";
                fileInfo.style.padding = "0.5rem";
                fileInfo.innerHTML = html;

                // bind handlers
                fileInfo.querySelectorAll('[data-action="view"]').forEach(b => {
                    b.addEventListener('click', (ev) => {
                        const idx = Number(ev.currentTarget.dataset.idx);
                        const saved = loadSavedProofs();
                        const item = saved[idx];
                        if (item) openModalPreview(item.name, item.data, item.type);
                    });
                });
                fileInfo.querySelectorAll('[data-action="remove"]').forEach(b => {
                    b.addEventListener('click', (ev) => {
                        const idx = Number(ev.currentTarget.dataset.idx);
                        const saved = loadSavedProofs();
                        if (!saved || !saved.length) return;
                        saved.splice(idx, 1);
                        saveProofs(saved);
                        showFileList(saved);
                        if (!saved.length) {
                            // hide if user had selected No
                            const sel = document.querySelector('input[name="certs"]:checked');
                            if (!sel || sel.value !== 'yes') {
                                if (fileuploadSection) fileuploadSection.style.display = "none";
                            } else {
                                hideFileInfo();
                            }
                        }
                        if (typeof hideFileInfo === "function") hideFileInfo();
                        console.log("File input cleared & education localStorage removed");
                    } else {
                        fileUploadSection.style.display = "block"; // show section
                        console.log("certYes selected → fileuploadSection shown");
                    }
                }
            };

            // Initial check on page load
            updateSectionVisibility();

            // Add change listeners to all cert radios
            certRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    // Save selection to localStorage
                    localStorage.setItem("review_certs", radio.value);
                    console.log("Saved cert:", radio.value);

                    // Update visibility & clear file if needed
                    updateSectionVisibility();
                });
            });

        });
    </script>

    <script>
        (function() {
            const section = document.getElementById('cert_section');
            const container = document.getElementById('certs_container');
            const tpl = document.getElementById('cert_template');
            const hidden = document.getElementById('certificates');
            const addBtn = document.getElementById('addCertBtn');
            const radios = Array.from(document.querySelectorAll('input[name="certs"]'));

            if (!section || !container || !tpl || !hidden || !addBtn || !radios.length) return;

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

            function debounce(fn, wait) {
                let t;
                return function() {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, arguments), wait);
                };
            }

            function syncFromUI() {
                const list = [];
                Array.from(container.children).forEach(block => {
                    const name = block.querySelector('input[name="certificate_name"]')?.value?.trim() || '';
                    const issued = block.querySelector('input[name="issued_by"]')?.value?.trim() || '';
                    const date = block.querySelector('input[name="date_completed"]')?.value?.trim() || '';
                    const desc = block.querySelector('input[name="training_description"]')?.value?.trim() || '';
                    if (name || issued || date || desc) list.push({
                        certificate_name: name,
                        issued_by: issued,
                        date_completed: date,
                        training_description: desc
                    });
                });
                writeHidden(list);
            }

            const debouncedSync = debounce(syncFromUI, 150);

            function createUploadSlotForNode(targetNode) {
                const suf = String(Date.now()) + Math.floor(Math.random()*1000);
                const slot = document.createElement('div');
                slot.className = 'mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3';

                const left = document.createElement('div');
                left.className = 'flex-1';
                const label = document.createElement('p');
                label.className = 'font-medium text-gray-800 text-sm sm:text-base';
                label.innerHTML = `<span id="validcertLabel_${suf}" class="flex items-center gap-2"><span>Upload File (Image or PDF)</span></span>`;
                const hint = document.createElement('p');
                hint.id = `validcertHint_${suf}`;
                hint.className = 'text-gray-600 italic text-xs sm:text-sm mt-1';
                hint.innerHTML = '(Mag-upload ng larawan o PDF ng iyong Certificates/Trainings)<br /><br />Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b><br />';
                const display = document.createElement('div');
                display.id = `validcertDisplay_${suf}`;
                const fileuploadWrap = document.createElement('div');
                fileuploadWrap.id = `fileuploadSection_${suf}`;
                fileuploadWrap.className = 'mt-3';
                const proofInfo = document.createElement('div');
                proofInfo.id = `proofFileInfo_${suf}`;
                fileuploadWrap.appendChild(proofInfo);
                left.appendChild(label);
                left.appendChild(hint);
                left.appendChild(display);
                left.appendChild(fileuploadWrap);

                const right = document.createElement('div');
                right.className = 'flex-shrink-0 flex flex-col items-center sm:items-end space-y-2';
                const lab = document.createElement('label');
                lab.htmlFor = `validcertFile_${suf}`;
                lab.className = 'cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition';
                lab.textContent = '📁 Choose File / Pumili ng File';
                const inp = document.createElement('input');
                inp.type = 'file'; inp.accept = '.jpg,.jpeg,.png,.pdf'; inp.id = `validcertFile_${suf}`; inp.className = 'hidden';
                const verr = document.createElement('div');
                verr.className = 'upload-error w-full text-sm text-right';
                right.appendChild(lab); right.appendChild(inp); right.appendChild(verr);

                slot.appendChild(left); slot.appendChild(right);

                // wire input -> targetNode hidden fields and display
                inp.addEventListener('change', function() {
                    const f = this.files && this.files[0];
                    if (!f) return;
                    const name = f.name || '';
                    const type = String(name.split('.').pop()||'').toLowerCase();
                    if (!['jpg','jpeg','png','pdf'].includes(type)) { alert('Invalid file type. Only JPG, PNG, or PDF allowed.'); this.value=''; return; }
                    if (f.size > 5 * 1024 * 1024) { alert('File too large. Max 5MB.'); this.value=''; return; }
                    const reader = new FileReader();
                    reader.onload = function(e){
                        try{
                            const data = e.target.result;
                            // write into targetNode hidden inputs
                            const hdData = targetNode.querySelector('input[name="certificate_file_data"]');
                            const hdName = targetNode.querySelector('input[name="certificate_file_name"]');
                            const hdType = targetNode.querySelector('input[name="certificate_file_type"]');
                            if (hdData) hdData.value = data;
                            if (hdName) hdName.value = name;
                            if (hdType) hdType.value = type;
                            // render proofInfo
                            proofInfo.innerHTML = `<div class="flex flex-wrap items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm"><span class="text-2xl">${['jpg','jpeg','png'].includes(type)?'🖼️':'📄'}</span><span class="truncate max-w-[160px] sm:max-w-[240px]">${name.length>60?name.slice(0,57)+'...':name}</span><div class="flex gap-2"><button type="button" class="view-file bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button><button type="button" class="remove-file bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button></div></div>`;
                            // hook view/remove
                            const vb = proofInfo.querySelector('.view-file');
                            const rb = proofInfo.querySelector('.remove-file');
                            if (vb) vb.addEventListener('click', function(){ if (typeof window.openModalPreview === 'function') return window.openModalPreview(name, data, type); const modal = document.getElementById('fileModal'); const mc = document.getElementById('modalContent'); if(mc) mc.innerHTML = `<h3 class="font-semibold mb-2">${name}</h3>` + (['jpg','jpeg','png'].includes(type)?`<img src="${data}" class="max-h-[70vh] mx-auto rounded-lg"/>`:(type==='pdf'?`<iframe src="${data}" class="w-full h-[70vh] rounded-lg border" title="${name}"></iframe>`:'')); if(modal) modal.classList.remove('hidden'); });
                            if (rb) rb.addEventListener('click', function(){ if (hdData) hdData.value=''; if (hdName) hdName.value=''; if (hdType) hdType.value=''; proofInfo.innerHTML=''; inp.value='';
                                // sync
                                try{ const evt = new Event('input',{bubbles:true}); targetNode.querySelectorAll('input').forEach(i=>i.dispatchEvent(evt)); }catch(e){}
                            });
                            // trigger sync
                            try{ const evt = new Event('input',{bubbles:true}); targetNode.querySelectorAll('input').forEach(i=>i.dispatchEvent(evt)); }catch(e){}
  
                            // OCR processing
                            debugger;
                            const datas = {
                                type: 'certificate_proof',
                                ocr_name: f.name,
                                ocr_data: reader.result,
                                ocr_type: type
                            };

                            fetch('db/ocr-validation.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(datas)
                            })
                            .then(response => {
                                // Always try to parse JSON, even on errors
                                return response.json().then(jsonData => ({
                                    ok: response.ok,
                                    status: response.status,
                                    body: jsonData
                                }));
                            })
                            .then(res => {
                                if (res.ok) {
                                    debugger;
                                    console.log('OCR Result:', res.body);
                                    if (res.body.data.ocrtype == 'certificate_proof') {
                                        alert('Cert Name: ' + res.body.data.ai_data.cert_name + ' Issued By: ' + res.body.data.ai_data.issued_by + ' Date Completed: ' + res.body.data.ai_data.date_completed + ' OCR Type: ' + res.body.data.ocrtype + ' processed successfully.');
                                    }
                                    else {
                                        alert('OCR Type: ' + res.body.data.ocrtype + ' processed successfully.');
                                    }
                                
                                } else {
                                    // ❌ Error
                                    alert(`Error ${res.status}: ${res.body.message || 'Unknown error'}`);
                                }
                            })
                            .catch(err => {
                                console.error('Fetch error:', err);
                                alert('Failed to fetch OCR data.');
                            });  

                        }catch(err){ console.warn(err); }
                    };



            // init UI from storage
            (function init() {
                const saved = window.loadSavedProofs();
                if (saved && saved.length) {
                    if (fileuploadSection) fileuploadSection.style.display = "block";
                    window.showFileList(saved);
                } else {
                    window.hideFileInfo();
                    if (fileuploadSection) fileuploadSection.style.display = "none";
                }
            })();

            // file selection (multiple)
            if (fileInput) {
                fileInput.addEventListener("change", async function() {
                    const files = Array.from(this.files || []);
                    if (!files.length) return;
                    const saved = loadSavedProofs();
                    for (const f of files) {
                        const ext = getFileType(f.name);
                        if (!["jpg", "jpeg", "png", "pdf"].includes(ext)) {
                            alert("Invalid file type. Only JPG, PNG, or PDF allowed.");
                            continue;
                        }
                        if (f.size > MAX_BYTES) {
                            alert(`${f.name} is too large. Max file size is 5MB.`);
                            continue;
                        }
                        try {
                            const data = await readFileAsDataURL(f);
                            saved.push({
                                name: f.name,
                                type: ext,
                                data
                            });
                        } catch (e) {
                            console.warn("Failed to read file", f.name, e);
                        }
                    }
                    saveProofs(saved);
                    showFileList(saved);
                    fileInput.value = "";
                    if (fileuploadSection) fileuploadSection.style.display = "block";
                });
            }

            // modal close handlers
            if (closeModal) {
                closeModal.addEventListener("click", (e) => {
                    e.preventDefault();
                    modal.classList.add("hidden");
                    modalContent.innerHTML = "";
                });
            }
            if (modal) {
                modal.addEventListener("click", (e) => {
                    if (e.target === modal) {
                        modal.classList.add("hidden");
                        modalContent.innerHTML = "";
                    }
                });
            }

            // radio visibility logic already present in file — ensure it uses same LS key
            document.querySelectorAll('input[name="certs"]').forEach(radio => {
                radio.addEventListener('change', (ev) => {
                    const val = ev.target.value;
                    if (fileuploadSection) {
                        if (val === 'yes') {
                            fileuploadSection.style.display = "block";
                            if (fileInput) fileInput.disabled = false;
                        } else {
                            fileuploadSection.style.display = "none";
                            if (fileInput) fileInput.value = "";
                            localStorage.removeItem(LS_KEY);
                            hideFileInfo();
                        }
                    }
                    try {
                        localStorage.setItem("review_certs", val);
                    } catch (e) {}
                });
            });

        })();
    </script>

    <script>
        // Auto-check 'Yes' for certificates when any uploaded file exists (shared or per-entry)
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const rawShared = localStorage.getItem('uploadedProofs_proof');
                const shared = rawShared ? (JSON.parse(rawShared) || []) : [];
                const hidden = document.getElementById('certificates');
                const canon = hidden ? (JSON.parse(hidden.value || '[]') || []) : [];
                const hasShared = Array.isArray(shared) && shared.length > 0;
                const hasCanonFile = Array.isArray(canon) && canon.some(it => it && (it.certificate_file_data || it.certificate_file_name));
                if (hasShared || hasCanonFile) {
                    const yes = document.querySelector('input[name="certs"][value="yes"]');
                    if (yes && !yes.checked) {
                        yes.checked = true;
                        yes.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            } catch (e) {
                console.warn('auto-check certs failed', e);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            (function() {
                const formEl = document.getElementById('educationForm');
                const btn = document.getElementById('educNext');
                const nextUrl = '{{ route('registerworkexpinfo') }}';
                if (!formEl || !btn) return;

                function showSummary(msg) {
                    const e = document.getElementById('educError');
                    if (e) e.textContent = msg || '';
                }

                function clearInline() {
                    ['school_name', 'review_other', 'proof', 'edu_level', 'certificates'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.classList.remove('border-red-500');
                        if (el && el.parentNode) {
                            const old = el.parentNode.querySelector('.field-error');
                            if (old) old.remove();
                        }
                    });
                }

                function validate() {
                    clearInline();
                    showSummary('');
                    const errors = [];
                    const eduVal = (document.getElementById('edu_level') && document.getElementById('edu_level')
                        .value || '').toString().trim();
                    if (!eduVal) errors.push({
                        id: 'edu_level',
                        msg: 'Please select your highest education.'
                    });
                    const school = (document.getElementById('school_name') && document.getElementById(
                        'school_name').value || '').toString().trim();
                    if (!school) errors.push({
                        id: 'school_name',
                        msg: 'Please enter your school name.'
                    });

                    const certSel = document.querySelector('input[name="certs"]:checked');
                    const certValue = certSel ? certSel.value : null;
                    if (certValue === 'yes') {
                        let ok = false;
                        try {
                            // 1) check canonical hidden certificates (may include file data)
                            const raw = document.getElementById('certificates') ? document.getElementById('certificates').value : '[]';
                            const arr = JSON.parse(raw || '[]');
                            if (Array.isArray(arr) && arr.length) {
                                ok = arr.some(it => it && (
                                    String(it.certificate_name || '').trim() ||
                                    String(it.issued_by || '').trim() ||
                                    String(it.date_completed || '').trim() ||
                                    String(it.training_description || '').trim() ||
                                    String(it.certificate_file_data || '').trim()
                                ));
                            }

                            // 2) if no canonical entries with content, check shared/local uploaded proofs
                            if (!ok) {
                                try {
                                    const shared = JSON.parse(localStorage.getItem('uploadedProofs_proof') || '[]') || [];
                                    if (Array.isArray(shared) && shared.length) ok = true;
                                } catch (e) {
                                    // ignore
                                }
                            }

                            // final fallback: if any preview/view button exists on the page,
                            // treat that as evidence that a file was uploaded (handles timing/init races)
                            if (!ok) {
                                try {
                                    const hasPreviewButton = !!document.querySelector('.view-file, .viewBtn');
                                    if (hasPreviewButton) ok = true;
                                } catch (e) {}
                            }
                        } catch (e) {
                            ok = false;
                        }
                        if (!ok) errors.push({
                            id: 'certificates',
                            msg: 'Please add at least one Certificate / Training entry.'
                        });
                    }
                    return errors;
                }

                function saveAndRedirect() {
                    try {
                        btn.classList.add('opacity-60');
                        const eduObj = {
                            edu_level: (document.getElementById('edu_level')?.value || '').toString(),
                            edu_other_text: (document.getElementById('review_other')?.value || '')
                                .toString(),
                            school_name: (document.getElementById('school_name')?.value || '').toString(),
                            certs: (document.querySelector('input[name="certs"]:checked')?.value || '')
                                .toString(),
                            certificates: []
                        };

                        // read hidden serialized certificates (maintains existing behavior)
                        try {
                            const raw = document.getElementById('certificates') ? document.getElementById(
                                'certificates').value : '[]';
                            const arr = JSON.parse(raw || '[]');
                            if (Array.isArray(arr)) eduObj.certificates = arr;
                        } catch (e) {
                            eduObj.certificates = [];
                        }

                        // normalize keys to the shape registration-data.php expects
                        eduObj.certificates = (eduObj.certificates || []).map(c => ({
                            certificate_name: c.certificate_name ?? c.name ?? c.title ?? '',
                            issued_by: c.issued_by ?? c.issuer ?? c.issuedBy ?? '',
                            date_completed: c.date_completed ?? c.date ?? c.completed ?? '',
                            training_description: c.training_description ?? c.description ?? c
                                .what_you_learned ?? ''
                        })).filter(x => x.certificate_name || x.issued_by || x.date_completed || x
                            .training_description);

                        // persist the education/profile + canonical certificate array
                        localStorage.setItem('education_profile', JSON.stringify(eduObj));
                        localStorage.setItem('edu_level', eduObj.edu_level);
                        localStorage.setItem('school_name', eduObj.school_name);
                        localStorage.setItem('review_certs', eduObj.certs);
                        localStorage.setItem('education_certificates', JSON.stringify(eduObj.certificates));

                        // route expects GET — follow workexp page behavior
                        window.location.href = nextUrl;
                    } catch (err) {
                        console.error('education save failed', err);
                        btn.classList.remove('opacity-60');
                    }
                }

                btn.addEventListener('click', function(ev) {
                    ev.preventDefault();
                    const errs = validate();
                    if (errs.length) {
                        showSummary(errs[0].msg);
                        if (btn) btn.classList.remove('opacity-60');
                        const el = document.getElementById(errs[0].id) || document.getElementById(
                            'edu_level') || document.getElementById('school_name');
                        if (el && typeof el.scrollIntoView === 'function') el.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        return;
                    }
                    saveAndRedirect();
                });

                formEl.addEventListener('submit', function(ev) {
                    ev.preventDefault();
                    btn.click();
                });
            })();
        });
    </script>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            const fileInput = document.getElementById("proof");
            const certRadios = document.querySelectorAll('input[name="certs"]');

            if (!fileInput || certRadios.length === 0) return;

            const updateFileInput = () => {
                const selected = document.querySelector('input[name="certs"]:checked');
                if (selected) {
                    if (selected.value === "no") {
                        fileInput.disabled = false;
                        fileInput.classList.remove("bg-blue-600", "hover:bg-blue-700");
                        fileInput.classList.add("bg-gray-400", "cursor-not-allowed");
                        console.log("Selected cert is 'no' → file input disabled and gray");
                    } else {
                        fileInput.disabled = false;
                        fileInput.classList.remove("bg-gray-400", "cursor-not-allowed");
                        fileInput.classList.add("bg-blue-600", "hover:bg-blue-700", "cursor-pointer");
                        console.log("Selected cert is 'yes' → file input enabled and blue");
                    }
                }
            };

            // Initial check on page load
            updateFileInput();

            // Add change listeners to all cert radios
            certRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    localStorage.setItem("review_certs", radio.value);
                    console.log("Saved cert:", radio.value);
                    updateFileInput();
                });
            });
        });
    </script>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            const fileUploadSection = document.getElementById("fileuploadSection");
            const certRadios = document.querySelectorAll('input[name="certs"]');
            const fileInput = document.getElementById("proof");

            if (!fileUploadSection || certRadios.length === 0) return;

            const updateSectionVisibility = () => {
                const selected = document.querySelector('input[name="certs"]:checked');
                if (selected) {
                    if (selected.id === "certNo") {
                        fileUploadSection.style.display = "none"; // hide section
                        console.log("certNo selected → fileuploadSection hidden");

                        // Clear file input & localStorage
                        if (fileInput) fileInput.value = "";
                        try {
                            // remove education canonical array
                            localStorage.removeItem(LS_KEY);
                            // also remove legacy single-file keys if they exist (safe no-op otherwise)
                            ['uploadedProofData1', 'uploadedProofType1', 'uploadedProofName1',
                                'uploadedProofData', 'uploadedProofName', 'uploadedProofType'
                            ].forEach(k => {
                                try {
                                    localStorage.removeItem(k);
                                } catch (e) {}
                            });
                        } catch (e) {
                            console.warn('education cleanup failed', e);
                        }
                        if (typeof hideFileInfo === "function") hideFileInfo();
                        console.log("File input cleared & education localStorage removed");
                    } else {
                        fileUploadSection.style.display = "block"; // show section
                        console.log("certYes selected → fileuploadSection shown");
                    }
                }
            };

            // Initial check on page load
            updateSectionVisibility();

            // Add change listeners to all cert radios
            certRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    // Save selection to localStorage
                    localStorage.setItem("review_certs", radio.value);
                    console.log("Saved cert:", radio.value);

                    // Update visibility & clear file if needed
                    updateSectionVisibility();
                });
            });

        });
    </script>

    <script>
        (function() {
            const section = document.getElementById('cert_section');
            const container = document.getElementById('certs_container');
            const tpl = document.getElementById('cert_template');
            const hidden = document.getElementById('certificates');
            const addBtn = document.getElementById('addCertBtn');
            const radios = Array.from(document.querySelectorAll('input[name="certs"]'));

            if (!section || !container || !tpl || !hidden || !addBtn || !radios.length) return;

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

            function debounce(fn, wait) {
                let t;
                return function() {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, arguments), wait);
                };
            }

            function syncFromUI() {
                const list = [];
                Array.from(container.children).forEach(block => {
                    const name = block.querySelector('input[name="certificate_name"]')?.value?.trim() || '';
                    const issued = block.querySelector('input[name="issued_by"]')?.value?.trim() || '';
                    const date = block.querySelector('input[name="date_completed"]')?.value?.trim() || '';
                    const desc = block.querySelector('input[name="training_description"]')?.value?.trim() || '';
                    const file_name = block.querySelector('input[name="certificate_file_name"]')?.value?.trim() || '';
                    const file_data = block.querySelector('input[name="certificate_file_data"]')?.value || '';
                    const file_type = block.querySelector('input[name="certificate_file_type"]')?.value?.trim() || '';

                    // include entry if any visible fields OR a file is attached
                    if (name || issued || date || desc || file_name || file_data) {
                        const entry = {
                            certificate_name: name,
                            issued_by: issued,
                            date_completed: date,
                            training_description: desc
                        };
                        if (file_name || file_data) {
                            entry.certificate_file_name = file_name;
                            entry.certificate_file_data = file_data;
                            entry.certificate_file_type = file_type || (file_name.split('.').pop()||'').toLowerCase();
                        }
                        list.push(entry);
                    }
                });
                writeHidden(list);
            }

            const debouncedSync = debounce(syncFromUI, 150);

            function createUploadSlotForNode(targetNode) {
                const suf = String(Date.now()) + Math.floor(Math.random()*1000);
                const slot = document.createElement('div');
                slot.className = 'mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3';

                const left = document.createElement('div');
                left.className = 'flex-1';
                const label = document.createElement('p');
                label.className = 'font-medium text-gray-800 text-sm sm:text-base';
                label.innerHTML = `<span id="validcertLabel_${suf}" class="flex items-center gap-2"><span>Upload File (Image or PDF)</span></span>`;
                const hint = document.createElement('p');
                hint.id = `validcertHint_${suf}`;
                hint.className = 'text-gray-600 italic text-xs sm:text-sm mt-1';
                hint.innerHTML = '(Mag-upload ng larawan o PDF ng iyong Certificates/Trainings)<br /><br />Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b><br />';
                const display = document.createElement('div');
                display.id = `validcertDisplay_${suf}`;
                const fileuploadWrap = document.createElement('div');
                fileuploadWrap.id = `fileuploadSection_${suf}`;
                fileuploadWrap.className = 'mt-3';
                const proofInfo = document.createElement('div');
                proofInfo.id = `proofFileInfo_${suf}`;
                fileuploadWrap.appendChild(proofInfo);
                left.appendChild(label);
                left.appendChild(hint);
                left.appendChild(display);
                left.appendChild(fileuploadWrap);

                const right = document.createElement('div');
                right.className = 'flex-shrink-0 flex flex-col items-center sm:items-end space-y-2';
                const lab = document.createElement('label');
                lab.htmlFor = `validcertFile_${suf}`;
                lab.className = 'cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition';
                lab.textContent = '📁 Choose File / Pumili ng File';
                const inp = document.createElement('input');
                inp.type = 'file'; inp.accept = '.jpg,.jpeg,.png,.pdf'; inp.id = `validcertFile_${suf}`; inp.className = 'hidden';
                const verr = document.createElement('div');
                verr.className = 'upload-error w-full text-sm text-right';
                right.appendChild(lab); right.appendChild(inp); right.appendChild(verr);

                slot.appendChild(left); slot.appendChild(right);

                // wire input -> targetNode hidden fields and display
                inp.addEventListener('change', function() {
                    const f = this.files && this.files[0];
                    if (!f) return;
                    const name = f.name || '';
                    const type = String(name.split('.').pop()||'').toLowerCase();
                    if (!['jpg','jpeg','png','pdf'].includes(type)) { alert('Invalid file type. Only JPG, PNG, or PDF allowed.'); this.value=''; return; }
                    if (f.size > 5 * 1024 * 1024) { alert('File too large. Max 5MB.'); this.value=''; return; }
                    const reader = new FileReader();
                    reader.onload = function(e){
                        try{
                            const data = e.target.result;
                            // write into targetNode hidden inputs
                            const hdData = targetNode.querySelector('input[name="certificate_file_data"]');
                            const hdName = targetNode.querySelector('input[name="certificate_file_name"]');
                            const hdType = targetNode.querySelector('input[name="certificate_file_type"]');
                            if (hdData) hdData.value = data;
                            if (hdName) hdName.value = name;
                            if (hdType) hdType.value = type;
                            // render proofInfo
                            proofInfo.innerHTML = `<div class="flex flex-wrap items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm"><span class="text-2xl">${['jpg','jpeg','png'].includes(type)?'🖼️':'📄'}</span><span class="truncate max-w-[160px] sm:max-w-[240px]">${name.length>60?name.slice(0,57)+'...':name}</span><div class="flex gap-2"><button type="button" class="view-file bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button><button type="button" class="remove-file bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button></div></div>`;
                            // hook view/remove
                            const vb = proofInfo.querySelector('.view-file');
                            const rb = proofInfo.querySelector('.remove-file');
                            if (vb) vb.addEventListener('click', function(){ if (typeof window.openModalPreview === 'function') return window.openModalPreview(name, data, type); const modal = document.getElementById('fileModal'); const mc = document.getElementById('modalContent'); if(mc) mc.innerHTML = `<h3 class="font-semibold mb-2">${name}</h3>` + (['jpg','jpeg','png'].includes(type)?`<img src="${data}" class="max-h-[70vh] mx-auto rounded-lg"/>`:(type==='pdf'?`<iframe src="${data}" class="w-full h-[70vh] rounded-lg border" title="${name}"></iframe>`:'')); if(modal) modal.classList.remove('hidden'); });
                            if (rb) rb.addEventListener('click', function(){
                                if (hdData) hdData.value=''; if (hdName) hdName.value=''; if (hdType) hdType.value=''; proofInfo.innerHTML=''; inp.value='';
                                // remove from canonical saved files as well
                                try {
                                    const fname = String(name || '').trim();
                                    if (fname) {
                                        const existing = window.loadSavedProofs ? window.loadSavedProofs() : (JSON.parse(localStorage.getItem(LS_KEY)||'[]')||[]);
                                        const filtered = (Array.isArray(existing) ? existing.filter(f => String((f && (f.name||f.filename||'')).toLowerCase()) !== fname.toLowerCase()) : existing);
                                        try { if (typeof window.saveProofs === 'function') window.saveProofs(filtered); else localStorage.setItem(LS_KEY, JSON.stringify(filtered)); } catch(e){}
                                        try { if (typeof window.showFileList === 'function') window.showFileList(filtered); } catch(e){}
                                    }
                                } catch(e){}
                                // sync inputs
                                try{ const evt = new Event('input',{bubbles:true}); targetNode.querySelectorAll('input').forEach(i=>i.dispatchEvent(evt)); }catch(e){}
                            });
                            // trigger sync
                            try{ const evt = new Event('input',{bubbles:true}); targetNode.querySelectorAll('input').forEach(i=>i.dispatchEvent(evt)); }catch(e){}

                            // also persist this per-entry file into the shared education files array
                            try {
                                const fname = String(name || '').trim();
                                const fdata = data;
                                const ftype = type;
                                if (fname && fdata) {
                                    const existing = window.loadSavedProofs ? window.loadSavedProofs() : (JSON.parse(localStorage.getItem(LS_KEY)||'[]')||[]);
                                    const filtered = (Array.isArray(existing) ? existing.filter(f => String((f && (f.name||f.filename||'')).toLowerCase()) !== fname.toLowerCase()) : []);
                                    filtered.push({ name: fname, type: ftype, data: fdata });
                                    try { if (typeof window.saveProofs === 'function') window.saveProofs(filtered); else localStorage.setItem(LS_KEY, JSON.stringify(filtered)); } catch(e){}
                                    try { if (typeof window.showFileList === 'function') window.showFileList(filtered); } catch(e){}
                                }
                            } catch(e) { console.warn('persist per-entry file failed', e); }
                        }catch(err){ console.warn(err); }
                    };
                    reader.onerror = function(){ alert('Failed to read file'); };
                    reader.readAsDataURL(f);
                });

                // allow external population (for restored items)
                slot.populateFile = function(name, data, type){
                    try{
                        const hdData = targetNode.querySelector('input[name="certificate_file_data"]');
                        const hdName = targetNode.querySelector('input[name="certificate_file_name"]');
                        const hdType = targetNode.querySelector('input[name="certificate_file_type"]');
                        if (hdData) hdData.value = data || '';
                        if (hdName) hdName.value = name || '';
                        if (hdType) hdType.value = type || '';
                        if (!data){ proofInfo.innerHTML = ''; return; }
                        proofInfo.innerHTML = `<div class="flex flex-wrap items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm"><span class="text-2xl">${['jpg','jpeg','png'].includes(type)?'🖼️':'📄'}</span><span class="truncate max-w-[160px] sm:max-w-[240px]">${(name||'Uploaded file').length>60? (name||'Uploaded file').slice(0,57)+'...' : (name||'Uploaded file')}</span><div class="flex gap-2"><button type="button" class="view-file bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button><button type="button" class="remove-file bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button></div></div>`;
                        const vb = proofInfo.querySelector('.view-file');
                        const rb = proofInfo.querySelector('.remove-file');
                        if (vb) vb.addEventListener('click', function(){ if (typeof window.openModalPreview === 'function') return window.openModalPreview(name, data, type); const modal = document.getElementById('fileModal'); const mc = document.getElementById('modalContent'); if(mc) mc.innerHTML = `<h3 class="font-semibold mb-2">${name}</h3>` + (['jpg','jpeg','png'].includes(type)?`<img src="${data}" class="max-h-[70vh] mx-auto rounded-lg"/>`:(type==='pdf'?`<iframe src="${data}" class="w-full h-[70vh] rounded-lg border" title="${name}"></iframe>`:'')); if(modal) modal.classList.remove('hidden'); });
                        if (rb) rb.addEventListener('click', function(){ if (hdData) hdData.value=''; if (hdName) hdName.value=''; if (hdType) hdType.value=''; proofInfo.innerHTML=''; inp.value=''; try{ const evt = new Event('input',{bubbles:true}); targetNode.querySelectorAll('input').forEach(i=>i.dispatchEvent(evt)); }catch(e){} });
                    }catch(e){ console.warn(e); }
                };

                return slot;
            }

            function buildEntry(item) {
                const node = tpl.content.firstElementChild.cloneNode(true);
                if (item) {
                    node.querySelector('input[name="certificate_name"]').value = item.certificate_name || '';
                    node.querySelector('input[name="issued_by"]').value = item.issued_by || '';
                    node.querySelector('input[name="date_completed"]').value = item.date_completed || '';
                    node.querySelector('input[name="training_description"]').value = item.training_description || '';
                }
                const removeBtn = node.querySelector('.remove-cert');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        // if this entry has an attached uploaded file, also remove it from saved files
                        try {
                            const hdName = node.querySelector('input[name="certificate_file_name"]');
                            const fname = hdName && hdName.value ? String(hdName.value).trim() : '';
                            if (fname) {
                                try {
                                    const savedFiles = window.loadSavedProofs ? window.loadSavedProofs() : (JSON.parse(localStorage.getItem(LS_KEY)||'[]')) || [];
                                    const filtered = (Array.isArray(savedFiles) ? savedFiles.filter(f => String((f && (f.name||f.filename||'')).toLowerCase()) !== fname.toLowerCase()) : savedFiles);
                                    try { window.saveProofs ? window.saveProofs(filtered) : localStorage.setItem(LS_KEY, JSON.stringify(filtered)); } catch(e){}
                                    try { if (typeof window.showFileList === 'function') window.showFileList(filtered); } catch(e){}
                                } catch(e){}
                            }
                        } catch(e){}
                        // also remove the upload slot immediately preceding this node (if any)
                        try {
                            const prev = node.previousElementSibling;
                            if (prev && prev.querySelector && prev.querySelector('[id^="proofFileInfo_"]')) {
                                prev.remove();
                            }
                        } catch(e){}
                        node.remove();
                        debouncedSync();
                    });
                }
                node.querySelectorAll('input').forEach(i => i.addEventListener('input', debouncedSync));
                return node;
            }

            function addCert(item) {
                const node = buildEntry(item || {});
                // create upload slot tied to this node and insert before the node
                const slot = createUploadSlotForNode(node);
                if (item && item.certificate_file_data) {
                    try{ slot.populateFile(item.certificate_file_name || '', item.certificate_file_data || '', item.certificate_file_type || ''); }catch(e){}
                }
                container.appendChild(slot);
                container.appendChild(node);
                debouncedSync();
                // focus first input of newly added
                const last = container.lastElementChild;
                if (last) last.querySelector('input[name="certificate_name"]')?.focus();
            }

            addBtn.addEventListener('click', function() {
                addCert();
            });

            radios.forEach(r => r.addEventListener('change', function(ev) {
                if (ev.target.value === 'yes') {
                    section.classList.remove('hidden');
                    // restore saved hidden values if any, else ensure one empty entry
                    const saved = parseHidden();
                    if (container.children.length === 0) {
                        if (saved && saved.length) saved.forEach(s => addCert(s));
                        else addCert();
                    }
                } else {
                    section.classList.add('hidden');
                    container.innerHTML = '';
                    writeHidden([]);
                }
            }));

            // init on load
            document.addEventListener('DOMContentLoaded', function() {
                const sel = document.querySelector('input[name="certs"]:checked');
                const saved = parseHidden();
                if (sel && sel.value === 'yes') {
                    section.classList.remove('hidden');
                    if (saved && saved.length) saved.forEach(s => addCert(s));
                    else addCert();
                } else {
                    section.classList.add('hidden');
                    container.innerHTML = '';
                    writeHidden([]);
                }
            });
        })();
    </script>

</body>

</html>

<script>
    // Restore education form state when user returns to this page
    window.addEventListener('DOMContentLoaded', function() {
        try {
            const edu_level = localStorage.getItem('edu_level');
            const school_name = localStorage.getItem('school_name');
            const review_certs = localStorage.getItem('review_certs');
            const certs_json = localStorage.getItem('education_certificates');

            if (edu_level) {
                const el = document.getElementById('edu_level');
                if (el) {
                    el.value = edu_level;
                    el.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            }
            // Restore visual selection on education cards
            try {
                const v = (edu_level || '').toString();
                if (v) {
                    // attempts: attribute data-edu, data-value, id, or matching label text inside .education-card
                    let found = null;
                    found = document.querySelector('.education-card[data-edu="' + v + '"]') || document
                        .querySelector('.education-card[data-value="' + v + '"]') || document.getElementById(
                            'edu_' + v.replace(/\s+/g, '_'));
                    if (!found) {
                        document.querySelectorAll('.education-card').forEach(c => {
                            try {
                                const txt = (c.textContent || '').trim().toLowerCase();
                                if (txt && txt.indexOf(v.toLowerCase()) !== -1) found = found || c;
                            } catch (e) {}
                        });
                    }
                    if (found) {
                        document.querySelectorAll('.education-card').forEach(c => c.classList.remove(
                            'selected'));
                        found.classList.add('selected');
                    }
                }
            } catch (e) {
                console.debug('could not restore education card selection', e);
            }
            if (school_name) {
                const s = document.getElementById('school_name');
                if (s) {
                    s.value = school_name;
                    s.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
            }

            if (review_certs) {
                const radio = document.querySelector('input[name="certs"][value="' + review_certs + '"]');
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            }

            if (certs_json) {
                try {
                    const arr = JSON.parse(certs_json || '[]');
                    if (Array.isArray(arr) && arr.length) {
                        // put canonical data into hidden field so existing certificate UI code picks it up
                        const hidden = document.getElementById('certificates');
                        if (hidden) hidden.value = JSON.stringify(arr);

                        // if the certificate UI builder already exists, rebuild the UI entries to reflect saved data
                        setTimeout(() => {
                            try {
                                const container = document.getElementById('certs_container');
                                const tpl = document.getElementById('cert_template');
                                if (!container || !tpl) return;
                                // clear existing
                                container.innerHTML = '';
                                arr.forEach(item => {
                                    const node = tpl.content.firstElementChild.cloneNode(true);
                                    const nameEl = node.querySelector(
                                        'input[name="certificate_name"]');
                                    const issuedEl = node.querySelector(
                                        'input[name="issued_by"]');
                                    const dateEl = node.querySelector(
                                        'input[name="date_completed"]');
                                    const descEl = node.querySelector(
                                        'input[name="training_description"]');
                                    if (nameEl) nameEl.value = item.certificate_name || item
                                        .name || item.title || '';
                                    if (issuedEl) issuedEl.value = item.issued_by || item
                                        .issuer || '';
                                    if (dateEl) dateEl.value = item.date_completed || item
                                        .date || '';
                                    if (descEl) descEl.value = item.training_description || item
                                        .description || '';
                                    container.appendChild(node);
                                });
                                // notify sync handlers
                                container.querySelectorAll('input').forEach(i => i.dispatchEvent(
                                    new Event('input', {
                                        bubbles: true
                                    })));
                            } catch (e) {
                                console.warn('cert restore failed', e);
                            }
                        }, 50);
                    }
                } catch (e) {
                    console.warn('invalid education_certificates', e);
                }
            }

        } catch (e) {
            console.warn('education restore failed', e);
        }
    });
</script>
