// Minimal self-contained Firebase module that uses window.FIREBASE_CONFIG (set by firebase-config-global.js)
// Exports: submitJobApplication(applicationData) -> Promise<{id:string}>

import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js';
import { getAuth, onAuthStateChanged, setPersistence, browserLocalPersistence } from 'https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js';
import { getFirestore, collection, addDoc, serverTimestamp } from 'https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore.js';
import { signInWithCustomToken } from 'https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js';

let app, auth, db;
let initPromise = null;

async function ensureInit() {
    if (initPromise) return initPromise;
    initPromise = (async () => {
        // Wait a short time for firebase-config-global.js to run and set window.FIREBASE_CONFIG
        if (!window.FIREBASE_CONFIG) {
            // Try to auto-load the global config script if it's not already present on the page.
            try {
                if (typeof document !== 'undefined') {
                    const found = Array.from(document.getElementsByTagName('script')).some(s => s.src && s.src.indexOf('firebase-config-global.js') !== -1);
                    if (!found) {
                        await new Promise((resolve) => {
                            const s = document.createElement('script');
                            s.src = '/js/firebase-config-global.js';
                            s.async = true;
                            s.onload = () => resolve();
                            s.onerror = () => resolve();
                            (document.head || document.body || document.documentElement).appendChild(s);
                        });
                    }
                }
            } catch (e) {
                // ignore and continue to polling
            }

            // poll for up to 2000ms for window.FIREBASE_CONFIG to become available
            await new Promise((resolve) => {
                const timeout = setTimeout(resolve, 2000);
                const iv = setInterval(() => {
                    if (window.FIREBASE_CONFIG) {
                        clearTimeout(timeout);
                        clearInterval(iv);
                        resolve();
                    }
                }, 50);
            });
        }
        const cfg = window.FIREBASE_CONFIG;
        if (!cfg) throw new Error('FIREBASE_CONFIG not found. Ensure /js/firebase-config-global.js is included before importing this module.');
        app = initializeApp(cfg);
        auth = getAuth(app);
        db = getFirestore(app);
        try {
            // Prefer local persistence so auth survives page reloads and redirects
            await setPersistence(auth, browserLocalPersistence);
        } catch (err) {
            console.debug('setPersistence(browserLocalPersistence) failed (non-critical):', err && err.message ? err.message : err);
        }
        return;
    })();
    return initPromise;
}

// Basic CSV parser that handles quoted fields and returns array of rows (each row is array of cells)
function parseCsv(text) {
    const rows = [];
    let i = 0;
    const len = text.length;
    let row = [];
    let cell = '';
    let inQuotes = false;
    while (i < len) {
        const ch = text[i];
        const chNext = i + 1 < len ? text[i+1] : null;
        if (inQuotes) {
            if (ch === '"') {
                if (chNext === '"') { // escaped quote
                    cell += '"';
                    i += 2;
                    continue;
                }
                // end quote
                inQuotes = false;
                i++;
                continue;
            }
            cell += ch;
            i++;
            continue;
        }

        if (ch === '"') {
            inQuotes = true;
            i++;
            continue;
        }

        if (ch === ',') {
            row.push(cell);
            cell = '';
            i++;
            continue;
        }

        // handle CRLF or LF
        if (ch === '\r') {
            // lookahead for \n
            if (i + 1 < len && text[i+1] === '\n') i++;
            row.push(cell);
            rows.push(row);
            row = [];
            cell = '';
            i++;
            continue;
        }
        if (ch === '\n') {
            row.push(cell);
            rows.push(row);
            row = [];
            cell = '';
            i++;
            continue;
        }

        // normal char
        cell += ch;
        i++;
    }
    // push last cell/row
    if (inQuotes) {
        // malformed CSV with unclosed quote - still push what we have
        row.push(cell);
        rows.push(row);
    } else {
        // if anything pending
        if (cell !== '' || row.length > 0) {
            row.push(cell);
            rows.push(row);
        }
    }
    return rows;
}

