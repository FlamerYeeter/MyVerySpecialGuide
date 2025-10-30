@extends('layouts.includes')

@section('content')

<main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


  <!-- Back Section -->
  <div class="bg-yellow-400 py-3 px-6 flex items-center gap-2 font-medium text-gray-800">
    <i class="ri-arrow-left-line text-lg"></i> Back
  </div>

  <!-- Profile Section -->
  <section class="max-w-5xl mx-auto px-4 py-10 space-y-8">

    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="bg-blue-800 text-white flex items-center gap-4 px-6 py-6 rounded-t-xl">
        <div class="bg-white text-blue-800 font-bold rounded-full w-16 h-16 flex items-center justify-center text-xl">
          JC
        </div>
        <div>
          <h2 class="text-lg font-semibold">Juan Dela Cruz</h2>
          <p class="flex items-center gap-2 text-sm"><i class="ri-map-pin-line"></i> Taguig City, Metro Manila</p>
          <p class="flex items-center gap-2 text-sm"><i class="ri-mail-line"></i> juancruz@gmail.com</p>
        </div>
      </div>

      <div class="p-6">
        <!-- Personal Info -->
        <section class="border-b border-gray-200 pb-6 mb-6">
          <h3 class="text-lg font-bold mb-4">Personal Information</h3>
          <div class="grid md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm text-gray-600 mb-1">First Name <span class="text-gray-400">(Unang Pangalan)</span></label>
              <input type="text" value="Juan" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
              <label class="block text-sm text-gray-600 mb-1">Last Name <span class="text-gray-400">(Apelyido)</span></label>
              <input type="text" value="Dela Cruz" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
              <label class="block text-sm text-gray-600 mb-1">Age <span class="text-gray-400">(Edad)</span></label>
              <input type="text" value="22 yrs old" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-4 mt-4">
            <div>
              <label class="block text-sm text-gray-600 mb-1">Email Address</label>
              <input type="email" value="juan.delacruz@gmail.com" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
              <label class="block text-sm text-gray-600 mb-1">Phone Number</label>
              <input type="text" value="+63 917 123 4567" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
          </div>

          <div class="mt-4">
            <label class="block text-sm text-gray-600 mb-1">Address <span class="text-gray-400">(Tirahan)</span></label>
            <input type="text" value="Taguig City, Metro Manila" class="w-full border rounded-md px-3 py-2 text-sm">
          </div>

          <div class="flex justify-between items-center mt-4">
            <p class="text-xs text-gray-500">Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin</p>
            <button class="bg-green-500 text-white px-6 py-2 rounded-md font-medium hover:bg-green-600">Edit</button>
          </div>
        </section>

        <!-- Parent/Guardian Info -->
        <section class="border-b border-gray-200 pb-6 mb-6">
          <h3 class="text-lg font-bold mb-4">Parent/Guardian Information</h3>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm text-gray-600 mb-1">First Name (Unang Pangalan)</label>
              <input type="text" value="Joseph" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
              <label class="block text-sm text-gray-600 mb-1">Last Name (Apelyido)</label>
              <input type="text" value="Cruz" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-4 mt-4">
            <div>
              <label class="block text-sm text-gray-600 mb-1">Email Address</label>
              <input type="email" value="josephcruz@gmail.com" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
              <label class="block text-sm text-gray-600 mb-1">Phone Number</label>
              <input type="text" value="+63 917 123 4567" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
          </div>

          <div class="mt-4">
            <label class="block text-sm text-gray-600 mb-1">Relation to User (Ka-ano-ano mo siya?)</label>
            <select class="w-full border rounded-md px-3 py-2 text-sm">
              <option>Parent</option>
              <option>Guardian</option>
            </select>
          </div>

          <div class="flex justify-between items-center mt-4">
            <p class="text-xs text-gray-500">Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin</p>
            <button class="bg-green-500 text-white px-6 py-2 rounded-md font-medium hover:bg-green-600">Edit</button>
          </div>
        </section>

        <!-- Account Details -->
        <section>
          <h3 class="text-lg font-bold mb-4">Account Details</h3>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm text-gray-600 mb-1">Username</label>
              <input type="text" value="@juandelacruz" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
              <label class="block text-sm text-gray-600 mb-1">Password</label>
              <input type="password" value="********" class="w-full border rounded-md px-3 py-2 text-sm">
              <p class="text-xs text-gray-500 mt-1"><input type="checkbox"> Click the box to show password (Pindutin ang box para makita ang password)</p>
              <p class="text-xs text-gray-500 mt-1">Pindutin ang <a href="#" class="text-blue-600 underline">"Change Password"</a> upang baguhin</p>
              <button class="bg-blue-800 text-white px-5 py-2 mt-2 rounded-md font-medium hover:bg-blue-900">Change Password</button>
            </div>
          </div>

          <div class="flex justify-between items-center mt-4">
            <p class="text-xs text-gray-500">Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin</p>
            <button class="bg-green-500 text-white px-6 py-2 rounded-md font-medium hover:bg-green-600">Edit</button>
          </div>
        </section>
      </div>
    </div>

    <!-- Next Button -->
    <div class="text-center space-y-2">
      <button class="bg-blue-800 text-white font-medium px-10 py-3 rounded-md hover:bg-blue-900 flex items-center justify-center gap-2 mx-auto">
        Next <i class="ri-arrow-right-line text-xl"></i>
      </button>
      <p class="text-sm">Click <span class="text-blue-800 font-medium">"Next"</span> to move to the next page</p>
      <p class="text-xs text-gray-500">(Pindutin ang <span class="text-blue-800 font-medium">"Next"</span> upang lumipat sa susunod na pahina)</p>
    </div>

  </section>
</main>

@endsection
