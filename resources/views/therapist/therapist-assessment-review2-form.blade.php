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

            <!-- ASSESSMENT REVIEW SECTIONS -->
            <div class="bg-white px-6 sm:px-10 py-10 space-y-8">

                <!-- DEVELOPMENT GOALS -->
                <div class="bg-[#EEF4FF] border border-[#BFD4FF] rounded-xl p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-[#1E40AF]">Development Goals</h3>
                        <button
                            class="bg-[#2E2EFF] hover:bg-[#1E40AF] text-white text-sm font-medium px-4 py-1.5 rounded-md transition">
                            Edit
                        </button>
                    </div>

                    <div class="bg-white border border-[#D8E3FF] rounded-lg p-5 sm:p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 flex items-center justify-center bg-[#1E40AF] text-white font-bold rounded-full text-sm">
                                    1
                                </div>
                                <h4 class="font-semibold text-gray-800">Input Goal Title</h4>
                            </div>
                        </div>

                        <p class="text-gray-700 text-sm mb-3">
                            <span class="font-semibold">Goal Description:</span>
                            -
                        </p>

                        <div class="flex flex-col sm:flex-row sm:justify-between text-sm text-gray-700 mt-4">
                            <p><span class="font-semibold">Timeline:</span> -</p>
                            <p><span class="font-semibold">Status:</span> -</p>
                        </div>
                    </div>
                </div>

                <!-- JOB READINESS EVALUATION -->
                <div class="bg-[#EEF4FF] border border-[#BFD4FF] rounded-xl p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-[#1E40AF]">Job Readiness Evaluation</h3>
                        <button
                            class="bg-[#2E2EFF] hover:bg-[#1E40AF] text-white text-sm font-medium px-4 py-1.5 rounded-md transition">
                            Edit
                        </button>
                    </div>

                    <div
                        class="border-2 border-[#1E40AF] rounded-lg p-6 flex flex-col items-center justify-center text-center mb-5">
                        <i class="ri-star-fill text-yellow-400 text-4xl mb-2"></i>
                        <h4 class="font-semibold text-gray-800">Getting Ready</h4>
                        <p class="text-gray-600 text-sm">Progressing well, approaching readiness</p>
                    </div>

                    <div class="text-gray-700 text-sm space-y-3">
                        <p>
                            <span class="font-semibold">Readiness Assessment Notes :</span><br>
                            -
                        </p>
                        <p>
                            <span class="font-semibold">Estimated Time to Work-Ready (If not ready):</span><br>
                            -
                        </p>
                    </div>
                </div>

                <!-- FIT EVALUATION -->
                <div class="bg-[#EEF4FF] border border-[#BFD4FF] rounded-xl p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-[#1E40AF]">Fit Evaluation</h3>
                        <button
                            class="bg-[#2E2EFF] hover:bg-[#1E40AF] text-white text-sm font-medium px-4 py-1.5 rounded-md transition">
                            Edit
                        </button>
                    </div>

                    <div
                        class="border-2 border-[#F5D98B] bg-[#FFF5D6] rounded-lg p-6 flex flex-col items-center justify-center text-center mb-5">
                        <div class="w-6 h-6 bg-yellow-400 rounded-full mb-2"></div>
                        <h4 class="font-semibold text-gray-800">Fair Fit</h4>
                        <p class="text-gray-600 text-sm">Some alignment</p>
                    </div>

                    <div class="text-gray-700 text-sm space-y-3">
                        <p>
                            <span class="font-semibold">Overall Job Fit Summary:</span><br>
                            -
                        </p>
                        <p>
                            <span class="font-semibold">Recommendations for Placement:</span><br>
                            -
                        </p>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="pt-4">
                    <button
                        class="w-full bg-[#2E2EFF] hover:bg-[#1E40AF] text-white font-semibold py-3 rounded-lg transition text-center">
                        Create Assessment
                    </button>
                </div>

            </div>

            <!-- SUCCESS MODAL -->
            <div id="successModal"
                class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 transition-opacity duration-300">
                <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-10 text-center max-w-md w-full mx-4">
                    <img src="image/success.png" alt="Confetti"
                        class="w-16 h-16 mx-auto mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Assessment Successfully Created</h3>
                    <p class="text-gray-600 mb-6 text-sm sm:text-base">
                        The candidate’s assessment has been saved and recorded in the system.
                    </p>
                    <button id="closeModalBtn"
                        class="w-full bg-[#2E2EFF] hover:bg-[#1E40AF] text-white font-semibold py-3 rounded-lg transition">
                        Okay
                    </button>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const modal = document.getElementById("successModal");
                    const openBtn = document.querySelector(".w-full.bg-\\[\\#2E2EFF\\]"); // Create Assessment button
                    const closeBtn = document.getElementById("closeModalBtn");

                    openBtn.addEventListener("click", (e) => {
                        e.preventDefault();
                        modal.classList.remove("hidden");
                    });

                    closeBtn.addEventListener("click", () => {
                        modal.classList.add("hidden");
                    });

                    // Close modal when clicking outside the modal box
                    modal.addEventListener("click", (e) => {
                        if (e.target === modal) modal.classList.add("hidden");
                    });
                });
            </script>
           
        </form>
        </section>
    </main>
</body>

</html>
