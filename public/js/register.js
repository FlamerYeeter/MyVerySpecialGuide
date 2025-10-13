/* Shared registration JS:
   - Dynamically loads Firebase (compat v8) when a firebase config is provided via
     window.FIREBASE_CONFIG or a meta[name="firebase-config"].
   - Handles user creation on Personal Info page and saves page data to Firestore (merge).
   - Provides autofill from Firestore and localStorage drafts.
   - Falls back to localStorage-only drafts when Firebase isn't configured.
*/

(function () {
  // Minimal helper to load external script
  function loadScript(src) {
    return new Promise((resolve, reject) => {
      const s = document.createElement('script');
      s.src = src;
      s.onload = () => resolve();
      s.onerror = (e) => reject(e);
      document.head.appendChild(s);
    });
  }

  // Try to read firebase config from window global, meta tag or localStorage cache
  function readFirebaseConfig() {
    // 1) explicit page-provided global (preferred)
    if (window.FIREBASE_CONFIG && typeof window.FIREBASE_CONFIG === 'object') return window.FIREBASE_CONFIG;

    // 2) meta tag (if some pages embed it)
    const meta = document.querySelector('meta[name="firebase-config"]');
    if (meta && meta.content) {
      try { return JSON.parse(meta.content); } catch (e) { console.warn('Invalid firebase-config meta JSON', e); }
    }

    // 3) cached in localStorage by earlier page (persisted after init)
    try {
      const cached = localStorage.getItem('FIREBASE_CONFIG');
      if (cached) {
        const parsed = JSON.parse(cached);
        if (parsed && parsed.apiKey) {
          // rehydrate global for debugging/visibility
          try { window.FIREBASE_CONFIG = parsed; } catch (e) { /* ignore */ }
          return parsed;
        }
      }
    } catch (e) {
      console.warn('Failed reading cached FIREBASE_CONFIG from localStorage', e);
    }
    return null;
  }

  // Globals
  let firebaseInitialized = false;
  let auth = null, db = null;
  const draftsKey = 'register_drafts';
  const log = (...a) => console.log('[reg.js]', ...a);
  const err = (...a) => console.error('[reg.js]', ...a);

  // UI helper to show errors on page (falls back to alert)
  function showError(message, elementId = 'regError') {
    if (!message) message = 'Unknown error';
    const el = document.getElementById(elementId);
    if (el) {
      el.textContent = message;
    } else {
      // fallback to generic error element if present
      const fallback = document.getElementById('finalError') || document.getElementById('workplaceError');
      if (fallback) fallback.textContent = message;
      else console.warn('showError fallback: no element to display error');
    }
    console.warn('[reg.js] user-visible error:', message);
  }

  // Ensure firebase (compat v8) is loaded and initialized if config exists
  async function ensureFirebase() {
    if (firebaseInitialized) return { auth, db };

    const cfg = readFirebaseConfig();
    // require at least apiKey to consider config valid
    if (!cfg || !cfg.apiKey) {
      log('No Firebase config found or missing apiKey — running in localStorage-only mode');
      showError('Firebase not configured. Drafts will be saved locally. (Set FIREBASE_* env variables)', 'regError');
      return null;
    }
    // show a small hint in console about config (do not print secret keys in production)
    log('Firebase config found (projectId):', cfg.projectId || '(missing projectId)', 'apiKey present:', !!cfg.apiKey);

    // load compat SDKs (v8.x)
    if (!window.firebase) {
      try {
        await loadScript('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
        await loadScript('https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js');
        await loadScript('https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js');
      } catch (e) {
        err('Failed to load Firebase SDKs', e);
        showError('Failed to load Firebase SDKs. Check console for network errors.');
        return null;
      }
    }

    try {
      if (!firebase.apps.length) {
        firebase.initializeApp(cfg);
        log('Firebase initialized');
      } else {
        log('Firebase app already initialized');
      }
      auth = firebase.auth();
      db = firebase.firestore();
      try {
        await auth.setPersistence(firebase.auth.Auth.Persistence.LOCAL);
        log('Auth persistence set to LOCAL');
      } catch (pErr) {
        err('setPersistence failed (continuing)', pErr);
      }
      // Persist the config so other pages can re-initialize from the cached config.
      try {
        localStorage.setItem('FIREBASE_CONFIG', JSON.stringify(cfg));
        log('Persisted FIREBASE_CONFIG to localStorage for subsequent pages');
      } catch (e) {
        console.warn('Could not persist FIREBASE_CONFIG to localStorage', e);
      }
      firebaseInitialized = true;
      return { auth, db };
    } catch (e) {
      err('Firebase init failed', e);
      showError('Firebase initialization failed. Check console for details.');
      return null;
    }
  }

  // Collect inputs on the page into an object keyed by element id
  function collectPageInputs() {
    const result = {};
    const els = document.querySelectorAll('input[id], textarea[id], select[id]');
    els.forEach(el => {
      if (el.type === 'checkbox') result[el.id] = !!el.checked;
      else if (el.type === 'radio') {
        if (el.checked) result[el.name || el.id] = el.value;
      } else result[el.id] = el.value;
    });

    // convert several JSON hidden strings back into arrays so Firestore stores arrays
    try {
      ['skills_page1','skills_page2','jobpref1','jobpref2','work_experiences'].forEach(key => {
        if (result.hasOwnProperty(key) && typeof result[key] === 'string') {
          try {
            const parsed = JSON.parse(result[key]);
            if (Array.isArray(parsed)) result[key] = parsed;
            else result[key] = parsed ? [parsed] : [];
          } catch (e) {
            // not JSON — if non-empty string, turn into single-element array
            if (result[key]) result[key] = [result[key]];
            else result[key] = [];
          }
        }
      });
    } catch (e) { /* ignore parsing errors */ }

    return result;
  }

  // Save draft to localStorage
  function saveLocalDraft(sectionKey, data) {
    try {
      const all = JSON.parse(localStorage.getItem(draftsKey) || '{}');
      all[sectionKey] = data;
      localStorage.setItem(draftsKey, JSON.stringify(all));
      log('Saved local draft', sectionKey);
    } catch (e) { err('Could not save local draft', e); }
  }

  // Read skills hidden inputs (JSON) and return a deduplicated array
  function getCombinedSkillsFromHidden() {
    try {
      const h1 = document.getElementById('skills_page1');
      const h2 = document.getElementById('skills_page2');
      let a1 = [], a2 = [];
      if (h1 && h1.value) {
        try { a1 = JSON.parse(h1.value || '[]'); } catch (e) { a1 = String(h1.value || '').trim() ? [h1.value] : []; }
      }
      if (h2 && h2.value) {
        try { a2 = JSON.parse(h2.value || '[]'); } catch (e) { a2 = String(h2.value || '').trim() ? [h2.value] : []; }
      }
      const merged = Array.from(new Set([...(Array.isArray(a1) ? a1 : []), ...(Array.isArray(a2) ? a2 : [])].filter(Boolean)));
      return merged;
    } catch (e) {
      console.warn('[reg.js] getCombinedSkillsFromHidden failed', e);
      return [];
    }
  }

  // Read jobpref hidden inputs (JSON) and return a deduplicated array
  function getCombinedJobPrefsFromHidden() {
    try {
      const h1 = document.getElementById('jobpref1');
      const h2 = document.getElementById('jobpref2');
      let a1 = [], a2 = [];
      if (h1 && h1.value) {
        try { a1 = JSON.parse(h1.value || '[]'); } catch (e) { a1 = String(h1.value || '').trim() ? [h1.value] : []; }
      }
      if (h2 && h2.value) {
        try { a2 = JSON.parse(h2.value || '[]'); } catch (e) { a2 = String(h2.value || '').trim() ? [h2.value] : []; }
      }
      const merged = Array.from(new Set([...(Array.isArray(a1) ? a1 : []), ...(Array.isArray(a2) ? a2 : [])].filter(Boolean)));
      return merged;
    } catch (e) {
      console.warn('[reg.js] getCombinedJobPrefsFromHidden failed', e);
      return [];
    }
  }

  // Autofill inputs from a data object (matching by id)
  function fillFormFields(data) {
    if (!data || typeof data !== 'object') return;
    Object.entries(data).forEach(([k, v]) => {
      // If Firestore stored a combined skills array, set both hidden inputs and select matching cards
      if (k === 'skills' && Array.isArray(v)) {
        try {
          const json = JSON.stringify(v || []);
          const hid1 = document.getElementById('skills_page1');
          const hid2 = document.getElementById('skills_page2');
          if (hid1) hid1.value = json;
          if (hid2) hid2.value = json;
        } catch (e) { /* ignore */ }
        try {
          document.querySelectorAll('.skills-card').forEach(c => {
            const val = c.getAttribute && c.getAttribute('data-value');
            if (val && Array.isArray(v) && v.indexOf(val) !== -1) c.classList.add('selected');
            else c.classList.remove('selected');
          });
        } catch (e) { /* ignore */ }
        return;
      }

      // If Firestore stored workExperience as an array, propagate to hidden field and try to render UI
      if (k === 'workExperience' && Array.isArray(v)) {
        try {
          const hid = document.getElementById('work_experiences');
          if (hid) hid.value = JSON.stringify(v || []);
        } catch (e) { /* ignore */ }
        try {
          if (window.renderWorkExperiencesFromArray) window.renderWorkExperiencesFromArray(v);
        } catch (e) { /* ignore */ }
        return;
      }

      // If Firestore stored combined job preferences array, set both hidden inputs and select matching job cards
      if (k === 'jobPreferences' && Array.isArray(v)) {
        try {
          const json = JSON.stringify(v || []);
          const hid1 = document.getElementById('jobpref1');
          const hid2 = document.getElementById('jobpref2');
          if (hid1) hid1.value = json;
          if (hid2) hid2.value = json;
        } catch (e) { /* ignore */ }
        try {
          document.querySelectorAll('.jobpref-card').forEach(c => {
            const val = c.getAttribute && c.getAttribute('data-value');
            if (val && Array.isArray(v) && v.indexOf(val) !== -1) c.classList.add('selected');
            else c.classList.remove('selected');
          });
        } catch (e) { /* ignore */ }
        return;
      }

      // legacy/individual jobPref arrays (fallback)
      if ((k === 'jobPref1' || k === 'jobPref2' || k === 'jobpref1' || k === 'jobpref2') && Array.isArray(v)) {
        try {
          const id = (k.toLowerCase().includes('jobpref2')) ? 'jobpref2' : 'jobpref1';
          const hid = document.getElementById(id);
          if (hid) hid.value = JSON.stringify(v || []);
        } catch (e) { /* ignore */ }
        try {
          document.querySelectorAll('.jobpref-card').forEach(c => {
            const val = c.getAttribute && c.getAttribute('data-value');
            if (val && Array.isArray(v) && v.indexOf(val) !== -1) c.classList.add('selected');
            else c.classList.remove('selected');
          });
        } catch (e) { /* ignore */ }
        return;
      }

      const el = document.getElementById(k);
      if (!el) return;
      try {
        if (el.type === 'checkbox') el.checked = !!v;
        else el.value = (v === null || v === undefined) ? '' : v;
      } catch (e) { /* ignore readonly/non-standard elements */ }
    });
  }

  // Fill from localStorage drafts (if present)
  function autofillFromLocalDrafts() {
    try {
      const all = JSON.parse(localStorage.getItem(draftsKey) || '{}');
      if (all && typeof all === 'object') {
        // Merge all sections into form where ids match
        Object.values(all).forEach(section => {
          if (section && typeof section === 'object') fillFormFields(section);
        });
      }
      // legacy admin draft rpi_personal
      const rpi = localStorage.getItem('rpi_personal');
      if (rpi) {
        try {
          const d = JSON.parse(rpi);
          if (d.firstName) fillFormFields({ first_name: d.firstName });
          if (d.lastName) fillFormFields({ last_name: d.lastName });
          if (d.email) fillFormFields({ email: d.email });
        } catch (e) { /* ignore */ }
      }
    } catch (e) {
      err('autofillFromLocalDrafts error', e);
    }
  }

  // small helper: normalize nextPath to an absolute URL within the same app base
  function normalizeNextPath(p) {
    if (!p) return p;
    // already absolute URL -> return as-is
    if (/^https?:\/\//.test(p)) return p;

    // compute base from current pathname (remove last segment which is the current page)
    const currentPath = window.location.pathname || '/';
    // baseDir ends with no trailing slash, e.g. "/MyVerySpecialGuide/public"
    const baseDir = currentPath.endsWith('/') ? currentPath.replace(/\/$/, '') : currentPath.replace(/\/[^\/]*$/, '');

    // If the provided path starts with '/', treat it as a route inside the same app base.
    // Example: p = '/registereducation' -> origin + baseDir + '/registereducation'
    if (p.startsWith('/')) {
      const candidate = (window.location.origin + baseDir + p).replace(/([^:]\/)\/+/g, '$1');
      console.debug('[reg.js] normalizeNextPath (leading /):', p, '->', candidate);
      return candidate;
    }

    // Relative path (no leading slash): append to current directory
    // Determine current directory with trailing slash, e.g. "/MyVerySpecialGuide/public/"
    const currentDir = currentPath.endsWith('/') ? currentPath : currentPath.replace(/\/[^\/]*$/, '/');
    const candidate = (window.location.origin + currentDir + p).replace(/([^:]\/)\/+/g, '$1');
    console.debug('[reg.js] normalizeNextPath (relative):', p, '->', candidate);
    return candidate;
  }

  // Retry pending failed writes persisted by storeFailedWriteLocally.
  async function flushPendingWrites(uid) {
    if (!uid) return;
    try {
      const key = 'pending_writes';
      const all = JSON.parse(localStorage.getItem(key) || '{}');
      if (!all || typeof all !== 'object') return;
      const userEntries = all[uid];
      if (!userEntries || typeof userEntries !== 'object') return;
      log('Flushing pending_writes for uid', uid, Object.keys(userEntries));
      for (const [sectionKey, entry] of Object.entries(userEntries)) {
        try {
          // entry may contain .data
          const data = entry && entry.data ? entry.data : entry;
          await saveToFirestore(uid, sectionKey, data);
          log('Flushed pending write for', sectionKey);
          // remove flushed entry
          delete all[uid][sectionKey];
        } catch (e) {
          // stop on permission issues; other errors continue
          if (e && e.message === 'permission-denied') {
            err('flushPendingWrites aborted: permission-denied for', sectionKey, e);
            break;
          }
          console.warn('flushPendingWrites: failed to flush', sectionKey, e);
        }
      }
      // cleanup empty uid
      if (all[uid] && Object.keys(all[uid]).length === 0) delete all[uid];
      localStorage.setItem(key, JSON.stringify(all));
    } catch (e) {
      err('flushPendingWrites failed', e);
    }
  }

  // Save to Firestore under users/{uid} -> merge { sectionKey: data }
  async function saveToFirestore(uid, sectionKey, data) {
    if (!db) throw new Error('Firestore not initialized');
    const payload = {};
    payload[sectionKey] = data;
    payload.updatedAt = firebase.firestore.FieldValue.serverTimestamp();
    try {
      await db.collection('users').doc(uid).set(payload, { merge: true });
      log('Saved to Firestore', sectionKey);
    } catch (e) {
      // handle permission errors: keep local fallback and show hints
      if (e && (e.code === 'permission-denied' || (e.message && e.message.toLowerCase().includes('permission')))) {
        err('Firestore permission denied while saving', e);
        try {
          // persist failed write locally for this uid/section
          storeFailedWriteLocally(uid, sectionKey, data);
        } catch (storeErr) {
          err('storing failed write locally failed', storeErr);
        }
        // show explicit hints to developer/user
        showPermissionHints(uid, sectionKey);
        // bubble up a specific error so callers can handle
        throw new Error('permission-denied');
      }
      throw e;
    }
  }

  // Flush any local drafts stored under draftsKey into Firestore for the given uid.
  // This ensures pages where the user clicked Next before auth restored still persist.
  async function flushLocalDraftsToFirestoreOnLogin(uid) {
    if (!uid) return;
    try {
      const all = JSON.parse(localStorage.getItem(draftsKey) || '{}');
      if (!all || typeof all !== 'object') return;
      log('Flushing local drafts to Firestore for uid', uid, Object.keys(all));
      for (const [sectionKey, sectionData] of Object.entries(all)) {
        if (!sectionData || typeof sectionData !== 'object') continue;
        try {
          await saveToFirestore(uid, sectionKey, sectionData);
          log('Flushed section to Firestore:', sectionKey);
        } catch (e) {
          // If permission denied, stop and inform console — keep local drafts intact
          if (e && e.message === 'permission-denied') {
            err('Flush aborted: permission-denied when writing section', sectionKey, e);
            return;
          }
          console.warn('Failed to flush section', sectionKey, e);
        }
      }
    } catch (e) {
      err('flushLocalDraftsToFirestoreOnLogin failed', e);
    }
  }

  // small helper: wait up to `timeoutMs` for auth.currentUser to be available
  // resolves with the firebase user or null if timeout
  function waitForAuth(timeoutMs = 7000) {
    return new Promise((resolve) => {
      if (auth && auth.currentUser) return resolve(auth.currentUser);
      let resolved = false;
      const timer = setTimeout(() => {
        if (!resolved) {
          resolved = true;
          resolve(null);
        }
      }, timeoutMs);

      // onAuthStateChanged will fire when Firebase restores session
      try {
        const unsubscribe = auth.onAuthStateChanged((user) => {
          if (resolved) return;
          resolved = true;
          clearTimeout(timer);
          unsubscribe();
          resolve(user || null);
        });
      } catch (e) {
        // fallback: poll auth.currentUser if onAuthStateChanged not available yet
        const pollInterval = 250;
        let elapsed = 0;
        const iv = setInterval(() => {
          elapsed += pollInterval;
          if (auth && auth.currentUser) {
            clearInterval(iv);
            clearTimeout(timer);
            if (!resolved) { resolved = true; resolve(auth.currentUser); }
          } else if (elapsed >= timeoutMs) {
            clearInterval(iv);
            if (!resolved) { resolved = true; resolve(null); }
          }
        }, pollInterval);
      }
    });
  }

  // Generic handler: save current page inputs to Firestore (if logged in) and localStorage, then navigate
  async function handleNextButton(buttonId, sectionKey, nextPath) {
    const btn = document.getElementById(buttonId);
    if (!btn) return;
    btn.addEventListener('click', async (ev) => {
      ev.preventDefault();
      let data = collectPageInputs();
      // Normalize skills and job preferences into combined sections if mapping requested those keys
      let sectionToSave = sectionKey;
      if (sectionKey === 'skills') {
        const combined = getCombinedSkillsFromHidden();
        data = { skills: combined };
        sectionToSave = 'skills';
      } else if (sectionKey === 'jobPreferences') {
        const combined = getCombinedJobPrefsFromHidden();
        data = { jobPreferences: combined };
        sectionToSave = 'jobPreferences';
      } else if (sectionKey === 'workExperience') {
        // If the page provides work_experiences (array or JSON string), save the array itself as the section value
        const we = data.work_experiences || data.work_experience || data.workExperience;
        try {
          // if it's a JSON string, try to parse
          if (typeof we === 'string') {
            const p = JSON.parse(we || '[]');
            data = Array.isArray(p) ? p : [];
          } else if (Array.isArray(we)) {
            data = we;
          } else {
            // fallback: collect fields into a single entry if present
            data = [];
          }
        } catch (e) {
          data = [];
        }
        sectionToSave = 'workExperience';
      }
      saveLocalDraft(sectionToSave, data);

      // Try to ensure firebase and current user
      const fb = await ensureFirebase();
      if (!fb || !auth) {
        log('No Firebase: navigating locally to', nextPath);
        if (nextPath) window.location.href = normalizeNextPath(nextPath);
        return;
      }

      // WAIT for auth state (important after redirect from personal-info account creation)
      const user = await waitForAuth(8000);
      if (!user) {
        // pick an error element id that exists on the page (skills/page-specific and jobpref page-specific)
        let errorId = `${sectionKey}Error`;
        if (sectionKey === 'skills') errorId = (buttonId === 'skills1Next') ? 'skills1Error' : 'skills2Error';
        if (sectionKey === 'jobPreferences') errorId = (buttonId === 'jobpref1Next') ? 'jobpref1Error' : 'jobpref2Error';
        // more user-friendly messaging for guardian page
        showError('No authenticated user found yet. If you just created an account, please wait a moment and retry.', errorId);
        console.warn('[reg.js] waitForAuth timed out — auth.currentUser still null');
        return;
      }

      try {
        await saveToFirestore(user.uid, sectionToSave, data);
        if (nextPath) window.location.href = normalizeNextPath(nextPath);
      } catch (e) {
        // handle permission-denied specifically
        let errorId = `${sectionKey}Error`;
        if (sectionKey === 'skills') errorId = (buttonId === 'skills1Next') ? 'skills1Error' : 'skills2Error';
        if (sectionKey === 'jobPreferences') errorId = (buttonId === 'jobpref1Next') ? 'jobpref1Error' : 'jobpref2Error';
        if (e && e.message === 'permission-denied') {
          showError('Firestore permissions error: update your Firestore rules to allow authenticated reads/writes for users. See console for details.', errorId);
          console.info('Actionable hints:');
          console.info('- Go to Firebase Console → Firestore → Rules and allow authenticated access (or add proper rules).');
          console.info('- Ensure Authorized domains include your dev host in Firebase Authentication.');
          console.info('- Ensure user is authenticated (inspect auth.currentUser).');
          return;
        }
        err('Error saving page to Firestore', e);
        alert('Error saving data. Saved locally instead.');
        if (nextPath) window.location.href = normalizeNextPath(nextPath);
      }
    });
  }

  // Auto-fill when signed in or when local drafts exist
  async function attachAutofill() {
    // local drafts
    autofillFromLocalDrafts();

    const fb = await ensureFirebase();
    if (!fb || !auth) return;

    // Wait for auth restoration, then flush drafts and pending writes and autofill from Firestore
    const user = await waitForAuth(8000);
    if (!user) {
      log('attachAutofill: no authenticated user after wait, will listen for auth changes');
      // still attach listener so when auth becomes available we flush drafts then autofill
      auth.onAuthStateChanged(async (u) => {
        if (!u) return;
        try {
          await flushLocalDraftsToFirestoreOnLogin(u.uid);
          await flushPendingWrites(u.uid);
        } catch (e) { /* ignore flush errors */ }
        try {
          const doc = await db.collection('users').doc(u.uid).get();
          if (doc.exists) {
            fillFormFields(doc.data());
            const data = doc.data();
            Object.keys(data || {}).forEach(k => {
              if (typeof data[k] === 'object') fillFormFields(data[k]);
            });
          }
        } catch (fireErr) {
          if (fireErr && fireErr.code === 'permission-denied') {
            err('Autofill: Firestore permission denied', fireErr);
            showError('Autofill from Firestore failed: permission denied. You can continue; data is saved locally.', 'regError');
          } else {
            err('Autofill from Firestore failed', fireErr);
          }
        }
      });
      return;
    }

    // if we have user now, flush drafts/pending and autofill immediately
    try {
      await flushLocalDraftsToFirestoreOnLogin(user.uid);
      await flushPendingWrites(user.uid);
    } catch (e) { /* ignore flush errors */ }
    try {
      const doc = await db.collection('users').doc(user.uid).get();
      if (doc.exists) {
        fillFormFields(doc.data());
        const data = doc.data();
        Object.keys(data || {}).forEach(k => {
          if (typeof data[k] === 'object') fillFormFields(data[k]);
        });
      }
    } catch (fireErr) {
      if (fireErr && fireErr.code === 'permission-denied') {
        err('Autofill: Firestore permission denied', fireErr);
        showError('Autofill from Firestore failed: permission denied. You can continue; data is saved locally.', 'regError');
      } else {
        err('Autofill from Firestore failed', fireErr);
      }
    }
  }

  // Handler for creating account on the Personal Information page.
  async function handlePersonalInfoCreate() {
    const btn = document.getElementById('nextBtn') || document.getElementById('createAccountBtn');
    // map input ids used on Blade: first_name, last_name, email, password, confirm_password, phone, age
    if (!btn) return;
    btn.addEventListener('click', async (ev) => {
      ev.preventDefault();
      const first = (document.getElementById('first_name')?.value || '').trim();
      const last = (document.getElementById('last_name')?.value || '').trim();
      const email = (document.getElementById('email')?.value || '').trim();
      const password = (document.getElementById('password')?.value || '');
      const confirm = (document.getElementById('confirm_password')?.value || '');
      const phone = (document.getElementById('phone')?.value || '').trim();
      const age = (document.getElementById('age')?.value || '').trim();

      // Basic validation
      if (!email || !password) {
        showError('Email and password are required.', 'regError');
        return;
      }
      if (password !== confirm) {
        showError('Passwords do not match.', 'regError');
        return;
      }

      // Save local draft
      saveLocalDraft('personalInfo', { first_name: first, last_name: last, email, phone, age });

      const fb = await ensureFirebase();
      if (!fb || !auth) {
        showError('Firebase not configured — saved locally. You will need Firebase config to create an account.', 'regError');
        return;
      }

      try {
        // Create user
        const cred = await auth.createUserWithEmailAndPassword(email, password);
        const uid = cred.user.uid;
        log('Firebase user created', uid);

        // Attempt to send verification email (best effort)
        try {
          await cred.user.sendEmailVerification();
          log('Email verification sent to', email);
        } catch (verr) {
          console.warn('sendEmailVerification failed', verr);
          const velem = document.getElementById('regError') || document.getElementById('finalError');
          if (velem) velem.textContent = 'Account created but verification email could not be sent. Check console for details.';
        }

        // Build user doc
        const userDoc = {
          personalInfo: { first_name: first, last_name: last, email, phone, age },
          role: 'User',
          createdAt: firebase.firestore.FieldValue.serverTimestamp()
        };

        try {
          await db.collection('users').doc(uid).set(userDoc, { merge: true });
          log('Firestore doc created for', uid);
        } catch (e) {
          if (e && e.code === 'permission-denied') {
            showError('Account created but Firestore write failed due to permissions. Update Firestore rules.', 'regError');
            console.info('Firestore write permission denied for new user. See Firebase Console -> Firestore -> Rules.');
            return;
          }
          throw e;
        }

        // Redirect to guardian page (use relative path)
        window.location.href = normalizeNextPath('registerguardianinfo');
      } catch (e) {
        err('Error creating user', e);
        const code = e && e.code ? e.code : 'unknown_error';
        const msg = (e && e.message) ? e.message : 'Error creating account';
        showError(`${code}: ${msg}`, 'regError');
        console.error('Auth error code:', code, e);
        if (code === 'auth/operation-not-allowed') {
          console.info('Enable Email/Password provider in Firebase Console -> Authentication -> Sign-in method.');
        } else if (code === 'auth/invalid-api-key' || code === 'auth/network-request-failed') {
          console.info('Check FIREBASE config and Authorized domains in Firebase Console.');
        }
      }
    });
  }

  // Finalize account on Final Step - if user signed-in, mark completed and navigate home
  function handleFinalize() {
    const btn = document.getElementById('createAccountBtn');
    if (!btn) return;
    btn.addEventListener('click', async (ev) => {
      ev.preventDefault();
      const fb = await ensureFirebase();
      if (!fb || !auth || !auth.currentUser) {
        alert('You must be signed in to create your account. Please complete Personal Information first.');
        return;
      }
      try {
        await db.collection('users').doc(auth.currentUser.uid).set({
          completed: true,
          completedAt: firebase.firestore.FieldValue.serverTimestamp()
        }, { merge: true });
        // navigate relatively to the app base (use route name 'registerfinalstep' or 'home' page)
        window.location.href = normalizeNextPath(''); // remain safe if root differs
      } catch (e) {
        err('Final step save failed', e);
        alert('Could not finalize account. Please try again.');
      }
    });
  }

  // Setup page-specific handlers mapping
  document.addEventListener('DOMContentLoaded', async () => {
    // Try to attach autofill asap (may run without firebase)
    attachAutofill().catch(e => err('attachAutofill error', e));

    // Personal info: create account via Next button
    handlePersonalInfoCreate();

    // Generic next handlers (buttonId, sectionKey, nextPath)
    const mapping = [
      ['guardianNext', 'guardianInfo', '/registereducation'],
      ['educNext', 'educationInfo', '/registerschoolworkinfo'],
      ['schoolNext', 'schoolWorkInfo', '/registerworkexpinfo'],
      ['workExpNext', 'workExperience', '/registersupportneed'],
      ['supportNext', 'supportNeed', '/registerworkplace'],
      ['workplaceNext', 'workplace', '/registerskills1'],
      // both skills pages save into the combined 'skills' section
      ['skills1Next', 'skills', '/registerskills2'],
      ['skills2Next', 'skills', '/registerjobpreference1'],
      // both job preference pages save into combined 'jobPreferences' section
      ['jobpref1Next', 'jobPreferences', '/registerjobpreference2'],
      ['jobpref2Next', 'jobPreferences', '/registerreview1'],
      ['schoolNext', 'schoolWorkInfo', '/registerworkexpinfo'], // duplicate safe
      ['workExpNext', 'workExperience', '/registersupportneed'] // duplicate safe
    ];
    mapping.forEach(([btn, section, path]) => {
      try { handleNextButton(btn, section, path); } catch (e) { /* ignore */ }
    });

    // guardian form Next (separate id used above) and other Next buttons that don't match pattern
    handleNextButton('guardianNext', 'guardianInfo', '/registereducation');
    handleNextButton('educNext', 'educationInfo', '/registerschoolworkinfo');
    handleNextButton('schoolNext', 'schoolWorkInfo', '/registerworkexpinfo');
    handleNextButton('workExpNext', 'workExperience', '/registersupportneed');
    handleNextButton('supportNext', 'supportNeed', '/registerworkplace');
    handleNextButton('workplaceNext', 'workplace', '/registerskills1');
    handleNextButton('skills1Next', 'skills', '/registerskills2');
    handleNextButton('skills2Next', 'skills', '/registerjobpreference1');
    handleNextButton('jobpref1Next', 'jobPreferences', '/registerjobpreference2');
    handleNextButton('jobpref2Next', 'jobPreferences', '/registerreview1');
    handleNextButton('jobpref1Next', 'jobPref1', '/registerjobpreference2');
    handleNextButton('jobpref2Next', 'jobPref2', '/registerreview1');

    // Guardian Next
    handleNextButton('guardianNext', 'guardianInfo', '/registereducation');

    // Finalize button
    handleFinalize();

    // small UX: allow create-password show toggles (some pages already have small inline script)
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
      if (!cb.id) return;
      // handled elsewhere in blades, so minimal here
    });
  });
})();
