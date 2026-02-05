@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">

        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-6 px-6 sm:px-10 lg:px-24">
            <div class="flex justify-start items-center space-x-3 max-w-[1600px] mx-auto">
                <a href="/navigationbuttons"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-3xl hover:underline focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back</span>
                </a>
            </div>
        </div>

        <!-- Profile Section -->
        <section class="max-w-[1600px] mx-auto px-10 py-14 space-y-12">

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200">

                <!-- Header -->
                <div class="bg-blue-800 text-white flex items-center gap-12 px-10 py-10 rounded-t-2xl">
                    <div id="profile_initials"
                        class="bg-white text-blue-800 font-bold rounded-full w-24 h-24 flex items-center justify-center text-3xl">
                        JD
                    </div>
                    <div>
                        <h1 id="profile_fullname" class="text-2xl font-semibold">Juan Dela Cruz</h1>
                        <p id="profile_location" class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" class="w-7 h-7">
                            <span id="profile_location_text">Taguig City, Metro Manila</span>
                        </p>
                        <p class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" class="w-6 h-6">
                            <span id="profile_header_email">juandelacruz@gmail.com</span>
                        </p>
                    </div>
                </div>

                <div class="p-10 space-y-14">

<!-- Personal Info -->
                    <section>
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Personal Information</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div>
                                <label for="first_name" class="block text-lg font-semibold mb-3">First Name <span
                                        class="text-gray-500">(Unang Pangalan)</span></label>
                                <input id="first_name" type="text" disabled
                                    class="w-full border rounded-xl px-5 py-4 text-lg select-none">
                            </div>
                            <div>
                                <label for="last_name" class="block text-lg font-semibold mb-3">Last Name <span
                                        class="text-gray-500">(Apelyido)</span></label>
                                <input id="last_name" type="text" disabled
                                    class="w-full border rounded-xl px-5 py-4 text-lg select-none">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-lg font-semibold mb-3">Date of Birth <span
                                    class="text-gray-500">(Petsa ng Kapanganakan)</span></label>
                                <input id="date_of_birth" type="date" disabled
                                    class="w-full border rounded-xl px-5 py-4 text-lg select-none">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8 mt-8">
                            <div>
                                <label for="email" class="block text-lg font-semibold mb-3">Email Address</label>
                                <input id="email" type="email" disabled
                                    class="w-full border rounded-xl px-5 py-4 text-lg  select-none">
                            </div>
                            <div>
                                <label for="phone" class="block text-lg font-semibold mb-3">Contact Number</label>
                                <input id="phone" type="tel" placeholder="+63 9XX XXX XXXX"
                                    pattern="^\+63\s?9\d{2}\s?\d{3}\s?\d{4}$"
                                    title="Please enter a valid Philippine number (e.g. +63 912 345 6789)" disabled
                                    class="w-full border rounded-xl px-5 py-4 text-lg">
                            </div>
                        </div>

                        <div class="mt-8">
                            <label for="address" class="block text-lg font-semibold mb-3">Address <span
                                    class="text-gray-500">(Tirahan)</span></label>
                            <input id="address" type="text" disabled
                                class="w-full border rounded-xl px-5 py-4 text-lg select-none">
                        </div>

                        <div class="mt-8">
                            <label for="r_dsType1" class="block text-lg font-semibold mb-3">Type of Syndrome <span
                                    class="text-gray-500">(optional)</span></label>
                            <select id="r_dsType1" disabled
                                class="w-full sm:w-80 border rounded-xl px-5 py-4 text-lg select-none">
                                <option>-- Select Type --</option>
                                <option value="Trisomy 21 (Nondisjunction)">Trisomy 21 (Nondisjunction)</option>
                                <option value="Mosaic Down Syndrome">Mosaic Down Syndrome</option>
                                <option value="Translocation Down">Translocation Down Syndrome</option>
                            </select>
                        </div>
                    </section>

<!-- Parent/Guardian Info -->
                    <section class="mt-4 border-b border-gray-200 pb-10 mb-10">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Parent/Guardian Information</h3>

