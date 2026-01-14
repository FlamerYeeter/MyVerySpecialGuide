<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Approval</title>
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
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
    }
    </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots (hidden on very small screens to avoid clutter) -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-6 top-1/3 w-28 lg:w-36 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="fixed left-1 sm:left-4 md:left-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-20 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-6 top-1/4 w-28 lg:w-36 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-6 bottom-24 w-28 lg:w-36 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('dataprivacy') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-6">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Create an
                Account</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-32 md:w-36 mb-6">

            <!-- Instruction Box -->
            <div class="bg-white rounded-3xl p-5 sm:p-7 md:p-8 border-4 border-blue-300 shadow-lg text-left">
             <!--    <h2 class="text-lg sm:text-xl md:text-2xl text-blue-600 font-bold flex flex-wrap items-center gap-x-3">
                    For Admin Approval
                    <span class="text-gray-600 italic text-sm sm:text-base">(Pahintulot sa Admin)</span> 
                    <button type="button" class="text-xl hover:scale-110 transition-transform tts-btn"
                        data-tts-en="For Admin Approval. Please type your information inside the box. The fields marked with a star must be filled in and attach a valid proof of membership."
                        data-tts-tl="Pahintulot sa Admin. Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may bituin ay dapat sagutan at mag-upload ng patunay na miyembro."
                        aria-label="Play audio for admin instruction">🔊</button>
                </h2> -->
                <p class="text-gray-800 text-sm sm:text-base mt-2">
                    Please type your information inside the box. The text with a ⭐ star must be filled in.
                </p>
                <p class="text-gray-600 italic text-sm sm:text-base mt-4 border-b-2 border-blue-400 pb-2">
                    (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may ⭐ bituin ay dapat sagutan.)
                </p>
            </div>
        </div>

        <!-- Overall Information Note -->
        <div
            class="relative bg-[#EEF4FF] border border-blue-200 text-blue-800 rounded-xl p-4 sm:p-5 md:p-6 mt-6 shadow-sm">

            <!-- Audio Button -->
            <button type="button" aria-label="Play audio for information note"
                class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white
                text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                data-tts-en="Please fill out all the required information below accurately. The details you provide help our administrators verify your account, confirm your eligibility, and ensure proper communication during the approval process."
                data-tts-tl="Mangyaring punan nang tama ang lahat ng kinakailangang impormasyon sa ibaba. Ang mga detalyeng iyong ibibigay ay makatutulong sa aming mga tagapangasiwa upang beripikahin ang iyong account, kumpirmahin ang iyong pagiging karapat-dapat, at tiyakin ang maayos na komunikasyon sa proseso ng pag-apruba.">
                🔊
            </button>

            <div class="flex items-start gap-3 pr-20"> <!-- Added right padding here -->
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 flex-shrink-0 mt-0.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1">
                    <p class="font-semibold text-sm sm:text-base leading-relaxed text-blue-800">
                     Please fill out all the required information below completely and accurately.
                     The details you provide will help us create your account, confirm your identity, 
                     and ensure we can contact you if we need additional information. Providing correct information 
                     will help you finish your registration smoothly and avoid delays.
                    </p>
                    <p class="italic text-gray-600 text-xs sm:text-sm mt-2 leading-relaxed">
                        (Pakisagutan nang kumpleto at tama ang impormasyon sa ibaba. Kailangan namin ito para magawa ang iyong
                         account, makilala ka, at makontak ka kung kailangan pa namin ng ibang detalye. Ang tamang impormasyon 
                         ay makakatulong para maging mabilis at maayos ang inyong registration at maiwasan ang anumang delay.)
                    </p>
                </div>
            </div>
        </div>



        <!-- Form -->
        <form id="registrationForm" class="mt-10 space-y-10 text-left">
            <!-- Personal Information -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Personal Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            First Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Unang Pangalan</p>
                        <input id="first_name" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Last Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Apelyido</p>
                        <input id="last_name" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Age <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Edad</p>
                        <input id="age" type="number" placeholder="Age"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Email -->
                    <div>
                        <label for="email"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Email <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Email</p>
                        <input id="email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="phone"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Contact Number <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Numero ng Telepono</p>
                        <input   id="phone" 
                                type="tel" 
                                placeholder="+63 9XX XXX XXXX"
                                pattern="^\+63\s?9\d{2}\s?\d{3}\s?\d{4}$"
                                title="Please enter a valid Philippine number (e.g. +63 912 345 6789)"
                                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <!-- Address -->
                <div class="mt-6">
                    <label for="address" class="font-semibold text-gray-800 text-sm sm:text-base">
                        Address <span>⭐</span>
                    </label>
                    <p class="text-gray-600 italic text-xs sm:text-sm">Tirahan</p>
                    <input id="address" type="text" placeholder="Complete Address"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                </div>
            </div>

            <!-- Type of Down Syndrome -->
            <div
                class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-5">

                <!-- Text Section -->
                <div class="flex-1">
                    <h3
                        class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                        Type of Down Syndrome <span class="text-[#4B5258] text-m">(optional)</span>
                    </h3>
                    <p class="text-black-600 text-xs sm:text-sm leading-snug mt-1">
                        You may fill this in if you already have records or a doctor’s assessment that shows your type
                        of Down syndrome.
                        It’s perfectly okay if you’re not aware of it yet — you can leave it blank.
                    </p>

                    <p class="text-gray-600 italic text-xs sm:text-sm leading-snug mt-4">
                        (Opsyonal lamang ito. Maaari mo itong sagutan kung mayroon ka nang tala o pagsusuri mula sa
                        doktor na nagpapakita
                        ng uri ng iyong Down syndrome. Ayos lang din kung hindi mo pa ito alam — maaari mo itong
                        laktawan.)
                    </p>
                </div>

                <!-- Dropdown Selector -->
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <select id="dsType" name="dsType"
                        class="w-full sm:w-60 border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Type --</option>
                        <option value="Trisomy 21 (Nondisjunction)">Trisomy 21 (Nondisjunction)</option>
                        <option value="Mosaic Down Syndrome">Mosaic Down Syndrome</option>
                        <option value="Translocation Down">Translocation Down Syndrome</option>
                    </select>
                </div>
            </div>


            <!-- Guardian Information -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Guardian Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Guardian First Name -->
                    <div>
                        <label for="guardian_first"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            First Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Unang Pangalan</p>
                        <input id="guardian_first" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Guardian Last Name -->
                    <div>
                        <label for="guardian_last"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Last Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Apelyido</p>
                        <input id="guardian_last" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Guardian Email -->
                    <div>
                        <label for="guardian_email"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Email <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Email</p>
                        <input id="guardian_email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Guardian Contact -->
                    <div>
                        <label for="guardian_phone"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Contact Number <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Numero ng Telepono</p>
                        <input id="guardian_phone" type="tel" placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <!-- Relationship -->
                <div class="mt-6">
                    <label for="guardian_relationship" class="font-semibold text-gray-800 text-sm sm:text-base">
                        Relationship to Account Holder <span>⭐</span>
                    </label>
                    <p class="text-gray-600 italic text-xs sm:text-sm">Relasyon sa May-ari ng Account</p>
                    <select id="guardian_relationship"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring focus:ring-blue-200 focus:outline-none">
                        <option value="" disabled selected>Select Relationship</option>
                        <option value="parent">Parent</option>
                        <option value="guardian">Guardian</option>
                        <option value="sibling">Sibling</option>
                        <option value="relative">Relative</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Account Details -->
            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Account Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="font-semibold flex items-center gap-1">Username
                            <span>⭐</span></label>
                        <input id="username" name="username" type="text" placeholder="Enter your username"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                        <p class="text-gray-500 text-xs mt-1">(example: @juancruz)</p>
                    </div>

                    <!-- Create Password -->
                    <div>
                        <label for="password" class="font-semibold flex items-center gap-1">Create Password
                            <span>⭐</span></label>
                        <input   id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="Enter your password"
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                                    title="Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and be 8+ characters long."
                                    class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                            <label for="togglePassword" class="text-sm text-gray-700 cursor-pointer leading-snug">
                                 <p id="passwordMessage" 
                                class="mt-1 text-sm text-red-500 italic hidden">
                                Password must have at least 1 uppercase, 1 lowercase, 1 number, and be 8+ characters long.
                                </p>
                    </div>
                </div>
                 

                <!-- Password Rules -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-blue-50 border border-blue-300 rounded-xl p-6 mt-6 text-sm gap-6 shadow-inner">
                    <!-- English -->
                    <div>
                        <p class="font-semibold text-blue-700 mb-2 flex items-center gap-2">English <button
                                type="button"
                                class="text-gray-600 text-lg hover:scale-110 transition-transform tts-btn"
                                title="Play audio" aria-label="Play audio for password rules (English)"
                                data-tts-en="Password must have: One uppercase letter, one lowercase letter, one number, and at least eight characters. Example: Lovedog12."
                                >🔊</button>
                        </p>
                        <p class="mb-2">Password must have:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>One uppercase letter (A, B, C)</li>
                            <li>One lowercase letter (a, b, c)</li>
                            <li>One number (1, 2, 3)</li>
                            <li>At least 8 characters (letters + numbers)</li>
                        </ul>
                        <p class="mt-3 text-gray-800 font-semibold">Example: Lovedog12</p>
                    </div>

                    <!-- Tagalog -->
                    <div>
                        <p class="font-semibold text-blue-700 mb-2 flex items-center gap-2">Tagalog <button
                                type="button"
                                class="text-gray-600 text-lg hover:scale-110 transition-transform tts-btn"
                                title="Play audio" aria-label="Play audio for password rules (Tagalog)"
                                data-tts-tl="Ang password ay dapat mayroong: isang malaking letra, isang maliit na letra, isang numero, at hindi bababa sa 8 karakter na halo ng letra at numero. Halimbawa: Lovedog12.">🔊</button>
                        </p>
                        <p class="mb-2">Ang password ay dapat mayroong:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Isang malaking letra (A, B, C)</li>
                            <li>Isang maliit na letra (a, b, c)</li>
                            <li>Isang numero (1, 2, 3)</li>
                            <li>Hindi bababa sa 8 karakter na halo ng letra at numero</li>
                        </ul>
                        <p class="mt-3 text-gray-800 font-semibold">Halimbawa: Lovedog12</p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-6">
                    <label for="confirmPassword" class="font-semibold text-base flex items-center gap-1">Confirm
                        Password <span>⭐</span></label>
                    <input id="confirmPassword" name="confirmPassword" type="password"
                        placeholder="Re-enter your password"
                        class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                </div>
                  <p id="confirmMessage" class="mt-1 text-sm text-red-500 italic hidden">
                    Passwords do not match.
                </p>
            </div>
