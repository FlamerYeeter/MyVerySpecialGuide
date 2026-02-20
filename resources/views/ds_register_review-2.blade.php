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

        /* Review2: make certificate text-only details match education page styling */
        .cert-details {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem 0.9rem;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }
        .cert-details .title {
            font-weight: 600;
            color: #1f2937; /* gray-800 */
            margin-bottom: 0.25rem;
        }
        .cert-details .meta {
            color: #4b5563; /* gray-600 */
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }
        .cert-no-file {
            color: #6b7280; /* gray-500 */
            font-style: italic;
        }
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
                        aria-label="Read this section aloud in English then Filipino">🔊</button>
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
                <button id="editSchoolBtn" type="button"
                class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm sm:text-base font-semibold shadow-md hover:bg-blue-700 transition">
                 ✏️ Edit Information
                </button>
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

                <!-- Visible indicator removed; we rely on uploadedCertificates_education for files -->

                <div id="certificateReview" class="mt-4 text-gray-800 mb-3">
                    <!-- Hidden canonical field for draft restore and scripts that expect an input -->
                    <input type="hidden" id="review_certs" name="review_certs" value="" />
                    <!-- Read-only list -->
                    <div id="certsList" class="space-y-3"></div>
                    <div id="noCertsMsg" class="text-gray-600 italic">No certificates or trainings added.</div>

                    <!-- Inline edit panel (hidden until Edit clicked) -->
                    <div id="certsEdit" class="hidden mt-4">
                        <div id="certs_container" class="space-y-4"></div>

                        <template id="cert_template">
                            <div class="cert-entry bg-white border border-gray-200 rounded-lg p-4 relative">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Name of Certificate / Training</label>
                                        <input type="text" class="cert-name mt-1 w-full border rounded px-2 py-1" placeholder="e.g. Food Safety Training">
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Issued By</label>
                                        <input type="text" class="cert-issuer mt-1 w-full border rounded px-2 py-1" placeholder="e.g. TESDA, Training Center">
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Date Completed</label>
                                        <input type="date" class="cert-date mt-1 w-full border rounded px-2 py-1">
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">What did you learn?</label>
                                        <input type="text" class="cert-desc mt-1 w-full border rounded px-2 py-1" placeholder="e.g. How to clean, serve food">
                                    </div>
                                </div>
                                <button type="button" class="remove-cert absolute top-3 right-3 text-sm bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                            </div>
                        </template>

                        <div class="flex gap-3 mt-4">
                            <button id="addCertBtn" type="button" class="bg-indigo-600 text-white px-4 py-2 rounded-md">＋ Add Another Certificate</button>
                            <button id="cancelCertsBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
                        </div>
                    </div>
                </div>
    </div>

<!-- Education Info edit/save btn script -->
<script>
/*
  Unified toggle: main #editSchoolBtn will open/close the education edit controls AND
  the inline certificates editor via the exposed cert-editor API (if present).
*/
(function(){
    const btn = document.getElementById('editSchoolBtn');
    if (!btn) return;
    // store editing state on the button to be read by other handlers
    function isEditing() { return btn.dataset.mvsgEditing === '1'; }
    function setEditing(v){
        btn.dataset.mvsgEditing = v ? '1' : '0';
        // visual label sync
        if (v) { btn.textContent = '💾 Save Changes'; btn.classList.remove('bg-blue-600'); btn.classList.add('bg-green-600'); }
        else    { btn.textContent = '✏️ Edit Information'; btn.classList.remove('bg-green-600'); btn.classList.add('bg-blue-600'); }
    }

    // ensure a stable display element exists for the education-level value (span)
    function ensureLevelDisplay(){
        const raw = document.getElementById('educationLevel');
        if (!raw) return null;
        let disp = document.getElementById('educationLevel_display');
        if (!disp) {
            disp = document.createElement('span');
            disp.id = 'educationLevel_display';
            disp.style.display = raw.style && raw.style.display ? raw.style.display : 'inline-block';
            raw.parentNode.insertBefore(disp, raw);
        }
        return { raw, disp };
    }

    function openEducationEditor(){
        const { raw, disp } = ensureLevelDisplay() || {};
        const editSelect = document.getElementById('edit_edu_select');
        const schoolSpan = document.getElementById('schoolName');
        const schoolInput = document.getElementById('edit_school_input');

        // Prefer values from localStorage (most authoritative), then display span, then raw
        const storedEdu = (localStorage.getItem('educationLevel') || localStorage.getItem('edu_level') || localStorage.getItem('review_edu') || '').trim();
        const storedSchool = (localStorage.getItem('schoolName') || localStorage.getItem('school') || localStorage.getItem('review_school') || '').trim();

        const currentVal = storedEdu || (disp && (disp.textContent||'').trim()) || (raw && ((raw.value||raw.textContent)||'').toString().trim()) || '';
        const currentSchool = storedSchool || (schoolSpan && (schoolSpan.textContent||'').trim()) || '';

        // populate editor controls
        if (editSelect) {
            // pick matching option if exists, else leave current value
            const opt = Array.from(editSelect.options).find(o => String(o.value).toLowerCase() === String(currentVal).toLowerCase() || String(o.text).toLowerCase() === String(currentVal).toLowerCase());
            if (opt) editSelect.value = opt.value;
            else if (currentVal) {
                // if value not in list, create a temporary option so user sees it
                try {
                    const tmp = document.createElement('option');
                    tmp.value = currentVal;
                    tmp.text = currentVal;
                    editSelect.add(tmp, editSelect.options[0]);
                    editSelect.value = currentVal;
                } catch(e){}
            }
        }
        if (schoolInput) schoolInput.value = currentSchool || '';

        // show editors, hide displays
        try { if (disp) disp.style.display = 'none'; } catch(e){}
        try { if (raw) raw.style.display = 'none'; } catch(e){}
        if (editSelect) { editSelect.classList.remove('hidden'); editSelect.style.display = ''; }
        if (schoolSpan) schoolSpan.classList.add('hidden');
        if (schoolInput) { schoolInput.classList.remove('hidden'); schoolInput.style.display = ''; }

        // open inline cert editor (use exposed API if present)
        try {
            if (typeof window.__mvsg_enterCerts === 'function') {
                window.__mvsg_enterCerts();
            } else {
                const certPanel = document.getElementById('certsEdit');
                if (certPanel) certPanel.classList.remove('hidden');
                const listEl = document.getElementById('certsList');
                if (listEl) listEl.style.display = 'none';
            }
        } catch(e){}
    }

    function closeEducationEditorAndSave(){
        const { raw, disp } = ensureLevelDisplay() || {};
        const editSelect = document.getElementById('edit_edu_select');
        const schoolSpan = document.getElementById('schoolName');
        const schoolInput = document.getElementById('edit_school_input');

        // read editor values (fall back to localStorage)
        const eduValue = (editSelect && (editSelect.value||'').toString().trim()) ||
                         (localStorage.getItem('educationLevel') || localStorage.getItem('edu_level') || '').toString().trim() ||
                         (disp && (disp.textContent||'').trim()) || (raw && (raw.value||raw.textContent||'').toString().trim()) || '';

        const schoolValue = (schoolInput && (schoolInput.value||'').toString().trim()) ||
                            (localStorage.getItem('schoolName') || localStorage.getItem('school') || '').toString().trim() ||
                            (schoolSpan && (schoolSpan.textContent||'').trim()) || '';

        // prepare display value: if user selected "Other", prefer the custom text
        function readOtherTextFromStorage(){
            try {
                const keys = ['edu_other_text','educationOther','education_other','review_other'];
                for (const k of keys) {
                    const v = (localStorage.getItem(k) || '').toString().trim();
                    if (v) return v;
                }
                // also check the canonical education_profile object
                const prof = localStorage.getItem('education_profile');
                if (prof) {
                    try {
                        const p = JSON.parse(prof);
                        if (p && (p.edu_other_text || p.eduOther || p.education_other)) return (p.edu_other_text || p.eduOther || p.education_other).toString().trim();
                    } catch(e){}
                }
            } catch(e){}
            return '';
        }

        let displayVal = eduValue || '';
        try {
            if (String(displayVal).toLowerCase() === 'other' || String(displayVal).toLowerCase() === 'others') {
                const other = readOtherTextFromStorage();
                if (other) displayVal = other;
            }
        } catch(e){}

        // update canonical display span
        try {
            if (disp) {
                disp.textContent = displayVal || '';
                disp.style.display = '';
                disp.classList.remove('hidden');
            }
        } catch(e){}

        // also keep the raw element in sync (some scripts query this id)
        try {
            if (raw) {
                if (raw.tagName === 'INPUT' || raw.tagName === 'TEXTAREA') raw.value = eduValue || '';
                else raw.textContent = eduValue || '';
                // keep raw hidden so display span is primary
                raw.style.display = 'none';
                raw.classList.add('hidden');
            }
        } catch(e){}

        // hide editor select cleanly
        if (editSelect) { try { editSelect.classList.add('hidden'); editSelect.style.display = 'none'; } catch(e){} }

        // update school display and hide input
        if (schoolSpan) {
            schoolSpan.textContent = schoolValue || '';
            schoolSpan.classList.remove('hidden');
            schoolSpan.style.display = '';
        }
        if (schoolInput) { try { schoolInput.classList.add('hidden'); schoolInput.style.display = 'none'; } catch(e){} }

        // persist to multiple known keys so other scripts pick up immediately
        try {
            const sEdu = eduValue || '';
            const sSchool = schoolValue || '';
            const keysEdu = ['educationLevel','edu_level','education_level','review_edu','eduLevel'];
            const keysSchool = ['schoolName','school','school_name','review_school'];

            keysEdu.forEach(k => { try { localStorage.setItem(k, sEdu); } catch(e){} });
            keysSchool.forEach(k => { try { localStorage.setItem(k, sSchool); } catch(e){} });

            // update rpi_personal2 draft if present
            try {
                const rawDraft = localStorage.getItem('rpi_personal2') || localStorage.getItem('rpi_personal') || localStorage.getItem('registrationDraft');
                let draft = rawDraft ? JSON.parse(rawDraft) : (window.__mvsg_lastLoadedDraft || {});
                if (!draft || typeof draft !== 'object') draft = {};
                draft.schoolWorkInfo = draft.schoolWorkInfo || {};
                draft.schoolWorkInfo.school = sSchool;
                draft.schoolWorkInfo.edu_level = sEdu;
                try { localStorage.setItem('rpi_personal2', JSON.stringify(draft)); } catch(e){}
            } catch(e){}
            // notify other listeners
            window.dispatchEvent(new CustomEvent('mvsg:educationSaved', { detail: { educationLevel: eduValue, schoolName: schoolValue } }));
            try { window.dispatchEvent(new StorageEvent('storage', { key: 'educationLevel', newValue: eduValue })); } catch(e){}
        } catch(e){ console.warn('persist education failed', e); }

        // ensure any other UI that reads certificates/education refreshes now
        try { if (typeof renderReadOnly === 'function') renderReadOnly(); } catch(e){}
        try { if (typeof renderPreviewBlock === 'function') renderPreviewBlock(); } catch(e){}
        try { if (typeof window.populateReview === 'function') window.populateReview(); } catch(e){}
        try { window.dispatchEvent(new Event('mvsg:populateDone')); } catch(e){}

        // close inline cert editor (save via exposed API if available)
        try {
            if (typeof window.__mvsg_exitCerts === 'function') {
                window.__mvsg_exitCerts(true);
            } else {
                const certPanel = document.getElementById('certsEdit');
                if (certPanel) certPanel.classList.add('hidden');
                const listEl = document.getElementById('certsList');
                if (listEl) listEl.style.display = '';
            }
        } catch(e){}
    }

    // single click handler
    btn.addEventListener('click', function(ev){
        if (!isEditing()) {
            setEditing(true);
            openEducationEditor();
        } else {
            // save + exit
            setEditing(false);
            closeEducationEditorAndSave();
        }
    });

    // initialize visual to "not editing"
    setEditing(false);
})();
</script>

            <!-- Work Experience -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 relative">
                <div class="flex justify-between items-center mb-4 border-b border-blue-300 pb-2">
                    <h3 class="text-lg font-semibold text-blue-600">Work Experience</h3>
                    <button type="button"
                    class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm sm:text-base font-semibold shadow-md hover:bg-blue-700 transition edit-btn" 
                    data-section="work">
                    ✏️ Edit Information
                </button>
                </div>

                <div class="text-gray-800 mb-5">
                    <p class="flex items-start gap-2"><span class="font-semibold">Type of Work:</span>
                        <span id="review_work_list" class="flex flex-wrap gap-2 items-center">
                            <span class="text-gray-600">N/A</span>
                        </span>
                        <!-- edit select (hidden until Edit clicked) -->
                        <select id="edit_work_select" class="hidden border rounded px-2 py-1 ml-3">
                            <option value="">— Select —</option>
                            <option value="paid">Paid</option>
                            <option value="volunteer">Volunteer</option>
                            <option value="internship">Internship</option>
                            <option value="none">No, this would be my first time</option>
                        </select>
                    </p>
                </div>

                <div class="text-gray-800">
                    <h4 class="text-md font-semibold text-blue-700 mb-3">Job Experiences</h4>
                    <div id="review_job_experiences" class="space-y-4">
                        <p class="text-gray-600 italic">No job experiences added.</p>
                    </div>
                <!-- Inline Work Edit Panel (hidden until Edit clicked) -->
                <div id="workEditPanel" class="hidden bg-white rounded-lg border border-gray-200 p-4 mt-4">
                    <template id="job_edit_template">
                        <div class="job-edit-entry bg-white p-4 rounded-lg border border-gray-100 mb-3">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Job Title</label>
                                    <input type="text" class="job-edit-title mt-1 w-full border rounded px-2 py-1" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Company</label>
                                    <input type="text" class="job-edit-company mt-1 w-full border rounded px-2 py-1" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Work Year</label>
                                    <input type="text" maxlength="4" inputmode="numeric" class="job-edit-year mt-1 w-full border rounded px-2 py-1" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" class="job-edit-desc mt-1 w-full border rounded px-2 py-1" />
                                </div>
                            </div>
                            <div class="mt-3 text-right">
                                <button type="button" class="remove-job-edit bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                            </div>
                        </div>
                    </template>

                    <div id="work_edit_container" class="space-y-3"></div>
                    <div class="flex gap-3 mt-4">
                        <button id="addWorkBtn" type="button" class="bg-indigo-600 text-white px-4 py-2 rounded-md">＋ Add Another Job</button>
                        <button id="saveWorkBtn" type="button" class="bg-green-600 text-white px-4 py-2 rounded-md">Save Work</button>
                        <button id="cancelWorkBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
                    </div>
                </div>
                    <script>
                        // Render saved job experiences from register work page into this review view.
                        (function(){
                            function normalizeEntry(e) {
                                if (!e || typeof e !== 'object') return null;
                                // Try many common key names used across forms
                                const title = e.title || e.job_title || e.position || e.role || e.job || '';
                                const company = e.company || e.company_name || e.employer || e.Company || '';
                                const year = e.work_year || e.start_year || e.job_start_year || e.year || e.startYear || e.job_work_year || '';
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
                // No diagnostics UI here — review-2 now reads canonical `uploadedCertificates_education`.
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
                            el.innerHTML = '';
                            if(!raw) {
                                el.innerHTML = '<span class="text-gray-600">—</span>';
                                if(imgContainer) imgContainer.classList.add('hidden');
                                return;
                            }

                            // Normalize value to an array of labels
                            let vals = [];
                            try{
                                const parsed = JSON.parse(raw);
                                if (Array.isArray(parsed)) vals = parsed.map(v => String(v || '').trim()).filter(Boolean);
                                else if (typeof parsed === 'object') vals = Object.values(parsed).map(v=>String(v||'').trim()).filter(Boolean);
                                else vals = String(parsed || '').split(',').map(s=>s.trim()).filter(Boolean);
                            }catch(e){
                                // not JSON — treat as comma-separated or single string
                                vals = String(raw || '').split(',').map(s=>s.trim()).filter(Boolean);
                            }

                            // If still empty, show dash
                            if(!vals.length){
                                el.innerHTML = '<span class="text-gray-600">—</span>';
                            } else {
                                // Create pill badges matching Type of Work style
                                vals.forEach(v => {
                                    const span = document.createElement('span');
                                    span.className = 'bg-blue-50 text-blue-800 px-3 py-1 rounded-md text-sm font-medium';
                                    span.textContent = (String(v) || '').replace(/^\[|\]$/g,'');
                                    el.appendChild(span);
                                });
                            }

                            // image handling stays the same
                            const imgSrc = readPossibleKeys(['workplace_choice_img','workplace_image','review_workplace_choice_img_src']);
                            if(imgSrc && imgEl){ imgEl.src = imgSrc; imgContainer.classList.remove('hidden'); }
                            else if(imgContainer) imgContainer.classList.add('hidden');
                        }catch(e){ console.debug('renderWorkplace error', e); }
                    }

                    document.addEventListener('DOMContentLoaded', function(){ renderWorkplace(); });
                    window.addEventListener('storage', function(e){ if(!e.key) { renderWorkplace(); return;} if(['workplace','preferred_workplace','workplace_choices','workplaceChoice','workplace_choice_img','workplace_image'].includes(e.key)) renderWorkplace(); });
                })();
            </script>

