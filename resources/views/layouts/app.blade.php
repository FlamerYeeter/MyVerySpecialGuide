<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EmpowerPath</title>

    <script src="https://cdn.tailwindcss.com"></script>

      @php
        // guard Vite manifest so missing build doesn't throw a 500
        $manifestPath = public_path('build/manifest.json');
    @endphp

    @if (file_exists($manifestPath))
        {{-- Use Vite when the build manifest is present (normal production / built dev) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Manifest missing — fallback to static assets to avoid server error.
        Run `npm install && npm run build` later to restore Vite-managed assets. --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">

<!-- NAVIGATION -->
<nav class="w-full bg-white/80 backdrop-blur-md shadow-md">
    <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-12 py-6">
        <div class="flex items-center justify-between gap-4">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 shrink-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 rounded">
                <img src="image/logo.png" alt="EmpowerPath Logo"
                     class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 object-contain">
                <span class="text-xl sm:text-2xl md:text-3xl font-extrabold text-blue-700">
                    EmpowerPath
                </span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-8 ml-auto">

                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'text-blue-700' : 'text-gray-800' }}
                          text-lg hover:text-blue-700 font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 rounded px-2 py-2">
                    Home
                </a>

                <!-- ABOUT DROPDOWN -->
                <div class="relative">

                    <button id="aboutMenuBtn"
                        type="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="flex items-center gap-2 text-lg text-gray-800 hover:text-blue-700 font-semibold
                               focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 rounded px-2 py-2">

                        Learn about us

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="aboutMenu"
                        class="hidden absolute left-0 mt-2 w-72 bg-white border-2 border-gray-300
                               rounded-xl shadow-lg py-3 z-50"
                        role="menu">

                        <a href="{{ route('about.us') }}"
                           class="block px-6 py-4 text-lg font-medium text-gray-900 hover:bg-blue-50 hover:text-blue-700 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            About EmpowerPath
                        </a>

                        <a href="{{ route('about.ds') }}"
                           class="block px-6 py-4 text-lg font-medium text-gray-900 hover:bg-blue-50 hover:text-blue-700 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            About Down Syndrome
                        </a>

                        <a href="{{ route('about.dsapi') }}"
                           class="block px-6 py-4 text-lg font-medium text-gray-900 hover:bg-blue-50 hover:text-blue-700 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Down Syndrome Association
                        </a>

                    </div>
                </div>

                <!-- Sign Up -->
                <a href="{{ route('login') }}"
                   class="bg-blue-700 text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-blue-800 transition shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Log in / Sign up
                </a>
            </div>

            <!-- RIGHT SIDE -->
            <div class="flex items-center space-x-4">

                @auth
                <div class="hidden md:block relative">

                    <button id="profileBtn"
                        class="flex items-center gap-3 border-2 border-gray-300 px-5 py-3 rounded-full text-lg font-semibold
                               focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 hover:bg-blue-50 transition">

                        <img src="{{ Auth::user()->photo ?? asset('image/avatar.png') }}"
                             class="w-9 h-9 rounded-full" alt="avatar">

                        <span class="text-lg font-bold">{{ Auth::user()->name }}</span>
                    </button>

                    <div id="profileMenu"
                        class="hidden absolute right-0 mt-2 w-56 bg-white border-2 border-gray-300 rounded-xl shadow-lg py-3 z-50">

                        <a href="{{ route('user.role') }}"
                           class="block px-6 py-4 text-lg font-medium text-gray-900 hover:bg-blue-50 hover:text-blue-700 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            My Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-6 py-4 text-lg font-medium text-red-700 hover:bg-red-50 hover:text-red-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                Sign Out
                            </button>
                        </form>

                    </div>
                </div>
                @endauth

                <!-- Mobile Button -->
                <button id="menuToggle"
                        class="lg:hidden text-2xl text-gray-800 font-bold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 rounded p-2">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu"
         class="hidden lg:hidden mt-4 bg-white shadow-md px-6 py-6 space-y-4">

        <a href="{{ route('home') }}" class="block text-xl font-bold py-3 text-gray-900 hover:text-blue-700 hover:bg-blue-50 rounded transition px-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Home</a>

        <!-- MOBILE ABOUT -->
        <div class="border-t border-gray-200 pt-4">
            <button id="mobileAboutBtn"
                class="w-full flex justify-between py-3 px-3 text-xl font-bold text-gray-900 hover:text-blue-700 hover:bg-blue-50 rounded transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Learn about us <span>▼</span>
            </button>

            <div id="mobileAboutMenu" class="hidden pl-6 space-y-3 mt-2">

                <a href="{{ route('about.us') }}" class="block text-lg py-3 text-gray-800 hover:text-blue-700 hover:bg-blue-50 rounded transition px-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">About EmpowerPath</a>
                <a href="{{ route('about.ds') }}" class="block text-lg py-3 text-gray-800 hover:text-blue-700 hover:bg-blue-50 rounded transition px-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">About Down Syndrome</a>
                <a href="{{ route('about.dsapi') }}" class="block text-lg py-3 text-gray-800 hover:text-blue-700 hover:bg-blue-50 rounded transition px-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Down Syndrome Association</a>

            </div>
        </div>

        <div class="border-t border-gray-200 pt-4">
            <a href="{{ route('login') }}" class="block text-xl font-bold bg-blue-700 text-white py-4 rounded-lg text-center hover:bg-blue-800 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Log in / Sign up
            </a>
        </div>

        @auth
        <div class="border-t border-gray-200 pt-4 space-y-3">
            <a href="{{ route('user.role') }}" class="block text-lg font-semibold py-3 text-gray-900 hover:text-blue-700 hover:bg-blue-50 rounded transition px-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">My Profile</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-lg font-semibold text-red-700 hover:text-red-800 hover:bg-red-50 py-3 rounded transition px-3 w-full text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Sign Out</button>
            </form>
        </div>
        @endauth
    </div>
