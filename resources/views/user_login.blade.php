<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col justify-center items-center bg-cover bg-center relative"
  style="background-image: url('image/herobg.png');">

  <!-- Back Button -->
  <div class="absolute top-6 left-6">
    <a href="{{ route('user.role') }}"
      class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold text-xl py-2 px-5 rounded-lg shadow transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
        stroke="currentColor" class="w-8 h-8 mr-3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      Back
    </a>
  </div>

  <!-- Login Card -->
  <div class="bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md p-8 sm:p-10 w-11/12 max-w-md text-center">
    <!-- Header -->
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">LOG IN</h2>

    <!-- Form -->
    <form id="loginForm" method="POST" action="{{ route('login.post') }}" class="space-y-5">
      @csrf
      <input type="hidden" name="redirect" value="/navigation-buttons" />
      <div id="loginError" class="text-red-600 text-sm"></div>
      @if($errors->any())
      <div class="text-red-600 text-sm">{{ $errors->first() }}</div>
      @endif
      <input name="email" type="text" placeholder="Email"
        value="{{ old('email') }}"
        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      <input name="password" type="password" placeholder="Password"
        class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      <button type="submit"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-md transition-all duration-300">
        Log In
      </button>
    </form>

    <!-- Forgot Password -->
    <div class="mt-4">
      <a href="{{ route('forgotpassword') }}" class="text-sm text-gray-700 hover:underline font-medium">
        Forgot your password?
      </a>
    </div>
  </div>

  <!-- Create Account Card -->
  <div class="mt-4 bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md p-6 w-11/12 max-w-md text-center">
    <p class="text-gray-800 text-base">
      Don’t have an account?
      <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Create Account</a>
    </p>
  </div>

  <!-- ✅ Loading Modal -->
  <div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center">
      <div class="border-4 border-blue-500 border-t-transparent rounded-full w-14 h-14 animate-spin mb-4"></div>
      <p class="text-gray-800 font-medium">Logging in, please wait...</p>
    </div>
  </div>

</body>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  const email = document.querySelector('input[name="email"]').value.trim();
  const password = document.querySelector('input[name="password"]').value;
  const errorDiv = document.getElementById('loginError');
  const loadingModal = document.getElementById('loadingModal');

  errorDiv.textContent = ''; // clear errors
  loadingModal.classList.remove('hidden'); // show loading

  try {
    const res = await fetch('/db/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password })
    });

    const data = await res.json();
 console.log(data);
    if (data.success) {
      localStorage.setItem('session_id', data.session_id);
      localStorage.setItem('user_id', data.user.id);
      localStorage.setItem('user_email', data.user.email);

      // ✅ simulate loading delay for nice UX
      setTimeout(() => {
        loadingModal.classList.add('hidden');
        window.location.href = '/navigation-buttons';
      }, 1000);
    } else {
      loadingModal.classList.add('hidden');
      errorDiv.textContent = data.message || 'Login failed.';
    }
  } catch (err) {
    loadingModal.classList.add('hidden');
    errorDiv.textContent = 'Server error.';
  }
});
</script>
</html>


<!-- <script>
    (function(){
        // safe JSON parse helper
        function safeParse(s){ try { return JSON.parse(s); } catch(e){ return null; } }

        // Create a local demo account and mark session as authenticated (local-only).
        // Opt-in only: triggered when URL contains ?demo=1. Demo email/password can be
        // overridden with ?demo_email=...&demo_password=... if needed.
        function createDemoAccountAndLogin(demoEmail, demoPassword) {
            try {
                const account = {
                    email: demoEmail,
                    password: demoPassword,
                    draft: { demo: true },
                    createdAt: new Date().toISOString(),
                    status: 'active_demo'
                };

                const key = 'local_accounts';
                let list = [];
                try { list = JSON.parse(localStorage.getItem(key) || '[]'); } catch(e){ list = []; }
                list = list.filter(x => String((x.email||'')).toLowerCase() !== String(demoEmail||'').toLowerCase());
                list.push(account);
                localStorage.setItem(key, JSON.stringify(list));

                // Mark authenticated state used by client-side flows
                localStorage.setItem('mvsg_authenticated', '1');
                localStorage.setItem('mvsg_current_email', demoEmail);
                localStorage.setItem('mvsg_current_user', JSON.stringify(account));
                // Also set local_current_email for flows that read this key
                try { localStorage.setItem('local_current_email', demoEmail); } catch(e) {}

                console.info('[demo-login] created local demo account for', demoEmail);
            } catch(e) { console.error('[demo-login] failed to create demo account', e); }
        }

        document.addEventListener('DOMContentLoaded', function(){
            const form = document.getElementById('loginForm');
            const errorEl = document.getElementById('loginError');
            if (!form) return;

            // If the URL contains ?demo=1, create a demo account and auto-login.
            try {
                const params = new URLSearchParams(window.location.search || '');
                if (params.get('demo') === '1') {
                    const demoEmail = params.get('demo_email') || 'thomasadriannaguit@gmail.com';
                    const demoPassword = params.get('demo_password') || '2703Remalf';
                    // create account and redirect directly to navigation-buttons for demo
                    createDemoAccountAndLogin(demoEmail, demoPassword);
                    try { localStorage.setItem('local_current_email', demoEmail); } catch(e) {}
                    // Small delay so storage writes settle before redirecting
                    setTimeout(()=> { window.location.href = '/navigation-buttons'; }, 120);
                    return;
                }
            } catch(e) { console.warn('demo login check failed', e); }

            form.addEventListener('submit', function(evt){
                // attempt client-side local_storage auth first
                try {
                    const email = (form.querySelector('input[name="email"]')?.value || '').trim();
                    const password = (form.querySelector('input[name="password"]')?.value || '').trim();
                    errorEl.textContent = '';

                    if (!email || !password) {
                        errorEl.textContent = 'Please enter both email and password.';
                        evt.preventDefault();
                        return;
                    }

                    const accs = safeParse(localStorage.getItem('local_accounts') || '[]') || [];
                    const found = accs.find(a => (a.email||'').toLowerCase() === email.toLowerCase() && String(a.password || '') === String(password));
                    if (found) {
                        // successful local login: mark as authenticated in local storage and redirect client-side
                        try {
                            localStorage.setItem('mvsg_authenticated', '1');
                            localStorage.setItem('mvsg_current_email', found.email || email);
                            localStorage.setItem('mvsg_current_user', JSON.stringify(found));
                        } catch(e) { /* ignore storage errors */ }

                        // redirect to provided redirect input or default
                        const redirect = form.querySelector('input[name="redirect"]')?.value || '/navigation-buttons';
                        evt.preventDefault();
                        window.location.href = redirect;
                        return;
                    }

                    // not found locally: allow form to submit to server (if present) but show a brief hint
                    errorEl.textContent = 'Login failed. Please check your credentials.';
                    // let server handle the submission; do not preventDefault here
                } catch(e) {
                    // fallback: allow normal submit
                    console.warn('local login check failed', e);
                }
            });
        });
    })();
</script> -->


