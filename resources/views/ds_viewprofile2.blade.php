@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-6 px-6 sm:px-10 lg:px-24">
            <div class="flex justify-start items-center space-x-3 max-w-[1600px] mx-auto">
                <a href="/viewprofile1"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-3xl sm:text-3xl hover:underline focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back</span>
                </a>
            </div>
        </div>


        <!-- Profile Section -->
        <section class="max-w-[1600px] mx-auto px-10 py-14 space-y-12">

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <div class="bg-blue-800 text-white flex items-center gap-12 px-10 py-10 rounded-t-2xl">
                    <div id="profile_initials"
                        class="bg-white text-blue-800 font-bold rounded-full w-24 h-24 flex items-center justify-center text-3xl">
                        JD
                    </div>
                    <div>
                        <h1 id="profile_fullname" class="text-2xl font-semibold">No name provided</h1>
                        <p id="profile_location" class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" class="w-7 h-7">
                            <span id="profile_location_text">Location not specified</span>
                        </p>
                        <p class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" class="w-6 h-6">
                            <span id="profile_header_email">Information not specified</span>
                        </p>
                    </div>
                </div>

                <div class="p-10 space-y-14">

<!-- Education Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Education</h3>

                        <div id="educationList" class="space-y-6">
                            <!-- Rendered education-item cards will appear here. If server returns a single top-level
                                 education string, the UI will fall back to the existing simple display below. -->
                        </div>

                        {{-- <div class="mt-4">
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-semibold">Highest Education (summary):</span>
                                <span id="educationLevel" class="text-gray-800">-</span>
                            </div>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-lg font-semibold">Primary School / Institution:</span>
                                <span id="schoolName" class="text-gray-800">-</span>
                            </div>
                        </div> --}}

                        <!-- Edit controls (kept for compatibility) -->
                        <select id="edit_edu_select" class="hidden w-full border rounded px-3 py-2 mt-4">
                            <option value="College">College</option>
                            <option value="Vocational/Training">Vocational/Training</option>
                            <option value="High School">High School</option>
                            <option value="Elementary">Elementary</option>
                        </select>
                        <input type="text" id="edit_school_input" class="hidden w-full border rounded px-3 py-2 mt-2" />

                        <!-- Certificates: match layout/column sizing used by Job Experiences -->
                        <div class="mt-6 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="col-span-1">
                                <label class="block text-lg font-semibold mb-3">Certificates & Trainings
                                </label>

                                    <div id="certificateReview" class="mt-2 text-gray-800">
                                        <div id="certsList" class="space-y-2"></div>
                                        <div id="noCertsMsg" class="text-gray-600 italic">No certificates or trainings added.</div>

                                        <!-- NOTE: "Click to Add Certificates / Training Details" removed per request -->
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
                                                        <div>
                                                            <label class="text-sm font-medium text-gray-700">Certificate File</label>
                                                            <div class="mt-1 flex items-center gap-2">
                                                                <input type="file" accept=".pdf,image/*" class="cert-file-input" />
                                                                <span class="cert-file-name text-sm text-gray-600"></span>
                                                            </div>
                                                            <input type="hidden" class="cert-file-data" />
                                                        </div>
                                                    </div>
                                                    <button type="button" class="remove-cert absolute top-3 right-3 text-sm bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                                                </div>
                                            </template>

                                            <div class="flex gap-3 mt-4">
                                                <button id="addCertEntryBtn" type="button" class="bg-indigo-600 text-white px-4 py-2 rounded-md">＋ Add Another Certificate</button>
                                                <!-- saveCertsBtn removed; main Edit/Save button will commit certificates -->
                                                <button id="cancelCertsBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div></div>
                            <div></div>
                        </div>

                        <!-- Edit Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600 italic">
                                Pindutin ang <span class="text-blue-600 font-medium italic">"Edit"</span> upang baguhin
                            </p>
                            <button id="editEducationBtn"
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

<!-- Work Experience Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Work Experience</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Type of Work + Job Experiences -->
                            <div class="col-span-1">

<!-- Type of Work Row -->
                                <div class="mb-4">
                                    <div class="flex items-center gap-4">
                                        <span class="text-lg font-semibold leading-none">Type of Work:</span>
                                        <div id="review_work_list" class="flex flex-wrap gap-3 text-gray-800 mb-2">
                                        </div>
                                    </div>
                                </div>
<!-- Job Experiences -->
                                <h4 class="mt-8 text-xl font-semibold text-blue-800 mb-2">Job Experiences</h4>
                                <div id="review_job_experiences" class="space-y-2 text-gray-800">
                                    <p class="text-gray-600 italic">No job experiences added.</p>
                                </div>
                                <!-- Add Work Experience Button -->
                                <button id="openWorkEditorBtn"
                                    class="mt-3 bg-blue-800 text-white px-5 py-2 rounded-lg text-base font-medium hover:bg-blue-700">
                                    Click to Add Work Experience
                                </button>
                            </div>

                            <!-- Empty divs to stabilize grid alignment -->
                            <div></div>
                            <div></div>

                        </div>

                        <!-- Edit Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600 italic">
                                Pindutin ang <span class="text-blue-600 font-medium italic">"Edit"</span> upang baguhin
                            </p>
                            <button id="editWorkBtn"
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

 <!-- Work Environment Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Preferred Work Environment</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Preferred Workplace -->
                            <div class="col-span-1">
                                <div class="mb-4">
                                    <div class="flex items-center gap-4">
                                        <div id="review_workplace_list" class="flex flex-wrap gap-3 text-gray-800 mb-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="review_workplace_choice_img_container" class="mt-4 text-center hidden">
                                <div
                                    class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
                                    <img id="review_workplace_choice_img" src="" alt="Workplace image"
                                        class="w-full h-full object-contain rounded-md" />
                                </div>
                            </div>
                        </div>


                        <!-- Empty divs to stabilize grid alignment -->
                        <div></div>
                        <div></div>

                        <!-- Edit Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600 italic">
                                Pindutin ang <span class="text-blue-600 font-medium italic">"Edit"</span> upang baguhin
                            </p>
                            <button id="editWorkplaceBtn"
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>


                    <!-- Next Button -->
                    <div class="text-center space-y-3">
                        <a href="/viewprofile3"
                            class="inline-flex bg-blue-800 text-white font-medium px-32 py-4 rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2 mx-auto text-lg">
                            Next → <i class="ri-arrow-right-line text-2xl"></i>
                        </a>
                        <p class="text-base">Click <span class="text-blue-800 font-medium">"Next"</span> to move to the next
                            page</p>
                        <p class="text-sm text-gray-500 italic">(Pindutin ang <span class="text-blue-800 font-medium italic">"Next"</span>
                            upang lumipat sa susunod na pahina)</p>
                    </div>

        </section>
<style>
/* selectable card visuals (copied from ds_register_review-2) */
.selectable-card {
    border: 2px solid transparent;
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
}
.selectable-card.selected {
    border-color: #2563eb;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.14);
    transform: translateY(-6px);
}

/* badge for selected card (checkmark) */
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

/* keep compatibility with existing selected-card class */
.selected-card {
    border: 3px solid #1E40AF !important;
    background-color: #DBEAFE !important;
}

