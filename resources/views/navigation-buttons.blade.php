@extends('layouts.includes')

@section('content')

    {{-- Main Content --}}
    <main class="px-8 py-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">The Navigation Buttons</h2>

        {{-- Green Info Box --}}
        <div class="bg-green-100 border border-green-500 rounded-md p-5 mb-6">
            <h3 class="font-semibold text-lg mb-2">What is the Navigation Buttons?</h3>
            <p class="text-gray-700 text-sm leading-relaxed">
                The navigation buttons is the color blue bar at the top of the page. It helps you move around the website and find different pages quickly!
            </p>
        </div>

        {{--Kindly add image nlang mga beh--}}
        {{-- Navigation Card 1 --}}
        <a href="{{ route('job.matches') }}" class="block">
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center hover:shadow-md transition">
            <div class="bg-orange-200 p-3 rounded-md">
                <img src="{{ asset('image/bagicon.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Job Matches</h4>
                <p class="text-sm text-gray-700">Click here to see jobs that are perfect for you! This page shows jobs that match your skills and interests.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>
        </a>

        {{-- Navigation Card 2 --}}
        <a href="{{ route('career.goals.progress') }}" class="block">
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center hover:shadow-md transition">
            <div class="bg-red-200 p-3 rounded-md">
                <img src="{{ asset('image/targeticon.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Goals and Progress</h4>
                <p class="text-sm text-gray-700">See your goals and track how you're doing! This page shows what you want to achieve and how close you are to reaching your goals.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>
        </a>

        {{-- Navigation Card 3 --}}
        <a href="{{ route('why.this.job.1') }}" class="block">
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center hover:shadow-md transition">
            <div class="bg-pink-200 p-3 rounded-md">
                <img src="{{ asset('image/brain.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Why This Job & How to Get There</h4>
                <p class="text-sm text-gray-700">This button explains why a job is a good match for you. It shows you what skills you already have, what you can learn, and gives you a plan to prepare for the job.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>
        </a>

        {{-- Navigation Card 4 --}}
    <a href="{{ route('guardianreview.pending') }}" class="block">
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center hover:shadow-md transition">
            <div class="bg-blue-200 p-3 rounded-md">
                <img src="{{ asset('image/shieldicon.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Guardian Review</h4>
                <p class="text-sm text-gray-700">A page for your parent, guardian, or helper to see your progress and help you with your job search.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>
        </a>

        {{-- Navigation Card 5 --}}
        <a href="{{ route('user.role') }}" class="block">
        <div class="bg-blue-50 rounded-lg flex p-5 mb-8 items-center hover:shadow-md transition">
            <div class="bg-purple-200 p-3 rounded-md">
                <img src="{{ asset('image/profileicon.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Profile</h4>
                <p class="text-sm text-gray-700">This button shows your name and picture. Click it to see more options!</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>
        </a>

        {{-- Back Button --}}
        <div class="flex justify-start">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 bg-sky-500 hover:bg-sky-600 text-white px-6 py-2 rounded-lg shadow-md">
                <span class="text-lg">←</span>
                <span>Back</span>
            </a>
        </div>
    </main>
</div>


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