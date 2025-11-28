@extends('layouts.includes')

@section('content')
    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">


 <!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/job-details"
      class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back to Job Details</span>
    </a>
  </div>
</div>


    <!-- JOB INFO CARD -->
    <section class="max-w-6xl mx-auto mt-14 px-6">
        <h2 class="text-4xl font-extrabold text-[#1E40AF] mb-10 text-center">You Are Applying For</h2>
        @php
            // We no longer use CSV files here — the page will request jobs from
            // public/db/get-jobs.php on the client. Keep only job_id for JS.
            // accept either job_id or id (URL may use ?id=...)
            $job_id = request('job_id') ?? request('id') ?? '';
        @endphp

        @php
            // Try to fetch the single job server-side (so the page can render immediately)
            $job = null;
            if (!empty($job_id)) {
                try {
                    $oraclePath = base_path('public/db/oracledb.php');
                    if (file_exists($oraclePath)) {
                        require_once $oraclePath; // provides getOracleConnection()
                        $conn = getOracleConnection();
                        if ($conn) {
                            // Basic job row
                            $sql = "SELECT ID, COMPANY_NAME, JOB_ROLE, JOB_DESCRIPTION, ADDRESS, JOB_TYPE, EMPLOYEE_CAPACITY FROM JOB_POSTINGS WHERE ID = :job_id";
                            $stid = oci_parse($conn, $sql);
                            oci_bind_by_name($stid, ':job_id', $job_id);
                            oci_execute($stid);
                            $row = oci_fetch_assoc($stid);
                            if ($row) {
                                // skills
                                $skills = [];
                                $pSql = "SELECT VALUE, TYPE FROM JOB_PROFILE WHERE JOB_POSTING_ID = :job_id AND VALUE IS NOT NULL AND TYPE IN ('skills','job-position','role')";
                                $pstid = oci_parse($conn, $pSql);
                                oci_bind_by_name($pstid, ':job_id', $job_id);
                                @oci_execute($pstid);
                                while ($p = @oci_fetch_assoc($pstid)) {
                                    $t = strtolower($p['TYPE'] ?? '');
                                    if ($t === 'skills') $skills[] = $p['VALUE'];
                                }
                                @oci_free_statement($pstid);

                                // image (match get-jobs.php behavior)
                                $imgSql = "SELECT COMPANY_IMAGE FROM JOB_POSTINGS WHERE ID = :job_id";
                                $imgSt = oci_parse($conn, $imgSql);
                                oci_bind_by_name($imgSt, ':job_id', $job_id);
                                @oci_execute($imgSt);
                                $imgRow = @oci_fetch_assoc($imgSt);
                                if ($imgRow && $imgRow['COMPANY_IMAGE'] !== null) {
                                    $blob = $imgRow['COMPANY_IMAGE'];
                                    $imageContent = $blob->load();
                                    $logoSrc = "data:image/png;base64," . base64_encode($imageContent);
                                } else {
                                    $logoSrc = "https://via.placeholder.com/150?text=Logo";
                                }
                                @oci_free_statement($imgSt);

                                $job = [
                                    'id' => $row['ID'],
                                    'company_name' => $row['COMPANY_NAME'] ?? '',
                                    'job_role' => $row['JOB_ROLE'] ?? '',
                                    'description' => $row['JOB_DESCRIPTION'] ?? '',
                                    'address' => $row['ADDRESS'] ?? '',
                                    'job_type' => $row['JOB_TYPE'] ?? '',
                                    'skills' => $skills,
                                    'openings' => $row['EMPLOYEE_CAPACITY'] ?? 10,
                                    'applied' => 0,
                                    'logo' => $logoSrc
                                ];
                            }
                            @oci_free_statement($stid);
                            @oci_close($conn);
                        }
                    }
               } catch (\Throwable $e) {
                   // ignore server-side lookup failures — client-side fetch will run as fallback
               }
           }
       @endphp


      <div
          class="bg-[#F0F9FF] border-[3px] border-[#1E40AF] rounded-3xl p-10 flex flex-col sm:flex-row items-center gap-10 shadow-lg">
          <!-- Company Logo / Placeholder -->
          <div class="flex items-center justify-center">
              <img id="jobLogo" src="https://via.placeholder.com/150?text=Logo" alt="Company Logo"
                  class="w-36 h-36 rounded-2xl border-2 border-gray-300 object-cover">
          </div>

          <!-- Job Info -->
          <div class="flex flex-col justify-center leading-snug text-center sm:text-left max-w-3xl">
              <h3 id="jobTitle" class="text-4xl font-extrabold text-black">Job Title</h3>
              <p id="jobCompany" class="text-gray-700 text-2xl font-semibold mt-2">Company Name</p>
              <p id="jobLocation" class="text-gray-600 text-xl mt-1">Location</p>
              <p id="jobDescription" class="text-gray-600 text-lg mt-3 leading-relaxed">Description</p>
          </div>
      </div>
    </section>


 <!-- JOB APPLICATION FORM -->
<section class="max-w-6xl mx-auto p-10 mt-8 space-y-8">
  <h2 class="text-4xl font-extrabold text-[#1E40AF] mb-6 text-center">
    Job Application Form
  </h2>
  <p class="text-gray-700 text-2xl mb-12 text-center leading-relaxed max-w-4xl mx-auto">
    Please fill out this form carefully. All questions marked with
    <span class="text-red-500 font-bold">*</span> are required.
  </p>

  <form class="space-y-14" id="mainForm">

