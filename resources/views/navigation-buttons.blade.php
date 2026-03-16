@extends('layouts.includes')

@section('content')
    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        .tts-btn.speaking {
            background-color: #2563eb !important;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
            transform: scale(1.03);
        }
        .tts-btn { padding: 0.55rem 0.6rem; border-radius: 9999px; }
        @media (max-width: 640px) {
            .tts-btn { padding: 0.6rem; font-size: 1.05rem; }
        }
    </style>

    <!-- Back Button 
    <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
        <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
            <a href="/jobmatches"
                class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Jobs</span>
            </a>
        </div>
    </div> -->

    <main class="px-4 sm:px-8 md:px-12 lg:px-16 py-6 sm:py-8 md:py-12 lg:py-16 max-w-7xl mx-auto">

        {{-- <!-- Title -->
        <h2 class="text-4xl font-bold text-center text-[#1E40AF] mb-8 flex items-center justify-center gap-3">
            <i class="ri-compass-3-line text-[#2563EB] text-5xl"></i>
            The Navigation Buttons
        </h2>

        <p class="text-center text-lg text-gray-700 mb-10">
            These buttons help you move around the website easily.
            <span class="block text-gray-600 italic text-base mt-1">
                (Ang mga pindutan na ito ay tutulong sa’yo na makalibot sa website nang madali.)
            </span>
        </p>

        <!-- Info Box -->
        <div class="bg-green-100 border-4 border-green-400 rounded-3xl p-6 mb-10 text-center shadow-md">
            <h3 class="font-bold text-2xl text-green-800 mb-3 flex items-center justify-center gap-3">
                <img src="image/bulb.png" alt="Bulb Icon" class="w-6 h-6 object-contain">
                What is the Navigation Bar?
            </h3>
            <p class="text-gray-800 text-lg leading-relaxed">
                It’s the blue bar at the top of the page that helps you go to different parts of the website.
            </p>
            <p class="text-gray-700 text-base italic mt-2">
                (Ito ang asul na bar sa itaas ng pahina na tumutulong sa’yo pumunta sa iba’t ibang bahagi ng website.)
            </p>
        </div> --}}


        <!-- NAVIGATION CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8 lg:gap-12 justify-center items-stretch">


            
            <!-- Card 1: Job Matches -->
            <a href="{{ route('job.matches') }}" class="block h-full">
                <div
                    class="relative bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-4 sm:p-6 md:p-8 hover:bg-blue-50 transition-all h-full">
                    <div class="flex flex-row md:flex-col items-center gap-2 sm:gap-4 md:gap-3">
                        <div class="bg-orange-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0 md:mb-2">
                            <img src="{{ asset('image/bagicon.png') }}" class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16" alt="">
                        </div>
                        <div class="md:text-center">
                            <h4 class="text-[#1E3A8A] font-bold text-xl sm:text-2xl">Jobs</h4>
                            <p class="text-gray-700 text-base sm:text-lg mt-2">Explore job opportunities that match your skills and interests. Click here to get started.</p>
                            <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Tingnan ang mga trabahong tumutugma sa iyong mga kakayahan at interes. I-click dito para makapagsimula.)</p>
                        </div>
                    </div>
                    <button type="button" class="absolute top-1 right-1 md:top-2 md:right-2 bg-[#1E40AF] hover:bg-blue-700 text-white p-2 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400" 
                     data-tts-en="Jobs.Explore job opportunities that match your skills and interests. Click here to get started." 
                     data-tts-tl="Tingnan ang mga trabahong tumutugma sa iyong mga kakayahan at interes. I-click dito para makapagsimula." aria-label="Play audio for Job Matches card">🔊</button>
                </div>
            </a>

            <!-- Card 2: Saved Jobs -->
            <a href="{{ route('saved') }}" class="block h-full">
                <div
                    class="relative bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-4 sm:p-6 md:p-8 hover:bg-blue-50 transition-all h-full">
                    <div class="flex flex-row md:flex-col items-center gap-2 sm:gap-4 md:gap-3">
                        <div class="bg-yellow-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0 md:mb-2">
                            <img src="{{ asset('image/savedicon.png') }}" class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16" alt="Saved Jobs Icon">
                        </div>
                        <div class="md:text-center">
                            <h4 class="text-[#1E3A8A] font-bold text-xl sm:text-2xl">Saved Jobs</h4>
                            <p class="text-gray-700 text-base sm:text-lg mt-2">Click here to view all the jobs you saved for
                                later.</p>
                            <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Pindutin ito upang tingnan ang lahat ng
                                trabahong iyong na save para balikan sa susunod.)</p>
                        </div>
                    </div>
                    <button type="button" class="absolute top-1 right-1 md:top-2 md:right-2 bg-[#1E40AF] hover:bg-blue-700 text-white p-2 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400" 
                    data-tts-en="Saved Jobs. Click here to view all the jobs you saved for later." 
                    data-tts-tl="Pindutin upang makita ang mga trabahong na-save mo." aria-label="Play audio for Saved Jobs card">🔊</button>
                </div>
            </a>

            <!-- Card 3: Job Application -->
            <a href="{{ route('my.job.applications') }}" class="block h-full">
                <div
                    class="relative bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-4 sm:p-6 md:p-8 hover:bg-blue-50 transition-all h-full">
                    <div class="flex flex-row md:flex-col items-center gap-2 sm:gap-4 md:gap-3">
                        <div class="bg-pink-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0 md:mb-2">
                            <img src="{{ asset('image/my-job-app.png') }}" class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16" alt="">
                        </div>
                        <div class="md:text-center">
                            <h4 class="text-[#1E3A8A] font-bold text-xl sm:text-2xl">Job Applications</h4>
                            <p class="text-gray-700 text-base sm:text-lg mt-2">Click here to track your application progress and manage your job applications</p>
                            <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Pindutin ito upang i-track ang iyong application progress at pamahalaan ang iyong mga job applications.)</p>
                        </div>
                    </div>
                    <button type="button" class="absolute top-1 right-1 md:top-2 md:right-2 bg-[#1E40AF] hover:bg-blue-700 text-white p-2 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400" 
                    data-tts-en="My Job Applications. Click here to track your application progress and manage your job applications" 
                    data-tts-tl="Pindutin upang subaybayan ang iyong aplikasyon at pamahalaan ang mga ito." aria-label="Play audio for My Job Applications card">🔊</button>
                </div>
            </a>



    </main>

