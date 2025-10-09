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
    class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-5 sm:px-7 py-2 sm:py-3 rounded-lg flex items-center gap-2 hover:bg-blue-600 transition shadow-md active:scale-95 z-10">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span class="text-base sm:text-lg font-medium">Back</span>
  </button>

  <!-- Main Container -->
  <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

    <!-- Header -->
    <div class="text-center mt-4">
      <h1 class="text-2xl font-semibold text-black mb-4">Create An Account</h1>
      <img src="image/obj6.png" alt="Pink Stone Object" class="mx-auto w-24 h-24 mb-6">

      <div class="max-w-xl mx-auto text-left">
        <h2 class="text-xl text-blue-500 font-semibold flex items-center gap-2">
          Let's create your account step by step
          <button class="text-gray-500 text-xl hover:scale-110 transition-transform">🔊</button>
        </h2>
        <p class="mt-2 text-gray-600 italic border-b-2 border-blue-500 pb-1">
          (Simulan natin ang paglikha ng iyong account sa pagsunod sa bawat hakbang)
        </p>
      </div>
    </div>

    <!-- Info Section -->
    <div class="mt-6 max-w-xl mx-auto">
      <div class="flex items-start gap-2">
        <span class="text-yellow-500 text-3xl mt-1">💡</span>
        <div class="flex-1">
          <p class="text-sm text-gray-800 leading-relaxed">
            We will create your account so we can find jobs that are perfect for you!<br>
            <span class="text-gray-600 italic text-sm">
              (Tayo ay gagawa ng iyong account upang makahanap ng mga trabahong para sa iyo!)
            </span>
          </p>
        </div>
        <button class="text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </div>
    </div>

    <!-- Steps -->
    <div class="mt-10 max-w-xl mx-auto">
      <div class="flex items-center gap-3 mb-4">
        <img src="image/targeticon.png" alt="Target Icon" class="w-7 h-7">
        <h3 class="text-lg text-blue-500 font-semibold flex items-center gap-2 flex-wrap">
          Here's what we'll do:
          <span class="text-gray-600 italic text-sm">(Pagkakasunod-sunod ng paggawa ng account)</span>
          <button class="text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h3>
      </div>

      <!-- Step Cards -->
      <div class="space-y-4">
        <!-- Repeatable Step Block -->
        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/1icon.png" alt="Step 1" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">
              Enter your full name and email, then wait for admin approval to continue setting up your profile.
              A confirmation will be sent to your email once approved.
            </p>
            <p class="mt-2 text-gray-600 italic text-sm">
              (Ilagay ang iyong buong pangalan at email, at hintayin ang kumpirmasyon ng admin sa iyong email matapos maaprubahan upang maituloy ang pag-set up ng iyong profile.)
            </p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/2icon.png" alt="Step 2" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">Tell us about your personal information and parent/guardian information</p>
            <p class="mt-2 text-gray-600 italic text-sm">(Ibahagi ang iyong personal na impormasyon at impormasyon ng magulang/tagapag-alaga)</p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/3icon.png" alt="Step 3" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">Tell us about your educational background and work experience</p>
            <p class="mt-2 text-gray-600 italic text-sm">(Ibahagi ang iyong pinag-aralan at karanasan sa trabaho)</p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/4icon.png" alt="Step 4" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">Choose the support you need and preferred work environment</p>
            <p class="mt-2 text-gray-600 italic text-sm">(Piliin ang suportang kailangan mo at ang uri ng lugar ng trabaho na gusto mo)</p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/5icon.png" alt="Step 5" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">Choose the skills you have</p>
            <p class="mt-2 text-gray-600 italic text-sm">(Pumili ng mga kakayahan na meron ka)</p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/6icon.png" alt="Step 6" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">Select the types of jobs you like</p>
            <p class="mt-2 text-gray-600 italic text-sm">(Piliin ang mga uri ng trabaho na gusto mo)</p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="bg-white rounded-xl p-5 border border-blue-300 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
          <img src="image/7icon.png" alt="Step 7" class="w-8 h-8 mt-1">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 leading-relaxed">Review the information you entered and finish</p>
            <p class="mt-2 text-gray-600 italic text-sm">(I-review ang impormasyong iyong inilagay at tapusin)</p>
          </div>
          <button class="text-xl hover:scale-110 transition-transform">🔊</button>
        </div>
      </div>
    </div>

    <!-- Next Button -->
    <div class="flex flex-col items-center mt-12">
      <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition shadow-md">
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
