<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .animate-float-slow { animation: float 5s ease-in-out infinite; }
      .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
      .animate-float-fast { animation: float 2.5s ease-in-out infinite; }

        .selectable-card {
            border: 2px solid transparent;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .selectable-card.selected {
            border-color: #2563eb;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.14);
            transform: translateY(-6px);
        }

        .selectable-card.selected::after,
        .jobpref-card.selected::after {
            content: "";
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 44px;
            height: 44px;
            background-image: url('/image/checkmark.png');
            background-size: contain;
            background-repeat: no-repeat;
        }
        /* TTS button visual state */
        .tts-btn { cursor: pointer; }
        .tts-btn.speaking { transform: scale(1.04); box-shadow: 0 8px 24px rgba(30,64,175,0.12); }
    </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots -->
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
    onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerreview4') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-3 h-3 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug">
                Review Your Job Preferences
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
        </div>

        <!-- Instructions -->
        <div class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>
                <div class="flex-1 text-center sm:text-left">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        You can change your job preference by clicking the "Change" button.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Maaari mong baguhin ang iyong mga trabahong gusto sa pamamagitan ng pag-click sa button na
                        “Change”)
                    </p>
                </div>
            </div>
            <button type="button"
                class="tts-btn absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200"
                data-tts-en="You can change your job preference by clicking the Change button."
                data-tts-tl="Maaari mong baguhin ang iyong mga trabahong gusto sa pamamagitan ng pag-click sa button na Change"
                aria-label="Read instructions aloud in English then Filipino"></button>
        </div>


        <!-- Info Box -->
        <div class="relative bg-green-50 border border-green-300 text-green-800 rounded-xl p-5 sm:p-6 mt-6 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-green-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        We use your job preferences to connect you with the right job, but some choices may not be
                        hiring now.
                    </p>
                    <p class="italic text-gray-700 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Gagamitin namin ang iyong piniling trabaho upang mahanap ang angkop na posisyon, ngunit may
                        pagkakataon maaaring walang hiring sa posisyon na ito.)
                    </p>
                </div>
            </div>

            <!-- Audio Button -->
            <button type="button"
                class="tts-btn absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md 
           hover:bg-green-800 hover:scale-105 transition-transform duration-200"
                data-tts-en="We use your job preferences to connect you with the right job, but some choices may not be hiring now."
                data-tts-tl="Gagamitin namin ang iyong piniling trabaho upang mahanap ang angkop na posisyon, ngunit may pagkakataon maaaring walang hiring sa posisyon na ito."
                aria-label="Read this info aloud in English then Filipino"></button>
        </div>

        <!-- Job Preferences Section -->
        <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200 mt-6">
            <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                Job Preferences Summary
            </h3>

            <!-- Job Preference Image 
            <div id="review_jobprefs_img_container" class="mt-4 text-center" style="display:none;">
                <div
                    class="inline-flex items-center justify-center w-40 h-40 bg-gray-50 rounded-xl shadow-md p-2 mx-auto">
                    <img id="review_jobprefs_img" src="" alt="Job preference image"
                        class="w-full h-full object-contain rounded-md" />
                </div>
            </div> -->

            <!-- Job Preference List -->
            <div id="review_jobprefs_list" class="flex flex-wrap gap-3 mt-6">
                <!-- populated dynamically with job preference pills; intentionally left empty when none -->
            </div>

            <!-- Change Jobs -->
            <div class="flex justify-center mt-6">
                <button type="button" id="rv5_change_jobprefs_btn"
                    class="bg-[#2E2EFF] hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition-transform duration-200 hover:scale-105">
                    ✏️ Edit
                </button>
            </div>
        </div>

        <!-- Job Preference Modal  -->
<div id="jobPrefModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center 
            z-[9999] transition-opacity duration-300 opacity-0">
  <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 max-w-5xl w-[95%] max-h-[90vh] 
            overflow-y-auto border border-gray-200 relative scale-95 transition-all duration-300">

    <!-- Header -->
    <div class="items-center justify-between mb-4">
      <h2 class="text-center text-1xl sm:text-2xl font-extrabold text-gray-800">Choose a Job You Prefer</h2>
      <p class="text-center text-gray-500 italic mt-1">
        (Pumili ng trabahong gusto mo)
    </p>
    </div>
   
    <!-- Yellow Note -->
    <div class="bg-yellow-100 border border-yellow-300 rounded-xl p-4 mt-6 text-center shadow-sm">
        <p class="font-semibold text-yellow-900">You can choose more than one option</p>
        <p class="text-yellow-800 italic text-sm">(Puwede kang pumili ng higit sa isa)</p>
    </div>

        <!-- Scrollable Job Cards Grid -->
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Store Greeter / Customer Assistant</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Merchandising Assistant</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Stockroom Helper</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Basket & Cart Organizer</h3>
                    <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                        You carefully collect the used baskets and carts and bring them back to their proper place. You arrange them neatly at the entrance 
                        so customers can easily use them.
                    </p>
                    <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                        (Maingat mong kinokolekta ang mga nagamit na basket at cart at ibinabalik ang mga ito sa tamang lugar. Inaayos mo rin ang mga ito nang maayos sa entrance para madaling magamit ng mga customer)
                    </p>
                </div>

                <!-- Job 5 -->
                <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                    data-value="Store Utility / Cleaner" onclick="toggleJobPref1Choice(this,'Store Utility / Cleaner')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Store Utility / Cleaner: You help keep the store clean. You wipe tables, organize small areas, and make sure paths are clear and safe for customers." 
                        data-tts-tl="Tumutulong kang panatilihing malinis ang store. Pinupunasan mo ang mga mesa at tinitiyak na malinis at ligtas ang daanan para sa mga customer" aria-label="Play audio for Food Service Work">🔊</button>
                    <img src="image/job5.jpg" alt="store cleaner" class="w-full rounded-md mb-4" />
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Store Utility / Cleaner</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Packaging Support / Bagging Assistant</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Alteration/Tailoring Assistant (for a clothing line)</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Menu & Order Assistant</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Food Runner / Server Assistant </h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Table Setter / Dining Area Assistant </h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Kitchen Helper</h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Housekeeping Assistant </h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center">Concierge / Front Desk Helper </h3>
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
                    <h3 class="text-blue-700 font-bold text-lg mb-2 text-center"> Sales & Promotion Assistant</h3>
                    <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                       You give out flyers, help with simple promotions, or assist in arranging display items.  
                    </p>
                    <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                        (Ikaw ay mamimigay ng flyers, tutulong sa simpleng promotions, o tututulong mag-ayos ng mga display)
                    </p>
                </div>
            </div>

            <!-- Buttons -->
    <div class="flex justify-center gap-6 mt-10">
        <button id="cancelJobPrefEdit"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl 
                       hover:bg-red-700 transition shadow-sm">
            Cancel
        </button>

        <button id="saveJobPrefEdit"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl 
                       hover:bg-blue-700 transition shadow-sm">
            Save Changes
        </button>
    </div>
