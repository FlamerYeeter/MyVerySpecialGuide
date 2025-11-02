// Non-module global wrapper that exposes FIREBASE_CONFIG for older scripts
// This file reads the values from the module-style firebase-config.js if available
// and falls back to an inline literal. It purposely does not use ES module syntax
// so it can be included via a <script> tag before register.js.
(function(){
  // Try to reuse the existing module config if it was bundled elsewhere
  try {
    if (window.__MVSG_FIREBASE_CONFIG__) { window.FIREBASE_CONFIG = window.__MVSG_FIREBASE_CONFIG__; return; }
  } catch(e){}
  // Try meta tag (pages may embed a JSON config in a meta tag)
  try {
    const meta = document.querySelector('meta[name="firebase-config"]');
    if (meta && meta.content) {
      try { window.FIREBASE_CONFIG = JSON.parse(meta.content); } catch(e) { /* ignore parse */ }
    }
  } catch(e){}

  // Try localStorage (some pages cache the config there)
  try {
    const cached = localStorage.getItem('FIREBASE_CONFIG');
    if (cached) {
      try { window.FIREBASE_CONFIG = JSON.parse(cached); } catch(e) { /* ignore */ }
    }
  } catch(e){}

  // Fallback: mirror the values present in public/js/firebase-config.js
  // Keep this minimal and safe to include in the browser
    window.FIREBASE_CONFIG = window.FIREBASE_CONFIG || null;
    console.warn('firebase-config-global.js loaded: Firebase integration removed from this build.');
})();
