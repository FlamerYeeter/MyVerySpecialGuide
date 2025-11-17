@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
            <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
                <a href="/viewprofile1"
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

<!-- Education Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Education</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Education Level -->
                            <div>
                                <label class="font-semibold block mb-1">Education Level:</label>

                                <!-- Display Mode -->
                                <span id="educationLevel" class="block"></span>

                                <!-- Edit Mode -->
                                <select id="edit_edu_select" class="hidden w-full border rounded px-3 py-2">
                                    <option value="College">College</option>
                                    <option value="Vocational/Training">Vocational/Training</option>
                                    <option value="High School">High School</option>
                                    <option value="Elementary">Elementary</option>
                                </select>
                            </div>

                            <!-- School Name -->
                            <div class="col-span-2">
                                <label class="font-semibold block mb-1">School Name:</label>

                                <!-- Display Mode -->
                                <span id="schoolName" class="block"></span>

                                <!-- Edit Mode -->
                                <input type="text" id="edit_school_input"
                                    class="hidden w-full border rounded px-3 py-2" />
                            </div>
                        </div>

                        <div>
                            <label class="mt-8 block text-base font-semibold text-black-700 mb-2">Certificates & Trainings
                                <span class="text-gray-500 italic">Uploaded file (if any)</span></label>
                            <div class="border rounded-lg px-4 py-3 bg-gray-50 text-gray-700">No file uploaded
                            </div>
                            <!-- Upload Button -->
                            <button
                                class="mt-3 bg-blue-800 text-white px-5 py-2 rounded-lg text-base font-medium hover:bg-blue-700">
                                Click to Upload Certificate & Training
                            </button>
                        </div>

                        <!-- Edit Button -->
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

<!-- Work Experience Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Work Experience</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Type of Work + Job Experiences -->
                            <div class="col-span-1">

                                <!-- Type of Work Row -->
                                <p class="flex items-center gap-2 mb-4">
                                    <span class="font-semibold">Type of Work:</span>
                                    <span id="review_work_list" class="text-gray-600">
                                        -
                                    </span>
                                </p>

                                <!-- Job Experiences -->
                                <h4 class="mt-8 text-xl font-semibold text-blue-800 mb-2">Job Experiences</h4>
                                <div id="review_job_experiences" class="space-y-2 text-gray-800">
                                    <p class="text-gray-600 italic">No job experiences added.</p>
                                </div>
                                <!-- Add Work Experience Button -->
                                <button
                                    class="mt-3 bg-blue-800 text-white px-5 py-2 rounded-lg text-base font-medium hover:bg-blue-700">
                                    Click to Add Work Experience
                                </button>
                            </div>

                            <!-- Empty divs to stabilize grid alignment -->
                            <div></div>
                            <div></div>

                        </div>

                        <!-- Edit Button -->
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

<!-- Work Environment Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Work Environment</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Preferred Workplace -->
                            <div class="col-span-1">

                                <p class="flex items-center gap-2 mb-4">
                                    <span class="font-semibold">Preferred Workplace:</span>
                                    <span id="review_workplace_list" class="text-gray-600">
                                        -
                                    </span>
                                </p>
                            </div>

                            <div id="review_workplace_choice_img_container" class="mt-4 text-center hidden">
                                <div
                                    class="inline-flex items-center justify-center w-40 h-40 bg-white rounded-xl shadow-md p-2 mx-auto">
                                    <img id="review_workplace_choice_img" src="" alt="Workplace image"
                                        class="w-full h-full object-contain rounded-md" />
                                </div>
                            </div>
                        </div>


                        <!-- Empty divs to stabilize grid alignment -->
                        <div></div>
                        <div></div>

                <!-- Edit Button -->
                <div class="flex flex-col items-end mt-6 space-y-2">
                    <p class="text-sm text-gray-500">
                        Pindutin ang <span class="text-blue-600 font-medium">"Edit"</span> upang baguhin
                    </p>
                    <button class="bg-green-500 text-white px-24 py-3 rounded-lg text-base font-medium hover:bg-green-600">
                        Edit
                    </button>
                </div>
        </section>


        <!-- Next Button -->
        <div class="text-center space-y-3">
            <a href="/viewprofile3"
                class="inline-flex bg-blue-800 text-white font-medium px-32 py-4 rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2 mx-auto text-lg">
                Next → <i class="ri-arrow-right-line text-2xl"></i>
            </a>
            <p class="text-base">Click <span class="text-blue-800 font-medium">"Next"</span> to move to the next
                page</p>
            <p class="text-sm text-gray-500">(Pindutin ang <span class="text-blue-800 font-medium">"Next"</span>
                upang lumipat sa susunod na pahina)</p>
        </div>

        </section>
    </main>
@endsection
