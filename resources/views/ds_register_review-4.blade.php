<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
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
      class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center justify-center gap-2 text-center hover:bg-blue-600 transition z-10 shadow-md active:scale-95">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-base sm:text-lg font-medium">Back</span>
    </button>

    <!-- Main Container -->
    <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

      <!-- Header -->
      <div class="mt-4 flex flex-col items-start text-left max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 border-b-2 border-blue-500 pb-1 w-full">
          Review Your Skills
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Kakayanan)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>

        <h2 class="text-[15px] font-semibold mt-8">
          Please review the skills you selected.
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
          <br />
          <span class="mt-8 text-[14px] text-gray-600 italic">(Pakisuri ang mga kakayanan na iyong pinili)</span>
        </h2>
      </div>

      <!-- Skills Information Form -->
      <form class="mt-6 max-w-xl mx-auto">
        <label class="font-semibold text-[15px] flex items-center gap-1">
          You can remove skills by clicking the ❌ button or add more by clicking "Add More Skills".
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">
          (Maaari kang magtanggal ng skills sa pag-click ng ❌ button o magdagdag pa sa pag-click ng "Add More Skills")
        </p>

        <p class="font-semibold text-black text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>

        <!-- Skills Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

          <!-- Card 1 -->
          <div class="bg-white p-4 rounded-xl shadow h-[360px] relative border-2 border-blue-500 group transition-all duration-300 hover:shadow-lg">
            <!-- Audio button -->
            <button type="button" class="absolute top-3 left-10 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <!-- Remove button -->
            <button type="button"
              class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow transition"
              title="Remove Skill">❌</button>
            <img src="image/skill1.png" alt="talking to people" class="w-full rounded-md mb-4 mt-6" />
            <h3 class="text-blue-600 font-semibold text-center">Good at talking to people</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Magaling makipag-usap sa tao)</p>
          </div>

          <!-- Card 2 -->
          <div class="bg-white p-4 rounded-xl shadow h-[360px] relative border-2 border-blue-500 group transition-all duration-300 hover:shadow-lg">
            <!-- Audio button -->
            <button type="button" class="absolute top-3 left-10 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <!-- Remove button -->
            <button type="button"
              class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow transition"
              title="Remove Skill">❌</button>
            <img src="image/skill2.png" alt="using computer" class="w-full rounded-md mb-4 mt-6" />
            <h3 class="text-blue-600 font-semibold text-center">Using Computer</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Paggamit ng computer)</p>
          </div>

        </div>

        <!-- Add More Skills Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang "Add More Skills" upang baguhin ang iyong sagot.)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            <span class="text-xl mr-2">➕</span> Click Add More Skills
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-6 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black leading-relaxed">
              Your skills help us know what kind of job is good for you.
            </p>
            <button type="button" class="text-green-600 text-xl leading-none hover:text-green-700 hover:scale-110 transition-transform mt-[2px]" title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Ang iyong mga kasanayan ay tumutulong sa amin na malaman kung anong uri ng trabaho ang nababagay sa iyo)
          </p>
        </div>

        <!-- Continue Button -->
        <div class="text-center mt-12">
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center mx-auto shadow-md">
            Continue →
          </button>
          <p class="text-gray-700 text-sm mt-3">
            Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
          </p>
          <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Continue” upang magpatuloy)</p>
        </div>
      </form>
    </div>

  </body>
</html>
