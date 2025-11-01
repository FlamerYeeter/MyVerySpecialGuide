<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
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

    /* selectable card visual (shared style used across review pages) */
        .selectable-card {
            border: 2px solid transparent;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                border-color .18s ease;
        }

        .selectable-card.selected {
            border-color: #2563eb;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.14);
            transform: translateY(-6px);
        }

        /* show small check badge when a card is selected */
        .selectable-card.selected::after,
        .guardian-card.selected::after,
        .education-card.selected::after,
        .skills-card.selected::after,
        .workexp-card.selected::after {
            content: "";
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 44px;
            height: 44px;
            background-image: url('/image/checkmark.png');
            background-size: contain;
            background-repeat: no-repeat;
            pointer-events: none;
        }
        /* TTS button visual state */
        .tts-btn { cursor: pointer; }
        .tts-btn.speaking { transform: scale(1.04); box-shadow: 0 8px 24px rgba(30,64,175,0.12); }
    </style>
</head>

<body class="bg-white flex justify-center items-start min-h-screen p-4 sm:p-6 md:p-8 relative overflow-x-hidden">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-6 top-1/3 w-28 lg:w-36 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="fixed left-1 sm:left-4 md:left-8 bottom-16 sm:bottom-20 md:bottom-28 w-14 sm:w-20 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-6 top-1/4 w-28 lg:w-36 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-6 bottom-24 w-28 lg:w-36 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-4 top-4 bg-[#2E2EFF] text-white px-6 py-3 rounded-2xl flex items-center gap-3 text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
    onclick="(history.length>1 ? history.back() : window.location.href='{{ route('registerjobpreference1') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-6">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">
                Edit Your Information
            </h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-24 sm:w-32 md:w-36 mb-6">

            <div class="bg-white rounded-3xl p-5 sm:p-7 border-4 border-blue-300 shadow-lg text-left">
                <h2 class="text-lg sm:text-xl md:text-2xl text-blue-600 font-bold flex items-center gap-x-3">
                    Edit Your Details
                    <button type="button" class="tts-btn text-xl hover:scale-110 transition-transform"
                        data-tts-en="Please review your details. Make sure all your information below is correct before going to the next page."
                        data-tts-tl="Siguraduhing tama ang lahat ng impormasyong nakasaad bago lumipat ng pahina."
                        aria-label="Read this section aloud in English then Filipino"></button>
                </h2>
                <p class="text-gray-800 text-sm sm:text-base mt-2">
                    You can edit or update your personal information below to reflect any recent changes.
                </p>
                <p class="text-gray-600 italic text-sm sm:text-base mt-3">
                    (Maaari mong i-edit o i-update ang iyong personal na impormasyon sa ibaba upang maipakita ang mga bagong pagbabago.)
                </p>
            </div>
        </div>

        <!-- Review Sections -->
        <div id="reviewContainer" class="mt-10 space-y-8">


        <!-- Form -->
        <form id="registrationForm" class="mt-10 space-y-10 text-left">
            <!-- Personal Information -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Personal Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            First Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Unang Pangalan</p>
                        <input id="first_name" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Last Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Apelyido</p>
                        <input id="last_name" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Age <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Edad</p>
                        <input id="age" type="number" placeholder="Age"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Email -->
                    <div>
                        <label for="email"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Email <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Email</p>
                        <input id="email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="phone"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Contact Number <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Numero ng Telepono</p>
                        <input   id="phone" 
                                type="tel" 
                                placeholder="+63 9XX XXX XXXX"
                                pattern="^\+63\s?9\d{2}\s?\d{3}\s?\d{4}$"
                                title="Please enter a valid Philippine number (e.g. +63 912 345 6789)"
                                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <!-- Address -->
                <div class="mt-6">
                    <label for="address" class="font-semibold text-gray-800 text-sm sm:text-base">
                        Address <span>⭐</span>
                    </label>
                    <p class="text-gray-600 italic text-xs sm:text-sm">Tirahan</p>
                    <input id="address" type="text" placeholder="Complete Address"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                </div>
            </div>

            <!-- Type of Down Syndrome -->
            <div
                class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-5">

                <!-- Text Section -->
                <div class="flex-1">
                    <h3
                        class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                        Type of Down Syndrome <span class="text-gray-500 text-m">(optional)</span>
                    </h3>
                    <p class="text-black-600 text-xs sm:text-sm leading-snug mt-1">
                        You may fill this in if you already have records or a doctor’s assessment that shows your type
                        of Down syndrome.
                        It’s perfectly okay if you’re not aware of it yet — you can leave it blank.
                    </p>

                    <p class="text-gray-600 italic text-xs sm:text-sm leading-snug mt-4">
                        (Opsyonal lamang ito. Maaari mo itong sagutan kung mayroon ka nang tala o pagsusuri mula sa
                        doktor na nagpapakita
                        ng uri ng iyong Down syndrome. Ayos lang din kung hindi mo pa ito alam — maaari mo itong
                        laktawan.)
                    </p>
                </div>

                <!-- Dropdown Selector -->
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <select id="dsType" name="dsType"
                        class="w-full sm:w-60 border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Type --</option>
                        <option value="Trisomy 21 (Nondisjunction)">Trisomy 21 (Nondisjunction)</option>
                        <option value="Mosaic Down Syndrome">Mosaic Down Syndrome</option>
                        <option value="Translocation Down Syndrome">Translocation Down Syndrome</option>
                    </select>
                </div>
            </div>


            <!-- Guardian Information -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Guardian Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Guardian First Name -->
                    <div>
                        <label for="guardian_first"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            First Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Unang Pangalan</p>
                        <input id="guardian_first" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Guardian Last Name -->
                    <div>
                        <label for="guardian_last"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Last Name <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Apelyido</p>
                        <input id="guardian_last" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Guardian Email -->
                    <div>
                        <label for="guardian_email"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Email <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Email</p>
                        <input id="guardian_email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>

                    <!-- Guardian Contact -->
                    <div>
                        <label for="guardian_phone"
                            class="font-semibold text-gray-800 flex items-center gap-1 text-sm sm:text-base">
                            Contact Number <span>⭐</span>
                        </label>
                        <p class="text-gray-600 italic text-xs sm:text-sm">Numero ng Telepono</p>
                        <input id="guardian_phone" type="tel" placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none" />
                    </div>
                </div>

                <!-- Relationship -->
                <div class="mt-6">
                    <label for="guardian_relationship" class="font-semibold text-gray-800 text-sm sm:text-base">
                        Relationship to User <span>⭐</span>
                    </label>
                    <p class="text-gray-600 italic text-xs sm:text-sm">Relasyon sa Gagamit</p>
                    <select id="guardian_relationship"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring focus:ring-blue-200 focus:outline-none">
                        <option value="" disabled selected>Select Relationship</option>
                        <option value="parent">Parent</option>
                        <option value="guardian">Guardian</option>
                        <option value="sibling">Sibling</option>
                        <option value="relative">Relative</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Account Details -->
            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-gray-200">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Account Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="font-semibold flex items-center gap-1">Username
                            <span>⭐</span></label>
                        <input id="username" name="username" type="text" placeholder="Enter your username"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                        <p class="text-gray-500 text-xs mt-1">(example: @juancruz)</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="font-semibold flex items-center gap-1">Password
                            <span>⭐</span></label>
                        <input   id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="Enter your password"
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                                    title="Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and be 8+ characters long."
                                    class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                            <label for="togglePassword" class="text-sm text-gray-700 cursor-pointer leading-snug">
                                 <p id="passwordMessage" 
                                class="mt-1 text-sm text-red-500 italic hidden">
                                Password must have at least 1 uppercase, 1 lowercase, 1 number, and be 8+ characters long.
                                </p>
                    </div>
                </div>    
                
                
                <!-- Password Rules -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-blue-50 border border-blue-300 rounded-xl p-6 mt-6 text-sm gap-6 shadow-inner">
                    <!-- English -->
                    <div>
                        <p class="font-semibold text-blue-700 mb-2 flex items-center gap-2">English <button
                                type="button"
                                class="text-gray-600 text-lg hover:scale-110 transition-transform tts-btn"
                                title="Play audio" aria-label="Play audio for password rules (English)"
                                data-tts-en="Password must have: One uppercase letter, one lowercase letter, one number, and at least eight characters. Example: Lovedog12."
                                >🔊</button>
                        </p>
                        <p class="mb-2">Password must have:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>One uppercase letter (A, B, C)</li>
                            <li>One lowercase letter (a, b, c)</li>
                            <li>One number (1, 2, 3)</li>
                            <li>At least 8 characters (letters + numbers)</li>
                        </ul>
                        <p class="mt-3 text-gray-800 font-semibold">Example: Lovedog12</p>
                    </div>

                    <!-- Tagalog -->
                    <div>
                        <p class="font-semibold text-blue-700 mb-2 flex items-center gap-2">Tagalog <button
                                type="button"
                                class="text-gray-600 text-lg hover:scale-110 transition-transform tts-btn"
                                title="Play audio" aria-label="Play audio for password rules (Tagalog)"
                                data-tts-tl="Ang password ay dapat mayroong: isang malaking letra, isang maliit na letra, isang numero, at hindi bababa sa 8 karakter na halo ng letra at numero. Halimbawa: Lovedog12.">🔊</button>
                        </p>
                        <p class="mb-2">Ang password ay dapat mayroong:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Isang malaking letra (A, B, C)</li>
                            <li>Isang maliit na letra (a, b, c)</li>
                            <li>Isang numero (1, 2, 3)</li>
                            <li>Hindi bababa sa 8 karakter na halo ng letra at numero</li>
                        </ul>
                        <p class="mt-3 text-gray-800 font-semibold">Halimbawa: Lovedog12</p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-6">
                    <label for="confirmPassword" class="font-semibold text-base flex items-center gap-1">Confirm
                        Password <span>⭐</span></label>
                    <input id="confirmPassword" name="confirmPassword" type="password"
                        placeholder="Re-enter your password"
                        class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                </div>
                  <p id="confirmMessage" class="mt-1 text-sm text-red-500 italic hidden">
                    Passwords do not match.
                </p>
            </div>

            <!-- Proof of Membership -->
            <div class="bg-white rounded-2xl shadow-md p-5 sm:p-6 border border-gray-300 mt-6">
                <h3
                    class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Proof of Membership <span class="text-gray-500 text-m">(optional)</span>
                </h3>
                

                <!-- File Upload Box -->
                <div
                    class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 text-sm sm:text-base">
                            <span id="proofLabel" class="flex items-center gap-2">
                                <span>Upload Proof (Image or PDF)</span> <span>⭐</span>
                            </span>
                        </p>
                        <p id="proofHint" class="text-gray-600 italic text-xs sm:text-sm mt-1">
                            (Mag-upload ng larawan o PDF bilang patunay ng pagiging miyembro.)<br><br>
                            Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b><br>
                        </p>

                        <!-- File preview details -->
                        <div id="proofFileInfo"
                            class="hidden mt-3 bg-white border border-gray-200 rounded-lg p-3 flex justify-between items-center shadow-sm">
                            <div class="flex items-center gap-2">
                                <span id="proofFileIcon" class="text-2xl"></span>
                                <span id="proofFileName"
                                    class="text-sm text-gray-700 truncate max-w-[160px] sm:max-w-[240px]"></span>
                            </div>
                            <div class="flex gap-2">
                                <button id="proofViewBtn" type="button"
                                    class="bg-[#2E2EFF] hover:bg-blue-600 font-medium text-white text-xs px-3 py-1 rounded-md transition">View
                                    / Tingnan</button>
                                <button id="proofRemoveBtn" type="button"
                                    class="bg-[#D20103] hover:bg-red-600 font-medium text-white text-xs px-3 py-1 rounded-md transition">Remove
                                    / Alisin</button>
                            </div>
                        </div>
                    </div>

                    <label for="proof"
                        class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium 
                        px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
                        📁 Choose File / Pumili ng File
                    </label>

                    <input id="proof" name="proof" type="file" accept=".jpg,.jpeg,.png,.pdf"
                        class="hidden" required>
                </div>

                <!-- Modal for File Preview -->
                <div id="fileModal"
                    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
                    <div
                        class="bg-white rounded-lg shadow-lg max-w-3xl w-[90%] max-h-[85vh] flex flex-col overflow-hidden">
                        <div class="flex justify-between items-center bg-[#2E2EFF] text-white px-4 py-2">
                            <h2 class="font-semibold text-base">File Preview / Pagtingin ng File</h2>
                            <button id="closeModalBtn" type="button"
                            class="text-white font-bold text-lg hover:text-gray-300">✕</button>
                        </div>
                        <div id="modalContent"
                            class="flex-1 bg-gray-100 overflow-auto flex items-center justify-center p-4">
                            
                            
                            <!-- File content will appear here -->
                        </div>
                    </div>
                </div>


                <!-- Script -->
                <script>
                    (function() {
                        const fileInput = document.getElementById('proof');
                        const fileInfo = document.getElementById('proofFileInfo');
                        const fileName = document.getElementById('proofFileName');
                        const fileIcon = document.getElementById('proofFileIcon');
                        const viewBtn = document.getElementById('proofViewBtn');
                        const removeBtn = document.getElementById('proofRemoveBtn');
                        const modal = document.getElementById('fileModal');
                        const modalContent = document.getElementById('modalContent');
                        const closeModal = document.getElementById('closeModalBtn');
                        const hintEl = document.getElementById('proofHint');

                        let currentFileURL = null;
                        let currentFileType = null;

                        // When user selects a file
                        fileInput.addEventListener('change', function() {
                            const file = this.files[0];
                            if (file) {
                                const name = file.name.length > 50 ? file.name.slice(0, 47) + '...' : file.name;
                                const ext = file.name.split('.').pop().toLowerCase();
                                currentFileType = ext;

                                // Set icon based on file type
                                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                                    fileIcon.textContent = '🖼️';
                                } else if (ext === 'pdf') {
                                    fileIcon.textContent = '📄';
                                } else {
                                    fileIcon.textContent = '📁';
                                }

                                fileName.textContent = name;
                                fileInfo.classList.remove('hidden');
                                if (hintEl) hintEl.style.display = 'none';

                                // Create object URL for preview
                                if (currentFileURL) URL.revokeObjectURL(currentFileURL);
                                currentFileURL = URL.createObjectURL(file);
                            } else {
                                fileInfo.classList.add('hidden');
                                fileName.textContent = '';
                                fileIcon.textContent = '';
                                if (hintEl) hintEl.style.display = '';
                            }
                        });

                        // View file in modal
                        viewBtn.addEventListener('click', () => {
                            if (currentFileURL) {
                                modalContent.innerHTML = ''; // Clear previous preview
                                if (['jpg', 'jpeg', 'png'].includes(currentFileType)) {
                                    const img = document.createElement('img');
                                    img.src = currentFileURL;
                                    img.alt = 'Uploaded Image';
                                    img.className = 'max-h-[80vh] rounded shadow';
                                    modalContent.appendChild(img);
                                } else if (currentFileType === 'pdf') {
                                    const iframe = document.createElement('iframe');
                                    iframe.src = currentFileURL;
                                    iframe.className = 'w-full h-[80vh] rounded';
                                    modalContent.appendChild(iframe);
                                } else {
                                    modalContent.innerHTML =
                                        '<p class="text-gray-600">Preview not available for this file type.</p>';
                                }
                                modal.classList.remove('hidden');
                            }
                        });

                        // Close modal without removing file
                        closeModal.addEventListener('click', (e) => {
                        e.preventDefault(); // 🚫 stops form submission/refresh
                        modal.classList.add('hidden');
                        modalContent.innerHTML = ''; // clear preview only
                    });


                        // Close modal by clicking outside 
                        modal.addEventListener('click', (e) => {
                            if (e.target === modal) {
                                modal.classList.add('hidden');
                                modalContent.innerHTML = '';
                            }
                        });

                        // Remove file manually
                        removeBtn.addEventListener('click', () => {
                            fileInput.value = '';
                            if (currentFileURL) {
                                URL.revokeObjectURL(currentFileURL);
                                currentFileURL = null;
                            }
                            fileInfo.classList.add('hidden');
                            fileName.textContent = '';
                            fileIcon.textContent = '';
                            if (hintEl) hintEl.style.display = '';
                        });
                    })();

                     const phoneInput = document.getElementById('phone');

                    phoneInput.addEventListener('input', () => {
                        let value = phoneInput.value;

                        // 1️⃣ Alisin lahat ng hindi digits or '+' sign
                        value = value.replace(/[^\d+]/g, '');

                        // 2️⃣ Kung nagsimula sa '0', palitan ng '+63'
                        if (value.startsWith('0')) {
                            value = '+63' + value.substring(1);
                        }

                        // 3️⃣ Kung hindi pa nagsisimula sa '+63', pilitin itong maging '+63'
                        if (!value.startsWith('+63')) {
                            value = '+63';
                        }

                        // 4️⃣ Limitahan ang haba: +63 (3 chars) + 10 digits = total 13
                        if (value.length > 13) {
                            value = value.slice(0, 13);
                        }

                        // 5️⃣ Optional: kung gusto mo lagyan ng space after +63 para readability
                        // value = value.replace(/(\+63)(\d)/, '$1 $2'); // uncomment if you want "+63 9..."

                        // 6️⃣ Update input value
                        phoneInput.value = value;
                    });

                    window.addEventListener('load', () => {
                    document.getElementById('first_name').value = '';
                    document.getElementById('last_name').value = '';
                    document.getElementById('age').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('address').value = '';
                    document.getElementById('dsType').selectedIndex = 0;
                    document.getElementById('guardian_first').value = '';
                    document.getElementById('guardian_last').value = '';
                    document.getElementById('guardian_email').value = '';
                    document.getElementById('guardian_phone').value = '';
                    document.getElementById('guardian_relationship').selectedIndex = 0;
              
              const passwordInput = document.getElementById('password');
                const passwordMessage = document.getElementById('passwordMessage');
                const confirmPasswordInput = document.getElementById('confirmPassword');
                const confirmMessage = document.getElementById('confirmMessage');
                const createAccountBtn = document.getElementById('createAccountBtn');
                const togglePassword = document.getElementById('togglePassword');

                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

                // 🔹 Password validation
                passwordInput.addEventListener('input', () => {
                const value = passwordInput.value.trim();

                if (value === '') {
                    passwordMessage.classList.add('hidden');
                    passwordInput.style.borderColor = '';
                    disableButton();
                    return;
                }

                passwordMessage.classList.remove('hidden');

                if (passwordRegex.test(value)) {
                    passwordInput.style.borderColor = 'green';
                    passwordMessage.textContent = '✅ Strong password. Ready to go!';
                    passwordMessage.classList.remove('text-red-500');
                    passwordMessage.classList.add('text-green-600');
                } else {
                    passwordInput.style.borderColor = 'red';
                    passwordMessage.textContent =
                    '❌ Must contain 1 uppercase, 1 lowercase, 1 number, and 8+ characters.';
                    passwordMessage.classList.remove('text-green-600');
                    passwordMessage.classList.add('text-red-500');
                }

                validateConfirmPassword();
                });

                // 🔹 Confirm password validation
                confirmPasswordInput.addEventListener('input', validateConfirmPassword);

                function validateConfirmPassword() {
                const passwordVal = passwordInput.value.trim();
                const confirmVal = confirmPasswordInput.value.trim();

                if (confirmVal === '') {
                    confirmMessage.classList.add('hidden');
                    confirmPasswordInput.style.borderColor = '';
                    disableButton();
                    return;
                }

                confirmMessage.classList.remove('hidden');

                if (passwordRegex.test(passwordVal) && passwordVal === confirmVal) {
                    confirmPasswordInput.style.borderColor = 'green';
                    confirmMessage.textContent = '✅ Passwords match.';
                    confirmMessage.classList.remove('text-red-500');
                    confirmMessage.classList.add('text-green-600');
                    enableButton();
                } else {
                    confirmPasswordInput.style.borderColor = 'red';
                    confirmMessage.textContent = '❌ Passwords do not match.';
                    confirmMessage.classList.remove('text-green-600');
                    confirmMessage.classList.add('text-red-500');
                    disableButton();
                }
                }

                // 🔹 Disable button
                function disableButton() {
                createAccountBtn.disabled = true;
                createAccountBtn.classList.remove('bg-[#2E2EFF]', 'hover:bg-blue-600', 'text-white');
                createAccountBtn.classList.add('bg-gray-400', 'cursor-not-allowed', 'opacity-90', 'text-white');
                }

                // 🔹 Enable button
                function enableButton() {
                createAccountBtn.disabled = false;
                createAccountBtn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'opacity-90');
                createAccountBtn.classList.add('bg-[#2E2EFF]', 'hover:bg-blue-600', 'text-white');
                }

                // 🔹 Toggle password visibility
                togglePassword.addEventListener('change', () => {
                const type = togglePassword.checked ? 'text' : 'password';
                passwordInput.type = type;
                confirmPasswordInput.type = type;
                });
              
              
              
                });
                </script>
                </div>

         
            <!-- Save Button -->
            <div class="flex flex-col items-center mt-6">
            <button 
                id="createAccountBtn" 
                type="button" 
                onclick="window.location.href='nextpage.html'" 
                class="text-white text-base sm:text-lg font-semibold px-6 sm:px-12 py-3 
                    rounded-xl transition-colors duration-300 shadow-md w-full sm:w-auto 
                    bg-blue-600 opacity-90 hover:bg-blue-700">
                Save
            </button>
            <p class="text-gray-600 text-sm mt-3 text-center">
                Click <span class="text-[#1E40AF] font-medium">“Save”</span> to Update Information<br>
                <span class="italic text-gray-600">(Pindutin upang magpatuloy sa susunod na hakbang)</span>
            </p>
            </div>
            <!-- ✅ Modal -->
            <div id="saveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 w-11/12 max-w-md text-center">
                <h2 class="text-xl font-semibold text-blue-700 mb-4">Information Saved!</h2>
                <p class="text-gray-700 mb-6">
                Your details have been successfully updated.<br>
                <span class="italic text-gray-600">Matagumpay na na-update ang iyong impormasyon.</span>
                </p>
                <button 
                id="closeModalBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow-md transition">
                Review Information
                </button>
            </div>
            </div>

            <!-- ✅ Script -->
            <script>
            const saveBtn = document.getElementById('createAccountBtn');
            const modal = document.getElementById('saveModal');
            const closeBtn = document.getElementById('closeModalBtn');

            saveBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            </script> 


              <!-- Show/hide password toggles -->
    <script>
        (function() {
            function toggleField(checkboxId, fieldId) {
                const cb = document.getElementById(checkboxId);
                const field = document.getElementById(fieldId);
                if (!cb || !field) return;
                // initialize based on checkbox state
                field.type = cb.checked ? 'text' : 'password';
                cb.addEventListener('change', function() {
                    field.type = this.checked ? 'text' : 'password';
                });
            }

            // Run after DOM loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    toggleField('togglePassword', 'password');
                    toggleField('toggleConfirm', 'confirmPassword');
                });
            } else {
                toggleField('togglePassword', 'password');
                toggleField('toggleConfirm', 'confirmPassword');
            }
        })();
    </script>