<!-- Names -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label for="g_first_name" class="block text-lg font-semibold mb-2">
                                    First Name <span class="text-gray-500">(Unang Pangalan)</span>
                                </label>
                                <input id="g_first_name" type="text" disabled
                                    class="w-full border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm select-none">
                            </div>

                            <div>
                                <label for="g_last_name" class="block text-lg font-semibold mb-2">
                                    Last Name <span class="text-gray-500">(Apelyido)</span>
                                </label>
                                <input id="g_last_name" type="text" disabled
                                    class="w-full border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm select-none">
                            </div>
                        </div>

<!-- Contact Info -->
                        <div class="grid md:grid-cols-2 gap-8 mt-8">
                            <div>
                                <label for="g_email" class="block text-lg font-semibold mb-2">Email Address</label>
                                <input id="g_email" type="email" disabled
                                    class="w-full border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm select-none">
                            </div>

                            <div>
                                <label for="g_phone" class="block text-lg font-semibold mb-2">Contact Number</label>
                                <input id="g_phone" type="tel" disabled
                                    class="w-full border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm select-none">
                            </div>
                        </div>

<!-- Relation -->
                        <div class="mt-8">
                            <label for="guardian_relationship" class="block text-lg font-semibold mb-2">
                                Relationship to User <span class="text-gray-500">(Ka-ano-ano mo siya?)</span>
                            </label>
                            <select id="guardian_relationship" disabled
                                class="w-full sm:w-80 border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm select-none"
                                style="margin-left:-6px;">
                                <option value="" disabled selected>Select Relationship</option>
                                <option value="Parent">Parent</option>
                                <option value="Guardian">Guardian</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Relative">Relative</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Edit -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button id="editProfileBtn"
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

<!-- Account Details -->
                    <section class="border-b border-gray-200 pb-10 mb-10">
                        <h3 class="text-3xl font-bold text-blue-800 mb-8">Account Details</h3>

                        <div class="grid md:grid-cols-2 gap-8">

<!-- Username -->
                            <div>
                                <label for="username" class="block text-lg font-semibold mb-2">Username</label>
                                <input id="username" type="text" disabled
                                    class="w-full border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm">
                            </div>

<!-- Password -->
                            <div>
                                <label for="password" class="block text-lg font-semibold mb-2">Password</label>
                                <input disabled id="password" type="password"
                                    class="w-full border border-gray-300 rounded-xl px-5 py-4 text-lg shadow-sm">

                                <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                                    <input type="checkbox"> Click the box to show password
                                </p>

                                <p class="text-sm text-gray-600 mt-2">
                                    Pindutin ang <span class="text-blue-600 font-medium">"Change Password"</span> upang
                                    baguhin
                                </p>

                                <button id="openChangePasswordModal"
                                    class="bg-blue-800 text-white px-6 py-3 mt-3 rounded-lg text-base font-medium hover:bg-blue-900">
                                    Change Password
                                </button>

                                <div class="flex flex-col items-end mt-10 space-y-2">
                                    <p class="text-lg text-gray-600">
                                        Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                                    </p>
                                    <button id="editAccountBtn"
                                        class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                        Edit
                                    </button>
                                </div>
                            </div>
                    </section>
                    
                    <!-- Uploaded Files -->
                    <section class="border-b border-gray-200 pb-10 mb-10" id="uploaded_files_section">
                        <h3 class="text-3xl font-bold text-blue-800 mb-8">Uploaded Files</h3>

                        <div class="grid md:grid-cols-2 gap-8">

                            <!-- Membership -->
                            <div>
                                <label class="block text-lg font-semibold mb-2">
                                    PWD ID <span class="text-gray-500 italic">Uploaded file (if any)</span>
                                </label>
                                <div id="r_proof"
                                    class="border border-gray-300 rounded-xl px-5 py-4 bg-gray-50 text-gray-700 shadow-sm">
                                    No file uploaded
                                </div>

                                <!-- file input (hidden until edit) -->
                                <div class="mt-3">
                                    <input id="proof_input" type="file" accept="application/pdf,image/*"
                                        class="hidden w-full border border-gray-300 rounded-xl px-5 py-3 text-sm" />
                                </div>
                            </div>

                            <!-- Medical Certificate -->
                            <div>
                                <label class="block text-lg font-semibold mb-2">
                                    Medical Certificate <span class="text-gray-500 italic">Uploaded file (if any)</span>
                                </label>
                                <div id="r_medical"
                                    class="border border-gray-300 rounded-xl px-5 py-4 bg-gray-50 text-gray-700 shadow-sm">
                                    No file uploaded
                                </div>

                                <!-- file input (hidden until edit) -->
                                <div class="mt-3">
                                    <input id="med_input" type="file" accept="application/pdf,image/*"
                                        class="hidden w-full border border-gray-300 rounded-xl px-5 py-3 text-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>

                            <!-- edit/save/cancel buttons -->
                            <div class="flex items-center gap-4">
                                <button id="editFilesBtn"
                                    class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                    Edit
                                </button>

                                <button id="saveFilesBtn" class="hidden bg-blue-800 text-white px-8 py-3 rounded-xl text-lg font-semibold shadow hover:bg-blue-900">
                                    Save
                                </button>

                                <button id="cancelFilesBtn" class="hidden bg-gray-300 text-gray-800 px-6 py-3 rounded-xl text-lg font-medium">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Next Button -->
                    <div class="text-center space-y-3">
                        <a href="/viewprofile2"
                            class="inline-flex bg-blue-800 text-white font-medium px-32 py-4 rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2 mx-auto text-lg">
                            Next → <i class="ri-arrow-right-line text-2xl"></i>
                        </a>
                        <p class="text-base">Click <span class="text-blue-800 font-medium">"Next"</span> to move to the
                            next page</p>
                        <p class="text-sm text-gray-500">(Pindutin ang <span
                                class="text-blue-800 font-medium">"Next"</span> upang lumipat sa susunod na pahina)</p>
                    </div>

        </section>

