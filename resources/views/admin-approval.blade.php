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
<div class="flex bg-gray-100 p-2 rounded-lg shadow-inner w-max space-x-2 mb-4">
  <button class="px-6 py-2 bg-white text-black font-semibold rounded-md shadow-sm">USER</button>
  <button class="px-6 py-2 text-gray-500 font-medium hover:text-black">EXPERT</button>
  <button class="px-6 py-2 text-gray-500 font-medium hover:text-black">COMPANY</button>
  <button class="px-6 py-2 text-gray-500 font-medium hover:text-black">JOB POSTING</button>
</div>



      <!-- Status Cards -->
      <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow-sm rounded-lg p-4 text-center">
          <p class="text-gray-500 text-sm">Pending Queue</p>
          <p class="text-2xl font-bold">10</p>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-4 text-center border-t-4 border-green-500">
          <p class="text-gray-500 text-sm">Approved</p>
          <p class="text-2xl font-bold">16</p>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-4 text-center border-t-4 border-yellow-400">
          <p class="text-gray-500 text-sm">Under Review</p>
          <p class="text-2xl font-bold">4</p>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-4 text-center border-t-4 border-red-500">
          <p class="text-gray-500 text-sm">Rejected</p>
          <p class="text-2xl font-bold">2</p>
        </div>
      </div>

     <!-- Filter -->
      <div class="flex justify-between items-center mb-3">
        <p class="font-medium">Status</p>
        <select class="border border-gray-300 rounded-md text-sm p-2 focus:outline-none">
          <option>All</option>
          <option>Pending</option>
          <option>Approved</option>
          <option>Rejected</option>
        </select>
      </div>

      <!-- Main Table -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left">
          <thead class="bg-pink-200 text-gray-800">
            <tr>
              <th class="px-4 py-2">Username</th>
              <th class="px-4 py-2">First Name</th>
              <th class="px-4 py-2">Last Name</th>
              <th class="px-4 py-2">Age</th>
              <th class="px-4 py-2">Email Address</th>
              <th class="px-4 py-2">Contact Number</th>
              <th class="px-4 py-2">Address</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <!-- Row 1 -->
            <tr class="border-t">
              <td class="px-4 py-2">JuanDC</td>
              <td class="px-4 py-2">Juan</td>
              <td class="px-4 py-2">Dela Cruz</td>
              <td class="px-4 py-2">20</td>
              <td class="px-4 py-2 text-blue-600">juan.delacruz@gmail.com</td>
              <td class="px-4 py-2">+639 876 184 3854</td>
              <td class="px-4 py-2">40 Block Maguining St., Taguig City</td>
              <td class="px-4 py-2 text-yellow-500 font-medium">Pending</td>
              <td class="px-4 py-2">
              <button class="text-blue-600 hover:text-blue-800">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </button>

                <select class="border border-gray-300 rounded-md text-sm p-2 focus:outline-none">
                  <option>Approve</option>
                  <option>Reject</option>
                  <option>Under Review</option>
                </select>
                <button class="text-red-500 hover:text-red-700">
                    🗑️
                </button>
              </td>
            </tr>

            <!-- Guardian Info -->
            <tr class="bg-pink-50 border-t">
              <td colspan="9" class="px-4 py-3">
                <p class="font-medium text-sm text-gray-700 mb-2">Guardian Information</p>
                <table class="w-full text-xs border border-gray-200">
                  <thead class="bg-pink-100">
                    <tr>
                      <th class="px-3 py-2">First Name</th>
                      <th class="px-3 py-2">Last Name</th>
                      <th class="px-3 py-2">Email Address</th>
                      <th class="px-3 py-2">Contact Number</th>
                      <th class="px-3 py-2">Relationship to User</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-3 py-2">Juan</td>
                      <td class="px-3 py-2">Dela Cruz</td>
                      <td class="px-3 py-2 text-blue-600">juan.delacruz@gmail.com</td>
                      <td class="px-3 py-2">+639 876 184 3854</td>
                      <td class="px-3 py-2">Son</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>

            <!-- Row 2 -->
            <tr class="border-t">
              <td class="px-4 py-2">Miguel</td>
              <td class="px-4 py-2">Dela</td>
              <td class="px-4 py-2">Cruz</td>
              <td class="px-4 py-2">20</td>
              <td class="px-4 py-2 text-blue-600">miguel.delacruz@gmail.com</td>
              <td class="px-4 py-2">+639 879 634 3800</td>
              <td class="px-4 py-2">40 Block Maguining St., Taguig City</td>
              <td class="px-4 py-2 text-yellow-500 font-medium">Pending</td>
              <td class="px-4 py-2 text-lg">✏️</td>
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

      <!-- Overview Table -->
      <div class="bg-white mt-8 shadow-sm rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-3">Overview</h3>
        <table class="w-full text-sm border border-gray-200 rounded-lg">
          <thead class="bg-pink-200">
            <tr>
              <th class="px-4 py-2">Username</th>
              <th class="px-4 py-2">First Name</th>
              <th class="px-4 py-2">Last Name</th>
              <th class="px-4 py-2">Age</th>
              <th class="px-4 py-2">Email Address</th>
              <th class="px-4 py-2">Contact Number</th>
              <th class="px-4 py-2">Address</th>
              <th class="px-4 py-2">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <tr>
              <td class="px-4 py-2">JuanDC</td>
              <td class="px-4 py-2">Juan</td>
              <td class="px-4 py-2">Dela Cruz</td>
              <td class="px-4 py-2">20</td>
              <td class="px-4 py-2 text-blue-600">juan.delacruz@gmail.com</td>
              <td class="px-4 py-2">+639 876 184 3854</td>
              <td class="px-4 py-2">40 Block Maguining St., Taguig City</td>
              <td class="px-4 py-2 text-green-500 font-medium">Approved</td>
            </tr>
            
          </tbody>
        </table>
      </div>

    </main>
  </div>

</body>
</html>