</div>
</div>

<!-- Skills Card Style -->
<style>
.selected-card {
    border: 3px solid #1E40AF !important;
    background-color: #DBEAFE !important;
}
</style>

        
 <script> 
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("jobPrefModal");
  const editBtn = document.getElementById("rv5_change_jobprefs_btn");
  const closeBtn = document.getElementById("closeJobPrefModalBtn");
  const cancelBtn = document.getElementById("cancelJobPrefEdit");
  const saveBtn = document.getElementById("saveJobPrefEdit");
  const cards = Array.from(document.querySelectorAll(".jobpref-card, .selectable-card"));
  const reviewList = document.getElementById("review_jobprefs_list");
  const imgContainer = document.getElementById("review_jobprefs_img_container");
  const imgPreview = document.getElementById("review_jobprefs_img");
  const hiddenInput = document.getElementById("jobpref1");
  const STORAGE_KEYS = ['jobPreferences','jobpref1','jobpref','jobprefs','job_preferences'];

  const parseMaybeJson = v => {
    if (v === null || v === undefined) return v;
    if (Array.isArray(v) || typeof v === 'object') return v;
    if (typeof v !== 'string') return v;
    const s = v.trim();
    if (!s) return '';
    if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
      try { return JSON.parse(s); } catch(e){}
    }
    return s;
  };

  const normalizeArray = v => {
    if (v === null || v === undefined) return [];
    if (Array.isArray(v)) return v.map(x => typeof x === 'string' ? x.trim() : String(x||'')).filter(Boolean);
    if (typeof v === 'object') {
      try { return Object.values(v).map(x => String(x||'').trim()).filter(Boolean); } catch(e){ return []; }
    }
    if (typeof v === 'string') {
      const s = v.trim();
      if (!s) return [];
      if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) {
        try { return normalizeArray(JSON.parse(s)); } catch(e){}
      }
      if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
      return [s];
    }
    return [];
  };

  function getSavedJobPrefs() {
    try {
      if (hiddenInput && hiddenInput.value) {
        const parsed = parseMaybeJson(hiddenInput.value);
        const norm = normalizeArray(parsed);
        if (norm.length) return norm;
      }
      for (const k of STORAGE_KEYS) {
        try {
          const raw = localStorage.getItem(k);
          if (!raw) continue;
          const parsed = parseMaybeJson(raw);
          const norm = normalizeArray(parsed);
          if (norm.length) return norm;
        } catch(e){}
      }
      try {
        const rpRaw = localStorage.getItem('rpi_personal') || localStorage.getItem('registrationDraft') || localStorage.getItem('registerDraft');
        if (rpRaw) {
          const rp = parseMaybeJson(rpRaw) || rpRaw;
          if (rp && typeof rp === 'object') {
            const candidates = [];
            if (rp.jobPreferences) candidates.push(rp.jobPreferences);
            if (rp.jobpref1) candidates.push(rp.jobpref1);
            if (rp.jobpref) candidates.push(rp.jobpref);
            for (const c of candidates) {
              const norm = normalizeArray(c);
              if (norm.length) return norm;
            }
          }
        }
      } catch(e){}
      try {
        const d = window.__mvsg_lastLoadedDraft || window.registrationDraft || window.__REGISTRATION_DRAFT__;
        if (d && typeof d === 'object') {
          const candidates = [];
          if (d.jobPreferences) candidates.push(d.jobPreferences);
          if (d.jobpref1) candidates.push(d.jobpref1);
          if (d.jobpref) candidates.push(d.jobpref);
          for (const c of candidates) {
            const norm = normalizeArray(c);
            if (norm.length) return norm;
          }
        }
      } catch(e){}
    } catch(e){ console.debug('getSavedJobPrefs error', e); }
    return [];
  }

  function resetSelections() {
    cards.forEach(card => {
      card.classList.remove("selected-card","selected","ring","ring-blue-500","scale-[1.02]");
      card.setAttribute('aria-pressed', 'false');
    });
  }

  function setPreviewImageFor(value) {
    if (!imgPreview || !imgContainer) return;
    const selector = `.jobpref-card[data-value="${CSS && CSS.escape ? CSS.escape(value) : value}"] img`;
    const firstImg = document.querySelector(selector) || document.querySelector(`.jobpref-card img`);
    if (firstImg && firstImg.src) {
      imgPreview.src = firstImg.src;
      imgContainer.style.display = 'block';
    } else {
      imgContainer.style.display = 'none';
    }
  }

  function updateReviewSection(selected) {
    if (!reviewList) return;
    reviewList.innerHTML = "";
    const uniq = [...new Set((selected||[]).map(s => String(s||'').trim()).filter(Boolean))];
    if (!uniq.length) {
      reviewList.innerHTML = `<span class="text-gray-600">—</span>`;
      if (imgContainer) imgContainer.style.display = 'none';
    } else {
      uniq.forEach(item => {
        const span = document.createElement('span');
        span.className = 'bg-blue-100 text-blue-700 px-4 py-2 rounded-xl shadow font-medium text-sm';
        span.textContent = item;
        reviewList.appendChild(span);
      });
      setPreviewImageFor(uniq[0]);
    }

    try {
      const arr = uniq.length ? JSON.stringify(uniq) : '';
      if (arr) {
        localStorage.setItem('jobPreferences', arr);
        localStorage.setItem('jobpref1', arr);
      } else {
        STORAGE_KEYS.forEach(k => { try { localStorage.removeItem(k); } catch(e){} });
      }
      if (hiddenInput) hiddenInput.value = uniq.length ? JSON.stringify(uniq) : '';
      try { window.dispatchEvent(new CustomEvent('mvsg:jobprefsChanged', { detail: { values: uniq } })); } catch(e){}
    } catch(e){ console.debug('persist jobprefs failed', e); }
  }

  // card toggle (ignore tts button clicks)
  function cardToggleHandler(e) {
    if (e.target && e.target.classList && e.target.classList.contains('tts-btn')) return;
    const card = this;
    card.classList.toggle('selected-card');
    const pressed = card.classList.contains('selected-card');
    card.setAttribute('aria-pressed', pressed ? 'true' : 'false');

    const selected = Array.from(cards.filter(c => c.classList.contains('selected-card')))
                          .map(c => (c.dataset.value || c.querySelector('h3')?.textContent || '').trim())
                          .filter(Boolean);
    updateReviewSection(selected);
  }

  cards.forEach(card => {
    card.setAttribute('role','button');
    card.tabIndex = 0;
    card.setAttribute('aria-pressed', card.classList.contains('selected-card') ? 'true' : 'false');
    card.addEventListener('click', cardToggleHandler);
    card.addEventListener('keydown', ev => { if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); card.click(); } });
  });

  function loadPreviousSelections() {
    resetSelections();
    const saved = getSavedJobPrefs();
    if (!saved || !saved.length) return updateReviewSection([]);
    const norm = saved.map(s => String(s||'').trim());
    const lcSet = new Set(norm.map(x => x.toLowerCase()));
    cards.forEach(card => {
      const value = (card.dataset.value || '').trim();
      const title = (card.querySelector('h3')?.textContent || '').trim();
      if ((value && lcSet.has(value.toLowerCase())) || (title && lcSet.has(title.toLowerCase()))) {
        card.classList.add('selected-card');
        card.setAttribute('aria-pressed','true');
      }
    });
    updateReviewSection(norm);
  }

  // open modal
  if (editBtn) {
    editBtn.addEventListener('click', () => {
      if (!modal) return;
      modal.classList.remove('hidden');
      document.documentElement.style.overflow = 'hidden';
      setTimeout(() => modal.classList.remove('opacity-0'), 10);
      loadPreviousSelections();
      const focusTarget = modal.querySelector('input, button, textarea, [role="button"]');
      if (focusTarget) focusTarget.focus();
    });
  }

  // close modal
  function closeModalLocal() {
    if (!modal) return;
    modal.classList.add('opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 180);
    document.documentElement.style.overflow = '';
  }
  // hook close UI
  if (closeBtn) closeBtn.addEventListener('click', closeModalLocal);
  if (cancelBtn) cancelBtn.addEventListener('click', closeModalLocal);
  // preserve global name used by inline handlers
  window.closeJobPrefModal = closeModalLocal;

  // save changes
  if (saveBtn) {
    saveBtn.addEventListener('click', () => {
      const errEl = document.getElementById('jobprefModalError');
      const selected = Array.from(cards.filter(c => c.classList.contains('selected-card')))
        .map(c => (c.dataset.value || c.querySelector('h3')?.textContent || '').trim())
        .filter(Boolean);
      // validation: minimum 3, maximum 5 (same rules as job-preference-1)
      if (!selected || selected.length < 3) {
        if (errEl) errEl.innerHTML = '<span class="text-red-600">Please select at least 3 options.</span>';
        try { const m = modal?.querySelector('.grid'); if (m && m.animate) m.animate([{ transform: 'translateY(-6px)' }, { transform: 'translateY(0)' }], { duration: 220 }); } catch(e){}
        return;
      }
      if (selected.length > 5) {
        if (errEl) errEl.innerHTML = '<span class="text-red-600">Please select no more than 5 options.</span>';
        try { const m = modal?.querySelector('.grid'); if (m && m.animate) m.animate([{ transform: 'translateY(-6px)' }, { transform: 'translateY(0)' }], { duration: 220 }); } catch(e){}
        return;
      }
      if (errEl) errEl.innerHTML = '';
      if (hiddenInput) hiddenInput.value = JSON.stringify(selected);
      updateReviewSection(selected);
      closeModalLocal();
    });
  }

  // initial populate on load
  (function initialPopulate() {
    let saved = getSavedJobPrefs();
    if (!saved || !saved.length) {
      try { if (hiddenInput && hiddenInput.value) saved = normalizeArray(parseMaybeJson(hiddenInput.value)); } catch(e){}
    }
    const uniq = [...new Set((saved||[]).map(x => String(x||'').trim()).filter(Boolean))];
    updateReviewSection(uniq);
    try {
      const lcSet = new Set(uniq.map(u => u.toLowerCase()));
      cards.forEach(card => {
        const title = (card.querySelector('h3')?.textContent || card.dataset.value || '').trim();
        if (title && lcSet.has(title.toLowerCase())) card.classList.add('selected-card');
        else card.classList.remove('selected-card');
      });
    } catch(e){ console.debug('initial mark failed', e); }
  })();

  // sync on storage changes
  window.addEventListener('storage', (ev) => {
    const keys = [...STORAGE_KEYS, 'rpi_personal','registrationDraft','registerDraft'];
    if (!ev.key || keys.includes(ev.key)) {
      setTimeout(() => {
        try { const saved = getSavedJobPrefs(); updateReviewSection(saved); } catch(e){/*ignore*/ }
      }, 30);
    }
  });

});
</script>


        <!-- Continue Buttons -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12">
            <button id="rv5_continue" type="button"
                class="flex justify-center items-center gap-2 bg-[#2E2EFF] text-white text-lg font-semibold 
            px-10 py-4 rounded-2xl hover:bg-blue-600 active:scale-95 transition-all duration-200 
            shadow-md w-full sm:w-64 text-center">
                Continue →
            </button>
        </div>

        <!-- Helper Text -->
        <p class="text-gray-700 text-sm mt-4 text-center">
            Click <span class="text-[#1E40AF] font-medium">“Continue”</span> to move to the next page
        </p>
        <p class="text-gray-600 italic text-[13px] text-center">
            (Pindutin ang “Continue” upang magpatuloy)
        </p>
    </div>


    {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
    <script src="{{ asset('js/register.js') }}"></script>
    <script>
        // Focused helper: only extract explicit job preference arrays from the draft.
        (function(){
            window.tryParseMVSG = function(s){ try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
            window.getDraftJobPreferences = function(){
                try {
                    let draft = window.__mvsg_lastLoadedDraft || null;
                    if (!draft) {
                        const raw = localStorage.getItem('rpi_personal') || localStorage.getItem('registrationDraft') || localStorage.getItem('registerDraft') || sessionStorage.getItem('rpi_personal');
                        draft = raw ? window.tryParseMVSG(raw) : null;
                    }
                    const robustParseArray = (input) => {
                        try {
                            if (!input && input !== 0) return [];
                            // If already an array
                            if (Array.isArray(input)) return input.map(x=>String(x||'').trim()).filter(Boolean);
                            // Try repeated JSON.parse in case of double-stringified values
                            let cur = input;
                            for (let i=0;i<4;i++) {
                                if (cur === null || cur === undefined) return [];
                                if (Array.isArray(cur)) return cur.map(x=>String(x||'').trim()).filter(Boolean);
                                if (typeof cur !== 'string') break;
                                const s = cur.trim();
                                if (!s) return [];
                                try {
                                    cur = JSON.parse(s);
                                    continue;
                                } catch(e) {
                                    // not JSON — fall back
                                    break;
                                }
                            }
                            // If we reach here and cur is a string, split by comma safely
                            if (typeof cur === 'string') return cur.split(',').map(s=>s.trim()).filter(Boolean);
                            // If object with numeric/value fields, try to extract values
                            if (typeof cur === 'object' && cur !== null) {
                                const vals = [];
                                Object.values(cur).forEach(v => {
                                    if (Array.isArray(v)) v.forEach(x=>vals.push(String(x||'').trim()));
                                    else if (v !== undefined && v !== null) vals.push(String(v||'').trim());
                                });
                                return vals.filter(Boolean);
                            }
                        } catch(e) {}
                        return [];
                    };
                    // Only read these explicit keys. Do NOT attempt to flatten or iterate the entire draft object.
                    if (draft && draft.jobPreferences && draft.jobPreferences.jobpref1) return robustParseArray(draft.jobPreferences.jobpref1);
                    if (draft && draft.jobpref1) return robustParseArray(draft.jobpref1);
                    return [];
                } catch(e) { return []; }
            };
        })();
    </script>
    <script>
        // Early restore of job preferences from local draft so they appear even if populateReview runs later
        (function(){
            const tryParse = s => { try { return typeof s === 'string' ? JSON.parse(s) : s; } catch(e){ return null; } };
            // Strictly normalize only known job-preference shapes. Do NOT fallback to Object.values on full draft objects.
            const normalizeToArray = v => {
                try {
                    if (!v) return [];
                    if (Array.isArray(v)) return v.map(x=>String(x||'').trim()).filter(Boolean);
                    if (typeof v === 'object') {
                        // Accept explicit jobpref1 arrays or nested jobPreferences.jobpref1
                        if (Array.isArray(v.jobpref1)) return v.jobpref1.map(x=>String(x||'').trim()).filter(Boolean);
                        if (v.jobPreferences && Array.isArray(v.jobPreferences.jobpref1)) return v.jobPreferences.jobpref1.map(x=>String(x||'').trim()).filter(Boolean);
                        // If the object is itself a stringified array stored as a value, try to parse specific known keys
                        if (typeof v.jobpref1 === 'string') {
                            try { return (JSON.parse(v.jobpref1) || []).map(x=>String(x||'').trim()).filter(Boolean); } catch(e){}
                        }
                        if (typeof v.jobPreferences === 'string') {
                            try { const p = tryParse(v.jobPreferences); if (p && p.jobpref1) return normalizeToArray(p.jobpref1); } catch(e){}
                        }
                        return [];
                    }
                    const s = String(v||'').trim(); if (!s) return [];
                    if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('{') && s.endsWith('}'))) return normalizeToArray(tryParse(s));
                    if (s.includes(',')) return s.split(',').map(x=>x.trim()).filter(Boolean);
                    return [s];
                } catch(e){ return []; }
            };

            // Heuristic validation to avoid treating a stringified personal-info blob as preferences
            const isLikelyJobPrefArray = (arr) => {
                try {
                    if (!Array.isArray(arr)) return false;
                    // sane size: 1-8 preferences
                    if (arr.length === 0 || arr.length > 8) return false;
                    const emailRe = /\S+@\S+\.\S+/;
                    const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                    for (const it of arr) {
                        const s = String(it || '').trim();
                        if (!s) return false; // empty entry suspicious
                        if (emailRe.test(s)) return false;
                        if (phoneRe.test(s)) return false;
                        // if an item looks like a JSON object marker or '[object' it's suspicious
                        if (/\{.*\}|\[object /.test(s)) return false;
                        // overly long single items are suspicious (personal addresses, long JSON blobs)
                        if (s.length > 120) return false;
                    }
                    return true;
                } catch (e) { return false; }
            };

            const runRestore = function(){
                try {
                    // Simplified: prefer hidden input #jobpref1, then localStorage fallbacks
                    let arr = [];
                    try {
                        const hidden = document.getElementById('jobpref1');
                        if (hidden && hidden.value) {
                            const v = (hidden.value||'').trim();
                            if (v) {
                                if ((v.startsWith('[') && v.endsWith(']')) || (v.startsWith('{') && v.endsWith('}'))) arr = JSON.parse(v) || [];
                                else if (v.indexOf(',') !== -1) arr = v.split(',').map(s=>s.trim()).filter(Boolean);
                                else arr = [v];
                            }
                        }
                    } catch(e) { arr = []; }

                    if (!arr.length) {
                        const keys = ['jobPreferences','jobpref1','jobpref','jobpref_1','jobprefs','job_preferences'];
                        for (const k of keys) {
                            try {
                                const raw = localStorage.getItem(k);
                                if (!raw) continue;
                                const s = raw.trim();
                                if (!s) continue;
                                if (s.startsWith('[')) arr = JSON.parse(s) || [];
                                else if (s.indexOf(',') !== -1) arr = s.split(',').map(x=>x.trim()).filter(Boolean);
                                else arr = [s];
                            } catch(e) { arr = []; }
                            if (arr.length) break;
                        }
                    }

                    arr = Array.from(new Set((arr||[]).map(x=>String(x||'').trim()).filter(Boolean)));
                    const el = document.getElementById('review_jobprefs_list');
                    if (!el) return;
                    el.innerHTML = '';
                    if (!arr.length) {
                        const none = document.createElement('span'); none.className = 'text-gray-600'; none.textContent = 'None'; el.appendChild(none);
                    } else {
                        if (window.renderPillList) window.renderPillList('review_jobprefs_list', arr);
                        else for (const it of arr) { const sp = document.createElement('span'); sp.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm'; sp.textContent = it; el.appendChild(sp); }

                        // select matching cards (case-insensitive)
                        const lc = arr.map(s=>s.toLowerCase());
                        try { setChoiceImage && setChoiceImage('review_jobprefs_img', arr[0], ['.jobpref-card', '.selectable-card']); } catch(e){}
                        document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card=>{
                            try {
                                const title = (card.querySelector('h3')?.textContent||'').trim();
                                const v = (card.getAttribute('data-value')||'').trim();
                                const matched = (title && lc.includes(title.toLowerCase())) || (v && lc.includes(v.toLowerCase()));
                                if (matched) card.classList.add('selected'); else card.classList.remove('selected');
                            } catch(e){}
                        });
                    }
                } catch(e) { console.debug('[review-5] simplified restore failed', e); }
            };

            // initial run
            runRestore();
            // re-run when populate completes or storage changes
            window.addEventListener('mvsg:populateDone', function(){ setTimeout(runRestore, 10); });
            window.addEventListener('storage', function(){ setTimeout(runRestore, 20); });
        })();
    </script>

    <script>
        // Save the visible job preferences into localStorage['jobpref1'] then navigate
        function saveDraftAndGotoJobPrefs(url) {
            try {
                try {
                    const container = document.getElementById('review_jobprefs_list');
                    if (container) {
                        const spans = Array.from(container.querySelectorAll('span'));
                        const vals = spans.map(s => (s.textContent||'').trim()).filter(Boolean);
                        if (vals.length) {
                            // store canonical simple array under both jobPreferences (existing page key) and jobpref1 (review canonical)
                            try { localStorage.setItem('jobPreferences', JSON.stringify(vals)); } catch(e) { console.warn('[review-5] failed to write jobPreferences', e); }
                            try { localStorage.setItem('jobpref1', JSON.stringify(vals)); } catch(e) { console.warn('[review-5] failed to write jobpref1', e); }
                            // also mirror into hidden input if present
                            try { const h = document.getElementById('jobpref1'); if (h) h.value = JSON.stringify(vals); } catch(e){}
                        }
                    }
                } catch(e) { console.debug('[review-5] collect prefs failed', e); }
            } catch(e) { console.warn('[review-5] build draft failed', e); }

            try {
                window.location.href = url;
            } catch(e) { window.location.href = url; }
        }

        // document.addEventListener('DOMContentLoaded', function(){
        //     try {
        //         const btn = document.getElementById('rv5_change_jobprefs_btn');
        //         if (btn) btn.addEventListener('click', function(e){ e.preventDefault(); saveDraftAndGotoJobPrefs('{{ route('registerjobpreference1') }}'); });
        //     } catch(e) { console.debug('[review-5] wiring change button failed', e); }
        // });
    </script>
    <script>
        // Continue: collect visible prefs, save local draft, attempt Firestore write, then navigate
        (function(){
            // const normalizeSpans = (containerId) => {
            //     const container = document.getElementById(containerId);
            //     if (!container) return [];
            //     const spans = Array.from(container.querySelectorAll('span'));
            //     // filter out header placeholders like "Chosen Work" if present (heuristic: ignore exact 'Chosen Work')
            //     return spans.map(s => (s.textContent||'').trim()).filter(t => t && t.toLowerCase() !== 'chosen work');
            // };

            // const storePendingWrite = (uid, section, data) => {
            //     try {
            //         const all = JSON.parse(localStorage.getItem('pending_writes') || '{}');
            //         if (!all[uid]) all[uid] = {};
            //         all[uid][section] = { data };
            //         localStorage.setItem('pending_writes', JSON.stringify(all));
            //         console.info('[review-5] stored pending_writes for', uid, section);
            //     } catch (e) { console.warn('[review-5] storePendingWrite failed', e); }
            // };

            // const writeToFirestore = async (uid, prefs) => {
            //     // Firebase client removed: do not attempt Firestore writes from client. Return failure so caller can fallback to local store.
            //     return { ok: false, error: 'firebase-client-removed' };
            // };

            const btn = document.getElementById('rv5_continue');
            if (!btn) return;
            btn.addEventListener('click', async function(e){
                try {
                    e.preventDefault();
                    // const errEl = document.getElementById('jobpref1Error');
                    // // collect prefs from the rendered review list, fallback to draft
                    // let prefs = normalizeSpans('review_jobprefs_list');
                    // if (!prefs.length) {
                    //     try { prefs = (window.getDraftJobPreferences && window.getDraftJobPreferences()) || []; } catch(e) { prefs = []; }
                    // }
                    // // sanitize prefs to remove any personal-info or filenames that may have leaked into the draft
                    // const sanitizePrefs = (arr, draftObj) => {
                    //     try {
                    //         let a = (arr || []).map(x => String(x||'').trim()).filter(Boolean);
                    //         const emailRe = /\S+@\S+\.\S+/;
                    //         const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                    //         const fileExtRe = /\.(pdf|docx|doc|png|jpg|jpeg|gif)$/i;
                    //         const personalSet = new Set();
                    //         try {
                    //             const d = draftObj || (window.__mvsg_lastLoadedDraft || {});
                    //             const p = d.personalInfo || d.personal || d;
                    //             const addIf = v => { try { if (v !== undefined && v !== null) { const s = String(v).trim(); if (s) personalSet.add(s.toLowerCase()); } } catch(e){} };
                    //             if (p && typeof p === 'object') {
                    //                 addIf(p.first_name || p.first || p.firstName);
                    //                 addIf(p.last_name || p.last || p.lastName);
                    //                 addIf(p.email || p.emailAddress);
                    //                 addIf(p.phone || p.mobile);
                    //                 addIf(p.address || p.addr);
                    //             }
                    //             addIf(d.proofFilename || d.cert_file || d.certfile || d.proof || d.proofFilename);
                    //             addIf(d.role || d.userRole || d.roleName);
                    //         } catch(e) {}
                    //         a = a.filter(s => {
                    //             try {
                    //                 if (!s) return false;
                    //                 if (emailRe.test(s)) return false;
                    //                 if (phoneRe.test(s)) return false;
                    //                 if (fileExtRe.test(s)) return false;
                    //                 if (/\[object\s+object\]/i.test(s)) return false;
                    //                 if (personalSet.size && personalSet.has(s.toLowerCase())) return false;
                    //                 if (/^\d{1,3}$/.test(s)) return false;
                    //                 if (s.length > 120) return false;
                    //                 return true;
                    //             } catch(e) { return false; }
                    //         });
                    //         return [...new Set(a)];
                    //     } catch(e) { return (arr||[]).map(x=>String(x||'').trim()).filter(Boolean); }
                    // };
                    // prefs = sanitizePrefs(prefs, window.__mvsg_lastLoadedDraft || (localStorage.getItem('rpi_personal') ? JSON.parse(localStorage.getItem('rpi_personal')) : null));
                    // if (!prefs || prefs.length < 3) {
                    //     if (errEl) errEl.textContent = 'Please select at least 3 options.';
                    //     return;
                    // }
                    // if (prefs.length > 5) {
                    //     if (errEl) errEl.textContent = 'Please select no more than 5 options.';
                    //     return;
                    // }
                    // if (errEl) errEl.textContent = '';

                    // // build draft and persist locally
                    // try {
                    //     // Persist canonical canonical jobpref1 array for review pages and future restores
                    //     try { localStorage.setItem('jobpref1', JSON.stringify(prefs)); } catch(e) { console.warn('[review-5] could not write jobpref1', e); }
                    //     try { const h = document.getElementById('jobpref1'); if (h) h.value = JSON.stringify(prefs); } catch(e){}
                    //     console.info('[review-5] wrote jobpref1 with jobpref1', prefs);
                    // } catch (e) { console.warn('[review-5] could not persist jobpref1', e); }

                    // // Firebase client removed: skip client-side Firestore write. Local persistence was already done above.
                    // console.info('[review-5] firebase client removed; skipping Firestore write (local only)');

                    // // navigate to final step (do not attempt client-side firebase uid append)
                    try {
                        window.location.href = '{{ route('registerfinalstep') }}';
                    } catch (e) { window.location.href = '{{ route('registerfinalstep') }}'; }

                } catch (e) { console.error('[review-5] continue handler failed', e); }
            });
        })();
    </script>
    <script>
        // Use centralized populateReview and render job preferences as pills
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                if (typeof window.populateReview === 'function') {
                    await window.populateReview();
                }
            } catch (e) {
                console.debug('review-5: populateReview failed', e);
            }
                try {
                    const draft = window.__mvsg_lastLoadedDraft || {};
                    // Only pull explicit job preference keys using the centralized helper
                    let prefsRaw = [];
                    try { prefsRaw = (window.getDraftJobPreferences && window.getDraftJobPreferences()) || []; } catch(e) { prefsRaw = []; }
                    // If centralized helper returns nothing, fallback to canonical localStorage keys that the job-pref page writes
                    if ((!prefsRaw || prefsRaw.length === 0) && typeof localStorage !== 'undefined') {
                        const fallbackKeys = ['jobPreferences','jobpref1','jobpref','jobprefs','job_preferences'];
                        for (const k of fallbackKeys) {
                            try {
                                const raw = localStorage.getItem(k);
                                if (!raw) continue;
                                const s = raw.trim();
                                if (!s) continue;
                                if (s.startsWith('[')) {
                                    prefsRaw = JSON.parse(s) || [];
                                } else if (s.indexOf(',') !== -1) {
                                    prefsRaw = s.split(',').map(x=>x.trim()).filter(Boolean);
                                } else {
                                    // single value
                                    prefsRaw = [s];
                                }
                            } catch(e) { prefsRaw = []; }
                            if (prefsRaw && prefsRaw.length) break;
                        }
                    }

                // normalize final list (dedupe and trim)
                try {
                    prefsRaw = (prefsRaw || []).map(x => (typeof x === 'string' ? x.trim() : x)).filter(Boolean);
                    prefsRaw = [...new Set(prefsRaw)];

                    // Remove anything that clearly looks like personal info or uploaded filenames
                    const emailRe = /\S+@\S+\.\S+/;
                    const phoneRe = /\+?\d[\d\s\-()]{5,}\d/;
                    const fileExtRe = /\.(pdf|docx|doc|png|jpg|jpeg|gif)$/i;

                    // Build a set of known personal values from the draft to exclude (first/last/email/phone/address/proofFilename/role)
                    const personalSet = new Set();
                    try {
                        const d = draft || {};
                        const p = d.personalInfo || d.personal || d.personalInfo || d;
                        const addIf = v => { try { if (v !== undefined && v !== null) { const s = String(v).trim(); if (s) personalSet.add(s.toLowerCase()); } } catch(e){} };
                        if (p && typeof p === 'object') {
                            addIf(p.first_name || p.first || p.firstName);
                            addIf(p.last_name || p.last || p.lastName);
                            addIf(p.email || p.emailAddress);
                            addIf(p.phone || p.mobile);
                            addIf(p.address || p.addr);
                        }
                        addIf(d.proofFilename || d.cert_file || d.certfile || d.proof || d.proofFilename);
                        addIf(d.role || d.userRole || d.roleName);
                        // also include guardian names if present
                        const g = d.guardianInfo || d.guardian || {};
                        if (g && typeof g === 'object') { addIf(g.guardian_first_name || g.first_name || g.guardian_first); addIf(g.guardian_last_name || g.last_name || g.guardian_last); }
                    } catch(e) { /* ignore */ }

                    // Filter out suspicious entries
                    prefsRaw = prefsRaw.filter(item => {
                        try {
                            if (!item) return false;
                            const s = String(item).trim();
                            const low = s.toLowerCase();
                            if (emailRe.test(s)) return false;
                            if (phoneRe.test(s)) return false;
                            if (fileExtRe.test(s)) return false;
                            if (/\[object\s+object\]/i.test(s)) return false;
                            if (personalSet.size && personalSet.has(low)) return false;
                            // avoid entries that are single numeric age or long addresses
                            if (/^\d{1,3}$/.test(s)) return false;
                            if (s.length > 120) return false;
                            return true;
                        } catch (e) { return false; }
                    });
                } catch (e) { /* ignore */ }

                // Normalize and render using global helper if available
                if (window.renderPillList) {
                    window.renderPillList('review_jobprefs_list', prefsRaw);
                } else {
                    // fallback: simple comma text into the existing container
                    const el = document.getElementById('review_jobprefs_list');
                    if (el) {
                        el.innerHTML = '';
                        const items = Array.isArray(prefsRaw) ? prefsRaw : (typeof prefsRaw === 'string' ? prefsRaw.split(',').map(s=>s.trim()) : []);
                        if (!items.length) {
                            const none = document.createElement('span'); none.className = 'text-gray-600'; none.textContent = 'None'; el.appendChild(none);
                        } else {
                            for (const it of items) {
                                const sp = document.createElement('span');
                                sp.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                                sp.textContent = it;
                                el.appendChild(sp);
                            }
                        }
                    }
                }

                // Highlight matching jobpref cards and set preview image
                try {
                    const items = (Array.isArray(prefsRaw) ? prefsRaw : []).map(x => typeof x === 'string' ? x.trim() : x).filter(Boolean);
                    if (items.length) {
                        setChoiceImage('review_jobprefs_img', items[0], ['.jobpref-card', '.selectable-card']);
                        document.querySelectorAll('.jobpref-card, .selectable-card').forEach(card => {
                            const title = card.querySelector('h3')?.textContent?.trim();
                            if (title && items.includes(title)) card.classList.add('selected'); else card.classList.remove('selected');
                        });
                    }
                } catch(e) { /* ignore */ }
            } catch (e) {
                console.debug('review-5 render error', e);
            }
        });
    </script>
    <!-- TTS script: speaks English then Filipino; prefers Microsoft AvaMultilingual voice when available -->
    <script>
        (function(){
            const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
            let voices = [];
            let preferredEnglish = null;
            let preferredTagalog = null;

            function populateVoices() {
                voices = speechSynthesis.getVoices() || [];
                preferredEnglish = voices.find(v => v.name === preferredEnglishVoiceName) || voices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) || null;
                preferredTagalog = voices.find(v => v.name === preferredTagalogVoiceName) || voices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name)) || null;
            }

            function pickBest(list) {
                if (!list || !list.length) return null;
                const preferred = list.find(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
                return preferred || list[0];
            }

            function chooseVoiceForLang(langCode) {
                if (!voices.length) return null;
                langCode = (langCode || '').toLowerCase();
                if (langCode.startsWith('tl') || langCode.startsWith('fil')) {
                    if (preferredTagalog) return preferredTagalog;
                    const candidates = voices.filter(v => (v.lang||'').toLowerCase().startsWith('tl') || (v.lang||'').toLowerCase().startsWith('fil'));
                    return pickBest(candidates.length ? candidates : voices);
                }
                if (langCode.startsWith('en')) {
                    if (preferredEnglish) return preferredEnglish;
                    const candidates = voices.filter(v => (v.lang||'').toLowerCase().startsWith('en'));
                    return pickBest(candidates.length ? candidates : voices);
                }
                return preferredEnglish || voices[0] || null;
            }

            function stopSpeaking() {
                try { speechSynthesis.cancel(); document.querySelectorAll('.tts-btn.speaking').forEach(b=>b.classList.remove('speaking')); } catch(e){}
            }

            function startSequence(btn, en, tl) {
                stopSpeaking();
                if (!en && !tl) return;
                btn.classList.add('speaking'); btn.setAttribute('aria-pressed','true');
                const uEn = en ? new SpeechSynthesisUtterance(en) : null;
                const uTl = tl ? new SpeechSynthesisUtterance(tl) : null;
                if (uEn) { uEn.lang='en-US'; uEn.voice = chooseVoiceForLang('en') || null; }
                if (uTl) { uTl.lang='tl-PH'; uTl.voice = chooseVoiceForLang('tl') || chooseVoiceForLang('en') || null; }
                const finalize = () => { btn.classList.remove('speaking'); btn.removeAttribute('aria-pressed'); };
                if (uEn && uTl) { uEn.onend = () => { setTimeout(()=>speechSynthesis.speak(uTl), 160); }; uTl.onend = finalize; uEn.onerror = uTl.onerror = finalize; speechSynthesis.speak(uEn); }
                else if (uEn) { uEn.onend = finalize; uEn.onerror = finalize; speechSynthesis.speak(uEn); }
                else if (uTl) { uTl.onend = finalize; uTl.onerror = finalize; speechSynthesis.speak(uTl); }
            }

            const init = () => {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = populateVoices;
                document.querySelectorAll('.tts-btn').forEach(b => {
                    b.addEventListener('click', ()=>{ if (b.classList.contains('speaking')) { stopSpeaking(); return; } startSequence(b, b.getAttribute('data-tts-en')||'', b.getAttribute('data-tts-tl')||''); });
                    b.addEventListener('keydown', ev=>{ if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); b.click(); } });
                });
                window.addEventListener('beforeunload', stopSpeaking);
            };

            if (document.readyState === 'complete' || document.readyState === 'interactive') init(); else document.addEventListener('DOMContentLoaded', init);
        })();
    </script>
</body>

</html>
