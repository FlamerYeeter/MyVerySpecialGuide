<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Working Environment</title>
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

    /* visual for selected workplace card */
    .workplace-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.25s ease, border 0.2s ease;
        will-change: transform, box-shadow;
        border: 1px solid #d1d5db; /* gray-300 border like workexpinfo cards */
    }
    .workplace-card:hover {
        transform: translateY(-4px);
        border-color: #9ca3af; 
    }
    .workplace-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
    .workplace-card.disabled {
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
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerworkexpinfo') }}')">
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
                            data-tts-en="Please choose the kind of workplace you like! Do you prefer a quiet, calm space, or a more active and lively environment? 
                            Your choice will help us recommend the best fit for you."
                            data-tts-tl="Piliin mo kung anong klase ng lugar ng trabaho ang swak sa’yo! Mas gusto mo ba ang tahimik at chill na kapaligiran, o mas masigla at lively na lugar? 
                            Makakatulong ang sagot mo para irekomenda namin ang pinakabagay sa’yo.">
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
                    Please choose the kind of workplace you like! Do you prefer a quiet, calm space, or a more active and lively environment? 
                    Your choice will help us recommend the best fit for you.
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Piliin mo kung anong klase ng lugar ng trabaho ang swak sa’yo! Mas gusto mo ba ang tahimik at chill na kapaligiran, o mas masigla at lively na lugar?
                         Makakatulong ang sagot mo para irekomenda namin ang pinakabagay sa’yo.)
                    </p>
                
                 <!-- Mobile Audio Button -->
                    <div class="mt-3 flex justify-center sm:hidden">
                        <button type="button" aria-label="Play audio for info section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                            transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please choose the kind of workplace you like! Do you prefer a quiet, calm space, or a more active and lively environment? 
                            Your choice will help us recommend the best fit for you."
                            data-tts-tl="Piliin mo kung anong klase ng lugar ng trabaho ang swak sa’yo! Mas gusto mo ba ang tahimik at chill na kapaligiran, o mas masigla at lively na lugar?
                             Makakatulong ang sagot mo para irekomenda namin ang pinakabagay sa’yo.">
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
                    What kind of workplace feels right for you?
                    </h2>
                    <p class="text-gray-700 italic text-md mt-2">
                    (Anong klase ng lugar ng trabaho ang komportable para sa’yo?)
                    </p>
                </div>
                <!-- Audio Button -->
                <button type="button" 
                    class="bg-[#1E40AF] hover:bg-blue-700 text-white p-2 sm:p-3 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400"
                    data-tts-en="What kind of workplace feels right for you? Choose the option from the images below that best describes the kind of workplace you prefer." 
                        data-tts-tl="Anong klase ng lugar ng trabaho ang komportable para sa’yo? Piliin ang opsyon sa mga larawan sa ibaba na pinakaakma sa klase ng lugar ng trabaho na gusto mo."
                    aria-label="Play audio for question">
                    🔊
                </button>
                </div>

                <!-- Instruction Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8 shadow border border-blue-100 mb-10 max-w-3xl mx-auto sm:mx-0">
                <p class="text-base sm:text-lg font-medium text-gray-800 leading-relaxed">
                    Choose the option from the images below that best describes the kind of
                    <span class="text-blue-700 font-semibold">workplace</span> you prefer.
                </p>
                <div class="border-t border-gray-200 my-4"></div>
                <p class="text-sm sm:text-base text-gray-700 italic">
                    (Piliin ang opsyon sa mga larawan sa ibaba na pinakaakma 
                    <span class="font-semibold text-blue-700">sa klase ng lugar ng trabaho</span> na gusto mo.)
                </p>
                </div>


            <!-- Cards Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

                <!-- Card 1 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'Friendly Team')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Friendly Team: You will work with a kind and helpful team." 
                        data-tts-tl="Makikipagtrabaho ka sa mabait at matulunging team" 
                        aria-label="Play audio for Quiet place option">🔊</button>
                    <img src="image/workplc1.jpg" alt="friendly" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Friendly Team</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">You will work with a kind and helpful team.</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Makikipagtrabaho ka sa mabait at matulunging team)</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'Buddy Helper')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Buddy Helper: You will have a buddy (a coworker) who will guide you and help you when you need support." 
                        data-tts-tl="Magkakaroon ka ng buddy (katrabaho) na gagabay at tutulong sa’yo kapag kailangan mo" 
                        aria-label="Play audio for Busy place option">🔊</button>
                    <img src="image/workplc2.jpg" alt="buddy" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Buddy Helper</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">You will have a buddy (a coworker) who will guide you and help you when you need support.</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Magkakaroon ka ng buddy (katrabaho) na gagabay at tutulong sa'yo kapag kailangan mo)</p>
                </div>

                  <!-- Card 3 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'Simple Instructions')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Simple Instructions: You will receive instructions that are easy to understand. These may include pictures, signs, or step-by-step directions."
                        data-tts-tl="Makakatanggap ka ng malinaw at madaling sundan na instructions. Maaaring may kasama itong larawan o sunod-sunod na steps" 
                        aria-label="Play audio for Busy place option">🔊</button>
                    <img src="image/workplc3.jpg" alt="simpleinstructions" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Simple Instructions</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">You will receive instructions that are easy to understand. These may include pictures, signs, or step-by-step directions.</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Makakatanggap ka ng malinaw at madaling sundan na instructions. Maaaring may kasama itong larawan o sunod-sunod na steps)</p>
                </div>

                  <!-- Card 4 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'Safe and Light Work')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Safe and Light Work: Your tasks will be safe and not too heavy." 
                        data-tts-tl="Ang mga gagawin mo ay ligtas at hindi mabigat na gawain" aria-label="Play audio for Busy place option">🔊</button>
                    <img src="image/workplc4.jpg" alt="safe&light" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">Safe and Light Work</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">Your tasks will be safe and not too heavy.</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Ang mga gagawin mo ay ligtas at hindi mabigat na gawain)</p>
                </div>

                  <!-- Card 5 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'No Heavy Lifting / No Pharmacy Tasks')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="No Heavy Lifting / No Pharmacy Tasks:You will not carry heavy items and you will not do pharmacy-related tasks." 
                        data-tts-tl="Hindi ka magbubuhat ng mabibigat na gamit at hindi ka gagawa ng anumang pharmacy-related na trabaho" aria-label="Play audio for Busy place option">🔊</button>
                    <img src="image/workplc5.jpg" alt="heavy&pharmacytask" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center text-base sm:text-lg">No Heavy Lifting / No Pharmacy Tasks</h3>
                    <p class="mt-2 text-sm sm:text-base text-gray-800 text-center">You will not carry heavy items and you will not do pharmacy-related tasks.</p>
                    <p class="mt-2 text-xs sm:text-sm text-gray-600 italic text-center">(Hindi ka magbubuhat ng mabibigat na gamit at hindi ka gagawa ng anumang pharmacy-related na trabaho)</p>
                </div>

                <!-- Other -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    data-value="other" onclick="selectWorkplaceChoice(this,'other')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Other, Type your answer inside the box if not in the choices" 
                        data-tts-tl="Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian" aria-label="Play audio for Other option">🔊</button>
                    <h3 id="workplace_other_label" class="text-blue-600 font-semibold text-center text-base sm:text-lg mb-2">Other</h3>
                    <p class="mt-6 text-sm sm:text-base text-gray-800">
                        Type your answer inside the box if not in the choices
                    </p>
                    <label for="workplace_other_text" class="sr-only">Type your other answer and enter here</label>
                    <p class="text-xs sm:text-sm text-gray-600 italic mt-1 mb-3">
                        (Isulat ang sagot at i-enter sa loob ng kahon kung wala sa pagpipilian)
                    </p>
                    <div id="workplace_other_chips" class="flex flex-wrap gap-2 mb-2"></div>
                    <input id="selectworkplace_other_text" name="workplace_other_text" type="text"
                        list="workplace_other_suggestions"
                        aria-labelledby="workplace_other_label" placeholder="Type your answer here (press Enter to add)"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <datalist id="workplace_other_suggestions">
                        <option value="Calm and low-noise space"></option>
                        <option value="Work tasks with visual guides"></option>
                        <option value="Short breaks and gentle pacing"></option>
                        <option value="Step-by-step checklists"></option>
                        <option value="One task at a time"></option>
                        <option value="Extra time for learning new tasks"></option>
                        <option value="Visual schedule board"></option>
                        <option value="A patient coach or buddy"></option>
                    </datalist>
                    <datalist id="workplace_other_suggestions">
                        <option value="Calm and low-noise space"></option>
                        <option value="Work tasks with visual guides"></option>
                        <option value="Short breaks and gentle pacing"></option>
                    </datalist>
                </div> 
            </div>

            <!-- Hidden Input for Workplace Choice -->
            <input id="workplace_choices" type="hidden" value="[]" />

            <script>
                function addWorkplaceOtherChip(value) {
                    const chipsContainer = document.getElementById('workplace_other_chips');
                    if (!chipsContainer || !value) return;
                    const normalized = value.trim();
                    if (!normalized) return;

                    // Prevent duplicates
                    const existing = Array.from(chipsContainer.querySelectorAll('.chip-item')).map(c => c.textContent.trim());
                    if (existing.includes(normalized)) return;

                    const chip = document.createElement('span');
                    chip.className = 'chip-item inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs sm:text-sm';
                    chip.textContent = normalized;

                    const remove = document.createElement('button');
                    remove.type = 'button';
                    remove.className = 'text-blue-700 hover:text-blue-900 font-bold';
                    remove.innerHTML = '&times;';
                    remove.addEventListener('click', () => chip.remove());

                    chip.appendChild(remove);
                    chipsContainer.appendChild(chip);
                }

                function getWorkplaceOtherChips() {
                    const chipsContainer = document.getElementById('workplace_other_chips');
                    if (!chipsContainer) return [];
                    return Array.from(chipsContainer.querySelectorAll('.chip-item')).map(c => c.firstChild.textContent.trim());
                }

                function clearWorkplaceOtherChips() {
                    const chipsContainer = document.getElementById('workplace_other_chips');
                    if (!chipsContainer) return;
                    chipsContainer.innerHTML = '';
                }

                document.addEventListener('DOMContentLoaded', () => {
                    const workplaceNextbtn = document.getElementById('workplaceNext');
                    const otherInput = document.getElementById('selectworkplace_other_text');

                    if (otherInput) {
                        otherInput.addEventListener('keydown', function (e) {
                            if (e.key === 'Enter' || e.key === ',') {
                                e.preventDefault();
                                const value = otherInput.value.trim();
                                if (value) {
                                    addWorkplaceOtherChip(value);
                                    otherInput.value = '';
                                }
                            }
                        });
                    }

                    if (!workplaceNextbtn) return;

                    workplaceNextbtn.addEventListener('click', function() {
                        const errorEl = document.getElementById('workplaceError');
                        if (errorEl) errorEl.textContent = '';

                        const selected = [];
                        document.querySelectorAll('.workplace-card.selected').forEach(card => {
                            const onclickAttr = card.getAttribute('onclick') || '';
                            const match = onclickAttr.match(/'([^']+)'/);
                            let value = match ? match[1] : (card.getAttribute('data-value') || (card.querySelector('h3')?.textContent || '').trim());
                            if (value) selected.push({ card, value });
                        });

                        // Validation: require at least one selection
                        if (!selected.length) {
                            if (errorEl) errorEl.textContent = 'Please select at least one working environment.';
                            const firstCard = document.querySelector('.workplace-card');
                            if (firstCard) { firstCard.scrollIntoView({behavior:'smooth', block:'center'}); }
                            return;
                        }

                        // If "other" was selected, require at least one chip or entered value
                        const otherSelected = selected.find(s => (String(s.value).toLowerCase() === 'other' || s.value === 'other'));
                        if (otherSelected) {
                            const chips = getWorkplaceOtherChips();
                            const typed = (otherInput && otherInput.value.trim()) || '';
                            if (!chips.length && !typed) {
                                if (errorEl) errorEl.textContent = 'Please add at least one answer for "Other".';
                                if (otherInput) { otherInput.scrollIntoView({behavior:'smooth', block:'center'}); otherInput.focus(); }
                                return;
                            }

                            if (typed) {
                                addWorkplaceOtherChip(typed);
                                otherInput.value = '';
                            }
                        }

                        // Passed validation — build array and save
                        const values = selected.flatMap(s => {
                            if (String(s.value).toLowerCase() === 'other') {
                                const chips = getWorkplaceOtherChips();
                                return chips.length ? chips : ['Other'];
                            }
                            return [s.value];
                        });

                        const hidden = document.getElementById('workplace_choices');
                        if (hidden) hidden.value = JSON.stringify(values);
                        try { localStorage.setItem('workplace', JSON.stringify(values)); } catch (e) {}

                        window.location.href = '{{ route("registerskills1") }}';
                    });
                });
            </script>


            <script>
                // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workplace.blade.php
                function selectWorkplaceChoice(el, value) {
                    try {
                        const hidden = document.getElementById('workplace_choices');
                        if (!hidden) return;
                        let arr = [];
                        try { arr = JSON.parse(hidden.value || '[]'); } catch(e){ arr = []; }

                        const idx = arr.indexOf(value);
                        if (idx === -1) {
                            arr.push(value);
                            if (el && el.classList) el.classList.add('selected');
                        } else {
                            arr.splice(idx, 1);
                            if (el && el.classList) el.classList.remove('selected');
                        }

                        hidden.value = JSON.stringify(arr);
                        const err = document.getElementById('workplaceError');
                        if (err) err.textContent = '';
                    } catch (e) {
                        console.error('selectWorkplaceChoice error', e);
                    }
                }
            </script>
    </div>
            <!-- Next Button -->
            <div class="flex flex-col items-center justify-center mt-6 mb-6 space-y-3 px-2">
                <div id="workplaceError" class="text-red-600 text-sm text-center"></div>
                <button id="workplaceNext" type="button"
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

    <script src="{{ asset('js/register.js') }}"></script>

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
    

