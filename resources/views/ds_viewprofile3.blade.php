@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-6 px-6 sm:px-10 lg:px-24">
            <div class="flex justify-start items-center space-x-3 max-w-[1600px] mx-auto">
                <a href="/viewprofile2"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back</span>
                </a>
            </div>
        </div>


        <!-- Profile Section -->
        <section class="max-w-[1600px] mx-auto px-10 py-14 space-y-12">

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <div class="bg-blue-800 text-white flex items-center gap-12 px-8 py-10 rounded-t-2xl">
                    <div id="profile_initials"
                        class="bg-white text-blue-800 font-bold rounded-full w-24 h-24 flex items-center justify-center text-3xl">
                        JD
                    </div>
                    <div>
                        <h1 id="profile_fullname" class="text-2xl font-semibold">Juan Dela Cruz</h1>
                        <p id="profile_location" class="flex items-center gap-3 text-lg mt-2">
                            <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location" class="w-6 h-6">
                            <span id="profile_location_text">Taguig City, Metro Manila</span>
                        </p>
                        <p class="flex items-center gap-4 text-base mt-2">
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" alt="Email Icon" class="w-5 h-5">
                            <span id="profile_header_email">juancruz@gmail.com</span>
                        </p>
                    </div>
                </div>

                <div class="p-10 space-y-14">

<!-- Skills Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Your Skills</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Selected Skills -->
                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div id="review_skills_list" class="flex flex-wrap gap-3 mb-6">

                                    <!-- Tags (empty for now) -->
                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                </div>
                            </div>

                        </div>

                        <!-- Edit Skills Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button id="rv4_change_skills_btn" type="button"
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

<!-- Job Preference Info -->
                    <section class="">
                        <h3 class="text-blue-800 text-3xl font-bold mb-8">Your Job Preferences</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Selected Jobs -->
                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div id="review_jobprefs_img_container" class="flex flex-wrap gap-3 mb-6">

                                    <!-- Tags (empty for now) -->
                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                </div>
                            </div>

                        </div>

                        <!-- Edit Job Preference Button -->
                        <div class="flex flex-col items-end mt-10 space-y-2">
                            <p class="text-lg text-gray-600">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button id="rv5_change_jobprefs_btn" type="button"
                                class="bg-green-500 text-white px-32 py-4 rounded-xl text-xl font-semibold shadow hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>

        </section>

    <!--  SKILLS EDIT MODAL -->

<div id="editSkillsModal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center 
            z-[9999] transition-opacity duration-300 opacity-0">

