/* --- UNIVERSAL REGISTRATION SCRIPT ---
   - Handles Firebase initialization, user creation, multi-step registration saving (Firestore + localStorage fallback)
   - Supports offline drafts and autofill.
   - Compatible with your Blade pages: personal info, guardian, education, school/work info, work experience, support need,
     workplace, skills1, skills2, jobpref1, jobpref2, final step.
*/

(function () {
  // -----------------------
  // Utility / Initialization
  // -----------------------
  function loadScript(src) {
    return new Promise((resolve, reject) => {
      const s = document.createElement('script');
      s.src = src; s.onload = resolve; s.onerror = reject;
      document.head.appendChild(s);
    });
  }

  function readFirebaseConfig() {
    if (window.FIREBASE_CONFIG && typeof window.FIREBASE_CONFIG === 'object') return window.FIREBASE_CONFIG;
    const meta = document.querySelector('meta[name="firebase-config"]');
    if (meta && meta.content) { try { return JSON.parse(meta.content); } catch {} }
    try {
      const cached = localStorage.getItem('FIREBASE_CONFIG');
      if (cached) return JSON.parse(cached);
    } catch {}
    return null;
  }

  let firebaseInitialized = false, auth = null, db = null;
  const draftsKey = 'register_drafts';
  const log = (...a) => console.log('[reg.js]', ...a);
  const err = (...a) => console.error('[reg.js]', ...a);

  function showError(msg, id = 'regError') {
    const el = document.getElementById(id) || document.getElementById('finalError') || document.getElementById('workplaceError');
    if (el) el.textContent = msg;
    else alert(msg);
  }

  async function ensureFirebase() {
    if (firebaseInitialized) return { auth, db };
    const cfg = readFirebaseConfig();
    if (!cfg || !cfg.apiKey) {
      // Do not show a blocking alert. Use console warning and fall back to local-only mode.
      console.warn('[reg.js] Firebase not configured — using local storage only.');
      return null;
    }

    if (!window.firebase) {
      await loadScript('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
      await loadScript('https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js');
      await loadScript('https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js');
    }
    if (!firebase.apps.length) firebase.initializeApp(cfg);

    auth = firebase.auth(); db = firebase.firestore();
    try { await auth.setPersistence(firebase.auth.Auth.Persistence.LOCAL); } catch {}
    firebaseInitialized = true;
    localStorage.setItem('FIREBASE_CONFIG', JSON.stringify(cfg));
    return { auth, db };
  }

  // -----------------------
  // Local Draft Handling
  // -----------------------
  function saveLocalDraft(section, data) {
    try {
      const all = JSON.parse(localStorage.getItem(draftsKey) || '{}');
      all[section] = data;
      localStorage.setItem(draftsKey, JSON.stringify(all));
    } catch (e) { err('local draft save fail', e); }
  }

  function autofillFromLocalDrafts() {
    try {
      const all = JSON.parse(localStorage.getItem(draftsKey) || '{}');
      Object.values(all).forEach(d => fillFormFields(d));
    } catch {}
  }

  function fillFormFields(data) {
    if (!data) return;
    for (const [id, val] of Object.entries(data)) {
      const el = document.getElementById(id);
      if (!el) continue;
      if (el.type === 'checkbox') el.checked = !!val;
      else el.value = val;
    }
  }

  // -----------------------
  // Firestore Saving / Retry
  // -----------------------
  async function saveToFirestore(uid, section, data) {
    if (!db) throw new Error('Firestore not initialized');
    try {
      await db.collection('users').doc(uid).set({ [section]: data, updatedAt: firebase.firestore.FieldValue.serverTimestamp() }, { merge: true });
    } catch (e) {
      if (e.code === 'permission-denied') {
        storeFailedWriteLocally(uid, section, data);
        showPermissionHints(uid, section);
        throw new Error('permission-denied');
      }
      throw e;
    }
  }

  function storeFailedWriteLocally(uid, section, data) {
    try {
      const all = JSON.parse(localStorage.getItem('pending_writes') || '{}');
      if (!all[uid]) all[uid] = {};
      all[uid][section] = { data };
      localStorage.setItem('pending_writes', JSON.stringify(all));
    } catch (e) { err('failed to store failed write', e); }
  }

  async function flushPendingWrites(uid) {
    if (!uid) return;
    const all = JSON.parse(localStorage.getItem('pending_writes') || '{}');
    if (!all[uid]) return;
    for (const [section, { data }] of Object.entries(all[uid])) {
      try {
        await saveToFirestore(uid, section, data);
        delete all[uid][section];
      } catch (e) { if (e.message === 'permission-denied') break; }
    }
    if (!Object.keys(all[uid]).length) delete all[uid];
    localStorage.setItem('pending_writes', JSON.stringify(all));
  }

  function showPermissionHints(uid, section) {
    console.group('[Firestore Permission Error]');
    console.log('User UID:', uid);
    console.log('Section:', section);
    console.log(`Hint: check Firestore rules. Use:
rules_version = '2';
service cloud.firestore {
 match /databases/{db}/documents {
   match /users/{userId} {
     allow read, write: if request.auth != null && request.auth.uid == userId;
   }
 }
}`);
    console.groupEnd();
  }

  // -----------------------
  // Auth / Wait Helpers
  // -----------------------
  function waitForAuth(timeoutMs = 7000) {
    return new Promise((resolve) => {
      if (auth?.currentUser) return resolve(auth.currentUser);
      const timer = setTimeout(() => resolve(null), timeoutMs);
      auth.onAuthStateChanged((u) => { clearTimeout(timer); resolve(u || null); });
    });
  }

  function normalizeNextPath(p) {
    if (!p) return window.location.origin;
    if (/^https?:/.test(p)) return p;
    const base = window.location.pathname.replace(/\/[^\/]*$/, '');
    return `${window.location.origin}${base}/${p}`.replace(/([^:]\/)\/+/g, '$1');
  }

  // -----------------------
  // Section Saving Handler
  // -----------------------
  async function handleNextButton(btnId, sectionKey, nextPath) {
    const btn = document.getElementById(btnId);
    if (!btn) return;
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const data = collectPageInputs();
      // validation for education step: ensure edu_level selected
      if (sectionKey === 'educationInfo') {
        const lvl = data.edu_level || document.getElementById('edu_level')?.value || '';
        if (!lvl) {
          showError('Please select your education level.', 'educError');
          return;
        }
      }
      saveLocalDraft(sectionKey, data);
      const fb = await ensureFirebase();
      if (!fb) return (window.location.href = normalizeNextPath(nextPath));
      const user = await waitForAuth(8000);
      if (!user) {
        // Don't surface a sign-in prompt in the UI. Fall back to local-only save and continue.
        // This avoids showing a 'please sign in again' message that can be confusing.
        // Save was already stored locally via saveLocalDraft above; just redirect to next path.
        return (window.location.href = normalizeNextPath(nextPath));
      }
      try {
        await saveToFirestore(user.uid, sectionKey, data);
        window.location.href = normalizeNextPath(nextPath);
      } catch (e2) {
        showError('Saved locally due to permission issue.', `${sectionKey}Error`);
        window.location.href = normalizeNextPath(nextPath);
      }
    });
  }

  function collectPageInputs() {
    const result = {};
    document.querySelectorAll('input[id], select[id], textarea[id]').forEach(el => {
      if (el.type === 'checkbox') result[el.id] = el.checked;
      else result[el.id] = el.value;
    });
    return result;
  }

  // -----------------------
  // Personal Info: Create Account
  // -----------------------
  function handlePersonalInfoCreate() {
    // Do not attach the generic personal-info create handler on the final-step page
    if (window.location.pathname && window.location.pathname.includes('registerfinalstep')) return;
    const btn = document.getElementById('nextBtn') || document.getElementById('createAccountBtn');
    if (!btn) return;
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const first = document.getElementById('first_name')?.value || '';
      const last = document.getElementById('last_name')?.value || '';
      const email = document.getElementById('email')?.value || '';
  const pass = document.getElementById('password')?.value || '';
  // Some templates use 'confirm_password' while others use camelCase 'confirmPassword'.
  // Read either so confirmation checks work regardless of which input id the page uses.
  const confirm = document.getElementById('confirm_password')?.value || document.getElementById('confirmPassword')?.value || '';
      const phone = document.getElementById('phone')?.value || '';
      const age = document.getElementById('age')?.value || '';
      if (!email || !pass) return showError('Email and password required');
      if (pass !== confirm) return showError('Passwords do not match');
      const fb = await ensureFirebase(); if (!fb) return;
      try {
  const cred = await auth.createUserWithEmailAndPassword(email, pass);
  const uid = cred.user.uid;
  // ensure auth state is established before Firestore writes (avoids permission-denied when rules require request.auth)
  try { await new Promise(res => auth.onAuthStateChanged(u => res(u))); } catch(e){}
          // include phone and age in the stored personalInfo
          // build guardian info from form if present
          const guardian = {
            guardian_first_name: document.getElementById('guardian_first')?.value || '',
            guardian_last_name: document.getElementById('guardian_last')?.value || '',
            guardian_email: document.getElementById('guardian_email')?.value || '',
            guardian_phone: document.getElementById('guardian_phone')?.value || '',
          guardian_relationship: readSelectValueOrText('guardian_relationship') || ''
          };

          await db.collection('users').doc(uid).set({
            personalInfo: { first, last, email, phone, age },
            guardianInfo: guardian,
            role: 'User',
            createdAt: firebase.firestore.FieldValue.serverTimestamp()
          }, { merge: true });
          // send verification email (best-effort)
          await cred.user.sendEmailVerification().catch(() => {});
          // If we're on the final step page, show verification modal and then go to verify-code route
          try {
            const isFinal = window.location.pathname.includes('registerfinalstep') || window.location.pathname.includes('registerfinal');
            if (isFinal && window.mvsgShowEmailVerificationModal) {
              try { window.mvsgShowEmailVerificationModal(email || ''); } catch(e){}
              // keep on page; user will click proceed which navigates to verify-code route
              return;
            }
          } catch(e){}
          // default: go to education (guardian/personal steps removed)
          window.location.href = normalizeNextPath('registereducation');
      } catch (e2) { showError(e2.message); }
    });
  }

  // Finalize registration from the Final Step page.
  // Exposed so inline page script can call it with agreement data.
  window.mvsgFinalizeRegistration = async function(finalData) {
    try {
      console.info('[reg.js] mvsgFinalizeRegistration start', finalData || {});
      const fb = await ensureFirebase();
      if (!fb) {
        showError('Firebase not configured. Account cannot be created.', 'finalError');
        return { ok: false, error: 'no-firebase' };
      }

      const email = (finalData && finalData.email) || document.getElementById('email')?.value || '';
      let password = document.getElementById('password')?.value || window.__mvsg_generatedPassword || '';
      if (!email || !password) {
        showError('Missing email or password for account creation.', 'finalError');
        console.warn('[reg.js] Missing credentials:', { email, passwordProvided: !!password });
        return { ok: false, error: 'missing-credentials' };
      }

      // Ensure auth exists
      if (!auth) {
        console.warn('[reg.js] auth is not initialized even after ensureFirebase()');
        showError('Authentication subsystem not available.', 'finalError');
        return { ok: false, error: 'no-auth' };
      }

      // Pre-check: see if this email already has sign-in methods (helps surface clear error)
      try {
        const methods = await auth.fetchSignInMethodsForEmail(email).catch(()=>null);
        if (methods && Array.isArray(methods) && methods.length) {
          console.warn('[reg.js] fetchSignInMethodsForEmail ->', methods);
          showError('Email already in use. Please sign in or use a different email.', 'finalError');
          return { ok: false, error: 'email-already-in-use', methods };
        }
      } catch (e) {
        console.debug('[reg.js] fetchSignInMethodsForEmail failed (continuing):', e && e.message);
      }

      try {
  const cred = await auth.createUserWithEmailAndPassword(email, password);
  const uid = cred.user.uid;
  console.info('[reg.js] created auth user', uid);
  // ensure auth state is established before Firestore writes (avoids permission-denied when rules require request.auth)
  try { await new Promise(res => auth.onAuthStateChanged(u => res(u))); } catch(e){}

        // Build a personalInfo object from available sources (drafts, forms)
        let personal = {};
        let guardian = {};
        try {
          const d = await getDraft().catch(()=>null);
          const draft = d && (d.data || d) || {};
          personal.first = draft.first_name || draft.firstName || draft.first || document.getElementById('first_name')?.value || '';
          personal.last = draft.last_name || draft.lastName || draft.last || document.getElementById('last_name')?.value || '';
          personal.email = email;
          personal.phone = draft.phone || document.getElementById('phone')?.value || '';
          personal.age = draft.age || document.getElementById('age')?.value || '';

          // Build guardian from draft or DOM
          guardian.guardian_first_name = draft.guardian_first || draft.guardian_first_name || document.getElementById('guardian_first')?.value || '';
          guardian.guardian_last_name = draft.guardian_last || draft.guardian_last_name || document.getElementById('guardian_last')?.value || '';
          guardian.guardian_email = draft.guardian_email || document.getElementById('guardian_email')?.value || '';
          guardian.guardian_phone = draft.guardian_phone || document.getElementById('guardian_phone')?.value || '';
        guardian.guardian_relationship = draft.guardian_relationship || draft.guardian_choice || readSelectValueOrText('guardian_relationship') || '';
        } catch (e) { console.debug('[reg.js] build personal info failed', e); }

        // Save to Firestore (best-effort). If it fails due to rules we'll continue but persist pending writes locally
        try {
          await db.collection('users').doc(uid).set({
            personalInfo: personal,
            guardianInfo: guardian,
            agreements: finalData && finalData.agreements ? finalData.agreements : {},
            role: 'User',
            createdAt: firebase.firestore.FieldValue.serverTimestamp()
          }, { merge: true });
          console.info('[reg.js] wrote user doc to Firestore', uid);
        } catch (e) {
          console.warn('[reg.js] Failed to write user doc to Firestore', e && e.message || e);
          // store as pending write for later flush
          try { storeFailedWriteLocally(uid, 'personalInfo', personal); } catch(e2) { console.warn(e2); }
        }

        // try flushing any pending writes for this uid
        try { await flushPendingWrites(uid).catch(()=>null); } catch(e) { /* ignore */ }

        // Send verification email (best-effort)
        try { await cred.user.sendEmailVerification(); console.info('[reg.js] verification email sent'); } catch (e) { console.warn('[reg.js] sendEmailVerification failed', e); }

        // Show verification modal if available
        if (typeof window.mvsgShowEmailVerificationModal === 'function') {
          try { window.mvsgShowEmailVerificationModal(email); } catch (e) { console.warn(e); }
        }

        // redirect user to home after successful registration
        try {
          window.location.href = normalizeNextPath('/home');
        } catch (e) { /* ignore */ }
        return { ok: true, uid };
      } catch (e) {
        console.error('mvsgFinalizeRegistration error', e);
        const code = e && e.code ? e.code : 'unknown';
        const msg = e && e.message ? e.message : String(e);
        // handle common firebase auth errors gracefully
        if (code === 'auth/email-already-in-use') {
          showError('Email already in use. Please sign in or use a different email. (' + code + ')', 'finalError');
        } else if (code === 'auth/invalid-email') {
          showError('Invalid email address. (' + code + ')', 'finalError');
        } else if (code === 'auth/weak-password') {
          showError('Password is too weak. Please try again. (' + code + ')', 'finalError');
        } else if (code === 'auth/operation-not-allowed') {
          showError('Email/password sign-in is not enabled for this project. Enable it in Firebase Console. (' + code + ')', 'finalError');
        } else {
          showError(msg || 'Account creation failed. (' + code + ')', 'finalError');
        }
        return { ok: false, error: e };
      }
    } catch (e) {
      console.error('mvsgFinalizeRegistration top-level error', e);
      showError('Account creation failed (internal).', 'finalError');
      return { ok: false, error: e };
    }
  };

  // -----------------------
  // Autofill on load
  // -----------------------
  async function attachAutofill() {
    autofillFromLocalDrafts();
    const fb = await ensureFirebase();
    if (!fb) return;
    const user = await waitForAuth(8000);
    if (!user) return;
    await flushPendingWrites(user.uid);
    try {
      const doc = await db.collection('users').doc(user.uid).get();
      if (doc.exists) {
        const data = doc.data();
        fillFormFields(data.personalInfo || {});
        // also try top-level fallbacks
        if (data.personalInfo) {
          try { safeSet('phone', data.personalInfo.phone || ''); } catch(e){}
          try { safeSet('age', data.personalInfo.age || ''); } catch(e){}
        }
        Object.values(data || {}).forEach(v => typeof v === 'object' && fillFormFields(v));
      }
    } catch (e) {
      // Don't surface Firestore read errors directly to the user UI.
      // Log for debugging and try local/session/global draft fallbacks.
      console.warn('Autofill (Firestore) failed:', e);
      try {
        const fallback = await getDraft();
        if (fallback && typeof fallback === 'object') {
          const data = fallback.personalInfo || fallback.personal || fallback;
          if (data) {
            fillFormFields(data);
            try { safeSet('phone', data.phone || ''); } catch (ee){}
            try { safeSet('age', data.age || ''); } catch (ee){}
          }
        }
      } catch (e2) {
        console.warn('Autofill fallback failed:', e2);
      }
    }
  }

  // central helpers for reading drafts and populating review pages
  const tryParse = s => {
    try { return typeof s === 'string' ? JSON.parse(s) : s; } catch (e) { return null; }
  };

  const initFirebase = () => {
    try {
      if (window.FIREBASE_CONFIG && window.firebase && !(firebase.apps && firebase.apps.length)) {
        firebase.initializeApp(window.FIREBASE_CONFIG);
      }
    } catch (e) { /* ignore */ }
  };

  const fetchFirestoreDraft = async () => {
    console.debug('[reg.js] fetchFirestoreDraft start - firebase available?', !!window.firebase);
     if (!window.firebase || !firebase.auth || !firebase.firestore) return null;
     initFirebase();
     try {
       const auth = firebase.auth(), db = firebase.firestore();
       let user = auth.currentUser;
       if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
       if (!user) return null;
       const collections = ['registrations','users','registrationDrafts','profiles','userDrafts','ds_registrations'];
      for (const c of collections) {
         try {
          const doc = await db.collection(c).doc(user.uid).get().catch(()=>null);
          if (doc && doc.exists) {
            console.debug('[reg.js] fetchFirestoreDraft found in', c);
            return doc.data();
          } else {
            console.debug('[reg.js] no doc in', c);
          }
         } catch (e) { /* ignore per-collection error */ }
       }
     } catch (e) { console.warn('fetchFirestoreDraft', e); }
     return null;
   };

  // getDraft tries local/session, registrationDraft globals, then Firestore
  async function getDraft() {
    console.debug('[reg.js] getDraft() called - scanning storage keys');
     const keys = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data','rpi_personal'];
     for (const k of keys) {
       const s = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
       if (s && typeof s === 'object') { console.debug('[reg.js] getDraft found in storage key', k); return s; }
     }
     if (window.registrationDraft || window.__REGISTRATION_DRAFT__) {
       try { console.debug('[reg.js] getDraft found window.registrationDraft'); return typeof window.registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window.registrationDraft || window.__REGISTRATION_DRAFT__); } catch(e){}
     }
     // last resort: Firestore
    const fb = await fetchFirestoreDraft();
    if (fb) { console.debug('[reg.js] getDraft returning Firestore draft (non-null)'); return fb; }
    console.debug('[reg.js] getDraft() no draft found');
    return null;
   }

  // readStored(key) checks local/session/global draft keys for single field
  function readStored(key) {
    try {
      const s = localStorage.getItem(key) || sessionStorage.getItem(key);
      if (s) { try { return JSON.parse(s); } catch(e){ return s; } }
      const g = window.registrationDraft || window.__REGISTRATION_DRAFT__;
      if (g) {
        try {
          const parsed = typeof g === 'string' ? JSON.parse(g) : g;
          if (parsed && parsed[key] !== undefined) return parsed[key];
        } catch(e){}
      }
      return null;
    } catch(e){ return null; }
  }

  // flatten and find helper
  function flatten(obj, out = {}, prefix = '') {
    if (!obj || typeof obj !== 'object') return out;
    for (const k of Object.keys(obj)) {
      const v = obj[k];
      const p = prefix ? `${prefix}.${k}` : k;
      if (v && typeof v === 'object' && !Array.isArray(v)) flatten(v, out, p);
      else out[p] = v;
    }
    return out;
  }
  function findFirstMatching(obj, subs = []) {
    try {
      const flat = flatten(obj || {});
      for (const sub of subs) {
        const s = sub.toLowerCase();
        for (const k of Object.keys(flat)) {
          if (k.toLowerCase().includes(s) && flat[k]) return flat[k];
        }
      }
    } catch(e){ /* ignore */ }
    return '';
  }

  // safe DOM setters
  function safeSet(id, value) {
    const el = document.getElementById(id);
    if (!el) return;
    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.value = value ?? '';
    else el.textContent = value ?? '';
  }

  // Read select value or fallback to option text (useful when option value is empty)
  function readSelectValueOrText(id) {
    try {
      const el = document.getElementById(id);
      if (!el) return '';
      const v = el.value;
      if (v !== undefined && v !== null && String(v).trim()) return String(v).trim();
      const opt = el.options && el.selectedIndex >= 0 ? el.options[el.selectedIndex] : null;
      return opt ? (opt.textContent || opt.innerText || '').trim() : '';
    } catch (e) { return ''; }
  }

  // copy matching card image into per-field preview container and mark matched card selected
  function setChoiceImage(placeholderId, value, cardSelectors = ['.selectable-card']) {
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
            const img = n.querySelector('img');
            if (img && ph) ph.src = img.src || '';
            if (container) container.style.display = 'block';
            n.classList.add('selected');
            return;
          }
        }
      }
      if (container) container.style.display = 'none';
      if (ph) ph.src = '';
    } catch(e){ console.warn('setChoiceImage', e); }
  }

  // Make key helpers available globally for inline review page scripts
  // (some review blade templates call findFirstMatching, setChoiceImage, safeSet, tryParse directly)
  try {
    window.findFirstMatching = findFirstMatching;
    window.setChoiceImage = setChoiceImage;
    window.safeSet = safeSet;
    window.tryParse = tryParse;
    // also keep getDraft/readStored/populateReview accessible
    window.getDraft = getDraft;
    window.readStored = readStored;
  window.populateReview = window.populateReview || populateReview;
  } catch (e) {
    console.warn('Could not attach global helpers', e);
  }

  // Top-level populate function — populates fields commonly used across review pages
  async function populateReview() {
    try {
      console.debug('[reg.js] populateReview() start');
      let data = await getDraft();
      console.debug('[reg.js] populateReview() got data:', data);

      // If draft looks partial (only personal fields) try Firestore as fallback and merge
      try {
        const neededKeys = ['guardianInfo','educationInfo','schoolWorkInfo','jobPreferences','skills','workExperience','workplace','supportNeed'];
        const hasAnyNeeded = (d) => neededKeys.some(k => d && (d[k] !== undefined && d[k] !== null));
        let mergedFromFirestore = false;
        // Ensure Firebase SDK is loaded if possible so fetchFirestoreDraft can run
        try { await ensureFirebase(); } catch(e) { /* ignore */ }
        if (!hasAnyNeeded(data) && typeof fetchFirestoreDraft === 'function') {
          try {
            const remote = await fetchFirestoreDraft();
            if (remote && typeof remote === 'object') {
              // merge only keys that are missing locally
              for (const k of Object.keys(remote)) {
                if (data == null || data[k] === undefined || data[k] === null || (typeof data[k] === 'object' && Object.keys(data[k]||{}).length === 0)) {
                  data = data || {};
                  data[k] = remote[k];
                }
              }
              mergedFromFirestore = true;
              window.__mvsg_mergedFromFirestore = true;
              console.debug('[reg.js] populateReview merged missing keys from Firestore');
            }
          } catch(e) { console.warn('populateReview fetchFirestore fallback failed', e); }
        }
        // expose for debug
        if (!window.__mvsg_mergedFromFirestore) window.__mvsg_mergedFromFirestore = mergedFromFirestore;
      } catch(e) { console.warn('populateReview merge check failed', e); }

      const parseMaybeJson = (v) => {
        if (v === null || v === undefined) return v;
        if (Array.isArray(v) || typeof v === 'object') return v;
        if (typeof v === 'string') {
          const s = v.trim();
          if (!s) return '';
          // try JSON parse for arrays/objects
          if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
            try { return JSON.parse(s); } catch(e) { /* fall through */ }
          }
          // if it's a comma-separated list fallback, split
          if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
        }
        return v;
      };

      // personal
      const p = data?.personalInfo || data?.personal || data?.personal || data?.personalInfo || data;
      if (p) {
        safeSet('review_fname', p.first_name || p.firstName || p.fname || p?.first || p.first || '');
        safeSet('review_lname', p.last_name || p.lastName || p.lname || p?.last || p.last || '');
        safeSet('review_email', p.email || p.emailAddress || p.email || '');
        safeSet('review_phone', p.phone || p.mobile || p.phone || '');
        safeSet('review_age', p.age || '');
      }

      // guardian
      const g = data?.guardianInfo || data?.guardian || {};
      safeSet('review_guardian_fname', g.guardian_first_name || g.first_name || g.first || data.guardian_first_name || '');
      safeSet('review_guardian_lname', g.guardian_last_name || g.last_name || g.last || data.guardian_last_name || '');
      safeSet('review_guardian_email', g.guardian_email || g.email || '');
      safeSet('review_guardian_phone', g.guardian_phone || g.phone || '');
      const guardianRel = g.guardian_choice || g.relationship || data.guardian_choice || findFirstMatching(data, ['guardian_choice','relationship','guardian']);
      safeSet('review_guardian_relationship', guardianRel || '');
      setChoiceImage('review_guardian_relationship_img', guardianRel, ['.guardian-card','.selectable-card']);

      // education
      const edu = data.educationInfo || data.education || findFirstMatching(data, ['education','edu','edu_level']) || '';
      safeSet('review_education_level', edu || '');
      setChoiceImage('review_education_level_img', edu, ['.education-card','.selectable-card']);
      safeSet('review_school_name', data.schoolWorkInfo?.school_name || data.school_name || '');
      safeSet('review_certs', data.schoolWorkInfo?.certs || data.certs || '');

      // work years / work experience preview
      const workYears = data.workExperience?.[0]?.years || data.work_years || findFirstMatching(data, ['work_years','workexperience','years']) || '';
      setChoiceImage('review_work_years_img', workYears, ['.workyr-card','.selectable-card']);

      // normalize work experiences: accept array, stringified JSON array, or comma/newline separated
      let weArr = [];
      try {
        const raw = data.workExperience?.work_experiences || data.work_experiences || readStored('work_experiences') || readStored('workExperience') || data.workExperience || null;
        const parsed = parseMaybeJson(raw);
        if (Array.isArray(parsed)) weArr = parsed;
        else if (typeof parsed === 'string' && parsed) weArr = [parsed];
      } catch(e){ /* ignore */ }
      if (weArr && weArr.length) {
        safeSet('work_experiences', JSON.stringify(weArr));
        if (window.renderWorkExperiencesFromArray && typeof window.renderWorkExperiencesFromArray === 'function') {
          try { window.renderWorkExperiencesFromArray(weArr); } catch(e){/*ignore*/ }
        }
      }

      // skills: handle nested maps and stringified arrays
      let skillsArr = [];
      try {
        const sFromData = data.skills || data.skillList || data.skills_page1 || data.skills_page2 || data.skillsPage1 || data.skillsPage2 || null;
        // try nested map 'skills' containing pages
        if (data.skills && typeof data.skills === 'object') {
          const fromMap = data.skills.skills_page1 || data.skills.skills_page2 || data.skills_page1 || data.skills_page2 || null;
          if (fromMap) {
            const p = parseMaybeJson(fromMap);
            if (Array.isArray(p)) skillsArr.push(...p);
            else if (typeof p === 'string') skillsArr.push(...(p.split(',').map(x=>x.trim()).filter(Boolean)));
          }
        }
        // try top-level string/array fields
        if (Array.isArray(sFromData)) skillsArr.push(...sFromData);
        else if (typeof sFromData === 'string' && sFromData) {
          const p = parseMaybeJson(sFromData);
          if (Array.isArray(p)) skillsArr.push(...p);
          else skillsArr.push(...sFromData.split(',').map(x=>x.trim()).filter(Boolean));
        }
        // also read stored keys (local/session)
        const s1 = parseMaybeJson(readStored('skills_page1') || readStored('skills1') || readStored('skills')) || [];
        const s2 = parseMaybeJson(readStored('skills_page2') || readStored('skills2')) || [];
        if (Array.isArray(s1)) skillsArr.push(...s1);
        if (Array.isArray(s2)) skillsArr.push(...s2);
      } catch(e){ /* ignore */ }
      const uniqSkills = [...new Set((skillsArr||[]).map(x => typeof x === 'string' ? x.trim() : x).filter(Boolean))];
      if (uniqSkills.length) {
        safeSet('review_skills_list', uniqSkills.join(', '));
        setChoiceImage('review_skills_img', uniqSkills[0], ['.skills-card','.selectable-card']);
        document.querySelectorAll('.skills-card, .selectable-card').forEach(card => {
          const title = card.querySelector('h3')?.textContent?.trim();
          if (title && uniqSkills.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
        });
      }

      // support & workplace — handle nested maps supportNeed/workplace and their internal keys
      const support = (data.supportNeed && (data.supportNeed.support_choice || data.supportNeed.supportChoice)) || data.support_choice || data.support || findFirstMatching(data, ['support','support_type','support_need']) || '';
      safeSet('review_support_choice', support || '');
      setChoiceImage('review_support_choice_img', support, ['.support-card','.selectable-card']);

      const workplace = (data.workplace && (data.workplace.workplace_choice || data.workplace.workplaceChoice)) || data.workplace_choice || data.workplace || data.workplaceInfo || findFirstMatching(data, ['workplace','work_place','work']) || '';
      safeSet('review_workplace_choice', workplace || '');
      setChoiceImage('review_workplace_choice_img', workplace, ['.workplace-card','.selectable-card']);

      // job preferences (jobpref1/jobpref2) — accept nested map data.jobPreferences or top-level keys
      let jpList = [];
      try {
        const jp1raw = data.jobPreferences?.jobpref1 || data.jobPreferences?.jobPref1 || data.jobpref1 || data.jobPref1 || readStored('jobpref1') || readStored('jobPref1') || null;
        const jp2raw = data.jobPreferences?.jobpref2 || data.jobPreferences?.jobPref2 || data.jobpref2 || data.jobPref2 || readStored('jobpref2') || readStored('jobPref2') || null;
        const p1 = parseMaybeJson(jp1raw);
        const p2 = parseMaybeJson(jp2raw);
        if (Array.isArray(p1)) jpList.push(...p1);
        else if (typeof p1 === 'string' && p1) jpList.push(...p1.split(',').map(x=>x.trim()).filter(Boolean));
        if (Array.isArray(p2)) jpList.push(...p2);
        else if (typeof p2 === 'string' && p2) jpList.push(...p2.split(',').map(x=>x.trim()).filter(Boolean));
      } catch(e){ /* ignore */ }
      const prefs = jpList.map(x => typeof x === 'string' ? x.trim() : x).filter(Boolean);
      if (prefs.length) {
        safeSet('review_jobprefs', prefs.join(', '));
        setChoiceImage('review_jobprefs_img', prefs[0], ['.jobpref-card','.selectable-card']);
        document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card => {
          const title = card.querySelector('h3')?.textContent?.trim();
          if (title && prefs.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
        });
      }

      // done
      window.__mvsg_lastLoadedDraft = data;
      window.__mvsg_lastDraftSource = (function(){
        try {
          if (!data) return 'none';
          const hasLocal = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data'].some(k => !!localStorage.getItem(k) || !!sessionStorage.getItem(k));
          return hasLocal ? 'localStorage/session' : 'firestore_or_global';
        } catch(e){ return 'unknown'; }
      })();
      console.debug('[reg.js] populateReview done. source=', window.__mvsg_lastDraftSource);
      
      try { window.dispatchEvent(new CustomEvent('mvsg:populateDone', { detail: { source: window.__mvsg_lastDraftSource } })); } catch(e){}
      try { console.debug('[register.js] loaded draft for review', { snapshot: data }); } catch(e){}
    } catch (e) {
      console.error('populateReview error', e);
    }
  }

  // debug helper you can run in console to print environment and run checks
  window.__mvsg_debugRun = async function () {
    try {
      console.group('[mvsg debug]');
      console.log('register.js loaded:', !!window.populateReview);
      console.log('FIREBASE_CONFIG present:', !!window.FIREBASE_CONFIG, window.FIREBASE_CONFIG && window.FIREBASE_CONFIG.projectId);
      console.log('localStorage keys (matching register/draft):');
      Object.keys(localStorage).filter(k=>k.toLowerCase().includes('reg')||k.toLowerCase().includes('draft')||k.toLowerCase().includes('work')||k.toLowerCase().includes('skills')).forEach(k=>console.log(k, localStorage.getItem(k)));
      console.log('window.registrationDraft present:', !!window.registrationDraft, window.registrationDraft || window.__REGISTRATION_DRAFT__);
      const d = await getDraft().catch(e=>{ console.warn('getDraft err', e); return null; });
      console.log('getDraft() -> ', d);
      console.log('lastLoadedDraft:', window.__mvsg_lastLoadedDraft);
      console.log('lastDraftSource:', window.__mvsg_lastDraftSource);
      console.groupEnd();
      return { draft: d, last: window.__mvsg_lastLoadedDraft, source: window.__mvsg_lastDraftSource };
    } catch(e) { console.error('debugRun failed', e); return null; }
  };

  // -----------------------
  // Main Entry
  // -----------------------
  document.addEventListener('DOMContentLoaded', async () => {
    attachAutofill();
    handlePersonalInfoCreate();
    const mapping = [
      ['guardianNext', 'guardianInfo', '/registereducation'],
      ['educNext', 'educationInfo', '/registerschoolworkinfo'],
      ['schoolNext', 'schoolWorkInfo', '/registerworkexpinfo'],
      ['workExpNext', 'workExperience', '/registersupportneed'],
      ['supportNext', 'supportNeed', '/registerworkplace'],
      ['workplaceNext', 'workplace', '/registerskills1'],
      // skills2 step removed: skills1 now advances directly to job preferences
  ['skills1Next', 'skills', '/registerjobpreference1'],
  // single job preference page flow: jobpref1 now advances directly to review
  ['jobpref1Next', 'jobPreferences', '/registerreview1'],
      ['finalizeNext', 'finalize', '/home']
    ];
    mapping.forEach(([btn, key, path]) => handleNextButton(btn, key, path));
    // If this page contains review placeholders, auto-run populateReview to hydrate previews
    try {
      const hasReviewEls = !!document.querySelector('[id^="review_"]');
      if (hasReviewEls && typeof populateReview === 'function') {
        try { await populateReview(); console.debug('[reg.js] populateReview auto-run complete'); } catch(e){ console.warn('[reg.js] populateReview auto-run failed', e); }
      }
    } catch(e) { /* ignore */ }
    
  });
})();

