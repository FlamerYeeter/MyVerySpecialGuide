<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Final Step</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .animate-float-slow { animation: float 5s ease-in-out infinite; }
      .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
      .animate-float-fast { animation: float 2.5s ease-in-out infinite; }
    </style>
    <script>
      // Polyfill for crypto.randomUUID for older browsers or insecure contexts
      (function(){
        try {
          if (typeof self === 'undefined') return;
          if (!self.crypto) self.crypto = self.msCrypto || {};
          if (typeof self.crypto.randomUUID === 'function') return; // already available

          var getRandomBytes = function(count) {
            if (self.crypto && typeof self.crypto.getRandomValues === 'function') {
              var arr = new Uint8Array(count);
              self.crypto.getRandomValues(arr);
              return arr;
            }
            // fallback to Math.random when crypto not available (less secure)
            var arr2 = new Uint8Array(count);
            for (var i = 0; i < count; i++) arr2[i] = Math.floor(Math.random() * 256);
            return arr2;
          };

          self.crypto.randomUUID = function() {
            var bytes = getRandomBytes(16);
            // Per RFC4122 v4: set version and variant bits
            bytes[6] = (bytes[6] & 0x0f) | 0x40;
            bytes[8] = (bytes[8] & 0x3f) | 0x80;
            var hex = [];
            for (var i = 0; i < bytes.length; i++) hex.push(bytes[i].toString(16).padStart(2,'0'));
            return hex.slice(0,4).join('') + '-' + hex.slice(4,6).join('') + '-' + hex.slice(6,8).join('') + '-' + hex.slice(8,10).join('') + '-' + hex.slice(10,16).join('');
          };
        } catch (e) {
          // ignore - polyfill best-effort
        }
      })();
    </script>
  </head>

