<?php $__env->startSection('content'); ?>
<!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/jobmatches"
      class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back to Jobs</span>
    </a>
  </div>
</div>

<!-- HERO SECTION -->
<section class="bg-pink-400 py-10 text-center shadow-md rounded-b-3xl">
  <div class="flex flex-col items-center justify-center">
    <img src="<?php echo e(asset('image/brain.png')); ?>" alt="Brain Icon" 
         class="w-24 h-24 mb-3 animate-bounce-slow">
    <h2 class="text-4xl font-extrabold text-white tracking-wide drop-shadow-md">
      Why This Job Match You?
    </h2>
    <p class="text-lg text-white/90 mt-2 max-w-2xl">
      Discover how your unique skills and interests align with this job role.  
    </p>
  </div>
</section>

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
  
<!-- Job Match Section -->
<section class="max-w-5xl mx-auto mt-12 mb-16 px-6">
  <div class="bg-white shadow-lg rounded-2xl p-8 border-2 border-blue-200 hover:shadow-xl transition-all duration-300">

    <!-- Header -->
    <div class="flex items-center justify-center md:justify-start gap-4 mb-6">
      <div class="bg-blue-100 p-3 rounded-full flex items-center justify-center">
        <img src="<?php echo e(asset('image/matchedjob.png')); ?>" alt="Job Icon" class="w-10 h-10">
      </div>
      <div>
        <h3 class="text-2xl font-bold text-[#1E3A8A]">Your Matched Jobs</h3>
        <p class="text-gray-600 text-base italic">View jobs specially matched to your abilities and preferences.</p>
      </div>
    </div>

    <?php
    // Prefer per-user cached recommendations when server session exists.
    try {
      if (\Illuminate\Support\Facades\Auth::check()) {
        $user = \Illuminate\Support\Facades\Auth::user();
        $maybeUid = $user->firebase_uid ?? $user->uid ?? null;
        if ($maybeUid) {
          $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', (string)$maybeUid);
          $userCache = storage_path('app/reco_user_' . $safeUid . '.json');
          if (file_exists($userCache)) {
            $raw = @file_get_contents($userCache);
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
              // If JSON is keyed by uid, extract that entry
              if (array_key_exists((string)$maybeUid, $decoded) && is_array($decoded[(string)$maybeUid])) {
                $recs = $decoded[(string)$maybeUid];
              } else {
                $recs = $decoded;
              }
              // Map server recommendation shape into the 'approvedJobs' structure expected by this template
              $mapped = [];
              foreach ($recs as $r) {
                if (!is_array($r)) continue;
                $assoc = [];
                $assoc['title'] = $r['Title'] ?? $r['title'] ?? $r['job_title'] ?? '';
                $assoc['job_title'] = $assoc['title'];
                $assoc['company'] = $r['Company'] ?? $r['company'] ?? '';
                // normalize skills field(s)
                $skills = $r['matching_skills'] ?? $r['skills'] ?? $r['skill_tags'] ?? $r['assoc']['skills'] ?? [];
                if (is_string($skills)) $skills = array_filter(array_map('trim', preg_split('/[,;\n]+/', $skills)));
                if (!is_array($skills)) $skills = [];
                $assoc['skills'] = array_values(array_unique(array_filter(array_map(function($s){ return is_scalar($s) ? (string)$s : ''; }, $skills))));
                $mapped[] = [
                  'job_id' => $r['job_id'] ?? ($r['id'] ?? null),
                  'assoc' => $assoc,
                  'match_score' => $r['hybrid_score'] ?? $r['match_score'] ?? $r['score'] ?? null,
                  'job_description' => $r['job_description'] ?? $r['JobDescription'] ?? ''
                ];
              }
              if (!empty($mapped)) {
                $approvedJobs = $mapped;
              }
            }
          }
        }
      }
    } catch (\Throwable $_e) { /* ignore and fall back to existing $approvedJobs */ }
    ?>

    <?php if(!empty($approvedJobs) && is_array($approvedJobs) && count($approvedJobs) > 0): ?>
        <?php $__currentLoopData = $approvedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            // Prepare a skills array to expose to client-side rescoring. Try multiple common keys.
            $jobSkills = [];
            if (!empty($job['matching_skills']) && is_array($job['matching_skills'])) {
                $jobSkills = $job['matching_skills'];
            } elseif (!empty($job['assoc']['skills']) && is_array($job['assoc']['skills'])) {
                $jobSkills = $job['assoc']['skills'];
            } elseif (!empty($job['assoc']['skill_tags']) && is_array($job['assoc']['skill_tags'])) {
                $jobSkills = $job['assoc']['skill_tags'];
            } else {
                // attempt to parse a skills string if present
                if (!empty($job['assoc']['skills']) && is_string($job['assoc']['skills'])) {
                    $jobSkills = array_filter(array_map('trim', preg_split('/[,;\\n]+/', $job['assoc']['skills'])));
                }
            }
            // Ensure unique, simple values
            $jobSkills = array_values(array_unique(array_filter(array_map(function($s){ return is_scalar($s) ? (string)$s : ''; }, $jobSkills))));

            // Normalize match score like before (server-supplied fallback)
            $rawMatch = $job['match_score'] ?? null;
            $matchPercent = null;
            if (is_numeric($rawMatch)) {
              $m = floatval($rawMatch);
              if ($m > 0 && $m <= 1.01) {
                $matchPercent = round($m * 100);
              } elseif ($m > 0 && $m <= 5.0) {
                $matchPercent = round($m * 20);
              } else {
                $matchPercent = round($m);
              }
            }
          ?>

          <div class="bg-white shadow rounded-xl border mb-8 why-job-card" data-job-id-canonical="<?php echo e($job['job_id'] ?? ''); ?>" data-job-id="<?php echo e($job['job_id'] ?? ''); ?>" data-job-skills="<?php echo e(htmlspecialchars(json_encode($jobSkills), ENT_QUOTES, 'UTF-8')); ?>" data-match-percent="<?php echo e($matchPercent ?? ''); ?>">
            <div class="p-6">
              <div class="flex justify-between items-center">
                <h4 class="font-semibold text-lg"><?php echo e($job['assoc']['title'] ?? ($job['assoc']['job_title'] ?? 'Untitled Job')); ?></h4>
                <span class="match-badge text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full font-medium"><?php echo e($matchPercent !== null ? $matchPercent . '% Match' : ($job['assoc']['fit_level'] ?? 'Matched')); ?></span>
              </div>

              
              <div style="margin-top:6px;">
                <span class="job-id-debug" style="font-size:12px;color:#6b7280;">debug-id: <?php echo e($job['job_id'] ?? ''); ?></span>
              </div>

              <p class="text-sm mt-2 text-gray-600 font-medium">Match Score</p>
              <div class="w-full bg-gray-200 h-3 rounded-full mt-1">
                <div class="bg-green-400 h-3 rounded-full match-progress" style="width: <?php echo e($matchPercent !== null ? intval($matchPercent) . '%' : '50%'); ?>"></div>
              </div>
              <p class="text-right text-sm font-semibold mt-1 match-percent-label"><?php echo e($matchPercent !== null ? intval($matchPercent) . '%' : ($job['match_score'] ?? 'N/A')); ?></p>

              <!-- Matching Skills -->
              <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Job Skills / Required Skills</p>
                <div class="flex flex-wrap gap-3 matching-skills-list">
                  <?php if(!empty($jobSkills) && is_array($jobSkills) && count($jobSkills) > 0): ?>
                    <?php $__currentLoopData = $jobSkills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <span class="bg-gray-100 text-gray-500 px-4 py-1 rounded-full text-sm"><?php echo e($skill); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                    <span class="text-sm text-gray-500">No specific skills were listed for this job.</span>
                  <?php endif; ?>
                </div>

                <div class="mt-3 client-matched-skills" aria-live="polite">
                  
                </div>
              </div>

              <!-- View Details -->
              <div class="mt-4 flex items-center justify-between">
                <a href="<?php echo e(route('why.this.job.2', ['job_id' => $job['job_id']])); ?>" class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 rounded-lg transition inline-block">View Details</a>
                <img src="/images/sound-icon.png" alt="Audio" class="w-6 h-6">
              </div>
              <p class="text-xs text-gray-500 mt-1">(Click "View Details" to see full information)</p>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
        <div class="bg-white rounded-xl border p-6">
          <p class="text-gray-700">No guardian-approved jobs were found yet. Once a guardian approves jobs you will see them listed here along with the matching skills highlighted by the recommendation algorithm.</p>
        </div>
      <?php endif; ?>

    </div>
  </section>