</body>

</html>

<script>
// Restore workplace choices when returning to this page. Runs immediately if page already loaded.
(function(){
    function doRestore(){
        try{
            const hidden = document.getElementById('workplace_choices');
            const raw = localStorage.getItem('workplace') || localStorage.getItem('workplace_choices') || (hidden ? hidden.value : '');
            let arr = [];
            if (raw) {
                try { arr = JSON.parse(raw || '[]'); } catch(e) {
                    arr = String(raw).trim().startsWith('[') ? JSON.parse(raw) : String(raw).split(',').map(s=>s.trim()).filter(Boolean);
                }
            }
            arr = Array.isArray(arr) ? Array.from(new Set(arr)) : [];
            if (hidden) hidden.value = JSON.stringify(arr);

            document.querySelectorAll('.workplace-card').forEach(card => {
                try {
                    const onclickAttr = card.getAttribute('onclick') || '';
                    const m = onclickAttr.match(/'([^']+)'/);
                    const value = m ? m[1] : (card.getAttribute('data-value') || (card.querySelector('h3')?.textContent || '').trim());
                    if (value && arr.includes(value)) card.classList.add('selected'); else card.classList.remove('selected');
                } catch(e) {}
            });
        } catch (e) { console.warn('workplace restore failed', e); }
    }
    if (document.readyState === 'loading') window.addEventListener('DOMContentLoaded', doRestore); else doRestore();
})();
</script>