<!-- Proof of Membership -->
<div class="mt-8 text-left px-2 sm:px-4">
  <label class="font-semibold text-base sm:text-lg flex items-center gap-2">
    Proof of Membership <span class="text-[#4B5258] text-m">(optional)</span>
    <button 
      type="button" 
      class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
      data-tts-en="Proof of Membership"
      data-tts-tl="Patunay ng pagiging miyembro"
    >🔊</button>
  </label>

  <p class="text-gray-600 italic text-sm sm:text-base mb-2">(Patunay ng pagiging miyembro)</p>

  <!-- Upload Section -->
  <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
  <div class="flex-1">
    <p class="font-medium text-gray-800 text-sm sm:text-base">
      <span id="proofLabel" class="flex items-center gap-2">
        <span>Upload Proof (Image or PDF)</span> 
      </span>
    </p>
    <p id="proofHint" class="text-gray-600 italic text-xs sm:text-sm mt-1">
      (Mag-upload ng larawan o PDF bilang patunay ng pagiging miyembro.)<br /><br />
      Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b><br />
    </p>

    <!-- File Info Display -->
    <div id="proofDisplay"></div>
  </div>

  <!-- Upload button + input wrapped so validation message is appended below the button -->
  <div class="flex-shrink-0 flex flex-col items-center sm:items-end space-y-2">
    <label
      for="proofFile"
      class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition"
    >
      📁 Choose File / Pumili ng File
    </label>
    <input id="proofFile" name="proof" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden" />
    <!-- showFieldError appends .field-error to the input's parent — this ensures it's placed under the button -->
    <div class="upload-error w-full text-sm text-right"></div>
  </div>
</div>

