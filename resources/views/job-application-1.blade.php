@extends('layouts.includes')

@section('content')
    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">


 <!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/jobdetails"
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
            // reuse job-details CSV parsing to show the selected job on the application page
            $csv_path = public_path('postings.csv');
            $job = null;
            $job_id = request('job_id');
            if ($job_id !== null && file_exists($csv_path)) {
                if (($handle = fopen($csv_path, 'r')) !== false) {
                    $header = fgetcsv($handle);
                    if ($header === false) {
                        fclose($handle);
                    }
                    $cols = array_map(
                        function ($h) {
                            return trim($h);
                        },
                        $header ?: [],
                    );
                    $numCols = count($cols);
                    $i = 0;
                    $maxRows = 5000;
                    while (($row = fgetcsv($handle)) !== false) {
                        if ($numCols > 0) {
                            if (count($row) < $numCols) {
                                $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
                            } elseif (count($row) > $numCols) {
                                $row = array_slice($row, 0, $numCols);
                            }
                            if (count($row) !== $numCols) {
                                $i++;
                                continue;
                            }
                        }
                        if ($i >= $maxRows) {
                            break;
                        }
                        if ($i == intval($job_id)) {
                            $assoc = $numCols ? (array_combine($cols, $row) ?: []) : [];
                            $job = [
                                'title' => $assoc['Title'] ?? ($assoc['jobpost'] ?? ''),
                                'company' => $assoc['Company'] ?? '',
                                'location' => $assoc['Location'] ?? '',
                                'job_description' => $assoc['JobDescription'] ?? ($assoc['JobRequirment'] ?? ''),
                            ];
                            break;
                        }
                        $i++;
                    }
                    fclose($handle);
                }
            }
        @endphp

        <div
            class="bg-[#F0F9FF] border-[3px] border-[#1E40AF] rounded-3xl p-10 flex flex-col sm:flex-row items-center gap-10 shadow-lg">
            <!-- Company Logo / Placeholder -->
            <div class="flex items-center justify-center">
                @if (!empty($company->logo))
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                        class="w-36 h-36 rounded-2xl border-2 border-gray-300 object-cover">
                @else
                    <div class="w-36 h-36 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                        <i class="ri-building-4-fill text-[#1E40AF] text-7xl"></i>
                    </div>
                @endif
            </div>

            <!-- Job Info -->
            <div class="flex flex-col justify-center leading-snug text-center sm:text-left max-w-3xl">
                <h3 class="text-4xl font-extrabold text-black">{{ $job['title'] ?? 'Job Title' }}</h3>
                <p class="text-gray-700 text-2xl font-semibold mt-2">{{ $job['company'] ?? 'Company Name' }}</p>
                <p class="text-gray-600 text-xl mt-1">{{ $job['location'] ?? 'Location' }}</p>
                <p class="text-gray-600 text-lg mt-3 leading-relaxed">
                    {{ Str::limit($job['job_description'] ?? 'Description', 200) }}</p>
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
<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
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
</div>

<!-- ================= REQUIRED DOCUMENTS (RESUME / CV) ================= -->
<div class="border-2 border-blue-200 bg-white shadow-lg rounded-3xl p-10 mb-10">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 border-b-4 border-blue-200 pb-3">
    <h3 class="text-3xl font-bold text-[#1E40AF] mb-4 sm:mb-0">Required Documents (Resume or CV)</h3>
  </div>

  <p class="text-gray-700 text-xl mb-6">
    Please upload your Resume or CV in PDF, DOC, or DOCX format. Make sure your file is complete and readable.
  </p>

  <div class="border-2 border-dashed border-[#1E40AF] rounded-2xl p-8 text-center bg-[#F0F9FF] hover:bg-blue-50 transition cursor-pointer"
    onclick="document.getElementById('resumeUpload').click()">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#1E40AF] mx-auto mb-4" fill="none"
      viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M7 16V4a2 2 0 012-2h6a2 2 0 012 2v12m-6 4l-4-4m4 4l4-4m-4 4V10" />
    </svg>
    <p class="text-2xl font-semibold text-[#1E40AF]">Click here to upload your Resume or CV</p>
    <p class="text-gray-600 text-lg mt-2">(Accepted formats: PDF, DOC, DOCX — Max size: 5MB)</p>
  </div>
</div>


                <!-- Hidden File Input -->
                <input id="resumeUpload" type="file" accept=".pdf,.doc,.docx" class="hidden"
                    onchange="handleResumeUpload(event)" />

                <!-- File Preview List -->
                <div id="resumePreview" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"></div>
            </div>

            <!-- ================= SUBMIT BUTTON ================= -->
            <div class="flex justify-center mt-6">
                <button type="button"
                    class="bg-[#1E40AF] text-white text-3xl font-bold px-16 py-6 rounded-2xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition">
                    Review & Submit
                </button>
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

        <script>
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
                const jobId = "{{ request('job_id') ?? '' }}";

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

        <!-- Ensure global Firebase config is present and autofill profile for signed-in users -->
  {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
        <script type="module">
            import {
                getUserProfile,
                isSignedIn
            } from "{{ asset('js/job-application-firebase.js') }}";

            (async function() {
                try {
                    console.debug('job-application-1: waiting for auth resolution (7s)');
                    const signed = await isSignedIn(7000);
                    console.debug('job-application-1: isSignedIn ->', signed);
                    if (!signed) {
                        // Not signed in — redirect to login preserving return URL
                        const current = window.location.pathname + window.location.search;
                        window.location.href = 'login?redirect=' + encodeURIComponent(current);
                        return;
                    }
                    const profile = await getUserProfile();
                    if (profile) {
                        if (profile.first_name) document.getElementById('first_name').value = profile.first_name;
                        if (profile.last_name) document.getElementById('last_name').value = profile.last_name;
                        if (profile.email) document.getElementById('email').value = profile.email;
                        if (profile.phone) document.getElementById('phone_number').value = profile.phone;
                        if (profile.address) document.getElementById('address').value = profile.address;
                    }
                } catch (err) {
                    console.warn('autofill/profile init failed', err);
                }
            })();
        </script>

        <!-- Ensure global Firebase config is present and autofill profile for logged-in users -->
  {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
        <script type="module">
            import {
                getUserProfile,
                isSignedIn
            } from "{{ asset('js/job-application-firebase.js') }}";

            async function autofillProfile() {
                try {
                    const profile = await getUserProfile();
                    if (!profile) return;
                    const personal = profile.personalInfo || {};
                    const school = profile.schoolWorkInfo || {};
                    const guardian = profile.guardianInfo || {};
                    const skills = profile.skills || {};
                    const work = profile.workExperience || {};

                    if (personal.first) document.getElementById('first_name').value = personal.first;
                    if (personal.last) document.getElementById('last_name').value = personal.last;
                    if (personal.email) document.getElementById('email').value = personal.email;
                    if (guardian.guardian_phone) document.getElementById('phone_number').value = guardian.guardian_phone;
                    if (school.school_name) document.getElementById('address').value = school.school_name;
                    try {
                        const we = JSON.parse(work.work_experiences || '[]');
                        if (we && we.length) {
                            const first = we[0];
                            if (first.title) document.getElementById('job_title').value = first.title;
                            if (first.company) document.getElementById('company_employer').value = first.company;
                            if (first.description) document.getElementById('job_description').value = first.description;
                        }
                    } catch (e) {}
                } catch (err) {
                    console.warn('Autofill failed', err);
                }
            }

            (async function() {
                try {
                    const signed = await isSignedIn(3000);
                    if (!signed) {
                        const current = window.location.pathname + window.location.search;
                        window.location.href = 'login?redirect=' + encodeURIComponent(current);
                        return;
                    }
                    document.addEventListener('DOMContentLoaded', autofillProfile);
                } catch (err) {
                    console.error('Auth check failed', err);
                    document.addEventListener('DOMContentLoaded', autofillProfile);
                }
            })();
        </script>
    @endsection