/* TTS button visual state */
.tts-btn { cursor: pointer; }
.tts-btn.speaking { transform: scale(1.04); box-shadow: 0 8px 24px rgba(30,64,175,0.12); }
</style>
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('/db/get_profile.php', { credentials: 'same-origin' })
    .then(r => r.json())
    .then(json => {
        if (!json.success) return console.warn('Profile fetch failed', json);
        const u = json.user || {};

        // Header
        const initialsEl = document.getElementById('profile_initials');
        const fullnameEl = document.getElementById('profile_fullname');
        const locationTextEl = document.getElementById('profile_location_text');
        const headerEmailEl = document.getElementById('profile_header_email');

        const fn = (u.FIRST_NAME || u.first_name || '').toString().trim();
        const ln = (u.LAST_NAME || u.last_name || '').toString().trim();
        const fullname = (fn + ' ' + ln).trim();
        if (fullnameEl) fullnameEl.textContent = fullname || (fullnameEl.textContent||'');
        let initials = '';
        if (fn) initials += fn.charAt(0);
        if (ln) initials += ln.charAt(0);
        if (!initials) initials = (u.USERNAME || u.EMAIL || '').toString().slice(0,2);
        if (initialsEl) initialsEl.textContent = initials.toUpperCase();
        if (locationTextEl) locationTextEl.textContent = (u.ADDRESS || u.address || '') || '—';
        if (headerEmailEl) headerEmailEl.textContent = (u.EMAIL || u.email || '') || '';

        // Education placeholders: use aliases provided by get_profile.php
        const eduEl = document.getElementById('educationLevel');
        const schoolEl = document.getElementById('schoolName');
        // avoid setting raw JSON string into textContent; default to '-' and populate below
        if (eduEl) eduEl.textContent = '-';
        if (schoolEl) schoolEl.textContent = '-';

        // Render full education entries (if server returned JSON array/object)
        let rawEdu = u.EDUCATION_LEVEL || u.education || null;
        // also accept parallel school/course/year columns (may be scalar, JSON string, or array)
        let rawSchool = u.SCHOOL_NAME || u.school || null;
        let rawCourse = u.EDUCATION_COURSE || u.education_course || null;
        let rawYs = u.YEAR_START || u.year_start || null;
        let rawYe = u.YEAR_END || u.year_end || null;
        const listContainer = document.getElementById('educationList');
        try {
            const _raw = rawEdu;
            if (rawEdu && listContainer) {
                let entries = null;
                if (Array.isArray(rawEdu)) entries = rawEdu;
                else if (typeof rawEdu === 'string') {
                    try { entries = JSON.parse(rawEdu); } catch (e) { entries = null; }
                } else if (typeof rawEdu === 'object') entries = [rawEdu];

                if (Array.isArray(entries) && entries.length) {
                    // parse parallel arrays when present
                    let schoolArr = null, courseArr = null, ysArr = null, yeArr = null;
                    try { schoolArr = Array.isArray(rawSchool) ? rawSchool : (typeof rawSchool === 'string' && rawSchool.trim()[0] === '[' ? JSON.parse(rawSchool) : null); } catch(e) { schoolArr = null; }
                    try { courseArr = Array.isArray(rawCourse) ? rawCourse : (typeof rawCourse === 'string' && rawCourse.trim()[0] === '[' ? JSON.parse(rawCourse) : null); } catch(e) { courseArr = null; }
                    try { ysArr = Array.isArray(rawYs) ? rawYs : (typeof rawYs === 'string' && rawYs.trim()[0] === '[' ? JSON.parse(rawYs) : null); } catch(e) { ysArr = null; }
                    try { yeArr = Array.isArray(rawYe) ? rawYe : (typeof rawYe === 'string' && rawYe.trim()[0] === '[' ? JSON.parse(rawYe) : null); } catch(e) { yeArr = null; }

                    listContainer.innerHTML = '';
                    entries.forEach((ent, idx) => {
                        // support primitive entries like "Highschool" as well as object entries
                        let lvl = '';
                        let sch = '';
                        if (ent === null || ent === undefined) {
                            lvl = '';
                        } else if (typeof ent === 'string' || typeof ent === 'number') {
                            lvl = String(ent);
                        } else if (Array.isArray(ent)) {
                            // array-of-strings inside entries — join as level
                            lvl = ent.filter(Boolean).join(', ');
                        } else if (typeof ent === 'object') {
                            lvl = (ent.education || ent.edu_level || ent.level || ent.education_level || '').toString();
                            sch = (ent.school || ent.school_name || ent.institution || '').toString();
                        }
                        let course = (ent && ent.course) ? (ent.course || ent.education_course || ent.program || ent.training || '') : '';
                        let ys = (ent && (ent.year_start || ent.yearFrom || ent.start)) ? (ent.year_start || ent.yearFrom || ent.start) : '';
                        let ye = (ent && (ent.year_end || ent.yearTo || ent.end)) ? (ent.year_end || ent.yearTo || ent.end) : '';

                        // fill from parallel arrays when entry doesn't include them
                        try { if ((!sch || sch === '') && Array.isArray(schoolArr) && schoolArr[idx]) sch = String(schoolArr[idx]); } catch(e){}
                        try { if ((!course || course === '') && Array.isArray(courseArr) && courseArr[idx]) course = String(courseArr[idx]); } catch(e){}
                        try { if ((!ys || ys === '') && Array.isArray(ysArr) && ysArr[idx]) ys = String(ysArr[idx]); } catch(e){}
                        try { if ((!ye || ye === '') && Array.isArray(yeArr) && yeArr[idx]) ye = String(yeArr[idx]); } catch(e){}

                        const node = document.createElement('div');
                        node.className = 'education-item bg-gray-50 border border-gray-200 rounded-xl p-4';
                        node.innerHTML = `
                            <div class="mb-3 flex items-start justify-between">
                                <div class="text-sm text-gray-600 italic">Filled from your profile</div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="font-semibold text-gray-800">Education Level</label>
                                    <div class="w-full rounded-lg p-3 text-gray-800 edu-val">${escapeHtml(lvl) || '-'}</div>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-800">School / Training Center</label>
                                    <div class="w-full rounded-lg p-3 text-gray-800 school-val">${escapeHtml(sch) || '-'}</div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-800">Course / Program</label>
                                    <div class="w-full rounded-lg p-3 text-gray-800 course-val">${escapeHtml(course) || '-'}</div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:col-span-2">
                                    <div>
                                        <label class="font-semibold text-gray-800">Year Started</label>
                                        <div class="w-full rounded-lg p-3 text-gray-800 ys-val">${escapeHtml(ys) || '-'}</div>
                                    </div>
                                    <div>
                                        <label class="font-semibold text-gray-800">Year Completed</label>
                                        <div class="w-full rounded-lg p-3 text-gray-800 ye-val">${escapeHtml(ye) || '-'}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                        listContainer.appendChild(node);
                    });
                    // update summary fields using first entry
                    const first = entries[0] || {};
                    if (eduEl) {
                        if (typeof first === 'string' || typeof first === 'number') eduEl.textContent = String(first) || '-';
                        else eduEl.textContent = (first.education || first.edu_level || first.level || eduEl.textContent) || '-';
                    }
                    if (schoolEl) {
                        if (typeof first === 'object' && first !== null) schoolEl.textContent = (first.school || first.school_name || schoolEl.textContent) || '-';
                    }
                }
            }
        } catch (e) { console.warn('render education failed', e); }

        // If render didn't produce any cards, at least display a readable summary
        try {
            if (listContainer && (!listContainer.children || listContainer.children.length === 0)) {
                if (Array.isArray(rawEdu)) {
                    if (eduEl) eduEl.textContent = rawEdu.join(', ') || '-';
                } else if (typeof rawEdu === 'string') {
                    const s = rawEdu.trim();
                    if (s[0] === '[' || s[0] === '{') {
                        try {
                            const p = JSON.parse(s);
                            if (Array.isArray(p)) { if (eduEl) eduEl.textContent = p.join(', ') || '-'; }
                            else if (typeof p === 'object') { if (eduEl) eduEl.textContent = JSON.stringify(p) || '-'; }
                        } catch(e) { if (eduEl) eduEl.textContent = s || '-'; }
                    } else {
                        if (eduEl) eduEl.textContent = s || '-';
                    }
                }
            }
        } catch(e){}

        // guardian/user id
        const userId = u.ID || u.id || u.USER_ID || u.GUARDIAN_ID || u.guardian_id;
        if (!userId) return console.warn('No user/guardian id in profile response');

        // expose guardian id globally so editors can use it
        window.__mvsg_guardian_id = userId;
// expose a function to render certificates from DB (used after saves)
        // expose a function to render certificates from DB (used after saves)
        window.__mvsg_certs_req_id = window.__mvsg_certs_req_id || 0;
        window.__mvsg_renderDBCerts = function(gid){
            const listEl = document.getElementById('certsList');
            const noneEl = document.getElementById('noCertsMsg');
            if (!listEl || !noneEl) return;
            // bump request id so only the latest response actually renders
            const reqId = ++window.__mvsg_certs_req_id;
            // clear UI immediately
            listEl.innerHTML = '';
            noneEl.style.display = 'none';

            fetch('/db/get-guardian-certs.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ guardian_id: gid })
            }).then(r => r.json()).then(j => {
                // ignore if a newer request was started
                if (reqId !== window.__mvsg_certs_req_id) return;
                // ensure clean slate before appending
                listEl.innerHTML = '';
                if (!j || !j.success || !Array.isArray(j.certificates || j.data || j.rows)) {
                    noneEl.style.display = 'block';
                    noneEl.textContent = 'No certificates or trainings added.';
                    return;
                }
                const arr = j.certificates || j.data || j.rows || [];
                if (!arr.length) {
                    // Try to render client-side uploaded certificates (localStorage) as a fallback
                    try {
                        const fallbackKeys = ['uploadedCertificates_education','uploadedProofs_proof','uploadedProofs','certificates','education_certificates'];
                        let fallback = [];
                        for (const k of fallbackKeys) {
                            try {
                                const raw = localStorage.getItem(k) || sessionStorage.getItem(k) || null;
                                if (!raw) continue;
                                let parsed = null;
                                try { parsed = JSON.parse(raw); } catch(e) { parsed = raw; }
                                if (Array.isArray(parsed)) { fallback = parsed; break; }
                                if (parsed && typeof parsed === 'object') { fallback = [parsed]; break; }
                                // raw base64/data-url string
                                if (typeof parsed === 'string' && (parsed.indexOf('data:') === 0 || parsed.match(/^data:[^;]+;base64,/))) {
                                    fallback.push({certificate_name: 'Uploaded Certificate', data: parsed});
                                    break;
                                }
                            } catch(e) { /* ignore per-key parse errors */ }
                        }
                        if (fallback.length) {
                            noneEl.style.display = 'none';
                            fallback.forEach(it => {
                                const name = it.certificate_name || it.name || it.cert_name || '';
                                const issuer = it.issued_by || it.issuer || '';
                                const date = it.date_completed || it.date || '';
                                const learned = it.training_description || it.what_learned || it.description || '';

                                const card = document.createElement('div');
                                card.className = 'mb-3 p-3 border rounded-md bg-white shadow-sm relative';
                                const title = name ? `<div class="font-semibold text-gray-800">${escapeHtml(name)}</div>` : '';
                                const meta = (issuer || date) ? `<div class="text-sm text-gray-600 mt-1">${escapeHtml(issuer)}${issuer && date ? ' • ' : ''}${date ? escapeHtml(fmtDate(date)) : ''}</div>` : '';
                                const desc = learned ? `<div class="text-sm text-gray-700 mt-2">${escapeHtml(learned)}</div>` : '';
                                let badge = '';
                                try {
                                    const rawData = it.data || it.file || it.certificate || it.certificate_data || null;
                                    if (rawData) {
                                        // create a downloadable/viewable link that opens the data URL in a new tab
                                        const href = (typeof rawData === 'string' && rawData.indexOf('data:') === 0) ? rawData : (typeof rawData === 'string' ? rawData : null);
                                        if (href) {
                                            badge = `<a href="${href}" target="_blank" rel="noopener" class="absolute right-3 top-3 inline-flex items-center gap-2 text-green-700 hover:opacity-90" title="View certificate"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="#ECFDF5"/><path d="M9 12.5l1.8 1.8L15 10" stroke="#059669" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>`;
                                        }
                                    }
                                } catch(e) { badge = ''; }
                                card.innerHTML = title + meta + desc + badge;
                                listEl.appendChild(card);
                            });
                            return;
                        }
                    } catch(e) { /* fallback parsing failed */ }
                    noneEl.style.display = 'block';
                    noneEl.textContent = 'No certificates or trainings added.';
                    return;
                }
                function fmtDate(d) {
                    if (!d) return '';
                    try {
                        const dt = new Date(d);
                        if (!isNaN(dt.getTime())) return dt.toLocaleDateString(undefined, { year:'numeric', month:'long', day:'numeric' });
                    } catch(e){}
                    try {
                        const dt2 = new Date(String(d));
                        if (!isNaN(dt2.getTime())) return dt2.toLocaleDateString();
                    } catch(e){}
                    return String(d);
                }

                arr.forEach(it => {
                    const name = it.NAME || it.name || it.certificate_name || '';
                    const issuer = it.ISSUED_BY || it.issued_by || it.issuer || '';
                    const date = it.DATE_COMPLETED || it.date_completed || it.date || '';
                    const learned = it.WHAT_LEARNED || it.what_learned || it.what_you_learned || '';

                    const card = document.createElement('div');
                    card.className = 'mb-3 p-3 border rounded-md bg-white shadow-sm relative';
                    const title = name ? `<div class="font-semibold text-gray-800">${escapeHtml(name)}</div>` : '';
                    const meta = (issuer || date) ? `<div class="text-sm text-gray-600 mt-1">${escapeHtml(issuer)}${issuer && date ? ' • ' : ''}${date ? escapeHtml(fmtDate(date)) : ''}</div>` : '';
                    const desc = learned ? `<div class="text-sm text-gray-700 mt-2">${escapeHtml(learned)}</div>` : '';
                    // badge for on-server certificate (green)
                    let badge = '';
                    try {
                        if (it.HAS_CERT || it.has_cert || it.HAS_CERT === 1) {
                            // use explicit cert_id parameter so endpoint targets CERTIFICATE column
                            const url = '/db/get-guardian-cert-file.php?cert_id=' + encodeURIComponent(it.ID || it.id);
                            badge = `<a href="${url}" target="_blank" class="absolute right-3 top-3 inline-flex items-center gap-2 text-green-700 hover:opacity-90" title="View certificate">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="#ECFDF5"/><path d="M9 12.5l1.8 1.8L15 10" stroke="#059669" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>`;
                        }
                    } catch(e) { badge = ''; }
                    card.innerHTML = title + meta + desc + badge;
                    listEl.appendChild(card);
                    // Also add a simple guardian cert link under serverCertLinks
                    try {
                        if (it.HAS_CERT || it.has_cert || it.HAS_CERT === 1) {
                            const gLinks = document.getElementById('guardianCertLinks');
                                if (gLinks) {
                                const gid = String(it.ID || it.id || '').trim();
                                if (/^\d+$/.test(gid)) {
                                    const a = document.createElement('a');
                                    a.href = '/db/get-guardian-cert-file.php?cert_id=' + encodeURIComponent(gid);
                                    a.target = '_blank';
                                    a.rel = 'noopener';
                                    a.className = 'text-green-700 underline';
                                    a.textContent = (it.NAME || it.name || 'Certificate') + ' — View / Download';
                                    a.setAttribute('download', (it.NAME||'certificate') + '.pdf');
                                    gLinks.appendChild(a);
                                }
                            }
                        }
                    } catch(e) { /* non-critical */ }
                });

                // show serverCertLinks if any guardian cert anchors were appended
                try {
                    const sLinks = document.getElementById('serverCertLinks');
                    const gLinks = document.getElementById('guardianCertLinks');
                    if (sLinks && gLinks && gLinks.children.length > 0) {
                        sLinks.style.display = '';
                    }
                } catch (e) { /* non-critical */ }
            }).catch(e => {
                // ignore if newer request started
                if (reqId !== window.__mvsg_certs_req_id) return;
                noneEl.style.display = 'block';
                noneEl.textContent = 'Unable to load certificates.';
                console.debug('guardian certs fetch failed', e);
            });
        };

        // initial render of DB-backed certs
        window.__mvsg_renderDBCerts(userId);

        // (server-file links removed — UI now shows certificates via DB-backed lists only)


        // fetch job_experience rows (by guardian_id)
        return fetch('/db/get-user-work.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ guardian_id: userId })
        });
    })
    .then(async r => {
        if (!r) return;
        const json = await r.json();
        if (!json.success) return console.warn('get-user-work failed', json);

        // populate work_experience (from USER_PROFILE.TYPE = 'work_experience')
        const profiles = json.profiles || {};
        const jobs = json.job_experience_rows || [];

        const reviewWorkList = document.getElementById('review_work_list');
        const reviewWorkplaceList = document.getElementById('review_workplace_list');
        const jobContainer = document.getElementById('review_job_experiences');
        // render Type of Work as badges (same look as viewprofile3)
        if (reviewWorkList) {
            reviewWorkList.innerHTML = '';
            const we = profiles.work_experience || [];
            function formatWork(v) {
                if (v === null || v === undefined) return '';
                const s = String(v).trim();
                if (s === '') return '';
                if (s.toLowerCase() === 'none') return 'None';
                return s.charAt(0).toUpperCase() + s.slice(1);
            }
            if (we.length) {
                we.forEach(v => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = formatWork(v);
                    reviewWorkList.appendChild(span);
                });
            } else {
                reviewWorkList.innerHTML = '<span class="text-gray-600">-</span>';
            }
        }

        // render Preferred Workplace as badges (single-line where possible)
        if (reviewWorkplaceList) {
            reviewWorkplaceList.innerHTML = '';
            const wp = profiles.workplace || [];
            function formatWorkplace(v) {
                if (v === null || v === undefined) return '';
                const s = String(v).trim();
                if (s.toLowerCase() === 'none' || s === '') return '-';
                return s.charAt(0).toUpperCase() + s.slice(1);
            }
            if (wp.length) {
                wp.forEach(v => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = formatWorkplace(v);
                    reviewWorkplaceList.appendChild(span);
                });
            } else {
                reviewWorkplaceList.innerHTML = '<span class="text-gray-600">-</span>';
            }
        }

        // leave Type of Work and Preferred Workplace as before (user_profile job_category/work_experience may be used elsewhere)
        // only render JOB_EXPERIENCE rows here
        if (jobContainer) {
            jobContainer.innerHTML = '';

            if (!jobs.length) {
                const p = document.createElement('p');
                p.className = 'text-gray-600 italic';
                p.textContent = 'No job experiences added.';
                jobContainer.appendChild(p);
            } else {
                jobs.forEach(j => {
                    const card = document.createElement('div');
                    card.className = 'mb-3 p-3 border rounded-md bg-white shadow-sm';
                    const title = escapeHtml(j.company_name || '') + (j.job_title ? ' — ' + escapeHtml(j.job_title) : '');
                    // Format period: prefer start_date/end_date -> start_month/start_year -> work_year
                    function fmtMonthYear(m,y){ if (!y && !m) return ''; var mm = m ? ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][parseInt(m)] || m : ''; return (mm ? mm + ' ' : '') + (y || ''); }
                    function fmtFromDate(dateStr){ if (!dateStr) return ''; try { const d = new Date(dateStr); if (!isNaN(d.getTime())) return d.toLocaleString(undefined, { month: 'short', year: 'numeric' }); } catch(e){} return ''; }
                    let period = '';
                    // prefer raw ISO dates if present
                    if (j.start_date) {
                        const s = fmtFromDate(j.start_date) || fmtMonthYear(j.start_month, j.start_year);
                        let e = '';
                        if (j.end_date) {
                            e = fmtFromDate(j.end_date) || fmtMonthYear(j.end_month, j.end_year);
                        } else if (j.end_year && String(j.end_year).toLowerCase() === 'present') {
                            e = 'Present';
                        } else if (j.end_year || j.end_month) {
                            e = fmtMonthYear(j.end_month, j.end_year);
                        }
                        period = s + (e ? ' — ' + e : '');
                    } else if (j.start_year || j.start_month) {
                        const s = fmtMonthYear(j.start_month, j.start_year);
                        let e = '';
                        if (j.end_year && String(j.end_year).toLowerCase() !== 'present') e = fmtMonthYear(j.end_month, j.end_year);
                        else if (j.end_year && String(j.end_year).toLowerCase() === 'present') e = 'Present';
                        period = s + (e ? ' — ' + e : '');
                    } else if (j.work_year) {
                        period = String(j.work_year);
                    } else {
                        period = '';
                    }
                    // Hide the 'More than 3 years' label; show other labels only if present
                    let expLabel = '';
                    try {
                        if (j.years_experience && String(j.years_experience).trim().toLowerCase() !== 'more than 3 years') {
                            expLabel = String(j.years_experience).trim();
                        }
                    } catch (e) { expLabel = ''; }
                    const meta = (expLabel ? escapeHtml(expLabel) : '') + (period ? (expLabel ? ' • ' : '') + escapeHtml(period) : '');
                    const desc = escapeHtml(j.job_description || '');
                    const env = j.working_environment ? '<div class="text-xs text-gray-500 mt-2">Environment: ' + escapeHtml(j.working_environment) + '</div>' : '';
                    const locVal = j.company_location || j.LOCATION || j.location || '';
                    const locHtml = locVal ? '<div class="text-sm text-gray-500 mt-1">' + escapeHtml(locVal) + '</div>' : '';
                    // If this job has per-entry certificate, show blue check with link
                    let jobBadge = '';
                    try {
                        if (j.HAS_CERT || j.has_cert || j.HAS_CERT === 1) {
                            // Ensure the id used in the URL is a plain integer to avoid malformed links
                            const rawId = j.id || j.ID || j.job_id || '';
                            const idStr = rawId !== null && rawId !== undefined ? String(rawId).trim() : '';
                            if (/^[A-Za-z0-9_\-]+$/.test(idStr)) {
                                const url = '/db/get-job-cert-file.php?id=' + encodeURIComponent(idStr);
                                jobBadge = `<a href="${url}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 ml-2" title="View work experience certificate">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="#EFF6FF"/><path d="M9 12.5l1.8 1.8L15 10" stroke="#1D4ED8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>`;
                            } else {
                                // invalid id value; skip rendering the link
                                jobBadge = '';
                                console.debug('Skipping job cert link due to invalid id', rawId);
                            }
                        }
                    } catch(e) { jobBadge = ''; }

                    card.innerHTML = '<div class="font-semibold">' + title + jobBadge + '</div>' +
                                     '<div class="text-sm text-gray-600">' + meta + '</div>' +
                                     locHtml +
                                     '<div class="text-sm text-gray-700 mt-2">' + desc + '</div>' + env;
                    jobContainer.appendChild(card);

                    // add per-job certificate link to serverCertLinks (if present)
                    try {
                        if (j.HAS_CERT || j.has_cert || j.HAS_CERT === 1) {
                            const jc = document.getElementById('jobCertLinks');
                            if (jc) {
                                const rawId = j.id || j.ID || j.job_id || '';
                                const idStr = rawId !== null && rawId !== undefined ? String(rawId).trim() : '';
                                if (/^[A-Za-z0-9_\-]+$/.test(idStr)) {
                                    const a = document.createElement('a');
                                    a.href = '/db/get-job-cert-file.php?id=' + encodeURIComponent(idStr);
                                    a.target = '_blank';
                                    a.rel = 'noopener';
                                    a.className = 'text-blue-600 underline';
                                    const label = (j.job_title || j.job_title === 0) ? (j.job_title + ' — Certificate') : ('Work Experience ' + idStr + ' — Certificate');
                                    a.textContent = label + ' — View / Download';
                                    a.setAttribute('download', 'workexp_' + idStr + '.pdf');
                                    jc.appendChild(a);
                                }
                            }
                        }
                    } catch(e) { /* non-critical */ }
                });

                // After rendering jobs, show serverCertLinks if any job cert anchors were appended
                try {
                    const sLinks = document.getElementById('serverCertLinks');
                    const jLinks = document.getElementById('jobCertLinks');
                    if (sLinks && jLinks && jLinks.children.length > 0) sLinks.style.display = '';
                } catch(e) { /* ignore */ }
            }
        }
    })
    .catch(err => console.error('profile/work fetch error', err));

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editEducationBtn');
    const eduSpan = document.getElementById('educationLevel');
    const schoolSpan = document.getElementById('schoolName');
    const eduSelect = document.getElementById('edit_edu_select');
    const schoolInput = document.getElementById('edit_school_input');

    if (!editBtn) return;

    function enterEditMode() {
        // If we have rendered education cards, make them editable in-place
        const list = document.getElementById('educationList');
        if (list && list.children && list.children.length) {
            Array.from(list.children).forEach((card, idx) => {
                // replace value divs with inputs
                const eVal = card.querySelector('.edu-val');
                const sVal = card.querySelector('.school-val');
                const cVal = card.querySelector('.course-val');
                const ysVal = card.querySelector('.ys-val');
                const yeVal = card.querySelector('.ye-val');

                if (eVal) {
                    const txt = (eVal.textContent||'').trim();
                    const inp = document.createElement('input');
                    inp.type = 'text'; inp.className = 'edu-input w-full rounded-lg p-2 border'; inp.value = txt === '-' ? '' : txt;
                    eVal.replaceWith(inp);
                }
                if (sVal) {
                    const txt = (sVal.textContent||'').trim();
                    const inp = document.createElement('input');
                    inp.type = 'text'; inp.className = 'school-input w-full rounded-lg p-2 border'; inp.value = txt === '-' ? '' : txt;
                    sVal.replaceWith(inp);
                }
                if (cVal) {
                    const txt = (cVal.textContent||'').trim();
                    const inp = document.createElement('input');
                    inp.type = 'text'; inp.className = 'course-input w-full rounded-lg p-2 border'; inp.value = txt === '-' ? '' : txt;
                    cVal.replaceWith(inp);
                }
                if (ysVal) {
                    const txt = (ysVal.textContent||'').trim();
                    const inp = document.createElement('input');
                    inp.type = 'text'; inp.className = 'ys-input w-full rounded-lg p-2 border'; inp.value = txt === '-' ? '' : txt;
                    ysVal.replaceWith(inp);
                }
                if (yeVal) {
                    const txt = (yeVal.textContent||'').trim();
                    const inp = document.createElement('input');
                    inp.type = 'text'; inp.className = 'ye-input w-full rounded-lg p-2 border'; inp.value = txt === '-' ? '' : txt;
                    yeVal.replaceWith(inp);
                }
            });
            // open certificates editor as well (if available)
            try { if (typeof window.__mvsg_enterCerts === 'function') window.__mvsg_enterCerts(); } catch(e){}
            editBtn.textContent = '💾 Save';
            editBtn.dataset.editing = '1';
            return;
        }

        // fallback to legacy summary editor when no cards present
        const cur = (eduSpan && eduSpan.textContent || '').trim();
        let matched = false;
        Array.from(eduSelect.options).forEach(opt => {
            if (opt.value.toLowerCase() === cur.toLowerCase() || opt.text.toLowerCase() === cur.toLowerCase()) {
                opt.selected = true;
                matched = true;
            }
        });
        if (!matched && cur) {
            const tmp = document.createElement('option');
            tmp.value = cur;
            tmp.text = cur;
            tmp.selected = true;
            eduSelect.prepend(tmp);
        }
        schoolInput.value = (schoolSpan && schoolSpan.textContent || '').trim() === '-' ? '' : (schoolSpan && schoolSpan.textContent || '').trim();

        eduSelect.classList.remove('hidden'); eduSelect.style.display = '';
        schoolInput.classList.remove('hidden'); schoolInput.style.display = '';
        if (eduSpan) eduSpan.classList.add('hidden'); if (schoolSpan) schoolSpan.classList.add('hidden');

        try { setTimeout(() => { if (typeof window.__mvsg_enterCerts === 'function') window.__mvsg_enterCerts(); }, 40); } catch(e){}
        editBtn.textContent = '💾 Save';
        editBtn.dataset.editing = '1';
    }

    async function exitEditModeAndSave() {
        editBtn.disabled = true;
        // if editing cards, collect from inputs
        const list = document.getElementById('educationList');
        let payload = {};
        if (list && list.children && list.children.length) {
            const eduArr = [];
            const schoolArr = [];
            const courseArr = [];
            const ysArr = [];
            const yeArr = [];
            Array.from(list.children).forEach(card => {
                const eIn = card.querySelector('.edu-input');
                const sIn = card.querySelector('.school-input');
                const cIn = card.querySelector('.course-input');
                const ysIn = card.querySelector('.ys-input');
                const yeIn = card.querySelector('.ye-input');
                eduArr.push(eIn ? (eIn.value || '') : '');
                schoolArr.push(sIn ? (sIn.value || '') : '');
                courseArr.push(cIn ? (cIn.value || '') : '');
                ysArr.push(ysIn ? (ysIn.value || '') : '');
                yeArr.push(yeIn ? (yeIn.value || '') : '');
            });
            payload.education = eduArr;
            payload.school = schoolArr;
            payload.education_course = courseArr;
            payload.year_start = ysArr;
            payload.year_end = yeArr;
            if (typeof window.__mvsg_collectEditedCerts === 'function') {
                try { const cs = window.__mvsg_collectEditedCerts(); if (cs && cs.length) payload.certificates = cs; } catch(e){}
            }
        } else {
            // fallback: legacy single-field editor
            const newEdu = (eduSelect.value || '').trim();
            const newSchool = (schoolInput.value || '').trim();
            payload = { education: newEdu, school: newSchool };
            if (typeof window.__mvsg_collectEditedCerts === 'function') {
                try { const cs = window.__mvsg_collectEditedCerts(); if (cs && cs.length) payload.certificates = cs; } catch(e){}
            }
        }
        if (window.__mvsg_guardian_id) payload.guardian_id = window.__mvsg_guardian_id;

        try {
            const r = await fetch('/db/editprofile-2.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json; charset=utf-8' },
                body: JSON.stringify(payload)
            });
            const j = await r.json();
            if (j && j.success) {
                // if edited cards, update UI: replace inputs back to value divs
                if (list && list.children && list.children.length) {
                    Array.from(list.children).forEach(card => {
                        const eIn = card.querySelector('.edu-input');
                        const sIn = card.querySelector('.school-input');
                        const cIn = card.querySelector('.course-input');
                        const ysIn = card.querySelector('.ys-input');
                        const yeIn = card.querySelector('.ye-input');
                        if (eIn) {
                            const d = document.createElement('div'); d.className = 'w-full rounded-lg p-3 text-gray-800 edu-val'; d.textContent = eIn.value || '-'; eIn.replaceWith(d);
                        }
                        if (sIn) {
                            const d = document.createElement('div'); d.className = 'w-full rounded-lg p-3 text-gray-800 school-val'; d.textContent = sIn.value || '-'; sIn.replaceWith(d);
                        }
                        if (cIn) {
                            const d = document.createElement('div'); d.className = 'w-full rounded-lg p-3 text-gray-800 course-val'; d.textContent = cIn.value || '-'; cIn.replaceWith(d);
                        }
                        if (ysIn) {
                            const d = document.createElement('div'); d.className = 'w-full rounded-lg p-3 text-gray-800 ys-val'; d.textContent = ysIn.value || '-'; ysIn.replaceWith(d);
                        }
                        if (yeIn) {
                            const d = document.createElement('div'); d.className = 'w-full rounded-lg p-3 text-gray-800 ye-val'; d.textContent = yeIn.value || '-'; yeIn.replaceWith(d);
                        }
                    });
                } else {
                    // fallback update summary
                    if (eduSpan) eduSpan.textContent = (Array.isArray(payload.education) ? (payload.education[0]||'-') : (payload.education||'-')) || '-';
                    if (schoolSpan) schoolSpan.textContent = (Array.isArray(payload.school) ? (payload.school[0]||'-') : (payload.school||'-')) || '-';
                }
                // refresh server certs list if available
                if (window.__mvsg_guardian_id && typeof window.__mvsg_renderDBCerts === 'function') window.__mvsg_renderDBCerts(window.__mvsg_guardian_id);
            } else {
                alert('Unable to save education/certificates.');
                console.warn('save failed', j);
            }
        } catch (err) {
            console.error('Save error', err);
            alert('Unable to save education/certificates.');
        } finally {
            try { if (typeof window.__mvsg_exitCerts === 'function') window.__mvsg_exitCerts(false); } catch(e){}
            // ensure legacy editors hidden
            try { eduSelect.classList.add('hidden'); eduSelect.style.display = 'none'; } catch(e){}
            try { schoolInput.classList.add('hidden'); schoolInput.style.display = 'none'; } catch(e){}
            try { if (eduSpan) eduSpan.classList.remove('hidden'); if (schoolSpan) schoolSpan.classList.remove('hidden'); } catch(e){}
            editBtn.textContent = 'Edit';
            editBtn.dataset.editing = '0';
            editBtn.disabled = false;
        }
    }

    editBtn.addEventListener('click', (ev) => {
        const isEditing = editBtn.dataset.editing === '1';
        if (!isEditing) enterEditMode();
        else exitEditModeAndSave();
    });
});
</script>