<!-- Medical Certificate -->
<div class="mt-8 text-left px-2 sm:px-4">
  <label class="font-semibold text-base sm:text-lg flex items-center gap-2">
    Please upload your medical certificate.
    <button 
      type="button" 
      class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
      data-tts-en="Please upload your medical certificate."
      data-tts-tl="Paki-upload ang iyong medical certificate."
    >🔊</button>
  </label>

   <p class="text-black-600 text-sm sm:text-base mt-4 mb-2">
    If you already have a medical certificate from a previous job fit or readiness assessment, you may upload it. If you do not have one, that is okay—this is optional.
  </p>

   <p class="text-gray-600 italic text-sm sm:text-base mb-2">
    (Kung mayroon ka nang medical certificate mula sa nakaraang assessment para sa job fit o readiness, puwede mo itong i-upload. Kung wala ka pa, ayos lang, optional lamang ito.)
  </p>

  <!-- Upload Section -->
  <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
  <div class="flex-1">
    <p class="font-medium text-gray-800 text-sm sm:text-base">
      <span id="medLabel" class="flex items-center gap-2">
        <span>Upload File (Image or PDF)</span> 
      </span>
    </p>
    <p id="medHint" class="text-gray-600 italic text-xs sm:text-sm mt-1">
      (Mag-upload ng larawan o PDF ng iyong medical certificate.)<br /><br />
      Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b><br />
    </p>

    <!-- File Info Display -->
    <div id="medDisplay"></div>
  </div>

  <!-- Upload button + input wrapped so validation message is appended below the button -->
  <div class="flex-shrink-0 flex flex-col items-center sm:items-end space-y-2">
    <label
      for="medFile"
      class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition"
    >
      📁 Choose File / Pumili ng File
    </label>
    <input id="medFile" name="medical_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden" />
    <!-- validation will be appended here (under the button) -->
    <div class="upload-error w-full text-sm text-right"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  setupUpload('proofFile', 'proofDisplay', 'proofLabel', 'proofHint');
  setupUpload('medFile', 'medDisplay', 'medLabel', 'medHint');
});

