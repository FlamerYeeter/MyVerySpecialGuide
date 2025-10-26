<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Final Step - Agreement</title>
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
    class="fixed left-3 top-3 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-2xl flex items-center gap-2 sm:gap-3 text-base sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="window.location.href='{{ route('registerreview5') }}'">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
      class="w-4 h-4 sm:w-6 sm:h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </button>

  <!-- Main Container -->
  <div
    class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden mt-20 sm:mt-24 md:mt-28">

    <!-- Header -->
    <div class="text-center mt-2 sm:mt-4 px-2">
      <h1
        class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug break-words">
        Final Step: Agreement
      </h1>
      <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
    </div>

    <!-- Instruction Box -->
    <div
      class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 sm:p-6 mt-6 sm:mt-8 shadow-sm">
      <div class="flex flex-col sm:flex-row items-start gap-3 pr-12 sm:pr-14">
        <svg xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
        </svg>
        <div class="flex-1 text-center sm:text-left">
          <p class="font-medium text-sm sm:text-base leading-relaxed">
            Please check the boxes below if you agree to the terms of this agreement.
          </p>
          <p class="italic text-gray-600 text-xs sm:text-sm mt-1 sm:mt-2 leading-relaxed">
            (Paki-check ang mga kahon sa ibaba kung ikaw ay sumasang-ayon sa kasunduang ito.)
          </p>
        </div>
      </div>
      <button type="button"
        class="tts-btn absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200"
        data-tts-en="Please check the boxes below if you agree to the terms of this agreement."
        data-tts-tl="Paki-check ang mga kahon sa ibaba kung ikaw ay sumasang-ayon sa kasunduang ito."
        aria-label="Read agreement instructions aloud in English then Filipino"></button>
    </div>

    <!-- Agreement Box -->
    <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-200 mt-6">
      <h3 class="text-lg sm:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2 text-center sm:text-left">
        Important Agreements <span class="text-gray-700 text-sm">(Mahalagang Kasunduan)</span>
      </h3>

      <!-- Agreement 1 -->
      <label
        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-blue-50 p-4 rounded-xl border border-blue-200 hover:bg-blue-100 transition mb-4 cursor-pointer">
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
                        aria-label="Read agreement 1 aloud in English then Filipino" title="Play Audio"></button>
            </div>
            <p class="text-gray-600 italic text-sm leading-snug mt-1">
              (Sumasang-ayon akong ibahagi ang aking impormasyon sa mga employer na naghahanap ng empleyado.)
            </p>
          </div>
        </div>
      </label>

      <!-- Agreement 2 -->
      <label
        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-blue-50 p-4 rounded-xl border border-blue-200 hover:bg-blue-100 transition cursor-pointer">
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
                aria-label="Read agreement 2 aloud in English then Filipino" title="Play Audio"></button>
            </div>
            <p class="text-gray-600 italic text-sm leading-snug mt-1">
              (Nauunawaan ko na ang aking impormasyon ay papanatilihing pribado at ligtas.)
            </p>
          </div>
        </div>
      </label>
    </div>

    <!-- Info Box -->
    <div class="bg-green-50 border border-green-400 rounded-lg px-4 sm:px-6 py-4 mt-6 shadow-sm">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <p class="text-sm sm:text-[15px] text-black leading-relaxed flex-1">
          After creating your account, we will match you with jobs that fit your skills and preferences.
          You will receive notifications when new opportunities are available.
        </p>
        <button type="button"
          class="tts-btn bg-[#1E40AF] text-white text-lg leading-none p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-110 transition-transform self-center"
          data-tts-en="After creating your account, we will match you with jobs that fit your skills and preferences. You will receive notifications when new opportunities are available."
          data-tts-tl="Pagkatapos gumawa ng iyong account, itutugma ka namin sa mga trabaho na ayon sa iyong kakayahan at kagustuhan. Makakatanggap ka ng notification kapag may bagong trabaho na available."
          aria-label="Read info aloud in English then Filipino" title="Play Audio"></button>
      </div>
      <p class="mt-2 italic text-gray-700 text-xs sm:text-[13px] leading-relaxed">
        (Pagkatapos gumawa ng iyong account, itutugma ka namin sa mga trabaho na ayon sa iyong kakayahan at kagustuhan. Makakatanggap ka ng notification kapag may bagong trabaho na available.)
      </p>
    </div>

    <!-- Buttons -->
    <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">
      <button id="createAccountBtn" type="button"
        class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-base sm:text-lg font-semibold 
        px-8 sm:px-10 py-3 sm:py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
        shadow-md w-full sm:w-64 text-center">
        Create My Account
      </button>
    </div>

    <!-- Error / Hidden fields used by scripts -->
    <div class="text-center mt-3">
      <p id="finalError" class="text-red-600 text-sm"></p>
    </div>

    <!-- Hidden inputs for autofill/verification (used by inline scripts) -->
    <input type="hidden" id="emailFromServer" name="emailFromServer" value="{{ $serverEmail ?? '' }}" />
    <input type="hidden" id="email" name="email" value="" />
    <input type="hidden" id="password" name="password" value="" />
    <input type="hidden" id="confirm_password" name="confirm_password" value="" />

    <!-- Email verification modal (hidden by default) -->
    <div id="emailVerifyModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black opacity-40"></div>
      <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-6 z-60">
        <div class="flex items-start justify-between">
          <h3 class="text-lg font-semibold text-gray-800">Verify Your Email</h3>
          <button id="emailVerifyClose" type="button" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div class="mt-4">
          <p class="text-sm text-gray-700">We will send a verification code to:</p>
          <p id="verificationEmail" class="mt-2 font-medium text-gray-900 break-words"></p>
        </div>
        <div class="mt-6 flex justify-end gap-3">
          <button id="emailVerifyCancel" type="button" class="px-4 py-2 bg-gray-100 rounded-md hover:bg-gray-200">Cancel</button>
          <button id="emailVerifyProceed" type="button" class="px-4 py-2 bg-[#2E2EFF] text-white rounded-md hover:bg-blue-600">Proceed</button>
        </div>
      </div>
    </div>

    <!-- Helper Text -->
    <p class="text-gray-700 text-xs sm:text-sm mt-4 text-center">
      Click <span class="text-[#1E40AF] font-medium">“Create My Account”</span> to complete your registration
    </p>
    <p class="text-gray-600 italic text-[12px] sm:text-[13px] text-center">
      (Pindutin ang “Create My Account” upang tapusin ang iyong pagpaparehistro)
    </p>
  </div>

    <script src="{{ asset('js/firebase-config-global.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>
    <script>
      (function(){
        const modal = document.getElementById('emailVerifyModal');
        const close = document.getElementById('emailVerifyClose');
        const cancel = document.getElementById('emailVerifyCancel');
        const proceed = document.getElementById('emailVerifyProceed');
        function hide(){ if(modal) modal.classList.add('hidden'); }
        function show(email){ if(!modal) return; document.getElementById('verificationEmail').textContent = email || ''; modal.classList.remove('hidden'); }
        if (close) close.addEventListener('click', hide);
        if (cancel) cancel.addEventListener('click', hide);
        if (proceed) proceed.addEventListener('click', function(){ window.location.href = '{{ route('registerverifycode') }}'; });
        // expose for register.js to call
        window.mvsgShowEmailVerificationModal = show;
      })();
    </script>
    <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
    <script>
      (function(){
        const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
        let voices = [];
        const populateVoices = () => { voices = speechSynthesis.getVoices() || []; };
        const pickBest = (list, langPrefix) => {
          if (!list || !list.length) return null;
          const exact = list.find(v=>v.name === preferredVoiceName); if (exact) return exact;
          const fuzzy = list.find(v=>v.name && v.name.toLowerCase().includes('microsoft') && v.name.toLowerCase().includes('multilingual')); if (fuzzy) return fuzzy;
          const langMatch = list.find(v => v.lang && v.lang.toLowerCase().startsWith(langPrefix)); if (langMatch) return langMatch;
          return list[0] || null;
        };
        const voiceFor = (lang) => { const forLang = voices.filter(v => v.lang && v.lang.toLowerCase().startsWith(lang)); return pickBest(forLang.length ? forLang : voices, lang); };
        const stopSpeaking = () => { try { speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>b.classList.remove('speaking')); } catch(e){} };
        const startSequence = (btn, en, tl) => {
          stopSpeaking(); if (!en && !tl) return; btn.classList.add('speaking'); btn.setAttribute('aria-pressed','true');
          const uEn = en ? new SpeechSynthesisUtterance(en) : null; const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
          if (uEn) { uEn.lang='en-US'; uEn.voice = voiceFor('en') || null; }
          if (uTl) { uTl.lang='tl-PH'; uTl.voice = voiceFor('tl') || (voiceFor('en') || null); }
          const finalize = () => { btn.classList.remove('speaking'); btn.setAttribute('aria-pressed','false'); };
          if (uEn && uTl) { uEn.onend = () => { setTimeout(()=>speechSynthesis.speak(uTl), 180); }; uTl.onend = finalize; speechSynthesis.speak(uEn); }
          else if (uEn) { uEn.onend = finalize; speechSynthesis.speak(uEn); }
          else if (uTl) { uTl.onend = finalize; speechSynthesis.speak(uTl); }
        };
        const init = () => {
          populateVoices(); window.speechSynthesis.onvoiceschanged = populateVoices;
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
        // Try to extract email from Firestore (or drafts) and populate hidden email fields
        (async function(){
          try {
            // helpers from register.js: ensureFirebase, getDraft, readStored, findFirstMatching
            const waitMs = (ms)=>new Promise(res=>setTimeout(res, ms));
            // prefer URL override param `uid` for admin review
            const params = new URLSearchParams(window.location.search || '');
            const overrideUid = params.get('uid') || params.get('user') || params.get('id');

            // ensure register.js loaded
            if (typeof ensureFirebase === 'function') await ensureFirebase();
            // small delay to let firebase auth initialize if present
            await waitMs(150);

            let email = '';

            // 1) if overrideUid provided, read that user's doc directly (no auth needed for public rules)
            if (overrideUid && window.firebase && firebase.firestore) {
              try {
                const db = firebase.firestore();
                const snap = await db.collection('users').doc(overrideUid).get().catch(()=>null);
                if (snap && snap.exists) {
                  const d = snap.data() || {};
                  email = d.personalInfo?.email || d.email || d.personal?.email || '';
                }
              } catch(e) { console.warn('override uid read failed', e); }
            }

            // 2) Try currently signed-in user doc
            if (!email && window.firebase && firebase.auth && firebase.firestore) {
              try {
                let user = firebase.auth().currentUser;
                if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                if (user) {
                  const snap = await firebase.firestore().collection('users').doc(user.uid).get().catch(()=>null);
                  if (snap && snap.exists) {
                    const d = snap.data() || {};
                    email = d.personalInfo?.email || d.email || d.personal?.email || '';
                  }
                }
              } catch(e) { console.warn('signed-in user read failed', e); }
            }

            // 3) fallback: use register.js getDraft() which checks local/session and Firestore
            if (!email && typeof getDraft === 'function') {
              try {
                const draftRes = await getDraft();
                const draft = draftRes && (draftRes.data || draftRes) || {};
                // try common locations
                email = draft.personalInfo?.email || draft.personal?.email || draft.email || draft.emailAddress || '';
              } catch(e) { console.warn('getDraft failed', e); }
            }

            // 4) last attempt: read common storage keys directly
            if (!email) {
              try {
                const keys = ['registrationDraft','registration_draft','dsRegistrationDraft','registerDraft','regDraft','reg_data'];
                for (const k of keys) {
                  try {
                    const v = localStorage.getItem(k) || sessionStorage.getItem(k);
                    if (!v) continue;
                    let parsed = null;
                    try { parsed = JSON.parse(v); } catch(e){ parsed = v; }
                    if (parsed && typeof parsed === 'object') {
                      email = parsed.personalInfo?.email || parsed.personal?.email || parsed.email || parsed.emailAddress || '';
                      if (email) break;
                    }
                  } catch(e){}
                }
              } catch(e){}
            }

            // set fields if found
            if (email) {
              try { const el = document.getElementById('email'); if (el) el.value = email; } catch(e){}
              try { const s = document.getElementById('emailFromServer'); if (s && !s.value) s.value = email; } catch(e){}
              try { const v = document.getElementById('verificationEmail'); if (v) v.textContent = email; } catch(e){}
              console.info('Final step: populated email from Firestore/draft:', email);
            } else {
              console.info('Final step: no email found in Firestore/drafts');
            }
          } catch(e) { console.error('finalstep autofill email failed', e); }
        })();
      </script>
    <script>
      (function(){
        const createBtn = document.getElementById('createAccountBtn');
        const agree1 = document.getElementById('agree1');
        const agree2 = document.getElementById('agree2');
        const finalError = document.getElementById('finalError');
        const emailField = document.getElementById('emailFromServer');

        function clearErrors(){
          finalError.textContent = '';
          [agree1, agree2].forEach(el => { if(el && el.parentElement) el.parentElement.classList.remove('ring','ring-2','ring-red-300'); });
        }

        createBtn && createBtn.addEventListener('click', function(e){
          e.preventDefault();
          clearErrors();

          const email = (emailField && emailField.value || '').trim();
          let hasError = false;

          if (!agree1 || !agree1.checked || !agree2 || !agree2.checked) {
            finalError.textContent = 'Please accept the required agreements.';
            [agree1, agree2].forEach(el => { if(el && el.parentElement) el.parentElement.classList.add('ring','ring-2','ring-red-300'); });
            hasError = true;
          }

          if (!email) {
            finalError.textContent = 'No email available for verification.';
            hasError = true;
          }

          if (hasError) {
            createBtn.classList.add('animate-pulse');
            setTimeout(()=> createBtn.classList.remove('animate-pulse'), 350);
            return;
          }

          // store email and agreement state for later use; no password collected here
          window.finalRegistrationData = {
            email: email,
            agreements: {
              agree1: !!(agree1 && agree1.checked),
              agree2: !!(agree2 && agree2.checked)
            }
          };

          // show existing verification modal with the email
          if (typeof window.mvsgShowEmailVerificationModal === 'function') {
            window.mvsgShowEmailVerificationModal(email);
          } else {
            const modal = document.getElementById('emailVerifyModal');
            if (modal) {
              document.getElementById('verificationEmail').textContent = email;
              modal.classList.remove('hidden');
            }
          }

          // optional hook if register.js exposes continuation
          try {
            if (typeof window.mvsgFinalizeRegistration === 'function') {
              window.mvsgFinalizeRegistration(window.finalRegistrationData);
            }
          } catch (err) { /* silent */ }
        });
      })();
    </script>
      <script>
        // Autofill hidden email/password fields from available drafts or Firestore
        (function(){
          const emailField = document.getElementById('email');
          const emailFromServer = document.getElementById('emailFromServer');
          const passField = document.getElementById('password');
          const confirmField = document.getElementById('confirm_password');

          function genRandomPassword() {
            // simple 12-char password: letters + numbers
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&*()-_';
            let p = ''; for (let i=0;i<12;i++) p += chars[Math.floor(Math.random()*chars.length)];
            return p;
          }

          async function tryFillFromDrafts() {
            try {
              // register.js exposes getDraft() and readStored(); use them if available
              if (window.getDraft && typeof window.getDraft === 'function') {
                const d = await window.getDraft();
                const data = d && (d.data || d) || {};
                const personal = data.personalInfo || data.personal || data;
                if (personal && (personal.email || personal.emailAddress)) return personal.email || personal.emailAddress;
              }
              // fallback to readStored
              if (window.readStored && typeof window.readStored === 'function') {
                const e = window.readStored('email') || window.readStored('emailAddress') || window.readStored('personal.email');
                if (e) return e;
              }
            } catch(e){ /* ignore */ }
            return null;
          }

          async function tryFillFromFirestore() {
            try {
              // ensure firebase is initialized by register.js ensureFirebase if available
              if (window.firebase && firebase.auth && firebase.firestore) {
                let user = firebase.auth().currentUser;
                if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                if (!user) return null;
                const doc = await firebase.firestore().collection('users').doc(user.uid).get();
                if (doc && doc.exists) {
                  const d = doc.data() || {};
                  const p = d.personalInfo || d.personal || d;
                  if (p && (p.email || p.emailAddress)) return p.email || p.emailAddress;
                }
              }
            } catch(e){ console.warn('autofill firestore fail', e); }
            return null;
          }

          async function main() {
            // priority: server-provided hidden value -> drafts -> firestore
            let e = (emailFromServer && emailFromServer.value && emailFromServer.value.trim()) || '';
            if (!e) e = (await tryFillFromDrafts()) || '';
            if (!e) e = (await tryFillFromFirestore()) || '';

            if (e && emailField) {
              emailField.value = e;
              if (emailFromServer && !emailFromServer.value) emailFromServer.value = e;
            }

            // If password fields are empty, generate a random password so create flow validates
            if (passField && confirmField && !passField.value) {
              const p = genRandomPassword();
              passField.value = p; confirmField.value = p;
              // keep in-memory only; do not persist to server-side templates
              window.__mvsg_generatedPassword = p;
            }

            // expose a helper for debugging
            window.mvsgAutoFilled = { email: emailField && emailField.value, password: passField && passField.value };
          }

          // run after DOMContentLoaded to ensure register.js may have attached helpers
          if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', main); else main();
        })();
      </script>
</body>
</html>