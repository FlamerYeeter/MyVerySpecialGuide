<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .animate-float-slow { animation: float 5s ease-in-out infinite; }
      .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
      .animate-float-fast { animation: float 2.5s ease-in-out infinite; }
      .audio-btn {
        @apply bg-blue-500 hover:bg-blue-600 text-white rounded-full w-7 h-7 flex justify-center items-center text-sm shadow-md active:scale-90 transition;
      }
    </style>
  </head>

  <body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0" />
    <img src="image/obj7.png" alt="Triangle Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0" />
    <img src="image/obj3.png" alt="Blue Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 top-1/4 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-fast z-0" />
    <img src="image/obj8.png" alt="Twin Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0" />

    <!-- Back Button -->
    <button
      class="absolute top-6 left-6 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg flex items-center gap-2 shadow-md transition active:scale-95 z-10">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="3" stroke="white" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="font-medium">Back</span>
    </button>

    <!-- Main Container -->
    <div
      class="bg-[#FFF2B3]/40 backdrop-blur-sm border border-yellow-200 rounded-2xl shadow-lg max-w-xl w-full p-10 text-center relative z-10 space-y-6">

      <!-- Instructions -->
      <div class="space-y-1">
        <div class="flex justify-center font-semibold items-center gap-2">
          <p class="text-gray-700 text-[12px]">
            Please check the inbox of the email you used to find the verification code.
          </p>
          <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
        </div>
        <div class="flex justify-center items-center gap-2">
          <p class="text-gray-500 italic text-[13px]">
            (Paki-check ang inbox ng ginamit mong email para makita ang verification code)
          </p>
        </div>
      </div>

      <!-- Title -->
      <div class="mt-4 space-y-1">
        <div class="flex justify-center items-center gap-2">
          <h2 class="text-xl font-semibold text-gray-800">
            Enter Verification Code Inside the Box
          </h2>
          <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
        </div>
        <div class="flex justify-center items-center gap-2">
          <p class="text-gray-500 italic text-sm">
            (Ilagay ang Verification Code sa loob ng kahon)
          </p>
        </div>
      </div>

      <!-- Code Input Boxes -->
      <div class="mt-4 flex justify-center gap-4">
        <input type="text" maxlength="1"
          class="w-14 h-16 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none bg-[#FFF8F6]" />
        <input type="text" maxlength="1"
          class="w-14 h-16 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none bg-[#FFF8F6]" />
        <input type="text" maxlength="1"
          class="w-14 h-16 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none bg-[#FFF8F6]" />
        <input type="text" maxlength="1"
          class="w-14 h-16 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none bg-[#FFF8F6]" />
      </div>

      <!-- Resend Link -->
      <div class="mt-6 space-y-1">
        <div class="flex justify-center items-center gap-2">
          <p class="text-gray-600 text-sm">
            Didn’t receive code? Click 
            <a href="#" class="text-blue-600 font-medium hover:underline">Resend</a>
          </p>
           <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
        </div>
        <div class="flex justify-center items-center gap-2">
          <p class="text-gray-500 italic text-sm">
            (Hindi nakatanggap ng code? I-click ang “Resend”)
          </p>
        </div>
      </div>

      <!-- Verify Button -->
      <div class="mt-6 space-y-1">
        <button
          class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold px-16 py-3 rounded-xl shadow-md transition active:scale-95">
          Verify
        </button>
        <div class="flex justify-center items-center gap-2 mt-2">
          <p class="text-gray-700 text-sm">
            Click <span class="text-blue-500 font-medium">“Verify”</span> to verify your entered code
          </p>
        </div>
        <div class="flex justify-center items-center gap-2">
          <p class="text-gray-500 italic text-xs">
            (Pindutin ang “Verify” upang i-verify ang code)
          </p>
        </div>
      </div>
    </div>
 
  </body>
</html>
