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
      .selectable-card { border: 2px solid transparent; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
      .selectable-card.selected { border-color: #2563eb; box-shadow: 0 10px 30px rgba(37,99,235,0.14); transform: translateY(-6px); }
      .selectable-card.selected::after,
      .jobpref-card.selected::after { content: ""; position:absolute; right:10px; bottom:10px; width:44px; height:44px; background-image:url('/image/checkmark.png'); background-size:contain; background-repeat:no-repeat; }
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
      onclick="window.location.href='{{ route('registerreview4') }}'">
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
          Review Your Job Preferences
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Kakayanan)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>

        <h2 class="text-[15px] font-semibold mt-8">
          Please review the jobs you selected.
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
          <br />
          <span class="mt-8 text-[14px] text-gray-600 italic">(Pakisuri ang mga trabaho na iyong pinili)</span>
        </h2>
      </div>

      <!-- Job Preferences Information Form -->
      <form class="mt-6 max-w-xl mx-auto">
        <label class="font-semibold text-[15px] flex items-center gap-1">
          You can remove jobs by clicking the X button or add more by clicking "Add More Jobs".
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">
          (Maaari kang magtanggal ng trabaho sa pag-click ng ❌ button o magdagdag pa sa pag-click ng "Add More Jobs")
        </p>

        <p class="font-semibold text-black text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>

        <p class="mt-2">Selected jobs: <span id="review_jobprefs">—</span></p>
        <div id="review_jobprefs_img_container" class="mt-3 text-center" style="display:none;">
          <div class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
            <img id="review_jobprefs_img" src="" alt="Job preference image" class="w-full h-full object-contain rounded-md" />
          </div>
        </div>

        <!-- Job Preferences Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

          <!-- Card 1 -->
          <div
            class="bg-white p-4 rounded-xl shadow relative border-2 border-blue-500 group transition-all duration-300 hover:shadow-lg selectable-card">
            <!-- Audio button -->
            <button type="button"
              class="absolute top-3 left-10 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <!-- Remove button -->
            <button type="button"
              class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow transition"
              title="Remove Skill">❌</button>
            <img src="image/officework.png" alt="Office Work" class="w-full rounded-md mb-4" />
            <h3 class="text-blue-600 font-semibold text-center">Office Work</h3>
            <p class="text-sm mt-2 text-justify">
              In this job, you will use the computer for simple tasks, answer the phone politely, and keep papers organized in folders.
            </p>
            <p class="text-[13px] text-gray-500 italic mt-2 text-justify">
              (Sa trabahong ito, gagamit ka ng computer para sa simpleng gawain, sasagot ng telepono nang magalang, at aayusin ang mga papeles sa mga folder.)
            </p>
          </div>

          <!-- Card 2 -->
          <div
            class="bg-white p-4 rounded-xl shadow relative border-2 border-blue-500 group transition-all duration-300 hover:shadow-lg selectable-card">
            <!-- Audio button -->
            <button type="button"
              class="absolute top-3 left-10 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <!-- Remove button -->
            <button type="button"
              class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow transition"
              title="Remove Skill">❌</button>
            <img src="image/storework.png" alt="Store Work" class="w-full rounded-md mb-4" />
            <h3 class="text-blue-600 font-semibold text-center">Store Work</h3>
            <p class="text-sm mt-2 text-justify">
              You will help customers find what they need, place items neatly on shelves, and work at the cashier to take payments.
            </p>
            <p class="text-[13px] text-gray-500 italic mt-2 text-justify">
              (Tutulungan mo ang mga customer na hanapin ang kanilang kailangan, maayos na ilalagay ang mga paninda, at magtatrabaho sa cashier para tumanggap ng bayad.)
            </p>
          </div>
        </div>

        <!-- Add More Job Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang "Add More Jobs" upang baguhin ang iyong sagot.)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            <span class="text-xl mr-2">➕</span> Click to Add More Jobs
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-6 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black leading-relaxed">
              We use your job preferences to connect you with the right job, but some choices may not be hiring now.
            </p>
            <button type="button"
              class="text-green-600 text-xl leading-none hover:text-green-700 hover:scale-110 transition-transform mt-[2px]"
              title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Gagamitin namin ang iyong piniling trabaho upang mahanap ang angkop na posisyon, ngunit may pagkakataon maaaring walang hiring sa posisyon na ito.)
          </p>
        </div>

        <!-- Continue Button -->
        <div class="text-center mt-12">
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center mx-auto shadow-md"
            onclick="window.location.href='{{ route('registerfinalstep') }}'">
            Continue →
          </button>
          <p class="text-gray-700 text-sm mt-3">
            Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
          </p>
          <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Continue” upang magpatuloy)</p>
        </div>
      </form>
    </div>

  <script src="{{ asset('js/firebase-config-global.js') }}"></script>
  <script src="{{ asset('js/register.js') }}"></script>
   <script>
     // Exhaustive loader for job preferences (includes nested jobPref1.jobpref1 and flat fields)
     document.addEventListener('DOMContentLoaded', async () => {
      const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
      const readStored = (key) => {
        try { const s = localStorage.getItem(key) || sessionStorage.getItem(key); if (s) { try { return JSON.parse(s); } catch(e){ return s; } } const g = window.registrationDraft || window.__REGISTRATION_DRAFT__; if (g) { try { const parsed = typeof g === 'string' ? JSON.parse(g) : g; if (parsed && parsed[key] !== undefined) return parsed[key]; } catch(e){} } return null; } catch(e){ return null; }
      };
      const getDraft = async () => {
        const keys = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data'];
        for (const k of keys) { const v = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k)); if (v && typeof v === 'object') return v; }
        if (window.registrationDraft || window.__REGISTRATION_DRAFT__) { try { return typeof window.registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window.registrationDraft || tryParse(window.__REGISTRATION_DRAFT__)); } catch(e){} }
        if (window.firebase && firebase.auth && firebase.firestore) {
          try { const auth=firebase.auth(), db=firebase.firestore(); let user=auth.currentUser; if(!user) user = await new Promise(res=>firebase.auth().onAuthStateChanged(res)); if(user){ const doc = await db.collection('users').doc(user.uid).get().catch(()=>null); if(doc && doc.exists) return doc.data(); } } catch(e){}
        }
        return null;
      };
      // gather possible job pref arrays/strings
      const a1 = readStored('jobpref1') || readStored('jobPref1') || readStored('jobpref') || readStored('jobpref1') || [];
      const a2 = readStored('jobpref2') || readStored('jobPref2') || readStored('jobpref2') || [];
       const flat = [].concat(Array.isArray(a1) ? a1 : (typeof a1 === 'string' ? a1.split(',') : []));
       flat.push(...(Array.isArray(a2) ? a2 : (typeof a2 === 'string' ? a2.split(',') : [])));
       const prefs = flat.map(x=>typeof x==='string'?x.trim():x).filter(Boolean);
       if (prefs.length) {
         const el = document.getElementById('review_jobprefs'); if(el) el.textContent = prefs.join(', ');
         setChoiceImage('review_jobprefs_img', prefs[0], ['.jobpref-card','.selectable-card']);
         document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card=>{
           const title = card.querySelector('h3')?.textContent?.trim();
           if(title && prefs.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
         });
       }
      // also attempt to hydrate from draft if needed (non-blocking)
      try {
        const data = await getDraft();
        if (data && !prefs.length) {
          const fallback = Array.isArray(data.jobPreferences) ? data.jobPreferences : (Array.isArray(data.jobpref1?.jobpref1) ? data.jobpref1.jobpref1 : []);
          if (fallback && fallback.length) {
            const el = document.getElementById('review_jobprefs'); if(el) el.textContent = fallback.join(', ');
            setChoiceImage('review_jobprefs_img', fallback[0], ['.jobpref-card','.selectable-card']);
            document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card=>{
              const title = card.querySelector('h3')?.textContent?.trim();
              if(title && fallback.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
            });
          }
        }
      } catch(e){ /* ignore non-fatal */ }
   });
   </script>
  </body>
</html>