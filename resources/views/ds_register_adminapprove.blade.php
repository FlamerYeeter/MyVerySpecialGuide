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
        onclick="window.location.href='{{ route('dataprivacy') }}'">
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
                <h2 class="text-lg sm:text-xl md:text-2xl text-blue-600 font-bold flex flex-wrap items-center gap-x-3">
                    For Admin Approval
                    <span class="text-gray-600 italic text-sm sm:text-base">(Pahintulot sa Admin)</span>
                    <button type="button" class="text-xl hover:scale-110 transition-transform">🔊</button>
                </h2>
                <p class="text-gray-800 text-sm sm:text-base mt-2">
                    Please type your information inside the box. The text with a ⭐ star must be filled in and attach a
                    valid proof of membership.
                </p>
                <p class="text-gray-600 italic text-sm sm:text-base mt-4 border-b-2 border-blue-400 pb-2">
                    (Isulat ang iyong impormasyon sa loob ng kahon. Ang mga text na may ⭐ bituin ay dapat sagutan at
                    mag-upload ng patunay na miyembro ka ng organisasyon.)
                </p>
            </div>
        </div>

        <!-- Overall Information Note -->
        <div
            class="relative bg-[#EEF4FF] border border-blue-200 text-blue-800 rounded-xl p-4 sm:p-5 md:p-6 mt-6 shadow-sm">

            <!-- Audio Button -->
            <button type="button" aria-label="Play audio for information note"
                class="absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white
    text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400">
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
                        Please fill out all the required information below accurately. The details you provide help our
                        administrators verify your account, confirm your eligibility, and ensure proper communication
                        during the approval process.
                    </p>
                    <p class="italic text-gray-600 text-xs sm:text-sm mt-2 leading-relaxed">
                        (Mangyaring punan nang tama ang lahat ng kinakailangang impormasyon sa ibaba. Ang mga detalyeng
                        iyong ibibigay ay makatutulong sa aming mga tagapangasiwa upang beripikahin ang iyong account,
                        kumpirmahin ang iyong pagiging karapat-dapat, at tiyakin ang maayos na komunikasyon sa proseso
                        ng pag-apruba.)
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
                        <input id="phone" type="tel" placeholder="+63 9XX XXX XXXX"
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
                        Type of Down Syndrome <span class="text-gray-500 text-m">(optional)</span>
                    </h3>
                    <p class="text-black-600 italic text-xs sm:text-sm leading-snug mt-1">
                        (You may fill this in if you already have records or a doctor’s assessment that shows your type
                        of Down syndrome.
                        It’s perfectly okay if you’re not aware of it yet — you can leave it blank.)
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
                        <option value="trisomy21">Trisomy 21 (Nondisjunction)</option>
                        <option value="mosaic">Mosaic Down Syndrome</option>
                        <option value="translocation">Translocation Down Syndrome</option>
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
                        Relationship to User <span>⭐</span>
                    </label>
                    <p class="text-gray-600 italic text-xs sm:text-sm">Relasyon sa Gagamit</p>
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
                        <input id="password" name="password" type="password" placeholder="Enter your password"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                        <div class="flex items-start mt-3 gap-2">
                            <input id="togglePassword" type="checkbox"
                                class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-400 cursor-pointer" />
                            <label for="togglePassword" class="text-sm text-gray-700 cursor-pointer leading-snug">
                                Click the box to show password.<br>
                                <span class="italic text-gray-500">(Pindutin ang box para makita ang password)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Password Rules -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-blue-50 border border-blue-300 rounded-xl p-6 mt-6 text-sm gap-6 shadow-inner">
                    <!-- English -->
                    <div>
                        <p class="font-semibold text-blue-700 mb-2 flex items-center gap-2">English <button
                                type="button" class="text-gray-600 text-lg hover:scale-110 transition-transform"
                                title="Play audio">🔊</button></p>
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
                                type="button" class="text-gray-600 text-lg hover:scale-110 transition-transform"
                                title="Play audio">🔊</button></p>
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
                    <div class="flex items-start mt-3 gap-2">
                        <input id="toggleConfirm" type="checkbox"
                            class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-400 cursor-pointer" />
                        <label for="toggleConfirm" class="text-sm text-gray-700 cursor-pointer leading-snug">
                            Click the box to show password.<br>
                            <span class="italic text-gray-500">(Pindutin ang box para makita ang password)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Proof of Membership -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Proof of Membership
                </h3>

                <!-- File Upload Box (matches certificate style) -->
                <div
                    class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="font-medium text-gray-800 text-sm sm:text-base">
                            Upload Proof (Image or PDF) <span>⭐</span>
                        </p>
                        <p class="text-gray-600 italic text-xs sm:text-sm">
                            (Mag-upload ng larawan o PDF bilang patunay ng pagiging miyembro.)
                        </p>
                    </div>

                    <label for="proof"
                        class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium 
                        px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
                        📁 Choose File
                    </label>

                    <input id="proof" name="proof" type="file" accept=".jpg,.jpeg,.png,.pdf"
                        class="hidden" required>
                </div>
            </div>


            <!-- Submit Button -->
            <div class="flex flex-col items-center mt-6">
                <button id="createAccountBtn" type="button"
                    class="bg-[#2E2EFF] text-white text-base sm:text-lg font-semibold px-6 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition shadow-md w-full sm:w-auto">
                    Submit for Approval
                </button>
                <p class="text-gray-600 text-sm mt-3 text-center">
                    Click <span class="text-[#1E40AF] font-medium">“Submit for Approval”</span> to continue<br>
                    <span class="italic text-gray-600">(Pindutin upang magpatuloy sa susunod na hakbang)</span>
                </p>
            </div>

            <!-- Notes Section -->
            <div class="mt-8 flex justify-center">
                <div
                    class="bg-white shadow-md rounded-2xl px-5 sm:px-6 py-6 max-w-lg w-full text-center border border-gray-100">
                    <div class="mb-5">
                        <h3 class="text-gray-800 font-semibold text-sm uppercase tracking-wide">Next Step</h3>
                        <p class="text-gray-700 text-[13px] mt-2 leading-relaxed">
                            Check your email inbox for the approval confirmation message to proceed to the next step.
                        </p>
                        <p class="text-gray-600 italic text-[12px] mt-1">
                            (Suriin ang iyong email inbox para sa mensahe ng kumpirmasyon ng pag-apruba upang magpatuloy
                            sa susunod na hakbang)
                        </p>
                    </div>

                    <div class="border-t border-gray-200 my-4"></div>

                    <div>
                        <p class="text-gray-600 text-sm">
                            Didn’t receive confirmation?
                            <a href="#" class="text-[#1E40AF] font-medium hover:underline">Resend</a>
                        </p>
                        <p class="text-gray-500 italic text-[12px] mt-1">(Hindi nakatanggap ng kumpirmasyon? I-click
                            ang “Resend”)</p>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Save draft script: persist to rpi_personal so register.js autofills personal page -->
    <script>
        (function() {
            // Save-only helper: persist draft so the central register.js can pick it up and create the account.
            const btn = document.getElementById('createAccountBtn');
            if (!btn) return;

            btn.addEventListener('click', function() {
                try {
                    btn.disabled = true;
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
                        username: data.username || '',
                        guardian_first: data.guardian_first || data.guardianFirst || '',
                        guardian_last: data.guardian_last || data.guardianLast || '',
                        guardian_email: data.guardian_email || '',
                        guardian_phone: data.guardian_phone || '',
                        guardian_relationship: data.guardian_relationship || data.guardianRelationship || ''
                    };

                    try {
                        localStorage.setItem('rpi_personal', JSON.stringify(draft));
                    } catch (err) {
                        console.warn('Could not save rpi_personal', err);
                    }
                    console.info('[adminapprove] saved rpi_personal draft', Object.keys(draft));
                    // dispatch event for other scripts to pick up
                    try {
                        window.dispatchEvent(new CustomEvent('mvsg:adminSaved', {
                            detail: {
                                key: 'rpi_personal',
                                data: draft
                            }
                        }));
                    } catch (e) {}

                    // Debug: report firebase config presence and firebase.auth availability
                    try {
                        console.info('[adminapprove] FIREBASE_CONFIG present?', !!window.FIREBASE_CONFIG, window
                            .FIREBASE_CONFIG && window.FIREBASE_CONFIG.projectId);
                        console.info('[adminapprove] window.firebase available?', !!window.firebase);
                        if (window.firebase && firebase.auth) console.info(
                            '[adminapprove] firebase.currentUser', firebase.auth().currentUser);
                    } catch (e) {
                        console.warn('[adminapprove] debug probe failed', e);
                    }

                    // Do not navigate here — allow register.js to run account creation and handle navigation.
                } catch (err) {
                    console.error('[adminapprove] submit failed', err);
                    btn.disabled = false;
                    btn.classList.remove('opacity-60');
                }
            });
        })();
    </script>

    <!-- Include Firebase config and registration script -->
    <script src="js/firebase-config-global.js"></script>
    <script src="js/register.js"></script>

</body>

</html>