</div>

<script type="module">
// Rescore job cards for signed-in user, prefer server-side per-UID recommendations,
// and display which profile skills match each job's skills.
(async function(){
  try {
    const mod = await import('/js/job-application-firebase.js');
    try { await mod.ensureInit?.(); } catch(e){}

    // Try server-backed sign-in first so we can fetch per-UID recs
    try {
      <!-- firebase.token removed -->
    } catch(e) { console.debug('signInWithServerToken (why-this-job) failed', e); }

    const signed = await mod.isSignedIn(5000).catch(()=>false);

    // If server recommendations endpoint exists and user is signed in, fetch per-user recs
    let serverRecsMap = {};
    let serverRecDebug = { status: 'not-called', httpStatus: null, body: null };
    if (signed) {
      try {
        // Acquire a Firebase ID token (if available) and include it in the
        // Authorization header (and the request body) so the server can verify
        // the token immediately and resolve the user's uid for per-UID recs.
        let idToken = null;
        try { if (mod.getIdToken) idToken = await mod.getIdToken(5000); } catch(e) { idToken = null; }

        const headers = { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' };
        const bodyPayload = {};
        if (idToken) {
          headers['Authorization'] = 'Bearer ' + idToken;
          bodyPayload.idToken = idToken;
        }
        // When auto-triggering from the client, ask the server to force generation when possible
        bodyPayload.force = true;

        const resp = await fetch('<?php echo e(url('/api/recommendations/user')); ?>', { method: 'POST', credentials: 'same-origin', headers, body: JSON.stringify(bodyPayload) });
        serverRecDebug.httpStatus = resp ? resp.status : null;
        if (resp && resp.ok) {
          const j = await resp.json().catch(()=>null);
          serverRecDebug.body = j;
          if (j && Array.isArray(j.recommendations)) {
            // normalize: map job_id to score
            for (const r of j.recommendations) {
              const id = r.job_id || r.jobId || (r.job && (r.job.job_id || r.job.jobId)) || null;
              const score = r.score ?? r.match_score ?? r.content_score ?? null;
              if (id !== null) serverRecsMap[String(id)] = score;
              serverRecDebug.status = 'ok-array';
            }
          } else if (Array.isArray(j)) {
            for (const r of j) {
              const id = r.job_id || r.jobId || (r.job && (r.job.job_id || r.job.jobId)) || null;
              const score = r.score ?? r.match_score ?? r.content_score ?? null;
              if (id !== null) serverRecsMap[String(id)] = score;
            }
              serverRecDebug.status = 'ok-root-array';
          }
        }
      } catch(e) { console.debug('fetch per-user recs failed', e); }
    }

      // Small visual debug indicator to show whether server personalization was used
      try {
        const container = document.createElement('div');
        container.id = 'why-this-job-debug';
        container.style.cssText = 'position:fixed;right:12px;bottom:12px;background:#111827;color:#fff;padding:8px 12px;border-radius:8px;z-index:1500;font-size:12px;opacity:0.95';
        container.setAttribute('aria-hidden','false');
        container.textContent = 'Personalization: checking...';
        document.body.appendChild(container);
        // Probe server session for debug info
        try {
          const sresp = await fetch('<?php echo e(url('/debug/firebase-session')); ?>', { credentials: 'same-origin' });
          if (sresp && sresp.ok) {
            const sj = await sresp.json().catch(()=>null);
            container.textContent = serverRecsMap && Object.keys(serverRecsMap).length ? 'Personalization: server (per-UID results)' : (signed ? 'Personalization: client (no server results)' : 'Personalization: anonymous');
            container.title = 'debug: ' + JSON.stringify({ serverRecDebug, session: sj });
          } else {
            container.textContent = serverRecsMap && Object.keys(serverRecsMap).length ? 'Personalization: server (per-UID results)' : (signed ? 'Personalization: client (no server results)' : 'Personalization: anonymous');
            container.title = 'debug: ' + JSON.stringify({ serverRecDebug, session: '<no-session-response>' });
          }
        } catch(e) {
          container.textContent = serverRecsMap && Object.keys(serverRecsMap).length ? 'Personalization: server (per-UID results)' : (signed ? 'Personalization: client (no server results)' : 'Personalization: anonymous');
          container.title = 'debug: ' + JSON.stringify({ serverRecDebug, session: '<probe-failed>' });
        }
      } catch (e) { console.debug('debug indicator install failed', e); }

    // Now get the user's Firestore profile so we can highlight matched skills
    const getUserProfile = mod.getUserProfile || (async ()=>null);
    let profile = null;
    try { profile = await getUserProfile(); } catch(e){ console.debug('getUserProfile failed', e); }

    // Normalize profile skills (same as job-rescore-client logic)
    const profileSkills = [];
    try {
      if (profile) {
        if (profile.skills && typeof profile.skills === 'object') {
          try { if (profile.skills.skills_page1) JSON.parse(profile.skills.skills_page1).forEach(x=>profileSkills.push(String(x).toLowerCase().trim())); } catch(e){}
          try { if (profile.skills.skills_page2) JSON.parse(profile.skills.skills_page2).forEach(x=>profileSkills.push(String(x).toLowerCase().trim())); } catch(e){}
        }
        if (Array.isArray(profile.skills)) profile.skills.forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
        if (typeof profile.skills === 'string') profile.skills.split(/[,;\n]+/).forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
        if (Array.isArray(profile.interests)) profile.interests.forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
        if (typeof profile.interests === 'string') profile.interests.split(/[,;\n]+/).forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
      }
    } catch(e){ console.debug('normalize profile skills failed', e); }
    const cleanedProfileSkills = Array.from(new Set(profileSkills.filter(Boolean)));

    // Helper to update a single card with a percent and matched skills
    function updateCard(el, pct, matched, jobSkills) {
      try {
        const badge = el.querySelector('.match-badge'); if (badge && pct !== null) badge.textContent = pct + '% Match';
        const prog = el.querySelector('.match-progress'); if (prog && pct !== null) prog.style.width = String(pct) + '%';
        const label = el.querySelector('.match-percent-label'); if (label && pct !== null) label.textContent = pct + '%';

        const skillsList = el.querySelector('.matching-skills-list');
        if (skillsList) {
          skillsList.innerHTML = '';
          if (!jobSkills || jobSkills.length === 0) skillsList.innerHTML = '<span class="text-sm text-gray-500">No specific skills were listed for this job.</span>';
          else jobSkills.forEach(s => {
            const span = document.createElement('span');
            if (matched.includes(s)) span.className = 'bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium';
            else span.className = 'bg-gray-100 text-gray-500 px-4 py-1 rounded-full text-sm';
            span.textContent = s; skillsList.appendChild(span);
          });
        }

        const clientMatchContainer = el.querySelector('.client-matched-skills');
        if (clientMatchContainer) {
          if (!matched || matched.length === 0) clientMatchContainer.innerHTML = '<p class="text-sm text-gray-500">No matching skills from your profile were detected for this job.</p>';
          else clientMatchContainer.innerHTML = '<p class="text-sm text-gray-700 font-medium">Skills from your profile that match this job:</p><div class="flex flex-wrap gap-3 mt-2">' + matched.map(s => '<span class="bg-green-50 text-green-600 px-4 py-1 rounded-full text-sm font-medium">'+String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</span>').join('') + '</div>';
        }
      } catch(e){ console.debug('updateCard failed', e); }
    }

    // Build an array of card elements and optionally override scores from server recs
    const cards = Array.from(document.querySelectorAll('.why-job-card'));
    const scored = [];
    cards.forEach(el => {
      try {
  const jobId = String(el.dataset.jobIdCanonical || el.getAttribute('data-job-id-canonical') || el.dataset.jobId || el.getAttribute('data-job-id') || '');
        const rawSkills = el.dataset.jobSkills || '[]';
        let jobSkills = [];
        try { jobSkills = JSON.parse(rawSkills).map(s=>String(s).toLowerCase().trim()); } catch(e){ jobSkills = []; }
        jobSkills = Array.from(new Set(jobSkills.filter(Boolean)));

        // If server recommendations include this job, prefer its score
        let pct = null;
        if (serverRecsMap && jobId && serverRecsMap.hasOwnProperty(jobId)) {
          const s = serverRecsMap[jobId];
          if (s !== null && s !== undefined) {
            if (typeof s === 'number') pct = Math.round(Math.min(100, Math.max(0, s > 1 ? s : s * 100)));
            else if (!isNaN(parseFloat(s))) { const sv = parseFloat(s); pct = Math.round(sv > 1 ? sv : sv * 100); }
          }
        }

        // If we don't have a server pct, and we have profile skills, compute a simple percent
        let matched = [];
        if (cleanedProfileSkills.length > 0 && jobSkills.length > 0) {
          matched = jobSkills.filter(s => cleanedProfileSkills.includes(s));
          if (pct === null) pct = Math.round((matched.length / jobSkills.length) * 100);
        }

        // fallback to original data-match-percent attr or visible label
        if (pct === null) {
          const fallback = parseInt(el.dataset.matchPercent || el.getAttribute('data-match-percent') || '') || null;
          if (fallback) pct = fallback;
        }

        scored.push({ el, pct: pct || 0 });
        updateCard(el, pct, matched, jobSkills);
      } catch(e){ console.debug('card iterate failed', e); }
    });

    // Reorder DOM: put higher scored cards first
    if (scored.length > 1) {
      scored.sort((a,b)=> (b.pct||0) - (a.pct||0));
      const parent = cards.length ? cards[0].parentNode : null;
      if (parent) {
        scored.forEach(s => parent.appendChild(s.el));
      }
    }

    // Finally, also import lightweight client-side rescoring for any additional behavior
    try { await import('/js/job-rescore-client.js'); } catch(e) { /* non-critical */ }

  } catch (err) { console.debug('why-this-job rescore orchestration failed', err); }
})();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.includes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\resources\views/why-this-job-1.blade.php ENDPATH**/ ?>