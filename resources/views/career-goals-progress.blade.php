@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    {{-- Insert small CSS for TTS speaking state --}}
    <style>
    /* TTS speaking state for audio buttons (minimal) */
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
        color: #fff;
    }
    </style>

    <div class="font-sans bg-white text-gray-800">

        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
            <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
                <a href="/job-matches"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Jobs</span>
                </a>
            </div>
        </div>

        <!-- HERO SECTION -->
        <section class="bg-[#10B981] py-10 text-center shadow-md rounded-b-3xl">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('image/targeticon.png') }}" alt="Goals Icon" class="w-24 h-24 mb-3 animate-bounce-slow">
                <h2 class="text-4xl font-extrabold text-white tracking-wide drop-shadow-md">
                    Assessment Progress
                </h2>
                <p class="text-lg text-white/90 mt-2">
                    Track your asessment progress and improve your skills step by step
                </p>
            </div>
        </section>

        <!-- NOTE: THIS IS STILL IN PROGRESS, I'M NOT SURE PANO AANUHIN YAN -->

<!-- STATS SECTION -->
<section class="mt-10 max-w-6xl mx-auto px-6">
  
 <!-- Section Header -->
  <div class="mb-8 text-left">
    <div class="flex items-center gap-4">
      <img src="https://img.icons8.com/color/96/combo-chart--v1.png" 
           alt="Assessment Overview Icon" 
           class="w-20 h-20 animate-bounce-slow">
      <div>
        <h2 class="text-4xl font-extrabold text-[#1E40AF] drop-shadow-md">
          Overview
        </h2>
        <p class="text-lg text-gray-700 mt-2 font-medium">
          See your current progress and accomplishments in your journey
        </p>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
 <!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 justify-center place-items-center">
    
    <!-- Card 1 - IN PROGRESS -->
   {{--<div class="bg-white rounded-2xl shadow-lg p-6 text-center relative border-4 border-yellow-200 hover:scale-105 transition-transform duration-300">
      <button class="absolute top-3 right-3 text-yellow-500 hover:scale-110" title="Play narration">
        <img src="https://img.icons8.com/color/48/speaker.png" class="w-7 h-7" alt="Speaker Icon">
      </button>
      <div class="flex justify-center mb-3">
        <img src="{{ asset('image/progress.png') }}" alt="" class="h-12">
      </div>
      <h3 class="text-4xl font-extrabold text-yellow-500">-</h3>
      <p class="text-gray-700 font-semibold mt-1 text-lg">In Progress</p>
      <p class="text-sm text-gray-500 italic">(Kasalukuyang Ginagawa)</p>
    </div>--}}

     <!-- Card 2 - COMPLETED -->
  <div class="bg-white rounded-2xl shadow-lg p-6 text-center relative border-4 border-green-200 hover:scale-105 transition-transform duration-300 w-full max-w-sm">
    <button
      class="absolute top-3 right-3 text-green-500 hover:scale-110 tts-btn"
      title="Play narration"
      data-tts-en="Completed assessments overview. Completed: -"
      data-tts-tl="Paglalarawan ng mga natapos na pagsusuri. Natapos: -">
      <img src="https://img.icons8.com/color/48/speaker.png" class="w-7 h-7" alt="Speaker Icon">
    </button>
    <div class="flex justify-center mb-3">
      <img src="{{ asset('image/completed.png') }}" alt="" class="h-12">
    </div>
    <h3 class="text-4xl font-extrabold text-green-600">-</h3>
    <p class="text-gray-700 font-semibold mt-1 text-lg">Completed</p>
    <p class="text-sm text-gray-500 italic">(Mga Natapos)</p>
  </div>

  <!-- Card 3 - OVERALL PROGRESS -->
  <div class="bg-white rounded-2xl shadow-lg p-6 text-center relative border-4 border-blue-200 hover:scale-105 transition-transform duration-300 w-full max-w-sm">
    <button
      class="absolute top-3 right-3 text-blue-500 hover:scale-110 tts-btn"
      title="Play narration"
      data-tts-en="Overall progress: - percent"
      data-tts-tl="Kabuuang progreso: - porsyento">
      <img src="https://img.icons8.com/color/48/speaker.png" class="w-7 h-7" alt="Speaker Icon">
    </button>
    <div class="flex justify-center mb-3">
      <img src="{{ asset('image/overall.png') }}" alt="" class="h-12">
    </div>
    <h3 class="text-4xl font-extrabold text-blue-600">-%</h3>
    <p class="text-gray-700 font-semibold mt-1 text-lg">Overall Progress</p>
    <p class="text-sm text-gray-500 italic">(Kabuuang Progreso)</p>
  </div>