<!-- ================= PERSONAL INFORMATION ================= -->
<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 border-b-4 border-blue-200 pb-3">
    <h3 class="text-3xl font-semibold text-[#1E40AF] mb-4 sm:mb-0">Personal Information</h3>
    <button type="button" id="autofillPersonal"
      class="bg-blue-600 text-white font-semibold px-8 py-2 text-lg rounded-xl hover:bg-blue-900 transition shadow">
      Autofill from Profile
    </button>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">First Name <span class="text-red-500">*</span></label>
      <input type="text" name="firstName"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">Last Name <span class="text-red-500">*</span></label>
      <input type="text" name="lastName"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div class="sm:col-span-2">
      <label class="block font-bold text-2xl text-gray-800 mb-2">Email Address <span class="text-red-500">*</span></label>
      <input type="email" name="email"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">Age <span class="text-red-500">*</span></label>
      <input type="number" name="age"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">Phone Number <span class="text-red-500">*</span></label>
      <input type="tel" name="phone"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div class="sm:col-span-2">
      <label class="block font-bold text-2xl text-gray-800 mb-2">Complete Address <span class="text-red-500">*</span></label>
      <input type="text" name="address"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
  </div>
</div>

<!-- ================= EDUCATION ================= -->
{{--<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 border-b-4 border-blue-200 pb-3">
    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4 sm:mb-0">Education</h3>
    <button type="button" id="autofillEducation"
      class="bg-blue-600 text-white font-semibold px-8 py-2 text-lg rounded-xl hover:bg-blue-900 transition shadow">
      Autofill from Profile
    </button>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
    <div class="relative">
      <label class="block font-bold text-2xl text-gray-800 mb-2">Highest Educational Attainment <span
          class="text-red-500">*</span></label>
      <select name="educationLevel"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl pr-12 appearance-none focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
        <option value="" disabled selected class="text-gray-400 italic">🎓 Select your education level</option>
        <option>Elementary</option>
        <option>High School</option>
        <option>College</option>
        <option>Vocational</option>
      </select>
      <div class="mt-10 absolute inset-y-0 right-4 flex items-center pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-black-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">School Name</label>
      <input type="text" name="school"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">Course/Program (if applicable)</label>
      <input type="text" name="course"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
    <div>
      <label class="block font-bold text-2xl text-gray-800 mb-2">Year Graduated</label>
      <input type="text" name="year"
        class="w-full border-2 border-gray-300 rounded-xl p-5 text-2xl focus:ring-4 focus:ring-blue-200 focus:border-[#1E40AF]">
    </div>
  </div>

  <div class="block mt-10">
    <h2 class="text-2xl font-bold mb-4">Upload Certifications <span class="text-gray-500 text-xl">(PDF, JPG, PNG)</span></h2>
    <div class="border-2 border-dashed border-[#1E40AF] rounded-2xl p-8 text-center bg-[#F0F9FF]">
      <input id="certifications" type="file" accept=".pdf,image/*" multiple class="hidden" />
      <button type="button" onclick="document.getElementById('certifications').click()"
        class="bg-[#1E40AF] text-white text-2xl font-semibold px-10 py-4 rounded-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition">
        + Add Certification
      </button>
      <p class="mt-3 text-lg text-gray-700">You can upload more than one file.</p>
    </div>
    <div id="filePreview" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"></div>
  </div>
</div>

<!-- ================= WORK EXPERIENCE ================= -->
<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 border-b-4 border-blue-200 pb-3">
    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4 sm:mb-0">Work Experience</h3>
    <button type="button" id="autofillExperience"
      class="bg-blue-600 text-white font-semibold px-8 py-2 text-lg rounded-xl hover:bg-blue-900 transition shadow">
      Autofill from Profile
    </button>
  </div>

  <div id="experienceList" class="space-y-6"></div>
  <div class="mt-6 text-center">
    <button type="button" onclick="addExperience()"
      class="bg-[#1E40AF] text-white text-2xl font-semibold px-10 py-4 rounded-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition">
      + Add Job Experience
    </button>
  </div>
</div>

<!-- ================= SKILLS SECTION ================= -->
<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 border-b-4 border-blue-200 pb-3">
    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4 sm:mb-0">Skills</h3>
    <button type="button" id="autofillSkills"
      class="bg-blue-600 text-white font-semibold px-8 py-2 text-lg rounded-xl hover:bg-blue-900 transition shadow">
      Autofill from Profile
    </button>
  </div>

  <p class="text-gray-600 mb-3">List your skills below. Press Enter to add.</p>
  <div class="border-2 border-dashed border-[#1E40AF] rounded-2xl p-6 bg-[#F0F9FF]">
    <div id="skillsContainer" class="flex flex-wrap gap-3 mb-3"></div>
    <input id="skillInput" type="text" placeholder="Type a skill and press Enter"
      class="w-full text-lg px-4 py-3 border rounded-xl focus:ring-4 focus:ring-blue-300 outline-none" />
  </div>
</div>--}}

