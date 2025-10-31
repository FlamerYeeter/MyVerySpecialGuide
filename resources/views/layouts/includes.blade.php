<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MyVerySpecialGuide</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans text-gray-900">

  <!-- HEADER -->
  <header class="w-full bg-white border-b border-gray-200 shadow-sm px-6 sm:px-10 py-5">
    <div class="flex flex-wrap items-center justify-between gap-4 w-full">

      <!-- Logo and Title -->
      <div class="flex items-center gap-3 flex-shrink-0">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 sm:w-14 h-12 sm:h-14 object-contain">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-800 whitespace-nowrap">
          MyVerySpecialGuide
        </h1>
      </div>

      <!-- Mobile Menu Toggle -->
      <button id="menuToggle"
        class="sm:hidden text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-lg p-2 ml-auto"
        aria-label="Toggle navigation menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- DESKTOP NAVIGATION -->
      <div id="navContainer"
        class="hidden sm:flex flex-wrap items-center justify-end gap-4 flex-1 text-center">

        <nav id="navMenu" class="flex flex-wrap justify-center gap-3 sm:gap-4">
          <a href="{{ route('job.matches') }}"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition">
            Jobs
          </a>
          <a href="#"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition">
            Saved Jobs
          </a>
          <a href="{{ route('career.goals.progress') }}"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition">
            Assessment Progress
          </a>
          <a href="{{ route('why.this.job.1') }}"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition">
            Why this Job 
          </a>
        </nav>

        <!-- Profile Dropdown -->
        <div class="relative">
          <button id="profileButton"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 flex items-center gap-2 transition">
            Profile
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown -->
          <div id="dropdownMenu"
            class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-xl shadow-md text-gray-700 z-20">
            <a href="{{ route('user.role') }}"
              class="block px-4 py-3 text-base hover:bg-blue-50 rounded-t-xl">View Profile</a>
            {{-- Logout via POST to avoid CSRF issues; falls back to JS submit when link clicked --}}
            <form method="POST" action="{{ route('logout') }}">
              @csrf
             {{-- Use same look as other dropdown links so color/position match --}}
             <button type="submit"
                class="w-full block px-4 py-3 text-base hover:bg-blue-50 rounded-b-xl">My Job Applications</button>
            </form>
              <button type="submit"
                class="w-full block px-4 py-3 text-base hover:bg-blue-50 rounded-b-xl">Logout</button>
            </form>
          </div>
        </div>
      </div>

      <!-- MOBILE NAVIGATION -->
      <div id="mobileNav" class="hidden w-full flex-col items-center mt-4 space-y-3 sm:hidden">
        <a href="{{ route('job.matches') }}"
          class="nav-link w-11/12 px-6 py-3 border-4 border-blue-600 rounded-3xl text-base font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition text-center">Jobs</a>
        <a href="#"
          class="nav-link w-11/12 px-6 py-3 border-4 border-blue-600 rounded-3xl text-base font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition text-center">Saved Jobs</a>
        <a href="{{ route('career.goals.progress') }}"
          class="nav-link w-11/12 px-6 py-3 border-4 border-blue-600 rounded-3xl text-base font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition text-center">Goals & Progress</a>
        <a href="{{ route('why.this.job.1') }}"
          class="nav-link w-11/12 px-6 py-3 border-4 border-blue-600 rounded-3xl text-base font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 transition text-center">Why this Job & How to Get there</a>

        <button id="profileButtonMobile"
          class="nav-link w-11/12 px-6 py-3 border-4 border-blue-600 rounded-3xl text-base font-semibold bg-white text-gray-900 shadow-md hover:bg-blue-50 flex justify-center items-center gap-2 transition">
          Profile
        </button>
      </div>
    </div>

    <!-- Help Text -->
    <div class="mt-8 text-center sm:text-left">
      <p class="text-base sm:text-lg font-semibold">
        <a href="#" class="underline text-blue-800 hover:text-blue-600">Click to know about the navigation bar</a>
        <span class="text-gray-600 italic ml-1">(pindutin upang malaman ang tungkol sa navigation bar)</span>
      </p>
    </div>
  </header>

  <!-- CONTENT -->
  <main class="flex-grow w-full">
    @yield('content')
  </main>

  <!-- JS -->
  <script>
    const profileButton = document.getElementById('profileButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const menuToggle = document.getElementById('menuToggle');
    const mobileNav = document.getElementById('mobileNav');
    const navLinks = document.querySelectorAll('.nav-link');

    // Toggle dropdown
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

    // Toggle mobile menu
    menuToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('hidden');
    });

    // Highlight active link
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        navLinks.forEach(l => {
          l.classList.remove('bg-blue-700', 'text-white', 'font-bold');
          l.classList.add('bg-white', 'text-gray-900');
        });
        link.classList.remove('bg-white', 'text-gray-900');
        link.classList.add('bg-blue-700', 'text-white', 'font-bold');
      });
    });
  </script>

</body>
</html>
