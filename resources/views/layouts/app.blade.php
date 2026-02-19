<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EmpowerPath</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
    </style>

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
    <!-- Navigation -->
    <nav class="w-full bg-white/80 backdrop-blur-md shadow-md">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-12 py-4">
         <div class="flex items-center justify-between gap-4">
            <!-- Logo (links to home) -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 shrink-0">
                <img src="image/logo.png" alt="EmpowerPath Logo"
                    class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 object-contain">
                <span class="text-lg sm:text-xl md:text-2xl font-bold text-blue-700">EmpowerPath</span>
            </a>

            <!-- Nav Links -->
            <div class="hidden lg:flex items-center gap-6 ml-auto">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base md:text-lg">Home</a>
                <a href="{{ route('about.us') }}"
                    class="{{ request()->routeIs('about.us') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base md:text-lg">About EmpowerPath</a>
                <a href="{{ route('about.ds') }}"
                    class="{{ request()->routeIs('about.ds') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base md:text-lg">About Down Syndrome</a>
                <a href="{{ route('about.dsapi') }}" 
                    class="{{ request()->routeIs('about.dsapi') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base md:text-lg">Down Syndrome Association</a>
                <!-- Sign Up Button -->
               <a href="{{ route('register') }}"
                    class="inline-block border-2 border-[#2563EB] text-[#2563EB]
                           px-8 py-3 rounded-xl text-base font-semibold
                           hover:bg-[#2563EB]/20 hover:border-[#1D4ED8]
                           transition-all duration-200 transform hover:scale-105">
                          Sign Up
                </a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <div class="hidden md:block relative">
                        <button id="desktopProfileBtn" type="button"
                            onclick="document.getElementById('desktopProfileMenu').classList.toggle('hidden')"
                            class="flex items-center gap-2 border px-3 py-1 rounded-full">
                            <img src="{{ Auth::user()->photo ?? asset('image/avatar.png') }}" alt="avatar"
                                class="w-6 h-6 rounded-full">
                            <span class="text-sm">{{ Auth::user()->name ?? 'Profile' }}</span>
                        </button>
                        <div id="desktopProfileMenu"
                            class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg py-2 z-50">
                            <a href="{{ route('user.role') }}"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="px-2">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left text-sm text-red-600 px-2 py-2 hover:bg-gray-100 rounded">Sign
                                    Out</button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- Responsive Menu Button -->
                <button id="menu-toggle" class="lg:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

        <!-- Responsive Dropdown Menu -->
        <div id="mobile-menu" class="hidden lg:hidden mt-4 rounded-xl bg-white shadow-md px-4 py-4 space-y-3">
            <a href="{{ route('home') }}"
                class="block {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base">Home</a>
            <a href="{{ route('about.us') }}"
                class="block {{ request()->routeIs('about.us') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base">About EmpowerPath</a>
            <a href="{{ route('about.ds') }}"
                class="block {{ request()->routeIs('about.ds') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base">About Down Syndrome</a>
            <a href="{{ route('about.dsapi') }}" class="block {{ request()->routeIs('about.dsapi') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600 font-medium text-base">Down Syndrome
                Association</a>
            <!-- Sign Up Button -->
            <a href="{{ route('register') }}"
                    class="inline-block border-2 border-[#2563EB] text-[#2563EB]
                           px-8 py-3 rounded-xl text-base font-semibold
                           hover:bg-[#2563EB]/20 hover:border-[#1D4ED8]
                           transition-all duration-200 transform hover:scale-105">
                          Sign Up
                </a>
            @auth
                <a href="{{ route('user.role') }}"
                    class="block text-gray-700 hover:text-blue-600 font-medium text-base">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="px-0">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600 font-medium py-2">Sign Out</button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-10
            grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8
            text-center md:text-left">

            <!-- Logo -->
            <div class="flex flex-col items-center md:items-start space-y-3">
                <img src="{{ asset('image/orglogo.jpg') }}" alt="Logo"
                    class="h-28 w-28 object-contain mx-auto md:mx-0">
            </div>

            <!-- Address -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">Address</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    3rd Floor 295 Fortress Hill Building <br>
                    Shaw Boulevard Bgy Hagdan Bato Libis,
                    Mandaluyong, Philippines
                </p>
            </div>

            <!-- Socials -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">Socials</h3>
                <ul class="text-gray-600 text-sm space-y-1">
                    <li><a href="https://www.facebook.com/downsyndromeassociationofthephilippinesinc"
                            class="hover:text-blue-500 transition-colors">Facebook</a></li>
                    <li><a href="dsapi@hotmail.com" class="hover:text-blue-500 transition-colors">Email</a></li>
                </ul>
            </div>

            <!-- About -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">About</h3>
                <ul class="text-gray-600 text-sm space-y-1">
                    <li><a href="#" class="hover:text-blue-500 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Go Up Button -->
            <div class="flex justify-center md:justify-start mt-6 md:mt-0">
                <button id="goUpBtn"
                    class="flex items-center gap-2 bg-blue-600 text-white font-semibold 
                       px-6 sm:px-10 py-2 sm:py-4 text-base sm:text-lg rounded-xl shadow-md 
                       hover:bg-blue-700 active:scale-95 transition-all">
                       <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="3">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                       </svg>
                    Go Up
                </button>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="bg-[#2563EB] text-white text-center py-3 text-xs sm:text-sm">
            © 2025 EmpowerPath. All rights reserved.
        </div>
    </footer>


    <!-- Script for Responsive Menu Toggle -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <script>
        const goUpBtn = document.getElementById("goUpBtn");
        goUpBtn.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>


</body>

</html>