<!-- Work Environment -->
<div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 relative">
    <div class="flex justify-between items-center mb-4 border-b border-blue-300 pb-2">
        <h3 class="text-lg font-semibold text-blue-600">Work Environment</h3>
        <button type="button"
                class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm sm:text-base font-semibold shadow-md hover:bg-blue-700 transition edit-btn"
                data-section="environment">
            ✏️ Edit Information
        </button>
    </div>

    <div class="text-gray-800">
        <p class="flex items-start gap-2">
            <span class="font-semibold">Preferred Workplace:</span>
            <span id="review_workplace_list" class="flex flex-wrap gap-2 items-center">
                <span class="text-gray-600">—</span>
            </span>
        </p>
    </div>

    <div id="review_workplace_choice_img_container" class="mt-4 text-center hidden">
        <div class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
            <img id="review_workplace_choice_img" src="" alt="Workplace image"
                 class="w-full h-full object-contain rounded-md" />
        </div>
    </div>
</div>


<!--  WORK ENVIRONMENT EDIT MODAL -->
<div id="editEnvironmentModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center 
            z-[9999] transition-opacity duration-300 opacity-0">

    <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 max-w-5xl w-[95%] max-h-[90vh] 
                overflow-y-auto border border-gray-200 relative scale-95 transition-all duration-300">


        <!-- Title -->
        <h2 class="text-center text-1xl sm:text-2xl font-extrabold text-gray-800">
            What kind of working environment feels comfortable for you?
        </h2>

        <p class="text-center text-gray-500 italic mt-1">
            (Anong klaseng lugar ng trabaho ang komportable para sa iyo?)
        </p>

        <!-- Yellow Note -->
        <div class="bg-yellow-100 border border-yellow-300 rounded-xl p-4 mt-6 text-center shadow-sm">
            <p class="font-semibold text-yellow-900">You can choose more than one option</p>
            <p class="text-yellow-800 italic text-sm">(Puwede kang pumili ng higit sa isa)</p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 px-2 sm:px-4">

            <!-- Friendly Team -->
            <div class="bg-white p-5 rounded-2xl cursor-pointer workplace-option shadow-md 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative text-center"
                 data-value="Friendly Team">

                <button type="button"
                        class="absolute top-3 right-3 bg-blue-700 hover:bg-blue-900 text-white p-2 
                               rounded-full shadow transition tts-btn"
                        data-tts-en="Friendly Team: You will work with a kind and helpful team."
                        data-tts-tl="Makikipagtrabaho ka sa mabait at matulunging team">🔊</button>

                <img src="image/workplc1.jpg" class="w-full rounded-lg mb-4 shadow-sm"/>
                <h3 class="text-blue-700 font-bold text-lg">Friendly Team</h3>
                <p class="mt-2 text-sm">You will work with a kind and helpful team.</p>
                <p class="mt-1 text-[13px] text-gray-600 italic">(Makikipagtrabaho ka sa mabait at matulunging team)</p>
            </div>

            <!-- Buddy Helper -->
            <div class="bg-white p-5 rounded-2xl cursor-pointer workplace-option shadow-md 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative text-center"
                 data-value="Buddy Helper">

                <button type="button"
                        class="absolute top-3 right-3 bg-blue-700 hover:bg-blue-900 text-white p-2 
                               rounded-full shadow transition tts-btn"
                        data-tts-en="Buddy Helper: You will have a buddy who guides you."
                        data-tts-tl="Magkakaroon ka ng buddy na gagabay at tutulong sa’yo">🔊</button>

                <img src="image/workplc2.jpg" class="w-full rounded-lg mb-4 shadow-sm"/>
                <h3 class="text-blue-700 font-bold text-lg">Buddy Helper</h3>
                <p class="mt-2 text-sm">You will have a buddy who guides and helps you.</p>
                <p class="mt-1 text-[13px] text-gray-600 italic">(Magkakaroon ka ng buddy na gagabay at tutulong sa’yo)</p>
            </div>

            <!-- Simple Instructions -->
            <div class="bg-white p-5 rounded-2xl cursor-pointer workplace-option shadow-md 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative text-center"
                 data-value="Simple Instructions">

                <button type="button"
                        class="absolute top-3 right-3 bg-blue-700 hover:bg-blue-900 text-white p-2 
                               rounded-full shadow transition tts-btn"
                        data-tts-en="Simple Instructions: Easy and clear steps."
                        data-tts-tl="Malinaw at madaling sundin ang instructions.">🔊</button>

                <img src="image/workplc3.jpg" class="w-full rounded-lg mb-4 shadow-sm"/>
                <h3 class="text-blue-700 font-bold text-lg">Simple Instructions</h3>
                <p class="mt-2 text-sm">Easy-to-understand instructions with steps or pictures.</p>
                <p class="mt-1 text-[13px] text-gray-600 italic">(Malinaw at madaling sundan na instructions)</p>
            </div>

            <!-- Safe and Light Work -->
            <div class="bg-white p-5 rounded-2xl cursor-pointer workplace-option shadow-md 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative text-center"
                 data-value="Safe and Light Work">

                <button type="button"
                        class="absolute top-3 right-3 bg-blue-700 hover:bg-blue-900 text-white p-2 
                               rounded-full shadow transition tts-btn"
                        data-tts-en="Safe and Light Work: Tasks are safe and not heavy."
                        data-tts-tl="Ang trabaho ay ligtas at hindi mabigat.">🔊</button>

                <img src="image/workplc4.jpg" class="w-full rounded-lg mb-4 shadow-sm"/>
                <h3 class="text-blue-700 font-bold text-lg">Safe and Light Work</h3>
                <p class="mt-2 text-sm">Your tasks will be safe and not heavy.</p>
                <p class="mt-1 text-[13px] text-gray-600 italic">(Ligtas at hindi mabigat ang gawain)</p>
            </div>

            <!-- No Heavy Lifting -->
            <div class="bg-white p-5 rounded-2xl cursor-pointer workplace-option shadow-md 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative text-center"
                 data-value="No Heavy Lifting / No Pharmacy Tasks">

                <button type="button"
                        class="absolute top-3 right-3 bg-blue-700 hover:bg-blue-900 text-white p-2 
                               rounded-full shadow transition tts-btn"
                        data-tts-en="No heavy lifting or pharmacy tasks."
                        data-tts-tl="Walang mabigat na buhat at pharmacy tasks.">🔊</button>

                <img src="image/workplc5.jpg" class="w-full rounded-lg mb-4 shadow-sm"/>
                <h3 class="text-blue-700 font-bold text-lg">No Heavy Lifting / No Pharmacy Tasks</h3>
                <p class="mt-2 text-sm">No heavy lifting. No pharmacy work.</p>
                <p class="mt-1 text-[13px] text-gray-600 italic">(Walang mabigat na buhat at pharmacy tasks)</p>
            </div>

            <!-- OTHER 
            <div class="bg-white p-5 rounded-2xl cursor-pointer workplace-option shadow-md 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center"
                 data-value="other">

                <h3 class="text-blue-700 font-bold text-lg mb-2">Other</h3>
                <p class="text-sm">Type your answer if not in the choices</p>
                <p class="text-xs italic text-gray-600">(Isulat ang sagot kung wala sa mga pagpipilian)</p>

                <input id="workplace_other_input"
                       type="text"
                       class="mt-3 w-full border border-gray-300 rounded-lg p-2 text-sm"
                       placeholder="Type here...">
            </div>-->
        </div>

        <!-- Buttons -->
        <div class="flex justify-center gap-6 mt-10">
            <button id="closeEnvironmentModal"
                    class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl 
                           hover:bg-red-700 transition shadow-sm">
                Cancel
            </button>

            <button id="saveEnvironmentEdit"
                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl 
                           hover:bg-blue-700 transition shadow-sm">
                Save Changes
            </button>
        </div>

    </div>
</div>


<!-- SELECTED CARD STYLE -->
<style>
.selected-card {
    border: 3px solid #1E40AF !important;
    background-color: #DBEAFE !important;
}
</style>


