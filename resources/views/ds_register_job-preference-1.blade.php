<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Job Preference</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    /* visual for selected job preference card */
    .jobpref-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.25s ease, border 0.2s ease;
        will-change: transform, box-shadow;
        border: 1px solid #d1d5db; 
    }
    .jobpref-card:hover {f
        transform: translateY(-4px);
        border-color: #9ca3af; 
    }
    .jobpref-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
    .jobpref-card.disabled {
        opacity: 0.45;
        pointer-events: none;
        filter: grayscale(0.05);
    }
    
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
    }

    .chip-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background-color: #dbeafe;
        color: #1d4ed8;
        padding: 0.2rem 0.55rem;
        border-radius: 9999px;
        font-size: 0.75rem;
    }
    .chip-item button { line-height: 1; }
    
    .skills-card h3, .jobpref-card h3 {
        font-size: clamp(1.05rem, 2.2vw, 1.4rem);
    }
    .skills-card p, .jobpref-card p {
        font-size: clamp(0.88rem, 1.5vw, 1rem);
    }
    
    .tts-btn {
        padding: 0.55rem 0.6rem;
        border-radius: 9999px;
    }
     /* Layout & Typography improvements */
    .main-container h1 { font-size: clamp(1.6rem, 3.6vw, 2.8rem); line-height: 1.05; }
    .main-container h2, .main-container h3 { font-size: clamp(1.05rem, 2.2vw, 1.4rem); }
    .main-container .text-gray-600.italic { font-size: 0.92rem; }
    .main-container .bg-white.rounded-2xl { padding: 1.25rem; }
    .main-container .upload-error { font-size: 0.92rem; }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        body { font-size: 15px; }
        .main-container { padding: 0.6rem; }
        .main-container h1 { text-align: center; margin-bottom: 0.5rem; }
        .main-container h2, .main-container h3 { text-align: center; }
        /* make labels and helper text slightly larger for readability */
        .main-container label, .main-container p, .main-container .text-gray-600 { font-size: 15px; }
        /* Ensure TTS buttons are touch-friendly */
        .tts-btn { padding: 0.6rem; font-size: 1.05rem; }
        /* Ensure inputs stretch and maintain balanced padding */
        .main-container input[type="text"],
        .main-container input[type="email"],
        .main-container input[type="tel"],
        .main-container input[type="date"],
        .main-container input[type="number"],
        .main-container input[type="password"],
        .main-container select,
        .main-container textarea { font-size: 15px; padding: 0.6rem 0.75rem; }
    }
    
    /* Section card consistency */
    .main-container .section-card {
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 0.75rem;
        min-height: 360px;
        padding: 1.25rem; 
    }
    /* Slightly smaller on medium screens */
    @media (max-width: 1024px) {
        .main-container .section-card { min-height: 320px; }
    }
    /* On small screens make section cards match the instruction blue card size */
    @media (max-width: 640px) {
        .main-container .section-card { min-height: 300px; padding: 0.9rem; }
        /* make section cards visually wider on small screens to use more horizontal space; keep info-card at original size */
        .main-container .section-card {
            width: calc(100% + 2rem);
            max-width: none;
            margin-left: -1rem;
            margin-right: -1rem;
        }
    }
    </style>
</head>

