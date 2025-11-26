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
            You can change your skills by clicking the "Edit" button. 
          </p>
          <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
            (Maaari mong baguhin ang iyong mga kasanayan sa pamamagitan ng pag-click sa button na “Edit”)
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
          ✏️ Edit
        </button>
      </div>
    </div>

     <input id="skills_page1" type="hidden" value="[]" />

    <!--  SKILLS EDIT MODAL -->

<div id="editSkillsModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center 
            z-[9999] transition-opacity duration-300 opacity-0">

<div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 max-w-5xl w-[95%] max-h-[90vh] 
            overflow-y-auto border border-gray-200 relative scale-95 transition-all duration-300">

    <!-- Title -->
    <h2 class="text-center text-1xl sm:text-2xl font-extrabold text-gray-800">
        What skills do you have or feel confident doing?
    </h2>
    <p class="text-center text-gray-500 italic mt-1">
        (Anong mga kakayahan ang kaya mong gawin o komportable ka?)
    </p>

    <!-- Yellow Note -->
    <div class="bg-yellow-100 border border-yellow-300 rounded-xl p-4 mt-6 text-center shadow-sm">
        <p class="font-semibold text-yellow-900">You can choose more than one option</p>
        <p class="text-yellow-800 italic text-sm">(Puwede kang pumili ng higit sa isa)</p>
    </div>

    <!-- Skills Cards Grid -->
    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

        <!-- Card 1 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Following Instructions">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Following Instructions:I can follow easy steps one at a time." 
                data-tts-tl="Kaya kong sundin ang simple, step-by-step na utos">🔊</button>
            <img src="image/skill1.png" alt="following instructions" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Following Instructions</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can follow easy steps one at a time.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong sundin ang simple, step-by-step na utos)</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Communication Skills">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Communication Skills: I can greet people, talk in a simple way, and answer Yes or No." 
                data-tts-tl="Kaya kong bumati (“Hello/Good morning”), makipag-usap nang simple, at sumagot ng Yes/No">🔊</button>
            <img src="image/skill2.png" alt="communication skills" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Communication Skills</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can greet people, talk in a simple way, and answer Yes or No.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong bumati (“Hello/Good morning”), makipag-usap nang simple, at sumagot ng Yes/No)</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Social Interaction">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Social Interaction: I can be polite, friendly, and talk nicely to other people." 
                data-tts-tl="Ako ay magalang, friendly, at kaya kong makipag-usap sa ibang tao o customers">🔊</button>
            <img src="image/skill3.png" alt="social interaction" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Social Interaction</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can be polite, friendly, and talk nicely to other people.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Ako ay magalang, friendly, at kaya kong makipag-usap sa ibang tao o customers)</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Physical Ability">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Physical Ability: I can stand, walk, and carry light things." 
                data-tts-tl="Kaya kong tumayo, maglakad, at magbuhat ng magagaan na gamit">🔊</button>
            <img src="image/skill4.png" alt="physical ability" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Physical Ability</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can stand, walk, and carry light things.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong tumayo, maglakad, at magbuhat ng magagaan na gamit)</p>
        </div>

        <!-- Card 5 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Attention to Task">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Attention to Task: I can stay focused and finish my task." 
                data-tts-tl="Kaya kong mag-focus at tapusin ang trabaho nang tuloy-tuloy">🔊</button>
            <img src="image/skill5.png" alt="attention to task" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Attention to Task</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can stay focused and finish my task.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong mag-focus at tapusin ang trabaho nang tuloy-tuloy)</p>
        </div>

        <!-- Card 6 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Task Repetition">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Task Repetition: I can repeat the same task many times, like arranging items." 
                data-tts-tl="Kaya kong ulit-ulitin ang gawain tulad ng pag-aayos ng products">🔊</button>
            <img src="image/skill6.png" alt="task repetition" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Task Repetition</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can repeat the same task many times, like arranging items.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong ulit-ulitin ang gawain tulad ng pag-aayos ng products)</p>
        </div>

        <!-- Card 7 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Trainable">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Trainable: I can learn new tasks when someone teaches me step by step." 
                data-tts-tl="Kaya ko matuto kapag may nagtuturo sa akin nang simple">🔊</button>
            <img src="image/skill7.png" alt="trainable" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Trainable</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can learn new tasks when someone teaches me step by step.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya ko matuto kapag may nagtuturo sa akin nang simple)</p>
        </div>

        <!-- Other -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Other">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Other, Type your answer inside the box if not in the choices" 
                data-tts-tl="Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian">🔊</button>
            <h3 class="text-blue-700 font-bold text-lg mb-2">Other</h3>
            <p class="text-sm text-center mt-2">Type your answer if not in the choices</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-1">(Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)</p>
            <input id="skills_other_input" type="text" placeholder="Type your answer here"
                class="w-full border border-gray-300 rounded-lg p-2 text-sm mt-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>
    </div>

   

    <!-- Buttons -->
    <div class="flex justify-center gap-6 mt-10">
        <button id="closeSkillsModal"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl 
                       hover:bg-red-700 transition shadow-sm">
            Cancel
        </button>

        <button id="saveSkillsEdit"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl 
                       hover:bg-blue-700 transition shadow-sm">
            Save Changes
        </button>
    </div>
