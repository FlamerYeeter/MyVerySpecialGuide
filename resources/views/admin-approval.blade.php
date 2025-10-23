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

      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border border-gray-200 rounded-lg">
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
            <tr class="border-t">
              <td class="px-4 py-2">JuanDC</td>
              <td class="px-4 py-2">Juan</td>
              <td class="px-4 py-2">Dela Cruz</td>
              <td class="px-4 py-2">20</td>
              <td class="px-4 py-2 text-blue-600">juan.delacruz@gmail.com</td>
              <td class="px-4 py-2">+639 876 184 3854</td>
              <td class="px-4 py-2">40 Block Maguining St., Taguig</td>
              <td class="px-4 py-2 text-yellow-500 font-medium">Pending</td>
                <td class="px-4 py-2">
                    <select class="border border-gray-300 rounded-md text-sm p-2 focus:outline-none">
                        <option value="approve" class="text-green-500">Approve</option>
                        <option value="reject" class="text-red-500">Reject</option>
                        <option value="under_review" class="text-yellow-500">Under Review</option>
                    </select>
                </td>
            </tr>
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
            <tr class="border-t">
              <td class="px-4 py-2">Miguel</td>
              <td class="px-4 py-2">Dela</td>
              <td class="px-4 py-2">Cruz</td>
              <td class="px-4 py-2">20</td>
              <td class="px-4 py-2 text-blue-600">miguel.delacruz@gmail.com</td>
              <td class="px-4 py-2">+639 879 634 3800</td>
              <td class="px-4 py-2">40 Block Maguining St., Taguig</td>
              <td class="px-4 py-2 text-yellow-500 font-medium">Pending</td>
              <td class="px-4 py-2">✏️</td>
            </tr>
          </tbody>
        </table>
      </div>
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
            <td class="px-4 py-2">40 Block Maguining St., Taguig</td>
            <td class="px-4 py-2 text-green-500 font-medium">Approved</td>
          </tr>
        </tbody>
      </table>
    </div>

  </main>

</body>
</html>