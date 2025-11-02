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
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-4 mb-6 w-full relative">


            <div>
                <div class="text-sm text-gray-500">
                    <span class="text-[#FBBF24] font-medium">Home</span>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-700 font-medium">Job Post</span>
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

                <div id="profileBtn"
                    class="flex items-center gap-1 w-fit h-9 bg-gray-100 border border-gray-200 rounded-full px-2 cursor-pointer relative z-10">
                    <i class="ri-user-line text-gray-500 text-lg"></i>
                    <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
                </div>
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

                <!-- Company Info Section -->
                <div
                    class="relative bg-white px-8 py-5 border border-gray-200 rounded-sm shadow-sm w-full sm:col-span-2">



                    <!-- Back Button -->
                    <button onclick="window.history.back()"
                        class="absolute -left-6 top-1/2 -translate-y-1/2 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-full p-2 shadow transition">
                        <i class="ri-arrow-left-line text-lg"></i>
                    </button>

                    <!-- Company Info -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full gap-4">
                        <div class="flex items-center gap-4 flex-wrap">
                            <!-- Logo -->
                            <div
                                class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 shrink-0">
                                <img id="companyLogo" alt="Company Logo" class="w-full h-full object-cover hidden"
                                    onerror="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');" />
                                <i class="ri-building-4-line text-gray-500 text-5xl"></i>
                            </div>

                            <!-- Text Info -->
                            <div>
                                <h2 class="mt-4 text-lg font-semibold text-gray-800">Company Name</h2>
                                <p class="mt-1 text-gray-500 text-sm flex items-center gap-1">
                                    <i class="ri-map-pin-line text-black text-lg"></i>
                                    Company Location
                                </p>
                                <span
                                    class="inline-block mb-2 mt-2 bg-green-100 text-green-700 text-sm font-medium px-4 py-1 rounded-lg min-w-[150px] text-center">
                                    Full Support
                                </span>
                            </div>
                        </div>

                        <!-- Right: Status Tag -->
                        <div class="flex items-center justify-center">
                            <span
                                class="text-blue-600 font-semibold text-sm border bg-blue-50 px-5 py-1.5 rounded-md shadow-sm">
                                STATUS TAG
                            </span>
                        </div>
                    </div>

                    <!-- Blue Header Line -->
                    <div class="relative mt-6">
                        <div class="border-b-2 border-[#2563EB] w-full"></div>
                        <span class="absolute -top-3 left-6 bg-white px-3 text-[#2563EB] font-semibold text-base">
                            Job Details
                        </span>
                    </div>
                </div>

                <!-- Job Description Sections -->
                <div class="p-6 space-y-6 bg-white rounded-sm border border-gray-200 shadow-sm">
                    <div>
                        <h3 class="font-semibold text-black-700 mb-2">Job Description</h3>
                        <div class="border border-gray-200 rounded-sm h-24"></div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-black-700 mb-2">Responsibilities</h3>
                        <div class="border border-gray-200 rounded-sm h-24"></div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-black-700 mb-2">Requirements</h3>
                        <div class="border border-gray-200 rounded-sm h-24"></div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-black-700 mb-2">Preferred Candidates</h3>
                        <div class="border border-gray-200 rounded-sm h-24"></div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-black-700 mb-2">Purpose</h3>
                        <div class="border border-gray-200 rounded-sm h-24"></div>
                    </div>
                </div>
            </div>

            <!-- Right Side Info Panel -->
            <aside class="w-full lg:w-80 space-y-6">

                <!-- Skills -->
                <div class="bg-white rounded-sm border border-gray-200 shadow-sm p-4">
                    <h3 class="font-semibold text-black-700 mb-3">Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 text-xs rounded-full border text-blue-500">Teamwork</span>
                        <span class="px-3 py-1 text-xs rounded-full border text-blue-500">Cleaning</span>
                        <span class="px-3 py-1 text-xs rounded-full border text-blue-500">Following Instructions</span>
                        <span class="px-3 py-1 text-xs rounded-full border text-blue-500">Patience</span>
                        <span class="px-3 py-1 text-xs rounded-full border text-blue-500">Detail-oriented</span>
                        <span class="px-3 py-1 text-xs rounded-full border text-blue-500">Empathy</span>
                    </div>
                </div>

                <!-- Job Program -->
                <div class="bg-white rounded-sm border border-gray-200 shadow-sm p-4">
                    <h3 class="font-semibold text-black-700 mb-2">Job Program</h3>
                    <span
                        class="inline-block border border-green-400 text-green-600 px-3 py-1 rounded-full text-sm font-medium">Love
                        'Em Down</span>
                </div>

                <!-- Hiring Manager -->
                <div class="bg-white rounded-sm border border-gray-200 shadow-sm p-4">
                    <h3 class="font-semibold text-black-700 mb-3">Hiring Manager</h3>
                    <div class="flex items-center gap-3">
                        <!-- Profile Image Placeholder -->
                        <div
                            class="w-12 h-12 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden">
                            <i class="ri-user-line text-gray-400 text-2xl"></i>
                            <!--
                           <img src="path-to-profile.jpg" alt="Profile" class="w-full h-full object-cover hidden"
                            onerror="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');" />
                            -->
                        </div>

                        <!-- Name and Title -->
                        <div class="flex flex-col">
                            <p class="font-medium text-base text-gray-800">John Carlo Garcia</p>
                            <p class="text-gray-500 text-xs">Human Resources Manager</p>
                        </div>
                    </div>
                </div>
                <!-- Contact Details -->
                <div class="bg-white rounded-sm border border-gray-200 shadow-sm p-4 space-y-3">
                    <h3 class="font-semibold text-black-700">Contact Details</h3>
                    <p class="text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-map-pin-line text-black text-lg"></i>
                        Lot 8 Blk W-39E Quezon Avenue, cor Jose Abad Santos St., Quezon City, Metro Manila
                    </p>
                    <p class="text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-phone-line text-black text-lg"></i> +63 5587 1234
                    </p>
                    <p class="text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-mail-line text-black text-lg"></i> Juan.Carla@shakeys.com
                    </p>
                    <p class="text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-building-4-line text-black text-lg"></i> Restaurant
                    </p>
                    <a href="https://www.shakeyspizza.ph/sustainability/people" target="_blank"
                        class="text-blue-500 text-sm flex items-center gap-4 hover:underline">
                        <i class="ri-link text-black text-lg"></i> https://www.shakeyspizza.ph/
                    </a>
                    <a href="https://maps.app.goo.gl/xTquSe3sPdryda7" target="_blank"
                        class="text-blue-500 text-sm flex items-center gap-4 hover:underline">
                        <i class="ri-map-2-line text-black text-lg"></i> Google Maps
                    </a>
                </div>
            </aside>

        </div>

    </main>

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

</body>

</html>
