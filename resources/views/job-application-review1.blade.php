@extends('layouts.includes')

@section('content')
    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

<!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/jobapplication1"
      class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back to Job Application</span>
    </a>
  </div>
</div>


    <!-- Applying For -->
    <section class="max-w-6xl mx-auto mt-14 px-6">
        <h2 class="text-4xl font-extrabold text-[#1E40AF] mb-10 text-center">You Are Applying For</h2>
        @php
            // safe access: use data_get to avoid errors when $job is null / not an array
            $job = $job ?? null;
            $jobTitle = data_get($job, 'title', 'Unknown Job');
            $jobCompany = data_get($job, 'company', 'Unknown Company');
            $jobAddress = data_get($job, 'location', 'Unknown Location');
            $jobType = data_get($job, 'type', 'Unknown Description');
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

    <section class="max-w-6xl mx-auto p-10 space-y-14">

        <!-- ================= REVIEW PAGE ================= -->
        <div class="mt-14">
            <h2 class="text-4xl font-bold text-[#1E40AF] text-center mb-10">Review Your Information</h2>
            <p class="text-gray-700 text-2xl mb-12 text-center leading-relaxed max-w-5xl mx-auto">
                Please review all information carefully before submitting. You can edit any section if needed.
            </p>

            <!-- PERSONAL INFORMATION -->
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative">
                <button onclick="editSection('personal')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-lg">
                    <p><span class="font-semibold">First Name:</span> <span id="rev-firstname"></span></p>
                    <p><span class="font-semibold">Last Name:</span> <span id="rev-lastname"></span></p>
                    <p class="sm:col-span-2"><span class="font-semibold">Email:</span> <span id="rev-email"></span></p>
                    <p><span class="font-semibold">Date of Birth:</span> <span id="rev-birthdate"></span></p>
                    <p><span class="font-semibold">Phone Number:</span> <span id="rev-phone"></span></p>
                    <p class="sm:col-span-2"><span class="font-semibold">Complete Address:</span> <span
                            id="rev-address"></span></p>
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
            <div id="" class="border-2 bg-white shadow-lg rounded-3xl p-10 relative mt-6">
                <button onclick="editSection('docs')"
                    class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-12 py-2 rounded-xl text-2xl font-semibold">Edit</button>
                <h3 class="text-3xl font-bold text-[#1E40AF] border-b-4 border-blue-200 pb-3 mb-8 text-center sm:text-left">
                    Required Documents</h3>

                <!-- Rendered slots (same UI as application1) -->
                <div id="rev-required-slots" class="space-y-4"></div>

                <!-- Fallback list (kept for compatibility) -->
                <ul id="rev-doc-list" class="list-disc list-inside text-lg space-y-1 hidden"></ul>
            </div>

            <!-- File preview modal for review page -->
            <div id="reviewFileModal" class="hidden fixed inset-0 z-[2000] flex items-center justify-center bg-black/60 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full overflow-hidden relative">
                <button id="reviewFileModalClose" class="absolute top-3 right-3 bg-gray-200 px-3 py-1 rounded">✕</button>
                <div id="reviewFileModalContent" class="p-4 min-h-[320px] flex items-center justify-center"></div>
            </div>
            </div>

            <!-- FINAL CONFIRMATION INFO BOX -->
            <div id=""
                class="border-l-4 border-green-500 bg-green-100 rounded-2xl p-8 shadow-md mt-8 max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-green-700 mb-4">Final Confirmation</h3>
                <p class="text-[18px] text-green-800 mb-4">
                    By submitting this application, you confirm that all information provided is accurate and complete.
                </p>
                <label class="flex items-center gap-2 text-green-800 text-lg">
                    <input type="checkbox" id="confirmCheck" class="w-5 h-5">
                    I confirm that all information provided is accurate and I agree to the
                    <a href="#" class="underline text-green-900">terms and conditions</a>.
                </label>
            </div>

            <!-- FINAL SUBMIT BUTTON -->
            <div class="flex justify-center mt-6">
                <button type="button" id="reviewSubmitBtn"
                    class="bg-[#1E40AF] text-white text-3xl font-bold px-16 py-6 rounded-2xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition disabled:opacity-50"
                    disabled>
                    Submit Application
                </button>
            </div>
        </div>

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

<script>
    // Enable submit button only when checkbox is checked
    const confirmCheck = document.getElementById('confirmCheck');
    const submitBtn = document.getElementById('reviewSubmitBtn');

    confirmCheck.addEventListener('change', () => {
        submitBtn.disabled = !confirmCheck.checked;
    });

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
                if (json.redirect) window.location.href = json.redirect;
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
        viewBtn.className = 'bg-gray-700 text-white text-sm px-3 py-1 rounded-md';
        viewBtn.textContent = 'View';
        viewBtn.disabled = !item.data;
        viewBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (!item.data) return;
            openReviewModal(item.data, item.type || '');
        });

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'bg-red-500 text-white text-sm px-3 py-1 rounded-md';
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
@endsection
