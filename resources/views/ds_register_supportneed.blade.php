<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Support Need</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center justify-center gap-2 text-center hover:bg-blue-600 transition z-10 shadow-md active:scale-95">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <span class="text-base sm:text-lg font-medium">Back</span>
  </button>

  <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

    <!-- Header -->
    <div class="text-center mt-8">
      <h1 class="text-2xl font-semibold text-black mb-4">Create An Account</h1>
      <img src="image/obj6.png" alt="Pink Stone Object" class="mx-auto w-24 h-24 mb-4">

      <!-- Section Header -->
      <div class="flex flex-col items-start text-left max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-blue-500 border-b-2 border-blue-500 w-full mb-2 flex items-center gap-2">
          Your Qualification <span class="text-xl text-gray-600 italic">(Iyong Kwalipikasyon)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h2>

        <!-- Description -->
        <div class="mt-4">
           <h2 class= "text-xl font-semibold" >Support I Need</h2> 
          <p class="mt-4 text-base font-medium leading-snug flex items-center gap-2">
            What kind of support would help you at work? (Select all that apply)
            <button class="text-gray-500 text-xl hover:scale-110 transition-transform">
              🔊
            </button>
          </p>
          <p class="mt-1 text-[13px] text-gray-500 italic leading-snug">
            (Ano klaseng tulong ang makakatulong sa iyo sa trabaho? Piliin lahat ng naaangkop na kakayahan na meron ka)
          </p>
        </div>

        <div class="flex items-center gap-2 mt-8">
          <p class="font-medium">Choose from the pictures provided and click your answer.</p>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </div>
        <p class="mt-2 text-[13px] text-gray-500 italic">
          (Pumili mula sa mga larawan at pindutin ang iyong sagot)
        </p>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

          <!-- Card 1 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/support1.png" alt="job coach" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Job coach/guide to guide me</h3>
          </div>

            <!-- Card 2 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/support2.png" alt="written instruction" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Written instructions</h3>
          </div>

            <!-- Card 3 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/support3.png" alt="work independtly" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">I can work independtly</h3>
          </div>

          <!-- Other -->
        <div class="bg-white p-4 rounded-xl shadow h-[340px]  transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
          <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
          <h3 class="text-blue-600 font-semibold text-center mb-2">Other</h3>
          <p class="mt-6 text-sm text-justify">
            Type your answer inside the box if not in the choices
          </p>
          <p class="text-[13px] text-gray-500 italic mt-1 mb-3 text-justify">
            (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
          </p>
          <input type="text" placeholder="Type your answer here"
                 class="sw-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
      </div>

        <!-- Next Button -->
        <div class="w-full flex flex-col items-center justify-center mt-12 mb-8">
            <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
                    onclick="window.location.href='{{ route('registerworkplace') }}'">
                Next →
            </button>
            <p class="text-gray-600 text-sm mt-2 text-center">
                 Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page Working Environment<br>
                 <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
        </div>

     </div>
</body>
</html>