<body class="bg-white flex justify-center sm:items-center items-start min-h-screen p-4 sm:p-6 relative overflow-auto">

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
    class="fixed left-2 top-2 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl flex items-center gap-2 sm:gap-3 text-sm sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="window.location.href='{{ route('registerreview5') }}'">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
      class="w-4 h-4 sm:w-6 sm:h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </button>

  <!-- Main Container -->
  <div
    class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-4">
            <h1
                class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Final Step</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">
            <h2
                class="relative flex flex-wrap items-center justify-center gap-3 text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold">
                <span class="block mx-auto max-w-[82%] sm:max-w-none md:max-w-[85%] text-center md:pr-2 ">You’re almost there—just one more step!</span>
                <button type="button" class="ml-2 md:ml-3 text-sm sm:text-2xl bg-[#1E40AF] text-white p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn md:absolute md:right-3 md:top-1/2 md:-translate-y-1/2"
                    data-tts-en="You’re almost there—just one more step!" data-tts-tl="Malapit ka na—isang hakbang na lang!"
                    aria-label="Play audio for header">🔊</button>
            </h2>
            <p
                class="mt-2 sm:mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Malapit ka na—isang hakbang na lang!)
            </p>
        </div>

     <!-- Information Section -->
        <div
            class="info-card mt-6 sm:mt-8 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md relative">

              <!-- Desktop Audio Button -->
                <button type="button" aria-label="Play audio for info section"
                    class="hidden sm:block absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
                         text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
                            focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en=" Please check all the boxes below if you agree to the terms of agreement."
                            data-tts-tl="Paki-check ang mga kahon sa ibaba kung ikaw ay sumasang-ayon sa kasunduang ito.">
                            🔊
                </button>

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pr-4 sm:pr-16"> 
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 flex-shrink-0 mt-0.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-base sm:text-lg text-gray-700 font-bold leading-relaxed">
                    Please check all the boxes below if you agree to the terms of agreement.
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Paki-check ang mga kahon sa ibaba kung ikaw ay sumasang-ayon sa kasunduang ito.)
                    </p>
                    
                
                 <!-- Mobile Audio Button -->
                    <div class="mt-3 flex justify-center sm:hidden">
                        <button type="button" aria-label="Play audio for info section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                            transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please check all the boxes below if you agree to the terms of agreement."
                            data-tts-tl="Paki-check ang mga kahon sa ibaba kung ikaw ay sumasang-ayon sa kasunduang ito.">
                            🔊
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container mt-10 space-y-8 text-center sm:text-left mx-auto w-full max-w-6xl px-4 sm:px-0">

    <!-- Agreement Box -->
    <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-200 mt-6">
      <h3 class="text-lg sm:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2 text-center sm:text-left">
        Important Agreements <span class="text-blue-600 italic text-[18px]">(Mahalagang Kasunduan)</span>
      </h3>

      <!-- Agreement 1 -->
      <label
        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-blue-50 p-4 rounded-xl border-2 sm:border-4 border-blue-200 hover:bg-blue-100 transition mb-4 cursor-pointer">
        <div class="flex items-start gap-3 w-full">
          <input id="agree1" type="checkbox"
            class="w-6 h-6 mt-[2px] accent-[#2E2EFF] border-2 border-gray-400 rounded-md flex-shrink-0" />
          <div class="flex flex-col gap-1 w-full">
            <div class="flex items-center justify-between">
              <p class="text-[15px] sm:text-base font-medium text-gray-800 leading-snug">
                I agree to share my information with employers who are hiring.
              </p>
                      <button type="button"
                        class="tts-btn bg-[#1E40AF] text-white text-lg leading-none p-2 rounded-full shadow-md hover:bg-blue-700 hover:scale-110 transition-transform flex-shrink-0"
                        data-tts-en="I agree to share my information with employers who are hiring."
                        data-tts-tl="Sumasang-ayon akong ibahagi ang aking impormasyon sa mga employer na naghahanap ng empleyado."
                        aria-label="Read agreement 1 aloud in English then Filipino" title="Play Audio">🔊</button>
            </div>
            <p class="text-gray-600 italic text-sm leading-snug mt-1">
              (Sumasang-ayon akong ibahagi ang aking impormasyon sa mga employer na naghahanap ng empleyado.)
            </p>
          </div>
        </div>
      </label>

      <!-- Agreement 2 -->
      <label
        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-blue-50 p-4 rounded-xl border-2 sm:border-4 border-blue-200 hover:bg-blue-100 transition cursor-pointer">
        <div class="flex items-start gap-3 w-full">
          <input id="agree2" type="checkbox"
            class="w-6 h-6 mt-[2px] accent-[#2E2EFF] border-2 border-gray-400 rounded-md flex-shrink-0" />
          <div class="flex flex-col gap-1 w-full">
            <div class="flex items-center justify-between">
              <p class="text-[15px] sm:text-base font-medium text-gray-800 leading-snug">
                I understand that my information will be kept private and safe.
              </p>
              <button type="button"
                class="tts-btn bg-[#1E40AF] text-white text-lg leading-none p-2 rounded-full shadow-md hover:bg-blue-700 hover:scale-110 transition-transform flex-shrink-0"
                data-tts-en="I understand that my information will be kept private and safe."
                data-tts-tl="Nauunawaan ko na ang aking impormasyon ay papanatilihing pribado at ligtas."
                aria-label="Read agreement 2 aloud in English then Filipino" title="Play Audio">🔊</button>
            </div>
            <p class="text-gray-600 italic text-sm leading-snug mt-1">
              (Nauunawaan ko na ang aking impormasyon ay papanatilihing pribado at ligtas.)
            </p>
          </div>
        </div>
      </label>


    </div>

    <!-- Info Box -->
    <div class="bg-green-50 border-2 sm:border-4 border-green-200 rounded-xl px-4 sm:px-6 py-4 mt-6 shadow-sm">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <p class="font-semibold text-base sm:text-lg text-gray-700 leading-relaxed flex-1">
          By creating an account, you confirm your information is accurate and agree to use the platform responsibly. Your privacy is protected.
        </p>
        <button type="button"
          class="tts-btn bg-[#1E40AF] text-white text-lg leading-none p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-110 transition-transform self-center"
          data-tts-en="By creating an account, you confirm your information is accurate and agree to use the platform responsibly. Your privacy is protected."
          data-tts-tl="Sa paggawa ng account, kinukumpirma mong tama ang iyong impormasyon at sumasang-ayon kang gamitin ang platform nang responsable. Pinoprotektahan namin ang iyong privacy."
          aria-label="Read info aloud in English then Filipino" title="Play Audio">🔊</button>
      </div>
      <p class="mt-2 italic text-gray-700 text-base sm:text-md leading-relaxed">
        (Sa paggawa ng account, kinukumpirma mong tama ang iyong impormasyon at sumasang-ayon kang gamitin ang platform nang responsable. Pinoprotektahan namin ang iyong privacy.)
    </div>

    <!-- Buttons -->
