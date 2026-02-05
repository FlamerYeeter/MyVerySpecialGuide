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
                        <h1 id="profile_fullname" class="text-2xl font-semibold">Juan Dela Cruz</h1>
                        <p id="profile_location" class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" class="w-7 h-7">
                            <span id="profile_location_text">Taguig City, Metro Manila</span>
                        </p>
                        <p class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" class="w-6 h-6">
                            <span id="profile_header_email">juandelacruz@gmail.com</span>
                        </p>
                    </div>
                </div>

                <div class="p-10 space-y-14">

<!-- Education Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Education</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Education Level -->
                            <div>
                                <label class="block text-lg font-semibold mb-3">Education Level:</label>

                                <!-- Display Mode -->
                                <span id="educationLevel" class="block"></span>

                                <!-- Edit Mode -->
                                <select id="edit_edu_select" class="hidden w-full border rounded px-3 py-2">
                                    <option value="College">College</option>
                                    <option value="Vocational/Training">Vocational/Training</option>
                                    <option value="High School">High School</option>
                                    <option value="Elementary">Elementary</option>
                                </select>
                            </div>

<!-- School Name -->
                            <div class="col-span-2">
                                <label class="block text-lg font-semibold mb-3">School Name:</label>

                                <!-- Display Mode -->
                                <span id="schoolName" class="block"></span>

                                <!-- Edit Mode -->
                                <input type="text" id="edit_school_input"
                                    class="hidden w-full border rounded px-3 py-2" />
                            </div>
                        </div>

                        <!-- Certificates: match layout/column sizing used by Job Experiences -->
                        <div class="mt-6 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="col-span-1">
                                <label class="block text-lg font-semibold mb-3">Certificates & Trainings
                                </label>

                                    <div id="certificateReview" class="mt-2 text-gray-800">
                                        <div id="certsList" class="space-y-2"></div>
                                        <div id="noCertsMsg" class="text-gray-600 italic">No certificates or trainings added.</div>

                                        <!-- View/Download links for server-stored files -->
                                        <div id="fileLinks" class="mt-3 space-x-4" style="display:none;">
                                            <a id="proofFileLink" class="text-blue-600 underline" target="_blank" rel="noopener" href="#">View / Download Proof of Membership</a>
                                            <a id="medFileLink" class="text-blue-600 underline" target="_blank" rel="noopener" href="#">View / Download Medical Certificate</a>
                                            <a id="otherFileLink" class="text-blue-600 underline" target="_blank" rel="noopener" href="#">View / Download Certificates</a>
                                        </div>

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
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
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
                                        <div id="review_work_list" class="flex flex-wrap gap-3 text-gray-800"></div>
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
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
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
                                        <div id="review_workplace_list" class="flex flex-wrap gap-3 text-gray-800"></div>
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
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
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
                        <p class="text-sm text-gray-500">(Pindutin ang <span class="text-blue-800 font-medium">"Next"</span>
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
        if (eduEl) eduEl.textContent = (u.EDUCATION_LEVEL || u.education || '-') || '-';
        if (schoolEl) schoolEl.textContent = (u.SCHOOL_NAME || u.school || '-') || '-';

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
                    card.className = 'mb-3 p-3 border rounded-md bg-white shadow-sm';
                    const title = name ? `<div class="font-semibold text-gray-800">${escapeHtml(name)}</div>` : '';
                    const meta = (issuer || date) ? `<div class="text-sm text-gray-600 mt-1">${escapeHtml(issuer)}${issuer && date ? ' • ' : ''}${date ? escapeHtml(fmtDate(date)) : ''}</div>` : '';
                    const desc = learned ? `<div class="text-sm text-gray-700 mt-2">${escapeHtml(learned)}</div>` : '';
                    card.innerHTML = title + meta + desc;
                    listEl.appendChild(card);
                });
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

        // Show view/download links for server-stored files if present in response
        try {
            const fileLinks = document.getElementById('fileLinks');
            const proofA = document.getElementById('proofFileLink');
            const medA = document.getElementById('medFileLink');
            const otherA = document.getElementById('otherFileLink');
            const files = json.files || {};
            const lengths = json.file_lengths || {};
            let shown = false;
            // Prefer inline base64 payloads returned in `json.files` when available.
            // Only show anchors with a valid href; force-download data: URLs.
            let anyShown = false;
            function setLink(a, dataB64, fallbackUrl, filename) {
                if (!a) return false;
                if (dataB64) {
                    a.href = 'data:application/octet-stream;base64,' + dataB64;
                    a.setAttribute('download', filename || 'file');
                    a.style.display = '';
                    // ensure clicking downloads instead of navigating in some browsers
                    a.addEventListener('click', function (ev) {
                        try {
                            if ((a.href || '').slice(0,5) === 'data:') {
                                ev.preventDefault();
                                const link = document.createElement('a');
                                link.href = a.href;
                                link.download = a.getAttribute('download') || filename || 'file';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        } catch (e) { /* ignore */ }
                    });
                    return true;
                }
                if (fallbackUrl && fallbackUrl.length) {
                    a.href = fallbackUrl;
                    a.removeAttribute('download');
                    a.style.display = '';
                    return true;
                }
                a.style.display = 'none';
                return false;
            }

            if (setLink(proofA, files.proof, (lengths.proof_len && lengths.proof_len > 0) ? '/db/get_file.php?type=proof' : '', 'proof.pdf')) anyShown = true;
            if (setLink(medA, files.med, (lengths.med_len && lengths.med_len > 0) ? '/db/get_file.php?type=med' : '', 'medical.pdf')) anyShown = true;
            if (setLink(otherA, files.other_certs, (lengths.other_len && lengths.other_len > 0) ? '/db/get_file.php?type=other' : '', 'certificates.pdf')) anyShown = true;

            if (fileLinks) fileLinks.style.display = anyShown ? '' : 'none';
            if (fileLinks) fileLinks.style.display = shown ? '' : 'none';
        } catch(e) { /* non-critical */ }


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
                    const meta = escapeHtml(j.years_experience || '') + (j.work_year ? ' • ' + escapeHtml(j.work_year) : '');
                    const desc = escapeHtml(j.job_description || '');
                    const env = j.working_environment ? '<div class="text-xs text-gray-500 mt-2">Environment: ' + escapeHtml(j.working_environment) + '</div>' : '';
                    card.innerHTML = '<div class="font-semibold">' + title + '</div>' +
                                     '<div class="text-sm text-gray-600">' + meta + '</div>' +
                                     '<div class="text-sm text-gray-700 mt-2">' + desc + '</div>' + env;
                    jobContainer.appendChild(card);
                });
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
        const cur = (eduSpan.textContent || '').trim();
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
        schoolInput.value = (schoolSpan.textContent || '').trim() === '-' ? '' : (schoolSpan.textContent || '').trim();

        eduSelect.classList.remove('hidden'); eduSelect.style.display = '';
        schoolInput.classList.remove('hidden'); schoolInput.style.display = '';
        eduSpan.classList.add('hidden'); schoolSpan.classList.add('hidden');

        // open certificates editor as well (if available)
        setTimeout(() => {
            if (typeof window.__mvsg_enterCerts === 'function') window.__mvsg_enterCerts();
        }, 40);

        editBtn.textContent = '💾 Save';
        editBtn.dataset.editing = '1';
    }

    async function exitEditModeAndSave() {
        const newEdu = (eduSelect.value || '').trim();
        const newSchool = (schoolInput.value || '').trim();
        editBtn.disabled = true;

        // collect certificates edited entries (if editor present)
        let certs = null;
        if (typeof window.__mvsg_collectEditedCerts === 'function') {
            try { certs = window.__mvsg_collectEditedCerts(); } catch(e){ certs = null; }
        }

        const payload = { education: newEdu, school: newSchool };
        if (certs !== null) payload.certificates = certs;
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
                if (eduSpan) eduSpan.textContent = newEdu || '-';
                if (schoolSpan) schoolSpan.textContent = newSchool || '-';
                if (window.__mvsg_guardian_id && typeof window.__mvsg_renderDBCerts === 'function') {
                    window.__mvsg_renderDBCerts(window.__mvsg_guardian_id);
                }
            } else {
                alert('Unable to save education/certificates.');
                console.warn('save failed', j);
            }
        } catch (err) {
            console.error('Save error', err);
            alert('Unable to save education/certificates.');
        } finally {
            // close editors
            if (typeof window.__mvsg_exitCerts === 'function') window.__mvsg_exitCerts(false);
            eduSelect.classList.add('hidden'); eduSelect.style.display = 'none';
            schoolInput.classList.add('hidden'); schoolInput.style.display = 'none';
            eduSpan.classList.remove('hidden'); schoolSpan.classList.remove('hidden');
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
                            <label class="text-sm font-medium text-gray-700">Start Year</label>
                            <input type="text" class="job-edit-year mt-1 w-full border rounded px-2 py-1" placeholder="YYYY or text" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Description</label>
                            <input type="text" class="job-edit-desc mt-1 w-full border rounded px-2 py-1" />
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
        node.querySelector('.job-edit-year').value = data.start_year || data.work_year || data.year || data.years_experience || '';
        node.querySelector('.job-edit-desc').value = data.job_description || data.description || '';
        node.querySelector('.remove-job').addEventListener('click', () => node.remove());
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
                const yearRaw = node.querySelector('.job-edit-year')?.value?.trim() || '';
                const desc = node.querySelector('.job-edit-desc')?.value?.trim() || '';
                const start_year = (/^\d{4}$/.test(yearRaw) ? yearRaw : yearRaw || '');
                if (!company && !title && !start_year && !desc) return null;
                return { company: company, title: title, start_year: start_year, description: desc };
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
                                    const meta = (it.start_year || '');
                                    const desc = (it.description || '');
                                    card.innerHTML = '<div class="font-semibold">' + escapeHtml(title) + '</div>' +
                                                    '<div class="text-sm text-gray-600">' + escapeHtml(meta) + '</div>' +
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
