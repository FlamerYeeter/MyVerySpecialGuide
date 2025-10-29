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

            <!-- Office Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Office Work" onclick="toggleJobPref1Choice(this,'Office Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Office Work: use the computer for simple tasks, answer the phone politely, and keep papers organized in folders." data-tts-tl="Office Work: gagamit ka ng computer para sa simpleng gawain, sasagot ng telepono nang magalang, at aayusin ang mga papeles sa mga folder." aria-label="Play audio for Office Work">🔊</button>
                <img src="image/officework.png" alt="Office Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Office Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    In this job, you will use the computer for simple tasks, answer the phone politely, and keep
                    papers organized in folders.
                </p>
                <p class="text-[13px] text-[#4D515C] italic mt-2 text-center">
                    (Sa trabahong ito, gagamit ka ng computer para sa simpleng gawain, sasagot ng telepono nang
                    magalang,
                    at aayusin ang mga papeles sa mga folder.)
                </p>
            </div>

            <!-- Store Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Store Work" onclick="toggleJobPref1Choice(this,'Store Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Store Work: help customers find what they need, place items neatly on shelves, and work at the cashier to take payments." data-tts-tl="Store Work: tutulungan mo ang mga customer na hanapin ang kanilang kailangan, maayos na ilalagay ang mga paninda sa mga lagayan, at magtatrabaho sa cashier para tumanggap ng bayad." aria-label="Play audio for Store Work">🔊</button>
                <img src="image/storework.png" alt="Store Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Store Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You will help customers find what they need, place items neatly on shelves, and work at the
                    cashier to take payments.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Tutulungan mo ang mga customer na hanapin ang kanilang kailangan, maayos na ilalagay ang mga
                    paninda sa mga lagayan, at magtatrabaho sa cashier para tumanggap ng bayad.)
                </p>
            </div>

            <!-- Cleaning Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Cleaning Work" onclick="toggleJobPref1Choice(this,'Cleaning Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Cleaning Work: sweep or mop the floor, wipe tables and windows, and make sure rooms stay neat and tidy." data-tts-tl="Cleaning Work: magwawalis o mag-mop ka ng sahig, magpupunas ng mga mesa at bintana, at sisiguraduhin na malinis at maayos ang mga silid." aria-label="Play audio for Cleaning Work">🔊</button>
                <img src="image/cleaningwork.png" alt="Cleaning Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Cleaning Work</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You will sweep or mop the floor, wipe tables and windows, and make sure rooms stay neat and
                    tidy.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Magwawalis o mag-mop ka ng sahig, magpupunas ng mga mesa at bintana, at sisiguraduhin na
                    malinis at maayos ang mga silid.)
                </p>
            </div>

            <!-- Hospitality Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Hospitality Work" onclick="toggleJobPref1Choice(this,'Hospitality Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Hospitality Work: greet guests with a smile, help clean and prepare rooms, and carry small items like towels." data-tts-tl="Hospitality Work: sasalubungin mo ang mga bisita nang may ngiti, tutulong sa paglilinis at paghahanda ng mga kuwarto, at magdadala ng maliliit na gamit tulad ng tuwalya." aria-label="Play audio for Hospitality Work">🔊</button>
                <img src="image/hospitalitywork.png" alt="Hospitality Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Hospitality Work</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You will greet guests with a smile, help clean and prepare rooms, and carry small items like
                    towels.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Sasalubungin mo ang mga bisita nang may ngiti, tutulong sa paglilinis at paghahanda ng mga kuwarto,
                    at magdadala
                    ng maliliit na gamit tulad ng tuwalya.)
            </div>

            <!-- Food Service Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Food Service Work" onclick="toggleJobPref1Choice(this,'Food Service Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Food Service Work: serving food and drinks, helping prepare simple meals, and keeping the tables and kitchen clean." data-tts-tl="Food Service Work: pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng pagkain, at pagpapanatiling malinis ng mga mesa at kusina." aria-label="Play audio for Food Service Work">🔊</button>
                <img src="image/foodservice.png" alt="food service work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Food Service Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    This job includes serving food and drinks, helping prepare simple meals, and keeping the tables and
                    kitchen clean.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng
                    pagkain,
                    at pagpapanatiling malinis ng mga mesa at kusina.)
                </p>
            </div>

            <!-- Packing Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Packing Packages Work" onclick="toggleJobPref1Choice(this,'Packing Packages Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Packing Packages Work: putting items in boxes or bags, carrying light packages, and organizing items on shelves." data-tts-tl="Packing Packages Work: paglalagay ng mga gamit sa kahon o bag, pagdadala ng magagaan na packages, at pag-aayos ng mga gamit sa mga lagayan." aria-label="Play audio for Packing Packages Work">🔊</button>
                <img src="image/packingwork.png" alt="Packing Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Packing Packages Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    This job includes putting items in boxes or bags, carrying light packages, and organizing items on
                    shelves.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang paglalagay ng mga gamit sa kahon o bag, pagdadala ng magagaan na
                    packages,
                    at pag-aayos ng mga gamit sa mga lagayan.)
                </p>
            </div>

            <!-- Creative Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Creative Work" onclick="toggleJobPref1Choice(this,'Creative Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Creative Work: make simple art or crafts, decorate for events, and use safe tools with guidance." data-tts-tl="Creative Work: gumawa ng simpleng sining o likha, magde-dekorasyon para sa mga okasyon, at gagamit ng ligtas na kagamitan sa tulong ng gabay." aria-label="Play audio for Creative Work">🔊</button>
                <img src="image/creativework.png" alt="Creative Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Creative Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    This job lets you make simple art or crafts, decorate for events, and use safe tools with guidance.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Sa trabahong ito, gagawa ka ng simpleng sining o likha, magde-dekorasyon para sa mga okasyon,
                    at gagamit ng ligtas na kagamitan sa tulong ng gabay.)
                </p>
            </div>

            <!-- Other -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl min-h-[340px] flex flex-col justify-between
              transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 
              cursor-pointer relative text-center jobpref-card"
                data-value="other" onclick="toggleJobPref1Choice(this,'other')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                    data-tts-en="Other, Type your answer inside the box if not in the choices" 
                    data-tts-tl="Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian" aria-label="Play audio for Other option">🔊</button>

                <div class="flex flex-col flex-grow justify-center">
                    <h3 id="support_other_label" class="text-blue-600 font-semibold text-center mb-2">Other</h3>
                    <p class="mt-3 text-sm text-justify">
                        Type your answer inside the box if not in the choices
                    </p>
                    <p class="text-[13px] text-gray-600 italic mt-1 mb-3 text-justify">
                        (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
                    </p>

                    <label for="jobpref_other_text" class="sr-only">Type your other answer here</label>
                    <input id="jobpref_other_text" name="jobpref_other_text" type="text"
                        aria-labelledby="jobpref_other_label" placeholder="Type your answer here"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
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
                        arr.push(value);
                        if (el && el.classList) el.classList.add('selected');
                    } else {
                        arr.splice(idx, 1);
                        if (el && el.classList) el.classList.remove('selected');
                    }
                    hidden.value = JSON.stringify(arr);
                    if (value === 'other') {
                        const other = document.getElementById('jobpref1_other_text');
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
    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tts-btn');
            const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            let preferredVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredVoice = availableVoices.find(v => v.name === preferredVoiceName)
                    || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
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
                            if (preferredVoice) return preferredVoice;
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                                    return chooseVoiceForLang('tl');
                                }
                                return chooseVoiceForLang(langHint);
                            }
                            return chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
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
