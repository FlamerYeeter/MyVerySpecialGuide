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
                    let currentStep = 3;

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
           
           <!-- GOALS -->
            <div class="px-6 sm:px-10 py-10 space-y-8">
                <div>
                    <h3 class="text-xl font-bold text-[#1E40AF] mb-2">Development Goals</h3>
                    <p class="text-gray-600 text-sm">
                        Identify the top areas to focus on for improvement based on the candidate’s ratings.
                    </p>
                </div>

                <!-- Goals Container -->
                <div id="goalContainer" class="space-y-6"></div>

                <!-- Add Goal Button -->
                <div class="border-2 border-dashed border-blue-400 rounded-xl py-4 text-center cursor-pointer hover:bg-blue-50 transition"
                    id="addGoalBtn">
                    <span class="text-blue-600 font-semibold text-base"><i class="ri-add-line mr-2"></i>Add Another
                        Goal</span>
                </div>

                <!-- Navigation Buttons -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-10 border-t border-gray-200 mt-10">
                    <button
                        onclick="window.location.href='{{ route('therapist-assessment-scoring-form') }}'"
                        class="w-full sm:w-auto flex justify-center items-center gap-2 border-2 border-[#2E2EFF] text-[#2E2EFF] font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] hover:text-white transition-all duration-200">
                        ← Previous
                    </button>
                    <button
                        onclick="window.location.href='{{ route('therapist-assessment-readiness-form') }}'"
                        class="w-full sm:w-auto flex justify-center items-center gap-2 bg-[#2E2EFF] text-white font-semibold text-lg px-14 py-3 rounded-xl hover:bg-[#1E40AF] transition-all duration-200">
                        Next →
                    </button>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const goalContainer = document.getElementById("goalContainer");
            const addGoalBtn = document.getElementById("addGoalBtn");
            let goalCount = 0;

            // Function to create one goal block
            const createGoalBlock = (id) => `
        <div class="goal-block bg-[#F8FAFF] border-2 border-blue-200 rounded-3xl shadow-sm p-6 space-y-5 transition-transform hover:scale-[1.01]" id="goal-${id}">
        <div class="flex items-center gap-3">
          <div class="goal-number bg-[#1E40AF] text-white font-bold rounded-full w-7 h-7 flex items-center justify-center">${id}</div>
          <h4 class="text-[#1E40AF] font-semibold text-lg">Goal Title</h4>
        </div>
        <input type="text" placeholder="e.g., Improve Task Completion Speed"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none" />

        <label class="block text-sm font-medium text-gray-700">Goal Description</label>
        <textarea rows="3" placeholder="Describe what the candidate will achieve in clear, simple terms..."
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none"></textarea>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Timeline (weeks)</label>
            <input type="number" min="1" placeholder="Enter number of weeks"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select
              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
              <option>Not Started</option>
              <option>In Progress</option>
              <option>Pending</option>
              <option>Completed</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-3">
          <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition" onclick="removeGoal(${id})">Remove</button>
          <button class="bg-[#1E40AF] text-white px-6 py-2 rounded-lg hover:bg-blue-900 transition">Add</button>
        </div>
      </div>`;

            // Add new goal block
            addGoalBtn.addEventListener("click", () => {
                goalCount++;
                goalContainer.insertAdjacentHTML("beforeend", createGoalBlock(goalCount));
                updateGoalNumbers();
            });

            // Update all goal numbers dynamically
            window.updateGoalNumbers = function() {
                const goalBlocks = document.querySelectorAll(".goal-block");
                goalBlocks.forEach((block, index) => {
                    const numberEl = block.querySelector(".goal-number");
                    const newId = index + 1;
                    numberEl.textContent = newId;
                    block.id = `goal-${newId}`;

                    // Update radio group names
                    const radios = block.querySelectorAll("input[type='radio']");
                    radios.forEach(radio => {
                        radio.name = `priority-${newId}`;
                    });
                });
                goalCount = goalBlocks.length;
            };

            // Remove a goal
            window.removeGoal = function(id) {
                const block = document.getElementById(`goal-${id}`);
                if (block) block.remove();
                updateGoalNumbers();
            };

            // Add one default goal on page load
            addGoalBtn.click();
        });
    </script>

</body>

</html>