(function(){
  // quick logger
  const info = (...a)=>console.info('[reg.js]',...a);
  const debug = (...a)=>console.debug('[reg.js]',...a);
  const warn = (...a)=>console.warn('[reg.js]',...a);

  // safe JSON parse
  function tryParse(s){
    try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; }
  }

  // keys we commonly use for drafts
  const DRAFT_KEYS = ['registrationDraft','registration_draft','dsRegistrationDraft','ds_registration','registerDraft','regDraft','reg_data','rpi_personal','workExperience','skills_page1','skills_page2','jobpref1','jobpref2'];

  // try to read a draft from local/session storage or window global
  async function getDraft(){
    // check local/session keys
    for(const k of DRAFT_KEYS){
      try {
        const v = tryParse(localStorage.getItem(k)) || tryParse(sessionStorage.getItem(k));
        if (v && typeof v === 'object') {
          debug('getDraft: found in storage key', k);
          return { source: 'localStorage', key: k, data: v };
        }
      } catch(e){ /* ignore */ }
    }
    // check global alias
    try {
      if (window.registrationDraft || window.__REGISTRATION_DRAFT__){
        const g = typeof window.registrationDraft === 'string' ? tryParse(window.registrationDraft) : (window.registrationDraft || window.__REGISTRATION_DRAFT__);
        if (g) { debug('getDraft: found in window.registrationDraft'); return { source:'global', key: 'registrationDraft', data: g }; }
      }
    } catch(e){ /* ignore */ }

    // no Firestore fetch here (keep simple); caller can rely on existing Firestore logic if present elsewhere
    debug('getDraft: no draft found in local/session/global');
    return { source: 'none', key: null, data: null };
  }

  // lightweight populateReview: only logs attempts and optionally writes into known review IDs (non-destructive)
  async function populateReview(){
    try {
      debug('populateReview: start');
      const result = await getDraft();
      debug('populateReview: draft result', result);
      const data = result.data || {};
      // best-effort map common fields into page if present
      const p = data.personalInfo || data.personal || data;
      if (p) {
        if (document.getElementById('review_fname')) document.getElementById('review_fname').value = p.first_name || p.firstName || p.first || '';
        if (document.getElementById('review_lname')) document.getElementById('review_lname').value = p.last_name || p.lastName || p.last || '';
        if (document.getElementById('review_email')) document.getElementById('review_email').value = p.email || p.emailAddress || '';
        if (document.getElementById('review_phone')) document.getElementById('review_phone').value = p.phone || p.mobile || '';
      }
      // expose snapshot for quick inspection
      window.__mvsg_lastLoadedDraft = data;
      window.__mvsg_lastDraftSource = result.source;
      debug('populateReview: finished — source', result.source);
      return { ok:true, source: result.source, data };
    } catch(e){
      warn('populateReview error', e);
      return { ok:false, error: e.message || String(e) };
    }
  }

  // debug runner: prints environment and getDraft() result
  async function __mvsg_debugRun(){
    try {
      console.group('%c[Mvsg Debug]', 'color:#155e75;font-weight:700');
      console.log('register.js present:', true);
      console.log('FIREBASE_CONFIG present:', !!window.FIREBASE_CONFIG, window.FIREBASE_CONFIG || null);
      try {
        console.log('firebase available:', !!window.firebase);
        if (window.firebase && firebase.auth) {
          console.log('firebase currentUser:', firebase.auth().currentUser || null);
        }
      } catch(e){ /* ignore */ }
      console.log('localStorage keys (matching common prefixes):');
      Object.keys(localStorage).filter(k=>/reg|draft|work|skill|jobpref/i.test(k)).forEach(k=>console.log(k, localStorage.getItem(k)));
      const draft = await getDraft();
      console.log('getDraft -> source:', draft.source, 'key:', draft.key);
      console.log('draft data (preview):', draft.data);
      console.log('lastLoadedDraft:', window.__mvsg_lastLoadedDraft || null);
      console.log('lastDraftSource:', window.__mvsg_lastDraftSource || null);
      console.groupEnd();
      return { draft: draft.data, source: draft.source };
    } catch(e){
      console.error('[reg.js] __mvsg_debugRun failed', e);
      return null;
    }
  }

  // small init log and event so pages can detect the script is loaded
    try {
    info('register.js initialized');
    window.__mvsg_debugRun = __mvsg_debugRun;
    // Do not overwrite existing implementations from the main module; only expose these helpers if not present
    window.getDraft = window.getDraft || getDraft;
    window.populateReview = window.populateReview || populateReview;
    // notify other inline scripts that register.js is available
    try { window.dispatchEvent(new CustomEvent('mvsg:registerLoaded')); } catch(e){}
  } catch(e){ warn('register.js init failed', e); }

  // Auto-run a debug log when included in dev mode (kept quiet: uses debug).
  document.addEventListener('DOMContentLoaded', function(){
    debug('register.js DOMContentLoaded — ready');
    // do not auto-populate aggressively; leave it to pages to call populateReview or use the shared event
    // but expose a short auto-log
    debug('run window.__mvsg_debugRun() to inspect draft/source and environment.');
  });
})();
