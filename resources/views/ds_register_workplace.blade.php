<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Working Environment</title>
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
    .workplace-card.selected {
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
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registersupportneed') }}')">
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
            class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-start gap-3 pr-14">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <div class="flex-1">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        The information you share here helps us find workplaces that match your comfort level — whether
                        you prefer a
                        quiet environment or one that’s more active and lively.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Ang impormasyong iyong ibibigay dito ay makatutulong upang mahanap namin ang mga lugar ng
                        trabaho na akma sa iyong kaginhawaan — tahimik man o masigla ang iyong gusto.)
                    </p>
                </div>
            </div>

            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 tts-btn"
                data-tts-en="The information you share here helps us find workplaces that match your comfort level — whether you prefer a quiet environment or one that’s more active and lively." data-tts-tl="Ang impormasyong iyong ibibigay dito ay makatutulong upang mahanap namin ang mga lugar ng trabaho na akma sa iyong kaginhawaan — tahimik man o masigla ang iyong gusto." aria-label="Play audio for information note">
                🔊
            </button>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
            <!-- Workplace Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class= "text-xl sm:text-3xl font-bold text-blue-700 mb-2">Working Environment</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">
                        What kind of working environment feels comfortable for you?
                        <button type="button"
                            class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn" data-tts-en="What kind of working environment feels comfortable for you? Select all that apply." data-tts-tl="Ano klaseng lugar ng trabaho ang komportable para sa iyo? Piliin lahat ng naaangkop." aria-label="Play audio for question">🔊</button>
                    </p>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">
                    (Ano klaseng lugar ng trabaho ang komportable para sa iyo? Piliin lahat ng naaangkop na kakayahan na
                    meron ka)
                </p>
            </div>

            <!-- Instruction -->
            <div class="mt-4 text-center sm:text-left px-1 sm:px-4">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="mt-4 text-gray-800 font-medium text-base sm:text-lg leading-snug">Choose from the pictures provided and
                        click
                        your answer.</p>
                    <button type="button"
                        class="mt-4 text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn" data-tts-en="Choose from the pictures provided and click your answer." data-tts-tl="Pumili mula sa mga larawan at pindutin ang iyong sagot" aria-label="Play audio for instruction">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Pumili mula sa mga larawan at pindutin ang
                    iyong sagot)</p>
            </div>


            <!-- Cards Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

                <!-- Card 1 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'quiet')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="The place is quiet and calm" data-tts-tl="Tahimik at kalmado ang lugar" aria-label="Play audio for Quiet place option">🔊</button>
                    <img src="image/workplc1.png" alt="quietplace" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">The place is quiet and calm</h3>
                    <p class="mt-2 text-[13px] text-gray-600 italic text-center">(Tahimik at kalmado ang lugar)</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    onclick="selectWorkplaceChoice(this,'busy')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="There are many people and many things happening" data-tts-tl="Maraming tao at maraming ginagawa" aria-label="Play audio for Busy place option">🔊</button>
                    <img src="image/workplc2.png" alt="busyplace" class="w-full rounded-md mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">There are many people and many things happening
                    </h3>
                    <p class="mt-2 text-[13px] text-gray-600 italic text-center">(Maraming tao at maraming ginagawa)</p>
                </div>

                <!-- Other -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center workplace-card"
                    data-value="other" onclick="selectWorkplaceChoice(this,'other')">
                    <button type="button"
                        class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition tts-btn"
                        data-tts-en="Other, Type your answer inside the box if not in the choices" 
                        data-tts-tl="Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian" aria-label="Play audio for Other option">🔊</button>
                    <h3 id="workplace_other_label" class="text-blue-600 font-semibold text-center mb-2">Other</h3>
                    <p class="mt-6 text-sm text-justify">
                        Type your answer inside the box if not in the choices
                    </p>
                    <label for="workplace_other_text" class="sr-only">Type your other answer here</label>
                    <p class="text-[13px] text-gray-600 italic mt-1 mb-3 text-justify">
                        (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
                    </p>
                    <input id="selectworkplace_other_text" name="workplace_other_text" type="text"
                        aria-labelledby="workplace_other_label" placeholder="Type your answer here"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            <!-- Hidden Input for Workplace Choice -->
            <input id="workplace_choice" type="hidden" value="" />

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                const workplaceNextbtn = document.getElementById('workplaceNext');

                workplaceNextbtn.addEventListener('click', function() {
                    // Find the card that currently has the "selected" class
                    const selectedCard = document.querySelector('.workplace-card.selected');

                    if (!selectedCard) return; // do nothing if none selected

                    // Extract the value from onclick attribute
                    const onclickAttr = selectedCard.getAttribute('onclick');
                    const match = onclickAttr.match(/'([^']+)'/); // value inside single quotes
                    const selectedValue = match ? match[1] : null;

                    if (!selectedValue) return;

                    // If "other", use input text; otherwise save the value
                    if (selectedValue === 'other') {
                        const otherInput = document.getElementById('selectworkplace_other_text');
                        const otherValue = otherInput.value.trim();
                        localStorage.setItem('workplace', otherValue || 'other');
                    } else {
                        localStorage.setItem('workplace', selectedValue);
                    }

                    console.log("Saved to localStorage:", localStorage.getItem('workplace'));
                    // Navigate to the Skills page next (was mistakenly pointing to job preference)
                    window.location.href = '{{ route("registerskills1") }}';
                    });
                });
            </script>

            <script>
                // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workplace.blade.php
                function selectWorkplaceChoice(el, value) {
                    try {
                        document.querySelectorAll('.workplace-card').forEach(c => c.classList.remove('selected'));
                        if (el && el.classList) el.classList.add('selected');
                        const hidden = document.getElementById('workplace_choice');
                        if (hidden) hidden.value = value || '';
                        /*if (value === 'other') {
                            const other = document.getElementById('workplace_other_text');
                            if (other) other.focus();
                        }*/
                        const err = document.getElementById('workplaceError');
                        if (err) err.textContent = '';
                    } catch (e) {
                        console.error('selectWorkplaceChoice error', e);
                    }
                }
            </script>

            <!-- Next Button -->
            <div class="w-full flex flex-col items-center justify-center mt-12 mb-8">
                <div id="workplaceError" class="text-red-600 text-sm mb-2"></div>
                <button id="workplaceNext" type="button"
                    class="bg-[#2E2EFF] text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
                    Next →
                </button>
                <p class="text-gray-600 text-sm mt-2 text-center">
                    Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page Your
                    Skills<br>
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
