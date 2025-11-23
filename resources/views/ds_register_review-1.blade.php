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

    /* selectable card visual (shared style used across review pages) */
        .selectable-card {
            border: 2px solid transparent;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                border-color .18s ease;
        }

        .selectable-card.selected {
            border-color: #2563eb;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.14);
            transform: translateY(-6px);
        }

        /* show small check badge when a card is selected */
        .selectable-card.selected::after,
        .guardian-card.selected::after,
        .education-card.selected::after,
        .skills-card.selected::after,
        .workexp-card.selected::after {
            content: "";
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 44px;
            height: 44px;
            background-image: url('/image/checkmark.png');
            background-size: contain;
            background-repeat: no-repeat;
            pointer-events: none;
        }
        /* TTS button visual state */
        .tts-btn { cursor: pointer; }
        .tts-btn.speaking { transform: scale(1.04); box-shadow: 0 8px 24px rgba(30,64,175,0.12); }
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
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerjobpreference1') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-6">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Review Your Information
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-32 md:w-36 mb-6">

            <div class="bg-white rounded-3xl p-5 sm:p-7 border-4 border-blue-300 shadow-lg text-left">
                <h2 class="text-lg sm:text-xl md:text-2xl text-blue-600 font-bold flex items-center gap-x-3">
                    Please Review Your Details
                    <button type="button" class="tts-btn text-xl hover:scale-110 transition-transform"
                        data-tts-en="Please review your details. Make sure all your information below is correct before going to the next page."
                        data-tts-tl="Siguraduhing tama ang lahat ng impormasyong nakasaad bago lumipat ng pahina."
                        aria-label="Read this section aloud in English then Filipino"></button>
                </h2>
                <p class="text-gray-800 text-sm sm:text-base mt-2">
                    Make sure all your information below is correct before going to the next page.
                </p>
                <p class="text-gray-600 italic text-sm sm:text-base mt-3">
                    (Siguraduhing tama ang lahat ng impormasyong nakasaad bago lumipat ng pahina.)
                </p>
            </div>
        </div>
                      

        <!-- Review Sections -->
        <div id="reviewContainer" class="mt-10 space-y-8">

            <!-- Form -->
        <form id="registrationForm" class="mt-10 space-y-10 text-left"></form>

<!-- Personal Information -->
         <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4 border-b border-blue-300 pb-2">
                 <h3 class="text-base sm:text-lg md:text-xl font-semibold text-blue-600">
                    Personal Information
                </h3>
                <button id="editPersonalInfoBtn" type="button"
                class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm sm:text-base font-semibold shadow-md hover:bg-blue-700 transition">
                 ✏️ Edit Information
                </button>
            </div>
            
            <div id="registerreview1" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- First Name -->
        <div>
            <label for="first_name" class="font-semibold text-gray-800 text-sm sm:text-base">First Name</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Unang Pangalan</p>
            <input id="first_name" type="text" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm" />
        </div>

        <!-- Last Name -->
        <div>
            <label for="last_name" class="font-semibold text-gray-800 text-sm sm:text-base">Last Name</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Apelyido</p>
            <input id="last_name" type="text" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

        <!-- Age -->
        <div>
            <label for="age" class="font-semibold text-gray-800 text-sm sm:text-base">Age</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Edad</p>
            <input id="age" type="number" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

    </div>

    <!-- Email + Phone -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Email -->
        <div>
            <label for="email" class="font-semibold text-gray-800 text-sm sm:text-base">Email</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Email</p>
            <input id="email" type="email" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

        <!-- Contact Number -->
        <div>
            <label for="phone" class="font-semibold text-gray-800 text-sm sm:text-base">Contact Number</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Numero ng Telepono</p>
            <input id="phone" type="tel" disabled
                placeholder="+63 9XX XXX XXXX"
                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

    </div>

    <!-- Address -->
    <div>
        <label for="address" class="font-semibold text-gray-800 text-sm sm:text-base">Address</label>
        <p class="text-gray-600 italic text-xs sm:text-sm">Tirahan</p>
        <input id="address" type="text" disabled
            class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
    </div>

    <!-- DS Type -->
    <div>
        <label for="r_dsType1" class="font-semibold text-gray-800 text-sm sm:text-base">Type of Down Syndrome</label>
        <p class="text-gray-600 italic text-xs sm:text-sm">Pumili ng uri</p>
        <select id="r_dsType1" disabled
            class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none">
            <option value="">-- Select Type --</option>
            <option value="Trisomy 21 (Nondisjunction)">Trisomy 21 (Nondisjunction)</option>
            <option value="Mosaic Down Syndrome">Mosaic Down Syndrome</option>
            <option value="Translocation Down Syndrome">Translocation Down Syndrome</option>
        </select>
    </div>

    <!-- Guardian Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Guardian First Name -->
        <div>
            <label for="g_first_name" class="font-semibold text-gray-800 text-sm sm:text-base">Guardian First Name</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Unang Pangalan</p>
            <input id="g_first_name" type="text" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

        <!-- Guardian Last Name -->
        <div>
            <label for="g_last_name" class="font-semibold text-gray-800 text-sm sm:text-base">Guardian Last Name</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Apelyido</p>
            <input id="g_last_name" type="text" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

        <!-- Guardian Email -->
        <div>
            <label for="g_email" class="font-semibold text-gray-800 text-sm sm:text-base">Guardian Email</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Email</p>
            <input id="g_email" type="email" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

        <!-- Guardian Phone -->
        <div>
            <label for="g_phone" class="font-semibold text-gray-800 text-sm sm:text-base">Guardian Contact Number</label>
            <p class="text-gray-600 italic text-xs sm:text-sm">Numero ng Telepono</p>
            <input id="g_phone" type="tel" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

    </div>

    <!-- Relationship -->
    <div>
        <label for="guardian_relationship" class="font-semibold text-gray-800 text-sm sm:text-base">Relationship to User</label>
        <p class="text-gray-600 italic text-xs sm:text-sm">(Ka-ano-ano mo siya?)</p>
        <select id="guardian_relationship" disabled
            class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none">
            <option value="">-- Select Relationship --</option>
            <option value="Parent">Parent</option>
            <option value="Guardian">Guardian</option>
            <option value="Sibling">Sibling</option>
            <option value="Relative">Relative</option>
            <option value="Other">Other</option>
        </select>
    </div>

</div>
</div>


<!-- Account Details -->
<div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">

    <!-- Header with single Edit/Save button -->
    <div class="flex justify-between items-center border-b border-blue-300 pb-2 mb-4">
        <h3 class="text-base sm:text-lg md:text-xl font-semibold text-blue-600">
            Account Details
        </h3>

        <button id="editAccountBtn"
            type="button"
            class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm sm:text-base font-semibold shadow-md hover:bg-blue-700 transition">
            ✏️ Edit Information
        </button>
    </div>

    <!-- Fields -->
    <div id="accountSection" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Username -->
        <div>
            <label for="username" class="font-semibold flex items-center gap-1">Username</label>
            <input id="username" type="text" disabled
                class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-800 shadow-sm select-none" />
        </div>

        <!-- Password -->
        <div class="relative">
            <label for="password" class="font-semibold flex items-center gap-1">Password</label>
            <input disabled id="password" name="password" type="password"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />

            <!-- Eye icon -->
            <button type="button" id="togglePassword"
                class="absolute top-[42px] right-3 text-gray-600 text-lg focus:outline-none">
                👁️
            </button>

            <p id="passwordMessage" class="mt-1 text-sm text-red-500 italic hidden">
                Password must have at least 1 uppercase, 1 lowercase, 1 number, and be 8+ characters long.
            </p>
        </div>
    </div>
</div>

<script>
// Function to toggle edit/save for any section
function setupEditSection(buttonId, sectionId) {
    const button = document.getElementById(buttonId);
    const section = document.getElementById(sectionId);
    const fields = section.querySelectorAll("input, select, textarea");

    button.addEventListener("click", function () {
        const isSaving = this.dataset.mode === "editing";

        if (isSaving) {
            // SAVE MODE → disable all fields
            fields.forEach(f => f.disabled = true);

            this.innerText = "✏️ Edit Information";
            this.classList.remove("bg-green-600", "hover:bg-green-700");
            this.classList.add("bg-blue-600", "hover:bg-blue-700");
            this.dataset.mode = "view";

        } else {
            // EDIT MODE → enable all fields
            fields.forEach(f => f.disabled = false);

            this.innerText = "💾 Save Changes";
            this.classList.remove("bg-blue-600", "hover:bg-blue-700");
            this.classList.add("bg-green-600", "hover:bg-green-700");
            this.dataset.mode = "editing";
        }
    });
}

// Apply to both Personal Information and Account Details
setupEditSection("editPersonalInfoBtn", "registerreview1");
setupEditSection("editAccountBtn", "accountSection");
</script>


<!-- Uploaded Files Review Section -->
<div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 mt-6">
  <div class="flex items-center justify-between mb-4 border-b border-blue-300 pb-2">
    <h3 class="text-base sm:text-lg md:text-xl font-semibold text-blue-600">Uploaded Files Preview</h3>
    <button id="editFilesBtn" type="button"
      class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm sm:text-base font-semibold shadow-md hover:bg-blue-700 transition">
      ✏️ Edit Files
    </button>
  </div>

  <div class="space-y-6">
    <!-- Proof of Membership -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="flex-1">
        <p class="font-medium text-gray-800 text-sm sm:text-base">Upload Proof of Membership</p>
        <p class="text-gray-600 italic text-xs sm:text-sm mt-1">
          (Mag-upload ng larawan o PDF bilang patunay ng pagiging miyembro.)<br>
          Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b>
        </p>
        <div id="proofDisplay"></div>
      </div>
      <div class="flex flex-col sm:flex-row sm:items-center gap-2">
        <label for="proofFile" class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
          📁 Choose File / Pumili ng File
        </label>
        <input id="proofFile" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden" disabled />
      </div>
    </div>

    <!-- Medical Certificate -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="flex-1">
        <p class="font-medium text-gray-800 text-sm sm:text-base">Upload Medical Certificate</p>
        <p class="text-gray-600 italic text-xs sm:text-sm mt-1">
          (Mag-upload ng larawan o PDF ng iyong medical certificate.)<br>
          Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b>
        </p>
        <div id="medDisplay"></div>
      </div>
      <div class="flex flex-col sm:flex-row sm:items-center gap-2">
        <label for="medFile" class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
          📁 Choose File / Pumili ng File
        </label>
        <input id="medFile" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden" disabled />
      </div>
    </div>
  </div>