<!-- ============ CHANGE PASSWORD MODAL ============ -->
        <div id="changePasswordModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center px-4 hidden z-50">

            <div class="bg-white rounded-3xl shadow-xl max-w-4xl w-full p-10 relative">

                <!-- Cancel Button -->
                <button id="closeModal"
                    class="absolute top-6 right-6 bg-red-600 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-red-700">
                    Cancel
                </button>

                <h2 class="text-3xl font-bold text-blue-800 mb-10">Change Password</h2>

                <div class="grid md:grid-cols-2 gap-10">

                    <div>
                        <label class="block text-lg font-semibold mb-2">New Password</label>
                        <input id="newPass" type="password"
                            class="w-full border border-gray-300 rounded-xl px-5 py-3 text-lg shadow-sm">
                        <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                            <input id="showNewPass" type="checkbox">
                            Click the box to show password.
                        </p>
                    </div>

                    <div>
                        <label class="block text-lg font-semibold mb-2">Retype New Password</label>
                        <input id="retypePass" type="password"
                            class="w-full border border-gray-300 rounded-xl px-5 py-3 text-lg shadow-sm">
                        <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                            <input id="showRetypePass" type="checkbox">
                            Click the box to show password.
                        </p>
                    </div>
                </div>

                <div class="border-2 border-blue-300 bg-blue-50 rounded-2xl p-8 mt-10 grid md:grid-cols-2 gap-10">

                    <div>
                        <h3 class="font-bold text-lg mb-2">English</h3>
                        <ul class="list-disc ml-5 mt-2 text-gray-700">
                            <li>One uppercase letter</li>
                            <li>One lowercase letter</li>
                            <li>One number</li>
                            <li>Minimum 8 characters</li>
                        </ul>
                        <p class="mt-3 font-semibold">Example: Lovedog12</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-2">Tagalog</h3>
                        <ul class="list-disc ml-5 mt-2 text-gray-700">
                            <li>Isang malaking letra</li>
                            <li>Isang maliit na letra</li>
                            <li>Isang numero</li>
                            <li>Hindi bababa sa 8 characters</li>
                        </ul>
                        <p class="mt-3 font-semibold">Halimbawa: Lovedog12</p>
                    </div>
                </div>

                <div class="text-right mt-10">
                    <button class="bg-blue-800 text-white px-10 py-4 rounded-xl text-xl font-semibold hover:bg-blue-900">
                        Save
                    </button>
                </div>

            </div>
        </div>

        <!-- ============ Change Password Script ============ -->
        <script>
            const modal = document.getElementById("changePasswordModal");
            const openBtn = document.getElementById("openChangePasswordModal");
            const closeBtn = document.getElementById("closeModal");

            openBtn.addEventListener("click", () => modal.classList.remove("hidden"));
            closeBtn.addEventListener("click", () => modal.classList.add("hidden"));

            document.getElementById("showNewPass").addEventListener("change", function() {
                document.getElementById("newPass").type = this.checked ? "text" : "password";
            });

            document.getElementById("showRetypePass").addEventListener("change", function() {
                document.getElementById("retypePass").type = this.checked ? "text" : "password";
            });
        </script>
        
