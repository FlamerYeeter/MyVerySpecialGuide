<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create an Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

<body class="bg-white flex justify-center items-center min-h-screen p-4 sm:p-6 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="fixed left-2 sm:left-6 lg:left-10 top-1/3 w-20 sm:w-28 md:w-32 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="fixed left-2 sm:left-6 lg:left-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="fixed right-2 sm:right-6 lg:right-10 top-1/4 w-20 sm:w-28 md:w-32 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="fixed right-2 sm:right-6 lg:right-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-32 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-blue-600 text-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl flex items-center gap-2 sm:gap-3 text-base sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('register') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-5 h-5 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-2">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Create an
                Account</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-28 md:w-36 mb-6">
            <h2
                class="text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold flex flex-wrap justify-center items-center gap-2 sm:gap-3 text-center">
                Let’s Get Started!
                <button class="text-2xl sm:text-3xl hover:scale-110 transition-transform">🔊</button>
            </h2>
            <p class="mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Magsimula tayo!)
            </p>
        </div>

        <!-- Info Section -->
        <div class="mt-10 max-w-3xl mx-auto bg-blue-50 p-5 sm:p-6 md:p-8 rounded-2xl border border-blue-300 shadow-md">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4 sm:gap-6">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Account Icon"
                    class="w-12 h-12 sm:w-14 sm:h-14 mt-1 flex-shrink-0 mx-auto sm:mx-0">
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-lg sm:text-xl text-gray-800 font-semibold leading-relaxed">
                        Don’t worry! We’ll help you set up your account easily and guide you along the way.
                    </p>
                    <p class="text-gray-700 italic text-base sm:text-lg mt-2">
                        (Huwag mag-alala! Tutulungan ka naming mag-set up ng iyong account nang madali.)
                    </p>
                </div>
                <button
                    class="text-2xl sm:text-3xl hover:scale-110 transition-transform self-center sm:self-start">🔊</button>
            </div>
        </div>

        <!-- Instruction Section -->
        <div class="mt-10 sm:mt-12 max-w-3xl mx-auto space-y-6 sm:space-y-8">

            <!-- English Instructions -->
            <div
                class="bg-white rounded-3xl p-5 sm:p-6 md:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                    <div class="text-center sm:text-left flex-1">
                        <div class="flex justify-center sm:justify-between items-center mb-2">
                            <h3 class="text-xl sm:text-2xl text-blue-600 font-bold">Instructions</h3>
                            <button class="text-2xl sm:text-3xl hover:scale-110 transition-transform ml-3 sm:ml-6">
                                🔊
                            </button>
                        </div>

                        <ul class="list-disc list-inside text-gray-700 text-base sm:text-lg space-y-1">
                            <li>You can go back and change your answers.</li>
                            <li>Take your time — there’s no rush.</li>
                            <li>We will help you every step of the way.</li>
                            <li>Press the audio button anytime to hear instructions.</li>
                        </ul>

                        <p class="text-gray-700 italic text-base sm:text-lg mt-3">
                            (Maaari kang bumalik at baguhin ang iyong mga sagot. Maglaan ng oras, huwag magmadali.
                            Tutulungan ka namin sa bawat hakbang.)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Next Button -->
            <div class="flex flex-col items-center mt-10 sm:mt-14 space-y-4">
                <button
                    class="bg-blue-500 text-white text-2xl sm:text-3xl font-bold px-20 sm:px-28 md:px-32 py-4 sm:py-5 rounded-3xl shadow-lg hover:bg-blue-600 active:scale-95 transition"
                    onclick="window.location.href='{{ route('dataprivacy') }}'">
                    Next →
                </button>
                <p class="text-gray-700 text-sm sm:text-base md:text-lg text-center leading-relaxed px-4 sm:px-0">
                    Click <span class="text-blue-600 font-bold">"Next"</span> to continue<br class="hidden sm:block">
                    <span class="italic text-gray-600 block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
                </p>
            </div>
        </div>

</body>

</html>
