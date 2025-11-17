@extends('layouts.includes')

@section('content')
    <main class="flex-grow w-full bg-gray-50 font-sans text-gray-800">


        <!-- Back Button -->
        <div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
            <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
                <a href="/viewprofile2"
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

<!-- Skills Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Your Skills</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Selected Skills -->
                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div id="review_skills_list" class="flex flex-wrap gap-3 mb-6">

                                    <!-- Tags (empty for now) -->
                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                </div>
                            </div>

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

<!-- Job Preference Info -->
                    <section class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6">Your Job Preferences</h3>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Selected Jobs -->
                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div id="review_jobprefs_img_container" class="flex flex-wrap gap-3 mb-6">

                                    <!-- Tags (empty for now) -->
                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                    <span
                                        class="bg-blue-100 text-blue-700 font-medium px-4 py-2 rounded-xl flex items-center gap-2 shadow-sm"></span>

                                </div>
                            </div>

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

        </section>
    </main>
@endsection
