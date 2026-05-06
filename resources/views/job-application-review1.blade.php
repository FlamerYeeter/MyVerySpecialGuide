@extends('layouts.includes')

@section('content')
  <!-- Icon link -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

  <style>
    a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
      outline: 2px solid #2563eb !important;
      outline-offset: 2px !important;
    }
    .form-section {
      transition: box-shadow 0.3s ease;
    }
    .form-section:focus-within {
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
  </style>


    <!-- Hero Section -->
    <section class="bg-sky-50 py-16 sm:py-20 border-b border-sky-100" role="region" aria-labelledby="review-heading">
      <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="text-center mb-10">
          <p class="text-base font-bold uppercase tracking-widest text-blue-700 mb-2">Application Review</p>
          <h1 id="review-heading" class="text-4xl sm:text-5xl font-extrabold text-slate-900">Review Your Application</h1>
        </div>

        <!-- JOB INFO CARD -->
        <div class="rounded-3xl border border-sky-200 bg-white shadow-sm p-8 sm:p-10">
          <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-8 text-center">You are applying for</h2>
          <div class="grid gap-8 lg:grid-cols-[1fr_2fr] lg:items-center">
            <!-- Company Logo -->
            <div class="flex justify-center">
              <img id="jobLogo" src="https://via.placeholder.com/150?text=Logo" alt="Company Logo"
                class="w-40 h-40 rounded-2xl border-2 border-sky-200 object-cover shadow-md">
            </div>
            <!-- Job Info -->
            <div class="space-y-4">
              <h3 id="jobTitle" class="text-3xl sm:text-4xl font-bold text-slate-900">Job Role</h3>
              <p id="jobCompany" class="text-xl font-semibold text-slate-700">Company Name</p>
              <p id="jobLocation" class="flex items-center gap-2 text-lg text-slate-600">
                <img src="https://img.icons8.com/color/24/marker.png" alt="" aria-hidden="true" class="w-5 h-5">
                Location
              </p>
              <p id="jobDescription" class="text-base text-slate-600 leading-relaxed">Description</p>
            </div>
          </div>
        </div>
    </section>
<!-- Back Button -->
<div class="bg-sky-50 py-6">
  <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 flex justify-center">

    <a href="/job-application-1"
      class="inline-flex items-center gap-3 rounded-full border-2 border-blue-200 bg-white px-6 py-3 text-blue-700 font-semibold shadow-sm transition hover:bg-blue-50 hover:border-blue-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">

      <!-- Icons8 Back Icon -->
      <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png"
        alt=""
        aria-hidden="true"
        class="w-5 h-5">

      <span>Back to application</span>
    </a>

  </div>
      </div>


    <!-- Review Content -->
    <section class="bg-white py-12 sm:py-16">
      <div class="max-w-6xl mx-auto px-6 sm:px-10 lg:px-12 space-y-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">
            Review Your Information
          </h2>
          <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">
            Please review all information carefully before submitting. You can return to the application to make changes.
          </p>
        </div>

        <!-- PERSONAL INFORMATION -->
        <div class="form-section border border-sky-200 bg-white rounded-2xl p-6 sm:p-8 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">
              Personal Information
            </h3>
            <a href="/job-application-1{{ request('job_id') ? ('?job_id=' . urlencode(request('job_id'))) : '' }}"
              class="text-sm font-semibold bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
              Edit
            </a>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-base">
            <div>
              <p class="text-sm font-semibold text-slate-700 mb-1">First Name</p>
              <p class="text-slate-900" id="rev-firstname">—</p>
            </div>
            <div>
              <p class="text-sm font-semibold text-slate-700 mb-1">Last Name</p>
              <p class="text-slate-900" id="rev-lastname">—</p>
            </div>
            <div class="sm:col-span-2">
              <p class="text-sm font-semibold text-slate-700 mb-1">Email Address</p>
              <p class="text-slate-900" id="rev-email">—</p>
            </div>
            <div>
              <p class="text-sm font-semibold text-slate-700 mb-1">Date of Birth</p>
              <p class="text-slate-900" id="rev-birthdate">—</p>
            </div>
            <div>
              <p class="text-sm font-semibold text-slate-700 mb-1">Phone Number</p>
              <p class="text-slate-900" id="rev-phone">—</p>
            </div>
            <div class="sm:col-span-2">
              <p class="text-sm font-semibold text-slate-700 mb-1">Complete Address</p>
              <p class="text-slate-900" id="rev-address">—</p>
            </div>
          </div>
        </div>

            <!-- EDUCATION + CERTIFICATIONS -->
            {{-- <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('education')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Education & Certifications
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-lg">
                    <p><span class="font-semibold">Highest Attainment:</span> <span id="rev-education-level"></span></p>
                    <p><span class="font-semibold">School Name:</span> <span id="rev-school"></span></p>
                    <p><span class="font-semibold">Course/Program:</span> <span id="rev-course"></span></p>
                    <p><span class="font-semibold">Year Graduated:</span> <span id="rev-year"></span></p>
                </div>

                <div class="mt-6">
                    <h4 class="text-2xl font-semibold text-[#1E40AF] mb-2">Certifications</h4>
                    <ul id="rev-cert-list" class="list-disc list-inside text-lg space-y-1"></ul>
                </div>
            </div>

            <!-- SKILLS -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('skills')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Skills</h3>
                <div id="rev-skills-container" class="flex flex-wrap gap-3 text-lg"></div>
            </div>

            <!-- WORK EXPERIENCE -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('work')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Work Experience</h3>
                <div id="rev-work-container" class="space-y-6 text-lg"></div>
            </div>--}}

        <!-- REQUIRED DOCUMENTS -->
        <div class="form-section border border-sky-200 bg-white rounded-2xl p-6 sm:p-8 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">
              Required Documents
            </h3>
            <a href="/job-application-1{{ request('job_id') ? ('?job_id=' . urlencode(request('job_id'))) : '' }}"
              class="text-sm font-semibold bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
              Edit
            </a>
          </div>

          <!-- Rendered slots (same UI as application1) -->
          <div id="rev-required-slots" class="space-y-4"></div>

          <!-- Fallback list (kept for compatibility) -->
          <ul id="rev-doc-list" class="list-disc list-inside text-base space-y-2 hidden text-slate-900"></ul>
        </div>

        <!-- File preview modal for review page -->
        <div id="reviewFileModal" class="hidden fixed inset-0 z-[2000] flex items-center justify-center bg-black/80 p-4">
          <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full overflow-hidden relative">
            <button id="reviewFileModalClose" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl" aria-label="Close modal">✕</button>
            <div id="reviewFileModalContent" class="p-4 min-h-[320px] flex items-center justify-center"></div>
          </div>
        </div>

        <!-- FINAL CONFIRMATION INFO BOX -->
        <div class="border border-sky-200 bg-sky-50 rounded-2xl p-8 shadow-sm">
          <h3 class="text-2xl font-bold text-slate-900 mb-4">Final Confirmation</h3>
          <p class="text-base text-slate-700 mb-6">
            By submitting this application, you confirm that all information provided is accurate and complete.
          </p>
          <label class="flex items-center gap-3">
            <input type="checkbox" id="confirmCheck" class="w-5 h-5 border border-slate-300 rounded accent-blue-600" aria-required="true">
            <span class="text-base text-slate-900">I confirm that all information provided is accurate and I agree to the <a href="#" class="underline text-blue-700 hover:text-blue-800">terms and conditions</a>.</span>
          </label>
        </div>

        <!-- FINAL SUBMIT BUTTON -->
        <div class="flex justify-center pt-8">
          <button type="button" id="reviewSubmitBtn"
            class="inline-block px-10 py-4 bg-blue-700 text-white font-semibold rounded-xl hover:bg-blue-800 transition shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300 disabled:opacity-50 disabled:cursor-not-allowed"
            disabled>
            Submit Application
          </button>
        </div>
      </div>
    </section>

    {{-- <!-- BACK TO TOP BUTTON -->
    <button id="backToTopBtn"
      class="hidden fixed bottom-8 right-8 bg-blue-700 text-white p-4 rounded-full shadow-lg hover:bg-blue-800 transition transform hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300"
      onclick="scrollToTop()" aria-label="Back to top">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
      </svg>
    </button> --}}

<script>
    // Enable submit button only when checkbox is checked
    const confirmCheck = document.getElementById('confirmCheck');
    const submitBtn = document.getElementById('reviewSubmitBtn');

    confirmCheck.addEventListener('change', () => {
        submitBtn.disabled = !confirmCheck.checked;
    });

    // Show/hide back to top button on scroll
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

    // helper: convert dataURL to Blob
    function dataURLtoBlob(dataurl) {
        if (!dataurl || dataurl.indexOf('data:') !== 0) return null;
        const arr = dataurl.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while (n--) u8arr[n] = bstr.charCodeAt(n);
        return new Blob([u8arr], { type: mime });
    }

    submitBtn.addEventListener('click', async (ev) => {
        ev.preventDefault();

        if (!confirmCheck.checked) return;

        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Submitting…';

        try {
            // gather saved payload (step1)
            let saved = null;
            try {
                saved = JSON.parse(sessionStorage.getItem('jobApplication_step1') || localStorage.getItem('jobApplication_step1') || 'null');
            } catch (e) { saved = null; }

            // collect persisted required uploads (localStorage prefix used across pages)
            const uploads = {};
            try {
                const prefix = 'jobreq_';
                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    if (!key || !key.startsWith(prefix)) continue;
                    const parts = key.slice(prefix.length).split('_'); // e.g. ['medical','name']
                    if (parts.length < 2) continue;
                    const field = parts[0]; // medical || resume || pwd
                    const suffix = parts.slice(1).join('_'); // name | data | type
                    uploads[field] = uploads[field] || {};
                    uploads[field][suffix] = localStorage.getItem(prefix + field + '_' + suffix);
                }
            } catch (e) { /* ignore */ }

            const fd = new FormData();

            // Job & user identifiers
            fd.append('job_id', typeof jobId !== 'undefined' ? jobId : '');
            // attempt to send logged-in user id (if available in localStorage)
            fd.append('guardian_id', localStorage.getItem('user_id') || '');

            // basic personal fields (fallbacks to various key names)
            const firstName = (saved && (saved.firstName || saved.first_name || saved.FIRST_NAME)) || document.getElementById('rev-firstname')?.textContent || '';
            const lastName = (saved && (saved.lastName || saved.last_name || saved.LAST_NAME)) || document.getElementById('rev-lastname')?.textContent || '';
            const email = (saved && (saved.email || saved.EMAIL || saved.email_address)) || document.getElementById('rev-email')?.textContent || '';
            const date_of_birth = (saved && (saved.date_of_birth || saved.dateOfBirth || saved.dob)) || document.getElementById('rev-birthdate')?.textContent || '';
            const phone = (saved && (saved.phone || saved.phone_number || saved.PHONE_NUMBER)) || document.getElementById('rev-phone')?.textContent || '';
            const address = (saved && (saved.address || saved.ADDRESS || saved.complete_address)) || document.getElementById('rev-address')?.textContent || '';

            fd.append('first_name', firstName);
            fd.append('last_name', lastName);
            fd.append('email', email);
            if (date_of_birth) fd.append('date_of_birth', date_of_birth);
            fd.append('phone_number', phone);
            fd.append('complete_address', address);

            // attach files — prefer persisted localStorage jobreq_* entries, else check saved.uploadedFiles
            const attachFromLocalStorage = (key, formKey) => {
                if (!uploads[key] || !uploads[key].data) return false;
                const blob = dataURLtoBlob(uploads[key].data);
                if (!blob) return false;
                const filename = uploads[key].name || (key + '.bin');
                fd.append(formKey, blob, filename);
                return true;
            };

            const attachFromSavedArray = (nameHint, formKey) => {
                if (!saved || !Array.isArray(saved.uploadedFiles)) return false;
                for (const it of saved.uploadedFiles) {
                    // file objects may be { key, name, data, type } or plain strings
                    if (typeof it === 'string') continue;
                    const keyMatch = (it.key || '').toLowerCase();
                    const nameLower = (it.name || it.label || '').toLowerCase();
                    if (keyMatch.includes(nameHint) || nameLower.includes(nameHint) || (it.name && it.name.toLowerCase().includes(nameHint))) {
                        if (it.data) {
                            const blob = dataURLtoBlob(it.data);
                            if (blob) {
                                fd.append(formKey, blob, it.name || (nameHint + '.bin'));
                                return true;
                            }
                        }
                    }
                }
                return false;
            };

            // medical -> MEDICAL_CERTIFICATE
            if (!attachFromLocalStorage('medical', 'medical')) attachFromSavedArray('medical', 'medical');
            // resume -> RESUME_CV
            if (!attachFromLocalStorage('resume', 'resume')) attachFromSavedArray('resume', 'resume');
            // pwd -> PWD_ID
            if (!attachFromLocalStorage('pwd', 'pwd')) attachFromSavedArray('pwd', 'pwd');

            // send to server endpoint (public/db/submit-application.php)
            const res = await fetch('/db/submit-application.php', {
                method: 'POST',
                body: fd,
                credentials: 'same-origin'
            });

            const json = await res.json();
            if (json && json.success) {
                alert('Application submitted successfully!');
                // Optionally clear persisted step1/localStorage jobreq entries
                try {
                    sessionStorage.removeItem('jobApplication_step1');
                    localStorage.removeItem('jobApplication_step1');
                    ['medical','resume','pwd'].forEach(k => {
                        localStorage.removeItem('jobreq_' + k + '_name');
                        localStorage.removeItem('jobreq_' + k + '_data');
                        localStorage.removeItem('jobreq_' + k + '_type');
                    });
                } catch (e) {}
                // redirect or update UI as needed
                    // show confirmation modal asking whether to apply to another job
                    showPostSubmitModal();
                    // if server provided a redirect, keep it as a fallback
                    if (json.redirect) window.__postSubmitFallbackRedirect = json.redirect;
            } else {
                throw new Error((json && json.error) ? json.error : 'Submission failed');
            }
        } catch (err) {
            console.error(err);
            alert('Failed to submit application: ' + (err.message || err));
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
</script>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // inject server values safely
    const serverJob = {!! json_encode($job ?? null, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!};
    const jobId = {!! json_encode($job_id ?? '', JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!};

    function setText(id, v) {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = (v === undefined || v === null || String(v).trim() === '') ? '' : String(v);
    }

    function loadSavedStep1() {
        const keys = ['jobApplication_step1','jobApplication_step_1','jobApplication-step1','step1','application_step1'];
        for (const k of keys) {
            try {
                const raw = sessionStorage.getItem(k) || localStorage.getItem(k);
                if (!raw) continue;
                const obj = JSON.parse(raw);
                if (obj && typeof obj === 'object') return obj;
            } catch (e) { /* ignore */ }
        }
        // fallback: gather individual keys
        const candidates = ['firstName','lastName','email','age','phone','address','first_name','last_name','email_address','phone_number'];
        const out = {};
        let found = false;
        for (const k of candidates) {
            try {
                const v = sessionStorage.getItem(k) || localStorage.getItem(k);
                if (v !== null && v !== undefined) { out[k] = v; found = true; }
            } catch (e) {}
        }
        return found ? out : null;
    }

    function pick(obj, keys) {
        if (!obj) return '';
        for (const k of keys) {
            if (Object.prototype.hasOwnProperty.call(obj, k) && obj[k] !== undefined && obj[k] !== null && String(obj[k]).trim() !== '') return obj[k];
        }
        return '';
    }

    // populate fields
    const saved = loadSavedStep1();
    if (saved) {
        setText('rev-firstname', pick(saved, ['firstName','first_name','FIRST_NAME']));
        setText('rev-lastname',  pick(saved, ['lastName','last_name','LAST_NAME']));
        setText('rev-email',     pick(saved, ['email','EMAIL','email_address','EMAIL_ADDRESS']));
        setText('rev-birthdate', pick(saved, ['date_of_birth','dateOfBirth','dob','birthdate','birth_date']));
        setText('rev-phone',     pick(saved, ['phone','phone_number','CONTACT_NUMBER','contact_number']));
        setText('rev-address',   pick(saved, ['address','ADDRESS','complete_address']));
    }

    // minimal doc list renderer (safe)
    function populateDocs(obj) {
        const listEl = document.getElementById('rev-doc-list');
        if (!listEl) return;
        listEl.innerHTML = '';
        const docs = (obj && Array.isArray(obj.uploadedFiles) ? obj.uploadedFiles.slice() : []);
        if (docs.length === 0) {
            const li = document.createElement('li'); li.textContent = 'No documents uploaded'; listEl.appendChild(li); return;
        }
        docs.forEach(d => {
            const li = document.createElement('li');
            li.textContent = (typeof d === 'string') ? d : (d.name || 'Uploaded file');
            listEl.appendChild(li);
        });
    }

    // job card rendering
    function normalizeJob(j) {
        if (!j) return null;
        return {
            role: j.job_role || j.job_title || j.title || '',
            company: j.company_name || j.company || '',
            address: j.address || j.location || '',
            description: j.description || j.job_description || '',
            logo: j.logo || j.company_image || j.company_logo || null
        };
    }
    function renderJob(j) {
        if (!j) return;
        const nj = normalizeJob(j);
        setText('jobTitle', nj.role || 'Job Title');
        setText('jobCompany', nj.company || '');
        setText('jobLocation', nj.address || '');
        const desc = document.getElementById('jobDescription'); if (desc) desc.textContent = nj.description || '';
        const logo = document.getElementById('jobLogo');
        if (logo) {
            let src = nj.logo || '';
            if (src && typeof src === 'string' && !/^data:|^https?:\/\//i.test(src)) {
                if (/^[A-Za-z0-9+/=]+$/.test(src) && src.length > 100) src = 'data:image/png;base64,' + src;
                else src = '';
            }
            logo.src = src || 'https://via.placeholder.com/150?text=Logo';
            logo.onerror = () => { logo.src = 'https://via.placeholder.com/150?text=Logo'; };
        }
    }

    if (serverJob) renderJob(serverJob);
    else if (saved) {
        // attempt approximate job from saved payload
        const approx = { job_role: pick(saved, ['job_title','jobTitle']), company_name: pick(saved, ['company','company_employer']), address: pick(saved, ['address','location']), description: pick(saved, ['job_description','description']) };
        if (approx.job_role || approx.company_name) renderJob(approx);
    }

    populateDocs(saved || serverJob || {});

    // signal other scripts
    window.dispatchEvent(new CustomEvent('jobReview:storageLoaded'));
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const SLOT_CONTAINER_ID = 'rev-required-slots';
    const LS_PREFIX = 'jobreq_';

    function readSavedPayload() {
        try {
            const raw = sessionStorage.getItem('jobApplication_step1') || localStorage.getItem('jobApplication_step1');
            if (raw) return JSON.parse(raw);
        } catch (e) {}
        return null;
    }

    function readPersistedSlotsFromLS() {
        const out = [];
        try {
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (!key || !key.startsWith(LS_PREFIX)) continue;
                const parts = key.slice(LS_PREFIX.length).split('_');
                const field = parts[0];
                const name = localStorage.getItem(LS_PREFIX + field + '_name');
                const data = localStorage.getItem(LS_PREFIX + field + '_data');
                const type = localStorage.getItem(LS_PREFIX + field + '_type') || '';
                if (name) out.push({ key: field, name: name, data: data || null, type: type });
            }
        } catch (e) {}
        return out;
    }

    function clearPersistedKey(key) {
        try {
            localStorage.removeItem(LS_PREFIX + key + '_name');
            localStorage.removeItem(LS_PREFIX + key + '_data');
            localStorage.removeItem(LS_PREFIX + key + '_type');
        } catch (e) {}
    }

    function openReviewModal(url, type) {
        const modal = document.getElementById('reviewFileModal');
        const content = document.getElementById('reviewFileModalContent');
        if (!modal || !content) return;
        content.innerHTML = '';
        if ((type && type.indexOf('image/') === 0) || (typeof url === 'string' && url.indexOf('data:image/') === 0)) {
            const img = document.createElement('img');
            img.src = url;
            img.className = 'max-h-[70vh] max-w-full rounded';
            content.appendChild(img);
        } else if ((type && type.indexOf('pdf') !== -1) || (typeof url === 'string' && url.slice(-4).toLowerCase() === '.pdf')) {
            const iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.className = 'w-full h-[70vh] border-0';
            content.appendChild(iframe);
        } else {
            const a = document.createElement('a');
            a.href = url;
            a.target = '_blank';
            a.rel = 'noopener noreferrer';
            a.textContent = 'Open file in new tab';
            a.className = 'text-blue-600 underline';
            content.appendChild(a);
        }
        modal.classList.remove('hidden');
    }

    const modalClose = document.getElementById('reviewFileModalClose');
    if (modalClose) modalClose.addEventListener('click', function () {
        const modal = document.getElementById('reviewFileModal');
        if (modal) modal.classList.add('hidden');
    });

    function createSlotNode(item) {
        // map keys to display labels
        const formatKeyLabel = (k) => {
            if (!k) return '';
            const key = String(k).toLowerCase();
            if (key === 'pwd') return 'PWD';
            if (key === 'medical') return 'Medical';
            if (key === 'resume') return 'Resume';
            return key.charAt(0).toUpperCase() + key.slice(1);
        };
        const wrap = document.createElement('div');
        wrap.className = 'required-slot flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm';

        const left = document.createElement('div');
        left.className = 'flex-1 min-w-0 text-center sm:text-left';

        const title = document.createElement('div');
        title.className = 'text-lg font-semibold text-gray-800';
        title.textContent = item.name;

        const subtitle = document.createElement('div');
        subtitle.className = 'text-sm text-gray-600 truncate';
        subtitle.textContent = formatKeyLabel(item.key || '');

        left.appendChild(title);
        left.appendChild(subtitle);

        const actions = document.createElement('div');
        actions.className = 'flex gap-2 items-center flex-none';

        const viewBtn = document.createElement('button');
        viewBtn.type = 'button';
        viewBtn.className = 'bg-gray-700 text-white text-sm px-3 py-1.5 rounded-md font-semibold hover:bg-gray-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300';
        viewBtn.textContent = 'View';
        viewBtn.disabled = !item.data;
        viewBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (!item.data) return;
            openReviewModal(item.data, item.type || '');
        });

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'bg-red-500 text-white text-sm px-3 py-1.5 rounded-md font-semibold hover:bg-red-600 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-300';
        removeBtn.textContent = 'Remove';
        removeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (item.key) {
                clearPersistedKey(item.key);
            }
            renderSlots();
        });

        actions.appendChild(viewBtn);
        actions.appendChild(removeBtn);

        wrap.appendChild(left);
        wrap.appendChild(actions);
        return wrap;
    }

    function renderSlots() {
        const container = document.getElementById(SLOT_CONTAINER_ID);
        if (!container) return;
        container.innerHTML = '';

        const payload = readSavedPayload();
        let docs = [];
        if (payload && Array.isArray(payload.uploadedFiles) && payload.uploadedFiles.length) {
            docs = payload.uploadedFiles.map(function (d) {
                if (typeof d === 'string') return { key: '', name: d, data: null, type: '' };
                return { key: d.key || d.name || '', name: d.name || d.label || 'Uploaded file', data: d.data || d.url || null, type: d.type || '' };
            });
        }

        if (docs.length === 0) {
            const persisted = readPersistedSlotsFromLS();
            docs = persisted;
        }

        if (!docs || docs.length === 0) {
            const p = document.createElement('p');
            p.className = 'text-gray-600';
            p.textContent = 'No documents uploaded';
            container.appendChild(p);
            return;
        }

        docs.forEach(function (it) {
            const node = createSlotNode(it);
            container.appendChild(node);
        });
    }

    renderSlots();
});
</script>

    </section>
    </div>
    <!-- Post-submit choice modal -->
    <div id="postSubmitModal" class="hidden fixed inset-0 z-[3000] flex items-center justify-center bg-black/80 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 relative">
            <button id="postSubmitModalClose" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">✕</button>
            <h3 class="text-2xl font-bold text-slate-900 mb-3">Application Submitted</h3>
            <p class="text-slate-700 text-base mb-6">Do you want to apply for another job?</p>
            <div class="flex justify-end gap-3">
                <button id="postSubmitNo" class="bg-slate-200 text-slate-900 px-4 py-2 rounded-lg font-semibold hover:bg-slate-300 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">No — View applications</button>
                <button id="postSubmitYes" class="bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">Yes — Browse jobs</button>
            </div>
        </div>
    </div>

    <script>
    // Show the post-submit modal and wire actions
    function showPostSubmitModal() {
        const modal = document.getElementById('postSubmitModal');
        if (!modal) return;
        modal.classList.remove('hidden');
        // focus the primary action for keyboard users
        setTimeout(() => {
            const yes = document.getElementById('postSubmitYes');
            if (yes) yes.focus();
        }, 10);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('postSubmitModal');
        const btnYes = document.getElementById('postSubmitYes');
        const btnNo = document.getElementById('postSubmitNo');
        const btnClose = document.getElementById('postSubmitModalClose');
        if (!modal) return;

        btnYes?.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = '/job-matches';
        });

        btnNo?.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = '/my-job-applications';
        });

        btnClose?.addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.add('hidden');
            // if server provided a fallback redirect, use it
            if (window.__postSubmitFallbackRedirect) window.location.href = window.__postSubmitFallbackRedirect;
        });

        // close when clicking backdrop
        modal.addEventListener('click', function (ev) {
            if (ev.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // close on Escape
        document.addEventListener('keydown', function (ev) {
            if (ev.key === 'Escape' && !modal.classList.contains('hidden')) modal.classList.add('hidden');
        });
    });
    </script>
@endsection