function setupUpload(inputId, displayId, labelId, hintId) {
  const fileInput = document.getElementById(inputId);
  const display = document.getElementById(displayId);
  const labelEl = document.getElementById(labelId);
  const hintEl = document.getElementById(hintId);
  const modal = document.getElementById('fileModal');
  const modalContent = document.getElementById('modalContent');
  const closeModalBtn = document.getElementById('closeModalBtn');

  let fileURL = null;

  if (!fileInput) return;

        // remember original label text so resetDisplay can restore it
        try { if (labelEl && typeof labelEl.dataset !== 'undefined') labelEl.dataset.original = labelEl.textContent || labelEl.dataset.original || 'Upload File'; } catch(e){}

        // determine storage keys for this input (used both on change and on init)
        let nameKey, dataKey, typeKey;
        if (inputId === 'proofFile') {
            nameKey = 'admin_uploaded_proof_name';
            dataKey = 'admin_uploaded_proof_data';
            typeKey = 'admin_uploaded_proof_type';
        } else {
            nameKey = 'admin_uploaded_med_name';
            dataKey = 'admin_uploaded_med_data';
            typeKey = 'admin_uploaded_med_type';
        }

        // If storage already contains a previously-uploaded file, render its preview on init
        try {
            const storedName = localStorage.getItem(nameKey);
            const storedData = localStorage.getItem(dataKey);
            const storedType = localStorage.getItem(typeKey);
            if (storedName && storedData) {
                const ext = (storedName.split('.').pop() || '').toLowerCase();
                const icon = ['jpg', 'jpeg', 'png'].includes(ext) ? '🖼️'
                                     : ext === 'pdf' ? '📄'
                                     : '📁';

                // show display block
                display.innerHTML = `
                    <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mt-3">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">${icon}</span>
                            <span class="text-sm text-gray-700 truncate max-w-[200px]">${storedName}</span>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" class="viewBtn bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
                            <button type="button" class="removeBtn bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button>
                        </div>
                    </div>
                `;

                // view uses storedData (data URL) as the source
                const viewBtn = display.querySelector('.viewBtn');
                const removeBtn = display.querySelector('.removeBtn');
                if (viewBtn) viewBtn.addEventListener('click', (e) => { e.preventDefault(); openModal(storedData, ext); });
                if (removeBtn) removeBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    resetDisplay();
                    try { fileInput.value = ''; } catch(e){}
                    localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey);
                    // also run legacy cleanup
                    try { cleanupUploadedFileByName(storedName); } catch(e){}
                });

                if (labelEl) { labelEl.textContent = 'File Uploaded:'; }
                if (hintEl) { hintEl.style.display = 'none'; }
            }
        } catch(e){}

  // --------------------------------------------------------------------
  // ⭐ Robust cleanup helper (your requested fix)
  // --------------------------------------------------------------------
  function cleanupUploadedFileByName(filename) {
    try {
      const name = String(filename || '').trim();

      const keys = [
        // admin
        'admin_uploaded_proof_name','admin_uploaded_proof_data','admin_uploaded_proof_type',
        'admin_uploaded_med_name','admin_uploaded_med_data','admin_uploaded_med_type',

        // legacy single-file
        'uploadedProofName','uploadedProofData','uploadedProofType',
        'uploadedProofName1','uploadedProofData1','uploadedProofType1',
        'uploadedProofName0','uploadedProofData0','uploadedProofType0',
        'uploaded_proof_name','uploaded_proof_data','uploaded_proof_type',
        'proofName','proofData','proofType','proofFilename',

        // review keys
        'review_certfile','review_certs_file','review_certfile_name','review_certs_name'
      ];

      keys.forEach(k => {
        try { localStorage.removeItem(k); sessionStorage.removeItem(k); } catch {}
      });

      // Array-based uploaded items
      const arrayKeys = [
        'uploadedProofs1',
        'uploadedProofs',
        'uploadedProofs_proof',
        'uploadedProofs_med'
      ];

      arrayKeys.forEach(k => {
        try {
          const raw = localStorage.getItem(k);
          if (!raw) return;

          const arr = JSON.parse(raw || '[]');
          if (!Array.isArray(arr)) return;

          const filtered = arr.filter(it => {
            const iname = (it && (it.name || it.filename)) ? String(it.name || it.filename) : '';
            return name ? iname !== name : true;
          });

          localStorage.setItem(k, JSON.stringify(filtered));
        } catch {}
      });

      console.info('[cleanup] removed legacy/admin keys and pruned arrays for', name || '<unknown>');
    } catch (e) {
      console.warn('[cleanup] error', e);
    }
  }
  // --------------------------------------------------------------------


  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (!file) {
      resetDisplay();
      return;
    }

    if (fileURL) URL.revokeObjectURL(fileURL);
    fileURL = URL.createObjectURL(file);

    const ext = file.name.split('.').pop().toLowerCase();
    const icon = ['jpg', 'jpeg', 'png'].includes(ext) ? '🖼️'
               : ext === 'pdf' ? '📄'
               : '📁';

    display.innerHTML = `
      <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mt-3">
        <div class="flex items-center gap-2">
          <span class="text-2xl">${icon}</span>
          <span class="text-sm text-gray-700 truncate max-w-[200px]">${file.name}</span>
        </div>
        <div class="flex gap-2">
          <button type="button" class="viewBtn bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
          <button type="button" class="removeBtn bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button>
        </div>
      </div>
    `;

    // Unique admin keys
    let nameKey, dataKey, typeKey;
    if (inputId === 'proofFile') {
      nameKey = 'admin_uploaded_proof_name';
      dataKey = 'admin_uploaded_proof_data';
      typeKey = 'admin_uploaded_proof_type';
    } else {
      nameKey = 'admin_uploaded_med_name';
      dataKey = 'admin_uploaded_med_data';
      typeKey = 'admin_uploaded_med_type';
    }

    // Save file to storage
    const reader = new FileReader();
    reader.onload = () => {
      try {
        localStorage.setItem(nameKey, file.name);
        localStorage.setItem(dataKey, reader.result);
        localStorage.setItem(typeKey, ext);
        console.info('[adminapprove] saved upload to localStorage', nameKey);
      } catch (err) {
        console.warn('Failed to save upload in localStorage', err);
      }
    };
    reader.readAsDataURL(file);

    // View
    display.querySelector('.viewBtn').addEventListener('click', (e) => {
      e.preventDefault();
      openModal(fileURL, ext);
    });

    // Remove
    display.querySelector('.removeBtn').addEventListener('click', (e) => {
      e.preventDefault();
      resetDisplay();
      fileInput.value = '';

      if (fileURL) URL.revokeObjectURL(fileURL);
      fileURL = null;

      // Remove admin keys
      localStorage.removeItem(nameKey);
      localStorage.removeItem(dataKey);
      localStorage.removeItem(typeKey);

      // ⭐ NEW: full cleanup fix
      cleanupUploadedFileByName(
        file?.name || localStorage.getItem(nameKey)
      );

      console.info('[adminapprove] removed upload and cleaned legacy keys for', nameKey);
    });

    labelEl.textContent = 'File Uploaded:';
    hintEl.style.display = 'none';
  });

  // Modal preview
  function openModal(url, ext) {
    modal.classList.remove('hidden');
    modalContent.innerHTML = '';

    if (['jpg', 'jpeg', 'png'].includes(ext)) {
      modalContent.innerHTML = `<img src="${url}" class="max-h-[80vh] mx-auto rounded-lg">`;
    } else if (ext === 'pdf') {
      modalContent.innerHTML = `<iframe src="${url}" class="w-full h-[80vh] rounded-lg border-0"></iframe>`;
    } else {
      modalContent.innerHTML = `<p class="text-gray-700 text-center">This file type cannot be previewed.<br>(Hindi maaaring i-preview ang file na ito.)</p>`;
    }
  }

  closeModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.add('hidden');
    modalContent.innerHTML = '';
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add('hidden');
      modalContent.innerHTML = '';
    }
  });

  function resetDisplay() {
    display.innerHTML = '';
    labelEl.textContent = labelEl.dataset.original || 'Upload File';
    hintEl.style.display = '';
  }
}
</script>
            
            <!-- Submit Button -->
            <div class="flex flex-col items-center mt-6">
                <button 
                id="createAccountBtn" 
                type="button" class="bg-[#2E2EFF] text-white text-sm sm:text-lg font-semibold px-10 sm:px-16 md:px-20 py-2 sm:py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md">
                    Next →
                </button>
                <p class="text-gray-600 text-sm mt-3 text-center">
                    Click <span class="text-[#1E40AF] font-medium">“Next”</span> to continue<br>
                    <span class="italic text-gray-600">(Pindutin upang magpatuloy sa susunod na hakbang)</span>
                </p>
            </div>

            

           <script>
                    const phoneInput = document.getElementById('phone');

                    phoneInput.addEventListener('input', () => {
                        let value = phoneInput.value;

                        // 1️⃣ Alisin lahat ng hindi digits or '+' sign
                        value = value.replace(/[^\d+]/g, '');

                        // 2️⃣ Kung nagsimula sa '0', palitan ng '+63'
                        if (value.startsWith('0')) {
                            value = '+63' + value.substring(1);
                        }

                        // 3️⃣ Kung hindi pa nagsisimula sa '+63', pilitin itong maging '+63'
                        if (!value.startsWith('+63')) {
                            value = '+63';
                        }

                        // 4️⃣ Limitahan ang haba: +63 (3 chars) + 10 digits = total 13
                        if (value.length > 13) {
                            value = value.slice(0, 13);
                        }

                        // 5️⃣ Optional: kung gusto mo lagyan ng space after +63 para readability
                        // value = value.replace(/(\+63)(\d)/, '$1 $2'); // uncomment if you want "+63 9..."

                        // 6️⃣ Update input value
                        phoneInput.value = value;
                    });
                  
                   window.addEventListener('load', () => {
                    document.getElementById('first_name').value = '';
                    document.getElementById('last_name').value = '';
                    document.getElementById('age').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('address').value = '';
                    document.getElementById('dsType').selectedIndex = 0;
                    document.getElementById('guardian_first').value = '';
                    document.getElementById('guardian_last').value = '';
                    document.getElementById('guardian_email').value = '';
                    document.getElementById('guardian_phone').value = '';
                    document.getElementById('guardian_relationship').selectedIndex = 0;
                });

                const passwordInput = document.getElementById('password');
                const passwordMessage = document.getElementById('passwordMessage');
                const confirmPasswordInput = document.getElementById('confirmPassword');
                const confirmMessage = document.getElementById('confirmMessage');
                const createAccountBtn = document.getElementById('createAccountBtn');
                // const togglePassword = document.getElementById('togglePassword');

                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

                // 🔹 Password validation
                passwordInput.addEventListener('input', () => {
                const value = passwordInput.value.trim();

                if (value === '') {
                    passwordMessage.classList.add('hidden');
                    passwordInput.style.borderColor = '';
                    disableButton();
                    return;
                }

                passwordMessage.classList.remove('hidden');

                if (passwordRegex.test(value)) {
                    passwordInput.style.borderColor = 'green';
                    passwordMessage.textContent = '✅ Strong password. Ready to go!';
                    passwordMessage.classList.remove('text-red-500');
                    passwordMessage.classList.add('text-green-600');
                } else {
                    passwordInput.style.borderColor = 'red';
                    passwordMessage.textContent =
                    '❌ Must contain 1 uppercase, 1 lowercase, 1 number, and 8+ characters.';
                    passwordMessage.classList.remove('text-green-600');
                    passwordMessage.classList.add('text-red-500');
                }

                validateConfirmPassword();
                });

                // 🔹 Confirm password validation
                confirmPasswordInput.addEventListener('input', validateConfirmPassword);

                function validateConfirmPassword() {
                const passwordVal = passwordInput.value.trim();
                const confirmVal = confirmPasswordInput.value.trim();

                if (confirmVal === '') {
                    confirmMessage.classList.add('hidden');
                    confirmPasswordInput.style.borderColor = '';
                    disableButton();
                    return;
                }

                confirmMessage.classList.remove('hidden');

                if (passwordRegex.test(passwordVal) && passwordVal === confirmVal) {
                    confirmPasswordInput.style.borderColor = 'green';
                    confirmMessage.textContent = '✅ Passwords match.';
                    confirmMessage.classList.remove('text-red-500');
                    confirmMessage.classList.add('text-green-600');
                    enableButton();
                } else {
                    confirmPasswordInput.style.borderColor = 'red';
                    confirmMessage.textContent = '❌ Passwords do not match.';
                    confirmMessage.classList.remove('text-green-600');
                    confirmMessage.classList.add('text-red-500');
                    disableButton();
                }
                }

                // 🔹 Disable button
                function disableButton() {
                createAccountBtn.disabled = true;
                createAccountBtn.classList.remove('bg-[#2E2EFF]', 'hover:bg-blue-600', 'text-white');
                createAccountBtn.classList.add('bg-gray-400', 'cursor-not-allowed', 'opacity-90', 'text-white');
                }

                // 🔹 Enable button
                function enableButton() {
                createAccountBtn.disabled = false;
                createAccountBtn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'opacity-90');
                createAccountBtn.classList.add('bg-[#2E2EFF]', 'hover:bg-blue-600', 'text-white');
                }

                // 🔹 Toggle password visibility
                // togglePassword.addEventListener('change', () => {
                // const type = togglePassword.checked ? 'text' : 'password';
                // passwordInput.type = type;
                // confirmPasswordInput.type = type;
                // });


                </script>

            </div>

    <!-- Show/hide password toggles -->
    <script>
        (function() {
            function toggleField(checkboxId, fieldId) {
                const cb = document.getElementById(checkboxId);
                const field = document.getElementById(fieldId);
                if (!cb || !field) return;
                // initialize based on checkbox state
                field.type = cb.checked ? 'text' : 'password';
                cb.addEventListener('change', function() {
                    field.type = this.checked ? 'text' : 'password';
                });
            }

            // Run after DOM loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    toggleField('togglePassword', 'password');
                    toggleField('toggleConfirm', 'confirmPassword');
                });
            } else {
                toggleField('togglePassword', 'password');
                toggleField('toggleConfirm', 'confirmPassword');
            }
        })();
    </script>

    <!-- 🔹 Modal (Shared for both uploads) -->
    <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
    <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
        <button id="closeModalBtn" type="button" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
        <div id="modalContent" class="p-2 text-center"></div>
    </div>
    </div>

    <script>
    (function(){
        function normalizeFilename(s){
            if(!s) return '';
            try{ const parts = String(s).split(/[/\\]+/); return parts[parts.length-1]||'';}catch(e){ return String(s||''); }
        }

        function setIf(id, val){
            try{
                const el = document.getElementById(id);
                if(!el) return false;
                if(el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') el.value = val || '';
                else el.textContent = val || '';
                return true;
            }catch(e){ return false; }
        }

        function setProofPreview(name){
            try{
                const info = document.getElementById('proofFileInfo');
                const fileName = document.getElementById('proofFileName');
                const icon = document.getElementById('proofFileIcon');
                const hint = document.getElementById('proofHint');
                if(!name){ if(info) info.classList.add('hidden'); if(hint) hint.style.display = ''; return; }
                const ext = (name.split('.').pop()||'').toLowerCase();
                if(icon) icon.textContent = (['jpg','jpeg','png'].includes(ext)?'🖼️': (ext==='pdf'?'📄':'📁'));
                if(fileName) fileName.textContent = name;
                if(info) info.classList.remove('hidden');
                if(hint) hint.style.display = 'none';
            }catch(e){}
        }

        function applyDraftToDom(d){
            try{
                if(!d || typeof d !== 'object') return false;
                const p = d.personal || d.personalInfo || d;
                const first = p.firstName || p.first_name || p.first || p.fname || '';
                const last = p.lastName || p.last_name || p.last || p.lname || '';
                const email = p.email || '';
                const phone = p.phone || p.mobile || '';
                const age = p.age || '';
                const address = p.address || '';
                const username = p.username || p.userName || '';
                let applied = false;
                applied = setIf('first_name', first) || applied;
                applied = setIf('last_name', last) || applied;
                applied = setIf('email', email) || applied;
                applied = setIf('phone', phone) || applied;
                applied = setIf('age', age) || applied;
                applied = setIf('address', address) || applied;
                applied = setIf('username', username) || applied;

                // dsType
                const ds = d.dsType || d.ds_type || p.dsType || p.ds_type || '';
                if(ds){
                    try{
                        const select = document.getElementById('dsType');
                        if(select){
                            let found = false;
                            for(const opt of select.options){ if(String(opt.value||'').toLowerCase()===String(ds).toLowerCase()){ select.value = opt.value; found = true; break; } }
                            if(!found){ for(const opt of select.options){ if(String(opt.textContent||'').toLowerCase()===String(ds).toLowerCase()){ select.value = opt.value; break; } } }
                            applied = true;
                        }
                    }catch(e){}
                }

                // guardian
                const g = d.guardian || d.guardianInfo || d;
                const gfirst = g.guardian_first_name || g.guardian_first || g.first || g.first_name || '';
                const glast = g.guardian_last_name || g.guardian_last || g.last || g.last_name || '';
                const gemail = g.guardian_email || g.email || '';
                const gphone = g.guardian_phone || g.phone || '';
                const grel = g.guardian_relationship || g.guardian_choice || g.relationship || '';
                applied = setIf('guardian_first', gfirst) || applied;
                applied = setIf('guardian_last', glast) || applied;
                applied = setIf('guardian_email', gemail) || applied;
                applied = setIf('guardian_phone', gphone) || applied;
                if(grel) applied = setIf('guardian_relationship', grel) || applied;

                // proof filename preview
                const proof = d.proofFilename || p.proofFilename || d.proof || d.cert_file || p.proof || '';
                const proofName = normalizeFilename(proof||''); if(proofName){ setProofPreview(proofName); applied = true; }
                return applied;
            }catch(e){ console.warn('applyDraftToDom failed', e); return false; }
        }

        function parseStored(raw){
            if(!raw) return null;
            try{ let parsed = JSON.parse(raw); if(parsed && parsed.data) parsed = parsed.data; return parsed; }catch(e){ return raw; }
        }

        function tryLoadAndApplyOnce(){
            try{
                const raw = localStorage.getItem('rpi_personal1') || sessionStorage.getItem('rpi_personal1');
                if(!raw) return null;
                return parseStored(raw);
            }catch(e){ console.warn('tryLoadAndApplyOnce failed', e); return null; }
        }

        // Boot: attempt application with retry
        const parsed = tryLoadAndApplyOnce();
        if(parsed){
            try{ console.info('[adminapprove-autofill] rpi_personal1 found, attempting to apply', Object.keys(parsed || {})); }catch(_){}
            let attempts = 0;
            const maxAttempts = 12;
            const interval = 120;
            function attempt(){
                attempts++;
                try{
                    const ok = applyDraftToDom(parsed);
                    if(ok){
                        try{ console.info('[adminapprove-autofill] applied local draft to form'); }catch(_){}
                        window.__mvsg_local_applied = true;
                        window.dispatchEvent(new CustomEvent('mvsg:localApplied',{detail:{key:'rpi_personal1'}}));
                        return;
                    }
                }catch(e){}
                if(attempts < maxAttempts) setTimeout(attempt, interval);
            }
            attempt();
        }

        // Listen for storage changes and custom events
        window.addEventListener('storage', function(e){
            try{ if((e.key === 'rpi_personal1' || e.key === null) && e.newValue){ const parsed = parseStored(e.newValue); if(parsed) applyDraftToDom(parsed); } }catch(_){}
        });

        window.addEventListener('mvsg:adminSaved', function(ev){
            try{ const d = (ev && ev.detail && ev.detail.data) ? ev.detail.data : null; if(d) applyDraftToDom(d); }catch(_){}
        });

    })();
    </script>

    <script src="js/register.js"></script>

    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.tts-btn');
            const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
            let preferredEnglishVoice = null;
            let preferredTagalogVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName) ||
                    availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) ||
                    null;
                preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName) ||
                    availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name)) ||
                    null;
            }

            function chooseVoiceForLang(langCode) {
                if (!availableVoices.length) return null;
                langCode = (langCode || '').toLowerCase();
                let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                if (candidates.length) return pickBest(candidates);
                candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
                if (candidates.length) return pickBest(candidates);
                return availableVoices[0];
            }

            function pickBest(list) {
                let preferred = list.filter(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
                if (preferred.length) return preferred[0];
                return list[0];
            }

            function stopSpeaking() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
                if (currentBtn) {
                    currentBtn.classList.remove('speaking');
                    currentBtn.removeAttribute('aria-pressed');
                    currentBtn = null;
                }
            }

            buttons.forEach(function(btn) {
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');

                btn.addEventListener('click', function() {
                    const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                    const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                    if (!textEn && !textTl) return;

                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
                        stopSpeaking();
                        return;
                    }

                    stopSpeaking();
                    setTimeout(function() {
                        if (!window.speechSynthesis) return;

                        function voiceFor(langHint) {
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                                    if (preferredTagalogVoice) return preferredTagalogVoice;
                                    return chooseVoiceForLang('tl');
                                }
                                if (hint.startsWith('en')) {
                                    if (preferredEnglishVoice) return preferredEnglishVoice;
                                    return chooseVoiceForLang('en');
                                }
                            }
                            return preferredEnglishVoice || chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
                        }

                        const seq = [];
                        if (textEn) {
                            const uEn = new SpeechSynthesisUtterance(textEn);
                            uEn.lang = 'en-US';
                            const v = voiceFor('en');
                            if (v) uEn.voice = v;
                            seq.push(uEn);
                        }
                        if (textTl) {
                            const uTl = new SpeechSynthesisUtterance(textTl);
                            uTl.lang = 'tl-PH';
                            const v2 = voiceFor('tl');
                            if (v2) uTl.voice = v2;
                            seq.push(uTl);
                        }

                        if (!seq.length) return;

                        seq[0].onstart = function() {
                            btn.classList.add('speaking');
                            btn.setAttribute('aria-pressed', 'true');
                            currentBtn = btn;
                        };

                        for (let i = 0; i < seq.length; i++) {
                            const ut = seq[i];
                            ut.onerror = function() {
                                if (btn) btn.classList.remove('speaking');
                                if (btn) btn.removeAttribute('aria-pressed');
                                currentBtn = null;
                            };
                            if (i < seq.length - 1) {
                                ut.onend = function() {
                                    window.speechSynthesis.speak(seq[i + 1]);
                                };
                            } else {
                                ut.onend = function() {
                                    if (btn) btn.classList.remove('speaking');
                                    if (btn) btn.removeAttribute('aria-pressed');
                                    currentBtn = null;
                                };
                            }
                        }

                        window.speechSynthesis.speak(seq[0]);
                    }, 50);
                });

                btn.addEventListener('keydown', function(ev) {
                    if (ev.key === 'Enter' || ev.key === ' ') {
                        ev.preventDefault();
                        btn.click();
                    }
                });
            });

            window.addEventListener('beforeunload', function() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });

            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function() {
                    populateVoices();
                };
            }
        });
    </script>
