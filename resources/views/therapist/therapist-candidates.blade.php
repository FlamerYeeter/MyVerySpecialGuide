<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Therapist - Candidates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex">

    <!-- Sidebar -->
    @include('layouts.therapistsidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4">

        <!-- Header -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-4 mb-6 w-full -mx-4 sm:-mx-6 relative">
            <div>
                <div class="text-sm text-gray-500">
                    <span class="text-[#1E40AF] font-medium">Therapist</span>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-700 font-medium">Candidates</span>
                </div>
            </div>

            <!-- Search & Profile -->
            <div class="flex items-center gap-4 relative">
                <div class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-gray-50">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-2 text-sm w-48 sm:w-56 bg-gray-50 focus:outline-none" />
                    <button class="bg-blue-500 px-2.5 py-2 text-white text-sm hover:bg-blue-600 transition">
                        <i class="ri-search-line"></i>
                    </button>
                </div>

                <div id="profileBtn"
                    class="flex items-center gap-1 w-fit h-9 bg-gray-100 border border-gray-200 rounded-full px-2 cursor-pointer relative z-10">
                    <i class="ri-user-line text-gray-500 text-lg"></i>
                    <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
                </div>
            </div>

            <div id="dropdownMenu"
                class="hidden absolute top-full right-6 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                <ul class="flex flex-col">
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Profile</li>
                </ul>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {

                // --- PROFILE DROPDOWN ---
                const profileBtn = document.getElementById('profileBtn');
                const dropdownIcon = document.getElementById('dropdownIcon');
                const dropdownMenu = document.getElementById('dropdownMenu');

                [profileBtn, dropdownIcon].forEach(el => {
                    el.addEventListener('click', (e) => {
                        e.stopPropagation();
                        dropdownMenu.classList.toggle('hidden');
                    });
                });

                window.addEventListener('click', () => dropdownMenu.classList.add('hidden'));

                // --- STATUS DROPDOWN (inside table) ---
                window.toggleDropdown = function(event) {
                    event.stopPropagation();
                    const button = event.currentTarget;
                    const menu = button.nextElementSibling;

                    // Close all other dropdowns first
                    document.querySelectorAll('.dropdown-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });

                    menu.classList.toggle('hidden');
                }

                window.selectStatus = function(button, status, colorClass) {
                    const dropdown = button.closest('.dropdown-menu');
                    const triggerBtn = dropdown.previousElementSibling;
                    dropdown.classList.add('hidden');

                    // Update button label
                    triggerBtn.innerHTML = `${status} <i class="ri-arrow-down-s-line ml-1"></i>`;

                    // Find main status pill in the same row
                    const row = button.closest('tr');
                    const statusSpan = row.querySelector('td:nth-child(8) span');
                    if (statusSpan) {
                        statusSpan.textContent = status;
                        statusSpan.className =
                            `inline-flex items-center justify-center px-3 sm:px-4 py-1.5 text-xs sm:text-sm rounded-full font-medium whitespace-nowrap ${colorClass}`;
                    }
                }

                // --- Close dropdowns when clicking outside ---
                window.addEventListener('click', () => {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
                });

                // --- TOGGLE DETAIL (eye icon) ---
                document.querySelectorAll('.toggle-detail').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const row = btn.closest('tr').nextElementSibling;
                        if (row && row.classList.contains('detail-row')) {
                            row.classList.toggle('hidden');
                        }
                    });
                });
            });
        </script>



        <div class="max-w-7xl mx-auto px-4">

            <!-- Filter -->
            <div class="flex items-center gap-3 mb-4">
                <label for="status" class="font-semibold text-gray-700">Status:</label>
                <select id="status"
                    class="border rounded-md px-3 py-1 focus:outline-none focus:ring focus:ring-blue-200">
                    <option>All</option>
                    <option>Pending</option>
                    <option>Active</option>
                    <option>In Progress</option>
                    <option>Under Review</option>
                    <option>Job-Ready</option>
                    <option>Placed</option>
                    <option>On Hold</option>
                    <option>Discontinued</option>
                </select>
            </div>


            <!-- Candidates Table -->
            <div class="bg-white shadow-md rounded-lg mb-10 overflow-x-auto w-full">
                <table class="min-w-full border-collapse text-sm table-auto w-full">
                    <thead>
                        <tr class="bg-[#1E40AF] text-white text-left">
                            <th class="px-4 py-3">First Name</th>
                            <th class="px-4 py-3">Last Name</th>
                            <th class="px-4 py-3">Age</th>
                            <th class="px-4 py-3">Email Address</th>
                            <th class="px-4 py-3">Contact Number</th>
                            <th class="px-4 py-3">Date of Birth</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-gray-700">

                        <!-- First Row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 break-words">-</td> <!-- First Name -->
                            <td class="px-4 py-3 break-words">-</td> <!-- Last Name -->
                            <td class="px-4 py-3">-</td> <!-- Age -->
                            <td class="px-4 py-3 break-words">-</td> <!-- Email -->
                            <td class="px-4 py-3 break-words">-</td> <!-- Contact Number -->
                            <td class="px-4 py-3 break-words">-</td> <!-- Date of Birth -->
                            <td class="px-4 py-3 break-words">-</td> <!-- Address -->

                            <!-- Status -->
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-3 sm:px-4 py-1.5 text-xs sm:text-sm rounded-full font-medium bg-yellow-100 text-yellow-700 whitespace-nowrap">
                                    Pending
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-wrap items-center justify-center gap-3 relative">
                                    <!-- Eye Icon -->
                                    <button class="text-gray-600 hover:text-blue-500 toggle-detail">
                                        <i class="ri-eye-line text-lg"></i>
                                    </button>

                                    <!-- Dropdown -->
                                    <div class="relative">
                                        <button onclick="toggleDropdown(event)"
                                            class="bg-gray-100 border border-gray-300 rounded px-3 py-1 text-sm text-gray-700 hover:bg-gray-200 transition flex items-center">
                                            Choose Status <i class="ri-arrow-down-s-line ml-1"></i>
                                        </button>
                                        <div
                                            class="dropdown-menu hidden absolute right-0 mt-1 w-36 border border-gray-200 rounded-md shadow-lg bg-white z-[9999]">
                                            <button onclick="selectStatus(this, 'Active', 'text-[#316CCC]')"
                                                class="block w-full text-left px-3 py-2 bg-[#3B82F6] hover:bg-[#316CCC] text-white text-sm">Active</button>
                                            <button onclick="selectStatus(this, 'In Progress', 'text-[#DDB411]')"
                                                class="block w-full text-left px-3 py-2 bg-[#FACC15] hover:bg-[#DDB411] text-white text-sm">In
                                                Progress</button>
                                            <button onclick="selectStatus(this, 'Under Review', 'text-[#ED8835]')"
                                                class="block w-full text-left px-3 py-2 bg-[#FB923C] hover:bg-[#ED8835] text-white text-sm">Under
                                                Review</button>
                                            <button onclick="selectStatus(this, 'Job-Ready', 'text-[#1EBB58]')"
                                                class="block w-full text-left px-3 py-2 bg-[#22C55E] hover:bg-[#1EBB58] text-white text-sm">Job-Ready</button>
                                            <button onclick="selectStatus(this, 'Placed', 'text-[#744AD2]')"
                                                class="block w-full text-left px-3 py-2 bg-[#8B5CF6] hover:bg-[#744AD2] text-white text-sm">Placed</button>
                                            <button onclick="selectStatus(this, 'On Hold', 'text-[#595E68]')"
                                                class="block w-full text-left px-3 py-2 bg-[#686D76] hover:bg-[#595E68] text-white text-sm">On
                                                Hold</button>
                                            <button onclick="selectStatus(this, 'Discontinued', 'text-[#EF4444]')"
                                                class="block w-full text-left px-3 py-2 bg-[#EF4444] hover:bg-[#E84040] text-white text-sm">Discontinued</button>
                                        </div>
                                    </div>

                                    <!-- Create Assessment: Route to Assessment Form -->
                                    <button
                                        class="bg-[#057773] hover:bg-[#03706C] text-white text-xs font-medium px-4 py-2 rounded-md shadow transition duration-200 whitespace-nowrap">
                                        Create Assessment
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Hidden Detail Row -->
                        <tr class="hidden bg-gray-50 detail-row">
                            <td colspan="9" class="px-6 py-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                    <!-- Guardian Information -->
                                    <div>
                                        <h3 class="font-bold text-[#1E40AF] mb-3">Guardian Information</h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2">
                                            <p class="font-semibold text-gray-700">First Name:</p>
                                            <p class="text-black">-</p>

                                            <p class="font-semibold text-gray-700">Last Name:</p>
                                            <p class="text-black">-</p>

                                            <p class="font-semibold text-gray-700">Email Address:</p>
                                            <p class="text-black">-</p>

                                            <p class="font-semibold text-gray-700">Contact Number:</p>
                                            <p class="text-black">-</p>

                                            <p class="font-semibold text-gray-700">Relationship to User:</p>
                                            <p class="text-black">-</p>

                                            <p class="font-semibold text-gray-700">Proof of Membership:</p>
                                            <a href="#" class="underline text-blue-600 hover:text-blue-500">
                                                View File
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Skills -->
                                    <div>
                                        <h3 class="font-bold text-[#1E40AF] mb-3">Skills</h3>
                                        <div class="flex flex-wrap gap-4">
                                            <span
                                                class="bg-blue-200 text-black px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                                Skill
                                            </span>
                                            <span
                                                class="bg-blue-200 text-black px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                                Skill
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Job Preference -->
                                    <div>
                                        <h3 class="font-bold text-[#1E40AF] mb-3 mt-6 md:mt-0">Job Preference</h3>
                                        <div class="flex flex-wrap gap-4">
                                            <span
                                                class="bg-blue-200 text-black px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                                Work Preference
                                            </span>
                                            <span
                                                class="bg-blue-200 text-black px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                                Work Preference
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Job Readiness Assessment -->
                                    <div>
                                        <h3 class="font-bold text-[#1E40AF] mb-3 mt-6 md:mt-0">
                                            Job Readiness Assessment For
                                        </h3>
                                        <p>
                                            <span class="font-semibold text-gray-700">Company Name:</span>
                                            <span class="text-black">-</span>
                                        </p>
                                        <p>
                                            <span class="font-semibold text-gray-700">Job Title:</span>
                                            <span class="text-black">-</span>
                                        </p>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row justify-between items-center px-6 py-4 border-t border-gray-200">
            <span class="text-sm text-gray-600 mb-2 sm:mb-0">Showing 0 to 0 of 0 entries</span>
            <div class="flex items-center space-x-2">
                <button
                    class="px-4 py-2 bg-[#057773] text-white text-sm font-medium rounded-md hover:bg-[#036F6A] transition">
                    Previous
                </button>
                <button
                    class="px-4 py-2 bg-[#057773] text-white text-sm font-medium rounded-md hover:bg-[#036F6A] transition">
                    Next
                </button>
            </div>
        </div>

        <!-- Overview -->
        <h3 class="py-4 font-semibold text-gray-700 text-2xl">Overview</h3>
        <div class="bg-white shadow-md rounded-lg overflow-x-auto mb-6">
            <table class="min-w-full border-collapse text-sm table-auto w-full">
                <thead>
                    <tr class="bg-[#1E40AF] text-white text-left">
                        <th class="px-4 py-3">First Name</th>
                        <th class="px-4 py-3">Last Name</th>
                        <th class="px-4 py-3">Age</th>
                        <th class="px-4 py-3">Email Address</th>
                        <th class="px-4 py-3">Contact Number</th>
                        <th class="px-4 py-3">Date of Birth</th>
                        <th class="px-4 py-3">Address</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3">-</td>
                        <td class="px-4 py-3 text-center">
                            <!-- Status -->
                            <span
                                class="inline-flex items-center justify-center px-3 sm:px-4 py-1.5 text-xs sm:text-sm rounded-full font-medium bg-yellow-100 text-yellow-700 whitespace-nowrap">
                                Pending
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button
                                class="bg-[#057773] hover:bg-[#036F6A] text-white text-xs font-medium px-4 py-2 rounded-md shadow transition duration-200">
                                View Assessment
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
     </div>

        </div>
    </main>
</body>

</html>
