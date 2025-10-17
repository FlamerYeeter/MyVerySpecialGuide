<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyVerySpecialGuide</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; padding: 0; min-height: 100vh; }
  </style>
</head>
<body>
<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-sm py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-4">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 md:w-16 md:h-16 object-contain">
                <h1 class="text-xl md:text-2xl font-bold text-blue-700">MyVerySpecialGuide</h1>
            </div>

            <!-- Desktop nav -->
            <nav class="hidden md:flex items-center space-x-3" aria-label="Primary">
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Job Matches</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Goals & Progress</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Why This Job & How to Get There</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Guardian Review</button>
            </nav>

            <div class="flex items-center space-x-3">
                <div class="hidden md:block">
                    <button class="border px-3 py-1 rounded-full text-sm">Profile ▾</button>
                </div>

                <!-- Mobile hamburger -->
                <button id="mobile-menu-button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open main menu">
                    <svg id="hamburger-open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="hamburger-close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-4 pt-4 pb-6 space-y-3 border-t border-gray-100">
                <button class="w-full text-left bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Job Matches</button>
                <button class="w-full text-left bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Goals & Progress</button>
                <button class="w-full text-left bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Why This Job & How to Get There</button>
                <button class="w-full text-left bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Guardian Review</button>
                <div class="pt-2">
                    <button class="w-full border px-3 py-2 rounded-full text-sm text-left">Profile ▾</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Info -->
    <div class="text-center mt-3 text-sm underline text-gray-600 px-4">
        <a href="#" class="hover:text-blue-600 font-medium">Click to know about the navigation buttons above</a>
        <p class="italic text-xs">(pindutin upang malaman ang tungkol sa navigation buttons sa taas)</p>
    </div>

    <!-- Page Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

</div>

<script>
  (function () {
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('hamburger-open');
    const closeIcon = document.getElementById('hamburger-close');

    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
      const isOpen = menu.classList.contains('hidden') === false;
      if (isOpen) {
        menu.classList.add('hidden');
        openIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
      } else {
        menu.classList.remove('hidden');
        openIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
      }
    });

    // Ensure menu is hidden if viewport is resized to md+
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768) {
        menu.classList.add('hidden');
        openIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
      }
    });
  })();
</script>
</body>
</html>