// Enrich applicationData with job details read from public CSV file
async function enrichPayloadWithJobFromCsv(applicationData) {
    try {
        const jobId = applicationData && (applicationData.job_id || applicationData.jobId || applicationData.job) ? String(applicationData.job_id || applicationData.jobId || applicationData.job) : '';
        if (!jobId) return applicationData;

        // fetch CSV (encode space in filename)
    const csvUrl = encodeURI('/postings.csv');
        const resp = await fetch(csvUrl);
        if (!resp.ok) return applicationData;
        const text = await resp.text();
        const rows = parseCsv(text);
        if (!rows || rows.length < 2) return applicationData;

        const headers = rows[0].map(h => (h || '').trim());
        const dataRows = rows.slice(1);

        // find job_id column index if exists
        let jobIdCol = null;
        for (let i = 0; i < headers.length; i++) {
            if (headers[i] && headers[i].toLowerCase() === 'job_id') { jobIdCol = i; break; }
        }

        let rowFound = null;
        let rowIndex = null;
        for (let i = 0; i < dataRows.length; i++) {
            const r = dataRows[i];
            if (jobIdCol !== null && r[jobIdCol] && String(r[jobIdCol]) === String(jobId)) { rowFound = r; rowIndex = i; break; }
            if (!isNaN(jobId) && parseInt(jobId, 10) === i) { rowFound = r; rowIndex = i; break; }
        }
        if (!rowFound) return applicationData;

        const raw = {};
        for (let hi = 0; hi < headers.length; hi++) raw[headers[hi]] = rowFound[hi] !== undefined ? rowFound[hi] : null;

        const job = {
            title: raw.Title || raw.jobpost || raw.title || '',
            company: raw.Company || raw.company || '',
            location: raw.Location || raw.location || '',
            description: raw.JobDescription || raw.jobDescription || raw.job_requirment || raw['JobRequirment'] || '',
            raw: raw,
            row_index: rowIndex
        };

        applicationData.job = job;
        return applicationData;
    } catch (e) {
        console.debug('enrichPayloadWithJobFromCsv failed', e && e.message ? e.message : e);
        return applicationData;
    }
}

export async function submitJobApplication(applicationData) {
    await ensureInit();

    // Try to enrich payload with job details from CSV before sending/writing so both server and fallback include job
    try { applicationData = await enrichPayloadWithJobFromCsv(applicationData); } catch(e) { console.debug('submitJobApplication: enrich failed', e); }

    // Prefer server-side submit (uses service account / REST) to avoid client Firestore rules issues.
    try {
        const csrfMeta = typeof document !== 'undefined' && document.querySelector ? document.querySelector('meta[name="csrf-token"]') : null;
        const headers = { 'Content-Type': 'application/json' };
        if (csrfMeta && csrfMeta.getAttribute) {
            const token = csrfMeta.getAttribute('content');
            if (token) headers['X-CSRF-TOKEN'] = token;
        }

        // Build candidate endpoints in order: explicit global, relative to current URL, relative path, absolute root
        const candidates = [];
        if (typeof window !== 'undefined' && window.JOB_APP_SUBMIT_URL) candidates.push(window.JOB_APP_SUBMIT_URL);
        try { candidates.push(new URL('job-application-submit', window.location.href).href); } catch(e) {}
        candidates.push('job-application-submit');
        candidates.push('/job-application-submit');

        let resp = null;
        for (const endpoint of candidates) {
            try {
                resp = await fetch(endpoint, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers,
                    body: JSON.stringify(applicationData),
                });
            } catch (e) {
                // network/invalid URL - try next candidate
                resp = null;
            }
            if (resp) {
                // if it's an HTML 404 returned by Apache, resp.ok will be false; we'll inspect below
                break;
            }
        }

        if (resp && resp.ok) {
            try {
                const j = await resp.json();
                if (j && j.success) return { id: j.id || j.name };
                // if server returned JSON error, fall through to client fallback
                console.debug('submitJobApplication: server returned', j);
            } catch (e) {
                console.debug('submitJobApplication: server returned non-json success', e);
            }
        } else {
            // Record server reason for debug but do not block fallback
            try { console.debug('submitJobApplication: server submit failed', resp && resp.status, resp ? await resp.text() : '<no response>'); } catch(e){}
        }
    } catch (e) {
        console.debug('submitJobApplication: server submit attempt failed', e);
    }

    // Fallback to client-side Firestore write if server submission is unavailable or failed
    // First try quick path: currentUser (synchronous if already signed-in)
    if (auth.currentUser) {
        const user = auth.currentUser;
        const docRef = await addDoc(collection(db, 'applications'), {
            uid: user.uid,
            email: user.email || applicationData.email || null,
            submitted_at: serverTimestamp(),
            payload: applicationData,
        });
        return { id: docRef.id };
    }

    // Otherwise wait up to 5s for onAuthStateChanged to fire (user may be signing in)
    return new Promise((resolve, reject) => {
        let settled = false;
        const timeout = setTimeout(() => {
            if (settled) return;
            settled = true;
            try { unsub && unsub(); } catch (e) {}
            reject(new Error('No authenticated user found (timed out).'));
        }, 5000);

        const unsub = onAuthStateChanged(auth, async (user) => {
            if (settled) return;
            settled = true;
            clearTimeout(timeout);
            unsub();
            if (!user) return reject(new Error('Not signed in'));
            try {
                const docRef = await addDoc(collection(db, 'applications'), {
                    uid: user.uid,
                    email: user.email || applicationData.email || null,
                    submitted_at: serverTimestamp(),
                    payload: applicationData,
                });
                resolve({ id: docRef.id });
            } catch (err) {
                reject(err);
            }
        }, (err) => {
            if (settled) return;
            settled = true;
            clearTimeout(timeout);
            reject(err || new Error('Auth state listener error'));
        });
    });
}

