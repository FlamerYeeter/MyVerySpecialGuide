<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
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

        .selectable-card {
            border: 2px solid transparent;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .selectable-card.selected {
            border-color: #2563eb;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.14);
            transform: translateY(-6px);
        }

        /* badge for selected card */
        .selectable-card.selected::after,
        .education-card.selected::after,
        .workyr-card.selected::after {
            content: "";
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 44px;
            height: 44px;
            background-image: url('/image/checkmark.png');
            background-size: contain;
            background-repeat: no-repeat;
        }

        /* TTS button visual state */
        .tts-btn { cursor: pointer; }
        .tts-btn.speaking { transform: scale(1.04); box-shadow: 0 8px 24px rgba(30,64,175,0.12); }

        /* no global floating preview; use small per-field preview containers */
    </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-6 top-1/3 w-28 lg:w-36 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="fixed left-1 sm:left-4 md:left-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-20 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-6 top-1/4 w-28 lg:w-36 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-6 bottom-24 w-28 lg:w-36 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
    class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="(history.length > 1 ? history.back() : window.location.href='{{ route('registereducation') }}')"
    >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-6">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md"
                style="line-height: 1.15;">
                Review Your Education and <br>Work Information
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-32 md:w-36 mb-6">

            <div class="bg-white rounded-3xl p-5 sm:p-7 border-4 border-blue-300 shadow-lg text-left">
                <h2 class="text-lg sm:text-xl md:text-2xl text-blue-600 font-bold flex items-center gap-x-3">
                    Please Review Your Details
                    <button type="button" class="tts-btn text-xl hover:scale-110 transition-transform"
                        data-tts-en="Please review your details. Make sure all your information below is correct before going to the next page."
                        data-tts-tl="Siguraduhing tama ang lahat ng impormasyong nakasaad bago lumipat ng pahina."
                        aria-label="Read this section aloud in English then Filipino"></button>
                </h2>
                <p class="text-gray-800 text-sm sm:text-base mt-2">
                    Make sure all your information below is correct before going to the next page.
                </p>
                <p class="text-gray-600 italic text-sm sm:text-base mt-3">
                    (Siguraduhing tama ang lahat ng impormasyong nakasaad bago lumipat ng pahina.)
                </p>
            </div>
        </div>

        <!-- Review Sections -->
        <div id="reviewContainer" class="mt-10 space-y-8">

            <!-- Education Info -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 relative">
                <div class="flex justify-between items-center mb-4 border-b border-blue-300 pb-2">
                    <h3 class="text-lg font-semibold text-blue-600">Education Information</h3>
                   <button type="button"
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition edit-btn"
                    id="editSchoolBtn">✏️ Edit</button>
                </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-800">
                <p class="flex items-center space-x-2">
                    <span class="font-semibold">Education Level:</span>
        
                    <input id="educationLevel" style="display:block;"></input>

                    <select id="edit_edu_select" class="hidden border rounded px-2 py-1">
                    <option value="College">College</option>
                    <option value="Vocational/Training">Vocational/Training</option>
                    <option value="High School">High School</option>
                    <option value="Elementary">Elementary</option>
                    </select>
                </p>

             

            <p class="col-span-2">
            <span class="font-semibold">School Name:</span>
            <span id="schoolName"></span>
            <input type="text" id="edit_school_input" class="hidden border rounded px-2 py-1" />
            </p>
        </div>

                <h3
                    class="mt-8 text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2 flex justify-between items-center">
                    Certificates & Trainings
                </h3>

                <div class="mt-4 text-gray-800 mb-3" id="certificateReview">
                    <p>
                        <span class="font-semibold">Certificates / Trainings:</span>
                        <input id="reviewCerts" />
                    </p>
                </div>
                       <!-- Certificates -->
            <div id = "certificateCard" class="hidden mt-8 text-left px-2 sm:px-4">
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
                    <p>
                        <span class="font-semibold">Uploaded Certificates / Trainings:</span>
                        <span id="review_certfile" class="ml-2 text-sm text-gray-700">No file uploaded</span>
                    </p>
                    <p class="text-sm text-gray-600 mt-1 italic">
                        <small>If you uploaded a certificate, its filename will appear above and you can preview it with the View button.</small>
                    </p>
                </div>
                
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
   id="ChooseFilelabel"
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
<!-- 🔹 MODAL PREVIEW -->
<div
  id="fileModal"
  class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50"
>
  <div class="bg-white rounded-lg shadow-lg p-4 max-w-6xl w-[96%] max-h-[90vh] overflow-auto relative">
    <button
      id="closeModalBtn"
      class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl"
    >
      ×
    </button>
    <div id="modalContent" class="p-2 text-center overflow-auto max-h-[85vh]"></div>
            </div>
  </div>
</div>
    </div>
            <!-- Work Experience -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 relative">
                <div class="flex justify-between items-center mb-4 border-b border-blue-300 pb-2">
                    <h3 class="text-lg font-semibold text-blue-600">Work Experience</h3>
                    <button type="button"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition edit-btn"
                        data-section="work">✏️ Edit</button>
                </div>

                <div class="text-gray-800 mb-5">
                    <p class="flex items-start gap-2"><span class="font-semibold">Type of Work:</span>
                        <span id="review_work_list" class="flex flex-wrap gap-2 items-center">
                            <span class="text-gray-600">N/A</span>
                        </span>
                    </p>
                </div>

                <div class="text-gray-800">
                    <h4 class="text-md font-semibold text-blue-700 mb-3">Job Experiences</h4>
                    <div id="review_job_experiences" class="space-y-4">
                        <p class="text-gray-600 italic">No job experiences added.</p>
                    </div>
                    <script>
                        // Render saved job experiences from register work page into this review view.
                        (function(){
                            function normalizeEntry(e) {
                                if (!e || typeof e !== 'object') return null;
                                // Try many common key names used across forms
                                const title = e.title || e.job_title || e.position || e.role || e.job || '';
                                const company = e.company || e.company_name || e.employer || e.Company || '';
                                const year = e.start_year || e.job_start_year || e.year || e.startYear || e.job_work_year || '';
                                const desc = e.description || e.job_description || e.desc || e.notes || '';
                                return { title:String(title||''), company:String(company||''), year:String(year||''), desc:String(desc||'') };
                            }

                            function renderExperiences() {
                                try {
                                    const container = document.getElementById('review_job_experiences');
                                    if (!container) return;
                                    // Clear existing
                                    container.innerHTML = '';

                                    const raw = localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || localStorage.getItem('jobExperiences');
                                    if (!raw) {
                                        container.innerHTML = '<p class="text-gray-600 italic">No job experiences added.</p>';
                                        return;
                                    }
                                    let arr = [];
                                    try { arr = JSON.parse(raw || '[]'); } catch (e) { arr = []; }
                                    if (!Array.isArray(arr) || arr.length === 0) {
                                        container.innerHTML = '<p class="text-gray-600 italic">No job experiences added.</p>';
                                        return;
                                    }

                                    arr.forEach(function(it, idx){
                                        const n = normalizeEntry(it) || {title:'',company:'',year:'',desc:''};
                                        const wrapper = document.createElement('div');
                                        wrapper.className = 'bg-white p-4 rounded-lg border border-gray-200 shadow-sm';
                                        wrapper.innerHTML = `
                                            <div class="flex justify-between items-start gap-4">
                                                <div>
                                                    <h5 class="text-lg font-semibold text-gray-800">${n.title ? escapeHtml(n.title) : '<span class="text-gray-500 italic">(No job title)</span>'}</h5>
                                                    <p class="text-sm text-gray-600 mt-1">${n.company ? escapeHtml(n.company) : ''} ${n.year ? '&middot; ' + escapeHtml(n.year) : ''}</p>
                                                    <p class="text-sm text-gray-700 mt-3">${n.desc ? escapeHtml(n.desc) : ''}</p>
                                                </div>
                                            </div>
                                        `;
                                        container.appendChild(wrapper);
                                    });
                                } catch (e) {
                                    console.debug('renderExperiences error', e);
                                }
                            }

                            function escapeHtml(s) {
                                if (s === null || s === undefined) return '';
                                return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                            }

                            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', renderExperiences);
                            else renderExperiences();

                            // Re-render when storage changes (e.g., user updated on another tab/page)
                            window.addEventListener('storage', function(e){
                                if (e.key && (e.key === 'job_experiences' || e.key === 'work_experiences' || e.key === 'jobExperiences')) renderExperiences();
                            });
                        })();
                    </script>
                </div>
            </div>

            <script>
                (function(){
                    function titleCase(s){
                        if(!s) return '';
                        return String(s).split(/[\s_\-]+/).map(w=> w.charAt(0).toUpperCase()+w.slice(1).toLowerCase()).join(' ');
                    }

                    function readPossibleKeys(keys){
                        for(const k of keys){
                            const v = localStorage.getItem(k);
                            if(v !== null && v !== undefined) return v;
                        }
                        return null;
                    }

                    function renderWorkplace(){
                        try{
                            const el = document.getElementById('review_workplace_list');
                            const imgEl = document.getElementById('review_workplace_choice_img');
                            const imgContainer = document.getElementById('review_workplace_choice_img_container');
                            const raw = readPossibleKeys(['workplace','preferred_workplace','workplace_choice','workplaceChoice','preferred_workplace_choice']);
                            if(!el) return;
                            el.innerHTML = '<span class="text-gray-600">—</span>';
                            if(!raw) { if(imgContainer) imgContainer.classList.add('hidden'); return; }
                            let val = raw;
                            try{ const parsed = JSON.parse(raw); if(Array.isArray(parsed)) val = parsed.join(', '); else if(typeof parsed === 'object') val = Object.values(parsed).join(', '); else val = String(parsed); }catch(e){ val = String(raw); }
                            el.textContent = titleCase(val.replace(/^\[|\]$/g,''));
                            const imgSrc = readPossibleKeys(['workplace_choice_img','workplace_image','review_workplace_choice_img_src']);
                            if(imgSrc && imgEl){ imgEl.src = imgSrc; imgContainer.classList.remove('hidden'); }
                            else if(imgContainer) imgContainer.classList.add('hidden');
                        }catch(e){ console.debug('renderWorkplace error', e); }
                    }

                    document.addEventListener('DOMContentLoaded', function(){ renderWorkplace(); });
                    window.addEventListener('storage', function(e){ if(!e.key) { renderWorkplace(); return;} if(['workplace','preferred_workplace','workplace_choice','workplaceChoice','workplace_choice_img','workplace_image'].includes(e.key)) renderWorkplace(); });
                })();
            </script>

            <!-- Work Environment -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 relative">
                <div class="flex justify-between items-center mb-4 border-b border-blue-300 pb-2">
                    <h3 class="text-lg font-semibold text-blue-600">Work Environment</h3>
                    <button type="button"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition edit-btn"
                        data-section="environment">✏️ Edit</button>
                </div>

                <div class="text-gray-800">
                    <p class="flex items-start gap-2"><span class="font-semibold">Preferred Workplace:</span>
                        <span id="review_workplace_list" class="flex flex-wrap gap-2 items-center">
                            <span class="text-gray-600">—</span>
                        </span>
                    </p>
                </div>
                <div id="review_workplace_choice_img_container" class="mt-4 text-center hidden">
                    <div
                        class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
                        <img id="review_workplace_choice_img" src="" alt="Workplace image"
                            class="w-full h-full object-contain rounded-md" />
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="text-center mt-10">


                <!-- Continue Button -->
                <button type="button"
                    class="bg-[#2E2EFF] text-white font-semibold text-lg px-20 py-3 rounded-xl hover:bg-blue-600 transition shadow-md"
                    onclick="window.location.href='{{ route('registerreview4') }}'">
                    Continue →
                </button>
                <p class="text-gray-700 text-sm mt-3">
                    Click <span class="text-[#1E40AF] font-medium">“Continue”</span> to move to the next
                    page
                </p>
                <p class="text-gray-600 italic text-[13px]">
                    (Pindutin ang “Continue” upang magpatuloy)
                </p>
            </div>

            <!-- Helper Text -->
            <div class="mt-6 text-center">

            </div>
            <script>
                window.addEventListener("DOMContentLoaded", () => {
                    console.log("Page loaded, attempting to retrieve saved cert...");

                    const savedCert = localStorage.getItem("review_certs"); // same key as saved
                    console.log("Retrieved from localStorage:", savedCert);

                    // Set span text
                    const certSpan = document.getElementById("review_certs");
                    if (certSpan) {
                        if (savedCert) {
                            certSpan.textContent = savedCert; // display "yes" or "no"
                            console.log(`Span updated with value: ${savedCert}`);
                        } else {
                            certSpan.textContent = '';
                            console.log("No saved cert found, span cleared.");
                        }
                    }
                });
            </script>

            <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
           <script>
                
                const editBtn = document.getElementById('editSchoolBtn') || document.getElementById('review_certfile');
                const schoolLabel = document.getElementById('schoolName');
                const schoolInput = document.getElementById('edit_school_input');
                const eduLabel = document.getElementById('educationLevel');
                const eduSelect = document.getElementById('edit_edu_select');
                const otherLabel = document.getElementById('review_other_label');
                const otherInput = document.getElementById('review_other');
                const fileuploadSection = document.getElementById('fileuploadSection'); 
                const certificateCard  = document.getElementById("certificateCard");
                const reviewCertEl3 = document.getElementById("certificateReview");

                editBtn.addEventListener('click', () => {
                    const isEditing =
                    schoolInput.classList.contains('hidden') ||
                    eduSelect.classList.contains('hidden') ||
                    otherInput.classList.contains('hidden');

                    if (isEditing) {
                    // 🔸 Switch to edit mode
                    schoolInput.value = schoolLabel.textContent.trim() || '';
                    schoolLabel.classList.add('hidden');
                    schoolInput.classList.remove('hidden');
                 //   fileuploadSection.classList.remove('hidden');
                    eduSelect.value = eduLabel.textContent.trim();
                    eduLabel.classList.add('hidden');
                    eduLabel.style.display = "none";
                    const newEduVal1 = eduSelect.value;
                    eduLabel.textContent = newEduVal1;
                    eduSelect.classList.remove('hidden');
                    otherInput.value = otherLabel.textContent.trim() || '';
                    otherLabel.classList.add('hidden');
                    otherInput.classList.remove('hidden');
                    reviewCertEl3.classList.add('hidden');
                    certificateCard.classList.remove('hidden');
                    editBtn.textContent = '💾 Save';
                
                    } else {
                    // 🔸 Switch back to label mode (save)
                    const newSchoolVal = schoolInput.value.trim();
                    schoolLabel.textContent = newSchoolVal;
                  //  localStorage.setItem('schoolName', newSchoolVal);
                    schoolInput.classList.add('hidden');
                    schoolLabel.classList.remove('hidden');
                     eduLabel.style.display = "block";      
                    const newEduVal = eduSelect.value;
                    eduLabel.textContent = newEduVal;
                  //  localStorage.setItem('educationLevel', newEduVal);
                    eduSelect.classList.add('hidden');
                    eduLabel.classList.remove('hidden');

                    const newOtherVal = otherInput.value.trim() || '';
                    otherLabel.textContent = newOtherVal;
                 //   localStorage.setItem('review_other', newOtherVal);
                    otherInput.classList.add('hidden');
                    otherLabel.classList.remove('hidden');
                    reviewCertEl3.classList.remove('hidden');
                    certificateCard.classList.add('hidden');
                    editBtn.textContent = '✏️ Edit';
                    }
                });

                // 🔹 Load saved values from localStorage (optional)
                const savedSchool = localStorage.getItem('schoolName');
                if (savedSchool) schoolLabel.textContent = savedSchool;

                const savedEdu = localStorage.getItem('educationLevel');
                if (savedEdu) eduLabel.textContent = savedEdu;

                const savedOther = localStorage.getItem('review_other');
                if (savedOther) otherLabel.textContent = savedOther;
                </script>

            <script>
                (function() {
                    const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
                    let voices = [];
                    const populateVoices = () => {
                        voices = speechSynthesis.getVoices() || [];
                    };
                    const pickBest = (list, langPrefix) => {
                        if (!list || !list.length) return null;
                        const exact = list.find(v => v.name === preferredVoiceName);
                        if (exact) return exact;
                        const fuzzy = list.find(v => v.name && v.name.toLowerCase().includes('microsoft') && v.name
                            .toLowerCase().includes('multilingual'));
                        if (fuzzy) return fuzzy;
                        const langMatch = list.find(v => v.lang && v.lang.toLowerCase().startsWith(langPrefix));
                        if (langMatch) return langMatch;
                        return list[0] || null;
                    };
                    const voiceFor = (lang) => {
                        const forLang = voices.filter(v => v.lang && v.lang.toLowerCase().startsWith(lang));
                        return pickBest(forLang.length ? forLang : voices, lang);
                    };
                    const stopSpeaking = () => {
                        try {
                            speechSynthesis.cancel();
                            document.querySelectorAll('.tts-btn.speaking').forEach(b => b.classList.remove('speaking'));
                        } catch (e) {}
                    };
                    const startSequence = (btn, en, tl) => {
                        stopSpeaking();
                        if (!en && !tl) return;
                        btn.classList.add('speaking');
                        btn.setAttribute('aria-pressed', 'true');
                        const uEn = en ? new SpeechSynthesisUtterance(en) : null;
                        const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
                        if (uEn) {
                            uEn.lang = 'en-US';
                            uEn.voice = voiceFor('en') || null;
                        }
                        if (uTl) {
                            uTl.lang = 'tl-PH';
                            uTl.voice = voiceFor('tl') || (voiceFor('en') || null);
                        }
                        const finalize = () => {
                            btn.classList.remove('speaking');
                            btn.setAttribute('aria-pressed', 'false');
                        };
                        if (uEn && uTl) {
                            uEn.onend = () => {
                                setTimeout(() => speechSynthesis.speak(uTl), 180);
                            };
                            uTl.onend = finalize;
                            speechSynthesis.speak(uEn);
                        } else if (uEn) {
                            uEn.onend = finalize;
                            speechSynthesis.speak(uEn);
                        } else if (uTl) {
                            uTl.onend = finalize;
                            speechSynthesis.speak(uTl);
                        }
                    };
                    const init = () => {
                        populateVoices();
                        window.speechSynthesis.onvoiceschanged = populateVoices;
                        document.querySelectorAll('.tts-btn').forEach(b => {
                            b.addEventListener('click', () => {
                                if (b.classList.contains('speaking')) {
                                    stopSpeaking();
                                    return;
                                }
                                startSequence(b, b.getAttribute('data-tts-en') || '', b.getAttribute(
                                    'data-tts-tl') || '');
                            });
                            b.addEventListener('keydown', ev => {
                                if (ev.key === 'Enter' || ev.key === ' ') {
                                    ev.preventDefault();
                                    b.click();
                                }
                            });
                        });
                        window.addEventListener('beforeunload', stopSpeaking);
                    };
                    if (document.readyState === 'complete' || document.readyState === 'interactive') init();
                    else document.addEventListener('DOMContentLoaded', init);
                })();
            </script>
            <script>
                // Save the visible review-2 section draft to localStorage then navigate to the given route.
                // Mirrors the behavior used on review-1 so destination pages can autofill from `rpi_personal2`.
                function saveDraftAndGoto(url) {
                    try {
                        let draft = window.__mvsg_lastLoadedDraft || {};
                        if (!draft || typeof draft !== 'object') draft = {};

                        // Ensure some namespaces exist
                        draft.schoolWorkInfo = draft.schoolWorkInfo || {};
                        draft.workExperience = draft.workExperience || {};
                        draft.workplace = draft.workplace || {};

                        const text = id => (document.getElementById(id) && (document.getElementById(id).textContent || document.getElementById(id).value)) ? (document.getElementById(id).textContent || document.getElementById(id).value).toString().trim() : '';

                        // Education
                        draft.schoolWorkInfo.school = draft.schoolWorkInfo.school || text('schoolName') || text('schoolName_name');
                        draft.schoolWorkInfo.edu_level = draft.schoolWorkInfo.edu_level || text('educationLevel');
                        draft.schoolWorkInfo.certs = draft.schoolWorkInfo.certs || text('review_certs_name');
                        // cert filename (if present)
                        const certfn = text('review_certs_file') || text('review_certfile');
                        if (certfn && certfn !== 'No file uploaded') draft.schoolWorkInfo.cert_file = draft.schoolWorkInfo.cert_file || certfn;

                        // Work
                        draft.schoolWorkInfo.work_type = draft.schoolWorkInfo.work_type || text('review_work_list') || text('review_work');
                        // Try to capture job experiences as plain HTML/text fallback
                        try {
                            const jobsEl = document.getElementById('review_job_experiences');
                            if (jobsEl && !draft.workExperience.work_experiences) {
                                // keep a simple textual capture if structured data not available
                                const items = Array.from(jobsEl.querySelectorAll('div')).map(d => d.textContent && d.textContent.trim()).filter(Boolean);
                                if (items.length) draft.workExperience.work_experiences = items;
                            }
                        } catch(e){}

                        // Workplace
                        draft.workplace.workplace_choice = draft.workplace.workplace_choice || text('review_workplace_list') || text('review_workplace_choice');

                        try {
                            localStorage.setItem('rpi_personal2', JSON.stringify(draft));
                            try {
                                const verified = JSON.parse(localStorage.getItem('rpi_personal2'));
                                console.info('[review-2] saveDraftAndGoto wrote rpi_personal2 and verified', verified);
                            } catch (verErr) {
                                console.info('[review-2] saveDraftAndGoto wrote rpi_personal2 (could not parse on readback)', localStorage.getItem('rpi_personal2'));
                            }
                        } catch (e) {
                            console.warn('[review-2] saveDraftAndGoto: failed to set localStorage', e);
                        }
                    } catch (e) { console.warn('[review-2] saveDraftAndGoto build draft failed', e); }

                    // Firebase removed: do not attempt client-side uid append. Always navigate to the URL.
                    try {
                        window.location.href = url;
                    } catch (e) {
                        window.location.href = url;
                    }
                }

                // Wire section Edit buttons to their routes
                document.addEventListener('DOMContentLoaded', function(){
                    try {
                        const routeMap = {
                            'education': '{{ route('registereducation') }}',
                            'work': '{{ route('registerworkexpinfo') }}',
                            'environment': '{{ route('registerworkplace') }}'
                        };
                        document.querySelectorAll('.edit-btn').forEach(btn => {
                            try {
                                const sec = (btn.getAttribute('data-section') || '').trim();
                                const target = routeMap[sec];
                                if (!target) return;
                                btn.addEventListener('click', function(ev){ ev.preventDefault(); saveDraftAndGoto(target); });
                            } catch(e) { /* ignore per-button errors */ }
                        });
                    } catch (e) { console.warn('[review-2] wiring edit buttons failed', e); }
                });
            </script>



            {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
            <script src="{{ asset('js/register.js') }}"></script>
            @if (!app()->environment('production'))
                <script>
                    // non-production diagnostic: fetch server-side session info and display it for debugging
                    (async function(){
                        try {
                            const el = document.getElementById('__rv2_debug_pre');
                            const resp = await fetch('{{ url('/debug/firebase-session') }}', { credentials: 'same-origin' });
                            const json = await resp.json().catch(()=>null);
                            if (el) el.textContent = JSON.stringify(json, null, 2);
                        } catch(e) {
                            try { document.getElementById('__rv2_debug_pre').textContent = 'debug endpoint failed: ' + (e && e.message); } catch(_){}
                        }
                    })();
                </script>
            @endif
            @if (!empty($serverProfile))
                <script>
                    // Server-provided Firestore profile (admin route)
                    window.__mvsg_serverProfile = {!! json_encode($serverProfile, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
                    window.__mvsg_serverProfileUid = {!! json_encode($serverProfileUid ?? null) !!};
                </script>
            @endif
            <script>
                // Ensure the shared populateReview() (from public/js/register.js) also runs on this page
                // This helps reuse the central draft/Firestore merge logic and keeps review-2 in sync
                document.addEventListener('DOMContentLoaded', async function() {
                    try {
                        if (typeof window.populateReview === 'function') {
                            try { await window.populateReview(); console.debug('[review-2] populateReview() invoked'); } catch(e){ console.debug('[review-2] populateReview error', e); }
                        }
                    } catch (e) { console.debug('[review-2] populateReview invocation failed', e); }
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', async () => {
                    // Try to sync client Firebase ID token to the server early so server-side endpoints
                    // (like /api/server-profile) can resolve the user's uid via session('firebase_uid').
                    async function trySyncClientIdTokenToServer() {
                        // Firebase client removed — no-op sync.
                        return null;
                    }

                    // Attempt sync but do not block the rest of script heavily — run and allow the later /api/server-profile call to use session if sync completed quickly.
                    // If needed we await it below before calling server-profile.
                    let __rv2_sync_result = null;
                    try {
                        __rv2_sync_result = trySyncClientIdTokenToServer();
                        // record client-side debug info when sync completes (or fails)
                        __rv2_sync_result.then && __rv2_sync_result.then(function(res){
                            try { window.__rv2_clientSyncStatus = { ok: true, result: res || null }; } catch(e){}
                            try { const dbgEl = document.getElementById('__rv2_debug_pre'); if (dbgEl) { try { const prev = JSON.parse(dbgEl.textContent||'{}'); prev.__client_sync = window.__rv2_clientSyncStatus; dbgEl.textContent = JSON.stringify(prev, null, 2); } catch(e){} } } catch(e){}
                        }).catch(function(err){
                            try { window.__rv2_clientSyncStatus = { ok: false, error: (err && err.message) || String(err) }; } catch(e){}
                            try { const dbgEl = document.getElementById('__rv2_debug_pre'); if (dbgEl) { try { const prev = JSON.parse(dbgEl.textContent||'{}'); prev.__client_sync = window.__rv2_clientSyncStatus; dbgEl.textContent = JSON.stringify(prev, null, 2); } catch(e){} } } catch(e){}
                        });
                    } catch(e){}
                    const tryParse = s => {
                        try {
                            return typeof s === 'string' ? JSON.parse(s) : s;
                        } catch (e) {
                            return null;
                        }
                    };
                    const initFirebase = () => { /* Firebase removed: noop */ };
                    const fetchFirestoreDraft = async () => {
                        // Client Firestore usage removed. This function intentionally returns null
                        // so the page falls back to localStorage/sessionStorage or server-side profile.
                        return null;
                    };
                    const readStored = async () => {
                        // Prefer local/session drafts and in-page globals so users editing keep their draft.
                        const keys = ['registrationDraft', 'registration_draft', 'dsRegistrationDraft',
                            'ds_registration', 'registerDraft', 'regDraft', 'reg_data'
                        ];
                        for (const k of keys) {
                            const v = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
                            if (v && typeof v === 'object') {
                                try { console.debug && console.debug('[review-2] readStored: found local/session draft key', k); } catch(e){}
                                try { window.__mvsg_lastLoadedDraft = v; window.__mvsg_lastDraftSource = 'local_storage:' + k; } catch(e){}
                                return v;
                            }
                        }
                        // also check for a global draft object set by other scripts
                        if (window.registrationDraft || window.__REGISTRATION_DRAFT__) {
                            try { console.debug && console.debug('[review-2] readStored: using global registrationDraft'); } catch(e){}
                            const gv = typeof window.registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window.registrationDraft || window.__REGISTRATION_DRAFT__);
                            try { window.__mvsg_lastLoadedDraft = gv; window.__mvsg_lastDraftSource = 'global_registrationDraft'; } catch(e){}
                            return gv;
                        }
                        // If the server injected a profile (admin view), prefer it only when no local draft exists
                        if (window.__mvsg_serverProfile) {
                            try { console.debug && console.debug('[review-2] readStored: using serverProfile injected by server'); } catch(e){}
                            try { window.__mvsg_lastLoadedDraft = window.__mvsg_serverProfile; window.__mvsg_lastDraftSource = 'server_injected'; } catch(e){}
                            return window.__mvsg_serverProfile;
                        }
                        // last resort: attempt Firestore read (client) which will try signed-in user or ?uid override
                        return await fetchFirestoreDraft();
                    };
                    const safeSet = (id, value) => {
                        try {
                            const el = document.getElementById(id);
                            if (!el) { console.debug('[review-2] element not found for id', id, 'value:', value); return; }
                            let out = value;
                            if (out === null || out === undefined) out = '';
                            else if (typeof out === 'object') {
                                if (Array.isArray(out)) out = out.join(', ');
                                else out = JSON.stringify(out);
                            }
                            out = String(out);
                            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = out ?? '';
                            else el.textContent = out ?? '';
                            console.debug('[review-2] set', id, out);
                        } catch (e) {
                            console.warn('[review-2] safeSet error for', id, e);
                        }
                    };
                    const flatten = (obj, out = {}, prefix = '') => {
                        if (!obj || typeof obj !== 'object') return out;
                        for (const k of Object.keys(obj)) {
                            const v = obj[k];
                            const p = prefix ? `${prefix}.${k}` : k;
                            if (v && typeof v === 'object' && !Array.isArray(v)) flatten(v, out, p);
                            else out[p] = v;
                        }
                        return out;
                    };
                    const findFirstMatching = (obj, subs = []) => {
                        try {
                            const flat = flatten(obj || {});
                            for (const sub of subs) {
                                const s = sub.toLowerCase();
                                for (const k of Object.keys(flat)) {
                                    if (k.toLowerCase().includes(s) && flat[k]) return flat[k];
                                }
                            }
                        } catch (e) {
                            /* ignore */
                        }
                        return '';
                    };
                    const normalizeFilename = (s) => {
                        try {
                            if (!s) return '';
                            const str = String(s || '');
                            const parts = str.split(/[/\\]+/);
                            return parts[parts.length - 1] || '';
                        } catch (e) {
                            return s;
                        }
                    };
                    const parseMaybeJson = (v) => {
                        if (v === null || v === undefined) return v;
                        if (Array.isArray(v) || typeof v === 'object') return v;
                        if (typeof v === 'string') {
                            const s = v.trim();
                            if (!s) return '';
                            if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
                                try {
                                    return JSON.parse(s);
                                } catch (e) {
                                    /* fall through */
                                }
                            }
                            if (s.includes(',')) return s.split(',').map(x => x.trim()).filter(Boolean);
                        }
                        return v;
                    };
                    const renderWorkExperiences = (arr) => {
                        const container = document.getElementById('review_job_experiences');
                        if (!container) return;
                        container.innerHTML = '';
                        if (!arr || !arr.length) {
                            container.innerHTML = '<p class="text-gray-600 italic">No job experiences added.</p>';
                            return;
                        }
                        for (const e of arr) {
                            try {
                                const title = e.title || e.job_title || e.jobTitle || '';
                                const company = e.company || e.company_name || e.companyName || '';
                                const desc = e.description || e.job_description || e.desc || '';
                                const el = document.createElement('div');
                                el.className = 'p-3 bg-white rounded-lg border';
                                el.innerHTML = `<p class="font-semibold">${title || company || 'Experience'}</p>` +
                                    (company ? `<p class="text-sm text-gray-600">Company: ${company}</p>` : '') +
                                    (desc ? `<p class="text-sm text-gray-700 mt-1">${desc}</p>` : '');
                                container.appendChild(el);
                            } catch (e) {
                                /* ignore item */
                            }
                        }
                    };
                    const setChoiceImage = (placeholderId, value, cardSelectors = ['.education-card',
                        '.workyr-card'
                    ]) => {
                        try {
                            const container = document.getElementById(`${placeholderId}_container`);
                            const ph = document.getElementById(placeholderId);
                            if (!value) {
                                if (container) container.style.display = 'none';
                                if (ph) ph.src = '';
                                return;
                            }
                            const target = String(value).trim().toLowerCase();
                            const selectors = Array.isArray(cardSelectors) ? cardSelectors : (
                                typeof cardSelectors === 'string' ? [cardSelectors] : ['.selectable-card']);
                            selectors.forEach(sel => document.querySelectorAll(sel).forEach(x => x.classList.remove(
                                'selected')));
                            for (const sel of selectors) {
                                for (const n of document.querySelectorAll(sel)) {
                                    const title = n.querySelector('h3')?.textContent?.trim()?.toLowerCase();
                                    if (title && title === target) {
                                        const img = n.querySelector('img');
                                        if (img && ph) ph.src = img.src || '';
                                        if (container) container.style.display = 'block';
                                        n.classList.add('selected');
                                        return;
                                    }
                                }
                            }
                            if (container) container.style.display = 'block';
                            if (ph) ph.src = '';
                        } catch (e) {
                            console.warn('setChoiceImage', e);
                        }
                    };
                    try {
                        let data = await readStored();
                        // Always attempt to fetch Firestore draft and merge missing keys from remote into local.
                        try {
                            const remoteDoc = await fetchFirestoreDraft();
                            const remote = (remoteDoc && typeof remoteDoc === 'object' && remoteDoc.data && typeof remoteDoc.data === 'object') ? remoteDoc.data : remoteDoc;
                            if (remote && typeof remote === 'object') {
                                // unwrap local wrapper if present
                                if (data && typeof data === 'object' && data.data && typeof data.data === 'object') data = data.data;
                                data = data || {};
                                for (const k of Object.keys(remote)) {
                                    const localVal = data[k];
                                    const remoteVal = remote[k];
                                    // If no local value at all, copy remote entirely
                                    if (localVal === undefined || localVal === null) {
                                        data[k] = remoteVal;
                                        continue;
                                    }
                                    // If local is an empty object, replace with remote
                                    if (typeof localVal === 'object' && !Array.isArray(localVal) && Object.keys(localVal || {}).length === 0) {
                                        data[k] = remoteVal;
                                        continue;
                                    }
                                    // If local is an empty string, replace with remote
                                    if (typeof localVal === 'string' && String(localVal).trim() === '') {
                                        data[k] = remoteVal;
                                        continue;
                                    }
                                    // If both are objects, perform a shallow deep-merge that fills empty/missing inner fields
                                    if (typeof localVal === 'object' && !Array.isArray(localVal) && typeof remoteVal === 'object' && !Array.isArray(remoteVal)) {
                                        for (const subKey of Object.keys(remoteVal)) {
                                            try {
                                                const lv = localVal[subKey];
                                                const rv = remoteVal[subKey];
                                                if (lv === undefined || lv === null) {
                                                    localVal[subKey] = rv;
                                                } else if (typeof lv === 'string' && String(lv).trim() === '') {
                                                    localVal[subKey] = rv;
                                                }
                                            } catch (e) { /* ignore per-field */ }
                                        }
                                        data[k] = localVal;
                                        continue;
                                    }
                                    // otherwise keep localVal as-is (it appears intentionally set)
                                }
                                try { window.__mvsg_lastLoadedDraft = data; window.__mvsg_lastDraftSource = 'firestore_merged'; } catch(e){}
                            }
                        } catch (e) { console.warn('[review-2] fetch/merge draft failed', e); }

                        // If no draft/local/serverProfile found yet, try server-side helper API
                        if (!data) {
                            // give the client->server idToken sync a short chance to complete so server can populate session('firebase_uid')
                            try {
                                if (typeof __rv2_sync_result !== 'undefined' && __rv2_sync_result) {
                                    await Promise.race([__rv2_sync_result, new Promise(res => setTimeout(() => res(null), 2000))]);
                                }
                            } catch (e) { /* ignore sync timing errors */ }
                            try {
                                const resp = await fetch('{{ url('/api/server-profile') }}', { credentials: 'same-origin' });
                                if (resp && resp.ok) {
                                    const json = await resp.json().catch(() => null);
                                    if (json && json.ok && json.profile) {
                                        data = json.profile;
                                        try { console.debug && console.debug('[review-2] fetched server-profile via /api/server-profile, keys:', Object.keys(data)); } catch(e){}
                                    }
                                } else {
                                    const status = resp ? resp.status : 'no-response';
                                    try { console.debug && console.debug('[review-2] /api/server-profile not available or returned', status); } catch(e){}
                                    // Diagnostic: ask server what it sees in session (helps identify missing firebase_uid)
                                    try {
                                        const dbg = await fetch('{{ url('/debug/firebase-session') }}', { credentials: 'same-origin' });
                                        const dbgJson = await dbg.json().catch(() => null);
                                        try { console.debug && console.debug('[review-2] debug/firebase-session:', dbgJson); } catch(e){}
                                        // If debug reveals a session_firebase_uid, try the server-profile endpoint with ?uid= override (useful in non-prod)
                                        if (dbgJson && dbgJson.session_firebase_uid) {
                                            try {
                                                const overrideResp = await fetch('{{ url('/api/server-profile') }}?uid=' + encodeURIComponent(dbgJson.session_firebase_uid), { credentials: 'same-origin' });
                                                if (overrideResp && overrideResp.ok) {
                                                    const js2 = await overrideResp.json().catch(() => null);
                                                    if (js2 && js2.ok && js2.profile) {
                                                        data = js2.profile;
                                                        try { console.debug && console.debug('[review-2] fetched server-profile via override uid from debug endpoint'); } catch(e){}
                                                    }
                                                } else {
                                                    try { console.debug && console.debug('[review-2] override fetch also failed', overrideResp && overrideResp.status); } catch(e){}
                                                }
                                            } catch (e) {
                                                /* ignore override attempt errors */
                                            }
                                        }
                                    } catch (e) {
                                        /* ignore debug fetch errors */
                                    }
                                }
                            } catch (e) {
                                console.warn('[review-2] server-profile fetch failed', e);
                            }
                        }
                        if (!data) {
                            try { console.debug && console.debug('[review-2] no data available after all fallbacks; __mvsg_lastLoadedDraft=', window.__mvsg_lastLoadedDraft, 'source=', window.__mvsg_lastDraftSource); } catch(e){}
                            return;
                        }

                        // Only populate the fields that exist on this review screen
                        const eduLevel = (data.educationInfo && (data.educationInfo.edu_level || data.educationInfo
                            .eduLevel)) || data.edu_level || '';
                        safeSet('review_edu', eduLevel);
                        const eduOther = (data.educationInfo && (data.educationInfo.edu_other_text || data.educationInfo
                            .eduOtherText)) || data.edu_other_text || '';
                        if (eduOther && String(eduOther).trim()) {
                            const el = document.getElementById('review_edu_other');
                            if (el) {
                                el.classList.remove('hidden');
                                el.textContent = 'Other: ' + String(eduOther);
                            }
                        }

                        const sw = data.schoolWorkInfo || data.school || {};
                        // fallback to several key variants and a fuzzy search for 'school' if present
                        const schoolVal = sw.school_name || sw.schoolName || data.school_name || data.school || findFirstMatching(data, ['school', 'school_name', 'schoolName']);
                       safeSet('schoolName', schoolVal || '');

                        safeSet('review_certs_name', sw.certs || sw.certificates || data.certs || '');
                        const certFileRaw = sw.cert_file || sw.certFile || data.cert_file || data.proofFilename || '';
                        const certFile = normalizeFilename(certFileRaw || '');
                        safeSet('review_certs_file', certFile || '');
                        if (certFile) safeSet('review_certfile', certFile);

                        safeSet('review_work', sw.work_type || sw.workType || data.work_type || data.work || '');

                        // work experiences (stringified or array)
                        let weArr = [];
                        try {
                            const raw = (data.workExperience && data.workExperience.work_experiences) || data
                                .work_experiences || '';
                            const parsed = parseMaybeJson(raw);
                            if (Array.isArray(parsed)) weArr = parsed;
                            else if (parsed) weArr = [parsed];
                        } catch (e) {
                            /* ignore */
                        }
                        renderWorkExperiences(weArr);

                        const workplace = (data.workplace && (data.workplace.workplace_choice || data.workplace
                            .workplaceChoice)) || data.workplace_choice || '';
                        safeSet('review_workplace_choice', workplace || '');
                        setChoiceImage('review_workplace_choice_img', workplace, ['.workplace-card',
                            '.selectable-card'
                        ]);


                        

                    } catch (e) {
                        console.error('review-2 preview', e);
                    }

                    // Update non-production debug panel with the last-loaded draft info (if present)
                    try {
                        const dbgEl = document.getElementById('__rv2_debug_pre');
                        if (dbgEl) {
                            const cur = window.__mvsg_lastLoadedDraft || null;
                            const src = window.__mvsg_lastDraftSource || null;
                            const extra = { lastDraftSource: src, lastDraftKeys: cur && typeof cur === 'object' ? Object.keys(cur) : null };
                            // append to existing debug JSON if server-session info already present
                            try {
                                const prev = JSON.parse(dbgEl.textContent || '{}');
                                prev.__client = extra;
                                dbgEl.textContent = JSON.stringify(prev, null, 2);
                            } catch (e) {
                                try { dbgEl.textContent = JSON.stringify({ __client: extra }, null, 2); } catch (e2) {}
                            }
                        }
                    } catch (e) {}
                });
            </script>
            <script>
                // Ensure pill labels are visibly title-cased/capitalized even when server-rendered
                (function(){
                    const titleCase = (s) => {
                        if (!s) return s;
                        return String(s).split(/\s+/).map(w => {
                            if (!w) return w;
                            return w.charAt(0).toUpperCase() + w.slice(1).toLowerCase();
                        }).join(' ');
                    };

                    const fixPillsIn = (rootSelector) => {
                        try {
                            const root = document.querySelector(rootSelector);
                            if (!root) return;
                            // target direct pill spans and any inline-flex badges inside
                            const candidates = Array.from(root.querySelectorAll('span'));
                            candidates.forEach(el => {
                                try {
                                    const txt = (el.textContent || '').trim();
                                    if (!txt) return;
                                    // skip purely decorative em-dash or punctuation
                                    if (/^[—\-–]+$/.test(txt)) return;
                                    const newText = titleCase(txt);
                                    if (newText !== txt) el.textContent = newText;
                                    // also force visual capitalization via inline style in case global CSS overrides
                                    el.style.textTransform = 'capitalize';
                                } catch(e){}
                            });
                        } catch(e) { console.debug('[review-2] fixPillsIn error', e); }
                    };

                    const runAll = () => {
                        try {
                            // common review lists that contain pills
                            ['#review_workplace_list', '#review_work_list', '#review_job_experiences', '#review_certs_name', '#review_certs_file'].forEach(sel => fixPillsIn(sel));
                        } catch(e){}
                    };

                    // run now and also after any populate / storage events
                    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', runAll);
                    else runAll();

                    window.addEventListener('storage', function(){ setTimeout(runAll, 20); });
                    window.addEventListener('mvsg:populateDone', function(){ setTimeout(runAll, 20); });
                    // also observe mutations in review lists (works if something replaces innerHTML)
                    try {
                        const obsTargets = ['review_workplace_list','review_work_list','review_job_experiences'];
                        const obs = new MutationObserver(function(){ setTimeout(runAll, 10); });
                        obsTargets.forEach(id => { const el = document.getElementById(id); if (el) obs.observe(el, { childList: true, subtree: true, characterData: true }); });
                    } catch(e){}
                })();
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
            const savedFileData = localStorage.getItem("uploadedProofData");
            const savedFileType = localStorage.getItem("uploadedProofType");
            const savedFileName = localStorage.getItem("uploadedProofName");

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
                    // store both legacy and "1" keys so both review pages can read it
                    localStorage.setItem("uploadedProofData", fileData);
                    localStorage.setItem("uploadedProofType", ext);
                    localStorage.setItem("uploadedProofName", file.name);

                    localStorage.setItem("uploadedProofData1", fileData);
                    localStorage.setItem("uploadedProofType1", ext);
                    localStorage.setItem("uploadedProofName1", file.name);

                    showFileInfo(file.name, ext);
                    makeFileClickable(prevFileEl, file.name, fileData, ext);
                };
                // ...
                // 🔹 Remove file
                removeBtn.addEventListener("click", () => {
                    // remove both variants
                    ["uploadedProofData","uploadedProofType","uploadedProofName",
                    "uploadedProofData1","uploadedProofType1","uploadedProofName1",
                    "uploadedProofData0","uploadedProofType0","uploadedProofName0",
                    "uploaded_proof_data","uploaded_proof_type","uploaded_proof_name",
                    "proofData","proofType","proofName"
                    ].forEach(k => { try { localStorage.removeItem(k); } catch(e){} });

                    fileInput.value = "";
                    hideFileInfo();
                });
                reader.readAsDataURL(file);
            });

            // 🔹 View button
            viewBtn.addEventListener("click", () => {
                const name = localStorage.getItem("uploadedProofName");
                const data = localStorage.getItem("uploadedProofData");
                const type = localStorage.getItem("uploadedProofType");
                if (data && type && name) openModalPreview(name, data, type);
            });

            // 🔹 Remove file
            removeBtn.addEventListener("click", () => {
                localStorage.removeItem("uploadedProofData");
                localStorage.removeItem("uploadedProofType");
                localStorage.removeItem("uploadedProofName");
                fileInput.value = "";
                hideFileInfo();
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
                    modalContent.innerHTML += `<img src="${data}" alt="${name}" class="w-auto max-w-full max-h-[85vh] mx-auto rounded-lg shadow" />`;
                } else if (type === "pdf") {
                    modalContent.innerHTML += `<iframe src="${data}" class="w-full h-[85vh] rounded-lg border" title="${name}"></iframe>`;
                } else {
                    modalContent.innerHTML += `<p class="text-gray-700">Preview not available for this file type.</p>`;
                }
            }
            })();
            </script>
           <script>
            window.addEventListener("DOMContentLoaded", () => {
                const fileUploadSection = document.getElementById("fileuploadSection");
                if (!fileUploadSection) return;

                // Function to update visibility based on review_certs value
                const updateSectionVisibility = () => {
                    const certValueEl = document.getElementById("review_certs"); // the element storing yes/no
                    const certValue = certValueEl ? certValueEl.textContent || certValueEl.value : null;

                    if (certValue === "yes") {
                        fileUploadSection.style.display = "block";
                        console.log("review_certs is 'yes' → fileuploadSection shown");
                    } else {
                        fileUploadSection.style.display = "none";
                        console.log("review_certs is 'no' or missing → fileuploadSection hidden");
                    }
                };

                // Initial check
                updateSectionVisibility();

                // Optional: if the value of review_certs can change dynamically, you can watch for changes:
                const observer = new MutationObserver(updateSectionVisibility);
                const certValueEl = document.getElementById("review_certs");
                if (certValueEl) {
                    observer.observe(certValueEl, { characterData: true, childList: true, subtree: true });
                }
            });
            </script>

            <script>
                // Populate education/certificates/type-of-work fields
                (function(){
                    function firstLocal(keys){
                        for(const k of keys){
                            try{ const v = localStorage.getItem(k); if(v !== null && v !== undefined) return v; }catch(e){}
                            const el = document.getElementById(k);
                            if(el && (el.value || el.textContent)) return el.value || el.textContent;
                        }
                        return null;
                    }

                    function renderEducation(){
                        const edu = firstLocal(['review_edu','edu_level','education_level','eduLevel']);
                        const school = firstLocal(['schoolName','school','school_name','schoolName']);
                        const other = firstLocal(['review_other','edu_other','edu_other_text']);
                    //    if(edu) document.getElementById('review_edu').textContent = String(edu);
                        if(school) document.getElementById('schoolName').textContent = String(school);
                        if(other) document.getElementById('review_other_label').textContent = String(other);
                    }

                    function renderCertificates(){
                        const cert = firstLocal(['review_certs','certs','has_certificates','review_certs_name']);
                        const certSpan = document.getElementById('review_certs');
                        if(certSpan) certSpan.textContent = cert ? String(cert) : '';
                        const fname = firstLocal(['uploadedProofName','review_certs_file','review_certfile','cert_file','proofFilename']);
                        const fEl = document.getElementById('review_certfile');
                        if(fEl) fEl.textContent = fname ? String(fname) : 'No file uploaded';
                    }

                    function renderTypeOfWork(){
                        const raw = firstLocal(['selected_work_experience','work_type','workType','selectedWorkExperience','review_work','review_work_list']);
                        const container = document.getElementById('review_work_list');
                        if(!container) return;
                        container.innerHTML = '';
                        if(!raw){ container.innerHTML = '<span class="text-gray-600">N/A</span>'; return; }
                        let arr = [];
                        try{ const p = JSON.parse(raw); if(Array.isArray(p)) arr = p; else if(typeof p === 'object') arr = [p]; else arr = String(p).split(',').map(s=>s.trim()).filter(Boolean); }catch(e){ arr = String(raw).split(',').map(s=>s.trim()).filter(Boolean); }
                        if(!arr.length){ container.innerHTML = '<span class="text-gray-600">N/A</span>'; return; }
                        arr.forEach(v=>{
                            const span = document.createElement('span');
                            span.className = 'bg-blue-50 text-blue-800 px-3 py-1 rounded-md text-sm font-medium';
                            span.textContent = String(v);
                            container.appendChild(span);
                        });
                    }

                    function doAll(){ renderEducation(); renderCertificates(); renderTypeOfWork(); }

                    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', doAll); else doAll();
                    window.addEventListener('storage', function(e){ if(!e.key) return doAll(); const keys = ['educationLevel', 'review_edu','edu_level','schoolName','review_other','review_certs','uploadedProofName','selected_work_experience','work_type']; if(keys.includes(e.key)) setTimeout(doAll, 10); });
                })();
            </script>

                <script>
                    window.addEventListener("DOMContentLoaded", () => {
                        const certYes = document.getElementById("certYes");
                        const certNo = document.getElementById("certNo");

                        const chooseFileLabel = document.getElementById("ChooseFilelabel");
                        const proofInput = document.getElementById("proof");
                        const proofRemoveBtn = document.getElementById("proofRemoveBtn");
                        const editBtn_2 = document.getElementById("editSchoolBtn"); 

                        if (!chooseFileLabel || !proofInput || !proofRemoveBtn || !editBtn_2) return;

                        const updateVisibility = (value) => {
                            if (certYes && certYes.checked && certYes.value === "yes") {
                                chooseFileLabel.style.display = "block";
                              //  proofInput.style.display = "block";
                                proofRemoveBtn.style.display = "block";
                                console.log("certYes selected & editBtn_2 says 💾 Save → elements shown");
                            } else {
                                chooseFileLabel.style.display = "none";
                             //   proofInput.style.display = "none";
                                proofRemoveBtn.style.display = "none";
                                console.log("certNo selected or editBtn_2 not 💾 Save → elements hidden");
                            }
                        };

                        // Add change listeners to radio buttons
                        [certYes, certNo].forEach(radio => {
                            radio.addEventListener("change", () => {
                                if (radio.checked) {
                                    updateVisibility(radio.value);
                                }
                            });
                        });

                        // Restore state from localStorage if exists
                        const savedCert = localStorage.getItem("review_certs");
                        if (savedCert) {
                            updateVisibility(savedCert);
                            console.log("Restored cert state from localStorage:", savedCert);
                        }
                    });
                    </script>
           
                  <script>
                    // Helper function to convert snake_case or PascalCase to camelCase
                    function toCamelCase(str) {
                        return str
                        .replace(/[-_](.)/g, (_, group1) => group1.toUpperCase())
                        .replace(/^[A-Z]/, c => c.toLowerCase());
                    }

                    const saved = localStorage.getItem("rpi_personal2");
                 

                    try {
                        const draft = JSON.parse(saved);
                        const fieldIds = ["educationLevel", "schoolName","reviewCerts"];

                        console.log("📦 Retrieved Draft from localStorage:");
                        fieldIds.forEach(id => {
                        const field = document.getElementById(id);
                        if (!field) {
                            console.warn(`Field not found: ${id}`);
                            return;
                        }

                        const value = draft[id] || draft[toCamelCase(id)] || "";
                        field.value = value;

                        console.log(`${id}: ${value}`);
                      //  alert(`${id}: ${value}`);
                        });

                        console.log("✅ Draft loaded into form.");
                    } catch (err) {
                        console.warn("❌ Failed to parse or apply rpi_personal2 draft", err);
                    }
                    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const reviewContainer = document.getElementById('certificateReview');
    const modal = document.getElementById('fileModal');
    const modalContent = document.getElementById('modalContent');
    const closeModalBtn = document.getElementById('closeModalBtn');

    if (!reviewContainer) return;

    /* ==========================================================
       COMPATIBILITY SHIM — Ensure both "normal" and "1" variants 
       exist so all pages can read uploaded file keys consistently.
    ========================================================== */
    (function ensureKeyVariants() {
        try {
            const map = [
                ['uploadedProofData', 'uploadedProofData1'],
                ['uploadedProofType', 'uploadedProofType1'],
                ['uploadedProofName', 'uploadedProofName1'],
                ['uploadedProofData0', 'uploadedProofData'],
                ['uploadedProofType0', 'uploadedProofType'],
                ['uploadedProofName0', 'uploadedProofName']
            ];
            map.forEach(([a, b]) => {
                try {
                    const va = localStorage.getItem(a);
                    const vb = localStorage.getItem(b);

                    if (va && !vb) localStorage.setItem(b, va);
                    else if (vb && !va) localStorage.setItem(a, vb);

                } catch (e) { /* ignore */ }
            });
        } catch (e) { /* ignore */ }
    })();
    /* ========================================================== */


    // ----------------------------------------------------------------------
    // Utility helpers
    // ----------------------------------------------------------------------

    function readFirst(keys) {
        for (const k of keys) {
            try {
                const v = localStorage.getItem(k);
                if (v !== null && v !== undefined) return v;
            } catch (e) {}
        }
        return null;
    }

    function getSavedCert() {
        const data = readFirst(['uploadedProofData1','uploadedProofData','uploadedProofData0','uploaded_proof_data','proofData']);
        const type = readFirst(['uploadedProofType1','uploadedProofType','uploadedProofType0','uploaded_proof_type','proofType']);
        const name = readFirst(['uploadedProofName1','uploadedProofName','uploadedProofName0','uploaded_proof_name','proofName']);
        const hasCertFlag = localStorage.getItem('review_certs') || null;
        return { data, type, name, hasCertFlag };
    }

    // ----------------------------------------------------------------------
    // Renderer for the preview block on the review page
    // ----------------------------------------------------------------------

    function renderPreviewBlock(saved) {
        reviewContainer.innerHTML = '';

        if (saved.hasCertFlag && String(saved.hasCertFlag).toLowerCase() === 'no') {
            reviewContainer.innerHTML = '<p class="text-gray-700 italic">Certificates / Trainings: No</p>';
            return;
        }

        if (saved.data && saved.name) {
            const ext = (saved.type || saved.name.split('.').pop()).toLowerCase();
            const icon = (ext === 'pdf') ? '📄' : (['jpg','jpeg','png'].includes(ext) ? '🖼️' : '📁');

            const block = document.createElement('div');
            block.className = 'flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm';
            block.innerHTML = `
                <span class="text-2xl">${icon}</span>
                <span class="text-sm text-gray-700 truncate max-w-[240px]">${saved.name}</span>
                <div class="ml-auto flex gap-2">
                    <button type="button" id="reviewViewCertBtn" class="bg-[#2E2EFF] text-white text-xs px-3 py-1 rounded-md">View</button>
                    <button type="button" id="reviewRemoveCertBtn" class="bg-[#D20103] text-white text-xs px-3 py-1 rounded-md">Remove</button>
                </div>
            `;
            reviewContainer.appendChild(block);

            document.getElementById('reviewViewCertBtn').addEventListener('click', function () {
                const fresh = getSavedCert();
                if (fresh.data && fresh.name) {
                    const updatedExt = (fresh.type || fresh.name.split('.').pop()).toLowerCase();
                    openPreviewModal(fresh.name, fresh.data, updatedExt);
                } else {
                    alert('No file data found to preview.');
                }
            });

            document.getElementById('reviewRemoveCertBtn').addEventListener('click', function () {
                ['uploadedProofData1','uploadedProofType1','uploadedProofName1',
                 'uploadedProofData','uploadedProofType','uploadedProofName',
                 'uploadedProofData0','uploadedProofType0','uploadedProofName0',
                 'uploaded_proof_data','uploaded_proof_type','uploaded_proof_name',
                 'proofData','proofType','proofName'
                ].forEach(k => { try { localStorage.removeItem(k); } catch(e){} });

                renderPreviewBlock({ hasCertFlag: localStorage.getItem('review_certs') });
            });

            return;
        }

        const filenameFromSpan = document.getElementById('review_certs')?.textContent?.trim();
        if (filenameFromSpan) {
            reviewContainer.innerHTML = `
                <p class="text-gray-700">
                    <span class="font-semibold">Certificates / Trainings:</span>
                    <span id="rv_filename" class="text-blue-600 underline cursor-pointer">${filenameFromSpan}</span>
                </p>
            `;
            const el = document.getElementById('rv_filename');
            if (el) el.addEventListener('click', function () {
                const s = getSavedCert();
                if (s.data && s.name)
                    openPreviewModal(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
                else alert('No file data available to preview.');
            });
            return;
        }

        reviewContainer.innerHTML = '<p class="text-gray-700 italic">Certificates / Trainings: No file uploaded</p>';
    }

    // ----------------------------------------------------------------------
    // Modal Preview
    // ----------------------------------------------------------------------

    function openPreviewModal(name, dataUrl, ext) {
        if (!modal || !modalContent) return;
        modalContent.innerHTML = `<h2 class="font-semibold mb-2">${name}</h2>`;

        let src = null;
        try {
            const s = String(dataUrl || '').trim();

            // Direct data: URL (base64)
            if (s.startsWith('data:')) {
                src = s;
            }
            // Fully qualified http/https or root-relative ("/")
            else if (s.startsWith('http://') || s.startsWith('https://') || s.startsWith('/')) {
                src = s;
            }
            else {
                // Try alternate fallback storage keys
                const fallbackKeys = [
                    'uploadedProofUrl', 'uploaded_proof_url',
                    'uploadedProofPath', 'uploaded_proof_path',
                    'uploadedProofDataUrl', 'uploaded_proof_data_url'
                ];

                for (const k of fallbackKeys) {
                    const v = localStorage.getItem(k);
                    if (v) {
                        src = v;
                        break;
                    }
                }

                // Final fallback: assume Laravel `/storage/uploads/<filename>`
                if (!src) {
                    const safe = encodeURIComponent((name || '').split(/[/\\]+/).pop());
                    src = safe ? '/storage/uploads/' + safe : '';
                }
            }
        } catch (e) { /* ignore */ }

        /* -----------------------------
        EXTENSION-SPECIFIC PREVIEW
        ------------------------------*/
        if (['jpg', 'jpeg', 'png'].includes(ext)) {
            modalContent.innerHTML += src
                ? `<img src="${src}" alt="${name}" class="w-auto max-w-full max-h-[85vh] mx-auto rounded-lg shadow" />`
                : `<p class="text-gray-700">No preview source available for this image.</p>`;
        }
        else if (ext === 'pdf') {
            modalContent.innerHTML += src
                ? `<iframe src="${src}" class="w-full h-[85vh] rounded-lg border"></iframe>`
                : `<p class="text-gray-700">No preview source available for this PDF.</p>`;
        }
        else {
            modalContent.innerHTML += `<p class="text-gray-700">Preview not available for this file type.</p>`;
        }

        modal.classList.remove('hidden');
    }


    function closeModalFn() {
        modal.classList.add('hidden');
        modalContent.innerHTML = '';
    }

    // ----------------------------------------------------------------------
    // Bind click handlers
    // ----------------------------------------------------------------------

    const fallbackFilenameEl = document.getElementById('review_certfile');
    if (fallbackFilenameEl) {
        fallbackFilenameEl.classList.add('cursor-pointer');
        fallbackFilenameEl.addEventListener('click', function () {
            const s = getSavedCert();
            if (s.data && s.name)
                openPreviewModal(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else alert('No file data available to preview.');
        });
    }

    const proofViewBtn = document.getElementById('proofViewBtn');
    if (proofViewBtn) {
        proofViewBtn.addEventListener('click', function () {
            const s = getSavedCert();
            if (s.data && s.type && s.name)
                openPreviewModal(s.name, s.data, s.type.toLowerCase());
            else if (s.data && s.name)
                openPreviewModal(s.name, s.data, (s.name.split('.').pop()).toLowerCase());
            else
                alert('No uploaded file found.');
        });
    }

    closeModalBtn?.addEventListener('click', e => { e.preventDefault(); closeModalFn(); });
    modal?.addEventListener('click', e => { if (e.target === modal) closeModalFn(); });

    // initial render
    renderPreviewBlock(getSavedCert());

    // listen for storage changes
    window.addEventListener('storage', function (e) {
        if (!e.key) { renderPreviewBlock(getSavedCert()); return; }

        const watchKeys = [
            'uploadedProofData1','uploadedProofType1','uploadedProofName1',
            'uploadedProofData','uploadedProofType','uploadedProofName',
            'uploadedProofData0','uploadedProofType0','uploadedProofName0',
            'uploaded_proof_data','uploaded_proof_type','uploaded_proof_name',
            'proofData','proofType','proofName',
            'review_certs'
        ];
        if (watchKeys.includes(e.key)) {
            setTimeout(() => renderPreviewBlock(getSavedCert()), 30);
        }
    });

});
</script>
<script>
(function(){
    // Ensure a registerreview1-style modal exists (create if not)
    let modal = document.getElementById('filePreviewModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'filePreviewModal';
        modal.className = 'hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[100000]';
        modal.innerHTML = '<div class="bg-white rounded-lg shadow-lg p-4 max-w-4xl w-[92%] relative">' +
            '<button id="filePreviewClose" class="absolute top-2 right-3 text-gray-600 hover:text-gray-900 text-2xl">×</button>' +
            '<div id="filePreviewContent" class="p-2"></div>' +
            '</div>';
        document.body.appendChild(modal);
    }

    const modalContent = document.getElementById('filePreviewContent');
    const modalClose = document.getElementById('filePreviewClose');

    // Resolve stored values (tries many common keys)
    function readFirst(keys){
        for(const k of keys){
            try { const v = localStorage.getItem(k); if (v !== null && v !== undefined && String(v).trim() !== '') return v; } catch(e){}
        }
        return null;
    }

    function resolvePreviewSrc(name, providedData){
        try {
            const s = (providedData || '').toString().trim();
            if (s && s.startsWith('data:')) return s;
            if (s && (s.startsWith('http://') || s.startsWith('https://') || s.startsWith('/'))) return s;
            // explicit fallback url/path keys
            const fallbackKeys = ['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path','uploadedProofDataUrl','uploaded_proof_data_url'];
            for (const k of fallbackKeys) { const v = readFirst([k]); if (v) return v; }
            // last resort: guess Laravel public storage path
            const fname = encodeURIComponent(String(name || '').split(/[/\\]+/).pop() || '');
            if (fname) return '/storage/uploads/' + fname;
        } catch(e){}
        return null;
    }

    function openPreview(name, dataUrl, type){
        modalContent.innerHTML = `<h2 class="font-semibold mb-2">${name || 'File preview'}</h2>`;
        const ext = (type || (name || '').split('.').pop() || '').toString().toLowerCase();
        const src = resolvePreviewSrc(name, dataUrl);
        if (['jpg','jpeg','png'].includes(ext)) {
            if (src) modalContent.innerHTML += `<img src="${src}" class="max-h-[70vh] rounded shadow mx-auto" alt="${name}">`;
            else modalContent.innerHTML += `<p class="text-gray-600">No preview source available for this image.</p>`;
        } else if (ext === 'pdf') {
            if (src) modalContent.innerHTML += `<iframe src="${src}" class="w-full h-[70vh] rounded border" title="${name}"></iframe>`;
            else modalContent.innerHTML += `<p class="text-gray-600">No preview source available for this PDF.</p>`;
        } else {
            if (src) modalContent.innerHTML += `<a href="${src}" target="_blank" rel="noopener" class="text-blue-600 underline">Open ${name}</a>`;
            else modalContent.innerHTML += `<p class="text-gray-600">Preview not available for this file type.</p>`;
        }
        modal.classList.remove('hidden');
    }

    function closePreview(){
        modal.classList.add('hidden');
        modalContent.innerHTML = '';
    }

    modalClose?.addEventListener('click', closePreview);
    modal?.addEventListener('click', function(e){ if (e.target === modal) closePreview(); });

    // Wire View buttons to use this modal. Use getSavedCert if present; otherwise read common keys.
    function getSavedCertFallback(){
        // prefer the getSavedCert defined earlier if available
        try { if (typeof getSavedCert === 'function') return getSavedCert(); } catch(e){}
        // fallback manual read
        const name = readFirst(['uploadedProofName1','uploadedProofName','uploadedProofName0','uploaded_proof_name','proofName']);
        const data = readFirst(['uploadedProofData1','uploadedProofData','uploadedProofData0','uploaded_proof_data','proofData']);
        const type = readFirst(['uploadedProofType1','uploadedProofType','uploadedProofType0','uploaded_proof_type','proofType']);
        return { name, data, type };
    }

    // Attach to proofViewBtn (upload section) and reviewViewCertBtn (preview block) if present
    const proofViewBtn = document.getElementById('proofViewBtn');
    if (proofViewBtn) {
        proofViewBtn.addEventListener('click', function(){
            const s = getSavedCertFallback();
            if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else {
                const url = readFirst(['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path']);
                if (url) openPreview(s.name || 'file', url, (s.type || (s.name? s.name.split('.').pop():'')).toLowerCase());
                else alert('No uploaded file found.');
            }
        });
    }

    const reviewViewBtn = document.getElementById('reviewViewCertBtn');
    if (reviewViewBtn) {
        reviewViewBtn.addEventListener('click', function(){
            const s = getSavedCertFallback();
            if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else {
                const url = readFirst(['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path']);
                if (url) openPreview(s.name || 'file', url, (s.type || (s.name? s.name.split('.').pop():'')).toLowerCase());
                else alert('No file data found to preview.');
            }
        });
    }

    // Make certificate filename element clickable to open modal
    const certFilenameEl = document.getElementById('review_certfile');
    if (certFilenameEl) {
        certFilenameEl.addEventListener('click', function(){
            const s = getSavedCertFallback();
            if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else {
                const url = readFirst(['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path']);
                if (url) openPreview(s.name || 'file', url, (s.type || (s.name? s.name.split('.').pop():'')).toLowerCase());
                else alert('No file data available to preview.');
            }
        });
    }

    // Also ensure the small certificateReview block (if it renders a View button later) is watched for dynamic injection
    const obs = new MutationObserver(() => {
        // rebind dynamically-inserted reviewViewCertBtn
        const dynBtn = document.getElementById('reviewViewCertBtn');
        if (dynBtn && !dynBtn.__mvsg_bound) {
            dynBtn.__mvsg_bound = true;
            dynBtn.addEventListener('click', function(){
                const s = getSavedCertFallback();
                if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
                else alert('No file data available to preview.');
            });
        }
    });
    const container = document.getElementById('certificateReview') || document.body;
    if (container) obs.observe(container, { childList: true, subtree: true });

})();
</script>
<script>
(function(){
    // Ensure a registerreview1-style modal exists (create if not)
    let modal = document.getElementById('filePreviewModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'filePreviewModal';
        modal.className = 'hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[100000]';
        modal.innerHTML = '<div class="bg-white rounded-lg shadow-lg p-4 max-w-4xl w-[92%] relative">' +
            '<button id="filePreviewClose" class="absolute top-2 right-3 text-gray-600 hover:text-gray-900 text-2xl">×</button>' +
            '<div id="filePreviewContent" class="p-2"></div>' +
            '</div>';
        document.body.appendChild(modal);
    }

    const modalContent = document.getElementById('filePreviewContent');
    const modalClose = document.getElementById('filePreviewClose');

    // Resolve stored values (tries many common keys)
    function readFirst(keys){
        for(const k of keys){
            try { const v = localStorage.getItem(k); if (v !== null && v !== undefined && String(v).trim() !== '') return v; } catch(e){}
        }
        return null;
    }

    function resolvePreviewSrc(name, providedData){
        try {
            const s = (providedData || '').toString().trim();
            if (s && s.startsWith('data:')) return s;
            if (s && (s.startsWith('http://') || s.startsWith('https://') || s.startsWith('/'))) return s;
            // explicit fallback url/path keys
            const fallbackKeys = ['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path','uploadedProofDataUrl','uploaded_proof_data_url'];
            for (const k of fallbackKeys) { const v = readFirst([k]); if (v) return v; }
            // last resort: guess Laravel public storage path
            const fname = encodeURIComponent(String(name || '').split(/[/\\]+/).pop() || '');
            if (fname) return '/storage/uploads/' + fname;
        } catch(e){}
        return null;
    }

    function openPreview(name, dataUrl, type){
        modalContent.innerHTML = `<h2 class="font-semibold mb-2">${name || 'File preview'}</h2>`;
        const ext = (type || (name || '').split('.').pop() || '').toString().toLowerCase();
        const src = resolvePreviewSrc(name, dataUrl);
        if (['jpg','jpeg','png'].includes(ext)) {
            if (src) modalContent.innerHTML += `<img src="${src}" class="max-h-[70vh] rounded shadow mx-auto" alt="${name}">`;
            else modalContent.innerHTML += `<p class="text-gray-600">No preview source available for this image.</p>`;
        } else if (ext === 'pdf') {
            if (src) modalContent.innerHTML += `<iframe src="${src}" class="w-full h-[70vh] rounded border" title="${name}"></iframe>`;
            else modalContent.innerHTML += `<p class="text-gray-600">No preview source available for this PDF.</p>`;
        } else {
            if (src) modalContent.innerHTML += `<a href="${src}" target="_blank" rel="noopener" class="text-blue-600 underline">Open ${name}</a>`;
            else modalContent.innerHTML += `<p class="text-gray-600">Preview not available for this file type.</p>`;
        }
        modal.classList.remove('hidden');
    }

    function closePreview(){
        modal.classList.add('hidden');
        modalContent.innerHTML = '';
    }

    modalClose?.addEventListener('click', closePreview);
    modal?.addEventListener('click', function(e){ if (e.target === modal) closePreview(); });

    // Wire View buttons to use this modal. Use getSavedCert if present; otherwise read common keys.
    function getSavedCertFallback(){
        // prefer the getSavedCert defined earlier if available
        try { if (typeof getSavedCert === 'function') return getSavedCert(); } catch(e){}
        // fallback manual read
        const name = readFirst(['uploadedProofName1','uploadedProofName','uploadedProofName0','uploaded_proof_name','proofName']);
        const data = readFirst(['uploadedProofData1','uploadedProofData','uploadedProofData0','uploaded_proof_data','proofData']);
        const type = readFirst(['uploadedProofType1','uploadedProofType','uploadedProofType0','uploaded_proof_type','proofType']);
        return { name, data, type };
    }

    // Attach to proofViewBtn (upload section) and reviewViewCertBtn (preview block) if present
    const proofViewBtn = document.getElementById('proofViewBtn');
    if (proofViewBtn) {
        proofViewBtn.addEventListener('click', function(){
            const s = getSavedCertFallback();
            if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else {
                const url = readFirst(['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path']);
                if (url) openPreview(s.name || 'file', url, (s.type || (s.name? s.name.split('.').pop():'')).toLowerCase());
                else alert('No uploaded file found.');
            }
        });
    }

    const reviewViewBtn = document.getElementById('reviewViewCertBtn');
    if (reviewViewBtn) {
        reviewViewBtn.addEventListener('click', function(){
            const s = getSavedCertFallback();
            if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else {
                const url = readFirst(['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path']);
                if (url) openPreview(s.name || 'file', url, (s.type || (s.name? s.name.split('.').pop():'')).toLowerCase());
                else alert('No file data found to preview.');
            }
        });
    }

    // Make certificate filename element clickable to open modal
    const certFilenameEl = document.getElementById('review_certfile');
    if (certFilenameEl) {
        certFilenameEl.addEventListener('click', function(){
            const s = getSavedCertFallback();
            if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
            else {
                const url = readFirst(['uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path']);
                if (url) openPreview(s.name || 'file', url, (s.type || (s.name? s.name.split('.').pop():'')).toLowerCase());
                else alert('No file data available to preview.');
            }
        });
    }

    // Also ensure the small certificateReview block (if it renders a View button later) is watched for dynamic injection
    const obs = new MutationObserver(() => {
        // rebind dynamically-inserted reviewViewCertBtn
        const dynBtn = document.getElementById('reviewViewCertBtn');
        if (dynBtn && !dynBtn.__mvsg_bound) {
            dynBtn.__mvsg_bound = true;
            dynBtn.addEventListener('click', function(){
                const s = getSavedCertFallback();
                if (s && s.data && s.name) openPreview(s.name, s.data, (s.type || s.name.split('.').pop()).toLowerCase());
                else alert('No file data available to preview.');
            });
        }
    });
    const container = document.getElementById('certificateReview') || document.body;
    if (container) obs.observe(container, { childList: true, subtree: true });

})();
</script>
</body>

</html>
