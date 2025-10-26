<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Education</title>
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

    .education-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
            /* light blue */
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
        onclick="window.location.href='{{ route('registeradminapprove') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">

        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1
                class="text-xl sm:text-3xl md:text-5xl font-extrabold text-blue-700 mb-2 sm:mb-3 drop-shadow-md leading-snug">
                Set Up Your Profile</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-16 sm:w-24 md:w-36 mb-3 sm:mb-6">
            <h2
                class="text-base sm:text-xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-2 flex-wrap">
                Continue setting up your profile
                <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn" data-tts-en="Continue setting up your profile" data-tts-tl="Ituloy ang pag-set up ng iyong profile" aria-label="Play audio for header">🔊</button>
            </h2>
            <p
                class="mt-2 sm:mt-3 text-gray-700 italic text-xs sm:text-sm md:text-lg border-b-4 border-blue-500 inline-block pb-1 sm:pb-2 px-2">
                (Ituloy ang pag-set up ng iyong profile)
            </p>
        </div>
        
        <!-- Information Note -->
        <div
            class="relative bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 sm:p-5 md:p-6 mt-6 shadow-sm">
            <!-- Audio Button -->
            <button type="button" aria-label="Play audio for information note"
                class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-[#1E40AF] hover:bg-blue-700 text-white 
           text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md transition-transform 
           hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                data-tts-en="Please select your highest education level. This helps us recommend suitable programs, job opportunities, and training that match your background." data-tts-tl="Pumili ng iyong pinakamataas na natapos na antas ng edukasyon. Makakatulong ito upang mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay na tumutugma sa iyong kaalaman.">
                🔊
            </button>

            <!-- Content -->
            <div class="flex flex-col sm:flex-row items-start gap-2 sm:gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <div class="flex-1 pr-10"> <!-- padding-right to avoid overlap with button -->
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        Please select your highest education level. This helps us recommend suitable programs,
                        job opportunities, and training that match your background.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Pumili ng iyong pinakamataas na natapos na antas ng edukasyon. Makakatulong ito upang
                        mairerekomenda namin ang mga angkop na programa, trabaho, at pagsasanay na tumutugma
                        sa iyong kaalaman.)
                    </p>
                </div>
            </div>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
            <!-- Education Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Education</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">What is your highest education?</p>
                    <button type="button" class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn" data-tts-en="What is your highest education?" data-tts-tl="Ano ang pinakamataas mong natapos na grade o taon sa school?" aria-label="Play audio for question">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Ano ang pinakamataas mong natapos na grade o
                    taon
                    sa school?)</p>
            </div>

            <!-- Instruction -->
            <div class="mt-6 text-center sm:text-left px-1 sm:px-4">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="text-xs sm:text-base font-medium text-gray-800">Choose from the pictures provided and
                        click
                        your answer.</p>
                    <button type="button" class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn" data-tts-en="Choose from the pictures provided and click your answer." data-tts-tl="Pumili mula sa mga larawan at pindutin ang iyong sagot" aria-label="Play audio for instruction">🔊</button>
                </div>
                <p class="text-[10px] sm:text-sm text-gray-600 italic mt-1">(Pumili mula sa mga larawan at pindutin ang
                    iyong sagot)</p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

                <!-- Card Template -->

                <!-- Card 1 -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Elementary')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Elementary" data-tts-tl="Elementary" aria-label="Play audio for Elementary option">🔊</button>
                    <img src="image/educ1.png" alt="elementary"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Elementary</h3>
                </div>
                
                <!-- Card 2 -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Highschool')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Highschool" data-tts-tl="Highschool" aria-label="Play audio for Highschool option">🔊</button>
                    <img src="image/educ3.png" alt="highschool"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Highschool</h3>
                </div>

                <!-- Card 3 -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'College')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="College" data-tts-tl="College" aria-label="Play audio for College option">🔊</button>
                    <img src="image/educ2.png" alt="college"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">College</h3>
                </div>

                <!-- Card 4 -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'Vocational/Training')">
                    <button type="button"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm tts-btn"
                        data-tts-en="Vocational or Training" data-tts-tl="Vocational o Pagsasanay" aria-label="Play audio for Vocational option">🔊</button>
                    <img src="image/educ4.png" alt="vocational"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-center">Vocational/Training</h3>
                </div>

                <!-- Other Option -->
                <div class="education-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectEducationChoice(this, 'other')">

                    <!-- Audio Button -->
                    <button type="button" aria-label="Play audio for Other option"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm transition-transform hover:scale-110">
                        🔊
                    </button>

                    <!-- Label -->
                    <label for="edu_other_text" id="edu_other_label"
                        class="block text-blue-600 font-semibold mb-2 text-sm sm:text-lg cursor-pointer">
                        Other
                    </label>

                    <!-- Description -->
                    <p class="mt-6 text-sm text-justify">
                        Type your answer inside the box if not in the choices
                    </p>
                    <p class="text-[13px] text-gray-600 italic mt-1 mb-3 text-justify">
                        (Isulat ang sagot sa loob ng kahon kung wala sa pagpipilian)
                    </p>

                    <!-- Input -->
                    <input id="edu_other_text" name="edu_other_text" type="text"
                        aria-labelledby="edu_other_label" placeholder="Type your answer here"
                        class="w-full border border-gray-300 rounded-lg p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                </div>
            </div>

            <!-- Hidden input for education level (collected by register.js) -->
            <input id="edu_level" type="hidden" value="" />

            <!-- Next Button -->
            <div class="flex flex-col items-center justify-center mt-10 mb-6 space-y-3 px-2">
                <div id="educError" class="text-red-600 text-sm text-center"></div>
                <button id="educNext" type="button"
                    class="bg-[#2E2EFF] text-white text-sm sm:text-lg font-semibold px-10 sm:px-16 md:px-20 py-2 sm:py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md">
                    Next →
                </button>
                <p class="text-gray-600 text-[11px] sm:text-sm mt-2 text-center leading-snug">
                    Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page<br>
                    <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>
        </form>
    </div>

    <!-- Small inline helper to toggle selection and write the value -->
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_education.blade.php
        function selectEducationChoice(el, value) {
            try {
                // remove selected class from all cards
                document.querySelectorAll('.education-card').forEach(c => c.classList.remove('selected'));

                // add selected class to clicked card
                if (el && el.classList) el.classList.add('selected');

                // set hidden input value
                const hidden = document.getElementById('edu_level');
                if (hidden) hidden.value = value || '';

                // if "other", focus the other text input
                if (String(value).toLowerCase() === 'other') {
                    const other = document.getElementById('edu_other_text');
                    if (other) other.focus();
                }

                // clear any error text
                const err = document.getElementById('educError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectEducationChoice error', e);
            }
        }
    </script>
    <script src="{{ asset('js/register.js') }}"></script>

    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tts-btn');
            // prefer a single high-quality voice for both English and Filipino
            const preferredVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            let preferredVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                // try exact match first, then fuzzy match for known Microsoft AvaMultilingual
                preferredVoice = availableVoices.find(v => v.name === preferredVoiceName)
                    || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
                    || null;
            }

            // heuristics to pick a good voice for a given lang (e.g., 'tl' or 'en')
            function chooseVoiceForLang(langCode) {
                if (!availableVoices.length) return null;
                langCode = (langCode || '').toLowerCase();
                // prefer exact lang match
                let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                if (candidates.length) return pickBest(candidates);
                // prefer voices whose name contains high-quality markers
                candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
                if (candidates.length) return pickBest(candidates);
                // fallback to first available
                return availableVoices[0];
            }

            function pickBest(list) {
                // prefer non-local (cloud-backed) or names with Neural/WaveNet
                let preferred = list.filter(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
                if (preferred.length) return preferred[0];
                return list[0];
            }

            function stopSpeaking() {
                if (window.speechSynthesis) {
                    window.speechSynthesis.cancel();
                }
                if (currentBtn) {
                    currentBtn.classList.remove('speaking');
                    currentBtn.removeAttribute('aria-pressed');
                    currentBtn = null;
                }
            }

            buttons.forEach(function (btn) {
                // make keyboard accessible
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');

                btn.addEventListener('click', function () {
                    const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                    const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                    // nothing to speak
                    if (!textEn && !textTl) return;

                    // If same button clicked while speaking, stop
                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
                        stopSpeaking();
                        return;
                    }

                    // Stop any existing speech then speak new text(s)
                    stopSpeaking();

                    // Small timeout to ensure previous utterance canceled
                    setTimeout(function () {
                        if (!window.speechSynthesis) return;

                        // Helper to pick voice for a given language (or selected by user)
                        function voiceFor(langHint) {
                            // prefer the configured Microsoft AvaMultilingual voice when available
                            if (preferredVoice) return preferredVoice;
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                                    return chooseVoiceForLang('tl');
                                }
                                return chooseVoiceForLang(langHint);
                            }
                            // fallback to any reasonable voice
                            return chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
                        }

                        // Build utterances sequence: English first (if any), then Tagalog
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

                        // Attach lifecycle handlers to the sequence
                        seq[0].onstart = function () {
                            btn.classList.add('speaking');
                            btn.setAttribute('aria-pressed', 'true');
                            currentBtn = btn;
                        };

                        // chain subsequent utterances
                        for (let i = 0; i < seq.length; i++) {
                            const ut = seq[i];
                            ut.onerror = function () {
                                if (btn) btn.classList.remove('speaking');
                                if (btn) btn.removeAttribute('aria-pressed');
                                currentBtn = null;
                            };
                            if (i < seq.length - 1) {
                                ut.onend = function () {
                                    // speak next
                                    window.speechSynthesis.speak(seq[i + 1]);
                                };
                            } else {
                                ut.onend = function () {
                                    if (btn) btn.classList.remove('speaking');
                                    if (btn) btn.removeAttribute('aria-pressed');
                                    currentBtn = null;
                                };
                            }
                        }

                        // start sequence
                        window.speechSynthesis.speak(seq[0]);
                    }, 50);
                });

                // also allow Enter/Space to trigger
                btn.addEventListener('keydown', function (ev) {
                    if (ev.key === 'Enter' || ev.key === ' ') {
                        ev.preventDefault();
                        btn.click();
                    }
                });
            });

            // Stop speech when navigating away or reloading
            window.addEventListener('beforeunload', function () {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });
            // populate voices now or when they change
            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function () {
                    populateVoices();
                };
            }

            // No preview UI: when voices are populated we attempt to use the preferred Microsoft AvaMultilingual voice
        });
    </script>

</body>

</html>
