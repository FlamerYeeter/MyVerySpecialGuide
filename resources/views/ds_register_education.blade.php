<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Education</title>
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
                        Please select your highest education level and fill in your school information. This helps us recommend suitable 
                        programs, job opportunities, and training that match your background.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Pumili ng iyong pinakamataas na natapos na antas ng edukasyon at ilagay ang impormasyon ng iyong paaralan. 
                        Makakatulong ito upang mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay na tumutugma
                        sa iyong kaalaman.)
                    </p>
                </div>
            </div>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
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
                    <p class="text-gray-800 font-medium text-base sm:text-lg leading-snug">Choose from the pictures provided and
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
                <div id="ElementaryAudioBtn" class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
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
                <div id="HighSchoolAudioBtn" class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
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
                <div  id="CollegeAudioBtn" class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
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
                <div id="VocationalAudioBtn" class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
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
                <div id="otherEducation" class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
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
                    <input  id="review_other" name="edu_other_text" type="text"
                        aria-labelledby="edu_other_label" placeholder="Type your answer here"
                        class="w-full border border-gray-300 rounded-lg p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                </div>
            </div>

            <!-- Hidden input for education level (collected by register.js) -->
            <input id="edu_level" type="hidden" value="" />

            <!-- School Name -->
            <div class="text-left px-2 sm:px-4 mt-16">
                <label for="school_name" class="font-semibold text-base sm:text-lg flex items-center gap-2">
                    Name of your school
                    <button type="button" aria-label="Play audio for Other option"
                        class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="Name of your school"
                         data-tts-tl="Pangalan ng iyong paaralan"
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
                <!-- Main Label -->
                <label for="certs" class="font-semibold text-base sm:text-lg flex items-center gap-2">
                    Do you have any certificates or special trainings?
                    <button type="button" aria-label="Play audio for Other option"
                        class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
                         data-tts-en="Do you have any certificates or special trainings?"
                         data-tts-tl="May mga certificate o special training ka ba?"
                        aria-label="Play audio for other option">🔊
                    </button>
                </label>

                <!-- Translation -->
                <p class="text-gray-600 italic text-sm sm:text-base mb-2">
                    (May mga certificate o special training ka ba?)
                </p>

   <!-- Radio Buttons -->
  <div class="flex items-center gap-6 mt-2">
  <label class="flex items-center gap-2 cursor-pointer">
    <input
      type="radio"
      id="certYes"
      name="certs"
      value="yes"
      class="text-blue-600 focus:ring-blue-400 w-5 h-5"
    />
    <span class="text-gray-800 text-sm sm:text-base">Yes</span>
  </label>

  <label class="flex items-center gap-2 cursor-pointer">
    <input
      type="radio"
      id="certNo"
      name="certs"
      value="no"
      class="text-blue-600 focus:ring-blue-400 w-5 h-5"
    />
    <span class="text-gray-800 text-sm sm:text-base">No</span>
  </label>
</div>

  <br>
               
                     <!-- File Upload -->
                  <div id="fileuploadSection"
  class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3"
><!-- 🔹 FILE UPLOAD SECTION -->
<div
  class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3"
>
  <div class="flex-1">
    <p class="font-medium text-gray-800 text-sm sm:text-base">
      <span id="proofLabel" class="flex items-center gap-2">
        <span>Upload Proof (Image or PDF)</span> <span>⭐</span>
      </span>
    </p>
    <p id="proofHint" class="text-gray-600 italic text-xs sm:text-sm mt-1">
      (Mag-upload ng larawan o PDF bilang patunay ng pagiging miyembro.)<br /><br />
      Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size:
      <b>5MB</b><br />
    </p>

    <!-- File preview details -->
    <div
      id="proofFileInfo"
      class="mt-3 bg-white border border-gray-200 rounded-lg p-3 flex justify-between items-center shadow-sm hidden"
    >
      <div class="flex items-center justify-between gap-4 p-2 border rounded-lg shadow-sm bg-white">
  <!-- File icon + name -->
  <div class="flex items-center gap-2">
    <span id="proofFileIcon" class="text-2xl">📄</span>
    <span
      id="proofFileName"
      class="text-sm text-gray-700 truncate max-w-[160px] sm:max-w-[240px]"
    ></span>
  </div>

  <!-- Buttons -->
  <div class="flex gap-3">
    <button
      id="proofViewBtn"
      type="button"
      class="bg-[#2E2EFF] hover:bg-blue-600 font-medium text-white text-xs px-3 py-1 rounded-md transition"
    >
      View / Tingnan
    </button>
    <button
      id="proofRemoveBtn"
      type="button"
      class="bg-[#D20103] hover:bg-red-600 font-medium text-white text-xs px-3 py-1 rounded-md transition"
    >
      Remove / Alisin
    </button>
  </div>