<div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 max-w-5xl w-[95%] max-h-[90vh] 
            overflow-y-auto border border-gray-200 relative scale-95 transition-all duration-300">

    <!-- Title -->
    <h2 class="text-center text-1xl sm:text-2xl font-extrabold text-gray-800">
        What skills do you have or feel confident doing?
    </h2>
    <p class="text-center text-gray-500 italic mt-1">
        (Anong mga kakayahan ang kaya mong gawin o komportable ka?)
    </p>

    <!-- Yellow Note -->
    <div class="bg-yellow-100 border border-yellow-300 rounded-xl p-4 mt-6 text-center shadow-sm">
        <p class="font-semibold text-yellow-900">You can choose more than one option</p>
        <p class="text-yellow-800 italic text-sm">(Puwede kang pumili ng higit sa isa)</p>
    </div>

    <!-- Skills Cards Grid -->
    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

        <!-- Card 1 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Following Instructions">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Following Instructions:I can follow easy steps one at a time." 
                data-tts-tl="Kaya kong sundin ang simple, step-by-step na utos">🔊</button>
            <img src="image/skill1.png" alt="following instructions" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Following Instructions</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can follow easy steps one at a time.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong sundin ang simple, step-by-step na utos)</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Communication Skills">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Communication Skills: I can greet people, talk in a simple way, and answer Yes or No." 
                data-tts-tl="Kaya kong bumati (“Hello/Good morning”), makipag-usap nang simple, at sumagot ng Yes/No">🔊</button>
            <img src="image/skill2.png" alt="communication skills" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Communication Skills</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can greet people, talk in a simple way, and answer Yes or No.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong bumati (“Hello/Good morning”), makipag-usap nang simple, at sumagot ng Yes/No)</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Social Interaction">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Social Interaction: I can be polite, friendly, and talk nicely to other people." 
                data-tts-tl="Ako ay magalang, friendly, at kaya kong makipag-usap sa ibang tao o customers">🔊</button>
            <img src="image/skill3.png" alt="social interaction" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Social Interaction</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can be polite, friendly, and talk nicely to other people.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Ako ay magalang, friendly, at kaya kong makipag-usap sa ibang tao o customers)</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Physical Ability">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Physical Ability: I can stand, walk, and carry light things." 
                data-tts-tl="Kaya kong tumayo, maglakad, at magbuhat ng magagaan na gamit">🔊</button>
            <img src="image/skill4.png" alt="physical ability" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Physical Ability</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can stand, walk, and carry light things.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong tumayo, maglakad, at magbuhat ng magagaan na gamit)</p>
        </div>

        <!-- Card 5 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Attention to Task">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Attention to Task: I can stay focused and finish my task." 
                data-tts-tl="Kaya kong mag-focus at tapusin ang trabaho nang tuloy-tuloy">🔊</button>
            <img src="image/skill5.png" alt="attention to task" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Attention to Task</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can stay focused and finish my task.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong mag-focus at tapusin ang trabaho nang tuloy-tuloy)</p>
        </div>

        <!-- Card 6 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Task Repetition">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Task Repetition: I can repeat the same task many times, like arranging items." 
                data-tts-tl="Kaya kong ulit-ulitin ang gawain tulad ng pag-aayos ng products">🔊</button>
            <img src="image/skill6.png" alt="task repetition" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Task Repetition</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can repeat the same task many times, like arranging items.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya kong ulit-ulitin ang gawain tulad ng pag-aayos ng products)</p>
        </div>

        <!-- Card 7 -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Trainable">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Trainable: I can learn new tasks when someone teaches me step by step." 
                data-tts-tl="Kaya ko matuto kapag may nagtuturo sa akin nang simple">🔊</button>
            <img src="image/skill7.png" alt="trainable" class="w-full rounded-md mb-4">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Trainable</h3>
            <p class="text-[13px] text-black-600 text-center mt-2">I can learn new tasks when someone teaches me step by step.</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-2">(Kaya ko matuto kapag may nagtuturo sa akin nang simple)</p>
        </div>

        <!-- Other -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 shadow-md hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
            data-value="Other">
            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                data-tts-en="Other, Type your answer inside the box if not in the choices" 
                data-tts-tl="Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian">🔊</button>
            <h3 class="text-blue-700 font-bold text-lg mb-2">Other</h3>
            <p class="text-sm text-center mt-2">Type your answer if not in the choices</p>
            <p class="text-[13px] text-gray-600 italic text-center mt-1">(Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)</p>
            <input id="skills_other_input" type="text" placeholder="Type your answer here"
                class="w-full border border-gray-300 rounded-lg p-2 text-sm mt-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>
    </div>

   

    <!-- Buttons -->
    <div class="flex justify-center gap-6 mt-10">
        <button id="closeSkillsModal"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl 
                       hover:bg-red-700 transition shadow-sm">
            Cancel
        </button>

        <button id="saveSkillsEdit"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl 
                       hover:bg-blue-700 transition shadow-sm">
            Save Changes
        </button>
    </div>
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
document.addEventListener('DOMContentLoaded', () => {
    function el(id){ return document.getElementById(id); }

    // fetch profile first and populate header, then fetch user-work
    fetch('/db/get_profile.php', { credentials: 'same-origin' })
    .then(r => r.json())
    .then(profileResp => {
        if (!profileResp || !profileResp.success) return;
        const u = profileResp.user || {};

        // populate header (same IDs as viewprofile1/2)
        const initialsEl = el('profile_initials');
        const fullnameEl = el('profile_fullname');
        const locationTextEl = el('profile_location_text');
        const headerEmailEl = el('profile_header_email');

        const fn = (u.FIRST_NAME || u.first_name || '').toString().trim();
        const ln = (u.LAST_NAME || u.last_name || '').toString().trim();
        const fullname = (fn + ' ' + ln).trim();
        if (fullnameEl && fullname) fullnameEl.textContent = fullname;

        let initials = '';
        if (fn) initials += fn.charAt(0);
        if (ln) initials += ln.charAt(0);
        if (!initials) initials = (u.USERNAME || u.EMAIL || '').toString().slice(0,2);
        if (initialsEl) initialsEl.textContent = initials.toUpperCase();

        if (locationTextEl) locationTextEl.textContent = (u.ADDRESS || u.address || '') || '—';
        if (headerEmailEl) headerEmailEl.textContent = (u.EMAIL || u.email || '') || '';

        const gid = u.ID || u.id || u.USER_ID || u.GUARDIAN_ID || u.guardian_id;
        if (!gid) return;

        return fetch('/db/get-user-work.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ guardian_id: gid })
        });
    })
    .then(r => { if (!r) return; return r.json(); })
    .then(data => {
        if (!data || !data.success) return;
        const profiles = data.profiles || {};
        const skills = profiles.skills || [];
        const jobprefs = profiles.job_preference || [];

        const skillsContainer = el('review_skills_list');
        const jobsContainer = el('review_jobprefs_img_container');

        if (skillsContainer) {
            skillsContainer.innerHTML = '';
            if (skills.length) {
                skills.forEach(s => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = s;
                    skillsContainer.appendChild(span);
                });
            } else {
                skillsContainer.innerHTML = '<p class="text-gray-600 italic">No skills selected.</p>';
            }
        }

        if (jobsContainer) {
            jobsContainer.innerHTML = '';
            if (jobprefs.length) {
                jobprefs.forEach(j => {
                    const span = document.createElement('span');
                    span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
                    span.textContent = j;
                    jobsContainer.appendChild(span);
                });
            } else {
                jobsContainer.innerHTML = '<p class="text-gray-600 italic">No job preferences selected.</p>';
            }
        }
    })
    .catch(err => console.error('profile->work fetch error', err));
});
</script>

