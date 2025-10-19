<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration: Job Preference</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Floating animations */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-float-slow { animation: float 5s ease-in-out infinite; }
    .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
    .animate-float-fast { animation: float 2.5s ease-in-out infinite; }

    /* visual for selected job preference card */
    .jobpref-card.selected {
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
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="window.location.href='{{ route('registerskills1') }}'">
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
                Continue setting up your profile
                <button type="button" class="text-lg sm:text-2xl hover:scale-110 transition-transform">🔊</button>
            </h2>
            <p
                class="mt-2 text-gray-700 italic text-sm sm:text-base md:text-lg border-b-4 border-blue-500 inline-block pb-2 px-2">
                (Ituloy ang pag-set up ng iyong profile)
            </p>
        </div>
        <!-- Information Section -->
        <div
            class="relative bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 sm:p-8 mt-10 shadow-md max-w-4xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start gap-4 pr-14">
                <div class="flex-shrink-0 flex justify-center sm:justify-start w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 mt-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                    </svg>
                </div>

                <div class="flex-1 text-center sm:text-left">
                    <p class="font-medium text-blue-800 text-sm sm:text-base leading-relaxed">
                        This section helps us understand what kind of jobs you prefer based on your skills and comfort
                        level.
                        By choosing your job preferences, we can match you with workplaces where you’ll feel
                        comfortable,
                        supported, and confident to do your best work.
                    </p>

                    <p class="italic text-gray-600 text-xs sm:text-sm mt-2 leading-relaxed">
                        (Ang seksyong ito ay tumutulong upang malaman namin kung anong klase ng trabaho ang gusto mo
                        batay sa iyong mga kakayahan at antas ng kaginhawaan. Sa pagpili ng iyong mga job preference,
                        matutulungan ka naming makahanap ng lugar ng trabaho kung saan ka magiging komportable,
                        suportado, at makakagawa ng iyong pinakamahusay.)
                    </p>

                    <p class="mt-3 text-xs sm:text-sm text-red-500 italic">
                        *Note: Some job options might not be available in your area right now, but they may open
                        soon.*<br>
                        *(Tandaan: Maaaring hindi pa available ang ilang trabaho sa iyong lugar sa ngayon, ngunit
                        maaaring magbukas ito kung kinakailangan.)*
                    </p>
                </div>
            </div>

            <button type="button"
                class="absolute top-3 right-3 bg-[#1E40AF] text-white text-base sm:text-xl p-2 sm:p-3 rounded-full shadow-md hover:bg-blue-800 hover:scale-105 transition-transform duration-200">
                🔊
            </button>
        </div>

        <!-- Instructions Section -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 mt-10 shadow-md border border-gray-200 max-w-4xl mx-auto">
            <div class="flex flex-col items-center sm:items-start gap-3">
                <div class="flex items-center justify-center sm:justify-start gap-2">
                    <p class="text-base sm:text-lg font-medium text-gray-800 leading-relaxed text-center sm:text-left">
                        Choose <span class="font-semibold text-blue-700">3 to 5 job options</span> from the pictures
                        that match your skills.
                        You may also pick a few jobs that interest you, even if they are not directly related to your
                        skills.
                    </p>
                    <button type="button"
                        class="text-blue-600 text-xl hover:scale-110 transition-transform">🔊</button>
                </div>
                <p class="text-sm sm:text-base text-gray-600 italic text-center sm:text-left leading-snug">
                    (Pumili ng <span class="font-semibold text-blue-700">3 hanggang 5 trabaho</span> mula sa mga larawan
                    na akma sa iyong mga kakayahan.
                    Maaari ka ring pumili ng ilang trabahong gusto mo, kahit na hindi ito direktang kaugnay ng iyong mga
                    kakayanan.)
                </p>
            </div>
        </div>

        <!-- Skills Section -->
        <div
            class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 sm:p-8 mt-10 shadow-md border border-blue-200 max-w-4xl mx-auto">
            <div class="flex flex-col gap-6">

                <!-- Matched Skills Header -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-">
                    <h2 class="text-xl sm:text-2xl font-bold text-blue-700 text-center sm:text-left flex-1">
                        Based on your skills, here are jobs that match you:
                    </h2>
                    <button type="button"
                        class="text-blue-600 text-xl sm:text-2xl p-2 hover:scale-110 transition-all self-center sm:self-start">
                        🔊
                    </button>
                </div>

                <p class="text-base sm:text-lg font-medium text-gray-700 italic text-center sm:text-left">
                    (Batay sa iyong mga kakayahan, narito ang mga trabahong bagay sa iyo)
                </p>

                <hr class="border-t border-blue-300 my-3 sm:my-4">

                <!-- Your Skills Section -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3">
                    <p class="font-semibold text-gray-800 text-lg sm:text-xl text-center sm:text-left flex-1">
                        Your Skills:
                    </p>
                    <button type="button"
                        class="text-blue-600 text-xl sm:text-2xl p-2  hover:scale-110 transition-all self-center sm:self-start">
                        🔊
                    </button>
                </div>

                <p
                    class="mt-2 text-blue-700 font-semibold underline text-base sm:text-lg text-center sm:text-left tracking-wide">
                    Matched skills, Matched skills, Matched skills
                </p>

            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

            <!-- Office Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Office Work" onclick="toggleJobPref1Choice(this,'Office Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
                <img src="image/officework.png" alt="Office Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Office Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    In this job, you will use the computer for simple tasks, answer the phone politely, and keep
                    papers organized in folders.
                </p>
                <p class="text-[13px] text-[#4D515C]italic mt-2 text-center">
                    (Kasama sa trabahong ito ang pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng
                    pagkain,
                    at pagpapanatiling malinis ng mga mesa at kusina.)
                </p>
            </div>

            <!-- Store Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Store Work" onclick="toggleJobPref1Choice(this,'Store Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
                <img src="image/storework.png" alt="Store Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Store Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    You will help customers find what they need, place items neatly on shelves, and work at the
                    cashier to take payments.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng
                    pagkain,
                    at pagpapanatiling malinis ng mga mesa at kusina.)
                </p>
            </div>

            <!-- Cleaning Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Cleaning Work" onclick="toggleJobPref1Choice(this,'Cleaning Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
                <img src="image/cleaningwork.png" alt="Cleaning Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Cleaning Work</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You will sweep or mop the floor, wipe tables and windows, and make sure rooms stay neat and
                    tidy.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng
                    pagkain,
                    at pagpapanatiling malinis ng mga mesa at kusina.)
                </p>
            </div>

            <!-- Hospitality Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Hospitality Work" onclick="toggleJobPref1Choice(this,'Hospitality Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
                <img src="image/hospitalitywork.png" alt="Hospitality Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Hospitality Work</h3>
                <p class="text-sm mt-2 text-justify" style="text-align: justify; text-align-last: center;">
                    You will greet guests with a smile, help clean and prepare rooms, and carry small items like
                    towels.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng
                    pagkain,
                    at pagpapanatiling malinis ng mga mesa at kusina.)
            </div>

        </div>

        <!-- Other Job Section -->
        <div
            class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 sm:p-8 mt-8 shadow-md border border-blue-200 max-w-4xl mx-auto">
            <div class="flex flex-col items-center sm:items-start gap-3">
                <h2 class="text-xl sm:text-2xl font-bold text-blue-700 text-center sm:text-left">
                    Job options not related to your skills that you might be interested in.
                    <button type="button"
                        class="text-blue-600 text-xl hover:scale-110 transition-transform">🔊</button>
                </h2>
                <div class="flex items-center justify-center sm:justify-start gap-2">
                    <p class="text-base sm:text-lg font-medium text-gray-700 italic text-center sm:text-left">
                        (Mga trabaho na maaaring hindi tugma sa iyong kakayahan pero maaaring magustuhan mo)
                    </p>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-8 px-2 sm:px-4">

            <!-- Food Service Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Food Service Work" onclick="toggleJobPref1Choice(this,'Food Service Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
                <img src="image/foodservice.png" alt="food service work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Food Service Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    This job includes serving food and drinks, helping prepare simple meals, and keeping the tables and
                    kitchen clean.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang pagsisilbi ng pagkain at inumin, pagtulong sa paghahanda ng simpleng
                    pagkain,
                    at pagpapanatiling malinis ng mga mesa at kusina.)
                </p>
            </div>

            <!-- Packing Work -->
            <div class="bg-white p-4 rounded-xl shadow transition-all duration-300 hover:bg-blue-100 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative jobpref-card"
                data-value="Packing Packages Work" onclick="toggleJobPref1Choice(this,'Packing Packages Work')">
                <button type="button"
                    class="absolute top-3 right-3 bg-[#1E40AF] hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
                <img src="image/packingwork.png" alt="Packing Work" class="w-full rounded-md mb-4" />
                <h3 class="text-blue-600 font-semibold text-center">Packing Packages Work</h3>
                <p class="text-sm mt-2" style="text-align: justify; text-align-last: center;">
                    This job includes putting items in boxes or bags, carrying light packages, and organizing items on
                    shelves.
                </p>
                <p class="text-[13px] text-gray-500 italic mt-2 text-center">
                    (Kasama sa trabahong ito ang paglalagay ng mga gamit sa kahon o bag, pagdadala ng magagaan na
                    packages, at pag-aayos ng mga gamit sa mga lagayan.)
                </p>
            </div>
        </div>


        <!-- Hidden input for job preference (JSON array) -->
        <input id="jobpref1" type="hidden" value="[]" />

        <script>
            // filepath: c:\xampp\htdocs\MyVerySpecialGuide\resources\views\ds_register_job-preference-1.blade.php
            function toggleJobPref1Choice(el, value) {
                try {
                    const hidden = document.getElementById('jobpref1');
                    if (!hidden) return;
                    let arr = [];
                    try {
                        arr = JSON.parse(hidden.value || '[]');
                    } catch (e) {
                        arr = [];
                    }
                    const idx = arr.indexOf(value);
                    if (idx === -1) {
                        arr.push(value);
                        if (el && el.classList) el.classList.add('selected');
                    } else {
                        arr.splice(idx, 1);
                        if (el && el.classList) el.classList.remove('selected');
                    }
                    hidden.value = JSON.stringify(arr);
                    if (value === 'other') {
                        const other = document.getElementById('jobpref1_other_text');
                        if (other && arr.indexOf('other') !== -1) other.focus();
                    }
                    const err = document.getElementById('jobpref1Error');
                    if (err) err.textContent = '';
                } catch (e) {
                    console.error('toggleJobPref1Choice error', e);
                }
            }

            // pre-select on load (if autofill set the hidden value)
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const hidden = document.getElementById('jobpref1');
                    if (!hidden) return;
                    let arr = [];
                    try {
                        arr = JSON.parse(hidden.value || '[]');
                    } catch (e) {
                        arr = [];
                    }
                    document.querySelectorAll('.jobpref-card[data-value]').forEach(c => {
                        const v = c.getAttribute('data-value');
                        if (v && arr.indexOf(v) !== -1) c.classList.add('selected');
                        else c.classList.remove('selected');
                    });
                } catch (e) {
                    /* ignore */
                }
            });
        </script>

        <!-- Next Button -->
        <div class="w-full flex flex-col items-center justify-center mt-12 mb-8">
            <div id="jobpref1Error" class="text-red-600 text-sm mb-2"></div>
            <button id="jobpref1Next" type="button"
                class="bg-[#2E2EFF] text-white text-lg font-semibold px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 shadow-md">
                Next →
            </button>
            <p class="text-gray-600 text-sm mt-2 text-center">
                Click <span class="text-[#1E40AF] font-medium">"Next"</span> to move to the next page<br>
                <span class="italic text-[#4B4F58]">(Pindutin ang "Next" upang lumipat sa susunod na pahina)</span>
            </p>
        </div>
    </div>
    </form>
    </div>

    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>
