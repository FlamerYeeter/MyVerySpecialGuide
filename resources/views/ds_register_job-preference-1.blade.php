<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Job Preference</title>
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
    .jobpref-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
    }
    </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-1 sm:left-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-1 sm:left-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-1 sm:right-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-1 sm:right-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerskills1') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-3 h-3 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug">
                Set Up Your Profile
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
            <h2
                class="text-lg sm:text-2xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-2 flex-wrap">
                Continue setting up your profile
                <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn" data-tts-en="Continue setting up your profile" data-tts-tl="Ituloy ang pag-set up ng iyong profile" aria-label="Play audio for header">🔊</button>
            </h2>
            <p
                class="mt-2 text-gray-700 italic text-sm sm:text-base md:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ituloy ang pag-set up ng iyong profile)
            </p>
        </div>
        <!-- Information Section -->
        <div
            class="relative bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 sm:p-8 mt-10 shadow-md max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start gap-4 pr-14">
                <div class="flex-shrink-0 flex justify-center sm:justify-start w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 mt-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                    </svg>
                </div>

                <div class="flex-1 text-center sm:text-left">
                    <p class="font-medium text-blue-800 text-sm sm:text-base leading-relaxed">
                        This section helps us understand what kind of jobs you prefer based on your comfort
                        level.
                        By choosing your job preferences, we can match you with workplaces where you’ll feel
                        comfortable,
                        supported, and confident to do your best work.
                    </p>

                    <p class="italic text-gray-600 text-xs sm:text-sm mt-2 leading-relaxed">
                        (Ang seksyong ito ay tumutulong upang malaman namin kung anong klase ng trabaho ang gusto mo
                        batay sa iyong antas ng kaginhawaan. Sa pagpili ng iyong mga job preference,
                        matutulungan ka naming makahanap ng lugar ng trabaho kung saan ka magiging komportable,
                        suportado, at makakagawa ng iyong pinakamahusay.)
                    </p>

                    <p class="mt-3 text-xs sm:text-sm text-red-500 italic">
                        *Note: Some job options might not be available in your area right now, but they may open
                        soon.*<br>
                        (Tandaan: Maaaring hindi pa available ang ilang trabaho sa iyong lugar sa ngayon, ngunit
                        maaaring magbukas ito kung kinakailangan.)
                    </p>
                </div>
            </div>

            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 tts-btn"
                data-tts-en="This section helps us understand what kind of jobs you prefer based on your comfort level. By choosing your job preferences, we can match you with workplaces where you’ll feel comfortable, supported, and confident to do your best work." data-tts-tl="Ang seksyong ito ay tumutulong upang malaman namin kung anong klase ng trabaho ang gusto mo batay sa iyong antas ng kaginhawaan. Sa pagpili ng iyong mga job preference, matutulungan ka naming makahanap ng lugar ng trabaho kung saan ka magiging komportable, suportado, at makakagawa ng iyong pinakamahusay." aria-label="Play audio for information note">
                🔊
            </button>
        </div>

        <!-- Instructions Section -->
        <div
            class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 sm:p-10 mt-10 shadow-lg border border-blue-100 max-w-4xl mx-auto">
            <div class="flex flex-col items-center sm:items-start text-center sm:text-left space-y-4">

                <!-- Header with Icon and Audio Button -->
                <div class="flex items-center justify-center sm:justify-start gap-3 w-full">
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                            Selection Instructions
                        </h2>
                    </div>
                    <button type="button"
                        class="ml-auto bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 tts-btn"
                        data-tts-en="Choose 3 to 5 job options from the images below. You must choose at least 3 and no more than 5 options to proceed." data-tts-tl="Pumili ng 3 hanggang 5 pagpipiliang trabaho mula sa mga larawan sa ibaba. Kailangang pumili ka ng hindi bababa sa 3 at hindi hihigit sa 5 na opsyon upang magpatuloy." title="Play instruction" aria-label="Play audio for instruction">
                        🔊
                    </button>
                </div>

                <!-- English Instruction -->
                <p class="text-base sm:text-lg font-medium text-gray-800 leading-relaxed">
                    Choose <span class="font-semibold text-blue-700">3 to 5 job options from the images below.</span>
                    You must choose at least 3 and no more than 5 options to proceed.
                </p>

                <!-- Divider -->
                <div class="w-full border-t border-gray-200"></div>

                <!-- Tagalog Instruction -->
                <p class="text-sm sm:text-base text-gray-700 italic leading-snug">
                    (<span class="font-semibold text-blue-700">Pumili ng 3 hanggang 5 pagpipiliang trabaho mula sa mga
                        larawan sa ibaba.</span>
                    Kailangang pumili ka ng hindi bababa sa 3 at hindi hihigit sa 5 na opsyon upang magpatuloy.)
                </p>
            </div>
        </div>


        <!-- Job Options Cards Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

            <!-- Job 1 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Store Greeter / Customer Assistant" onclick="toggleJobPref1Choice(this,'Store Greeter / Customer Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Store Greeter/Customer Assistant: You stay in your assigned place with a warm smile, welcoming customers as they arrive. You kindly
                     assist them by guiding them to the areas they’re looking for and helping them find what they need."
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
            </div>

            <!-- Job 2 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Merchandising Assistant" onclick="toggleJobPref1Choice(this,'Merchandising Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Merchandising Assistant:You will help keep the store looking nice. You arrange products on the shelves and make sure everything looks neat 
                    and in the right place." 
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
            </div>

            <!-- Job 3 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Stockroom Helper" onclick="toggleJobPref1Choice(this,'Stockroom Helper')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Stockroom Helper: You work in the stockroom where you sort items and fix boxes. You help prepare products before they go out to the store." 
                    data-tts-tl="Magtatrabaho ka sa stockroom kung saan inaayos mo ang mga gamit at mga kahon. Tinutulungan mong ihanda ang mga products bago ilagay sa store" aria-label="Play audio for Cleaning Work">🔊</button>
                <img src="image/job3.jpg" alt="stockroom helper" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Stockroom Helper</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You work in the stockroom where you sort items and fix boxes. You help prepare products before they go out to the store.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Magtatrabaho ka sa stockroom kung saan inaayos mo ang mga gamit at mga kahon. Tinutulungan mong ihanda ang mga products bago ilagay sa store)
                </p>
            </div>

            <!-- Job 4 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Basket & Cart Organizer" onclick="toggleJobPref1Choice(this,'Basket & Cart Organizer')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Basket & Cart Organizer: You carefully collect the used baskets and carts and bring them back to their proper place. You arrange them neatly at the entrance 
                    so customers can easily use them." 
                    data-tts-tl="Maingat mong kinokolekta ang mga nagamit na basket at cart at ibinabalik ang mga ito sa tamang lugar. Inaayos mo rin ang mga ito nang maayos sa entrance para madaling magamit ng mga customer" aria-label="Play audio for Hospitality Work">🔊</button>
                <img src="image/job4.jpg" alt="basket organizer" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Basket & Cart Organizer</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You carefully collect the used baskets and carts and bring them back to their proper place. You arrange them neatly at the entrance 
                    so customers can easily use them.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Maingat mong kinokolekta ang mga nagamit na basket at cart at ibinabalik ang mga ito sa tamang lugar. Inaayos mo rin ang mga ito nang maayos sa entrance para madaling magamit ng mga customer)
            </div>

            <!-- Job 5 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Store Utility / Cleaner" onclick="toggleJobPref1Choice(this,'Store Utility / Cleaner')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Store Utility / Cleaner: You help keep the store clean. You wipe tables, organize small areas, and make sure paths are clear and safe for customers." 
                    data-tts-tl="Tumutulong kang panatilihing malinis ang store. Pinupunasan mo ang mga mesa at tinitiyak na malinis at ligtas ang daanan para sa mga customer" aria-label="Play audio for Food Service Work">🔊</button>
                <img src="image/job5.jpg" alt="store cleaner" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Store Utility / Cleaner</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You help keep the store clean. You wipe tables, organize small areas, and make sure paths are clear and safe for customers.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tumutulong kang panatilihing malinis ang store. Pinupunasan mo ang mga mesa at tinitiyak na malinis at ligtas ang daanan para sa mga customer)
                </p>
            </div>

            <!-- Job 6 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Packaging Support / Bagging Assistant" onclick="toggleJobPref1Choice(this,'Packaging Support / Bagging Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Packaging Support / Bagging Assistant:You help customers by placing their items gently and neatly into bags at the cashier area." 
                    data-tts-tl="Tutuulungan mo ang customer sa cashier sa paglalagay ng kanilang mga binili sa bag nang maingat at maayos" aria-label="Play audio for Packing Packages Work">🔊</button>
                <img src="image/job6.jpg" alt="packing support" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Packaging Support / Bagging Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You help customers by placing their items gently and neatly into bags at the cashier area.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutuulungan mo ang customer sa cashier sa paglalagay ng kanilang mga binili sa bag nang maingat at maayos)
                </p>
            </div>

            <!-- Job 7 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Alteration/Tailoring Assistant (for a clothing line)" onclick="toggleJobPref1Choice(this,'Alteration/Tailoring Assistant (for a clothing line)')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Alteration/Tailoring Assistant (for a clothing line):You help fix clothes by doing simple sewing tasks, like shortening pants or repairing small parts. You use basic
                    sewing tools and make sure the clothes are ready for customers." 
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
            </div>

            <!-- Job 8 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Menu & Order Assistant" onclick="toggleJobPref1Choice(this,'Menu & Order Assistant ')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Menu & Order Assistant:You help show the menu, guide customers, and assist in taking their orders together with a partner crew." 
                    data-tts-tl="Tutulong mo ipakita ang menu, gabayan ang customers, at kumuha ng kanilang order kasama ang partner crew" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job8.jpg" alt="order assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Menu & Order Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help show the menu, guide customers, and assist in taking their orders together with a partner crew. 
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulong mo ipakita ang menu, gabayan ang customers, at kumuha ng kanilang order kasama ang partner crew)
                </p>
            </div>

            <!-- Job 9 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Food Runner / Server Assistant" onclick="toggleJobPref1Choice(this,'Food Runner / Server Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Food Runner / Server Assistant:You bring food to the customers' tables safely and politely. " 
                    data-tts-tl="Ikaw ay magdadala ng pagkain sa mesa ng customers nang maayos at magalang" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job9.jpg" alt="server assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Food Runner / Server Assistant </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You bring food to the customers' tables safely and politely. 
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Ikaw ay magdadala ng pagkain sa mesa ng customers nang maayos at magalang)
                </p>
            </div>

            <!-- Job 10 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Table Setter / Dining Area Assistant " onclick="toggleJobPref1Choice(this,'Table Setter / Dining Area Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Table Setter / Dining Area Assistant:You set up tables, wipe surfaces, and help keep the dining area clean." 
                    data-tts-tl="Aayusin mo ang mesa, lilinisin ang ibabaw nito, at tutulong panatilihing malinis ang dining area" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job10.jpg" alt="dining assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Table Setter / Dining Area Assistant </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You set up tables, wipe surfaces, and help keep the dining area clean. 
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Aayusin mo ang mesa, lilinisin ang ibabaw nito, at tutulong panatilihing malinis ang dining area)
                </p>
            </div>

            <!-- Job 11 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Kitchen Helper" onclick="toggleJobPref1Choice(this,'Kitchen Helper')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Kitchen Helper:You help with simple kitchen tasks like sorting utensils or preparing food." 
                    data-tts-tl="Tutulong ka sa mga simpleng gawain sa kusina tulad ng pagsasaayos ng utensils o paghahanda ng maliliit na pagkain" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job11.jpg" alt="kitchen helper" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Kitchen Helper</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help with simple kitchen tasks like sorting utensils or preparing food.  
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulong ka sa mga simpleng gawain sa kusina tulad ng pagsasaayos ng utensils o paghahanda ng maliliit na pagkain)
                </p>
            </div>

             <!-- Job 12 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Housekeeping Assistant" onclick="toggleJobPref1Choice(this,'Housekeeping Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Housekeeping Assistant:You help clean rooms, make beds, fold towels, and organize items." 
                    data-tts-tl="Tututulong ka maglinis ng kwarto, mag-ayos ng kama, magtupi ng tuwalya, at mag-ayos ng mga gamit" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job12.jpg" alt="housekeeping assistant" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Housekeeping Assistant </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help clean rooms, make beds, fold towels, and organize items.   
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tututulong ka maglinis ng kwarto, mag-ayos ng kama, magtupi ng tuwalya, at mag-ayos ng mga gamit)
                </p>
            </div>

            <!-- Job 13 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Concierge / Front Desk Helper" onclick="toggleJobPref1Choice(this,'Concierge / Front Desk Helper')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Concierge / Front Desk Helper:You help welcome guests, smile, greet them, and guide them to where they need to go. " 
                    data-tts-tl="Tututulong ka mag-welcome ng guests, bumati, ngumiti, at ituro sila sa tamang lugar kung saan sila dadaan" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job13.jpg" alt="concierge" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Concierge / Front Desk Helper </h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You help welcome guests, smile, greet them, and guide them to where they need to go.  
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tututulong ka mag-welcome ng guests, bumati, ngumiti, at ituro sila sa tamang lugar kung saan sila dadaan)
                </p>
            </div>

            <!-- Job 14 -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value=" Sales & Promotion Assistant" onclick="toggleJobPref1Choice(this,' Sales & Promotion Assistant')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en=" Sales & Promotion Assistant:You give out flyers, help with simple promotions, or assist in arranging display items." 
                    data-tts-tl="Ikaw ay mamimigay ng flyers, tutulong sa simpleng promotions, o tututulong mag-ayos ng mga display" aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/job14.jpg" alt="sales" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center"> Sales & Promotion Assistant</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                   You give out flyers, help with simple promotions, or assist in arranging display items.  
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Ikaw ay mamimigay ng flyers, tutulong sa simpleng promotions, o tututulong mag-ayos ng mga display)
                </p>
            </div>
            

        </div>

        <!-- Hidden input for job preference (JSON array) -->
        <input id="jobpref1" type="hidden" value="[]" />

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
                    document.querySelectorAll('.jobpref-card[data-value]').forEach(c => {
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
        <div class="w-full flex flex-col items-center justify-center mt-12 mb-8">
            <div id="jobpref1Error" class="text-red-600 text-sm mb-2"></div>
            <button id="jobpref1Next" type="button"
                class="bg-[#2E2EFF] text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md">
                Next →
            </button>
            <p class="text-gray-600 text-sm mt-2 text-center">
                Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page<br>
                <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
            </p>
        </div>
    </div>
    </form>
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

                    // ✅ Save selected job preferences to localStorage
                    localStorage.setItem('jobPreferences', JSON.stringify(arr));
                    console.log('Saved job preferences to localStorage:', arr);

                    // Allow register.js to handle navigation and saving if present
                    if (typeof window.populateReview === 'function' || typeof window.__mvsg_debugRun === 'function') {
                        return; // defer to register.js
                    }

                    // Fallback if register.js not present
                    const form = document.querySelector('form');
                    if (form) { form.submit(); return; }

                    window.location.href = '{{ route('registerreview1') }}';
                } catch (e) {
                    console.error('jobpref1Next click handler error', e);
                }
            });
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
