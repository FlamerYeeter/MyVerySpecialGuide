<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Education</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Floating animation */
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
    onclick="window.location.href='{{ route('registerguardianinfo') }}'">
    Back
  </button>

  <!-- Main Card -->
  <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10 mt-12 mb-12">

    <!-- Header -->
    <div class="text-center">
      <h1 class="text-2xl font-semibold text-black mb-4">Create An Account</h1>
      <img src="image/obj6.png" alt="Pink Stone Object" class="mx-auto w-24 h-24 mb-4">
    </div>

    <!-- Section Header -->
    <div class="max-w-xl mx-auto text-left">
      <h2 class="text-xl font-semibold text-blue-500 border-b-2 border-blue-500 w-full pb-1 mb-4 flex items-center gap-2">
        Your Qualification 
        <span class="text-gray-600 italic text-base">(Iyong Kwalipikasyon)</span>
        <button class="text-gray-500 text-xl hover:scale-110 transition-transform">🔊</button>
      </h2>

      <!-- Education Question -->
      <div class="mt-4">
        <h3 class="text-lg font-semibold">Education</h3>
        <p class="mt-2 text-base font-medium flex items-center gap-1.5">
          <span>What is your highest education?</span>
          <button class="text-gray-500 text-lg hover:scale-110 transition-transform">🔊</button>
        </p>
        <p class="text-gray-500 italic text-[13px] mt-1">(Ano ang pinakamataas mong natapos na grade o taon sa school?)</p>
      </div>

      <!-- Instruction -->
      <div class="mt-6">
        <div class="flex items-center gap-2">
          <p class="font-medium">Choose from the pictures provided and click your answer.</p>
          <button class="text-gray-500 text-xl hover:scale-110 transition-transform">🔊</button>
        </div>
        <p class="text-[13px] text-gray-500 italic mt-1">(Pumili mula sa mga larawan at pindutin ang iyong sagot)</p>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

        <!-- Card 1 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/educ1.png" alt="elementary" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Elementary</h3>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/educ3.png" alt="highschool" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Highschool</h3>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/educ2.png" alt="college" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">College</h3>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <img src="image/educ4.png" alt="vocational" class="w-full rounded-md mb-4">
          <h3 class="text-blue-600 font-semibold text-center">Vocational/Training</h3>
        </div>

        <!-- Other -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px] hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 transition cursor-pointer relative">
          <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
          <h3 class="text-blue-600 font-semibold text-center mb-2">Other</h3>
          <p class="text-sm text-justify mt-4">Type your answer inside the box if not in the choices</p>
          <p class="text-[13px] text-gray-500 italic mt-1 mb-3 text-justify">(Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)</p>
          <input type="text" placeholder="Type your answer here" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>
      </div>
      
        <!-- Next Button -->
        <div class="flex flex-col items-center justify-center mt-12 mb-8 space-y-4">
        <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
        onclick="window.location.href='{{ route('registerschoolworkinfo') }}'">
          Next →
        </button>

        <p class="text-gray-600 text-sm mt-2 text-center">
          Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
          <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
</body>
</html>
