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
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-12 py-4">
        <div class="flex items-center justify-between gap-4">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 shrink-0">
                <img src="image/logo.png" alt="EmpowerPath Logo"
                     class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 object-contain">
                <span class="text-lg sm:text-xl md:text-2xl font-bold text-blue-700">
                    EmpowerPath
                </span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-6 ml-auto">

                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-700' }}
                          text-base hover:text-blue-600 font-medium">
                    Home
                </a>

                <!-- ABOUT DROPDOWN -->
                <div class="relative">

                    <button id="aboutMenuBtn"
                        type="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="flex items-center gap-1 text-base text-gray-700 hover:text-blue-600 font-medium
                               focus:outline-none focus:ring-2 focus:ring-blue-600 rounded">

                        About

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="aboutMenu"
                        class="hidden absolute left-0 mt-2 w-56 bg-white border border-gray-200
                               rounded-md shadow-lg py-2 z-50"
                        role="menu">

                        <a href="{{ route('about.us') }}"
                           class="block px-4 py-3 text-base hover:bg-gray-100 transition">
                            About EmpowerPath
                        </a>

                        <a href="{{ route('about.ds') }}"
                           class="block px-4 py-3 text-base hover:bg-gray-100 transition">
                            About Down Syndrome
                        </a>

                        <a href="{{ route('about.dsapi') }}"
                           class="block px-4 py-3 text-base hover:bg-gray-100 transition">
                            Down Syndrome Association
                        </a>

                    </div>
                </div>

                <!-- Sign Up -->
                <a href="{{ route('login') }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700 transition">
                    Log in / Sign up
                </a>
            </div>

            <!-- RIGHT SIDE -->
            <div class="flex items-center space-x-4">

                @auth
                <div class="hidden md:block relative">

                    <button id="profileBtn"
                        class="flex items-center gap-2 border px-4 py-2 rounded-full text-base
                               focus:ring-2 focus:ring-blue-600 hover:bg-gray-50 transition">

                        <img src="{{ Auth::user()->photo ?? asset('image/avatar.png') }}"
                             class="w-7 h-7 rounded-full" alt="avatar">

                        <span class="text-base font-medium">{{ Auth::user()->name }}</span>
                    </button>

                    <div id="profileMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg py-2 z-50">

                        <a href="{{ route('user.role') }}"
                           class="block px-4 py-3 text-base hover:bg-gray-100 transition">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-3 text-base text-red-600 hover:bg-gray-100 transition">
                                Sign Out
                            </button>
                        </form>

                    </div>
                </div>
                @endauth

                <!-- Mobile Button -->
                <button id="menuToggle"
                        class="lg:hidden text-gray-700 focus:ring-2 focus:ring-blue-600 rounded">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu"
         class="hidden lg:hidden mt-4 bg-white shadow-md px-4 py-4 space-y-3">

        <a href="{{ route('home') }}" class="block text-base py-2 hover:text-blue-600 transition">Home</a>

        <!-- MOBILE ABOUT -->
        <div>
            <button id="mobileAboutBtn"
                class="w-full flex justify-between py-3 text-base text-gray-700 hover:text-blue-600 transition">
                About <span>▼</span>
            </button>

            <div id="mobileAboutMenu" class="hidden pl-4 space-y-2">

                <a href="{{ route('about.us') }}" class="block text-base py-2 hover:text-blue-600 transition">About EmpowerPath</a>
                <a href="{{ route('about.ds') }}" class="block text-base py-2 hover:text-blue-600 transition">About Down Syndrome</a>
                <a href="{{ route('about.dsapi') }}" class="block text-base py-2 hover:text-blue-600 transition">Down Syndrome Association</a>

            </div>
        </div>

        <a href="{{ route('login') }}" class="block text-base text-blue-600 py-2 hover:text-blue-700 transition font-semibold">
            Log in / Sign up
        </a>

        @auth
        <a href="{{ route('user.role') }}" class="block text-base py-2 hover:text-blue-600 transition">Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-base text-red-600 hover:text-red-700 py-2 transition">Sign Out</button>
        </form>
        @endauth
    </div>
</nav>

<!-- MAIN -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-white border-t mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8 text-center md:text-left">

        <div>
            <img src="{{ asset('image/orglogo.jpg') }}" class="h-28 w-28 mx-auto md:mx-0">
        </div>

        <div>
            <h3 class="font-semibold mb-3">Address</h3>
            <p class="text-sm text-gray-600">
                3rd Floor 295 Fortress Hill Building<br>
                Mandaluyong, Philippines
            </p>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Socials</h3>
            <a href="#" class="text-sm hover:text-blue-500">Facebook</a>
        </div>

        <div>
            <h3 class="font-semibold mb-3">About</h3>
            <a href="#" class="text-sm">Privacy Policy</a>
        </div>

    </div>

    <div class="bg-blue-600 text-white text-center py-3 text-sm">
         © 2025 EmpowerPath. All rights reserved.
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
</script>

</body>
</html>