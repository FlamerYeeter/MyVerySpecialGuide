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
        onclick="window.location.href='{{ route('registerreview1') }}'">
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
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md"
                style="line-height: 1.15;">
                Review Your Education and <br>Work Information
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

            <!-- Education Info -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Education Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-800">
                    <!-- Education Level Image -->
                    <p><span class="font-semibold">Education Level:</span> <span id="review_edu"></span></p>
                    <p id="review_edu_other" class="text-gray-600 italic hidden">Other: </p>
                    <p class="col-span-2"><span class="font-semibold">School Name:</span> <span
                            id="review_school"></span></p>
                </div>
            </div>
            <!-- Certificates / Trainings -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Certificates & Trainings
                </h3>

                <!-- Certificate / Training Name -->
                <div class="text-gray-800 mb-3">
                    <p>
                        <span class="font-semibold">Certificates / Trainings:</span>
                        <span id="review_certs_name" class="ml-1">None</span>
                    </p>
                </div>

                <!-- Uploaded File Info -->
                <div class="text-gray-800">
                    <p>
                        <span class="font-semibold">Uploaded Certificates / Trainings:</span>
                        <span id="review_certs_file" class="ml-1">None</span>
                    </p>
                    <p class="text-sm text-gray-600 mt-1 italic">
                        <span id="review_certfile">No file uploaded</span>
                    </p>
                </div>
            </div>

            <!-- Work Experience -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Work Experience
                </h3>

                <!-- Type of Work --> <!-- The yes & no image-->
                <div class="text-gray-800 mb-5">
                    <p><span class="font-semibold">Type of Work:</span> <span id="review_work">N/A</span></p>
                </div>

                <!-- Job Experience List -->
                <div class="text-gray-800">
                    <h4 class="text-md font-semibold text-blue-700 mb-3">Job Experiences</h4>
                    <div id="review_job_experiences" class="space-y-4">
                        <!-- Dynamically filled from stored data -->
                        <p class="text-gray-600 italic">No job experiences added.</p>
                    </div>
                </div>
            </div>

            <!-- Support I Need -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Support I Need
                </h3>
                <div class="text-gray-800">
                    <p><span class="font-semibold">Selected Support:</span> <span id="review_support_choice">—</span>
                    </p>
                </div>
                <div id="review_support_choice_img_container" class="mt-4 text-center hidden">
                    <div
                        class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
                        <img id="review_support_choice_img" src="" alt="Support image"
                            class="w-full h-full object-contain rounded-md" />
                    </div>
                </div>
            </div>

            <!-- Work Environment -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Work Environment
                </h3>
                <div class="text-gray-800">
                    <p><span class="font-semibold">Preferred Workplace:</span> <span
                            id="review_workplace_choice">—</span></p>
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
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">
                <!-- Edit Button -->
                <button
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
                    onclick="window.location.href='{{ route('registerreview4') }}'">
                    Continue →
                </button>
            </div>

            <!-- Helper Text -->
            <div class="mt-6 text-center">
                <p class="text-gray-700 text-sm">
                    Click <span class="text-[#1E40AF] font-medium">“Continue”</span> to move to the next page
                </p>
                <p class="text-gray-600 italic text-[13px]">
                    (Pindutin ang “Continue” upang magpatuloy)
                </p>
            </div>


            <script src="{{ asset('js/firebase-config-global.js') }}"></script>
            <script src="{{ asset('js/register.js') }}"></script>
            <script>
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
                                    .length)) firebase.initializeApp(window.FIREBASE_CONFIG);
                        } catch (e) {}
                    };
                    const fetchFirestoreDraft = async () => {
                        if (!window.firebase) return null;
                        initFirebase();
                        try {
                            const auth = firebase.auth(),
                                db = firebase.firestore();
                            let user = auth.currentUser;
                            if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                            if (!user) return null;
                            for (const c of ['registrations', 'users', 'registrationDrafts', 'profiles']) {
                                const s = await db.collection(c).doc(user.uid).get().catch(() => null);
                                if (s && s.exists) return s.data();
                            }
                        } catch (e) {
                            console.warn(e);
                        }
                        return null;
                    };
                    const readStored = async () => {
                        const keys = ['registrationDraft', 'registration_draft', 'dsRegistrationDraft',
                            'ds_registration', 'registerDraft', 'regDraft', 'reg_data'
                        ];
                        for (const k of keys) {
                            const v = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
                            if (v && typeof v === 'object') return v;
                        }
                        if (window.registrationDraft || window.__REGISTRATION_DRAFT__) return typeof window
                            .registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window
                                .registrationDraft || window.__REGISTRATION_DRAFT__);
                        return await fetchFirestoreDraft();
                    };
                    const safeSet = (id, value) => {
                        const el = document.getElementById(id);
                        if (!el) return;
                        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = value ?? '';
                        else el.textContent = value ?? '';
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
                        const data = await readStored();
                        if (!data) return;
                        const edu = data.educationInfo || data.education || findFirstMatching(data, ['education', 'edu',
                            'edu_level'
                        ]) || '';
                        if (edu) setChoiceImage('review_education_level_img', edu, ['.education-card',
                            '.selectable-card'
                        ]);
                        const workYears = data.workExperience?.[0]?.years || data.work_years || findFirstMatching(data,
                            ['work_years', 'workexperience', 'years']) || '';
                        if (workYears) setChoiceImage('review_work_years_img', workYears, ['.workyr-card',
                            '.selectable-card'
                        ]);
                    } catch (e) {
                        console.error('review-2 preview', e);
                    }
                });
            </script>
</body>

</html>
