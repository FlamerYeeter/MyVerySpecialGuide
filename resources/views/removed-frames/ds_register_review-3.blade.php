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

      .selectable-card { border: 2px solid transparent; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
      .selectable-card.selected { border-color: #2563eb; box-shadow: 0 10px 30px rgba(37,99,235,0.14); transform: translateY(-6px); }
      .selectable-card.selected::after,
      .support-card.selected::after,
      .workplace-card.selected::after { content: ""; position:absolute; right:10px; bottom:10px; width:44px; height:44px; background-image:url('/image/checkmark.png'); background-size:contain; background-repeat:no-repeat; }

      /* no global floating preview; per-field small preview containers are used */
    </style>
  </head>
<body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" class="fixed left-2 top-1/3 w-20 sm:w-28 opacity-90 animate-float-slow z-0" />
    <img src="image/obj7.png" class="fixed left-2 bottom-20 w-20 sm:w-28 opacity-90 animate-float-medium z-0" />
    <img src="image/obj3.png" class="fixed right-2 top-1/4 w-20 sm:w-28 opacity-90 animate-float-fast z-0" />
    <img src="image/obj8.png" class="fixed right-2 bottom-20 w-20 sm:w-28 opacity-90 animate-float-medium z-0" />

    <!-- Back Button -->
    <button
      class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-600 transition shadow-md active:scale-95"
  onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerreview2') }}')">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="font-medium text-base">Back</span>
    </button>

    <!-- Main Review Container -->
    <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

      <!-- Header -->
      <div class="text-left border-b-2 border-blue-500 pb-2">
        <h2 class="text-xl font-semibold text-blue-600 flex items-center gap-2">
          Review Your Qualifications
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Kwalipikasyon)</span>
        </h2>
      </div>

      <!-- Continue Button -->
      <div class="text-center mt-10">
        <button type="button"
          class="bg-blue-500 text-white font-semibold text-lg px-20 py-3 rounded-xl hover:bg-blue-600 transition shadow-md"
          onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerreview4') }}')">
          Continue →
        </button>
        <p class="text-gray-700 text-sm mt-3">
          Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
        </p>
        <p class="text-gray-500 italic text-sm">(Pindutin ang “Continue” upang magpatuloy)</p>
      </div>
    </div>


    <!-- removed global floating preview -->

  <script src="{{ asset('js/firebase-config-global.js') }}"></script>
  <script src="{{ asset('js/register.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', async () => {
        const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
        const initFirebase = () => { try { if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) firebase.initializeApp(window.FIREBASE_CONFIG); } catch(e){} };
        const fetchFirestoreDraft = async () => {
          if (!window.firebase) return null;
          initFirebase();
          try {
            const auth = firebase.auth(), db = firebase.firestore();
            let user = auth.currentUser; if (!user) user = await new Promise(res=>firebase.auth().onAuthStateChanged(res));
            if (!user) return null;
            for (const c of ['registrations','users','registrationDrafts','profiles']) {
              const s = await db.collection(c).doc(user.uid).get().catch(()=>null);
              if (s && s.exists) return s.data();
            }
          } catch(e){ console.warn(e); }
          return null;
        };
        const readStored = async () => {
          const keys = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data'];
          for (const k of keys) { const v = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k)); if (v && typeof v === 'object') return v; }
          if (window.registrationDraft || window.__REGISTRATION_DRAFT__) return typeof window.registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window.registrationDraft || window.__REGISTRATION_DRAFT__);
          return await fetchFirestoreDraft();
        };
        const safeSet = (id, value) => { const el=document.getElementById(id); if(!el) return; if(el.tagName==='INPUT'||el.tagName==='TEXTAREA') el.value = value ?? ''; else el.textContent = value ?? ''; };
        const setChoiceImage = (placeholderId, value, cardSelectors = ['.support-card','.workplace-card']) => {
          try {
            const container = document.getElementById(`${placeholderId}_container`);
            const ph = document.getElementById(placeholderId);
            if (!value) { if (container) container.style.display='none'; if (ph) ph.src=''; return; }
            const target = String(value).trim().toLowerCase();
            const selectors = Array.isArray(cardSelectors) ? cardSelectors : [cardSelectors];
            selectors.forEach(sel => document.querySelectorAll(sel).forEach(n=>n.classList.remove('selected')));
            for (const sel of selectors) {
              for (const n of document.querySelectorAll(sel)) {
                const title = n.querySelector('h3')?.textContent?.trim()?.toLowerCase();
                if(title && title === target){ const img = n.querySelector('img'); if(img && ph) ph.src = img.src||''; if(container) container.style.display='block'; n.classList.add('selected'); return; }
              }
            }
            if (container) container.style.display='none';
            if (ph) ph.src = '';
          } catch (e) { console.warn('setChoiceImage', e); }
        };
        try {
          const data = await readStored();
          if (!data) return;
          const support = data.supportNeed || data.support || findFirstMatching?.(data,['support','support_type']) || '';
          safeSet('review_support_choice', support || '');
          setChoiceImage('review_support_choice_img', support, ['.support-card','.selectable-card']);
          const workplace = data.workplace || data.workplaceInfo || findFirstMatching?.(data,['workplace','work_place','work']) || '';
          safeSet('review_workplace_choice', workplace || '');
          setChoiceImage('review_workplace_choice_img', workplace, ['.workplace-card','.selectable-card']);
        } catch(e){ console.error('review-3 preview', e); }
      });
    </script>
  </body>
</html>