<script>
    (function() {
        // Save-only helper: persist draft so the central register.js can pick it up and create the account.
        const btn = document.getElementById('createAccountBtn');
        if (!btn) return;

        const required = {
            personal: ['first_name','last_name','age','email','phone','address'],
            guardian: ['guardian_first','guardian_last','guardian_email','guardian_phone','guardian_relationship'],
            account: ['username','password','confirmPassword'],
            uploads: ['proofFile','medFile']
        };

        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRe = /^\+63\d{10}$/; // expects "+63" + 10 digits (no spaces) -- input enforces this format
        const passwordRe = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

        // --- moved helper: check whether a storage key contains meaningful data ---
        function storedHasData(key) {
            try {
                const raw = localStorage.getItem(key) || sessionStorage.getItem(key);
                if (!raw) return false;
                const trimmed = String(raw).trim();
                if (!trimmed) return false;
                if (trimmed === '[]' || trimmed === '{}' || trimmed === 'null') return false;
                try {
                    const parsed = JSON.parse(trimmed);
                    if (Array.isArray(parsed)) return parsed.length > 0;
                    if (parsed && typeof parsed === 'object') return Object.keys(parsed).length > 0;
                    return String(parsed).trim() !== '';
                } catch (e) {
                    return trimmed !== '';
                }
            } catch (e) { return false; }
        }

        // --- moved helper: determine if upload exists for proof/med (used both in validation and live-clear) ---
        function hasUploadedFileFor(id) {
            try {
                if (id === 'proofFile') {
                    const input = document.getElementById('proofFile');
                    if (input && input.files && input.files.length) return true;
                    if (storedHasData('admin_uploaded_proof_name') || storedHasData('admin_uploaded_proof_data') || storedHasData('admin_uploaded_proof_type')) return true;
                    if (storedHasData('uploadedProofs_proof') || storedHasData('uploadedProofs1') || storedHasData('uploadedProofs')) return true;
                    if (storedHasData('uploadedProofName') || storedHasData('uploaded_proof_name') || storedHasData('proofName')) return true;
                    return false;
                }

                if (id === 'medFile') {
                    const input = document.getElementById('medFile');
                    if (input && input.files && input.files.length) return true;
                    if (storedHasData('admin_uploaded_med_name') || storedHasData('admin_uploaded_med_data') || storedHasData('admin_uploaded_med_type')) return true;
                    if (storedHasData('uploadedProofs_med') || storedHasData('uploadedProofs')) return true;
                    if (storedHasData('review_certfile_name') || storedHasData('review_certs_name')) return true;
                    return false;
                }

                return false;
            } catch (e) { return false; }
        }

        function showFieldError(id, msg) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('border-red-500');
            // existing error element?
            let err = el.parentNode.querySelector('.field-error');
            if (!err) {
                err = document.createElement('p');
                err.className = 'field-error mt-1 text-sm text-red-500 italic';
                el.parentNode.appendChild(err);
            }
            err.textContent = msg;
        }

        function clearFieldError(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('border-red-500');
            const err = el.parentNode.querySelector('.field-error');
            if (err) err.remove();
        }

        function validateRequired() {
            // clear previous errors
            [...required.personal, ...required.guardian, ...required.account, ...required.uploads].forEach(clearFieldError);

            const values = {};
            // Only gather non-file inputs into values; uploads are checked via hasUploadedFileFor()
            [...required.personal, ...required.guardian, ...required.account].forEach(id => {
                const el = document.getElementById(id);
                values[id] = el ? (el.value || '').trim() : '';
            });

            const errors = [];

            // Personal checks
            required.personal.forEach(id => {
                if (!values[id]) {
                    errors.push({ id, msg: 'This field is required.' });
                }
            });

            // age numeric > 0
            if (values.age && !(Number(values.age) > 0)) {
                errors.push({ id: 'age', msg: 'Please enter a valid age.' });
            }

            // email
            if (values.email && !emailRe.test(values.email)) {
                errors.push({ id: 'email', msg: 'Please enter a valid email.' });
            }

            // phone
            if (values.phone && !phoneRe.test(values.phone.replace(/\s+/g,''))) {
                errors.push({ id: 'phone', msg: 'Please enter a valid Philippine number (e.g. +639121234567).' });
            }

            // guardian checks
            required.guardian.forEach(id => {
                if (!values[id]) {
                    errors.push({ id, msg: 'This field is required.' });
                }
            });

            // guardian_relationship - ensure not default empty
            if (!values.guardian_relationship) {
                errors.push({ id: 'guardian_relationship', msg: 'Please select a relationship.' });
            }

            // account checks
            if (!values.username) errors.push({ id: 'username', msg: 'Please enter a username.' });
            if (!values.password) errors.push({ id: 'password', msg: 'Please enter a password.' });
            if (values.password && !passwordRe.test(values.password)) {
                errors.push({ id: 'password', msg: 'Password must have 1 uppercase, 1 lowercase, 1 number and be 8+ chars.' });
            }
            if (!values.confirmPassword) errors.push({ id: 'confirmPassword', msg: 'Please confirm your password.' });
            if (values.password && values.confirmPassword && values.password !== values.confirmPassword) {
                errors.push({ id: 'confirmPassword', msg: 'Passwords do not match.' });
            }

            // uploads checks — require proof and medical certificate (either file selected now or previously saved/uploaded)
            if (!hasUploadedFileFor('proofFile')) {
                errors.push({ id: 'proofFile', msg: 'Please upload proof of membership.' });
            }
            if (!hasUploadedFileFor('medFile')) {
                errors.push({ id: 'medFile', msg: 'Please upload a medical certificate.' });
            }

            if (errors.length) {
                // show errors; focus first error and scroll into view
                const first = errors[0];
                errors.forEach(e => showFieldError(e.id, e.msg));
                const firstEl = document.getElementById(first.id);
                if (firstEl) {
                    firstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstEl.focus();
                } else {
                    // fallback: scroll to top of form
                    const form = document.getElementById('registrationForm');
                    if (form) form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                return false;
            }

            return true;
        }

        // --- New: attach live listeners so warning text disappears as fields become valid ---
        function attachLiveClear() {
            const watchIds = [...required.personal, ...required.guardian, ...required.account];
            watchIds.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', () => {
                    const v = (el.value || '').trim();
                    let ok = true;
                    if (id === 'age') ok = v !== '' && Number(v) > 0;
                    else if (id === 'email') ok = emailRe.test(v);
                    else if (id === 'phone') ok = phoneRe.test(v.replace(/\s+/g,''));
                    else if (id === 'password') ok = passwordRe.test(v);
                    else if (id === 'confirmPassword') {
                        const pw = (document.getElementById('password')?.value || '').trim();
                        ok = pw && v && pw === v;
                    } else if (id === 'guardian_relationship') ok = v !== '';
                    else ok = v !== '';
                    if (ok) clearFieldError(id);
                });

                // also clear on blur to cover paste/select scenarios
                el.addEventListener('blur', () => {
                    const evt = new Event('input');
                    el.dispatchEvent(evt);
                });
            });

            // file inputs: clear when a file is selected (or when legacy storage detected)
            ['proofFile','medFile'].forEach(fid => {
                const inp = document.getElementById(fid);
                if (inp) {
                    inp.addEventListener('change', () => {
                        if (hasUploadedFileFor(fid)) clearFieldError(fid);
                    });
                }
            });

            // also listen for storage events (in case uploads are set by other scripts)
            window.addEventListener('storage', (e) => {
                if (!e) return;
                if (e.key && /proof|med|uploadedProofs|admin_uploaded/i.test(e.key)) {
                    ['proofFile','medFile'].forEach(fid => { if (hasUploadedFileFor(fid)) clearFieldError(fid); });
                }
            });
        }

        // init live clearing
        attachLiveClear();

        btn.addEventListener('click', function() {
            try {
                // run validation first
                if (!validateRequired()) {
                    // visually undo the "working" state if validation failed
                    btn.classList.remove('opacity-60');
                    return;
                }

                btn.classList.add('opacity-60');
                const data = {};
                // collect all inputs/selects/textareas that have an id
                document.querySelectorAll('input[id], select[id], textarea[id]').forEach(el => {
                    const id = el.id;
                    if (!id) return;
                    if (el.type === 'checkbox') data[id] = !!el.checked;
                    else data[id] = el.value || '';
                });

                // normalize common fields to expected keys
                const draft = {
                    firstName: data.first_name || data.firstName || data.first || '',
                    lastName: data.last_name || data.lastName || data.last || '',
                    email: data.email || '',
                    phone: data.phone || '',
                    age: data.age || '',
                    address: data.address || '',
                    username: data.username || '',
                    // persist selected Down Syndrome type (if present) under multiple keys for compatibility
                    dsType: data.dsType || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                    r_dsType1: data.r_dsType1 || data.r_dsType || data.dsType || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                    r_dsType: data.r_dsType || data.r_dsType1 || data.dsType || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                    guardian_first: data.guardian_first || data.guardianFirst || '',
                    guardian_last: data.guardian_last || data.guardianLast || '',
                    guardian_email: data.guardian_email || '',
                    guardian_phone: data.guardian_phone || '',
                    guardian_relationship: data.guardian_relationship || data.guardianRelationship || '',
                    r_dsType1: data.r_dsType1 || '',
                    password: data.password || '',
                };

                try {
                    localStorage.setItem('rpi_personal1', JSON.stringify(draft));
                } catch (err) {
                    console.warn('Could not save rpi_personal1', err);
                }

                console.info('[adminapprove] saved rpi_personal1 draft', Object.keys(draft));
                // dispatch event for other scripts to pick up
                try {
                    window.dispatchEvent(new CustomEvent('mvsg:adminSaved', {
                        detail: {
                            key: 'rpi_personal1',
                            data: draft
                        }
                    }));
                } catch (e) {}

               window.location.href = '{{ route("registereducation") }}';
            } catch (err) {
                console.error('[adminapprove] submit failed', err);
                btn.classList.remove('opacity-60');
            }
        });
    })();