</div>
</section>
<!-- PENDING ASSESSMENT SECTION -->
<section class="bg-[#F0F9FF] py-12 px-6 sm:px-12 lg:px-20 mt-16">
  <!-- Header -->
  <div class="flex items-center gap-4 mb-8">
    <img src="https://img.icons8.com/color/96/test-passed.png" alt="Pending Icon" class="w-20 h-20 animate-bounce-slow">
    <div>
      <h2 class="text-4xl font-extrabold text-[#1E40AF] drop-shadow-md">
        Pending Job Training Assessment
      </h2>
      <p class="text-lg text-gray-700 mt-2 font-medium">
        A company will process your assessment.
    </div>
  </div>

  <!-- Job Card -->
  <div
      class="relative bg-white border-2 border-blue-200 rounded-3xl shadow-lg p-10 mb-10 transition-transform hover:scale-[1.02]">
     <h2 class="text-lg font-semibold mb-10">Assessment Progress</h2>

    <div class="flex items-center justify-around w-full">
        <!-- In Progress -->
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6 text-green-500" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="mt-2 text-green-600 font-medium">In Progress</p>
            <p class="text-sm text-gray-600">Aug 25</p>
        </div>

        <!-- Under Review -->
        <div class="flex flex-col items-center opacity-50">
            <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6 text-gray-400" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="mt-2 text-gray-600">Under-review</p>
        </div>

        <!-- Job Ready -->
        <div class="flex flex-col items-center opacity-50">
            <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6 text-gray-400" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="mt-2 text-gray-600">Job Ready</p>
        </div>

        <!-- Decision -->
        <div class="flex flex-col items-center opacity-50">
            <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6 text-gray-400" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="mt-2 text-gray-600">Decision</p>
        </div>
    </div>

    <!-- Status + Time -->
    <div class="flex items-center justify-between mt-10">
        <p class="text-gray-600 text-sm">Last update: 2 hours ago</p>
    </div>
