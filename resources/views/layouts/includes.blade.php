<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MyVerySpecialGuide</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900 font-sans">

  <!-- Header -->
  <header class="p-6 border-b border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
      
      <!-- Left: Logo and Title + Hamburger -->
      <div class="flex items-center justify-between w-full md:w-auto">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-16 h-16 object-contain">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-800 truncate">
            MyVerySpecialGuide
          </h1>
        </div>

        <!-- Hamburger Button (Mobile) -->
        <button id="menuButton"
                class="ml-3 md:hidden flex-shrink-0 text-blue-800 hover:text-blue-600 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>

      <!-- Right: Profile button -->
      <div class="relative mt-4 md:mt-0 text-center md:text-right">
        <button id="profileButton"
                class="px-8 py-4 border-2 border-blue-600 rounded-2xl text-lg font-semibold flex items-center justify-center gap-2 mx-auto md:mx-0 hover:bg-blue-50 transition">
          Profile
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="dropdownMenu"
             class="hidden absolute right-0 mt-2 w-40 bg-white border border-blue-600 rounded-xl shadow-lg z-10 text-left">
          <a href="{{ route('user.role') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-right">View Profile</a>
          <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-right">Settings</a>
          {{-- Logout via POST to avoid CSRF issues; falls back to JS submit when link clicked --}}
          <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            {{-- Use same look as other dropdown links so color/position match --}}
            <button type="submit" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-right">Logout</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Navigation Bar -->
    <nav id="menu" class="flex flex-col md:flex-row items-center justify-center gap-4 mt-6 hidden md:flex">
      <a href="{{ route('job.matches') }}" class="px-10 py-5 border-2 border-blue-600 rounded-2xl text-xl font-semibold hover:bg-blue-50 transition">
        Jobs
      </a>
      <a href="{{ route('career.goals.progress') }}" class="px-10 py-5 border-2 border-blue-600 rounded-2xl text-xl font-semibold hover:bg-blue-50 transition">
        Goals & Progress
      </a>
      <a href="{{ route('why.this.job.1') }}" class="px-10 py-5 border-2 border-blue-600 rounded-2xl text-xl font-semibold hover:bg-blue-50 transition">
        Why this Job & How to Get there
      </a>
      <a href="{{ route('guardianreview.instructions') }}" class="px-10 py-5 border-2 border-blue-600 rounded-2xl text-xl font-semibold hover:bg-blue-50 transition">
        Guardian Review
      </a>
    </nav>
  </header>

  <!-- Info Text -->
  <main class="text-center mt-10 px-4">
    <p class="text-lg font-semibold">
      <a href="#" class="underline text-black hover:text-blue-700">Click to know about the navigation bar</a>
      <span class="text-gray-500">(pindutin upang malaman ang tungkol sa navigation bar)</span>
    </p>
  </main>

  <!-- Page Content -->
  <main class="flex-grow w-full">
    @yield('content')
  </main>

  <!-- JS for dropdown & mobile menu -->
  <script>
    const profileButton = document.getElementById('profileButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const menuButton = document.getElementById('menuButton');
    const menu = document.getElementById('menu');

    // Toggle Profile Dropdown
    profileButton.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
      if (!profileButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.add('hidden');
      }
    });

    // Toggle Mobile Menu
    menuButton.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });
  </script>

</body>
</html>