<!-- Replace previous localStorage-only cert editor with server-backed editor -->
<script>
(function(){
    const certsList = document.getElementById('certsList');
    const noCertsMsg = document.getElementById('noCertsMsg');
    const certsEdit = document.getElementById('certsEdit');
    const certsContainer = document.getElementById('certs_container');
    const addCertEntryBtn = document.getElementById('addCertEntryBtn');
    const cancelCertsBtn = document.getElementById('cancelCertsBtn');
    const certTemplate = document.getElementById('cert_template');

    function escapeHtml(s){ if (s===null||s===undefined) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    function buildEditEntry(data) {
        const node = certTemplate.content.firstElementChild.cloneNode(true);
        const nameInput = node.querySelector('.cert-name');
        const issuerInput = node.querySelector('.cert-issuer');
        const dateInput = node.querySelector('.cert-date');
        const descInput = node.querySelector('.cert-desc');
        const fileInput = node.querySelector('.cert-file-input');
        const fileNameSpan = node.querySelector('.cert-file-name');
        const fileDataHidden = node.querySelector('.cert-file-data');
        if (data) {
            nameInput.value = data.NAME || data.certificate_name || data.name || '';
            issuerInput.value = data.ISSUED_BY || data.issued_by || data.issuer || '';
            const rawDate = data.DATE_COMPLETED || data.date_completed || data.date || '';
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
            descInput.value = data.WHAT_LEARNED || data.what_learned || data.training_description || data.what_you_learned || '';
        }
        // show existing server-side file indicator when present
        if (data && (data.HAS_CERT || data.has_cert || data.HAS_CERT === 1) && (data.ID || data.id)) {
            const id = data.ID || data.id;
            const a = document.createElement('a');
            a.href = '/db/get-guardian-cert-file.php?cert_id=' + encodeURIComponent(id);
            a.target = '_blank';
            a.className = 'inline-block text-sm text-green-700 mr-3';
            a.textContent = 'View existing file';
            fileNameSpan.parentNode.insertBefore(a, fileNameSpan);
        }

        // wire file input -> hidden base64 data
        if (fileInput) {
            fileInput.addEventListener('change', (ev) => {
                const f = fileInput.files && fileInput.files[0];
                if (!f) { fileNameSpan.textContent = ''; fileDataHidden.value = ''; return; }
                fileNameSpan.textContent = f.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    // store data URL so server can accept it as-is
                    fileDataHidden.value = e.target.result || '';
                };
                reader.readAsDataURL(f);
            });
        }
        node.querySelector('.remove-cert').addEventListener('click', () => node.remove());
        return node;
    }

    function enterEditMode() {
        const gid = window.__mvsg_guardian_id;
        certsContainer.innerHTML = '';
        // load current DB certs to populate editor
        fetch('/db/get-guardian-certs.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ guardian_id: gid })
        }).then(r => r.json()).then(j => {
            const arr = (j && j.success && Array.isArray(j.certificates)) ? j.certificates : [];
            if (!arr.length) certsContainer.appendChild(buildEditEntry({}));
            else arr.forEach(it => certsContainer.appendChild(buildEditEntry(it)));
            certsEdit.classList.remove('hidden');
            if (certsList) certsList.style.display = 'none';
            if (noCertsMsg) noCertsMsg.style.display = 'none';
            // Removed automatic focus to avoid placing the typing cursor immediately when Edit is clicked.
            // Users can click into fields or press Tab to focus inputs intentionally.
        }).catch(e => {
            certsContainer.appendChild(buildEditEntry({}));
            certsEdit.classList.remove('hidden');
            if (certsList) certsList.style.display = 'none';
            if (noCertsMsg) noCertsMsg.style.display = 'none';
        });
    }

    function collectEditedCerts() {
        if (!certsContainer) return [];
        const entries = Array.from(certsContainer.querySelectorAll('.cert-entry'));
        const out = entries.map(el => {
            const get = cls => (el.querySelector('.' + cls) && el.querySelector('.' + cls).value) ? el.querySelector('.' + cls).value.trim() : '';
            const obj = {
                certificate_name: get('cert-name'),
                issued_by: get('cert-issuer'),
                date_completed: get('cert-date'),
                training_description: get('cert-desc')
            };
            // include file if user selected one
            const fdata = (el.querySelector('.cert-file-data') && el.querySelector('.cert-file-data').value) ? el.querySelector('.cert-file-data').value.trim() : '';
            if (fdata) obj.certificate = fdata;
            if (!obj.certificate_name && !obj.issued_by && !obj.date_completed && !obj.training_description) return null;
            return obj;
        }).filter(Boolean);
        return out;
    }

    function exitEditMode(save) {
        const gid = window.__mvsg_guardian_id;
        if (save) {
            // save is handled by main Save handler; do nothing here
            return;
        }
        // cancel: simply close editor and reveal the existing list (do not re-fetch to avoid duplicate appends)
        certsEdit.classList.add('hidden');
        if (certsList) certsList.style.display = '';
        // do NOT call window.__mvsg_renderDBCerts here to avoid concurrent duplicate rendering
    }

    // API
    window.__mvsg_enterCerts = enterEditMode;
    window.__mvsg_exitCerts = exitEditMode;
    window.__mvsg_collectEditedCerts = collectEditedCerts;

    if (addCertEntryBtn) addCertEntryBtn.addEventListener('click', () => { certsContainer.appendChild(buildEditEntry({})); });
    if (cancelCertsBtn) cancelCertsBtn.addEventListener('click', () => { exitEditMode(false); });
})();
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Work editor DOM builders & handlers
    const reviewJobs = document.getElementById('review_job_experiences');
    const reviewWorkList = document.getElementById('review_work_list');
    const openWorkEditorBtn = document.getElementById('openWorkEditorBtn');
    const editWorkBtn = document.getElementById('editWorkBtn');

    // lazy-created panel refs
    let workEditPanel = null;
    let workContainer = null;
    let editWorkSelect = null;

    function createWorkEditPanel() {
        if (workEditPanel) return workEditPanel;
        const panel = document.createElement('div');
        panel.id = 'workEditPanel';
        panel.className = 'bg-white border rounded-lg p-6 shadow mt-4';
        panel.style.maxWidth = '900px';

        panel.innerHTML = `
            <div class="mb-4">
                <label class="block text-lg font-semibold mb-2">Type of Work</label>
                <select id="edit_work_select" class="w-full border rounded px-3 py-2">
                    <option value="">-- Select type --</option>
                            <option value="paid">Paid</option>
                            <option value="volunteer">Volunteer</option>
                            <option value="internship">Internship</option>
                            <option value="none">No, this would be my first time</option>
                </select>
            </div>
            <div id="work_entries" class="space-y-4 mb-4"></div>
            <template id="job_entry_template">
                <div class="job-edit-entry bg-white border border-gray-200 rounded-lg p-4 relative">
                    <button type="button" class="remove-job absolute top-3 right-3 text-sm bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" class="job-edit-company mt-1 w-full border rounded px-2 py-1" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Job Title</label>
                            <input type="text" class="job-edit-title mt-1 w-full border rounded px-2 py-1" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Location</label>
                            <input type="text" class="job-edit-location mt-1 w-full border rounded px-2 py-1" placeholder="City / Municipality" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Start Month</label>
                            <select class="job-edit-start-month mt-1 w-full border rounded px-2 py-1">
                                <option value="">--</option>
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Start Year</label>
                            <input type="text" maxlength="4" inputmode="numeric" class="job-edit-start-year mt-1 w-full border rounded px-2 py-1" placeholder="YYYY" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">End Month</label>
                            <select class="job-edit-end-month mt-1 w-full border rounded px-2 py-1">
                                <option value="">--</option>
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">End Year</label>
                            <input type="text" maxlength="4" inputmode="numeric" class="job-edit-end-year mt-1 w-full border rounded px-2 py-1" placeholder="YYYY or 'Present'" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Description</label>
                            <input type="text" class="job-edit-desc mt-1 w-full border rounded px-2 py-1" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Certificate File</label>
                            <div class="mt-1 flex items-center gap-2">
                                <input type="file" accept=".pdf,image/*" class="job-edit-file-input" />
                                <span class="job-edit-file-name text-sm text-gray-600"></span>
                            </div>
                            <input type="hidden" class="job-edit-file-data" />
                        </div>
                    </div>
                </div>
            </template>
            <div class="flex gap-3 mt-4">
                <button id="addJobEntryBtn" type="button" class="bg-indigo-600 text-white px-4 py-2 rounded-md">＋ Add Another Job</button>
                <button id="cancelWorkBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
            </div>
        `;

        // attach to container area (after reviewJobs)
        if (reviewJobs && reviewJobs.parentNode) {
            reviewJobs.parentNode.insertBefore(panel, reviewJobs.nextSibling);
        } else {
            // fallback append to main section
            document.querySelector('main')?.appendChild(panel);
        }

        workEditPanel = panel;
        workContainer = panel.querySelector('#work_entries');
        editWorkSelect = panel.querySelector('#edit_work_select');

        // handlers
        panel.querySelector('#addJobEntryBtn').addEventListener('click', () => {
            workContainer.appendChild(buildJobEntry({}));
        });
        panel.querySelector('#cancelWorkBtn').addEventListener('click', () => {
            exitWorkEdit(false);
        });

        return panel;
    }

    function buildJobEntry(data) {
        const tpl = document.getElementById('job_entry_template');
        const node = tpl.content.firstElementChild.cloneNode(true);
        node.querySelector('.job-edit-company').value = data.company_name || data.company || '';
        node.querySelector('.job-edit-title').value = data.job_title || data.title || '';
        // populate start/end month/year from available sources (prefer start_date/end_date)
        const startMonthEl = node.querySelector('.job-edit-start-month');
        const startYearEl = node.querySelector('.job-edit-start-year');
        const endMonthEl = node.querySelector('.job-edit-end-month');
        const endYearEl = node.querySelector('.job-edit-end-year');
        let sMonth = '';
        let sYear = '';
        let eMonth = '';
        let eYear = '';
        try {
            if (data.start_date) {
                const d = new Date(data.start_date);
                if (!isNaN(d)) { sMonth = String(d.getMonth() + 1); sYear = String(d.getFullYear()); }
            }
        } catch (e) {}
        if (!sYear) {
            sMonth = (data.start_month || data.startMonth || data.start || '') + '';
            sYear = (data.start_year || data.startYear || data.year || data.work_year || '') + '';
        }
        try {
            if (data.end_date) {
                const d2 = new Date(data.end_date);
                if (!isNaN(d2)) { eMonth = String(d2.getMonth() + 1); eYear = String(d2.getFullYear()); }
            }
        } catch (e) {}
        if (!eYear) {
            eMonth = (data.end_month || data.endMonth || '') + '';
            eYear = (data.end_year || data.endYear || '') + '';
        }
        if (startMonthEl) startMonthEl.value = (sMonth || '').toString();
        if (startYearEl) startYearEl.value = (sYear || '').toString();
        if (endMonthEl) endMonthEl.value = (eMonth || '').toString();
        if (endYearEl) endYearEl.value = (eYear || '').toString();
        node.querySelector('.job-edit-desc').value = data.job_description || data.description || '';
        // populate location when present
        try {
            const locEl = node.querySelector('.job-edit-location');
            if (locEl) locEl.value = data.company_location || data.location || data.company_city || '';
        } catch (e) {}
        // wire remove
        node.querySelector('.remove-job').addEventListener('click', () => node.remove());

        // file input wiring: convert selected file to data URL and store in hidden input
        const fileInput = node.querySelector('.job-edit-file-input');
        const fileNameSpan = node.querySelector('.job-edit-file-name');
        const fileDataHidden = node.querySelector('.job-edit-file-data');
        if (fileInput) {
            fileInput.addEventListener('change', (ev) => {
                const f = fileInput.files && fileInput.files[0];
                if (!f) { fileNameSpan.textContent = ''; fileDataHidden.value = ''; return; }
                fileNameSpan.textContent = f.name;
                const reader = new FileReader();
                reader.onload = function(e) { fileDataHidden.value = e.target.result || ''; };
                reader.readAsDataURL(f);
            });
        }
        // if existing server-side cert present, show link
        if (data && (data.HAS_CERT || data.has_cert || data.HAS_CERT === 1) && (data.ID || data.id)) {
            const id = data.ID || data.id;
            const a = document.createElement('a');
            a.href = '/db/get-job-cert-file.php?id=' + encodeURIComponent(id);
            a.target = '_blank';
            a.className = 'inline-block text-sm text-blue-700 mr-3';
            a.textContent = 'View existing file';
            fileNameSpan.parentNode.insertBefore(a, fileNameSpan);
        }
        return node;
    }

    async function enterWorkEdit() {
        createWorkEditPanel();
        // clear existing entries
        workContainer.innerHTML = '';
        if (reviewJobs) reviewJobs.style.display = 'none';
        if (reviewWorkList) reviewWorkList.style.display = 'none';

        const gid = window.__mvsg_guardian_id;
        try {
            const res = await fetch('/db/get-user-work.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ guardian_id: gid })
            });
            const j = await res.json();
            const profiles = j.profiles || {};
            const jobs = j.job_experience_rows || [];

            // set work type if provided (profiles.work_experience may be array)
            const we = Array.isArray(profiles.work_experience) ? (profiles.work_experience[0] || '') : (profiles.work_experience || '');
            if (we) editWorkSelect.value = String(we).toLowerCase();
            else editWorkSelect.value = '';

            if (!jobs.length) {
                workContainer.appendChild(buildJobEntry({}));
            } else {
                jobs.forEach(row => workContainer.appendChild(buildJobEntry(row)));
            }
        } catch (e) {
            // fallback empty entry
            workContainer.appendChild(buildJobEntry({}));
        }

        workEditPanel.classList.remove('hidden');
        editWorkBtn && editWorkBtn.setAttribute('data-editing','1');
        editWorkBtn && (editWorkBtn.textContent = '💾 Save');
    }

    async function exitWorkEdit(save) {
        createWorkEditPanel();
        const sel = editWorkSelect ? String(editWorkSelect.value).trim() : '';
        if (save) {
            // collect entries
                const entries = Array.from(workContainer.querySelectorAll('.job-edit-entry'));
            const out = entries.map(node => {
                const company = node.querySelector('.job-edit-company')?.value?.trim() || '';
                const title = node.querySelector('.job-edit-title')?.value?.trim() || '';
                const start_month = node.querySelector('.job-edit-start-month')?.value?.trim() || '';
                const start_year = node.querySelector('.job-edit-start-year')?.value?.trim() || '';
                const end_month = node.querySelector('.job-edit-end-month')?.value?.trim() || '';
                const end_year = node.querySelector('.job-edit-end-year')?.value?.trim() || '';
                const desc = node.querySelector('.job-edit-desc')?.value?.trim() || '';
                const company_location = node.querySelector('.job-edit-location')?.value?.trim() || '';
                const certData = node.querySelector('.job-edit-file-data')?.value?.trim() || '';
                if (!company && !title && !start_year && !desc) return null;
                const obj = { company: company, title: title, company_location: company_location || undefined, start_month: start_month, start_year: start_year, end_month: end_month, end_year: end_year, description: desc };
                if (certData) obj.certificate = certData;
                return obj;
            }).filter(Boolean);

            const payload = { job_experiences: out, work_type: sel };
            if (window.__mvsg_guardian_id) payload.guardian_id = window.__mvsg_guardian_id;

            // disable inputs during save
            workEditPanel.querySelectorAll('input,button,select').forEach(n => n.disabled = true);
            if (editWorkBtn) { editWorkBtn.disabled = true; editWorkBtn.dataset.saving = '1'; }
            // LOG PAYLOAD FOR DEBUGGING — place here, right before the fetch
            console.log('Saving work payload', payload);
            try {
                const r = await fetch('/db/editprofile-2.php', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/json; charset=utf-8' },
                    body: JSON.stringify(payload)
                });

                // try to parse JSON even on non-200 to get details
                let j = null;
                try { j = await r.json(); } catch(e) { j = { success: false, error: 'Invalid JSON response', details: (await r.text()).slice(0,2000) }; }
                if (r.ok && j && j.success) {
                    try {
                        // update job list UI (existing code)...
                        if (reviewJobs) {
                            reviewJobs.innerHTML = '';
                            if (!out.length) {
                                const p = document.createElement('p');
                                p.className = 'text-gray-600 italic';
                                p.textContent = 'No job experiences added.';
                                reviewJobs.appendChild(p);
                            } else {
                                out.forEach(it => {
                                    const card = document.createElement('div');
                                    card.className = 'mb-3 p-3 border rounded-md bg-white shadow-sm';
                                    const title = (it.company || '') + (it.title ? ' — ' + it.title : '');
                                    // format period
                                    const monthNames = ['', 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                                    let meta = '';
                                    if (it.start_year) {
                                        if (it.start_month && monthNames[parseInt(it.start_month)]) meta += monthNames[parseInt(it.start_month)] + ' ' + it.start_year;
                                        else meta += it.start_year;
                                    }
                                    if (it.end_year) {
                                        const end = (it.end_month && monthNames[parseInt(it.end_month)]) ? (monthNames[parseInt(it.end_month)] + ' ' + it.end_year) : it.end_year;
                                        meta += (meta ? ' — ' : '') + end;
                                    }
                                    const desc = (it.description || '');
                                    const loc = it.company_location ? '<div class="text-sm text-gray-500 mt-1">' + escapeHtml(it.company_location) + '</div>' : '';
                                    card.innerHTML = '<div class="font-semibold">' + escapeHtml(title) + '</div>' +
                                                    '<div class="text-sm text-gray-600">' + escapeHtml(meta) + '</div>' + loc +
                                                    '<div class="text-sm text-gray-700 mt-2">' + escapeHtml(desc) + '</div>';
                                    reviewJobs.appendChild(card);
                                });
                            }
                        }

                        // update work badge UI
                        if (reviewWorkList) {
                            reviewWorkList.innerHTML = '';
                            if (!sel || sel === '') reviewWorkList.innerHTML = '<span class="text-gray-600">-</span>';
                            else if (sel === 'none') reviewWorkList.innerHTML = '<span class="text-gray-600">N/A</span>';
                            else {
                                const span = document.createElement('span');
                                span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                                span.textContent = sel.charAt(0).toUpperCase() + sel.slice(1);
                                reviewWorkList.appendChild(span);
                            }
                        }

                        // ensure editor is closed and review is visible
                        if (workEditPanel) workEditPanel.classList.add('hidden');
                        if (reviewJobs) reviewJobs.style.display = '';
                        if (reviewWorkList) reviewWorkList.style.display = '';

                        // restore Edit button to normal state
                        if (editWorkBtn) {
                            editWorkBtn.dataset.editing = '0';
                            editWorkBtn.dataset.saving = '0';
                            editWorkBtn.disabled = false;
                            editWorkBtn.textContent = 'Edit';
                        }
                    } catch (uiErr) {
                        console.warn('UI update after save failed', uiErr);
                        // fallback: ensure button returns to Edit so user isn't stuck
                        if (editWorkBtn) {
                            editWorkBtn.dataset.editing = '0';
                            editWorkBtn.dataset.saving = '0';
                            editWorkBtn.disabled = false;
                            editWorkBtn.textContent = 'Edit';
                        }
                    }
                } else {
                    // show server-provided error details when available
                    console.error('Save failed', r.status, j);
                    const msg = (j && (j.error || j.details)) ? (j.error || j.details) : ('HTTP ' + r.status);
                    alert('Unable to save work experience.\n' + String(msg));
                }
            } catch (err) {
                console.error('Save network/error', err);
                alert('Unable to save work experience.\nNetwork or unexpected error occurred.');
            } finally {
                // always restore UI state so button doesn't stay stuck
                try { workEditPanel.querySelectorAll('input,button,select').forEach(n => n.disabled = false); } catch(e){}
                if (editWorkBtn) {
                    editWorkBtn.disabled = false;
                    editWorkBtn.dataset.saving = '0';
                    // always return button to Edit (so user can retry or re-enter)
                    editWorkBtn.dataset.editing = '0';
                    editWorkBtn.textContent = 'Edit';
                }
            }
            return;
        }

        // cancel
        workEditPanel.classList.add('hidden');
        if (reviewJobs) reviewJobs.style.display = '';
        if (reviewWorkList) reviewWorkList.style.display = '';
        if (editWorkBtn) { editWorkBtn.dataset.editing = '0'; editWorkBtn.textContent = 'Edit'; }
    }

    // wire buttons
    if (openWorkEditorBtn) openWorkEditorBtn.addEventListener('click', (e) => {
        e && e.preventDefault();
        enterWorkEdit();
        if (editWorkBtn) { editWorkBtn.dataset.editing = '1'; editWorkBtn.textContent = '💾 Save'; }
    });

    if (editWorkBtn) editWorkBtn.addEventListener('click', (e) => {
        e && e.preventDefault();
        const isEditing = editWorkBtn.dataset.editing === '1';
        if (!isEditing) {
            enterWorkEdit();
        } else {
            // trigger save
            exitWorkEdit(true);
        }
    });

    // expose APIs (optional)
    window.__mvsg_enterWork = enterWorkEdit;
    window.__mvsg_exitWork = exitWorkEdit;
});
</script>
<script>
/* make escapeHtml globally available for all handlers */
window.escapeHtml = function (s) {
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>"']/g, function (c) {
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c];
    });
};
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // WORK ENVIRONMENT modal wiring + save -> POST /db/editprofile-2.php (upsert USER_PROFILE TYPE='workplace')
    const envModal = document.getElementById('editEnvironmentModal');
    const saveEnvBtn = document.getElementById('saveEnvironmentEdit');
    const closeEnvBtn = document.getElementById('closeEnvironmentModal');
    const workplaceOptions = () => Array.from(document.querySelectorAll('.workplace-option'));
    const reviewWorkplaceList = document.getElementById('review_workplace_list');

    function collectSelectedWorkplace() {
        return workplaceOptions()
            .filter(c => c.classList.contains('selected') || c.classList.contains('selected-card'))
            .map(c => (c.dataset.value || c.querySelector('h3')?.textContent || '').toString().trim())
            .filter(Boolean);
    }

    function renderWorkplacePills(vals) {
        if (!reviewWorkplaceList) return;
        reviewWorkplaceList.innerHTML = '';
        if (!vals || !vals.length) { reviewWorkplaceList.innerHTML = '<span class="text-gray-600">-</span>'; return; }
        vals.forEach(v => {
            const span = document.createElement('span');
            span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
            span.textContent = String(v).charAt(0).toUpperCase() + String(v).slice(1);
            reviewWorkplaceList.appendChild(span);
        });
    }

    if (closeEnvBtn) closeEnvBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (!envModal) return;
        envModal.classList.add('opacity-0');
        setTimeout(()=> envModal.classList.add('hidden'), 220);
    });

    if (saveEnvBtn) saveEnvBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        const vals = collectSelectedWorkplace();
        // disable while saving
        saveEnvBtn.disabled = true;
        saveEnvBtn.textContent = 'Saving...';
        const payload = { workplace: vals };
        if (window.__mvsg_guardian_id) payload.guardian_id = window.__mvsg_guardian_id;
        try {
            const res = await fetch('/db/editprofile-2.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            let j = null;
            try { j = await res.json(); } catch(e) { j = { success:false, error: 'Invalid JSON response' }; }
            if (res.ok && j && j.success) {
                renderWorkplacePills(vals);
                // close modal
                envModal.classList.add('opacity-0');
                setTimeout(()=> envModal.classList.add('hidden'), 220);
            } else {
                console.error('Save workplace failed', j);
                alert('Unable to save preferred workplace.\n' + (j && (j.error||j.details) ? (j.error||j.details) : 'Server error'));
            }
        } catch (err) {
            console.error('Save workplace network error', err);
            alert('Unable to save preferred workplace. Network error.');
        } finally {
            saveEnvBtn.disabled = false;
            saveEnvBtn.textContent = 'Save Changes';
        }
    });

    // allow clicking cards in modal to toggle selection
    document.addEventListener('click', (ev) => {
        const card = ev.target && ev.target.closest && ev.target.closest('.workplace-option');
        if (!card) return;
        // ignore if clicked the TTS button inside the card
        if (ev.target && ev.target.classList && ev.target.classList.contains('tts-btn')) return;
        card.classList.toggle('selected');
        card.classList.toggle('selected-card');
    });

    // expose helper to open modal (used elsewhere)
    window.__mvsg_openWorkplaceModal = function(){
        if (!envModal) return;
        envModal.classList.remove('hidden');
        setTimeout(()=> envModal.classList.remove('opacity-0'), 10);
        // pre-mark cards from current review pills
        try {
            const pills = Array.from(reviewWorkplaceList?.querySelectorAll('span')||[]).map(s=> (s.textContent||'').trim().toLowerCase());
            workplaceOptions().forEach(c => {
                const val = ((c.dataset.value||c.querySelector('h3')?.textContent)||'').toString().trim().toLowerCase();
                if (pills.includes(val)) c.classList.add('selected','selected-card'); else c.classList.remove('selected','selected-card');
            });
        } catch(e){}
    };
    const editWorkplaceBtn = document.getElementById('editWorkplaceBtn');
    if (editWorkplaceBtn) {
        editWorkplaceBtn.addEventListener('click', (e) => {
            e && e.preventDefault();
            if (typeof window.__mvsg_openWorkplaceModal === 'function') {
                window.__mvsg_openWorkplaceModal();
            } else if (envModal) {
                envModal.classList.remove('hidden');
                setTimeout(()=> envModal.classList.remove('opacity-0'), 10);
            }
        });
    }
});
</script>
    </main>
@endsection
