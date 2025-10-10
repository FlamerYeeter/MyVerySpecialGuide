<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration: Personal Information</title>
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
    onclick="window.location.href='{{ route('register') }}'">
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
        Personal Information
        <span class="text-gray-600 italic text-base">(Impormasyon Tungkol sa Iyo)</span>
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
      </h2>

      <!-- Instruction -->
      <p class="mt-6 text-gray-700 text-[14px] leading-snug flex items-start gap-2">
        Please type your information inside the box. The text with a ⭐ star must be filled in.
        <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
      </p>
      
      <p class="mt-1 text-[13px] text-gray-500 italic border-b-2 border-blue-500 pb-1 w-full">
        (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may ⭐ bituin ay dapat sagutan.)
      </p>
    </div>

    <!-- Form -->
    <form class="mt-8 max-w-xl mx-auto">

      <!-- First & Last Name --> <!-- Fecth info from admin approval -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
        <!-- First Name -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            First Name <span>⭐</span>
            <button class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Unang Pangalan</p>
          <input type="text" placeholder="First name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-1">Type your first name (example: <span class="font-semibold">John</span>)</p>
        </div>

        <!-- Last Name -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">
            Last Name <span>⭐</span>
            <button class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Apelyido</p>
          <input type="text" placeholder="Last name" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200"/>
          <p class="text-gray-500 text-xs mt-1">Type your last name (example: <span class="font-semibold">Cruz</span>)</p>
        </div>
      </div>

      <!-- Email Address --> <!-- Fecth info from admin approval -->
      <div class="max-w-xl mx-auto mt-8 text-left">
         <label class="font-semibold text-sm flex items-center gap-1">
           Email Address <span>⭐</span>
           <button class="text-gray-500 text-xl hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
          </label>
          <p class="text-gray-500 italic text-[13px]">Email Address</p>
          <input type="email" placeholder="Email Address" class="mt-1 w-full border border-gray-300 rounded-md px-3 
          py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-2">
            Type your email (example: <span class="font-semibold">john@gmail.com</span>). 
            The account confirmation will be sent to your email.<br>
            <span class="italic text-gray-500">(Ang kumpirmasyon ay ipapadala sa iyong email.)</span>
          </p>
        </div>

         <!-- Phone and Age -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left mt-8">
        <!-- Phone -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">Phone Number <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">
            🔊</button></label>
          <p class="text-gray-500 italic text-[13px]">Telepono</p>
          <input type="text" placeholder="+63 9XX XXX XXXX" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-1">
            Type your phone number (example: <span class="font-semibold">+63 917 123 4567</span>). This is optional.
          </p>
        </div>

        <!-- Age -->
        <div>
          <label class="font-semibold text-sm flex items-center gap-1">Age <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">
            🔊</button></label>
          <p class="text-gray-500 italic text-[13px]">Edad</p>
          <input type="number" placeholder="Age" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
          <p class="text-gray-500 text-xs mt-1">Type your age (example: <span class="font-semibold">20 years old</span>).</p>
        </div>
      </div>

      <!-- Create Password -->
      <div>
        <label class="font-semibold text-sm flex items-center mt-8 gap-1">Create Password ⭐ <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">
          🔊</button></label>
        <p class="text-gray-500 italic text-[13px]">Gumawa ng Password</p>
        <input type="password" placeholder="Password" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
        <p class="text-gray-500 text-xs mt-1">
          Type a strong password to keep your account safe.
          <span class="italic text-gray-500">(Gumawa ng matibay na password para safe ang account mo)</span>
        </p>
        <div class="flex items-center gap-2 mt-2 text-sm text-gray-700">
          <input type="checkbox" class="accent-blue-500" />
          <span>Click the box to show password. 
            <span class="italic text-gray-500">(Pindutin ang box para makita ang password)</span>
          </span>
        </div>
      </div>

     <!-- Password Rules -->
<div class="grid grid-cols-1 md:grid-cols-2 bg-blue-50 border border-blue-300 rounded-lg p-4 mt-4 text-sm gap-x-8">
  
  <!-- English Section -->
  <div>
    <p class="font-semibold mb-1 flex items-center gap-2">
      English 
      <button class="text-gray-600 text-lg hover:scale-110 transition-transform" title="Play audio">🔊</button>
    </p>
    <p class="mb-2">Password must have:</p>
    <ul class="list-disc list-inside space-y-1">
      <li>One big letter (A, B, C)</li>
      <li>One small letter (a, b, c)</li>
      <li>One number (1, 2, 3)</li>
      <li>At least 8 mixed of letters and numbers</li>
    </ul>
    <p class="mt-2 text-gray-800 font-semibold">Example: Lovedog12</p>
  </div>

  <!-- Tagalog Section -->
  <div>
    <p class="font-semibold mb-1 flex items-center gap-2">
      Tagalog 
      <button class="text-gray-600 text-lg hover:scale-110 transition-transform" title="Play audio">🔊</button>
    </p>
    <p class="mb-2">Ang password dapat ay may:</p>
    <ul class="list-disc list-inside space-y-1">
      <li>Isang malaking letra (A, B, C)</li>
      <li>Isang maliit na letra (a, b, c)</li>
      <li>Isang numero (1, 2, 3)</li>
      <li>Hindi bababa sa 8 letra at numero</li>
    </ul>
    <p class="mt-2 text-gray-800 font-semibold">Halimbawa: Lovedog12</p>
  </div>
</div>


      <!-- Confirm Password -->
      <div>
        <label class="font-semibold text-sm flex items-center mt-8 gap-1">Type Password Again ⭐ <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">
          🔊</button></label>
        <p class="text-gray-500 italic text-[13px]">I-type muli ang password</p>
        <input type="password" placeholder="Password" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
        <p class="text-gray-500 text-xs mt-1">
          Type the same password again to make sure it’s correct.
          <span class="italic text-gray-500">(I-type muli ang parehong password para siguradong tama)</span>
        </p>
        <div class="flex items-center gap-2 mt-2 text-sm text-gray-700">
          <input type="checkbox" class="accent-blue-500" />
          <span>Click the box to show password. 
            <span class="italic text-gray-500">(Pindutin ang box para makita ang password)</span>
          </span>
        </div>
      </div>

      <!-- Next Button -->
      <div class="text-center mt-12">
        <button class="bg-blue-500 text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
          onclick="window.location.href='{{ route('registerguardianinfo') }}'">
          Next →
        </button>
        <p class="text-gray-700 text-sm mt-3">
          Click <span class="text-blue-500 font-medium">“Next”</span> to move to the next page Parent/Guardian Information
        </p>
        <p class="text-gray-500 italic text-[13px]">
          (Pindutin ang “Next” upang lumipat sa susunod na pahina)
        </p>
      </div>
    </form>
  </div>


</body>
</html>