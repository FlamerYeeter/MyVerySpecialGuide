<!-- Collapsible Sidebar -->
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside id="sidebar"
    class="fixed left-0 top-0 h-full w-72 bg-white shadow-lg flex flex-col justify-between border-r border-gray-200 transition-all duration-300 overflow-hidden z-30">
    <div>
      <!-- Header with Toggle -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200">
        <h1 class="text-2xl font-extrabold text-[#2563EB] tracking-tight sidebar-title transition-all duration-300">
          AdminHub
        </h1>
        <button id="toggleBtn"
          class="p-2 rounded-md hover:bg-gray-100 text-gray-600 transition-all duration-200 focus:outline-none flex items-center justify-center w-10 h-10">
          <img id="toggleIcon" src="image/collapsed.png" alt="Toggle Menu"
            class="w-5 h-5 transition-transform duration-300">
        </button>
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
          data-default-icon="image/moderation.png"
          data-active-icon="image/moderation1.png"
          class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 hover:bg-[#2563EB] hover:text-white group">
          <img src="image/moderation.png" alt="Moderation" class="nav-icon w-6 h-6 transition-all duration-200">
          <span class="font-medium sidebar-text">Moderation</span>
        </a>

        <a href="#"
          data-default-icon="image/approval.png"
          data-active-icon="image/approval1.png"
          class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 hover:bg-[#2563EB] hover:text-white group">
          <img src="image/approval.png" alt="Approval Workflow" class="nav-icon w-5 h-5 transition-all duration-200">
          <span class="font-semibold sidebar-text">Approval Workflow</span>
        </a>

        <a href="#"
          data-default-icon="image/compliance.png"
          data-active-icon="image/compliance1.png"
          class="nav-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 hover:bg-[#2563EB] hover:text-white group">
          <img src="image/compliance.png" alt="Compliance & Reports" class="nav-icon w-5 h-5 transition-all duration-200">
          <span class="font-medium sidebar-text">Compliance & Reports</span>
        </a>
      </nav>
    </div>

    <!-- Logout -->
    <div class="p-5 border-t border-gray-200 flex items-center justify-start transition-all duration-300">
      <button class="flex items-center space-x-2 w-full hover:text-red-600 transition-colors duration-200">
        <img src="image/logout.png" alt="Logout" class="w-5 h-5 hover:opacity-100">
        <span class="font-medium sidebar-text">Logout</span>
      </button>
    </div>
  </aside>

  <!-- Main Content -->
  <main id="mainContent" class="flex-grow w-full transition-all duration-300 ml-[18rem] p-6">
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <style>
    /* Sidebar transition */
    #sidebar {
      transition: all 0.3s ease;
    }

    /* Collapsed state */
    #sidebar.collapsed {
      width: 4.5rem !important;
    }

    #sidebar.collapsed .sidebar-title,
    #sidebar.collapsed .sidebar-text {
      display: none !important;
    }

    #sidebar.collapsed nav {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 0.75rem 0;
    }

    #sidebar.collapsed nav a {
      justify-content: center;
      width: 100%;
      padding: 1rem 0;
    }

    #sidebar.collapsed .nav-icon {
      margin: 0 auto;
    }

    #sidebar.collapsed .p-5 {
      justify-content: center;
      display: flex;
    }

    /* Keep toggle button fixed size and position */
    #sidebar.collapsed #toggleBtn {
      width: 2.5rem;
      height: 2.5rem;
      margin-left: auto;
      margin-right: auto;
    }

    #sidebar.collapsed #toggleIcon {
      width: 1.25rem;
      height: 1.25rem;
    }

    /* Adjust main content shift */
    #mainContent {
      margin-left: 18rem;
    }

    #sidebar.collapsed + #mainContent {
      margin-left: 4.5rem !important;
    }
  </style>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleBtn');
    const toggleIcon = document.getElementById('toggleIcon');
    const mainContent = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');
      toggleIcon.classList.toggle('rotate-180');
    });

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
<?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\MyVerySpecialGuide\resources\views/layouts/adminsidebar.blade.php ENDPATH**/ ?>