export async function sendClientLog(level, message, meta = {}) {
  try {
    const url = '/client-log';
    const body = JSON.stringify({ level, message, meta });
    // pick CSRF token from meta tag if present
    let headers = { 'Content-Type': 'application/json' };
    try {
      const metaEl = document.querySelector && document.querySelector('meta[name="csrf-token"]');
      if (metaEl && metaEl.getAttribute) headers['X-CSRF-TOKEN'] = metaEl.getAttribute('content');
    } catch (e) {}
    await fetch(url, {
      method: 'POST',
      headers,
      body,
      credentials: 'same-origin'
    });
  } catch (e) {
    // avoid throwing in client logging
    console.debug('sendClientLog failed', e);
  }
}
