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
      .skills-card.selected::after { content: ""; position:absolute; right:10px; bottom:10px; width:44px; height:44px; background-image:url('/image/checkmark.png'); background-size:contain; background-repeat:no-repeat; }
      /* TTS button visual state */
      .tts-btn { cursor: pointer; }
      .tts-btn.speaking { transform: scale(1.04); box-shadow: 0 8px 24px rgba(30,64,175,0.12); }
    </style>
  </head>
<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot"
    class="hidden sm:block fixed left-1 sm:left-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-slow z-0">
  <img src="image/obj7.png" alt="Triangle Mascot"
    class="hidden sm:block fixed left-1 sm:left-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">
  <img src="image/obj3.png" alt="Blue Mascot"
    class="hidden sm:block fixed right-1 sm:right-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-fast z-0">
  <img src="image/obj8.png" alt="Twin Mascot"
    class="hidden sm:block fixed right-1 sm:right-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">

  <!-- Back Button -->
  <button
  class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
  onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerreview2') }}')">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
      class="w-3 h-3 sm:w-6 sm:h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </button>

  <!-- Main Content Container -->
  <div
    class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

    <!-- Header -->
    <div class="text-center mt-2 sm:mt-4 px-2">
      <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug">
        Review Your Skills
      </h1>
      <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
    </div>

    <!-- Instructions -->
    <div class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm">
      <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
        <svg xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
        </svg>
        <div class="flex-1 text-center sm:text-left">
          <p class="font-medium text-xs sm:text-base leading-relaxed">
            You can change your skills by clicking the "Change" button. 
          </p>
          <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
            (Maaari mong baguhin ang iyong mga kasanayan sa pamamagitan ng pag-click sa button na “Change”)
          </p>
        </div>
      </div>
      <button type="button"
        class="tts-btn absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200"
        data-tts-en="You can change your skills by clicking the Change button."
        data-tts-tl="Maaari mong baguhin ang iyong mga kasanayan sa pamamagitan ng pag-click sa button na Change"
        aria-label="Read instructions aloud in English then Filipino"></button>
    </div>

    <!-- Skills Review Section -->
    <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 mt-6">
      <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
        Skills Summary
      </h3>

      <!-- Skills List -->
      <div id="review_skills_list" class="flex flex-wrap gap-3 mb-6">
        <!-- Example skill tags -->
        <span
          class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm">
  
        </span>
        <span
          class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm">
    
        </span>
      </div>


      <!-- Change Skills -->
      <div class="flex justify-center">
        <button type="button" id="rv4_change_skills_btn"
          class="bg-[#2E2EFF] hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition-transform duration-200 hover:scale-105">
          ✏️ Change
        </button>
      </div>
    </div>

    <!-- Continue Button -->
    <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">
      <button type="button"
        class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
          px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
          shadow-md w-full sm:w-64 text-center"
  onclick="window.location.href='{{ route('registerreview5') }}'">
        Continue →
      </button>
    </div>

    <!-- Helper Text -->
    <p class="text-gray-700 text-sm mt-4 text-center">
      Click <span class="text-[#1E40AF] font-medium">“Continue”</span> to move to the next page
    </p>
    <p class="text-gray-600 italic text-[13px] text-center">
      (Pindutin ang “Continue” upang magpatuloy)
    </p>
  </div>


    <!-- removed global floating preview -->

  <script src="{{ asset('js/firebase-config-global.js') }}"></script>
  <script src="{{ asset('js/register.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', async () => {
      try {
        // Prefer the centralized populateReview() logic which merges local/session/global and Firestore.
        if (typeof window.populateReview === 'function') {
          await window.populateReview();
        }
        const data = window.__mvsg_lastLoadedDraft || {};
        const parseMaybeJson = (v) => {
          if (v === null || v === undefined) return v;
          if (Array.isArray(v) || typeof v === 'object') return v;
          if (typeof v === 'string') {
            const s = v.trim(); if (!s) return '';
            if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
              try { return JSON.parse(s); } catch(e) { /* fall through */ }
            }
            if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
          }
          return v;
        };

        // unify candidate lookup for skills (handle multiple shapes)
        const sCandidates = (data.skills && (data.skills.skills_page1 || data.skills_page2 || data.skills_page || data.skills)) || data.skillList || data.selectedSkills || data.skillsPage1 || data.skills_page1 || data.skills_page || data.selected_skills || null;
        let arr = [];
        const parsed = parseMaybeJson(sCandidates);
        if (Array.isArray(parsed)) arr = parsed;
        else if (typeof parsed === 'string' && parsed) arr = parsed.split(',');
        // fallback: read common top-level keys stored as JSON strings
        if (!arr.length) {
          const fallback = parseMaybeJson(data.skills_page1) || parseMaybeJson(data.skills_page2) || parseMaybeJson(data.skills1) || parseMaybeJson(data.skills2) || null;
          if (Array.isArray(fallback)) arr = fallback;
        }
        const uniq = [...new Set((arr||[]).map(x => typeof x === 'string' ? x.trim() : x).filter(Boolean))];
        if (uniq.length) {
          const el = document.getElementById('review_skills_list');
          if (el) {
            el.innerHTML = '';
            for (const s of uniq) {
              try {
                const span = document.createElement('span');
                span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                span.textContent = s;
                el.appendChild(span);
              } catch(e) { /* ignore */ }
            }
          }
          try { if (typeof window.setChoiceImage === 'function') window.setChoiceImage('review_skills_img', uniq[0], ['.skills-card','.selectable-card']); } catch(e){}
          try { document.querySelectorAll('.skills-card, .selectable-card').forEach(card=>{ const title = card.querySelector('h3')?.textContent?.trim(); if (title && uniq.includes(title)) card.classList.add('selected'); else card.classList.remove('selected'); }); } catch(e){}
        }
      } catch (e) {
        console.error('review-4 populateReview usage failed', e);
      }
    });
    </script>
    <script>
      // Save visible skills review to localStorage['rpi_personal'] then navigate to the given url (preserve uid if available)
      function saveDraftAndGotoSkills(url) {
        try {
          let draft = window.__mvsg_lastLoadedDraft || {};
          if (!draft || typeof draft !== 'object') draft = {};

          // ensure skills namespace exists
          draft.skills = draft.skills || {};

          // collect skill tags from DOM
          try {
            const listEl = document.getElementById('review_skills_list');
            if (listEl) {
              const spans = Array.from(listEl.querySelectorAll('span'));
              const vals = spans.map(s => (s.textContent||'').trim()).filter(Boolean);
              if (vals.length) draft.skills = draft.skills || {};
              // store as array and also as comma string for legacy shapes
              draft.skills.selected = vals;
              draft.skills.selected_csv = vals.join(', ');
            }
          } catch(e) { console.debug('[review-4] collect skills failed', e); }

          try {
            localStorage.setItem('rpi_personal', JSON.stringify(draft));
            try { console.info('[review-4] saveDraftAndGotoSkills wrote rpi_personal', JSON.parse(localStorage.getItem('rpi_personal'))); } catch(e) { console.info('[review-4] saveDraftAndGotoSkills wrote rpi_personal (readback failed)'); }
          } catch(e) { console.warn('[review-4] failed to write rpi_personal', e); }
        } catch(e) { console.warn('[review-4] build draft failed', e); }

        // navigate and append uid when available
        try {
          let uid = '';
          if (window.firebase && firebase.auth) {
            const user = firebase.auth().currentUser;
            if (user && user.uid) uid = user.uid;
          }
          if (uid) {
            const sep = url.includes('?') ? '&' : '?';
            window.location.href = url + sep + 'uid=' + encodeURIComponent(uid);
          } else {
            window.location.href = url;
          }
        } catch(e) { window.location.href = url; }
      }

      // Wire the Change button to save draft first then navigate
      document.addEventListener('DOMContentLoaded', function(){
        try {
          const btn = document.getElementById('rv4_change_skills_btn');
          if (btn) btn.addEventListener('click', function(e){ e.preventDefault(); saveDraftAndGotoSkills('{{ route('registerskills1') }}'); });
        } catch(e) { console.debug('[review-4] wiring change button failed', e); }
      });
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
  </body>
</html>
