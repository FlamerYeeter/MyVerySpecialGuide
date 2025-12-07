@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-6 px-6 sm:px-10 lg:px-24">
            <div class="flex justify-start items-center space-x-3 max-w-[1600px] mx-auto">
                <a href="/viewprofile1"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-3xl sm:text-3xl hover:underline focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back</span>
                </a>
            </div>
        </div>


        <!-- Profile Section -->
        <section class="max-w-[1600px] mx-auto px-10 py-14 space-y-12">

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
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

<!-- Education Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Education</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Education Level -->
                            <div>
                                <label class="block text-lg font-semibold mb-3">Education Level:</label>

                                <!-- Display Mode -->
                                <span id="educationLevel" class="block"></span>

                                <!-- Edit Mode -->
                                <select id="edit_edu_select" class="hidden w-full border rounded px-3 py-2">
                                    <option value="College">College</option>
                                    <option value="Vocational/Training">Vocational/Training</option>
                                    <option value="High School">High School</option>
                                    <option value="Elementary">Elementary</option>
                                </select>
                            </div>

<!-- School Name -->
                            <div class="col-span-2">
                                <label class="block text-lg font-semibold mb-3">School Name:</label>

                                <!-- Display Mode -->
                                <span id="schoolName" class="block"></span>

                                <!-- Edit Mode -->
                                <input type="text" id="edit_school_input"
                                    class="hidden w-full border rounded px-3 py-2" />
                            </div>
                        </div>

                        <div>
                            <label class="mt-8 block text-lg font-semibold mb-3">Certificates & Trainings
                                <span class="text-gray-500 italic">Uploaded file (if any)</span></label>
                            <div class="border rounded-lg px-4 py-3 bg-gray-50 text-gray-700">No file uploaded
                            </div>
                            <!-- Upload Button -->
                            <button
                                class="mt-3 bg-blue-800 text-white px-5 py-2 rounded-lg text-base font-medium hover:bg-blue-700">
                                Click to Upload Certificate & Training
                            </button>
                        </div>

                        <!-- Edit Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

<!-- Work Experience Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Work Experience</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Type of Work + Job Experiences -->
                            <div class="col-span-1">

<!-- Type of Work Row -->
                                <div class="mb-4">
                                    <div class="flex items-center gap-4">
                                        <span class="text-lg font-semibold leading-none">Type of Work:</span>
                                        <div id="review_work_list" class="flex flex-wrap gap-3 text-gray-800"></div>
                                    </div>
                                </div>
