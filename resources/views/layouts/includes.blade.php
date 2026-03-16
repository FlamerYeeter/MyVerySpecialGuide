  <!DOCTYPE html>
  <html lang="en">

  <head>

      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>EmpowerPath</title>

      <script src="https://cdn.tailwindcss.com"></script>

      <style type="text/tailwindcss">
          /* Desktop navigation button */
          .nav-btn {
              padding: 10px 22px;
              border: 3px solid #2563eb;
              border-radius: 999px;
              font-weight: 600;
              font-size: 15px;
              transition: 0.2s;
          }

          @media (min-width:1024px) {
              .nav-btn {
                  padding: 14px 30px;
                  font-size: 18px;
              }
          }

          .nav-btn:hover {
              @apply bg-blue-50;
          }

          .nav-active {
              @apply bg-blue-700 text-white;
          }

          .nav-active:hover {
              @apply bg-blue-50 text-blue-800;
          }

          .mobile-active {
              @apply bg-blue-700 text-white;
          }

          .mobile-active:hover {
              @apply bg-blue-50 text-blue-800;
          }

          /* Mobile buttons */
          .mobile-btn {
              width: 90%;
              max-width: 320px;
              padding: 10px;
              border: 2px solid #2563eb;
              border-radius: 999px;
              font-weight: 600;
              text-align: center;
          }

          .mobile-btn:hover {
              @apply bg-blue-50;
          }

          /* Hamburger animation */
          .hamburger-line {
              transition: all 0.3s ease;
          }

          .menu-open .hamburger-line:nth-child(1) {
              transform: rotate(45deg) translate(5px, 5px);
          }

          .menu-open .hamburger-line:nth-child(2) {
              opacity: 0;
          }

          .menu-open .hamburger-line:nth-child(3) {
              transform: rotate(-45deg) translate(5px, -5px);
          }
      </style>

  </head>

  <body class="bg-white font-sans text-gray-900">

      <!-- HEADER -->
      <header class="top-0 z-50 bg-white border-b border-gray-200 shadow-sm">

          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

              <div class="flex items-center justify-between h-16 lg:h-24 xl:h-28">

                  <!-- Logo -->
                  <div class="flex items-center gap-3">

                      <img src="{{ asset('image/logo.png') }}" class="w-10 sm:w-12 h-auto">

                      <span class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-blue-700">
                          EmpowerPath
                      </span>

                  </div>


                  <!-- Desktop Navigation -->
                  <nav class="hidden md:flex items-center gap-4 lg:gap-6" aria-label="Main Navigation">

                      <a href="{{ route('job.matches') }}"
                          class="nav-btn {{ Request::routeIs('job.matches') ? 'nav-active' : '' }}">
                          Jobs
                      </a>

                      <a href="{{ route('saved') }}"
                          class="nav-btn {{ Request::routeIs('saved') ? 'nav-active' : '' }}">
                          Saved Jobs
                      </a>

                      <a href="{{ route('my.job.applications') }}"
                          class="nav-btn {{ Request::routeIs('my.job.applications') ? 'nav-active' : '' }}">
                          Job Applications
                      </a>

                      <!-- Profile Dropdown -->
                      <div class="relative">

                          <button id="profileBtn" class="nav-btn flex items-center gap-1" aria-haspopup="true"
                              aria-expanded="false" aria-controls="profileMenu">

                              Profile

                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                              </svg>

                          </button>

                          <div id="profileMenu"
                              class="hidden absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-md">

                              <a href="{{ route('viewprofile1') }}" class="block px-4 py-2 hover:bg-blue-50">
                                  View Profile
                              </a>

                              <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <button class="w-full text-left text-red-600 px-4 py-2 hover:bg-red-50">
                                      Logout
                                  </button>
                              </form>

                          </div>

                      </div>

                  </nav>


                  <!-- Mobile Menu Button -->
                  <button id="menuBtn" class="md:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1"
                      aria-label="Toggle navigation">

                      <span class="hamburger-line w-6 h-0.5 bg-blue-800"></span>
                      <span class="hamburger-line w-6 h-0.5 bg-blue-800"></span>
                      <span class="hamburger-line w-6 h-0.5 bg-blue-800"></span>

                  </button>

              </div>

          </div>


          <!-- Mobile Menu -->
          <div id="mobileMenu" class="hidden md:hidden border-t bg-white">

              <div class="flex flex-col items-center gap-3 py-4">

                  <a href="{{ route('job.matches') }}"
                      class="mobile-btn {{ Request::routeIs('job.matches') ? 'mobile-active' : '' }}">
                      Jobs
                  </a>

                  <a href="{{ route('saved') }}"
                      class="mobile-btn {{ Request::routeIs('saved') ? 'mobile-active' : '' }}">
                      Saved Jobs
                  </a>

                  <a href="{{ route('my.job.applications') }}"
                      class="mobile-btn {{ Request::routeIs('my.job.applications') ? 'mobile-active' : '' }}">
                      Job Applications
                  </a>

                  <a href="{{ route('viewprofile1') }}"
                      class="mobile-btn {{ Request::routeIs('viewprofile1') ? 'mobile-active' : '' }}">
                      View Profile
                  </a>

                  <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                      @csrf
                      <button class="mobile-btn text-red-600 hover:bg-red-50 !border-red-600">
                          Logout
                      </button>
                  </form>

              </div>

          </div>

          <!-- Help text -->
          <div class="text-center py-4">

              <p class="text-sm sm:text-base font-semibold">

                  <a href="{{ route('navigationbuttons') }}" class="underline text-blue-800 hover:text-blue-600">

                      Click to know about the navigation bar

                  </a>

                  <span class="text-gray-600 italic ml-2">
                      (pindutin upang malaman ang tungkol sa navigation bar)
                  </span>

              </p>

          </div>

      </header>


      <!-- PAGE CONTENT -->
      <main class="flex-grow w-full">

          @yield('content')

      </main>


      <script>
          const menuBtn = document.getElementById("menuBtn");
          const mobileMenu = document.getElementById("mobileMenu");
          const profileBtn = document.getElementById("profileBtn");
          const profileMenu = document.getElementById("profileMenu");


          // MOBILE MENU
          menuBtn.addEventListener("click", () => {

              mobileMenu.classList.toggle("hidden");
              menuBtn.classList.toggle("menu-open");

          });


          // AUTO CLOSE MOBILE MENU ON RESIZE
          window.addEventListener("resize", () => {

              if (window.innerWidth >= 768) {

                  mobileMenu.classList.add("hidden");
                  menuBtn.classList.remove("menu-open");

              }

          });


          // PROFILE DROPDOWN
          profileBtn.addEventListener("click", (e) => {

              e.stopPropagation();

              const expanded =
                  profileBtn.getAttribute("aria-expanded") === "true";

              profileBtn.setAttribute("aria-expanded", !expanded);

              profileMenu.classList.toggle("hidden");

          });


          // CLOSE WHEN CLICKING OUTSIDE
          window.addEventListener("click", () => {

              profileMenu.classList.add("hidden");
              profileBtn.setAttribute("aria-expanded", "false");

          });


          // ESC KEY CLOSE
          document.addEventListener("keydown", (e) => {

              if (e.key === "Escape") {

                  profileMenu.classList.add("hidden");
                  mobileMenu.classList.add("hidden");
                  menuBtn.classList.remove("menu-open");

              }

          });
      </script>

  </body>

  </html>