<!-- ================= REQUIRED DOCUMENTS ================= -->
<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
  
  <!-- HEADER -->
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 border-b-4 border-blue-200 pb-3">
    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4 sm:mb-0">
      Required Documents
    </h3>
  </div>

  <p class="text-gray-700 text-xl mb-6">
    Please upload all required documents in PDF, DOC, DOCX, JPG, or PNG format
  </p>

  <!-- CHECKLIST -->
  <div class="space-y-4 mb-6">
    <label class="flex items-center gap-3 cursor-pointer">
      <input id="chk_medical" type="checkbox" class="w-5 h-5 text-blue-600 rounded">
      <span class="text-xl text-gray-800 font-semibold">Medical Certificate</span>
    </label>

    <label class="flex items-center gap-3 cursor-pointer">
      <input id="chk_resume" type="checkbox" class="w-5 h-5 text-blue-600 rounded">
      <span class="text-xl text-gray-800 font-semibold">Resume / CV</span>
    </label>

    <label class="flex items-center gap-3 cursor-pointer">
      <input id="chk_pwd" type="checkbox" class="w-5 h-5 text-blue-600 rounded">
      <span class="text-xl text-gray-800 font-semibold">PWD ID</span>
    </label>
  </div>

  <!-- SINGLE UPLOAD BOX -->
  <div class="border-2 border-dashed border-[#1E40AF] rounded-2xl p-8 text-center 
              bg-[#F0F9FF] hover:bg-blue-50 transition" onclick="document.getElementById('allDocuments').click()">
    
    <div id="bigUploadContent" class="cursor-pointer">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#1E40AF] mx-auto mb-4" 
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M7 16V4a2 2 0 012-2h6a2 2 0 012 2v12m-6 4l-4-4m4 4l4-4m-4 4V10" />
    </svg>

    <!-- the inner clickable content — hide/show independently from the dashed box -->
      <p class="text-2xl font-semibold text-[#1E40AF]">Click here to upload all documents</p>
      <p class="text-gray-600 text-lg mt-2">
        (PDF, DOC, DOCX, JPG, PNG — Max size: 15MB each)
      </p>
      <p class="text-gray-600 text-lg font-semibold mt-2">You may upload up to 3 files</p>
    </div>
    <div id="requiredFilesSlots" class="mt-6 grid grid-cols-1 gap-4 max-w-3xl mx-auto"></div>
  </div>
  <!-- HIDDEN FILE INPUT -->
  <input type="file" id="allDocuments" class="hidden" 
         accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
</div>
            <!-- ================= SUBMIT BUTTON ================= -->
            <div class="flex justify-center mt-6">
                {{-- Preserve job_id when navigating to the review page (if present) --}}
                <a href="/job-application-review1{{ $job_id ? ('?job_id=' . urlencode($job_id)) : '' }}"
                   class="bg-[#1E40AF] text-white text-3xl font-bold px-16 py-6 rounded-2xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition inline-block text-center">
                    Click to Review Application
                </a>
            </div>
        </form>

         <!-- BACK TO TOP BUTTON -->
         <button id="backToTopBtn"
            class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
              onclick="scrollToTop()" aria-label="Back to top">
  
         <!-- Up Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="3">
         <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
         </svg>

        <span>Back to Top</span>
        </button>

        <!-- ================= MODALS ================= -->
        <div id="imageModal"
            class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 p-4">
            <div class="relative">
                <img id="modalImage" src="" class="max-w-full max-h-[80vh] rounded-lg shadow-lg">
                <button onclick="closeModal('imageModal')"
                    class="absolute top-2 right-2 text-white text-3xl font-bold bg-black bg-opacity-50 px-3 py-1 rounded-lg">✕</button>
            </div>
        </div>

        <div id="pdfModal" class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 p-4">
            <div class="relative bg-white rounded-lg shadow-2xl w-full max-w-4xl h-[80vh] flex flex-col">
                <iframe id="pdfFrame" class="w-full h-full rounded-b-lg" frameborder="0"></iframe>
                <button onclick="closeModal('pdfModal')"
                    class="absolute top-2 right-2 text-white text-3xl font-bold bg-black bg-opacity-50 px-3 py-1 rounded-lg z-10">✕</button>
            </div>
        </div>

        {{-- <script>
            // =============== SKILLS ===============
            const skillInput = document.getElementById('skillInput');
            const skillsContainer = document.getElementById('skillsContainer');
            let skills = [];

            skillInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && skillInput.value.trim() !== '') {
                    e.preventDefault();
                    const skill = skillInput.value.trim();
                    if (!skills.includes(skill)) {
                        skills.push(skill);
                        renderSkills();
                    }
                    skillInput.value = '';
                }
            });

            function renderSkills() {
                skillsContainer.innerHTML = '';
                skills.forEach((skill, index) => {
                    const tag = document.createElement('div');
                    tag.className = 'bg-[#1E40AF] text-white px-4 py-2 rounded-full text-lg flex items-center gap-2';
                    tag.innerHTML =
                        `${skill} <button onclick="removeSkill(${index})" class="ml-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold">Remove</button>`;
                    skillsContainer.appendChild(tag);
                });
            }

            function removeSkill(index) {
                skills.splice(index, 1);
                renderSkills();
            }

            // =============== WORK EXPERIENCE ===============
            const experienceList = document.getElementById('experienceList');

            function addExperience() {
                const expDiv = document.createElement('div');
                expDiv.className = 'p-6 bg-[#F0F9FF] rounded-2xl border border-[#1E40AF] shadow-sm space-y-3 relative';
                expDiv.innerHTML = `
    <button type="button" class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold" onclick="this.parentElement.remove()">Remove</button>
    <div><label class="font-semibold text-lg">Job Title</label>
      <input type="text" class="w-full border rounded-lg px-4 py-2 text-lg" placeholder="e.g. Sales Associate">
    </div>
    <div><label class="font-semibold text-lg">Company Name</label>
      <input type="text" class="w-full border rounded-lg px-4 py-2 text-lg" placeholder="e.g. ABC Corp">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div><label class="font-semibold text-lg">Start Date</label>
        <input type="date" class="w-full border rounded-lg px-4 py-2 text-lg">
      </div>
      <div><label class="font-semibold text-lg">End Date</label>
        <input type="date" class="w-full border rounded-lg px-4 py-2 text-lg">
      </div>
    </div>
    <div>
      <label class="font-semibold text-lg">Job Description</label>
      <textarea class="w-full border rounded-lg px-4 py-2 text-lg resize-y min-h-[80px]" placeholder="Describe your tasks and responsibilities"></textarea>
    </div>
  `;
                experienceList.appendChild(expDiv);
            }
            // ==================== UNIVERSAL FILE UPLOADER ====================