<!-- Work Environment edit/save script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("editEnvironmentModal");
  const cards = Array.from(document.querySelectorAll(".workplace-option"));
  const hiddenInput = document.getElementById("workplace_page1"); // optional hidden input
  const otherInput = document.getElementById("workplace_other_input");
  const reviewList = document.getElementById("review_workplace_list");
  const editBtns = Array.from(document.querySelectorAll(".edit-btn"));
  const closeBtn = document.getElementById("closeEnvironmentModal");
  const saveBtn = document.getElementById("saveEnvironmentEdit");
  const IMG_CONTAINER_ID = "review_workplace_choice_img_container";
  const LS_KEYS = ['workplace','preferred_workplace','workplace_choice','workplaceChoice','preferred_workplace_choice','workplace_page1','workplace_page'];

  const parseMaybeJson = (v) => {
    if (v === null || v === undefined) return v;
    if (Array.isArray(v) || typeof v === 'object') return v;
    if (typeof v !== 'string') return v;
    const s = v.trim();
    if (!s) return '';
    if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
      try { return JSON.parse(s); } catch(e){}
    }
    return s;
  };

  const normalizeArray = (v) => {
    if (v === null || v === undefined) return [];
    if (Array.isArray(v)) return v.map(x => typeof x === 'string' ? x.trim() : String(x||'')).filter(Boolean);
    if (typeof v === 'object') {
      try { return Object.values(v).map(x => String(x||'').trim()).filter(Boolean); } catch(e){ return []; }
    }
    if (typeof v === 'string') {
      const s = v.trim();
      if (!s) return [];
      if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
        try { return normalizeArray(JSON.parse(s)); } catch(e){}
      }
      if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
      return [s];
    }
    return [];
  };

  function getSavedWorkplace() {
    try {
      if (hiddenInput && hiddenInput.value) {
        const parsed = parseMaybeJson(hiddenInput.value);
        const norm = normalizeArray(parsed);
        if (norm.length) return norm;
      }
      for (const k of LS_KEYS) {
        try {
          const raw = localStorage.getItem(k);
          if (!raw) continue;
          const parsed = parseMaybeJson(raw);
          const norm = normalizeArray(parsed);
          if (norm.length) return norm;
        } catch(e){}
      }
      try {
        const rpRaw = localStorage.getItem('rpi_personal') || localStorage.getItem('rpi_personal2');
        if (rpRaw) {
          const rp = parseMaybeJson(rpRaw) || rpRaw;
          if (rp && typeof rp === 'object') {
            const candidates = [];
            if (rp.workplace) candidates.push(rp.workplace);
            if (rp.workplace_choice) candidates.push(rp.workplace_choice);
            if (rp.preferred_workplace) candidates.push(rp.preferred_workplace);
            for (const c of candidates) {
              const norm = normalizeArray(c);
              if (norm.length) return norm;
            }
          }
        }
      } catch(e){}
      try {
        const d = window.__mvsg_lastLoadedDraft || window.registrationDraft || window.__REGISTRATION_DRAFT__;
        if (d && typeof d === 'object') {
          const candidates = [];
          if (d.workplace) candidates.push(d.workplace);
          if (d.workplace_choice) candidates.push(d.workplace_choice);
          if (d.preferred_workplace) candidates.push(d.preferred_workplace);
          for (const c of candidates) {
            const norm = normalizeArray(c);
            if (norm.length) return norm;
          }
        }
      } catch(e){}
    } catch(e) { console.debug("getSavedWorkplace error", e); }
    return [];
  }

  function resetSelections() {
    cards.forEach(card => {
      card.classList.remove("selected-card","selected");
      card.setAttribute('aria-pressed','false');
      card.tabIndex = 0;
    });
    if (otherInput) otherInput.value = "";
  }

  // robust normalizer for matching text
  function normalizeForCompare(s){
    if (s === null || s === undefined) return '';
    try {
      return String(s)
        .replace(/\u2013|\u2014/g, '-')          // normalize dashes
        .replace(/[^\w\s\/&-]/g, '')            // remove punctuation except slash & ampersand and dash
        .replace(/\s+/g, ' ')
        .trim()
        .toLowerCase();
    } catch(e){
      return String(s||'').toLowerCase().trim();
    }
  }

  // mark cards if they match review pills or storage values
  function markCardsSelectedIfMatch(){
    try {
      // collect canonical values from reviewList if present, else from storage/draft
      let pills = [];
      if (reviewList) {
        pills = Array.from(reviewList.querySelectorAll('span'))
                     .map(s => (s.textContent||'').trim())
                     .filter(Boolean)
                     .filter(t => t !== '—');
      }
      if (!pills.length) {
        const stored = getSavedWorkplace();
        if (stored && stored.length) pills = stored;
      }
      // normalize and dedupe
      const normalizedPills = [...new Set(pills.map(p => normalizeForCompare(p)).filter(Boolean))];

      // clear all first
      cards.forEach(c => c.classList.remove('selected-card','selected'));

      if (!normalizedPills.length) {
        if (otherInput) otherInput.value = '';
        return;
      }

      // attempt exact normalized match, then loose match (token overlap)
      cards.forEach(card => {
        const dv = normalizeForCompare(card.dataset.value || '');
        const title = normalizeForCompare(card.querySelector('h3')?.textContent || '');
        let matched = false;
        for (const pill of normalizedPills) {
          if (pill === dv || pill === title) { matched = true; break; }
        }
        if (!matched) {
          for (const pill of normalizedPills) {
            // loose match: token intersection threshold
            const pillParts = pill.split(/[\/&\-\s]+/).filter(Boolean);
            const target = (dv || title);
            const hits = pillParts.reduce((acc, t) => acc + (target.includes(t) ? 1 : 0), 0);
            if (hits >= Math.max(1, Math.floor(pillParts.length / 2))) { matched = true; break; }
          }
        }
        if (matched) card.classList.add('selected-card','selected');
      });

      // populate otherInput with unmatched original pill texts (not normalized)
      if (otherInput) {
        const unmatched = pills.filter(p => {
          const pn = normalizeForCompare(p);
          return !cards.some(c => {
            const dv = normalizeForCompare(c.dataset.value || '');
            const title = normalizeForCompare(c.querySelector('h3')?.textContent || '');
            return pn === dv || pn === title;
          });
        });
        otherInput.value = unmatched.join(', ');
      }
    } catch(e) { console.debug('markCardsSelectedIfMatch error', e); }
  }

  function loadPreviousSelections() {
    resetSelections();
    const saved = getSavedWorkplace();
    if (!saved || !saved.length) return;
    const normSet = new Set(saved.map(s => normalizeForCompare(String(s||''))));
    cards.forEach(card => {
      const value = normalizeForCompare((card.dataset.value || '').trim());
      const title = normalizeForCompare((card.querySelector('h3')?.textContent || '').trim());
      if ((value && normSet.has(value)) || (title && normSet.has(title))) {
        card.classList.add("selected-card","selected");
        card.setAttribute('aria-pressed','true');
      }
    });

    // unmatched -> other input (use original saved values)
    const unmatched = saved.filter(s => {
      const low = normalizeForCompare(String(s||'').trim());
      return !cards.some(c => {
        const dv = normalizeForCompare((c.dataset.value||'').trim());
        const t = normalizeForCompare((c.querySelector('h3')?.textContent||'').trim());
        return dv === low || t === low;
      });
    });
    if (unmatched.length && otherInput) otherInput.value = unmatched.join(', ');
  }

  function updateReviewSection(selected) {
    if (!reviewList) return;
    reviewList.innerHTML = "";
    if (!selected || !selected.length) {
      reviewList.innerHTML = `<span class="text-gray-600">—</span>`;
      // ensure cards cleared
      markCardsSelectedIfMatch();
      return;
    }
    selected.forEach(item => {
      const span = document.createElement('span');
      span.className = 'bg-blue-50 text-blue-800 px-3 py-1 rounded-md text-sm font-medium';
      span.textContent = item;
      reviewList.appendChild(span);
    });
    // after rendering pills, mark cards
    setTimeout(markCardsSelectedIfMatch, 8);
  }

  // wire card click toggles (ignore tts buttons)
  cards.forEach(card => {
    card.setAttribute('role','button');
    card.tabIndex = 0;
    card.setAttribute('aria-pressed', card.classList.contains('selected-card') ? 'true' : 'false');

    card.addEventListener('click', (e) => {
      if (e.target && e.target.classList && e.target.classList.contains('tts-btn')) return;
      card.classList.toggle('selected-card');
      card.classList.toggle('selected');
      const pressed = card.classList.contains('selected-card');
      card.setAttribute('aria-pressed', pressed ? 'true' : 'false');
    });

    card.addEventListener('keydown', (ev) => {
      if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); card.click(); }
    });
  });

  // open modal and preselect
  editBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if ((btn.dataset.section || '').trim() !== 'environment') return;
      if (!modal) return;
      modal.classList.remove('hidden');
      setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.querySelector('.rounded-3xl, div')?.classList.remove('scale-95');
      }, 10);
      loadPreviousSelections();
      const focusTarget = modal.querySelector('input, button, textarea, [role="button"]');
      if (focusTarget) focusTarget.focus();
    });
  });

  // close modal
  function closeModal() {
    if (!modal) return;
    modal.classList.add('opacity-0');
    modal.querySelector('.rounded-3xl, div')?.classList.add('scale-95');
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 220);
  }
  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (modal) {
    modal.addEventListener('click', (ev) => { if (ev.target === modal) closeModal(); });
    document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeModal(); });
  }

  // save button inside modal
  if (saveBtn) {
    saveBtn.addEventListener('click', () => {
      const selected = [];
      cards.forEach(card => {
        if (card.classList.contains('selected-card') || card.classList.contains('selected')) {
          const v = (card.dataset.value || '').trim();
          if (v === 'other') {
            const oth = (otherInput && otherInput.value || '').trim();
            if (oth) selected.push(...oth.split(',').map(s=>s.trim()).filter(Boolean));
          } else if (v) selected.push(v);
        }
      });

      if (hiddenInput) hiddenInput.value = JSON.stringify(selected);
      updateReviewSection(selected);

      // hide image preview container if present
      const imgContainer = document.getElementById(IMG_CONTAINER_ID);
      if (imgContainer) imgContainer.classList.add('hidden');

      // persist canonical keys
      try {
        const arr = selected.length ? JSON.stringify(selected) : '';
        if (arr) {
          localStorage.setItem('workplace', arr);
          localStorage.setItem('preferred_workplace', arr);
          localStorage.setItem('workplace_choice', arr);
        } else {
          LS_KEYS.forEach(k => { try { localStorage.removeItem(k); } catch(e){} });
        }
      } catch(e){ console.debug('persist workplace failed', e); }

      try { window.dispatchEvent(new CustomEvent('mvsg:workplaceChanged', { detail: { values: selected } })); } catch(e){}

      // ensure cards reflect saved pills
      setTimeout(markCardsSelectedIfMatch, 20);

      closeModal();
    });
  }

  // Initial populate of review area and ensure matching cards are marked
  (function initialPopulate() {
    let saved = getSavedWorkplace();
    if (!saved || !saved.length) {
      try {
        if (hiddenInput && hiddenInput.value) saved = normalizeArray(parseMaybeJson(hiddenInput.value));
      } catch(e){}
    }
    const uniq = [...new Set((saved||[]).map(x => String(x||'').trim()).filter(Boolean))];
    updateReviewSection(uniq);
    setTimeout(markCardsSelectedIfMatch, 10);
  })();

  // observe review list changes and storage to re-run matching
  try {
    if (reviewList) {
      const obs = new MutationObserver(() => setTimeout(markCardsSelectedIfMatch, 10));
      obs.observe(reviewList, { childList: true, subtree: true, characterData: true });
    }
  } catch(e){}

  window.addEventListener('storage', (ev) => {
    const keys = ['workplace','preferred_workplace','workplace_choice','workplaceChoice','preferred_workplace_choice','rpi_personal2','registrationDraft'];
    if(!ev.key || keys.includes(ev.key)) setTimeout(() => {
      // refresh review UI from storage and re-mark
      try {
        let fromStore = getSavedWorkplace();
        if (!fromStore || !fromStore.length) {
          if (hiddenInput && hiddenInput.value) fromStore = normalizeArray(parseMaybeJson(hiddenInput.value));
        }
        const uniq = [...new Set((fromStore||[]).map(x => String(x||'').trim()).filter(Boolean))];
        updateReviewSection(uniq);
        setTimeout(markCardsSelectedIfMatch, 8);
      } catch(e){ console.debug('storage handler failed', e); }
    }, 30);
  });

});
</script>



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

                    // Update hidden input (for draft restore and scripts) and visible display
                    const certInput = document.getElementById("review_certs");
                    const certDisplay = document.getElementById("review_certs_display");
                    if (certInput) {
                        try { certInput.value = savedCert || ''; } catch(e){}
                    }
                    if (certDisplay) {
                        certDisplay.textContent = savedCert ? String(savedCert) : '';
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
                // document.addEventListener('DOMContentLoaded', function(){
                //     try {
                //         const routeMap = {
                //             'education': '{{ route('registereducation') }}',
                //             'work': '{{ route('registerworkexpinfo') }}',
                //             'environment': '{{ route('registerworkplace') }}'
                //         };
                //         document.querySelectorAll('.edit-btn').forEach(btn => {
                //             try {
                //                 const sec = (btn.getAttribute('data-section') || '').trim();
                //                 const target = routeMap[sec];
                //                 if (!target) return;
                //                 btn.addEventListener('click', function(ev){ ev.preventDefault(); saveDraftAndGoto(target); });
                //             } catch(e) { /* ignore per-button errors */ }
                //         });
                //     } catch (e) { console.warn('[review-2] wiring edit buttons failed', e); }
                // });
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

                        const workplace = (data.workplace && (data.workplace.workplace_choices || data.workplace
                            .workplaceChoice)) || data.workplace_choices || '';
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
                (function(){
                    // Render certificate entries saved by ds_register_education.blade.php
                    const CERT_KEYS = ['education_certificates','education_profile','education_profile.certificates','education_certificates_array'];

                    function parseMaybe(v){
                        if (!v) return null;
                        try { return typeof v === 'string' ? JSON.parse(v) : v; } catch(e) { return v; }
                    }

                    function readCertificates() {
                                        // Read metadata arrays (canonical) AND also include any file-only uploads.
                                        var result = [];
                                        // 1) direct canonical key (education_certificates)
                                        try {
                                            const raw = localStorage.getItem('education_certificates');
                                            if (raw) {
                                                const parsed = parseMaybe(raw);
                                                if (Array.isArray(parsed)) result = parsed.slice();
                                            }
                                        } catch(e){}

                                        // 2) education_profile with nested certificates (prefer these if present)
                                        try {
                                            const epRaw = localStorage.getItem('education_profile') || localStorage.getItem('education_profile_json');
                                            if (epRaw) {
                                                const ep = parseMaybe(epRaw);
                                                if (ep && Array.isArray(ep.certificates)) result = ep.certificates.slice();
                                                else if (ep && Array.isArray(ep.education_certificates)) result = ep.education_certificates.slice();
                                            }
                                        } catch(e){}

                                        // 3) other possible keys (if nothing found yet)
                                        if (!result.length) {
                                            for (const k of ['educationCertificates','certificates','education_certificates_array']) {
                                                try {
                                                    const r = localStorage.getItem(k);
                                                    const p = parseMaybe(r);
                                                    if (Array.isArray(p)) { result = p.slice(); break; }
                                                } catch(e){}
                                            }
                                        }

                                        // 4) also include any uploaded certificate files saved by the education uploader
                                        try {
                                            const filesRaw = localStorage.getItem('uploadedCertificates_education') || localStorage.getItem('uploadedProofs_proof') || localStorage.getItem('uploadedProofs1') || localStorage.getItem('uploadedProofs') || null;
                                            const files = filesRaw ? parseMaybe(filesRaw) : null;
                                            if (Array.isArray(files) && files.length) {
                                                const mapped = files.map(f => ({ certificate_name: f.name || f.filename || '', issued_by: '', date_completed: '', training_description: '', __file_only: true }));
                                                const seen = new Set((result || []).map(r => String(r.certificate_name || r.name || '').toLowerCase()));
                                                for (const m of mapped) {
                                                    const n = String(m.certificate_name || '').toLowerCase();
                                                    if (!n) continue;
                                                    if (!seen.has(n)) { result.push(m); seen.add(n); }
                                                }
                                            }
                                        } catch(e){}

                                        // 5) broad scan: if still empty, scan localStorage keys for arrays/objects that look like uploaded files
                                        try {
                                            if (!result.length && typeof localStorage === 'object') {
                                                const candidates = [];
                                                for (let i=0;i<localStorage.length;i++) {
                                                    const k = localStorage.key(i) || '';
                                                    if (!/upload|proof|cert|certificate|uploaded/i.test(k)) continue;
                                                    try {
                                                        const v = parseMaybe(localStorage.getItem(k));
                                                        if (Array.isArray(v)) {
                                                            // check if array of objects with name/data
                                                            if (v.length && v.some(it => it && (it.name || it.filename || it.data || it.url))) candidates.push({key:k,arr:v});
                                                        } else if (v && (v.name || v.filename || v.data || v.url)) {
                                                            candidates.push({key:k,arr:[v]});
                                                        }
                                                    } catch(e){}
                                                }
                                                if (candidates.length) {
                                                    // merge first candidate arrays
                                                    const mapped = [];
                                                    for (const c of candidates) {
                                                        for (const f of (c.arr||[])) {
                                                            if (!f) continue;
                                                            mapped.push({ certificate_name: f.name || f.filename || '', issued_by: '', date_completed: '', training_description: '', __file_only: true, __source: c.key });
                                                        }
                                                    }
                                                    const seen = new Set((result || []).map(r => String(r.certificate_name || r.name || '').toLowerCase()));
                                                    for (const m of mapped) {
                                                        const n = String(m.certificate_name || '').toLowerCase();
                                                        if (!n) continue;
                                                        if (!seen.has(n)) { result.push(m); seen.add(n); }
                                                    }
                                                }
                                            }
                                        } catch(e){}

                                        return result || [];
                    }

                    function fmtDate(d) {
                        if (!d) return '';
                        // accept ISO or yyyy-mm-dd
                        try {
                            const dt = new Date(d);
                            if (!isNaN(dt.getTime())) return dt.toLocaleDateString(undefined, { year:'numeric', month:'long', day:'numeric' });
                        } catch(e){}
                        return String(d);
                    }

                    function makeCard(c) {
                        const name = c.certificate_name || c.name || c.title || '';
                        const issuer = c.issued_by || c.issuer || c.issuedBy || '';
                        const date = fmtDate(c.date_completed || c.date || c.completed || '');
                        const desc = c.training_description || c.description || c.what_you_learned || '';
                        const html = document.createElement('div');
                        html.className = 'bg-white border border-gray-200 rounded-lg p-4 shadow-sm';
                        html.innerHTML = `
                            <h4 class="text-blue-700 font-semibold mb-1">${escapeHtml(name || '—')}</h4>
                            <div class="text-sm text-gray-700 mb-1">
                                ${issuer ? `<strong>Issued by:</strong> ${escapeHtml(issuer)}` : ''}
                            </div>
                            ${date ? `<div class="text-sm text-gray-700 mb-2"><strong>Date:</strong> ${escapeHtml(date)}</div>` : ''}
                            ${desc ? `<div class="text-gray-800 text-sm">${escapeHtml(desc)}</div>` : ''}
                        `;
                        return html;
                    }

                    function escapeHtml(s){ if (s===null||s===undefined) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

                    function render() {
                        const listEl = document.getElementById('certsList');
                        const noneEl = document.getElementById('noCertsMsg');
                        if (!listEl || !noneEl) return;
                        listEl.innerHTML = '';
                        const arr = readCertificates() || [];
                        if (!arr.length) {
                            noneEl.style.display = 'block';
                            // show diagnostic candidates when no certificates found
                            try { showCertDebug && showCertDebug(); } catch(e){}
                            return;
                        }
                        noneEl.style.display = 'none';
                        arr.forEach(it => {
                            listEl.appendChild(makeCard(it));
                        });
                    }

                    // Diagnostic: scan localStorage for candidate keys and render a small debug block
                    function showCertDebug() {
                        // Debugging disabled in production UI — no-op
                        return;
                        try {
                            const reviewContainer = document.getElementById('certificateReview');
                            if (!reviewContainer) return;
                            // avoid adding multiple debug blocks
                            let dbg = document.getElementById('certsDebugPanel');
                            if (dbg) dbg.remove();
                            const panel = document.createElement('div');
                            panel.id = 'certsDebugPanel';
                            panel.className = 'mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded';
                            panel.style.fontSize = '13px';
                            const header = document.createElement('div');
                            header.className = 'font-semibold text-yellow-800 mb-2';
                            header.textContent = 'Debug: no certificates found — scanning localStorage for candidates';
                            panel.appendChild(header);
                            const list = document.createElement('div');
                            const candidates = [];
                            for (let i=0;i<localStorage.length;i++) {
                                const k = localStorage.key(i) || '';
                                if (!/upload|proof|cert|certificate|resume|file|uploaded/i.test(k)) continue;
                                try {
                                    const raw = localStorage.getItem(k);
                                    const preview = String(raw||'').slice(0,200).replace(/\n/g,' ');
                                    candidates.push({ key: k, preview });
                                } catch(e){}
                            }
                            if (!candidates.length) {
                                const none = document.createElement('div');
                                none.className = 'text-gray-600 italic';
                                none.textContent = 'No likely upload-related localStorage keys found.';
                                panel.appendChild(none);
                                reviewContainer.appendChild(panel);
                                return;
                            }
                            candidates.forEach(c => {
                                const row = document.createElement('div');
                                row.className = 'mb-2';
                                row.innerHTML = `<div class="font-medium">Key: <code style="background:#fff;padding:2px 4px;border-radius:4px">${c.key}</code></div><div class="text-xs text-gray-700 mt-1">${escapeHtml(c.preview)}${c.preview.length>=200? '…':''}</div>`;
                                list.appendChild(row);
                            });
                            panel.appendChild(list);
                            const info = document.createElement('div');
                            info.className = 'mt-2 text-xs text-gray-700';
                            info.textContent = 'If you see a key that contains your uploaded filename or data URL, please paste that key and a short value into the chat.';
                            panel.appendChild(info);
                            reviewContainer.appendChild(panel);
                        } catch(e){ console.debug('showCertDebug error', e); }
                    }

                    // Expose the debug scanner so external controls (buttons) can invoke it
                    try { window.__mvsg_showCertDebug = showCertDebug; } catch(e){}

                    document.addEventListener('DOMContentLoaded', function(){
                        render();
                        // wire edit button to go back to education page (saveDraftAndGoto will persist draft)
                        // Only attach navigation handler when inline edit UI is NOT present.
                        const editBtn = document.getElementById('editSchoolBtn');
                        const inlinePanel = document.getElementById('certsEdit');
                        if (editBtn && !inlinePanel) {
                            editBtn.addEventListener('click', function(){
                                try { saveDraftAndGoto('{{ route('registereducation') }}'); }
                                catch(e){ window.location.href='{{ route('registereducation') }}'; }
                            });
                        }
                    });

                    window.addEventListener('storage', function(e){
                        const watch = ['education_certificates','education_profile','education_profile_json','review_certs','certificates'];
                        if (!e.key || watch.includes(e.key)) setTimeout(render, 40);
                    });
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
                        const draft = saved ? JSON.parse(saved) : {};
                        // use the exact IDs/keys written by the Education page
                        const fieldIds = ["educationLevel", "schoolName","review_certs"];

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
/*
  Replace legacy single-file getters with a robust reader that:
  - prefers admin_uploaded_* keys
  - falls back to uploadedProofs1 (array)
  - then falls back to uploadedProofData1 / uploadedProofData etc.
  This also updates renderPreviewBlock to display stacked files when uploadedProofs1 is used.
*/
(function(){
    // helper: read first non-empty localStorage key
    function readFirst(keys){
        for(const k of keys){
            try {
                const v = localStorage.getItem(k);
                if (v !== null && v !== undefined && String(v).trim() !== '') return v;
            } catch(e){}
        }
        return null;
    }

    // unified loader: returns { list: [{name,type,data}], hasCertFlag }
    function loadSavedCerts() {
        // 1) array-style storage used by Education page (canonical for review-2)
        try {
            // Prefer canonical education key(s): include uploadedCertificates_education and education_certificates
            // try canonical keys first, remember which key provided data so removals can write back
            const tryKeys = [
                'uploadedCertificates_education',
                'education_certificates',
                // session / global fallback
                'uploadedCertificates_education_session',
                // legacy arrays
                'uploadedProofs1',
                'uploadedProofs',
                'uploadedProofs_proof'
            ];
            let arrRaw = null;
            let sourceKey = null;
            for (const k of tryKeys) {
                try {
                    const v = (k === 'uploadedCertificates_education_session') ? sessionStorage.getItem('uploadedCertificates_education') : localStorage.getItem(k);
                    if (v !== null && v !== undefined && String(v).trim() !== '') { arrRaw = v; sourceKey = k; break; }
                } catch(e){}
            }
            if (!arrRaw) { arrRaw = '[]'; sourceKey = null; }
            let arr = [];
            try {
                try { console.debug('[review-2] loadSavedCerts arrRaw preview:', String(arrRaw||'').slice(0,200)); } catch(e){}
                if (!arrRaw) arr = [];
                else if (typeof arrRaw === 'object') arr = arrRaw;
                else {
                    try { arr = JSON.parse(arrRaw || '[]'); }
                    catch (e) {
                        // last-resort: attempt to evaluate loose JS object arrays (non-standard JSON)
                        try { arr = (new Function('return ' + String(arrRaw)))() || []; } catch (e2) { arr = []; }
                    }
                }
                try { console.debug('[review-2] parsed uploadedCertificates_education length:', Array.isArray(arr)?arr.length:null); } catch(e){}
            } catch(e){ arr = []; }
            if (Array.isArray(arr) && arr.length) {
                const normalized = arr.map((it, _idx) => {
                    const idx = _idx || 0;
                    if (!it) return null;
                    if (typeof it === 'string') return { name: it, type: (it.split('.').pop()||'').toLowerCase(), data: null, sourceKey, originalIndex: idx };
                    // accept many possible key names used across pages:
                    const name = it.name || it.filename || it.certificate_file_name || it.certificate_name || it.fileName || it.name_raw || '';
                    const data = it.data || it.url || it.certificate_file_data || it.fileData || it.dataUrl || null;
                    const type = (it.type || it.certificate_file_type || (name||'').split('.').pop() || '').toLowerCase();
                    return { name: name || '', type: (type||'').toLowerCase(), data, sourceKey, originalIndex: idx };
                }).filter(Boolean);
                if (normalized.length) return { list: normalized, hasCertFlag: localStorage.getItem('review_certs') || null, sourceKey };
            }
        } catch(e){ /* ignore parse errors */ }

        // 2) legacy single-file keys used by Education page (explicit education keys)
            const data = readFirst(['uploadedProofData1','uploadedProofData','uploadedProofData0','uploaded_proof_data','proofData']);
            const type = readFirst(['uploadedProofType1','uploadedProofType','uploadedProofType0','uploaded_proof_type','proofType']);
            const name = readFirst(['uploadedProofName1','uploadedProofName','uploadedProofName0','uploaded_proof_name','proofName']);
        if (data && name) {
            // single-file legacy keys — indicate special sourceKey 'single-legacy' so remove can clean legacy keys
            return { list: [{ name, type: (type||name.split('.').pop()).toLowerCase(), data }], hasCertFlag: localStorage.getItem('review_certs') || null, sourceKey: 'single-legacy' };
        }

        // IMPORTANT: do NOT read admin_uploaded_* here — admin files belong to review-1 only

        // nothing found
        return { list: [], hasCertFlag: localStorage.getItem('review_certs') || null };
    }

    // render one stacked card (used for list)
    function makeFileCard(item, idx) {
        const ext = (item.type || (item.name||'').split('.').pop()||'').toLowerCase();
        const icon = ext === 'pdf' ? '📄' : (['jpg','jpeg','png'].includes(ext) ? '🖼️' : '📁');
        const nameSafe = String(item.name || '').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        return `
            <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mb-3" data-idx="${idx}">
                <span class="text-2xl">${icon}</span>
                <span class="text-sm text-gray-700 truncate max-w-[420px]">${nameSafe}</span>
                <div class="ml-auto flex gap-2">
                    <button type="button" data-idx="${idx}" data-action="view" class="bg-[#2E2EFF] text-white text-xs px-3 py-1 rounded-md">View</button>
                    <button type="button" data-idx="${idx}" data-action="replace" class="bg-[#0ea5a0] text-white text-xs px-3 py-1 rounded-md">Replace</button>
                    <button type="button" data-idx="${idx}" data-action="remove" class="bg-[#D20103] text-white text-xs px-3 py-1 rounded-md">Remove</button>
                </div>
            </div>
            `;
    }

    // replace the previous renderPreviewBlock with one that uses loadSavedCerts()
    function renderPreviewBlock() {
        // Important: only update the inner read-only list (do NOT replace the whole certificateReview container)
        const reviewContainer = document.getElementById('certificateReview');
        if (!reviewContainer) return;
        const listEl = document.getElementById('certsList');
        const noEl = document.getElementById('noCertsMsg');
        // Debug: snapshot relevant storage keys to aid troubleshooting when files don't appear
        try {
            console.debug('[review-2] storage keys snapshot', {
                uploadedCertificates_education: localStorage.getItem('uploadedCertificates_education'),
                uploadedProofs_proof: localStorage.getItem('uploadedProofs_proof'),
                uploadedProofs1: localStorage.getItem('uploadedProofs1'),
                uploadedProofs: localStorage.getItem('uploadedProofs'),
                review_certs: localStorage.getItem('review_certs')
            });
        } catch (e) { /* ignore console errors */ }

        const saved = loadSavedCerts();
        try { console.debug('[review-2] loadSavedCerts result', saved); } catch(e){}

        // explicit "no"
        if (saved.hasCertFlag && String(saved.hasCertFlag).toLowerCase() === 'no') {
            if (listEl) listEl.innerHTML = '';
            if (noEl) { noEl.style.display = 'block'; noEl.textContent = 'No certificates or trainings added.'; }
            return;
        }

            // If there are no uploaded files but certificate text entries exist, render text-only entries
            try {
                // read certificate text entries from multiple possible keys (education writes to education_certificates)
                function readCertTextArray() {
                    try {
                        const tryKeys = ['certificates','education_certificates'];
                        for (const k of tryKeys) {
                            const v = localStorage.getItem(k);
                            if (v) {
                                try { const p = JSON.parse(v); if (Array.isArray(p)) return p; } catch(e) {}
                            }
                        }
                        const ep = localStorage.getItem('education_profile');
                        if (ep) {
                            try { const parsed = JSON.parse(ep); if (parsed && Array.isArray(parsed.certificates)) return parsed.certificates; } catch(e) {}
                        }
                    } catch(e){}
                    return null;
                }
                const certsFallbackArr = readCertTextArray();
                if ((!Array.isArray(saved.list) || saved.list.length === 0) && Array.isArray(certsFallbackArr) && certsFallbackArr.length) {
                    if (noEl) noEl.style.display = 'none';
                    listEl.innerHTML = '';
                    const esc = s => (s===null||s===undefined)?'':String(s).replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    const fmt = function(raw){ try { const d=new Date(String(raw)); if (!isNaN(d.getTime())) return d.toLocaleDateString(undefined,{year:'numeric',month:'long',day:'numeric'}); } catch(e){} return String(raw||''); };
                    certsFallbackArr.forEach((cert, idx) => {
                        const card = document.createElement('div');
                        card.className = 'flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mb-3';
                        card.setAttribute('data-idx', idx);
                        card.innerHTML = `<span class="text-2xl">📁</span><div class="flex-1"></div>`;
                        const details = document.createElement('div');
                        details.className = 'cert-details';
                        const cname = cert.certificate_name || cert.certificateName || cert.name || '';
                        const issuer = cert.issued_by || cert.issuedBy || cert.issuer || '';
                        const date = cert.date_completed || cert.dateCompleted || cert.completed || '';
                        const desc = cert.training_description || cert.trainingDescription || '';
                        details.innerHTML = `
                            <div class="title">${esc(cname) || '<span class="text-gray-400">(no name)</span>'}</div>
                            <div class="meta">${issuer ? '<strong>Issued By:</strong> ' + esc(issuer) : ''}</div>
                            <div class="meta mt-1">${date ? '<strong>Date Completed:</strong> ' + esc(fmt(date)) : ''}</div>
                            ${desc ? '<div class="meta mt-2"> <strong>What I learned:</strong> ' + esc(desc) + '</div>' : ''}
                        `;
                        card.appendChild(details);
                        listEl.appendChild(card);
                    });
                    return;
                }
            } catch(e) { console.debug('render text-only certs fallback failed', e); }

        // render stacked list into certsList (preserve certsEdit and other controls)
        if (Array.isArray(saved.list) && saved.list.length) {
            if (noEl) noEl.style.display = 'none';
            const wrapper = document.createElement('div');
            wrapper.innerHTML = saved.list.map((it, idx) => makeFileCard(it, idx)).join('');
            if (listEl) {
                listEl.innerHTML = '';
                // move children from wrapper into listEl (keeps event observers scoped)
                Array.from(wrapper.children).forEach(ch => listEl.appendChild(ch));

                // Also render any certificate text-only entries (those saved in 'certificates' but without an uploaded file)
                try {
                    const certsArr = (function(){
                        try {
                            const tryKeys = ['certificates','education_certificates'];
                            for (const k of tryKeys) {
                                const v = localStorage.getItem(k);
                                if (v) { try { const p = JSON.parse(v); if (Array.isArray(p)) return p; } catch(e) {} }
                            }
                            const ep = localStorage.getItem('education_profile');
                            if (ep) { try { const parsed = JSON.parse(ep); if (parsed && Array.isArray(parsed.certificates)) return parsed.certificates; } catch(e) {} }
                        } catch(e){}
                        return null;
                    })();
                    // helper escaper/formatter
                    const esc = s => (s===null||s===undefined)?'':String(s).replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    const fmt = function(raw){ try { const d=new Date(String(raw)); if (!isNaN(d.getTime())) return d.toLocaleDateString(undefined,{year:'numeric',month:'long',day:'numeric'}); } catch(e){} return String(raw||''); };
                    if (Array.isArray(certsArr) && certsArr.length) {
                        // if there are more text entries than files, append text-only cards
                        if (certsArr.length > saved.list.length) {
                            for (let i = saved.list.length; i < certsArr.length; i++) {
                                const noFileCard = document.createElement('div');
                                noFileCard.className = 'flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mb-3';
                                noFileCard.setAttribute('data-idx', i);
                                noFileCard.innerHTML = `<span class="text-2xl">📁</span><span class="text-sm text-gray-700">No uploaded file</span><div class="ml-auto flex gap-2"></div>`;
                                listEl.appendChild(noFileCard);
                            }
                        }

                        // attach details to all cards (file-backed or text-only) by index
                        Array.from(listEl.children).forEach((card, idx) => {
                            const cert = certsArr[idx] || null;
                            if (!cert) return;
                            const cname = cert.certificate_name || cert.certificateName || cert.name || '';
                            const issuer = cert.issued_by || cert.issuedBy || cert.issuer || '';
                            const date = cert.date_completed || cert.dateCompleted || cert.completed || '';
                            const desc = cert.training_description || cert.trainingDescription || cert.training_description || '';
                            const details = document.createElement('div');
                            details.className = 'cert-details';
                            details.innerHTML = `
                                <div class="font-semibold text-gray-800">${esc(cname) || '<span class="text-gray-400">(no name)</span>'}</div>
                                <div class="text-sm text-gray-600">${issuer ? '<strong>Issued By:</strong> ' + esc(issuer) : ''}</div>
                                <div class="text-sm text-gray-600 mt-1">${date ? '<strong>Date Completed:</strong> ' + esc(fmt(date)) : ''}</div>
                                ${desc ? '<div class="text-sm text-gray-700 mt-2"><strong>What I learned:</strong> ' + esc(desc) + '</div>' : ''}
                            `;
                            card.appendChild(details);
                        });
                    }
                } catch(e){ console.debug('attach cert text failed', e); }

                // bind view/remove on the newly-inserted nodes
                listEl.querySelectorAll('[data-action="view"]').forEach(btn => {
                    btn.addEventListener('click', (ev) => {
                        const idx = Number(ev.currentTarget.dataset.idx);
                        const it = saved.list[idx];
                        if (!it) return alert('No preview available.');
                        openPreviewModal(it.name, it.data || it.url || '', it.type || (it.name||'').split('.').pop());
                    });
                });
                listEl.querySelectorAll('[data-action="remove"]').forEach(btn => {
                    btn.addEventListener('click', (ev) => {
                        const idx = Number(ev.currentTarget.dataset.idx);
                        try {
                            const item = saved.list && saved.list[idx];
                            if (!item) return;
                            const skey = item.sourceKey || null;
                            if (skey && skey !== 'single-legacy') {
                                try {
                                    const arr = JSON.parse(localStorage.getItem(skey) || '[]') || [];
                                    if (Array.isArray(arr)) {
                                        if (typeof item.originalIndex === 'number' && arr.length > item.originalIndex) {
                                            arr.splice(item.originalIndex, 1);
                                        } else {
                                            const findIdx = arr.findIndex(a => (a && (a.name || a.fileName || a.filename)) === item.name);
                                            if (findIdx !== -1) arr.splice(findIdx, 1);
                                        }
                                        localStorage.setItem(skey, JSON.stringify(arr));
                                    }
                                } catch(e){}
                            } else {
                                // legacy single-file keys cleanup (same behavior as review-1)
                                const fname = item.name;
                                if (fname) {
                                    ['uploadedProofName','uploadedProofData','uploadedProofType',
                                    'uploadedProofName1','uploadedProofData1','uploadedProofType1',
                                    'uploadedProofName0','uploadedProofData0','uploadedProofType0','uploaded_proof_name','uploaded_proof_data','uploaded_proof_type','proofName','proofData'].forEach(k=>{
                                        try { const v = localStorage.getItem(k); if (v && String(v).includes(fname)) localStorage.removeItem(k); } catch(e){}
                                    });
                                }
                            }
                        } catch(e){}
                        setTimeout(renderPreviewBlock, 30);
                    });
                });
                // wire replace handlers
                listEl.querySelectorAll('[data-action="replace"]').forEach(btn => {
                    btn.addEventListener('click', (ev) => {
                        const idx = Number(ev.currentTarget.dataset.idx);
                        const it = saved.list && saved.list[idx];
                        // create an ephemeral file input to pick replacement
                        const picker = document.createElement('input');
                        picker.type = 'file';
                        picker.accept = '.jpg,.jpeg,.png,.pdf';
                        picker.style.display = 'none';
                        document.body.appendChild(picker);
                        picker.addEventListener('change', function() {
                            const f = this.files && this.files[0];
                            if (!f) { picker.remove(); return; }
                            const reader = new FileReader();
                            reader.onload = function(e){
                                try {
                                    const dataUrl = e.target.result;
                                    const name = f.name || '';
                                    const type = (name.split('.').pop()||'').toLowerCase();
                                    // prefer to persist replacement to the originating storage key for this item
                                    try {
                                        if (it && it.sourceKey && it.sourceKey !== 'single-legacy') {
                                            const diskArr = JSON.parse(localStorage.getItem(it.sourceKey) || '[]') || [];
                                            if (Array.isArray(diskArr)) {
                                                if (typeof it.originalIndex === 'number' && diskArr.length > it.originalIndex) {
                                                    diskArr[it.originalIndex] = { name, type, data: dataUrl };
                                                } else {
                                                    const findIdx = diskArr.findIndex(a => (a && (a.name || a.fileName || a.filename)) === it.name);
                                                    if (findIdx !== -1) diskArr[findIdx] = { name, type, data: dataUrl };
                                                    else diskArr.push({ name, type, data: dataUrl });
                                                }
                                                localStorage.setItem(it.sourceKey, JSON.stringify(diskArr));
                                                console.debug('[review-2] replaced file at', idx, 'and wrote to', it.sourceKey);
                                                setTimeout(renderPreviewBlock, 40);
                                                picker.remove();
                                                return;
                                            }
                                        }
                                    } catch(e){ console.warn('[review-2] replace write to source failed', e); }

                                    // fallback: update aggregated view and write back to canonical education key
                                    try {
                                        const arr = Array.isArray(saved.list) ? saved.list.slice() : [];
                                        arr[idx] = { name, type, data: dataUrl };
                                        localStorage.setItem('uploadedCertificates_education', JSON.stringify(arr));
                                        console.debug('[review-2] replaced file at', idx, 'and wrote to uploadedCertificates_education');
                                    } catch (e) { console.warn('[review-2] fallback write failed', e); }
                                    setTimeout(renderPreviewBlock, 40);
                                } catch (e) { console.warn('replace handler failed', e); }
                                picker.remove();
                            };
                            reader.onerror = function(){ picker.remove(); };
                            reader.readAsDataURL(f);
                        });
                        picker.click();
                    });
                });
            } else {
                // fallback: if certsList not present, replace minimal area
                reviewContainer.querySelectorAll('*').forEach(n => n.remove());
                reviewContainer.appendChild(wrapper);
            }
            return;
        }

        // nothing found
        if (listEl) { listEl.innerHTML = ''; if (noEl) { noEl.style.display='block'; noEl.textContent = 'No certificates or trainings added.'; } }
        else reviewContainer.innerHTML = '<p class="text-gray-700 italic">Certificates / Trainings: No file uploaded</p>';
    }

    // small helper used by view handlers in other scripts
    function openPreviewModal(name, dataUrl, ext) {
        const modal = document.getElementById('fileModal') || document.getElementById('filePreviewModal');
        const modalContent = document.getElementById('modalContent') || document.getElementById('filePreviewContent');
        if (!modal || !modalContent) return;
        modalContent.innerHTML = `<h2 class="font-semibold mb-2">${name}</h2>`;
        const e = (ext || (name||'').split('.').pop() || '').toLowerCase();
        const src = (dataUrl && String(dataUrl).trim()) || null;
        if (['jpg','jpeg','png'].includes(e)) {
            if (src) modalContent.innerHTML += `<img src="${src}" class="max-h-[85vh] mx-auto rounded-lg shadow" />`;
            else modalContent.innerHTML += `<p class="text-gray-700">No preview source available for this image.</p>`;
        } else if (e === 'pdf') {
            if (src) modalContent.innerHTML += `<iframe src="${src}" class="w-full h-[85vh] rounded-lg border"></iframe>`;
            else modalContent.innerHTML += `<p class="text-gray-700">No preview source available for this PDF.</p>`;
        } else {
            modalContent.innerHTML += `<p class="text-gray-700">Preview not available for this file type.</p>`;
        }
        modal.classList.remove('hidden');
    }

    // initial render and watch storage
    document.addEventListener('DOMContentLoaded', renderPreviewBlock);
    window.addEventListener('storage', function(e){
        const watch = ['uploadedCertificates_education','education_certificates','uploadedProofs1','uploadedProofData','uploadedProofName','uploadedProofData1','uploadedProofName1','review_certs','uploadedProofs','uploadedProofs_proof','uploadedResume_file','uploadedWorkExp_file'];
        if (!e.key || watch.includes(e.key)) setTimeout(renderPreviewBlock, 30);
    });

    // expose openPreviewModal globally for other handlers
    window.__mvsg_openReviewPreview = openPreviewModal;
// Retry renderPreviewBlock a few times after load to beat race conditions
(function(){
    let attempts = 0;
    const maxAttempts = 6;
    const iv = setInterval(()=>{
        try { renderPreviewBlock(); } catch(e){ console.debug('[review-2] retry renderPreviewBlock error', e); }
        attempts++;
        if (attempts >= maxAttempts) clearInterval(iv);
    }, 120);
})();
})();
</script>

<script>
// Render resume uploaded from Work Experience page (uploadedResume_file)
(function(){
    function getResumeItem(){
        try{
            // 1) prefer per-job certificates stored inside job_experiences or work_experiences
            try {
                const rawJobs = localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || null;
                if (rawJobs) {
                    const parsedJobs = JSON.parse(rawJobs || '[]') || [];
                    // iterate from last to first to pick most recent uploaded cert
                    for (let i = parsedJobs.length - 1; i >= 0; i--) {
                        const j = parsedJobs[i];
                        if (j && j.certificate && (j.certificate.data || j.certificate.name)) return j.certificate;
                    }
                }
            } catch (e) { /* ignore per-job parse errors */ }

            // 2) fall back to legacy resume/workexp single-file keys
            const raw = localStorage.getItem('uploadedResume_file') || localStorage.getItem('uploadedWorkExp_file') || localStorage.getItem('resume') || null;
            if(!raw) return null;
            try{ const parsed = JSON.parse(raw||'null');
                if(Array.isArray(parsed) && parsed.length) return parsed[parsed.length-1];
                if(parsed && (parsed.name || parsed.data)) return parsed;
            }catch(e){
                // if it's a single filename string
                return { name: String(raw), type: (String(raw).split('.').pop()||'').toLowerCase(), data: null };
            }
        }catch(e){}
        return null;
    }

    function renderResumeBlock(){
        try{
            let container = document.getElementById('resumeReview') || document.getElementById('review_resume') || document.getElementById('review_job_experiences') || document.getElementById('job_experiences_container') || document.getElementById('reviewContainer');
            if(!container) return;
            let inner = container.querySelector('.resume-list') || container.querySelector('#resumeList');
            if(!inner){ inner = document.createElement('div'); inner.id = 'resumeList'; inner.className = 'resume-list mt-3'; container.insertBefore(inner, container.firstChild); }

            // gather per-entry certificates from job_experiences/work_experiences
            let certs = [];
            try {
                const rawJobs = localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || null;
                if (rawJobs) {
                    const parsed = JSON.parse(rawJobs || '[]') || [];
                    for (let i = 0; i < parsed.length; i++) {
                        const j = parsed[i];
                        if (j && j.certificate && (j.certificate.name || j.certificate.data)) certs.push({ cert: j.certificate, index: i });
                    }
                }
            } catch (e) { certs = []; }

            if (!certs.length) {
                // fallback to single legacy item
                const it = getResumeItem();
                if(!it){ inner.innerHTML = '<p class="text-gray-600 italic">No certificate uploaded.</p>'; return; }
                certs = [{ cert: it, index: -1 }];
            }

            // render stacked list
            inner.innerHTML = '';
            certs.forEach((entry, idx) => {
                try {
                    const it = entry.cert || {};
                    const ext = (it.type || (it.name||'').split('.').pop()||'').toLowerCase();
                    const icon = ext === 'pdf' ? '📄' : (['jpg','jpeg','png'].includes(ext) ? '🖼️' : '📁');
                    const nameSafe = String(it.name || 'Certificate').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    const card = document.createElement('div');
                    card.className = 'flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mb-3';
                    card.innerHTML = `<div class="text-2xl">${icon}</div><div class="min-w-0"><div class="text-sm text-gray-700 truncate max-w-[520px]">${nameSafe}</div><div class="text-xs text-gray-500 mt-1">${(ext||'').toUpperCase()}</div></div><div class="ml-auto flex gap-2"><button class="view-cert bg-[#2E2EFF] text-white text-xs px-3 py-1 rounded-md">View</button><button class="remove-cert bg-[#D20103] text-white text-xs px-3 py-1 rounded-md">Remove</button></div>`;
                    // attach handlers
                    card.querySelector('.view-cert').addEventListener('click', function(){
                        const modal = document.getElementById('filePreviewModal') || document.getElementById('fileModal');
                        const content = document.getElementById('filePreviewContent') || document.getElementById('modalContent');
                        if(modal && content){
                            content.innerHTML = `<h3 class="font-semibold mb-2">${nameSafe}</h3>`;
                            if(['jpg','jpeg','png'].includes(ext)) content.innerHTML += `<img src="${it.data || ''}" class="max-h-[85vh] mx-auto rounded-lg shadow" />`;
                            else if(ext==='pdf') content.innerHTML += `<iframe src="${it.data || ''}" class="w-full h-[85vh] rounded-lg border"></iframe>`;
                            else content.innerHTML += `<p class="text-gray-700">Preview not available for this file type.</p>`;
                            modal.classList.remove('hidden');
                        } else alert('No preview available.');
                    });

                    card.querySelector('.remove-cert').addEventListener('click', function(){
                        try {
                            if (entry.index >= 0) {
                                // remove certificate from the corresponding job entry
                                const rawJobs2 = localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || null;
                                if (rawJobs2) {
                                    const parsed2 = JSON.parse(rawJobs2 || '[]') || [];
                                    if (parsed2[entry.index]) { delete parsed2[entry.index].certificate; localStorage.setItem('job_experiences', JSON.stringify(parsed2)); }
                                }
                            } else {
                                // legacy: remove from uploadedResume_file array
                                const raw = localStorage.getItem('uploadedResume_file');
                                if (raw) { const arr = JSON.parse(raw||'[]')||[]; if(arr && arr.length){ arr.pop(); localStorage.setItem('uploadedResume_file', JSON.stringify(arr)); } }
                            }
                        } catch(e) { console.warn(e); }
                        setTimeout(renderResumeBlock, 40);
                    });

                    inner.appendChild(card);
                } catch(e) { console.warn('render cert failed', e); }
            });

        }catch(e){ console.warn('renderResumeBlock failed', e); }
    }

    document.addEventListener('DOMContentLoaded', renderResumeBlock);
    window.addEventListener('storage', function(e){
        const watch = ['uploadedResume_file','uploadedWorkExp_file','uploadedCertificates_education','education_certificates'];
        if(!e.key || watch.includes(e.key)) setTimeout(renderResumeBlock, 40);
    });
    // expose for debugging
    window.__mvsg_renderResume = renderResumeBlock;
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
            <script>
                (function(){
                    // utilities (kept small and robust)
                    const LS_KEY = 'education_certificates';
                    const $ = id => document.getElementById(id);
                    const parseJSON = s => { try { return JSON.parse(s||'null'); } catch(e){ return null; } };

                    function readCerts() {
                        const raw = localStorage.getItem(LS_KEY);
                        const arr = parseJSON(raw);
                        return Array.isArray(arr) ? arr : [];
                    }
                    function saveCerts(arr) {
                        try { localStorage.setItem(LS_KEY, JSON.stringify(arr || [])); } catch(e){}
                        window.dispatchEvent(new StorageEvent('storage',{key:LS_KEY, newValue: JSON.stringify(arr || [])}));
                    }

                    function fmtDateFriendly(d) {
                        if (!d) return '';
                        try { const dt = new Date(d); if (!isNaN(dt.getTime())) return dt.toLocaleDateString(undefined,{ year:'numeric', month:'long', day:'numeric' }); } catch(e){}
                        return d;
                    }

                    // read-only render
                    function renderReadOnly() {
                        const listEl = $('certsList');
                        const noneEl = $('noCertsMsg');
                        if (!listEl || !noneEl) return;
                        const arr = readCerts();
                        listEl.innerHTML = '';
                        if (!arr.length) { noneEl.style.display = 'block'; return; }
                        noneEl.style.display = 'none';
                        arr.forEach(item => {
                            const card = document.createElement('div');
                            card.className = 'bg-white border border-gray-200 rounded-lg p-4 shadow-sm';
                            const name = item.certificate_name || item.name || item.title || '—';
                            const issuer = item.issued_by || item.issuer || '';
                            const date = fmtDateFriendly(item.date_completed || item.date || item.completed || '');
                            const desc = item.training_description || item.description || item.what_you_learned || '';
                            card.innerHTML = `
                                <h4 class="text-blue-700 font-semibold mb-1">${escapeHtml(name)}</h4>
                                ${issuer ? `<div class="text-sm text-gray-700"><strong>Issued by:</strong> ${escapeHtml(issuer)}</div>` : ''}
                                ${date ? `<div class="text-sm text-gray-700 mt-1"><strong>Date:</strong> ${escapeHtml(date)}</div>` : ''}
                                ${desc ? `<div class="text-gray-800 text-sm mt-2">${escapeHtml(desc)}</div>` : ''}
                            `;
                            listEl.appendChild(card);
                        });
                    }

                    function escapeHtml(s){ if(s===null||s===undefined) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

                    // edit mode
                    function buildEditEntry(data) {
                        const tpl = $('cert_template');
                        const node = tpl.content.firstElementChild.cloneNode(true);
                        const nameInput = node.querySelector('.cert-name');
                        const issuerInput = node.querySelector('.cert-issuer');
                        const dateInput = node.querySelector('.cert-date');
                        const descInput = node.querySelector('.cert-desc');
                        if (data) {
                            nameInput.value = data.certificate_name || data.name || data.title || '';
                            issuerInput.value = data.issued_by || data.issuer || '';
                            // normalize date to yyyy-mm-dd for input
                            const rawDate = data.date_completed || data.date || data.completed || '';
                            try {
                                const dt = new Date(rawDate);
                                if (!isNaN(dt.getTime())) {
                                    const yyyy = dt.getFullYear();
                                    const mm = String(dt.getMonth()+1).padStart(2,'0');
                                    const dd = String(dt.getDate()).padStart(2,'0');
                                    dateInput.value = `${yyyy}-${mm}-${dd}`;
                                } else {
                                    dateInput.value = rawDate || '';
                                }
                            } catch(e){ dateInput.value = rawDate || ''; }
                            descInput.value = data.training_description || data.description || data.what_you_learned || '';
                        }
                        node.querySelector('.remove-cert').addEventListener('click', () => {
                            node.remove();
                        });
                        return node;
                    }

                    function enterEditMode() {
                        const editPanel = $('certsEdit');
                        const container = $('certs_container');
                        if (!editPanel || !container) return;
                        container.innerHTML = '';
                        const arr = readCerts();
                        if (!arr.length) container.appendChild(buildEditEntry({}));
                        else arr.forEach(it => container.appendChild(buildEditEntry(it)));
                        editPanel.classList.remove('hidden');
                        const list = $('certsList'); if (list) list.style.display = 'none';
                        const none = $('noCertsMsg'); if (none) none.style.display = 'none';
                    }

                    function exitEditMode(save) {
                        const editPanel = $('certsEdit');
                        const container = $('certs_container');
                        if (!editPanel || !container) return;
                        if (save) {
                            const entries = Array.from(container.querySelectorAll('.cert-entry'));
                            const out = entries.map(el => {
                                const get = cls => (el.querySelector('.' + cls) && el.querySelector('.' + cls).value) ? el.querySelector('.' + cls).value.trim() : '';
                                const obj = {
                                    certificate_name: get('cert-name'),
                                    issued_by: get('cert-issuer'),
                                    date_completed: get('cert-date'),
                                    training_description: get('cert-desc')
                                };
                                if (!obj.certificate_name && !obj.issued_by && !obj.date_completed && !obj.training_description) return null;
                                return obj;
                            }).filter(Boolean);
                            saveCerts(out);
                        }
                        editPanel.classList.add('hidden');
                        const list = $('certsList'); if (list) list.style.display = '';
                        const none = $('noCertsMsg'); if (none && (!readCerts() || !readCerts().length)) none.style.display = 'block';
                        renderReadOnly();
                    }
                    // expose API so main edit button can call into the cert editor without relying on click proxies
                    window.__mvsg_enterCerts = enterEditMode;
                    window.__mvsg_exitCerts = exitEditMode;
                    window.__mvsg_saveCerts = function(){ exitEditMode(true); };

                    // make document-click handler ignore clicks when button has mvsgSkip flag (so central handler can control flow)
                    document.addEventListener('click', function(ev){
                        try {
                            const closestBtn = ev.target && ev.target.closest ? ev.target.closest('#editSchoolBtn') : (ev.target && ev.target.id === 'editSchoolBtn' ? ev.target : null);
                            if (closestBtn && closestBtn.dataset && closestBtn.dataset.mvsgSkip === '1') {
                                // intentionally ignore — another handler is orchestrating open/close
                                return;
                            }
                        } catch(e){}

                        const target = ev.target;
                        if (!target) return;
                        if (target.id === 'editSchoolBtn') {
                            const editPanel = $('certsEdit');
                            if (editPanel && editPanel.classList.contains('hidden')) enterEditMode();
                            else exitEditMode(true);
                        }
                        if (target.id === 'addCertBtn') {
                            const container = $('certs_container');
                            if (container) container.appendChild(buildEditEntry({}));
                        }
                        if (target.id === 'saveCertsBtn') exitEditMode(true);
                        if (target.id === 'cancelCertsBtn') exitEditMode(false);
                    });
                    // wire buttons
                    document.addEventListener('click', function(ev){
                        const target = ev.target;
                        if (!target) return;
                        if (target.id === 'editSchoolBtn') {
                            const editPanel = $('certsEdit');
                            if (editPanel && editPanel.classList.contains('hidden')) enterEditMode();
                            else exitEditMode(true);
                        }
                        if (target.id === 'addCertBtn') {
                            const container = $('certs_container');
                            if (container) container.appendChild(buildEditEntry({}));
                        }
                        if (target.id === 'saveCertsBtn') exitEditMode(true);
                        if (target.id === 'cancelCertsBtn') exitEditMode(false);
                    });

                    // re-render when storage changes
                    window.addEventListener('storage', function(e){
                        if (!e.key || e.key === LS_KEY) setTimeout(renderReadOnly, 30);
                    });

                    // init on load
                    document.addEventListener('DOMContentLoaded', function(){
                        renderReadOnly();
                    });

                })();
            </script>
<script>
/*
  Central sync + safe edit-button wiring for Education fields.
  - Removes previous anonymous listeners by replacing the button node.
  - Keeps UI and localStorage in sync so saved values appear immediately and after reload.
*/
(function(){
    const EDU_KEYS = ['educationLevel','edu_level','education_level','review_edu','eduLevel'];
    const SCHOOL_KEYS = ['schoolName','school','school_name','review_school'];

    function readFirst(keys){
        for(const k of keys){
            try {
                const v = localStorage.getItem(k);
                if (v !== null && v !== undefined && String(v).trim() !== '') return String(v).trim();
            } catch(e){}
        }
        // try draft object
        try {
            const draftRaw = localStorage.getItem('rpi_personal2') || localStorage.getItem('registrationDraft') || null;
            if (draftRaw) {
                const d = JSON.parse(draftRaw);
                if (d) {
                    // common nested locations
                    const s = (d.schoolWorkInfo && (d.schoolWorkInfo.edu_level || d.schoolWorkInfo.school)) || d.edu_level || d.school || '';
                    if (s) return String(s).trim();
                }
            }
        } catch(e){}
        return '';
    }

    function ensureElements(){
        const raw = document.getElementById('educationLevel'); // used as raw fallback
        let disp = document.getElementById('educationLevel_display');
        if (!disp && raw) {
            disp = document.createElement('span');
            disp.id = 'educationLevel_display';
            raw.parentNode.insertBefore(disp, raw);
        }
        return {
            raw,
            disp,
            select: document.getElementById('edit_edu_select'),
            schoolSpan: document.getElementById('schoolName'),
            schoolInput: document.getElementById('edit_school_input')
        };
    }

    function syncEducationToUI(){
        const el = ensureElements();
        const edu = readFirst(EDU_KEYS) || '';
        const school = readFirst(SCHOOL_KEYS) || '';

        // determine display value: if edu is "Other", prefer a user-provided custom value
        function readOtherFromStorageLocal(){
            try {
                const keys = ['edu_other_text','educationOther','education_other','review_other'];
                for (const k of keys) {
                    const v = (localStorage.getItem(k) || '').toString().trim();
                    if (v) return v;
                }
                const prof = localStorage.getItem('education_profile');
                if (prof) {
                    try { const p = JSON.parse(prof); if (p && (p.edu_other_text || p.eduOther || p.education_other)) return (p.edu_other_text||p.eduOther||p.education_other).toString().trim(); } catch(e){}
                }
            } catch(e){}
            return '';
        }

        let displayVal = edu || '';
        try {
            if (String(displayVal).toLowerCase() === 'other' || String(displayVal).toLowerCase() === 'others') {
                const otherText = readOtherFromStorageLocal();
                if (otherText) displayVal = otherText;
            }
        } catch(e){}

        // update display span (primary)
        if (el.disp) {
            el.disp.textContent = displayVal;
            el.disp.classList.remove('hidden');
            el.disp.style.display = '';
        }
        // keep raw input/value consistent for other scripts
        if (el.raw) {
            try {
                if (el.raw.tagName === 'INPUT' || el.raw.tagName === 'TEXTAREA') el.raw.value = edu;
                else el.raw.textContent = edu;
                el.raw.classList.remove('hidden');
                el.raw.style.display = 'none'; // prefer display span visually
            } catch(e){}
        }
        // sync select (keep option existing)
        if (el.select) {
            const val = String(edu || '').trim();
            if (val) {
                const opt = Array.from(el.select.options).find(o => o.value === val || o.text === val);
                if (opt) el.select.value = opt.value;
                else {
                    // temporary option so select shows current value when opened
                    try {
                        const tmp = document.createElement('option');
                        tmp.value = val; tmp.text = val;
                        el.select.insertBefore(tmp, el.select.firstChild);
                        el.select.value = val;
                    } catch(e){}
                }
            }
            // hide editor by default
            el.select.classList.add('hidden');
            el.select.style.display = 'none';
        }

        // school
        if (el.schoolSpan) {
            el.schoolSpan.textContent = school;
            el.schoolSpan.classList.remove('hidden');
            el.schoolSpan.style.display = '';
        }
        if (el.schoolInput) {
            el.schoolInput.value = school || '';
            el.schoolInput.classList.add('hidden');
            el.schoolInput.style.display = 'none';
        }
    }

    function persistEducation(eduValue, schoolValue){
        const sEdu = String(eduValue || '');
        const sSchool = String(schoolValue || '');
        const keysEdu = EDU_KEYS;
        const keysSchool = SCHOOL_KEYS;
        keysEdu.forEach(k => { try { localStorage.setItem(k, sEdu); } catch(e){} });
        keysSchool.forEach(k => { try { localStorage.setItem(k, sSchool); } catch(e){} });

        // update draft object if present
        try {
            const rawDraft = localStorage.getItem('rpi_personal2') || '{}';
            let draft = {};
            try { draft = JSON.parse(rawDraft || '{}'); } catch(e){ draft = {}; }
            draft.schoolWorkInfo = draft.schoolWorkInfo || {};
            draft.schoolWorkInfo.school = sSchool;
            draft.schoolWorkInfo.edu_level = sEdu;
            localStorage.setItem('rpi_personal2', JSON.stringify(draft));
        } catch(e){}

        // notify listeners
        try { window.dispatchEvent(new CustomEvent('mvsg:educationSaved', { detail: { educationLevel: sEdu, schoolName: sSchool } })); } catch(e){}
        try { window.dispatchEvent(new StorageEvent('storage', { key: 'educationLevel', newValue: sEdu })); } catch(e){}
    }

    // Replace existing editSchoolBtn node to remove prior anonymous listeners, then attach unified handler.
    function wireEditButton(){
        const existing = document.getElementById('editSchoolBtn');
        if (!existing) return;
        const clone = existing.cloneNode(true);
        existing.parentNode.replaceChild(clone, existing);

        // ensure our state flag
        clone.dataset.mvsgEditing = '0';

        clone.addEventListener('click', function(){
            const editing = clone.dataset.mvsgEditing === '1';
            const els = ensureElements();
            if (!editing) {
                // open editors
                clone.dataset.mvsgEditing = '1';
                clone.textContent = '💾 Save Changes';
                clone.classList.remove('bg-blue-600'); clone.classList.add('bg-green-600');
                // show select and school input populated from UI/localStorage
                const currentEdu = els.disp ? els.disp.textContent.trim() : (els.raw ? (els.raw.value||els.raw.textContent||'') : '');
                if (els.select) {
                    // un-hide and ensure selection option exists
                    const opt = Array.from(els.select.options).find(o => o.value === currentEdu || o.text === currentEdu);
                    if (!opt && currentEdu) {
                        try { const tmp = document.createElement('option'); tmp.value = currentEdu; tmp.text = currentEdu; els.select.insertBefore(tmp, els.select.firstChild); } catch(e){}
                    }
                    els.select.classList.remove('hidden'); els.select.style.display = '';
                }
                if (els.disp) { els.disp.style.display = 'none'; els.disp.classList.add('hidden'); }
                if (els.raw) { els.raw.style.display = 'none'; els.raw.classList.add('hidden'); }
                if (els.schoolSpan) { els.schoolSpan.classList.add('hidden'); els.schoolSpan.style.display = 'none'; }
                if (els.schoolInput) { els.schoolInput.classList.remove('hidden'); els.schoolInput.style.display = ''; }
                // open inline certs editor as well (if available)
                try { if (typeof window.__mvsg_enterCerts === 'function') window.__mvsg_enterCerts(); else { const c = document.getElementById('certsEdit'); if (c) c.classList.remove('hidden'); const l = document.getElementById('certsList'); if (l) l.style.display = 'none'; } } catch(e){}
            } else {
                // save values and close editors
                const newEdu = (document.getElementById('edit_edu_select') && document.getElementById('edit_edu_select').value) || (document.getElementById('educationLevel') && (document.getElementById('educationLevel').value||document.getElementById('educationLevel').textContent)) || '';
                const newSchool = (document.getElementById('edit_school_input') && document.getElementById('edit_school_input').value) || (document.getElementById('schoolName') && document.getElementById('schoolName').textContent) || '';
                // persist
                persistEducation(newEdu.trim(), newSchool.trim());
                // update UI
                syncEducationToUI();
                // close certs editor
                try { if (typeof window.__mvsg_exitCerts === 'function') window.__mvsg_exitCerts(true); else { const c = document.getElementById('certsEdit'); if (c) c.classList.add('hidden'); const l = document.getElementById('certsList'); if (l) l.style.display = ''; } } catch(e){}
                // restore button label/state
                clone.dataset.mvsgEditing = '0';
                clone.textContent = '✏️ Edit Information';
                clone.classList.remove('bg-green-600'); clone.classList.add('bg-blue-600');
            }
        }, { passive: true });
    }

    // boot
    document.addEventListener('DOMContentLoaded', function(){
        try { syncEducationToUI(); } catch(e){ console.debug('sync init failed', e); }
        try { wireEditButton(); } catch(e){ console.debug('wireEditButton failed', e); }
    });

    // keep UI in sync when storage changes
    window.addEventListener('storage', function(e){
        const keys = EDU_KEYS.concat(SCHOOL_KEYS, ['rpi_personal2','registrationDraft']);
        if (!e.key || keys.includes(e.key)) {
            setTimeout(syncEducationToUI, 20);
        }
    });

    // also respond to our custom save event
    window.addEventListener('mvsg:educationSaved', function(){ setTimeout(syncEducationToUI, 10); });

})();
</script>
<script>
(function(){
    // Work inline edit: toggle, build entries, save to localStorage 'job_experiences'
    const workEditPanel = document.getElementById('workEditPanel');
    const workContainer = document.getElementById('work_edit_container');
    const template = document.getElementById('job_edit_template');
    const reviewJobs = document.getElementById('review_job_experiences');
    const reviewWorkList = document.getElementById('review_work_list');
    const editWorkSelect = document.getElementById('edit_work_select');
    let workEditBtn = Array.from(document.querySelectorAll('.edit-btn')).find(b=>b.dataset && b.dataset.section==='work');

    function parseJSONSafe(s){ try { return s ? JSON.parse(s) : []; } catch(e){ return Array.isArray(s) ? s : (typeof s === 'string' ? s.split(',').map(x=>x.trim()).filter(Boolean) : []); } }
    function readSavedJobs(){ return parseJSONSafe(localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || '[]'); }

    function buildEditNode(item){
        const node = template.content.firstElementChild.cloneNode(true);
        const title = node.querySelector('.job-edit-title');
        const company = node.querySelector('.job-edit-company');
        const year = node.querySelector('.job-edit-year');
        const desc = node.querySelector('.job-edit-desc');
        if (item) {
            title.value = item.title || item.job_title || item.position || '';
            company.value = item.company || item.company_name || item.employer || '';
            year.value = item.start_year || item.job_work_year || item.year || '';
            desc.value = item.description || item.job_description || item.desc || '';
        }
        node.querySelector('.remove-job-edit').addEventListener('click', () => { node.remove(); });
        return node;
    }

    function enterWorkEdit(){
        if (!workEditPanel || !workContainer) return;
        workContainer.innerHTML = '';
        const arr = readSavedJobs();
        if (!Array.isArray(arr) || arr.length === 0) workContainer.appendChild(buildEditNode({}));
        else arr.forEach(it => workContainer.appendChild(buildEditNode(it)));
        if (reviewJobs) reviewJobs.style.display = 'none';
        if (reviewWorkList) reviewWorkList.style.display = 'none';
        // populate & show work-type select
        try {
            const stored = localStorage.getItem('selected_work_experience') || localStorage.getItem('work_type') || localStorage.getItem('selectedWorkExperience') || '';
            if (editWorkSelect) {
                if (stored) {
                    try {
                        const parsed = JSON.parse(stored);
                        if (Array.isArray(parsed) && parsed.length) editWorkSelect.value = parsed[0];
                        else if (typeof stored === 'string' && String(stored).trim()) editWorkSelect.value = String(stored).replace(/[\[\]"]+/g,'').split(',')[0].trim();
                    } catch(e){ editWorkSelect.value = String(stored).replace(/[\[\]"]+/g,'').split(',')[0].trim(); }
                } else {
                    // try visible pills
                    const pill = reviewWorkList && reviewWorkList.querySelector('span:not(.text-gray-600)');
                    if (pill) editWorkSelect.value = pill.textContent.trim().toLowerCase() || '';
                }
                editWorkSelect.classList.remove('hidden');
                editWorkSelect.style.display = '';
            }
        } catch(e){}
        workEditPanel.classList.remove('hidden');
    }

    function exitWorkEdit(save){
        if (!workEditPanel || !workContainer) return;
        // read selection early
        const sel = (editWorkSelect && editWorkSelect.value) ? String(editWorkSelect.value).trim() : '';
        // persist work-type keys regardless of save flag (so UI reflects choice immediately)
        try {
            if (sel) {
                const asArr = JSON.stringify([sel]);
                localStorage.setItem('selected_work_experience', asArr);
                localStorage.setItem('work_type', asArr);
                localStorage.setItem('selectedWorkExperience', asArr);
                // update simple review pill display immediately
                if (reviewWorkList) {
                    reviewWorkList.innerHTML = '';
                    if (sel === 'none') reviewWorkList.innerHTML = '<span class="text-gray-600">N/A</span>';
                    else {
                        const span = document.createElement('span');
                        span.className = 'bg-blue-50 text-blue-800 px-3 py-1 rounded-md text-sm font-medium';
                        span.textContent = sel.charAt(0).toUpperCase() + sel.slice(1);
                        reviewWorkList.appendChild(span);
                    }
                }
            }
        } catch(e){}
        // build and persist job entries
        let out = [];
        if (save) {
            const entries = Array.from(workContainer.querySelectorAll('.job-edit-entry'));
            // try to preserve any previously stored certificate data for each job entry
            let prevJobs = [];
            try { prevJobs = JSON.parse(localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || '[]') || []; } catch(e){ prevJobs = []; }
            out = entries.map((node, idx) => {
                try {
                    const title = node.querySelector('.job-edit-title')?.value?.trim() || '';
                    const company = node.querySelector('.job-edit-company')?.value?.trim() || '';
                    const yearRaw = node.querySelector('.job-edit-year')?.value?.trim() || '';
                    const desc = node.querySelector('.job-edit-desc')?.value?.trim() || '';
                    // Normalize year/start_year: prefer 4-digit year, else try extract yyyy from common date formats
                    let start_year;
                    if (/^\d{4}$/.test(yearRaw)) start_year = yearRaw;
                    else {
                        const m = String(yearRaw).match(/(\d{4})\b/);
                        start_year = m ? m[1] : (yearRaw || undefined);
                    }
                    if (!title && !company && !start_year && !desc) return null;
                    const obj = { title, company, description: desc };
                    if (start_year !== undefined) obj.start_year = start_year;

                    // Attempt to capture certificate data from the edit node (various possible selectors)
                    try {
                        const hiddenVals = [
                            node.querySelector('.job_cert_data')?.value,
                            node.querySelector('.job-edit-cert-data')?.value,
                            node.querySelector('.job-edit-cert')?.value,
                            node.querySelector('input[name="job_cert_data"]')?.value
                        ];
                        for (const hv of hiddenVals) {
                            if (hv && typeof hv === 'string' && hv.trim()) {
                                try { obj.certificate = JSON.parse(hv); break; } catch(e){ obj.certificate = hv; break; }
                            }
                        }
                    } catch(e){}

                    // Fallback: if previous saved job at same index had a certificate, carry it forward
                    try {
                        if ((!obj.certificate || obj.certificate === '') && Array.isArray(prevJobs) && prevJobs[idx] && prevJobs[idx].certificate) {
                            obj.certificate = prevJobs[idx].certificate;
                        }
                    } catch(e){}

                    return obj;
                } catch(e){ return null; }
            }).filter(Boolean);
        }

        // If user selected "none", remove saved job_experiences so review shows empty state
        try {
            if (sel === 'none') {
                out = [];
            }
        } catch(e){}

        // persist canonical keys and draft
        try {
            const s = JSON.stringify(out || []);
            try { localStorage.setItem('job_experiences', s); } catch(e){}
            try { localStorage.setItem('work_experiences', s); } catch(e){}
            try { localStorage.setItem('workExperience', JSON.stringify({ work_experiences: out || [] })); } catch(e){}
            // Persist selected_work_year so final-step/readers have a stable key
            try {
                const years = (out || []).map(o => (o && (o.start_year || o.year || ''))).filter(Boolean);
                localStorage.setItem('selected_work_year', JSON.stringify(years));
            } catch(e){}
            // update rpi_personal2 draft object if present so server-side save sees changes
            try {
                const rawDraft = localStorage.getItem('rpi_personal2') || localStorage.getItem('rpi_personal') || '{}';
                let draft = {};
                try { draft = JSON.parse(rawDraft || '{}'); } catch(e){ draft = {}; }
                draft.workExperience = draft.workExperience || {};
                draft.workExperience.work_experiences = out || [];
                try { draft.workExperience.selected_work_year = (out || []).map(x => x.start_year || x.year || '').filter(Boolean); } catch(e){}
                localStorage.setItem('rpi_personal2', JSON.stringify(draft));
            } catch(e){}
            // notify other listeners
            try { window.dispatchEvent(new StorageEvent('storage', { key:'job_experiences', newValue: s })); } catch(e){}
            try { window.dispatchEvent(new CustomEvent('mvsg:workSaved', { detail: { workExperiences: out || [] } })); } catch(e){}
        } catch(e){ console.warn('persist work experiences failed', e); }

        workEditPanel.classList.add('hidden');
        if (reviewJobs) reviewJobs.style.display = '';
        if (reviewWorkList) reviewWorkList.style.display = '';
        // trigger re-render of review block
        setTimeout(()=>{ try { const ev = new Event('mvsg:populateDone'); window.dispatchEvent(ev); } catch(e){} }, 20);
    }
    
    // Remove standalone Save Work button (we'll use the top Edit -> Save toggle)
    const oldSaveBtn = document.getElementById('saveWorkBtn');
    if (oldSaveBtn && oldSaveBtn.parentNode) oldSaveBtn.parentNode.removeChild(oldSaveBtn);

    // Wire top-level Work Edit button to behave like Education's EditInformation (toggle -> Save)
    if (workEditBtn) {
        const clone = workEditBtn.cloneNode(true);
        workEditBtn.parentNode.replaceChild(clone, workEditBtn);
        clone.dataset.mvsgEditing = '0';
        // ensure initial visual state
        clone.textContent = clone.textContent.trim() || '✏️ Edit Information';
        clone.classList.remove('bg-green-600'); clone.classList.add('bg-blue-600');

        clone.addEventListener('click', function(){
            const editing = clone.dataset.mvsgEditing === '1';
            if (!editing) {
                // enter edit mode
                clone.dataset.mvsgEditing = '1';
                clone.textContent = '💾 Save Changes';
                clone.classList.remove('bg-blue-600'); clone.classList.add('bg-green-600');
                enterWorkEdit();
            } else {
                // save and exit
                clone.dataset.mvsgEditing = '0';
                clone.textContent = '✏️ Edit Information';
                clone.classList.remove('bg-green-600'); clone.classList.add('bg-blue-600');
                exitWorkEdit(true);
            }
        }, { passive: true });
    }

    // wire add/cancel buttons (keep these; save is now via top button)
    document.addEventListener('click', function(ev){
        const t = ev.target;
        if (!t) return;
        if (t.id === 'addWorkBtn') {
            if (workContainer) workContainer.appendChild(buildEditNode({}));
            return;
        }
        if (t.id === 'cancelWorkBtn') { exitWorkEdit(false); return; }
    });

    // Ensure panel hidden on load
    document.addEventListener('DOMContentLoaded', function(){
        if (workEditPanel) workEditPanel.classList.add('hidden');
        // hide edit select initially and sync review display from storage
        try {
            if (editWorkSelect) { editWorkSelect.classList.add('hidden'); editWorkSelect.style.display = 'none'; }
            const stored = localStorage.getItem('selected_work_experience') || localStorage.getItem('work_type') || '';
            if (stored && reviewWorkList) {
                try {
                    const parsed = JSON.parse(stored);
                    if (Array.isArray(parsed) && parsed.length) {
                        reviewWorkList.innerHTML = '';
                        parsed.forEach(v => {
                            const span = document.createElement('span');
                            span.className = 'bg-blue-50 text-blue-800 px-3 py-1 rounded-md text-sm font-medium';
                            span.textContent = String(v).charAt(0).toUpperCase() + String(v).slice(1);
                            reviewWorkList.appendChild(span);
                        });
                    }
                } catch(e){
                    const v = String(stored).replace(/[\[\]"]+/g,'').split(',')[0].trim();
                    if (v) {
                        reviewWorkList.innerHTML = '';
                        const span = document.createElement('span');
                        span.className = 'bg-blue-50 text-blue-800 px-3 py-1 rounded-md text-sm font-medium';
                        span.textContent = v.charAt(0).toUpperCase() + v.slice(1);
                        reviewWorkList.appendChild(span);
                    }
                }
            }
        } catch(e){}
    });

    // respond to storage changes so UI stays consistent
    window.addEventListener('storage', function(e){
        if (!e.key) return;
        if (['job_experiences','work_experiences','selected_work_experience','work_type'].includes(e.key)) {
            setTimeout(function(){
                try {
                    if (workEditPanel) workEditPanel.classList.add('hidden');
                    if (reviewJobs) reviewJobs.style.display = '';
                    if (reviewWorkList) reviewWorkList.style.display = '';
                } catch(e){}
            }, 20);
        }
    });
})();
</script>

</body>

</html>
