<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Applicant Registration: Data Privacy</title>
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

<body class="bg-white flex justify-center sm:items-center items-start min-h-screen p-4 sm:p-6 relative overflow-auto">

  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot"
    class="hidden sm:block fixed left-2 sm:left-6 lg:left-10 top-1/3 w-20 sm:w-28 md:w-32 opacity-90 animate-float-slow z-0">
  <img src="image/obj7.png" alt="Triangle Mascot"
    class="hidden sm:block fixed left-2 sm:left-6 lg:left-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-28 opacity-90 animate-float-medium z-0">
  <img src="image/obj3.png" alt="Blue Mascot"
    class="hidden sm:block fixed right-2 sm:right-6 lg:right-10 top-1/4 w-20 sm:w-28 md:w-32 opacity-90 animate-float-fast z-0">
  <img src="image/obj8.png" alt="Twin Mascot"
    class="hidden sm:block fixed right-2 sm:right-6 lg:right-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-32 opacity-90 animate-float-medium z-0">

  <!-- Back Button -->
  <button
    class="fixed left-2 top-2 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl flex items-center gap-2 sm:gap-3 text-sm sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
      onclick="(history.length>1 ? history.back() : window.location.href='{{ route('register2') }}')">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="4" stroke="white" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </button>

  <!-- Main Container -->
  <div class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

    <!-- Header -->
    <div class="text-center mt-4">
      <h1 class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Data Privacy Notice</h1>
      <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">
      <h2 class="relative flex flex-wrap items-center justify-center gap-3 text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold">
        <span class="block mx-auto max-w-[82%] sm:max-w-none md:max-w-[85%] text-center md:pr-2 ">We protect your personal information</span>
        <button type="button" aria-label="Play audio: We protect your personal information"
        class="ml-2 md:ml-3 text-sm sm:text-2xl bg-[#1E40AF] text-white p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn md:absolute md:right-3 md:top-1/2 md:-translate-y-1/2" 
        data-tts-en="We Protect Your Personal Information" data-tts-tl="Pinangangalagaan namin ang iyong personal na impormasyon">🔊</button>
      </h2>
      <p class="mt-2 sm:mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
        (Pinangangalagaan namin ang iyong personal na impormasyon)
      </p>
    </div>