// Store uploads separately by input ID
const uploadedFilesMap = {};

function setupUploader(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  uploadedFilesMap[inputId] = []; // initialize storage for this uploader

  input.addEventListener('change', (event) => {
    const newFiles = Array.from(event.target.files);
    uploadedFilesMap[inputId].push(...newFiles);
    renderPreviews(inputId, previewId);
    input.value = ''; // reset so same file can be uploaded again
  });

  function renderPreviews(inputId, previewId) {
    const preview = document.getElementById(previewId);
    const files = uploadedFilesMap[inputId];
    preview.innerHTML = '';

    if (files.length === 0) {
      preview.innerHTML =
        '<p class="text-gray-500 text-center text-lg">No document uploaded yet.</p>';
      return;
    }

    files.forEach((file, index) => {
      const url = URL.createObjectURL(file);

      const card = document.createElement('div');
      card.className =
        'relative border-2 border-gray-300 rounded-2xl p-6 bg-white shadow-md flex flex-col items-center justify-center text-center';

      const removeBtn = document.createElement('button');
      removeBtn.innerHTML = 'Remove';
      removeBtn.className =
        'absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold';
      removeBtn.onclick = (e) => {
        e.preventDefault();
        files.splice(index, 1);
        renderPreviews(inputId, previewId);
      };

      const fileName = document.createElement('p');
      fileName.className =
        'text-gray-700 font-medium text-lg mt-3 truncate w-56';
      fileName.textContent = file.name;

      // Display previews or buttons based on type
      if (file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.src = url;
        img.className =
          'w-48 h-48 object-cover rounded-xl border cursor-pointer hover:scale-105 transition';
        img.onclick = () => openImageModal(url);
        card.append(img, fileName, removeBtn);
      } else if (file.type === 'application/pdf') {
        const btn = document.createElement('button');
        btn.textContent = 'View PDF';
        btn.className = 'text-blue-600 underline font-semibold mt-2';
        btn.onclick = (e) => {
          e.preventDefault();
          openPDFModal(url);
        };
        card.append(fileName, btn, removeBtn);
      } else {
        const btn = document.createElement('button');
        btn.textContent = 'Open File';
        btn.className = 'text-blue-600 underline font-semibold mt-2';
        btn.onclick = (e) => {
          e.preventDefault();
          window.open(url, '_blank');
        };
        card.append(fileName, btn, removeBtn);
      }

      preview.appendChild(card);
    });
  }
}

// ==================== MODALS ====================
function openImageModal(src) {
  document.getElementById('modalImage').src = src;
  document.getElementById('imageModal').classList.remove('hidden');
}

function openPDFModal(url) {
  document.getElementById('pdfFrame').src = url;
  document.getElementById('pdfModal').classList.remove('hidden');
}

function closeModal(id) {
  document.getElementById(id).classList.add('hidden');
}

