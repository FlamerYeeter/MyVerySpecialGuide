<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Floating animations */
      @keyframes float {
        0%, 100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-10px);
        }
      }
      .animate-float-slow {
        animation: float 5s ease-in-out infinite;
      }
      .animate-float-medium {
        animation: float 3.5s ease-in-out infinite;
      }
      .animate-float-fast {
        animation: float 2.5s ease-in-out infinite;
      }

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
        box-shadow: 0 10px 30px rgba(37,99,235,0.14);
        transform: translateY(-6px);
      }
    </style>
  </head>

  <body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0" />

    <img src="image/obj7.png" alt="Triangle Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0" />

    <img src="image/obj3.png" alt="Blue Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 top-1/4 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-fast z-0" />

    <img src="image/obj8.png" alt="Twin Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0" />

    <!-- Back Button -->
    <button
      class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center justify-center gap-2 text-center hover:bg-blue-600 transition z-10 shadow-md active:scale-95"
      onclick="window.location.href='{{ route('registerjobpreference2') }}'">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-base sm:text-lg font-medium">Back</span>
    </button>

    <!-- Main Container -->
    <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

      <!-- Header -->
      <div class="mt-4 flex flex-col items-start text-left max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 border-b-2 border-blue-500 pb-1 w-full">
          Review Your Profile
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Profile)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>

        <!-- Instruction -->
        <div class="mt-4">
          <p class="mt-2 text-base font-medium flex items-center gap-1.5">
            <span>Final Step: Review your information before creating your account</span>
            <button class="text-gray-500 text-lg hover:scale-110 transition-transform">🔊</button>
          </p>
          <p class="text-gray-500 italic text-[13px] mt-1 mb-12">
            (Huling Hakbang: Suriin muna ang iyong impormasyon bago gumawa ng account)
          </p>
        </div>

        <!-- Personal Information Section -->
        <h2 class="text-lg font-semibold border-b-2 border-black mb-4 w-full">
          Personal Information
          <span class="text-gray-600 italic text-base">(Impormasyon Tungkol sa Iyo)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>
      </div>

      <!-- Personal Information Form -->
      <form class="mt-6 max-w-xl mx-auto">

        <!-- First & Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 text-left">
          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              First Name
              <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Unang Pangalan</p>
            <input id="review_fname" type="text" placeholder="First name"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>

          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              Last Name
              <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Apelyido</p>
            <input id="review_lname" type="text" placeholder="Last name"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>
        </div>

        <!-- Email and Phone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 text-left mt-8">
          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              Email Address
              <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Email</p>
            <input id="review_email" type="email" placeholder="Email"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>

          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              Phone Number
              <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Telepono</p>
            <input id="review_phone" type="tel" placeholder="+63 9XX XXX XXXX"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>
        </div>

        <!-- Age -->
        <div class="mt-8">
          <label class="font-semibold text-sm flex items-center gap-1">
            Age
            <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Edad</p>
          <input id="review_age" type="number" placeholder="Age"
            class="mt-1 w-full md:w-1/2 border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
            readonly />
        </div>

        <!-- Edit Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang “Edit Personal Information” upang baguhin ang iyong sagot)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            ✏️ Click to Edit Personal Information
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-5 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black-800 leading-relaxed">
              This information will help us create your job recommendation account and find the best job for you.
            </p>
            <button type="button"
              class="text-green-600 text-xl hover:text-green-700 hover:scale-110 transition-transform mt-[2px]"
              title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Ang impormasyong ito ay makakatulong sa amin na gumawa ng iyong job recommendation account at makahanap ng pinakaangkop na trabaho para sa iyo)
          </p>
        </div>
      </form>

      <!-- Parent/Guardian Information Section -->
      <h2 class="text-lg font-semibold border-b-2 border-black mt-12 mb-4 w-full max-w-xl mx-auto">
        Parent/Guardian
        <span class="text-gray-600 italic text-base">(Impormasyon ng Magulang o Tagapag-alaga)</span>
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
      </h2>

      <form class="mt-6 max-w-xl mx-auto">

        <!-- First & Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 text-left">
          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              First Name
              <button type="button"
                class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Unang Pangalan</p>
            <input id="review_guardian_fname" type="text" placeholder="First name"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>

          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              Last Name
              <button type="button"
                class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Apelyido</p>
            <input id="review_guardian_lname" type="text" placeholder="Last name"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>
        </div>

        <!-- Email and Phone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 text-left mt-8">
          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              Email Address
              <button type="button"
                class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Email</p>
            <input id="review_guardian_email" type="email" placeholder="Email"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>

          <div>
            <label class="font-semibold text-sm flex items-center gap-1">
              Phone Number
              <button type="button"
                class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
            </label>
            <p class="text-gray-500 italic text-[13px]">Telepono</p>
            <input id="review_guardian_phone" type="tel" placeholder="+63 9XX XXX XXXX"
              class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
              readonly />
          </div>
        </div>

        <!-- Relationship -->
        <div class="mt-8">
          <label class="font-semibold text-sm flex items-center gap-1">
            Relationship to Applicant
            <button type="button"
              class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
          </label>
          <p class="mt-2 text-gray-500 italic text-[14px]">Kaano-ano mo siya?</p>
          <p class="font-semibold text-black-500 text-[15px]  mt-8">
             The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button"
              class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>
        <input id="review_guardian_relationship" type="hidden" value="" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <!-- Guardian relationship answer -->
        <div id="guardian_card_parent" class="bg-white p-4 rounded-xl shadow h-[340px] relative border-2 border-blue-500 selectable-card">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/guardian1.png" alt="parent" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Parent</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Magulang - Nanay o Tatay)</p>
        </div>    
        </div>

        <!-- Edit Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang “Edit Parent/Guardian Information” upang baguhin ang iyong sagot)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            ✏️ Click to  Edit Parent/Guardian Information
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-5 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black-800 leading-relaxed">
              This information will help us verify your parent or guardian's contact details for emergency or guidance purposes.
            </p>
            <button type="button"
              class="text-green-600 text-xl hover:text-green-700 hover:scale-110 transition-transform mt-[2px]"
              title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Makakatulong ang impormasyong ito upang ma-verify ang detalye ng iyong magulang o tagapag-alaga para sa mga emergency o panggabayan na layunin)
          </p>
        </div>
      </form>
    </div>
    <!-- Continue Button -->
      <div class="text-center mt-12">
        <button type="button"
          class="bg-blue-500 text-white font-semibold text-lg px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center mx-auto shadow-md"
          onclick="window.location.href='{{ route('registerreview2') }}'">
          Continue →
        </button>
        <p class="text-gray-700 text-sm mt-3">
          Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
        <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Continue” upang magpatuloy)</p>
      </div>
    <script src="{{ asset('js/register.js') }}"></script>
    <script>
      // Expanded exhaustive preview loader with explicit Firestore-field mappings (guardian_first_name, guardian_choice, jobPref1.jobpref1)
      document.addEventListener('DOMContentLoaded', async () => {
        // fallback utilities: flatten and find first matching key substring
        const flatten = (obj, out = {}, prefix = '') => {
          if (!obj || typeof obj !== 'object') return out;
          for (const k of Object.keys(obj)) {
            const val = obj[k];
            const path = prefix ? `${prefix}.${k}` : k;
            if (val && typeof val === 'object' && !Array.isArray(val)) flatten(val, out, path);
            else out[path] = val;
          }
          return out;
        };
        const findFirstMatching = (obj, substrings) => {
          const flat = flatten(obj);
          const lowered = Object.keys(flat).map(k => [k, String(flat[k])]);
          for (const substr of substrings) {
            const s = substr.toLowerCase();
            for (const [k, v] of lowered) {
              if (k.toLowerCase().includes(s) && v && v.trim()) return v;
            }
          }
          return '';
        };

        const safeSet = (id, value) => {
          const el = document.getElementById(id);
          if (!el) return;
          if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = value ?? '';
          else el.textContent = value ?? '';
        };

        const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch (e) { return null; } };
        const keysToCheck = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data'];

        const scanStorageAll = () => {
          const found = [];
          try { for (let i = 0; i < localStorage.length; i++) { const k = localStorage.key(i); const v = localStorage.getItem(k); found.push({key:k,parsed:tryParse(v)}); } } catch(e){}
          try { for (let i = 0; i < sessionStorage.length; i++) { const k = sessionStorage.key(i); const v = sessionStorage.getItem(k); found.push({key:k,parsed:tryParse(v),session:true}); } } catch(e){}
          return found;
        };

        const mergeSections = (acc, obj) => {
          if (!obj || typeof obj !== 'object') return acc;
          const sectionNames = ['personalInfo','guardianInfo','educationInfo','skills','jobPreferences','supportNeed','workplace','workExperience','schoolWorkInfo','skillsPage1','jobPref1','jobPref2'];
          for (const k of Object.keys(obj)) {
            if (sectionNames.includes(k) || k.toLowerCase().includes('personal') || k.toLowerCase().includes('guardian')) {
              acc[k] = { ...(acc[k] || {}), ...(obj[k] || {}) };
            } else {
              acc[k] = acc[k] || obj[k];
            }
          }
          const personalKeys = ['first_name','firstName','last_name','lastName','email','phone','age','school_name'];
          for (const pk of personalKeys) if (obj[pk] !== undefined) { acc.personalInfo = acc.personalInfo || {}; acc.personalInfo[pk] = obj[pk]; }
          return acc;
        };

        const getDraft = async () => {
          if (window.registrationDraft) { console.debug('[review-1] window.registrationDraft'); const p = tryParse(window.registrationDraft); if (p) return p; }
          if (window.__REGISTRATION_DRAFT__) { console.debug('[review-1] window.__REGISTRATION_DRAFT__'); const p = tryParse(window.__REGISTRATION_DRAFT__); if (p) return p; }
          for (const k of keysToCheck) {
            try {
              const s = sessionStorage.getItem(k); if (s) { const p = tryParse(s); console.debug('[review-1] session key', k, p); if (p) return p; }
              const l = localStorage.getItem(k); if (l) { const p = tryParse(l); console.debug('[review-1] local key', k, p); if (p) return p; }
            } catch (e) {}
          }
          const all = scanStorageAll(); console.debug('[review-1] scanned entries', all.length);
          let aggregate = {};
          for (const entry of all) {
            if (!entry.parsed) continue;
            const obj = entry.parsed;
            const keys = Object.keys(obj).map(x => x.toLowerCase());
            const anyPersonal = keys.some(k => ['first_name','firstname','last_name','lastname','email','phone','age'].includes(k));
            const anySection = keys.some(k => ['guardian','personal','education','skills','job','workplace','support','schoolwork','jobpref','skillspage'].some(s => k.includes(s)));
            if (anyPersonal || anySection) { console.debug('[review-1] merging candidate', entry.key, obj); aggregate = mergeSections(aggregate, obj); }
          }
          if (Object.keys(aggregate).length) return aggregate;
          const el = document.getElementById('registrationDraftJson');
          if (el) { const p = tryParse(el.textContent || el.value || el.innerText); if (p) { console.debug('[review-1] DOM draft'); return p; } }
          if (window.firebase && firebase.auth && firebase.firestore) {
            try {
              const auth = firebase.auth(), db = firebase.firestore();
              let user = auth.currentUser;
              if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
              if (user) {
                const doc = await db.collection('users').doc(user.uid).get();
                if (doc.exists) { console.debug('[review-1] Firestore user doc'); return doc.data(); }
                const regDoc = await db.collection('registrations').doc(user.uid).get().catch(()=>null);
                if (regDoc && regDoc.exists) { console.debug('[review-1] Firestore registrations doc'); return regDoc.data(); }
              }
            } catch (e) { console.warn('[review-1] Firestore attempt failed', e); }
          }
          return null;
        };

        try {
          const data = await getDraft();
          console.debug('[review-1] merged data:', data);
          // Debug: print flattened keys/object so we can see exact field names from storage/Firestore
          try {
            const flat = (typeof flatten === 'function') ? flatten(data) : (function _f(o, out = {}, p = '') { if (!o || typeof o !== 'object') return out; for (const k of Object.keys(o)) { const v = o[k]; const np = p ? p + '.' + k : k; if (v && typeof v === 'object' && !Array.isArray(v)) _f(v, out, np); else out[np] = v; } return out; })(data);
            console.debug('[review-1] flattened keys:', Object.keys(flat).sort());
            console.debug('[review-1] flattened object:', flat);
          } catch (e) { console.warn('[review-1] flatten debug failed', e); }
          if (!data) { console.warn('[review-1] no registration data found'); return; }

          // Personal
          const p = data.personalInfo || data.personal_info || data.personal || data.personalDetails || data;
          safeSet('review_fname', p.first_name || p.firstName || p.fname || p.first || '');
          safeSet('review_lname', p.last_name || p.lastName || p.lname || p.last || '');
          safeSet('review_email', p.email || p.emailAddress || p.email_address || '');
          safeSet('review_phone', p.phone || p.telephone || p.mobile || '');
          safeSet('review_age', p.age || p.years || '');

          // Guardian - support both guardianInfo.* and flat guardian_* fields (as in your screenshot)
          const g = data.guardianInfo || data.guardian_info || data.guardian || {};
          // Firestore screenshot shows fields like guardian_first_name / guardian_choice
          const guardianFirst = g.guardian_first_name || g.guardianFirstName || g.first_name || g.firstName || g.fname || data.guardian_first_name || '';
          const guardianLast = g.guardian_last_name || g.guardianLastName || g.last_name || g.lastName || g.lname || data.guardian_last_name || '';
          const guardianEmail = g.guardian_email || g.guardianEmail || g.email || data.guardian_email || '';
          const guardianPhone = g.guardian_phone || g.guardianPhone || g.phone || data.guardian_phone || '';
          const guardianChoice = g.guardian_choice || g.guardianChoice || g.relationship || g.relation || data.guardian_choice || '';
          safeSet('review_guardian_fname', guardianFirst);
          safeSet('review_guardian_lname', guardianLast);
          safeSet('review_guardian_email', guardianEmail);
          safeSet('review_guardian_phone', guardianPhone);
          safeSet('review_guardian_relationship', guardianChoice);
          console.debug('[review-1] guardian mapped:', { guardianFirst, guardianLast, guardianEmail, guardianPhone, guardianChoice });
          const parentCard = document.getElementById('guardian_card_parent');
          if (parentCard) { if ((guardianChoice || '').toString().toLowerCase().includes('parent')) parentCard.classList.add('selected'); else parentCard.classList.remove('selected'); }

          // Education fields (with fallback search)
          const edu = data.educationInfo || data.education_info || data.education || data.schoolWorkInfo || {};
          safeSet('review_education_level', edu.edu_level || edu.eduLevel || edu.level || data.edu_level || findFirstMatching(data, ['education','edu_level','level','school','school_name']));
          safeSet('review_school_name', edu.school_name || edu.school || data.school_name || findFirstMatching(data, ['school','school_name','schoolname']));
          safeSet('review_certs', edu.certs || edu.certificates || data.certs || findFirstMatching(data, ['cert','certificate','training']));

          // Explicit exact-key fallbacks from Firestore screenshot (schoolWorkInfo, educationInfo)
          if (data.schoolWorkInfo) {
            safeSet('review_school_name', data.schoolWorkInfo.school_name || data.schoolWorkInfo.school || document.getElementById('review_school_name')?.value || '');
            safeSet('review_certs', data.schoolWorkInfo.certs || data.schoolWorkInfo.certificate || document.getElementById('review_certs')?.value || '');
            // some flows store work_type or edu level under schoolWorkInfo
            if (!document.getElementById('review_education_level')?.textContent?.trim()) {
              safeSet('review_education_level', data.schoolWorkInfo.edu_level || data.schoolWorkInfo.work_type || document.getElementById('review_education_level')?.textContent || '');
            }
          }
          if (data.educationInfo) {
            safeSet('review_education_level', data.educationInfo.edu_level || data.educationInfo.edu_level || document.getElementById('review_education_level')?.textContent || '');
          }

          // Exact workplace mapping shown in screenshot
          if (data.workplace && (data.workplace.workplace_choice !== undefined)) {
            safeSet('review_workplace_choice', data.workplace.workplace_choice);
          }
        } catch (err) {
          console.error('[review-1] Preview loader error', err);
        }
      });
    </script>
  </body>
</html>
