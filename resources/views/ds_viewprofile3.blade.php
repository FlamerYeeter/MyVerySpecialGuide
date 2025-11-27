@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-6 px-6 sm:px-10 lg:px-24">
            <div class="flex justify-start items-center space-x-3 max-w-[1600px] mx-auto">
                <a href="/viewprofile2"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
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
                <div class="bg-blue-800 text-white flex items-center gap-12 px-8 py-10 rounded-t-2xl">
                    <div
                        class="bg-white text-blue-800 font-bold rounded-full w-24 h-24 flex items-center justify-center text-3xl">
                        JD
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold">Juan Dela Cruz</h1>
                        <p class="flex items-center gap-3 text-lg mt-2"><img
                                src="https://img.icons8.com/color/48/marker--v1.png" alt="Location" class="w-6 h-6">
                            Taguig City, Metro Manila</p>
                        <p class="flex items-center gap-4 text-base mt-2"><img
                                src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" alt="Email Icon"
                                class="w-5 h-5">
                            juancruz@gmail.com</p>
                    </div>
                </div>

                <div class="p-10 space-y-14">

<!-- Skills Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Your Skills</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Selected Skills -->
                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div id="review_skills_list" class="flex flex-wrap gap-3 mb-6">

                                    <!-- Tags (empty for now) -->
                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                </div>
                            </div>

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

<!-- Job Preference Info -->
                    <section class="">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Your Job Preferences</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Selected Jobs -->
                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div id="review_jobprefs_img_container" class="flex flex-wrap gap-3 mb-6">

                                    <!-- Tags (empty for now) -->
                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                </div>
                            </div>

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

        </section>
<script>
document.addEventListener('DOMContentLoaded', () => {
    function el(id){ return document.getElementById(id); }

    fetch('/db/get_profile.php', { credentials: 'same-origin' })
    .then(r => r.json())
    .then(profileResp => {
        if (!profileResp || !profileResp.success) return;
        const u = profileResp.user || {};
        const gid = u.ID || u.id || u.USER_ID || u.GUARDIAN_ID || u.guardian_id;
        if (!gid) return;

        return fetch('/db/get-user-work.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ guardian_id: gid })
        });
    })
    .then(r => { if (!r) return; return r.json(); })
    .then(data => {
        if (!data || !data.success) return;
        const profiles = data.profiles || {};
        const skills = profiles.skills || [];
        const jobprefs = profiles.job_category || [];

        const skillsContainer = el('review_skills_list');
        const jobsContainer = el('review_jobprefs_img_container');

        if (skillsContainer) {
            skillsContainer.innerHTML = '';
            if (skills.length) {
                skills.forEach(s => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = s;
                    skillsContainer.appendChild(span);
                });
            } else {
                skillsContainer.innerHTML = '<p class="text-gray-600 italic">No skills selected.</p>';
            }
        }

        if (jobsContainer) {
            jobsContainer.innerHTML = '';
            if (jobprefs.length) {
                jobprefs.forEach(j => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = j;
                    jobsContainer.appendChild(span);
                });
            } else {
                jobsContainer.innerHTML = '<p class="text-gray-600 italic">No job preferences selected.</p>';
            }
        }
    })
    .catch(err => console.error('profile->work fetch error', err));
});
</script>
    </main>
@endsection