<!-- Info Section -->
<div
  class="mt-8 sm:mt-10 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md relative">

  <!-- Desktop Audio Button -->
  <button type="button" aria-label="Play audio for info section"
    class="hidden sm:block absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
           text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
           focus:ring-2 focus:ring-blue-400 tts-btn"
    data-tts-en="We value your trust and are committed to protecting your data in compliance with the Data Privacy Act of 2012 (RA 10173)."
    data-tts-tl="Pinahahalagahan namin ang iyong tiwala at pinoprotektahan namin ang iyong impormasyon alinsunod sa Data Privacy Act of 2012.">
    🔊
  </button>

  <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pr-4 sm:pr-16">

    <!-- Icon -->
    <span class="text-[#846506] text-3xl sm:text-5xl mt-1 flex-shrink-0 mx-auto sm:mx-0">💡</span>

    <!-- Text -->
    <div class="flex-1 text-center sm:text-left">

      <p class="text-base sm:text-lg text-gray-700 font-bold leading-relaxed">
        We value your trust and are committed to protecting your data in compliance with the Data Privacy Act of 2012 (RA 10173).
      </p>

      <p class="text-gray-700 italic text-sm sm:text-base mt-2">
        (Pinahahalagahan namin ang iyong tiwala at pinoprotektahan namin ang iyong impormasyon alinsunod sa Data Privacy Act of 2012.)
      </p>

      <!-- Mobile Audio Button -->
      <div class="mt-3 flex justify-center sm:hidden">
        <button type="button" aria-label="Play audio for info section"
          class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                 transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
          data-tts-en="We value your trust and are committed to protecting your data in compliance with the Data Privacy Act of 2012 (RA 10173)."
          data-tts-tl="Pinahahalagahan namin ang iyong tiwala at pinoprotektahan namin ang iyong impormasyon alinsunod sa Data Privacy Act of 2012.">
          🔊
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Sections -->
<div class="mt-10 sm:mt-12 max-w-4xl mx-auto space-y-6 sm:space-y-8">

  <!-- Info We Collect -->
  <div class="bg-white rounded-3xl p-6 sm:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center sm:items-start">

      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
        class="w-14 h-14 flex-shrink-0 mx-auto sm:mx-0">

      <div class="flex-1 text-center sm:text-left max-w-2xl">

        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-4">
          Information We Collect
        </h3>

        <ul class="list-disc list-inside text-gray-800 text-base sm:text-lg space-y-2 text-left sm:text-left mx-auto sm:mx-0 max-w-xl">
          <li>Personal details: name, contact number, age, email, home address.</li>
          <li>Parent/Guardian details: name, contact number, email.</li>
          <li>Education and employment history.</li>
          <li>Preferred workplace, your skills, and job preferences.</li>
          <li>PWD ID, Medical Certificate, and Resume</li>
        </ul>

        <p class="text-gray-600 italic text-base sm:text-lg mt-4 text-center sm:text-left">
          (Kinokolekta namin ang impormasyon tulad ng pangalan, contact number, email, address,
          edukasyon, gustong lugar ng trabaho, iyong kakayanan at mga trabahong kagustuhan.)
        </p>

      </div>
    </div>

    <div class="mt-4 flex justify-center sm:justify-end">
      <button type="button"
        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
        data-tts-en="Personal details we collect include name, contact number, email address, parent or guardian details, education and employment history, supports needed, your skills, and job preferences."
        data-tts-tl="Kinokolekta namin ang impormasyon tulad ng pangalan, contact number, email, edukasyon, supportang kailangan, iyong kakayanan at mga trabahong kagustuhan.">
        🔊
      </button>
    </div>
  </div>


  <!-- Purpose -->
  <div class="bg-white rounded-3xl p-6 sm:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center sm:items-start">

      <img src="https://cdn-icons-png.flaticon.com/512/9119/9119230.png"
        class="w-14 h-14 flex-shrink-0 mx-auto sm:mx-0">

      <div class="flex-1 text-center sm:text-left max-w-2xl">

        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-3">
          Purpose of Data Collection
        </h3>

        <ul class="list-disc list-inside text-gray-800 text-base sm:text-lg space-y-2 text-left sm:text-left mx-auto sm:mx-0 max-w-xl">
          <li>Match you with job opportunities.</li>
          <li>Improve our services and support.</li>
          <li>Meet compliance requirements.</li>
        </ul>

        <p class="text-gray-600 italic text-base sm:text-lg mt-4 text-center sm:text-left">
          (Upang mahanap ang angkop na trabaho, mapabuti ang aming serbisyo, at makasunod sa mga regulasyon.)
        </p>

      </div>
    </div>

    <div class="mt-4 flex justify-center sm:justify-end">
      <button type="button"
        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
        data-tts-en="We collect data to match you with job opportunities and training, improve our services and support, and meet compliance requirements."
        data-tts-tl="Upang mahanap ang angkop na trabaho o pagsasanay, mapabuti ang aming serbisyo, at makasunod sa mga regulasyon.">
        🔊
      </button>
    </div>
  </div>


  <!-- Protection -->
  <div class="bg-white rounded-3xl p-6 sm:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center sm:items-start">

      <img src="https://cdn-icons-png.flaticon.com/512/10473/10473528.png"
        class="w-14 h-14 flex-shrink-0 mx-auto sm:mx-0">

      <div class="flex-1 text-center sm:text-left max-w-2xl">

        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-3">
          Data Protection & Access
        </h3>

        <p class="text-gray-700 text-base sm:text-lg leading-relaxed">
          We use secure systems and only authorized personnel can access your data. Information is only used for declared purposes.
        </p>

        <p class="text-gray-700 italic text-base sm:text-lg mt-3">
          (Ginagamit ang ligtas na sistema at tanging may awtoridad ang pwedeng kumuha ng impormasyon. Ginagamit lamang para sa nakasaad na layunin.)
        </p>

      </div>
    </div>

    <div class="mt-4 flex justify-center sm:justify-end">
      <button type="button"
        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
        data-tts-en="We use secure systems and only authorized personnel can access your data. Information is only used for declared purposes."
        data-tts-tl="Ginagamit ang ligtas na sistema at tanging may awtoridad ang pwedeng kumuha ng impormasyon. Ginagamit lamang para sa nakasaad na layunin.">
        🔊
      </button>
    </div>
  </div>


  <!-- Consent -->
  <div class="bg-white rounded-3xl p-6 sm:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
    <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center sm:items-start">

      <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png"
        class="w-14 h-14 flex-shrink-0 mx-auto sm:mx-0">

      <div class="flex-1 text-center sm:text-left max-w-2xl">

        <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-3">
          Your Consent
        </h3>

        <p class="text-gray-700 text-base sm:text-lg leading-relaxed">
          By using our services, you consent to the collection & processing of your personal data under this policy.
        </p>

        <p class="text-gray-700 italic text-base sm:text-lg mt-3">
          (Sa paggamit ng aming serbisyo, pumapayag ka sa pagkuha at paggamit ng iyong impormasyon alinsunod sa patakarang ito.)
        </p>

      </div>
    </div>

    <div class="mt-4 flex justify-center sm:justify-end">
      <button type="button"
        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
        data-tts-en="By using our services, you consent to the collection and processing of your personal data under this policy."
        data-tts-tl="Sa paggamit ng aming serbisyo, pumapayag ka sa pagkuha at paggamit ng iyong impormasyon alinsunod sa patakarang ito.">
        🔊
      </button>
    </div>
  </div>

