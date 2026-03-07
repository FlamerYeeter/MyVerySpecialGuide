<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Applicant Registration</title>
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

<body class="bg-white flex justify-center sm:items-center items-start min-h-screen p-4 sm:p-6 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-1 sm:left-4 md:left-10 top-1/3 w-16 sm:w-24 md:w-32 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-1 sm:left-4 md:left-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-20 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-1 sm:right-4 md:right-10 top-1/4 w-16 sm:w-24 md:w-32 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-1 sm:right-4 md:right-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-24 md:w-36 opacity-90 animate-float-medium z-0">


    <!-- Back Button -->
    <button
        class="fixed left-2 top-2 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl flex items-center gap-2 sm:gap-3 text-sm sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
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
            <h1 class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Registration
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">

            <h2 class="relative flex flex-wrap items-center justify-center gap-3 text-lg sm:text-2xl md:text-3xl text-blue-600 font-bold">
                <span class="block mx-auto max-w-[82%] sm:max-w-none md:max-w-[85%] text-center md:pr-12">Step-by-step guide to complete your registration</span>
                <button aria-label="Read instructions"
                    class="ml-2 md:ml-3 text-sm sm:text-2xl bg-[#1E40AF] text-white p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn md:absolute md:right-3 md:top-1/2 md:-translate-y-1/2"
                    data-tts-en="Step-by-step guide to complete your registration."
                    data-tts-tl="Narito ang lahat ng hakbang para sa iyong registration.">🔊</button>
            </h2>
            <p class="mt-2 sm:mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Narito ang lahat ng hakbang para sa iyong registration.)
            </p>
        </div>

        <!-- Steps Section -->
        <div class="mt-10 sm:mt-12 max-w-4xl mx-auto space-y-8">


            <!-- Step Items -->
            <div class="space-y-6">

                <!-- Step 1 -->
                <div
                    class="bg-white rounded-3xl p-4 sm:p-5 md:p-6 border-2 sm:border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow sm:shadow-lg hover:shadow-xl transition relative">
                    <img src="image/1icon.png" alt="Step 1" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-6 sm:pr-16">
                        <p class="font-bold text-base sm:text-lg text-gray-700 leading-relaxed">
                            Provide your required personal information.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-sm sm:text-base">
                            (Ibigay ang mga kinakailangang personal na impormasyon.)
                        </p>
                    </div>

                    <!-- Audio Button -->
                    <button type="button"
                        class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Provide your required personal information.." data-tts-tl="Ibigay ang mga kinakailangang personal na impormasyon.">
                        🔊
                    </button>
                </div>

                <!-- Step 2 -->
                <div
                    class="bg-white rounded-3xl p-4 sm:p-5 md:p-6 border-2 sm:border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow sm:shadow-lg hover:shadow-xl transition relative">
                    <img src="image/2icon.png" alt="Step 2" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-6 sm:pr-16">
                        <p class="font-bold text-base sm:text-lg text-gray-700">
                            Set up your profile by telling us about your education and work experience.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-sm sm:text-base">
                            (I-set up ang iyong profile sa pamamagitan ng pagbibigay ng impormasyon tungkol sa iyong edukasyon at karanasan sa trabaho.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Set up your profile by telling us about your education and work experience." 
                        data-tts-tl="I-set up ang iyong profile sa pamamagitan ng pagbibigay ng impormasyon tungkol sa iyong edukasyon at karanasan sa trabaho.">
                        🔊
                    </button>
                </div>

                <!-- Step 3 -->
                <div
                    class="bg-white rounded-3xl p-4 sm:p-5 md:p-6 border-2 sm:border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow sm:shadow-lg hover:shadow-xl transition relative">
                    <img src="image/3icon.png" alt="Step 3" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-6 sm:pr-16">
                        <p class="font-bold text-base sm:text-lg text-gray-700">
                            Choose the work environment that you are most comfortable with.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-sm sm:text-base">
                            (Piliin ang work environment kung saan ka pinakakomportable.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Choose the work environment that you are most comfortable with." 
                        data-tts-tl="Piliin ang work environment kung saan ka pinakakomportable.">
                        🔊
                    </button>
                </div>

                <!-- Step 4 -->
                <div
                    class="bg-white rounded-3xl p-4 sm:p-5 md:p-6 border-2 sm:border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow sm:shadow-lg hover:shadow-xl transition relative">
                    <img src="image/4icon.png" alt="Step 4" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-6 sm:pr-16">
                        <p class="font-bold text-base sm:text-lg text-gray-700">
                            Choose the skills that best describe you.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-sm sm:text-base">
                            (Piliin ang mga kasanayan na pinakaangkop na naglalarawan sa iyo.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Choose the skills that best describe you." 
                        data-tts-tl="Piliin ang mga kasanayan na pinakaangkop na naglalarawan sa iyo.">
                        🔊
                    </button>
                </div>

                <!-- Step 5 -->
                <div
                    class="bg-white rounded-3xl p-4 sm:p-5 md:p-6 border-2 sm:border-4 border-blue-300 flex flex-col sm:flex-row items-center sm:items-start gap-5 shadow sm:shadow-lg hover:shadow-xl transition relative">
                    <img src="image/5icon.png" alt="Step 5" class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0">
                    <div class="flex-1 text-center sm:text-left pr-6 sm:pr-16">
                        <p class="font-bold text-base sm:text-lg text-gray-700">
                            Choose the jobs you prefer to do, then finish your registration.
                        </p>
                        <p class="mt-2 text-gray-700 italic text-sm sm:text-base">
                            (Piliin ang mga trabahong nais mong gawin, tapos tapusin ang iyong pagregister.)
                        </p>
                    </div>
                    <button type="button"
                        class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                        data-tts-en="Choose the jobs you prefer to do, then finish your registration." 
                        data-tts-tl="Piliin ang mga trabahong nais mong gawin, tapos tapusin ang iyong pagregister.">
                        🔊
                    </button>
                </div>

                
        <!-- Info Section -->
        <div
            class="mt-8 sm:mt-10 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md relative">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pr-6 sm:pr-16">
                <span class="text-[#846506] text-3xl sm:text-5xl mt-1 flex-shrink-0">💡</span>
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-base sm:text-lg text-blue-600 font-bold leading-relaxed">
                        Start your registration so we can recommend jobs that are perfect for you!
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Simulan ang iyong pagpaparehistro para ma-rekomenda namin ang mga trabahong swak para sa iyo!)
                    </p>
                </div>
            </div>

            <!-- Audio Button -->
            <button type="button"
                class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                data-tts-en="Start your registration so we can recommend jobs that are perfect for you!" 
                data-tts-tl="Simulan ang iyong pagpaparehistro para ma-rekomenda namin ang mga trabahong swak para sa iyo!">
                🔊
            </button>
        </div>

                <!-- Next Button -->
                <div class="flex flex-col items-center mt-14 sm:mt-16 w-full px-4 sm:px-0">
                    <button
                        class="w-full sm:w-auto bg-[#2E2EFF] text-white text-2xl sm:text-3xl font-bold px-8 sm:px-20 md:px-32 py-3 sm:py-4 rounded-3xl shadow-lg hover:bg-blue-700 active:scale-95 transition"
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
                                ut.onend = function () {
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

            window.addEventListener('beforeunload', function () {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });

            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function () {
                    populateVoices();
                };
            }
        });
    </script>

</body>
</html>
