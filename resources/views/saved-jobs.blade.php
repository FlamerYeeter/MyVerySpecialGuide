@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    <main role="main" class="overflow-x-hidden flex flex-col flex-1 min-h-0">

<!-- HERO STYLE HEADER -->
<section class="bg-sky-50 py-12 sm:py-16" role="region" aria-labelledby="hero-heading">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 text-center">

        <p class="text-base font-bold uppercase tracking-widest text-blue-700">
            Your jobs
        </p>

        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 mt-2" id="hero-heading">
            Saved Jobs
        </h1>

        <div class="mx-auto max-w-2xl">
            <p class="text-lg sm:text-xl text-slate-700 mt-4">
                These are the jobs you saved. You can come back anytime and apply when you're ready.
            </p>
            <div class="mt-6 inline-flex items-center justify-center gap-3">
                <button type="button"
                class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-2.5 text-white font-semibold shadow hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300"
                aria-label="Read hero section aloud"
                onclick="speakText(document.getElementById('tts-hero').textContent)">

                <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
                Listen
            </button>
            </div>
        </div>

        <!-- COUNT BUTTON -->
        <div class="mt-6">
            <button type="button" id="savedJobsCountBtn"
                aria-label="Saved jobs count"
                class="inline-flex items-center justify-center gap-3 rounded-full bg-blue-700 px-8 py-4 text-white text-lg font-bold shadow-lg hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
                <img src="https://img.icons8.com/fluency/48/bookmark-ribbon.png" class="w-6 h-6" alt="" aria-hidden="true">
                <span id="savedJobsCountText" role="status" aria-live="polite">Loading...</span>
            </button>
        </div>

        <div class="pt-6">
            <a href="/job-matches"
                class="inline-flex items-center gap-3 rounded-full border-2 border-blue-200 bg-white px-6 py-3 text-blue-700 font-semibold shadow-sm transition hover:bg-blue-50 hover:border-blue-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">

                <!-- Icons8 Back Icon -->
                <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png"
                    alt=""
                    aria-hidden="true"
                    class="w-5 h-5">

                <span>Back to jobs</span>
            </a>
        </div>

    </div>
    <div id="tts-hero" class="sr-only">Your jobs. Saved Jobs. These are the jobs you saved. You can come back anytime and apply when you’re ready.</div>
