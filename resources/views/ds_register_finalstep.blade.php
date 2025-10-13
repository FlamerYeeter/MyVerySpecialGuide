<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Final Step - Agreement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .animate-float-slow { animation: float 5s ease-in-out infinite; }
      .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
      .animate-float-fast { animation: float 2.5s ease-in-out infinite; }
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
      class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center justify-center gap-2 text-center hover:bg-blue-600 transition z-10 shadow-md active:scale-95"
      onclick="window.location.href='{{ route('registerreview5') }}'">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-base sm:text-lg font-medium">Back</span>
    </button>

    <!-- Main Container -->
    <div class="bg-yellow-100 max-w-3xl w-full mx-auto rounded-2xl shadow-lg p-8 relative z-10">

      <!-- Header -->
      <div class="mt-4 flex flex-col items-start text-left max-w-xl mx-auto">
        <div class="flex items-center gap-2 border-b-2 border-blue-500 pb-1 w-full">
          <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2">
            Final Step
            <span class="text-gray-600 italic text-base">(Panghuling Hakbang)</span>
          </h2>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </div>

        <div class="mt-6 flex items-start gap-2">
          <div>
            <p class="text-gray-800 font-semibold">
              Please check the box if you agree to the agreement explained below.
            </p>
            <p class="text-gray-500 italic text-sm mt-1">
              (Paki-check ang kahon kung ikaw ay sumasang-ayon sa kasunduan na ipinaliwanag)
            </p>
          </div>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform mt-1">🔊</button>
        </div>

        <!-- Important Agreements -->
        <div class="bg-[#E8FBFB] border border-blue-200 rounded-2xl p-6 mt-6 shadow-sm">
          <!-- Header -->
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <img src="image/targeticon.png" alt="Info" class="w-6 h-6" />
              <h3 class="text-blue-600 font-semibold text-lg">
                Important Agreements
                <span class="text-sm text-gray-600 italic">(Mahalagang Kasunduan)</span>
              </h3>
            </div>
            <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform
            max-w-xl mx-auto">🔊</button>
          </div>

          <!-- Checkbox 1 -->
          <label class="flex items-start gap-4 bg-white/70 p-4 rounded-xl border border-blue-100 hover:bg-blue-50 transition mb-3 cursor-pointer shadow-sm" id="agree1_label">
            <input id="agree1" type="checkbox" class="w-6 h-6 mt-[2px] accent-blue-500 border-2 border-gray-400 rounded-md flex-shrink-0" />
            <div class="flex flex-col gap-1">
              <div class="flex items-start justify-between gap-2">
                <p class="text-[15px] font-medium text-gray-800 flex-1">
                  I agree to share my information with employers who have jobs that match my skills.
                </p>
                <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
              </div>
              <p class="text-gray-500 italic text-sm leading-snug">
                (Sumasang-ayon akong ibahagi ang aking impormasyon sa mga employer na may trabaho na tumutugma sa aking kakayahan.)
              </p>
            </div>
          </label>

          <!-- Checkbox 2 -->
          <label class="flex items-start gap-4 bg-white/70 p-4 rounded-xl border border-blue-100 hover:bg-blue-50 transition cursor-pointer shadow-sm" id="agree2_label">
            <input id="agree2" type="checkbox" class="w-6 h-6 mt-[2px] accent-blue-500 border-2 border-gray-400 rounded-md flex-shrink-0" />
            <div class="flex flex-col gap-1">
              <div class="flex items-start justify-between gap-2">
                <p class="text-[15px] font-medium text-gray-800 flex-1">
                  I understand that my information will be kept private and safe.
                </p>
                <button type="button" class="text-gray-500 text-lg leading-none hover:scale-110 transition-transform">🔊</button>
              </div>
              <p class="text-gray-500 italic text-sm leading-snug">
                (Nauunawaan ko na ang aking impormasyon ay papanatilihing pribado at ligtas.)
              </p>
            </div>
          </label>
        </div>

        <!-- Info Box -->
        <div class="bg-[#C7F5C4] border border-green-500 rounded-lg p-5 mt-6 shadow-sm">
          <div class="flex items-start justify-between gap-2">
            <div>
              <p class="text-[14px] text-gray-800">
                After creating your account, we will match you with jobs that fit your skills and preferences.
                You will receive notifications when new job opportunities are available.
              </p>
              <p class="italic text-gray-700 text-[13px] mt-2">
                (Pagkatapos gumawa ng iyong account, itutugma ka namin sa mga trabaho na ayon sa iyong kakayahan at
                kagustuhan. Makakatanggap ka ng notification kapag may bagong trabaho na available.)
              </p>
            </div>
            <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform mt-1">🔊</button>
          </div>
        </div>

        <!-- Create Account Button -->
        <div class="mt-8 flex flex-col items-center justify-center text-center w-full">
          <div id="finalError" class="text-red-600 text-sm mb-2"></div>
          <button id="createAccountBtn" type="button" class="bg-blue-500 text-white font-semibold text-lg px-12 sm:px-20 py-3 rounded-xl hover:bg-blue-600 transition shadow-md">
            Create My Account
          </button>
          <p class="text-[13px] text-gray-700 mt-3">
            Click <span class="text-blue-500 font-medium">“Create My Account”</span> to create your account
          </p>
          <p class="italic text-[12px] text-gray-500">
            (Pindutin ang “Create My Account” upang magawa ang iyong account)
          </p>
        </div>
      </div>
    </div>
  
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>