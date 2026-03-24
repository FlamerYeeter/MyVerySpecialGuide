<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Skills</title>
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
    
    .skills-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.25s ease, border 0.2s ease;
        will-change: transform, box-shadow;
        border: 1px solid #d1d5db; 
    }

    .skills-card:hover {
        transform: translateY(-4px);
        border-color: #9ca3af; 
    }

    .skills-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
    .skills-card.disabled {
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
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerworkplace') }}')">
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
                            data-tts-en="Please choose the skills you’re good at! Which ones do you feel confident using? Your choices will help us recommend the best opportunities for you."
                            data-tts-tl="Piliin mo ang mga kasanayan na kaya mo o sanay ka! Alin sa mga ito ang komportable kang gamitin? Makakatulong ang sagot mo para ma-rekomenda namin ang pinakaakmang oportunidad para sa’yo.">
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
                    Please choose the skills you’re good at! Which ones do you feel confident using? Your choices will help us recommend the best opportunities for you.
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Piliin mo ang mga kasanayan na kaya mo o sanay ka! Alin sa mga ito ang komportable kang gamitin? Makakatulong ang sagot mo para ma-rekomenda namin ang pinakaakmang oportunidad para sa’yo.)
                    </p>
                
                 <!-- Mobile Audio Button -->
                    <div class="mt-3 flex justify-center sm:hidden">
                        <button type="button" aria-label="Play audio for info section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                            transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please choose the skills you’re good at! Which ones do you feel confident using? Your choices will help us recommend the best opportunities for you."
                            data-tts-tl="Piliin mo ang mga kasanayan na kaya mo o sanay ka! Alin sa mga ito ang komportable kang gamitin? Makakatulong ang sagot mo para ma-rekomenda namin ang pinakaakmang oportunidad para sa’yo.">
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
                    What skills do you have?
                    </h2>
                    <p class="text-gray-700 italic text-md mt-2">
                    (Anong mga kasanayan ang meron ka?)
                    </p>
                </div>
                <!-- Audio Button -->
                <button type="button" 
                    class="bg-[#1E40AF] hover:bg-blue-700 text-white p-2 sm:p-3 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400"
                    data-tts-en="What skills do you have? Choose the images below that show the skills you have. You can choose more than one if it fits" 
                        data-tts-tl="Anong mga kasanayan ang meron ka? Piliin ang mga larawan sa ibaba na nagpapakita ng mga kasanayan na meron ka.
                        Pwede kang pumili ng higit sa isa kung bagay sa’yo!"
                    aria-label="Play audio for question">
                    🔊
                </button>
                </div>

                <!-- Instruction Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8 shadow border border-blue-100 mb-10 max-w-3xl mx-auto sm:mx-0">
                <p class="text-base sm:text-lg font-medium text-gray-800 leading-relaxed">
                    Choose the images below that show the 
                    <span class="text-blue-700 font-semibold">skills</span> you have. You can choose more than one if it fits!
                </p>
                <div class="border-t border-gray-200 my-4"></div>
                <p class="text-sm sm:text-base text-gray-700 italic">
                    (Piliin ang mga larawan sa ibaba na nagpapakita ng mga
                    <span class="font-semibold text-blue-700">kasanayan</span> na meron ka. Pwede kang pumili ng higit sa isa kung bagay sa’yo!)
                </p>
                </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">


                <!-- Card 1 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Following Instructions"
                    onclick="toggleSkills1Choice(this,'Following Instructions')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Following Instructions:I can follow easy steps one at a time Example: Following a recipe to make a sandwich" 
                        data-tts-tl="Kaya kong sundin ang simple, step-by-step na utos" aria-label="Play audio for Good at talking to people">🔊</button>
                    <img src="image/skill1.png" alt="following instructions" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Following Instructions</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can follow easy steps one at a time.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Following a recipe to make a sandwich</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Kaya kong sundin ang simple, step-by-step na utos)</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Communication Skills" onclick="toggleSkills1Choice(this,'Communication Skills')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Communication Skills: I can greet people, talk in a simple way, and answer Yes or No Example: Saying Hello and Thank you to customers" 
                        data-tts-tl="Kaya kong bumati (“Hello/Good morning”), makipag-usap nang simple, at sumagot ng Yes/No" aria-label="Play audio for Using Computer">🔊</button>
                    <img src="image/skill2.png" alt="communication skills" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Communication Skills</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can greet people, talk in a simple way, and answer Yes or No.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Saying "Hello" and "Thank you" to customers</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Kaya kong bumati ("Hello/Good morning"), makipag-usap nang simple, at sumagot ng Yes/No)</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Social Interaction" onclick="toggleSkills1Choice(this,'Social Interaction')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Social Interaction: I can be polite, friendly, and talk nicely to other people Example: Helping customers find what they need" 
                        data-tts-tl="Ako ay magalang, friendly, at kaya kong makipag-usap sa ibang tao o customers" aria-label="Play audio for Organizing things">🔊</button>
                    <img src="image/skill3.png" alt="social interaction" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Social Interaction</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can be polite, friendly, and talk nicely to other people.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Helping customers find what they need</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Ako ay magalang, friendly, at kaya kong makipag-usap sa ibang tao o customers)</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Physical Ability" onclick="toggleSkills1Choice(this,'Physical Ability')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Physical Ability: I can stand, walk, and carry light things Example: Carrying trays or organizing shelves" 
                        data-tts-tl="Kaya kong tumayo, maglakad, at magbuhat ng magagaan na gamit" aria-label="Play audio for Working with others">🔊</button>
                    <img src="image/skill4.png" alt="physical ability" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Physical Ability</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can stand, walk, and carry light things.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Carrying trays or organizing shelves</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Kaya kong tumayo, maglakad, at magbuhat ng magagaan na gamit)</p>
                </div>

                <!-- Card 5 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Attention to Task" onclick="toggleSkills1Choice(this,'Attention to Task')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Attention to Task: I can stay focused and finish my taskExample: Completing a checklist of daily tasks" 
                        data-tts-tl="Kaya kong mag-focus at tapusin ang trabaho nang tuloy-tuloy" aria-label="Play audio for Art and creativity">🔊</button>
                    <img src="image/skill5.png" alt="attention to task" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Attention to Task</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can stay focused and finish my task.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Completing a checklist of daily tasks</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center">(Kaya kong mag-focus at tapusin ang trabaho nang tuloy-tuloy)</p>
                </div>

                <!-- Card 6 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Task Repetition" onclick="toggleSkills1Choice(this,'Task Repetition')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Task Repetition: I can repeat the same task many times, like arranging items Example: Sorting and folding laundry repeatedly" 
                        data-tts-tl="Kaya kong ulit-ulitin ang gawain tulad ng pag-aayos ng products" aria-label="Play audio for Helping people">🔊</button>
                    <img src="image/skill6.png" alt="task repetition" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Task Repetition</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can repeat the same task many times, like arranging items.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Sorting and folding laundry repeatedly</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center">(Kaya kong ulit-ulitin ang gawain tulad ng pag-aayos ng products)</p>
                </div>

                <!-- Card 7 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="Trainable" onclick="toggleSkills1Choice(this,'Trainable')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Trainable: I can learn new tasks when someone teaches me step by step Example: Learning to operate a cash register with guidance" 
                        data-tts-tl="Kaya ko matuto kapag may nagtuturo sa akin nang simple" aria-label="Play audio for Attention to details">🔊</button>
                    <img src="image/skill7.png" alt="attention to details" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Trainable</h3>
                     <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">I can learn new tasks when someone teaches me step by step.</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center mt-1">Example: Learning to operate a cash register with guidance</p>
                    <p class="text-xs sm:text-sm text-gray-600 italic text-center">(Kaya ko matuto kapag may nagtuturo sa akin nang simple)</p>
                </div>

                <!-- Other -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center skills-card"
                    data-value="other" onclick="toggleSkills1Choice(this,'other')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Other,  Type your answer and press enter inside the box if not in the choices" 
                        data-tts-tl="Isulat ang sagot at pindutin ang enter sa loob ng kahon kung wala sa pagpipilian" aria-label="Play audio for Other option">🔊</button>
                    <h3 id="skills1_other_label" class="text-blue-600 font-semibold text-center mb-1">Other</h3>
                    <p class="mt-2 text-sm text-justify">
                         Type your answer and press enter inside the box if not in the choices
                    </p>
                    <label for="skills1_other_text" class="sr-only">Type your other answer here</label>
                    <p class="text-[13px] text-gray-600 italic mt-1 mb-1 text-justify">
                        (Isulat ang sagot at pindutin ang enter sa loob ng kahon kung wala sa pagpipilian)
                    </p>
                    <div id="skills1_other_chips" class="flex flex-wrap gap-2 mb-1"></div>
                    <input id="skills1_other_text" name="skills1_other_text" type="text"
                        aria-labelledby="skills1_other_label" placeholder="Type your answer here (press Enter to add)"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <div id="skills1_suggestions" class="suggestions-container mt-1">
                        <ul id="skills1_suggestions_list" class="suggestions-list hidden"></ul>
                    </div>
                </div>
            </div>

            <input id="skills_page1" type="hidden" value="[]" />
    </div>
            <!-- Next Button -->
            <div class="flex flex-col items-center justify-center mt-6 mb-6 space-y-3 px-2">
                <div id="skills1Error" class="text-red-600 text-sm text-center"></div>
                <button id="skills1Next" type="button"
                    class="w-full sm:w-auto bg-[#2E2EFF] text-white text-lg sm:text-2xl font-semibold px-6 sm:px-16 md:px-28 py-3 sm:py-4 rounded-2xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Next →
                </button>
                <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
                        Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue <br class="hidden sm:block">
                       <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
                </p>
            </div>

            <!-- ensure shared register logic is available so the Next button is handled and autofill runs -->
            <script src="{{ asset('js/register.js') }}"></script>

            <script>
                // Simplified restore: prefer the hidden input, then fall back to a few localStorage keys.
                document.addEventListener('DOMContentLoaded', function() {
                    try {
                        const hidden = document.getElementById('skills_page1');
                        if (!hidden) return;

                        let arr = [];
                        // 1) try hidden input value
                        try {
                            const v = (hidden.value || '').trim();
                            if (v) {
                                if ((v.startsWith('[') && v.endsWith(']')) || (v.startsWith('{') && v.endsWith('}'))) {
                                    arr = JSON.parse(v) || [];
                                } else if (v.indexOf(',') !== -1) {
                                    arr = v.split(',').map(s=>s.trim()).filter(Boolean);
                                } else if (v) {
                                    arr = [v];
                                }
                            }
                        } catch(e) { arr = []; }

                        // 2) fallback: localStorage keys
                        if (!arr.length) {
                            const keys = ['skills_page1','skills','selected_skills','selectedSkills'];
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

                        // normalize and dedupe
                        arr = Array.from(new Set((arr||[]).map(x=>String(x||'').trim()).filter(Boolean)));
                        if (!arr.length) return;

                        // write back to hidden for other scripts
                        hidden.value = JSON.stringify(arr);

                        // select matching cards (case-insensitive match against data-value or h3 text)
                        const lc = arr.map(s => s.toLowerCase());
                        document.querySelectorAll('.skills-card[data-value]').forEach(card => {
                            try {
                                const v = (card.getAttribute('data-value') || '').trim();
                                const title = (card.querySelector('h3')?.textContent || '').trim();
                                const matched = lc.includes(String(v||'').toLowerCase()) || lc.includes(String(title||'').toLowerCase());
                                if (matched) card.classList.add('selected'); else card.classList.remove('selected');
                            } catch(e){}
                        });
                    } catch(e) { console.debug('skills restore failed', e); }
                });
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

            <!-- existing toggleSkills1Choice + init script relies on register.js being present earlier -->
            <script>
                // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_skills-1.blade.php
                // Toggle handler for multi-select skills on page 1
                function toggleSkills1Choice(el, value) {
                    try {
                        const hidden = document.getElementById('skills_page1');
                        if (!hidden) return;
                        let arr = [];
                        try {
                            arr = JSON.parse(hidden.value || '[]');
                        } catch (e) {
                            arr = [];
                        }
                        const idx = arr.indexOf(value);
                        if (idx === -1) {
                            arr.push(value);
                            if (el && el.classList) el.classList.add('selected');
                        } else {
                            arr.splice(idx, 1);
                            if (el && el.classList) el.classList.remove('selected');
                        }
                        hidden.value = JSON.stringify(arr);
                        // focus "other" input when selected
                        /*if (value === 'other') {
                            const other = document.getElementById('skills1_other_text');
                            if (other && arr.indexOf('other') !== -1) other.focus();
                        }*/
                        const err = document.getElementById('skills1Error');
                        if (err) err.textContent = '';
                    } catch (e) {
                        console.error('toggleSkills1Choice error', e);
                    }
                }

                // On load: pre-select cards based on hidden input (useful for autofill/local drafts)
                document.addEventListener('DOMContentLoaded', function() {
                    try {
                        const hidden = document.getElementById('skills_page1');
                        if (!hidden) return;
                        let arr = [];
                        try {
                            arr = JSON.parse(hidden.value || '[]');
                        } catch (e) {
                            arr = [];
                        }
                        if (!Array.isArray(arr)) arr = [];
                        document.querySelectorAll('.skills-card[data-value]').forEach(c => {
                            try {
                                const v = c.getAttribute('data-value');
                                if (v && arr.indexOf(v) !== -1) c.classList.add('selected');
                                else c.classList.remove('selected');
                            } catch (e) {
                                /* ignore */
                            }
                        });
                        // if 'other' preselected, focus its input
                        if (arr.indexOf('other') !== -1) {
                            const other = document.getElementById('skills1_other_text');
                            if (other) other.focus();
                        }
                    } catch (e) {
                        console.warn('skills_page1 init failed', e);
                    }
                });
                // Autosuggest for "Other" input: populate from existing skill cards
                document.addEventListener('DOMContentLoaded', function(){
                    try{
                        const input = document.getElementById('skills1_other_text');
                        const listEl = document.getElementById('skills1_suggestions_list');
                        const container = document.getElementById('skills1_suggestions');
                        if (!input || !listEl || !container) return;

                        // Build pool of skill values (exclude 'other')
                        const pool = Array.from(document.querySelectorAll('.skills-card[data-value]')).map(card=>{
                            return { value: (card.getAttribute('data-value')||'').trim(), title: (card.querySelector('h3')?.textContent||'').trim(), card };
                        }).filter(x=>x.value && x.value.toLowerCase()!=='other');

                        // Additional suggestions (not present as cards). Edit this list to add more.
                        const extraSuggestions = [
                            'Using Computer',
                            'Organizing Things',
                            'Helping People',
                            'Art & Creativity',
                            'Attention to Details',
                            'Working With Others',
                            'Problem Solving',
                            'Time Management',
                            'Customer Service',
                            'Cash Handling',
                            'Cleaning',
                            'Cooking',
                            'Inventory Counting',
                            'Stocking Shelves',
                            'Basic Sewing',
                            'Gardening',
                            'Packaging',
                            'Delivery Assistance',
                            'Data Entry',
                            'Typing',
                            'Basic Math',
                            'Retail Sales',
                            'Order Picking',
                            'Machine Operation',
                            'Forklift Operation',
                            'Quality Inspection',
                            'Labeling',
                            'Telephone Handling',
                            'Scheduling',
                            'Basic First Aid',
                            'Language Skills (Tagalog)',
                            'Language Skills (English)',
                            'Translation',
                            'Cashiering',
                            'Sales Assistance',
                            'Merchandising',
                            'Basic Carpentry',
                            'Painting',
                            'Electrical Help',
                            'Plumbing Assistance',
                            'Phone Support',
                            'Social Media',
                            'Photography',
                            'Video Editing',
                            'Graphic Design',
                            'Teaching Assistance',
                            'Childcare',
                            'Elderly Care',
                            'Personal Care',
                            'Laundry',
                            'Packing & Shipping',
                            'Warehouse Management',
                            'Order Fulfillment',
                            'Route Assistance',
                            'Basic Accounting',
                            'Bookkeeping',
                            'Data Analysis',
                            'Microsoft Excel',
                            'Google Sheets',
                            'Inventory Management',
                            'Health & Safety Awareness',
                            'Food Handling',
                            'Barista',
                            'Bartending',
                            'Retail POS',
                            'Sales Negotiation',
                            'Receptionist',
                            'Event Setup'
                        ];

                        // Merge extras into pool (avoid duplicates)
                        const lowerExists = new Set(pool.map(p=>p.value.toLowerCase()));
                        extraSuggestions.forEach(s => {
                            if (!s) return;
                            if (!lowerExists.has(String(s).toLowerCase())) pool.push({ value: s, title: s, card: null, extra: true });
                        });

                        // helper: chips for multiple Other entries
                        function addOtherChip(text) {
                            try {
                                text = String(text || '').trim();
                                if (!text) return;
                                const container = document.getElementById('skills1_other_chips');
                                if (!container) return;
                                const existing = Array.from(container.querySelectorAll('.chip')).map(c=>c.dataset.value.toLowerCase());
                                if (existing.includes(text.toLowerCase())) return;
                                const span = document.createElement('span');
                                span.className = 'chip inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm';
                                span.dataset.value = text;
                                const txt = document.createElement('span'); txt.textContent = text;
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'ml-2 text-blue-600 font-bold hover:text-blue-800';
                                btn.setAttribute('aria-label','Remove');
                                btn.textContent = '✕';
                                btn.addEventListener('click', function(){ span.remove(); });
                                span.appendChild(txt);
                                span.appendChild(btn);
                                container.appendChild(span);
                            } catch(e) { console.warn('addOtherChip failed', e); }
                        }

                        function getOtherChips() {
                            try {
                                const container = document.getElementById('skills1_other_chips');
                                if (!container) return [];
                                return Array.from(container.querySelectorAll('.chip')).map(c=>String(c.dataset.value||'').trim()).filter(Boolean);
                            } catch(e) { return []; }
                        }
                        // expose helpers globally so restore/doRestore can use them
                        try { window.addOtherChip = addOtherChip; window.getOtherChips = getOtherChips; } catch(e){}

                        function renderSuggestions(q){
                            listEl.innerHTML = '';
                            if (!q || String(q).trim().length===0) { listEl.classList.add('hidden'); return; }
                            const qq = String(q).toLowerCase();
                            const matches = pool.filter(p => p.value.toLowerCase().includes(qq) || p.title.toLowerCase().includes(qq)).slice(0,8);
                            if (!matches.length) { listEl.classList.add('hidden'); return; }
                            matches.forEach(m => {
                                const li = document.createElement('li');
                                li.className = 'suggestion-item';
                                li.textContent = m.title || m.value;
                                li.dataset.value = m.value;
                                li.addEventListener('click', function(){
                                    try{
                                        const v = this.dataset.value;
                                        // attempt to find an existing card for this suggestion
                                        const target = document.querySelector('.skills-card[data-value="'+v+'"]');
                                        if (target) {
                                            // deselect 'other' if selected, then select the matched card
                                            const otherCard = document.querySelector('.skills-card[data-value="other"]');
                                            if (otherCard && otherCard.classList.contains('selected')) toggleSkills1Choice(otherCard,'other');
                                            if (!target.classList.contains('selected')) toggleSkills1Choice(target, v);
                                            input.value = '';
                                        } else {
                                                    // Not an existing card: ensure 'Other' is selected and add as a chip
                                                    const otherCard = document.querySelector('.skills-card[data-value="other"]');
                                                    if (otherCard && !otherCard.classList.contains('selected')) toggleSkills1Choice(otherCard,'other');
                                                    try { addOtherChip(this.textContent || v); } catch(e) { console.warn(e); }
                                                    input.value = '';
                                                    input.focus();
                                                }
                                        listEl.classList.add('hidden');
                                    }catch(e){console.error(e);} 
                                });
                                listEl.appendChild(li);
                            });
                            listEl.classList.remove('hidden');
                        }

                        // show suggestions on input
                        input.addEventListener('input', function(){ renderSuggestions(this.value); });
                        input.addEventListener('focus', function(){ renderSuggestions(this.value); });

                        // keyboard navigation
                        let highlighted = -1;
                        function updateHighlight(){
                            const items = Array.from(listEl.querySelectorAll('.suggestion-item'));
                            items.forEach((it,i)=> it.classList.toggle('highlight', i===highlighted));
                            if (highlighted>=0 && items[highlighted]) items[highlighted].scrollIntoView({ block: 'nearest' });
                        }
                        input.addEventListener('keydown', function(e){
                            const items = Array.from(listEl.querySelectorAll('.suggestion-item'));
                            if (!items.length) return;
                            if (e.key === 'ArrowDown'){ e.preventDefault(); highlighted = Math.min(highlighted+1, items.length-1); updateHighlight(); }
                            else if (e.key === 'ArrowUp'){ e.preventDefault(); highlighted = Math.max(highlighted-1, 0); updateHighlight(); }
                            else if (e.key === 'Enter'){
                                e.preventDefault();
                                if (highlighted>=0 && items[highlighted]) items[highlighted].click();
                                else {
                                    // treat as free text: add as a chip and ensure other card selected
                                    try {
                                        const val = (input.value || '').trim();
                                        if (val) addOtherChip(val);
                                    } catch(e) { console.warn(e); }
                                    const otherCard = document.querySelector('.skills-card[data-value="other"]');
                                    if (otherCard && !otherCard.classList.contains('selected')) toggleSkills1Choice(otherCard,'other');
                                }
                                listEl.classList.add('hidden'); highlighted = -1;
                            }
                        });

                        // hide when clicking outside
                        document.addEventListener('click', function(e){ if (!e.target.closest('#skills1_suggestions') && e.target !== input) listEl.classList.add('hidden'); });
                    }catch(e){ console.warn('skills suggestions init failed', e); }
                });
            </script>
            <script>
                document.getElementById('skills1Next').addEventListener('click', function () {
                    const errEl = document.getElementById('skills1Error');
                    if (errEl) errEl.textContent = '';

                    const selectedCards = Array.from(document.querySelectorAll('.skills-card.selected') || []);
                    const selected = [];

                    // validate selections (handle 'other' requiring text)
                    for (const card of selectedCards) {
                        const value = (card.getAttribute('data-value') || '').trim();
                        if (!value) continue;
                        if (value === 'other') {
                            // gather chips (multiple entries) or fallback to input value
                            const chips = (window.getOtherChips ? window.getOtherChips() : []);
                            const otherInput = document.getElementById('skills1_other_text');
                            const inputVal = otherInput ? (otherInput.value || '').trim() : '';
                            if (inputVal && !chips.includes(inputVal)) chips.push(inputVal);
                            if (!chips.length) {
                                if (errEl) errEl.textContent = 'Please type your answer for "Other".';
                                if (otherInput) { otherInput.focus(); otherInput.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
                                return;
                            }
                            for (const c of chips) selected.push(c);
                        } else {
                            selected.push(value);
                        }
                    }

                    if (selected.length === 0) {
                        if (errEl) errEl.textContent = 'Please select at least one skill.';
                        const firstCard = document.querySelector('.skills-card');
                        if (firstCard) firstCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }

                    // persist selections
                    try {
                        const hidden = document.getElementById('skills_page1');
                        if (hidden) hidden.value = JSON.stringify(selected);
                    } catch (e) { /* ignore */ }

                    try { localStorage.setItem('skills1_selected', JSON.stringify(selected)); } catch (e) {}

                    // proceed
                    window.location.href = '{{ route("registerjobpreference1") }}';
                });
            </script>

    </div>
    </div>
    </form>
    </div>

</body>

</html>

<script>
// Restore skills selections when returning to this page. Runs immediately if page already loaded.
(function(){
    function doRestore(){
        try{
            const hidden = document.getElementById('skills_page1');
            if (!hidden) return;
            let arr = [];

            // Prefer hidden value first
            try {
                const v = (hidden.value || '').trim();
                if (v) {
                    if ((v.startsWith('[') && v.endsWith(']')) || (v.startsWith('{') && v.endsWith('}'))) arr = JSON.parse(v) || [];
                    else if (v.indexOf(',') !== -1) arr = v.split(',').map(s=>s.trim()).filter(Boolean);
                    else if (v) arr = [v];
                }
            } catch(e) { arr = []; }

            // Fallback to localStorage keys (include current and legacy names)
            if (!arr.length) {
                const keys = ['skills_page1','skills1_selected','skills','selected_skills','selectedSkills'];
                for (const k of keys) {
                    try {
                        const raw = localStorage.getItem(k);
                        if (!raw) continue;
                        let parsed = [];
                        if (String(raw).trim().startsWith('[')) parsed = JSON.parse(raw || '[]');
                        else if (String(raw).indexOf(',') !== -1) parsed = String(raw).split(',').map(s=>s.trim()).filter(Boolean);
                        else parsed = [String(raw).trim()];
                        if (parsed && parsed.length) { arr = parsed; break; }
                    } catch(e) { arr = []; }
                }
            }

            arr = Array.isArray(arr) ? Array.from(new Set(arr.map(x=>String(x||'').trim()).filter(Boolean))) : [];
            if (!arr.length) return;

            // write normalized value back to hidden
            hidden.value = JSON.stringify(arr);

            // apply selection to cards (match data-value or h3 text, case-insensitive)
            const lc = arr.map(s => s.toLowerCase());
            document.querySelectorAll('.skills-card').forEach(card => {
                try{
                    const v = (card.getAttribute('data-value') || '').trim();
                    const title = (card.querySelector('h3')?.textContent || '').trim();
                    const matched = (v && lc.includes(v.toLowerCase())) || (title && lc.includes(title.toLowerCase()));
                    if (matched) card.classList.add('selected'); else card.classList.remove('selected');
                }catch(e){}
            });
            // populate chips for any arr entries that don't correspond to card values/titles
            try {
                const matchedSet = new Set();
                document.querySelectorAll('.skills-card').forEach(card=>{
                    try{
                        const v = (card.getAttribute('data-value')||'').trim().toLowerCase();
                        const title = (card.querySelector('h3')?.textContent||'').trim().toLowerCase();
                        if (v) matchedSet.add(v);
                        if (title) matchedSet.add(title);
                    }catch(e){}
                });
                arr.forEach(item=>{
                    try{
                        const s = String(item||'').trim();
                        if (!s) return;
                        if (!matchedSet.has(s.toLowerCase())) {
                            if (window && window.addOtherChip) window.addOtherChip(s);
                        }
                    }catch(e){}
                });
            } catch(e) {}
        } catch (e) { console.warn('skills restore failed', e); }
    }
    if (document.readyState === 'loading') window.addEventListener('DOMContentLoaded', doRestore); else doRestore();
})();
</script>