// Lightweight helper: returns true if a user is currently signed in, initializing the SDK if needed.
export async function isSignedIn(timeoutMs = 3000) {
    await ensureInit();
    if (auth.currentUser) return true;
    return new Promise((resolve) => {
        let settled = false;
        const unsub = onAuthStateChanged(auth, (user) => {
            if (settled) return;
            settled = true;
            try { unsub(); } catch (e) {}
            console.debug('isSignedIn -> onAuthStateChanged fired, user=', user);
            resolve(!!user);
        });
        setTimeout(() => {
            if (settled) return;
            settled = true;
            try { unsub(); } catch (e) {}
            console.debug('isSignedIn -> timeout, auth.currentUser=', auth.currentUser);
            resolve(!!auth.currentUser);
        }, timeoutMs);
    });
}

// Return the current signed-in user's UID, waiting up to timeoutMs for auth state
export async function getCurrentUserUid(timeoutMs = 3000) {
    await ensureInit();
    if (auth && auth.currentUser) return auth.currentUser.uid;
    return new Promise((resolve) => {
        let settled = false;
        const unsub = onAuthStateChanged(auth, (user) => {
            if (settled) return;
            settled = true;
            try { unsub(); } catch (e) {}
            resolve(user ? user.uid : null);
        }, (err) => {
            if (settled) return;
            settled = true;
            try { unsub(); } catch (e) {}
            resolve(null);
        });
        setTimeout(() => {
            if (settled) return;
            settled = true;
            try { unsub(); } catch (e) {}
            resolve(auth && auth.currentUser ? auth.currentUser.uid : null);
        }, timeoutMs);
    });
}

// Fetch the user's profile document from Firestore (collection 'users', doc = uid)
export async function getUserProfile() {
    await ensureInit();
    return new Promise((resolve, reject) => {
        const unsub = onAuthStateChanged(auth, async (user) => {
            unsub();
            if (!user) return resolve(null);
            try {
                const { getDoc, doc } = await import('https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore.js');
                const dref = doc(db, 'users', user.uid);
                const snap = await getDoc(dref);
                if (!snap.exists()) return resolve(null);
                console.debug('getUserProfile -> fetched profile for', user.uid, snap.data && typeof snap.data === 'function' ? snap.data() : snap.data);
                return resolve(snap.data());
            } catch (err) {
                return reject(err);
            }
        }, (err) => reject(err));
    });
}

