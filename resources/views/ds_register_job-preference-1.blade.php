<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Job Preference</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

  <!-- Floating Mascots -->
  <img src="image/obj4.png" alt="Yellow Mascot"
    class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0">

  <img src="image/obj7.png" alt="Yellow Mascot"
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
    <h2 class="text-xl font-semibold text-blue-500 border-b-2 border-blue-500 w-full mb-2">
        Job Preferences <span class="ml-2 text-xl text-gray-600 italic">(Trabahong Iyong Gusto)</span>
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
    </h2>
    
    <!-- Description -->
    <div class="flex items-center gap-2 mt-4">
        <p class="text-m font-medium">
            Based on your skills, here are jobs that match you:
        </p>
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
    </div>
    <p class="mt-2 text-[13px] text-gray-500 italic">
        (Batay sa iyong mga kakayahan, narito ang mga trabahong bagay sa iyo)
    </p>
    
    <!-- Skills --> <!-- Fetch the input skills of the user -->
    <div class="flex items-center gap-2 mt-8">
        <p class="font-medium">Your Skills:</p>
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
    </div>
    <p class="mt-2 text-blue-500 text-m font-semibold underline">
         Good at talking to people,&nbsp;&nbsp;Organizing things,&nbsp;&nbsp; Helping people
    </p>
    
    <!-- Instructions --> <!-- Display Job Roles based to input skills -->
    <div class="flex items-start gap-1 mt-10">
      <div>
        <p class="text-base font-medium leading-snug">
          Choose your job preferences from the pictures provided and click your answers and you can select up to 3–5 options only.
        </p>
        <p class="mt-2 text-[13px] text-gray-500 italic leading-snug">
          (Piliin ang mga trabahong gusto mo mula sa mga larawang ibinigay. I-click ang iyong sagot.
          Maaari kang pumili ng 3 hanggang 5 na opsyon lamang.)
        </p>
    </div>
    <button class="text-gray-500 text-xl hover:scale-110 transition-transform -ml-4"> 🔊</button>
    </div>
    
    <!-- Job Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">

     <!-- Food Service Work -->
    <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
        <!-- Audio Button -->
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">
            🔊
        </button>
        <img src="image/officework.png" alt="Office Work" class="w-full rounded-md mb-4" />
        <h3 class="text-blue-600 font-semibold text-center">Office Work</h3>
        <p class="text-sm mt-2 text-justify">
             In this job, you will use the computer for simple tasks, answer the phone politely, and keep papers organized in folders.
        </p>
        <p class="text-[13px] text-gray-500 text-justify italic mt-2">
            (Sa trabahong ito, gagamit ka ng computer para sa simpleng gawain, sasagot ng telepono nang magalang, at aayusin ang mga papeles sa mga folder.)
        </p>
    </div>

      <!-- Packing Work -->
      <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
        <!-- Audio Button -->
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">
            🔊
        </button>
        <img src="image/storework.png" alt="Store Work" class="w-full rounded-md mb-4" />
        <h3 class="text-blue-600 font-semibold text-center">Store Work</h3>
        <p class="text-sm mt-2 text-justify">
          You will help customers find what they need, place items neatly on shelves, and work at the cashier to take payments.
        </p>
        <p class="text-[13px] text-gray-500 text-justify italic mt-2">
          (Tutulungan mo ang mga customer na hanapin ang kanilang kailangan, maayos na ilalagay ang mga paninda sa mga lagayan, at magtatrabaho sa cashier para tumanggap ng bayad.)
        </p>
      </div>

      <!-- Creative Work -->
      <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
        <!-- Audio Button -->
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">
            🔊
        </button>
        <img src="image/cleaningwork.png" alt="Cleaning Work" class="w-full rounded-md mb-4" />
        <h3 class="text-blue-600 font-semibold text-center">Cleaning Work</h3>
        <p class="text-sm mt-2 text-justify">
          You will sweep or mop the floor, wipe tables and windows, and make sure rooms stay neat and tidy.
        </p>
        <p class="text-[13px] text-gray-500 text-justify italic mt-2">
          (Magwawalis o mag-mop ka ng sahig, magpupunas ng mga mesa at bintana, at sisiguraduhing malinis at maayos ang mga silid.)
        </p>
      </div>

       <!-- Hospitality Work -->
      <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative">
        <!-- Audio Button -->
        <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">
            🔊
        </button>
        <img src="image/hospitalitywork.png" alt="Hospitality Work" class="w-full rounded-md mb-4" />
        <h3 class="text-blue-600 font-semibold text-center">Hospitality Work</h3>
        <p class="text-sm mt-2 text-justify">
          You will greet guests with a smile, help clean and prepare rooms, and carry small items like towels.
        </p>
        <p class="text-[13px] text-gray-500 text-justify italic mt-2">
          (Sasalubungin mo ang mga bisita nang may ngiti, tutulong sa paglilinis at paghahanda ng mga kuwarto, at magdadala ng maliliit na gamit tulad ng tuwalya.)
        </p>
      </div>
    </div>

    <!-- Next Button -->
<div class="w-full flex flex-col items-center justify-center mt-12 mb-8">
  <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
        onclick="window.location.href='{{ route('registerjobpreference2') }}'">
    Next →
  </button>
  <p class="text-gray-600 text-sm mt-2 text-center">
    Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page for more Job Preferences Options<br>
    <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
  </p>
</div>


</body>
</html>