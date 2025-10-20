{{--Will move to the company folder tas route niyo ng maayos yan Thomas--}}
{{--gagawin kong responsive mamaya--}}

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Email Verification</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#ffffff] min-h-screen flex items-center justify-center p-6">
  <div class="bg-[#fff2bf] rounded-2xl shadow-md max-w-2xl w-full p-10 relative">
    <!-- Step indicator -->
    <div class="absolute top-5 right-6 text-sm font-medium text-gray-800">
      Step 2 out of 2
    </div>

    <!-- Instructions -->
    <p class="text-center text-gray-800 mb-6 text-base">
      Please check the inbox of the email you used to find the verification code.
    </p>

    <!-- Title -->
    <h1 class="text-center text-2xl font-medium text-gray-900 mb-8">
      Enter Verification Code Inside the Box
    </h1>

    <!-- Verification Code Boxes -->
    <div class="flex flex-col items-center space-y-3">
      <label class="text-xs text-gray-700 uppercase tracking-wider">
        Verification Code
      </label>
      <div class="flex justify-center space-x-3">
        <input type="text" maxlength="1" class="w-12 h-14 text-center border border-gray-400 rounded-md bg-[#fff4f1] text-xl focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="text" maxlength="1" class="w-12 h-14 text-center border border-gray-400 rounded-md bg-[#fff4f1] text-xl focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="text" maxlength="1" class="w-12 h-14 text-center border border-gray-400 rounded-md bg-[#fff4f1] text-xl focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="text" maxlength="1" class="w-12 h-14 text-center border border-gray-400 rounded-md bg-[#fff4f1] text-xl focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="text" maxlength="1" class="w-12 h-14 text-center border border-gray-400 rounded-md bg-[#fff4f1] text-xl focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
    </div>

    <!-- Resend Link -->
    <p class="text-center text-gray-600 mt-6 text-sm">
      Didn’t receive code?
      <a href="#" class="text-blue-600 font-medium hover:underline">Click Resend</a>
    </p>

    <!-- Verify Button -->
    <div class="flex justify-center mt-8">
      <button class="bg-[#3da9fc] hover:bg-[#1d9bf0] text-white font-medium px-16 py-2 rounded-md text-lg">
        Verify
      </button>
    </div>

    <!-- Footer Note -->
    <p class="text-center text-gray-600 mt-3 text-sm">
      Click <span class="text-blue-600 font-medium">“Verify”</span> to verify your entered code
    </p>
  </div>

  <!-- Optional Auto-focus & Move to Next Input -->
  <script>
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        if (e.target.value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });
      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });
  </script>
</body>
</html>
