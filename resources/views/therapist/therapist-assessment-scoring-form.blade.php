<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Therapist - Candidate Assessment Input Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col sm:flex-row">

    <!-- Sidebar -->
    @include('layouts.therapistsidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-6">

        <!-- Header -->
        <div
            class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-4 mb-6">
            <div class="text-sm text-gray-500">
                <span class="text-[#1E40AF] font-medium">Therapist</span>
                <span class="mx-2 text-gray-400">›</span>
                <span class="text-gray-700 font-medium">Assessments</span>
            </div>

            <!-- Search & Profile -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 relative">
                <div
                    class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-gray-50 w-full sm:w-auto">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-2 text-sm w-full sm:w-56 bg-gray-50 focus:outline-none" />
                    <button class="bg-blue-500 px-3 py-2 text-white text-sm hover:bg-blue-600 transition">
                        <i class="ri-search-line"></i>
                    </button>
                </div>

                <!-- Profile Button -->
                <div id="profileBtn"
                    class="flex items-center gap-1 bg-gray-100 border border-gray-200 rounded-full px-3 py-1 cursor-pointer relative z-10">
                    <i class="ri-user-line text-gray-500 text-lg"></i>
                    <i id="dropdownIcon" class="ri-arrow-down-s-line text-gray-500"></i>
                </div>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu"
                    class="hidden absolute top-full right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                    <ul class="flex flex-col">
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            // --- PROFILE DROPDOWN ---
            document.addEventListener("DOMContentLoaded", () => {
                const profileBtn = document.getElementById("profileBtn");
                const dropdownMenu = document.getElementById("dropdownMenu");

                profileBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle("hidden");
                });

                document.addEventListener("click", (e) => {
                    if (!profileBtn.contains(e.target)) {
                        dropdownMenu.classList.add("hidden");
                    }
                });
            });
        </script>

        <!-- ===================== FORM CONTENT ===================== -->
        <section class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">

            <!-- Header -->
            <div class="bg-[#1E40AF] text-white flex items-center gap-3 px-6 sm:px-10 py-6">
                <img src="image/form.png" alt="Assessment Icon" class="w-10 h-10 object-contain">
                <div>
                    <h2 class="text-2xl font-bold">Candidate Assessment Input Form</h2>
                    <p class="text-white/80 text-sm mt-1">Evaluation for job readiness</p>
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
                    let currentStep = 2;

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
            <!-- Form Content -->
            <div class="px-6 sm:px-10 py-10 space-y-8">

                <!-- Section Title -->
                <div>
                    <h3 class="text-xl font-bold text-[#1E40AF] mb-2">Rate Performance and Satisfaction Levels</h3>
                    <p class="text-gray-600 text-sm">
                        The therapist asks the candidate to rate each activity (1–10) for performance and satisfaction
                        to identify key areas
                        for improvement and monitor progress.
                    </p>
                </div>

                <!-- Rating Boxes -->
                <div class="space-y-6">

                    <!-- Prioritize Section -->
                    <div class="bg-[#EEF4FF] rounded-xl p-8 mt-6 shadow-sm">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2 ">
                            <img src="https://img.icons8.com/color/36/000000/ok--v1.png" alt="Check Icon"
                                class="w-6 h-6">
                            Highest Prioritize Area
                        </h4>
                        <p class="text-base font-semibold text-[#1E40AF] mb-5">
                            Performance <span class="font-normal text-[#1E40AF]">(1 = Unable, 10 = Excellent)</span>
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <!-- Rating Buttons -->
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">1</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">2</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">3</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">4</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">5</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">6</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">7</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">8</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">9</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">10</button>
                        </div>

                        <p class="mt-10 text-base font-semibold text-[#1E40AF] mb-5">
                            Satisfaction <span class="font-normal text-[#1E40AF]"> (1 = Very Dissatisfied, 10 = Very
                                Satisfied)</span>
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <!-- Rating Buttons -->
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">1</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">2</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">3</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">4</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">5</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">6</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">7</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">8</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">9</button>
                            <button
                                class="rating-btn w-14 h-14 rounded-xl bg-gray-200 text-gray-800 font-bold text-lg hover:bg-[#1E40AF] hover:text-white transition">10</button>
                        </div>
                    </div>
                    <!-- Continue Display Rest of the Prioritize Areas -->

                    <script>
                        // --- Highlight Selected Rating ---
                        document.querySelectorAll(".rating-btn").forEach(btn => {
                            btn.addEventListener("click", () => {
                                const group = btn.parentElement.querySelectorAll(".rating-btn");
                                group.forEach(b => b.classList.remove("bg-[#1E40AF]", "text-white"));
                                btn.classList.add("bg-[#1E40AF]", "text-white");
                            });
                        });
                    </script>

                    <!-- Overall Average Section -->
                    <div class="bg-[#EEF4FF] rounded-xl p-6 mt-10 shadow-sm text-center">
                        <!-- Title -->
                        <h4 class="text-[#1E40AF] font-bold text-lg mb-4">Overall Average</h4>

                        <!-- Average Values -->
                        <div class="flex justify-center items-center gap-16">
                            <div>
                                <p class="text-black text-sm font-semibold">Avg Performance</p>
                                <!-- Sum of all performance area/Number of area -->
                                <p class="font-bold text-[#1E40AF] text-lg">0</p>
                            </div>
                            <div>
                                <p class="text-black text-sm font-semibold">Avg Satisfaction</p>
                                <!-- Sum of all satisfaction area/Number of area -->
                                <p class="font-bold text-[#1E40AF] text-lg">0</p>
                            </div>
                        </div>
                    </div>


                    <!-- Individual Areas Avg. Scores Section -->
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

                    <div
                        class="border-2 border-green-400 bg-white rounded-xl p-5 flex flex-col sm:flex-row justify-between items-center sm:items-center gap-3 sm:gap-0 shadow-sm">
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
                            class="bg-green-100 text-green-700 font-semibold px-4 py-1 rounded-full text-sm whitespace-nowrap">
                            Job Ready
                        </span>
                    </div>
                </div>

                <!-- Continue Display Rest of the  Avg Score of Prioritize Areas -->
                <!--🔴 Need Immediate Attention = avgScore <= 3 ,🟡 Needs Support = avgScore <= 5
                            🔵 Room For Growth = avgScore <= 7, 🟢 Job Ready = return -->


                <!-- Navigation Buttons -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-10 border-t border-gray-200 mt-10">
                    <!-- Previous Button -->
                    <button
                        onclick="window.location.href='{{ route('therapist-assessment-prioritize-form') }}'"
                        class="w-full sm:w-auto flex justify-center items-center gap-2 border-2 border-[#2E2EFF] text-[#2E2EFF] font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] hover:text-white transition-all duration-200">
                        ← Previous
                    </button>

                    <!-- Next Button -->
                    <button
                        onclick="window.location.href='{{ route('therapist-assessment-goal-form') }}'"
                        class="w-full sm:w-auto flex justify-center items-center gap-2 bg-[#2E2EFF] text-white font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] transition-all duration-200">
                        Next →
                    </button>
                </div>
        </section>
    </main>

</body>

</html>