</div>

    </div>
  </div>

  <!-- Upload button -->
  <label
    for="proof"
    class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium 
                        px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition"
  >
    📁 Choose File / Pumili ng File
  </label>

  <input
    id="proof"
    name="proof"
    type="file"
    accept=".jpg,.jpeg,.png,.pdf"
    class="hidden"
    required
  />
</div>

<!-- 🔹 MODAL PREVIEW -->
<div
  id="fileModal"
  class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
>
  <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
    <button
      id="closeModalBtn"
      class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl"
    >
      ×
    </button>
    <div id="modalContent" class="p-2 text-center"></div>
            </div>
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
                                } catch (e) { console.debug('cert toggle error', e); }
                            };
                            radios.forEach(r => r.addEventListener('change', (ev) => toggleFile(ev.target.value)));
                            // initialise based on current selection
                            const sel = document.querySelector('input[name="certs"]:checked');
                            if (sel) toggleFile(sel.value);
                        } catch (e) { console.debug('certs radio bind failed', e); }
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
                    <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
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
            const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
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
                            return preferredEnglishVoice || chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
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
            (function () {
            const fileInput = document.getElementById("proof");
            const fileInfo = document.getElementById("proofFileInfo");
            const fileName = document.getElementById("proofFileName");
            const fileIcon = document.getElementById("proofFileIcon");
            const viewBtn = document.getElementById("proofViewBtn");
            const removeBtn = document.getElementById("proofRemoveBtn");
            const modal = document.getElementById("fileModal");
            const modalContent = document.getElementById("modalContent");
            const closeModal = document.getElementById("closeModalBtn");
            const hintEl = document.getElementById("proofHint");
            const prevFileEl = document.getElementById("review_certfile");

            console.log("✅ File upload script initialized");

            // 🔹 Load file from localStorage (base64)
            const savedFileData = localStorage.getItem("uploadedProofData1");
            const savedFileType = localStorage.getItem("uploadedProofType1");
            const savedFileName = localStorage.getItem("uploadedProofName1");

            if (savedFileData && savedFileType && savedFileName) {
                showFileInfo(savedFileName, savedFileType);
                makeFileClickable(prevFileEl, savedFileName, savedFileData, savedFileType);
            } else if (prevFileEl && prevFileEl.textContent.trim() !== "No file uploaded") {
                // If coming from previous form
                const prevFileName = prevFileEl.textContent.trim();
                showFileInfo(prevFileName, getFileType(prevFileName));
                makeFileClickable(prevFileEl, prevFileName, savedFileData, getFileType(prevFileName));
            }

            // 🔹 When a new file is selected
            fileInput.addEventListener("change", function () {
                const file = this.files[0];
                if (!file) return;

                const ext = getFileType(file.name);
                if (!["jpg", "jpeg", "png", "pdf"].includes(ext)) {
                alert("Invalid file type. Only JPG, PNG, or PDF allowed.");
                fileInput.value = "";
                return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                const fileData = e.target.result; // base64 content
                localStorage.setItem("uploadedProofData1", fileData);
                localStorage.setItem("uploadedProofType1", ext);
                localStorage.setItem("uploadedProofName1", file.name);

                showFileInfo(file.name, ext);
                makeFileClickable(prevFileEl, file.name, fileData, ext);
                };
                reader.readAsDataURL(file);
            });

            // 🔹 View button
            viewBtn.addEventListener("click", () => {
                const name = localStorage.getItem("uploadedProofName1");
                const data = localStorage.getItem("uploadedProofData1");
                const type = localStorage.getItem("uploadedProofType1");
                if (data && type && name) openModalPreview(name, data, type);
            });

            // 🔹 Remove file
            removeBtn.addEventListener("click", () => {
                localStorage.removeItem("uploadedProofData1");
                localStorage.removeItem("uploadedProofType1");
                localStorage.removeItem("uploadedProofName1");
                fileInput.value = "";
                hideFileInfo();
            });
                                        // Close modal without removing file
                    closeModal.addEventListener('click', (e) => {
                    e.preventDefault(); // 🚫 stops form submission/refresh
                    modal.classList.add('hidden');
                    modalContent.innerHTML = ''; // clear preview only
                });

            // 🔹 Close modal
            closeModal.addEventListener("click", closeModalFn);
            modal.addEventListener("click", (e) => {
                if (e.target === modal) closeModalFn();
            });

            // ===============================
            // 🔹 Helper Functions
            // ===============================

            function showFileInfo(name, type) {
                fileInfo.classList.remove("hidden");
                if (hintEl) hintEl.style.display = "none";
                fileIcon.textContent = type === "pdf" ? "📄" : "🖼️";
                fileName.textContent = name;
            }

            function hideFileInfo() {
                fileInfo.classList.add("hidden");
                fileName.textContent = "";
                fileIcon.textContent = "";
                if (hintEl) hintEl.style.display = "";
            }

            function closeModalFn() {
                modal.classList.add("hidden");
                modalContent.innerHTML = "";
            }

            function getFileType(filename) {
                return filename.split(".").pop().toLowerCase();
            }

            // 🔹 Make filename clickable
            function makeFileClickable(el, name, data, type) {
                if (!el) return;
                el.classList.add("text-blue-600", "underline", "cursor-pointer");
                el.title = "Click to view uploaded file";
                el.onclick = () => openModalPreview(name, data, type);
            }

            // 🔹 Open modal preview
            function openModalPreview(name, data, type) {
                modalContent.innerHTML = `<h2 class="font-semibold mb-2">${name}</h2>`;
                if (["jpg", "jpeg", "png"].includes(type)) {
                modalContent.innerHTML += `<img src="${data}" alt="${name}" class="max-h-[70vh] mx-auto rounded-lg shadow" />`;
                } else if (type === "pdf") {
                modalContent.innerHTML += `<iframe src="${data}" class="w-full h-[70vh] rounded-lg border" title="${name}"></iframe>`;
                } else {
                modalContent.innerHTML += `<p class="text-gray-700">Preview not available for this file type.</p>`;
                }
                modal.classList.remove("hidden");
            }
            })();
            </script>
          
        <script>
            (function () {
            const btn = document.getElementById('educNext');
            if (!btn) return;

            btn.addEventListener('click', function () {
                try {
                btn.classList.add('opacity-60');

                // Collect all inputs/selects/textareas with an ID
                const data = {};
                document.querySelectorAll('input[id], select[id], textarea[id]').forEach(el => {
                    const id = el.id;
                    if (!id) return;
                    data[id] = el.type === 'checkbox' ? !!el.checked : el.value || '';
                });

                // Get selected cert radio button
                const selectedReviewCerts = document.querySelector('input[name="certs"]:checked');
                const reviewCertsValue = selectedReviewCerts ? selectedReviewCerts.value : '';

                // Get selected education card value
                let educationValuex = '';
                const selectedCard = document.querySelector('.education-card.selected');
                if (selectedCard) {
                    const onclickAttr = selectedCard.getAttribute('onclick');
                    const match = onclickAttr?.match(/selectEducationChoice\(this,\s*'([^']+)'\)/);
                    if (match && match[1]) {
                    educationValuex = match[1];
                    if (educationValuex === 'other') {
                        const otherField = document.getElementById('review_other');
                        educationValuex = otherField?.value || educationValuex;
                    }
                    }
                }

                // Build draft object
                const draft = {
                    schoolName: data.school_name || '',
                    reviewCerts: reviewCertsValue,
                    educationLevel: educationValuex,
                    otherFields: data.review_other || ''
                };

                // Save to localStorage
                try {
                    localStorage.setItem('rpi_personal2', JSON.stringify(draft));
              //      alert("Saved draft:\n" + JSON.stringify(draft, null, 2));
                } catch (err) {
                    console.warn('Could not save rpi_personal2', err);
                //    alert('Could not save rpi_personal2');
                }

                console.info('[adminapprove] saved rpi_personal2 draft', draft);

                // Dispatch event for other scripts
                try {
                    window.dispatchEvent(new CustomEvent('mvsg:adminSaved', {
                    detail: {
                        key: 'rpi_personal2',
                        data: draft
                    }
                    }));
                } catch (e) {}

                // Optional redirect
                 window.location.href = '{{ route("registerworkexpinfo") }}';

                } catch (err) {
                console.error('[adminapprove] submit failed', err);
                btn.classList.remove('opacity-60');
                }
            });
            })();
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
                                localStorage.removeItem("uploadedProofData1");
                                localStorage.removeItem("uploadedProofType1");
                                localStorage.removeItem("uploadedProofName1");
                                if (typeof hideFileInfo === "function") hideFileInfo();
                                console.log("File input cleared & localStorage removed");
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

</body>

</html>
