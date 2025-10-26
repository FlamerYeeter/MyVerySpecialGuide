<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Privacy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 6s ease-in-out infinite; }
    .animate-float-medium { animation: float 4s ease-in-out infinite; }
    .animate-float-fast { animation: float 3s ease-in-out infinite; }
    .tts-btn.speaking {
      background-color: #2563eb !important;
      box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
      transform: scale(1.03);
    }
  </style>
</head>

<body class="bg-white flex justify-center items-center min-h-screen p-4 sm:p-6 relative overflow-auto">

  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot"
    class="fixed left-2 sm:left-6 lg:left-10 top-1/3 w-20 sm:w-28 md:w-32 opacity-90 animate-float-slow z-0">
  <img src="image/obj7.png" alt="Triangle Mascot"
    class="fixed left-2 sm:left-6 lg:left-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-28 opacity-90 animate-float-medium z-0">
  <img src="image/obj3.png" alt="Blue Mascot"
    class="fixed right-2 sm:right-6 lg:right-10 top-1/4 w-20 sm:w-28 md:w-32 opacity-90 animate-float-fast z-0">
  <img src="image/obj8.png" alt="Twin Mascot"
    class="fixed right-2 sm:right-6 lg:right-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-32 opacity-90 animate-float-medium z-0">

  <!-- Back Button -->
  <button
    class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl flex items-center gap-2 sm:gap-3 text-base sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="window.location.href='<?php echo e(route('register2')); ?>'">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="4" stroke="white" class="w-5 h-5 sm:w-6 sm:h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </button>

  <!-- Main Container -->
  <div class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

    <!-- Header -->
    <div class="text-center mt-2">
      <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Data Privacy Notice</h1>
      <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-28 md:w-36 mb-6">
      <h2 class="text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold flex flex-wrap justify-center items-center gap-2 sm:gap-3 text-center">
        We Protect Your Personal Information
        <button type="button" class="text-2xl sm:text-3xl hover:scale-110 transition-transform tts-btn" data-tts-en="We Protect Your Personal Information" data-tts-tl="Pinangangalagaan namin ang iyong personal na impormasyon">🔊</button>
      </h2>
      <p class="mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
        (Pinangangalagaan namin ang iyong personal na impormasyon)
      </p>
    </div>

   <!-- Info Section -->
<div
  class="mt-10 max-w-3xl mx-auto bg-blue-50 p-5 sm:p-6 md:p-8 rounded-2xl border border-blue-300 shadow-md relative">

  <!-- Audio Button -->
  <button type="button" aria-label="Play audio for info section"
    class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
           text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
           focus:ring-2 focus:ring-blue-400 tts-btn"
    data-tts-en="We value your trust and are committed to protecting your data in compliance with the Data Privacy Act of 2012 (RA 10173)."
    data-tts-tl="Pinahahalagahan namin ang iyong tiwala at pinoprotektahan namin ang iyong impormasyon alinsunod sa Data Privacy Act of 2012.">
    🔊
  </button>

  <div class="flex flex-col sm:flex-row sm:items-start gap-4 sm:gap-6 pr-20">
    <!-- Icon -->
    <span class="text-[#846506] text-4xl sm:text-5xl mt-1 flex justify-center sm:justify-start">💡</span>

    <!-- Text -->
    <div class="flex-1 text-center sm:text-left">
      <p class="text-lg sm:text-xl text-gray-800 font-semibold leading-relaxed">
        We value your trust and are committed to protecting your data in compliance with the Data Privacy Act of 2012 (RA 10173).
      </p>
      <p class="text-gray-700 italic text-base sm:text-lg mt-2">
        (Pinahahalagahan namin ang iyong tiwala at pinoprotektahan namin ang iyong impormasyon alinsunod sa Data Privacy Act of 2012.)
      </p>
    </div>
  </div>
</div>

 <!-- Sections -->
