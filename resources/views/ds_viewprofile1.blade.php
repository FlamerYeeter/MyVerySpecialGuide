@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
            <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
                <a href="/"
                    class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back</span>
                </a>
            </div>
        </div>


        <!-- Profile Section -->
        <section class="max-w-7xl mx-auto px-6 py-12 space-y-10">

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <div class="bg-blue-800 text-white flex items-center gap-6 px-8 py-8 rounded-t-2xl">
                    <div
                        class="bg-white text-blue-800 font-bold rounded-full w-20 h-20 flex items-center justify-center text-2xl">
                        JD
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold">Juan Dela Cruz</h1>
                        <p class="flex items-center gap-2 text-base mt-2"><img
                                src="https://img.icons8.com/color/48/marker--v1.png" alt="Location" class="w-6 h-6">
                            Taguig City, Metro Manila</p>
                        <p class="flex items-center gap-4 text-base mt-2"><img
                                src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" alt="Email Icon"
                                class="w-5 h-5">
                            juancruz@gmail.com</p>
                    </div>
                </div>

                <div class="p-8">

<!-- Personal Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Personal Information</h3>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">First Name <span
                                        class="text-gray-500">(Unang Pangalan)</span></label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Last Name <span
                                        class="text-gray-500">(Apelyido)</span></label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Age <span
                                        class="text-gray-500">(Edad)</span></label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Email Address</label>
                                <input type="email" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Phone Number</label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-base font-semibold text-black-700 mb-2">Address <span
                                    class="text-gray-500">(Tirahan)</span></label>
                            <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                        </div>

                        <div class="mt-6">
                            <label class="block text-base font-semibold text-black-700 mb-2">Type of Syndrome<span
                                    class="text-gray-500">(optional)</span></label>
                            <select id="" name=""
                                class="w-full sm:w-60 border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Type --</option>
                                <option value="Trisomy 21 (Nondisjunction)">Trisomy 21 (Nondisjunction)</option>
                                <option value="Mosaic Down Syndrome">Mosaic Down Syndrome</option>
                                <option value="Translocation Down">Translocation Down Syndrome</option>
                            </select>
                        </div>

                        <div class="flex flex-col items-end mt-6 space-y-2">
                            <p class="text-sm text-gray-500">Pindutin ang <span
                                    class="text-blue-600 font-medium">"Edit"</span> upang baguhin</p>
                            <button
                                class="bg-green-500 text-white px-24 py-3 rounded-lg text-base font-medium hover:bg-green-600">Edit</button>
                        </div>
                    </section>

<!-- Parent/Guardian Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Parent/Guardian Information</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">First Name <span
                                        class="text-gray-500">(Unang Pangalan)</span></label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Last Name <span
                                        class="text-gray-500">(Apelyido)</span></label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Email Address</label>
                                <input type="email" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Phone Number</label>
                                <input type="text" value="" class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-base font-semibold text-black-700 mb-2">Relation to User <span
                                    class="text-gray-500">(Ka-ano-ano mo siya?)</span></label>
                            <select id=""
                                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring focus:ring-blue-200 focus:outline-none">
                                <option value="" disabled selected>Select Relationship</option>
                                <option value="parent">Parent</option>
                                <option value="guardian">Guardian</option>
                                <option value="sibling">Sibling</option>
                                <option value="relative">Relative</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="flex flex-col items-end mt-6 space-y-2">
                            <p class="text-sm text-gray-500">Pindutin ang <span
                                    class="text-blue-600 font-medium">"Edit"</span> upang baguhin</p>
                            <button
                                class="bg-green-500 text-white px-24 py-3 rounded-lg text-base font-medium hover:bg-green-600">Edit</button>
                        </div>
                    </section>

<!-- Account Details -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Account Details</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Username</label>
                                <input type="text" value=""
                                    class="w-full border rounded-lg px-4 py-3 text-base">
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Password</label>
                                <input type="password" value=""
                                    class="w-full border rounded-lg px-4 py-3 text-base">
                                <p class="text-sm text-gray-500 mt-2 flex items-center gap-2"><input type="checkbox">
                                    Click the box to show password (Pindutin ang box para makita ang password)</p>
                                <p class="text-sm text-gray-500 mt-2">Pindutin ang <a href="#"
                                        class="text-blue-600 underline">"Change Password"</a> upang baguhin</p>
                                <button
                                    class="bg-blue-800 text-white px-6 py-3 mt-3 rounded-lg text-base font-medium hover:bg-blue-900">Change
                                    Password</button>
                            </div>
                        </div>


                        <div class="flex flex-col items-end mt-6 space-y-2">
                            <p class="text-sm text-gray-500">Pindutin ang <span
                                    class="text-blue-600 font-medium">"Edit"</span> upang baguhin</p>
                            <button
                                class="bg-green-500 text-white px-24 py-3 rounded-lg text-base font-medium hover:bg-green-600">Edit</button>
                        </div>
                    </section>


<!-- Uploaded Files -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Uploaded Files</h3>

                        <div class="grid md:grid-cols-2 gap-6">
<!-- Membership -->
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Proof of Membership
                                    <span class="text-gray-500 italic">Uploaded file (if any)</span></label>
                                <div class="border rounded-lg px-4 py-3 bg-gray-50 text-gray-700">No file uploaded
                                </div>
                            </div>

<!-- Medical Certificate -->
                            <div>
                                <label class="block text-base font-semibold text-black-700 mb-2">Medical Certificate
                                    <span class="text-gray-500 italic">Uploaded file (if any)</span></label>
                                <div class="border rounded-lg px-4 py-3 bg-gray-50 text-gray-700">No file uploaded
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-end mt-6 space-y-2">
                            <p class="text-sm text-gray-500">
                                Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                            </p>
                            <button
                                class="bg-green-500 text-white px-24 py-3 rounded-lg text-base font-medium hover:bg-green-600">
                                Edit
                            </button>
                        </div>
                    </section>


                    <!-- Next Button -->
                    <div class="text-center space-y-3">
                        <button
                            class="bg-blue-800 text-white font-medium px-32 py-4 rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2 mx-auto text-lg">
                            Next → <i class="ri-arrow-right-line text-2xl"></i>
                        </button>
                        <p class="text-base">Click <span class="text-blue-800 font-medium">"Next"</span> to move to the
                            next page</p>
                        <p class="text-sm text-gray-500">(Pindutin ang <span
                                class="text-blue-800 font-medium">"Next"</span> upang lumipat sa susunod na pahina)</p>
                    </div>

        </section>
    </main>
@endsection