</div>


  <!-- Agree & Next Buttons -->
  <div class="flex flex-col items-center mt-10 sm:mt-14 w-full px-4 sm:px-0 space-y-4">

    <!-- Agreement Checkbox -->
    <label for="agreeCheckbox" class="w-full max-w-2xl flex items-center gap-2 sm:gap--1 md:gap-1 lg:gap-1 text-gray-800 text-base sm:text-lg font-semibold cursor-pointer mb-6">

      <input type="checkbox" id="agreeCheckbox" class="w-6 h-6 sm:w-8 sm:h-8 accent-blue-600 flex-shrink-0 focus:ring-2 focus:ring-blue-300 rounded-sm" aria-describedby="agreeHelp">

      <div class="flex-1 text-center">
        <div class="text-lg leading-tight">I have read and agree to the Data Privacy Policy</div>
        <div id="agreeHelp" class="italic text-gray-600 text-md sm:text-base">(Sumasang-ayon ako sa Patakaran sa Privacy)</div>
      </div>

    </label>

    <!-- Next Button -->
    <div class="flex flex-col items-center mt-18 sm:mt-22 w-full px-4 sm:px-0">
      <button id="nextButton"
        class="w-full sm:w-auto bg-[#2E2EFF] text-white text-2xl sm:text-3xl font-bold px-8 sm:px-20 md:px-32 py-3 sm:py-4 rounded-3xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-300"
        disabled
        aria-disabled="true"
        onclick="window.location.href='{{ route('registeradminapprove') }}'">
        Next →
      </button>
        <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
        Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue <br class="hidden sm:block">
        <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
      </p>
    </div>

  </div>

  <script>
    (function () {
      const agreeCheckbox = document.getElementById('agreeCheckbox');
      const nextButton = document.getElementById('nextButton');

      function updateButtonState() {
        const checked = !!agreeCheckbox.checked;
        nextButton.disabled = !checked;
        nextButton.setAttribute('aria-disabled', (!checked).toString());
        nextButton.classList.toggle('bg-blue-600', checked);
      }

      agreeCheckbox.addEventListener('change', updateButtonState);

      // keyboard: allow toggling with Space/Enter on label-controlled input (native),
      // and allow pressing Enter on focused button to proceed (native). Add small helper for clarity.
      agreeCheckbox.addEventListener('keydown', function (ev) {
        if ((ev.key === 'Enter' || ev.key === ' ') && agreeCheckbox.checked) {
          // space/enter toggles the checkbox naturally — when it's already checked, allow quick submit
          // only trigger click if the checkbox is checked and nextButton is enabled
          ev.preventDefault();
          updateButtonState();
          if (!nextButton.disabled) nextButton.focus();
        }
      });

      // Initialize state on load
      document.addEventListener('DOMContentLoaded', updateButtonState);
      // If script loads after DOM ready
      updateButtonState();
    })();
  </script>

  <!-- TTS: Web Speech API handler -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const buttons = document.querySelectorAll('.tts-btn');
      // prefer a single high-quality voice for English and a preferred Tagalog voice
      const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
      const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
      let preferredVoice = null;
      let preferredTagalogVoice = null;
      let currentBtn = null;
      let availableVoices = [];

      function populateVoices() {
        availableVoices = window.speechSynthesis.getVoices() || [];
        // try exact match first for English, then fuzzy match for known Microsoft AvaMultilingual
        preferredVoice = availableVoices.find(v => v.name === preferredVoiceName)
          || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
          || null;
        // prefer a Tagalog voice (matches ds_register_2 preferences)
        preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName)
          || availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name))
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
              // prefer explicit Tagalog or English voices when available
              if (langHint) {
                const hint = (langHint || '').toLowerCase();
                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                  if (preferredTagalogVoice) return preferredTagalogVoice;
                  return chooseVoiceForLang('tl');
                }
                if (hint.startsWith('en')) {
                  if (preferredVoice) return preferredVoice;
                  return chooseVoiceForLang('en');
                }
              }
              // fallback to preferred English voice then a general chooser
              if (preferredVoice) return preferredVoice;
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
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Comprehensive client-side clear for registerreview2 keys
  const explicitKeys = [
    // registration drafts
    'registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data',
    'rpi_personal','rpi_personal1','rpi_personal2','__mvsg_lastLoadedDraft','__mvsg_lastDraftSource',
    // certificate / proof keys (many variants)
    'uploadedProofData','uploadedProofType','uploadedProofName',
    'uploadedProofData1','uploadedProofType1','uploadedProofName1',
    'uploadedProofData0','uploadedProofType0','uploadedProofName0',
    'uploaded_proof_data','uploaded_proof_type','uploaded_proof_name',
    'uploadedProofUrl','uploaded_proof_url','uploadedProofPath','uploaded_proof_path',
    'uploadedProofDataUrl','uploaded_proof_data_url',
    'proofData','proofType','proofName','proofFilename','cert_file',
    // review fields & UI keys used by review-2
    'review_certs','review_certfile','review_certfile_name','review_certs_name','review_certs_file',
    'review_certfile','review_certs_file','review_certs_name','review_certs_file',
    'review_edu','edu_level','educationLevel','education_level','schoolName','school','school_name','schoolName_name',
    'review_other','edu_other','edu_other_text','review_certs_file','review_certs_name',
    // work / job keys
    'job_experiences','work_experiences','jobExperiences','jobExperience','job_experience',
    'selected_work_experience','work_type','workType','review_work','review_work_list',
    'workplace','preferred_workplace','workplace_choice','workplaceChoice','workplace_choice_img','workplace_image',
    'review_workplace_choice_img','review_workplace_choice_img_src','review_job_experiences',
    // skills / prefs
    'jobPreferences','jobpref1','jobpref','jobprefs','job_preferences','skills1_selected','skills_page1','skills','selected_skills'
  ];

  // substrings to remove broadly
  const substrings = ['uploaded','upload','proof','cert','file','rpi_personal','registration','jobpref','job','work','review_','school','skill','experience','mvsg','__mvsg'];

  // cookie names to expire (client side best-effort)
  const cookieCandidates = ['laravel_session','XSRF-TOKEN','session','session_id','firebase_uid','session_firebase_uid'];

  function expireCookie(name) {
    try {
      document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT; SameSite=Lax;";
      const parts = location.hostname.split('.');
      if (parts.length > 1) {
        const domain = '.' + parts.slice(-2).join('.');
        document.cookie = name + "=; Path=/; Domain=" + domain + "; Expires=Thu, 01 Jan 1970 00:00:01 GMT; SameSite=Lax;";
      }
    } catch(e){}
  }

  function clearStorages() {
    try {
      // explicit keys first
      explicitKeys.forEach(k => { try { localStorage.removeItem(k); sessionStorage.removeItem(k); } catch(e){} });

      // remove by substring (localStorage)
      try {
        for (let i = localStorage.length - 1; i >= 0; i--) {
          const key = localStorage.key(i);
          if (!key) continue;
          const low = key.toLowerCase();
          for (const sub of substrings) {
            if (low.includes(sub.toLowerCase())) {
              try { localStorage.removeItem(key); } catch(e){}
              break;
            }
          }
        }
      } catch (e) {}

      // remove by substring (sessionStorage)
      try {
        for (let i = sessionStorage.length - 1; i >= 0; i--) {
          const key = sessionStorage.key(i);
          if (!key) continue;
          const low = key.toLowerCase();
          for (const sub of substrings) {
            if (low.includes(sub.toLowerCase())) {
              try { sessionStorage.removeItem(key); } catch(e){}
              break;
            }
          }
        }
      } catch (e) {}

    } catch (e) { console.warn('[mvsg] clearStorages error', e); }
  }

  function clearCookies() {
    try {
      cookieCandidates.forEach(expireCookie);
      // expire cookies that look related
      const all = document.cookie ? document.cookie.split(';') : [];
      all.forEach(c => {
        const name = c.split('=')[0].trim();
        if (!name) return;
        const low = name.toLowerCase();
        for (const sub of substrings.concat(['session','auth','firebase'])) {
          if (low.includes(sub)) { expireCookie(name); break; }
        }
      });
    } catch(e){ console.warn('[mvsg] clearCookies error', e); }
  }

  function clearUIAndGlobals() {
    try {
      // clear known globals
      try { window.__mvsg_serverProfile = null; } catch(e){}
      try { window.__mvsg_serverProfileUid = null; } catch(e){}
      try { window.__mvsg_lastLoadedDraft = null; } catch(e){}
      try { window.__mvsg_lastDraftSource = null; } catch(e){}

      // set file UI text to "No file uploaded"
      const fileUiIds = ['review_certfile','review_certfile_name','proofFileName','review_certs','proofFileInfo','proofFileIcon','proof'];
      fileUiIds.forEach(id => {
        try {
          const el = document.getElementById(id);
          if (!el) return;
          if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = '';
          else el.textContent = (id === 'review_certfile' || id === 'review_certfile_name' || id === 'proofFileName') ? 'No file uploaded' : '';
          if (id === 'proofFileInfo' && el.classList) el.classList.add('hidden');
        } catch(e){}
      });
    } catch(e){ console.warn('[mvsg] clearUIAndGlobals error', e); }
  }

  function notifyOthers() {
    try {
      localStorage.setItem('mvsg:cleared', Date.now().toString());
      setTimeout(()=> { try { localStorage.removeItem('mvsg:cleared'); } catch(e){} }, 600);
      try { window.dispatchEvent(new CustomEvent('mvsg:cleared', { detail: { ts: Date.now() } })); } catch(e){}
    } catch(e){}
  }

  // Run clears
  try {
    clearStorages();
    clearCookies();
    clearUIAndGlobals();
    notifyOthers();
    console.info('[mvsg] client-side draft/ uploaded-file keys cleared (data-privacy)');
  } catch (err) {
    console.warn('[mvsg] data-privacy clear failed', err);
  }

  // OPTIONAL: notify server to clear server-side session keys
  // Create a POST route /clear-draft that calls session()->forget([...]) if you want server-side clearing.
  (function tryServerClear() {
    try {
      fetch('/clear-draft', { method: 'POST', credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' }, body: JSON.stringify({ clear: true }) })
        .then(r => r.json().catch(()=>null))
        .then(j => { if (j && j.ok) console.info('[mvsg] server-side draft cleared'); else console.debug('[mvsg] server clear returned', j); })
        .catch(e => console.debug('[mvsg] server clear request failed', e));
    } catch(e){}
  })();

});
</script>
</body>
</html>
