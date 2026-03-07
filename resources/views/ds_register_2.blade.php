<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Applicant Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            onclick="(history.length>1 ? history.back() : window.location.href='{{ route('register') }}')">
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
            <h1 class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Registration</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">
            <h2 class="relative flex flex-wrap items-center justify-center gap-3 text-xl sm:text-2xl md:text-3xl text-blue-600 font-bold">
                <span class="block mx-auto max-w-[82%] sm:max-w-none md:max-w-[85%] text-center md:pr-12">Let’s get your registration started!</span>
                <button type="button" aria-label="Play audio: Let’s get your registration started"
                    class="ml-2 md:ml-3 text-sm sm:text-2xl bg-[#1E40AF] text-white p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn md:absolute md:right-3 md:top-1/2 md:-translate-y-1/2"
                    data-tts-en="Let’s get your registration started!" data-tts-tl="Simulan na natin ang iyong pagregister!">
                    🔊
                </button>
            </h2>
            <p class="mt-2 sm:mt-3 text-gray-700 italic text-base sm:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Simulan na natin ang iyong pagregister!)
            </p>
        </div>

<!-- Info Section -->
<div
    class="relative mt-10 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 md:p-8 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md overflow-hidden">

    <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-4 sm:gap-6">

        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Account Icon"
            class="w-10 h-10 sm:w-14 sm:h-14 flex-shrink-0">

        <div class="flex-1">
            <p class="text-base sm:text-lg text-gray-700 font-semibold leading-relaxed">
                Don’t worry! We will help you complete your registration easily and guide you every step of the way.
            </p>

            <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                (Wag mag-alala! Tutulungan ka naming tapusin ang iyong pagregister nang madali at gagabayan ka sa bawat hakbang.)
            </p>

            <!--  Audio Button -->
            <div class="mt-3 flex justify-end">
                <button type="button" aria-label="Play audio: Info message"
                    class="bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-sm sm:shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 focus:outline-none tts-btn"
                    data-tts-en="Don’t worry! We will help you complete your registration easily and guide you every step of the way."
                    data-tts-tl="Huwag mag-alala! Tutulungan ka naming tapusin ang iyong pagregister nang madali at gagabayan ka sa bawat hakbang.">
                    🔊
                </button>
            </div>

        </div>
    </div>
</div>


