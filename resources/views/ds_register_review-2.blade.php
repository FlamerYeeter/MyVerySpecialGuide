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
      onclick="window.location.href='{{ route('registerreview1') }}'">
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
          Review Your Qualifications
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Kwalipikasyon)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>

        <!-- Education Information Section -->
        <h2 class="text-lg font-semibold mt-8">
          Education
          <span class="text-gray-600 italic text-base">(Edukasyon)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h2>
      </div>

      <!-- Education Information Form -->
      <form class="mt-6 max-w-xl mx-auto">
        <label class="font-semibold text-[15px] flex items-center gap-1">
          Your Highest Level of Education
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">(Pinakamataas mong natapos na grade o taon sa school)</p>
        <p class="font-semibold text-black-500 text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>

        <!-- Education level answer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
          <div class="bg-white p-4 rounded-xl shadow h-[340px] relative border-2 border-blue-500 selectable-card">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <img src="image/educ1.png" alt="elementary" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Elementary</h3>
          </div>    
        </div>

        <!-- Hidden Inputs for Review -->
        <input id="edu_level" type="hidden" value="" />

        <p class="mt-4">Selected: <span id="review_education_level">—</span></p>

        <!-- School Name -->
        <div class="max-w-xl mx-auto mt-8 text-left">
          <label class="font-semibold text-sm flex items-center gap-1">
            School Name
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Pangalan ng iyong paaralan</p>
          <input id="review_school_name" type="text" placeholder="School Name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" readonly />
        </div>

        <!-- Certificates and Training -->
        <div class="max-w-xl mx-auto mt-8 text-left">
          <label class="font-semibold text-sm flex items-center gap-1">
            Certificates or Special Trainings
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Mga Certificates or Special Trainings</p>
          <input id="review_certs" type="text" placeholder="Certificates or Trainings" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" readonly />
        </div>

        <!-- Edit Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang “Edit Education Information” upang baguhin ang iyong sagot)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            ✏️ Click to Edit Education Information
          </button>
        </div>
      </form>

      <!-- Work Experience Section -->
      <div class="mt-12 max-w-xl mx-auto">
        <h2 class="text-lg font-semibold">
          Work Experience
          <span class="text-gray-600 italic text-base">(Karanasan sa Trabaho)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h2>

        <label class="font-semibold text-[15px] flex items-center gap-1 mt-6">
          Have you worked before?
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">(Nakapagtrabaho ka na dati?)</p>

        <p class="font-semibold text-black-500 text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>

        <!-- Work yr answer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
          <div class="bg-white p-4 rounded-xl shadow h-[340px] relative border-2 border-blue-500">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/workyr1.png" alt="less 1 yr" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Less than 1 year</h3>
          </div>
        </div>

        <!-- Work Experience Card --> <!-- Fetch user input -->
        <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 mt-6 shadow-sm">
          <div class="flex justify-between items-start">
            <p class="font-semibold">Company Name</p>
            <p class="font-semibold">Work Year</p>
          </div>
          <p class="font-semibold mt-2">Job Title</p>
          <ul class="list-disc list-inside mt-2 text-[15px]">
            <li>Job Description</li>
            <li>Job Description</li>
          </ul>
        </div>

        <!-- Edit Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang “Edit Work Experience” upang baguhin ang iyong sagot)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            ✏️ Click to Edit Work Experience
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-6 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black-800 leading-relaxed">
              This information will help us match you with the best job opportunities.
            </p>
            <button type="button" class="text-green-600 text-xl leading-none hover:text-green-700 hover:scale-110 transition-transform mt-[2px]" title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Ang impormasyong ito ay makakatulong sa amin na maitugma ka sa mga angkop na oportunidad sa trabaho.)
          </p>
        </div>
      </div>

      <!-- Continue Button -->
      <div class="text-center mt-12">
        <button type="button" class="bg-blue-500 text-white font-semibold text-lg px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center mx-auto shadow-md"
                onclick="window.location.href='{{ route('registerreview3') }}'">
          Continue →
        </button>
        <p class="text-gray-700 text-sm mt-3">
          Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
        <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Continue” upang magpatuloy)</p>
      </div>

    </div>

    <script src="{{ asset('js/register.js') }}"></script>
    <script>
      // Same exhaustive loader used across review pages (populates personal/guardian/education/skills/jobs/support/workplace/workExperience)
      document.addEventListener('DOMContentLoaded', async () => {
        // ensure helpers exist globally (no-op if already created)
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
        // local aliases
        const flatten = window.__mvsg_flatten;
        const findFirstMatching = window.__mvsg_findFirstMatching;

        // start loader logic directly in this single DOMContentLoaded handler
        const safeSet = (id, value) => { const el = document.getElementById(id); if(!el) return; if(el.tagName==='INPUT' || el.tagName==='TEXTAREA') el.value = value ?? ''; else el.textContent = value ?? ''; };
        const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch (e) { return null; } };
        const keysToCheck = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data'];
        const scanStorageAll = () => { const out=[]; try{ for(let i=0;i<localStorage.length;i++){ const k=localStorage.key(i); out.push({key:k,parsed:tryParse(localStorage.getItem(k))}); } }catch(e){} try{ for(let i=0;i<sessionStorage.length;i++){ const k=sessionStorage.key(i); out.push({key:k,parsed:tryParse(sessionStorage.getItem(k)),session:true}); } }catch(e){} return out; };
        const mergeSections = (acc,obj) => { if(!obj||typeof obj!=='object') return acc; for(const k of Object.keys(obj)) acc[k] = { ...(acc[k]||{}), ...(obj[k]||{}) }; const personalKeys=['first_name','firstName','last_name','lastName','email','phone','age','school_name']; for(const pk of personalKeys) if(obj[pk]!==undefined){ acc.personalInfo = acc.personalInfo||{}; acc.personalInfo[pk]=obj[pk]; } return acc; };
        const getDraft = async () => {
          if(window.registrationDraft){ const p=tryParse(window.registrationDraft); if(p) return p; }
          if(window.__REGISTRATION_DRAFT__){ const p=tryParse(window.__REGISTRATION_DRAFT__); if(p) return p; }
          for(const k of keysToCheck){ try{ const s=sessionStorage.getItem(k); if(s){ const p=tryParse(s); if(p) return p; } const l=localStorage.getItem(k); if(l){ const p=tryParse(l); if(p) return p; } }catch(e){} }
          const all = scanStorageAll(); let agg={}; for(const e of all){ if(!e.parsed) continue; const keys=Object.keys(e.parsed).map(x=>x.toLowerCase()); const anyPersonal = keys.some(k=>['first_name','firstname','last_name','lastname','email','phone','age','school_name'].includes(k)); const anySection = keys.some(k=>['guardian','personal','education','skills','job','workplace','support','workexperience'].some(s=>k.includes(s))); if(anyPersonal||anySection) agg = mergeSections(agg,e.parsed); }
          if(Object.keys(agg).length) return agg;
          const el = document.getElementById('registrationDraftJson'); if(el){ const p = tryParse(el.textContent||el.value||el.innerText); if(p) return p; }
          if(window.firebase && firebase.auth && firebase.firestore){ try{ const auth=firebase.auth(), db=firebase.firestore(); let user=auth.currentUser; if(!user) user = await new Promise(res=>firebase.auth().onAuthStateChanged(res)); if(user){ const doc = await db.collection('users').doc(user.uid).get(); if(doc.exists) return doc.data(); const reg = await db.collection('registrations').doc(user.uid).get().catch(()=>null); if(reg && reg.exists) return reg.data(); } }catch(e){ console.warn('[review-2] firestore failed', e); } }
          return null;
        };

        try {
          const data = await getDraft();
          console.debug('[review-2] merged data:', data);
          // Debug: flattened dump to reveal exact keys
          try {
            const flat = (typeof flatten === 'function') ? flatten(data) : (function _f(o, out = {}, p = '') { if (!o || typeof o !== 'object') return out; for (const k of Object.keys(o)) { const v = o[k]; const np = p ? p + '.' + k : k; if (v && typeof v === 'object' && !Array.isArray(v)) _f(v, out, np); else out[np] = v; } return out; })(data);
            console.debug('[review-2] flattened keys:', Object.keys(flat).sort());
            console.debug('[review-2] flattened object:', flat);
          } catch (e) { console.warn('[review-2] flatten debug failed', e); }
          if(!data){ console.warn('[review-2] no data'); return; }

          // Personal
          const p = data.personalInfo || data.personal_info || data.personal || data.personalDetails || data;
          safeSet('review_fname', p.first_name || p.firstName || p.fname || '');
          safeSet('review_lname', p.last_name || p.lastName || p.lname || '');
          safeSet('review_email', p.email || p.emailAddress || '');
          safeSet('review_phone', p.phone || p.telephone || p.mobile || '');
          safeSet('review_age', p.age || p.years || '');

          // Guardian (flat fields or nested)
          const g = data.guardianInfo || data.guardian_info || data.guardian || {};
          const guardianFirst = g.guardian_first_name || g.first_name || data.guardian_first_name || g.firstName || '';
          const guardianLast = g.guardian_last_name || g.last_name || data.guardian_last_name || g.lastName || '';
          safeSet('review_guardian_fname', guardianFirst);
          safeSet('review_guardian_lname', guardianLast);
          safeSet('review_guardian_email', g.guardian_email || g.email || data.guardian_email || '');
          safeSet('review_guardian_phone', g.guardian_phone || g.phone || data.guardian_phone || '');
          safeSet('review_guardian_relationship', g.guardian_choice || g.relationship || data.guardian_choice || '');

          // Education (with fallback search)
          const edu = data.educationInfo || data.education_info || data.education || {};
          safeSet('review_education_level', edu.edu_level || edu.level || data.edu_level || findFirstMatching(data,['edu','education','level','school']));
          safeSet('review_school_name', edu.school_name || edu.school || data.school_name || findFirstMatching(data,['school','school_name','schoolname']));
          safeSet('review_certs', edu.certs || edu.certificates || data.certs || findFirstMatching(data,['cert','certificate','training']));

          // Exact-key fallbacks (schoolWorkInfo & educationInfo)
          if (data.schoolWorkInfo) {
            safeSet('review_school_name', data.schoolWorkInfo.school_name || data.schoolWorkInfo.school || '');
            safeSet('review_certs', data.schoolWorkInfo.certs || '');
            // sometimes work_type stored here indicates training/work category
            if (!document.getElementById('review_education_level')?.textContent?.trim()) {
              safeSet('review_education_level', data.schoolWorkInfo.edu_level || data.educationInfo?.edu_level || '');
            }
          }
          if (data.educationInfo) {
            safeSet('review_education_level', data.educationInfo.edu_level || data.educationInfo.edu_level || '');
          }

          // WorkExperience company fallback
          if(Array.isArray(data.workExperience) && data.workExperience.length){
            const exp = data.workExperience[0] || {};
            safeSet('review_company_name', exp.company || exp.companyName || exp.employer || '');
          } else {
            const fallbackCompany = findFirstMatching ? findFirstMatching(data, ['company','employer','organization','org']) : '';
            if (fallbackCompany) safeSet('review_company_name', fallbackCompany);
          }
        } catch(err){ console.error('[review-2] loader error', err); }
      }); // end single DOMContentLoaded handler
    </script>
  </body>
</html>
