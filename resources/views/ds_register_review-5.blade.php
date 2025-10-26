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
        onclick="window.location.href='{{ route('registerreview4') }}'">
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
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200">
                🔊
            </button>
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
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md 
           hover:bg-green-800 hover:scale-105 transition-transform duration-200">
                🔊
            </button>
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
                <span
                    class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm">
                    Chosen Work
                </span>
                <span
                    class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm">
                    Chosen Work
                </span>
            </div>

            <!-- Change Jobs -->
            <div class="flex justify-center mt-6">
                <button type="button"
                    class="bg-[#2E2EFF] hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition-transform duration-200 hover:scale-105">
                    ✏️ Change
                </button>
            </div>
        </div>

        <!-- Continue Buttons -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">
            <button type="button"
                class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
            px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
            shadow-md w-full sm:w-64 text-center"
                onclick="window.location.href='{{ route('registerfinalstep') }}'">
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
        // Exhaustive loader for job preferences (includes nested jobPref1.jobpref1 and flat fields)
        document.addEventListener('DOMContentLoaded', async () => {
            const tryParse = s => {
                try {
                    return typeof s === 'string' ? JSON.parse(s) : s;
                } catch (e) {
                    return null;
                }
            };
            const readStored = (key) => {
                try {
                    const s = localStorage.getItem(key) || sessionStorage.getItem(key);
                    if (s) {
                        try {
                            return JSON.parse(s);
                        } catch (e) {
                            return s;
                        }
                    }
                    const g = window.registrationDraft || window.__REGISTRATION_DRAFT__;
                    if (g) {
                        try {
                            const parsed = typeof g === 'string' ? JSON.parse(g) : g;
                            if (parsed && parsed[key] !== undefined) return parsed[key];
                        } catch (e) {}
                    }
                    return null;
                } catch (e) {
                    return null;
                }
            };
            const getDraft = async () => {
                const keys = ['registrationDraft', 'registration_draft', 'dsRegistrationDraft',
                    'ds_registration', 'registerDraft', 'regDraft', 'reg_data'
                ];
                for (const k of keys) {
                    const v = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
                    if (v && typeof v === 'object') return v;
                }
                if (window.registrationDraft || window.__REGISTRATION_DRAFT__) {
                    try {
                        return typeof window.registrationDraft === 'string' ? tryParse(window
                            .registrationDraft) : (window.registrationDraft || tryParse(window
                            .__REGISTRATION_DRAFT__));
                    } catch (e) {}
                }
                if (window.firebase && firebase.auth && firebase.firestore) {
                    try {
                        const auth = firebase.auth(),
                            db = firebase.firestore();
                        let user = auth.currentUser;
                        if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(
                            res));
                        if (user) {
                            const doc = await db.collection('users').doc(user.uid).get().catch(() =>
                                null);
                            if (doc && doc.exists) return doc.data();
                        }
                    } catch (e) {}
                }
                return null;
            };
            // gather possible job pref arrays/strings
            const a1 = readStored('jobpref1') || readStored('jobPref1') || readStored('jobpref') || readStored(
                'jobpref1') || [];
            const a2 = readStored('jobpref2') || readStored('jobPref2') || readStored('jobpref2') || [];
            const flat = [].concat(Array.isArray(a1) ? a1 : (typeof a1 === 'string' ? a1.split(',') : []));
            flat.push(...(Array.isArray(a2) ? a2 : (typeof a2 === 'string' ? a2.split(',') : [])));
            const prefs = flat.map(x => typeof x === 'string' ? x.trim() : x).filter(Boolean);
            if (prefs.length) {
                const el = document.getElementById('review_jobprefs');
                if (el) el.textContent = prefs.join(', ');
                setChoiceImage('review_jobprefs_img', prefs[0], ['.jobpref-card', '.selectable-card']);
                document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card => {
                    const title = card.querySelector('h3')?.textContent?.trim();
                    if (title && prefs.includes(title)) card.classList.add('selected');
                    else card.classList.remove('selected');
                });
            }
            // also attempt to hydrate from draft if needed (non-blocking)
            try {
                const data = await getDraft();
                if (data && !prefs.length) {
                    const fallback = Array.isArray(data.jobPreferences) ? data.jobPreferences : (Array.isArray(
                        data.jobpref1?.jobpref1) ? data.jobpref1.jobpref1 : []);
                    if (fallback && fallback.length) {
                        const el = document.getElementById('review_jobprefs');
                        if (el) el.textContent = fallback.join(', ');
                        setChoiceImage('review_jobprefs_img', fallback[0], ['.jobpref-card',
                            '.selectable-card'
                        ]);
                        document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card => {
                            const title = card.querySelector('h3')?.textContent?.trim();
                            if (title && fallback.includes(title)) card.classList.add('selected');
                            else card.classList.remove('selected');
                        });
                    }
                }
            } catch (e) {
                /* ignore non-fatal */
            }
        });
    </script>
</body>

</html>
