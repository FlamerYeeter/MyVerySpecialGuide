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
    if (!cfg || !cfg.apiKey) { showError('Firebase not configured — using local storage only.'); return null; }

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
      saveLocalDraft(sectionKey, data);
      const fb = await ensureFirebase();
      if (!fb) return (window.location.href = normalizeNextPath(nextPath));
      const user = await waitForAuth(8000);
      if (!user) return showError('Please sign in again before proceeding.', `${sectionKey}Error`);
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
    const btn = document.getElementById('nextBtn') || document.getElementById('createAccountBtn');
    if (!btn) return;
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const first = document.getElementById('first_name')?.value || '';
      const last = document.getElementById('last_name')?.value || '';
      const email = document.getElementById('email')?.value || '';
      const pass = document.getElementById('password')?.value || '';
      const confirm = document.getElementById('confirm_password')?.value || '';
      if (!email || !pass) return showError('Email and password required');
      if (pass !== confirm) return showError('Passwords do not match');
      const fb = await ensureFirebase(); if (!fb) return;
      try {
        const cred = await auth.createUserWithEmailAndPassword(email, pass);
        const uid = cred.user.uid;
        await db.collection('users').doc(uid).set({
          personalInfo: { first, last, email },
          role: 'User',
          createdAt: firebase.firestore.FieldValue.serverTimestamp()
        }, { merge: true });
        await cred.user.sendEmailVerification().catch(() => {});
        window.location.href = normalizeNextPath('registerguardianinfo');
      } catch (e2) { showError(e2.message); }
    });
  }

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
        Object.values(data || {}).forEach(v => typeof v === 'object' && fillFormFields(v));
      }
    } catch (e) { showError('Autofill failed (Firestore)', 'regError'); }
  }

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
      ['skills1Next', 'skills', '/registerskills2'],
      ['skills2Next', 'skills', '/registerjobpreference1'],
      ['jobpref1Next', 'jobPreferences', '/registerjobpreference2'],
      ['jobpref2Next', 'jobPreferences', '/registerfinalstep'],
      ['finalizeNext', 'finalize', '/home']
    ];
    mapping.forEach(([btn, key, path]) => handleNextButton(btn, key, path));
  });
})();