// Attempt to sign into Firebase using a server-issued custom token for the
// current Laravel-authenticated session. Returns true if sign-in succeeded.
export async function signInWithServerToken(tokenEndpoint = '/firebase-token') {
    try {
        await ensureInit();
        // fetch token from server (protected by Laravel session cookie)
        let resp = await fetch(tokenEndpoint, { credentials: 'same-origin' });
        // If endpoint returned 404 try common fallbacks (in case route() produced an unexpected path)
        if (resp.status === 404) {
            console.debug('signInWithServerToken: primary endpoint returned 404, trying /firebase-token fallback');
            try { resp = await fetch('/firebase-token', { credentials: 'same-origin' }); } catch (e) { /* ignore */ }
        }
        if (resp.status === 404) {
            console.debug('signInWithServerToken: /firebase-token returned 404, trying relative fallback');
            try { resp = await fetch('firebase-token', { credentials: 'same-origin' }); } catch (e) { /* ignore */ }
        }

        if (!resp.ok) {
            // If response isn't ok, log details for debugging (status + text)
            let bodyText = null;
            try { bodyText = await resp.text(); } catch (e) { bodyText = '<no body>'; }
            console.debug('signInWithServerToken: server returned', resp.status, bodyText);
            try { (await import('./client-logger.js')).sendClientLog('warning', 'signInWithServerToken: server returned non-ok', { status: resp.status, body: bodyText }); } catch(e){}
            return false;
        }
        const body = await resp.json();
        const token = body && body.token;
        if (!token) {
            if (body && body.error === 'service_account_missing') {
                console.info('signInWithServerToken: server has no service account configured (expected in dev)');
                try { (await import('./client-logger.js')).sendClientLog('info', 'signInWithServerToken: service_account_missing'); } catch(e){}
            } else if (body && body.error) {
                console.info('signInWithServerToken: server returned error:', body.error);
                try { (await import('./client-logger.js')).sendClientLog('warning', 'signInWithServerToken: server returned error', { error: body.error }); } catch(e){}
            } else {
                console.debug('signInWithServerToken: no token in response');
                try { (await import('./client-logger.js')).sendClientLog('debug', 'signInWithServerToken: no token in response'); } catch(e){}
            }
            return false;
        }
        await signInWithCustomToken(auth, token);
        console.info('signInWithServerToken: signed in, uid=', auth.currentUser && auth.currentUser.uid);
        try { (await import('./client-logger.js')).sendClientLog('info', 'signInWithServerToken: signed in', { uid: auth.currentUser && auth.currentUser.uid }); } catch(e){}
        return true;
    } catch (err) {
        console.warn('signInWithServerToken failed', err);
        try { (await import('./client-logger.js')).sendClientLog('error', 'signInWithServerToken failed', { error: String(err) }); } catch(e){}
        return false;
    }
}

// Debug helper: call from browser console to print auth state and listen for changes
export function debugAuthLogging() {
    // Make debugAuthLogging safe to call synchronously before SDK init.
    // We return a synchronous unsubscribe function immediately that will
    // noop until the SDK is ready, and once ready we'll attach real
    // listeners to the initialized `auth` instance.

    let unsubLocal = null; // will hold the real unsubscribe when attached
    let closed = false;

    // Attach placeholder unsubscribe that's safe to call synchronously.
    const safeUnsub = () => {
        closed = true;
        try {
            if (typeof unsubLocal === 'function') {
                unsubLocal();
                console.info('debugAuthLogging: unsubscribed');
            }
        } catch (e) {
            console.warn('debugAuthLogging: unsubscribe failed', e);
        }
    };

    // Begin initialization and attach listeners once ready.
    ensureInit().then(() => {
        try {
            console.info('debugAuthLogging: auth.currentUser =', auth.currentUser);
        } catch (e) {
            console.warn('debugAuthLogging: reading auth.currentUser failed', e);
        }

        if (closed) {
            // user already unsubscribed before we attached listeners
            return;
        }

        try {
            // primary invisible listener to capture errors
            const un1 = onAuthStateChanged(auth, () => {}, (err) => console.warn('debugAuthLogging: onAuthStateChanged error', err));
            // visible listener to log state changes
            const un2 = onAuthStateChanged(auth, (u) => console.info('debugAuthLogging: onAuthStateChanged ->', u));

            // prefer to keep the visible listener as the one to unsubscribe
            unsubLocal = () => { try { un1 && un1(); } catch(e){}; try { un2 && un2(); } catch(e){} };
        } catch (err) {
            console.warn('debugAuthLogging: attaching listeners failed', err);
        }
    }).catch(e => console.warn('debugAuthLogging: ensureInit failed', e));

    return safeUnsub;
}