</div>
</div>



<!-- Skills Card Style -->
<style>
.selected-card {
    border: 3px solid #1E40AF !important;
    background-color: #DBEAFE !important;
}
</style>

<!-- Skills edit/save script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // consolidate and update: only use 'selected-card' class (remove any use of legacy 'selected' class)
  const skillsModal = document.getElementById("editSkillsModal");
  const skillsCards = Array.from(document.querySelectorAll(".skills-card, .selectable-card"));
  const hiddenInput = document.getElementById("skills_page1");
  const editBtn = document.getElementById("rv4_change_skills_btn");
  const closeBtn = document.getElementById("closeSkillsModal");
  const saveBtn = document.getElementById("saveSkillsEdit");
  const reviewList = document.getElementById("review_skills_list");

  const LS_KEYS = ['skills_page1','skills_page_1','skills1','skills','selected_skills','selectedSkills','skills_page','skills_page1_value','skills1_selected'];

  const parseMaybeJson = (v) => {
    if (v === null || v === undefined) return v;
    if (Array.isArray(v) || typeof v === 'object') return v;
    if (typeof v !== 'string') return v;
    const s = v.trim();
    if (!s) return '';
    if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
      try { return JSON.parse(s); } catch(e){}
    }
    return s;
  };

  const normalizeArray = (v) => {
    if (v === null || v === undefined) return [];
    if (Array.isArray(v)) return v.map(x => typeof x === 'string' ? x.trim() : String(x||'')).filter(Boolean);
    if (typeof v === 'object') {
      try { return Object.values(v).map(x => String(x||'').trim()).filter(Boolean); } catch(e){ return []; }
    }
    if (typeof v === 'string') {
      const s = v.trim();
      if (!s) return [];
      if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
        try { return normalizeArray(JSON.parse(s)); } catch(e){}
      }
      if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
      return [s];
    }
    return [];
  };

  function getSavedSkills() {
    try {
      // 1) hidden input first (explicit)
      if (hiddenInput && hiddenInput.value) {
        const parsed = parseMaybeJson(hiddenInput.value);
        const norm = normalizeArray(parsed);
        if (norm.length) return norm;
      }

      // 2) localStorage keys
      for (const k of LS_KEYS) {
        try {
          const raw = localStorage.getItem(k);
          if (!raw) continue;
          const parsed = parseMaybeJson(raw);
          const norm = normalizeArray(parsed);
          if (norm.length) return norm;
        } catch(e){}
      }

      // 3) rpi_personal namespace (narrow to skills fields)
      try {
        const rpRaw = localStorage.getItem('rpi_personal');
        if (rpRaw) {
          const rp = parseMaybeJson(rpRaw) || rpRaw;
          if (rp && typeof rp === 'object') {
            const candidates = [];
            if (rp.skills) candidates.push(rp.skills);
            if (rp.selected_skills) candidates.push(rp.selected_skills);
            if (rp.selectedSkills) candidates.push(rp.selectedSkills);
            if (rp.skills_page1) candidates.push(rp.skills_page1);
            for (const c of candidates) {
              const norm = normalizeArray(c);
              if (norm.length) return norm;
            }
          }
        }
      } catch(e){}

      // 4) preloaded draft object
      try {
        const d = window.__mvsg_lastLoadedDraft;
        if (d && typeof d === 'object') {
          const candidates = [];
          if (d.skills) candidates.push(d.skills);
          if (d.selected_skills) candidates.push(d.selected_skills);
          if (d.selectedSkills) candidates.push(d.selectedSkills);
          if (d.skills_page1) candidates.push(d.skills_page1);
          for (const c of candidates) {
            const norm = normalizeArray(c);
            if (norm.length) return norm;
          }
        }
      } catch(e){}
    } catch(e) {
      console.debug("getSavedSkills error", e);
    }
    return [];
  }

  function resetSelections() {
    skillsCards.forEach(card => card.classList.remove("selected-card"));
  }

  function loadPreviousSelections() {
    resetSelections();
    const saved = getSavedSkills();
    if (!saved || !saved.length) return;
    const normSet = new Set(saved.map(s => String(s||'').trim().toLowerCase()));
    skillsCards.forEach(card => {
      const value = (card.dataset.value || '').trim();
      const title = (card.querySelector('h3')?.textContent || '').trim();
      if (value && normSet.has(value.toLowerCase())) card.classList.add("selected-card");
      else if (title && normSet.has(title.toLowerCase())) card.classList.add("selected-card");
    });
  }

  function updateReviewSection(selected) {
    if (!reviewList) return;
    reviewList.innerHTML = "";
    if (!selected || !selected.length) {
      reviewList.innerHTML = `<span class="text-gray-600">—</span>`;
      return;
    }
    selected.forEach(skill => {
      const span = document.createElement('span');
      span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
      span.textContent = skill;
      reviewList.appendChild(span);
    });
  }

  // wire card click toggles (ONLY 'selected-card' now)
  skillsCards.forEach(card => {
    card.addEventListener('click', () => {
      card.classList.toggle('selected-card');
    });
    card.addEventListener('keydown', (ev) => {
      if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); card.click(); }
    });
  });

  // open modal and preselect
  if (editBtn) {
    editBtn.addEventListener('click', () => {
      if (!skillsModal) return;
      skillsModal.classList.remove('hidden');
      setTimeout(() => {
        skillsModal.classList.remove('opacity-0');
        const modalContent = skillsModal.querySelector('.rounded-3xl');
        if (modalContent) modalContent.classList.remove('scale-95');
      }, 10);
      loadPreviousSelections();
    });
  }

  // close modal
  function closeModal() {
    if (!skillsModal) return;
    skillsModal.classList.add('opacity-0');
    const modalContent = skillsModal.querySelector('.rounded-3xl, div');
    if (modalContent) modalContent.classList.add('scale-95');
    setTimeout(() => {
      skillsModal.classList.add('hidden');
    }, 220);
  }
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  // save button inside modal
  if (saveBtn) {
    saveBtn.addEventListener('click', () => {
      const selected = skillsCards.filter(c => c.classList.contains('selected-card'))
                                  .map(c => c.dataset.value || c.querySelector('h3')?.textContent || '').filter(Boolean);
      if (hiddenInput) hiddenInput.value = JSON.stringify(selected);
      updateReviewSection(selected);
      closeModal();
    });
  }

  // Initial populate of review area and ensure matching cards are marked
  (function initialPopulate() {
    let saved = getSavedSkills();
    if (!saved || !saved.length) {
      try {
        if (hiddenInput && hiddenInput.value) saved = normalizeArray(parseMaybeJson(hiddenInput.value));
      } catch(e){}
    }
    const uniq = [...new Set((saved||[]).map(x => String(x||'').trim()).filter(Boolean))];
    updateReviewSection(uniq);
    try {
      const lcSet = new Set(uniq.map(u => u.toLowerCase()));
      skillsCards.forEach(card => {
        const title = (card.querySelector('h3')?.textContent || card.dataset.value || '').trim();
        if (title && lcSet.has(title.toLowerCase())) card.classList.add('selected-card');
        else card.classList.remove('selected-card');
      });
    } catch(e){ console.debug('mark cards failed', e); }
  })();

  // Ensure other scripts that might mark cards use 'selected-card' as well:
  try {
    // mark matching cards for any pre-rendered review list
    if (reviewList) {
      const spans = Array.from(reviewList.querySelectorAll('span')).map(s => (s.textContent||'').trim()).filter(Boolean);
      const vals = spans.filter(v => v !== '—');
      if (vals.length) {
        const lc = new Set(vals.map(v => v.toLowerCase()));
        skillsCards.forEach(card => {
          const title = (card.querySelector('h3')?.textContent || card.dataset.value || '').trim();
          if (title && lc.has(title.toLowerCase())) card.classList.add('selected-card');
          else card.classList.remove('selected-card');
        });
      }
    }
  } catch(e){}

});
</script>



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

  {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
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
      // Defensive fallback: only target explicit skills keys (avoid flattening whole rpi_personal objects)
      document.addEventListener('DOMContentLoaded', function(){
        try {
          const el = document.getElementById('review_skills_list');
          if (!el) return;
          const hasContent = el.children && el.children.length && Array.from(el.children).some(c=> (c.textContent||'').trim());
          if (hasContent) return; // already populated

          const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
          const normalizeArray = v => {
            if (!v && v !== 0) return [];
            if (Array.isArray(v)) return v.map(x=> (typeof x==='string'?x.trim():x)).filter(Boolean);
            if (typeof v === 'string') {
              const s = v.trim(); if (!s) return [];
              if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) return normalizeArray(tryParse(s) || []);
              if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
              return [s];
            }
            return [];
          };

          // Look for skills only in targeted keys (localStorage, hidden inputs, or rpi_personal.skills)
          const lsKeys = ['skills_page1','skills_page_1','skills1','skills','selected_skills','selectedSkills','skills_page','skills_page1_value','skills_page1_value'];
          let found = [];

          // 1) check for a hidden input on the page (skills_page1)
          try {
            const hidden = document.getElementById('skills_page1');
            if (hidden && hidden.value) {
              const parsed = tryParse(hidden.value) || hidden.value;
              const norm = normalizeArray(parsed);
              if (norm && norm.length) found = norm;
            }
          } catch(e){}

          // 2) then check localStorage keys if not found
          if (!found.length) {
            for (const k of lsKeys) {
              try {
                const raw = localStorage.getItem(k);
                if (!raw) continue;
                const parsed = tryParse(raw) || raw;
                const norm = normalizeArray(parsed);
                if (norm && norm.length) { found = norm; break; }
              } catch(e){}
            }
          }

          // If not found, check rpi_personal but only the skills namespace (do NOT flatten entire object)
          if (!found.length) {
            try {
              const rpRaw = localStorage.getItem('rpi_personal');
              const rp = tryParse(rpRaw) || rpRaw;
              if (rp && typeof rp === 'object') {
                const candidates = [];
                if (rp.skills) candidates.push(rp.skills);
                if (rp.selected_skills) candidates.push(rp.selected_skills);
                if (rp.selectedSkills) candidates.push(rp.selectedSkills);
                if (rp.skills_page1) candidates.push(rp.skills_page1);
                for (const c of candidates) {
                  const norm = normalizeArray(c);
                  if (norm && norm.length) { found = norm; break; }
                }
              }
            } catch(e){}
          }

          // Also check a preloaded draft object for skills specifically
          if (!found.length && window.__mvsg_lastLoadedDraft && typeof window.__mvsg_lastLoadedDraft === 'object') {
            try {
              const d = window.__mvsg_lastLoadedDraft;
              const candidates = [];
              if (d.skills) candidates.push(d.skills);
              if (d.selected_skills) candidates.push(d.selected_skills);
              if (d.selectedSkills) candidates.push(d.selectedSkills);
              if (d.skills_page1) candidates.push(d.skills_page1);
              for (const c of candidates) {
                const norm = normalizeArray(c);
                if (norm && norm.length) { found = norm; break; }
              }
            } catch(e){}
          }

          if (!found.length) return;

          // render only the found skills
          el.innerHTML = '';
          for (const s of found) {
            const span = document.createElement('span');
            span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
            span.textContent = s;
            el.appendChild(span);
          }

          // mark matching cards selected if present (case-sensitive match to card <h3>)
          try {
            const cards = document.querySelectorAll('.skills-card, .selectable-card');
            cards.forEach(card=>{
              const title = card.querySelector('h3')?.textContent?.trim();
              if (!title) return card.classList.remove('selected');
              // match case-insensitive and trimmed
              const lcTitle = title.toLowerCase();
              const matched = found.some(f => String(f || '').trim().toLowerCase() === lcTitle);
              if (matched) card.classList.add('selected'); else card.classList.remove('selected');
            });
          } catch(e){}
        } catch(e){ console.debug('review4 fallback skills render failed', e); }
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
            // Firebase client removed: skip client auth checks
            if (false) {
              const user = null;
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
      // document.addEventListener('DOMContentLoaded', function(){
      //   try {
      //     const btn = document.getElementById('rv4_change_skills_btn');
      //     if (btn) btn.addEventListener('click', function(e){ e.preventDefault(); saveDraftAndGotoSkills('{{ route('registerskills1') }}'); });
      //   } catch(e) { console.debug('[review-4] wiring change button failed', e); }
      // });
    </script>
  <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
  <script>
    (function(){
      const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
      const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
      let voices = [];
      let preferredEnglish = null;
      let preferredTagalog = null;

      function populateVoices(){ voices = speechSynthesis.getVoices() || []; preferredEnglish = voices.find(v=>v.name===preferredEnglishVoiceName) || voices.find(v=>/ava.*multilingual|microsoft ava/i.test(v.name)) || null; preferredTagalog = voices.find(v=>v.name===preferredTagalogVoiceName) || voices.find(v=>/blessica|fil-?ph|filipino|tagalog/i.test(v.name)) || null; }

      function pickBest(list){ if(!list||!list.length) return null; const preferred = list.find(v=> /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name)); return preferred || list[0]; }

      function chooseVoiceForLang(langCode){
        if(!voices.length) return null;
        langCode = (langCode||'').toLowerCase();
        if(langCode.startsWith('tl') || langCode.startsWith('fil')) {
          if(preferredTagalog) return preferredTagalog;
          const candidates = voices.filter(v=> (v.lang||'').toLowerCase().startsWith('tl') || (v.lang||'').toLowerCase().startsWith('fil'));
          return pickBest(candidates.length ? candidates : voices);
        }
        if(langCode.startsWith('en')) {
          if(preferredEnglish) return preferredEnglish;
          const candidates = voices.filter(v=> (v.lang||'').toLowerCase().startsWith('en'));
          return pickBest(candidates.length ? candidates : voices);
        }
        return preferredEnglish || voices[0] || null;
      }

      function stopSpeaking(){ try{ speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>b.classList.remove('speaking')); }catch(e){} }

      function startSequence(btn,en,tl){
        stopSpeaking();
        if(!en && !tl) return;
        btn.classList.add('speaking'); btn.setAttribute('aria-pressed','true');
        const uEn = en ? new SpeechSynthesisUtterance(en) : null;
        const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
        if(uEn){ uEn.lang='en-US'; uEn.voice = chooseVoiceForLang('en') || null; }
        if(uTl){ uTl.lang='tl-PH'; uTl.voice = chooseVoiceForLang('tl') || chooseVoiceForLang('en') || null; }
        const finalize = ()=>{ btn.classList.remove('speaking'); btn.removeAttribute('aria-pressed'); };
        if(uEn && uTl){ uEn.onend = ()=>{ setTimeout(()=>speechSynthesis.speak(uTl),160); }; uTl.onend = finalize; uEn.onerror = uTl.onerror = finalize; speechSynthesis.speak(uEn); }
        else if(uEn){ uEn.onend = finalize; uEn.onerror = finalize; speechSynthesis.speak(uEn); }
        else if(uTl){ uTl.onend = finalize; uTl.onerror = finalize; speechSynthesis.speak(uTl); }
      }

      const init = () => {
        populateVoices();
        window.speechSynthesis.onvoiceschanged = populateVoices;
        document.querySelectorAll('.tts-btn').forEach(b => {
          b.addEventListener('click', ()=>{ if (b.classList.contains('speaking')) { stopSpeaking(); return; } startSequence(b, b.getAttribute('data-tts-en')||'', b.getAttribute('data-tts-tl')||''); });
          b.addEventListener('keydown', ev=>{ if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); b.click(); } });
        });
        window.addEventListener('beforeunload', stopSpeaking);
      };

      if (document.readyState === 'complete' || document.readyState === 'interactive') init(); else document.addEventListener('DOMContentLoaded', init);
    })();
  </script>

 <script>
  document.addEventListener("DOMContentLoaded", () => {
    const savedSkills = localStorage.getItem("skills1_selected");
    const container = document.getElementById("review_skills_list");

    if (!container) {
      console.warn("❌ review_skills_list not found.");
      return;
    }

    if (!savedSkills) {
      container.innerHTML = `<span class="text-gray-500 italic">No skills selected.</span>`;
      console.warn("⚠️ No skills1_selected found in localStorage.");
      return;
    }

    try {
      const skills = JSON.parse(savedSkills);
      if (Array.isArray(skills) && skills.length > 0) {
        container.innerHTML = skills.map(skill => `
          <span class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm">
            ${skill}
          </span>
        `).join("");
      } else {
        container.innerHTML = `<span class="text-gray-500 italic">No skills selected.</span>`;
      }
    } catch (err) {
      console.error("❌ Failed to parse skills1_selected", err);
      container.innerHTML = `<span class="text-red-500 italic">Error loading skills.</span>`;
    }
  });
</script>


  </body>
</html>
