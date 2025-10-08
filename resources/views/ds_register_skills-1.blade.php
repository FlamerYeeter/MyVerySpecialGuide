<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Skills</title>
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
          Your Skills <span class="text-xl text-gray-600 italic">(Iyong Kakayanan)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h2>

        <!-- Description -->
        <div class="mt-4">
          <p class="text-base font-medium leading-snug flex items-center gap-2">
            What skills do you have? (Select all that apply)
            <button class="text-gray-500 text-xl hover:scale-110 transition-transform">
              🔊
            </button>
          </p>
          <p class="mt-1 text-[13px] text-gray-500 italic leading-snug">
            (Ano ang kakayahan na meron ka? Piliin lahat ng naaangkop na kakayahan na meron ka)
          </p>
        </div>

        <div class="flex items-center gap-2 mt-8">
          <p class="font-medium">Choose from the pictures provided and click your answer.</p>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </div>
        <p class="mt-2 text-[13px] text-gray-500 italic">
          (Pumili mula sa mga larawan at pindutin ang iyong sagot)
        </p>

        <!-- Skills Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

          <!-- Card 1 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill1.png" alt="talking to people" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Good at talking to people</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Magaling makipag-usap sa tao)</p>
          </div>

          <!-- Card 2 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill2.png" alt="using computer" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Using Computer</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Paggamit ng computer)</p>
          </div>

          <!-- Card 3 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill3.png" alt="organize" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Organizing things</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Pag-ayos ng mga bagay)</p>
          </div>

          <!-- Card 4 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill4.png" alt="work with others" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Working with others</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Pakikipagtulungan sa iba)</p>
          </div>

          <!-- Card 5 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill5.png" alt="creativity" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Art and creativity</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Sining at pagiging malikhain)</p>
          </div>

          <!-- Card 6 -->
          <div class="bg-white p-4 rounded-xl shadow h-[340px] transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/skill6.png" alt="help people" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Helping people</h3>
            <p class="text-[13px] text-gray-500 italic text-center">(Pagtulong sa kapwa)</p>
          </div>
        </div>

        <!-- Next Section -->
        <div class="w-full flex flex-col justify-center items-center text-center mt-10 mb-8">
            <p class="text-gray-700 font-medium mb-4">
                More options in the next page
            </p>
            
            <div class="flex flex-col items-center justify-center">
                <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
        onclick="window.location.href='{{ route('registerskills2') }}'">
                    Next →
                </button>
                <p class="text-gray-600 text-sm mt-3 max-w-md text-center">
                    Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
                    <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>
        </div>


     
  </div>
</body>
</html>
