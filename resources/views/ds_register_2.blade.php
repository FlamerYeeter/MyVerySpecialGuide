<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create an Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Floating Mascot Animations */
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .animate-float-slow { animation: float 6s ease-in-out infinite; }
      .animate-float-medium { animation: float 4s ease-in-out infinite; }
      .animate-float-fast { animation: float 3s ease-in-out infinite; }
    </style>
  </head>

  <body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 top-1/4 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
      class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-5 sm:px-7 py-2 sm:py-3 rounded-lg flex items-center gap-2 hover:bg-blue-600 transition shadow-md active:scale-95 z-10"
      onclick="window.location.href='{{ route('register') }}'">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-base sm:text-lg font-medium">Back</span>
    </button>

    <!-- Main Container -->
    <div class="bg-[#FEF2C7] rounded-3xl p-10 shadow-lg w-[90%] max-w-2xl text-center relative z-10">
      
      <!-- Header -->
      <div class="flex justify-center items-center gap-2">
        <h1 class="text-xl font-medium text-gray-800">Create An Account</h1>
        <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
      </div>
      <img src="image/obj6.png" alt="Pink Stone Object" class="mx-auto w-24 h-24 mb-6">

      <!-- Green Instruction Box -->
      <div class="bg-[#CFFFC2] border border-green-400 rounded-xl mt-6 p-6 text-left space-y-3">
        
        <!-- Title-->
        <div class="flex items-center gap-2 mb-2">
          <img src="image/obj5.png" class="w-16" alt="icon">
          <p class="font-semibold text-gray-800 text-lg flex items-center gap-2">
            Don't worry! 
            <span class="text-gray-600 italic text-sm ml-1">(Huwag mag-alala!)</span>
          </p>
        </div>

        <!-- English Instructions -->
        <ul class="text-gray-800 text-sm space-y-2 mt-3">
          <li class="flex items-center gap-2">
            <span>• You can go back and change your answers</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
          <li class="flex items-center gap-2">
            <span>• Take your time — there's no rush</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
          <li class="flex items-center gap-2">
            <span>• We will help you every step of the way</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
          <li class="flex items-center gap-2">
            <span>• Press the audio button anytime to hear instructions</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
        </ul>

        <!-- Filipino Translation -->
        <ul class="mt-4 text-gray-600 text-sm italic space-y-2">
          <li class="flex items-center gap-2">
            <span>• Maaari kang bumalik at baguhin ang iyong mga sagot.</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
          <li class="flex items-center gap-2">
            <span>• Maglaan ng oras — huwag magmadali.</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
          <li class="flex items-center gap-2">
            <span>• Tutulungan ka namin sa bawat hakbang.</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
          </li>
          <li class="flex items-start gap-2 flex-wrap">
            <span class="leading-snug">• Pindutin ang pindutan ng audio anumang oras upang marinig ang mga instructions.</span>
            <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform mt-1 sm:mt-0">🔊</button>
          </li>
        </ul>
      </div>

      <!-- Next Button -->
      <div class="flex flex-col items-center mt-12">
        <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition shadow-md"
                onclick="window.location.href='{{ route('registeradminapprove') }}'">
          Next →
        </button>
        <p class="text-gray-600 text-sm mt-2 text-center">
          Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
          <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
        </p>
      </div>
    </div>
  
</body>
</html>
