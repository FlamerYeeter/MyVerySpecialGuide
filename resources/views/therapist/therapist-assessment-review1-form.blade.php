<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Therapist - Candidate Assessment Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col sm:flex-row">
    @include('layouts.therapistsidebar')

    <main class="flex-1 p-4 sm:p-6">
        <!-- Header -->
        <div
            class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-4 mb-6">
            <div class="text-sm text-gray-500">
                <span class="text-[#1E40AF] font-medium">Therapist</span>
                <span class="mx-2 text-gray-400">›</span>
                <span class="text-gray-700 font-medium">Assessment</span>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 relative">
                <div
                    class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-gray-50 w-full sm:w-auto">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-2 text-sm w-full sm:w-56 bg-gray-50 focus:outline-none" />
                    <button class="bg-blue-500 px-3 py-2 text-white text-sm hover:bg-blue-600 transition">
                        <i class="ri-search-line"></i>
                    </button>
                </div>

                <div id="profileBtn"
                    class="flex items-center gap-1 bg-gray-100 border border-gray-200 rounded-full px-3 py-1 cursor-pointer relative z-10">
                    <i class="ri-user-line text-gray-500 text-lg"></i>
                    <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
                </div>
                <div id="dropdownMenu"
                    class="hidden absolute top-full right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                    <ul class="flex flex-col">
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Profile</li>
                    </ul>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const profileBtn = document.getElementById("profileBtn");
                const dropdownMenu = document.getElementById("dropdownMenu");
                profileBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle("hidden");
                });
                document.addEventListener("click", (e) => {
                    if (!profileBtn.contains(e.target)) dropdownMenu.classList.add("hidden");
                });
            });
        </script>

        <!-- FORM -->
        <section class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#1E40AF] text-white flex flex-col sm:flex-row items-center gap-3 px-6 sm:px-10 py-6">
                <img src="image/form.png" alt="Assessment Icon" class="w-10 h-10 object-contain">
                <div class="text-center sm:text-left">
                    <h2 class="text-2xl font-bold">Candidate Assessment Review Summary</h2>
                    <p class="text-white/80 text-sm mt-1">Evaluation overview before submission</p>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="bg-[#EDF4FC] w-full px-4 sm:px-10 py-10">
                <div class="relative flex flex-col sm:flex-row justify-between items-center gap-8 sm:gap-0">

                    <!-- Gray Line -->
                    <div
                        class="hidden sm:block absolute top-1/2 left-0 right-0 h-[2px] bg-gray-300 -translate-y-1/2 z-0">
                    </div>

                    <!-- Animated Blue Progress Line -->
                    <div id="progressLine"
                        class="hidden sm:block absolute top-1/2 left-0 h-[2px] bg-[#1E40AF] -translate-y-1/2 z-10 transition-all duration-700 ease-in-out"
                        style="width: 0%;"></div>

                    <!-- Steps -->
                    <div class="flex flex-col items-center relative z-20 w-full sm:w-1/6">
                        <div
                            class="step-circle w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg">
                            1</div>
                        <p class="step-label text-xs sm:text-sm mt-2 text-center">Assessment Details</p>
                    </div>

                    <div class="flex flex-col items-center relative z-20 w-full sm:w-1/6">
                        <div
                            class="step-circle w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg">
                            2</div>
                        <p class="step-label text-xs sm:text-sm mt-2 text-center">Prioritizing & Scoring</p>
                    </div>

                    <div class="flex flex-col items-center relative z-20 w-full sm:w-1/6">
                        <div
                            class="step-circle w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg">
                            3</div>
                        <p class="step-label text-xs sm:text-sm mt-2 text-center">Goals</p>
                    </div>

                    <div class="flex flex-col items-center relative z-20 w-full sm:w-1/6">
                        <div
                            class="step-circle w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg">
                            4</div>
                        <p class="step-label text-xs sm:text-sm mt-2 text-center">Readiness</p>
                    </div>

                    <div class="flex flex-col items-center relative z-20 w-full sm:w-1/6">
                        <div
                            class="step-circle w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg">
                            5</div>
                        <p class="step-label text-xs sm:text-sm mt-2 text-center">Job Fit</p>
                    </div>

                    <div class="flex flex-col items-center relative z-20 w-full sm:w-1/6">
                        <div
                            class="step-circle w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg">
                            6</div>
                        <p class="step-label text-xs sm:text-sm mt-2 text-center">Review</p>
                    </div>
                </div>
            </div>

            <!-- PROGRESS SCRIPT -->
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const steps = document.querySelectorAll(".step-circle");
                    const labels = document.querySelectorAll(".step-label");
                    const progressLine = document.getElementById("progressLine");
                    const totalSteps = steps.length;

                    // Change this value depending on your current step (1–6)
                    let currentStep = 6;

                    function updateSteps() {
                        steps.forEach((step, index) => {
                            if (index < currentStep - 1) {
                                // Completed steps
                                step.classList.add("bg-[#7DDA58]", "text-white");
                                step.classList.remove("bg-[#1E40AF]", "bg-gray-300", "text-gray-700");
                                labels[index].classList.add("text-gray-700");
                            } else if (index === currentStep - 1) {
                                // Current step
                                step.classList.add("bg-[#1E40AF]", "text-white");
                                step.classList.remove("bg-gray-300", "text-gray-700", "bg-[#7DDA58]");
                                labels[index].classList.add("text-[#1E40AF]", "font-semibold");
                            } else {
                                // Future steps
                                step.classList.add("bg-gray-300", "text-gray-700");
                                step.classList.remove("bg-[#1E40AF]", "bg-[#7DDA58]", "text-white");
                                labels[index].classList.add("text-gray-700");
                            }
                        });

                        // Update progress line
                        const progressWidth = ((currentStep - 1) / (totalSteps - 1)) * 100;
                        progressLine.style.width = `${progressWidth}%`;
                        progressLine.style.backgroundColor = "#7DDA58";
                    }

                    updateSteps();
                });
            </script>

            <!-- Content -->
            <div class="p-6 sm:p-10 space-y-10">

                <!-- Assessment Information -->
                <div class="bg-[#F8FAFF] border border-[#D6E0FF] rounded-xl p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5">
                        <h3 class="text-lg font-semibold text-[#1E40AF]">Assessment Information</h3>
                        <button
                            class="bg-[#2E2EFF] hover:bg-[#1E40AF] text-white text-sm font-medium px-5 py-1.5 rounded-md transition-all">
                            Edit
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-4 text-gray-700 text-sm">
                        <p><span class="font-semibold">Candidate Name:</span> -</p>
                        <p class="font-semibold">
                            <span class="font-semibold">Job Readiness Assessment for</span>
                            <span class="ml-1 mt-4">
                                <span class="font-semibold text-[#1E40AF]"><br>Company Name:</span> -
                                <span class="font-semibold text-[#1E40AF]"><br>Job Title:</span> -
                            </span>
                        </p>
                        <p><span class="font-semibold">Assessment Date:</span> -</p>
                        <p><span class="font-semibold">Assessment Notes:</span> -</p>
                    </div>

                    <!-- Areas of Difficulty -->
                    <div class="mt-6">
                        <p class="font-semibold text-gray-800 mb-2">Areas of Difficulty</p>
                        <p class="text-gray-600 text-sm mb-3">Tasks where the candidate faces challenges:</p>
                        <div class="flex flex-wrap gap-3">
                            <span
                                class="bg-[#E0EAFF] text-[#1E40AF] px-4 py-1.5 rounded-lg text-sm font-medium">Input Area</span>
                            <span class="bg-[#E0EAFF] text-[#1E40AF] px-4 py-1.5 rounded-lg text-sm font-medium">Input Area</span>
                            <span
                                class="bg-[#E0EAFF] text-[#1E40AF] px-4 py-1.5 rounded-lg text-sm font-medium">Input Area</span>
                        </div>
                    </div>
                </div>

                <!-- Top Priority Activities -->
                <div class="bg-[#F8FAFF] border border-[#D6E0FF] rounded-xl p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5">
                        <h3 class="text-lg font-semibold text-[#1E40AF]">Top Priority Activities</h3>
                        <button
                            class="bg-[#2E2EFF] hover:bg-[#1E40AF] text-white text-sm font-medium px-5 py-1.5 rounded-md transition-all">
                            Edit
                        </button>
                    </div>

                    <p class="text-sm text-gray-600 mb-5">Ranked by importance for job success:</p>

                    <!-- List -->
                    <div class="space-y-4">
                    <!-- Activity 1 -->
                            <div
                                class="flex justify-between items-center bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-9 h-9 bg-[#1E40AF] text-white rounded-full flex items-center justify-center font-bold text-base">
                                        1
                                    </div>
                                    <p class="font-medium text-gray-800 text-base">Highest Rated</p>
                                </div>
                                <span class="text-[#1E40AF] text-sm font-semibold transform -translate-x-16">Importance:
                                    NumberRate</span>
                            </div>

                            <!-- Activity 2 -->
                            <div
                                class="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-9 h-9 bg-[#1E40AF] text-white rounded-full flex items-center justify-center font-bold text-base">
                                        2
                                    </div>
                                    <p class="font-medium text-gray-800 text-base">Second Rated</p>
                                </div>
                                <span class="text-[#1E40AF] text-sm font-semibold transform -translate-x-16">Importance:
                                    NumberRate</span>
                            </div>

                            <!-- Activity 3 -->
                            <div
                                class="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-9 h-9 bg-[#1E40AF] text-white rounded-full flex items-center justify-center font-bold text-base">
                                        3
                                    </div>
                                    <p class="font-medium text-gray-800 text-base">Third Rated</p>
                                </div>
                                <span class="text-[#1E40AF] text-sm font-semibold transform -translate-x-16">Importance:
                                    NumberRate</span>
                            </div>
                        </div>
                    </div>

                <!-- Performance & Satisfaction Ratings -->
                <div class="bg-[#F8FAFF] border border-[#D6E0FF] rounded-xl p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5">
                        <h3 class="text-lg font-semibold text-[#1E40AF]">Performance & Satisfaction Ratings</h3>
                        <button
                            class="bg-[#2E2EFF] hover:bg-[#1E40AF] text-white text-sm font-medium px-5 py-1.5 rounded-md transition-all">
                            Edit
                        </button>
                    </div>

                    <div class="text-center mb-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Overall Performance Average</p>
                                <p class="text-2xl font-bold text-[#1E40AF]">0</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Overall Satisfaction Average</p>
                                <p class="text-2xl font-bold text-[#1E40AF]">0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ratings List -->
                      <div class="mt-8 space-y-4">

                        <!-- Areas Avg. Score -->
                        <div
                            class="border-2 border-yellow-400 bg-white rounded-xl p-5 flex flex-col sm:flex-row justify-between items-center sm:items-center gap-3 sm:gap-0 shadow-sm">

                            <!-- Area Title -->
                            <div class="flex items-center gap-2">
                                <img src="https://img.icons8.com/color/36/000000/ok--v1.png" alt="Check Icon"
                                    class="w-6 h-6">
                                <p class="font-semibold text-gray-800">Sample Area</p>
                            </div>

                            <!-- Average Score -->
                            <p class="text-[#1E40AF] font-semibold text-center sm:text-left">
                                Average Score:
                                <span class="font-bold text-gray-800">0</span>
                            </p>

                            <!-- Status Tag -->
                            <span
                                class="bg-yellow-100 text-yellow-700 font-semibold px-4 py-1 rounded-full text-sm whitespace-nowrap">
                                Needs Support
                            </span>
                        </div>

                        <div
                            class="border-2 border-blue-400 bg-white rounded-xl p-5 flex flex-col sm:flex-row justify-between items-center sm:items-center gap-3 sm:gap-0 shadow-sm">
                            <!-- Area Title -->
                            <div class="flex items-center gap-2">
                                <img src="https://img.icons8.com/color/36/000000/ok--v1.png" alt="Check Icon"
                                    class="w-6 h-6">
                                <p class="font-semibold text-gray-800">Sample Area</p>
                            </div>

                            <!-- Average Score -->
                            <p class="text-[#1E40AF] font-semibold text-center sm:text-left">
                                Average Score:
                                <span class="font-bold text-gray-800">0</span>
                            </p>

                            <!-- Status Tag -->
                            <span
                                class="bg-blue-100 text-blue-700 font-semibold px-4 py-1 rounded-full text-sm whitespace-nowrap">
                                Room for Growth
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div
                    onclick="window.location.href='{{ route('therapist-assessment-fiteval-form') }}'"
                    class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-10 border-t border-gray-200 mt-10">
                    <button
                        class="w-full sm:w-auto flex justify-center items-center gap-2 border-2 border-[#2E2EFF] text-[#2E2EFF] font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] hover:text-white transition-all duration-200">
                        ← Previous
                    </button>
                    <button
                         onclick="window.location.href='{{ route('therapist-assessment-review2-form') }}'"
                        class="w-full sm:w-auto flex justify-center items-center gap-2 bg-[#2E2EFF] text-white font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] transition-all duration-200">
                        Next →
                    </button>
                </div>

            </div>
            </div>
        </section>
    </main>

</body>

</html>