</div>
      <!-- Top Section -->
      {{--<div class="flex flex-col lg:flex-row justify-between items-start gap-8">
          <!-- Company Info -->
          <div class="flex items-start gap-6">
              <!-- Company Logo + Flag -->
              <div class="flex items-center gap-4">
                  <!-- Flag beside Logo -->
                  <button
                      class="flag-btn text-gray-400 text-5xl focus:outline-none hover:text-red-500 transition-all duration-300">
                      <i class="ri-flag-line"></i>
                  </button>

                  <!-- Company Logo -->
                  <div class="flex-shrink-0">
                      @if (!empty($company->logo))
                          <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                              class="w-32 h-32 rounded-2xl border-2 border-gray-300 object-cover">
                      @else
                          <div
                              class="w-32 h-32 flex items-center justify-center rounded-2xl border-4 border-gray-300 bg-gray-50">
                              <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                          </div>
                      @endif
                  </div>
              </div>

              <!-- Job Info -->
              <div>
                  <h3 class="font-bold text-3xl text-gray-900">Pet Care Assistant</h3>
                  <p class="text-gray-700 text-2xl font-medium mt-2">iPet Club</p>
                  <p class="text-gray-600 text-lg mt-1 flex items-center gap-2">
                      <img src="https://img.icons8.com/color/48/marker--v1.png" alt="Location Icon"
                          class="w-6 h-6">
                      <span>Taguig City, Metro Manila</span>
                  </p>

                  <!-- Job Tags -->
                  <div class="flex flex-wrap gap-3 mt-3">
                      <span
                          class="bg-green-100 text-green-700 text-lg px-5 py-2 rounded-md font-semibold">Healthcare</span>
                      <span
                          class="bg-yellow-100 text-yellow-700 text-lg px-5 py-2 rounded-md font-semibold">Quiet</span>
                  </div>
              </div>
          </div>

          <!-- Right: Match Info -->
          <a href="#"
              class="text-[#2563EB] text-2xl font-bold underline hover:underline self-center lg:self-start whitespace-nowrap mt-22 lg:mt-0">
              Why this job match you?
          </a>
      </div>

      <!-- Description -->
      <p class="text-gray-700 text-xl mt-8 leading-relaxed max-w-4xl">
          Help feed animals, clean spaces, and provide companionship.
      </p>

      <!-- Skills -->
      <div class="flex flex-wrap gap-3 mt-6">
          <span class="bg-blue-100 text-blue-700 text-lg font-semibold px-5 py-2 rounded-md">Organization</span>
          <span class="bg-blue-100 text-blue-700 text-lg font-semibold px-5 py-2 rounded-md">Cleaning</span>
          <span class="bg-blue-100 text-blue-700 text-lg font-semibold px-5 py-2 rounded-md">Following Instructions</span>
      </div>

      <!-- Job Type -->
      <div class="flex flex-wrap gap-3 mt-8">
          <span
              class="border border-[#2563EB] text-[#2563EB] text-lg px-5 py-2 rounded-md font-semibold">Full-Time</span>
          <span class="border border-[#88BF02] text-[#88BF02] text-lg px-5 py-2 rounded-md font-semibold">Full Support</span>
          <span class="border border-[#F89596] text-[#F89596] text-lg px-5 py-2 rounded-md font-semibold">Excellent Fit</span>
      </div>

      <!-- Assessment Status Button -->
      <div class="flex justify-end mt-10">
          <button
              class="bg-[#FFAC1D] text-white text-lg font-bold rounded-md px-10 py-3 w-[480px] hover:bg-[#D78203] transition text-center">
              Pending Therapist Job Readiness Assessment
          </button>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end flex-wrap gap-4 mt-4">
          <button
              class="bg-[#55BEBB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#47a4a1] transition">
              Details
          </button>
          <button
              class="bg-[#2563EB] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#1e4fc5] transition">
              Apply
          </button>
          <button
              class="bg-[#008000] text-white text-lg font-bold rounded-md px-10 py-3 w-[150px] hover:bg-[#006400] transition">
              Save
          </button>
      </div>
  </div>
</section>--}}



  <!-- ASSESSMENTS SECTION -->
  <section class="max-w-6xl mx-auto mt-12 mb-20 bg-white rounded-3xl shadow-lg p-10 border-t-8 border-green-400">
    <div class="flex items-center justify-between mb-8">
      <h3 class="text-4xl font-bold text-green-600 flex items-center gap-3">
        <img src="https://img.icons8.com/color/48/star--v1.png" class="w-10 h-10" alt="Star Icon">
        Your Assessments
      </h3>

      {{-- Make this narration button TTS-enabled --}}
      <button
        class="text-green-500 hover:scale-110 tts-btn"
        title="Play narration"
        data-tts-en="Your assessments section. View your current assessments and progress."
        data-tts-tl="Seksyon ng iyong mga pagsusuri. Tingnan ang iyong kasalukuyang mga pagsusuri at progreso.">
        <img src="https://img.icons8.com/color/48/speaker.png" class="w-10 h-10" alt="Speaker Icon">
      </button>
    </div>

    <!-- Goal 1 
    <div
      class="border-2 border-yellow-200 rounded-3xl p-8 mb-8 shadow-sm bg-yellow-50 hover:shadow-md transition-all relative">
      <div class="flex justify-between items-center mb-3">
        <h4 class="font-bold text-2xl text-gray-800">Learn Pet Grooming Techniques</h4>
        <span class="bg-yellow-300 text-yellow-900 px-5 py-2 rounded-full text-base font-semibold">In Progress</span>
      </div>
      <p class="text-lg text-gray-700 mt-2 leading-relaxed">
        Develop expertise in essential pet grooming techniques including cutting, styling, and bathing.
      </p>

      <p class="text-base text-gray-600 mt-5 font-medium">Progress (Pagbuti ng Kakayanan)</p>
      <div class="w-full bg-gray-200 rounded-full h-4 mt-1">
        <div class="bg-green-500 h-4 rounded-full transition-all" style="width: 50%"></div>
      </div>
      <p class="text-right text-base text-gray-600 mt-1 font-semibold">50%</p>

      <button
        class="mt-5 bg-green-500 text-white px-8 py-3 rounded-full hover:bg-green-600 text-lg font-bold transition-transform hover:scale-105 shadow-md">
        View Details
      </button>
      <p class="text-base text-gray-500 italic mt-3">(Pindutin ang “View Details” upang makita ang buong impormasyon)</p>

      <button class="absolute bottom-3 right-3 text-green-500 hover:scale-110" title="Play narration">
        <img src="https://img.icons8.com/color/48/speaker.png" class="w-7 h-7" alt="Speaker Icon">
      </button>
    </div>

    
    <div
      class="border-2 border-green-200 rounded-3xl p-8 bg-green-50 shadow-sm hover:shadow-md transition-all relative">
      <div class="flex justify-between items-center mb-3">
        <h4 class="font-bold text-2xl text-gray-800">Learn Customer Service Skills</h4>
        <span class="bg-green-300 text-green-900 px-5 py-2 rounded-full text-base font-semibold">Completed</span>
      </div>
      <p class="text-lg text-gray-700 mt-2 leading-relaxed">
        Develop strong communication and customer interaction skills for hospitality and retail environments.
      </p>

      <p class="text-base text-gray-600 mt-5 font-medium">Progress (Pagbuti ng Kakayanan)</p>
      <div class="w-full bg-gray-200 rounded-full h-4 mt-1">
        <div class="bg-green-500 h-4 rounded-full transition-all" style="width: 100%"></div>
      </div>
      <p class="text-right text-base text-gray-600 mt-1 font-semibold">100%</p>

      <button
        class="mt-5 bg-green-500 text-white px-8 py-3 rounded-full hover:bg-green-600 text-lg font-bold transition-transform hover:scale-105 shadow-md">
        View Details
      </button>
      <p class="text-base text-gray-500 italic mt-3">(Pindutin ang “View Details” upang makita ang buong impormasyon)</p>

      <button class="absolute bottom-3 right-3 text-green-500 hover:scale-110" title="Play narration">
        <img src="https://img.icons8.com/color/48/speaker.png" class="w-7 h-7" alt="Speaker Icon">
      </button> -->
    </div>
  </section>

</div>


    <!-- BACK TO TOP BUTTON -->
    <button id="backToTopBtn"
        class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
        onclick="scrollToTop()" aria-label="Back to top">

        <!-- Up Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>

        <span>Back to Top</span>
    </button>

    <script>
        // Show/hide the Back to Top button
        const backToTopBtn = document.getElementById("backToTopBtn");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove("hidden");
            } else {
                backToTopBtn.classList.add("hidden");
            }
        });

        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>

    {{-- Insert the TTS Web Speech API handler (copied from register_1) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.tts-btn');
            // prefer separate high-quality voices for English and Tagalog
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
                            // prefer explicit per-language preferred voices when available
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
                            // fallback: prefer English preferred voice, then any reasonable voice
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

@endsection
