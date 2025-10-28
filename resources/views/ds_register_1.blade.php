<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create an Account</title>
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

    .skills-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
    /* TTS speaking state for audio buttons */
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
    }
    </style>
</head>

<body class="bg-white flex justify-center items-center min-h-screen p-4 sm:p-6 relative overflow-auto">

    <!-- Floating Mascots (z-index lower) -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="fixed left-1 sm:left-4 md:left-10 top-1/3 w-16 sm:w-24 md:w-32 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="fixed left-1 sm:left-4 md:left-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-20 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="fixed right-1 sm:right-4 md:right-10 top-1/4 w-16 sm:w-24 md:w-32 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="fixed right-1 sm:right-4 md:right-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-24 md:w-36 opacity-90 animate-float-medium z-0">


    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('user.role') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-4">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Create an Account
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-28 sm:w-36 mb-6">

            <h2
                class="text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-3 flex-wrap">
                Let's create your account step by step
                <button class="text-2xl sm:text-3xl hover:scale-110 transition-transform tts-btn" data-tts-en="Let's create your account step by step" data-tts-tl="Simulan natin ang paglikha ng iyong account sa pagsunod sa bawat hakbang">🔊</button>
            </h2>
            <p class="mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Simulan natin ang paglikha ng iyong account sa pagsunod sa bawat hakbang)
            </p>
        </div>

        <!-- Info Section -->
        <div
            class="mt-8 sm:mt-10 max-w-3xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border border-blue-300 shadow-md relative">
            <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6 pr-16">
                <span class="text-[#846506] text-4xl sm:text-5xl mt-1 flex-shrink-0">💡</span>
                <div class="flex-1 text-left">
                    <p class="text-lg sm:text-xl text-gray-800 font-semibold leading-relaxed">
                        We will create your account so we can find jobs that are perfect for you!
                    </p>
                    <p class="text-gray-700 italic text-base sm:text-lg mt-1">
                        (Tayo ay gagawa ng iyong account upang makahanap ng mga trabahong para sa iyo!)
                    </p>
                </div>
            </div>

            <!-- Audio Button -->
            <button type="button"
                class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                data-tts-en="We will create your account so we can find jobs that are perfect for you!" data-tts-tl="Tayo ay gagawa ng iyong account upang makahanap ng mga trabahong para sa iyo!">
                🔊
            </button>
        </div>

        <!-- Steps Section -->
        <div class="mt-10 sm:mt-12 max-w-4xl mx-auto space-y-8">

            <!-- Section Header -->
            <div
                class="flex flex-col sm:flex-row items-center sm:items-start gap-3 sm:gap-4 mb-4 sm:mb-8 text-center sm:text-left">
                <img src="image/targeticon.png" alt="Target Icon" class="w-10 sm:w-12 mx-auto sm:mx-0">
                <h3
                    class="text-xl sm:text-2xl text-blue-600 font-bold flex items-center gap-2 flex-wrap justify-center sm:justify-start">
                    Here's what we'll do:
                    <span class="text-gray-700 italic text-base sm:text-lg block sm:inline">
                        (Pagkakasunod-sunod ng paggawa ng account)
                    </span>
                    <button type="button" class="text-2xl sm:text-3xl hover:scale-110 transition-transform tts-btn"
                    data-tts-en="Here's what we'll do:" data-tts-tl="Pagkakasunod-sunod ng paggawa ng account">
                   🔊
                  </button>
                </h3>
            </div>

            <!-- Step Items -->
            <div class="space-y-6">

                <!-- Step 1 -->
                <div
                    class="bg-white rounded-3xl p-5 sm:p-6 border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-lg hover:shadow-xl transition relative">
                    <img src="image/1icon.png" alt="Step 1" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-16">
                        <p class="font-bold text-lg sm:text-xl text-gray-900 leading-relaxed">
                            Enter the required information, then wait for admin approval.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-base sm:text-lg">
                            (Ilagay ang impormasyon na kailangan, at hintayin ang kumpirmasyon ng admin bago
                            magpatuloy.)
                        </p>
                    </div>

                    <!-- Audio Button -->
                    <button type="button"
                        class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Enter the required information, then wait for admin approval." data-tts-tl="Ilagay ang impormasyon na kailangan, at hintayin ang kumpirmasyon ng admin bago magpatuloy.">
                        🔊
                    </button>
                </div>

                <!-- Step 2 -->
                <div
                    class="bg-white rounded-3xl p-5 sm:p-6 border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-lg hover:shadow-xl transition relative">
                    <img src="image/2icon.png" alt="Step 2" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-16">
                        <p class="font-bold text-lg sm:text-xl text-gray-900">
                            Set up your profile, first tell us about your education and work experience.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-base sm:text-lg">
                            (Ayusin ang iyong profile, una ay ibahagi ang iyong pinag-aralan at karanasan sa trabaho.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Set up your profile, first tell us about your education and work experience." data-tts-tl="Ayusin ang iyong profile, una ay ibahagi ang iyong pinag-aralan at karanasan sa trabaho.">
                        🔊
                    </button>
                </div>

                <!-- Step 3 -->
                <div
                    class="bg-white rounded-3xl p-5 sm:p-6 border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-lg hover:shadow-xl transition relative">
                    <img src="image/3icon.png" alt="Step 3" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-16">
                        <p class="font-bold text-lg sm:text-xl text-gray-900">
                            Choose the support you need and the workplace you like.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-base sm:text-lg">
                            (Piliin ang suportang kailangan mo at ang uri ng lugar ng trabaho na gusto mo.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Choose the support you need and the workplace you like." data-tts-tl="Piliin ang suportang kailangan mo at ang uri ng lugar ng trabaho na gusto mo.">
                        🔊
                    </button>
                </div>

                <!-- Step 4 -->
                <div
                    class="bg-white rounded-3xl p-5 sm:p-6 border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-lg hover:shadow-xl transition relative">
                    <img src="image/4icon.png" alt="Step 4" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-16">
                        <p class="font-bold text-lg sm:text-xl text-gray-900">
                            Choose your skills.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-base sm:text-lg">
                            (Pumili ng mga kakayahan na meron ka.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Choose your skills." data-tts-tl="Pumili ng mga kakayahan na meron ka.">
                        🔊
                    </button>
                </div>

                <!-- Step 5 -->
                <div
                    class="bg-white rounded-3xl p-5 sm:p-6 border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-lg hover:shadow-xl transition relative">
                    <img src="image/5icon.png" alt="Step 5" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-16">
                        <p class="font-bold text-lg sm:text-xl text-gray-900">
                            Select the jobs you like.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-base sm:text-lg">
                            (Piliin ang mga uri ng trabaho na gusto mo.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Select the jobs you like." data-tts-tl="Piliin ang mga uri ng trabaho na gusto mo.">
                        🔊
                    </button>
                </div>

                <!-- Step 6 -->
                <div
                    class="bg-white rounded-3xl p-5 sm:p-6 border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow-lg hover:shadow-xl transition relative">
                    <img src="image/6icon.png" alt="Step 6" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-16">
                        <p class="font-bold text-lg sm:text-xl text-gray-900">
                            Review your answers and finish.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-base sm:text-lg">
                            (I-review ang impormasyong iyong inilagay at tapusin.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-4 right-4 bg-[#1E40AF] text-white text-xl sm:text-2xl p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Review your answers and finish." data-tts-tl="I-review ang impormasyong iyong inilagay at tapusin.">
                        🔊
                    </button>
                </div>

                <!-- Next Button -->
                <div class="flex flex-col items-center mt-14 sm:mt-16">
                    <button
                        class="bg-[#2E2EFF] text-white text-2xl sm:text-3xl font-bold px-20 sm:px-28 md:px-32 py-4 sm:py-5 rounded-3xl shadow-lg hover:bg-blue-700 active:scale-95 transition"
                        onclick="window.location.href='{{ route('register2') }}'">
                        Next →
                    </button>
                    <p
                        class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
                        Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue<br
                            class="hidden sm:block">
                        <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang
                            magpatuloy)</span>
                    </p>
                </div>

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
