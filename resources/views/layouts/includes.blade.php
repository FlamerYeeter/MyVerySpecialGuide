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
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold shadow-md transition {{ Request::routeIs('job.matches') ? 'bg-blue-700 text-white font-bold' : 'bg-white text-gray-900 hover:bg-blue-50' }}">
            Jobs
          </a>

          <a href="{{ route('saved') }}"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold shadow-md transition {{ Request::routeIs('saved') ? 'bg-blue-700 text-white font-bold' : 'bg-white text-gray-900 hover:bg-blue-50' }}">
            Saved Jobs
          </a>

          <a href="{{ route('assessment') }}"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold shadow-md transition {{ Request::routeIs('assessment') ? 'bg-blue-700 text-white font-bold' : 'bg-white text-gray-900 hover:bg-blue-50' }}">
            Assessment Progress
          </a>

          <a href="{{ route('whythisjob') }}"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold shadow-md transition {{ Request::routeIs('whythisjob') ? 'bg-blue-700 text-white font-bold' : 'bg-white text-gray-900 hover:bg-blue-50' }}">
            Why this Job 
          </a>
        </nav>

        <!-- Profile Dropdown -->
        <div class="relative">
          <button id="profileButton"
            class="nav-link px-6 py-3 border-4 border-blue-600 rounded-3xl text-base sm:text-lg font-semibold shadow-md transition flex items-center gap-2 {{ Request::routeIs(['viewprofile1', 'viewprofile2', 'viewprofile3']) ? 'bg-blue-700 text-white font-bold' : 'bg-white text-gray-900 hover:bg-blue-50' }}">
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
            <a href="{{ route('viewprofile1') }}"
              class="w-full text-left block px-4 py-3 text-base hover:bg-blue-50 rounded-b-xl">View Profile</a>

            <a href="{{ route('my.job.applications') }}"
              class="w-full text-left block px-4 py-3 text-base hover:bg-blue-50 rounded-b-xl">My Job Applications</a>

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="w-full text-left block px-4 py-3 text-base hover:bg-red-50 rounded-b-xl">Logout</button>
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
    <div class="mt-8 text-center">
      <p class="text-base sm:text-lg font-semibold">
        <a href="{{ route('navigationbuttons') }}" class="underline text-blue-800 hover:text-blue-600 inline-block">
          Click to know about the navigation bar
        </a>
        <span class="text-gray-600 italic ml-2">(pindutin upang malaman ang tungkol sa navigation bar)</span>
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
    // only consider the primary nav items inside #navMenu (exclude the Profile button)
    const navLinks = document.querySelectorAll('#navMenu .nav-link');

    // helper to toggle Profile active style while dropdown open
    function setProfileActive(active) {
      if (!profileButton) return;
      if (active) {
        profileButton.classList.add('bg-blue-700', 'text-white', 'font-bold');
        profileButton.classList.remove('bg-white', 'text-gray-900');
      } else {
        profileButton.classList.remove('bg-blue-700', 'text-white', 'font-bold');
        profileButton.classList.add('bg-white', 'text-gray-900');
      }
    }

    // Toggle dropdown (guarded) — keep profile button active while open
    if (profileButton && dropdownMenu) {
      profileButton.addEventListener('click', (e) => {
        e.stopPropagation();
        const nowOpen = dropdownMenu.classList.toggle('hidden') === false;
        setProfileActive(nowOpen);
      });

      // Close dropdown when clicking outside (guarded)
      window.addEventListener('click', (e) => {
        if (!profileButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
          if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('hidden');
            setProfileActive(false);
          }
        }
      });

      // Close dropdown when clicking any dropdown item (links/buttons)
      dropdownMenu.querySelectorAll('a, button').forEach(item => {
        item.addEventListener('click', () => {
          dropdownMenu.classList.add('hidden');
          setProfileActive(false);
        });
      });
    }

    // Toggle mobile menu (guarded)
    if (menuToggle) {
      menuToggle.addEventListener('click', () => {
        if (mobileNav) mobileNav.classList.toggle('hidden');
      });
    }

    // Highlight active link (only navMenu items; Profile button no longer included)
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
