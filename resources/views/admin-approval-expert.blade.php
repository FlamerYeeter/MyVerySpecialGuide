<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdminHub - Expert Account Approval </title>
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
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-4 mb-6 w-full -mx-4 sm:-mx-6 relative">
            <!-- Left Side: Breadcrumb -->
            <div>
                <div class="text-sm text-gray-500">
                    <span class="text-[#FBBF24] font-medium">Home</span>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-700 font-medium">Approval</span>
                </div>
            </div>

            <!-- Right Side: Search + Icons -->
            <div class="flex items-center gap-4 relative">
                <!-- Search Bar -->
                <div class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-gray-50">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-2 text-sm w-48 sm:w-56 bg-gray-50 focus:outline-none" />
                    <button class="bg-blue-500 px-2.5 py-2 text-white text-sm hover:bg-blue-600 transition">
                        <i class="ri-search-line"></i>
                    </button>
                </div>

                <!-- Profile Circle with Arrow -->
                <div id="profileBtn"
                    class="flex items-center gap-1 w-fit h-9 bg-gray-100 border border-gray-200 rounded-full px-2 cursor-pointer relative z-10">
                    <i class="ri-user-line text-gray-500 text-lg"></i>
                    <!-- Dropdown Arrow -->
                    <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
                </div>
            </div>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu"
                class="hidden absolute top-full right-6 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                <ul class="flex flex-col">
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Profile</li>
                </ul>
            </div>
        </div>

        <!-- Script of profile dropdown -->
        <script>
            const profileBtn = document.getElementById('profileBtn');
            const dropdownIcon = document.getElementById('dropdownIcon');
            const dropdownMenu = document.getElementById('dropdownMenu');

            [profileBtn, dropdownIcon].forEach(el => {
                el.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });
            });

            window.addEventListener('click', () => {
                dropdownMenu.classList.add('hidden');
            });
        </script>


        <!-- Approval Header -->
        <div class="flex items-center justify-between mb-4 mt-8 -ml-4 px-6">
            <h1 class="text-2xl font-bold text-gray-800">Approval</h1>
        </div>

        <!-- Unified Content Container -->
        <div class="w-full bg-gray-50 rounded-lg mb-10 -mx-4 sm:-mx-6 px-6">

            <!-- Tabs Section -->
            <div class="bg-gray-100 rounded-lg p-2 mb-6 w-full px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button class="text-gray-500 hover:text-gray-700 font-medium text-sm px-6 py-2 transition w-full">
                        USER
                    </button>
                    <button
                        class="bg-white text-gray-900 font-semibold text-sm shadow-sm rounded-md px-6 py-2 border border-gray-200 w-full">
                        EXPERT
                    </button>
                    <button class="text-gray-500 hover:text-gray-700 font-medium text-sm px-6 py-2 transition w-full">
                        COMPANY
                    </button>
                    <button class="text-gray-500 hover:text-gray-700 font-medium text-sm px-6 py-2 transition w-full">
                        JOB POSTING
                    </button>
                </div>
            </div>

            <!-- Status Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 px-6">
                <div class="bg-white shadow rounded-lg p-4 text-center border-r-4 border-[#D78203]">
                    <h3 class="text-gray-600 font-semibold">Pending Queue</h3>
                    <p class="text-3xl font-bold text-[#D78203]">--</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center border-r-4 border-[#008000]">
                    <h3 class="text-gray-600 font-semibold">Approved</h3>
                    <p class="text-3xl font-bold text-[#008000]">--</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center border-r-4 border-[#686D76]">
                    <h3 class="text-gray-600 font-semibold">Under Review</h3>
                    <p class="text-3xl font-bold text-[#686D76]">--</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center border-r-4 border-[#D20103]">
                    <h3 class="text-gray-600 font-semibold">Rejected</h3>
                    <p class="text-3xl font-bold text-[#D20103]">--</p>
                </div>
            </div>



            <!-- Filter -->
            <div class="flex items-center gap-3 mb-4">
                <label for="status" class="font-semibold text-gray-700">Status:</label>
                <select id="status"
                    class="border rounded-md px-3 py-1 focus:outline-none focus:ring focus:ring-blue-200">
                    <option>All</option>
                    <option>Pending</option>
                    <option>Approved</option>
                    <option>Under Review</option>
                    <option>Rejected</option>
                </select>
            </div>

            <!-- Approval expert table -->
            <div class="bg-white shadow-md rounded-lg mb-10 overflow-x-auto">
                <table class="min-w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#516AA3] text-white">
                            <th class="px-4 py-3 text-left">First Name</th>
                            <th class="px-4 py-3 text-left">Last Name</th>
                            <th class="px-4 py-3 text-left">Gender</th>
                            <th class="px-4 py-3 text-left">Email Address</th>
                            <th class="px-4 py-3 text-left">Contact Number</th>
                            <th class="px-4 py-3 text-left">Date of Birth</th>
                            <th class="px-4 py-3 text-left">Address</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <!-- Example Row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Pending</span>
                            </td>

                            <td class="px-4 py-3 flex items-center gap-3 relative">
                                <!-- Eye Icon -->
                                <button class="text-gray-600 hover:text-blue-500 toggle-detail">
                                    <i class="ri-eye-line text-lg"></i>
                                </button>

                                <!-- Status Dropdown -->
                                <div class="relative inline-block text-left">
                                    <button onclick="toggleDropdown(this)"
                                        class="dropdown-btn border border-gray-300 rounded-md text-xs px-3 py-1.5 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none flex items-center gap-1">
                                        Choose Status
                                        <i class="ri-arrow-down-s-line text-gray-500 text-sm"></i>
                                    </button>

                                    <div
                                        class="dropdown-menu hidden absolute left-0 mt-1 w-36 bg-white border border-gray-200 rounded-md shadow-lg z-[999]">
                                        <button onclick="selectStatus(this, 'Approved', 'text-green-600')"
                                            class="block w-full text-left px-3 py-2 text-green-600 hover:bg-green-100 text-sm">Approved</button>
                                        <button onclick="selectStatus(this, 'Rejected', 'text-red-600')"
                                            class="block w-full text-left px-3 py-2 text-red-600 hover:bg-red-100 text-sm">Rejected</button>
                                        <button onclick="selectStatus(this, 'Under Review', 'text-gray-600')"
                                            class="block w-full text-left px-3 py-2 text-gray-600 hover:bg-gray-100 text-sm">Under
                                            Review</button>
                                    </div>
                                </div>

                                <!-- Trash Icon -->
                                <button class="text-red-500 hover:text-red-700">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Account & Professional Info Row (hidden by default) -->
                        <tr class="account-info hidden bg-gray-50">
                            <td colspan="9" class="px-6 py-4">
                                <!-- Account Detail -->
                                <div class="mb-4">
                                    <h4 class="text-black-700 font-semibold text-sm">Account Details</h4>
                                    <div class=" mt-4 grid grid-cols-2 gap-4">
                                        <div><strong class="text-[#516AA3]">Username:</strong> —</div>
                                        <div>
                                            <strong class="text-[#516AA3]">Valid ID Upload:</strong>
                                            <a href="#" class="text-blue-500 underline">View File</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div>
                                    <h4 class="text-black-700 font-semibold text-sm">Professional Information</h4>
                                    <div class="mt-4 grid grid-cols-2 gap-4">
                                        <div><strong class="text-[#516AA3]">Professional Title:</strong> —</div>
                                        <div><strong class="text-[#516AA3]">PRC ID:</strong> —</div>
                                        <div><strong class="text-[#516AA3]">Years of Experience:</strong> —</div>
                                        <div><strong class="text-[#516AA3]">Area of Specialization:</strong> —</div>
                                        <div><strong class="text-[#516AA3]">Organization Name:</strong> —</div>
                                        <div><strong class="text-[#516AA3]">Position:</strong> —</div>
                                        <div><strong class="text-[#516AA3]">Work Address:</strong> —</div>
                                        <div>
                                            <strong class="text-[#516AA3]">Proof of Employment:</strong>
                                            <a href="#" class="text-blue-500 underline">View File</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Example Second Row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Approved</span>
                            </td>

                            <td class="px-4 py-3 flex items-center gap-3 relative">
                                <button class="text-gray-600 hover:text-blue-500 toggle-detail">
                                    <i class="ri-eye-line text-lg"></i>
                                </button>

                                <div class="relative inline-block text-left">
                                    <button onclick="toggleDropdown(this)"
                                        class="dropdown-btn border border-gray-300 rounded-md text-xs px-3 py-1.5 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none flex items-center gap-1">
                                        Choose Status
                                        <i class="ri-arrow-down-s-line text-gray-500 text-sm"></i>
                                    </button>

                                    <div
                                        class="dropdown-menu hidden absolute left-0 mt-1 w-36 bg-white border border-gray-200 rounded-md shadow-lg z-[999]">
                                        <button onclick="selectStatus(this, 'Approved', 'text-green-600')"
                                            class="block w-full text-left px-3 py-2 text-green-600 hover:bg-green-100 text-sm">Approved</button>
                                        <button onclick="selectStatus(this, 'Rejected', 'text-red-600')"
                                            class="block w-full text-left px-3 py-2 text-red-600 hover:bg-red-100 text-sm">Rejected</button>
                                        <button onclick="selectStatus(this, 'Under Review', 'text-gray-600')"
                                            class="block w-full text-left px-3 py-2 text-gray-600 hover:bg-gray-100 text-sm">Under
                                            Review</button>
                                    </div>
                                </div>

                                <button class="text-red-500 hover:text-red-700">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Approval Table Script -->
            <script>
                // Toggle Account Detail / Professional Info Row
                document.querySelectorAll('.toggle-detail').forEach(button => {
                    button.addEventListener('click', () => {
                        const currentRow = button.closest('tr');
                        const nextRow = currentRow.nextElementSibling;
                        if (nextRow && nextRow.classList.contains('account-info')) {
                            nextRow.classList.toggle('hidden');
                        }
                    });
                });

                // Dropdown Menu Logic
                function toggleDropdown(button) {
                    const menu = button.nextElementSibling;
                    const allMenus = document.querySelectorAll(".dropdown-menu");
                    allMenus.forEach((m) => {
                        if (m !== menu) m.classList.add("hidden");
                    });
                    menu.classList.toggle("hidden");
                }

                function selectStatus(option, label, colorClass) {
                    const container = option.closest(".relative");
                    const button = container.querySelector(".dropdown-btn");
                    button.innerHTML = `${label} <i class='ri-arrow-down-s-line text-gray-500 text-sm'></i>`;
                    button.className =
                        `dropdown-btn border border-gray-300 rounded-md text-xs px-3 py-1.5 focus:outline-none flex items-center gap-1 bg-white ${colorClass}`;
                    container.querySelector(".dropdown-menu").classList.add("hidden");
                }

                window.addEventListener("click", (e) => {
                    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                        const button = menu.previousElementSibling;
                        if (!menu.contains(e.target) && !button.contains(e.target)) {
                            menu.classList.add("hidden");
                        }
                    });
                });
            </script>

            <!-- Pagination -->
            <div class="flex justify-center items-center space-x-2 mt-6" id="pagination">
                <!-- Previous Button -->
                <button id="prevPage"
                    class="flex items-center space-x-1 px-4 py-2 border border-gray-300 rounded-full text-blue-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="ri-arrow-left-s-line"></i>
                    <span>Previous</span>
                </button>

                <!-- Page Numbers -->
                <div id="pageNumbers" class="flex items-center space-x-2"></div>

                <!-- Next Button -->
                <button id="nextPage"
                    class="flex items-center space-x-1 px-4 py-2 border border-gray-300 rounded-full text-blue-500 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span>Next</span>
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>

            <script>
                // PAGINATION SCRIPT
                document.addEventListener("DOMContentLoaded", () => {
                    const rows = Array.from(document.querySelectorAll("tbody tr"))
                        .filter(row => !row.classList.contains("guardian-info")); // exclude hidden detail rows

                    const rowsPerPage = 5; // adjust how many rows per page
                    let currentPage = 1;
                    const totalPages = Math.ceil(rows.length / rowsPerPage);

                    const pageNumbersContainer = document.getElementById("pageNumbers");
                    const prevBtn = document.getElementById("prevPage");
                    const nextBtn = document.getElementById("nextPage");

                    function renderTablePage(page) {
                        const start = (page - 1) * rowsPerPage;
                        const end = start + rowsPerPage;

                        rows.forEach((row, index) => {
                            row.style.display = index >= start && index < end ? "" : "none";
                        });
                    }

                    function renderPageButtons() {
                        pageNumbersContainer.innerHTML = "";
                        for (let i = 1; i <= totalPages; i++) {
                            const btn = document.createElement("button");
                            btn.textContent = i;
                            btn.className = `px-3 py-1 border border-gray-300 rounded-full ${i === currentPage
          ? "bg-gray-200 text-gray-700"
          : "text-blue-500 hover:bg-gray-100"}`;
                            btn.addEventListener("click", () => {
                                currentPage = i;
                                renderTablePage(currentPage);
                                renderPageButtons();
                                updateButtons();
                            });
                            pageNumbersContainer.appendChild(btn);
                        }
                    }

                    function updateButtons() {
                        prevBtn.disabled = currentPage === 1;
                        nextBtn.disabled = currentPage === totalPages;
                    }

                    prevBtn.addEventListener("click", () => {
                        if (currentPage > 1) {
                            currentPage--;
                            renderTablePage(currentPage);
                            renderPageButtons();
                            updateButtons();
                        }
                    });

                    nextBtn.addEventListener("click", () => {
                        if (currentPage < totalPages) {
                            currentPage++;
                            renderTablePage(currentPage);
                            renderPageButtons();
                            updateButtons();
                        }
                    });

                    // Initial render
                    renderTablePage(currentPage);
                    renderPageButtons();
                    updateButtons();
                });
            </script>



            <!-- Overview -->
            <h3 class="py-4 font-semibold text-gray-700 text-2xl">Overview</h3>
            <div class="bg-white shadow-md rounded-lg mb-10 overflow-x-auto">
                <table class="min-w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#516AA3] text-white">
                            <th class="px-4 py-3 text-left">First Name</th>
                            <th class="px-4 py-3 text-left">Last Name</th>
                            <th class="px-4 py-3 text-left">Gender</th>
                            <th class="px-4 py-3 text-left">Email Address</th>
                            <th class="px-4 py-3 text-left">Contact Number</th>
                            <th class="px-4 py-3 text-left">Date of Birth</th>
                            <th class="px-4 py-3 text-left">Address</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3">—</td>
                            <td class="px-4 py-3 text-green-600 font-semibold">Approved</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </main>

</body>

</html>
