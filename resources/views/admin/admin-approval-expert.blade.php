<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval - AdminHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-700">
    <div class="flex h-screen">

        <!-- Sidebar include -->
        @include('layouts.adminsidebar')
        <!-- Main Content -->
  <main class="flex-1 p-6 overflow-y-auto scrollbar-hide">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <nav class="text-sm text-gray-500">
        Home <span class="mx-1">›</span> <span class="text-black font-medium">Approval</span>
      </nav>
      <div class="flex items-center space-x-4">
        <button class="bg-gray-100 p-2 rounded-full">🔍</button>
        <button class="bg-gray-100 p-2 rounded-full">🔔</button>
        <div class="bg-gray-200 w-8 h-8 rounded-full"></div>
      </div>
    </div>

    <!-- Title -->
    <h2 class="text-2xl font-semibold mt-4 mb-3">Approval</h2>

    <!-- Tabs -->
    <div class="flex flex-wrap gap-3 mb-5 text-gray-600 font-medium">
      <button class="px-3 py-2 hover:text-[#2a9cf4] border border-gray-200 rounded-md">User Approval</button>
      <button class="px-3 py-2 active-tab">New Admin Approval</button>
      <button class="px-3 py-2 hover:text-[#2a9cf4] border border-gray-200 rounded-md">Expert Approval</button>
      <button class="px-3 py-2 hover:text-[#2a9cf4] border border-gray-200 rounded-md">Job Application Approval</button>
      <button class="px-3 py-2 hover:text-[#2a9cf4] border border-gray-200 rounded-md">Job Posting Approval</button>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-4 gap-4 mb-6">
      <div class="bg-white shadow-sm rounded-lg p-4 text-center">
        <p class="text-gray-500 text-sm">Pending Queue</p>
        <p class="text-2xl font-bold text-black">10</p>
      </div>
      <div class="bg-white shadow-sm rounded-lg p-4 text-center border-t-4 border-green-500">
        <p class="text-gray-500 text-sm">Approved</p>
        <p class="text-2xl font-bold text-black">16</p>
      </div>
      <div class="bg-white shadow-sm rounded-lg p-4 text-center border-t-4 border-yellow-400">
        <p class="text-gray-500 text-sm">Under Review</p>
        <p class="text-2xl font-bold text-black">4</p>
      </div>
      <div class="bg-white shadow-sm rounded-lg p-4 text-center border-t-4 border-red-500">
        <p class="text-gray-500 text-sm">Rejected</p>
        <p class="text-2xl font-bold text-black">2</p>
      </div>
    </div>

   <!-- Table -->
    <div class="bg-white shadow-sm rounded-lg p-4">
      <div class="flex justify-between items-center mb-3">
        <p class="font-medium">Status</p>
        <select class="border border-gray-300 rounded-md text-sm p-2 focus:outline-none">
          <option>All</option>
          <option>Pending</option>
          <option>Approved</option>
          <option>Rejected</option>
        </select>
      </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
      <table class="w-full text-sm text-left border-collapse">
        <thead class="bg-[#004aad] text-white">
          <tr>
            <th class="px-4 py-3">First Name</th>
            <th class="px-4 py-3">Last Name</th>
            <th class="px-4 py-3">Gender</th>
            <th class="px-4 py-3">Email Address</th>
            <th class="px-4 py-3">Contact Number</th>
            <th class="px-4 py-3">Date of Birth</th>
            <th class="px-4 py-3">Address</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b">
            <td class="px-4 py-3">Juan</td>
            <td class="px-4 py-3">Dela Cruz</td>
            <td class="px-4 py-3">Male</td>
            <td class="px-4 py-3 text-blue-600">juan.delacruz@gmail.com</td>
            <td class="px-4 py-3">+639 876 134 3654</td>
            <td class="px-4 py-3">September 10, 1994</td>
            <td class="px-4 py-3">48 Block Kagawingan St. West Avenue, Taguig City</td>
            <td class="px-4 py-3 text-yellow-500 font-medium">Pending</td>
            <td class="px-4 py-2 text-center">
                <div class="flex justify-center items-center space-x-2">
                    <select class="border rounded-md text-sm p-1 focus:outline-none bg-white">
                        <option class="bg-green-500 text-white">Approved</option>
                        <option class="bg-red-500 text-white">Rejected</option>
                    </select>
                    <button class="text-red-500 hover:text-red-700">
                    🗑️
                    </button>
                </div>
            </td>
          </tr>

          <!-- Expanded Row -->
          <tr class="bg-gray-50 border-b">
            <td colspan="9" class="p-5">
              <div class="grid grid-cols-2 gap-8 text-sm">
                <div>
                  <h4 class="font-semibold text-gray-700 mb-2">Account Details</h4>
                  <table class="w-full border-collapse text-gray-700">
                    <tr>
                      <td class="font-medium w-1/3">Username</td>
                      <td>JuanDC</td>
                    </tr>
                    <tr>
                      <td class="font-medium w-1/3">Valid ID Upload</td>
                      <td>
                        <div class="flex items-center space-x-2 mt-1">
                          <span class="bg-gray-100 border px-2 py-1 text-xs rounded flex items-center">
                            📄 Juan_DelaCruz_IDUpload.pdf
                          </span>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>

                <div>
                  <h4 class="font-semibold text-gray-700 mb-2">Professional Information</h4>
                  <table class="w-full border-collapse text-gray-700">
                    <tr>
                      <td class="font-medium w-1/3">Professional Title</td>
                      <td>Licensed Engineer</td>
                    </tr>
                    <tr>
                      <td class="font-medium">PRC ID</td>
                      <td>123456</td>
                    </tr>
                    <tr>
                      <td class="font-medium">Years of Experience</td>
                      <td>8</td>
                    </tr>
                    <tr>
                      <td class="font-medium">Area of Specialization</td>
                      <td>Civil Engineering</td>
                    </tr>
                    <tr>
                      <td class="font-medium">Organization Name</td>
                      <td>ABC Builders Inc.</td>
                    </tr>
                    <tr>
                      <td class="font-medium">Position</td>
                      <td>Project Engineer</td>
                    </tr>
                    <tr>
                      <td class="font-medium">Work Address</td>
                      <td>Makati City</td>
                    </tr>
                    <tr>
                      <td class="font-medium">Proof of Employment</td>
                      <td>
                        <span class="bg-gray-100 border px-2 py-1 text-xs rounded">📄 JuanDelaCruz_Employment.pdf</span>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-end items-center mt-4 space-x-2 text-sm">
      <button class="px-2 py-1 border rounded">« Previous</button>
      <button class="px-3 py-1 border rounded">1</button>
      <button class="px-3 py-1 border rounded bg-gray-200 font-medium">2</button>
      <button class="px-3 py-1 border rounded">3</button>
      <button class="px-3 py-1 border rounded">4</button>
      <button class="px-2 py-1 border rounded">Next »</button>
    </div>

    <!-- Overview -->
    <div class="bg-white mt-8 shadow-sm rounded-lg p-4">
      <h3 class="text-lg font-semibold mb-3">Overview</h3>
      <table class="w-full text-sm border border-gray-200 rounded-lg">
        <thead class="bg-[#004aad] text-white">
          <tr>
            <th class="px-4 py-3">First Name</th>
            <th class="px-4 py-3">Last Name</th>
            <th class="px-4 py-3">Gender</th>
            <th class="px-4 py-3">Email Address</th>
            <th class="px-4 py-3">Contact Number</th>
            <th class="px-4 py-3">Date of Birth</th>
            <th class="px-4 py-3">Address</th>
            <th class="px-4 py-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-gray-400">
            <td colspan="8" class="px-4 py-6 text-center">No records found</td>
          </tr>
        </tbody>
      </table>
    </div>



    </main>
</body>
</html>