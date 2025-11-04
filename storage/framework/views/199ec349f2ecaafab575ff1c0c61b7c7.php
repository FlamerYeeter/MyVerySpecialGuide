<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdminHub - Company Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
  </head>

<body class="bg-gray-50 min-h-screen flex">

  <!-- Static Sidebar -->
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside id="sidebar"
    class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg flex flex-col justify-between border-r border-gray-200 overflow-hidden z-30">
    <div>
     <!-- Header (Static with image beside text) -->
      <div class="flex items-center gap-2 p-6 border-b border-gray-200">
        <img src="MVSG logo.png" alt="Logo" class="w- h-10 object-contain">
        <h1 class="text-s font-extrabold text-[#2563EB] tracking-tight sidebar-title">
          MyVerySpecialGuide
        </h1>
      </div>

      <!-- Navigation -->
      <nav id="sidebarNav" class="px-4 space-y-1 mt-3">
        <a href="#"
          data-default-icon="image/dashboard.png"
          data-active-icon="image/dashboard1.png"
          class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 hover:bg-[#2563EB] hover:text-white group">
          <img src="image/dashboard.png" alt="Dashboard" class="nav-icon w-5 h-5 transition-all duration-200">
          <span class="font-medium sidebar-text">Dashboard</span>
        </a>

        <a href="#"
          data-default-icon="image/InclusiveJob.png"
          data-active-icon="image/InclusiveJob1.png"
          class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 hover:bg-[#2563EB] hover:text-white group">
          <img src="image/InclusiveJob.png" alt="InclusiveJob" class="nav-icon w-6 h-6 transition-all duration-200">
          <span class="font-medium sidebar-text">Inclusive Job</span>
        </a>

        <a href="#"
          data-default-icon="image/ProgressReport.png"
          data-active-icon="image/ProgressReport1.png"
          class="nav-item flex items-center space-x-4 p-3 rounded-lg transition-all duration-200 hover:bg-[#2563EB] hover:text-white group">
          <img src="image/ProgressReport.png" alt="ProgressReport" class="nav-icon w-5 h-5 transition-all duration-200">
          <span class="font-semibold sidebar-text">Progress Report</span>
        </a>
      </nav>
      </div>
       

    <!-- Logout -->
    <div class="p-5 border-t border-gray-200 flex items-center justify-start">
      <button class="flex items-center space-x-2 w-full hover:text-red-600 transition-colors duration-200">
        <img src="image/logout.png" alt="Logout" class="w-5 h-5 hover:opacity-100">
        <span class="font-medium sidebar-text">Logout</span>
      </button>
    </div>
  </aside>

  <!-- Main Content -->
  <main id="mainContent" class="flex-grow w-full transition-all duration-300 ml-64 p-6">
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <script>
    // Keep hover + active icon behavior only
    const navItems = document.querySelectorAll('#sidebarNav .nav-item');
    navItems.forEach(item => {
      const icon = item.querySelector('.nav-icon');
      const defaultIcon = item.dataset.defaultIcon;
      const activeIcon = item.dataset.activeIcon;

      item.addEventListener('mouseenter', () => {
        if (!item.classList.contains('active')) icon.src = activeIcon;
      });
      item.addEventListener('mouseleave', () => {
        if (!item.classList.contains('active')) icon.src = defaultIcon;
      });

      item.addEventListener('click', e => {
        e.preventDefault();
        navItems.forEach(nav => {
          nav.classList.remove('active', 'bg-[#2563EB]', 'text-white');
          nav.querySelector('.nav-icon').src = nav.dataset.defaultIcon;
        });
        item.classList.add('active', 'bg-[#2563EB]', 'text-white');
        icon.src = activeIcon;
      });
    });
  </script>
</div>


    <!-- Main Content -->
    <main class="flex-1 p-4">

        <!-- Header Section -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-4 mb-6 w-full relative">


            <div>
                <div class="text-sm text-gray-500">
                    <span class="text-[#FBBF24] font-medium">Home</span>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-700 font-medium">Company Dashboard</span>
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
          <i class="ri-user-line mr-2 text-sm text-gray-600"></i> Company Profile
      </a>
    <a href="settings.php"
   class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-b-md transition text-gray-700">
  <i class="ri-settings-3-line mr-2 text-gray-600 text-base"></i> Settings
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

        <body class="bg-white p-6">

            <?php
                // Example: user’s name from session
                session_start();
                // Example: simulate login data
                $_SESSION['username'] = $_SESSION['username'] ?? 'Juan';

                $user = $_SESSION['username'];

                // Determine greeting based on time
                $hour = date('H');
                if ($hour < 12) {
                $greeting = "Good morning";
                } elseif ($hour < 18) {
                $greeting = "Good afternoon";
                } else {
                $greeting = "Good evening";
                }
            ?>

            <!-- Greeting Header -->
            <header class="max-w-7xl mx-auto">
              <div class ="p-4">
                <h1 class="text-base sm:text-3xl font-semibold text-gray-900">
                <?= $greeting ?>, <?= htmlspecialchars($user) ?>!
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Here is your job listings static report
                </p>
                </div>
            </header>

            </body>
            </html>

       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-4">

              <!-- New Candidates -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">8</h2>
                  <p class="text-gray-600 text-sm">New Candidates</p>
                </div>
              <img src="<?php echo e(asset('image/NewUsers.png')); ?>" class="max-w-[80px] h-auto object-contain">
              </div>

              <!-- Job Post -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">25</h2>
                  <p class="text-gray-600 text-sm">Job Post</p>
                </div>
                    <img src="<?php echo e(asset('image/Therapist.png')); ?>" class="max-w-[80px] h-auto object-contain">

              </div>
              <!-- Job Opens -->
              <div class="flex items-center justify-between bg-white shadow-md rounded-xl border-l-4 border-yellow-400 p-5 w-60 h-32">
                <div>
                  <h2 class="text-3xl font-bold text-gray-900">12</h2>
                  <p class="text-gray-600 text-sm">Job Opens</p>
                </div>
                    <img src="<?php echo e(asset('image/Job Posting.png')); ?>" class="max-w-[80px] h-auto object-contain">

              </div>

                <section class="p-6 flex justify-center"></section>
  
  

   <!-- Job Statistic Card -->
  <div class="bg-white rounded-2xl shadow-md w-[750px] p-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row gap-6 sm:items-center sm:justify-between mb-5">
      <div>
        <h2 class="text-lg font-semibold text-gray-900">Job Statistic</h2>
        <p class="text-sm text-gray-500">Showing Job statistics Jul 19–15</p>
      </div>

      <div class="flex gap-2 mt-3 sm:mt-0">
        <button class="text-xs font-medium border border-gray-300 px-3 py-1.5 rounded-md hover:bg-gray-100 focus:bg-blue-100">Week</button>
        <button class="text-xs font-medium border border-gray-300 px-3 py-1.5 rounded-md hover:bg-gray-100">Month</button>
        <button class="text-xs font-medium border border-gray-300 px-3 py-1.5 rounded-md hover:bg-gray-100">Year</button>
      </div>
    </div>

    <!-- Tabs -->
    <div class="border-b mb-6 flex gap-6 text-sm">
      <button class="font-medium text-blue-600 border-b-2 border-blue-600 pb-2">Overview</button>
      <button class="text-gray-500 hover:text-blue-600 pb-2">Jobs View</button>
      <button class="text-gray-500 hover:text-blue-600 pb-2">Job Applied</button>
    </div>

    <!-- Chart + Stats Section -->
    <div class="flex flex-col lg:flex-row items-start gap-8">
      
      <!-- Chart -->
      <div class="flex-1">
        <canvas id="jobChart" height="220"></canvas>

        <div class="flex justify-center mt-6 text-xs text-gray-600 gap-6">
          <div class="flex items-center gap-1">
            <span class="w-3 h-3 bg-[#FFE7A0] rounded"></span> Job View
          </div>
          <div class="flex items-center gap-1">
            <span class="w-3 h-3 bg-[#93E5CF] rounded"></span> Job Applied
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="space-y-4 min-w-[180px]">
        <div class="border rounded-lg p-4 text-sm text-gray-700 shadow-sm">
          <div class="font-medium text-gray-500">Job Views</div>
          <div class="text-2xl font-semibold text-gray-900">-</div>
          <p class="text-xs text-gray-400">This week</p>
        </div>

        <div class="border rounded-lg p-4 text-sm text-gray-700 shadow-sm">
          <div class="font-medium text-gray-500">Job Applied</div>
          <div class="text-2xl font-semibold text-gray-900">-</div>
          <p class="text-xs text-gray-400">This week</p>
        </div>
      </div>
    </div>
  </div>


  <!-- Right Section: Applicants Summary -->
   <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-6"></div>
 <section class="bg-white shadow rounded-2xl p-6 w-[390px] h-fit ml-auto lg:ml-[180px]">
    <h2 class="text-lg font-semibold text-gray-900">Applicants Summary</h2>
    <p class="text-sm text-gray-500 mb-2">25 Applicants</p>

    <div class="text-4xl font-semibold text-gray-900 mb-4">25</div>

    <div class="w-full bg-gray-100 rounded-full h-3 mb-4 flex overflow-hidden">
      <div class="bg-[#3B82F6] h-3 w-1/4"></div>
      <div class="bg-[#93E5CF] h-3 w-1/4"></div>
      <div class="bg-[#FACC15] h-3 w-1/4"></div>
      <div class="bg-[#FCA5A5] h-3 w-1/4"></div>
    </div>

    <ul class="text-xs text-gray-600 space-y-1">
      <li class="flex items-center gap-2">
        <span class="w-3 h-3 bg-[#3B82F6] rounded"></span> Full Time
      </li>
      <li class="flex items-center gap-2">
        <span class="w-3 h-3 bg-[#93E5CF] rounded"></span> Part Time
      </li>
      <li class="flex items-center gap-2">
        <span class="w-3 h-3 bg-[#FACC15] rounded"></span> Internship
      </li>
      <li class="flex items-center gap-2">
        <span class="w-3 h-3 bg-[#FCA5A5] rounded"></span> Contract
      </li>
    </ul>
  </section>
</div>

 <!-- Chart Script -->
  <script>
    const ctx = document.getElementById('jobChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
          {
            label: 'Job View',
            backgroundColor: '#FFE7A0',
            data: [12, 9, 14, 16, 10, 7, 4],
          },
          {
            label: 'Job Applied',
            backgroundColor: '#93E5CF',
            data: [8, 2, 10, 8, 9, 5, 3],
          },
        ],
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true, grid: { color: '#F3F4F6' } },
        },
      },
    });
  </script>

