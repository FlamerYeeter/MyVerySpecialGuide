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
          By creating an account, you confirm that the information entered is true and that you are an authorized 
          individual to use this platform. Any misuse or false representation may lead to account restriction.
        </p>
        <button type="button"
          class="tts-btn bg-[#1E40AF] text-white text-lg leading-none p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-110 transition-transform self-center"
          data-tts-en="After creating your account, we will match you with jobs that fit your skills and preferences. You will receive notifications when new opportunities are available."
          data-tts-tl="Pagkatapos gumawa ng iyong account, itutugma ka namin sa mga trabaho na ayon sa iyong kakayahan at kagustuhan. Makakatanggap ka ng notification kapag may bagong trabaho na available."
          aria-label="Read info aloud in English then Filipino" title="Play Audio"></button>
      </div>
      <p class="mt-2 italic text-gray-700 text-xs sm:text-[13px] leading-relaxed">
        (Sa paglikha ng account, pinapatunayan mong totoo at tama ang impormasyong iyong inilagay at na ikaw ay awtorisadong indibidwal na gumamit ng platform na ito. Ang anumang maling paggamit o pagpapahayag ng hindi 
        totoong impormasyon ay maaaring magresulta sa pagkakabawal o pagkakasuspinde ng iyong account.)
    </div>

    <!-- Buttons -->
<div class="flex justify-center mt-12">
  <button
    type="button"
    id="createAccountBtn"
    class="w-full sm:w-[530px] bg-[#1E40AF] text-white text-sm sm:text-base font-semibold py-3 sm:py-4 rounded-md shadow-sm hover:bg-[#1E88E5] transition-all duration-200"
  >
    Create Account
  </button>
</div>


    <!-- Helper Text -->
    <p class="text-gray-700 text-xs sm:text-sm mt-4 text-center">
      Click <span class="text-[#1E40AF] font-medium">“Create Account”</span> to complete your registration
    </p>
    <p class="text-gray-600 italic text-[12px] sm:text-[13px] text-center">
      (Pindutin ang “Create Account” upang tapusin ang iyong pagpaparehistro)
    </p>
  </div>

  <!-- Created Success Modal (hidden) -->
  <div id="createdModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-11/12 max-w-lg text-center">
      <div class="mb-4 text-5xl">🎉</div>
      <h3 class="text-2xl font-bold mb-2">Account<br/>Successfully Created!</h3>
      <p class="text-gray-700 mb-6">Congratulations! Click OK to proceed to login.</p>
      <button id="createdModalOk" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md transition-all duration-200">Okay</button>
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
    <script src="{{ asset('js/register.js') }}"></script>
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
      createBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
      createBtn.classList.add('bg-[#1E40AF]', 'hover:bg-[#1E88E5]');
    } else {
      createBtn.disabled = true;
      createBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
      createBtn.classList.remove('bg-[#1E40AF]', 'hover:bg-[#1E88E5]');
    }
  }

  agree1?.addEventListener('change', toggleCreateButton);
  agree2?.addEventListener('change', toggleCreateButton);

  // ✅ Handle create account
  createBtn?.addEventListener('click', function(e){
    e.preventDefault();

    // Check both checkboxes
    if (!agree1.checked || !agree2.checked) {
      createBtn.classList.add('animate-pulse');
      setTimeout(()=> createBtn.classList.remove('animate-pulse'), 400);
      return;
    }

    // ✅ Save data to backend 
    const data = {
      education: localStorage.getItem('education'),
      job_experiences: localStorage.getItem('job_experiences'),
      review_certs: localStorage.getItem('review_certs'),
      rpi_personal: localStorage.getItem('rpi_personal'),
      school_name: localStorage.getItem('school_name'),
      selected_work_experience: localStorage.getItem('selected_work_experience'),
      selected_work_year: localStorage.getItem('selected_work_year'),
      support: localStorage.getItem('support'),
      uploadedProofData0: localStorage.getItem('uploadedProofData0'),
      uploadedProofData1: localStorage.getItem('uploadedProofData1'),
      uploadedProofName0: localStorage.getItem('uploadedProofName0'),
      uploadedProofName1: localStorage.getItem('uploadedProofName1'),
      uploadedProofType0: localStorage.getItem('uploadedProofType0'),
      uploadedProofType1: localStorage.getItem('uploadedProofType1'),
      workplace: localStorage.getItem('workplace'),
      jobPreferences: localStorage.getItem('jobPreferences'),
      skills1_selected: localStorage.getItem('skills1_selected')
    };

    fetch('public/db/registration-data.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    }).catch(console.error);

    // ✅ Show success modal
    successModal.classList.remove('hidden');
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