<!-- TTS: Web Speech API handler -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.tts-btn');
        const preferredEnglishVoiceName =
            'Microsoft AvaMultilingual Online (Natural) - English (United States)';
        const preferredTagalogVoiceName = 'fil-PH-RosaNeural';
        let preferredEnglishVoice = null;
        let preferredTagalogVoice = null;
        let currentBtn = null;
        let availableVoices = [];

        function populateVoices() {
            availableVoices = window.speechSynthesis.getVoices() || [];
            preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName) ||
                availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) ||
                null;
            preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName) ||
                availableVoices.find(v => /rosa|blessica|fil-?ph|filipino|tagalog/i.test(v.name)) ||
                null;
        }

        function chooseVoiceForLang(langCode) {
            if (!availableVoices.length) return null;
            langCode = (langCode || '').toLowerCase();
            let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
            if (candidates.length) return pickBest(candidates);
            candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i
                .test(v.name));
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

        buttons.forEach(function(btn) {
            btn.setAttribute('role', 'button');
            btn.setAttribute('tabindex', '0');

            btn.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                // nothing to speak
                if (!textEn && !textTl) return;

                // If same button clicked while speaking, stop
                if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn ===
                    btn) {
                    stopSpeaking();
                    return;
                }

                // Stop any existing speech then speak new text(s)
                stopSpeaking();

                // Small timeout to ensure previous utterance canceled
                setTimeout(function() {
                    if (!window.speechSynthesis) return;

                    // Helper to pick voice for a given language (or selected by user)
                    function voiceFor(langHint) {
                        if (langHint) {
                            const hint = (langHint || '').toLowerCase();
                            if (hint.startsWith('tl') || hint.startsWith('fil') || hint
                                .includes('tagalog')) {
                                if (preferredTagalogVoice) return preferredTagalogVoice;
                                return chooseVoiceForLang('tl');
                            }
                            if (hint.startsWith('en')) {
                                if (preferredEnglishVoice) return preferredEnglishVoice;
                                return chooseVoiceForLang('en');
                            }
                        }
                        return preferredEnglishVoice || chooseVoiceForLang('en') || (
                            availableVoices.length ? availableVoices[0] : null);
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
                        uTl.lang = 'fil-PH';
                        const v2 = voiceFor('tl');
                        if (v2) uTl.voice = v2;
                        seq.push(uTl);
                    }

                    if (!seq.length) return;

                    // Attach lifecycle handlers to the sequence
                    seq[0].onstart = function() {
                        btn.classList.add('speaking');
                        btn.setAttribute('aria-pressed', 'true');
                        currentBtn = btn;
                    };

                    // chain subsequent utterances
                    for (let i = 0; i < seq.length; i++) {
                        const ut = seq[i];
                        ut.onerror = function() {
                            if (btn) btn.classList.remove('speaking');
                            if (btn) btn.removeAttribute('aria-pressed');
                            currentBtn = null;
                        };
                        if (i < seq.length - 1) {
                            ut.onend = function() {
                                // speak next
                                window.speechSynthesis.speak(seq[i + 1]);
                            };
                        } else {
                            ut.onend = function() {
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
            btn.addEventListener('keydown', function(ev) {
                if (ev.key === 'Enter' || ev.key === ' ') {
                    ev.preventDefault();
                    ev.stopPropagation();
                    btn.click();
                }
            });
        });

        // Stop speech when navigating away or reloading
        window.addEventListener('beforeunload', function() {
            if (window.speechSynthesis) window.speechSynthesis.cancel();
        });
        // populate voices now or when they change
        if (window.speechSynthesis) {
            populateVoices();
            window.speechSynthesis.onvoiceschanged = function() {
                populateVoices();
            };
        }

        // No preview UI: when voices are populated we attempt to use the preferred Microsoft AvaMultilingual voice
    });
</script>
@endsection

<!-- Ensure Firebase config + auth guard for navigation page -->
{{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
{{-- <script>
    @auth
    window.__SERVER_AUTH = true;
    @else
        window.__SERVER_AUTH = false;
    @endauth
</script>
<script type="module">
    (async function() {
        try {
            const mod = await import("{{ asset('js/job-application-firebase.js') }}");
            const logger = await import("{{ asset('js/client-logger.js') }}");
            console.debug('nav auth guard: waiting for sign-in resolution (7s)');
            // If we have a Laravel session, request a server-issued Firebase custom token
            // and sign the client in. This will make auth.currentUser non-null.
            try {
                <!-- firebase.token removed -->
            } catch (e) {
                console.debug('nav signInWithServerToken failed', e);
                try {
                    logger.sendClientLog('debug', 'nav signInWithServerToken failed', {
                        error: String(e)
                    });
                } catch (_) {}
            }
            const signed = await mod.isSignedIn(7000);
            console.debug('nav auth guard: isSignedIn ->', signed);
            try {
                if (mod && typeof mod.debugAuthLogging === 'function') window.__unsubAuthLog = mod
                    .debugAuthLogging();
            } catch (e) {
                console.warn('nav debugAuthLogging failed', e);
                try {
                    logger.sendClientLog('warning', 'nav debugAuthLogging failed', {
                        error: String(e)
                    });
                } catch (_) {}
            }
            if (!signed) {
                if (window.__SERVER_AUTH) {
                    console.info('nav auth guard: server session present, not redirecting');
                    try {
                        logger.sendClientLog('info',
                        'nav auth guard: server session present, not redirecting', {});
                    } catch (_) {}
                    return;
                }
                const current = window.location.pathname + window.location.search;
                try {
                    logger.sendClientLog('info', 'nav auth guard: redirecting to login', {
                        redirect: current
                    });
                } catch (_) {}
                window.location.href = 'login?redirect=' + encodeURIComponent(current);
                return;
            }
        } catch (err) {
            console.error('nav auth guard failed', err);
            try {
                (await import("{{ asset('js/client-logger.js') }}")).sendClientLog('error',
                    'nav auth guard failed', {
                        error: String(err)
                    });
            } catch (_) {}
        }
    })();
</script> --}}
