<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Admin Approval</title>
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
  <button type="button"
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
    <div class="text-center mt-8">
      <h1 class="text-2xl font-semibold text-black mb-4">Create An Account</h1>
      <img src="image/obj6.png" alt="Pink Stone Object" class="mx-auto w-24 h-24 mb-4">
    </div>

    <!-- Section Header -->
    <div class="flex flex-col items-start text-left max-w-xl mx-auto">
      <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2">
        For Admin Approval 
        <span class="text-gray-600 italic text-base">(Pahintulot sa Admin)</span>
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
      </h2>

      <!-- Instruction -->
      <p class="mt-6 text-gray-700 text-[14px] leading-snug flex items-start gap-2">
        Please type your information inside the box. The text with a ⭐ star must be filled in.
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </p>
      
      <p class="mt-1 text-[13px] text-gray-500 italic border-b-2 border-blue-500 pb-1 w-full">
        (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may ⭐ bituin ay dapat sagutan.)
      </p>
    </div>

    <!-- Form -->
    <form class="mt-8 max-w-xl mx-auto">

      <!-- First & Last Name -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
        <!-- First Name -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            First Name <span>⭐</span>
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Unang Pangalan</p>
          <input type="text" placeholder="First name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-1">
            Type your first name (example: <span class="font-semibold">John</span>)
          </p>
        </div>

        <!-- Last Name -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            Last Name <span>⭐</span>
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Apelyido</p>
          <input type="text" placeholder="Last name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"/>
          <p class="text-gray-500 text-xs mt-1">
            Type your last name (example: <span class="font-semibold">Cruz</span>)
          </p>
        </div>
      </div>

      <!-- Email Address -->
      <div class="max-w-xl mx-auto mt-8 text-left">
        <label class="font-semibold text-sm flex items-center gap-1">
          Email Address <span>⭐</span>
          <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </label>
        <p class="text-gray-500 italic text-[13px]">Email Address</p>
        <input type="email" placeholder="Email Address" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
        <p class="text-gray-500 text-xs mt-2">
          Type your email (example: <span class="font-semibold">john@gmail.com</span>).
          The confirmation will be sent to your email.<br>
          <span class="italic text-gray-500">(Ang kumpirmasyon ay ipapadala sa iyong email.)</span>
        </p>
      </div>
        
      <!-- Submit Button -->
      <div class="text-center mt-20"> 
        <p class="text-gray-600 text-sm mb-2">
          Pindutin ang <span class="text-blue-500 font-medium">“Click to Submit for Approval”</span>
        </p>
        <button type="submit"
          class="bg-blue-500 text-white font-semibold text-lg px-16 py-3 rounded-xl hover:bg-blue-600 transition shadow-md">
          Click to Submit for Approval
        </button>
      </div>
    </form>

    <!-- Notes -->
    <div class="flex flex-col text-left mt-8 max-w-xl mx-auto">
      <p class="font-medium text-[13px] text-gray-700">
        Check your email inbox for the approval confirmation message to proceed to the next step.
      </p>
      <p class="text-gray-500 italic text-justify text-[12px] mt-1">
        (Suriin ang iyong email inbox para sa mensahe ng kumpirmasyon ng pag-apruba upang magpatuloy sa susunod na hakbang)
      </p>

      <p class="text-center mt-12 text-gray-600">
        Didn’t receive confirmation? Click
        <a href="#" class="text-blue-500 font-medium hover:underline">Resend</a>
      </p>
      <p class="text-center text-gray-500 italic text-[13px]">
        (Hindi nakatanggap ng kumpirmasyon? I-click ang “Resend”)
      </p>
    </div>

  </div>

</body>
</html>
