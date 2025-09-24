<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyVerySpecialGuide</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo and Title -->
            <div class="flex flex-col items-start">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-14">
                    <span class="font-bold text-3xl text-[#2C2C2C] drop-shadow" style="font-family: 'Comic Sans MS', 'Comic Sans', cursive;">
                        <span class="text-[#FF5E5B]">M</span><span class="text-[#FFD600]">i</span><span class="text-[#00C2FF]">n</span><span class="text-[#43D86E]">d</span><span class="text-[#FF5E5B]">f</span><span class="text-[#FFD600]">u</span><span class="text-[#00C2FF]">l</span>
                        <span class="ml-2 text-[#43D86E]">T</span><span class="text-[#FF5E5B]">o</span><span class="text-[#FFD600]">t</span><span class="text-[#00C2FF]">s</span>
                    </span>
                </div>
                <span class="text-xs text-[#4A90E2] font-semibold tracking-wide mt-1 ml-1">GROWTH IN PROGRESS</span>
            </div>
            <!-- Navigation Links -->
            <div class="flex items-center space-x-12">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-medium text-lg">Home</a>
                <a href="/about-mvsg" class="text-gray-700 hover:text-blue-600 font-medium text-lg">About MVSG</a>
                <a href="/about-down-syndrome" class="text-gray-700 hover:text-blue-600 font-medium text-lg">About Down Syndrome</a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="container mx-auto px-6 py-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center space-x-2 mb-4 md:mb-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10">
                <span class="text-xl font-bold text-blue-700">Mindful Tots</span>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-16 text-center md:text-left">
                <div class="mb-4 md:mb-0">
                    <h3 class="font-semibold text-gray-800 mb-1">Address</h3>
                    <p class="text-gray-600 text-sm">Tri-AX One Center,<br>Second Floor, 133 M. Almeda St., Brgy. San Roque</p>
                </div>
                <div class="mb-4 md:mb-0">
                    <h3 class="font-semibold text-gray-800 mb-1">Socials</h3>
                    <p class="text-gray-600 text-sm">Facebook<br>Email</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">About</h3>
                    <p class="text-gray-600 text-sm">Privacy Policy</p>
                </div>
            </div>
        </div>
        <div class="bg-blue-400 text-white text-center py-2 text-sm">
            © 2025 EmpowerPath
        </div>
    </footer>

</body>
</html>
