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

    /* selectable card visual (shared style used across review pages) */
        .selectable-card {
            border: 2px solid transparent;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                border-color .18s ease;
        }

        .selectable-card.selected {
            border-color: #2563eb;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.14);
            transform: translateY(-6px);
        }

        /* show small check badge when a card is selected */
        .selectable-card.selected::after,
        .guardian-card.selected::after,
        .education-card.selected::after,
        .skills-card.selected::after,
        .workexp-card.selected::after {
            content: "";
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 44px;
            height: 44px;
            background-image: url('/image/checkmark.png');
            background-size: contain;
            background-repeat: no-repeat;
            pointer-events: none;
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
    onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerjobpreference1') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-6">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Review Your Information
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

            <!-- Personal Info -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Personal Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-gray-800">
                    <p><span class="font-semibold">First Name:</span> <span id="r_first_name"></span></p>
                    <p><span class="font-semibold">Last Name:</span> <span id="r_last_name"></span></p>
                    <p><span class="font-semibold">Age:</span> <span id="r_age"></span></p>
                    <p><span class="font-semibold">Email:</span> <span id="r_email"></span></p>
                    <p><span class="font-semibold">Phone:</span> <span id="r_phone"></span></p>
                    <p class="col-span-3"><span class="font-semibold">Address:</span> <span id="r_address"></span></p>
                </div>
            </div>

            <!-- DS Type -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Additional Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-800">
                    <p><span class="font-semibold">Type of Down Syndrome:</span> <span id="r_dsType"></span></p>
                </div>
            </div> 

            <!-- Guardian Info -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Guardian Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-gray-800">
                    <p><span class="font-semibold">First Name:</span> <span id="r_guardian_first"></span></p>
                    <p><span class="font-semibold">Last Name:</span> <span id="r_guardian_last"></span></p>
                    <p><span class="font-semibold">Email:</span> <span id="r_guardian_email"></span></p>
                    <p><span class="font-semibold">Phone:</span> <span id="r_guardian_phone"></span></p>
                    <p><span class="font-semibold">Relationship:</span> <span id="r_guardian_relationship"></span></p>
                </div>
            </div>

            <!-- Account Info -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Account Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-800">
                    <p><span class="font-semibold">Username:</span> <span id="r_username"></span></p>
                    <p><span class="font-semibold">Password:</span> <span id="r_password"></span></p>
                </div>
            </div>

            <!-- Proof of Membership -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Proof of Membership
                </h3>
                <div class="text-gray-800">
                    <p><span class="font-semibold">Uploaded File:</span> <span id="r_proof">No file uploaded</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">

            <!-- Edit Button -->
            <button id="editInfo" onclick="saveDraftAndEdit();"
                class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
           px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
           shadow-md w-full sm:w-64 text-center">
                ✏️ Edit Information
            </button>

            <!-- Continue Button -->
            <button id="review1Continue" type="button"
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


    <script src="{{ asset('js/firebase-config-global.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>
    <script>
        // Save the currently-displayed review draft into localStorage so the adminapprove page
        // (and register.js) can prefill fields. If Firebase user is available, append ?uid= to the URL.
        function saveDraftAndEdit() {
            try {
                // Prefer the merged draft if the preview loader exposed it
                let draft = window.__mvsg_lastLoadedDraft || null;
                if (!draft || typeof draft !== 'object') {
                    // Fallback: build a minimal draft from the visible review DOM
                    draft = draft || {};
                    draft.personal = draft.personal || {};
                    draft.guardian = draft.guardian || {};
                    const text = id => (document.getElementById(id) && document.getElementById(id).textContent) ? document.getElementById(id).textContent.trim() : '';
                    draft.personal.first = draft.personal.first || text('r_first_name');
                    draft.personal.last = draft.personal.last || text('r_last_name');
                    draft.personal.email = draft.personal.email || text('r_email');
                    draft.personal.phone = draft.personal.phone || text('r_phone');
                    draft.personal.age = draft.personal.age || text('r_age');
                    draft.personal.address = draft.personal.address || text('r_address');
                    draft.personal.username = draft.personal.username || text('r_username');
                    // Password in review is a masked placeholder; keep it if present (won't reveal real password)
                    const pw = text('r_password'); if (pw) draft.personal.password = draft.personal.password || pw;
                    draft.guardian.guardian_first_name = draft.guardian.guardian_first_name || text('r_guardian_first');
                    draft.guardian.guardian_last_name = draft.guardian.guardian_last_name || text('r_guardian_last');
                    draft.guardian.guardian_email = draft.guardian.guardian_email || text('r_guardian_email');
                    draft.guardian.guardian_phone = draft.guardian.guardian_phone || text('r_guardian_phone');
                    draft.guardian.relationship = draft.guardian.relationship || text('r_guardian_relationship');
                    draft.dsType = draft.dsType || text('r_dsType');
                    // proof filename (may contain 'No file uploaded')
                    const proof = text('r_proof'); if (proof && proof !== 'No file uploaded') draft.proofFilename = draft.proofFilename || proof;
                }
                try {
                    localStorage.setItem('rpi_personal', JSON.stringify(draft));
                    // read back and show verified JSON so we can confirm storage succeeded in the browser console
                    try {
                        const verified = JSON.parse(localStorage.getItem('rpi_personal'));
                        console.info('[review] saveDraftAndEdit wrote rpi_personal and verified', verified);
                    } catch (verErr) {
                        console.info('[review] saveDraftAndEdit wrote rpi_personal (could not parse on readback)', localStorage.getItem('rpi_personal'));
                    }
                } catch (e) { console.warn('saveDraftAndEdit: failed to set localStorage', e); }
            } catch (e) { console.warn('saveDraftAndEdit build draft failed', e); }

            // Try to get firebase uid to make adminapprove load the authoritative document when possible
            try {
                let uid = '';
                if (window.firebase && firebase.auth) {
                    const user = firebase.auth().currentUser;
                    if (user && user.uid) uid = user.uid;
                }
                let url = '{{ route('registeradminapprove') }}';
                if (uid) url += '?uid=' + encodeURIComponent(uid);
                window.location.href = url;
            } catch (e) {
                // fallback navigation
                window.location.href = '{{ route('registeradminapprove') }}';
            }
        }
    </script>
    <script>
        // Try to sync client Firebase ID token to the server before navigating to review-2.
        // This helps populate Laravel session('firebase_uid') so the next page can fetch server-profile.
        (function(){
            async function trySyncClientIdTokenToServer() {
                try {
                    if (!window.firebase || !firebase.auth) return null;
                    try { if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) firebase.initializeApp(window.FIREBASE_CONFIG); } catch(e){}
                    let user = firebase.auth().currentUser;
                    if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                    if (!user) return null;
                    const idToken = await user.getIdToken().catch(()=>null);
                    if (!idToken) return null;
                    const headers = { 'Content-Type': 'application/json' };
                    try { const csrfMeta = document.querySelector && document.querySelector('meta[name="csrf-token"]'); if (csrfMeta && csrfMeta.getAttribute) headers['X-CSRF-TOKEN'] = csrfMeta.getAttribute('content'); } catch(e){}
                    const resp = await fetch('{{ url('/session/firebase-signin') }}', { method: 'POST', credentials: 'same-origin', headers, body: JSON.stringify({ idToken }) });
                    try { const j = await resp.json().catch(()=>null); return j || (resp.ok?{ok:true}:null); } catch(e){ return resp.ok?{ok:true}:null; }
                } catch (e) { return null; }
            }
            const btn = document.getElementById('review1Continue');
            if (btn) {
                btn.addEventListener('click', async function(e){
                    e.preventDefault();
                    // attempt sync but don't block more than ~2s (give slightly more time for idToken retrieval)
                    try {
                        const p = trySyncClientIdTokenToServer();
                        // write debug info to console and wait up to 2s for the sync promise
                        p && p.then && p.then(function(r){ console.debug('[review1] client->server sync result', r); }).catch(function(err){ console.debug('[review1] client->server sync error', err); });
                        await Promise.race([p, new Promise(res=>setTimeout(()=>res(null), 2000))]);
                    } catch(e){}
                    window.location.href = '{{ route('registerreview2') }}';
                });
            }
        })();
    </script>
    <script>
        // unified robust preview loader (tries local/session, registrationDraft globals, then Firestore)
        document.addEventListener('DOMContentLoaded', async () => {
            const tryParse = s => {
                try {
                    return typeof s === 'string' ? JSON.parse(s) : s;
                } catch (e) {
                    return null;
                }
            };
            const initFirebase = () => {
                try {
                    if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps
                            .length)) {
                        firebase.initializeApp(window.FIREBASE_CONFIG);
                    }
                } catch (e) {
                    console.warn('initFirebase', e);
                }
            };
            const fetchFirestoreDraft = async () => {
                if (!window.firebase || !firebase.firestore) return null;
                initFirebase();
                try {
                    const db = firebase.firestore();

                    // Allow an override via URL query param for admin/review pages.
                    // Example: /registerreview1?uid=n71qnTkNT9WUQhP4NAjOjA95lmK2
                    const params = new URLSearchParams(window.location.search || '');
                    const overrideUid = params.get('uid') || params.get('user') || params.get('id');
                    if (overrideUid) {
                        try {
                            const snap = await db.collection('users').doc(overrideUid).get().catch(() => null);
                            if (snap && snap.exists) return snap.data();
                        } catch (e) {
                            console.warn('fetchFirestoreDraft override read failed', e);
                        }
                    }

                    // Fallback: try to use currently signed-in user (if any)
                    if (window.firebase && firebase.auth) {
                        const auth = firebase.auth();
                        let user = auth.currentUser;
                        if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                        if (!user) return null;
                        // try common collections where drafts may be stored
                        const cols = ['registrations', 'users', 'registrationDrafts', 'profiles'];
                        for (const c of cols) {
                            try {
                                const snap = await db.collection(c).doc(user.uid).get().catch(() => null);
                                if (snap && snap.exists) return snap.data();
                            } catch (e) {
                                /* ignore per-collection errors */ }
                        }
                    }
                } catch (e) {
                    console.warn('fetchFirestoreDraft', e);
                }
                return null;
            };
            const readStored = async () => {
                // prefer registrationDraft aliases in storage/globals, otherwise try Firestore
                const keys = ['registrationDraft', 'registration_draft', 'dsRegistrationDraft',
                    'ds_registration', 'registerDraft', 'regDraft', 'reg_data', 'rpi_personal'
                ];
                for (const k of keys) {
                    const s = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
                    if (s && typeof s === 'object') return s;
                }
                if (window.registrationDraft || window.__REGISTRATION_DRAFT__) {
                    try {
                        return typeof window.registrationDraft === 'string' ? tryParse(window
                            .registrationDraft) : (window.registrationDraft || window
                            .__REGISTRATION_DRAFT__);
                    } catch (e) {}
                }
                // final attempt: Firestore
                return await fetchFirestoreDraft();
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
                    /* ignore */ }
                return '';
            };

            // Robust resolver for Down Syndrome type — check common key variants and nested objects
            const resolveDsType = (root, personal) => {
                const candidates = [];
                // direct common keys (both camelCase and snake_case)
                try {
                    candidates.push(root?.dsType, root?.ds_type, root?.typeOfDs, root?.type_of_ds, root?.type, root?.downSyndromeType, root?.down_syndrome_type);
                    candidates.push(personal?.dsType, personal?.ds_type, personal?.typeOfDs, personal?.type_of_ds, personal?.type, personal?.downSyndromeType, personal?.down_syndrome_type);
                } catch (e) {}
                // try flattened search for any key containing ds or "down" or "syndrome"
                try {
                    const found = findFirstMatching(root || {}, ['ds', 'dsType', 'ds_type', 'down', 'down syndrome', 'type']);
                    if (found) candidates.push(found);
                } catch (e) {}

                for (const c of candidates) {
                    if (c === undefined || c === null) continue;
                    // If it's an object, try common string props
                    if (typeof c === 'object') {
                        if (Array.isArray(c) && c.length) return c.join(', ');
                        const label = c.label || c.name || c.type || c.text || c.value || c.display || c.code || null;
                        if (label && String(label).trim()) return String(label).trim();
                        // fallback to JSON stringify if object has useful content
                        try {
                            const s = JSON.stringify(c);
                            if (s && s !== '{}' && s !== 'null') return s;
                        } catch (e) {}
                        continue;
                    }
                    // If it's a non-empty string/number, return it
                    if ((typeof c === 'string' && c.trim()) || (typeof c === 'number' && !Number.isNaN(c))) return String(c).trim();
                }
                return '';
            };

            const safeSet = (id, value) => {
                try {
                    const el = document.getElementById(id);
                    if (!el) { console.debug('[review] element not found for id', id, 'value:', value); return; }
                    let out = value;
                    if (out === null || out === undefined) out = '';
                    else if (typeof out === 'object') {
                        if (Array.isArray(out)) out = out.join(', ');
                        else out = JSON.stringify(out);
                    }
                    out = String(out);
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = out ?? '';
                    else el.textContent = out ?? '';
                    console.debug('[review] set', id, out);
                } catch (e) {
                    console.warn('[review] safeSet error for', id, e);
                }
            };
            const setChoiceImage = (placeholderId, value, cardSelectors = ['.guardian-card',
                '.selectable-card']) => {
                try {
                    const container = document.getElementById(`${placeholderId}_container`);
                    const ph = document.getElementById(placeholderId);
                    if (!value) {
                        if (container) container.style.display = 'none';
                        if (ph) ph.src = '';
                        return;
                    }
                    const target = String(value).trim().toLowerCase();
                    const selectors = Array.isArray(cardSelectors) ? cardSelectors : [cardSelectors];
                    selectors.forEach(sel => document.querySelectorAll(sel).forEach(n => n.classList.remove(
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
                    if (container) container.style.display = 'none';
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
                    }
                } catch (e) { console.warn('fetch/merge draft failed', e); }
                if (!data) return;
                // expose loaded draft to window for debugging (no visible debug panel)
                try { window.__mvsg_lastLoadedDraft = data; } catch(e){}
                try { window.__mvsg_lastDraftSource = (window.__mvsg_mergedFromFirestore ? 'firestore_merged' : 'local_or_remote'); } catch(e){}

                // helper to normalize filenames (strip paths like C:\\fakepath\\...)
                const normalizeFilename = (s) => {
                    try {
                        if (!s) return '';
                        const str = String(s || '');
                        const parts = str.split(/[/\\\\]+/);
                        return parts[parts.length - 1] || '';
                    } catch(e) { return s; }
                };
                // map common guardian fields
                const p = data.personalInfo || data.personal || data;
                safeSet('r_first_name', p?.first || p?.first_name || p?.firstName || p?.fname || '');
                safeSet('r_last_name', p?.last || p?.last_name || p?.lastName || p?.lname || '');
                safeSet('r_email', p?.email || p?.emailAddress || '');
                safeSet('r_phone', p?.phone || p?.mobile || '');
                safeSet('r_age', p?.age || '');
                const addrVal = p?.address || p?.address1 || p?.addr || findFirstMatching(data, ['address','addr','location','street','barangay','city']) || '';
                safeSet('r_address', addrVal);
                // account fields
                safeSet('r_username', p?.username || p?.userName || data?.username || '');
                // show password as masked stars if present in draft/remote (do not reveal actual characters)
                try {
                    const pwdCandidate = p?.password || p?.pass || p?.confirm_password || p?.confirmPassword || data?.password || data?.pass || '';
                    let masked = '';
                    if (pwdCandidate && typeof pwdCandidate === 'string' && pwdCandidate.length) {
                        // mask with same number of asterisks as chars provided
                        masked = '*'.repeat(pwdCandidate.length);
                    }
                    // if no password found in drafts, show a masked placeholder so users know a password will be set
                    safeSet('r_password', masked || '********');
                } catch (e) { safeSet('r_password', ''); }
                // dsType and school/work info
                // Debug: log loaded data shape to help trace why dsType may be missing
                try { console.debug('[review] loaded data keys:', Object.keys(data || {})); } catch(e){}
                try { console.debug('[review] personalInfo (p):', p); } catch(e){}
                const dsType = resolveDsType(data, p);
                try { console.debug('[review] resolved dsType:', dsType); } catch(e){}
                // ensure Down Syndrome info is shown in review (fallback to a placeholder if missing)
                safeSet('r_dsType', dsType || 'Not provided');

                // If dsType wasn't found in the merged/local draft, attempt an authoritative read
                // from Firestore (this will respect ?uid= override or the current firebase auth user).
                if (!dsType) {
                    try {
                        // Ensure Firebase SDKs are loaded (in case register.js didn't initialize Firebase yet)
                        const ensureFirebaseSdk = async () => {
                            if (window.firebase && firebase.firestore) return;
                            const load = (src) => new Promise((res, rej) => {
                                const s = document.createElement('script'); s.src = src; s.onload = res; s.onerror = rej; document.head.appendChild(s);
                            });
                            try {
                                await load('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
                                await load('https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js');
                                await load('https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js');
                                // call initFirebase if it's available in this scope (defined above)
                                if (typeof initFirebase === 'function') {
                                    try { initFirebase(); } catch(e) { console.warn('initFirebase failed', e); }
                                }
                            } catch (e) {
                                console.warn('[review] failed to load Firebase SDKs', e);
                            }
                        };

                        await ensureFirebaseSdk();
                        const remoteDoc = await fetchFirestoreDraft();
                        const remote = (remoteDoc && typeof remoteDoc === 'object' && remoteDoc.data && typeof remoteDoc.data === 'object') ? remoteDoc.data : remoteDoc;
                        if (remote) {
                            const remoteP = remote.personalInfo || remote.personal || remote;
                            const remoteDs = resolveDsType(remote, remoteP || {});
                            if (remoteDs) {
                                try { console.debug('[review] firestore dsType found:', remoteDs); } catch(e){}
                                safeSet('r_dsType', remoteDs);
                            }
                        }
                    } catch (e) {
                        console.warn('[review] failed to fetch dsType from Firestore', e);
                    }
                }
                
                const sw = data.schoolWorkInfo || data.school || data.work || {};
                safeSet('r_school_name', sw?.school_name || sw?.school || sw?.schoolName || '');
                safeSet('r_work_type', sw?.work_type || sw?.work || sw?.occupation || '');
                const cert = sw?.cert_file || data?.cert_file || sw?.certificate || findFirstMatching(data, ['cert', 'certificate', 'cert_file']);
                safeSet('r_cert_file', normalizeFilename(cert) || '');
                const g = data.guardianInfo || data.guardian || {};
                const guardianFirst = g?.guardian_first_name || g?.first_name || data?.guardian_first_name || findFirstMatching(data, ['guardian_first_name','guardian_first','guardianfirst','guardian.first','guardian.first_name','guardian.firstName']) || '';
                const guardianLast = g?.guardian_last_name || g?.last_name || data?.guardian_last_name || findFirstMatching(data, ['guardian_last_name','guardian_last','guardianlast','guardian.last','guardian.last_name','guardian.lastName']) || '';
                const guardianEmail = g?.guardian_email || g?.email || data?.guardian_email || findFirstMatching(data, ['guardian_email','guardian.email','guardian.email_address','guardian_email_address','guardianEmail','guardian_email']) || '';
                const guardianPhone = g?.guardian_phone || g?.phone || data?.guardian_phone || findFirstMatching(data, ['guardian_phone','guardian.phone','guardianPhone','guardian_mobile','guardian_mobile_phone']) || '';
                safeSet('r_guardian_first', guardianFirst);
                safeSet('r_guardian_last', guardianLast);
                safeSet('r_guardian_email', guardianEmail);
                safeSet('r_guardian_phone', guardianPhone);
                const guardianRel = g?.guardian_choice || g?.relationship || data?.guardian_choice || findFirstMatching(data, ['guardian_choice', 'relationship', 'guardian']);
                safeSet('r_guardian_relationship', guardianRel || '');
                setChoiceImage('review_guardian_relationship_img', guardianRel, ['.guardian-card',
                    '.selectable-card'
                ]);
                // proof filename: try multiple locations (also check schoolWorkInfo.cert_file)
                try {
                    let proof = data.proofFilename || (data.personalInfo && data.personalInfo.proofFilename) || (data.personal && data.personal.proofFilename) || '';
                    // fallback to school/work certificate filename if proof missing
                    if (!proof) {
                        const swc = (data.schoolWorkInfo && (data.schoolWorkInfo.cert_file || data.schoolWorkInfo.certs)) || data.cert_file || data.certs || '';
                        proof = swc || '';
                    }
                    proof = normalizeFilename(proof || '');
                    safeSet('r_proof', proof || 'No file uploaded');
                } catch (e) {}

                // No fallback DOM writes here — rely on explicit element ids already present in the template
            } catch (e) {
                console.error('preview loader failed', e);
            }
        });
    </script>
    <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
    <script>
        (function(){
            const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            let voices = [];
            const populateVoices = () => {
                voices = speechSynthesis.getVoices() || [];
            };
            const pickBest = (list, langPrefix) => {
                if (!list || !list.length) return null;
                // exact preferred name
                const exact = list.find(v=>v.name === preferredVoiceName);
                if (exact) return exact;
                // fuzzy name
                const fuzzy = list.find(v=>v.name && v.name.toLowerCase().includes('microsoft') && v.name.toLowerCase().includes('multilingual'));
                if (fuzzy) return fuzzy;
                // language match
                const langMatch = list.find(v => v.lang && v.lang.toLowerCase().startsWith(langPrefix));
                if (langMatch) return langMatch;
                return list[0] || null;
            };
            const voiceFor = (lang) => {
                const forLang = voices.filter(v => v.lang && v.lang.toLowerCase().startsWith(lang));
                return pickBest(forLang.length ? forLang : voices, lang);
            };
            const stopSpeaking = () => {
                try { speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>b.classList.remove('speaking')); } catch(e){}
            };
            const startSequence = (btn, en, tl) => {
                stopSpeaking();
                if (!en && !tl) return;
                btn.classList.add('speaking');
                btn.setAttribute('aria-pressed','true');
                const uEn = en ? new SpeechSynthesisUtterance(en) : null;
                const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
                if (uEn) { uEn.lang='en-US'; uEn.voice = voiceFor('en') || null; }
                if (uTl) { uTl.lang='tl-PH'; uTl.voice = voiceFor('tl') || (voiceFor('en') || null); }
                const finalize = () => { btn.classList.remove('speaking'); btn.setAttribute('aria-pressed','false'); };
                if (uEn && uTl) {
                    uEn.onend = () => { setTimeout(()=>speechSynthesis.speak(uTl), 180); };
                    uTl.onend = finalize;
                    speechSynthesis.speak(uEn);
                } else if (uEn) { uEn.onend = finalize; speechSynthesis.speak(uEn); }
                else if (uTl) { uTl.onend = finalize; speechSynthesis.speak(uTl); }
            };
            const init = () => {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = populateVoices;
                document.querySelectorAll('.tts-btn').forEach(b=>{
                    b.addEventListener('click', e=>{
                        const en = b.getAttribute('data-tts-en') || '';
                        const tl = b.getAttribute('data-tts-tl') || '';
                        if (b.classList.contains('speaking')) { stopSpeaking(); return; }
                        startSequence(b, en, tl);
                    });
                    b.addEventListener('keydown', ev=>{ if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); b.click(); } });
                });
                window.addEventListener('beforeunload', stopSpeaking);
            };
            if (document.readyState === 'complete' || document.readyState === 'interactive') init(); else document.addEventListener('DOMContentLoaded', init);
        })();
    </script>
        <script>
            // Safety-net: ensure proof filename is shown in the review UI when a draft contains it.
            (function(){
                const normalizeFilename = (s) => {
                    try { if (!s) return ''; const parts = String(s).split(/[/\\]+/); return parts[parts.length-1] || ''; } catch(e){ return s; }
                };
                const tryGetProof = (obj) => {
                    if (!obj) return '';
                    // common places
                    const candidates = [obj.proofFilename, obj.proof_filename, obj.proofFile, obj.proof, obj.cert_file, obj.certFile, obj.certs, obj.certificate];
                    for (const c of candidates) if (c) return c;
                    // nested personalInfo / personal
                    if (obj.personalInfo && typeof obj.personalInfo === 'object') {
                        const p = obj.personalInfo;
                        for (const c of [p.proofFilename, p.proof, p.cert_file, p.certFile]) if (c) return c;
                    }
                    if (obj.personal && typeof obj.personal === 'object') {
                        const p = obj.personal;
                        for (const c of [p.proofFilename, p.proof, p.cert_file, p.certFile]) if (c) return c;
                    }
                    // schoolWorkInfo
                    if (obj.schoolWorkInfo && typeof obj.schoolWorkInfo === 'object') {
                        const s = obj.schoolWorkInfo;
                        for (const c of [s.cert_file, s.certFile, s.certs]) if (c) return c;
                    }
                    return '';
                };

                const apply = () => {
                    try {
                        let draft = null;
                        try { draft = window.__mvsg_lastLoadedDraft || null; } catch(e){}
                        if (!draft) {
                            try { draft = JSON.parse(localStorage.getItem('rpi_personal') || localStorage.getItem('registrationDraft') || 'null'); } catch(e){ draft = null; }
                        }
                        const proofRaw = tryGetProof(draft) || '';
                        const proof = normalizeFilename(proofRaw || '');
                        if (proof && document.getElementById('r_proof')) {
                            document.getElementById('r_proof').textContent = proof;
                            console.info('[review] applied proofFilename to r_proof:', proof);
                            return true;
                        }
                    } catch (e) { /* ignore safety-net errors */ }
                    return false;
                };

                // attempt immediate apply, but also retry and listen for populate/storage events
                let attempts = 0;
                const applyWithRetry = () => {
                    try {
                        const ok = apply();
                        if (ok) return;
                        attempts++;
                        if (attempts < 8) setTimeout(applyWithRetry, 300);
                        else {
                            // Final fallback: try to fetch authoritative document from Firestore (best-effort)
                            try {
                                (async function fetchProofFromFirestore(){
                                    try {
                                        if (!window.firebase || !firebase.firestore) return;
                                        // initialize if necessary
                                        try { if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) firebase.initializeApp(window.FIREBASE_CONFIG); } catch(e){}
                                        const params = new URLSearchParams(window.location.search || '');
                                        const overrideUid = params.get('uid') || params.get('user') || params.get('id');
                                        let docUid = overrideUid || (firebase.auth && firebase.auth().currentUser && firebase.auth().currentUser.uid) || null;
                                        // attempt to wait for auth if not ready
                                        if (!docUid && firebase.auth) {
                                            const user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                                            if (user && user.uid) docUid = user.uid;
                                        }
                                        if (!docUid) return;
                                        const db = firebase.firestore();
                                        const snap = await db.collection('users').doc(docUid).get().catch(()=>null);
                                        const doc = snap && snap.exists ? snap.data() : null;
                                        if (!doc) return;
                                        const proofRaw = doc.proofFilename || doc.proof_filename || doc.proofFile || (doc.personalInfo && (doc.personalInfo.proofFilename || doc.personalInfo.proof)) || (doc.personal && (doc.personal.proofFilename || doc.personal.proof)) || doc.cert_file || '';
                                        const proof = normalizeFilename(proofRaw || '');
                                        if (proof && document.getElementById('r_proof')) {
                                            document.getElementById('r_proof').textContent = proof;
                                            console.info('[review] fetched proofFilename from Firestore and applied to r_proof:', proof);
                                        }
                                    } catch(e) { /* ignore final fallback errors */ }
                                })();
                            } catch(e){}
                        }
                    } catch(e){}
                };

                // run on DOM ready
                if (document.readyState === 'complete' || document.readyState === 'interactive') setTimeout(applyWithRetry, 50);
                else document.addEventListener('DOMContentLoaded', () => setTimeout(applyWithRetry, 50));

                // when register.js finishes populate it dispatches mvsg:populateDone — re-run apply
                try { window.addEventListener('mvsg:populateDone', applyWithRetry); } catch(e){}

                // if another window/tab writes rpi_personal or register writes it, catch storage events
                try { window.addEventListener('storage', function(e){ if (e && (e.key === 'rpi_personal' || e.key === 'registrationDraft')) setTimeout(applyWithRetry, 80); }); } catch(e){}
            })();
        </script>
</body>

</html>