<div class="mt-10 sm:mt-12 max-w-4xl mx-auto space-y-6 sm:space-y-8">

  <!-- Info We Collect -->
  <div class="relative bg-white rounded-3xl p-5 sm:p-6 md:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <!-- Audio Button -->
    <button type="button" aria-label="Play audio for info section"
      class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
             text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
             focus:ring-2 focus:ring-blue-400 tts-btn"
      data-tts-en="Personal details we collect include name, contact number, email address, parent or guardian details, education and employment history, supports needed, your skills, and job preferences."
      data-tts-tl="Kinokolekta namin ang impormasyon tulad ng pangalan, contact number, email, edukasyon, supportang kailangan, iyong kakayanan at mga trabahong kagustuhan.">
      🔊
    </button>

    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center pr-20">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Collect Data Icon"
        class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 mx-auto sm:mx-0">
      <div class="flex-1 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-2">Information We Collect</h3>
        <ul class="list-disc list-inside text-gray-700 text-base sm:text-lg space-y-1">
          <li>Personal details: name, contact number, email address.</li>
          <li>Parent/Guardian details: name, contact number, email address.</li>
          <li>Education and employment history.</li>
          <li>Supports need, your skills, and job preferences.</li>
        </ul>
        <p class="text-gray-700 italic text-base sm:text-lg mt-2">
          (Kinokolekta namin ang impormasyon tulad ng pangalan, contact number, email, edukasyon, supportang 
          kailangan, iyong kakayanan at mga trabahong kagustuhan.)
        </p>
      </div>
    </div>
  </div>

  <!-- Purpose -->
  <div class="relative bg-white rounded-3xl p-5 sm:p-6 md:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <!-- Audio Button -->
    <button type="button" aria-label="Play audio for purpose section"
      class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
             text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
             focus:ring-2 focus:ring-blue-400 tts-btn"
      data-tts-en="We collect data to match you with job opportunities and training, improve our services and support, and meet compliance requirements."
      data-tts-tl="Upang mahanap ang angkop na trabaho o pagsasanay, mapabuti ang aming serbisyo, at makasunod sa mga regulasyon.">
      🔊
    </button>

    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center pr-20">
      <img src="https://cdn-icons-png.flaticon.com/512/9119/9119230.png" alt="Purpose Icon"
        class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 mx-auto sm:mx-0">
      <div class="flex-1 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-2">Purpose of Data Collection</h3>
        <ul class="list-disc list-inside text-gray-700 text-base sm:text-lg space-y-1">
          <li>Match you with job opportunities & training.</li>
          <li>Improve our services and support.</li>
          <li>Meet compliance requirements.</li>
        </ul>
        <p class="text-gray-700 italic text-base sm:text-lg mt-2">
          (Upang mahanap ang angkop na trabaho o pagsasanay, mapabuti ang aming serbisyo, at makasunod sa mga regulasyon.)
        </p>
      </div>
    </div>
  </div>

  <!-- Protection -->
  <div class="relative bg-white rounded-3xl p-5 sm:p-6 md:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <!-- Audio Button -->
    <button type="button" aria-label="Play audio for protection section"
      class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
             text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
             focus:ring-2 focus:ring-blue-400 tts-btn"
      data-tts-en="We use secure systems and only authorized personnel can access your data. Information is only used for declared purposes."
      data-tts-tl="Ginagamit ang ligtas na sistema at tanging may awtoridad ang pwedeng kumuha ng impormasyon. Ginagamit lamang para sa nakasaad na layunin.">
      🔊
    </button>

    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center pr-20">
      <img src="https://cdn-icons-png.flaticon.com/512/10473/10473528.png" alt="Data Protection Icon"
        class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 mx-auto sm:mx-0">
      <div class="flex-1 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-2">Data Protection & Access</h3>
        <p class="text-gray-700 text-base sm:text-lg leading-relaxed">
          We use secure systems and only authorized personnel can access your data. Information is only used for declared purposes.
        </p>
        <p class="text-gray-700 italic text-base sm:text-lg mt-2">
          (Ginagamit ang ligtas na sistema at tanging may awtoridad ang pwedeng kumuha ng impormasyon. Ginagamit lamang para sa nakasaad na layunin.)
        </p>
      </div>
    </div>
  </div>

  <!-- Consent -->
  <div class="relative bg-white rounded-3xl p-5 sm:p-6 md:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <!-- Audio Button -->
    <button type="button" aria-label="Play audio for consent section"
      class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
             text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
             focus:ring-2 focus:ring-blue-400 tts-btn"
      data-tts-en="By using our services, you consent to the collection and processing of your personal data under this policy."
      data-tts-tl="Sa paggamit ng aming serbisyo, pumapayag ka sa pagkuha at paggamit ng iyong impormasyon alinsunod sa patakarang ito.">
      🔊
    </button>

    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center pr-20">
      <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Check Icon"
        class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 mx-auto sm:mx-0">
      <div class="flex-1 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-2">Your Consent</h3>
        <p class="text-gray-700 text-base sm:text-lg leading-relaxed">
          By using our services, you consent to the collection & processing of your personal data under this policy.
        </p>
        <p class="text-gray-700 italic text-base sm:text-lg mt-2">
          (Sa paggamit ng aming serbisyo, pumapayag ka sa pagkuha at paggamit ng iyong impormasyon alinsunod sa patakarang ito.)
        </p>
      </div>
    </div>
  </div>

