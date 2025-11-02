// job-application-firebase.js (shim)
// Original Firebase client removed. Provide small ES module shim so dynamic imports succeed
// and existing Blade templates don't need to change.

try { if (typeof window !== 'undefined') window.firebase = window.firebase || undefined; } catch(e) {}

export async function submitJobApplication(applicationData) {
    console.warn('submitJobApplication shim: Firebase integration removed.');
    // Prefer server-side submit. Throw to make caller fall back to server endpoint or handle gracefully.
    throw new Error('Firebase integration removed');
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

