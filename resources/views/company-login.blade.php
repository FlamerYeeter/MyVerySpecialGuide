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
    const res = await fetch('/db/company-login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password })
    });

    const data = await res.json();

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