</div>


    <!-- Agree & Next Buttons -->
    <div class="flex flex-col items-center mt-10 sm:mt-14 space-y-6">
      <label class="flex items-center gap-3 text-gray-800 text-base sm:text-lg font-semibold">
        <input type="checkbox" id="agreeCheckbox" class="w-5 h-5 accent-blue-600">
        I have read and agree to the Data Privacy Policy
        <span class="italic text-gray-600 text-sm sm:text-base">(Sumasang-ayon ako sa Patakaran sa Privacy)</span>
      </label>

      <button id="nextButton"
        class="bg-[#2E2EFF] text-white text-2xl sm:text-3xl font-bold px-20 sm:px-28 md:px-32 py-4 sm:py-5 rounded-3xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed"
        disabled
        onclick="window.location.href='<?php echo e(route('registeradminapprove')); ?>'">
        Next →
      </button>

      <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-2 text-center leading-relaxed px-4 sm:px-0">
        Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue<br class="hidden sm:block">
        <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
      </p>
    </div>
  </div>

  <script>
    const agreeCheckbox = document.getElementById('agreeCheckbox');
    const nextButton = document.getElementById('nextButton');

    agreeCheckbox.addEventListener('change', () => {
      nextButton.disabled = !agreeCheckbox.checked;
      nextButton.classList.toggle('bg-blue-600', agreeCheckbox.checked);
    });
  </script>

  <!-- TTS: Web Speech API handler -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const buttons = document.querySelectorAll('.tts-btn');
      // prefer a single high-quality voice for both English and Filipino
      const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
      let preferredVoice = null;
      let currentBtn = null;
      let availableVoices = [];

      function populateVoices() {
        availableVoices = window.speechSynthesis.getVoices() || [];
        // try exact match first, then fuzzy match for known Microsoft AvaMultilingual
        preferredVoice = availableVoices.find(v => v.name === preferredVoiceName)
          || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
          || null;
      }

      function chooseVoiceForLang(langCode) {
        if (!availableVoices.length) return null;
        langCode = (langCode || '').toLowerCase();
        let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
        if (candidates.length) return pickBest(candidates);
        candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
        if (candidates.length) return pickBest(candidates);
        return availableVoices[0];
      }

      function pickBest(list) {
        let preferred = list.filter(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
        if (preferred.length) return preferred[0];
        return list[0];
      }

      function stopSpeaking() {
        if (window.speechSynthesis) {
          window.speechSynthesis.cancel();
        }
        if (currentBtn) {
          currentBtn.classList.remove('speaking');
          currentBtn.removeAttribute('aria-pressed');
          currentBtn = null;
        }
      }

      buttons.forEach(function (btn) {
        btn.setAttribute('role', 'button');
        btn.setAttribute('tabindex', '0');

        btn.addEventListener('click', function () {
          const textEn = (btn.getAttribute('data-tts-en') || '').trim();
          const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
          if (!textEn && !textTl) return;

          if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
            stopSpeaking();
            return;
          }

          stopSpeaking();

          setTimeout(function () {
            if (!window.speechSynthesis) return;

            function voiceFor(langHint) {
              if (preferredVoice) return preferredVoice;
              if (langHint) {
                const hint = (langHint || '').toLowerCase();
                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                  return chooseVoiceForLang('tl');
                }
                return chooseVoiceForLang(langHint);
              }
              return chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
            }

            const seq = [];
            if (textEn) {
              const uEn = new SpeechSynthesisUtterance(textEn);
              uEn.lang = 'en-US';
              const v = voiceFor('en');
              if (v) uEn.voice = v;
              seq.push(uEn);
            }
            if (textTl) {
              const uTl = new SpeechSynthesisUtterance(textTl);
              uTl.lang = 'tl-PH';
              const v2 = voiceFor('tl');
              if (v2) uTl.voice = v2;
              seq.push(uTl);
            }

            if (!seq.length) return;

            seq[0].onstart = function () {
              btn.classList.add('speaking');
              btn.setAttribute('aria-pressed', 'true');
              currentBtn = btn;
            };

            for (let i = 0; i < seq.length; i++) {
              const ut = seq[i];
              ut.onerror = function () {
                if (btn) btn.classList.remove('speaking');
                if (btn) btn.removeAttribute('aria-pressed');
                currentBtn = null;
              };
              if (i < seq.length - 1) {
                ut.onend = function () {
                  window.speechSynthesis.speak(seq[i + 1]);
                };
              } else {
                ut.onend = function () {
                  if (btn) btn.classList.remove('speaking');
                  if (btn) btn.removeAttribute('aria-pressed');
                  currentBtn = null;
                };
              }
            }

            window.speechSynthesis.speak(seq[0]);
          }, 50);
        });

        btn.addEventListener('keydown', function (ev) {
          if (ev.key === 'Enter' || ev.key === ' ') {
            ev.preventDefault();
            btn.click();
          }
        });
      });

      window.addEventListener('beforeunload', function () {
        if (window.speechSynthesis) window.speechSynthesis.cancel();
      });

      if (window.speechSynthesis) {
        populateVoices();
        window.speechSynthesis.onvoiceschanged = function () {
          populateVoices();
        };
      }
    });
  </script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\resources\views/ds_data-privacy.blade.php ENDPATH**/ ?>