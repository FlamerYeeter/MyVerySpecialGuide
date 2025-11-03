// job-application-firebase.js (shim)
// Original Firebase client removed. Provide small ES module shim so dynamic imports succeed
// and existing Blade templates don't need to change.

try { if (typeof window !== 'undefined') window.firebase = window.firebase || undefined; } catch(e) {}

export async function submitJobApplication(applicationData) {
    console.warn('submitJobApplication shim: Firebase integration removed. Falling back to server POST if available.');
    // Attempt a best-effort POST to the server endpoint 'job.application.submit' while preserving caller expectations.
    try {
        const resp = await fetch('/job/application/submit', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': (typeof document !== 'undefined' && document.querySelector)? (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||'') : '' }, body: JSON.stringify(applicationData), credentials: 'same-origin' });
        if (!resp.ok) throw new Error('server rejected');
        try { return await resp.json().catch(()=>({ok:true})); } catch(e){ return {ok:true}; }
    } catch (e) {
        console.warn('submitJobApplication shim: server fallback failed', e);
        throw new Error('Firebase integration removed and server fallback failed');
    }
}

export async function isSignedIn(timeoutMs = 3000) {
    return false;
}

export async function getCurrentUserUid(timeoutMs = 3000) {
    return null;
}

export async function getUserProfile() {
    return null;
}

export async function signInWithServerToken(tokenEndpoint = '/firebase-token') {
    console.warn('signInWithServerToken shim: Firebase integration removed.');
    return false;
}

export function debugAuthLogging() {
    console.warn('debugAuthLogging shim: Firebase integration removed.');
    return function() {};
}

