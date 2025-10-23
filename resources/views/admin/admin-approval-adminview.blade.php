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
<!-- Back button -->
    <button class="flex items-center text-gray-600 mb-5 hover:text-[#2a9cf4]">
      ← <span class="ml-1">Back</span>
    </button>

    <!-- Job Title + Status -->
    <div class="flex justify-between items-start mb-6">
      <div class="flex items-center space-x-4">
        <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" class="w-16 h-16 rounded-md shadow" alt="">
        <div>
          <h2 class="text-xl font-semibold">Pet Care Assistant</h2>
          <p class="text-gray-500 text-sm">📍 Taguig City, Metro Manila</p>
        </div>
      </div>
      <p class="text-yellow-500 font-semibold text-sm uppercase">Under Review</p>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-3 gap-6">

      <!-- Left: Job Description -->
      <div class="col-span-2 space-y-5">

        <!-- Job Description -->
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center space-x-2 mb-4">
            <span class="text-lg font-medium">📄 Job Description</span>
          </div>

          <div class="mb-4">
            <h3 class="font-semibold text-gray-700 mb-2">About</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
              The Pet Care Assistant plays an important role in ensuring that all animals in our care are safe, clean, and happy.
              This position supports the team by feeding pets, keeping their spaces neat and tidy, and giving them the attention
              they need. The role also involves helping pets stay healthy and comfortable, while providing them with kindness,
              affection, and companionship every day.
            </p>
          </div>

          <!-- Key Responsibilities -->
          <div class="mb-4">
            <h3 class="font-semibold text-gray-700 mb-2">Key Responsibilities</h3>
            <div class="space-y-2">
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
            </div>
          </div>

          <!-- Requirements -->
          <div class="mb-4">
            <h3 class="font-semibold text-gray-700 mb-2">Requirements</h3>
            <div class="space-y-2">
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
              <div class="border rounded-md px-3 py-2">[Placeholder Text]</div>
            </div>
          </div>

          <!-- Skills -->
          <div>
            <h3 class="font-semibold text-gray-700 mb-2">Skills</h3>
            <div class="flex flex-wrap gap-2">
              <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Organization</span>
              <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Cleaning</span>
              <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Following Instructions</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Right: Job Info and Map -->
      <div class="col-span-1 space-y-5">

        <!-- Availability -->
        <div class="grid grid-cols-2 gap-2 bg-white p-4 rounded-lg shadow text-sm">
          <div>
            <p class="font-semibold">Availability</p>
            <p class="text-gray-500">Part time</p>
          </div>
          <div>
            <p class="font-semibold">Experience</p>
            <p class="text-gray-500">5+ years</p>
          </div>
          <div>
            <p class="font-semibold">Work Approach</p>
            <p class="text-gray-500">Onsite</p>
          </div>
          <div>
            <p class="font-semibold">Industry</p>
            <p class="text-gray-500">Healthcare</p>
          </div>
        </div>

        <!-- Contact Details -->
        <div class="bg-white rounded-lg shadow p-5 text-sm">
          <h3 class="bg-[#0d6efd] text-white px-3 py-2 rounded-md font-medium mb-3">Contact Details</h3>
          <p><span class="font-semibold">Address:</span> The Fort Residences, Burgos Cir, Makati City, 1630 Metro Manila</p>
          <p><span class="font-semibold">Phone:</span> 0981 633 2222</p>
          <p><span class="font-semibold">Email:</span> ipetclub2023@gmail.com</p>
          <p><span class="font-semibold">Products and Services:</span> Facebook.com</p>
          <p><span class="font-semibold">Service Options:</span> Onsite services</p>
          <p><span class="font-semibold">Hours:</span> <span class="text-green-600 font-semibold">Open</span></p>
          <p><span class="font-semibold">Located in:</span> The Fort Residences</p>

          <!-- Map -->
          <div class="mt-3">
            <img src="https://maps.googleapis.com/maps/api/staticmap?center=Taguig,Metro+Manila&zoom=15&size=300x200&markers=color:red%7CTaguig" alt="Map" class="rounded-md border">
          </div>
        </div>

        <!-- Hiring Manager -->
        <div class="bg-white rounded-lg shadow p-5 text-sm">
          <h3 class="font-semibold mb-3">Hiring Manager</h3>
          <div class="space-y-3">
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 rounded-full bg-gray-200"></div>
              <div>
                <p class="font-medium">John Carlo Garcia</p>
                <p class="text-gray-500 text-xs">Recruiter</p>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 rounded-full bg-gray-200"></div>
              <div>
                <p class="font-medium">Clarence Aquino</p>
                <p class="text-gray-500 text-xs">HR Manager</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    </main>
</body>
</html>