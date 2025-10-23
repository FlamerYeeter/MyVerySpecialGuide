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
        onclick="window.location.href='adminapproval.html'">
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
                    <button type="button" class="text-xl hover:scale-110 transition-transform">🔊</button>
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
            <button id="editInfo"
                class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
           px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
           shadow-md w-full sm:w-64 text-center">
                ✏️ Edit Information
            </button>

            <!-- Continue Button -->
            <button type="button"
                class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
           px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
           shadow-md w-full sm:w-64 text-center"
                onclick="window.location.href='{{ route('registerreview2') }}'">
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
                if (!window.firebase || !firebase.auth || !firebase.firestore) return null;
                initFirebase();
                try {
                    const auth = firebase.auth(),
                        db = firebase.firestore();
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

            const safeSet = (id, value) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = value ?? '';
                else el.textContent = value ?? '';
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
                const data = await readStored();
                if (!data) return;
                // map common guardian fields
                const p = data.personalInfo || data.personal || data;
                safeSet('review_fname', p?.first_name || p?.firstName || p?.fname || '');
                safeSet('review_lname', p?.last_name || p?.lastName || p?.lname || '');
                safeSet('review_email', p?.email || p?.emailAddress || '');
                safeSet('review_phone', p?.phone || p?.mobile || '');
                safeSet('review_age', p?.age || '');
                const g = data.guardianInfo || data.guardian || {};
                safeSet('review_guardian_fname', g?.guardian_first_name || g?.first_name || data
                    ?.guardian_first_name || '');
                safeSet('review_guardian_lname', g?.guardian_last_name || g?.last_name || data
                    ?.guardian_last_name || '');
                safeSet('review_guardian_email', g?.guardian_email || g?.email || '');
                safeSet('review_guardian_phone', g?.guardian_phone || g?.phone || '');
                const guardianRel = g?.guardian_choice || g?.relationship || data?.guardian_choice ||
                    findFirstMatching(data, ['guardian_choice', 'relationship', 'guardian']);
                safeSet('review_guardian_relationship', guardianRel || '');
                setChoiceImage('review_guardian_relationship_img', guardianRel, ['.guardian-card',
                    '.selectable-card'
                ]);
            } catch (e) {
                console.error('preview loader failed', e);
            }
        });
    </script>
</body>

</html>