</body>
</html>

 <div class="bg-white w-[450px] sm:w-[775px] rounded-2xl shadow-sm p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-semibold text-gray-800">Recent Job Updates</h2>
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <!-- Job Card -->
    <div class="flex items-start gap-4 bg-[#F9FAFB] rounded-xl p-2 border-l-4 border-red-500">
      <!-- Logo -->
      <img src="image/shakeys.png" alt="Shakey’s" class="w-16 h-16 rounded-md object-cover">

      <!-- Job Info -->
      <div class="flex-1">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="font-semibold text-gray-900">Shakey’s Company</h3>
            <p class="text-sm text-gray-600">East Wood • Taguig City, PH</p>
          </div>
          <p class="text-xs text-gray-400">2 hours ago</p>
        </div>

        <!-- Job Roles -->
        <div class="flex gap-2 mt-1">
          <span class="px-3 py-1 text-xs font-medium rounded-full bg-lime-100 text-lime-700 border border-lime-400">
            Service Crew
          </span>
          <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 border border-blue-400">
            Staff Clerk
          </span>
        </div>

        <!-- Progress Bar -->
        <div class="mt-3">
          <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
            <div class="bg-blue-500 h-2 w-[50%] rounded-full"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1">
            <span class="font-semibold text-gray-700">5 Applied</span> of 10 Capacity
          </p>
        </div>
      </div>
    </div>
  </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\MyVerySpecialGuide\resources\views/company-dashboard.blade.php ENDPATH**/ ?>