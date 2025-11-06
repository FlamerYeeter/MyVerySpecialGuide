<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Set New Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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
    <a href="{{ route('login') }}" class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold text-xl py-2 px-5 rounded-lg shadow transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
          stroke="currentColor" class="w-8 h-8 mr-3">
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
        class="bg-sky-400 text-white font-semibold py-2.5 w-3/4 mx-auto rounded-full hover:bg-sky-500 transition">
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
    const form = document.getElementById('reset-form');
    const prompt = document.getElementById('success-prompt');
    const card = document.getElementById('password-card');

    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const password = newPassword.value.trim();
      const confirm = confirmPassword.value.trim();
      let valid = true;

      // Reset errors
      newPasswordError.classList.add('hidden');
      confirmPasswordError.classList.add('hidden');

      // Validation rules
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/;

      if (!passwordRegex.test(password)) {
        newPasswordError.textContent = "Password must have 8+ chars, uppercase, lowercase, number, and special char.";
        newPasswordError.classList.remove('hidden');
        valid = false;
      }

      if (password !== confirm) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.classList.remove('hidden');
        valid = false;
      }

      if (!valid) return;

      // ✅ Show success modal and redirect
      card.classList.add('hidden');
      prompt.classList.remove('hidden');

      setTimeout(() => {
        window.location.href = "{{ route('login') }}"; // or your login URL
      }, 3000);
    });
  </script>
</body>
</html>