</div>

<!-- Modal for viewing files -->
<div id="fileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg max-w-3xl w-full p-4 sm:p-6 relative">
    <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-lg font-bold">&times;</button>
    <div id="modalContent" class="flex justify-center items-center"></div>
  </div>
</div>

<!-- Uploaded Files Edit Script -->
<script>
/* Replaced Uploaded Files Edit Script with adminapprove-style stacked preview and View/Remove handling.
   Uses (in order): admin_uploaded_* keys, uploadedProofs1 array, legacy single-file keys.
*/
(function(){
  const proofDisplay = document.getElementById("proofDisplay");
  const medDisplay = document.getElementById("medDisplay");
  const fileModal = document.getElementById("fileModal");
  const modalContent = document.getElementById("modalContent");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const editFilesBtn = document.getElementById("editFilesBtn");

  const LS_ARRAY_KEY = 'uploadedProofs1';
  const ADMIN_KEYS = {
    proof: { name: 'admin_uploaded_proof_name', data: 'admin_uploaded_proof_data', type: 'admin_uploaded_proof_type' },
    medical: { name: 'admin_uploaded_med_name', data: 'admin_uploaded_med_data', type: 'admin_uploaded_med_type' }
  };
  const LEGACY_KEYS = {
    proof: { name: 'uploadedProofName1', data: 'uploadedProofData1', type: 'uploadedProofType1' },
    medical: { name: 'uploadedProofName0', data: 'uploadedProofData0', type: 'uploadedProofType0' }
  };

  function readJson(key){ try { return JSON.parse(localStorage.getItem(key)); } catch(e){ return null; } }
  function readFirst(keys){
    for(const k of keys){ try{ const v = localStorage.getItem(k); if(v) return v; }catch(e){} }
    return null;
  }

  function loadArrayFiles(){
    const arr = readJson(LS_ARRAY_KEY);
    return Array.isArray(arr) ? arr : [];
  }

  function renderListTo(container, list){
    container.innerHTML = '';
    if(!list || !list.length){ container.innerHTML = '<p class="text-gray-600 italic">No file uploaded.</p>'; return; }
    list.forEach((f, idx) => {
      const ext = (f.type || (f.name||'').split('.').pop()||'').toLowerCase();
      const icon = ext === 'pdf' ? '📄' : (['jpg','jpeg','png'].includes(ext) ? '🖼️' : '📁');
      const card = document.createElement('div');
      card.className = 'flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mb-3';
      card.dataset.idx = idx;
      card.innerHTML = `
        <div class="flex items-center gap-3 min-w-0">
          <div class="text-2xl">${icon}</div>
          <div class="min-w-0">
            <div class="text-sm text-gray-700 truncate max-w-[420px]">${escapeHtml(f.name)}</div>
            <div class="text-xs text-gray-500 mt-1">${(f.type||'').toUpperCase()}</div>
          </div>
        </div>
        <div class="ml-auto flex gap-2">
          <button data-action="view" data-idx="${idx}" class="bg-[#2E2EFF] text-white text-xs px-3 py-1 rounded-md">View</button>
          <button data-action="remove" data-idx="${idx}" class="bg-[#D20103] text-white text-xs px-3 py-1 rounded-md">Remove</button>
        </div>
      `;
      container.appendChild(card);
    });

    // bind
    container.querySelectorAll('[data-action="view"]').forEach(b => b.addEventListener('click', (ev)=>{
      const i = Number(ev.currentTarget.dataset.idx);
      const list = loadArrayFiles();
      const item = list[i];
      if(item && item.data) openPreview(item.name, item.data, item.type);
      else alert('Preview not available for this file.');
    }));

    container.querySelectorAll('[data-action="remove"]').forEach(b => b.addEventListener('click', (ev)=>{
      const i = Number(ev.currentTarget.dataset.idx);
      const list = loadArrayFiles();
      if(!Array.isArray(list) || !list.length) return;
      list.splice(i,1);
      try { localStorage.setItem(LS_ARRAY_KEY, JSON.stringify(list)); } catch(e){ console.warn(e); }
      // also update legacy/admin single-file keys to keep pages compatible (clear them)
      ['uploadedProofData','uploadedProofType','uploadedProofName','uploadedProofData1','uploadedProofType1','uploadedProofName1'].forEach(k=>{ try{ localStorage.removeItem(k); }catch(e){} });
      renderAll();
    }));
  }

  function renderSingleTo(container, name, data, type, storageKeysForRemoval){
    container.innerHTML = '';
    if(!name || !data){ container.innerHTML = '<p class="text-gray-600 italic">No file uploaded.</p>'; return; }
    const ext = (type || (name||'').split('.').pop()||'').toLowerCase();
    const icon = ext === 'pdf' ? '📄' : (['jpg','jpeg','png'].includes(ext) ? '🖼️' : '📁');
    const card = document.createElement('div');
    card.className = 'flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mb-3';
    card.innerHTML = `
      <div class="flex items-center gap-3 min-w-0">
        <div class="text-2xl">${icon}</div>
        <div class="min-w-0">
          <div class="text-sm text-gray-700 truncate max-w-[420px]">${escapeHtml(name)}</div>
          <div class="text-xs text-gray-500 mt-1">${(type||'').toUpperCase()}</div>
        </div>
      </div>
      <div class="ml-auto flex gap-2">
        <button id="r_view" class="bg-[#2E2EFF] text-white text-xs px-3 py-1 rounded-md">View</button>
        <button id="r_remove" class="bg-[#D20103] text-white text-xs px-3 py-1 rounded-md">Remove</button>
      </div>
    `;
    container.appendChild(card);

    container.querySelector('#r_view').addEventListener('click', ()=>{
      openPreview(name, data, type);
    });
    container.querySelector('#r_remove').addEventListener('click', ()=>{
      (storageKeysForRemoval || []).forEach(k=>{ try{ localStorage.removeItem(k); } catch(e){} });
      // if array exists, remove first matching by name
      const arr = loadArrayFiles();
      const idx = arr.findIndex(x => String(x.name||'') === String(name||''));
      if(idx >= 0){ arr.splice(idx,1); try{ localStorage.setItem(LS_ARRAY_KEY, JSON.stringify(arr)); }catch(e){} }
      renderAll();
    });
  }

  function escapeHtml(s){ if(s===null||s===undefined) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

  function openPreview(name, dataUrl, type){
    if(!fileModal || !modalContent) return;
    modalContent.innerHTML = `<h2 class="font-semibold mb-2">${escapeHtml(name)}</h2>`;
    const ext = (type || (name||'').split('.').pop() || '').toLowerCase();
    if (['jpg','jpeg','png'].includes(ext)) modalContent.innerHTML += `<img src="${dataUrl}" class="max-h-[80vh] mx-auto rounded-lg">`;
    else if (ext === 'pdf') modalContent.innerHTML += `<iframe src="${dataUrl}" class="w-full h-[80vh] rounded-lg border-0"></iframe>`;
    else modalContent.innerHTML += `<p class="text-gray-700 text-center">This file type cannot be previewed.</p>`;
    fileModal.classList.remove('hidden');
  }

  closeModalBtn?.addEventListener('click', (e)=>{ e.preventDefault(); fileModal.classList.add('hidden'); modalContent.innerHTML = ''; });
  fileModal?.addEventListener('click', (e)=>{ if(e.target === fileModal){ fileModal.classList.add('hidden'); modalContent.innerHTML=''; } });

   function renderAll(){
    // PRIORITY: show admin files first (adminapprove), then uploadedProofs1 array, then legacy single-file keys.
    const adminProofName = localStorage.getItem(ADMIN_KEYS.proof.name);
    const adminProofData = localStorage.getItem(ADMIN_KEYS.proof.data);
    const adminProofType = localStorage.getItem(ADMIN_KEYS.proof.type);

    const adminMedName = localStorage.getItem(ADMIN_KEYS.medical.name);
    const adminMedData = localStorage.getItem(ADMIN_KEYS.medical.data);
    const adminMedType = localStorage.getItem(ADMIN_KEYS.medical.type);

    // 1) If admin keys exist, render them (single-file cards)
    if (adminProofName && adminProofData) {
      renderSingleTo(proofDisplay, adminProofName, adminProofData, adminProofType, [ADMIN_KEYS.proof.name, ADMIN_KEYS.proof.data, ADMIN_KEYS.proof.type]);
    } else {
      // 2) fallback to uploadedProofs1 array
      const arr = loadArrayFiles();
      if (Array.isArray(arr) && arr.length) {
        renderListTo(proofDisplay, arr);
      } else {
        // 3) fallback to legacy single-file keys for proof
        const legacyProofName = localStorage.getItem(LEGACY_KEYS.proof.name);
        const legacyProofData = localStorage.getItem(LEGACY_KEYS.proof.data);
        const legacyProofType = localStorage.getItem(LEGACY_KEYS.proof.type);
        if (legacyProofName && legacyProofData) {
          renderSingleTo(proofDisplay, legacyProofName, legacyProofData, legacyProofType, [LEGACY_KEYS.proof.name, LEGACY_KEYS.proof.data, LEGACY_KEYS.proof.type]);
        } else {
          proofDisplay.innerHTML = '<p class="text-gray-600 italic">No file uploaded.</p>';
        }
      }
    }

    // Repeat for medical / admin uploaded med
    if (adminMedName && adminMedData) {
      renderSingleTo(medDisplay, adminMedName, adminMedData, adminMedType, [ADMIN_KEYS.medical.name, ADMIN_KEYS.medical.data, ADMIN_KEYS.medical.type]);
    } else {
      // If array had items and they were used for proof, we already showed them; show empty for med
      const arr2 = loadArrayFiles();
      if (Array.isArray(arr2) && arr2.length) {
        // if you want to separate proof vs medical files inside the array you can filter by naming convention;
        // for now treat array as general proofs and show empty for medical to avoid duplication
        medDisplay.innerHTML = '<p class="text-gray-600 italic">No file uploaded.</p>';
      } else {
        const legacyMedName = localStorage.getItem(LEGACY_KEYS.medical.name);
        const legacyMedData = localStorage.getItem(LEGACY_KEYS.medical.data);
        const legacyMedType = localStorage.getItem(LEGACY_KEYS.medical.type);
        if (legacyMedName && legacyMedData) {
          renderSingleTo(medDisplay, legacyMedName, legacyMedData, legacyMedType, [LEGACY_KEYS.medical.name, LEGACY_KEYS.medical.data, LEGACY_KEYS.medical.type]);
        } else {
          medDisplay.innerHTML = '<p class="text-gray-600 italic">No file uploaded.</p>';
        }
      }
    }
  }


  // wire Edit Files toggle to enable/disable file inputs if present (keeps UX)
  if(editFilesBtn){
    editFilesBtn.addEventListener('click', ()=>{
      const isEditing = editFilesBtn.dataset.mode === 'editing';
      const proofFile = document.getElementById('proofFile');
      const medFile = document.getElementById('medFile');
      if(isEditing){
        if(proofFile) proofFile.disabled = true;
        if(medFile) medFile.disabled = true;
        editFilesBtn.innerText = '✏️ Edit Files';
        editFilesBtn.dataset.mode = 'view';
      } else {
        if(proofFile) proofFile.disabled = false;
        if(medFile) medFile.disabled = false;
        editFilesBtn.innerText = '💾 Save Files';
        editFilesBtn.dataset.mode = 'editing';
      }
    });
  }

  // initial render
  renderAll();

  // listen storage changes
  window.addEventListener('storage', (e)=>{
    if(!e.key) { renderAll(); return; }
    const watch = [LS_ARRAY_KEY,
      ADMIN_KEYS.proof.name, ADMIN_KEYS.proof.data, ADMIN_KEYS.proof.type,
      ADMIN_KEYS.medical.name, ADMIN_KEYS.medical.data, ADMIN_KEYS.medical.type,
      LEGACY_KEYS.proof.name, LEGACY_KEYS.proof.data, LEGACY_KEYS.proof.type,
      LEGACY_KEYS.medical.name, LEGACY_KEYS.medical.data, LEGACY_KEYS.medical.type
    ];
    if(watch.includes(e.key)) setTimeout(renderAll, 20);
  });
})();
</script>



         <!-- Action Buttons -->
        <div class="text-center mt-10">


            <!-- Continue Button -->
            <button id="review1Continue" type="button"
                class="bg-[#2E2EFF] text-white font-semibold text-lg px-20 py-3 rounded-xl hover:bg-blue-600 transition shadow-md">
                Continue →
            </button>
        

        <!-- Helper Text -->
        <p class="text-gray-700 text-sm mt-3">
            Click <span class="text-[#1E40AF] font-medium">“Continue”</span> to move to the next page
        </p>
        <p class="text-gray-600 italic text-[13px]">
            (Pindutin ang “Continue” upang magpatuloy)
        </p>
       </div>
</div>


    {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
    <script src="{{ asset('js/register.js') }}"></script>
    <script>
        // Save the currently-displayed review draft into localStorage so the adminapprove page
        // (and register.js) can prefill fields. If Firebase user is available, append ?uid= to the URL.
  function saveDraftAndEdit() {
                document.getElementById('registrationForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Stop default reload

                // Your logic here
                console.log('Form submission blocked. Custom handling.');
            });

                try {
  // Prefer the merged draft if the preview loader exposed it
                    let draft = window.__mvsg_lastLoadedDraft || null;

                    if (!draft || typeof draft !== 'object') {
                        // Fallback: build a minimal draft from the visible review DOM
                        draft = draft || {};
                        draft.personal = draft.personal || {};
                        draft.guardian = draft.guardian || {};

                        const text = id => {
                            const el = document.getElementById(id);
                            return el && el.textContent ? el.textContent.trim() : '';
                        };

                        // Personal fields
                        draft.personal.first = draft.personal.first || text('r_first_name');
                        draft.personal.last = draft.personal.last || text('r_last_name');
                        draft.personal.email = draft.personal.email || text('r_email');
                        draft.personal.phone = draft.personal.phone || text('r_phone');
                        draft.personal.age = draft.personal.age || text('r_age');
                        draft.personal.address = draft.personal.address || text('r_address');
                        draft.personal.username = draft.personal.username || text('r_username');

                        const pw = text('r_password');
                        if (pw) draft.personal.password = draft.personal.password || pw;

                        // Guardian fields
                        draft.guardian.guardian_first_name = draft.guardian.guardian_first_name || text('r_guardian_first');
                        draft.guardian.guardian_last_name = draft.guardian.guardian_last_name || text('r_guardian_last');
                        draft.guardian.guardian_email = draft.guardian.guardian_email || text('r_guardian_email');
                        draft.guardian.guardian_phone = draft.guardian.guardian_phone || text('r_guardian_phone');
                        draft.guardian.relationship = draft.guardian.relationship || text('r_guardian_relationship');

                        draft.dsType = draft.dsType || text('r_dsType');

                        const proof = text('r_proof');
                        if (proof && proof !== 'No file uploaded') {
                            draft.proofFilename = draft.proofFilename || proof;
                        }
                    }

                    // Save to localStorage
                    try {
localStorage.setItem('rpi_personal1', JSON.stringify(draft));
                        try {
                            const verified = JSON.parse(localStorage.getItem('rpi_personal1'));
                            console.info('[review] saveDraftAndEdit wrote rpi_personal1 and verified', verified);
                        } catch (verErr) {
                            console.info('[review] saveDraftAndEdit wrote rpi_personal1 (could not parse on readback)', localStorage.getItem('rpi_personal1'));
                        }
                    } catch (e) {
                        console.warn('saveDraftAndEdit: failed to set localStorage', e);
                    }
} catch (e) {
                    console.warn('saveDraftAndEdit build draft failed', e);
                }
 // Firebase UID logic
                try {
                    let uid = '';
                    if (window.firebase && firebase.auth) {
                        const user = firebase.auth().currentUser;
                        if (user && user.uid) uid = user.uid;
                    }

                    let url = '{{ route('registeradminapprove') }}';
                    if (uid) url += '?uid=' + encodeURIComponent(uid);

                    console.log('Test');

                   function enableFields() {
                    const fieldIds = [
                        "first_name", "last_name", "age", "email", "phone", "address",
                        "r_dsType1", "g_last_name", "g_first_name", "g_phone", "g_email",
                        "guardian_relationship", "username", "password"
                    ];

                    fieldIds.forEach(id => {
                        const field = document.getElementById(id);
                        if (field) {
                            field.disabled = false;
                            field.classList.remove("bg-gray-50", "border-gray-300", "text-gray-800", "select-none");
                            field.classList.add("bg-white", "text-gray-900");
                            console.log(`${id} enabled and gray removed`);
                        }
                    });
                }

                // Run immediately if DOM is ready, else wait
                if (document.readyState === "loading") {
                    document.addEventListener("DOMContentLoaded", enableFields);
                } else {
                    enableFields();
                }
                } catch (e) {
                    // fallback navigation
                    // window.location.href = '{{ route('registeradminapprove') }}';
                }
}

     </script>
        <!-- Simple deterministic fallback: directly apply common draft keys to visible fields -->
        <script>
        (function(){
            function tryParse(s){ try { return s && typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } }
            function setIf(id, val){ 
                try{ 
                    const el=document.getElementById(id); 
                    if(!el) return false; 

                    // Do not overwrite with empty/null/whitespace values — only apply meaningful data
                    if (val === undefined || val === null) return false;
                    let out;
                    if (typeof val === 'object') {
                        out = Array.isArray(val) ? val.join(', ') : JSON.stringify(val);
                    } else {
                        out = String(val);
                    }
                    if (out.trim() === '') return false;

                    if(el.tagName === 'SELECT' || el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = out; 
                    else el.textContent = out; 
                    return true;
                }catch(e){
                    return false;
                } 
            }
            function setSelectByValueOrText(id, value){
                try{
                    if(!value) return false;
                    const el = document.getElementById(id);
                    if(!el || el.tagName !== 'SELECT') return false;

                    const normalizeStr = s => String(s||'').toLowerCase().replace(/\(.*?\)/g,'').replace(/[\W_]+/g,' ').trim();
                    const wantRaw = String(value||'');
                    const want = normalizeStr(wantRaw);

                    // 1) exact value/text match
                    for(const opt of Array.from(el.options||[])){
                        const v = normalizeStr(opt.value||'');
                        const t = normalizeStr(opt.text||'');
                        if(v === want || t === want){ el.value = opt.value; try{ el.dispatchEvent(new Event('change',{bubbles:true})); }catch(e){} return true; }
                    }

                    // 2) contains match (option text contains want) or want contains option text
                    for(const opt of Array.from(el.options||[])){
                        const v = normalizeStr(opt.value||'');
                        const t = normalizeStr(opt.text||'');
                        if(v && want.includes(v) || t && want.includes(t) || v && t && (v.includes(want) || t.includes(want))){ el.value = opt.value; try{ el.dispatchEvent(new Event('change',{bubbles:true})); }catch(e){} return true; }
                    }

                    // 3) startsWith match
                    for(const opt of Array.from(el.options||[])){
                        const v = normalizeStr(opt.value||'');
                        const t = normalizeStr(opt.text||'');
                        if(v && v.startsWith(want) || t && t.startsWith(want)){ el.value = opt.value; try{ el.dispatchEvent(new Event('change',{bubbles:true})); }catch(e){} return true; }
                    }

                    // not found -> insert a visible selected option at the top (so the user sees the original value)
                    const newOpt = document.createElement('option'); newOpt.value = wantRaw; newOpt.text = wantRaw; newOpt.selected = true; // insert at top so visible
                    try { el.insertBefore(newOpt, el.firstChild); el.selectedIndex = 0; el.dispatchEvent(new Event('change',{bubbles:true})); } catch(e) { try { el.appendChild(newOpt); el.value = wantRaw; el.dispatchEvent(new Event('change',{bubbles:true})); } catch(err){} }
                    return true;
                }catch(e){
                    console.warn('[review] setSelectByValueOrText error', e);
                    return false;
                }
            }
            function mapRelationship(raw){ if(!raw) return ''; const s = raw.toString().toLowerCase(); const mapping = { parent: 'Parent', mother: 'Parent', father: 'Parent', mom: 'Parent', dad: 'Parent', guardian: 'Guardian', sibling: 'Sibling', brother: 'Sibling', sister: 'Sibling', relative: 'Relative', aunty: 'Relative', aunt: 'Relative', other: 'Other' }; for(const k of Object.keys(mapping)){ if(s.includes(k)) return mapping[k]; } return raw; }

            function loadDraft(){
                // priority: last loaded draft, rpi_personal1, registrationDraft, registration_draft
                let draft = window.__mvsg_lastLoadedDraft || null;
                if(!draft) draft = tryParse(localStorage.getItem('rpi_personal1')) || tryParse(sessionStorage.getItem('rpi_personal1')) || tryParse(localStorage.getItem('registrationDraft')) || tryParse(localStorage.getItem('registration_draft')) || tryParse(localStorage.getItem('regDraft')) || null;
                return draft || null;
            }

            function applyOnce(){
                try{
                    const d = loadDraft(); if(!d) return false;
                    const p = d.personal || d.personalInfo || d || {};
                    const g = d.guardian || d.guardianInfo || d || {};
                    // guardian fields
                    setIf('g_first_name', g.guardian_first_name || g.first_name || g.first || g.guardian_first || p.guardian_first_name || '');
                    setIf('g_last_name', g.guardian_last_name || g.last_name || g.last || g.guardian_last || p.guardian_last_name || '');
                    setIf('g_email', g.guardian_email || g.email || p.guardian_email || p.email || '');
                    setIf('g_phone', g.guardian_phone || g.phone || p.guardian_phone || p.phone || '');
                    // relationship
                    const rawRel = g.guardian_choice || g.relationship || d.guardian_relationship || p.guardian_relationship || '';
                    const mapped = mapRelationship(rawRel);
                    if(!setSelectByValueOrText('guardian_relationship', mapped)) setIf('guardian_relationship', mapped || '');
                    // ds type
                    // Check many possible locations and key names for DS type (top-level, personal, and legacy keys)
                    const ds = d.dsType || d.ds_type || d.r_dsType1 || d.r_dsType || p.dsType || p.ds_type || p.r_dsType1 || p.r_dsType || p.type || '';
                    if (ds) setSelectByValueOrText('r_dsType1', ds);
                    return true;
                }catch(e){ console.warn('[review-fallback] applyOnce failed', e); return false; }
            }

            // run on DOM ready
            function boot(){
                let applied = applyOnce();
                if(!applied){ // retry a couple times in case register.js writes later
                    let attempts = 0; const max = 6; const iv = setInterval(()=>{ attempts++; if(applyOnce() || attempts>=max) clearInterval(iv); }, 250);
                }
            }

            if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();

            // re-apply when storage or custom populate event occurs
            window.addEventListener('storage', function(e){ if(e && (e.key==='rpi_personal1' || e.key==='registrationDraft' || e.key==='regDraft')) setTimeout(applyOnce, 80); });
            window.addEventListener('mvsg:populateDone', function(){ setTimeout(applyOnce, 80); });
            window.addEventListener('mvsg:adminSaved', function(){ setTimeout(applyOnce, 80); });
        })();
        </script>
    <script>
        // Try to sync client Firebase ID token to the server before navigating to review-2.
        // This helps populate Laravel session('firebase_uid') so the next page can fetch server-profile.
        (function(){
            async function trySyncClientIdTokenToServer() {
                try {
                    if (!window.firebase || !firebase.auth) return null;
                    try { if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) firebase.initializeApp(window.FIREBASE_CONFIG); } catch(e){}
                    let user = firebase.auth().currentUser;
                    if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                    if (!user) return null;
                    const idToken = await user.getIdToken().catch(()=>null);
                    if (!idToken) return null;
                    const headers = { 'Content-Type': 'application/json' };
                    try { const csrfMeta = document.querySelector && document.querySelector('meta[name="csrf-token"]'); if (csrfMeta && csrfMeta.getAttribute) headers['X-CSRF-TOKEN'] = csrfMeta.getAttribute('content'); } catch(e){}
                    const resp = await fetch('{{ url('/session/firebase-signin') }}', { method: 'POST', credentials: 'same-origin', headers, body: JSON.stringify({ idToken }) });
                    try { const j = await resp.json().catch(()=>null); return j || (resp.ok?{ok:true}:null); } catch(e){ return resp.ok?{ok:true}:null; }
                } catch (e) { return null; }
            }
            const btn = document.getElementById('review1Continue');
            if (btn) {
                btn.addEventListener('click', async function(e){
                    e.preventDefault();
                    // attempt sync but don't block more than ~2s (give slightly more time for idToken retrieval)
                    try {
                        const p = trySyncClientIdTokenToServer();
                        // write debug info to console and wait up to 2s for the sync promise
                        p && p.then && p.then(function(r){ console.debug('[review1] client->server sync result', r); }).catch(function(err){ console.debug('[review1] client->server sync error', err); });
                        await Promise.race([p, new Promise(res=>setTimeout(()=>res(null), 2000))]);
                    } catch(e){}
    window.location.href = '{{ route('registerreview2') }}';
                });
            }
        })();
  </script>
    <script>
        // unified robust preview loader (tries local/session, registrationDraft globals, then Firestore)
        document.addEventListener('DOMContentLoaded', async () => {
            const tryParse = s => {
                try {
                    return typeof s === 'string' ? JSON.parse(s) : s;
                } catch (e) {
                    return null;
                }
            };
            const initFirebase = () => {
                try {
                    if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps
                            .length)) {
                        firebase.initializeApp(window.FIREBASE_CONFIG);
                    }
                } catch (e) {
                    console.warn('initFirebase', e);
                }
            };
            const fetchFirestoreDraft = async () => {
                if (!window.firebase || !firebase.firestore) return null;
                initFirebase();
                try {
                    const db = firebase.firestore();

                    // Allow an override via URL query param for admin/review pages.
                    // Example: /registerreview1?uid=n71qnTkNT9WUQhP4NAjOjA95lmK2
                    const params = new URLSearchParams(window.location.search || '');
                    const overrideUid = params.get('uid') || params.get('user') || params.get('id');
                    if (overrideUid) {
                        try {
                            const snap = await db.collection('users').doc(overrideUid).get().catch(() => null);
                            if (snap && snap.exists) return snap.data();
                        } catch (e) {
                            console.warn('fetchFirestoreDraft override read failed', e);
                        }
                    }

                    // Fallback: try to use currently signed-in user (if any)
                    if (window.firebase && firebase.auth) {
                        const auth = firebase.auth();
                        let user = auth.currentUser;
                        if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                        if (!user) return null;
                        // try common collections where drafts may be stored
                        const cols = ['registrations', 'users', 'registrationDrafts', 'profiles'];
                        for (const c of cols) {
                            try {
                                const snap = await db.collection(c).doc(user.uid).get().catch(() => null);
                                if (snap && snap.exists) return snap.data();
                            } catch (e) {
                                /* ignore per-collection errors */ }
                        }
                    }
                } catch (e) {
                    console.warn('fetchFirestoreDraft', e);
                }
                return null;
            };
            const readStored = async () => {
                // prefer registrationDraft aliases in storage/globals, otherwise try Firestore
                const keys = ['registrationDraft', 'registration_draft', 'dsRegistrationDraft',
                    'ds_registration', 'registerDraft', 'regDraft', 'reg_data', 'rpi_personal1'
                ];
                for (const k of keys) {
                    const s = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
                    if (s && typeof s === 'object') return s;
                }
                if (window.registrationDraft || window.__REGISTRATION_DRAFT__) {
                    try {
                        return typeof window.registrationDraft === 'string' ? tryParse(window
                            .registrationDraft) : (window.registrationDraft || window
                            .__REGISTRATION_DRAFT__);
                    } catch (e) {}
                }
                // final attempt: Firestore
                return await fetchFirestoreDraft();
            };
            const flatten = (obj, out = {}, prefix = '') => {
                if (!obj || typeof obj !== 'object') return out;
                for (const k of Object.keys(obj)) {
                    const v = obj[k];
                    const p = prefix ? `${prefix}.${k}` : k;
                    if (v && typeof v === 'object' && !Array.isArray(v)) flatten(v, out, p);
                    else out[p] = v;
                }
                return out;
            };
            const findFirstMatching = (obj, subs = []) => {
                try {
                    const flat = flatten(obj || {});
                    for (const sub of subs) {
                        const s = sub.toLowerCase();
                        for (const k of Object.keys(flat)) {
                            if (k.toLowerCase().includes(s) && flat[k]) return flat[k];
                        }
                    }
                } catch (e) {
                    /* ignore */ }
                return '';
            };

            // Robust resolver for Down Syndrome type — check common key variants and nested objects
            const resolveDsType = (root, personal) => {
                const candidates = [];
                // direct common keys (both camelCase and snake_case)
                try {
                    candidates.push(root?.dsType, root?.ds_type, root?.typeOfDs, root?.type_of_ds, root?.type, root?.downSyndromeType, root?.down_syndrome_type);
                    candidates.push(personal?.dsType, personal?.ds_type, personal?.typeOfDs, personal?.type_of_ds, personal?.type, personal?.downSyndromeType, personal?.down_syndrome_type);
                } catch (e) {}
                // try flattened search for any key containing ds or "down" or "syndrome"
                try {
                    const found = findFirstMatching(root || {}, ['ds', 'dsType', 'ds_type', 'down', 'down syndrome', 'type']);
                    if (found) candidates.push(found);
                } catch (e) {}

                for (const c of candidates) {
                    if (c === undefined || c === null) continue;
                    // If it's an object, try common string props
                    if (typeof c === 'object') {
                        if (Array.isArray(c) && c.length) return c.join(', ');
                        const label = c.label || c.name || c.type || c.text || c.value || c.display || c.code || null;
                        if (label && String(label).trim()) return String(label).trim();
                        // fallback to JSON stringify if object has useful content
                        try {
                            const s = JSON.stringify(c);
                            if (s && s !== '{}' && s !== 'null') return s;
                        } catch (e) {}
                        continue;
                    }
                    // If it's a non-empty string/number, return it
                    if ((typeof c === 'string' && c.trim()) || (typeof c === 'number' && !Number.isNaN(c))) return String(c).trim();
                }
                return '';
            };

            const safeSet = (id, value) => {
                try {
                    const el = document.getElementById(id);
                    if (!el) { console.debug('[review] element not found for id', id, 'value:', value); return; }
                    let out = value;
                    if (out === null || out === undefined) out = '';
                    else if (typeof out === 'object') {
                        if (Array.isArray(out)) out = out.join(', ');
                        else out = JSON.stringify(out);
                    }
                    out = String(out);
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = out ?? '';
                    else el.textContent = out ?? '';
                    console.debug('[review] set', id, out);
                } catch (e) {
                    console.warn('[review] safeSet error for', id, e);
                }
            };
            const setChoiceImage = (placeholderId, value, cardSelectors = ['.guardian-card',
                '.selectable-card']) => {
                try {
                    const container = document.getElementById(`${placeholderId}_container`);
                    const ph = document.getElementById(placeholderId);
                    if (!value) {
                        if (container) container.style.display = 'none';
                        if (ph) ph.src = '';
                        return;
                    }
                    const target = String(value).trim().toLowerCase();
                    const selectors = Array.isArray(cardSelectors) ? cardSelectors : [cardSelectors];
                    selectors.forEach(sel => document.querySelectorAll(sel).forEach(n => n.classList.remove(
                        'selected')));
                    for (const sel of selectors) {
                        for (const n of document.querySelectorAll(sel)) {
                            const title = n.querySelector('h3')?.textContent?.trim()?.toLowerCase();
                            if (title && title === target) {
                                const img = n.querySelector('img');
                                if (img && ph) ph.src = img.src || '';
                                if (container) container.style.display = 'block';
                                n.classList.add('selected');
                                return;
                            }
                        }
                    }
                    if (container) container.style.display = 'none';
                    if (ph) ph.src = '';
                } catch (e) {
                    console.warn('setChoiceImage', e);
                }
            };

            try {
                let data = await readStored();
                // Always attempt to fetch Firestore draft and merge missing keys from remote into local.
                try {
                    const remoteDoc = await fetchFirestoreDraft();
                    const remote = (remoteDoc && typeof remoteDoc === 'object' && remoteDoc.data && typeof remoteDoc.data === 'object') ? remoteDoc.data : remoteDoc;
                    if (remote && typeof remote === 'object') {
                        // unwrap local wrapper if present
                        if (data && typeof data === 'object' && data.data && typeof data.data === 'object') data = data.data;
                        data = data || {};
                        for (const k of Object.keys(remote)) {
                            const localVal = data[k];
                            const remoteVal = remote[k];
                            // If no local value at all, copy remote entirely
                            if (localVal === undefined || localVal === null) {
                                data[k] = remoteVal;
                                continue;
                            }
                            // If local is an empty object, replace with remote
                            if (typeof localVal === 'object' && !Array.isArray(localVal) && Object.keys(localVal || {}).length === 0) {
                                data[k] = remoteVal;
                                continue;
                            }
                            // If local is an empty string, replace with remote
                            if (typeof localVal === 'string' && String(localVal).trim() === '') {
                                data[k] = remoteVal;
                                continue;
                            }
                            // If both are objects, perform a shallow deep-merge that fills empty/missing inner fields
                            if (typeof localVal === 'object' && !Array.isArray(localVal) && typeof remoteVal === 'object' && !Array.isArray(remoteVal)) {
                                for (const subKey of Object.keys(remoteVal)) {
                                    try {
                                        const lv = localVal[subKey];
                                        const rv = remoteVal[subKey];
                                        if (lv === undefined || lv === null) {
                                            localVal[subKey] = rv;
                                        } else if (typeof lv === 'string' && String(lv).trim() === '') {
                                            localVal[subKey] = rv;
                                        }
                                    } catch (e) { /* ignore per-field */ }
                                }
                                data[k] = localVal;
                                continue;
                            }
                            // otherwise keep localVal as-is (it appears intentionally set)
                        }
                    }
                } catch (e) { console.warn('fetch/merge draft failed', e); }
                if (!data) return;
                // expose loaded draft to window for debugging (no visible debug panel)
                try { window.__mvsg_lastLoadedDraft = data; } catch(e){}
                try { window.__mvsg_lastDraftSource = (window.__mvsg_mergedFromFirestore ? 'firestore_merged' : 'local_or_remote'); } catch(e){}

                // helper to normalize filenames (strip paths like C:\\fakepath\\...)
                const normalizeFilename = (s) => {
                    try {
                        if (!s) return '';
                        const str = String(s || '');
                        const parts = str.split(/[/\\\\]+/);
                        return parts[parts.length - 1] || '';
                    } catch(e) { return s; }
                };
                // map common guardian fields
                const p = data.personalInfo || data.personal || data;
                safeSet('r_first_name', p?.first || p?.first_name || p?.firstName || p?.fname || '');
                safeSet('r_last_name', p?.last || p?.last_name || p?.lastName || p?.lname || '');
                safeSet('r_email', p?.email || p?.emailAddress || '');
                safeSet('r_phone', p?.phone || p?.mobile || '');
                safeSet('r_age', p?.age || '');
                const addrVal = p?.address || p?.address1 || p?.addr || findFirstMatching(data, ['address','addr','location','street','barangay','city']) || '';
                safeSet('r_address', addrVal);
                // account fields
                safeSet('r_username', p?.username || p?.userName || data?.username || '');
                // show password as masked stars if present in draft/remote (do not reveal actual characters)
                try {
                    const pwdCandidate = p?.password || p?.pass || p?.confirm_password || p?.confirmPassword || data?.password || data?.pass || '';
                    let masked = '';
                    if (pwdCandidate && typeof pwdCandidate === 'string' && pwdCandidate.length) {
                        // mask with same number of asterisks as chars provided
                        masked = '*'.repeat(pwdCandidate.length);
                    }
                    // if no password found in drafts, show a masked placeholder so users know a password will be set
                    safeSet('r_password', masked || '********');
                } catch (e) { safeSet('r_password', ''); }
                // dsType and school/work info
                // Debug: log loaded data shape to help trace why dsType may be missing
                try { console.debug('[review] loaded data keys:', Object.keys(data || {})); } catch(e){}
                try { console.debug('[review] personalInfo (p):', p); } catch(e){}
                const dsType = resolveDsType(data, p);
                try { console.debug('[review] resolved dsType:', dsType); } catch(e){}
                // ensure Down Syndrome info is shown in review (set the SELECT with id r_dsType1)
                try {
                    // prefer using the page's select-setter if available so we get fuzzy matching and change events
                    if (dsType) {
                        // normalize and attempt mapped display values for common synonyms
                        const normalize = s => (s||'').toString().replace(/\(.*?\)/g,'').replace(/[\W_]+/g,' ').trim();
                        const raw = String(dsType||'').trim();
                        const norm = normalize(raw);
                        const syn = (function(v){
                            const m = v.toLowerCase();
                            if (m.includes('trisomy') || m.includes('trisomy 21') || m.includes('non') || m.includes('nondisjunction')) return 'Trisomy 21 (Nondisjunction)';
                            if (m.includes('mosaic')) return 'Mosaic Down Syndrome';
                            if (m.includes('translocation')) return 'Translocation Down Syndrome';
                            return null;
                        })(norm);

                        if (typeof setSelectByValueOrText === 'function') {
                            // try mapped canonical value first, then original, then normalized
                            if (syn) setSelectByValueOrText('r_dsType1', syn) || setSelectByValueOrText('r_dsType1', raw) || setSelectByValueOrText('r_dsType1', norm);
                            else setSelectByValueOrText('r_dsType1', raw) || setSelectByValueOrText('r_dsType1', norm);
                        } else {
                            // helper not available yet: directly set the select value (best-effort) and dispatch change
                            const sel = document.getElementById('r_dsType1');
                            if (sel) {
                                try {
                                    // try to set exact match first
                                    let matched = false;
                                    for (const o of Array.from(sel.options||[])) {
                                        const ov = (o.value||'').toString().trim().toLowerCase();
                                        const ot = (o.text||'').toString().trim().toLowerCase();
                                        if (ov === raw.toLowerCase() || ot === raw.toLowerCase() || ov === norm.toLowerCase() || ot === norm.toLowerCase()) { sel.value = o.value; matched = true; break; }
                                    }
                                    if (!matched) {
                                        // append a selected option at top
                                        const opt = document.createElement('option'); opt.value = raw; opt.text = raw; opt.selected = true;
                                        try { sel.insertBefore(opt, sel.firstChild); sel.selectedIndex = 0; } catch(e){ sel.appendChild(opt); sel.value = raw; }
                                    }
                                    try { sel.dispatchEvent(new Event('change',{bubbles:true})); } catch(e){}
                                } catch(e) { console.warn('[review] set r_dsType1 direct failed', e); }
                            }
                        }
                    } else {
                        // nothing found, leave default -- do not overwrite empty select
                    }
                } catch(e) { console.warn('[review] dsType apply error', e); }

                // If dsType wasn't found in the merged/local draft, attempt an authoritative read
                // from Firestore (this will respect ?uid= override or the current firebase auth user).
                if (!dsType) {
                    try {
                        // Ensure Firebase SDKs are loaded (in case register.js didn't initialize Firebase yet)
                        const ensureFirebaseSdk = async () => {
                            if (window.firebase && firebase.firestore) return;
                            const load = (src) => new Promise((res, rej) => {
                                const s = document.createElement('script'); s.src = src; s.onload = res; s.onerror = rej; document.head.appendChild(s);
                            });
                            try {
                                await load('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
                                await load('https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js');
                                await load('https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js');
                                // call initFirebase if it's available in this scope (defined above)
                                if (typeof initFirebase === 'function') {
                                    try { initFirebase(); } catch(e) { console.warn('initFirebase failed', e); }
                                }
                            } catch (e) {
                                console.warn('[review] failed to load Firebase SDKs', e);
                            }
                        };

                        await ensureFirebaseSdk();
                        const remoteDoc = await fetchFirestoreDraft();
                        const remote = (remoteDoc && typeof remoteDoc === 'object' && remoteDoc.data && typeof remoteDoc.data === 'object') ? remoteDoc.data : remoteDoc;
                        if (remote) {
                            const remoteP = remote.personalInfo || remote.personal || remote;
                            const remoteDs = resolveDsType(remote, remoteP || {});
                            if (remoteDs) {
                                try { console.debug('[review] firestore dsType found:', remoteDs); } catch(e){}
                                safeSet('r_dsType', remoteDs);
                            }
                        }
                    } catch (e) {
                        console.warn('[review] failed to fetch dsType from Firestore', e);
                    }
                }
                
                const sw = data.schoolWorkInfo || data.school || data.work || {};
                safeSet('r_school_name', sw?.school_name || sw?.school || sw?.schoolName || '');
                safeSet('r_work_type', sw?.work_type || sw?.work || sw?.occupation || '');
                const cert = sw?.cert_file || data?.cert_file || sw?.certificate || findFirstMatching(data, ['cert', 'certificate', 'cert_file']);
                safeSet('r_cert_file', normalizeFilename(cert) || '');
                const g = data.guardianInfo || data.guardian || {};
                const guardianFirst = g?.guardian_first_name || g?.first_name || data?.guardian_first_name || findFirstMatching(data, ['guardian_first_name','guardian_first','guardianfirst','guardian.first','guardian.first_name','guardian.firstName']) || '';
                const guardianLast = g?.guardian_last_name || g?.last_name || data?.guardian_last_name || findFirstMatching(data, ['guardian_last_name','guardian_last','guardianlast','guardian.last','guardian.last_name','guardian.lastName']) || '';
                const guardianEmail = g?.guardian_email || g?.email || data?.guardian_email || findFirstMatching(data, ['guardian_email','guardian.email','guardian.email_address','guardian_email_address','guardianEmail','guardian_email']) || '';
                const guardianPhone = g?.guardian_phone || g?.phone || data?.guardian_phone || findFirstMatching(data, ['guardian_phone','guardian.phone','guardianPhone','guardian_mobile','guardian_mobile_phone']) || '';
                safeSet('r_guardian_first', guardianFirst);
                safeSet('r_guardian_last', guardianLast);
                safeSet('r_guardian_email', guardianEmail);
                safeSet('r_guardian_phone', guardianPhone);
                const guardianRel = g?.guardian_choice || g?.relationship || data?.guardian_choice || findFirstMatching(data, ['guardian_choice', 'relationship', 'guardian']);
                safeSet('r_guardian_relationship', guardianRel || '');
                setChoiceImage('review_guardian_relationship_img', guardianRel, ['.guardian-card',
                    '.selectable-card'
                ]);
                // proof filename: try multiple locations (also check schoolWorkInfo.cert_file)
                try {
                    let proof = data.proofFilename || (data.personalInfo && data.personalInfo.proofFilename) || (data.personal && data.personal.proofFilename) || '';
                    // fallback to school/work certificate filename if proof missing
                    if (!proof) {
                        const swc = (data.schoolWorkInfo && (data.schoolWorkInfo.cert_file || data.schoolWorkInfo.certs)) || data.cert_file || data.certs || '';
                        proof = swc || '';
                    }
                    proof = normalizeFilename(proof || '');
                    safeSet('r_proof', proof || 'No file uploaded');
                } catch (e) {}

                // No fallback DOM writes here — rely on explicit element ids already present in the template
            } catch (e) {
                console.error('preview loader failed', e);
            }
        });
    </script>
    <!-- Final safety re-apply for DS type: run after all other scripts to beat race conditions -->
    <script>
    (function(){
        function tryParse(s){ try{ return s? JSON.parse(s): null; }catch(e){ return null; } }
        function normalize(s){ return String(s||'').toLowerCase().replace(/\(.*?\)/g,'').replace(/[\W_]+/g,' ').trim(); }
        function mapSynonym(raw){ if(!raw) return null; const m = normalize(raw); if(m.includes('trisomy')) return 'Trisomy 21 (Nondisjunction)'; if(m.includes('mosaic')) return 'Mosaic Down Syndrome'; if(m.includes('transloc')) return 'Translocation Down Syndrome'; return null; }

        function findDsInStorage(){
            // direct small keys
            const direct = localStorage.getItem('dsType') || sessionStorage.getItem('dsType') || localStorage.getItem('r_dsType') || sessionStorage.getItem('r_dsType');
            if(direct) return direct;
            // try rpi_personal1 or registrationDraft shapes
            const candidates = ['rpi_personal1','registrationDraft','registration_draft','regDraft','reg_data'];
            for(const k of candidates){
                const raw = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
                if(raw){
                    // common shapes
                    if(raw.dsType) return raw.dsType;
                    if(raw.ds_type) return raw.ds_type;
                    if(raw.personal && (raw.personal.dsType || raw.personal.ds_type)) return raw.personal.dsType||raw.personal.ds_type;
                    // sometimes stored under simple key name mapping
                    if(raw.r_dsType) return raw.r_dsType;
                    if(raw.r_dsType1) return raw.r_dsType1;
                }
            }
            // try window-exposed merged draft
            try{ const w = window.__mvsg_lastLoadedDraft; if(w){ if(w.dsType) return w.dsType; if(w.personal && (w.personal.dsType||w.personal.ds_type)) return w.personal.dsType||w.personal.ds_type; } }catch(e){}
            return null;
        }

        function applyNow(){
            try{
                const raw = findDsInStorage();
                if(!raw) return false;
                const syn = mapSynonym(raw);
                if(typeof setSelectByValueOrText === 'function'){
                    if(syn) setSelectByValueOrText('r_dsType1', syn) || setSelectByValueOrText('r_dsType1', raw);
                    else setSelectByValueOrText('r_dsType1', raw);
                } else {
                    // fallback to direct DOM set
                    const sel = document.getElementById('r_dsType1'); if(!sel) return false;
                    const want = String(raw||'');
                    try{ for(const o of sel.options){ if(String(o.value||'').toLowerCase()===want.toLowerCase()||String(o.text||'').toLowerCase()===want.toLowerCase()){ sel.value = o.value; sel.dispatchEvent(new Event('change',{bubbles:true})); return true; } }
                        const mapped = syn || want; const opt = document.createElement('option'); opt.value = mapped; opt.text = mapped; opt.selected = true; sel.insertBefore(opt, sel.firstChild); sel.selectedIndex = 0; sel.dispatchEvent(new Event('change',{bubbles:true})); return true; }catch(e){ return false; }
                }
                return true;
            }catch(e){ console.warn('[review-final-reapply] error', e); return false; }
        }

        // run a few times with short backoff to beat timing issues
        let attempts = 0; const max = 8; const iv = setInterval(()=>{ attempts++; if(applyNow() || attempts>=max) clearInterval(iv); }, 180);
        // also run once after DOM ready
        if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', applyNow); else setTimeout(applyNow, 40);
    })();
    </script>
    <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
    <script>
        (function(){
            const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            let voices = [];
            const populateVoices = () => {
                voices = speechSynthesis.getVoices() || [];
            };
            const pickBest = (list, langPrefix) => {
                if (!list || !list.length) return null;
                // exact preferred name
                const exact = list.find(v=>v.name === preferredVoiceName);
                if (exact) return exact;
                // fuzzy name
                const fuzzy = list.find(v=>v.name && v.name.toLowerCase().includes('microsoft') && v.name.toLowerCase().includes('multilingual'));
                if (fuzzy) return fuzzy;
                // language match
                const langMatch = list.find(v => v.lang && v.lang.toLowerCase().startsWith(langPrefix));
                if (langMatch) return langMatch;
                return list[0] || null;
            };
            const voiceFor = (lang) => {
                const forLang = voices.filter(v => v.lang && v.lang.toLowerCase().startsWith(lang));
                return pickBest(forLang.length ? forLang : voices, lang);
            };
            const stopSpeaking = () => {
                try { speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>b.classList.remove('speaking')); } catch(e){}
            };
            const startSequence = (btn, en, tl) => {
                stopSpeaking();
                if (!en && !tl) return;
                btn.classList.add('speaking');
                btn.setAttribute('aria-pressed','true');
                const uEn = en ? new SpeechSynthesisUtterance(en) : null;
                const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
                if (uEn) { uEn.lang='en-US'; uEn.voice = voiceFor('en') || null; }
                if (uTl) { uTl.lang='tl-PH'; uTl.voice = voiceFor('tl') || (voiceFor('en') || null); }
                const finalize = () => { btn.classList.remove('speaking'); btn.setAttribute('aria-pressed','false'); };
                if (uEn && uTl) {
                    uEn.onend = () => { setTimeout(()=>speechSynthesis.speak(uTl), 180); };
                    uTl.onend = finalize;
                    speechSynthesis.speak(uEn);
                } else if (uEn) { uEn.onend = finalize; speechSynthesis.speak(uEn); }
                else if (uTl) { uTl.onend = finalize; speechSynthesis.speak(uTl); }
            };
            const init = () => {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = populateVoices;
                document.querySelectorAll('.tts-btn').forEach(b=>{
                    b.addEventListener('click', e=>{
                        const en = b.getAttribute('data-tts-en') || '';
                        const tl = b.getAttribute('data-tts-tl') || '';
                        if (b.classList.contains('speaking')) { stopSpeaking(); return; }
                        startSequence(b, en, tl);
                    });
                    b.addEventListener('keydown', ev=>{ if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); b.click(); } });
                });
                window.addEventListener('beforeunload', stopSpeaking);
            };
            if (document.readyState === 'complete' || document.readyState === 'interactive') init(); else document.addEventListener('DOMContentLoaded', init);
        })();
    </script>
        <script>
            // Safety-net: ensure proof filename is shown in the review UI when a draft contains it.
            (function(){
                const normalizeFilename = (s) => {
                    try { if (!s) return ''; const parts = String(s).split(/[/\\]+/); return parts[parts.length-1] || ''; } catch(e){ return s; }
                };
                const tryGetProof = (obj) => {
                    if (!obj) return '';
                    // common places
                    const candidates = [obj.proofFilename, obj.proof_filename, obj.proofFile, obj.proof, obj.cert_file, obj.certFile, obj.certs, obj.certificate];
                    for (const c of candidates) if (c) return c;
                    // nested personalInfo / personal
                    if (obj.personalInfo && typeof obj.personalInfo === 'object') {
                        const p = obj.personalInfo;
                        for (const c of [p.proofFilename, p.proof, p.cert_file, p.certFile]) if (c) return c;
                    }
                    if (obj.personal && typeof obj.personal === 'object') {
                        const p = obj.personal;
                        for (const c of [p.proofFilename, p.proof, p.cert_file, p.certFile]) if (c) return c;
                    }
                    // schoolWorkInfo
                    if (obj.schoolWorkInfo && typeof obj.schoolWorkInfo === 'object') {
                        const s = obj.schoolWorkInfo;
                        for (const c of [s.cert_file, s.certFile, s.certs]) if (c) return c;
                    }
                    return '';
                };

                const apply = () => {
                    try {
                        let draft = null;
                        try { draft = window.__mvsg_lastLoadedDraft || null; } catch(e){}
                        if (!draft) {
                            try { draft = JSON.parse(localStorage.getItem('rpi_personal1') || localStorage.getItem('registrationDraft') || 'null'); } catch(e){ draft = null; }
                        }
                        const proofRaw = tryGetProof(draft) || '';
                        const proof = normalizeFilename(proofRaw || '');
                        if (proof && document.getElementById('r_proof')) {
                            document.getElementById('r_proof').textContent = proof;
                            console.info('[review] applied proofFilename to r_proof:', proof);
                            return true;
                        }
                    } catch (e) { /* ignore safety-net errors */ }
                    return false;
                };

                // attempt immediate apply, but also retry and listen for populate/storage events
                let attempts = 0;
                const applyWithRetry = () => {
                    try {
                        const ok = apply();
                        if (ok) return;
                        attempts++;
                        if (attempts < 8) setTimeout(applyWithRetry, 300);
                        else {
                            // Final fallback: try to fetch authoritative document from Firestore (best-effort)
                            try {
                                (async function fetchProofFromFirestore(){
                                    try {
                                        if (!window.firebase || !firebase.firestore) return;
                                        // initialize if necessary
                                        try { if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) firebase.initializeApp(window.FIREBASE_CONFIG); } catch(e){}
                                        const params = new URLSearchParams(window.location.search || '');
                                        const overrideUid = params.get('uid') || params.get('user') || params.get('id');
                                        let docUid = overrideUid || (firebase.auth && firebase.auth().currentUser && firebase.auth().currentUser.uid) || null;
                                        // attempt to wait for auth if not ready
                                        if (!docUid && firebase.auth) {
                                            const user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
                                            if (user && user.uid) docUid = user.uid;
                                        }
                                        if (!docUid) return;
                                        const db = firebase.firestore();
                                        const snap = await db.collection('users').doc(docUid).get().catch(()=>null);
                                        const doc = snap && snap.exists ? snap.data() : null;
                                        if (!doc) return;
                                        const proofRaw = doc.proofFilename || doc.proof_filename || doc.proofFile || (doc.personalInfo && (doc.personalInfo.proofFilename || doc.personalInfo.proof)) || (doc.personal && (doc.personal.proofFilename || doc.personal.proof)) || doc.cert_file || '';
                                        const proof = normalizeFilename(proofRaw || '');
                                        if (proof && document.getElementById('r_proof')) {
                                            document.getElementById('r_proof').textContent = proof;
                                            console.info('[review] fetched proofFilename from Firestore and applied to r_proof:', proof);
                                        }
                                    } catch(e) { /* ignore final fallback errors */ }
                                })();
                            } catch(e){}
                        }
                    } catch(e){}
                };

                // run on DOM ready
                if (document.readyState === 'complete' || document.readyState === 'interactive') setTimeout(applyWithRetry, 50);
                else document.addEventListener('DOMContentLoaded', () => setTimeout(applyWithRetry, 50));

                // when register.js finishes populate it dispatches mvsg:populateDone — re-run apply
                try { window.addEventListener('mvsg:populateDone', applyWithRetry); } catch(e){}

                // if another window/tab writes rpi_personal1 or register writes it, catch storage events
                try { window.addEventListener('storage', function(e){ if (e && (e.key === 'rpi_personal1' || e.key === 'registrationDraft')) setTimeout(applyWithRetry, 80); }); } catch(e){}
            })();
        </script>

         <script>

             const phoneInput = document.getElementById('phone');

                    phoneInput.addEventListener('input', () => {
                        let value = phoneInput.value;

                        // 1️⃣ Alisin lahat ng hindi digits or '+' sign
                        value = value.replace(/[^\d+]/g, '');

                        // 2️⃣ Kung nagsimula sa '0', palitan ng '+63'
                        if (value.startsWith('0')) {
                            value = '+63' + value.substring(1);
                        }

                        // 3️⃣ Kung hindi pa nagsisimula sa '+63', pilitin itong maging '+63'
                        if (!value.startsWith('+63')) {
                            value = '+63';
                        }

                        // 4️⃣ Limitahan ang haba: +63 (3 chars) + 10 digits = total 13
                        if (value.length > 13) {
                            value = value.slice(0, 13);
                        }

                        // 5️⃣ Optional: kung gusto mo lagyan ng space after +63 para readability
                        // value = value.replace(/(\+63)(\d)/, '$1 $2'); // uncomment if you want "+63 9..."

                        // 6️⃣ Update input value
                        phoneInput.value = value;
                    });
                   

                    const passwordInput = document.getElementById('password');
                const passwordMessage = document.getElementById('passwordMessage');
                const confirmPasswordInput = document.getElementById('confirmPassword');
                const confirmMessage = document.getElementById('confirmMessage');
                const createAccountBtn = document.getElementById('createAccountBtn');
                const togglePassword = document.getElementById('togglePassword');

                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

                // 🔹 Password validation
                passwordInput.addEventListener('input', () => {
                const value = passwordInput.value.trim();

                if (value === '') {
                    passwordMessage.classList.add('hidden');
                    passwordInput.style.borderColor = '';
                    return;
                }

                passwordMessage.classList.remove('hidden');

                if (passwordRegex.test(value)) {
                    passwordInput.style.borderColor = 'green';
                    passwordMessage.textContent = '✅ Strong password. Ready to go!';
                    passwordMessage.classList.remove('text-red-500');
                    passwordMessage.classList.add('text-green-600');
                } else {
                    passwordInput.style.borderColor = 'red';
                    passwordMessage.textContent =
                    '❌ Must contain 1 uppercase, 1 lowercase, 1 number, and 8+ characters.';
                    passwordMessage.classList.remove('text-green-600');
                    passwordMessage.classList.add('text-red-500');
                }
                });
                document.getElementById("togglePassword").addEventListener("click", function () {
                const passwordField = document.getElementById("password");
                const isHidden = passwordField.type === "password";
                passwordField.type = isHidden ? "text" : "password";
                });

            </script>
            <script>
            const saved = localStorage.getItem("rpi_personal1");
            if (!saved) {
            console.warn("No draft found in localStorage.");
         //   return;
            }

            try {
            const draft = JSON.parse(saved);

            const fieldIds = [
                "first_name", "last_name", "age", "email", "phone", "address",
                "r_dsType1", "g_last_name", "g_first_name", "g_phone", "g_email",
                "guardian_relationship", "username", "password"
            ];

            console.log("📦 Retrieved Draft from localStorage:");
            fieldIds.forEach(id => {
                const field = document.getElementById(id);
                if (!field) return;

                const value = draft[id] || draft[toCamelCase(id)] || "";
                field.value = value;

                console.log(`${id}:`, value);
            });

            console.log("✅ Draft loaded into form.");
            } catch (err) {
            console.warn("❌ Failed to parse or apply rpi_personal1 draft", err);
            }

            function toCamelCase(str) {
            return str
                .replace(/[-_](.)/g, (_, group1) => group1.toUpperCase())
                .replace(/^[A-Z]/, c => c.toLowerCase());
            }
        </script>
         <script>
        (function() {
            // Save-only helper: persist draft so the central register.js can pick it up and create the account.
            const btn = document.getElementById('review1Continue');
            if (!btn) return;

            btn.addEventListener('click', function() {
                try {
                    btn.disabled = true;
                    btn.classList.add('opacity-60');
                    const data = {};
                    // collect all inputs/selects/textareas that have an id
                    document.querySelectorAll('input[id], select[id], textarea[id]').forEach(el => {
                        const id = el.id;
                        if (!id) return;
                        if (el.type === 'checkbox') data[id] = !!el.checked;
                        else data[id] = el.value || '';
                    });

                    // normalize common fields to expected keys
                    const draft = {
                        firstName: data.first_name || data.firstName || data.first || '',
                        lastName: data.last_name || data.lastName || data.last || '',
                        email: data.email || '',
                        phone: data.phone || '',
                        age: data.age || '',
                        address: data.address || '',
                        username: data.username || '',
                        g_first_name: data.g_first_name || data.guardianFirst || '',
                        g_last_name: data.g_last_name || data.guardianLast || '',
                        g_email: data.g_email || '',
                        g_phone: data.g_phone || '',
                        guardian_relationship: data.guardian_relationship || data.guardianRelationship || '',
                        r_dsType1: data.r_dsType1 || data.r_dsType1 || '',
                        password: data.password || '',
                    };

                    try {
                        localStorage.setItem('rpi_personal1', JSON.stringify(draft));
                    } catch (err) {
                        console.warn('Could not save rpi_personal1', err);
                    }

                    console.info('[adminapprove] saved rpi_personal1 draft', Object.keys(draft));
                    // dispatch event for other scripts to pick up
                    try {
                        window.dispatchEvent(new CustomEvent('mvsg:adminSaved', {
                            detail: {
                                key: 'rpi_personal1',
                                data: draft
                            }
                        }));
                    } catch (e) {}

                    window.location.href = '{{ route("registerreview2") }}';

                } catch (err) {
                    console.error('[adminapprove] submit failed', err);
                    btn.disabled = false;
                    btn.classList.remove('opacity-60');
                }
            });
        })();
    </script>
    <script>
