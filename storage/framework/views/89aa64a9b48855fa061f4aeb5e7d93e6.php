<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdminHub - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex">

    <!-- Sidebar -->
    <?php echo $__env->make('layouts.adminsidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content -->
    <main class="flex-1 p-4">

        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-4 mb-6 w-full relative">


            <div>
                <div class="text-sm text-gray-500">
                    <span class="text-[#FBBF24] font-medium">Home</span>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-700 font-medium">Dashboard</span>
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

        <!-- Main Content Layout -->
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            <!-- Left Main Content -->
            <div class="flex-1 space-y-6">

            <!-- Overview Placeholder -->
               <div class="w-full max-w-7xl bg-white shadow-sm rounded-md border border-gray-200">
                 <div class="border-b border-gray-200 px-6 py-3">
                  <h2 class="text-gray-700 font-medium text-lg">Overview</h2>
              </div>
              
               <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">

              <!-- New Users -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">8</h2>
                  <p class="text-gray-600 text-sm">New Users</p>
                </div>
              <img src="<?php echo e(asset('image/NewUsers.png')); ?>" class="max-w-[80px] h-auto object-contain">
              </div>

              <!-- Therapist -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">25</h2>
                  <p class="text-gray-600 text-sm">Therapist</p>
                </div>
                    <img src="<?php echo e(asset('image/Therapist.png')); ?>" class="max-w-[80px] h-auto object-contain">

              </div>

              <!-- Job Posting -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">12</h2>
                  <p class="text-gray-600 text-sm">Job Posting</p>
                </div>
                    <img src="<?php echo e(asset('image/Job Posting.png')); ?>" class="max-w-[80px] h-auto object-contain">

              </div>

              <!-- Flagged -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">5</h2>
                  <p class="text-gray-600 text-sm">Flagged</p>
                </div>
                    <img src="<?php echo e(asset('image/Flag.png')); ?>" class="max-w-[65px] h-auto object-contain">

              </div>

            </div>

          <!-- Job Posting and Moderation Overview -->
          <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-4 px-6">

            <!-- Job Posting -->
            <div class="bg-white rounded-xl shadow border overflow-hidden">
              <!-- Header -->
              <div class="flex items-center justify-between p-4 bg-blue-900 text-white">
                <h2 class="text-lg font-semibold">Job Posting</h2>
                <a href="#" class="text-white text-xs sm:text-sm font-medium hover:text-blue-700 focus:outline-none transition"> View all
                      </a>
              </div>

              <!-- Table -->
              <div class="p-4">
                <table class="w-full text-left text-sm text-gray-700 border-collapse table-fixed">
                  <thead>
                    <tr class="border-b bg-gray-50 text-gray-600">
                      <th class="py-2 px-3 font-semibold w-1/4">Name</th>
                      <th class="py-2 px-3 font-semibold w-1/4">Company</th>
                      <th class="py-2 px-3 font-semibold w-1/4">Date & Time</th>
                      <th class="py-2 px-3 font-semibold w-1/4">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-b text-gray-500 hover:bg-gray-50 transition">
                      <td class="py-3 px-3">-</td>
                      <td class="px-3">-</td>
                      <td class="px-3">-</td>
                      <td class="px-3">-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Moderation Overview (Unchanged) -->
            <div class="bg-white rounded-2xl shadow-md border overflow-hidden">
              <!-- Header -->
              <div class="bg-rose-300 text-white p-4 rounded-t-2xl">
                <h2 class="text-lg font-semibold text-center">Moderation Overview</h2>
              </div>

              <!-- Draft Doughnut Chart -->
              <div class="p-6 flex flex-col items-center justify-center">
                <div class="relative w-40 h-40 rounded-full bg-gray-200 overflow-hidden">
                  <!-- Simulated slices -->
                  <div class="absolute inset-0 rounded-full bg-green-500" style="clip-path: polygon(50% 50%, 100% 0%, 100% 100%);"></div>
                  <div class="absolute inset-0 rounded-full bg-red-500" style="clip-path: polygon(50% 50%, 100% 100%, 0% 100%);"></div>
                  <div class="absolute inset-0 rounded-full bg-orange-400" style="clip-path: polygon(50% 50%, 0% 100%, 0% 0%);"></div>
                  <div class="absolute inset-0 rounded-full bg-gray-400" style="clip-path: polygon(50% 50%, 0% 0%, 50% 0%);"></div>
                  <div class="absolute inset-0 rounded-full bg-sky-400" style="clip-path: polygon(50% 50%, 50% 0%, 100% 0%);"></div>

                  <!-- Inner circle for doughnut effect -->
                  <div class="absolute inset-6 bg-white rounded-full"></div>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap justify-center gap-4 mt-6 text-sm">
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span> <span>Approved</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-600"></span> <span>Rejected</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-orange-400"></span> <span>Pending</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-400"></span> <span>Under Review</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-sky-400"></span> <span>Flagged</span>
                  </div>
                </div>
              </div>
            </div>
          </div>


            <script>
              const ctx = document.getElementById('moderationChart').getContext('2d');
              new Chart(ctx, {
                type: 'pie',
                data: {
                  labels: ['Approved', 'Rejected', 'Pending', 'Under Review', 'Flagged'],
                  datasets: [{
                    data: [40, 15, 8, 20, 17],
                    backgroundColor: [
                      '#84cc16', // Approved
                      '#dc2626', // Rejected
                      '#fb923c', // Pending
                      '#9ca3af', // Under Review
                      '#38bdf8'  // Flagged
                    ],
                    borderWidth: 0,
                    cutout: '60%'
                  }]
                },
                options: {
                  plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                  }
                }
              });
            </script>


            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-6">
              <!-- Recent Activity -->
              <div class="bg-white rounded-xl shadow border">
                <div class="flex items-center justify-between p-4 border-b bg-[#55BEBB] rounded-t-xl">
                  <h2 class="text-lg text-white font-semibold">Recent Activity</h2>
                </div>
                <div class="p-4 space-y-4">
                  <?php 
                    $activities = [
                      ['initials' => 'AC', 'name' => 'Sophia Doe', 'desc' => 'Applied for Waiter in Shakey’s Company'],
                      ['initials' => 'MJ', 'name' => 'Sophia Doe', 'desc' => 'Applied for Waiter in Shakey’s Company'],
                      ['initials' => 'JC', 'name' => 'Sophia Doe', 'desc' => 'Applied for Waiter in Shakey’s Company']
                    ];
                    foreach ($activities as $a): 
                  ?>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-700 font-semibold">
                        <?= $a['initials'] ?>
                      </div>
                      <div>
                        <p class="font-medium"><?= $a['name'] ?></p>
                        <p class="text-xs text-gray-500"><?= $a['desc'] ?></p>
                      </div>
                    </div>
                    <div class="relative inline-block text-left">
            <button
              type="button"
              onclick="toggleMenu(this)"
              class="text-gray-500 hover:text-gray-700 focus:outline-none transition">⋮</button>

            <div
              class="absolute hidden bg-white border rounded-lg shadow-md right-0 mt-2 w-28 z-10"
            >
              <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">View</a>
              <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">Remove</a>
            </div>
          </div>

          <script>
            function toggleMenu(button) {
              const menu = button.nextElementSibling;
              menu.classList.toggle("hidden");

              // Close if clicking outside
              document.addEventListener("click", function handleClickOutside(event) {
                if (!button.parentElement.contains(event.target)) {
                  menu.classList.add("hidden");
                  document.removeEventListener("click", handleClickOutside);
                }
              });
            }
          </script>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Recent Flagged Activity -->
              <div class="bg-white rounded-xl shadow border">
                <div class="flex items-center justify-between p-4 border-b bg-[#91B5F5] rounded-t-xl">
                  <h2 class="text-lg font-semibold text-white"> Recent Flagged Activity</h2>
                      <a href="#" class="text-white text-xs sm:text-sm font-medium hover:text-blue-700 focus:outline-none transition"> View all
                      </a>
              </div>
                <div class="p-6 text-gray-400 text-sm">
                  No flagged activity yet.
                </div>
              </div>
              
            </div>
<?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\MyVerySpecialGuide\resources\views/admin-dashboard.blade.php ENDPATH**/ ?>