</script>

            <!-- Ensure persisted sensitive fields and upload previews are restored after page load -->
            <script>
            window.addEventListener('load', function() {
                try {
                    const raw = localStorage.getItem('rpi_personal1') || sessionStorage.getItem('rpi_personal1');
                    if (raw) {
                        let parsed = {};
                        try { parsed = JSON.parse(raw); } catch(e) { parsed = raw; }
                        const pwd = parsed && parsed.password ? parsed.password : '';
                        if (pwd) {
                            const p = document.getElementById('password');
                            const c = document.getElementById('confirmPassword');
                            if (p) p.value = pwd;
                            if (c) c.value = pwd;
                            // trigger validation UI updates
                            try { p.dispatchEvent(new Event('input')); c.dispatchEvent(new Event('input')); } catch(e){}
                        }
                    }
                } catch(e){}

                // re-run upload initializers to render stored uploads (this is safe; setupUpload checks storage on init)
                try { if (typeof setupUpload === 'function') { setupUpload('proofFile','proofDisplay','proofLabel','proofHint'); setupUpload('medFile','medDisplay','medLabel','medHint'); } } catch(e){}
            });
            </script>

            <!-- Comprehensive restore: fill all form fields from saved draft/localStorage -->
            <script>
            window.addEventListener('load', function() {
                try {
                    const raw = localStorage.getItem('rpi_personal1') || sessionStorage.getItem('rpi_personal1');
                    if (!raw) return;
                    let parsed;
                    try { parsed = JSON.parse(raw); } catch(e) { parsed = raw; }
                    // support wrapped { data: {...} }
                    if (parsed && parsed.data) parsed = parsed.data;

                    const p = parsed.personal || parsed.personalInfo || parsed || {};

                    function safeSet(id, val) {
                        try {
                            if (val === undefined || val === null) return;
                            const el = document.getElementById(id);
                            if (!el) return;
                            if (el.tagName === 'SELECT') {
                                // try to match by value or by visible text
                                const wanted = String(val || '').trim();
                                if (!wanted) return;
                                let matched = false;
                                for (const opt of el.options) {
                                    if (String(opt.value || '').trim().toLowerCase() === wanted.toLowerCase()) { el.value = opt.value; matched = true; break; }
                                }
                                if (!matched) {
                                    for (const opt of el.options) {
                                        if (String(opt.textContent || '').trim().toLowerCase() === wanted.toLowerCase()) { el.value = opt.value; break; }
                                    }
                                }
                            } else {
                                el.value = val;
                            }
                            // fire input/change so other handlers pick it up
                            try { el.dispatchEvent(new Event('input', { bubbles: true })); el.dispatchEvent(new Event('change', { bubbles: true })); } catch(e){}
                        } catch(e){}
                    }

                    // common personal fields
                    safeSet('first_name', p.firstName || p.first_name || p.first || p.fname || '');
                    safeSet('last_name', p.lastName || p.last_name || p.last || p.lname || '');
                    safeSet('age', p.age || '');
                    safeSet('email', p.email || '');
                    safeSet('phone', p.phone || p.mobile || '');
                    safeSet('address', p.address || '');
                    safeSet('username', parsed.username || p.username || '');

                    // dsType if present
                    const dsVal = parsed.dsType || parsed.ds_type || p.dsType || p.ds_type || parsed.r_dsType || '';
                    if (dsVal) safeSet('dsType', dsVal);

                    // guardian
                    safeSet('guardian_first', (parsed.guardian_first || p.guardian_first || p.guardian_first_name || ''));
                    safeSet('guardian_last', (parsed.guardian_last || p.guardian_last || p.guardian_last_name || ''));
                    safeSet('guardian_email', (parsed.guardian_email || p.guardian_email || ''));
                    safeSet('guardian_phone', (parsed.guardian_phone || p.guardian_phone || ''));
                    safeSet('guardian_relationship', (parsed.guardian_relationship || p.guardian_relationship || p.relationship || ''));

                    // password + confirm
                    const pwd = parsed.password || p.password || '';
                    if (pwd) {
                        safeSet('password', pwd);
                        safeSet('confirmPassword', pwd);
                    }

                    // If uploads stored under admin keys, ensure previews are initialized by re-calling setupUpload
                    try { if (typeof setupUpload === 'function') { setupUpload('proofFile','proofDisplay','proofLabel','proofHint'); setupUpload('medFile','medDisplay','medLabel','medHint'); } } catch(e){}
                } catch(e) {
                    console.warn('[restore] could not apply draft', e);
                }
            });
            </script>

</body>

</html>