<!-- Job Experiences -->
                                <h4 class="mt-8 text-xl font-semibold text-blue-800 mb-2">Job Experiences</h4>
                                <div id="review_job_experiences" class="space-y-2 text-gray-800">
                                    <p class="text-gray-600 italic">No job experiences added.</p>
                                </div>
                                <!-- Add Work Experience Button -->
                                <button
                                    class="mt-3 bg-blue-800 text-white px-5 py-2 rounded-lg text-base font-medium hover:bg-blue-700">
                                    Click to Add Work Experience
                                </button>
                            </div>

                            <!-- Empty divs to stabilize grid alignment -->
                            <div></div>
                            <div></div>

                        </div>

                        <!-- Edit Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

 <!-- Work Environment Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Preferred Work Environment</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Preferred Workplace -->
                            <div class="col-span-1">
                                <div class="mb-4">
                                    <div class="flex items-center gap-4">
                                        <div id="review_workplace_list" class="flex flex-wrap gap-3 text-gray-800"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="review_workplace_choice_img_container" class="mt-4 text-center hidden">
                                <div
                                    class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
                                    <img id="review_workplace_choice_img" src="" alt="Workplace image"
                                        class="w-full h-full object-contain rounded-md" />
                                </div>
                            </div>
                        </div>


                        <!-- Empty divs to stabilize grid alignment -->
                        <div></div>
                        <div></div>

                        <!-- Edit Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>


                    <!-- Next Button -->
                    <div class="text-center space-y-3">
                        <a href="/viewprofile3"
                            class="inline-flex bg-blue-800 text-white font-medium px-32 py-4 rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2 mx-auto text-lg">
                            Next → <i class="ri-arrow-right-line text-2xl"></i>
                        </a>
                        <p class="text-base">Click <span class="text-blue-800 font-medium">"Next"</span> to move to the next
                            page</p>
                        <p class="text-sm text-gray-500">(Pindutin ang <span class="text-blue-800 font-medium">"Next"</span>
                            upang lumipat sa susunod na pahina)</p>
                    </div>

        </section>
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('/db/get_profile.php', { credentials: 'same-origin' })
    .then(r => r.json())
    .then(json => {
        if (!json.success) return console.warn('Profile fetch failed', json);
        const u = json.user || {};

        // Header
        const initialsEl = document.getElementById('profile_initials');
        const fullnameEl = document.getElementById('profile_fullname');
        const locationTextEl = document.getElementById('profile_location_text');
        const headerEmailEl = document.getElementById('profile_header_email');

        const fn = (u.FIRST_NAME || u.first_name || '').toString().trim();
        const ln = (u.LAST_NAME || u.last_name || '').toString().trim();
        const fullname = (fn + ' ' + ln).trim();
        if (fullnameEl) fullnameEl.textContent = fullname || (fullnameEl.textContent||'');
        let initials = '';
        if (fn) initials += fn.charAt(0);
        if (ln) initials += ln.charAt(0);
        if (!initials) initials = (u.USERNAME || u.EMAIL || '').toString().slice(0,2);
        if (initialsEl) initialsEl.textContent = initials.toUpperCase();
        if (locationTextEl) locationTextEl.textContent = (u.ADDRESS || u.address || '') || '—';
        if (headerEmailEl) headerEmailEl.textContent = (u.EMAIL || u.email || '') || '';

        // Education placeholders: use aliases provided by get_profile.php
        const eduEl = document.getElementById('educationLevel');
        const schoolEl = document.getElementById('schoolName');
        if (eduEl) eduEl.textContent = (u.EDUCATION_LEVEL || u.education || '-') || '-';
        if (schoolEl) schoolEl.textContent = (u.SCHOOL_NAME || u.school || '-') || '-';

        // guardian/user id
        const userId = u.ID || u.id || u.USER_ID || u.GUARDIAN_ID || u.guardian_id;
        if (!userId) return console.warn('No user/guardian id in profile response');

        // fetch job_experience rows (by guardian_id)
        return fetch('/db/get-user-work.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ guardian_id: userId })
        });
    })
    .then(async r => {
        if (!r) return;
        const json = await r.json();
        if (!json.success) return console.warn('get-user-work failed', json);

        // populate work_experience (from USER_PROFILE.TYPE = 'work_experience')
        const profiles = json.profiles || {};
        const jobs = json.job_experience_rows || [];

        const reviewWorkList = document.getElementById('review_work_list');
        const reviewWorkplaceList = document.getElementById('review_workplace_list');
        const jobContainer = document.getElementById('review_job_experiences');
        // render Type of Work as badges (same look as viewprofile3)
        if (reviewWorkList) {
            reviewWorkList.innerHTML = '';
            const we = profiles.work_experience || [];
            function formatWork(v) {
                if (v === null || v === undefined) return '';
                const s = String(v).trim();
                if (s === '') return '';
                if (s.toLowerCase() === 'none') return 'None';
                return s.charAt(0).toUpperCase() + s.slice(1);
            }
            if (we.length) {
                we.forEach(v => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = formatWork(v);
                    reviewWorkList.appendChild(span);
                });
            } else {
                reviewWorkList.innerHTML = '<span class="text-gray-600">-</span>';
            }
        }

        // render Preferred Workplace as badges (single-line where possible)
        if (reviewWorkplaceList) {
            reviewWorkplaceList.innerHTML = '';
            const wp = profiles.workplace || [];
            function formatWorkplace(v) {
                if (v === null || v === undefined) return '';
                const s = String(v).trim();
                if (s.toLowerCase() === 'none' || s === '') return '-';
                return s.charAt(0).toUpperCase() + s.slice(1);
            }
            if (wp.length) {
                wp.forEach(v => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = formatWorkplace(v);
                    reviewWorkplaceList.appendChild(span);
                });
            } else {
                reviewWorkplaceList.innerHTML = '<span class="text-gray-600">-</span>';
            }
        }

        // leave Type of Work and Preferred Workplace as before (user_profile job_category/work_experience may be used elsewhere)
        // only render JOB_EXPERIENCE rows here
        if (jobContainer) {
            jobContainer.innerHTML = '';

            if (!jobs.length) {
                const p = document.createElement('p');
                p.className = 'text-gray-600 italic';
                p.textContent = 'No job experiences added.';
                jobContainer.appendChild(p);
            } else {
                jobs.forEach(j => {
                    const card = document.createElement('div');
                    card.className = 'mb-3 p-3 border rounded-md bg-white shadow-sm';
                    const title = escapeHtml(j.company_name || '') + (j.job_title ? ' — ' + escapeHtml(j.job_title) : '');
                    const meta = escapeHtml(j.years_experience || '') + (j.work_year ? ' • ' + escapeHtml(j.work_year) : '');
                    const desc = escapeHtml(j.job_description || '');
                    const env = j.working_environment ? '<div class="text-xs text-gray-500 mt-2">Environment: ' + escapeHtml(j.working_environment) + '</div>' : '';
                    card.innerHTML = '<div class="font-semibold">' + title + '</div>' +
                                     '<div class="text-sm text-gray-600">' + meta + '</div>' +
                                     '<div class="text-sm text-gray-700 mt-2">' + desc + '</div>' + env;
                    jobContainer.appendChild(card);
                });
            }
        }
    })
    .catch(err => console.error('profile/work fetch error', err));

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }
});
</script>
    </main>
@endsection
