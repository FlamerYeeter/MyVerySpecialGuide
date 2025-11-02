<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdminHub - Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex">

    <!-- Sidebar -->
    @include('layouts.adminsidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4">

        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-4 mb-6 w-full relative">


            <div>
                <div class="text-sm text-gray-500">
                    <span class="text-[#FBBF24] font-medium">Home</span>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-700 font-medium">Admin Profile</span>
                </div>
            </div>

            <!-- Search + Profile -->
            <div class="flex items-center gap-4 relative">
                <div class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-gray-50">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-2 text-sm w-48 sm:w-56 bg-gray-50 focus:outline-none" />
                    <button class="bg-blue-500 px-2.5 py-2 text-white text-sm hover:bg-blue-600 transition">
                        <i class="ri-search-line"></i>
                    </button>
                </div>

<!-- 🔔 Notification Bell -->
<div class="relative">
  <button id="notifBtn"
    class="relative flex items-center justify-center w-9 h-9 bg-gray-100 border border-gray-200 rounded-full hover:bg-gray-200 transition">
    <i class="ri-notification-3-line text-gray-600 text-lg"></i>
    <!-- Red Dot (Unread indicator) -->
    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
  </button>

  <!-- Notification Dropdown -->
  <div id="notifDropdown"
    class="absolute right-0 mt-2 w-96 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-2 px-4 py-3 border-b border-gray-100">
      <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Notifications</h3>
      <button id="markAllBtn"
        class="text-blue-600 text-xs sm:text-sm font-medium hover:text-blue-700 focus:outline-none transition">
        Mark all as read
      </button>
    </div>

<!-- Tabs -->
<div id="notifTabs"
  class="flex flex-wrap justify-between sm:justify-around border-b border-gray-100 px-2 sm:px-3 py-2 text-xs sm:text-sm gap-2">

  <button data-tab="all"
    class="tab-btn flex-1 min-w-[70px] py-1 rounded-md text-gray-600 hover:bg-gray-100 transition text-center font-normal">
    All
  </button>

  <button data-tab="unread"
    class="tab-btn flex-1 min-w-[70px] py-1 rounded-md bg-gray-100 text-gray-800 font-semibold transition text-center">
    Unread
  </button>

  <button data-tab="read"
    class="tab-btn flex-1 min-w-[70px] py-1 rounded-md text-gray-600 hover:bg-gray-100 transition text-center font-normal">
    Read
  </button>
</div>

              <!-- Notification List -->
              <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">

              <!-- Notification Item 1 -->
                <div class="flex flex-col sm:flex-row sm:items-start gap-3 px-4 py-3">
                  <div class="relative flex-shrink-0 self-center sm:self-auto">
                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-blue-500 rounded-full"></span>
                  </div>
                  <div class="flex-1 text-xs sm:text-sm">
                    <p class="text-gray-700">
                      <span class="font-semibold">Robert Fox</span> wants to log in
                      <span class="font-semibold">Admin Module</span>
                    </p>
                    <p class="text-gray-400 mt-1">5 min ago</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                      <button
                        class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-600 transition">Accept</button>
                      <button
                        class="border border-gray-300 text-gray-700 text-xs px-3 py-1 rounded-md hover:bg-gray-100 transition">Deny</button>
                      <button
                        class="border border-gray-300 text-gray-700 text-xs px-3 py-1 rounded-md hover:bg-gray-100 transition">View</button>
                    </div>
                  </div>
                </div>


                  <!-- Notification Item 2 -->
                <div class="flex flex-col sm:flex-row sm:items-start gap-3 px-4 py-3">
                  <div class="relative flex-shrink-0 self-center sm:self-auto">
                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-blue-500 rounded-full"></span>
                  </div>
                  <div class="flex-1 text-xs sm:text-sm">
                    <p class="text-gray-700">
                      <span class="font-semibold">Ralph Edwards</span> updated password in his Profile on
                      <span class="font-semibold">Admin Module</span>
                    </p>
                    <p class="text-gray-400 mt-1">1 hour ago</p>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- Script -->
          <script>
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');

            notifBtn.addEventListener('click', () => {
              notifDropdown.classList.toggle('hidden');
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
              if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
                notifDropdown.classList.add('hidden');
              }
            });
          // Tab switching logic
            const tabButtons = document.querySelectorAll('.tab-btn');

            tabButtons.forEach(button => {
              button.addEventListener('click', () => {
                // Remove active styles from all tabs
                tabButtons.forEach(btn => {
                  btn.classList.remove('bg-gray-100', 'text-gray-800', 'font-semibold');
                  btn.classList.add('text-gray-600', 'font-normal');
                });

                // Apply active styles to the clicked one
                button.classList.add('bg-gray-100', 'text-gray-800', 'font-semibold');
                button.classList.remove('text-gray-600', 'font-normal');

                // (Optional) handle content switching here if you have tabbed sections
                const selectedTab = button.getAttribute('data-tab');
                console.log("Active Tab:", selectedTab);
              });
            });
          </script>


                        <!-- Profile Button + Dropdown -->
          <div class="relative">
            <div id="profileBtn"
                class="flex items-center gap-1 w-fit h-9 bg-gray-100 border border-gray-200 rounded-full px-2 cursor-pointer relative z-10">
                <i class="ri-user-line text-gray-500 text-lg"></i>
                <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
            </div>

            <!-- Dropdown Menu (White Background) -->
            <div id="profileDropdown"
               class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
                <a href="#"
                    class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-t-md transition">
                    <i class="ri-user-line mr-2 text-sm text-gray-600"></i> Admin Profile
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-b-md transition">
                    <i class="ri-user-add-line mr-2 text-sm text-gray-600"></i> Admin List
                </a>
            </div>
          </div>

          <!-- Script -->
          <script>
            const profileBtn = document.getElementById('profileBtn');
            const dropdown = document.getElementById('profileDropdown');
            const icon = document.getElementById('dropdownIcon');

            profileBtn.addEventListener('click', () => {
              dropdown.classList.toggle('hidden');
              icon.classList.toggle('ri-arrow-up-s-line');
              icon.classList.toggle('ri-arrow-down-s-line');
            });

            // Optional: close dropdown if clicking outside
            document.addEventListener('click', (e) => {
              if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
                icon.classList.remove('ri-arrow-up-s-line');
                icon.classList.add('ri-arrow-down-s-line');
              }
            });
          </script>
                          
                      </div>

                      <!-- Dropdown -->
                      <div id="dropdownMenu"
                          class="hidden absolute top-full right-6 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                          <ul class="flex flex-col">
                              <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Profile</li>
                          </ul>
                      </div>
                  </div>

        <!-- Profile Content -->
        <h2 class="text-lg font-medium mb-4">My Profile</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- LEFT CARD -->
            <div class="border rounded-lg p-6 flex flex-col items-center text-center shadow-sm bg-white">
                <div
                    class="w-24 h-24 bg-yellow-200 rounded-full flex items-center justify-center text-2xl font-medium text-gray-800 mb-4">
                    JD
                </div>
                <h2 class="text-lg font-medium text-gray-800">Juan Dela Cruz</h2>
                <p class="text-sm text-gray-500 mb-2">Admin</p>
                <p class="text-xs text-gray-400 mb-4">Last login 4 minutes ago</p>

                <hr class="w-full mb-4 border-gray-200">

                <div class="flex items-center text-sm text-gray-700 mb-2">
                    <img src="{{ asset('mail-svgrepo-com.png') }}" alt="Email Icon"
                        class="h-4 w-4 mr-2 object-contain">
                    juandelacruz@admin.com
                </div>

                <div class="flex items-center text-sm text-gray-700">
                    <img src="{{ asset('phone-svgrepo-com.png') }}" alt="Phone Icon"
                        class="h-4 w-4 mr-2 object-contain">
                    +639 123 4567
                </div>
               <!-- Bio -->
                <div class="w-full mt-3 border border-gray-300 rounded-md p-2 bg-gray-50 text-gray-700">
                  Type here your bio
                </div>


            <!-- RIGHT CARD -->
           <div class="border rounded-lg p-6 shadow-sm bg-white relative z-0">
                <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <i class="ri-edit-2-line text-lg"></i>
                </button>
      
                <form class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">First Name</label>
                        <input type="text" placeholder="Juan"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Middle Name</label>
                        <input type="text" placeholder="Dela"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Last Name</label>
                        <input type="text" placeholder="Cruz"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Phone Number</label>
                        <input type="text" placeholder="+639 123 4567"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Gender</label>
                        <input type="text" placeholder="Male"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Birthday</label>
                        <input type="date"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1">Password</label>
                        <input type="password" placeholder="********"
                            class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-300">
                    </div>
                </form>
            </div>

        </div>
    </main>

</body>
</html>
