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

        <!-- Show exact image for selected relationship (preview card, hidden when no selection) -->
        <div id="review_guardian_relationship_container" class="mt-4 text-center" style="display:none;">
          <div class="inline-flex items-center justify-center w-36 h-36 bg-white rounded-xl shadow-md p-2 mx-auto">
            <img id="review_guardian_relationship_img" src="" alt="Selected relationship image" class="w-full h-full object-contain rounded-md" />
          </div>
        </div>

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
+    // unified robust preview loader (tries local/session, registrationDraft globals, then Firestore)
+    document.addEventListener('DOMContentLoaded', async () => {
+      const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
+      const initFirebase = () => {
+        try {
+          if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) {
+            firebase.initializeApp(window.FIREBASE_CONFIG);
+          }
+        } catch(e){ console.warn('initFirebase', e); }
+      };
+      const fetchFirestoreDraft = async () => {
+        if (!window.firebase || !firebase.auth || !firebase.firestore) return null;
+        initFirebase();
+        try {
+          const auth = firebase.auth(), db = firebase.firestore();
+          let user = auth.currentUser;
+          if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
+          if (!user) return null;
+          // try common collections where drafts may be stored
+          const cols = ['registrations','users','registrationDrafts','profiles'];
+          for (const c of cols) {
+            try {
+              const snap = await db.collection(c).doc(user.uid).get().catch(()=>null);
+              if (snap && snap.exists) return snap.data();
+            } catch(e){ /* ignore per-collection errors */ }
+          }
+        } catch(e){ console.warn('fetchFirestoreDraft', e); }
+        return null;
+      };
+      const readStored = async () => {
+        // prefer registrationDraft aliases in storage/globals, otherwise try Firestore
+        const keys = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data','rpi_personal'];
+        for (const k of keys) {
+          const s = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
+          if (s && typeof s === 'object') return s;
+        }
+        if (window.registrationDraft || window.__REGISTRATION_DRAFT__) {
+          try { return typeof window.registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window.registrationDraft || window.__REGISTRATION_DRAFT__); } catch(e){}
+        }
+        // final attempt: Firestore
+        return await fetchFirestoreDraft();
+      };
+
+      const flatten = (obj, out = {}, prefix = '') => {
+        if (!obj || typeof obj !== 'object') return out;
+        for (const k of Object.keys(obj)) {
+          const v = obj[k];
+          const p = prefix ? `${prefix}.${k}` : k;
+          if (v && typeof v === 'object' && !Array.isArray(v)) flatten(v, out, p);
+          else out[p] = v;
+        }
+        return out;
+      };
+      const findFirstMatching = (obj, subs=[]) => {
+        try {
+          const flat = flatten(obj || {});
+          for (const sub of subs) {
+            const s = sub.toLowerCase();
+            for (const k of Object.keys(flat)) {
+              if (k.toLowerCase().includes(s) && flat[k]) return flat[k];
+            }
+          }
+        } catch(e){ /* ignore */ }
+        return '';
+      };
+
+      const safeSet = (id, value) => { const el = document.getElementById(id); if(!el) return; if(el.tagName==='INPUT'||el.tagName==='TEXTAREA') el.value = value ?? ''; else el.textContent = value ?? ''; };
+      const setChoiceImage = (placeholderId, value, cardSelectors = ['.guardian-card','.selectable-card']) => {
+        try {
+          const container = document.getElementById(`${placeholderId}_container`);
+          const ph = document.getElementById(placeholderId);
+          if (!value) { if (container) container.style.display = 'none'; if (ph) ph.src = ''; return; }
+          const target = String(value).trim().toLowerCase();
+          const selectors = Array.isArray(cardSelectors) ? cardSelectors : [cardSelectors];
+          selectors.forEach(sel => document.querySelectorAll(sel).forEach(n => n.classList.remove('selected')));
+          for (const sel of selectors) {
+            for (const n of document.querySelectorAll(sel)) {
+              const title = n.querySelector('h3')?.textContent?.trim()?.toLowerCase();
+              if (title && title === target) {
+                const img = n.querySelector('img');
+                if (img && ph) ph.src = img.src || '';
+                if (container) container.style.display = 'block';
+                n.classList.add('selected');
+                return;
+              }
+            }
+          }
+          if (container) container.style.display = 'none';
+          if (ph) ph.src = '';
+        } catch(e){ console.warn('setChoiceImage', e); }
+      };
+
+      try {
+        const data = await readStored();
+        if (!data) return;
+        // map common guardian fields
+        const p = data.personalInfo || data.personal || data;
+        safeSet('review_fname', p?.first_name || p?.firstName || p?.fname || '');
+        safeSet('review_lname', p?.last_name || p?.lastName || p?.lname || '');
+        safeSet('review_email', p?.email || p?.emailAddress || '');
+        safeSet('review_phone', p?.phone || p?.mobile || '');
+        safeSet('review_age', p?.age || '');
+
+        const g = data.guardianInfo || data.guardian || {};
+        safeSet('review_guardian_fname', g?.guardian_first_name || g?.first_name || data?.guardian_first_name || '');
+        safeSet('review_guardian_lname', g?.guardian_last_name || g?.last_name || data?.guardian_last_name || '');
+        safeSet('review_guardian_email', g?.guardian_email || g?.email || '');
+        safeSet('review_guardian_phone', g?.guardian_phone || g?.phone || '');
+        const guardianRel = g?.guardian_choice || g?.relationship || data?.guardian_choice || findFirstMatching(data, ['guardian_choice','relationship','guardian']);
+        safeSet('review_guardian_relationship', guardianRel || '');
+        setChoiceImage('review_guardian_relationship_img', guardianRel, ['.guardian-card','.selectable-card']);
+      } catch(e){ console.error('preview loader failed', e); }
+    });
    </script>
  </body>
</html>
