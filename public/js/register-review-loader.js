/* Shared preview loader for review pages
   - Centralizes the robust draft-reading and DOM population logic used by review pages
   - Runs after register.js and firebase-config-global.js
   - Populates both `r_*` ids (review-1) and `review_*` ids (review-2)
*/
(function(){
  'use strict';
  // small helpers copied/adapted to avoid depending on register.js internals
  const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
  const normalizeFilename = (s) => { try { if (!s) return ''; const parts = String(s||'').split(/[/\\]+/); return parts[parts.length-1]||''; } catch(e){ return s; } };
  const flatten = (obj, out = {}, prefix = '') => { if (!obj || typeof obj !== 'object') return out; for (const k of Object.keys(obj)) { const v = obj[k]; const p = prefix ? `${prefix}.${k}` : k; if (v && typeof v === 'object' && !Array.isArray(v)) flatten(v, out, p); else out[p] = v; } return out; };
  const findFirstMatching = (obj, subs = []) => { try { const flat = flatten(obj||{}); for (const sub of subs) { const s = sub.toLowerCase(); for (const k of Object.keys(flat)) { if (k.toLowerCase().includes(s) && flat[k]) return flat[k]; } } } catch(e){} return ''; };

  const safeSet = (id, value) => {
    try {
      const el = document.getElementById(id);
      if (!el) return false;
      let out = value;
      if (out === null || out === undefined) out = '';
      else if (typeof out === 'object') out = Array.isArray(out) ? out.join(', ') : JSON.stringify(out);
      out = String(out);
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = out ?? '';
      else el.textContent = out ?? '';
      return true;
    } catch(e){ console.warn('safeSet err', id, e); return false; }
  };

  const setChoiceImage = (placeholderId, value, cardSelectors = ['.selectable-card']) => {
    try {
      const container = document.getElementById(`${placeholderId}_container`);
      const ph = document.getElementById(placeholderId);
      if (!value) { if (container) container.style.display = 'none'; if (ph) ph.src = ''; return; }
      const target = String(value).trim().toLowerCase();
      const selectors = Array.isArray(cardSelectors) ? cardSelectors : [cardSelectors];
      selectors.forEach(sel => document.querySelectorAll(sel).forEach(n => n.classList.remove('selected')));
      for (const sel of selectors) {
        for (const n of document.querySelectorAll(sel)) {
          const title = n.querySelector('h3')?.textContent?.trim()?.toLowerCase();
          if (title && title === target) {
            const img = n.querySelector('img'); if (img && ph) ph.src = img.src || ''; if (container) container.style.display = 'block'; n.classList.add('selected'); return;
          }
        }
      }
      if (container) container.style.display = 'block'; if (ph) ph.src = '';
    } catch(e){ console.warn('setChoiceImage', e); }
  };

  const parseMaybeJson = (v) => {
    if (v === null || v === undefined) return v;
    if (Array.isArray(v) || typeof v === 'object') return v;
    if (typeof v === 'string') {
      const s = v.trim(); if (!s) return '';
      if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
        try { return JSON.parse(s); } catch(e) { /* fallthrough */ }
      }
      if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
    }
    return v;
  };

  const renderWorkExperiences = (arr) => {
    try {
      const container = document.getElementById('review_job_experiences');
      if (!container) return;
      container.innerHTML = '';
      if (!arr || !arr.length) { container.innerHTML = '<p class="text-gray-600 italic">No job experiences added.</p>'; return; }
      for (const e of arr) {
        try {
          const title = e.title || e.job_title || e.jobTitle || e.role || '';
          const company = e.company || e.company_name || e.companyName || e.employer || '';
          const desc = e.description || e.job_description || e.desc || e.details || '';
          const el = document.createElement('div'); el.className = 'p-3 bg-white rounded-lg border';
          el.innerHTML = `<p class="font-semibold">${title || company || 'Experience'}</p>` + (company ? `<p class="text-sm text-gray-600">Company: ${company}</p>` : '') + (desc ? `<p class="text-sm text-gray-700 mt-1">${desc}</p>` : '');
          container.appendChild(el);
        } catch(e){}
      }
    } catch(e){ console.warn('renderWorkExperiences', e); }
  };

  // Main loader
  async function loadPreview() {
    try {
      // prefer explicit server-provided profile (admin views may set this)
      let data = (window.__mvsg_serverProfile) ? window.__mvsg_serverProfile : null;
      // try to use register.js getDraft if available (it may return { source, key, data } or raw data)
      if (!data && typeof window.getDraft === 'function') {
        try {
          const r = await window.getDraft();
          if (r && typeof r === 'object') data = r.data !== undefined ? r.data : r;
        } catch(e) { console.warn('getDraft failed', e); }
      }
      // last-resort try reading common local/session keys directly
      if (!data) {
        const keys = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data','rpi_personal'];
        for (const k of keys) {
          try { const s = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k)); if (s && typeof s === 'object') { data = s; break; } } catch(e){}
        }
      }
      // If still not found, attempt a Firestore fetch using the helper (if present)
      if (!data && typeof window.fetchFirestoreDraft === 'function') {
        try { const fb = await window.fetchFirestoreDraft(); if (fb) data = (fb.data || fb); } catch(e){ console.warn('fetchFirestoreDraft failed', e); }
      }
      if (!data) return;
      // expose for debugging
      try { window.__mvsg_lastLoadedDraft = data; } catch(e){}

      // Map fields for review-1 (r_*) and review-2 (review_*)
      const p = data.personalInfo || data.personal || data;
      if (p) {
        safeSet('r_first_name', p.first || p.first_name || p.firstName || '');
        safeSet('r_last_name', p.last || p.last_name || p.lastName || '');
        safeSet('r_age', p.age || '');
        safeSet('r_email', p.email || '');
        safeSet('r_phone', p.phone || p.mobile || '');
        safeSet('r_address', p.address || p.addr || '');
        safeSet('review_fname', p.first || p.first_name || '');
        safeSet('review_lname', p.last || p.last_name || '');
        safeSet('review_email', p.email || '');
        safeSet('review_phone', p.phone || p.mobile || '');
        safeSet('review_age', p.age || '');
      }

      // account fields
      safeSet('r_username', data.username || data.userName || '');
      safeSet('r_password', '');

      // guardian
      const g = data.guardianInfo || data.guardian || {};
      safeSet('r_guardian_first', g.guardian_first_name || g.first || g.first_name || '');
      safeSet('r_guardian_last', g.guardian_last_name || g.last || g.last_name || '');
      safeSet('r_guardian_email', g.guardian_email || g.email || '');
      safeSet('r_guardian_phone', g.guardian_phone || g.phone || '');
      const guardianRel = g.guardian_relationship || g.guardian_choice || g.relationship || data.guardian_relationship || data.guardian_choice || findFirstMatching(data, ['guardian','relationship']) || '';
      safeSet('r_guardian_relationship', guardianRel || '');
      safeSet('review_guardian_fname', g.guardian_first_name || '');
      safeSet('review_guardian_lname', g.guardian_last_name || '');
      safeSet('review_guardian_email', g.guardian_email || '');
      safeSet('review_guardian_phone', g.guardian_phone || '');

      // education / schoolWork
      const edu = data.educationInfo || data.education || {};
      const eduLevel = (edu && (edu.edu_level || edu.eduLevel)) || data.edu_level || data.edu || findFirstMatching(data, ['education','edu']) || '';
      safeSet('review_edu', eduLevel || '');
      if (edu && (edu.edu_other_text || edu.eduOtherText)) { const el = document.getElementById('review_edu_other'); if (el) { el.classList.remove('hidden'); el.textContent = 'Other: ' + (edu.edu_other_text || edu.eduOtherText); } }
      const sw = data.schoolWorkInfo || data.schoolWork || data.school || {};
      safeSet('review_school', sw.school_name || sw.schoolName || data.school_name || data.school || '');
      safeSet('review_school_name', sw.school_name || '');
      safeSet('r_school_name', sw.school_name || '');

      // certificates
      safeSet('review_certs_name', sw.certs || sw.certificates || data.certs || data.certificates || 'None');
      const certFileRaw = sw.cert_file || sw.certFile || data.cert_file || data.proofFilename || findFirstMatching(data, ['cert','certificate','proof']) || '';
      const certFile = normalizeFilename(certFileRaw || '');
      safeSet('review_certs_file', certFile || 'None');
      if (certFile) safeSet('review_certfile', certFile);
      safeSet('r_cert_file', certFile || '');

      // work type
      safeSet('review_work', sw.work_type || sw.workType || data.work_type || data.work || '');
      safeSet('r_work_type', sw.work_type || data.work_type || '');

      // work experiences
      let weArr = [];
      try {
        const raw = (data.workExperience && (data.workExperience.work_experiences || data.workExperience.experiences)) || data.work_experiences || data.workExperience || data.work_experience || findFirstMatching(data, ['work_experiences','workExperience','experiences']) || '';
        const parsed = parseMaybeJson(raw);
        if (Array.isArray(parsed)) weArr = parsed;
        else if (parsed && typeof parsed === 'object') weArr = [parsed];
        else if (typeof parsed === 'string' && parsed.trim()) {
          try { const p2 = JSON.parse(parsed); if (Array.isArray(p2)) weArr = p2; else weArr = [{ title: parsed }]; } catch(e){ weArr = [{ title: parsed }]; }
        }
      } catch(e){}
      renderWorkExperiences(weArr);

      // support
      const support = (data.supportNeed && (data.supportNeed.support_choice || data.supportNeed.supportChoice)) || data.support_choice || data.support || findFirstMatching(data, ['support','assistance']) || '';
      safeSet('review_support_choice', support || '—');
      safeSet('r_support_choice', support || '');
      setChoiceImage('review_support_choice_img', support, ['.support-card','.selectable-card']);

      // workplace
      const workplace = (data.workplace && (data.workplace.workplace_choice || data.workplace.workplaceChoice)) || data.workplace_choice || data.workplace || findFirstMatching(data, ['workplace','preferred']) || '';
      safeSet('review_workplace_choice', workplace || '—');
      safeSet('r_workplace_choice', workplace || '');
      setChoiceImage('review_workplace_choice_img', workplace, ['.workplace-card','.selectable-card']);

      // job preferences
      try {
        const jpraw = data.jobPreferences?.jobpref1 || data.jobPreferences?.jobpref1 || data.jobpref1 || data.jobpref || data.jobPreferences || findFirstMatching(data, ['jobpref','jobPreferences','job']);
        const jp = parseMaybeJson(jpraw) || [];
        if (Array.isArray(jp) && jp.length) safeSet('review_jobprefs', jp.join(', '));
      } catch(e){}

      // done
      try { window.__mvsg_lastLoadedDraft = data; } catch(e){}
    } catch (e) { console.error('register-review-loader failed', e); }
  }

  // Run after DOM is ready and after register.js loaded
  function whenReady(fn){ if (document.readyState === 'complete' || document.readyState === 'interactive') setTimeout(fn,0); else document.addEventListener('DOMContentLoaded', fn); }
  whenReady(()=>{ setTimeout(loadPreview, 50); });

  // expose for debugging
  try { window.registerReviewLoader = { loadPreview }; } catch(e){}
})();