<div class="flex justify-center mt-12">
  <button
    type="button"
    id="createAccountBtn"
    class="w-full sm:w-[530px] bg-[#2E2EFF] hover:bg-blue-600 text-white text-sm sm:text-base font-semibold py-3 sm:py-4 rounded-md shadow-sm transition-all duration-300">
    Create Account
  </button>
</div>


    <!-- Helper Text -->
    <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-2 text-center leading-relaxed px-4 sm:px-0">
      Click <span class="text-[#1E40AF] font-medium">“Create Account”</span> to complete your registration <br>
      <span class="mt-2 italic text-[#4B4F58] block sm:inline">(Pindutin ang “Create Account” upang tapusin ang iyong pagpaparehistro)</span>
    </p>
    </div>
  </div>

  <!-- Created Success Modal (hidden) -->
  <div id="createdModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-11/12 max-w-lg text-center">
      <div class="mb-4 text-5xl">🎉</div>
      <h3 class="text-2xl font-bold mb-2">Account<br/>Successfully Created!</h3>
      <p class="text-gray-700 mb-6">Congratulations! Click OK to proceed to login.</p>
      <button id="createdModalOk" class="bg-[#2E2EFF] hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition-all duration-200">Okay</button>
    </div>
  </div>

  <!-- Creating Loading Modal -->
  <div id="creatingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center">
      <div class="border-4 border-blue-500 border-t-transparent rounded-full w-14 h-14 animate-spin mb-4"></div>
      <p class="text-gray-800 font-medium">Creating account, please wait...</p>
    </div>
  </div>

    <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
    <script>
      (function(){
        const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
        const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
        let voices = [];
        let preferredEnglish = null;
        let preferredTagalog = null;

        const populateVoices = () => {
          voices = speechSynthesis.getVoices() || [];
          preferredEnglish = voices.find(v => v.name === preferredEnglishVoiceName)
            || voices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) || null;
          preferredTagalog = voices.find(v => v.name === preferredTagalogVoiceName)
            || voices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name)) || null;
        };

        const pickBest = (list) => {
          if (!list || !list.length) return null;
          const preferred = list.find(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
          return preferred || list[0];
        };

        const chooseVoiceForLang = (lang) => {
          if (!voices.length) return null;
          lang = (lang||'').toLowerCase();
          if (lang.startsWith('tl') || lang.startsWith('fil')) {
            if (preferredTagalog) return preferredTagalog;
            const candidates = voices.filter(v => (v.lang||'').toLowerCase().startsWith('tl') || (v.lang||'').toLowerCase().startsWith('fil'));
            return pickBest(candidates.length ? candidates : voices);
          }
          if (lang.startsWith('en')) {
            if (preferredEnglish) return preferredEnglish;
            const candidates = voices.filter(v => (v.lang||'').toLowerCase().startsWith('en'));
            return pickBest(candidates.length ? candidates : voices);
          }
          return preferredEnglish || voices[0] || null;
        };

        const stopSpeaking = () => {
          try { speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>{ b.classList.remove('speaking'); b.removeAttribute('aria-pressed'); }); } catch(e){}
        };

        const startSequence = (btn, en, tl) => {
          stopSpeaking();
          if (!en && !tl) return;
          btn.classList.add('speaking'); btn.setAttribute('aria-pressed','true');
          const uEn = en ? new SpeechSynthesisUtterance(en) : null;
          const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
          if (uEn) { uEn.lang = 'en-US'; uEn.voice = chooseVoiceForLang('en') || null; }
          if (uTl) { uTl.lang = 'tl-PH'; uTl.voice = chooseVoiceForLang('tl') || chooseVoiceForLang('en') || null; }
          const finalize = () => { btn.classList.remove('speaking'); btn.removeAttribute('aria-pressed'); };
          if (uEn && uTl) {
            uEn.onend = () => { setTimeout(()=> speechSynthesis.speak(uTl), 160); };
            uTl.onend = finalize;
            uEn.onerror = uTl.onerror = finalize;
            speechSynthesis.speak(uEn);
          } else if (uEn) { uEn.onend = finalize; uEn.onerror = finalize; speechSynthesis.speak(uEn); }
          else if (uTl) { uTl.onend = finalize; uTl.onerror = finalize; speechSynthesis.speak(uTl); }
        };

        const init = () => {
          populateVoices();
          window.speechSynthesis.onvoiceschanged = populateVoices;
          document.querySelectorAll('.tts-btn').forEach(b=>{
            b.addEventListener('click', ()=>{ if (b.classList.contains('speaking')) { stopSpeaking(); return; } startSequence(b, b.getAttribute('data-tts-en')||'', b.getAttribute('data-tts-tl')||''); });
            b.addEventListener('keydown', ev=>{ if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); b.click(); } });
          });
          window.addEventListener('beforeunload', stopSpeaking);
        };

        if (document.readyState === 'complete' || document.readyState === 'interactive') init(); else document.addEventListener('DOMContentLoaded', init);
      })();
    </script>
