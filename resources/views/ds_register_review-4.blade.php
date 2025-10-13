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
      onclick="window.location.href='{{ route('registerreview3') }}'">
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
          Review Your Skills
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Kakayanan)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>

        <h2 class="text-[15px] font-semibold mt-8">
          Please review the skills you selected.
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
          <br />
          <span class="mt-8 text-[14px] text-gray-600 italic">(Pakisuri ang mga kakayanan na iyong pinili)</span>
        </h2>
      </div>

      <!-- Skills Information Form -->
      <form class="mt-6 max-w-xl mx-auto">
        <label class="font-semibold text-[15px] flex items-center gap-1">
          You can remove skills by clicking the ❌ button or add more by clicking "Add More Skills".
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">
          (Maaari kang magtanggal ng skills sa pag-click ng ❌ button o magdagdag pa sa pag-click ng "Add More Skills")
        </p>

        <p class="font-semibold text-black text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>

        <p class="mt-2">Selected skills: <span id="review_skills_list">—</span></p>

        <!-- Skills Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

          <!-- Card 1 -->
          <div class="bg-white p-4 rounded-xl shadow h-[360px] relative border-2 border-blue-500 group transition-all duration-300 hover:shadow-lg selectable-card">
            <!-- Audio button -->
            <button type="button" class="absolute top-3 left-10 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <!-- Remove button -->
            <button type="button"
              class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow transition"
              title="Remove Skill">❌</button>
            <img src="image/skill1.png" alt="talking to people" class="w-full rounded-md mb-4 mt-6" />
            <h3 class="text-blue-600 font-semibold text-center">Good at talking to people</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Magaling makipag-usap sa tao)</p>
          </div>

          <!-- Card 2 -->
          <div class="bg-white p-4 rounded-xl shadow h-[360px] relative border-2 border-blue-500 group transition-all duration-300 hover:shadow-lg selectable-card">
            <!-- Audio button -->
            <button type="button" class="absolute top-3 left-10 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <!-- Remove button -->
            <button type="button"
              class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow transition"
              title="Remove Skill">❌</button>
            <img src="image/skill2.png" alt="using computer" class="w-full rounded-md mb-4 mt-6" />
            <h3 class="text-blue-600 font-semibold text-center">Using Computer</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Paggamit ng computer)</p>
          </div>

        </div>

        <!-- Add More Skills Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang "Add More Skills" upang baguhin ang iyong sagot.)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            <span class="text-xl mr-2">➕</span> Click Add More Skills
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-6 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black leading-relaxed">
              Your skills help us know what kind of job is good for you.
            </p>
            <button type="button" class="text-green-600 text-xl leading-none hover:text-green-700 hover:scale-110 transition-transform mt-[2px]" title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Ang iyong mga kasanayan ay tumutulong sa amin na malaman kung anong uri ng trabaho ang nababagay sa iyo)
          </p>
        </div>

        <!-- Continue Button -->
        <div class="text-center mt-12">
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center mx-auto shadow-md"
            onclick="window.location.href='{{ route('registerreview5') }}'">
            Continue →
          </button>
          <p class="text-gray-700 text-sm mt-3">
            Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
          </p>
          <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Continue” upang magpatuloy)</p>
        </div>
      </form>
    </div>

    <script src="{{ asset('js/register.js') }}"></script>
    <script>
      // Exhaustive loader for skills and other review fields
      document.addEventListener('DOMContentLoaded', async () => {
        if (!window.__mvsg_flatten) {
          window.__mvsg_flatten = function flatten(obj, out = {}, prefix = '') {
            if (!obj || typeof obj !== 'object') return out;
            for (const k of Object.keys(obj)) {
              const v = obj[k];
              const p = prefix ? `${prefix}.${k}` : k;
              if (v && typeof v === 'object' && !Array.isArray(v)) window.__mvsg_flatten(v, out, p);
              else out[p] = v;
            }
            return out;
          };
        }
        if (!window.__mvsg_findFirstMatching) {
          window.__mvsg_findFirstMatching = function findFirstMatching(obj, subs) {
            const flat = window.__mvsg_flatten(obj || {});
            for (const sub of (subs || [])) {
              const s = sub.toLowerCase();
              for (const k of Object.keys(flat)) {
                if (k.toLowerCase().includes(s) && flat[k]) return flat[k];
              }
            }
            return '';
          };
        }
        const flatten = window.__mvsg_flatten;
        const findFirstMatching = window.__mvsg_findFirstMatching;

        // Exhaustive loader for skills and other review fields
        document.addEventListener('DOMContentLoaded', async () => {
          const safeSet = (id, value) => { const el=document.getElementById(id); if(!el) return; if(el.tagName==='INPUT'||el.tagName==='TEXTAREA') el.value = value ?? ''; else el.textContent = value ?? ''; };
          const tryParse = s => { try{ return typeof s==='string' ? JSON.parse(s) : s; }catch(e){ return null; } };
          const keysToCheck = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data'];
          const scanAll = () => { const out=[]; try{ for(let i=0;i<localStorage.length;i++){ const k=localStorage.key(i); out.push({key:k,parsed:tryParse(localStorage.getItem(k))}); } }catch(e){} try{ for(let i=0;i<sessionStorage.length;i++){ const k=sessionStorage.key(i); out.push({key:k,parsed:tryParse(sessionStorage.getItem(k)),session:true}); } }catch(e){} return out; };
          const merge = (acc,obj) => { if(!obj||typeof obj!=='object') return acc; for(const k of Object.keys(obj)) acc[k] = { ...(acc[k]||{}), ...(obj[k]||{}) }; return acc; };
          const getDraft = async ()=> {
            if(window.registrationDraft){ const p=tryParse(window.registrationDraft); if(p) return p; }
            if(window.__REGISTRATION_DRAFT__){ const p=tryParse(window.__REGISTRATION_DRAFT__); if(p) return p; }
            for(const k of keysToCheck){ try{ const s=sessionStorage.getItem(k); if(s){ const p=tryParse(s); if(p) return p; } const l=localStorage.getItem(k); if(l){ const p=tryParse(l); if(p) return p; } }catch(e){} }
            const all = scanAll(); let agg={}; for(const e of all){ if(!e.parsed) continue; const keysLower = Object.keys(e.parsed).map(x=>x.toLowerCase()); const any = keysLower.some(k=>['skills','skill','selectedskills','skilllist'].some(s=>k.includes(s))) || keysLower.some(k=>['first_name','email','guardian','education'].some(s=>k.includes(s))); if(any) agg = merge(agg,e.parsed); }
            if(Object.keys(agg).length) return agg;
            const el=document.getElementById('registrationDraftJson'); if(el){ const p=tryParse(el.textContent||el.value||el.innerText); if(p) return p; }
            if(window.firebase && firebase.auth && firebase.firestore){ try{ const a=firebase.auth(), db=firebase.firestore(); let user=a.currentUser; if(!user) user = await new Promise(res=>firebase.auth().onAuthStateChanged(res)); if(user){ const doc = await db.collection('users').doc(user.uid).get(); if(doc.exists) return doc.data(); } }catch(e){} }
            return null;
          };

          try {
            const data = await getDraft();
            console.debug('[review-4] merged', data);
            // Debug dump: flattened keys/object for mapping
            try {
              const flat = (typeof flatten === 'function') ? flatten(data) : (function _f(o, out = {}, p = '') { if (!o || typeof o !== 'object') return out; for (const k of Object.keys(o)) { const v = o[k]; const np = p ? p + '.' + k : k; if (v && typeof v === 'object' && !Array.isArray(v)) _f(v, out, np); else out[np] = v; } return out; })(data);
              console.debug('[review-4] flattened keys:', Object.keys(flat).sort());
              console.debug('[review-4] flattened object:', flat);
            } catch (e) { console.warn('[review-4] flatten debug failed', e); }
            if(!data){ console.warn('[review-4] no data'); return; }
            // common fields
            const p = data.personalInfo || data.personal || data; safeSet('review_fname', p.first_name||p.firstName||''); safeSet('review_lname', p.last_name||p.lastName||'');
            // skills (with fallback)
            const skillsRaw = data.skills || data.skillList || data.selectedSkills || data.skillsPage1 || (typeof findFirstMatching === 'function' ? findFirstMatching(data, ['skills','skill','selectedskills','skilllist']) : []);
            const skillArray = Array.isArray(skillsRaw) ? skillsRaw : (typeof skillsRaw === 'string' ? [skillsRaw] : []);
            if(skillArray.length) safeSet('review_skills_list', skillArray.join(', '));
            // explicit education/school fallback if present somewhere
            if (data.schoolWorkInfo) {
              safeSet('review_school_name', data.schoolWorkInfo.school_name || '');
              safeSet('review_certs', data.schoolWorkInfo.certs || '');
            }
            if (data.educationInfo) {
              safeSet('review_education_level', data.educationInfo.edu_level || data.educationInfo.edu_level || '');
            }
            document.querySelectorAll('.selectable-card').forEach(card => {
              const title = card.querySelector('h3')?.textContent?.trim();
              if(title && skills.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
            });
          } catch(err){ console.error('[review-4] loader error', err); }
        });
    </script>
  </body>
</html>
