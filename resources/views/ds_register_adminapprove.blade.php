<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Approval</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 6s ease-in-out infinite; }
    .animate-float-medium { animation: float 4s ease-in-out infinite; }
    .animate-float-fast { animation: float 3s ease-in-out infinite; }
  </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots (hidden on very small screens to avoid clutter) -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-6 top-1/3 w-28 lg:w-36 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-6 bottom-24 w-28 lg:w-36 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-6 top-1/4 w-28 lg:w-36 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-6 bottom-24 w-28 lg:w-36 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-blue-600 text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('home') }}'">
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
        <div class="mt-8 bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <!-- Info Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mt-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-blue-700 font-semibold text-lg">Important Information</h2>
                    <p class="text-gray-700 text-sm leading-relaxed mt-1">
                        Please fill out all the required information below accurately. The details you provide help our
                        administrators verify your account, confirm your eligibility, and ensure proper communication
                        during the approval process.
                    </p>
                    <p class="text-gray-600 italic text-[13px] mt-1">
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
                    Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="font-semibold flex items-center gap-1">First Name <span>⭐</span></label>
                        <p class="text-gray-500 italic text-xs sm:text-sm">Unang Pangalan</p>
                        <input id="first_name" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="font-semibold flex items-center gap-1">Last Name <span>⭐</span></label>
                        <p class="text-gray-500 italic text-xs sm:text-sm">Apelyido</p>
                        <input id="last_name" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="font-semibold flex items-center gap-1">Age <span>⭐</span></label>
                        <p class="text-gray-500 italic text-xs sm:text-sm">Edad</p>
                        <input id="age" type="number" placeholder="Age"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="font-semibold flex items-center gap-1">Email <span>⭐</span></label>
                        <input id="email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="font-semibold flex items-center gap-1">Contact Number <span>⭐</span></label>
                        <input id="phone" type="tel" placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold">Address ⭐</label>
                    <p class="text-gray-500 italic text-xs sm:text-sm">Tirahan</p>
                    <input id="address" type="text" placeholder="Complete Address"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                </div>
            </div>

            <!-- Guardian Information -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Guardian Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold flex items-center gap-1">First Name <span>⭐</span></label>
                        <p class="text-gray-500 italic text-xs sm:text-sm">Unang Pangalan</p>
                        <input id="guardian_first" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="font-semibold flex items-center gap-1">Last Name <span>⭐</span></label>
                        <p class="text-gray-500 italic text-xs sm:text-sm">Apelyido</p>
                        <input id="guardian_last" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="font-semibold flex items-center gap-1">Email <span>⭐</span></label>
                        <input id="guardian_email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="font-semibold flex items-center gap-1">Contact Number <span>⭐</span></label>
                        <input id="guardian_phone" type="tel" placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <!-- Relationship to User -->
                <div class="mt-6">
                    <label class="font-semibold flex items-center gap-1">Relationship to User <span>⭐</span></label>
                    <p class="text-gray-500 italic text-xs sm:text-sm">Relasyon sa Gagamit</p>
                    <select id="guardian_relationship"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring focus:ring-blue-200">
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
                    Proof of Membership</h3>
                <label class="font-semibold text-sm">Upload Proof (Image or PDF) ⭐</label>
                <input id="proof" type="file" accept=".jpg,.jpeg,.png,.pdf"
                    class="mt-2 w-full border border-gray-300 rounded-xl px-3 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:bg-blue-500 hover:file:bg-blue-600 transition" />
                <p class="text-gray-500 italic text-xs mt-1">(Mag-upload ng larawan o PDF bilang patunay ng pagiging
                    miyembro.)</p>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col items-center mt-6">
                <button id="adminSubmitBtn" type="button"
                    class="bg-blue-500 text-white text-base sm:text-lg font-semibold px-6 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition shadow-md w-full sm:w-auto">
                    Submit for Approval
                </button>
                <p class="text-gray-600 text-sm mt-3 text-center">
                    Click <span class="text-blue-500 font-medium">“Submit for Approval”</span> to continue<br>
                    <span class="italic text-gray-500">(Pindutin upang magpatuloy sa susunod na hakbang)</span>
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
                        <p class="text-gray-500 italic text-[12px] mt-1">
                            (Suriin ang iyong email inbox para sa mensahe ng kumpirmasyon ng pag-apruba upang magpatuloy
                            sa susunod na hakbang)
                        </p>
                    </div>

                    <div class="border-t border-gray-200 my-4"></div>

                    <div>
                        <p class="text-gray-600 text-sm">
                            Didn’t receive confirmation?
                            <a href="#" class="text-blue-500 font-medium hover:underline">Resend</a>
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
            const btn = document.getElementById('adminSubmitBtn');
            if (!btn) return;
            btn.addEventListener('click', function() {
                try {
                    const first = (document.getElementById('admin_first_name')?.value || '').trim();
                    const last = (document.getElementById('admin_last_name')?.value || '').trim();
                    const email = (document.getElementById('admin_email')?.value || '').trim();
                    if (!first && !last && !email) {
                        // nothing to save — still navigate
                        window.location.href = '{{ route('registereducation') }}';
                        return;
                    }
                    const draft = {
                        firstName: first,
                        lastName: last,
                        email: email,
                        phone: '',
                        age: '',
                        // password intentionally not set — user will create password on personal info page
                    };
                    try {
                        localStorage.setItem('rpi_personal', JSON.stringify(draft));
                    } catch (e) {
                        console.warn('Could not save admin draft', e);
                    }
                    // navigate to personal info page (register.js will pick up the draft)
                    window.location.href = '{{ route('registerpersonalinfo') }}';
                } catch (e) {
                    console.error('admin submit failed', e);
                    window.location.href = '{{ route('registerpersonalinfo') }}';
                }
            });
        })();
    </script>

</body>

</html>
