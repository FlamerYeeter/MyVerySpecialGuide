// Lightweight per-user rescoring for job cards using Firebase profile
// This module dynamically imports the existing firebase helper to get the user profile
(async function(){
  // Global debug object for easy inspection in console
  window.__JOB_RESCORE_DEBUG = window.__JOB_RESCORE_DEBUG || { events: [] };
  function dbg(ev, payload) {
    try { window.__JOB_RESCORE_DEBUG.events.push({ when: Date.now(), ev, payload }); } catch(e){}
    try { console.debug('job-rescore:', ev, payload); } catch(e){}
  }

  try {
    dbg('start', { location: window.location.href });
    // Import helper module (should export getUserProfile/isSignedIn)
    let mod = null;
    try {
      mod = await import('/js/job-application-firebase.js');
      dbg('imported firebase helper', { path: '/js/job-application-firebase.js' });
    } catch (impErr) {
      dbg('import_failed', { error: String(impErr) });
      // still continue — no profile means we stop later
    }

    const getUserProfile = (mod && (mod.getUserProfile || mod.default?.getUserProfile)) || (async ()=>null);

    // Wait a short time for firebase init to complete if present
    await new Promise(r => setTimeout(r, 300));

    let profile = null;
    try {
      profile = await getUserProfile();
      dbg('got_profile', { profile: (profile ? { uid: profile.uid, email: profile.email } : null) });
    } catch(e){ dbg('getUserProfile_failed', { error: String(e) }); }
    if (!profile) {
      dbg('no_profile');
      return; // nothing to do for anonymous users
    }

    // Normalize skills/interests from profile (support array or comma/string)
    let skills = [];
    if (Array.isArray(profile.skills)) skills = profile.skills.map(s=>String(s).toLowerCase().trim());
    else if (typeof profile.skills === 'string') skills = profile.skills.split(/[,;\n]/).map(s=>s.toLowerCase().trim()).filter(Boolean);
    // Also accept interests/tags
    if (Array.isArray(profile.interests)) skills = skills.concat(profile.interests.map(s=>String(s).toLowerCase().trim()));
    else if (typeof profile.interests === 'string') skills = skills.concat(profile.interests.split(/[,;\n]/).map(s=>s.toLowerCase().trim()).filter(Boolean));

    dbg('normalized_skills', { skillsCount: skills.length, skillsSample: skills.slice(0,10) });
    if (skills.length === 0) {
      dbg('no_skills');
      return; // nothing to match
    }

    // Helper to estimate match score from job text
    function scoreJobText(text){
      if (!text) return 0;
      const t = String(text).toLowerCase();
      let c = 0;
      for (const s of skills) {
        if (!s) continue;
        // match whole word or substring
        if (t.indexOf(s) !== -1) c++;
        else if (s.split(' ').length > 1) {
          // allow partial matches of multi-word skills
          const parts = s.split(' ');
          for (const p of parts) if (p && t.indexOf(p) !== -1) { c++; break; }
        }
      }
      // normalize to 0-100
      return Math.min(100, Math.round((c / Math.max(1, skills.length)) * 100));
    }

    // Update all job cards that expose description or data-content attributes
    const cards = Array.from(document.querySelectorAll('[data-content-score], .job-card, [data-job-id]'));
    dbg('cards_found', { count: cards.length });
    if (!cards.length) return;

    for (const el of cards) {
      try {
        // try to find description text
        let desc = '';
        // common attribute that pages used
        if (el.dataset && el.dataset.raw) desc = el.dataset.raw;
        // look for nested description nodes
        if (!desc) {
          const d = el.querySelector('.job-description, .desc, .job-desc, p, .text-sm');
          if (d) desc = d.textContent || '';
        }
        // also check data-content-score or data-job json
        if (!desc && el.dataset && el.dataset.job) {
          try { const j = JSON.parse(el.dataset.job); desc = j.description || j.desc || j.raw?.description || ''; } catch(e){}
        }

        const initialContent = parseFloat(el.dataset.contentScore || el.getAttribute('data-content-score') || el.dataset.contentScore || '0') || 0;
        const newScore = scoreJobText(desc);

        // update badge/text elements inside card
        const badge = el.querySelector('#match-badge, .match-badge, .badge-match, .match-percent, .js-match-badge');
        const rawBefore = el.dataset.rawMatch || el.getAttribute('data-raw-match') || '';
        if (badge) {
          badge.innerHTML = `${newScore}% Match <small class="text-xs text-gray-500">(debug)</small>`;
        } else {
          // fallback: try to find any element with text that ends with "% Match" and replace
          const nodes = el.querySelectorAll('*');
          for (const n of nodes) {
            if (n.childElementCount === 0 && /%\s*Match$/i.test((n.textContent||'').trim())) {
              n.textContent = `${newScore}% Match`;
              break;
            }
          }
        }

        // also update data-content-score attribute for downstream code
        try { el.setAttribute('data-content-score', (newScore/100).toFixed(3)); } catch(e){}

        // Normalize job id for consistent matching/logs: always use a trimmed string
        const rawJobId = el.dataset.jobId || el.getAttribute('data-job-id') || '';
        const jobIdCanonical = String(rawJobId).trim();
        // expose canonical id on element for debugging and other scripts
        try { el.setAttribute('data-job-id-canonical', jobIdCanonical); } catch(e){}

        // insert a tiny debug label if not present to visually confirm ids during testing
        try {
          if (!el.querySelector('.job-id-debug')) {
            const dbgSpan = document.createElement('span');
            dbgSpan.className = 'job-id-debug';
            dbgSpan.style.cssText = 'display:block;font-size:10px;color:#666;margin-top:4px;';
            dbgSpan.textContent = `debug-id: ${jobIdCanonical || '<none>'}`;
            // append to card but avoid breaking layout: put at end
            el.appendChild(dbgSpan);
          }
        } catch(e){}

        dbg('card_scored', { jobId: jobIdCanonical || null, initialContent, newScore, rawBefore, snippet: (desc||'').slice(0,120) });
      } catch(e) { dbg('card_error', { error: String(e) }); }
    }

    dbg('finished', { updated: cards.length, user: profile.uid || profile.email });
  } catch (err) {
    dbg('fatal_error', { error: String(err) });
  }
})();
