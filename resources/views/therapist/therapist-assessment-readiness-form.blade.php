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
                    let currentStep = 4;

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

            <!-- Readiness -->
            <div class="px-6 sm:px-10 py-10 space-y-8">
                <div>
                    <h3 class="text-xl font-bold text-[#1E40AF] mb-2">Job Readiness Evaluation</h3>
                    <p class="text-gray-600 text-sm">
                        Determine the candidate’s current readiness level.
                    </p>
                </div>

                <!-- Job Ready Container -->
                <div id="jobreadyContainer" class="space-y-6"></div>

                <!-- Readiness Cards -->
                <div id="readinessCards" class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                    <!-- Beginner -->
                    <div data-level="Beginner"
                        class="readiness-card border-2 border-gray-200 rounded-2xl bg-white hover:border-[#1E40AF] hover:shadow-md cursor-pointer p-6 text-center transition-all duration-200">
                        <img src="image/jobready1.png" alt="Beginner" class="w-10 h-10 mx-auto mb-3">
                        <h3 class="text-[#1E40AF] font-semibold text-lg">Beginner</h3>
                        <p class="text-gray-600 text-sm mt-1">Just starting, needs significant support</p>
                    </div>

                    <!-- Getting Ready -->
                    <div data-level="Getting Ready"
                        class="readiness-card border-2 border-[#1E40AF] bg-blue-50 rounded-2xl shadow-md cursor-pointer p-6 text-center transition-all duration-200">
                        <img src="image/jobready2.png" alt="Getting Ready" class="w-10 h-10 mx-auto mb-3">
                        <h3 class="text-[#1E40AF] font-semibold text-lg">Getting Ready</h3>
                        <p class="text-gray-600 text-sm mt-1">Progressing well, approaching readiness</p>
                    </div>

                    <!-- Work Ready -->
                    <div data-level="Work-Ready"
                        class="readiness-card border-2 border-gray-200 rounded-2xl bg-white hover:border-[#1E40AF] hover:shadow-md cursor-pointer p-6 text-center transition-all duration-200">
                        <img src="image/jobready3.png" alt="Work Ready" class="w-10 h-10 mx-auto mb-3">
                        <h3 class="text-[#1E40AF] font-semibold text-lg">Work-Ready</h3>
                        <p class="text-gray-600 text-sm mt-1">Ready for supported employment</p>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Readiness Assessment Notes <span
                            class="text-red-500">*</span></label>
                    <textarea rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none"
                        placeholder="Describe the candidate’s current status, progress, and what they need to become fully work-ready... ">
                    </textarea>
                </div>

                <!-- Estimated Weeks -->
                <div class="mb-10">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Time to Work-Ready, if not
                        ready
                        (weeks)</label>
                    <input type="number" value=""
                        class="w-full sm:w-1/3 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none" />
                </div>


                <!-- Readiness Selection Script -->
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const cards = document.querySelectorAll(".readiness-card");

                        cards.forEach(card => {
                            card.addEventListener("click", () => {
                                // Remove active state from all
                                cards.forEach(c => c.classList.remove("border-[#1E40AF]", "bg-blue-50",
                                    "shadow-md"));
                                c = card;
                                // Add active state to selected
                                card.classList.add("border-[#1E40AF]", "bg-blue-50", "shadow-md");
                            });
                        });
                    });
                </script>

                <!-- Navigation Buttons -->
<div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-10 border-t border-gray-200 mt-10">

    <!-- Previous Button -->
    <button
        type="button"
        onclick="window.location.href='{{ route('therapist-assessment-goal-form') }}'"
        class="w-full sm:w-auto flex justify-center items-center gap-2 border-2 border-[#2E2EFF] text-[#2E2EFF] font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] hover:text-white transition-all duration-200">
        ← Previous
    </button>

    <!-- Next Button -->
    <button
        type="button"
        onclick="window.location.href='{{ route('therapist-assessment-fiteval-form') }}'"
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