</nav>

<!-- MAIN -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-white border-t-2 border-gray-200 mt-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-14 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 text-center md:text-left">

        <div>
            <img src="{{ asset('image/orglogo.jpg') }}" class="h-32 w-32 mx-auto md:mx-0" alt="Organization logo">
        </div>

        <div>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">Address</h3>
            <p class="text-lg text-gray-700 leading-relaxed">
                3rd Floor 295 Fortress Hill Building<br>
                Mandaluyong, Philippines
            </p>
        </div>

        <div>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">Socials</h3>
            <a href="#" class="text-lg text-blue-700 hover:text-blue-800 font-semibold block py-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 rounded">Facebook</a>
        </div>

        <div>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">About</h3>
            <a href="#" class="text-lg text-blue-700 hover:text-blue-800 font-semibold block py-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 rounded">Privacy Policy</a>
        </div>

    </div>

    <div class="bg-blue-700 text-white py-6 border-t-2 border-blue-600">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-lg font-semibold text-center sm:text-left">
                © 2025 EmpowerPath. All rights reserved.
            </p>
            <button id="backToTopBtn" class="inline-flex items-center gap-2 bg-white text-blue-700 px-6 py-3 rounded-full font-bold text-lg hover:bg-blue-50 transition shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 15l7-7 7 7"></path>
                </svg>
                Back to top
            </button>
        </div>
    </div>
</footer>

<!-- SCRIPTS -->
<script>
const aboutBtn = document.getElementById('aboutMenuBtn');
const aboutMenu = document.getElementById('aboutMenu');
const profileBtn = document.getElementById('profileBtn');
const profileMenu = document.getElementById('profileMenu');
const menuToggle = document.getElementById('menuToggle');
const mobileMenu = document.getElementById('mobileMenu');
const mobileAboutBtn = document.getElementById('mobileAboutBtn');
const mobileAboutMenu = document.getElementById('mobileAboutMenu');

/* About dropdown */
aboutBtn?.addEventListener('click', () => {
    const expanded = aboutBtn.getAttribute('aria-expanded') === 'true';
    aboutBtn.setAttribute('aria-expanded', !expanded);
    aboutMenu.classList.toggle('hidden');
});

/* Profile dropdown */
profileBtn?.addEventListener('click', () => {
    profileMenu.classList.toggle('hidden');
});

/* Mobile menu */
menuToggle?.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

/* Mobile about */
mobileAboutBtn?.addEventListener('click', () => {
    mobileAboutMenu.classList.toggle('hidden');
});

/* Outside click */
document.addEventListener('click', (e) => {
    if (aboutBtn && !aboutBtn.contains(e.target) && !aboutMenu.contains(e.target)) {
        aboutMenu.classList.add('hidden');
        aboutBtn.setAttribute('aria-expanded', 'false');
    }
});

/* ESC key */
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        aboutMenu?.classList.add('hidden');
        profileMenu?.classList.add('hidden');
        aboutBtn?.setAttribute('aria-expanded', 'false');
    }
});

/* Back to top button */
const backToTopBtn = document.getElementById('backToTopBtn');
backToTopBtn?.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>

</body>
</html>