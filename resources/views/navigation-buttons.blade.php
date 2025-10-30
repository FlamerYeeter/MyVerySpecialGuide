@extends('layouts.includes')

@section('content')

<!-- Back Button -->
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
</div>

<main class="px-8 sm:px-12 py-10 max-w-7xl mx-auto">

  <!-- Title -->
  <h2 class="text-4xl font-bold text-center text-[#1E40AF] mb-8">
    🧭 The Navigation Buttons
  </h2>
  <p class="text-center text-lg text-gray-700 mb-10">
    These buttons help you move around the website easily.  
    <span class="block text-gray-600 italic text-base mt-1">
      (Ang mga pindutan na ito ay tutulong sa’yo na makalibot sa website nang madali.)
    </span>
  </p>

  <!-- Info Box -->
  <div class="bg-green-100 border-4 border-green-400 rounded-3xl p-6 mb-10 text-center shadow-md">
    <h3 class="font-bold text-2xl text-green-800 mb-3">
      💡 What is the Navigation Bar?
    </h3>
    <p class="text-gray-800 text-lg leading-relaxed">
      It’s the blue bar at the top of the page that helps you go to different parts of the website.
    </p>
    <p class="text-gray-700 text-base italic mt-2">
      (Ito ang asul na bar sa itaas ng pahina na tumutulong sa’yo pumunta sa iba’t ibang bahagi ng website.)
    </p>
  </div>


<!-- NAVIGATION CARDS -->
<div class="grid md:grid-cols-2 gap-10 justify-center items-stretch">

  <!-- Card 1: Job Matches -->
  <a href="{{ route('job.matches') }}" class="block h-full">
    <div class="bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-6 hover:bg-blue-50 hover:shadow-lg transition-all h-full">
      <div class="flex items-center gap-5">
        <div class="bg-orange-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('image/bagicon.png') }}" class="w-14 h-14" alt="">
        </div>
        <div>
          <h4 class="text-[#1E3A8A] font-bold text-2xl">Jobs</h4>
          <p class="text-gray-700 text-lg mt-2">Click here to see jobs perfect for you — matched to your skills and interests.</p>
          <p class="text-gray-600 italic text-base mt-1">(Pindutin ito upang makita ang mga trabahong akma sa iyong kakayahan at interes.)</p>
        </div>
      </div>
    </div>
  </a>

  <!-- Card 2: Saved Jobs -->
  <a href="/" class="block h-full">
    <div class="bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-6 hover:bg-blue-50 hover:shadow-lg transition-all h-full">
      <div class="flex items-center gap-5">
        <div class="bg-yellow-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('image/savedicon.png') }}" class="w-14 h-14" alt="Saved Jobs Icon">
        </div>
        <div>
          <h4 class="text-[#1E3A8A] font-bold text-2xl">Saved Jobs</h4>
          <p class="text-gray-700 text-lg mt-2">Click here to view all the jobs you liked or saved for later.</p>
          <p class="text-gray-600 italic text-base mt-1">(Pindutin ito upang tingnan ang lahat ng trabahong iyong nagustuhan o in-save para balikan sa susunod.)</p>
        </div>
      </div>
    </div>
  </a>

  <!-- Card 3: Goals and Progress -->
  <a href="#" class="block h-full">
    <div class="bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-6 hover:bg-blue-50 hover:shadow-lg transition-all h-full">
      <div class="flex items-center gap-5">
        <div class="bg-red-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('image/targeticon.png') }}" class="w-14 h-14" alt="">
        </div>
        <div>
          <h4 class="text-[#1E3A8A] font-bold text-2xl">Goals and Progress</h4>
          <p class="text-gray-700 text-lg mt-2">Click here to see your goals and how close you are to reaching them!</p>
          <p class="text-gray-600 italic text-base mt-1">(Pinduting ito upang tingnan ang iyong mga layunin at kung gaano kalapit ka sa pag-abot ng mga ito!)</p>
        </div>
      </div>
    </div>
  </a>

  <!-- Card 4: Why This Job -->
  <a href="#" class="block h-full">
    <div class="bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-6 hover:bg-blue-50 hover:shadow-lg transition-all h-full">
      <div class="flex items-center gap-5">
        <div class="bg-pink-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('image/brain.png') }}" class="w-14 h-14" alt="">
        </div>
        <div>
          <h4 class="text-[#1E3A8A] font-bold text-2xl">Why This Job & How to Get There</h4>
          <p class="text-gray-700 text-lg mt-2">Click here to learn why this job fits you and what steps can help you prepare for it.</p>
          <p class="text-gray-600 italic text-base mt-1">(Pindutin ito upang alamin kung bakit ang trabahong ito ay akma sa iyo at kung ano ang mga hakbang na makakatulong upang mapaghandaan ito.)</p>
        </div>
      </div>
    </div>
  </a>

  <!-- Card 5: Profile -->
  <a href="#" class="block h-full">
    <div class="bg-white border-4 border-blue-300 rounded-3xl flex flex-col justify-between p-6 hover:bg-blue-50 hover:shadow-lg transition-all h-full">
      <div class="flex items-center gap-5">
        <div class="bg-purple-200 p-4 rounded-2xl flex items-center justify-center flex-shrink-0">
          <img src="{{ asset('image/profileicon.png') }}" class="w-14 h-14" alt="">
        </div>
        <div>
          <h4 class="text-[#1E3A8A] font-bold text-2xl">Profile</h4>
          <p class="text-gray-700 text-lg mt-2">Click here to view your name, picture, and personal information easily here.</p>
          <p class="text-gray-600 italic text-base mt-1">(Pindutin upang makita dito ang iyong pangalan, larawan, at iba pang impormasyon tungkol sa iyo.)</p>
        </div>
      </div>
    </div>
  </a>