<script>
document.addEventListener('DOMContentLoaded', () => {
    // prefer a known guardian id (window.__mvsg_guardian_id), then localStorage, then server-side session
    const __server_guardian_id = @json(Auth::id() ?? session('guardian_id') ?? session('user_id') ?? null);
    (function(){
        let url = '/db/get_profile.php';
        const gid = window.__mvsg_guardian_id || localStorage.getItem('user_id') || __server_guardian_id;
        console.debug('profile fetch using gid=', gid, 'window.__mvsg_guardian_id=', window.__mvsg_guardian_id, 'localStorage.user_id=', localStorage.getItem('user_id'), 'server=', __server_guardian_id);
        if (gid) url += '?guardian_id=' + encodeURIComponent(gid);
        fetch(url, { credentials: 'same-origin' })
            .then(async r => {
                const text = await r.text();
                console.log('get_profile raw response status:', r.status, 'text length:', text.length, 'preview:', text.slice(0,200));
                if (!text) throw new Error('Empty response body from get_profile.php (status ' + r.status + ')');
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Failed to parse JSON from get_profile.php: ' + e.message + ' -- raw:' + text.slice(0,1000));
                }
            })
            .then(json => {
            console.log('get_profile response:', json);

            if (!json.success) {
                console.warn('Profile fetch failed', json);
                return;
            }

            const u = json.user || {};
            const files = json.files || {};
            const lengths = json.file_lengths || {};
            console.log('file lengths:', lengths);

            /* ==========================================================
               HEADER UPDATE (initials, name, location, email)
               ========================================================== */
            try {
                const initialsEl = document.getElementById('profile_initials');
                const fullnameEl = document.getElementById('profile_fullname');
                const locationTextEl = document.getElementById('profile_location_text');
                const headerEmailEl = document.getElementById('profile_header_email');

                const fn = (u.FIRST_NAME || '').trim();
                const ln = (u.LAST_NAME || '').trim();
                const fullname = (fn + ' ' + ln).trim();

                if (fullnameEl && fullname) fullnameEl.textContent = fullname;

                // compute initials
                let initials = '';
                if (fn) initials += fn.charAt(0);
                if (ln) initials += ln.charAt(0);
                if (!initials) {
                    const fallback = (u.USERNAME || u.EMAIL || '').toString();
                    initials = fallback.slice(0, 2);
                }
                initials = initials.toUpperCase();
                if (initialsEl) initialsEl.textContent = initials;

                // address/location: write into dedicated span to preserve the icon markup
                const addr = (u.ADDRESS || '').trim();
                if (locationTextEl) {
                    locationTextEl.textContent = addr || '—';
                } else {
                    // fallback: create the span if it doesn't exist
                    const locationEl = document.getElementById('profile_location');
                    if (locationEl) {
                        let span = locationEl.querySelector('#profile_location_text');
                        if (!span) {
                            span = document.createElement('span');
                            span.id = 'profile_location_text';
                            locationEl.appendChild(span);
                        }
                        span.textContent = addr || '—';
                    }
                }

                // header email
                if (headerEmailEl) headerEmailEl.textContent = (u.EMAIL || '').toString();
            } catch (e) {
                console.warn('header update failed', e);
            }

            /* ==========================================================
               FORM POPULATION
               ========================================================== */

            const set = (id, val) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = val ?? '';
                else if (el.tagName === 'SELECT') el.value = val ?? '';
            };

            set('first_name', u.FIRST_NAME);
            set('last_name', u.LAST_NAME);
            set('date_of_birth', u.DATE_OF_BIRTH);
            set('email', u.EMAIL);
            set('phone', u.CONTACT_NUMBER);
            set('address', u.ADDRESS);
            set('r_dsType1', u.TYPES_OF_DS);

            // Guardian
            set('g_first_name', u.GUARDIAN_FIRST_NAME);
            set('g_last_name', u.GUARDIAN_LAST_NAME);
            set('g_email', u.GUARDIAN_EMAIL);
            set('g_phone', u.GUARDIAN_CONTACT_NUMBER);

            // Relationship dropdown
            const relVal = (u.RELATIONSHIP_TO_USER || '').trim();
            const relSelect = document.getElementById('guardian_relationship');
            if (relSelect && relVal) {
                const match = Array.from(relSelect.options)
                    .find(o => (o.value || '').toLowerCase() === relVal.toLowerCase());
                if (match) relSelect.value = match.value;
                else {
                    const opt = document.createElement('option');
                    opt.value = relVal;
                    opt.textContent = relVal;
                    opt.selected = true;
                    relSelect.appendChild(opt);
                }
            }

            // username (never populate password)
            set('username', u.USERNAME);
            const pwd = document.getElementById('password');
            if (pwd) {
                pwd.value = '';
                pwd.placeholder = 'Hidden for security';
            }

            /* ==========================================================
               FILE LINKS (server-streamed)
               ========================================================== */

            function makeServerLink(type, label, filename) {
                const a = document.createElement('a');
                a.className = 'text-blue-600 underline';
                a.textContent = label || 'View / Download';
                a.href = '/db/get_file.php?type=' + encodeURIComponent(type);
                a.target = '_blank';
                a.rel = 'noopener';
                a.setAttribute('download', filename || '');
                return a;
            }

            const proofEl = document.getElementById('r_proof');
            const medEl = document.getElementById('r_medical');

            // Helper: decide whether server reports a file exists. We accept multiple possible shapes.
            function fileExistsAccordingToServer(type) {
                try {
                    // prefer explicit files object
                    if (files && Object.prototype.hasOwnProperty.call(files, type)) {
                        const v = files[type];
                        if (v === null || v === false || v === '') return false;
                        return true;
                    }
                    // try lengths map (several possible key names)
                    if (lengths) {
                        const candidates = [type, type + '_len', type + '_length', type + 'Len', type.toUpperCase() + '_LENGTH'];
                        for (const k of candidates) {
                            if (Object.prototype.hasOwnProperty.call(lengths, k)) {
                                const n = Number(lengths[k] || 0);
                                return n > 0;
                            }
                        }
                    }
                } catch (e) { /* ignore */ }
                return false;
            }

            if (proofEl) {
                proofEl.innerHTML = '';
                if (fileExistsAccordingToServer('proof')) {
                    proofEl.appendChild(makeServerLink('proof', 'View / Download', 'proof.pdf'));
                } else {
                    const no = document.createElement('div');
                    no.className = 'text-gray-600';
                    no.textContent = 'No file uploaded';
                    proofEl.appendChild(no);
                }
            }

            if (medEl) {
                medEl.innerHTML = '';
                if (fileExistsAccordingToServer('med')) {
                    medEl.appendChild(makeServerLink('med', 'View / Download', 'medical.pdf'));
                } else {
                    const no = document.createElement('div');
                    no.className = 'text-gray-600';
                    no.textContent = 'No file uploaded';
                    medEl.appendChild(no);
                }
            }

        })
        .catch(err => {
            console.error('profile fetch error', err);
        });
    })();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // list of fields to toggle (personal + guardian)
    const fieldIds = [
        "first_name","last_name","date_of_birth","email","phone","address","r_dsType1",
        "g_first_name","g_last_name","g_email","g_phone","guardian_relationship"
    ];

    const btn = document.getElementById('editProfileBtn');
    if (!btn) return;

    // initial mode = view
    btn.dataset.mode = 'view';

    function setFieldsEditable(editable) {
        fieldIds.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.disabled = !editable;
            // visual classes (optional): swap gray -> white when editable
            if (editable) {
                el.classList.remove('bg-gray-50','select-none');
                el.classList.add('bg-white','text-gray-900');
            } else {
                el.classList.add('bg-gray-50','select-none');
                el.classList.remove('bg-white','text-gray-900');
            }
        });
    }

    btn.addEventListener('click', async function () {
        const mode = this.dataset.mode || 'view';

        if (mode === 'view') {
            // switch to edit mode
            setFieldsEditable(true);
            this.dataset.mode = 'editing';
            this.textContent = 'Save';
            this.classList.remove('bg-green-500','hover:bg-green-600');
            this.classList.add('bg-green-600'); // keep green but reflect save
            return;
        }

        // Save mode -> gather values and POST to server
        this.disabled = true;
        this.textContent = 'Saving...';

        const payload = {};
        fieldIds.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            if (el.tagName === 'SELECT') payload[id] = el.value || '';
            else payload[id] = el.value || '';
        });

        try {
            const resp = await fetch('/db/editprofile-1.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const j = await resp.json().catch(()=>({success:false}));
            if (j && j.success) {
                // success → return to view mode
                setFieldsEditable(false);
                btn.dataset.mode = 'view';
                btn.textContent = 'Edit';
                btn.classList.remove('bg-green-600');
                btn.classList.add('bg-green-500','hover:bg-green-600');
                console.log('Profile saved');
            } else {
                console.error('Save failed', j);
                alert('Save failed. Check console for details.');
                btn.textContent = 'Save';
            }
        } catch (err) {
            console.error('Save error', err);
            alert('Network or server error while saving.');
            btn.textContent = 'Save';
        } finally {
            this.disabled = false;
        }
    });

    // ensure initial state matches disabled inputs in template
    setFieldsEditable(false);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const acctFieldIds = ['username','password'];
    const btn = document.getElementById('editAccountBtn');
    if (!btn) return;

    btn.dataset.mode = 'view';

    function setAcctEditable(editable) {
        acctFieldIds.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            // password input when editing should be empty for security
            if (id === 'password') {
                if (editable) {
                    el.value = '';
                    el.placeholder = 'Enter new password (leave blank to keep current)';
                } else {
                    // reset to view state
                    el.value = '';
                    el.placeholder = 'Hidden for security';
                }
            }
            el.disabled = !editable;
            if (editable) {
                el.classList.remove('bg-gray-50','select-none');
                el.classList.add('bg-white','text-gray-900');
            } else {
                el.classList.add('bg-gray-50','select-none');
                el.classList.remove('bg-white','text-gray-900');
            }
        });
    }

    btn.addEventListener('click', async function () {
        const mode = this.dataset.mode || 'view';
        if (mode === 'view') {
            setAcctEditable(true);
            this.dataset.mode = 'editing';
            this.textContent = 'Save';
            this.classList.remove('bg-green-500','hover:bg-green-600');
            this.classList.add('bg-green-600');
            return;
        }

        // Save
        this.disabled = true;
        this.textContent = 'Saving...';

        const payload = {};
        const usernameEl = document.getElementById('username');
        const passwordEl = document.getElementById('password');
        if (usernameEl) payload.username = usernameEl.value || '';
        if (passwordEl && passwordEl.value.trim() !== '') payload.password = passwordEl.value.trim();

        try {
            const resp = await fetch('/db/editprofile-1.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const j = await resp.json().catch(()=>({success:false}));
            if (j && j.success) {
                setAcctEditable(false);
                btn.dataset.mode = 'view';
                btn.textContent = 'Edit';
                btn.classList.remove('bg-green-600');
                btn.classList.add('bg-green-500','hover:bg-green-600');
                // If username changed, optionally update header display
                if (payload.username) {
                    const header = document.getElementById('profile_header_email');
                    if (header) header.textContent = payload.username;
                }
            } else {
                console.error('Account save failed', j);
                alert('Save failed. See console for details.');
                btn.textContent = 'Save';
            }
        } catch (err) {
            console.error('Save error', err);
            alert('Network or server error while saving.');
            btn.textContent = 'Save';
        } finally {
            this.disabled = false;
        }
    });

    // initial state
    setAcctEditable(false);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editFilesBtn');
    const saveBtn = document.getElementById('saveFilesBtn');
    const cancelBtn = document.getElementById('cancelFilesBtn');
    const proofInput = document.getElementById('proof_input');
    const medInput = document.getElementById('med_input');
    const proofEl = document.getElementById('r_proof');
    const medEl = document.getElementById('r_medical');

    if (!editBtn || !saveBtn || !cancelBtn) return;

    function setEditing(on) {
        if (on) {
            proofInput.classList.remove('hidden');
            medInput.classList.remove('hidden');
            saveBtn.classList.remove('hidden');
            cancelBtn.classList.remove('hidden');
            editBtn.classList.add('hidden');
        } else {
            proofInput.classList.add('hidden');
            medInput.classList.add('hidden');
            saveBtn.classList.add('hidden');
            cancelBtn.classList.add('hidden');
            editBtn.classList.remove('hidden');
            proofInput.value = '';
            medInput.value = '';
        }
    }

    function makeDownloadLink(type, label, filename) {
        const a = document.createElement('a');
        a.className = 'text-blue-600 underline';
        a.textContent = label || 'View / Download';
        a.href = '/db/get_file.php?type=' + encodeURIComponent(type);
        a.target = '_blank';
        a.rel = 'noopener';
        if (filename) a.setAttribute('download', filename);
        return a;
    }

    editBtn.addEventListener('click', () => setEditing(true));
    cancelBtn.addEventListener('click', () => setEditing(false));

    saveBtn.addEventListener('click', async () => {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        const fd = new FormData();
        if (proofInput.files && proofInput.files[0]) fd.append('proof', proofInput.files[0]);
        if (medInput.files && medInput.files[0]) fd.append('med', medInput.files[0]);

        // if no files selected, cancel
        if (!fd.has('proof') && !fd.has('med')) {
            alert('Please choose at least one file to upload.');
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save';
            return;
        }

        try {
            const resp = await fetch('/db/editprofile-files.php', {
                method: 'POST',
                credentials: 'same-origin',
                body: fd
            });
            const j = await resp.json().catch(()=>({success:false}));
            console.debug('editprofile-files response', j);
            if (j && j.success) {
                // update links (server-streamed endpoint serves current files)
                if (proofEl) {
                    proofEl.innerHTML = '';
                    proofEl.appendChild(makeDownloadLink('proof','View / Download','proof.pdf'));
                }
                if (medEl) {
                    medEl.innerHTML = '';
                    medEl.appendChild(makeDownloadLink('med','View / Download','medical.pdf'));
                }
                setEditing(false);
                alert('Files updated successfully.');
            } else {
                console.error('Upload failed', j);
                // Try to show detailed errors to the user
                try {
                    if (j && j.results) {
                        const parts = [];
                        for (const k of Object.keys(j.results)) {
                            const r = j.results[k];
                            if (!r.ok) parts.push(k + ': ' + (r.error || JSON.stringify(r)));
                        }
                        if (parts.length) {
                            alert('Upload failed for: ' + parts.join('; '));
                        } else if (j.error) {
                            alert('Upload failed: ' + j.error);
                        } else {
                            alert('Upload failed. See console for details.');
                        }
                    } else if (j && j.error) {
                        alert('Upload failed: ' + j.error);
                    } else {
                        alert('Upload failed. See console for details.');
                    }
                } catch(e) {
                    console.error('Error parsing upload failure', e);
                    alert('Upload failed. See console for details.');
                }
            }
        } catch (err) {
            console.error('Upload error', err);
            alert('Network or server error while uploading.');
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save';
        }
    });

    // initial state: not editing
    setEditing(false);
});
</script>

    </main>
@endsection
