<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdminHub - Auditlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    

</head>

<body class="bg-gray-50 min-h-screen flex">

    <!-- Sidebar -->
    @include('layouts.adminsidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4">

  <!-- ===================== HEADER SECTION ===================== -->
  <header
    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-4 mb-6 w-full relative">

    <!-- Breadcrumb -->
    <div>
      <div class="text-sm text-gray-500">
        <span class="text-[#FBBF24] font-medium">Home</span>
        <span class="mx-2 text-gray-400">›</span>
        <span class="text-gray-700 font-medium">Audit Log</span>
      </div>
    </div>

    <!-- Search + Notification + Profile -->
    <div class="flex items-center gap-4 relative">

      <!-- Search -->
      <div class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-gray-50">
        <input type="text" placeholder="Search..."
          class="px-3 py-2 text-sm w-48 sm:w-56 bg-gray-50 focus:outline-none" />
        <button class="bg-blue-500 px-2.5 py-2 text-white text-sm hover:bg-blue-600 transition">
          <i class="ri-search-line"></i>
        </button>
      </div>

      <!-- Notification Bell -->
      <div class="relative">
        <button id="notifBtn"
          class="relative flex items-center justify-center w-9 h-9 bg-gray-100 border border-gray-200 rounded-full hover:bg-gray-200 transition">
          <i class="ri-notification-3-line text-gray-600 text-lg"></i>
          <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
        </button>

        <!-- Dropdown -->
        <div id="notifDropdown"
          class="absolute right-0 mt-2 w-96 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
          <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Notifications</h3>
            <button id="markAllBtn"
              class="text-blue-600 text-xs sm:text-sm font-medium hover:text-blue-700 transition">Mark all as read</button>
          </div>

          <!-- Tabs -->
          <div id="notifTabs"
            class="flex justify-between border-b border-gray-100 px-3 py-2 text-xs sm:text-sm">
            <button data-tab="all"
              class="tab-btn flex-1 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition text-center font-normal">
              All
            </button>
            <button data-tab="unread"
              class="tab-btn flex-1 py-1 rounded-md bg-gray-100 text-gray-800 font-semibold transition text-center">
              Unread
            </button>
            <button data-tab="read"
              class="tab-btn flex-1 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition text-center font-normal">
              Read
            </button>
          </div>

          <!-- Notification Items -->
          <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
            <div class="flex gap-3 px-4 py-3">
              <div class="relative">
                <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                <span class="absolute top-0 right-0 w-2 h-2 bg-blue-500 rounded-full"></span>
              </div>
              <div class="flex-1 text-sm">
                <p class="text-gray-700">
                  <span class="font-semibold">Robert Fox</span> wants to log in <span class="font-semibold">Admin Module</span>
                </p>
                <p class="text-gray-400 mt-1 text-xs">5 min ago</p>
                <div class="flex gap-2 mt-2">
                  <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-600 transition">Accept</button>
                  <button class="border border-gray-300 text-gray-700 text-xs px-3 py-1 rounded-md hover:bg-gray-100 transition">Deny</button>
                  <button class="border border-gray-300 text-gray-700 text-xs px-3 py-1 rounded-md hover:bg-gray-100 transition">View</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Dropdown -->
      <div class="relative">
        <div id="profileBtn"
          class="flex items-center gap-1 w-fit h-9 bg-gray-100 border border-gray-200 rounded-full px-2 cursor-pointer relative z-10">
          <i class="ri-user-line text-gray-500 text-lg"></i>
          <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
        </div>

        <div id="profileDropdown"
          class="absolute right-0 mt-2 w-44 bg-white text-gray-700 border border-gray-200 rounded-md shadow-lg hidden">
          <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-t-md transition">
            <i class="ri-user-line mr-2 text-sm text-gray-600"></i> Admin Profile
          </a>
          <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-b-md transition">
            <i class="ri-user-add-line mr-2 text-sm text-gray-600"></i> Admin List
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- ===================== AUDIT LOG SECTION ===================== -->
  <main class="max-w-7xl mx-auto p-6 space-y-6">

    <!-- Title + Buttons -->
    <section class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">Audit Log</h3>
        <p class="text-sm text-gray-500">
          This can help identify potential security issues, investigate suspicious behavior, and troubleshoot access.
        </p>
      </div>

      <div class="mt-4 sm:mt-0 flex gap-2">
        <button
          class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-md flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Export in Excel
        </button>
        

        <button
          class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M4 9a8 8 0 0116 0M20 15a8 8 0 01-16 0" />
          </svg>
          Refresh
        </button>
      </div>
    </section>

   <!-- Filters -->
<section class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
  <select
    class="border border-gray-300 text-sm rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
    <option>Last day</option>
    <option>Last 3 days</option>
    <option selected>Last 7 days</option>
    <option>Last 14 days</option>
    <option>Custom</option>
  </select>

  <!-- 🔘 Filter Button (trigger) -->
  <button id="filterBtn"
    class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2H3V4zm0 4h18v12a1 1 0 01-1 1H4a1 1 0 01-1-1V8z" />
    </svg>
    Filters
  </button>
</section>

<!-- ===================== FILTER MODAL ===================== -->
<div id="filterModal"
  class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">

  <div class="bg-white rounded-lg shadow-lg w-80 sm:w-96 p-5 relative">
    <h2 class="text-base font-semibold text-gray-800 mb-4">Filter Logs</h2>

    <!-- User Name Field -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">User Name</label>
      <div class="relative">
        <input type="text" id="usernameInput" placeholder="Enter name"
          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" />
        <button id="clearUsername"
          class="absolute inset-y-0 right-2 text-gray-400 hover:text-gray-600 hidden">
          <i class="ri-close-line text-lg"></i>
        </button>
      </div>
    </div>

    <!-- Category Dropdown -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
      <select id="categorySelect"
        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">Select category</option>
        <option>Admin</option>
        <option>Author</option>
        <option>Moderator</option>
        <option>User</option>
        <option>Unknown</option>
      </select>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-2">
      <button id="cancelBtn"
        class="border border-gray-300 text-gray-600 text-sm font-medium px-4 py-2 rounded-md hover:bg-gray-100 transition">
        Cancel
      </button>
      <button id="applyBtn"
        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-md transition">
        Apply
      </button>
    </div>
  </div>
</div>

<!-- ===================== SCRIPT ===================== -->
<script>
  const filterBtn = document.getElementById("filterBtn");
  const filterModal = document.getElementById("filterModal");
  const cancelBtn = document.getElementById("cancelBtn");
  const applyBtn = document.getElementById("applyBtn");
  const usernameInput = document.getElementById("usernameInput");
  const clearUsername = document.getElementById("clearUsername");

  // Open modal
  filterBtn.addEventListener("click", () => filterModal.classList.remove("hidden"));

  // Close modal
  cancelBtn.addEventListener("click", () => filterModal.classList.add("hidden"));
  applyBtn.addEventListener("click", () => {
    filterModal.classList.add("hidden");
    // TODO: Add filter logic here (e.g., AJAX fetch or table filtering)
  });

  // Close when clicking outside
  filterModal.addEventListener("click", (e) => {
    if (e.target === filterModal) filterModal.classList.add("hidden");
  });

  // Show/Hide clear “X” button
  usernameInput.addEventListener("input", () => {
    clearUsername.classList.toggle("hidden", usernameInput.value.trim() === "");
  });

  // Clear username field
  clearUsername.addEventListener("click", () => {
    usernameInput.value = "";
    clearUsername.classList.add("hidden");
    usernameInput.focus();
  });
</script>

    <!-- Table -->
    <section class="overflow-x-auto bg-white rounded-lg shadow border border-gray-100">
      <table class="min-w-full text-sm text-gray-700">
        <thead>
          <tr class="bg-blue-600 text-white text-left">
            <th class="py-3 px-4 font-medium">User name</th>
            <th class="py-3 px-4 font-medium">Category</th>
            <th class="py-3 px-4 font-medium">Event</th>
            <th class="py-3 px-4 font-medium">Date & Time</th>
          </tr>
        </thead>
        

         <?php
$logs = [
  ["username" => "Moderator", "category" => "Author", "event" => "Moderator logged in", "datetime" => "October 09, 2025, 1:22 PM"],
  ["username" => "User", "category" => "Admin", "event" => "User changed password", "datetime" => "October 10, 2025, 3:45 PM"],
  ["username" => "", "category" => "", "event" => "", "datetime" => ""] // Example blank row
];

foreach ($logs as $log) {
  // Replace empty values with "-"
  $username = !empty($log['username']) ? $log['username'] : "-";
  $category = !empty($log['category']) ? $log['category'] : "-";
  $event = !empty($log['event']) ? $log['event'] : "-";
  $datetime = !empty($log['datetime']) ? $log['datetime'] : "-";

  echo "<tr class='border-b hover:bg-gray-50'>
          <td class='py-3 px-4'>{$username}</td>
          <td class='py-3 px-4'>{$category}</td>
          <td class='py-3 px-4'>{$event}</td>
          <td class='py-3 px-4'>{$datetime}</td>
        </tr>";
}
?>
        </tbody>
      </table>
    </section>
  </main>

  <script>
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    notifBtn.addEventListener('click', () => notifDropdown.classList.toggle('hidden'));
    document.addEventListener('click', e => {
      if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) notifDropdown.classList.add('hidden');
    });

    const profileBtn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');
    const icon = document.getElementById('dropdownIcon');
    profileBtn.addEventListener('click', () => {
      dropdown.classList.toggle('hidden');
      icon.classList.toggle('ri-arrow-up-s-line');
      icon.classList.toggle('ri-arrow-down-s-line');
    });
    document.addEventListener('click', e => {
      if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
        icon.classList.remove('ri-arrow-up-s-line');
        icon.classList.add('ri-arrow-down-s-line');
      }
    });
  </script>
</body>
</html>