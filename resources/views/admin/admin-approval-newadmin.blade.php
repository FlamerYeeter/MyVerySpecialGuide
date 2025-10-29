<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdminHub - View Job Post</title>
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
                    <span class="text-gray-700 font-medium">Admin List</span>
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
    class="absolute right-0 mt-2 w-96 bg-white border border-gray-200 rounded-lg shadow-lg hidden">

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
      class="absolute right-0 mt-2 w-44 bg-white text-gray-700 border border-gray-200 rounded-md shadow-lg hidden">
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

 <body class="bg-white text-gray-900 p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-semibold">Admin List</h1>
      </div>

      <!-- Filter Row (Status + Add Button aligned) -->
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-2">
        <p class="font-medium text-gray-800">Status</p>
        <select
  class="appearance-none border border-gray-300 rounded-md text-sm px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
  style="background-image: url('/path/to/Dropdown.png');
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 12px auto;">
        
        <option>All</option>
          <option>Pending</option>
          <option>Approved</option>
          <option>Rejected</option>
        </select>
        </div>

        <!-- Add New Admin Button -->
<button
  onclick="document.getElementById('newAdminModal').classList.remove('hidden')"
  class="bg-blue-600 font-semibold text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700 transition"
>
  + Add New Admin
</button>

<!-- New Admin Modal -->
<div
  id="newAdminModal"
  class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
>
  <div
    class="bg-white rounded-xl shadow-lg w-full max-w-lg md:max-w-2xl p-6 relative"
  >
    <!-- Close Button -->
    <button
      onclick="document.getElementById('newAdminModal').classList.add('hidden')"
      class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition"
    >
      ✕
    </button>

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-3">New Admin</h2>
    <hr class="mb-6" />

    <!-- Form -->
    <form class="space-y-5">
      <!-- Name + Type -->
      <div
        class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0"
      >
        <div class="flex-1">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Admin Name
          </label>
          <input
            type="text"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
          />
        </div>

        <div class="flex-1">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Admin Type
          </label>
          <select
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
          >
            <option>Select Type</option>
            <option>Moderator</option>
            <option>Editor</option>
          </select>
        </div>
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Email Address
        </label>
        <input
          type="email"
          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
        />
      </div>

      <hr class="my-5" />

      <!-- Buttons -->
      <div
        class="flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0"
      >
        <button
          type="submit"
          class="bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700 transition"
        >
          Send Invite
        </button>
        <button
          type="button"
          onclick="document.getElementById('newAdminModal').classList.add('hidden')"
          class="border border-gray-300 text-sm px-4 py-2 rounded-md hover:bg-gray-100 transition"
        >
          Cancel
        </button>
      </div>
    </form>
  </div>
</div>

      </div>

   <!-- Table -->
<div class="overflow-xl-auto rounded-xl border border-gray-200">
  <table class="min-w-full bg-white text-sm">
    <thead class="bg-[#F0F0F0] text-gray-600 font-medium">
      <tr>
        <!-- Name -->
        <th class="text-left py-3 pl-8">
          <div class="flex items-center gap-1">
            <span class="text-gray-700 font-semibold text-sm sm:text-base">Name</span>
            <!-- Sortable Arrow -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </div>
        </th>

        <!-- Other Headers -->
        <th class="text-left py-3 pl-10">Admin Type</th>
        <th class="text-left py-3 pl-10">Status</th>
        <th class="text-left py-3 pl-10">Last Login Date</th>
        <th class="text-left py-3 pl-10">Login IP</th>

        <!-- Right-aligned Action header -->
        <th class="py-3 pr-10 text-right font-semibold text-gray-700 whitespace-nowrap">
          Action
        </th>
      </tr>
    </thead>

    <tbody>
      <tr class="border-t hover:bg-white">
        <!-- Static aligned cells -->
        <td class="py-3 pl-8 text-gray-800">Juan Dela Cruz</td>
        <td class="py-3 pl-10 text-gray-700">juan.delacruz@gmail.com</td>

        <!-- ✅ Status Badge -->
        <td class="py-3 pl-10">
          <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
            Approved
          </span>
        </td>

        <td class="py-3 pl-10 text-gray-800">October 08, 2025, 6:43 PM</td>
        <td class="py-3 pl-10 text-gray-800">192.168.1.5</td>

        <!-- Aligned Action Column -->
        <td class="py-3 pr-9 text-right relative align-middle">
          <div class="inline-flex items-center gap-2">
            <!-- Pencil Icon -->
            <button class="p-1 rounded-full hover:bg-gray-100 transition">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-gray-600 hover:text-gray-800"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M12 20h9"></path>
                <path
                  d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"
                ></path>
              </svg>
            </button>

            <!-- 3 Dots Menu -->
            <button onclick="toggleMenu(this)" class="p-1 rounded-full hover:bg-gray-100 transition">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-gray-600 hover:text-gray-800"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <circle cx="12" cy="5" r="1"></circle>
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="12" cy="19" r="1"></circle>
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
              class="hidden absolute right-6 top-10 w-32 bg-white border border-gray-200 rounded-md shadow-lg z-50"
            >
              <a
                href="#"
                class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 text-center"
              >
                Remove
              </a>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- JS -->
<script>
  function toggleMenu(button) {
    const menu = button.nextElementSibling;
    menu.classList.toggle("hidden");

    // Close when clicking outside
    document.addEventListener("click", function handleClickOutside(event) {
      if (!button.parentElement.contains(event.target)) {
        menu.classList.add("hidden");
        document.removeEventListener("click", handleClickOutside);
      }
    });
  }
</script>