<body class="bg-white flex justify-center sm:items-center items-start min-h-screen p-4 sm:p-6 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-2 sm:left-6 lg:left-10 top-1/3 w-20 sm:w-28 md:w-32 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-2 sm:left-6 lg:left-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-2 sm:right-6 lg:right-10 top-1/4 w-20 sm:w-28 md:w-32 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-2 sm:right-6 lg:right-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-32 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-2 top-2 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl flex items-center gap-2 sm:gap-3 text-sm sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerskills1') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-4">
            <h1
                class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Set Up Your Profile</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">
            <h2
                class="relative flex flex-wrap items-center justify-center gap-3 text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold">
                <span class="block mx-auto max-w-[82%] sm:max-w-none md:max-w-[85%] text-center md:pr-2 ">Let’s continue setting up your profile</span>
                <button type="button" class="ml-2 md:ml-3 text-sm sm:text-2xl bg-[#1E40AF] text-white p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn md:absolute md:right-3 md:top-1/2 md:-translate-y-1/2"
                    data-tts-en="Let’s continue setting up your profile" data-tts-tl="Ipagpatuloy natin ang pag-set up ng iyong profile"
                    aria-label="Play audio for header">🔊</button>
            </h2>
            <p
                class="mt-2 sm:mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ipagpatuloy natin ang pag-set up ng iyong profile)
            </p>
        </div>

        <!-- Information Section -->
        <div
            class="info-card mt-6 sm:mt-8 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md relative">

              <!-- Desktop Audio Button -->
                <button type="button" aria-label="Play audio for info section"
                    class="hidden sm:block absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
                         text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
                            focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please choose the kind of jobs you like! What type of work do you prefer? Your choices will help us recommend the best options for you.
                            Note: Some jobs might not be available in your area right now, but they may open soon"
                            data-tts-tl="Piliin mo ang mga uri ng trabahong gusto mo! Anong klaseng trabaho ang mas gusto mo? Makakatulong ang sagot mo para ma-rekomenda namin ang mga pinakaakmang trabaho para sa’yo.
                            Tandaan: Maaaring hindi pa available ang ilang trabaho sa iyong lugar sa ngayon, ngunit maaaring magbukas ito kung kinakailangan">
                            🔊
                </button>

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pr-4 sm:pr-16"> 
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 flex-shrink-0 mt-0.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-base sm:text-lg text-gray-700 font-bold leading-relaxed">
                    Please choose the kind of jobs you like! What type of work do you prefer? Your choices will help us recommend the best options for you.
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Piliin mo ang mga uri ng trabahong gusto mo! Anong klaseng trabaho ang mas gusto mo? Makakatulong ang sagot mo para ma-rekomenda namin ang mga pinakaakmang trabaho para sa’yo.)
                    </p>
                    <p class="text-red-600 italic text-sm sm:text-base mt-3 font-medium">
                        *Note: Some jobs might not be available in your area right now, but they may open soon.*<br>
                        (Tandaan: Maaaring hindi pa available ang ilang trabaho sa iyong lugar sa ngayon, ngunit maaaring magbukas ito kung kinakailangan.)
                    </p>
                
                 <!-- Mobile Audio Button -->
                    <div class="mt-3 flex justify-center sm:hidden">
                        <button type="button" aria-label="Play audio for info section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                            transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please choose the kind of jobs you like! What type of work do you prefer? Your choices will help us recommend the best options for you.
                            Note: Some jobs might not be available in your area right now, but they may open soon"
                            data-tts-tl="Piliin mo ang mga uri ng trabahong gusto mo! Anong klaseng trabaho ang mas gusto mo? Makakatulong ang sagot mo para ma-rekomenda namin ang mga pinakaakmang trabaho para sa’yo.
                            Tandaan: Maaaring hindi pa available ang ilang trabaho sa iyong lugar sa ngayon, ngunit maaaring magbukas ito kung kinakailangan">
                            🔊
                    </button>
                </div>
            </div>
        </div>
    </div>

        <div class="main-container mt-10 space-y-8 text-center sm:text-left mx-auto w-full max-w-6xl px-4 sm:px-0">

            <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-6">
                <div class="text-left px-2 sm:px-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-blue-600 flex items-center justify-between gap-2">
                    What kind of job feels right for you?
                    </h2>
                    <p class="text-gray-700 italic text-md mt-2">
                    (Anong klaseng trabaho ang bagay sa’yo?)
                    </p>
                </div>
                <!-- Audio Button -->
                <button type="button" 
                    class="bg-[#1E40AF] hover:bg-blue-700 text-white p-2 sm:p-3 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400"
                    data-tts-en="What kind of job feels right for you? Please choose 3–5 images below that show the kind of jobs you like. You must pick at least 3 and no more than 5" 
                        data-tts-tl="Anong klaseng trabaho ang bagay sa’yo? Pumili ng 3–5 larawan sa ibaba na nagpapakita ng mga trabahong gusto mo. Kailangan pumili ng hindi bababa sa 3 at hindi hihigit sa 5"
                    aria-label="Play audio for question">
                    🔊
                </button>
                </div>

                <!-- Instruction Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8 shadow border border-blue-100 mb-10 max-w-3xl mx-auto sm:mx-0">
                <p class="text-base sm:text-lg font-medium text-gray-800 leading-relaxed">
                    Please choose 
                    <span class="text-blue-700 font-semibold">3 to 5 images</span> below that show the kind of jobs you like. You must pick at least 3 and no more than 5!
                </p>
                <div class="border-t border-gray-200 my-4"></div>
                <p class="text-sm sm:text-base text-gray-700 italic">
                    (Pumili ng 
                    <span class="font-semibold text-blue-700">3–5 larawan </span> sa ibaba na nagpapakita ng mga trabahong gusto mo. Kailangan pumili ng hindi bababa sa 3 at hindi hihigit sa 5!)
                </p>
                </div>



        <!-- Job Options Cards Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

            <!-- Job 1 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Store Greeter / Customer Assistant" onclick="toggleJobPref1Choice(this,'Store Greeter / Customer Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Store Greeter/Customer Assistant: You stay in your assigned place with a warm smile, welcoming customers as they arrive. You kindly
                     assist them by guiding them to the areas they’re looking for and helping them find what they need
                     Example: Greeting customers and helping them locate items with a smile"
                    data-tts-tl="Mananatili ka sa iyong assigned place upang mag-welcome ng mga dumarating na customer. Magiliw mo 
                    silang gagabayan sa mga lugar na hinahanap nila at tutulungan mahanap ang kanilang mga kailangan" aria-label="Play audio for Store Greeter/Customer Assistant">🔊</button>
                <img src="image/job1.jpg" alt="store greeter" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Store Greeter / Customer Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You stay in your assigned place with a warm smile, welcoming customers as they arrive. You kindly
                     assist them by guiding them to the areas they’re looking for and helping them find what they need.
                </p>
                <p class="text-[13px] text-[#4D515C] italic mt-2 text-center">
                    (Mananatili ka sa iyong assigned place upang mag-welcome ng mga dumarating na customer. Magiliw mo 
                    silang gagabayan sa mga lugar na hinahanap nila at tutulungan mahanap ang kanilang mga kailangan)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Greeting customers and helping them locate items with a smile.</p>
            </div>

            <!-- Job 2 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Merchandising Assistant" onclick="toggleJobPref1Choice(this,'Merchandising Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Merchandising Assistant:You will help keep the store looking nice. You arrange products on the shelves and make sure everything looks neat 
                    and in the right place Example: Straightening shelves and restocking items neatly each hour" 
                    data-tts-tl="Tutulong ka upang maging maganda at maayos tingnan ang store. Aayuisn mo ang mga products sa lalagyanan at tinitiyak mong 
                    maayos at nasa tamang pwesto ang mga ito." aria-label="Play audio for Store Work">🔊</button>
                <img src="image/job2.jpg" alt="merchandising assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Merchandising Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                  You will help keep the store looking nice. You arrange products on the shelves and make sure everything looks neat 
                  and in the right place.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulong ka upang maging maganda at maayos tingnan ang store. Aayuisn mo ang mga products sa lalagyanan at tinitiyak mong 
                    maayos at nasa tamang pwesto ang mga ito)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Straightening shelves and restocking items neatly each hour.</p>
            </div>

            <!-- Job 3 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Stockroom Helper" onclick="toggleJobPref1Choice(this,'Stockroom Helper')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Stockroom Helper: You work in the stockroom where you sort items and fix boxes. You help prepare products before they go out to the store
                    Example: Sorting boxes and preparing shipments for store shelves" 
                    data-tts-tl="Magtatrabaho ka sa stockroom kung saan inaayos mo ang mga gamit at mga kahon. Tinutulungan mong ihanda ang mga products bago ilagay sa store" aria-label="Play audio for Cleaning Work">🔊</button>
                <img src="image/job3.jpg" alt="stockroom helper" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Stockroom Helper</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You work in the stockroom where you sort items and fix boxes. You help prepare products before they go out to the store.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Magtatrabaho ka sa stockroom kung saan inaayos mo ang mga gamit at mga kahon. Tinutulungan mong ihanda ang mga products bago ilagay sa store)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Sorting boxes and preparing shipments for store shelves.</p>
            </div>

            <!-- Job 4 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Basket & Cart Organizer" onclick="toggleJobPref1Choice(this,'Basket & Cart Organizer')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Basket & Cart Organizer: You carefully collect the used baskets and carts and bring them back to their proper place. You arrange them neatly at the entrance 
                    so customers can easily use them >Example: Gathering carts and arranging them neatly for incoming shoppers" 
                    data-tts-tl="Maingat mong kinokolekta ang mga nagamit na basket at cart at ibinabalik ang mga ito sa tamang lugar. Inaayos mo rin ang mga ito nang maayos sa entrance para madaling magamit ng mga customer" aria-label="Play audio for Hospitality Work">🔊</button>
                <img src="image/job4.jpg" alt="basket organizer" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Basket & Cart Organizer</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You carefully collect the used baskets and carts and bring them back to their proper place. You arrange them neatly at the entrance 
                    so customers can easily use them.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Maingat mong kinokolekta ang mga nagamit na basket at cart at ibinabalik ang mga ito sa tamang lugar. Inaayos mo rin ang mga ito nang maayos sa entrance para madaling magamit ng mga customer)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Gathering carts and arranging them neatly for incoming shoppers.</p>
            </div>

            <!-- Job 5 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Store Utility / Cleaner" onclick="toggleJobPref1Choice(this,'Store Utility / Cleaner')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Store Utility / Cleaner: You help keep the store clean. You wipe tables, organize small areas, and make sure paths are clear and safe for customers
                    Example: Wiping counters and clearing walkways to keep the store safe" 
                    data-tts-tl="Tumutulong kang panatilihing malinis ang store. Pinupunasan mo ang mga mesa at tinitiyak na malinis at ligtas ang daanan para sa mga customer" aria-label="Play audio for Food Service Work">🔊</button>
                <img src="image/job5.jpg" alt="store cleaner" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Store Utility / Cleaner</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You help keep the store clean. You wipe tables, organize small areas, and make sure paths are clear and safe for customers.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tumutulong kang panatilihing malinis ang store. Pinupunasan mo ang mga mesa at tinitiyak na malinis at ligtas ang daanan para sa mga customer)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Wiping counters and clearing walkways to keep the store safe.</p>
            </div>

            <!-- Job 6 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Packaging Support / Bagging Assistant" onclick="toggleJobPref1Choice(this,'Packaging Support / Bagging Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Packaging Support / Bagging Assistant:You help customers by placing their items gently and neatly into bags at the cashier area
                    Example: Packing groceries carefully and making sure bags don’t break" 
                    data-tts-tl="Tutuulungan mo ang customer sa cashier sa paglalagay ng kanilang mga binili sa bag nang maingat at maayos" aria-label="Play audio for Packing Packages Work">🔊</button>
                <img src="image/job6.jpg" alt="packing support" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Packaging Support / Bagging Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You help customers by placing their items gently and neatly into bags at the cashier area.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutuulungan mo ang customer sa cashier sa paglalagay ng kanilang mga binili sa bag nang maingat at maayos)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Packing groceries carefully and making sure bags don’t break.</p>
            </div>

            <!-- Job 7 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Alteration/Tailoring Assistant (for a clothing line)" onclick="toggleJobPref1Choice(this,'Alteration/Tailoring Assistant (for a clothing line)')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Alteration/Tailoring Assistant (for a clothing line):You help fix clothes by doing simple sewing tasks, like shortening pants or repairing small parts. You use basic
                    sewing tools and make sure the clothes are ready for customers Example: Fixing small tears and hemming pants for neat display" 
                    data-tts-tl="Tutulong ka sa pag-aayos ng damit gamit ang simpleng pananahi, tulad ng pagpapaikli ng pantalon o pag-ayos ng maliliit na bahagi. Gumagamit ka ng simpleng gamit pangtahi 
                    at tinitiyak na handa ang damit para sa mga customer" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job7.jpg" alt="tailoring assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Alteration/Tailoring Assistant (for a clothing line)</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help fix clothes by doing simple sewing tasks, like shortening pants or repairing small parts. You use basic
                    sewing tools and make sure the clothes are ready for customers.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulong ka sa pag-aayos ng damit gamit ang simpleng pananahi, tulad ng pagpapaikli ng pantalon o pag-ayos ng maliliit na bahagi. Gumagamit ka ng simpleng gamit pangtahi 
                    at tinitiyak na handa ang damit para sa mga customer)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Fixing small tears and hemming pants for neat display.</p>
            </div>

            <!-- Job 8 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Menu & Order Assistant" onclick="toggleJobPref1Choice(this,'Menu & Order Assistant ')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Menu & Order Assistant:You help show the menu, guide customers, and assist in taking their orders together with a partner crew
                    Example: Guiding customers through menu choices and confirming their order politely" 
                    data-tts-tl="Tutulong mo ipakita ang menu, gabayan ang customers, at kumuha ng kanilang order kasama ang partner crew" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job8.jpg" alt="order assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Menu & Order Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help show the menu, guide customers, and assist in taking their orders together with a partner crew. 
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulong mo ipakita ang menu, gabayan ang customers, at kumuha ng kanilang order kasama ang partner crew)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Guiding customers through menu choices and confirming their order politely.</p>
            </div>

            <!-- Job 9 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Food Runner / Server Assistant" onclick="toggleJobPref1Choice(this,'Food Runner / Server Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Food Runner / Server Assistant:You bring food to the customers' tables safely and politely
                    Example: Delivering meals quickly and politely to customers’ tables" 
                    data-tts-tl="Ikaw ay magdadala ng pagkain sa mesa ng customers nang maayos at magalang" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job9.jpg" alt="server assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Food Runner / Server Assistant </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You bring food to the customers' tables safely and politely. 
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Ikaw ay magdadala ng pagkain sa mesa ng customers nang maayos at magalang)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Delivering meals quickly and politely to customers’ tables.</p>
            </div>

            <!-- Job 10 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Table Setter / Dining Area Assistant " onclick="toggleJobPref1Choice(this,'Table Setter / Dining Area Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Table Setter / Dining Area Assistant:You set up tables, wipe surfaces, and help keep the dining area clean
                    Example: Set up tables and clear dishes so guests can dine comfortably" 
                    data-tts-tl="Aayusin mo ang mesa, lilinisin ang ibabaw nito, at tutulong panatilihing malinis ang dining area" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job10.jpg" alt="dining assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Table Setter / Dining Area Assistant </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You set up tables, wipe surfaces, and help keep the dining area clean. 
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Aayusin mo ang mesa, lilinisin ang ibabaw nito, at tutulong panatilihing malinis ang dining area)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Set up tables and clear dishes so guests can dine comfortably.</p>
            </div>

            <!-- Job 11 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Kitchen Helper" onclick="toggleJobPref1Choice(this,'Kitchen Helper')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Kitchen Helper:You help with simple kitchen tasks like sorting utensils or preparing food
                    Example: Organizing utensils and helping prepare simple kitchen items" 
                    data-tts-tl="Tutulong ka sa mga simpleng gawain sa kusina tulad ng pagsasaayos ng utensils o paghahanda ng maliliit na pagkain" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job11.jpg" alt="kitchen helper" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Kitchen Helper</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help with simple kitchen tasks like sorting utensils or preparing food.  
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulong ka sa mga simpleng gawain sa kusina tulad ng pagsasaayos ng utensils o paghahanda ng maliliit na pagkain)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Organizing utensils and helping prepare simple kitchen items.</p>
            </div>

             <!-- Job 12 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Housekeeping Assistant" onclick="toggleJobPref1Choice(this,'Housekeeping Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Housekeeping Assistant:You help clean rooms, make beds, fold towels, and organize items
                    Example: Making beds and folding towels to keep hotel rooms tidy" 
                    data-tts-tl="Tututulong ka maglinis ng kwarto, mag-ayos ng kama, magtupi ng tuwalya, at mag-ayos ng mga gamit" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job12.jpg" alt="housekeeping assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Housekeeping Assistant </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help clean rooms, make beds, fold towels, and organize items.   
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tututulong ka maglinis ng kwarto, mag-ayos ng kama, magtupi ng tuwalya, at mag-ayos ng mga gamit)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Making beds and folding towels to keep hotel rooms tidy.</p>
            </div>

            <!-- Job 13 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value="Concierge / Front Desk Helper" onclick="toggleJobPref1Choice(this,'Concierge / Front Desk Helper')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Concierge / Front Desk Helper:You help welcome guests, smile, greet them, and guide them to where they need to go
                    Example: Greeting visitors and directing them to the right service area" 
                    data-tts-tl="Tututulong ka mag-welcome ng guests, bumati, ngumiti, at ituro sila sa tamang lugar kung saan sila dadaan" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job13.jpg" alt="concierge" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Concierge / Front Desk Helper </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help welcome guests, smile, greet them, and guide them to where they need to go.  
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tututulong ka mag-welcome ng guests, bumati, ngumiti, at ituro sila sa tamang lugar kung saan sila dadaan)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Greeting visitors and directing them to the right service area.</p>
            </div>

            <!-- Job 14 -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card jobpref-card"
                data-value=" Sales & Promotion Assistant" onclick="toggleJobPref1Choice(this,' Sales & Promotion Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en=" Sales & Promotion Assistant:You give out flyers, help with simple promotions, or assist in arranging display items
                    Example: Handing out flyers and arranging promotional displays neatly" 
                    data-tts-tl="Ikaw ay mamimigay ng flyers, tutulong sa simpleng promotions, o tututulong mag-ayos ng mga display" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job14.jpg" alt="sales" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center"> Sales & Promotion Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You give out flyers, help with simple promotions, or assist in arranging display items.  
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Ikaw ay mamimigay ng flyers, tutulong sa simpleng promotions, o tututulong mag-ayos ng mga display)
                </p>
                <p class="text-[13px] text-gray-600 italic mt-2 text-center">Example: Handing out flyers and arranging promotional displays neatly.</p>
            </div>
            

        </div>

        <!-- Hidden input for job preference (JSON array) -->
        <input id="jobpref1" type="hidden" value="[]" />
    </div>

        <script>
            // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_job-preference-1.blade.php
            function toggleJobPref1Choice(el, value) {
                try {
                    const hidden = document.getElementById('jobpref1');
                    if (!hidden) return;
                    let arr = [];
                    try {
                        arr = JSON.parse(hidden.value || '[]');
                    } catch (e) {
                        arr = [];
                    }
                    const idx = arr.indexOf(value);
                    if (idx === -1) {
                        // enforce maximum of 5 selections
                        if (arr.length >= 5) {
                            const err = document.getElementById('jobpref1Error');
                            if (err) err.textContent = 'You can select up to 5 options only.';
                            // brief shake animation (if supported)
                            try { if (el && el.animate) el.animate([{ transform: 'translateY(-3px)' }, { transform: 'translateY(0)' }], { duration: 220 }); } catch(_){}
                            return;
                        }
                        arr.push(value);
                        if (el && el.classList) el.classList.add('selected');
                    } else {
                        arr.splice(idx, 1);
                        if (el && el.classList) el.classList.remove('selected');
                        const err = document.getElementById('jobpref1Error');
                        if (err) err.textContent = '';
                    }
                    hidden.value = JSON.stringify(arr);
                    if (value === 'other') {
                        // focus the 'Other' text input (id in template is jobpref_other_text)
                        const other = document.getElementById('jobpref_other_text') || document.getElementById('jobpref1_other_text');
                        if (other && arr.indexOf('other') !== -1) other.focus();
                    }
                    const err = document.getElementById('jobpref1Error');
                    if (err) err.textContent = '';
                } catch (e) {
                    console.error('toggleJobPref1Choice error', e);
                }
            }

            // pre-select on load (if autofill set the hidden value)
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const hidden = document.getElementById('jobpref1');
                    if (!hidden) return;
                    let arr = [];
                    try {
                        arr = JSON.parse(hidden.value || '[]');
                    } catch (e) {
                        arr = [];
                    }
                    document.querySelectorAll('.skills-card[data-value], .jobpref-card[data-value]').forEach(c => {
                        const v = c.getAttribute('data-value');
                        if (v && arr.indexOf(v) !== -1) c.classList.add('selected');
                        else c.classList.remove('selected');
                    });
                } catch (e) {
                    /* ignore */
                }
            });
        </script>

        <!-- Next Button -->
        <div class="flex flex-col items-center justify-center mt-6 mb-6 space-y-3 px-2">
            <div id="jobpref1Error" class="text-red-600 text-sm text-center"></div>
            <button id="jobpref1Next" type="button"
                class="w-full sm:w-auto bg-[#2E2EFF] text-white text-lg sm:text-2xl font-semibold px-6 sm:px-16 md:px-28 py-3 sm:py-4 rounded-2xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-300">
                Next →
            </button>
               <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
                        Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue <br class="hidden sm:block">
                       <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
                </p>
        </div>
    </div>
    </form>
    </div>

    <!-- Review / Preview modal (merged) -->
    <div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-lg p-4 w-11/12 max-w-3xl mx-4 overflow-auto">
            <h3 class="text-lg font-bold mb-2 text-blue-700">Job Recommendations Preview</h3>
            <p id="previewBasedOn" class="text-sm text-gray-600 italic mb-4"> </p>
            <div id="previewList" class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-80 overflow-auto mb-4"></div>
            <p class="text-sm text-gray-700 mb-4">You are about to proceed to the final step of the process. Do you want to continue?</p>
            <div class="flex justify-end gap-3">
                <button id="reviewModalCancel" class="px-4 py-2 rounded-md bg-gray-200">Cancel</button>
                <button id="reviewModalSkip" class="px-4 py-2 rounded-md bg-green-600 text-white">Go to final step</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/register.js') }}"></script>
    <script>
        // Validate selection count on Next click (must be between 3 and 5)
        (function() {
            const next = document.getElementById('jobpref1Next');
            if (!next) return;

            next.addEventListener('click', function(e) {
                try {
                    e.preventDefault();
                    const hidden = document.getElementById('jobpref1');
                    let arr = [];
                    try { arr = JSON.parse(hidden.value || '[]'); } catch (err) { arr = []; }

                    const errEl = document.getElementById('jobpref1Error');

                    // Validation
                    if (!arr || arr.length < 3) {
                        if (errEl) errEl.textContent = 'Please select at least 3 options.';
                        return;
                    }
                    if (arr.length > 5) {
                        if (errEl) errEl.textContent = 'Please select no more than 5 options.';
                        return;
                    }
                    if (errEl) errEl.textContent = '';

                    // ✅ Save selected job preferences to localStorage and hidden input
                    localStorage.setItem('jobPreferences', JSON.stringify(arr));
                    if (hidden) hidden.value = JSON.stringify(arr);
                    console.log('Saved job preferences to localStorage:', arr);

                    // Allow register.js to handle navigation and saving if present
                    if (typeof window.populateReview === 'function' || typeof window.__mvsg_debugRun === 'function') {
                        return; // defer to register.js
                    }

                    // If preview function is available, fetch preview and show modal (user-triggered)
                    if (typeof window.fetchPreviewFor === 'function') {
                        try { window.fetchPreviewFor(arr); } catch(e) { console.warn('fetchPreviewFor failed', e); }
                        return;
                    }

                    // Fallback if register.js / preview not present: submit form or navigate
                    const form = document.querySelector('form');
                    if (form) { form.submit(); return; }
                    window.location.href = '{{ route('registerreview1') }}';
                } catch (e) {
                    console.error('jobpref1Next click handler error', e);
                }
            });
        })();
    </script>

    <script>
        // Modal button handlers for review/skip
        (function(){
            const modal = document.getElementById('reviewModal');
            if (!modal) return;
            const btnSkip = document.getElementById('reviewModalSkip');
            const btnCancel = document.getElementById('reviewModalCancel');

            function closeModal() { modal.classList.add('hidden'); }

            if (btnCancel) btnCancel.addEventListener('click', function(){ closeModal(); });
            if (btnSkip) btnSkip.addEventListener('click', function(){
                closeModal();
                window.location.href = '{{ route('registerfinalstep') }}';
            });

            // close on Escape
            window.addEventListener('keydown', function (ev) {
                if (ev.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });
        })();
    </script>

    <script>
        // Job preferences -> merged review/preview modal integration
        (function(){
            const reviewModal = document.getElementById('reviewModal');
            const previewList = document.getElementById('previewList');
            const previewBasedOn = document.getElementById('previewBasedOn');
            const btnCancel = document.getElementById('reviewModalCancel');
            const btnSkip = document.getElementById('reviewModalSkip');

            let debounceTimer = null;

            function closeModal() { if (reviewModal) reviewModal.classList.add('hidden'); }
            function openModal() { if (reviewModal) reviewModal.classList.remove('hidden'); }

            function getSelectedPrefs() {
                const els = Array.from(document.querySelectorAll('.skills-card.selected, .jobpref-card.selected'));
                return els.map(e => e.getAttribute('data-value')).filter(Boolean);
            }

            async function fetchPreviewFor(prefs) {
                if (!prefs || prefs.length === 0) return;
                try {
                    // Build a compact profile payload from localStorage (if available)
                    const profileKeys = ['skills','certifications','education','address','city','province','experience','languages','disabilities','age','gender','firstName','lastName','occupation','summary'];
                    const profile = {};
                    profileKeys.forEach(k => {
                        try {
                            const raw = localStorage.getItem(k);
                            if (raw === null || raw === undefined) return;
                            // try to parse JSON arrays/objects, otherwise send raw string
                            try { profile[k] = JSON.parse(raw); } catch(_) { profile[k] = raw; }
                        } catch(e) { /* ignore localStorage errors */ }
                    });

                    const bodyPayload = { job_prefs: prefs };
                    // only attach profile if it contains any keys
                    if (Object.keys(profile).length) bodyPayload.profile = profile;

                    const res = await fetch('/db/get-jobs-preview.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(bodyPayload)
                    });
                    const data = await res.json();
                    if (data && data.success && Array.isArray(data.recommendations)) {
                        renderRecommendations(data.recommendations, data.preview_based_on || prefs);
                        // show the modal
                        openModal();
                    }
                } catch (err) {
                    console.warn('Preview fetch failed', err);
                }
            }

            function renderRecommendations(list, basedOn) {
                if (!previewList) return;
                previewList.innerHTML = '';
                previewBasedOn.textContent = basedOn && basedOn.length ? 'Based on: ' + basedOn.join(', ') : '';
                list.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 p-3 border rounded-lg';
                    const img = document.createElement('img');
                    img.src = item.logo || 'https://via.placeholder.com/80?text=Logo';
                    img.alt = item.company_name || 'logo';
                    img.className = 'w-16 h-16 object-cover rounded-md';
                    const body = document.createElement('div');
                    body.className = 'flex-1';
                    const title = document.createElement('div');
                    title.className = 'font-semibold text-blue-700';
                    title.textContent = item.job_role || 'Job';
                    const company = document.createElement('div');
                    company.className = 'text-sm text-gray-600';
                    company.textContent = item.company_name || '';
                    const score = document.createElement('div');
                    score.className = 'text-xs text-gray-500 mt-1';
                    score.textContent = 'Match: ' + (item.computed_score !== undefined ? item.computed_score + '%' : (item.content_score ? item.content_score + '%' : '—'));
                    const desc = document.createElement('div');
                    desc.className = 'text-sm text-gray-700 mt-1';
                    desc.textContent = (item.description || '').slice(0, 140) + ((item.description || '').length > 140 ? '…' : '');
                    body.appendChild(title);
                    body.appendChild(company);
                    body.appendChild(score);
                    body.appendChild(desc);
                    div.appendChild(img);
                    div.appendChild(body);
                    previewList.appendChild(div);
                });
            }

            // Delegated click handler intentionally left minimal: selection is handled
            // by `toggleJobPref1Choice()` which updates the hidden input. We do NOT
            // auto-open the preview modal on selection anymore; the preview/modal
            // will be shown only when the user clicks Next.
            // (No auto-fetch on click.)

            // Expose fetchPreviewFor and getSelectedPrefs globally so Next button can invoke them
            window.getSelectedJobPrefs = getSelectedPrefs;
            window.fetchPreviewFor = fetchPreviewFor;

            if (btnCancel) btnCancel.addEventListener('click', function(){ closeModal(); });
            if (btnSkip) btnSkip.addEventListener('click', function(){ closeModal(); window.location.href = '{{ route('registerfinalstep') }}'; });

            // allow Escape to close modal
            window.addEventListener('keydown', function(ev){ if (ev.key === 'Escape' && reviewModal && !reviewModal.classList.contains('hidden')) { closeModal(); } });
        })();
    </script>

    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tts-btn');
            const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
            let preferredEnglishVoice = null;
            let preferredTagalogVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName)
                    || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
                    || null;
                preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName)
                    || availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name))
                    || null;
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

            buttons.forEach(function (btn) {
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');

                btn.addEventListener('click', function () {
                    const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                    const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                    if (!textEn && !textTl) return;
                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
                        stopSpeaking();
                        return;
                    }
                    stopSpeaking();
                    setTimeout(function () {
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

                        seq[0].onstart = function () {
                            btn.classList.add('speaking');
                            btn.setAttribute('aria-pressed', 'true');
                            currentBtn = btn;
                        };

                        for (let i = 0; i < seq.length; i++) {
                            const ut = seq[i];
                            ut.onerror = function () {
                                if (btn) btn.classList.remove('speaking');
                                if (btn) btn.removeAttribute('aria-pressed');
                                currentBtn = null;
                            };
                            if (i < seq.length - 1) {
                                ut.onend = function () { window.speechSynthesis.speak(seq[i + 1]); };
                            } else {
                                ut.onend = function () {
                                    if (btn) btn.classList.remove('speaking');
                                    if (btn) btn.removeAttribute('aria-pressed');
                                    currentBtn = null;
                                };
                            }
                        }

                        window.speechSynthesis.speak(seq[0]);
                    }, 50);
                });

                btn.addEventListener('keydown', function (ev) {
                    if (ev.key === 'Enter' || ev.key === ' ') {
                        ev.preventDefault();
                        btn.click();
                    }
                });
            });

            window.addEventListener('beforeunload', function () { if (window.speechSynthesis) window.speechSynthesis.cancel(); });
            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function () { populateVoices(); };
            }
        });
    </script>
        <script>
        // Restore job preference selections when returning to this page.
        // Runs immediately if the document has already loaded.
        (function(){
            function doRestore(){
                try{
                    const hidden = document.getElementById('jobpref1');
                    const raw = localStorage.getItem('jobPreferences') || localStorage.getItem('jobpref1') || localStorage.getItem('jobpref') || (hidden ? hidden.value : '');
                    let arr = [];
                    if (raw) {
                        try { arr = JSON.parse(raw || '[]'); } catch(e) {
                            arr = String(raw).split(',').map(s=>s.trim()).filter(Boolean);
                        }
                    }
                    arr = Array.isArray(arr) ? Array.from(new Set(arr.map(x=>String(x||'').trim()).filter(Boolean))) : [];
                    if (hidden) hidden.value = JSON.stringify(arr);

                    document.querySelectorAll('.jobpref-card').forEach(card => {
                        try {
                            const v = (card.getAttribute('data-value') || '').trim();
                            if (v && arr.includes(v)) card.classList.add('selected'); else card.classList.remove('selected');
                        } catch(e) {}
                    });
                } catch (e) { console.warn('jobpref restore failed', e); }
            }
            if (document.readyState === 'loading') window.addEventListener('DOMContentLoaded', doRestore); else doRestore();
        })();
        </script>

    </body>

    </html>