<script>
(function(){
  const createBtn = document.getElementById('createAccountBtn');
  const agree1 = document.getElementById('agree1');
  const agree2 = document.getElementById('agree2');
  const successModal = document.getElementById('createdModal'); // 
  const successOk = document.getElementById('createdModalOk');  // 

  // ✅ Enable button only if both checkboxes are checked
  function toggleCreateButton() {
    if (agree1.checked && agree2.checked) {
      createBtn.disabled = false;
      // remove any disabled/previous background or hover classes that may conflict
      createBtn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'bg-[#2E2EFF]', 'hover:bg-blue-600');
      createBtn.classList.add('bg-[#2E2EFF]', 'hover:bg-blue-600');
    } else {
      createBtn.disabled = true;
      // make visually disabled and remove active styles
      createBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
      createBtn.classList.remove('bg-[#2E2EFF]', 'hover:bg-blue-600');
    }
  }

  agree1?.addEventListener('change', toggleCreateButton);
  agree2?.addEventListener('change', toggleCreateButton);

  // ✅ Handle create account (with enhanced console debugging)
  // Global error handlers to capture uncaught errors/rejections in DevTools
  window.addEventListener('error', function (ev) {
    try { console.error('[global error]', ev.message, ev.error || ev.filename || ev); } catch(e){}
  });
  window.addEventListener('unhandledrejection', function (ev) {
    try { console.error('[unhandled rejection]', ev.reason); } catch(e){}
  });

  createBtn?.addEventListener('click', function(e){
    e.preventDefault();

    // Check both checkboxes
    if (!agree1.checked || !agree2.checked) {
      createBtn.classList.add('animate-pulse');
      setTimeout(()=> createBtn.classList.remove('animate-pulse'), 400);
      return;
    }

    let jobExperiencesRaw = localStorage.getItem('job_experiences') || localStorage.getItem('work_experiences') || '[]';
    let jobExperiences = [];
    try { jobExperiences = JSON.parse(jobExperiencesRaw || '[]'); } catch(err){ jobExperiences = []; }
    const derivedYears = (Array.isArray(jobExperiences) ? jobExperiences.map(j => j.start_year || j.year || '').filter(Boolean) : []);

    // Save data to backend --- sanitize work-year values to avoid invalid years (e.g. 0) being sent
    (function(){
      // try to read saved selected_work_year (may be JSON string or CSV)
      let savedYearsRaw = localStorage.getItem('selected_work_year') || localStorage.getItem('work_years') || null;
      let savedYears = [];
      if (savedYearsRaw) {
        try { savedYears = JSON.parse(savedYearsRaw); }
        catch(e) { savedYears = String(savedYearsRaw).split(/[;,\|\n]+/).map(s=>s.trim()).filter(Boolean); }
      }
      // fallback to derivedYears (from job experiences) if none
      if ((!savedYears || !savedYears.length) && Array.isArray(derivedYears) && derivedYears.length) savedYears = derivedYears.slice();

      // helper: extract first 4-digit year token
      const extractYear = (v) => {
        if (v === null || v === undefined) return null;
        const s = String(v);
        const m = s.match(/(\d{4})/);
        if (m) {
          const y = parseInt(m[1],10);
          if (!Number.isNaN(y)) return y;
        }
        return null;
      };

      const nowYear = new Date().getFullYear();
      const validYears = Array.from(new Set((savedYears||[]).map(extractYear).filter(y => typeof y === 'number' && y >= 1900 && y <= nowYear)));

      // Build payload
        const data = {
          education: localStorage.getItem('edu_level'),
          education_profile: localStorage.getItem('education_profile'),
          job_experiences: localStorage.getItem('job_experiences'),
          review_certs: localStorage.getItem('review_certs'),
          // include rpi_personal so server receives personal fields (but do not recreate debug dump on server)
          rpi_personal: localStorage.getItem('rpi_personal1'),
          school_name: localStorage.getItem('school_name'),
          selected_work_experience: localStorage.getItem('selected_work_experience'),
          selected_work_year: JSON.stringify(validYears),
          admin_uploaded_med_data: localStorage.getItem('admin_uploaded_med_data'),
          admin_uploaded_pwd_data: localStorage.getItem('admin_uploaded_pwd_data'), 
          // Fit-To-Work certificate data (admin uploader)
          admin_uploaded_fit_data: localStorage.getItem('admin_uploaded_fit_data'),
          workplace: localStorage.getItem('workplace'),
          jobPreferences: localStorage.getItem('jobPreferences'),
          skills1_selected: localStorage.getItem('skills1_selected'),
          certificates: localStorage.getItem('certificates') || localStorage.getItem('education_certificates') || '[]'
        };

      // replace previous data variable in outer scope by attaching to window for the fetch below
      window.__mvsg_registration_payload = data;

      // Ensure each certificate entry includes the canonical text fields the server expects
      // (certificate_name, issued_by, date_completed). We keep certificate_name defaulted
      // to 'Uploaded Certificate' when missing, but require the user to supply issued_by
      // and date_completed before submit to avoid Oracle storing NULLs.
      window.ensureCertificateFields = function(payload) {
        try {
          let certs = [];
          try { certs = Array.isArray(payload.certificates) ? payload.certificates : JSON.parse(payload.certificates||'[]'); } catch(e) { certs = []; }
          for (let i=0;i<certs.length;i++) {
            const c = certs[i] = certs[i] || {};
            // canonical field names
            c.certificate_name = (c.certificate_name || c.name || 'Uploaded Certificate').toString();
            // silently provide a safe issued_by default so DB receives a non-empty string
            c.issued_by = (c.issued_by || c.issuer || c.issuedBy || 'Not specified').toString();
            // normalize date_completed but do not force a value here (server may accept NULL)
            c.date_completed = c.date_completed || c.date || c.completed || '';
            // preserve training_description and possible binary data
            c.training_description = c.training_description || c.what_learned || '';
            c.data = c.data || c.file || c.certificate || c.certificate_data || null;
            certs[i] = c;
          }
          payload.certificates = JSON.stringify(certs);
          return true;
        } catch (e) { console.warn('ensureCertificateFields failed', e); return true; }
      }

      // Rehydrate uploaded file base64 data into the payload where possible. This attempts
      // to recover files saved under various localStorage keys (uploadedCertificates_education,
      // uploadedWorkExp_file, uploadedResume_file, uploadedProofs_proof, etc.) and attach them
      // to `certificates` entries or `job_experiences` entries so the server receives base64 blobs.
      ;(function rehydrateFilesIntoPayload(payload){
        try {
          function parseLS(key){ try { const raw = localStorage.getItem(key); return raw ? JSON.parse(raw) : null; } catch(e){ return null; } }

          const eduCertKeys = ['uploadedCertificates_education','education_certificates','uploadedCertificates','uploadedProofs_proof','uploadedProofs','uploadedProofData','uploadedProofData1','uploadedProofs1'];
          const workCertKeys = ['uploadedWorkExp_file','uploadedResume_file','uploadedWorkExpFiles','uploadedWorkExp','uploadedResume'];

          function gatherFiles(keys){
            const out = [];
            for (const k of keys){
              const v = parseLS(k);
              if (!v) continue;
              if (Array.isArray(v)){
                for (const it of v){
                  if (!it) continue;
                  if (typeof it === 'string') out.push(it);
                  else if (it.data) out.push(it.data);
                  else if (it.file) out.push(it.file);
                  else if (it.certificate_data) out.push(it.certificate_data);
                  else if (it.certificate) out.push(it.certificate);
                  else if (it.cert && (it.cert.data||it.cert.file)) out.push(it.cert.data||it.cert.file);
                }
              } else if (typeof v === 'object') {
                if (v.data) out.push(v.data);
                else if (v.file) out.push(v.file);
              } else if (typeof v === 'string' && v.indexOf('data:') === 0) {
                out.push(v);
              }
            }
            return out;
          }

          const eduFiles = gatherFiles(eduCertKeys);
          const workFiles = gatherFiles(workCertKeys);

          // Attach edu files into certificates array
          try {
            let certsArr = [];
            try { certsArr = Array.isArray(payload.certificates) ? payload.certificates : JSON.parse(payload.certificates||'[]'); } catch(e){ certsArr = []; }
            for (let i=0;i<certsArr.length;i++){
              if ((!certsArr[i].data && !certsArr[i].file && !certsArr[i].certificate) && eduFiles.length){
                certsArr[i].data = eduFiles.shift();
              }
            }
            // If there are remaining eduFiles and no structured certificate entries, append them
            while (eduFiles.length) {
              const f = eduFiles.shift();
              certsArr.push({ certificate_name: 'Uploaded Certificate', issued_by: '', date_completed: '', training_description: '', data: f });
            }
            payload.certificates = JSON.stringify(certsArr);
          } catch(e){ console.warn('rehydrate certs failed', e); }

          // Attach work files into job_experiences entries
          try {
            let jobs = [];
            try { jobs = Array.isArray(payload.job_experiences) ? payload.job_experiences : JSON.parse(payload.job_experiences||'[]'); } catch(e){ jobs = []; }
            for (let j=0;j<jobs.length;j++){
              if ((!jobs[j].certificate && !jobs[j].certificate_data && !jobs[j].file) && workFiles.length){
                // Put the raw base64 string or object depending on earlier shape
                jobs[j].certificate = workFiles.shift();
              }
            }
            payload.job_experiences = JSON.stringify(jobs);
          } catch(e){ console.warn('rehydrate jobs failed', e); }
        } catch(e){ console.warn('rehydrateFilesIntoPayload failed', e); }
      })(window.__mvsg_registration_payload);
    })();

    // Debug: log payload size and keys (avoid dumping huge binary in case of large data URLs)
    try {
      const payloadForSummary = window.__mvsg_registration_payload || {};
      const safeSummary = Object.keys(payloadForSummary).reduce((acc, k) => {
        try {
          const v = payloadForSummary[k];
          if (!v) acc[k] = null;
          else if (typeof v === 'string' && v.length > 200) acc[k] = `${v.slice(0,120)}... (${v.length} chars)`;
          else acc[k] = v;
        } catch(e){ acc[k] = typeof payloadForSummary[k]; }
        return acc;
      }, {});
      console.groupCollapsed('[registration] submitting payload summary');
      console.debug('payload summary', safeSummary);
      console.groupEnd();
    } catch(e){ console.warn('could not summarize payload', e); }

    // show loading modal
    const creatingModal = document.getElementById('creatingModal');
    try { if (creatingModal) creatingModal.classList.remove('hidden'); } catch(e){}

    // Before sending, ensure certificate text fields are present; abort if user cancels
    if (!ensureCertificateFields(window.__mvsg_registration_payload)) {
      try { if (creatingModal) creatingModal.classList.add('hidden'); } catch(e){}
      return;
    }

    const __mvsg_payload_to_send = window.__mvsg_registration_payload || (typeof data !== 'undefined' ? data : {});
    fetch('db/registration-data.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(__mvsg_payload_to_send)
    })
    .then(async response => {
      // always capture response body for debugging
      let text = null;
      try { text = await response.text(); } catch(e) { text = null; }

      console.groupCollapsed('[registration] server response');
      console.debug('status', response.status);
      console.debug('statusText', response.statusText);
      console.debug('body (text)', text);
      try { const parsed = text ? JSON.parse(text) : null; console.debug('body (json)', parsed); } catch(e) { console.debug('body not JSON'); }
      console.groupEnd();

      if (response.status === 200) {
        // Success — hide creating modal then show success
        try { if (creatingModal) creatingModal.classList.add('hidden'); } catch(e){}
        try { successModal.classList.remove('hidden'); } catch(e){}
        return;
      }

      // Non-200: report full details to console and alert user to check DevTools
      console.error('[registration] failed — status', response.status, 'body:', text);
      try { if (creatingModal) creatingModal.classList.add('hidden'); } catch(e){}
      try { alert('Invalid Data. Please try again later. See console (DevTools) for details.'); } catch(e){}
    })
    .catch(err => {
      console.error('[registration] fetch error', err);
      try { if (creatingModal) creatingModal.classList.add('hidden'); } catch(e){}
      try { alert('Network error — see console (DevTools) for details.'); } catch(e){}
    });

  });

  // ✅ Redirect to login after clicking OK
  successOk?.addEventListener('click', () => {
    successModal.classList.add('hidden');
    window.location.href = '{{ route("login") }}'; // ✅ Redirect to login
  });

  // Initially disable the button until checkboxes are checked
  toggleCreateButton();

})();
</script>
