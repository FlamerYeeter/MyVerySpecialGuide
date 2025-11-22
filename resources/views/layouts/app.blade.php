<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyVerySpecialGuide</title>
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
    <nav class="w-full px-6 md:px-12 py-4 bg-white/80 backdrop-blur-md shadow-md">
        <div class="flex items-center justify-between">
            <!-- Logo (links to home) -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="image/logo.png" alt="MyVerySpecialGuide Logo"
                    class="w-14 h-14 md:w-16 md:h-16 object-contain">
                <span class="text-xl md:text-2xl font-bold text-blue-700">MyVerySpecialGuide</span>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">Home</a>
                <a href="{{ route('about.us') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">About MVSG</a>
                <a href="{{ route('about.ds') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">About Down Syndrome</a>
                <a href="/" class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">Down
                    Syndrome Association</a>
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
                <button id="menu-toggle" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Responsive Dropdown Menu -->
        <div id="mobile-menu" class="hidden flex-col mt-4 space-y-3 md:hidden">
            <a href="{{ route('home') }}"
                class="block text-gray-700 hover:text-blue-600 font-medium text-base">Home</a>
            <a href="{{ route('about.us') }}"
                class="block text-gray-700 hover:text-blue-600 font-medium text-base">About MVSG</a>
            <a href="{{ route('about.ds') }}"
                class="block text-gray-700 hover:text-blue-600 font-medium text-base">About Down Syndrome</a>
            <a href="/" class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">Down Syndrome
                Association</a>
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
            class="container md:px-12 mx-auto px-6 py-10 
               grid grid-cols-1 md:grid-cols-5 gap-5 
               text-center md:text-left items-start">

            <!-- Logo -->
            <div class="px-12 flex flex-col items-center md:items-start space-y-3">
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
            <div class="px-16">
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
                       px-12 py-4 rounded-xl shadow-md text-lg
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
        <div class="bg-[#2563EB] text-white text-center py-3 text-sm">
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