/*
  Robust password reveal toggle:
  - If the visible value is masked, try to load the real password from localStorage.rpi_personal1
    (checks common key locations).
  - Toggle input.type between "password" and "text" and swap displayed value accordingly.
  - Keeps a simple icon/text swap on the button.
*/
(function () {
    const btn = document.getElementById('togglePassword');
    const input = document.getElementById('password');
    if (!btn || !input) return;

    let revealed = false;
    let realValue = null;

    function tryLoadFromDraft() {
        try {
            const raw = localStorage.getItem('rpi_personal1') || localStorage.getItem('registrationDraft') || sessionStorage.getItem('rpi_personal1');
            if (!raw) return null;
            const obj = JSON.parse(raw);
            // check common places
            const tryKeys = (o) => {
                if (!o || typeof o !== 'object') return null;
                const keys = ['password','pass','pwd','p','userPassword'];
                for (const k of keys) if (o[k]) return o[k];
                // nested personal
                if (o.personal && o.personal.password) return o.personal.password;
                if (o.personal && o.personal.pass) return o.personal.pass;
                if (o.personalInfo && o.personalInfo.password) return o.personalInfo.password;
                return null;
            };
            return tryKeys(obj) || tryKeys(obj.data) || null;
        } catch (e) {
            return null;
        }
    }

    function maskFor(val) {
        try { return val && val.length ? '*'.repeat(val.length) : '********'; } catch (e) { return '********'; }
    }

    // initialize a dataset backup (in case a previous script placed real value in dataset)
    if (input.dataset && input.dataset.realPassword) realValue = input.dataset.realPassword;

    btn.addEventListener('click', function (ev) {
        ev.preventDefault();
        // load real password lazily if needed
        if (!realValue) realValue = tryLoadFromDraft();

        if (!revealed) {
            // reveal
            // if we still don't have a real value, try to use current input.value (in case it's already the real password)
            const showVal = realValue || input.value || '';
            input.type = 'text';
            input.value = showVal;
            btn.textContent = '🙈'; // toggled icon
            revealed = true;
        } else {
            // hide
            input.type = 'password';
            // if we have the real value, show masked stars; otherwise keep current value masked
            input.value = realValue ? maskFor(realValue) : maskFor(input.value);
            btn.textContent = '👁️';
            revealed = false;
        }
    });
})();
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('filePreviewModal');
  const modalContent = document.getElementById('filePreviewContent');
  const modalClose = document.getElementById('filePreviewClose');

  function openPreview(name, dataUrl, type) {
    modal.classList.remove('hidden');
    modalContent.innerHTML = `<h2 class="font-semibold mb-2">${name}</h2>`;
    if (!dataUrl) {
      modalContent.innerHTML += '<p class="text-gray-600">No preview available.</p>';
      return;
    }
    if (['jpg','jpeg','png'].includes(type)) {
      modalContent.innerHTML += `<img src="${dataUrl}" class="max-h-[70vh] rounded shadow" alt="${name}">`;
    } else if (type === 'pdf') {
      modalContent.innerHTML += `<iframe src="${dataUrl}" class="w-full h-[70vh] rounded border"></iframe>`;
    } else {
      modalContent.innerHTML += `<a href="${dataUrl}" target="_blank" rel="noopener" class="text-blue-600 underline">Open ${name}</a>`;
    }
  }

  function closePreview() {
    modal.classList.add('hidden');
    modalContent.innerHTML = '';
  }

  modalClose?.addEventListener('click', closePreview);
  modal?.addEventListener('click', function(e){ if (e.target === modal) closePreview(); });

  // helper to wire a preview block