// ==================== INITIALIZE BOTH UPLOADERS ====================
setupUploader('certifications', 'filePreview');   // for certifications
setupUploader('resumeUpload', 'resumePreview');   // for resume/CV

            // ================= MODALS =================
            function openImageModal(src) {
                document.getElementById('modalImage').src = src;
                document.getElementById('imageModal').classList.remove('hidden');
            }

            function openPDFModal(url) {
                document.getElementById('pdfFrame').src = url;
                document.getElementById('pdfModal').classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }

             // Show/hide the Back to Top button
              const backToTopBtn = document.getElementById("backToTopBtn");
              window.addEventListener("scroll", () => {
                if (window.scrollY > 300) {
                 backToTopBtn.classList.remove("hidden");
                } else {
                backToTopBtn.classList.add("hidden");
                }
              });

              // Smooth scroll to top
            function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
          </script>
          

        {{-- Replaced the previous module-based script with a plain script that always runs --}}
        <script>
            (function() {
                // Helper: safely read request('job_id') from blade into JS
                const jobId = {!! json_encode($job_id) !!};

                // attach handler when DOM is ready
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('jobApplicationForm');
                    if (!form) return;

                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // stop default POST that adds _token to URL

                        // collect form values (keep in sync with your inputs)
                        const data = {
                            user_id: document.getElementById('user_id') ? document.getElementById(
                                'user_id').value : 'user1234',
                            first_name: (document.getElementById('first_name') || {}).value || '',
                            last_name: (document.getElementById('last_name') || {}).value || '',
                            email: (document.getElementById('email') || {}).value || '',
                            phone_number: (document.getElementById('phone_number') || {}).value || '',
                            address: (document.getElementById('address') || {}).value || '',
                            date_of_birth: (document.getElementById('date_of_birth') || {}).value || '',
                            gender: (document.getElementById('gender') || {}).value || '',
                            job_title: (document.getElementById('job_title') || {}).value || '',
                            company_employer: (document.getElementById('company_employer') || {})
                                .value || '',
                            start_date: (document.getElementById('start_date') || {}).value || '',
                            end_date: (document.getElementById('end_date') || {}).value || '',
                            job_description: (document.getElementById('job_description') || {}).value ||
                                ''
                        };

                        // Save to sessionStorage and localStorage so page 2 / review pages can access it
                        try {
                            const json = JSON.stringify(data);
                            sessionStorage.setItem('jobApplication_step1', json);
                            localStorage.setItem('jobApplication_step1', json);
                        } catch (err) {
                            // storage may be disabled; ignore but still redirect
                            console.warn('storage not available', err);
                        }

                        // Build next URL and redirect to Job Application 2 with job_id preserved
                        const base = "{{ route('job.application.2') }}";
                        const nextUrl = jobId ? base + '?job_id=' + encodeURIComponent(jobId) : base;
                        window.location.href = nextUrl;
                    });
                });
            })();
        </script>
