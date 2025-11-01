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
      background-image: url('image/herobg.png'); /* Replace with your own pastel doodle bg */
      background-size: contain;
      background-repeat: repeat;
    }
  </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

  <!-- Back Button -->
  <div class="absolute top-6 left-6">
    <button class="flex items-center space-x-2 bg-sky-400 text-white px-5 py-2 rounded-lg hover:bg-sky-500 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-lg font-medium">Back</span>
    </button>
  </div>
 
 <!-- Main Card -->
<div class="bg-yellow-100 max-w-md w-full rounded-2xl shadow-md p-8 text-center">
  <h2 class="text-2xl font-semibold text-gray-800 mb-2">Set New Password</h2>
  <p class="text-gray-600 text-sm mb-6">
    Create a strong password with at least 8 characters, including uppercase and lowercase letters, a number, and a special character.
  </p>

  <form class="flex flex-col space-y-3">
    <input
      type="password"
      placeholder="New Password"
      class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sky-300 focus:outline-none"/>
    <input
      type="password"
      placeholder="Confirm Password"
      class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sky-300 focus:outline-none"/>

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

 <script>
    const form = document.getElementById('reset-form');
    const prompt = document.getElementById('success-prompt');
    const card = document.getElementById('password-card');

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      // Hide the form card
      card.classList.add('hidden');

      // Show success prompt
      prompt.classList.remove('hidden');

      // Simulate redirect after a few seconds
      setTimeout(() => {
        window.location.href = '/login'; // Replace with your login page
      }, 3000);
    });
  </script>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.3s ease-out forwards;
    }
  </style>
</body>
</html>