</section>

       {{--<!-- Job List Container -->
        <div class="mt-10 space-y-8">

            <!-- Job Card -->
            <div
                class="bg-white border-2 border-blue-200 rounded-1xl shadow-lg p-8 flex flex-col lg:flex-row justify-between items-start gap-8 hover:scale-[1.01] transition-transform duration-300">

                <!-- Left: Logo + Info -->
                <div class="flex items-start gap-6 w-full lg:w-2/3">

                    <!-- Flag -->
                    {{-- <button
                        class="flag-btn text-gray-400 text-4xl font-bold focus:outline-none hover:text-red-500 transition-all duration-300 self-start mt-2"
                        title="Report or Flag Job">
                        <i class="ri-flag-line"></i>
                    </button> --}}

                    <!-- Company Logo -->
                   {{-- <div class="flex-shrink-0">
                        @if (!empty($company->logo))
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                                class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-2 border-gray-300 object-cover shadow-sm">
                        @else
                            <div
                                class="w-28 h-28 sm:w-32 sm:h-32 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                                <i class="ri-building-4-fill text-[#1E40AF] text-5xl sm:text-6xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Job Info -->
                    {{-- <div class="flex flex-col justify-center flex-1">
                        <h3 class="font-bold text-2xl text-gray-800 leading-tight">Shakey’s Service Crew</h3>

                        <p class="text-base sm:text-lg text-gray-600 mt-2 flex items-center gap-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location Icon"
                                class="w-5 h-5 sm:w-6 sm:h-6">
                            Eastwood • Taguig City, PH
                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span
                                class="border border-[#2563EB] text-[#2563EB] text-sm sm:text-base px-4 py-2 rounded-md font-semibold">Full-Time</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Buttons + Progress -->
                <div class="flex flex-col items-center lg:items-end w-full lg:w-1/3 mt-4 lg:mt-0">

                    <!-- Assessment Button -->
                    {{-- <button
                        class="bg-[#FFAC1D] text-white text-base sm:text-lg font-bold rounded-lg px-8 py-3 w-full sm:w-[360px] mb-4 hover:bg-[#D78203] transition-all duration-200 text-center shadow-md">
                        Apply for Therapist Job Readiness Assessment
                    </button> --}}

                    <!-- Action Buttons -->
                    {{--  <div class="flex flex-wrap justify-center lg:justify-end gap-4 mb-4">
                        <button
                            class="bg-[#55BEBB] text-white font-semibold px-8 py-3 text-base rounded-lg hover:bg-[#399f96] transition-all w-[110px] shadow-md">
                            Details
                        </button>
                        <button
                            class="bg-[#2563EB] text-white font-semibold px-8 py-3 text-base rounded-lg hover:bg-[#1b3999] transition-all w-[110px] shadow-md">
                            Apply
                        </button>
                    </div>

                    <!-- Progress -->
                    <div class="w-full sm:w-[360px]">
                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-[#88BF02] w-1/2 rounded-full"></div>
                        </div>
                        <p class="text-sm sm:text-base text-gray-600 font-semibold mt-2 text-center lg:text-right">
                            <span class="font-semibold text-black">5 applied</span> of 10 capacity
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section> --}}





    <!-- Job Cards -->
    <section class="bg-white py-12 sm:py-16" id="saved-jobs" role="region" aria-labelledby="saved-jobs-heading">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 id="saved-jobs-heading" class="text-2xl sm:text-3xl font-bold text-slate-900">Saved jobs</h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600">Review the jobs you have saved and apply when you’re ready.</p>
            </div>
             <button type="button"
            class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-2.5 text-white font-semibold shadow hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300"
            aria-label="Read saved jobs section aloud"
            onclick="speakText(
                document.getElementById('saved-jobs-heading').textContent + '. ' + 
                document.getElementById('saved-jobs-description').textContent
            )">

            <img src="https://img.icons8.com/ios-filled/18/ffffff/speaker.png" class="w-4 h-4">
            Listen
        </button>
        </div>
        <div id="saved-jobs-list" class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 grid gap-10 lg:grid-cols-2">
            <p class="col-span-2 text-center text-slate-600 text-base">Loading saved jobs…</p>
        </div>
        <div id="tts-saved-jobs" class="sr-only">Saved Jobs section. Review the jobs you have saved and apply when you’re ready.</div>
    </section>

    <script>
    (function(){
        function esc(s){ return s ? String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : ''; }
        const container = document.getElementById('saved-jobs-list');
        fetch('/db/saved-jobs.php', { credentials: 'same-origin' })
        .then(r => r.json())
                .then(json => {
                        // update top count button
                        const btnTextEl = document.getElementById('savedJobsCountText');
                        const btnEl = document.getElementById('savedJobsCountBtn');
                        const savedArr = (json && Array.isArray(json.saved)) ? json.saved : [];
                        const totalSaved = savedArr.length;
                        if (btnTextEl) {
                                if (totalSaved === 0) btnTextEl.textContent = 'No saved jobs yet';
                                else btnTextEl.textContent = `${totalSaved} Saved Job${totalSaved !== 1 ? 's' : ''}`;
                        }

                        if (!json || !json.success || !Array.isArray(json.saved) || json.saved.length === 0) {
                                container.innerHTML = `
                                    <div class="col-span-2 bg-blue-50 border-2 border-blue-200 rounded-2xl p-8 sm:p-12 text-center">
                                        <div class="mb-4 text-5xl" aria-hidden="true">📋</div>
                                        <p class="text-lg sm:text-xl font-bold text-gray-900 mb-2">No saved jobs yet</p>
                                        <p class="text-sm sm:text-base text-gray-600 mb-6">Save jobs from the Jobs page and they'll appear here.</p>
                                        <a href="/job-matches" class="inline-flex items-center gap-2 bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
                                            Browse Jobs
                                        </a>
                                    </div>`;
                                return;
                        }

                        // Build modern cards, skip removed entries (server can return j.removed = true)
                        const rows = json.saved.filter(j => !(j.removed || j.is_removed || j.status === 'removed'));
                        if (rows.length === 0) {
                                container.innerHTML = '<div class="text-center text-gray-600 text-sm sm:text-base">You have no active saved jobs.</div>';
                                return;
                        }

                        // Ensure client's applied state is current by fetching the user's applications
                        const userIdForApps = (typeof window !== 'undefined' && window.LARAVEL_USER_ID) ? String(window.LARAVEL_USER_ID) : localStorage.getItem('user_id');
                        const appliedSet = new Set();
                        const fetchApps = userIdForApps ? fetch('/db/get-applications.php?guardian_id=' + encodeURIComponent(userIdForApps), { credentials: 'same-origin' }).then(r => r.json()).then(a => {
                            if (a && a.success && Array.isArray(a.applications)) {
                                a.applications.forEach(x => { if (x.job_posting_id) appliedSet.add(String(x.job_posting_id)); });
                            }
                        }).catch(() => {/* ignore */}) : Promise.resolve();

                        fetchApps.then(() => {
                            container.innerHTML = rows.map(j => {
                                const jid = esc(j.job_id || j.JP_ID || '');
                                const safeJid = jid.replace(/[^a-zA-Z0-9_-]/g, '_');
                                const title = esc(j.job_role || 'Untitled Job');
                                const company = esc(j.company_name || '');
                                const loc = esc(j.address || '');
                                const desc = esc((j.description || '').replace(/\s+/g,' ').trim()).slice(0, 280);
                                const logo = esc(j.logo || '/image/jobexp3.png');

                                // compute apply-disabled state
                                const openingsNum = j.openings ? Number(j.openings) : 0;
                                const appliedNum = j.applied ? Number(j.applied) : 0;
                                let applyBefore = null;
                                try { if (j.apply_before) applyBefore = new Date(j.apply_before); } catch (e) { applyBefore = null; }
                                // Disable Apply only when the requesting user already applied for this job.
                                const userApplied = appliedSet.has(jid);
                                const applyDisabled = userApplied;
                                const applyBtnAttr = applyDisabled ? 'disabled' : `onclick="location.href='/job-application-1?job_id=${encodeURIComponent(jid)}'"`;
                                const applyBtnClass = applyDisabled ? 'px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm lg:text-base bg-gray-400 text-white rounded-md shadow-md cursor-not-allowed font-semibold' : 'px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm lg:text-base bg-[#2563EB] text-white rounded-md shadow-md hover:bg-[#1e4fc5] font-semibold transition-all';
                                const applyBtnText = applyDisabled ? '🚫 Applied' : '🚀 Apply Now';

                                return `
                                    <div data-job-id="${jid}" class="job-card rounded-2xl border border-slate-200 bg-white shadow-md transition hover:shadow-lg hover:border-slate-300 overflow-hidden flex flex-col h-full">
                                        <!-- Header with Logo and Info -->
                                        <div class="p-6 pb-4">
                                            <div class="flex items-start gap-4">
                                                <!-- Logo -->
                                                <div class="flex-shrink-0 rounded-xl bg-blue-50 p-2 shadow-sm">
                                                    <img src="${logo}" alt="${title} logo" class="h-14 w-14 object-cover rounded-lg">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 leading-tight">${title}</h3>
                                                    ${ company ? `<p class="text-sm sm:text-base text-gray-600 mt-1">${company}</p>` : '' }
                                                    ${ loc ? `<p class="text-xs sm:text-sm text-gray-500 mt-2 flex items-center gap-2"><img src='https://img.icons8.com/color/48/marker--v1.png' class='w-4 h-4 flex-shrink-0' alt='' aria-hidden='true'> <span>${loc}</span></p>` : '' }
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        ${ desc ? `<div class="px-6 pb-4"><p class="text-sm text-gray-600 line-clamp-2">${desc}...</p></div>` : '' }

                                        <!-- Hidden audio text -->
                                        <div id="tts-${safeJid}" class="sr-only">${title}${company ? '. ' + company : ''}${loc ? '. ' + loc : ''}${desc ? '. ' + desc : ''}</div>

                                        <!-- Divider -->
                                        <div class="border-t border-slate-100"></div>

                                        <!-- Action Buttons -->
                                        <div class="p-6 pt-4 flex flex-col gap-2 sm:flex-row sm:gap-2 lg:gap-3">
                                            <button type="button" data-target="tts-${safeJid}" class="tts-btn flex-shrink-0 bg-blue-600 text-white rounded-full px-3 py-2 hover:bg-blue-700 transition transform hover:scale-110 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300" aria-label="Read saved job details aloud">
                                                🔊
                                            </button>

                                            <a href="/job-details?job_id=${encodeURIComponent(jid)}"
                                            class="flex-1 px-3 py-2 text-xs sm:text-sm font-semibold text-center rounded-lg bg-[#55BEBB] text-white shadow-sm hover:bg-[#47a4a1] transition-all whitespace-nowrap focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
                                            📝 Details
                                            </a>

                                            <button ${applyBtnAttr} class="flex-1 px-3 py-2 text-xs sm:text-sm font-semibold rounded-lg shadow-sm transition-all whitespace-nowrap ${applyBtnClass} focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300" title="${applyDisabled ? 'You already applied' : 'Apply for this job'}">
                                            ${applyBtnText}
                                            </button>

                                            <button onclick="removeSavedJob('${esc(jid)}', this)"
                                            class="flex-1 px-3 py-2 text-xs sm:text-sm font-semibold rounded-lg bg-red-500 text-white shadow-sm hover:bg-red-600 transition-all whitespace-nowrap focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-300">
                                            🗑️ Remove
                                            </button>
                                        </div>
                                    </div>`;
                            }).join('\n');
                        });
        })
        .catch(err => {
            console.error('get-saved-jobs error', err);
            container.innerHTML = '<div class="text-center text-red-600 text-sm sm:text-base">Failed to load saved jobs. Please try again later.</div>';
        });
    })();
    // ...existing code...
    function updateSavedJobsCounter() {
        try {
            const listContainer = document.getElementById('saved-jobs-list');
            const btnTextEl = document.getElementById('savedJobsCountText');
            const btnEl = document.getElementById('savedJobsCountBtn');
            // count remaining job cards
            const remaining = listContainer ? listContainer.querySelectorAll('.job-card').length : 0;

            if (btnTextEl) {
                if (remaining === 0) {
                    btnTextEl.textContent = 'No saved jobs yet';
                    btnEl.disabled = true;
                    btnEl.classList.add('opacity-60', 'cursor-not-allowed');
                } else {
                    btnTextEl.textContent = `${remaining} Saved Job${remaining !== 1 ? 's' : ''}`;
                    btnEl.disabled = false;
                    btnEl.classList.remove('opacity-60', 'cursor-not-allowed');
                }
            }

            // if no jobs left, show the empty placeholder
            if (listContainer && remaining === 0) {
                listContainer.innerHTML = `
                    <div class="col-span-2 bg-blue-50 border-2 border-blue-200 rounded-2xl p-8 sm:p-12 text-center">
                        <div class="mb-4 text-5xl" aria-hidden="true">📋</div>
                        <p class="text-lg sm:text-xl font-bold text-gray-900 mb-2">No saved jobs yet</p>
                        <p class="text-sm sm:text-base text-gray-600 mb-6">Save jobs from the Jobs page and they'll appear here.</p>
                        <a href="/job-matches" class="inline-flex items-center gap-2 bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-300">
                            Browse Jobs
                        </a>
                    </div>`;
            }
        } catch (e) { /* ignore */ }
    }

    function removeSavedJob(jobId, btn) {
        if (!jobId) return;
        const card = btn && btn.closest('[data-job-id]');
        btn.disabled = true;
        btn.textContent = 'Removing…';
        fetch('/db/remove-saved-job.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ job_id: jobId })
        })
        .then(r => r.json())
        .then(j => {
            if (j && j.success) {
                // animate out then remove
                if (card) {
                    card.style.transition = 'opacity 220ms, transform 220ms';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(8px)';
                    setTimeout(()=> {
                        card.remove();
                        updateSavedJobsCounter();
                    }, 260);
                } else btn.textContent = 'Removed';
                // if there was no card reference, still update counter
                if (!card) updateSavedJobsCounter();
            } else {
                throw new Error(j?.message || 'Remove failed');
            }
        })
        .catch(err => {
            console.error('removeSavedJob error', err);
            btn.disabled = false;
            btn.textContent = 'Remove';
            alert('Failed to remove saved job. Try again.');
        });
    }
    </script>

    <!-- TTS Functionality -->
    <script>
    function speakText(text) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(text);
            speechSynthesis.speak(utterance);
        } else {
            alert('TTS not supported in this browser');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tts-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let text = '';
                if (this.dataset.target) {
                    const target = document.getElementById(this.dataset.target);
                    if (target) {
                        text = target.textContent || target.innerText || '';
                    }
                } else if (this.dataset.text) {
                    text = this.dataset.text;
                }
                if (text.trim()) {
                    speakText(text.trim());
                }
            });
        });
    });
    </script>



@endsection