// ------------------------------------------------------------
// Unified, safe wireBlock()
// Prefers admin keys → fallback to legacy keys → ignores generic collisions
// ------------------------------------------------------------
function wireBlock(prefix, storageIndex) {

  // NEW admin-specific keys (preferred)
  const adminMap = {
    proof: {
      name: 'admin_uploaded_proof_name',
      data: 'admin_uploaded_proof_data',
      type: 'admin_uploaded_proof_type'
    },
    medical: {
      name: 'admin_uploaded_med_name',
      data: 'admin_uploaded_med_data',
      type: 'admin_uploaded_med_type'
    }
  };

  // OLD legacy keys used by older pages
  const legacy = {
    proof: {
      name: 'uploadedProofName1',
      data: 'uploadedProofData1',
      type: 'uploadedProofType1'
    },
    medical: {
      name: 'uploadedProofName0',
      data: 'uploadedProofData0',
      type: 'uploadedProofType0'
    }
  };

  // UI references
  const textEl   = document.getElementById(prefix === 'proof' ? 'r_proof' : 'r_medical');
  const infoEl   = document.getElementById(prefix === 'proof' ? 'proofFileInfo' : 'medFileInfo');
  const iconEl   = document.getElementById(prefix === 'proof' ? 'proofFileIcon' : 'medFileIcon');
  const nameEl   = document.getElementById(prefix === 'proof' ? 'proofFileName' : 'medFileName');
  const viewBtn  = document.getElementById(prefix === 'proof' ? 'proofViewBtn' : 'medViewBtn');
  const removeBtn= document.getElementById(prefix === 'proof' ? 'proofRemoveBtn' : 'medRemoveBtn');

  // Try admin first → legacy second
  function getStored(keys) {
    for (const k of keys) {
      const v = localStorage.getItem(k);
      if (v) return { key: k, val: v };
    }
    return { key: null, val: null };
  }

  function render() {
    // Which keys to try, in order
    const tryNames = [
      adminMap[prefix].name,
      legacy[prefix].name
    ];
    const tryData = [
      adminMap[prefix].data,
      legacy[prefix].data
    ];
    const tryType = [
      adminMap[prefix].type,
      legacy[prefix].type
    ];

    const nameResult = getStored(tryNames);
    const dataResult = getStored(tryData);
    const typeResult = getStored(tryType);

    const name = nameResult.val;
    const data = dataResult.val;
    const type = (typeResult.val || '').toLowerCase();

    if (name && data) {
      // Show UI
      textEl.classList.add('hidden');
      infoEl.classList.remove('hidden');

      nameEl.textContent = name;
      iconEl.textContent = (
        type === 'pdf' ? '📄' :
        ['jpg','jpeg','png'].includes(type) ? '🖼️' : '📁'
      );

      viewBtn.disabled = false;
      viewBtn.onclick = () => openPreview(name, data, type);

      removeBtn.disabled = false;
      removeBtn.onclick = () => {
        // Remove ALL related keys to keep everything clean
        [
          adminMap[prefix].name, adminMap[prefix].data, adminMap[prefix].type,
          legacy[prefix].name, legacy[prefix].data, legacy[prefix].type
        ].forEach(k => localStorage.removeItem(k));

        render();
      };
    } else {
      // No file
      textEl.classList.remove('hidden');
      textEl.textContent = 'No file uploaded';

      infoEl.classList.add('hidden');

      viewBtn.disabled = true;
      viewBtn.onclick = null;

      removeBtn.disabled = true;
      removeBtn.onclick = null;
    }
  }

  // Initial load
  render();

  // Storage sync (other tabs)
  window.addEventListener('storage', (e) => {
    const relatedKeys = [
      adminMap[prefix].name, adminMap[prefix].data, adminMap[prefix].type,
      legacy[prefix].name, legacy[prefix].data, legacy[prefix].type
    ];
    if (!e.key || relatedKeys.includes(e.key)) {
      setTimeout(render, 20);
    }
  });
}

  wireBlock('proof', 1);
  wireBlock('medical', 0);
});
</script>
               <!-- Modal for file preview -->
               <div id="filePreviewModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[100000]">
                 <div class="bg-white rounded-lg shadow-lg p-4 max-w-4xl w-[92%] relative">
                   <button id="filePreviewClose" type="button" class="absolute top-2 right-3 text-gray-600 hover:text-gray-900 text-2xl">×</button>
                   <div id="filePreviewContent" class="p-2"></div>
                 </div>
               </div>
</body>

</html>