<!-- Instruction Section -->
<div class="mt-10 sm:mt-12 max-w-4xl mx-auto space-y-6 sm:space-y-8">

    <div
        class="relative bg-white rounded-3xl p-5 sm:p-6 md:p-8 border-4 border-blue-300 shadow-lg hover:shadow-xl transition">

        <div class="text-center sm:text-left">

            <h3 class="text-xl sm:text-2xl text-blue-600 font-bold mb-4">
                Instructions
                <span class="block sm:inline text-lg italic">(Panuto)</span>
            </h3>

            <ul class="list-disc list-inside text-gray-800 text-base sm:text-lg space-y-2 text-left sm:text-left mx-auto sm:mx-0 max-w-xl">
                <li>You can go back and change your answers.</li>
                <li>Take your time, there is no rush.</li>
                <li>We will help you every step of the way.</li>
                <li>Press the audio button anytime to hear instructions.</li>
            </ul>

            <p class="text-gray-600 italic text-base sm:text-lg mt-4 text-center sm:text-left">
                (Maaari kang bumalik at baguhin ang iyong mga sagot. Maglaan ng oras, huwag magmadali.
                Tutulungan ka namin sa bawat hakbang.)
            </p>

            <div class="mt-5 text-center sm:text-left">
                <p class="font-bold text-base sm:text-lg text-red-600">
                    Reminder:
                    <span class="block sm:inline">
                        Do not forget to review or check your answers before moving to the next page.
                    </span>
                </p>

                <p class="mt-2 text-red-600 italic text-sm sm:text-base">
                    (Paalala: Huwag kalimutang i-check ang iyong mga sagot bago pumunta sa susunod na pahina.)
                </p>

                <!-- Audio Button -->
                <div class="-mt-3 sm:-mt-2 flex justify-end">
                    <button type="button" aria-label="Play audio: Instructions and reminder"
                        class="bg-[#1E40AF] text-white text-lg sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-700 hover:scale-105 transition-transform duration-200 tts-btn"
                        data-tts-en="Instructions: You can go back and change your answers. Take your time there is no rush. We will help you every step of the way. Press the audio button anytime to hear instructions.\nReminder: Do not forget to review or check your answers before moving to the next page."
                        data-tts-tl="Panuto: Maaari kang bumalik at baguhin ang iyong mga sagot. Maglaan ng oras, huwag magmadali. Tutulungan ka namin sa bawat hakbang.\nPaalala: Huwag kalimutang i-check ang iyong mga sagot bago pumunta sa susunod na pahina.">
                        🔊
                    </button>
                </div>
            </div>
        </div>
    </div>

                   
        <!-- Next Button -->
        <div class="flex flex-col items-center mt-10 sm:mt-14 space-y-4">
            <button
                class="bg-[#2E2EFF] text-white text-2xl sm:text-3xl font-bold px-20 sm:px-28 md:px-32 py-4 sm:py-5 rounded-3xl shadow-lg hover:bg-blue-600 active:scale-95 transition"
                onclick="window.location.href='{{ route('dataprivacy') }}'">
                Next →
            </button>
            <p class="text-gray-700 text-sm sm:text-base md:text-lg text-center leading-relaxed px-4 sm:px-0">
                Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue<br class="hidden sm:block">
                <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
            </p>
        </div>
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
            let audioFallback = null;

            function populateVoices() {
                availableVoices = (window.speechSynthesis && window.speechSynthesis.getVoices()) || [];
                preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName)
                    || availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name))
                    || null;
                preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName)
                    || availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name))
                    || null;
            }

            function waitForVoices(timeout = 1200) {
                return new Promise((resolve) => {
                    populateVoices();
                    if (availableVoices.length) return resolve(true);
                    const start = Date.now();
                    const iv = setInterval(() => {
                        populateVoices();
                        if (availableVoices.length || Date.now() - start > timeout) {
                            clearInterval(iv);
                            resolve(availableVoices.length > 0);
                        }
                    }, 120);
                });
            }

            function pickBest(list) {
                const preferred = list.filter(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
                return (preferred.length ? preferred[0] : list[0]) || null;
            }

            function chooseVoiceForLang(langCode) {
                if (!availableVoices.length) return null;
                langCode = (langCode || '').toLowerCase();
                let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                if (candidates.length) return pickBest(candidates);
                candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
                if (candidates.length) return pickBest(candidates);
                return availableVoices[0] || null;
            }

            function stopSpeaking() {
                try { if (window.speechSynthesis) window.speechSynthesis.cancel(); } catch (e) { }
                if (audioFallback) { audioFallback.pause(); audioFallback.currentTime = 0; audioFallback = null; }
                if (currentBtn) { currentBtn.classList.remove('speaking'); currentBtn.removeAttribute('aria-pressed'); currentBtn = null; }
            }

            function playAudioFallback(btn, src) {
                if (!src) return false;
                stopSpeaking();
                audioFallback = new Audio(src);
                audioFallback.crossOrigin = 'anonymous';
                btn.classList.add('speaking');
                btn.setAttribute('aria-pressed', 'true');
                currentBtn = btn;
                audioFallback.onended = function () { stopSpeaking(); };
                audioFallback.onerror = function () { stopSpeaking(); };
                audioFallback.play().catch(() => { stopSpeaking(); });
                return true;
            }

            function speakWithSynthesis(btn, textEn, textTl) {
                if (!window.speechSynthesis) return false;
                const seq = [];
                if (textEn) {
                    const uEn = new SpeechSynthesisUtterance(textEn);
                    uEn.lang = 'en-US';
                    const v = preferredEnglishVoice || chooseVoiceForLang('en');
                    if (v) uEn.voice = v;
                    uEn.rate = 1; uEn.pitch = 1;
                    seq.push(uEn);
                }
                if (textTl) {
                    const uTl = new SpeechSynthesisUtterance(textTl);
                    uTl.lang = 'tl-PH';
                    const v2 = preferredTagalogVoice || chooseVoiceForLang('tl');
                    if (v2) uTl.voice = v2;
                    uTl.rate = 1; uTl.pitch = 1;
                    seq.push(uTl);
                }
                if (!seq.length) return false;
                stopSpeaking();
                seq[0].onstart = function () { btn.classList.add('speaking'); btn.setAttribute('aria-pressed', 'true'); currentBtn = btn; };
                for (let i = 0; i < seq.length; i++) {
                    const ut = seq[i];
                    ut.onerror = function () { stopSpeaking(); };
                    if (i < seq.length - 1) ut.onend = function () { window.speechSynthesis.speak(seq[i + 1]); };
                    else ut.onend = function () { stopSpeaking(); };
                }
                try { window.speechSynthesis.speak(seq[0]); return true; } catch (e) { return false; }
            }

            buttons.forEach(function (btn) {
                btn.setAttribute('role', 'button'); btn.setAttribute('tabindex', '0');
                btn.addEventListener('click', async function () {
                    const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                    const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                    const fallbackSrc = btn.getAttribute('data-tts-src');
                    if (!textEn && !textTl && !fallbackSrc) return;
                    if (currentBtn === btn && (window.speechSynthesis && window.speechSynthesis.speaking)) { stopSpeaking(); return; }
                    stopSpeaking();
                    try {
                        const synthesisAvailable = !!window.speechSynthesis;
                        if (synthesisAvailable) {
                            const voicesReady = await waitForVoices(1500);
                            if (voicesReady) { const ok = speakWithSynthesis(btn, textEn, textTl); if (ok) return; }
                        }
                    } catch (e) { }
                    if (fallbackSrc) { if (playAudioFallback(btn, fallbackSrc)) return; }
                    try { speakWithSynthesis(btn, textEn, textTl); } catch (e) { stopSpeaking(); }
                });
                btn.addEventListener('keydown', function (ev) { if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); btn.click(); } });
            });

            function warmVoicesOnce() { if (!window.speechSynthesis) return; populateVoices(); window.speechSynthesis.getVoices(); window.removeEventListener('pointerdown', warmVoicesOnce); window.removeEventListener('touchstart', warmVoicesOnce); }
            window.addEventListener('pointerdown', warmVoicesOnce, { once: true }); window.addEventListener('touchstart', warmVoicesOnce, { once: true });
            window.addEventListener('beforeunload', function () { stopSpeaking(); });
            if (window.speechSynthesis) { populateVoices(); window.speechSynthesis.onvoiceschanged = populateVoices; }
        });
    </script>

</body>

</html>
