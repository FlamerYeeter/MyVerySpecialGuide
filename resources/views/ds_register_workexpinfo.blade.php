<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration: Work Experience Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Floating animation */
      @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 5s ease-in-out infinite; }
    .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
    .animate-float-fast { animation: float 2.5s ease-in-out infinite; }

    .workyr-card.selected {
            border: 3px solid #2563eb;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-4px);
            background-color: #eff6ff;
    }
    </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-1 sm:left-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-1 sm:left-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-1 sm:right-4 top-1/4 w-16 sm:w-20 lg:w-28 opacity-80 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-1 sm:right-6 bottom-10 sm:bottom-20 w-16 sm:w-24 lg:w-28 opacity-80 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-blue-600 text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('registerschoolworkinfo') }}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-3 h-3 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

     <!-- Main Content Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-4 sm:p-8 md:p-10 relative z-10 border-4 border-blue-200 overflow-hidden">


        <!-- Header -->
        <div class="text-center mt-2 sm:mt-4 px-2">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-3 drop-shadow-md leading-snug">
                Set Up Your Profile
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-28 md:w-36 mb-5">
            <h2
                class="text-lg sm:text-2xl md:text-3xl text-blue-600 font-bold flex justify-center items-center gap-2 flex-wrap">
                Continue setting up your account
                <button class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
            </h2>
            <p
                class="mt-2 text-gray-700 italic text-sm sm:text-base md:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ituloy ang pag-set up ng iyong account)
            </p>
        </div>

        <!-- Information Note -->
        <div
            class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-5 sm:p-6 mt-8 shadow-sm text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 mt-1 flex-shrink-0 mx-auto sm:mx-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-xs sm:text-base leading-relaxed">
                        Please share your work experience information. This helps us understand the kind of work you’ve
                        done before and
                        identify roles or opportunities where your skills and background will be most valued.
                    </p>
                    <p class="italic text-gray-600 text-[11px] sm:text-sm mt-1 sm:mt-2 leading-relaxed">
                        (Ilagay ang iyong impormasyon tungkol sa karanasan sa trabaho. Makakatulong ito upang maunawaan
                        namin ang uri
                        ng mga gawaing iyong nagawa na at matukoy ang mga posisyon o oportunidad na babagay sa iyong
                        kasanayan at
                        karanasan.)
                    </p>
                    <p class="text-gray-700 text-[11px] sm:text-sm mt-4 leading-relaxed">
                        Even if you haven’t worked before, you can still share volunteer work, school activities, or
                        other experiences
                        that helped you develop your skills.
                        <span class="italic text-gray-600 text-[10px] sm:text-xs mt-1">
                            (Kahit wala ka pang pormal na trabaho, maaari mong ilagay ang mga karanasang boluntaryo,
                            gawain sa paaralan, o
                            iba pang aktibidad na nakatulong sa iyong paghubog ng kasanayan.)
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <form class="mt-10 max-w-3xl mx-auto">
            <!-- Work Experience Question -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Work Experience</h2>
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-2">
                    <p class="mt-2 text-base sm:text-lg font-medium text-gray-800">If you have worked before, how long
                        did you work
                        there?</p>
                    <button class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Kung may karanasan ka sa trabaho, gaano ka
                    katagal
                    nagtrabaho doon?)</p>
            </div>

            <!-- Instruction -->
            <div class="mt-6 text-center sm:text-left px-1 sm:px-4">
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2">
                    <p class="text-xs sm:text-base font-medium text-gray-800">Choose from the pictures provided and
                        click
                        your answer.</p>
                    <button class="text-gray-500 text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-[10px] sm:text-sm text-gray-600 italic mt-1">(Pumili mula sa mga larawan at pindutin ang
                    iyong sagot)</p>
            </div>

            <!-- Work Years Cards -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">
                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, 'lt1')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/workyr1.png" alt="less 1 yr"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">Less than 1 year</h3>
                </div>

                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, '1-2')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/workyr2.png" alt="1-2 yrs"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">1-2 years</h3>
                </div>

                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, 'gt3')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/workyr3.png" alt="more than 3 yrs"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">More than 3 years</h3>
                </div>

                <div class="workyr-card bg-white p-4 sm:p-5 rounded-2xl transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative text-center"
                    onclick="selectWorkYearsChoice(this, 'none')">
                    <button
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-blue-500 hover:bg-blue-600 text-white p-1.5 sm:p-2 rounded-full shadow text-xs sm:text-sm">🔊</button>
                    <img src="image/workyr4.png" alt="no experience"
                        class="w-full h-32 sm:h-44 md:h-48 object-contain rounded-md mb-3 sm:mb-4">
                    <h3 class="text-blue-600 font-semibold text-sm sm:text-lg">None</h3>
                </div>
            </div>

            <!-- Job Experience Section -->
            <div class="mt-12 px-2 sm:px-4 text-center sm:text-left">
                <h2 class="text-xl sm:text-3xl font-bold text-blue-700 mb-2">Job Experiences</h2>
                <p class="text-gray-500 italic mt-4 text-base sm:text-lg">Add one or more previous jobs.</p>
                <div id="job_experiences_container" class="space-y-4 mt-4"></div>
                <template id="job_exp_template">
                    <div
                        class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 ease-in-out mt-3">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold text-blue-800 text-sm sm:text-base">Job Experience</h4>
                            <button type="button"
                                class="remove-job text-red-600 text-xs sm:text-sm bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg font-medium transition-colors duration-200">
                                Remove
                            </button>
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Job Title -->
                            <div class="flex flex-col">
                                <label class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input
                                    class="job_title w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="e.g. Kitchen Helper" />
                            </div>

                            <!-- Company Name -->
                            <div class="flex flex-col">
                                <label class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input
                                    class="company_name w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="e.g., McDonald's or University of Makati" />
                            </div>

                            <!-- Job Description (full width) -->
                            <div class="sm:col-span-2 flex flex-col">
                                <label class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Job
                                    Description</label>
                                <textarea
                                    class="job_description w-full border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm h-20 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                                    placeholder="What you did (e.g. cleaned tables, organized shelves)"></textarea>
                            </div>
                        </div>
                    </div>
                </template>


                <input id="work_experiences" type="hidden" value="[]" />
                <input id="work_years" type="hidden" value="" />

                <!-- Add Button -->
                <div class="mt-6 text-center">
                    <button id="addJobBtn" type="button"
                        class="bg-blue-500 text-white font-medium text-xs sm:text-base px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-600 transition">
                        <span class="text-lg sm:text-xl mr-2">➕</span> Add Another Job Experience
                    </button>
                </div>
            </div>

            <!-- Next Button -->
            <div class="flex flex-col items-center justify-center mt-10 mb-6 space-y-3 px-2">
                <div id="workExpError" class="text-red-600 text-sm text-center"></div>
                <button id="workExpNext" type="button"
                    class="bg-blue-500 text-white text-sm sm:text-lg font-semibold px-10 sm:px-16 md:px-20 py-2 sm:py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md"
                    onclick="window.location.href='{{ route('registersupportneed') }}'">
                    Next →
                </button>
                <p class="text-gray-600 text-[11px] sm:text-sm mt-2 text-center leading-snug">
                    Click <span class="text-blue-500 font-medium">"Next"</span> to move to the next page<br>
                    <span class="italic text-gray-500">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
                </p>
            </div>
        </form>
    </div>
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workexpinfo.blade.php
        function selectWorkYearsChoice(el, value) {
            try {
                document.querySelectorAll('.workyr-card').forEach(c => c.classList.remove('selected'));
                if (el && el.classList) el.classList.add('selected');
                const hidden = document.getElementById('work_years');
                if (hidden) hidden.value = value || '';
                const err = document.getElementById('workExpError');
                if (err) err.textContent = '';
            } catch (e) {
                console.error('selectWorkYearsChoice error', e);
            }
        }
    </script>
    <script>
        // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_workexpinfo.blade.php
        (function() {
            const container = document.getElementById('job_experiences_container');
            const tpl = document.getElementById('job_exp_template');
            const hidden = document.getElementById('work_experiences');

            function parseHidden() {
                try {
                    return JSON.parse(hidden.value || '[]');
                } catch (e) {
                    return [];
                }
            }

            function writeHidden(arr) {
                try {
                    hidden.value = JSON.stringify(arr || []);
                } catch (e) {
                    hidden.value = '[]';
                }
            }

            function buildEntry(item) {
                const node = tpl.content.firstElementChild.cloneNode(true);
                if (item) {
                    node.querySelector('.job_title').value = item.title || '';
                    node.querySelector('.job_description').value = item.description || '';
                    node.querySelector('.company_name').value = item.company || '';
                }
                // remove handler
                node.querySelector('.remove-job').addEventListener('click', function() {
                    node.remove();
                    syncHiddenFromUI();
                });
                // update hidden when inputs change
                node.querySelectorAll('input').forEach(inp => {
                    inp.addEventListener('input', debounce(syncHiddenFromUI, 150));
                });
                return node;
            }

            function syncHiddenFromUI() {
                const arr = [];
                // select direct child entry blocks reliably (avoid invalid selectors like "> div")
                Array.from(container.children).forEach(block => {
                    const title = block.querySelector('.job_title')?.value?.trim() || '';
                    const description = block.querySelector('.job_description')?.value?.trim() || '';
                    const company = block.querySelector('.company_name')?.value?.trim() || '';
                    // only include if any field present
                    if (title || description || company) arr.push({
                        title,
                        description,
                        company
                    });
                });
                writeHidden(arr);
            }

            function addJob(item) {
                const entry = buildEntry(item || {});
                container.appendChild(entry);
                syncHiddenFromUI();
            }

            function clearAndRenderFromArray(arr) {
                container.innerHTML = '';
                (arr || []).forEach(it => addJob(it));
                if ((arr || []).length === 0) addJob(); // make one empty row by default
            }

            // Simple debounce helper
            function debounce(fn, wait) {
                let t;
                return function() {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, arguments), wait);
                };
            }

            // Add button
            document.getElementById('addJobBtn').addEventListener('click', function() {
                addJob();
            });

            // Expose renderer for register.js autofill
            window.renderWorkExperiencesFromArray = function(arr) {
                clearAndRenderFromArray(Array.isArray(arr) ? arr : []);
                writeHidden(arr || []);
            };

            // On load: if hidden has data (from autofill/local draft) render it; otherwise create one empty entry
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const arr = parseHidden();
                    if (Array.isArray(arr) && arr.length) clearAndRenderFromArray(arr);
                    else addJob();
                } catch (e) {
                    console.warn('job experiences init failed', e);
                    addJob();
                }
            });
        })();
    </script>
    <script src="{{ asset('js/register.js') }}"></script>

</body>

</html>