<script>
  (function () {
    const defs = [
      { checkboxId: 'chk_medical', key: 'medical', label: 'Medical Certificate' },
      { checkboxId: 'chk_resume', key: 'resume', label: 'Resume / CV' },
      { checkboxId: 'chk_pwd', key: 'pwd', label: 'PWD ID' }
    ];

    const LS_PREFIX = 'jobreq_';
    const stored = {};     // key -> { name, url (dataURL), type, rawFile }
    const pendingFiles = [];

    function guessTypeFromFilename(name) {
      const ext = (name || '').split('.').pop().toLowerCase();
      if (!ext) return '';
      if (['jpg','jpeg','png','gif','webp','bmp'].includes(ext)) return ext;
      if (ext === 'pdf') return 'pdf';
      return ext;
    }

    function loadPersisted() {
      defs.forEach(def => {
        try {
          const name = localStorage.getItem(LS_PREFIX + def.key + '_name');
          const data = localStorage.getItem(LS_PREFIX + def.key + '_data');
          const type = localStorage.getItem(LS_PREFIX + def.key + '_type');
          if (name && data) {
            stored[def.key] = { name: name, url: data, type: type || guessTypeFromFilename(name) };
          }
        } catch (e) { /* ignore */ }
      });
    }

    function persistEntry(key) {
      try {
        if (stored[key] && stored[key].url) {
          localStorage.setItem(LS_PREFIX + key + '_name', stored[key].name);
          localStorage.setItem(LS_PREFIX + key + '_data', stored[key].url);
          localStorage.setItem(LS_PREFIX + key + '_type', stored[key].type || '');
        } else {
          localStorage.removeItem(LS_PREFIX + key + '_name');
          localStorage.removeItem(LS_PREFIX + key + '_data');
          localStorage.removeItem(LS_PREFIX + key + '_type');
        }
      } catch (e) { console.warn('persistEntry failed', e); }
    }

        function createSlot(def) {
      const wrap = document.createElement('div');
      wrap.className = 'required-slot flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm';

      const left = document.createElement('div');
      left.className = 'flex-1 min-w-0 text-center';

      const title = document.createElement('div');
      title.className = 'text-sm font-semibold text-gray-800';
      title.textContent = def.label;

      const name = document.createElement('div');
      name.className = 'text-sm text-gray-600 truncate';
      name.id = def.key + '_name';
      name.textContent = 'No file selected';

      left.appendChild(title);
      left.appendChild(name);

      const actions = document.createElement('div');
      actions.className = 'flex gap-2 items-center flex-none';

      // --- CHOOSE ---
      const choose = document.createElement('button');
      choose.type = 'button';
      choose.className = 'bg-[#2E2EFF] text-white text-xs px-3 py-1 rounded-md';
      choose.textContent = 'Choose file';
      choose.addEventListener('click', (e) => {
        e.stopPropagation();
        e.preventDefault();
        getOrCreateInput(def.key).click();
      });

      // --- VIEW ---
      const view = document.createElement('button');
      view.type = 'button';
      view.className = 'bg-gray-700 text-white text-xs px-3 py-1 rounded-md';
      view.textContent = 'View';
      view.disabled = true;

      // --- REMOVE ---
      const remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'bg-red-500 text-white text-xs px-3 py-1 rounded-md';
      remove.textContent = 'Remove';
      remove.disabled = true;

      // helper: get extension (prefer mime -> fallback to filename)
      function getExt(type, name) {
        if (type) {
          const t = String(type).toLowerCase();
          if (t.includes('pdf')) return 'pdf';
          if (t.startsWith('image/')) return t.split('/')[1] || 'image';
        }
        if (name) return (name.split('.').pop() || '').toLowerCase();
        return '';
      }

      // view opens shared fileModal
      view.addEventListener('click', (e) => {
        e.stopPropagation();
        e.preventDefault();
        const s = stored[def.key];
        if (!s || !s.url) return;
        const ext = getExt(s.type, s.name);
        openModal(s.url, ext);
      });

      remove.addEventListener('click', (e) => {
        e.stopPropagation();
        e.preventDefault();
        removeFile(def.key);
      });

      actions.appendChild(choose);
      actions.appendChild(view);
      actions.appendChild(remove);

      wrap.appendChild(left);
      wrap.appendChild(actions);

      return { wrap, nameEl: name, viewBtn: view, removeBtn: remove };
    }

    // --- CLICK ANYWHERE ON THE BIG BOX ---
    const bigBox = document.getElementById('bigUploadBox');
    const bigPicker = document.getElementById('allDocuments');

    if (bigBox && bigPicker) {
      bigBox.addEventListener('click', (e) => {
        // Only trigger if the click was on the box and NOT on a slot button
        if (!e.defaultPrevented) {
          bigPicker.click();
        }
      });
    }

    function getOrCreateInput(key) {
      let inp = document.getElementById('input_' + key);
      if (!inp) {
        inp = document.createElement('input');
        inp.type = 'file';
        inp.accept = '.pdf,.doc,.docx,.jpg,.jpeg,.png';
        inp.id = 'input_' + key;
        inp.className = 'hidden';
        inp.addEventListener('change', (ev) => {
          const f = ev.target.files[0];
          if (!f) return;
          const reader = new FileReader();
          reader.onload = (r) => {
            stored[key] = { name: f.name, url: r.target.result, type: f.type || guessTypeFromFilename(f.name), rawFile: f };
            persistEntry(key);
            renderSlots();
            updateBigUploadContentVisibility();
          };
          reader.readAsDataURL(f);
          ev.target.value = '';
        });
        document.body.appendChild(inp);
      }
      return inp;
    }

    function assignFileToKey(key, file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        stored[key] = { name: file.name, url: e.target.result, type: file.type || guessTypeFromFilename(file.name), rawFile: file };
        persistEntry(key);
        renderSlots();
        updateBigUploadContentVisibility();
      };
      reader.readAsDataURL(file);
    }

    function removeFile(key) {
      if (stored[key]) {
        delete stored[key];
        persistEntry(key);
      }
      renderSlots();
      updateBigUploadContentVisibility();
    }

    function renderSlots() {
      const container = document.getElementById('requiredFilesSlots');
      if (!container) return;
      container.innerHTML = '';
      // Show a slot only if there is an uploaded/persisted file for that requirement
      defs.forEach(def => {
        const entry = stored[def.key];
        if (!entry || !entry.name) return; // do not show empty slots
        const { wrap, nameEl, viewBtn, removeBtn } = createSlot(def);
        nameEl.textContent = entry.name;
        viewBtn.disabled = false;
        removeBtn.disabled = false;
        container.appendChild(wrap);
      });
    }

    function assignPendingToChecked() {
      if (!pendingFiles.length) return;
      const checkedDefs = defs.filter(d => document.getElementById(d.checkboxId) && document.getElementById(d.checkboxId).checked);
      for (let i = 0; i < checkedDefs.length && pendingFiles.length; i++) {
        const def = checkedDefs[i];
        if (!stored[def.key]) {
          const file = pendingFiles.shift();
          if (file) assignFileToKey(def.key, file);
        }
      }
    }

    // NEW: update inner prompt visibility (hide prompt when any uploaded slot exists)
    function updateBigUploadContentVisibility() {
      const content = document.getElementById('bigUploadContent');
      if (!content) return;
      const anyStored = defs.some(d => stored[d.key] && stored[d.key].name);
      if (anyStored) content.classList.add('hidden');
      else content.classList.remove('hidden');
    }

    const bigInput = document.getElementById('allDocuments');
    if (bigInput) {
      bigInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files || []).slice(0, 3);
        if (!files.length) return;
        // For each file, find first checked requirement that currently has no stored file
        files.forEach(file => {
          const targetDef = defs.find(d => {
            const chk = document.getElementById(d.checkboxId);
            return chk && chk.checked && !(stored[d.key] && stored[d.key].name);
          });
          if (targetDef) {
            assignFileToKey(targetDef.key, file);
          } else {
            // if no checked empty slot exists, queue as pending
            if (pendingFiles.length < 3) pendingFiles.push(file);
          }
        });
        e.target.value = '';
        renderSlots();
        updateBigUploadContentVisibility();
      });
    }

    defs.forEach(def => {
      const chk = document.getElementById(def.checkboxId);
      if (!chk) return;
      chk.addEventListener('change', () => {
        const checked = defs.filter(d => document.getElementById(d.checkboxId) && document.getElementById(d.checkboxId).checked);
        if (checked.length > 3) {
          chk.checked = false;
          alert('You can upload up to 3 required documents.');
          return;
        }
        // when a box is checked try to assign any pending files to newly available checked slots
        assignPendingToChecked();
        // do not render empty slots — only render when files exist
        renderSlots();
        updateBigUploadContentVisibility();
      });
    });

    // init
    loadPersisted();
    // do NOT auto-check checkboxes — keep them as user left them
    // show persisted slots if any
    document.addEventListener('DOMContentLoaded', () => {
      renderSlots();
      assignPendingToChecked();
      updateBigUploadContentVisibility();
    });

    // expose helper for form submit
    window.getRequiredUploads = function () {
      const out = {};
      defs.forEach(d => { out[d.key] = stored[d.key] ? stored[d.key].rawFile || stored[d.key] : undefined; });
      out._pending = pendingFiles.slice();
      return out;
    };
  })();