<script>
// filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_viewprofile3.blade.php
document.addEventListener('DOMContentLoaded', () => {
    const skillsModal = document.getElementById('editSkillsModal');
    const jobModal = document.getElementById('jobPrefModal');
    const editSkillsBtn = document.querySelector('[id^="rv4_change_skills_btn"], #rv4_change_skills_btn, button[data-open="skills"]');
    const editJobBtn = document.querySelector('[id^="rv5_change_jobprefs_btn"], #rv5_change_jobprefs_btn, button[data-open="jobprefs"]');
    const saveSkillsBtn = document.getElementById('saveSkillsEdit');
    const closeSkillsBtn = document.getElementById('closeSkillsModal');
    const saveJobBtn = document.getElementById('saveJobPrefEdit');
    const cancelJobBtn = document.getElementById('cancelJobPrefEdit');

    const skillsCards = Array.from(document.querySelectorAll('.skills-card, .selectable-card'));
    const jobCards = Array.from(document.querySelectorAll('.jobpref-card, .selectable-card'));
    const reviewSkillsList = document.getElementById('review_skills_list');
    const reviewJobPrefsList = document.getElementById('review_jobprefs_list') || document.getElementById('review_jobprefs_img_container');

    function openModal(modal) {
        if (!modal) return;
        modal.classList.remove('hidden');
        document.documentElement.style.overflow = 'hidden';
        setTimeout(()=> modal.classList.remove('opacity-0'), 10);
    }
    function closeModal(modal) {
        if (!modal) return;
        modal.classList.add('opacity-0');
        setTimeout(()=> {
            modal.classList.add('hidden');
            document.documentElement.style.overflow = '';
        }, 200);
    }

    function resetCards(cards){
        cards.forEach(c => c.classList.remove('selected-card','selected'));
    }
    function preselectFromReview(cards, reviewEl){
        resetCards(cards);
        if (!reviewEl) return;
        const items = Array.from(reviewEl.querySelectorAll('span')).map(s => (s.textContent||'').trim()).filter(Boolean);
        const lc = new Set(items.map(i => i.toLowerCase()));
        cards.forEach(c => {
            const v = (c.dataset.value || c.querySelector('h3')?.textContent || '').trim();
            if (v && lc.has(v.toLowerCase())) c.classList.add('selected-card');
        });
    }

    // toggle handlers
    skillsCards.forEach(c => {
        c.addEventListener('click', (e) => {
            if (e.target && e.target.classList && e.target.classList.contains('tts-btn')) return;
            c.classList.toggle('selected-card');
        });
    });
    jobCards.forEach(c => {
        c.addEventListener('click', (e) => {
            if (e.target && e.target.classList && e.target.classList.contains('tts-btn')) return;
            c.classList.toggle('selected-card');
        });
    });

    // open editors
    if (editSkillsBtn) editSkillsBtn.addEventListener('click', (e) => { e.preventDefault(); preselectFromReview(skillsCards, reviewSkillsList); openModal(skillsModal); });
    if (editJobBtn) editJobBtn.addEventListener('click', (e) => { e.preventDefault(); preselectFromReview(jobCards, reviewJobPrefsList); openModal(jobModal); });

    if (closeSkillsBtn) closeSkillsBtn.addEventListener('click', () => closeModal(skillsModal));
    if (cancelJobBtn) cancelJobBtn.addEventListener('click', () => closeModal(jobModal));

    async function postPayload(payload){
        try {
            const r = await fetch('/db/editprofile-3.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {'Content-Type':'application/json'},
                body: JSON.stringify(payload)
            });
            let j = null;
            try { j = await r.json(); } catch(e) { return {ok:false, parsed:false, respText: await r.text()}; }
            return { ok: r.ok, body: j };
        } catch (err) {
            return { ok:false, error: err.message || String(err) };
        }
    }

    function updateReviewListFromArray(el, arr){
        if (!el) return;
        el.innerHTML = '';
        if (!arr || !arr.length) {
            el.innerHTML = '<span class="text-gray-600">—</span>';
            return;
        }
        arr.forEach(v => {
            const span = document.createElement('span');
            span.className = 'bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm';
            span.textContent = v;
            el.appendChild(span);
        });
    }

    // Save skills
    if (saveSkillsBtn) {
        saveSkillsBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const sel = skillsCards.filter(c => c.classList.contains('selected-card')).map(c => (c.dataset.value || c.querySelector('h3')?.textContent || '').trim()).filter(Boolean);
            // also include typed Other input if present
            const otherCard = skillsCards.find(c => (c.dataset.value||'').toLowerCase()==='other' || (c.querySelector('h3')?.textContent||'').toLowerCase()==='other');
            if (otherCard) {
                const inp = otherCard.querySelector('input[type="text"], #skills_other_input');
                if (inp && inp.value.trim()) sel.push(inp.value.trim());
            }
            saveSkillsBtn.disabled = true;
            const res = await postPayload({ skills: sel });
            saveSkillsBtn.disabled = false;
            if (res.ok && res.body && res.body.success) {
                updateReviewListFromArray(reviewSkillsList, sel);
                closeModal(skillsModal);
            } else {
                console.error('Save skills failed', res);
                alert('Unable to save skills.\n' + (res.body && res.body.error ? res.body.error : (res.error || 'Server error')));
            }
        });
    }

    // Save job preferences
    if (saveJobBtn) {
        saveJobBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const sel = jobCards.filter(c => c.classList.contains('selected-card')).map(c => (c.dataset.value || c.querySelector('h3')?.textContent || '').trim()).filter(Boolean);
            saveJobBtn.disabled = true;
            const res = await postPayload({ job_preference: sel });
            saveJobBtn.disabled = false;
            if (res.ok && res.body && res.body.success) {
                updateReviewListFromArray(reviewJobPrefsList, sel);
                closeModal(jobModal);
            } else {
                console.error('Save jobprefs failed', res);
                alert('Unable to save job preferences.\n' + (res.body && res.body.error ? res.body.error : (res.error || 'Server error')));
            }
        });
    }

    // ensure initial visual selection in cards matches pre-rendered review lists
    try {
        preselectFromReview(skillsCards, reviewSkillsList);
        preselectFromReview(jobCards, reviewJobPrefsList);
    } catch(e){}
});
</script>
    </main>
@endsection