</div>
</main>



@endsection

    <!-- Ensure Firebase config + auth guard for navigation page -->
    <script src="{{ asset('js/firebase-config-global.js') }}"></script>
    <script>
        @auth
            window.__SERVER_AUTH = true;
        @else
            window.__SERVER_AUTH = false;
        @endauth
    </script>
    <script type="module">
        (async function(){
            try {
                const mod = await import("{{ asset('js/job-application-firebase.js') }}");
                const logger = await import("{{ asset('js/client-logger.js') }}");
                console.debug('nav auth guard: waiting for sign-in resolution (7s)');
                // If we have a Laravel session, request a server-issued Firebase custom token
                // and sign the client in. This will make auth.currentUser non-null.
                try {
                    await mod.signInWithServerToken("{{ route('firebase.token') }}");
                } catch(e) { console.debug('nav signInWithServerToken failed', e); try { logger.sendClientLog('debug', 'nav signInWithServerToken failed', {error: String(e)}); } catch(_) {} }
                const signed = await mod.isSignedIn(7000);
                console.debug('nav auth guard: isSignedIn ->', signed);
                try {
                    if (mod && typeof mod.debugAuthLogging === 'function') window.__unsubAuthLog = mod.debugAuthLogging();
                } catch(e) { console.warn('nav debugAuthLogging failed', e); try { logger.sendClientLog('warning', 'nav debugAuthLogging failed', {error: String(e)}); } catch(_) {} }
                if (!signed) {
                    if (window.__SERVER_AUTH) {
                        console.info('nav auth guard: server session present, not redirecting');
                        try { logger.sendClientLog('info', 'nav auth guard: server session present, not redirecting', {}); } catch(_) {}
                        return;
                    }
                    const current = window.location.pathname + window.location.search;
                    try { logger.sendClientLog('info', 'nav auth guard: redirecting to login', { redirect: current }); } catch(_) {}
                    window.location.href = 'login?redirect=' + encodeURIComponent(current);
                    return;
                }
            } catch (err) {
                console.error('nav auth guard failed', err);
                try { (await import("{{ asset('js/client-logger.js') }}")).sendClientLog('error', 'nav auth guard failed', {error: String(err)}); } catch(_) {}
            }
        })();
    </script>