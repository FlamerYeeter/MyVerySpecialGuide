<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Set New Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <script>
    // Run as early as possible: capture fragment token and move to sessionStorage,
    // then remove fragment from address bar before page renders.
    (function(){
      try {
        var raw = window.location.hash || '';
        // capture entire value after hash= until next & (supports base64url and percent-encoded tokens)
        var m = raw.match(/#?hash=([^&]+)/);
        if (m && m[1]) {
          try { sessionStorage.setItem('mvsg_reset_hash', m[1]); } catch(e) {}
          // remove fragment
          var clean = window.location.protocol + '//' + window.location.host + window.location.pathname + window.location.search;
          window.history.replaceState({}, document.title, clean);
        }
      } catch(e) {}
    })();
  </script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      background-image: url('image/herobg.png');
      background-size: contain;
      background-repeat: repeat;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.3s ease-out forwards;
    }
  </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

  <!-- Back Button -->
  <div class="absolute top-6 left-6">
    <a href="{{ route('login') }}" class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-8 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      Back
    </a>
  </div>

  <!-- Main Card -->
  <div id="password-card" class="bg-yellow-100 max-w-md w-full rounded-2xl shadow-md p-8 text-center">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Set New Password</h2>
    <p class="text-gray-600 text-sm mb-6">
      Create a strong password with at least 8 characters, including uppercase and lowercase letters, a number, and a special character.
    </p>

    <form id="reset-form" class="flex flex-col space-y-4">
      <!-- hidden field to receive the reset token (captured from ?hash= in URL) -->
      <input type="hidden" id="resetHash" name="reset_hash" value="" />
      <div class="text-left">
        <input
          id="newPassword"
          type="password"
          placeholder="New Password"
          class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sky-300 focus:outline-none"
        />
        <p id="newPasswordError" class="text-red-500 text-xs mt-1 hidden"></p>
      </div>

      <div class="text-left">
        <input
          id="confirmPassword"
          type="password"
          placeholder="Confirm Password"
          class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sky-300 focus:outline-none"
        />
        <p id="confirmPasswordError" class="text-red-500 text-xs mt-1 hidden"></p>
      </div>

      <button
        type="submit"
        class="w-full bg-[#2E2EFF] hover:bg-blue-600 text-white font-semibold py-3 rounded-md transition-all duration-300">
        Reset Password
      </button>
    </form>
  </div>

  <!-- Success Prompt -->
  <div id="success-prompt" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg max-w-sm w-11/12 p-6 text-center animate-fadeIn">
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Password Reset Successful</h3>
      <p class="text-gray-600 text-sm mb-4">
        Your password has been updated. You can now log in with your new credentials.
      </p>
      <p class="italic text-gray-500 text-sm">Redirecting to login...</p>
    </div>
  </div>

  <!-- ✅ Validation Script -->
  <script>
    // Capture #hash token, save to sessionStorage and hidden field, then remove fragment
    (function(){
      try {
        const raw = window.location.hash || '';
        // accept any characters until an ampersand (covers base64url and percent-encoded tokens)
        const match = raw.match(/[#&]?hash=([^&]+)/);
        if (match && match[1]) {
          const token = match[1];
          // store in sessionStorage (not exposed to server logs)
          try { sessionStorage.setItem('mvsg_reset_hash', token); } catch(e){}
          // set hidden input too (so form submit includes it)
          const el = document.getElementById('resetHash');
          if (el) el.value = token;
          // remove fragment from address bar
          const cleanUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
          window.history.replaceState({}, document.title, cleanUrl);
        } else {
          // if token already in sessionStorage, populate hidden field
          try {
            const stored = sessionStorage.getItem('mvsg_reset_hash');
            if (stored) {
              const el2 = document.getElementById('resetHash'); if (el2) el2.value = stored;
            }
          } catch(e){}
        }
      } catch (e) { console.warn('Could not process reset token', e); }
    })();

    const form = document.getElementById('reset-form');
    const prompt = document.getElementById('success-prompt');
    const card = document.getElementById('password-card');

    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const password = newPassword.value.trim();
      const confirm = confirmPassword.value.trim();
      let valid = true;

      // Reset errors
      newPasswordError.classList.add('hidden');
      confirmPasswordError.classList.add('hidden');

      // Validation rules: remove special-character requirement per request
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

      if (!passwordRegex.test(password)) {
        newPasswordError.textContent = "Password must have 8+ chars, include uppercase, lowercase, and a number.";
        newPasswordError.classList.remove('hidden');
        valid = false;
      }

      if (password !== confirm) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.classList.remove('hidden');
        valid = false;
      }

      if (!valid) return;

      // Submit to server to change password
      try {
        card.classList.add('opacity-60');
        const token = document.getElementById('resetHash')?.value || sessionStorage.getItem('mvsg_reset_hash');
        if (!token) throw new Error('Reset token missing.');

        const res = await fetch('/db/reset-password-submit.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ reset_hash: token, password })
        });

        const data = await res.json();
        card.classList.remove('opacity-60');
        if (data && data.status === 'success') {
          // clear token from sessionStorage
          try { sessionStorage.removeItem('mvsg_reset_hash'); } catch(e){}
          // show success
          card.classList.add('hidden');
          prompt.classList.remove('hidden');
          setTimeout(() => { window.location.href = "{{ route('login') }}"; }, 2000);
        } else {
          throw new Error((data && data.message) ? data.message : 'Failed to update password');
        }
      } catch (err) {
        newPasswordError.textContent = err.message || 'Server error';
        newPasswordError.classList.remove('hidden');
        card.classList.remove('opacity-60');
      }
    });
  </script>
</body>
</html>