</script>

<script>
// Add modal open/close helpers (uses your existing #fileModal / #modalContent / #closeModalBtn)
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('fileModal');
  const modalContent = document.getElementById('modalContent');
  const closeBtn = document.getElementById('closeModalBtn');

  window.openModal = function (url, ext) {
    if (!modal || !modalContent) return;
    modal.classList.remove('hidden');
    modalContent.innerHTML = '';

    const imageExts = ['jpg','jpeg','png','gif','webp','bmp'];
    if (imageExts.includes(ext)) {
      modalContent.innerHTML = `<img src="${url}" class="max-h-[80vh] mx-auto rounded-lg">`;
    } else if (ext === 'pdf') {
      modalContent.innerHTML = `<iframe src="${url}" class="w-full h-[80vh] rounded-lg border-0"></iframe>`;
    } else {
      modalContent.innerHTML = `<p class="text-gray-700 text-center">This file type cannot be previewed.<br>(Hindi maaaring i-preview ang file na ito.)</p>`;
    }
  };

  function closeModalLocal() {
    if (!modal || !modalContent) return;
    modal.classList.add('hidden');
    modalContent.innerHTML = '';
  }

  if (closeBtn) closeBtn.addEventListener('click', (e) => { e.preventDefault(); closeModalLocal(); });
  if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) closeModalLocal(); });
});
</script>

    <!-- 🔹 Modal (Shared for both uploads) -->
    <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
    <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
        <button id="closeModalBtn" type="button" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
        <div id="modalContent" class="p-2 text-center"></div>
    </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Ensure modals are direct children of <body> and forced to full-viewport fixed
  ['fileModal','imageModal','pdfModal'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    // Escape any transformed/stacked parent by moving to body
    if (el.parentElement !== document.body) document.body.appendChild(el);
    // Force full-screen fixed placement and very high z-index
    el.style.position = 'fixed';
    el.style.top = '0';
    el.style.left = '0';
    el.style.width = '100%';
    el.style.height = '100%';
    el.style.inset = '0';
    el.style.zIndex = '100000';
  });

  // optional: lock body scroll when any modal is visible
  function lockBodyLock(visible) { document.body.style.overflow = visible ? 'hidden' : ''; }
  // hook your modal open/close if needed (example when using openModal/closeModalLocal)
  // e.g. wrap openModal to call lockBodyLock(true) and close handlers to call lockBodyLock(false)
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('autofillPersonal');
  if (!btn) return;

  btn.addEventListener('click', async function (e) {
    e.preventDefault();
    btn.disabled = true;
    const orig = btn.textContent;
    btn.textContent = 'Loading…';

    try {
      const res = await fetch('/db/get_profile.php', { credentials: 'same-origin' });
      const json = await res.json();
      if (!json || !json.success || !json.user) throw new Error(json && json.error ? json.error : 'No profile returned');

      const u = json.user || {};

      // helper to pick first existing key variant
      const pick = (obj, keys) => {
        for (const k of keys) {
          if (obj[k] !== undefined && obj[k] !== null && String(obj[k]).trim() !== '') return obj[k];
        }
        return '';
      };

      // map server keys to form fields
      const fieldMap = {
        firstName: ['FIRST_NAME', 'first_name', 'firstName'],
        lastName:  ['LAST_NAME', 'last_name', 'lastName'],
        email:     ['EMAIL', 'email', 'EMAIL_ADDRESS'],
        age:       ['AGE', 'age'],
        phone:     ['CONTACT_NUMBER', 'contact_number', 'contactNumber', 'PHONE_NUMBER'],
        address:   ['ADDRESS', 'address']
      };

      const setField = (name, value) => {
        const byName = document.querySelector(`[name="${name}"]`);
        const byId   = document.getElementById(name);
        if (byName) byName.value = value;
        else if (byId) byId.value = value;
      };

      setField('firstName', pick(u, fieldMap.firstName));
      setField('lastName',  pick(u, fieldMap.lastName));
      setField('email',     pick(u, fieldMap.email));
      setField('age',       pick(u, fieldMap.age));
      setField('phone',     pick(u, fieldMap.phone));
      setField('address',   pick(u, fieldMap.address));

    } catch (err) {
      console.error('Autofill failed', err);
      alert('Could not load profile. Please make sure you are logged in.');
    } finally {
      btn.disabled = false;
      btn.textContent = orig;
    }
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // job_id from the URL
    const jobId = {!! json_encode($job_id) !!};
    // server-side lookup result (if found) — will be null if not found
    const serverJob = {!! json_encode($job) !!};

    // If the server already resolved the job, render it immediately and skip client fetch.
    if (serverJob && Object.keys(serverJob).length) {
        try { fill(serverJob); } catch (e) { console.error(e); }
        return;
    }

    if (!jobId) return;

    const payload = { user_id: localStorage.getItem('user_id') || '' };
    fetch('/db/get-jobs.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(json => {
        if (!json || !json.success || !Array.isArray(json.jobs)) {
            console.warn('get-jobs returned no jobs or failed');
            return;
        }
        // find by id (string/int compatible)
        let job = json.jobs.find(j => String(j.id) === String(jobId));
        if (!job) {
            // legacy fallback: treat jobId as numeric index into array
            const idx = parseInt(jobId, 10);
            if (!Number.isNaN(idx) && json.jobs[idx]) {
                job = json.jobs[idx];
            }
        }
        if (!job) {
            console.warn('Job not found for id:', jobId);
            return;
        }
        fill(job);
    })
    .catch(err => console.error('Failed to load job from Oracle:', err));

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function fill(job) {
        if (!job) return;
        const titleEl = document.getElementById('jobTitle');
        const companyEl = document.getElementById('jobCompany');
        const locationEl = document.getElementById('jobLocation');
        const descEl = document.getElementById('jobDescription');
        const logoEl = document.getElementById('jobLogo');

        if (titleEl) titleEl.textContent = job.job_role || job.job_title || job.title || 'Job Title';
        if (companyEl) companyEl.textContent = job.company_name || job.company || '';
        if (locationEl) locationEl.textContent = job.address || job.location || '';
        if (descEl) descEl.innerHTML = escapeHtml(job.description || job.job_description || '').replace(/\n/g, '<br>');

        // choose logo: prefer data URI or full URL
        const logoCandidates = [job.logo, job.logo_url, job.company_logo, job.company_image, job.logo_src];
        let logo = logoCandidates.find(x => x && String(x).trim() !== '');
        if (logo && typeof logo === 'string') {
            if (!/^data:/.test(logo) && !/^https?:\/\//i.test(logo)) {
                if (/^[A-Za-z0-9+/=]+$/.test(logo) && logo.length > 100) {
                    logo = 'data:image/png;base64,' + logo;
                } else {
                    logo = null;
                }
            }
        } else {
            logo = null;
        }

        if (logo) {
            logoEl.src = logo;
        } else {
            logoEl.src = "https://via.placeholder.com/150?text=Logo";
        }
        logoEl.onerror = function () { this.src = "https://via.placeholder.com/150?text=Logo"; };
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // attach to the review link (preserves existing href with job_id)
  const toReview = document.querySelector('a[href^="/job-application-review1"]');
  if (!toReview) return;

  toReview.addEventListener('click', function (e) {
    e.preventDefault();

    // Collect current form values (names used in this page)
    const data = {
      firstName: (document.querySelector('[name="firstName"]') || {}).value || '',
      lastName:  (document.querySelector('[name="lastName"]')  || {}).value || '',
      email:     (document.querySelector('[name="email"]')     || {}).value || '',
      age:       (document.querySelector('[name="age"]')       || {}).value || '',
      phone:     (document.querySelector('[name="phone"]')     || {}).value || '',
      address:   (document.querySelector('[name="address"]')   || {}).value || '',
      // optionally include other fields you may need
      saved_at: new Date().toISOString()
    };

    try {
      // Gather any persisted required-document uploads stored using LS_PREFIX 'jobreq_'
      const uploads = [];
      try {
        const prefix = 'jobreq_';
        for (let i = 0; i < localStorage.length; i++) {
          const key = localStorage.key(i);
          if (!key || !key.startsWith(prefix)) continue;
          // expected keys like jobreq_medical_name / jobreq_medical_data / jobreq_medical_type
          const parts = key.slice(prefix.length).split('_'); // e.g. ['medical','name']
          if (parts.length < 2) continue;
          const field = parts[0]; // e.g. medical
          // read name/data/type consistently
          const name = localStorage.getItem(prefix + field + '_name') || null;
          const dataUrl = localStorage.getItem(prefix + field + '_data') || null;
          const type = localStorage.getItem(prefix + field + '_type') || null;
          // add once per field if name present
          if (name && (dataUrl || type)) {
            // avoid duplicates
            if (!uploads.find(u => u.key === field)) {
              uploads.push({ key: field, name: name, type: type || '', data: dataUrl || '' });
            }
          }
        }
      } catch (err) {
        console.warn('could not read persisted uploads', err);
      }

      // include uploads in the saved step payload so review page can show them
      data.uploadedFiles = uploads;

      const json = JSON.stringify(data);
      sessionStorage.setItem('jobApplication_step1', json);
      localStorage.setItem('jobApplication_step1', json);
    } catch (err) {
      console.warn('Could not persist application step1', err);
    }

    // navigate to the review URL that the anchor already points to
    // (use href so job_id query param is preserved)
    const href = toReview.getAttribute('href');
    window.location.href = href;
  });
});
</script>
    @endsection
