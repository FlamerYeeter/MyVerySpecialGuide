<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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

        .selectable-card.selected::after,
        .jobpref-card.selected::after {
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
    onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerreview4') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-3 h-3 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug">
                Review Your Job Preferences
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
        </div>

        <!-- Instructions -->
        <div class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>
                <div class="flex-1 text-center sm:text-left">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        You can change your job preference by clicking the "Change" button.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Maaari mong baguhin ang iyong mga trabahong gusto sa pamamagitan ng pag-click sa button na
                        “Change”)
                    </p>
                </div>
            </div>
            <button type="button"
                class="tts-btn absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200"
                data-tts-en="You can change your job preference by clicking the Change button."
                data-tts-tl="Maaari mong baguhin ang iyong mga trabahong gusto sa pamamagitan ng pag-click sa button na Change"
                aria-label="Read instructions aloud in English then Filipino"></button>
        </div>


        <!-- Info Box -->
        <div class="relative bg-green-50 border border-green-300 text-green-800 rounded-xl p-5 sm:p-6 mt-6 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-green-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        We use your job preferences to connect you with the right job, but some choices may not be
                        hiring now.
                    </p>
                    <p class="italic text-gray-700 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Gagamitin namin ang iyong piniling trabaho upang mahanap ang angkop na posisyon, ngunit may
                        pagkakataon maaaring walang hiring sa posisyon na ito.)
                    </p>
                </div>
            </div>

            <!-- Audio Button -->
            <button type="button"
                class="tts-btn absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md 
           hover:bg-green-800 hover:scale-105 transition-transform duration-200"
                data-tts-en="We use your job preferences to connect you with the right job, but some choices may not be hiring now."
                data-tts-tl="Gagamitin namin ang iyong piniling trabaho upang mahanap ang angkop na posisyon, ngunit may pagkakataon maaaring walang hiring sa posisyon na ito."
                aria-label="Read this info aloud in English then Filipino"></button>
        </div>

        <!-- Job Preferences Section -->
        <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 mt-6">
            <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                Job Preferences Summary
            </h3>

            <!-- Job Preference Image -->
            <div id="review_jobprefs_img_container" class="mt-4 text-center" style="display:none;">
                <div
                    class="inline-flex items-center justify-center w-40 h-40 bg-gray-50 rounded-xl shadow-md p-2 mx-auto">
                    <img id="review_jobprefs_img" src="" alt="Job preference image"
                        class="w-full h-full object-contain rounded-md" />
                </div>
            </div>

            <!-- Job Preference List -->
            <div id="review_jobprefs_list" class="flex flex-wrap gap-3 mt-6">
                <!-- populated dynamically with job preference pills; intentionally left empty when none -->
            </div>

            <!-- Change Jobs -->
            <div class="flex justify-center mt-6">
                <button type="button" id="rv5_change_jobprefs_btn"
                    class="bg-[#2E2EFF] hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition-transform duration-200 hover:scale-105">
                    ✏️ Change
                </button>
            </div>
        </div>

        <!-- Continue Buttons -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">
            <button id="rv5_continue" type="button"
                class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
            px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
            shadow-md w-full sm:w-64 text-center">
                Continue →
            </button>
        </div>

        <!-- Helper Text -->
        <p class="text-gray-700 text-sm mt-4 text-center">
            Click <span class="text-[#1E40AF] font-medium">“Continue”</span> to move to the next page
        </p>
        <p class="text-gray-600 italic text-[13px] text-center">
            (Pindutin ang “Continue” upang magpatuloy)
        </p>
    </div>


    {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
    <script src="{{ asset('js/register.js') }}"></script>
    <script>
        // Focused helper: only extract explicit job preference arrays from the draft.
        (function(){
            window.tryParseMVSG = function(s){ try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
            window.getDraftJobPreferences = function(){
                try {
                    let draft = window.__mvsg_lastLoadedDraft || null;
                    if (!draft) {
                        const raw = localStorage.getItem('rpi_personal') || localStorage.getItem('registrationDraft') || localStorage.getItem('registerDraft') || sessionStorage.getItem('rpi_personal');
                        draft = raw ? window.tryParseMVSG(raw) : null;
                    }
                    const robustParseArray = (input) => {
                        try {
                            if (!input && input !== 0) return [];
                            // If already an array
                            if (Array.isArray(input)) return input.map(x=>String(x||'').trim()).filter(Boolean);
                            // Try repeated JSON.parse in case of double-stringified values
                            let cur = input;
                            for (let i=0;i<4;i++) {
                                if (cur === null || cur === undefined) return [];
                                if (Array.isArray(cur)) return cur.map(x=>String(x||'').trim()).filter(Boolean);
                                if (typeof cur !== 'string') break;
                                const s = cur.trim();
                                if (!s) return [];
                                try {
                                    cur = JSON.parse(s);
                                    continue;
                                } catch(e) {
                                    // not JSON — fall back
                                    break;
                                }
                            }
                            // If we reach here and cur is a string, split by comma safely
                            if (typeof cur === 'string') return cur.split(',').map(s=>s.trim()).filter(Boolean);
                            // If object with numeric/value fields, try to extract values
                            if (typeof cur === 'object' && cur !== null) {
                                const vals = [];
                                Object.values(cur).forEach(v => {
                                    if (Array.isArray(v)) v.forEach(x=>vals.push(String(x||'').trim()));
                                    else if (v !== undefined && v !== null) vals.push(String(v||'').trim());
                                });
                                return vals.filter(Boolean);
                            }
                        } catch(e) {}
                        return [];
                    };
                    // Only read these explicit keys. Do NOT attempt to flatten or iterate the entire draft object.
                    if (draft && draft.jobPreferences && draft.jobPreferences.jobpref1) return robustParseArray(draft.jobPreferences.jobpref1);
                    if (draft && draft.jobpref1) return robustParseArray(draft.jobpref1);
                    return [];
                } catch(e) { return []; }
            };
        })();
    </script>
    <script>
        // Early restore of job preferences from local draft so they appear even if populateReview runs later
        (function(){
            const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
            // Strictly normalize only known job-preference shapes. Do NOT fallback to Object.values on full draft objects.
            const normalizeToArray = v => {
                try {
                    if (!v) return [];
                    if (Array.isArray(v)) return v.map(x=>String(x||'').trim()).filter(Boolean);
                    if (typeof v === 'object') {
                        // Accept explicit jobpref1 arrays or nested jobPreferences.jobpref1
                        if (Array.isArray(v.jobpref1)) return v.jobpref1.map(x=>String(x||'').trim()).filter(Boolean);
                        if (v.jobPreferences && Array.isArray(v.jobPreferences.jobpref1)) return v.jobPreferences.jobpref1.map(x=>String(x||'').trim()).filter(Boolean);
                        // If the object is itself a stringified array stored as a value, try to parse specific known keys
                        if (typeof v.jobpref1 === 'string') {
                            try { return (JSON.parse(v.jobpref1) || []).map(x=>String(x||'').trim()).filter(Boolean); } catch(e){}
                        }
                        if (typeof v.jobPreferences === 'string') {
                            try { const p = tryParse(v.jobPreferences); if (p && p.jobpref1) return normalizeToArray(p.jobpref1); } catch(e){}
                        }
                        return [];
                    }
                    const s = String(v||'').trim(); if (!s) return [];
                    if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) return normalizeToArray(tryParse(s));
                    if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
                    return [s];
                } catch(e){ return []; }
            };

            // Heuristic validation to avoid treating a stringified personal-info blob as preferences
            const isLikelyJobPrefArray = (arr) => {
                try {
                    if (!Array.isArray(arr)) return false;
                    // sane size: 1-8 preferences
                    if (arr.length === 0 || arr.length > 8) return false;
                    const emailRe = /\S+@\S+\.\S+/;
                    const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                    for (const it of arr) {
                        const s = String(it || '').trim();
                        if (!s) return false; // empty entry suspicious
                        if (emailRe.test(s)) return false;
                        if (phoneRe.test(s)) return false;
                        // if an item looks like a JSON object marker or '[object' it's suspicious
                        if (/\{.*\}|\[object /.test(s)) return false;
                        // overly long single items are suspicious (personal addresses, long JSON blobs)
                        if (s.length > 120) return false;
                    }
                    return true;
                } catch (e) { return false; }
            };

            const runRestore = function(){
                try {
                    // Only pull explicit job-preference keys. Do NOT inspect or flatten the whole draft.
                    let prefs = [];
                    try { prefs = (window.getDraftJobPreferences && window.getDraftJobPreferences()) || []; } catch(e) { prefs = []; }
                    prefs = Array.from(new Set((prefs||[]).map(x=>String(x||'').trim()).filter(Boolean)));
                    // sanitize prefs same as later rendering: remove personal info, emails, phones, filenames, [object Object]
                    const sanitize = (arr, draftObj) => {
                        try {
                            const emailRe = /\S+@\S+\.\S+/;
                            const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                            const fileExtRe = /\.(pdf|docx|doc|png|jpg|jpeg|gif)$/i;
                            const personalSet = new Set();
                            try {
                                const d = draftObj || (window.__mvsg_lastLoadedDraft || {});
                                const p = d.personalInfo || d.personal || d;
                                const addIf = v => { try { if (v !== undefined && v !== null) { const s = String(v).trim(); if (s) personalSet.add(s.toLowerCase()); } } catch(e){} };
                                if (p && typeof p === 'object') {
                                    addIf(p.first_name || p.first || p.firstName);
                                    addIf(p.last_name || p.last || p.lastName);
                                    addIf(p.email || p.emailAddress);
                                    addIf(p.phone || p.mobile);
                                    addIf(p.address || p.addr);
                                }
                                addIf(d.proofFilename || d.cert_file || d.certfile || d.proof || d.proofFilename);
                                addIf(d.role || d.userRole || d.roleName);
                                const g = d.guardianInfo || d.guardian || {};
                                if (g && typeof g === 'object') { addIf(g.guardian_first_name || g.first_name || g.guardian_first); addIf(g.guardian_last_name || g.last_name || g.guardian_last); }
                            } catch(e) {}
                            return arr.filter(item => {
                                try {
                                    if (!item) return false;
                                    const s = String(item).trim();
                                    if (emailRe.test(s)) return false;
                                    if (phoneRe.test(s)) return false;
                                    if (fileExtRe.test(s)) return false;
                                    if (/\[object\s+object\]/i.test(s)) return false;
                                    if (personalSet.size && personalSet.has(s.toLowerCase())) return false;
                                    if (/^\d{1,3}$/.test(s)) return false;
                                    if (s.length > 120) return false;
                                    return true;
                                } catch(e){ return false; }
                            });
                        } catch(e) { return arr; }
                    };

                    const safePrefs = sanitize(prefs, window.__mvsg_lastLoadedDraft || (localStorage.getItem('rpi_personal') ? tryParse(localStorage.getItem('rpi_personal')) : null));
                    // Intersect with known card labels on the page to avoid showing unrelated values
                    const knownLabels = Array.from(document.querySelectorAll('.jobpref-card h3, .selectable-card h3')).map(n=>String(n.textContent||'').trim().toLowerCase()).filter(Boolean);
                    const finalPrefs = (knownLabels.length > 0) ? safePrefs.filter(p => knownLabels.indexOf(String(p||'').trim().toLowerCase()) !== -1) : safePrefs;
                    if (finalPrefs.length) {
                        try {
                            if (window.renderPillList) window.renderPillList('review_jobprefs_list', finalPrefs);
                            else {
                                const el = document.getElementById('review_jobprefs_list'); if (el) { el.innerHTML = ''; for (const it of finalPrefs) { const sp = document.createElement('span'); sp.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm'; sp.textContent = it; el.appendChild(sp); } }
                            }
                        } catch(e){}
                        // mark matching cards selected and set preview image
                        try {
                            setChoiceImage && setChoiceImage('review_jobprefs_img', prefs[0], ['.jobpref-card', '.selectable-card']);
                            document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card => {
                                try {
                                    const title = card.querySelector('h3')?.textContent?.trim();
                                    if (title && prefs.indexOf(title) !== -1) card.classList.add('selected'); else card.classList.remove('selected');
                                } catch(e){}
                            });
                        } catch(e){}
                        // restored
                    } else {
                        // nothing found — silently leave the container as-is
                    }
                } catch(e) { console.debug('[review-5] restore prefs failed', e); }
            };

            // initial run
            runRestore();
            // re-run when populate completes or storage changes
            window.addEventListener('mvsg:populateDone', function(){ setTimeout(runRestore, 10); });
            window.addEventListener('storage', function(){ setTimeout(runRestore, 20); });
        })();
    </script>

    <script>
        // Save the visible job preferences into localStorage['rpi_personal'] then navigate (preserve uid when available)
        function saveDraftAndGotoJobPrefs(url) {
            try {
                let draft = window.__mvsg_lastLoadedDraft || {};
                if (!draft || typeof draft !== 'object') draft = {};
                draft.jobPreferences = draft.jobPreferences || {};

                try {
                    const container = document.getElementById('review_jobprefs_list');
                    if (container) {
                        const spans = Array.from(container.querySelectorAll('span'));
                        const vals = spans.map(s => (s.textContent||'').trim()).filter(Boolean);
                        if (vals.length) {
                            // store both shapes: nested map and top-level key
                            draft.jobPreferences.jobpref1 = vals;
                            draft.jobpref1 = JSON.stringify(vals);
                        }
                    }
                } catch(e) { console.debug('[review-5] collect prefs failed', e); }

                try {
                    localStorage.setItem('rpi_personal', JSON.stringify(draft));
                    try { console.info('[review-5] saveDraftAndGotoJobPrefs wrote rpi_personal', JSON.parse(localStorage.getItem('rpi_personal'))); } catch(e) { console.info('[review-5] wrote rpi_personal (readback failed)'); }
                } catch(e) { console.warn('[review-5] failed to write rpi_personal', e); }
            } catch(e) { console.warn('[review-5] build draft failed', e); }

            try {
                let uid = '';
                if (window.firebase && firebase.auth) {
                    const user = firebase.auth().currentUser;
                    if (user && user.uid) uid = user.uid;
                }
                if (uid) {
                    const sep = url.includes('?') ? '&' : '?';
                    window.location.href = url + sep + 'uid=' + encodeURIComponent(uid);
                } else {
                    window.location.href = url;
                }
            } catch(e) { window.location.href = url; }
        }

        document.addEventListener('DOMContentLoaded', function(){
            try {
                const btn = document.getElementById('rv5_change_jobprefs_btn');
                if (btn) btn.addEventListener('click', function(e){ e.preventDefault(); saveDraftAndGotoJobPrefs('{{ route('registerjobpreference1') }}'); });
            } catch(e) { console.debug('[review-5] wiring change button failed', e); }
        });
    </script>
    <script>
        // Continue: collect visible prefs, save local draft, attempt Firestore write, then navigate
        (function(){
            const normalizeSpans = (containerId) => {
                const container = document.getElementById(containerId);
                if (!container) return [];
                const spans = Array.from(container.querySelectorAll('span'));
                // filter out header placeholders like "Chosen Work" if present (heuristic: ignore exact 'Chosen Work')
                return spans.map(s => (s.textContent||'').trim()).filter(t => t && t.toLowerCase() !== 'chosen work');
            };

            const storePendingWrite = (uid, section, data) => {
                try {
                    const all = JSON.parse(localStorage.getItem('pending_writes') || '{}');
                    if (!all[uid]) all[uid] = {};
                    all[uid][section] = { data };
                    localStorage.setItem('pending_writes', JSON.stringify(all));
                    console.info('[review-5] stored pending_writes for', uid, section);
                } catch (e) { console.warn('[review-5] storePendingWrite failed', e); }
            };

            const writeToFirestore = async (uid, prefs) => {
                try {
                    if (!window.firebase || !firebase.firestore) throw new Error('no-firebase');
                    const db = firebase.firestore();
                    await db.collection('users').doc(uid).set({ jobPreferences: { jobpref1: prefs } , updatedAt: firebase.firestore.FieldValue.serverTimestamp() }, { merge: true });
                    console.info('[review-5] wrote jobPreferences to Firestore for', uid, prefs);
                    return { ok: true };
                } catch (e) {
                    console.warn('[review-5] Firestore write failed', e && e.message ? e.message : e);
                    // emulate register.js permission fallback
                    if (e && (e.code === 'permission-denied' || String(e).toLowerCase().includes('permission'))) {
                        return { ok: false, code: 'permission-denied', error: e };
                    }
                    return { ok: false, error: e };
                }
            };

            const btn = document.getElementById('rv5_continue');
            if (!btn) return;
            btn.addEventListener('click', async function(e){
                try {
                    e.preventDefault();
                    const errEl = document.getElementById('jobpref1Error');
                    // collect prefs from the rendered review list, fallback to draft
                    let prefs = normalizeSpans('review_jobprefs_list');
                    if (!prefs.length) {
                        try { prefs = (window.getDraftJobPreferences && window.getDraftJobPreferences()) || []; } catch(e) { prefs = []; }
                    }
                    // sanitize prefs to remove any personal-info or filenames that may have leaked into the draft
                    const sanitizePrefs = (arr, draftObj) => {
                        try {
                            let a = (arr || []).map(x => String(x||'').trim()).filter(Boolean);
                            const emailRe = /\S+@\S+\.\S+/;
                            const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                            const fileExtRe = /\.(pdf|docx|doc|png|jpg|jpeg|gif)$/i;
                            const personalSet = new Set();
                            try {
                                const d = draftObj || (window.__mvsg_lastLoadedDraft || {});
                                const p = d.personalInfo || d.personal || d;
                                const addIf = v => { try { if (v !== undefined && v !== null) { const s = String(v).trim(); if (s) personalSet.add(s.toLowerCase()); } } catch(e){} };
                                if (p && typeof p === 'object') {
                                    addIf(p.first_name || p.first || p.firstName);
                                    addIf(p.last_name || p.last || p.lastName);
                                    addIf(p.email || p.emailAddress);
                                    addIf(p.phone || p.mobile);
                                    addIf(p.address || p.addr);
                                }
                                addIf(d.proofFilename || d.cert_file || d.certfile || d.proof || d.proofFilename);
                                addIf(d.role || d.userRole || d.roleName);
                            } catch(e) {}
                            a = a.filter(s => {
                                try {
                                    if (!s) return false;
                                    if (emailRe.test(s)) return false;
                                    if (phoneRe.test(s)) return false;
                                    if (fileExtRe.test(s)) return false;
                                    if (/\[object\s+object\]/i.test(s)) return false;
                                    if (personalSet.size && personalSet.has(s.toLowerCase())) return false;
                                    if (/^\d{1,3}$/.test(s)) return false;
                                    if (s.length > 120) return false;
                                    return true;
                                } catch(e) { return false; }
                            });
                            return [...new Set(a)];
                        } catch(e) { return (arr||[]).map(x=>String(x||'').trim()).filter(Boolean); }
                    };
                    prefs = sanitizePrefs(prefs, window.__mvsg_lastLoadedDraft || (localStorage.getItem('rpi_personal') ? JSON.parse(localStorage.getItem('rpi_personal')) : null));
                    if (!prefs || prefs.length < 3) {
                        if (errEl) errEl.textContent = 'Please select at least 3 options.';
                        return;
                    }
                    if (prefs.length > 5) {
                        if (errEl) errEl.textContent = 'Please select no more than 5 options.';
                        return;
                    }
                    if (errEl) errEl.textContent = '';

                    // build draft and persist locally
                    try {
                        let draft = window.__mvsg_lastLoadedDraft || {};
                        if (!draft || typeof draft !== 'object') draft = {};
                        draft.jobPreferences = draft.jobPreferences || {};
                        draft.jobPreferences.jobpref1 = prefs;
                        draft.jobpref1 = JSON.stringify(prefs);
                        localStorage.setItem('rpi_personal', JSON.stringify(draft));
                        console.info('[review-5] wrote rpi_personal with jobpref1', prefs);
                    } catch (e) { console.warn('[review-5] could not write rpi_personal', e); }

                    // attempt Firestore write if possible and user signed in
                    try {
                        if (window.firebase && firebase.auth && firebase.firestore) {
                            const user = firebase.auth().currentUser;
                            if (user && user.uid) {
                                const res = await writeToFirestore(user.uid, prefs);
                                if (!res.ok && res.code === 'permission-denied') {
                                    storePendingWrite(user.uid, 'jobPreferences', { jobpref1: prefs });
                                }
                            } else {
                                console.info('[review-5] user not signed in; skipping Firestore write (will save locally)');
                            }
                        } else {
                            console.info('[review-5] firebase not available; skipping Firestore write');
                        }
                    } catch (e) { console.warn('[review-5] write attempt failed', e); }

                    // navigate to final step (preserve uid param if available via firebase currentUser)
                    try {
                        let url = '{{ route('registerfinalstep') }}';
                        let uid = '';
                        if (window.firebase && firebase.auth) {
                            const u = firebase.auth().currentUser;
                            if (u && u.uid) uid = u.uid;
                        }
                        if (uid) url += (url.includes('?') ? '&' : '?') + 'uid=' + encodeURIComponent(uid);
                        window.location.href = url;
                    } catch (e) { window.location.href = '{{ route('registerfinalstep') }}'; }

                } catch (e) { console.error('[review-5] continue handler failed', e); }
            });
        })();
    </script>
    <script>
        // Use centralized populateReview and render job preferences as pills
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                if (typeof window.populateReview === 'function') {
                    await window.populateReview();
                }
            } catch (e) {
                console.debug('review-5: populateReview failed', e);
            }
                try {
                    const draft = window.__mvsg_lastLoadedDraft || {};
                    // Only pull explicit job preference keys using the centralized helper
                    let prefsRaw = [];
                    try { prefsRaw = (window.getDraftJobPreferences && window.getDraftJobPreferences()) || []; } catch(e) { prefsRaw = []; }

                // normalize final list (dedupe and trim)
                try {
                    prefsRaw = (prefsRaw || []).map(x => (typeof x === 'string' ? x.trim() : x)).filter(Boolean);
                    prefsRaw = [...new Set(prefsRaw)];

                    // Remove anything that clearly looks like personal info or uploaded filenames
                    const emailRe = /\S+@\S+\.\S+/;
                    const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                    const fileExtRe = /\.(pdf|docx|doc|png|jpg|jpeg|gif)$/i;

                    // Build a set of known personal values from the draft to exclude (first/last/email/phone/address/proofFilename/role)
                    const personalSet = new Set();
                    try {
                        const d = draft || {};
                        const p = d.personalInfo || d.personal || d.personalInfo || d;
                        const addIf = v => { try { if (v !== undefined && v !== null) { const s = String(v).trim(); if (s) personalSet.add(s.toLowerCase()); } } catch(e){} };
                        if (p && typeof p === 'object') {
                            addIf(p.first_name || p.first || p.firstName);
                            addIf(p.last_name || p.last || p.lastName);
                            addIf(p.email || p.emailAddress);
                            addIf(p.phone || p.mobile);
                            addIf(p.address || p.addr);
                        }
                        addIf(d.proofFilename || d.cert_file || d.certfile || d.proof || d.proofFilename);
                        addIf(d.role || d.userRole || d.roleName);
                        // also include guardian names if present
                        const g = d.guardianInfo || d.guardian || {};
                        if (g && typeof g === 'object') { addIf(g.guardian_first_name || g.first_name || g.guardian_first); addIf(g.guardian_last_name || g.last_name || g.guardian_last); }
                    } catch(e) { /* ignore */ }

                    // Filter out suspicious entries
                    prefsRaw = prefsRaw.filter(item => {
                        try {
                            if (!item) return false;
                            const s = String(item).trim();
                            const low = s.toLowerCase();
                            if (emailRe.test(s)) return false;
                            if (phoneRe.test(s)) return false;
                            if (fileExtRe.test(s)) return false;
                            if (/\[object\s+object\]/i.test(s)) return false;
                            if (personalSet.size && personalSet.has(low)) return false;
                            // avoid entries that are single numeric age or long addresses
                            if (/^\d{1,3}$/.test(s)) return false;
                            if (s.length > 120) return false;
                            return true;
                        } catch (e) { return false; }
                    });
                } catch (e) { /* ignore */ }

                // Normalize and render using global helper if available
                if (window.renderPillList) {
                    window.renderPillList('review_jobprefs_list', prefsRaw);
                } else {
                    // fallback: simple comma text into the existing container
                    const el = document.getElementById('review_jobprefs_list');
                    if (el) {
                        el.innerHTML = '';
                        const items = Array.isArray(prefsRaw) ? prefsRaw : (typeof prefsRaw === 'string' ? prefsRaw.split(',').map(s=>s.trim()) : []);
                        if (!items.length) {
                            const none = document.createElement('span'); none.className = 'text-gray-600'; none.textContent = 'None'; el.appendChild(none);
                        } else {
                            for (const it of items) {
                                const sp = document.createElement('span');
                                sp.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                                sp.textContent = it;
                                el.appendChild(sp);
                            }
                        }
                    }
                }

                // Highlight matching jobpref cards and set preview image
                try {
                    const items = (Array.isArray(prefsRaw) ? prefsRaw : []).map(x => typeof x === 'string' ? x.trim() : x).filter(Boolean);
                    if (items.length) {
                        setChoiceImage('review_jobprefs_img', items[0], ['.jobpref-card', '.selectable-card']);
                        document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card => {
                            const title = card.querySelector('h3')?.textContent?.trim();
                            if (title && items.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
                        });
                    }
                } catch(e) { /* ignore */ }
            } catch (e) {
                console.debug('review-5 render error', e);
            }
        });
    </script>
    <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
    <script>
        (function(){
            const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            let voices = [];
            const populateVoices = () => { voices = speechSynthesis.getVoices() || []; };
            const pickBest = (list, langPrefix) => {
                if (!list || !list.length) return null;
                const exact = list.find(v=>v.name === preferredVoiceName); if (exact) return exact;
                const fuzzy = list.find(v=>v.name && v.name.toLowerCase().includes('microsoft') && v.name.toLowerCase().includes('multilingual')); if (fuzzy) return fuzzy;
                const langMatch = list.find(v => v.lang && v.lang.toLowerCase().startsWith(langPrefix)); if (langMatch) return langMatch;
                return list[0] || null;
            };
            const voiceFor = (lang) => { const forLang = voices.filter(v => v.lang && v.lang.toLowerCase().startsWith(lang)); return pickBest(forLang.length ? forLang : voices, lang); };
            const stopSpeaking = () => { try { speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>b.classList.remove('speaking')); } catch(e){} };
            const startSequence = (btn, en, tl) => {
                stopSpeaking(); if (!en && !tl) return; btn.classList.add('speaking'); btn.setAttribute('aria-pressed','true');
                const uEn = en ? new SpeechSynthesisUtterance(en) : null; const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
                if (uEn) { uEn.lang='en-US'; uEn.voice = voiceFor('en') || null; }
                if (uTl) { uTl.lang='tl-PH'; uTl.voice = voiceFor('tl') || (voiceFor('en') || null); }
                const finalize = () => { btn.classList.remove('speaking'); btn.setAttribute('aria-pressed','false'); };
                if (uEn && uTl) { uEn.onend = () => { setTimeout(()=>speechSynthesis.speak(uTl), 180); }; uTl.onend = finalize; speechSynthesis.speak(uEn); }
                else if (uEn) { uEn.onend = finalize; speechSynthesis.speak(uEn); }
                else if (uTl) { uTl.onend = finalize; speechSynthesis.speak(uTl); }
            };
            const init = () => {
                populateVoices(); window.speechSynthesis.onvoiceschanged = populateVoices;
                document.querySelectorAll('.tts-btn').forEach(b=>{
                    b.addEventListener('click', ()=>{ if (b.classList.contains('speaking')) { stopSpeaking(); return; } startSequence(b, b.getAttribute('data-tts-en')||'', b.getAttribute('data-tts-tl')||''); });
                    b.addEventListener('keydown', ev=>{ if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); b.click(); } });
                });
                window.addEventListener('beforeunload', stopSpeaking);
            };
            if (document.readyState === 'complete' || document.readyState === 'interactive') init(); else document.addEventListener('DOMContentLoaded', init);
        })();
    </script>
</body>

</html>
