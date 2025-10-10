<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Parent/Guardian Information</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Floating animations */
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
    class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0">
  <img src="image/obj7.png" alt="Triangle Mascot"
    class="fixed left-2 sm:left-6 lg:left-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0">
  <img src="image/obj3.png" alt="Blue Mascot"
    class="fixed right-2 sm:right-6 lg:right-8 top-1/4 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-fast z-0">
  <img src="image/obj8.png" alt="Twin Mascot"
    class="fixed right-2 sm:right-6 lg:right-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0">

  <!-- Back Button -->
  <button
    class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center gap-2 hover:bg-blue-600 transition z-10 shadow-md active:scale-95"
    onclick="window.location.href='{{ route('registerpersonalinfo') }}'">
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
        Parent/Guardian
        <span class="text-gray-600 italic text-base">(Magulang/Tagapag Alaga)</span>
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
      </h2>

      <!-- Instruction -->
      <p class="mt-6 text-gray-700 text-[14px] leading-snug flex items-start gap-2">
        Please type your information inside the box. The boxes with a ⭐ star must be filled in.
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </p>
      
      <p class="mt-1 text-[13px] text-gray-500 italic border-b-2 border-blue-500 pb-1 w-full">
        (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga kahon na may ⭐ bituin ay dapat sagutan.)
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
          <p class="text-gray-500 text-xs mt-1">Type your Parent/Guardian name (example: <span class="font-semibold">John</span>)</p>
        </div>

        <!-- Last Name -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            Last Name <span>⭐</span>
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Apelyido</p>
          <input type="text" placeholder="Last name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"/>
          <p class="text-gray-500 text-xs mt-1">Type your Parent/Guardian name (example: <span class="font-semibold">Cruz</span>)</p>
        </div>
      </div>

      <!-- Email and Phone -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left mt-8">
        <!-- Email -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            Email Address <span>⭐</span>
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Email</p>
          <input type="email" placeholder="Email" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-1">
            Type your Parent/Guardian email (example: <span class="font-semibold">john@gmail.com</span>).
          </p>
        </div>
        
        <!-- Phone -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            Phone Number <span>⭐</span>
            <button type="button" class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Telepono</p>
          <input type="tel" placeholder="+63 9XX XXX XXXX" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-1">
            Type your Parent/Guardian phone number (example: <span class="font-semibold">+63 917 123 4567</span>).
          </p>
        </div>
      </div>

      <!-- Relationship -->
      <div class="mt-8">
        <p class="mt-4 text-base font-medium leading-snug flex items-center gap-1.5">
          <span>How are you related?</span>
          <button type="button" class="text-gray-500 text-lg hover:scale-110 transition-transform">🔊</button>
        </p>
        <p class="mt-1 text-[15px] text-gray-500 italic leading-snug">(Kaano-ano mo siya?)</p>
      </div>

      <div class="flex items-center gap-2 mt-8">
        <p class="font-medium">Choose from the pictures provided and click your answer.</p>
        <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </div>
      <p class="mt-2 text-[13px] text-gray-500 italic">
        (Pumili mula sa mga larawan at pindutin ang iyong sagot)
      </p>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
        <!-- Card 1 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/guardian1.png" alt="parent" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Parent</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Magulang - Nanay o Tatay)</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/guardian2.png" alt="sibling" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Sibling</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Kapatid - Ate o Kuya)</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/guardian3.png" alt="guardian" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Guardian</h3>
          <p class="text-[13px] text-gray-500 italic text-center">(Tagapag-alaga)</p>
        </div>

        <!-- Other -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <h3 class="text-blue-600 font-semibold text-center mb-2">Other</h3>
          <p class="mt-6 text-sm text-justify">Type your answer inside the box if not in the choices</p>
          <p class="text-[13px] text-gray-500 italic mt-1 mb-3 text-justify">
            (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
          </p>
          <input type="text" placeholder="Type your answer here" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>
      </div>

      <!-- Next Button -->
      <div class="text-center mt-12">
        <button type="button" class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
          onclick="window.location.href='{{ route('registereducation') }}'">
          Next →
        </button>
        <p class="text-gray-700 text-sm mt-3">
          Click <span class="text-blue-500 font-medium">“Next”</span> to move to the next page Your Qualifications
        </p>
        <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Next” upang lumipat sa susunod na pahina)</p>
      </div>
    </form>
  </div>
</body>
</html>
