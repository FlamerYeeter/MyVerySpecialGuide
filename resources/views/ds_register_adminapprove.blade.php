<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Applicant Registration: Personal Information</title>
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
    .tts-btn.speaking {
        background-color: #2563eb !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.18);
        transform: scale(1.03);
    }
    
    /* OCR Loading Spinner */
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .ocr-spinner {
      border: 4px solid #e5e7eb;
      border-top: 4px solid #2E2EFF;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
    }
        .ocr-loading-container {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background-color: #f0f4ff;
            border: 1px solid #2E2EFF;
            border-radius: 8px;
            margin-top: 12px;
            width: 100%;
            box-sizing: border-box;
        }
    .ocr-loading-text {
      font-size: 14px;
      color: #1e40af;
      font-weight: 500;
    }
        /* Layout & Typography improvements */
        .main-container h1 { font-size: clamp(1.6rem, 3.6vw, 2.8rem); line-height: 1.05; }
        .main-container h2, .main-container h3 { font-size: clamp(1.05rem, 2.2vw, 1.4rem); }
        .main-container .text-gray-600.italic { font-size: 0.92rem; }
        .main-container .bg-white.rounded-2xl { padding: 1.25rem; }
        .main-container .upload-error { font-size: 0.92rem; }
        /* Make TTS buttons consistent */
        .tts-btn { padding: 0.55rem 0.6rem; border-radius: 9999px; }
        /* Improve spacing inside form groups */
        .main-container .grid > div { display:block; }

        /* Responsive adjustments */
        @media (max-width: 640px) {
                body { font-size: 15px; }
                .main-container { padding: 0.6rem; }
                .main-container h1 { text-align: center; margin-bottom: 0.5rem; }
                .main-container h3 { text-align: center; }
                /* make labels and helper text slightly larger for readability */
                .main-container label, .main-container p, .main-container .text-gray-600 { font-size: 15px; }
                /* Ensure TTS buttons are touch-friendly */
                .tts-btn { padding: 0.6rem; font-size: 1.05rem; }
                /* Ensure inputs stretch and maintain balanced padding */
                .main-container input[type="text"],
                .main-container input[type="email"],
                .main-container input[type="tel"],
                .main-container input[type="date"],
                .main-container select,
                .main-container textarea { font-size: 15px; padding: 0.6rem 0.75rem; }
        }
        /* Section card consistency */
        .main-container .section-card {
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 0.75rem;
            min-height: 360px;
            padding: 1.25rem; 
        }
        /* Slightly smaller on medium screens */
        @media (max-width: 1024px) {
            .main-container .section-card { min-height: 320px; }
        }
        /* On small screens make section cards match the instruction blue card size */
        @media (max-width: 640px) {
            .main-container .section-card { min-height: 300px; padding: 0.9rem; }
            /* make section cards visually wider on small screens to use more horizontal space; keep info-card at original size */
            .main-container .section-card {
                width: calc(100% + 2rem);
                max-width: none;
                margin-left: -1rem;
                margin-right: -1rem;
            }
        }
        </style>

</head>

<body class="bg-white flex justify-center sm:items-center items-start min-h-screen p-4 sm:p-6 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
        class="hidden sm:block fixed left-2 sm:left-6 lg:left-10 top-1/3 w-20 sm:w-28 md:w-32 opacity-90 animate-float-slow z-0">
    <img src="image/obj7.png" alt="Triangle Mascot"
        class="hidden sm:block fixed left-2 sm:left-6 lg:left-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-28 opacity-90 animate-float-medium z-0">
    <img src="image/obj3.png" alt="Blue Mascot"
        class="hidden sm:block fixed right-2 sm:right-6 lg:right-10 top-1/4 w-20 sm:w-28 md:w-32 opacity-90 animate-float-fast z-0">
    <img src="image/obj8.png" alt="Twin Mascot"
        class="hidden sm:block fixed right-2 sm:right-6 lg:right-8 bottom-16 sm:bottom-24 lg:bottom-28 w-16 sm:w-24 md:w-32 opacity-90 animate-float-medium z-0">

    <!-- Back Button -->
    <button
        class="fixed left-2 top-2 sm:left-4 sm:top-4 bg-[#2E2EFF] text-white px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl flex items-center gap-2 sm:gap-3 text-sm sm:text-lg font-semibold shadow-lg hover:bg-blue-700 active:scale-95 transition z-[9999]"
        onclick="(history.length>1 ? history.back() : window.location.href='{{ route('dataprivacy') }}')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="white"
            class="w-6 h-6" >
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </button>

    <!-- Main Container -->
    <div
        class="bg-[#FEF2C7] w-full max-w-5xl rounded-3xl shadow-2xl p-6 sm:p-10 md:p-12 relative z-10 border-4 border-blue-200">

        <!-- Header -->
        <div class="text-center mt-4">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-blue-700 mb-4 drop-shadow-md">Registration</h1>
            <img src="image/obj6.png" alt="Pink Object" class="mx-auto w-20 sm:w-32 mb-4">

        <!-- Information Note -->
        <div
            class="info-card mt-2 sm:mt-2 max-w-4xl mx-auto bg-blue-50 p-4 sm:p-6 rounded-2xl border-2 sm:border-4 border-blue-300 shadow sm:shadow-md relative">

              <!-- Desktop Audio Button -->
                <button type="button" aria-label="Play audio for info section"
                    class="hidden sm:block absolute top-1/2 right-5 -translate-y-1/2 bg-[#1E40AF] hover:bg-blue-700 text-white 
                         text-lg sm:text-xl p-3 rounded-full shadow-lg transition-transform hover:scale-110 
                            focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please fill out all the required fields completely and accurately. Type your information in the boxes below any field with a ⭐ must be filled in. Thank you!"
                            data-tts-tl="Pakisagutan nang buo at tama ang lahat ng kinakailangang impormasyon. I-type ang iyong sagot sa mga kahon sa ibaba; 
                            ang mga field na may ⭐ ay kinakailangang sagutan. Salamat!">
                            🔊
                </button>

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pr-4 sm:pr-16"> 
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 flex-shrink-0 mt-0.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-base sm:text-lg text-gray-700 font-bold leading-relaxed">
                     Please fill out all the required fields completely and accurately. Type your information in the boxes below any field with a ⭐ must be filled in. Thank you!
                    </p>
                    <p class="text-gray-700 italic text-sm sm:text-base mt-2">
                        (Pakisagutan nang buo at tama ang lahat ng kinakailangang impormasyon. I-type ang iyong sagot sa mga kahon sa ibaba; 
                        ang mga field na may ⭐ ay kinakailangang sagutan. Salamat!)
                    </p>
                
                 <!-- Mobile Audio Button -->
                    <div class="mt-3 flex justify-center sm:hidden">
                        <button type="button" aria-label="Play audio for info section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg 
                            transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Please fill out all the required fields completely and accurately. Type your information in the boxes below any field with a star must be filled in. Thank you!"
                            data-tts-tl="Pakisagutan nang buo at tama ang lahat ng kinakailangang impormasyon. I-type ang iyong sagot sa mga kahon sa ibaba; 
                            ang mga field na may star ay kinakailangang sagutan. Salamat!">
                            🔊
                    </button>
                </div>
            </div>
        </div>
    </div>



                <!-- Form -->
                <form id="registrationForm" class="main-container mt-10 space-y-8 text-center sm:text-left mx-auto w-full max-w-6xl px-4 sm:px-0">

<!-- Personal Information -->
<div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

    <!-- Section Title -->
    <div class="mb-4">
        <h3 class="text-xl sm:text-2xl font-bold text-blue-600">
            Personal Information
        </h3>
    </div>

    <!-- English Instruction -->
    <p class="text-gray-700 font-semibold text-lg mb-2">
        Please upload your PWD ID to help auto-fill some of your information and for verification.<span>⭐</span>
    </p>

    <!-- Tagalog Instruction -->
    <p class="text-gray-700 italic text-md flex items-center gap-2">
        (Mag upload ng iyong PWD ID upang makatulong sa automatic na paglagay ng iyong impormasyon at para sa verification.)
        <button type="button"
            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
            data-tts-en="Please upload your PWD ID to help auto-fill some of your information and for verification."
            data-tts-tl="Mag upload ng iyong PWD ID upang makatulong sa automatic na paglagay ng iyong impormasyon at para sa verification.">
            🔊
        </button>
    </p>


            <!-- PWD ID Upload Card -->
            <div class="mt-4 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-8 pwdid-card">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">

                    <!-- Upload Info -->
                    <div class="flex-1 text-center sm:text-left">
                        <p class="text-gray-700 text-lg sm:text-base mb-1">
                            Upload an image or PDF of the front and back of your PWD ID.
                        </p>

                        <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                            (Mag-upload ng larawan o PDF ng harap at likod ng iyong PWD ID.)
                        </p>

                        <p class="text-gray-600 text-sm sm:text-base">
                            Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                        </p>

                        <div id="pwdidDisplay" class="mt-2"></div>
                    </div>

                    <!-- Upload Button: Front/Back combined (allow 1 or 2 files) -->
                    <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-3">

                        <div class="w-full sm:w-auto text-center sm:text-right">
                            <label id="pwdidLabel" for="pwdidFile" class="inline-flex items-center justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-4 py-2 rounded-lg transition shadow-md cursor-pointer">
                                📁 Upload Front/Back of ID (1-2 files)
                            </label>
                            <input id="pwdidFile" name="pwd_id[]" type="file" accept=".jpg,.jpeg,.png,.pdf" multiple class="hidden" />
                            <div id="pwdidDisplay" class="upload-info text-sm text-gray-700 mt-2 justify-center sm:justify-end"></div>
                            <p id="pwdidHint" class="text-gray-600 text-xs mt-1">You may upload either the front only, or both front and back (max 2 files).</p>
                        </div>

                        <div class="upload-error text-sm text-red-600 w-full text-center sm:text-right"></div>

                    </div>

                </div>

            </div>

                <!-- Personal Fields -->
                <div class="space-y-6">

                    <!-- Name Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                        <div>
                            <label class="font-semibold flex items-center gap-1">
                                Last Name <span>⭐</span>
                            </label>
                            <p class="text-gray-500 italic flex text-sm mt-1">Apelyido</p>
                            <input id="last_name" type="text" placeholder="Last Name"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>
                        </div>

                        <div>
                            <label class="font-semibold flex items-center gap-1">
                                First Name <span>⭐</span>
                            </label>
                            <p class="text-gray-500 italic flex text-sm mt-1">Unang Pangalan</p>
                            <input id="first_name" type="text" placeholder="First Name"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>
                        </div>

                        <div>
                            <label class="font-semibold flex items-center gap-1">
                                Middle Name 
                            </label>
                            <p class="text-gray-500 italic flex text-sm mt-1">Gitnang Pangalan (Opsyonal)</p>
                            <input id="middle_name" name="middleName" type="text" placeholder="Middle Name"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>
                        </div>

                    </div>

                 <!-- Birth & Contact Fields -->
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                    <!-- Date of Birth -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">
                            Date of Birth <span>⭐</span>
                        </label>
                        <p class="text-gray-500 italic flex text-sm mt-1">Petsa ng Kapanganakan</p>
                        <input id="birthdate" type="date"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">
                            Email Address <span>⭐</span>
                        </label>
                        <p class="text-gray-500 italic flex text-sm mt-1">Email Address</p>
                        <input id="email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>
                        <div id="emailError" class="text-red-600 text-sm mt-1"></div>
                    </div>

                    <!-- Cellphone Number -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">
                            Cellphone Number <span>⭐</span>
                        </label>
                        <p class="text-gray-500 italic flex text-sm mt-1">Numero ng Cellphone</p>
                        <input id="phone"
                            type="tel"
                            placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>
                    </div>

                </div>

                <!-- Address -->
                <div>

                    <label class="font-semibold flex items-center gap-1">
                       Home Address <span>⭐</span>
                    </label>

                    <p class="text-gray-500 italic flex text-sm mt-1">
                        Tirahan (No./Blk/Lot, Street, Barangay, City)
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mt-2">

                        <input id="address_number" type="text" placeholder="No./Blk/Lot"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="address_street" type="text" placeholder="Street"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="address_barangay" type="text" placeholder="Barangay"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="address_city" type="text" placeholder="City / Municipality"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                    </div>
                        <input id="address" name="address" type="hidden"/>
                    
            <!-- Type of Down Syndrome Section -->
            <div id="type_of_down_syndrome_container" class="mt-8 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm">

                <div class="flex items-center justify-between mb-3">
                    <div>
                        <label class="font-semibold text-gray-800 text-sm sm:text-lg" for="down_syndrome_type">
                            What is your Karyotype Result? <span>⭐</span>
                        </label>
                        <p class="mt-2 text-gray-700 text-md">
                            Please select your karyotype result if you already have medical records or information from your doctor.
                        </p>
                        <p class="mt-1 text-gray-600 italic text-sm">
                            (Piliin ang iyong karyotype result kung mayroon ka nang medical records o impormasyon mula sa iyong doktor.)
                        </p>
                    </div>

                    <!-- TTS Audio Button -->
                    <button type="button"
                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                        data-tts-en="Please select your karyotype result if you already have medical records or information from your doctor."
                        data-tts-tl="Piliin ang iyong karyotype result kung mayroon ka nang medical records o impormasyon mula sa iyong doktor.">
                        🔊
                    </button>
                </div>

                <!-- Options: Radio Buttons -->
                <div class="flex flex-col sm:flex-row sm:gap-6 gap-4" id="down_syndrome_type">

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" id="down_syndrome_Pure" name="down_syndrome_type" value="Pure Trisomy" class="accent-blue-600"/>
                        <span class="text-gray-700">Pure Trisomy</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" id="down_syndrome_Mosaic" name="down_syndrome_type" value="Mosaic Trisomy" class="accent-blue-600"/>
                        <span class="text-gray-700">Mosaic Trisomy</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" id="down_syndrome_Translocation" name="down_syndrome_type" value="Translocation Trisomy" class="accent-blue-600"/>
                        <span class="text-gray-700">Translocation Trisomy 21</span>
                   </label>
                    <!-- Hidden field to surface selected karyotype into collected form data -->
                    <input id="dsType" name="dsType" type="hidden" value="" />
                    <!-- Legacy/alias hidden fields for server and older pages -->
                    <input id="r_dsType1" name="r_dsType1" type="hidden" value="" />
                    <input id="r_dsType" name="r_dsType" type="hidden" value="" />
                    <input id="types_of_ds" name="types_of_ds" type="hidden" value="" />
                    <input id="TYPES_OF_DS" name="TYPES_OF_DS" type="hidden" value="" />
                    <input id="karyotype" name="karyotype" type="hidden" value="" />
                </div>
            </div>

            <!-- Medical Certificate Info Section -->
            <div class="mt-6 text-left flex flex-col gap-2">

                <!-- Title  -->
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-gray-800 text-sm sm:text-lg">
                        Please upload your Medical Certificate.<span>⭐</span>
                    </p>
                    <!-- TTS Audio Button -->
                    <button type="button"
                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                        data-tts-en="Please upload your Medical Certificate issued within the last 3 months to show you’re fit and ready to work."
                        data-tts-tl="I-upload ang medical certificate na inisyu sa loob ng nakaraang 3 buwan para ipakita na ikaw ay malusog at handa nang magtrabaho.">
                        🔊
                    </button>
                </div>

                <p class="mt-2 text-gray-700 text-md">
                    Please upload a medical certificate issued within the last <strong>3 months</strong> to show your health information is up to date.
                </p>

                <p class="mt-1 text-gray-600 italic text-sm">
                    (I-upload ang medical certificate na inisyu sa loob ng nakaraang <strong>3 buwan</strong> upang ipakita na updated ang iyong kalusugan.)
                </p>

            </div>
                        <!-- Medical Certificate Upload Card -->
                        <div id="medical_certificate_container" class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                <!-- Info Section inside Card -->
                                <div class="flex-1 text-center sm:text-left">
                                    <p class="text-gray-700 text-lg sm:text-base mb-1">
                                        Upload an image or PDF of your Medical Certificate.
                                    </p>
                                    <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                                        (Mag-upload ng larawan o PDF ng iyong Medical Certificate.)
                                    </p>
                                    <p class="text-gray-600 text-sm sm:text-base">
                                        Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                                    </p>

                                    <!-- File Info Display -->
                                    <div id="medDisplay" class="mt-2"></div>
                                </div>

                    <!-- Upload Button Section -->
                    <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-2">

                        <label
                            for="medFile"
                            class="block w-full text-center sm:inline-flex sm:w-auto justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-5 py-3 rounded-lg transition shadow-md"
                        >
                            📁 Choose File / Pumili ng File
                        </label>

                        <input id="medFile" name="medical_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden"/>

                        <!-- Upload error / validation -->
                        <div class="upload-error text-sm text-red-600"></div>

                    </div>
                </div>
            </div>

                                            <!-- Fit-To-Work Certificate Upload Card -->
                                            <!-- Fit-To-Work Info Section -->
                                            <div class="mt-6 text-left flex flex-col gap-2">

                                                <!-- Title  -->
                                                <div class="flex justify-between items-center">
                                                    <p class="font-semibold text-gray-800 text-sm sm:text-lg">
                                                        Please upload your Fit-To-Work Certificate.<span>⭐</span>
                                                    </p>
                                                    <!-- TTS Audio Button -->
                                                    <button type="button"
                                                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                                                        data-tts-en="Please upload your Fit-To-Work certificate issued within the last 3 months to confirm you are medically cleared to work."
                                                        data-tts-tl="I-upload ang Fit-To-Work certificate na inisyu sa loob ng nakaraang 3 buwan upang kumpirmahin na ikaw ay medikal na karapat-dapat magtrabaho.">
                                                        🔊
                                                    </button>
                                                </div>

                                                <p class="mt-2 text-gray-700 text-md">
                                                    Please upload a Fit-To-Work certificate issued within the last <strong>3 months</strong> to confirm you’re cleared and ready to work.
                                                </p>

                                                <p class="mt-1 text-gray-600 italic text-sm">
                                                    (I-upload ang Fit-To-Work certificate na inisyu sa loob ng nakaraang <strong>3 buwan</strong> upang kumpirmahin na ikaw ay handa at pinapayagang magtrabaho.)
                                                </p>

                                            </div>

                                            <div id="fit_certificate_container" class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm">

                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                                    <!-- Info Section inside Card -->
                                                    <div class="flex-1 text-center sm:text-left">
                                                        <p class="text-gray-700 text-lg sm:text-base mb-1">
                                                            Upload an image or PDF of your Fit-To-Work Certificate.
                                                        </p>
                                                        <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                                                            (Mag-upload ng larawan o PDF ng iyong Fit-To-Work Certificate.)
                                                        </p>
                                                        <p class="text-gray-600 text-sm sm:text-base">
                                                            Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                                                        </p>

                                                        <!-- File Info Display -->
                                                        <div id="fitDisplay" class="mt-2"></div>
                                                    </div>

                                        <!-- Upload Button Section -->
                                        <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-2">

                                            <label
                                                for="fitFile"
                                                id="fitLabel"
                                                class="block w-full text-center sm:inline-flex sm:w-auto justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-5 py-3 rounded-lg transition shadow-md"
                                            >
                                                📁 Choose File / Pumili ng File
                                            </label>

                                            <input id="fitFile" name="fit_to_work_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden"/>

                                            <div id="fitHint" class="text-gray-500 text-sm italic mt-1">Please upload your Fit-To-Work Certificate.</div>

                                            <!-- Upload error / validation -->
                                            <div class="upload-error text-sm text-red-600"></div>

                                        </div>
                                    </div>
                                </div>

                </div>
            </div>
        </div>

                            <script>
                            (function(){
                                function combineAddressFields(){
                                    try{
                                        const parts = [];
                                        const n = document.getElementById('address_number');
                                        const s = document.getElementById('address_street');
                                        const b = document.getElementById('address_barangay');
                                        const c = document.getElementById('address_city');
                                        if(n && n.value.trim()) parts.push(n.value.trim());
                                        if(s && s.value.trim()) parts.push(s.value.trim());
                                        if(b && b.value.trim()) parts.push(b.value.trim());
                                        if(c && c.value.trim()) parts.push(c.value.trim());
                                        const combined = parts.join(' ');
                                        const hidden = document.getElementById('address');
                                        if(hidden) hidden.value = combined;
                                        return combined;
                                    }catch(e){ console.warn('combineAddressFields error', e); return ''; }
                                }

                                function splitAddressToFields(addr){
                                    try{
                                        if(!addr) return;
                                        const n = document.getElementById('address_number');
                                        const s = document.getElementById('address_street');
                                        const b = document.getElementById('address_barangay');
                                        const c = document.getElementById('address_city');

                                        // If the stored address uses commas, prefer that splitting (legacy DB values)
                                        if(addr.indexOf(',') !== -1){
                                            const parts = addr.split(',').map(s=>s.trim()).filter(Boolean);
                                            if(parts.length===1){ if(c) c.value = parts[0]; }
                                            else if(parts.length===2){ if(b) b.value = parts[0]; if(c) c.value = parts[1]; }
                                            else if(parts.length===3){ if(s) s.value = parts[0]; if(b) b.value = parts[1]; if(c) c.value = parts[2]; }
                                            else { if(n) n.value = parts[0]; if(s) s.value = parts[1]; if(b) b.value = parts[2]; if(c) c.value = parts.slice(3).join(', '); }
                                            return;
                                        }

                                        // Heuristic for comma-less addresses: split into words and assign
                                        const words = addr.split(/\s+/).filter(Boolean);
                                        if(words.length<=1){ if(c) c.value = addr; return; }
                                        if(words.length<=4){
                                            // Map sequentially: number, street, barangay, city (fill what exists)
                                            if(n) n.value = words[0]||'';
                                            if(s) s.value = words[1]||'';
                                            if(b) b.value = words[2]||'';
                                            if(c) c.value = words[3]||'';
                                            return;
                                        }
                                        // >4 words: assume first token is number, last token(s) are city
                                        if(n) n.value = words[0];
                                        if(c) {
                                            const last = words[words.length-1];
                                            // include last 1-2 words for city if common suffix present
                                            if(words[words.length-1].toLowerCase()==='city' && words.length>=2){
                                                c.value = words[words.length-2] + ' ' + words[words.length-1];
                                            } else {
                                                c.value = last;
                                            }
                                        }
                                        // middle words -> street/barangay
                                        const middle = words.slice(1, words.length - 1);
                                        if(middle.length<=1){ if(s) s.value = middle.join(' '); }
                                        else if(middle.length===2){ if(s) s.value = middle[0]; if(b) b.value = middle[1]; }
                                        else { if(s) s.value = middle.slice(0, middle.length-1).join(' '); if(b) b.value = middle.slice(-1)[0]; }
                                    }catch(e){ console.warn('splitAddressToFields error', e); }
                                }

                                document.addEventListener('DOMContentLoaded', function(){
                                    try{
                                        // populate components if hidden combined address exists
                                        const hidden = document.getElementById('address');
                                        if(hidden && hidden.value) splitAddressToFields(hidden.value);

                                        // update hidden whenever any component changes
                                        ['address_number','address_street','address_barangay','address_city'].forEach(id=>{
                                            const el = document.getElementById(id);
                                            if(!el) return;
                                            el.addEventListener('input', combineAddressFields);
                                        });

                                        // ensure combined is set before form submit
                                        const form = document.getElementById('registrationForm');
                                        if(form){
                                            form.addEventListener('submit', function(ev){
                                                combineAddressFields();
                                            });
                                        }
                                    }catch(e){console.warn('address init failed', e);} 
                                });
                            })();
                            </script>


        {{-- <!-- Type of Congenital or Developmental Disability Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <!-- Text -->
            <div class="flex-1 text-center sm:text-left">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">
                    Congenital or Developmental Disability
                    <span class="text-red-500 text-sm">(required)</span>
                </h3>

                <p class="text-black-600 text-xs sm:text-sm leading-snug mt-1">
                    Please select the type of Congenital or Developmental Disability based on medical records or a doctor’s assessment.
                </p>

                <p class="text-gray-600 italic text-xs sm:text-sm leading-snug mt-4"> 
                    (Mangyaring piliin ang uri ng Congenital o Developmental Disability batay sa iyong mga medical record o pagsusuri ng doktor.)
                </p> 
            </div>

                <!-- Checkbox group + Others Input -->
            <div class="w-full sm:w-60 sm:mt-[10px]" id="cddType">
                <div class="space-y-2">
                    <label class="flex items-center gap-2"><input type="checkbox" name="cddType[]" value="Congenital Heart Defects" class="cdd-checkbox"> Congenital Heart Defects</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="cddType[]" value="Hearing/Vision" class="cdd-checkbox"> Hearing/Vision</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="cddType[]" value="Thyroid issues" class="cdd-checkbox"> Thyroid issues</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="cddType[]" value="Low Muscle Tone (Hypotonia)" class="cdd-checkbox"> Low Muscle Tone (Hypotonia)</label>
                    <label class="flex items-center gap-2"><input type="checkbox" id="cddTypeOtherChk" name="cddType[]" value="Others" class="cdd-checkbox"> Others</label>
                </div>

                <!-- Input for "Others" (toggled when checkbox checked) -->
                <input type="text" id="cddTypeOther" name="cddTypeOther" placeholder="Please specify"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-2 hidden focus:ring-blue-500 focus:border-blue-500" />

                <!-- hidden canonical value for legacy scripts -->
                <input type="hidden" id="cddTypeHidden" name="cddTypeHidden" value="" />
            </div>
        </div>

        <script>
            (function(){
                const checkboxes = Array.from(document.querySelectorAll('#cddType input.cdd-checkbox'));
                const otherChk = document.getElementById('cddTypeOtherChk');
                const otherInput = document.getElementById('cddTypeOther');
                const hidden = document.getElementById('cddTypeHidden');

                function updateHidden() {
                    const vals = checkboxes.filter(c=>c.checked).map(c=>String(c.value||'').trim()).filter(Boolean);
                    hidden.value = vals.join(', ');
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function(){
                        if (otherChk && otherChk.checked) {
                            otherInput.classList.remove('hidden'); otherInput.required = true;
                        } else {
                            otherInput.classList.add('hidden'); otherInput.required = false; if(otherInput) otherInput.value='';
                        }
                        updateHidden();
                    });
                });

                // ensure hidden sync on manual other input change too
                if (otherInput) otherInput.addEventListener('input', updateHidden);
            })();
        </script> --}}


            <!-- Parents / Guardian & Spouse Information Card -->
            <div class="section-card mt-8 bg-white rounded-xl shadow-md p-6 border border-gray-200">

                <h2 class="text-xl font-bold text-blue-600 mb-6">
                    Parents / Guardian Information
                </h2>

                <!-- ================= Parents / Guardian ================= -->
                <h3 class="text-lg font-semibold text-blue-700 mb-4">
                    Parent / Guardian 
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Last Name -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Last Name ⭐</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Apelyido</p>
                        <input id="guardian_last" name="g_last_name" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">First Name ⭐</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Unang Pangalan</p>
                        <input id="guardian_first" name="g_first_name" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Middle Name</label>
                        <p class="text-gray-500 flex italic text-sm mt-1"> Gitnang Pangalan (Opsyonal)</p>
                        <input id="guardian_middle" name="g_middle_name" type="text" placeholder="Middle Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Birthdate ⭐</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Petsa ng Kapanganakan</p>
                        <input id="guardian_birthdate" name="g_birthdate" type="date"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Relationship -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Relationship to Applicant ⭐</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Relasyon sa Applicant</p>
                        <select id="guardian_relationship" name="guardian_relationship"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring focus:ring-blue-200 focus:outline-none">
                            <option value="" disabled selected>Select Relationship</option>
                            <option>Father</option>
                            <option>Mother</option>
                            <option>Guardian</option>
                            <option>Relative</option>
                        </select>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Email ⭐</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Email</p>
                        <input id="guardian_email" name="g_email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Home Phone -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Home Phone No.</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Numero ng Telepono sa Bahay</p>
                        <input id="guardian_home_phone" name="g_home_phone" type="tel" placeholder="Home Phone"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Cellphone -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Cellphone No. ⭐</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Numero ng Cellphone</p>
                        <input id="guardian_phone" name="g_phone" type="tel" placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        <input id="GUARDIAN_CELL_NUMBER" name="GUARDIAN_CELL_NUMBER" type="hidden" value="" />
                    </div>

                    <!-- Work Phone -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Work Phone No.</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Numero ng Telepono sa Trabaho</p>
                        <input id="guardian_work_phone" name="g_work_phone" type="tel" placeholder="Work Phone"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                </div>

                <!-- Work Address -->
                <div class="mt-6">
                    <label class="font-semibold flex items-center gap-1">Work Address</label>
                    <p class="text-gray-500 flex italic text-sm mt-1">Adress ng Trabaho</p>
                    <input id="guardian_work_address" name="g_work_address" type="text" placeholder="Work Address"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>

                <!-- Divider -->
                <div class="border-t my-8"></div>

                <!-- ================= Spouse ================= -->
                <h3 class="text-lg font-semibold text-blue-700 mb-4">
                   Parent / Guardian Spouse Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Last Name -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Last Name</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Apelyido</p>
                        <input id="spouse_last" name="spouse_last" type="text" placeholder="Last Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">First Name</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Unang Pangalan</p>
                        <input id="spouse_first" name="spouse_first" type="text" placeholder="First Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Middle Name</label>
                        <p class="text-gray-500 flex italic text-sm mt-1"> Gitnang Pangalan (Opsyonal)</p>
                        <input id="spouse_middle" name="spouse_middle" type="text" placeholder="Middle Name"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Birthdate</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Petsa ng Kapanganakan</p>
                        <input id="spouse_birthdate" name="spouse_birthdate" type="date"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Relationship -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Relationship to Applicant</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Relasyon sa Applicant</p>
                        <select id="spouse_relationship" name="spouse_relationship"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring focus:ring-blue-200 focus:outline-none">
                            <option value="" disabled selected>Select Relationship</option>
                            <option>Father</option>
                            <option>Mother</option>
                            <option>Guardian</option>
                            <option>Relative</option>
                        </select>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Email</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Email</p>
                        <input id="spouse_email" name="spouse_email" type="email" placeholder="Email"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Cellphone -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Cellphone No.</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Numero ng Cellphone</p>
                        <input id="spouse_phone" name="spouse_phone" type="tel" placeholder="+63 9XX XXX XXXX"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Home Phone -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Home Phone No.</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Numero ng Telepono sa Bahay</p>
                        <input id="spouse_home_phone" name="spouse_home_phone" type="tel"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- Work Phone -->
                    <div>
                        <label class="font-semibold flex items-center gap-1">Work Phone No.</label>
                        <p class="text-gray-500 flex italic text-sm mt-1">Numero ng Telepono sa Trabaho</p>
                        <input id="spouse_work_phone" name="spouse_work_phone" type="tel"
                            class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                </div>

                <!-- Work Address -->
                <div class="mt-6">
                    <label class="font-semibold flex items-center gap-1">Work Address</label>
                    <p class="text-gray-500 flex italic text-sm mt-1">Adress ng Trabaho</p>
                    <input id="spouse_work_address" name="spouse_work_address" type="text" placeholder="Work Address"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>

            </div>

            <!-- Account Details -->
             <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Section Title -->
                <div class="mb-4">
                    <h3 class="text-xl sm:text-2xl font-bold text-blue-600">
                       Account Details
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="font-semibold flex items-center gap-1">Username
                            <span>⭐</span></label>
                        <input id="username" name="username" type="text" placeholder="Enter your username"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                        <p class="text-gray-500 flex italic text-sm mt-1">(example: @juancruz)</p>
                    </div>

                    <!-- Create Password -->
                    <div>
                        <label for="password" class="font-semibold flex items-center gap-1">Create Password
                            <span>⭐</span></label>
                        <input   id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="Enter your password"
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                                    title="Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and be 8+ characters long."
                                    class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                            <p id="passwordMessage" class="mt-1 text-sm text-red-500 italic hidden">
                                Password must have at least 1 uppercase, 1 lowercase, 1 number, and be 8+ characters long.
                            </p>
                            <label class="flex gap-2 text-sm text-gray-700 cursor-pointer mt-2">
                                <input id="showCreatePassword" type="checkbox" class="h-4 w-4" />
                                <span>Show password</span>
                            </label>
                            <div id="passwordSuccess" class="mt-1 text-sm text-green-600 hidden">✅ Strong password. Ready to go!</div>
                    </div>
                </div>
                 

                <!-- Password Rules -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mt-6 text-sm gap-6 shadow-inner">
                    <!-- English -->
                    <div>
                        <p class="font-semibold text-blue-700 mb-2 flex items-center gap-2">English <button
                            type="button"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
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
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
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
                    <label class="flex gap-2 text-sm text-gray-700 cursor-pointer mt-2">
                        <input id="showConfirmPassword" type="checkbox" class="h-4 w-4" />
                        <span>Show password</span>
                    </label>
                </div>
                  <p id="confirmMessage" class="mt-1 text-sm text-red-500 italic hidden">
                    Passwords do not match.
                </p>
            </div>

{{-- 
<!-- Proof of Membership -->
<div class="mt-8 text-left px-2 sm:px-4">
  <label class="font-semibold text-base sm:text-lg flex items-center gap-2">
    Proof of DSAPI Membership <span class="text-[#4B5258] text-m">(optional)</span>
    <button 
      type="button" 
      class="text-lg sm:text-2xl hover:scale-110 transition-transform tts-btn"
      data-tts-en="Proof of DSAPI Membership"
      data-tts-tl="Patunay ng pagiging miyembro ng DSAPI"
    >🔊</button>
  </label>

  <p class="text-gray-600 italic text-sm sm:text-base mb-2">(Patunay ng pagiging miyembro ng DSAPI)</p>

  <!-- Upload Section -->
  <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div class="flex-1 text-center sm:text-left">
    <p class="font-medium text-gray-800 text-sm sm:text-base">
      <span id="proofLabel" class="flex items-center gap-2">
        <span>Upload Proof (Image or PDF)</span> 
      </span>
    </p>
    <p id="proofHint" class="text-gray-600 italic text-xs sm:text-sm mt-1">
      (Mag-upload ng larawan o PDF bilang patunay ng pagiging miyembro.)<br /><br />
      Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b><br />
    </p> 

    <!-- File Info Display -->
    <div id="proofDisplay"></div>
  </div>

  <!-- Upload button + input wrapped so validation message is appended below the button -->
  <div class="flex-shrink-0 flex flex-col items-center sm:items-end space-y-2">
    <label
      for="proofFile"
      class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition"
    >
      📁 Choose File / Pumili ng File
    </label>
    <input id="proofFile" name="proof" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden" />
    <!-- showFieldError appends .field-error to the input's parent — this ensures it's placed under the button -->
    <div class="upload-error w-full text-sm text-right"></div>
  </div>
</div>
--}}



<script>
function validateMedicalCertificateDate(dateString, errorContainer, label) {
    // label: optional friendly name for the certificate (e.g. 'Fit-To-Work certificate')
    label = typeof label === 'string' && label ? label : 'Medical certificate';
    if (!dateString) {
        if (errorContainer) errorContainer.textContent = `Unable to detect the ${label.toLowerCase()} date.`;
        return false;
    }
    const today = new Date();
    const certDate = new Date(dateString);
    
    // Add 3 months to certificate date
    const expiryDate = new Date(certDate);
    expiryDate.setMonth(expiryDate.getMonth() + 3);
    
    if (today > expiryDate) {
        if (errorContainer) errorContainer.textContent = `${label} must be within 3 months only.`;
        return false;
    } 
    else {
        if (errorContainer) errorContainer.textContent = "";
        alert(`${label} is valid!`);
        return true; 
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setupUpload('proofFile', 'proofDisplay', 'proofLabel', 'proofHint');
    setupUpload('pwdidFile', 'pwdidDisplay', 'pwdidLabel', 'pwdidHint');
    setupUpload('medFile', 'medDisplay', 'medLabel', 'medHint');
    setupUpload('fitFile', 'fitDisplay', 'fitLabel', 'fitHint');
    try {
        const createToggle = document.getElementById('showCreatePassword');
        if (createToggle) {
            createToggle.addEventListener('change', function(e){
                const show = !!e.target.checked;
                try { const el = document.getElementById('password'); if (el) el.type = show ? 'text' : 'password'; } catch(e){}
            });
        }
        const confirmToggle = document.getElementById('showConfirmPassword');
        if (confirmToggle) {
            confirmToggle.addEventListener('change', function(e){
                const show = !!e.target.checked;
                try { const el = document.getElementById('confirmPassword'); if (el) el.type = show ? 'text' : 'password'; } catch(e){}
            });
        }
    } catch(e) { console.warn('showPassword init failed', e); }
    // password strength hint
    try {
        const pwd = document.getElementById('password');
        const pwdMsg = document.getElementById('passwordMessage');
        const pwdSuccess = document.getElementById('passwordSuccess');
        if (pwd) {
            const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
            pwd.addEventListener('input', function(e){
                try {
                    const val = String(e.target.value || '');
                    if (re.test(val)) {
                        if (pwdSuccess) pwdSuccess.classList.remove('hidden');
                        if (pwdMsg) pwdMsg.classList.add('hidden');
                    } else {
                        if (pwdSuccess) pwdSuccess.classList.add('hidden');
                        // show rule message only when there's input
                        if (pwdMsg) {
                            if (val.trim().length) pwdMsg.classList.remove('hidden'); else pwdMsg.classList.add('hidden');
                        }
                    }
                } catch(e) {}
            });
        }
    } catch(e) { console.warn('password hint init failed', e); }
});

// NOTE: Preview handling for uploads is centralized in `setupUpload()` above.
// The legacy/createUploadCard logic has been removed to avoid duplicate previews.

// Format a date-like value into 'Month DD, YYYY', e.g. 'February 12, 2026'
window.formatDateWords = function(raw) {
    if (!raw && raw !== 0) return '';
    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    try {
        const d = new Date(raw);
        if (!Number.isNaN(d.getTime())) {
            const dd = d.getDate();
            const mm = months[d.getMonth()];
            const yyyy = d.getFullYear();
            return `${mm} ${dd}, ${yyyy}`;
        }
    } catch(e) {}
    const m = String(raw).match(/^(\d{4})-(\d{2})-(\d{2})/);
    if (m) {
        const yyyy = m[1];
        const mmIdx = parseInt(m[2],10) - 1;
        const dd = parseInt(m[3],10);
        const mm = months[mmIdx] || m[2];
        return `${mm} ${dd}, ${yyyy}`;
    }
    return String(raw).slice(0,10);
}

// Apply OCR'd AI data into matching form fields when possible
function applyOcrDataToForm(aiData, detectedType, ocrtype) {
    try {
        if (!aiData || typeof aiData !== 'object') return;

        // Name -> first / last (accept either `name` or separate `first_name`/`last_name`)
        if (aiData.first_name || aiData.last_name) {
            const firstEl = document.getElementById('first_name');
            const lastEl = document.getElementById('last_name');
            if (firstEl && aiData.first_name) firstEl.value = String(aiData.first_name).trim();
            if (lastEl && aiData.last_name) lastEl.value = String(aiData.last_name).trim();
            // if full name is provided too, only fill missing pieces
            if ((firstEl && !firstEl.value) || (lastEl && !lastEl.value)) {
                if (aiData.name) {
                    const full = String(aiData.name).trim();
                    const parts = full.split(/\s+/);
                    if (parts.length) {
                        if (firstEl && !firstEl.value) firstEl.value = parts[0] || '';
                        if (lastEl && !lastEl.value) lastEl.value = parts.slice(1).join(' ') || '';
                    }
                }
            }
        } else if (aiData.name) {
            const full = String(aiData.name).trim();
            const parts = full.split(/\s+/);
            if (parts.length) {
                const firstEl = document.getElementById('first_name');
                const lastEl = document.getElementById('last_name');
                if (firstEl) firstEl.value = parts[0] || '';
                if (lastEl) lastEl.value = parts.slice(1).join(' ') || '';
            }
        }

        // Date of birth -> birthdate input (try multiple keys)
        const dob = aiData.date_of_birth || aiData.birthdate || aiData.dob || aiData.birthday;
        if (dob) {
            const parsed = new Date(dob);
            if (!Number.isNaN(parsed.getTime())) {
                const yyyy = parsed.getFullYear();
                const mm = String(parsed.getMonth() + 1).padStart(2, '0');
                const dd = String(parsed.getDate()).padStart(2, '0');
                const el = document.getElementById('birthdate');
                if (el) el.value = `${yyyy}-${mm}-${dd}`;
            }
        }

        // Phone
        const phone = aiData.phone || aiData.mobile || aiData.contact;
        if (phone) {
            const el = document.getElementById('phone');
            if (el) {
                // naive normalization: keep digits and leading +
                const normalized = String(phone).replace(/[^\d+]/g, '');
                el.value = normalized;
            }
        }

        // Email
        const email = aiData.email || aiData.e_mail || aiData.mail;
        if (email) {
            const e = document.getElementById('email') || document.querySelector('[name="email"]');
            if (e) e.value = String(email).trim();
        }

        // ID / card number -> try filling commonly-named fields
        const idVal = aiData.id_number || aiData.id_no || aiData.idno || aiData.id || aiData.number || aiData.card_number || aiData.pwd_number || aiData.identity_number || aiData.identification_number;
        if (idVal) {
            const tryIds = ['id_number','idno','id_no','pwd_number','pwd_id_number','identification_number','identity_number','card_number','id'];
            for (const tid of tryIds) {
                try {
                    const el = document.getElementById(tid);
                    if (el) { el.value = String(idVal); }
                } catch(e){}
            }
            // also try common name attributes
            const tryNames = ['id_number','pwd_id','pwd_id_number','identification_number','idno'];
            for (const nm of tryNames) {
                try {
                    const el2 = document.querySelector(`[name="${nm}"]`);
                    if (el2) el2.value = String(idVal);
                } catch(e){}
            }
        }

        // Address → try to fill common address inputs (address, street, barangay, city)
        if (aiData.address) {
            const raw = String(aiData.address).trim();
            // primary full address field
            const fullEl = document.getElementById('address') || document.querySelector('[name="address"]');
            if (fullEl) fullEl.value = raw;

            // try splitting by commas to populate smaller fields
            const parts = raw.split(/,|\n/).map(s => s.trim()).filter(Boolean);
            if (parts.length) {
                // heuristics: last part often city/province, first part house/street
                const street = parts[0] || '';
                const city = parts.length > 1 ? parts[parts.length - 1] : '';
                const barangay = parts.length > 2 ? parts[parts.length - 2] : '';

                const streetEl = document.getElementById('street') || document.getElementById('address_street') || document.querySelector('[name="street"]') || null;
                const barangayEl = document.getElementById('barangay') || document.querySelector('[name="barangay"]') || null;
                const cityEl = document.getElementById('city') || document.getElementById('municipality') || document.querySelector('[name="city"]') || null;

                if (streetEl && streetEl.value === '') streetEl.value = street;
                if (barangayEl && barangayEl.value === '') barangayEl.value = barangay;
                if (cityEl && cityEl.value === '') cityEl.value = city;
            }
        }

        // Disability -> intelligent mapping:
        // - If AI mentions Down syndrome (trisomy/mosaic/translocation), map to `dsType` select
        // - Otherwise, attempt to match `cddType`; fallback to `Others` with text placed in cddTypeOther
        if (aiData.type_of_disability || aiData.disability) {
            const rawVal = String(aiData.type_of_disability || aiData.disability).trim();
            const val = rawVal.toLowerCase();

            // keywords that indicate Down Syndrome
            const dsKeywords = ['trisomy', 'trisomy 21', 'down syndrome', 'mosaic', 'translocation', 'downs'];

            const dsSelect = document.getElementById('dsType');
            const cddContainer = document.getElementById('cddType');
            const cddOther = document.getElementById('cddTypeOther');

            // if mentions DS, try to set dsType
            const mentionsDs = dsKeywords.some(k => val.includes(k));
            if (mentionsDs && dsSelect) {
                let set = false;
                for (let i = 0; i < dsSelect.options.length; i++) {
                    const opt = dsSelect.options[i];
                    if (!opt.value) continue;
                    const ov = opt.value.toLowerCase();
                    if (val.includes('trisomy') && ov.includes('trisomy')) { dsSelect.value = opt.value; set = true; break; }
                    if (val.includes('mosaic') && ov.includes('mosaic')) { dsSelect.value = opt.value; set = true; break; }
                    if (val.includes('translocation') && ov.includes('translocation')) { dsSelect.value = opt.value; set = true; break; }
                    if (ov.includes('down') && val.includes('down')) { dsSelect.value = opt.value; set = true; break; }
                }
                if (!set) {
                    // no exact match — try to pick first ds option
                    if (dsSelect.options.length > 1) dsSelect.selectedIndex = 1;
                }

                // if we matched to dsType, clear any cddOther
                if (cddOther) { cddOther.classList.add('hidden'); cddOther.required = false; cddOther.value = ''; }
            } else if (cddContainer) {
                // try to match CDD checkbox options
                const boxes = Array.from(cddContainer.querySelectorAll('input[type="checkbox"][name="cddType[]"]'));
                let matched = false;
                for (const b of boxes) {
                    try{
                        const ov = String(b.value||'').toLowerCase();
                        if (!ov) continue;
                        if (ov.includes(val) || val.includes(ov) || ov.split(/\W+/).some(tok => val.includes(tok))) {
                            b.checked = true; matched = true; // keep searching to allow multiple matches
                        }
                    }catch(e){}
                }
                if (!matched && cddOther) {
                    const otherChk = document.getElementById('cddTypeOtherChk'); if (otherChk) otherChk.checked = true;
                    cddOther.classList.remove('hidden');
                    cddOther.required = true;
                    cddOther.value = rawVal;
                }
            }
        }

        // For membership proofs, show small summary in proofDisplay
        if (detectedType === 'membership_proof' && (typeof aiData.is_membership !== 'undefined')) {
            const disp = document.getElementById('proofDisplay');
            if (disp) {
                disp.innerHTML = `<div class="mt-2 text-sm text-green-700">Membership Detected: ${aiData.is_membership ? 'Yes' : 'No'}${aiData.member_name ? ' — ' + aiData.member_name : ''}</div>`;
            }
        }

        // For PWD ID OCR, show detected Type of Disability under the PWD display (like med date)
        if (detectedType === 'pwd_id' && aiData.type_of_disability) {
            const pd = document.getElementById('pwdidDisplay');
            const txt = String(aiData.type_of_disability || '');
            if (pd) {
                const prev = pd.querySelector('.ocr-summary');
                if (prev) prev.textContent = `Detected Disability: ${txt}`;
                else pd.insertAdjacentHTML('beforeend', `<div class="ocr-summary mt-2 text-sm text-gray-700">Detected Disability: ${txt}</div>`);
            }
            // Persist detected disability so back-side uploads can include it if DOM isn't available
            try { localStorage.setItem('admin_uploaded_pwd_detected', txt); } catch(e) {}
        }

        // For medical certificate, show detected exam date in medDisplay (formatted)
        if (detectedType === 'medical_certificate' && aiData.date) {
            const md = document.getElementById('medDisplay');
            if (md) {
                // format using helper if available
                let raw = aiData.date || '';
                let txt = (window.formatDateWords ? window.formatDateWords(raw) : String(raw).slice(0,10));
                const prev = md.querySelector('.ocr-summary');
                if (prev) prev.textContent = `Detected Medical Date: ${txt}`;
                else md.insertAdjacentHTML('beforeend', `<div class="ocr-summary mt-2 text-sm text-gray-700">Detected Medical Date: ${txt}</div>`);
            }
        }

    } catch (e) {
        console.warn('applyOcrDataToForm failed', e);
    }
}

function setupUpload(inputId, displayId, labelId, hintId) {
  const fileInput = document.getElementById(inputId);
  const display = document.getElementById(displayId);
  const labelEl = document.getElementById(labelId);
  const hintEl = document.getElementById(hintId);
  const modal = document.getElementById('fileModal');
  const modalContent = document.getElementById('modalContent');
  const closeModalBtn = document.getElementById('closeModalBtn');

  let fileURL = null;

  if (!fileInput) return;

        // remember original label text so resetDisplay can restore it
        try { if (labelEl && typeof labelEl.dataset !== 'undefined') labelEl.dataset.original = labelEl.textContent || labelEl.dataset.original || 'Upload File'; } catch(e){}

        // determine storage keys for this input (used both on change and on init)
        let nameKey, dataKey, typeKey;
        if (String(inputId).toLowerCase().includes('proo')) {
            nameKey = 'admin_uploaded_proof_name';
            dataKey = 'admin_uploaded_proof_data';
            typeKey = 'admin_uploaded_proof_type';
        } else if (String(inputId).toLowerCase().includes('pwdid') || String(inputId).toLowerCase().includes('pwdidfile')) {
            nameKey = 'admin_uploaded_pwd_name';
            dataKey = 'admin_uploaded_pwd_data';
            typeKey = 'admin_uploaded_pwd_type';
        } else {
            nameKey = 'admin_uploaded_med_name';
            dataKey = 'admin_uploaded_med_data';
            typeKey = 'admin_uploaded_med_type';
        }

        // If storage already contains a previously-uploaded file, render its preview on init
        // NOTE: we intentionally skip auto-restoring previews for PWD ID and Medical Certificate
        // inputs so a page refresh won't show previously-uploaded previews for those sensitive fields.
                try {
            if (!/pwdidfile|\bpwdid\b|medfile|fitfile/i.test(String(inputId))) {
                const storedName = localStorage.getItem(nameKey);
                const storedData = localStorage.getItem(dataKey);
                const storedType = localStorage.getItem(typeKey);
                if (storedName && storedData) {
                    const ext = (storedName.split('.').pop() || '').toLowerCase();
                    const icon = ['jpg', 'jpeg', 'png'].includes(ext) ? '🖼️'
                                         : ext === 'pdf' ? '📄'
                                         : '📁';

                                            // show display block (responsive markup)
                                        display.innerHTML = `
                                                <div class="w-full bg-white border border-gray-200 rounded-lg px-3 py-3 shadow-sm mt-3">
                                                    <div class="flex flex-col sm:flex-row items-center sm:items-center justify-between gap-3">
                                                        <div class="flex items-center gap-3">
                                                            <div class="thumb">${['jpg','jpeg','png'].includes(ext) ? `<img src="${storedData}" alt="${storedName}" class="max-w-[110px] max-h-[88px] rounded-md object-cover">` : `<div class="pdf-icon inline-flex items-center justify-center w-[80px] h-[64px] bg-[#eff6ff] text-[#1e40af] font-bold rounded-md">PDF</div>`}</div>
                                                            <div class="filename text-sm text-gray-700 break-words max-w-full">${storedName}</div>
                                                        </div>
                                                        <div class="flex gap-2 mt-2 sm:mt-0">
                                                            <button type="button" class="viewBtn bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
                                                            <button type="button" class="removeBtn bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button>
                                                        </div>
                                                    </div>
                                                </div>
                                        `;

                    const viewBtn = display.querySelector('.viewBtn');
                    const removeBtn = display.querySelector('.removeBtn');
                    if (viewBtn) viewBtn.addEventListener('click', (e) => { e.preventDefault(); openModal(storedData, ext); });
                    if (removeBtn) removeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        resetDisplay();
                        try { fileInput.value = ''; } catch(e){}
                        localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey);
                        try { cleanupUploadedFileByName(storedName); } catch(e){}
                    });

                    if (labelEl) { labelEl.textContent = 'File Uploaded:'; }
                    if (hintEl) { hintEl.style.display = 'none'; }
                }
            }
        } catch(e){}

  // --------------------------------------------------------------------
  // ⭐ Robust cleanup helper (your requested fix)
  // --------------------------------------------------------------------
  function cleanupUploadedFileByName(filename) {
    try {
      const name = String(filename || '').trim();

            const keys = [
                // admin
                'admin_uploaded_proof_name','admin_uploaded_proof_data','admin_uploaded_proof_type',
                'admin_uploaded_pwd_name','admin_uploaded_pwd_data','admin_uploaded_pwd_type',
                'admin_uploaded_med_name','admin_uploaded_med_data','admin_uploaded_med_type',

        // legacy single-file
        'uploadedProofName','uploadedProofData','uploadedProofType',
        'uploadedProofName1','uploadedProofData1','uploadedProofType1',
        'uploadedProofName0','uploadedProofData0','uploadedProofType0',
        'uploaded_proof_name','uploaded_proof_data','uploaded_proof_type',
        'proofName','proofData','proofType','proofFilename',
        // pwd variants
        'uploaded_pwd_name','uploaded_pwd_data','uploaded_pwd_type','pwdName','pwdData','pwdType','pwdFilename',

        // review keys
        'review_certfile','review_certs_file','review_certfile_name','review_certs_name'
      ];

      keys.forEach(k => {
        try { localStorage.removeItem(k); sessionStorage.removeItem(k); } catch {}
      });

      // Array-based uploaded items
      const arrayKeys = [
        'uploadedProofs1',
        'uploadedProofs',
        'uploadedProofs_proof',
        'uploadedProofs_med'
      ];

      arrayKeys.forEach(k => {
        try {
          const raw = localStorage.getItem(k);
          if (!raw) return;

          const arr = JSON.parse(raw || '[]');
          if (!Array.isArray(arr)) return;

          const filtered = arr.filter(it => {
            const iname = (it && (it.name || it.filename)) ? String(it.name || it.filename) : '';
            return name ? iname !== name : true;
          });

          localStorage.setItem(k, JSON.stringify(filtered));
        } catch {}
      });

      console.info('[cleanup] removed legacy/admin keys and pruned arrays for', name || '<unknown>');
    } catch (e) {
      console.warn('[cleanup] error', e);
    }
  }

    // These variables should live in the same scope as fileInput, display, labelEl, hintEl, etc.
    let isProcessing = false;
    let currentFileURL = null;
    let lastChangeTime = 0;

    function safeSetText(el, txt) {
        try { if (el) el.textContent = txt; } catch (e) { console.warn('safeSetText failed', e); }
    }

    if (!fileInput.dataset.changeListenerAttached) {
        fileInput.addEventListener('change', async function (e) {
            const now = Date.now();

            // ── Guard 1: already processing ────────────────────────────────
            if (isProcessing) {
                console.log("[upload-guard] Already processing – skipped");
                return;
            }

            // ── Guard 2: too soon after last change (prevents double-fire) ──
            if (now - lastChangeTime < 300) {
                console.log("[upload-guard] Change event too soon (<300ms) – ignored");
                return;
            }
            lastChangeTime = now;

            isProcessing = true;
            console.log("[upload] Change event started", new Date().toISOString());

                try {
                const files = Array.from(fileInput.files || []);
                const file = files[0];
                if (!file) {
                    resetDisplay();
                    return;
                }

                // Clean up old object URL
                if (currentFileURL) {
                    URL.revokeObjectURL(currentFileURL);
                }
                currentFileURL = URL.createObjectURL(file);

                const ext = file.name.split('.').pop().toLowerCase();
                const icon = ['jpg', 'jpeg', 'png'].includes(ext) ? '🖼️'
                        : ext === 'pdf' ? '📄'
                        : '📁';

                const namesList = files.map(f => f.name).join(', ');

                                display.innerHTML = `
                                        <div class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm mt-3">
                                            <div class="flex flex-col sm:flex-row items-center sm:items-center justify-between gap-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-2xl">${icon}</span>
                                                    <span class="text-sm text-gray-700 break-words max-w-[240px]">${namesList}</span>
                                                </div>
                                                <div class="flex gap-2 mt-2 sm:mt-0">
                                                    <button type="button" class="viewBtn bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
                                                    <button type="button" class="removeBtn bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button>
                                                </div>
                                            </div>
                                        </div>
                                `;

                // Determine storage keys & OCR type
                let nameKey, dataKey, typeKey, ocrtype;
                if (String(inputId).toLowerCase().includes('proo')) {
                    nameKey = 'admin_uploaded_proof_name';
                    dataKey = 'admin_uploaded_proof_data';
                    typeKey = 'admin_uploaded_proof_type';
                    ocrtype = 'membership_proof';
                } else if (String(inputId).toLowerCase().includes('pwdid') || String(inputId).toLowerCase().includes('pwdidfile')) {
                    nameKey = 'admin_uploaded_pwd_name';
                    dataKey = 'admin_uploaded_pwd_data';
                    typeKey = 'admin_uploaded_pwd_type';
                    ocrtype = 'pwd_id';
                } else if (String(inputId).toLowerCase().includes('fit') || /fitfile/i.test(String(inputId))) {
                    nameKey = 'admin_uploaded_fit_name';
                    dataKey = 'admin_uploaded_fit_data';
                    typeKey = 'admin_uploaded_fit_type';
                    ocrtype = 'fit_to_work';
                } else {
                    nameKey = 'admin_uploaded_med_name';
                    dataKey = 'admin_uploaded_med_data';
                    typeKey = 'admin_uploaded_med_type';
                    ocrtype = 'medical_certificate';
                }

                // Read file as Data URL
                const dataUrl = await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = () => reject(reader.error || new Error("FileReader failed"));
                    reader.readAsDataURL(file);
                });

                console.log("[upload] File read completed");

                // Save to localStorage
                localStorage.setItem(nameKey, file.name);
                localStorage.setItem(dataKey, dataUrl);
                localStorage.setItem(typeKey, ext);
                console.info('[adminapprove] saved upload to localStorage', nameKey);

                // Create and show loading indicator
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'ocr-loading-container';
                loadingDiv.id = `ocr-loading-${inputId}`;
                loadingDiv.innerHTML = `
                    <div class="ocr-spinner"></div>
                    <span class="ocr-loading-text">Processing OCR... Please wait</span>
                `;
                display.appendChild(loadingDiv);

                // Prepare and send to backend
                const payload = {
                    type: ocrtype,
                    ocr_name: file.name,
                    ocr_data: dataUrl,
                    ocr_type: ext
                };

                // If this is the BACK side of a PWD ID upload and the front side
                // already detected a disability, include that info so the server
                // will accept a back-only upload. We look for an existing
                // `.ocr-summary` rendered by previous OCR runs.
                try {
                    // If this appears to be a BACK side upload (either id name included 'back' or
                    // the filename hints at 'back'), include previously-detected disability info.
                    if (ocrtype === 'pwd_id' && (String(inputId).toLowerCase().includes('back') || /\bback|backside|rear|_b\b|\-b\b/i.test(file.name))) {
                        // Prefer the visible summary in the shared display, then front/back containers,
                        // then fall back to any persisted detection in localStorage.
                        let prev = null;
                        const candidates = [ document.getElementById('pwdidDisplay') ];
                        for (const el of candidates) {
                            try {
                                if (!el) continue;
                                const summary = el.querySelector('.ocr-summary');
                                if (summary && String(summary.textContent||'').trim()) {
                                    const txt = String(summary.textContent||'').trim();
                                    const m = txt.match(/Detected\s*Disability\s*:\s*(.+)/i);
                                    prev = m ? m[1].trim() : (txt || null);
                                    if (prev) break;
                                }
                            } catch (e) { /* ignore per-element errors */ }
                        }
                        // fallback to persisted value if DOM had nothing
                        if (!prev) {
                            try { const stored = localStorage.getItem('admin_uploaded_pwd_detected'); if (stored) prev = stored; } catch(e) {}
                        }
                        if (prev) {
                            payload.previous_disability = prev;
                            payload.previous_disability_source = 'front';
                            console.info('[upload] Attaching previous_disability to payload:', prev);
                        }
                    }
                } catch (e) { console.warn('previous_disability attach failed', e); }

                console.log("[upload] Sending OCR request for:", file.name);
                // debugger;   // ← keep if you need to inspect payload

                let response;
                try {
                    response = await fetch('db/ocr-validation.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });
                } catch (fetchErr) {
                    // Remove loading indicator on network error
                    const loading = document.getElementById(`ocr-loading-${inputId}`);
                    if (loading) loading.remove();
                    console.error('[upload] Fetch failed:', fetchErr);
                    alert('Network error: Failed to connect to OCR service');
                    isProcessing = false;
                    return;
                }

                let result;
                try {
                    result = await response.json();
                } catch (jsonErr) {
                    // Remove loading indicator on JSON parse error
                    const loading = document.getElementById(`ocr-loading-${inputId}`);
                    if (loading) loading.remove();
                    console.warn("Invalid JSON from server", jsonErr);
                    result = { message: 'Invalid response format' };
                }

                if (response.ok) {
                    console.log('OCR Result:', result);

                    const detectedType = result.data?.ocrtype;
                    const aiData = result.data?.ai_data || {};

                    if (detectedType === 'pwd_id' && ocrtype === 'pwd_id') {
                        // Validate detected disability against selected form values.
                        let pwdDisplayEl = document.getElementById('pwdidDisplay');
                        let errorBox = null;
                        if (pwdDisplayEl) {
                            errorBox = pwdDisplayEl.querySelector('.ocr-error');
                            if (!errorBox) {
                                errorBox = document.createElement('div');
                                errorBox.className = 'ocr-error mt-2 text-sm text-red-600';
                                pwdDisplayEl.appendChild(errorBox);
                            }
                        } else {
                            errorBox = { textContent: '' };
                        }

                        // Prefer the AI-parsed disability, but fall back to the server-level
                        // `detected_disability` (set when OCR ran per-image). This covers
                        // cases where the model returned an `error` message but the
                        // server still detected a disability from another image.
                        if ((!aiData || !aiData.type_of_disability || String(aiData.type_of_disability).trim() === '') && result.data && result.data.detected_disability) {
                            try { if (!aiData) aiData = {}; aiData.type_of_disability = result.data.detected_disability; } catch(e){}
                        }
                        const detectedDisability = String(aiData.type_of_disability || aiData.disability || aiData.type || result.data?.detected_disability || '').trim();

                        // determine selected disability from form (supports checkbox group)
                        const dsSelectEl = document.getElementById('dsType');
                        const cddContainer = document.getElementById('cddType');
                        const cddOtherEl = document.getElementById('cddTypeOther');

                        const selectedDs = dsSelectEl && dsSelectEl.value ? String(dsSelectEl.value).trim() : '';
                        const selectedCddArr = cddContainer ? Array.from(cddContainer.querySelectorAll('input[name="cddType[]"]:checked')).map(x=>String(x.value||'').trim()).filter(Boolean) : [];
                        const selectedCddOther = cddOtherEl && cddOtherEl.value ? String(cddOtherEl.value).trim() : '';

                        function normalize(s){ return String(s||'').toLowerCase(); }
                        function matchesSelected(det) {
                            if (!det) return false;
                            const d = normalize(det);
                            // check Down Syndrome keywords first
                            const dsKeywords = ['trisomy','trisomy 21','down syndrome','downs','mosaic','translocation'];
                            if (selectedDs) {
                                const sd = normalize(selectedDs);
                                // if user selected any dsType, ensure AI mentions DS keywords
                                if (dsKeywords.some(k => d.includes(k) || sd.includes(k))) return true;
                                if (sd.includes('down') && d.includes('down')) return true;
                                return false;
                            }

                            if (selectedCddArr && selectedCddArr.length) {
                                // prefer explicit non-Others selections
                                const nonOther = selectedCddArr.filter(x=>String(x||'').toLowerCase()!=='others');
                                const candidates = nonOther.length ? nonOther : (selectedCddOther ? [selectedCddOther] : []);
                                for(const scRaw of candidates){
                                    const sc = normalize(scRaw);
                                    if (!sc) continue;
                                    if (d.includes(sc) || sc.includes(d)) return true;
                                    const toks = sc.split(/\W+/).filter(Boolean);
                                    if (toks.some(t => d.includes(t))) return true;
                                }
                                return false;
                            }

                            if (selectedCddOther) {
                                const sc = normalize(selectedCddOther);
                                if (d.includes(sc) || sc.includes(d)) return true;
                                const toks2 = sc.split(/\W+/).filter(Boolean);
                                if (toks2.some(t => d.includes(t))) return true;
                                return false;
                            }
                            // If no selection to compare to, accept if AI provided a disability string
                            return !!detectedDisability;
                        }

                        const isMatch = matchesSelected(detectedDisability);

                        if (!isMatch) {
                            // Don't block the upload for missing/mismatched disability — treat as a bonus.
                            let warnMsg;
                            if (!detectedDisability) {
                                warnMsg = 'No disability detected in the uploaded PWD ID. The upload will still be accepted and any extracted info will be applied.';
                            } else {
                                warnMsg = `Detected disability "${detectedDisability}" does not match the selected disability. The upload will still be accepted; please review the extracted info.`;
                            }
                            if (errorBox) errorBox.textContent = warnMsg;
                            try { console.warn('[upload] Non-blocking PWD mismatch:', warnMsg); } catch(e){}
                            try { const loading = document.getElementById(`ocr-loading-${inputId}`); if (loading) loading.remove(); } catch(e){}
                            // continue (do not reject)
                        }

                        // If match, autofill and persist
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        // Remove loading indicator
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        if (pwdDisplayEl) {
                            const _e = pwdDisplayEl.querySelector('.ocr-error');
                            if (_e) _e.textContent = '';
                        }
                        alert(`Disability: ${aiData.type_of_disability || '?'}  OCR Type: ${detectedType} processed successfully.`);
                    } else if (detectedType === 'fit_to_work' && ocrtype === 'fit_to_work') {
                        // Fit-To-Work specific handling: require explicit fit-to-work text/statement
                        let fitDisplayEl = document.getElementById('fitDisplay') || document.getElementById('medDisplay');
                        let errorBox = null;
                        if (fitDisplayEl) {
                            errorBox = fitDisplayEl.querySelector('.ocr-error');
                            if (!errorBox) {
                                errorBox = document.createElement('div');
                                errorBox.className = 'ocr-error mt-2 text-sm text-red-600';
                                fitDisplayEl.appendChild(errorBox);
                            }
                        } else {
                            errorBox = { textContent: '' };
                        }

                        // Check server-side flag for 'Fit to Work' presence
                        const containsFit = Boolean(result.data && result.data.contains_fit_to_work);

                        if (!containsFit) {
                            const loading = document.getElementById(`ocr-loading-${inputId}`);
                            if (loading) loading.remove();
                            if (errorBox) errorBox.textContent = "Fit-To-Work statement not detected in this document. Upload rejected.";
                            try { localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey); } catch(e){}
                            try { resetDisplay(); } catch(e){}
                            alert('The uploaded Fit-To-Work document does not indicate fitness to work. Please upload a valid Fit-To-Work certificate.');
                            isProcessing = false;
                            return;
                        }

                        // Autofill and persist but do not enforce date strictness here
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        if (fitDisplayEl) {
                            const _e = fitDisplayEl.querySelector('.ocr-error'); if (_e) _e.textContent = '';
                        }
                        alert(`Fit-To-Work: ${aiData.fit_statement || aiData.doctor || '?'}  OCR Type: ${detectedType} processed successfully.`);

                    } else if (detectedType === 'medical_certificate' && ocrtype === 'medical_certificate') {
                        // Use medDisplay as the error container (create a child .ocr-error if missing)
                        let medDisplayEl = document.getElementById('medDisplay');
                        let errorBox = null;
                        if (medDisplayEl) {
                            errorBox = medDisplayEl.querySelector('.ocr-error');
                            if (!errorBox) {
                                errorBox = document.createElement('div');
                                errorBox.className = 'ocr-error mt-2 text-sm text-red-600';
                                medDisplayEl.appendChild(errorBox);
                            }
                        } else {
                            // fallback plain object
                            errorBox = { textContent: '' };
                        }

                        // autofill where possible
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}

                        // For pure medical certificates we enforce the 3-month date rule
                        const isValid = validateMedicalCertificateDate(aiData.date, errorBox, 'Medical certificate');
                        // Remove loading indicator
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        
                        if (isValid) {
                            alert(`Medical Date: ${aiData.date || '?'}  OCR Type: ${detectedType} processed successfully.`);
                        } else {
                            // Enforce strict 3-month rule: do not accept expired medical certificates.
                            if (errorBox && errorBox.textContent) {
                                console.warn('Rejected medical certificate date (older than 3 months):', aiData.date);
                            }
                            alert(`Detected medical date ${aiData.date || '?'} is older than 3 months and cannot be accepted. Please upload a valid medical certificate within 3 months.`);
                        }
                    } else if (detectedType === 'membership_proof' && ocrtype === 'membership_proof') {
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        // Remove loading indicator
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        alert(`Is Member of DSAPI: ${aiData.is_membership || '?'}  OCR Type: ${detectedType} processed successfully.`);
                    } else {
                        // generic autofill attempt
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        // Remove loading indicator
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        alert(`OCR Type: ${detectedType || ocrtype} processed successfully.`);
                    }
                } else {
                    // Remove loading indicator on error
                    const loading = document.getElementById(`ocr-loading-${inputId}`);
                    if (loading) loading.remove();
                    alert(`Error ${response.status}: ${result.message || 'Unknown server error'}`);
                }

                // If a second file was selected (merged front/back upload), process it as well
                try {
                    const filesAll = Array.from(fileInput.files || []);
                    if (filesAll.length > 1) {
                        const file2 = filesAll[1];
                        if (file2) {
                            // read second file data
                            const dataUrl2 = await new Promise((resolve, reject) => {
                                const reader2 = new FileReader();
                                reader2.onload = () => resolve(reader2.result);
                                reader2.onerror = () => reject(reader2.error || new Error('FileReader failed'));
                                reader2.readAsDataURL(file2);
                            });

                            const ext2 = (file2.name.split('.').pop()||'').toLowerCase();

                            // Convert existing single-value storage into arrays if needed, then append
                            try {
                                const prevName = localStorage.getItem(nameKey);
                                const prevData = localStorage.getItem(dataKey);
                                const prevType = localStorage.getItem(typeKey);
                                let names = [], datas = [], types = [];
                                try { names = JSON.parse(prevName); } catch(e){ if (prevName) names = [prevName]; }
                                try { datas = JSON.parse(prevData); } catch(e){ if (prevData) datas = [prevData]; }
                                try { types = JSON.parse(prevType); } catch(e){ if (prevType) types = [prevType]; }

                                names.push(file2.name);
                                datas.push(dataUrl2);
                                types.push(ext2);

                                localStorage.setItem(nameKey, JSON.stringify(names));
                                localStorage.setItem(dataKey, JSON.stringify(datas));
                                localStorage.setItem(typeKey, JSON.stringify(types));
                            } catch(e) { console.warn('updating storage for second file failed', e); }

                            // send OCR request for second file
                            const payload2 = { type: ocrtype, ocr_name: file2.name, ocr_data: dataUrl2, ocr_type: ext2 };
                            try {
                                if (ocrtype === 'pwd_id' && /\bback|backside|rear|_b\b|\-b\b/i.test(file2.name)) {
                                    const stored = localStorage.getItem('admin_uploaded_pwd_detected');
                                    if (stored) { payload2.previous_disability = stored; payload2.previous_disability_source = 'front'; }
                                }
                            } catch(e){}

                            try {
                                const resp2 = await fetch('db/ocr-validation.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload2) });
                                const resJson2 = await resp2.json().catch(()=>({ message: 'Invalid JSON' }));
                                if (resp2.ok) {
                                    console.log('OCR Result (file 2):', resJson2);
                                    const detectedType2 = resJson2.data?.ocrtype;
                                    const aiData2 = resJson2.data?.ai_data || {};
                                    if (detectedType2 === 'pwd_id' && aiData2.type_of_disability) {
                                        const pd = document.getElementById('pwdidDisplay');
                                        const txt2 = String(aiData2.type_of_disability || '').trim();
                                        if (pd) pd.insertAdjacentHTML('beforeend', `<div class="ocr-summary mt-2 text-sm text-gray-700">Detected Disability (2nd image): ${txt2}</div>`);
                                        try { localStorage.setItem('admin_uploaded_pwd_detected', txt2); } catch(e){}
                                    }
                                    try { applyOcrDataToForm(aiData2, detectedType2, ocrtype); } catch(e){}
                                } else {
                                    console.warn('OCR failed for second file', resJson2);
                                }
                            } catch(e) { console.warn('fetch for second file failed', e); }
                        }
                    }
                } catch(e) { console.warn('second-file OCR flow failed', e); }

                // Attach button listeners (only once per file selection)
                const viewBtn = display.querySelector('.viewBtn');
                const removeBtn = display.querySelector('.removeBtn');

                if (viewBtn) {
                    viewBtn.addEventListener('click', (ev) => {
                        ev.preventDefault();
                        openModal(currentFileURL, ext);
                    });
                }

                if (removeBtn) {
                    removeBtn.addEventListener('click', (ev) => {
                        ev.preventDefault();
                        resetDisplay();
                        fileInput.value = '';

                        if (currentFileURL) {
                            URL.revokeObjectURL(currentFileURL);
                            currentFileURL = null;
                        }

                        localStorage.removeItem(nameKey);
                        localStorage.removeItem(dataKey);
                        localStorage.removeItem(typeKey);

                        cleanupUploadedFileByName(file?.name || localStorage.getItem(nameKey));

                        console.info('[adminapprove] removed upload and cleaned legacy keys for', nameKey);
                    });
                }

                safeSetText(labelEl, 'File Uploaded:');
                if (hintEl) hintEl.style.display = 'none';

            } catch (err) {
                // Remove loading indicator on error
                const loading = document.getElementById(`ocr-loading-${inputId}`);
                if (loading) loading.remove();
                console.error('[upload] Processing failed:', err);
                alert('Something went wrong while processing the file.');
            }
            finally {
                isProcessing = false;
                fileInput.value = '';   // Clear input so same file can be selected again if needed
                console.log("[upload] Processing finished", new Date().toISOString());
            }
        });

        fileInput.dataset.changeListenerAttached = 'true';
        console.log("[upload] Change listener attached (one-time)");
    } else {
        console.log("[upload] Change listener already attached – skipped re-attachment");
    }
    
  // Modal preview
  function openModal(url, ext) {
    modal.classList.remove('hidden');
    modalContent.innerHTML = '';

    if (['jpg', 'jpeg', 'png'].includes(ext)) {
      modalContent.innerHTML = `<img src="${url}" class="max-h-[80vh] mx-auto rounded-lg">`;
    } else if (ext === 'pdf') {
      modalContent.innerHTML = `<iframe src="${url}" class="w-full h-[80vh] rounded-lg border-0"></iframe>`;
    } else {
      modalContent.innerHTML = `<p class="text-gray-700 text-center">This file type cannot be previewed.<br>(Hindi maaaring i-preview ang file na ito.)</p>`;
    }
  }

  closeModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.add('hidden');
    modalContent.innerHTML = '';
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add('hidden');
      modalContent.innerHTML = '';
    }
  });

  function resetDisplay() {
    display.innerHTML = '';
    safeSetText(labelEl, (labelEl && labelEl.dataset ? (labelEl.dataset.original || 'Upload File') : 'Upload File'));
        if (hintEl) hintEl.style.display = '';
  }
}
</script>
            
            <!-- Submit Button -->
            <div class="flex flex-col items-center mt-12 sm:mt-16 w-full px-4 sm:px-0">
                <button 
                id="createAccountBtn" 
                type="button" class="w-full sm:w-auto bg-[#2E2EFF] text-white text-lg sm:text-2xl font-semibold px-6 sm:px-16 md:px-28 py-3 sm:py-4 rounded-2xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Next →
                </button>
                <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
                    Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue <br class="hidden sm:block">
                    <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy)</span>
                </p>
            </div>

            

           <script>
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
                    // clear primary personal fields
                    try { document.getElementById('first_name').value = ''; } catch(e){}
                    try { document.getElementById('last_name').value = ''; } catch(e){}
                    try { document.getElementById('birthdate').value = ''; } catch(e){}
                    try { document.getElementById('email').value = ''; } catch(e){}
                    try { document.getElementById('phone').value = ''; } catch(e){}
                    try { document.getElementById('address').value = ''; } catch(e){}
                    try { const ds = document.getElementById('dsType'); if(ds) ds.value = ''; document.querySelectorAll('input[name="down_syndrome_type"]').forEach(r=>{ try{ r.checked = false; }catch(e){} }); } catch(e){}

                    // guardian: clear both existing and newly-added fields
                    try { document.getElementById('guardian_first').value = ''; } catch(e){}
                    try { document.getElementById('guardian_last').value = ''; } catch(e){}
                    try { document.getElementById('guardian_middle').value = ''; } catch(e){}
                    try { document.getElementById('guardian_birthdate').value = ''; } catch(e){}
                    try { document.getElementById('guardian_email').value = ''; } catch(e){}
                    try { document.getElementById('guardian_phone').value = ''; } catch(e){}
                    try { document.getElementById('guardian_home_phone').value = ''; } catch(e){}
                    try { document.getElementById('guardian_work_phone').value = ''; } catch(e){}
                    try { document.getElementById('guardian_work_address').value = ''; } catch(e){}
                    try { const gr = document.getElementById('guardian_relationship'); if(gr) gr.selectedIndex = 0; } catch(e){}

                    // spouse: clear newly-added spouse fields
                    try { document.getElementById('spouse_first').value = ''; } catch(e){}
                    try { document.getElementById('spouse_last').value = ''; } catch(e){}
                    try { document.getElementById('spouse_middle').value = ''; } catch(e){}
                    try { document.getElementById('spouse_birthdate').value = ''; } catch(e){}
                    try { document.getElementById('spouse_email').value = ''; } catch(e){}
                    try { document.getElementById('spouse_phone').value = ''; } catch(e){}
                    try { document.getElementById('spouse_home_phone').value = ''; } catch(e){}
                    try { document.getElementById('spouse_work_phone').value = ''; } catch(e){}
                    try { document.getElementById('spouse_work_address').value = ''; } catch(e){}
                    try { const sr = document.getElementById('spouse_relationship'); if(sr) sr.selectedIndex = 0; } catch(e){}
                });

                // Keep the hidden karyotype fields in sync with the radio buttons (including legacy aliases)
                try {
                    const dsHiddenIds = ['dsType','r_dsType1','r_dsType','types_of_ds','TYPES_OF_DS','karyotype'];
                    const setAllDs = (v) => {
                        dsHiddenIds.forEach(id => {
                            try { const el = document.getElementById(id); if (el) el.value = v || ''; } catch(e){}
                        });
                    };

                    document.querySelectorAll('input[name="down_syndrome_type"]').forEach(r => {
                        r.addEventListener('change', e => {
                            setAllDs(e.target.value || '');
                        });
                    });

                    // initialize hidden inputs from any pre-checked radio
                    const sel = document.querySelector('input[name="down_syndrome_type"]:checked');
                    if (sel) setAllDs(sel.value || '');

                    // Keep radios in sync when any hidden input is changed programmatically
                    const primaryHidden = document.getElementById('dsType');
                    if (primaryHidden) {
                        let lastDs = primaryHidden.value || '';
                        const applyHiddenToRadios = (v) => {
                            document.querySelectorAll('input[name="down_syndrome_type"]').forEach(r => {
                                try { r.checked = (String(r.value || '') === String(v || '')); } catch(e){}
                            });
                        };
                        if (lastDs) applyHiddenToRadios(lastDs);
                        setInterval(() => {
                            try {
                                const v = primaryHidden.value || '';
                                if (v !== lastDs) { lastDs = v; applyHiddenToRadios(v); setAllDs(v); }
                            } catch (e) {}
                        }, 300);
                    }
                } catch (e) {}
                // Keep GUARDIAN_CELL_NUMBER hidden field in sync with guardian phone input
                try {
                    const gp = document.getElementById('guardian_phone');
                    const gHidden = document.getElementById('GUARDIAN_CELL_NUMBER');
                    if (gp && gHidden) {
                        // initialize
                        gHidden.value = gp.value || '';
                        gp.addEventListener('input', (ev) => { try { gHidden.value = ev.target.value || ''; } catch(e){} });
                    }
                } catch(e) {}

                const passwordInput = document.getElementById('password');
                const passwordMessage = document.getElementById('passwordMessage');
                const confirmPasswordInput = document.getElementById('confirmPassword');
                const confirmMessage = document.getElementById('confirmMessage');
                const createAccountBtn = document.getElementById('createAccountBtn');
                // const togglePassword = document.getElementById('togglePassword');

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
                // togglePassword.addEventListener('change', () => {
                // const type = togglePassword.checked ? 'text' : 'password';
                // passwordInput.type = type;
                // confirmPasswordInput.type = type;
                // });


                </script>

            </div>

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

    <!-- 🔹 Modal (Shared for both uploads) -->
    <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
    <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
        <button id="closeModalBtn" type="button" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
        <div id="modalContent" class="p-2 text-center"></div>
    </div>
    </div>

    <script>
    (function(){
        function normalizeFilename(s){
            if(!s) return '';
            try{ const parts = String(s).split(/[/\\]+/); return parts[parts.length-1]||'';}catch(e){ return String(s||''); }
        }

        function setIf(id, val){
            try{
                const el = document.getElementById(id);
                if(!el) return false;
                if(el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') el.value = val || '';
                else el.textContent = val || '';
                return true;
            }catch(e){ return false; }
        }

        function setProofPreview(name){
            try{
                const info = document.getElementById('proofFileInfo');
                const fileName = document.getElementById('proofFileName');
                const icon = document.getElementById('proofFileIcon');
                const hint = document.getElementById('proofHint');
                if(!name){ if(info) info.classList.add('hidden'); if(hint) hint.style.display = ''; return; }
                const ext = (name.split('.').pop()||'').toLowerCase();
                if(icon) icon.textContent = (['jpg','jpeg','png'].includes(ext)?'🖼️': (ext==='pdf'?'📄':'📁'));
                if(fileName) fileName.textContent = name;
                if(info) info.classList.remove('hidden');
                if(hint) hint.style.display = 'none';
            }catch(e){}
        }

        function applyDraftToDom(d){
            try{
                if(!d || typeof d !== 'object') return false;
                const p = d.personal || d.personalInfo || d;
            const first = p.firstName || p.first_name || p.first || p.fname || '';
            const last = p.lastName || p.last_name || p.last || p.lname || '';
            const email = p.email || '';
            const phone = p.phone || p.mobile || '';
            const birthdate = p.birthdate || p.birth_date || p.dob || p.dateOfBirth || p.age || '';
            const address = p.address || '';
                const username = p.username || p.userName || '';
                let applied = false;
                applied = setIf('first_name', first) || applied;
                applied = setIf('last_name', last) || applied;
                applied = setIf('email', email) || applied;
                applied = setIf('phone', phone) || applied;
            applied = setIf('birthdate', birthdate) || applied;
                applied = setIf('address', address) || applied;
                applied = setIf('username', username) || applied;

                // Guardian fields (if present in draft)
                applied = setIf('guardian_first', d.guardian_first || d.guardian_first_name || p.guardian_first || '') || applied;
                applied = setIf('guardian_last', d.guardian_last || d.guardian_last_name || p.guardian_last || '') || applied;
                applied = setIf('guardian_middle', d.guardian_middle || d.guardian_middle_name || p.guardian_middle || '') || applied;
                applied = setIf('guardian_email', d.guardian_email || p.guardian_email || '') || applied;
                applied = setIf('guardian_phone', d.guardian_phone || p.guardian_phone || '') || applied;
                applied = setIf('guardian_home_phone', d.guardian_home_phone || p.guardian_home_phone || '') || applied;
                applied = setIf('guardian_work_phone', d.guardian_work_phone || p.guardian_work_phone || '') || applied;
                applied = setIf('guardian_birthdate', d.guardian_birthdate || d.guardian_birth_date || p.guardian_birthdate || '') || applied;
                applied = setIf('guardian_relationship', d.guardian_relationship || p.guardian_relationship || '') || applied;
                applied = setIf('guardian_work_address', d.guardian_work_address || p.guardian_work_address || '') || applied;

                // Spouse fields
                applied = setIf('spouse_first', d.spouse_first || p.spouse_first || '') || applied;
                applied = setIf('spouse_last', d.spouse_last || p.spouse_last || '') || applied;
                applied = setIf('spouse_middle', d.spouse_middle || p.spouse_middle || '') || applied;
                applied = setIf('spouse_email', d.spouse_email || p.spouse_email || '') || applied;
                applied = setIf('spouse_phone', d.spouse_phone || p.spouse_phone || '') || applied;
                applied = setIf('spouse_home_phone', d.spouse_home_phone || p.spouse_home_phone || '') || applied;
                applied = setIf('spouse_work_phone', d.spouse_work_phone || p.spouse_work_phone || '') || applied;
                applied = setIf('spouse_birthdate', d.spouse_birthdate || p.spouse_birthdate || '') || applied;
                applied = setIf('spouse_relationship', d.spouse_relationship || p.spouse_relationship || '') || applied;
                applied = setIf('spouse_work_address', d.spouse_work_address || p.spouse_work_address || '') || applied;

                // dsType
                const ds = d.dsType || d.ds_type || p.dsType || p.ds_type || '';
                if(ds){
                    try{
                        const select = document.getElementById('dsType');
                        if(select){
                            let found = false;
                            for(const opt of select.options){ if(String(opt.value||'').toLowerCase()===String(ds).toLowerCase()){ select.value = opt.value; found = true; break; } }
                            if(!found){ for(const opt of select.options){ if(String(opt.textContent||'').toLowerCase()===String(ds).toLowerCase()){ select.value = opt.value; break; } } }
                            applied = true;
                        }
                    }catch(e){}
                }

                // cddType (Congenital/Developmental Disability) — supports multiple selections
                try{
                    let cdd = d.cddType || d.cdd_type || p.cddType || p.cdd_type || d.r_cddType1 || p.r_cddType1 || d.disability || p.disability || '';
                    const container = document.getElementById('cddType');
                    const otherCdd = document.getElementById('cddTypeOther');
                    const hidden = document.getElementById('cddTypeHidden');

                    if(!container) { /* still mark applied if cdd exists */ if(cdd) applied = true; }

                    // normalize incoming cdd into array of strings
                    let items = [];
                    if (Array.isArray(cdd)) items = cdd.map(x=>String(x||'').trim()).filter(Boolean);
                    else if (typeof cdd === 'string') {
                        // accept comma/semicolon separated values or plain single string
                        items = cdd.split(/[;,|\n]+/).map(x=>String(x||'').trim()).filter(Boolean);
                        if(items.length===0 && cdd.trim()) items = [cdd.trim()];
                    } else if (cdd) items = [String(cdd)];

                    // also consider explicit other-text
                    const otherText = d.cddTypeOther || d.cdd_type_other || (p && (p.cddTypeOther || p.cdd_type_other)) || '';
                    if (otherText && !items.includes(String(otherText).trim())) items.push(String(otherText).trim());

                    if(items.length){
                        // clear existing checks first
                        const boxes = container ? Array.from(container.querySelectorAll('input[type="checkbox"][name="cddType[]"]')) : [];
                        boxes.forEach(b=>{ b.checked = false; });

                        const unmatched = [];
                        items.forEach(val => {
                            const low = String(val||'').toLowerCase();
                            let matched = false;
                            for(const b of boxes){
                                try{
                                    const bv = String(b.value||'').toLowerCase();
                                    if(bv === low || bv.includes(low) || String(b.nextSibling && b.nextSibling.textContent||'').toLowerCase().includes(low)){
                                        b.checked = true; matched = true; break;
                                    }
                                }catch(e){}
                            }
                            if(!matched) unmatched.push(val);
                        });

                        // if there are unmatched items, populate Others
                        if(unmatched.length && otherCdd){ otherCdd.classList.remove('hidden'); otherCdd.required = true; otherCdd.value = unmatched.join(', '); const chk = document.getElementById('cddTypeOtherChk'); if(chk) chk.checked = true; }

                        // update hidden canonical value for legacy code
                        if(hidden) hidden.value = items.join(', ');

                        // trigger change handlers
                        if(container){ container.dispatchEvent(new Event('change',{bubbles:true})); }
                        applied = true;
                    }
                }catch(e){ console.warn('[adminapprove] applyDraft cddType failed', e); }

                // guardian
                const g = d.guardian || d.guardianInfo || d;
                const gfirst = g.guardian_first_name || g.guardian_first || g.first || g.first_name || '';
                const glast = g.guardian_last_name || g.guardian_last || g.last || g.last_name || '';
                const gemail = g.guardian_email || g.email || '';
                const gphone = g.guardian_phone || g.phone || '';
                const grel = g.guardian_relationship || g.guardian_choice || g.relationship || '';
                applied = setIf('guardian_first', gfirst) || applied;
                applied = setIf('guardian_last', glast) || applied;
                applied = setIf('guardian_email', gemail) || applied;
                applied = setIf('guardian_phone', gphone) || applied;
                if(grel) applied = setIf('guardian_relationship', grel) || applied;

                // proof filename preview
                const proof = d.proofFilename || p.proofFilename || d.proof || d.cert_file || p.proof || '';
                const proofName = normalizeFilename(proof||''); if(proofName){ setProofPreview(proofName); applied = true; }
                return applied;
            }catch(e){ console.warn('applyDraftToDom failed', e); return false; }
        }

        function parseStored(raw){
            if(!raw) return null;
            try{ let parsed = JSON.parse(raw); if(parsed && parsed.data) parsed = parsed.data; return parsed; }catch(e){ return raw; }
        }

        function tryLoadAndApplyOnce(){
            try{
                const raw = localStorage.getItem('rpi_personal1') || sessionStorage.getItem('rpi_personal1');
                if(!raw) return null;
                return parseStored(raw);
            }catch(e){ console.warn('tryLoadAndApplyOnce failed', e); return null; }
        }

        // Boot: attempt application with retry
        const parsed = tryLoadAndApplyOnce();
        if(parsed){
            try{ console.info('[adminapprove-autofill] rpi_personal1 found, attempting to apply', Object.keys(parsed || {})); }catch(_){}
            let attempts = 0;
            const maxAttempts = 12;
            const interval = 120;
            function attempt(){
                attempts++;
                try{
                    const ok = applyDraftToDom(parsed);
                    if(ok){
                        try{ console.info('[adminapprove-autofill] applied local draft to form'); }catch(_){}
                        window.__mvsg_local_applied = true;
                        window.dispatchEvent(new CustomEvent('mvsg:localApplied',{detail:{key:'rpi_personal1'}}));
                        return;
                    }
                }catch(e){}
                if(attempts < maxAttempts) setTimeout(attempt, interval);
            }
            attempt();
        }

        // Listen for storage changes and custom events
        window.addEventListener('storage', function(e){
            try{ if((e.key === 'rpi_personal1' || e.key === null) && e.newValue){ const parsed = parseStored(e.newValue); if(parsed) applyDraftToDom(parsed); } }catch(_){}
        });

        window.addEventListener('mvsg:adminSaved', function(ev){
            try{ const d = (ev && ev.detail && ev.detail.data) ? ev.detail.data : null; if(d) applyDraftToDom(d); }catch(_){}
        });

    })();
    </script>

    <script src="js/register.js"></script>

    <!-- TTS: Web Speech API handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.tts-btn');
            const preferredEnglishVoiceName = 'Microsoft AvaMultilingual Online (Natural) - English (United States)';
            const preferredTagalogVoiceName = 'fil-PH-BlessicaNeural';
            let preferredEnglishVoice = null;
            let preferredTagalogVoice = null;
            let currentBtn = null;
            let availableVoices = [];

            function populateVoices() {
                availableVoices = window.speechSynthesis.getVoices() || [];
                preferredEnglishVoice = availableVoices.find(v => v.name === preferredEnglishVoiceName) ||
                    availableVoices.find(v => /ava.*multilingual|microsoft ava/i.test(v.name)) ||
                    null;
                preferredTagalogVoice = availableVoices.find(v => v.name === preferredTagalogVoiceName) ||
                    availableVoices.find(v => /blessica|fil-?ph|filipino|tagalog/i.test(v.name)) ||
                    null;
            }

            function chooseVoiceForLang(langCode) {
                if (!availableVoices.length) return null;
                langCode = (langCode || '').toLowerCase();
                let candidates = availableVoices.filter(v => (v.lang || '').toLowerCase().startsWith(langCode));
                if (candidates.length) return pickBest(candidates);
                candidates = availableVoices.filter(v => /wave|neural|google|premium|microsoft|mbrola|amazon|polly/i.test(v.name));
                if (candidates.length) return pickBest(candidates);
                return availableVoices[0];
            }

            function pickBest(list) {
                let preferred = list.filter(v => /neural|wave|wavenet|google|microsoft|polly|amazon/i.test(v.name));
                if (preferred.length) return preferred[0];
                return list[0];
            }

            function stopSpeaking() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
                if (currentBtn) {
                    currentBtn.classList.remove('speaking');
                    currentBtn.removeAttribute('aria-pressed');
                    currentBtn = null;
                }
            }

            buttons.forEach(function(btn) {
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');

                btn.addEventListener('click', function() {
                    const textEn = (btn.getAttribute('data-tts-en') || '').trim();
                    const textTl = (btn.getAttribute('data-tts-tl') || '').trim();
                    if (!textEn && !textTl) return;

                    if (window.speechSynthesis && window.speechSynthesis.speaking && currentBtn === btn) {
                        stopSpeaking();
                        return;
                    }

                    stopSpeaking();
                    setTimeout(function() {
                        if (!window.speechSynthesis) return;

                        function voiceFor(langHint) {
                            if (langHint) {
                                const hint = (langHint || '').toLowerCase();
                                if (hint.startsWith('tl') || hint.startsWith('fil') || hint.includes('tagalog')) {
                                    if (preferredTagalogVoice) return preferredTagalogVoice;
                                    return chooseVoiceForLang('tl');
                                }
                                if (hint.startsWith('en')) {
                                    if (preferredEnglishVoice) return preferredEnglishVoice;
                                    return chooseVoiceForLang('en');
                                }
                            }
                            return preferredEnglishVoice || chooseVoiceForLang('en') || (availableVoices.length ? availableVoices[0] : null);
                        }

                        const seq = [];
                        if (textEn) {
                            const uEn = new SpeechSynthesisUtterance(textEn);
                            uEn.lang = 'en-US';
                            const v = voiceFor('en');
                            if (v) uEn.voice = v;
                            seq.push(uEn);
                        }
                        if (textTl) {
                            const uTl = new SpeechSynthesisUtterance(textTl);
                            uTl.lang = 'tl-PH';
                            const v2 = voiceFor('tl');
                            if (v2) uTl.voice = v2;
                            seq.push(uTl);
                        }

                        if (!seq.length) return;

                        seq[0].onstart = function() {
                            btn.classList.add('speaking');
                            btn.setAttribute('aria-pressed', 'true');
                            currentBtn = btn;
                        };

                        for (let i = 0; i < seq.length; i++) {
                            const ut = seq[i];
                            ut.onerror = function() {
                                if (btn) btn.classList.remove('speaking');
                                if (btn) btn.removeAttribute('aria-pressed');
                                currentBtn = null;
                            };
                            if (i < seq.length - 1) {
                                ut.onend = function() {
                                    window.speechSynthesis.speak(seq[i + 1]);
                                };
                            } else {
                                ut.onend = function() {
                                    if (btn) btn.classList.remove('speaking');
                                    if (btn) btn.removeAttribute('aria-pressed');
                                    currentBtn = null;
                                };
                            }
                        }

                        window.speechSynthesis.speak(seq[0]);
                    }, 50);
                });

                btn.addEventListener('keydown', function(ev) {
                    if (ev.key === 'Enter' || ev.key === ' ') {
                        ev.preventDefault();
                        btn.click();
                    }
                });
            });

            window.addEventListener('beforeunload', function() {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });

            if (window.speechSynthesis) {
                populateVoices();
                window.speechSynthesis.onvoiceschanged = function() {
                    populateVoices();
                };
            }
        });
    </script>
<script>
    (function() {
        // Save-only helper: persist draft so the central register.js can pick it up and create the account.
        const btn = document.getElementById('createAccountBtn');
        if (!btn) return;

        const required = {
            personal: ['first_name','last_name','birthdate','email','phone','address'],
            guardian: ['guardian_first','guardian_last','guardian_email','guardian_phone','guardian_relationship'],
            account: ['username','password','confirmPassword'],
            // Proof of membership is optional; medical certificate and PWD ID are required
            uploads: ['medFile','pwdidFile']
        };

        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRe = /^\+63\d{10}$/; // expects "+63" + 10 digits (no spaces) -- input enforces this format
        const passwordRe = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

        // --- moved helper: check whether a storage key contains meaningful data ---
        function storedHasData(key) {
            try {
                const raw = localStorage.getItem(key) || sessionStorage.getItem(key);
                if (!raw) return false;
                const trimmed = String(raw).trim();
                if (!trimmed) return false;
                if (trimmed === '[]' || trimmed === '{}' || trimmed === 'null') return false;
                try {
                    const parsed = JSON.parse(trimmed);
                    if (Array.isArray(parsed)) return parsed.length > 0;
                    if (parsed && typeof parsed === 'object') return Object.keys(parsed).length > 0;
                    return String(parsed).trim() !== '';
                } catch (e) {
                    return trimmed !== '';
                }
            } catch (e) { return false; }
        }

        // --- moved helper: determine if upload exists for proof/med/pwd (used both in validation and live-clear) ---
        function hasUploadedFileFor(id) {
            try {
                if (id === 'proofFile') {
                    const input = document.getElementById('proofFile');
                    if (input && input.files && input.files.length) return true;
                    if (storedHasData('admin_uploaded_proof_name') || storedHasData('admin_uploaded_proof_data') || storedHasData('admin_uploaded_proof_type')) return true;
                    if (storedHasData('uploadedProofs_proof') || storedHasData('uploadedProofs1') || storedHasData('uploadedProofs')) return true;
                    if (storedHasData('uploadedProofName') || storedHasData('uploaded_proof_name') || storedHasData('proofName')) return true;
                    return false;
                }

                if (id === 'medFile') {
                    const input = document.getElementById('medFile');
                    if (input && input.files && input.files.length) return true;
                    if (storedHasData('admin_uploaded_med_name') || storedHasData('admin_uploaded_med_data') || storedHasData('admin_uploaded_med_type')) return true;
                    if (storedHasData('uploadedProofs_med') || storedHasData('uploadedProofs')) return true;
                    if (storedHasData('review_certfile_name') || storedHasData('review_certs_name')) return true;
                    return false;
                }

                if (id === 'pwdidFile') {
                    const input = document.getElementById('pwdidFile');
                    if (input && input.files && input.files.length) return true;
                    if (storedHasData('admin_uploaded_pwd_name') || storedHasData('admin_uploaded_pwd_data') || storedHasData('admin_uploaded_pwd_type')) return true;
                    if (storedHasData('uploaded_pwd_name') || storedHasData('uploaded_pwd_data')) return true;
                    if (storedHasData('pwdName') || storedHasData('pwdFilename')) return true;
                    return false;
                }

                return false;
            } catch (e) { return false; }
        }

        // --- Email uniqueness check ---
        (function(){
            const emailEl = document.getElementById('email');
            const guardianEmailEl = document.getElementById('guardian_email');
            const emailError = document.getElementById('emailError');
            const guardianEmailError = document.getElementById('guardianEmailError');
            const submitBtn = document.getElementById('createAccountBtn');

            let lastEmail = '';
            let lastGuardianEmail = '';
            let emailOk = true;
            let guardianEmailOk = true;

            function setSubmitState() {
                if (!emailOk || !guardianEmailOk) {
                    if (submitBtn) { submitBtn.disabled = true; submitBtn.classList.add('bg-gray-400','cursor-not-allowed','opacity-90'); }
                } else {
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.classList.remove('bg-gray-400','cursor-not-allowed','opacity-90'); }
                }
            }

            function checkEmailRemote(value, cb) {
                if (!value || value.length < 3) { cb(false); return; }
                fetch('/db/check_email.php?email=' + encodeURIComponent(value), { credentials: 'same-origin' })
                    .then(r => r.json())
                    .then(j => { if (j && j.success) cb(!!j.exists); else cb(false); })
                    .catch(() => cb(false));
            }

            function debounce(fn, wait) { let t; return function(...a){ clearTimeout(t); t = setTimeout(()=>fn.apply(this,a), wait); }; }

            const debouncedCheck = debounce(function(el, isGuardian){
                const v = el.value.trim();
                if (!v) {
                    if (isGuardian) { guardianEmailError.textContent = ''; guardianEmailOk = true; }
                    else { emailError.textContent = ''; emailOk = true; }
                    setSubmitState();
                    return;
                }
                // skip if unchanged
                if ((!isGuardian && v === lastEmail) || (isGuardian && v === lastGuardianEmail)) { return; }
                checkEmailRemote(v, function(exists){
                    if (exists) {
                        if (isGuardian) {
                            guardianEmailError.textContent = 'This email is already in use.';
                            guardianEmailOk = false;
                        } else {
                            emailError.textContent = 'This email is already in use.';
                            emailOk = false;
                        }
                    } else {
                        if (isGuardian) { guardianEmailError.textContent = ''; guardianEmailOk = true; }
                        else { emailError.textContent = ''; emailOk = true; }
                    }
                    setSubmitState();
                });
            }, 450);

            if (emailEl) {
                emailEl.addEventListener('input', (e) => { lastEmail = ''; emailOk = true; debouncedCheck(emailEl, false); });
                emailEl.addEventListener('blur', (e) => { debouncedCheck(emailEl, false); });
            }
            if (guardianEmailEl) {
                guardianEmailEl.addEventListener('input', (e) => { lastGuardianEmail = ''; guardianEmailOk = true; debouncedCheck(guardianEmailEl, true); });
                guardianEmailEl.addEventListener('blur', (e) => { debouncedCheck(guardianEmailEl, true); });
            }

            // ensure submit state reflects any pre-filled values on load
            window.addEventListener('load', function(){ if (emailEl && emailEl.value) debouncedCheck(emailEl, false); if (guardianEmailEl && guardianEmailEl.value) debouncedCheck(guardianEmailEl, true); });
        })();

        function showFieldError(id, msg) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('border-red-500');
            // existing error element?
            let err = el.parentNode.querySelector('.field-error');
            if (!err) {
                err = document.createElement('p');
                err.className = 'field-error mt-1 text-sm text-red-500 italic';
                el.parentNode.appendChild(err);
            }
            err.textContent = msg;
        }

        function clearFieldError(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('border-red-500');
            const err = el.parentNode.querySelector('.field-error');
            if (err) err.remove();
        }

        function validateRequired() {
            // clear previous errors
            [...required.personal, ...required.guardian, ...required.account, ...required.uploads].forEach(clearFieldError);

                const values = {};
            // Only gather non-file inputs into values; uploads are checked via hasUploadedFileFor()
                [...required.personal, ...required.guardian, ...required.account].forEach(id => {
                const el = document.getElementById(id);
                values[id] = el ? (el.value || '').trim() : '';
            });

            const errors = [];

            // Personal checks
            required.personal.forEach(id => {
                if (!values[id]) {
                    errors.push({ id, msg: 'This field is required.' });
                }
            });

            // birthdate must indicate at least 18 years old
            if (values.birthdate) {
                try {
                    const bd = new Date(values.birthdate);
                    if (!bd || isNaN(bd.getTime())) {
                        errors.push({ id: 'birthdate', msg: 'Please enter a valid date of birth.' });
                    } else {
                        const today = new Date();
                        let ageYears = today.getFullYear() - bd.getFullYear();
                        const m = today.getMonth() - bd.getMonth();
                        if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) ageYears--;
                        if (!(ageYears >= 18)) errors.push({ id: 'birthdate', msg: 'You must be at least 18 years old.' });
                    }
                } catch (e) { errors.push({ id: 'birthdate', msg: 'Please enter a valid date of birth.' }); }
            } else {
                errors.push({ id: 'birthdate', msg: 'This field is required.' });
            }

            // email
            if (values.email && !emailRe.test(values.email)) {
                errors.push({ id: 'email', msg: 'Please enter a valid email.' });
            }

            // phone
            if (values.phone && !phoneRe.test(values.phone.replace(/\s+/g,''))) {
                errors.push({ id: 'phone', msg: 'Please enter a valid Philippine number (e.g. +639121234567).' });
            }

            // guardian checks
            required.guardian.forEach(id => {
                if (!values[id]) {
                    errors.push({ id, msg: 'This field is required.' });
                }
            });

            // guardian_relationship - ensure not default empty
            if (!values.guardian_relationship) {
                errors.push({ id: 'guardian_relationship', msg: 'Please select a relationship.' });
            }

            // account checks
            if (!values.username) errors.push({ id: 'username', msg: 'Please enter a username.' });
            if (!values.password) errors.push({ id: 'password', msg: 'Please enter a password.' });
            if (values.password && !passwordRe.test(values.password)) {
                errors.push({ id: 'password', msg: 'Password must have 1 uppercase, 1 lowercase, 1 number and be 8+ chars.' });
            }
            if (!values.confirmPassword) errors.push({ id: 'confirmPassword', msg: 'Please confirm your password.' });
            if (values.password && values.confirmPassword && values.password !== values.confirmPassword) {
                errors.push({ id: 'confirmPassword', msg: 'Passwords do not match.' });
            }

            // uploads checks — require medical certificate and PWD ID (proof of membership is optional)
            if (!hasUploadedFileFor('medFile')) {
                errors.push({ id: 'medFile', msg: 'Please upload a medical certificate.' });
            }
            if (!hasUploadedFileFor('pwdidFile')) {
                errors.push({ id: 'pwdidFile', msg: 'Please upload your PWD ID.' });
            }

            // If OCR produced a medical date, validate it and prevent proceeding when invalid
            try {
                const mdEl = document.getElementById('medDisplay');
                if (mdEl) {
                    let errEl = mdEl.querySelector('.ocr-error');
                    if (!errEl) {
                        errEl = document.createElement('div');
                        errEl.className = 'ocr-error mt-2 text-sm text-red-600';
                        mdEl.appendChild(errEl);
                    } else {
                        errEl.textContent = '';
                    }
                    const summary = mdEl.querySelector('.ocr-summary');
                    if (summary) {
                        const txt = String(summary.textContent || '').replace(/Detected medical date:\s*/i, '').trim();
                        if (txt) {
                            const ok = validateMedicalCertificateDate(txt, errEl);
                            if (!ok) {
                                errors.push({ id: 'medFile', msg: 'Medical certificate appears expired or invalid.' });
                            }
                        }
                    }
                }
            } catch (e) { /* ignore OCR validation errors */ }

            if (errors.length) {
                console.warn('[validateRequired] blocking errors found');
                console.log('[validateRequired] values snapshot:', values);
                console.log('[validateRequired] upload checks:', { med: hasUploadedFileFor('medFile'), pwd: hasUploadedFileFor('pwdidFile') });
                try { console.log('[validateRequired] storage keys', { admin_med: localStorage.getItem('admin_uploaded_med_name'), admin_pwd: localStorage.getItem('admin_uploaded_pwd_name') }); } catch(e){}
                console.debug('[validateRequired] errors list:', errors);
                // show errors; focus first error and scroll into view
                const first = errors[0];
                errors.forEach(e => showFieldError(e.id, e.msg));
                const firstEl = document.getElementById(first.id);
                if (firstEl) {
                    firstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstEl.focus();
                } else {
                    // fallback: scroll to top of form
                    const form = document.getElementById('registrationForm');
                    if (form) form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                return false;
            }

            return true;
        }

        // --- New: attach live listeners so warning text disappears as fields become valid ---
        function attachLiveClear() {
            const watchIds = [...required.personal, ...required.guardian, ...required.account];
            watchIds.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                    el.addEventListener('input', () => {
                    const v = (el.value || '').trim();
                    let ok = true;
                    if (id === 'birthdate') {
                        try {
                            if (!v) { ok = false; }
                            else {
                                const bd = new Date(v);
                                if (!bd || isNaN(bd.getTime())) ok = false;
                                else {
                                    const today = new Date();
                                    let ageYears = today.getFullYear() - bd.getFullYear();
                                    const m = today.getMonth() - bd.getMonth();
                                    if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) ageYears--;
                                    ok = ageYears >= 18;
                                }
                            }
                        } catch (e) { ok = false; }
                    }
                    else if (id === 'email') ok = emailRe.test(v);
                    else if (id === 'phone') ok = phoneRe.test(v.replace(/\s+/g,''));
                    else if (id === 'password') ok = passwordRe.test(v);
                    else if (id === 'confirmPassword') {
                        const pw = (document.getElementById('password')?.value || '').trim();
                        ok = pw && v && pw === v;
                    } else if (id === 'guardian_relationship') ok = v !== '';
                    else ok = v !== '';
                    if (ok) clearFieldError(id);
                });

                // also clear on blur to cover paste/select scenarios
                el.addEventListener('blur', () => {
                    const evt = new Event('input');
                    el.dispatchEvent(evt);
                });
            });

            // file inputs: clear when a file is selected (or when legacy storage detected)
            ['proofFile','pwdidFile','medFile'].forEach(fid => {
                const inp = document.getElementById(fid);
                if (inp) {
                    inp.addEventListener('change', () => {
                        if (hasUploadedFileFor(fid)) clearFieldError(fid);
                    });
                }
            });

            // also listen for storage events (in case uploads are set by other scripts)
            window.addEventListener('storage', (e) => {
                if (!e) return;
                if (e.key && /proof|med|pwd|uploadedProofs|admin_uploaded/i.test(e.key)) {
                    ['proofFile','pwdidFile','medFile'].forEach(fid => { if (hasUploadedFileFor(fid)) clearFieldError(fid); });
                }
            });
        }

        // init live clearing
        attachLiveClear();

        btn.addEventListener('click', function() {
            try {
                // run validation first
                if (!validateRequired()) {
                    // visually undo the "working" state if validation failed
                    btn.classList.remove('opacity-60');
                    return;
                }

                btn.classList.add('opacity-60');
                const data = {};
                // collect all inputs/selects/textareas that have an id
                document.querySelectorAll('input[id], select[id], textarea[id]').forEach(el => {
                    const id = el.id;
                    if (!id) return;
                    if (el.type === 'checkbox') data[id] = !!el.checked;
                    else data[id] = el.value || '';
                });

                // normalize common fields to expected keys
                    const draft = {
                        firstName: data.first_name || data.firstName || data.first || '',
                        middleName: data.middle_name || data.middleName || data.mname || '',
                        lastName: data.last_name || data.lastName || data.last || '',
                        email: data.email || '',
                        phone: data.phone || '',
                        birthdate: data.birthdate || data.birth_date || data.dob || data.dateOfBirth || data.age || '',
                        address: data.address || (function(){
                            try{
                                const parts = [];
                                const n = (data.address_number || '').trim(); if(n) parts.push(n);
                                const s = (data.address_street || '').trim(); if(s) parts.push(s);
                                const b = (data.address_barangay || '').trim(); if(b) parts.push(b);
                                const c = (data.address_city || '').trim(); if(c) parts.push(c);
                                return parts.join(', ');
                            }catch(e){ return data.address || ''; }
                        })() || '',
                        username: data.username || '',
                        // karyotype / Down syndrome type (persist under multiple aliases)
                        dsType: data.dsType || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                        // ensure types_of_ds picks up value from hidden `dsType` (radio group) when present
                        types_of_ds: data.types_of_ds || data.karyotype || data.TYPES_OF_DS || data.karyotype || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                        // mirror under several legacy keys so server can read whichever it expects
                        TYPES_OF_DS: data.TYPES_OF_DS || data.types_of_ds || data.karyotype || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                        karyotype: data.karyotype || data.types_of_ds || data.TYPES_OF_DS || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                        // persist CDD (Congenital/Developmental Disability)
                        cddType: data.cddType || (function(){ try{ const el=document.getElementById('cddType'); if(!el) return ''; const hidden=document.getElementById('cddTypeHidden'); if(hidden && hidden.value) return hidden.value; const vals = Array.from(el.querySelectorAll('input[name="cddType[]"]:checked')).map(x=>String(x.value||'').trim()).filter(Boolean); return vals.join(', '); }catch(e){return '';} })() || '',
                        // persist optional "Other" text when 'Others' is chosen
                        cddTypeOther: data.cddTypeOther || (document.getElementById('cddTypeOther') ? document.getElementById('cddTypeOther').value : '') || '',
                        r_cddType1: data.r_cddType1 || data.cddType || (function(){ try{ const el=document.getElementById('cddType'); if(!el) return ''; const hidden=document.getElementById('cddTypeHidden'); if(hidden && hidden.value) return hidden.value; const vals = Array.from(el.querySelectorAll('input[name="cddType[]"]:checked')).map(x=>String(x.value||'').trim()).filter(Boolean); return vals.join(', '); }catch(e){return '';} })() || '',
                        r_dsType1: data.r_dsType1 || data.r_dsType || data.dsType || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',
                        r_dsType: data.r_dsType || data.r_dsType1 || data.dsType || (document.getElementById('dsType') ? document.getElementById('dsType').value : '') || '',

                        // Guardian fields (include multiple alias keys)
                        guardian_first: data.guardian_first || data.guardianFirst || data.g_first_name || '',
                        guardian_last: data.guardian_last || data.guardianLast || data.g_last_name || '',
                        guardian_middle: data.guardian_middle || data.g_middle_name || data.GUARDIAN_MIDDLE_NAME || data.g_middle || '',
                        // include legacy/uppercase and alternate keys the backend may expect
                        g_middle_name: data.g_middle_name || data.guardian_middle || data.GUARDIAN_MIDDLE_NAME || data.g_middle || '',
                        GUARDIAN_MIDDLE_NAME: data.GUARDIAN_MIDDLE_NAME || data.g_middle_name || data.guardian_middle || '',
                        guardian_birthdate: data.guardian_birthdate || data.g_birthdate || '',
                        guardian_email: data.guardian_email || data.g_email || '',
                        guardian_phone: data.guardian_phone || data.g_phone || data.g_cell || data.GUARDIAN_CELL_NUMBER || data.guardian_cell_number || data.guardian_contact_number || '',
                        // also populate common legacy names so server-side aliases find the value
                        // Ensure GUARDIAN_CELL_NUMBER is explicitly set from the hidden field or guardian_phone
                        GUARDIAN_CELL_NUMBER: (document.getElementById('GUARDIAN_CELL_NUMBER') ? document.getElementById('GUARDIAN_CELL_NUMBER').value : (data.GUARDIAN_CELL_NUMBER || '')) || (data.guardian_phone || data.g_phone || data.g_cell || data.guardian_cell_number || ''),
                        guardian_cell_number: data.guardian_cell_number || data.guardian_phone || data.g_phone || data.g_cell || (document.getElementById('GUARDIAN_CELL_NUMBER') ? document.getElementById('GUARDIAN_CELL_NUMBER').value : data.GUARDIAN_CELL_NUMBER) || '',
                        guardian_contact_number: data.guardian_contact_number || data.guardian_phone || data.guardian_cell_number || (document.getElementById('GUARDIAN_CELL_NUMBER') ? document.getElementById('GUARDIAN_CELL_NUMBER').value : data.GUARDIAN_CELL_NUMBER) || '',
                        g_cell: data.g_cell || data.guardian_phone || data.guardian_cell_number || (document.getElementById('GUARDIAN_CELL_NUMBER') ? document.getElementById('GUARDIAN_CELL_NUMBER').value : data.GUARDIAN_CELL_NUMBER) || '',
                        // legacy/uppercase alias for guardian phone
                        g_phone: data.g_phone || data.guardian_phone || (document.getElementById('GUARDIAN_CELL_NUMBER') ? document.getElementById('GUARDIAN_CELL_NUMBER').value : data.GUARDIAN_CELL_NUMBER) || '',
                        guardian_home_phone: data.guardian_home_phone || data.g_home_phone || data.g_home || '',
                        guardian_work_phone: data.guardian_work_phone || data.g_work_phone || '',
                        guardian_work_address: data.guardian_work_address || data.g_work_address || '',
                        guardian_relationship: data.guardian_relationship || data.guardianRelationship || '',

                        // Spouse fields
                        spouse_first: data.spouse_first || data.spouse_first_name || '',
                        spouse_middle: data.spouse_middle || data.spouse_middle_name || '',
                        spouse_last: data.spouse_last || data.spouse_last_name || '',
                        spouse_birthdate: data.spouse_birthdate || '',
                        spouse_email: data.spouse_email || '',
                        spouse_phone: data.spouse_phone || data.spouse_cell_number || '',
                        spouse_home_phone: data.spouse_home_phone || '',
                        spouse_work_phone: data.spouse_work_phone || '',
                        spouse_work_address: data.spouse_work_address || '',
                        spouse_relationship: data.spouse_relationship || '',

                        // legacy / misc
                        r_dsType1: data.r_dsType1 || '',
                        password: data.password || '',
                    };

                try {
                    localStorage.setItem('rpi_personal1', JSON.stringify(draft));
                } catch (err) {
                    console.warn('Could not save rpi_personal1', err);
                }

                console.info('[adminapprove] saved rpi_personal1 draft', Object.keys(draft));
                // dispatch event for other scripts to pick up
                try {
                    window.dispatchEvent(new CustomEvent('mvsg:adminSaved', {
                        detail: {
                            key: 'rpi_personal1',
                            data: draft
                        }
                    }));
                } catch (e) {}

               window.location.href = '{{ route("registereducation") }}';
            } catch (err) {
                console.error('[adminapprove] submit failed', err);
                btn.classList.remove('opacity-60');
            }
        });
    })();
</script>

            <!-- Ensure persisted sensitive fields and upload previews are restored after page load -->
            <script>
            window.addEventListener('load', function() {
                try {
                    const raw = localStorage.getItem('rpi_personal1') || sessionStorage.getItem('rpi_personal1');
                    if (raw) {
                        let parsed = {};
                        try { parsed = JSON.parse(raw); } catch(e) { parsed = raw; }
                        const pwd = parsed && parsed.password ? parsed.password : '';
                        if (pwd) {
                            const p = document.getElementById('password');
                            const c = document.getElementById('confirmPassword');
                            if (p) p.value = pwd;
                            if (c) c.value = pwd;
                            // trigger validation UI updates
                            try { p.dispatchEvent(new Event('input')); c.dispatchEvent(new Event('input')); } catch(e){}
                        }
                    }
                } catch(e){}

                // re-run upload initializers to render stored uploads (this is safe; setupUpload checks storage on init)
                try { if (typeof setupUpload === 'function') { setupUpload('proofFile','proofDisplay','proofLabel','proofHint'); setupUpload('pwdidFile','pwdidDisplay','pwdidLabel','pwdidHint'); setupUpload('medFile','medDisplay','medLabel','medHint'); setupUpload('fitFile','fitDisplay','fitLabel','fitHint'); } } catch(e){}
            });
            </script>

            <!-- Comprehensive restore: fill all form fields from saved draft/localStorage -->
            <script>
            window.addEventListener('load', function() {
                try {
                    const raw = localStorage.getItem('rpi_personal1') || sessionStorage.getItem('rpi_personal1');
                    if (!raw) return;
                    let parsed;
                    try { parsed = JSON.parse(raw); } catch(e) { parsed = raw; }
                    // support wrapped { data: {...} }
                    if (parsed && parsed.data) parsed = parsed.data;

                    const p = parsed.personal || parsed.personalInfo || parsed || {};

                    function safeSet(id, val) {
                        try {
                            if (val === undefined || val === null) return;
                            const el = document.getElementById(id);
                            if (!el) return;
                            if (el.tagName === 'SELECT') {
                                // try to match by value or by visible text
                                const wanted = String(val || '').trim();
                                if (!wanted) return;
                                let matched = false;
                                for (const opt of el.options) {
                                    if (String(opt.value || '').trim().toLowerCase() === wanted.toLowerCase()) { el.value = opt.value; matched = true; break; }
                                }
                                if (!matched) {
                                    for (const opt of el.options) {
                                        if (String(opt.textContent || '').trim().toLowerCase() === wanted.toLowerCase()) { el.value = opt.value; break; }
                                    }
                                }
                            } else {
                                el.value = val;
                            }
                            // fire input/change so other handlers pick it up
                            try { el.dispatchEvent(new Event('input', { bubbles: true })); el.dispatchEvent(new Event('change', { bubbles: true })); } catch(e){}
                        } catch(e){}
                    }

                    // common personal fields
                    safeSet('first_name', p.firstName || p.first_name || p.first || p.fname || '');
                    safeSet('last_name', p.lastName || p.last_name || p.last || p.lname || '');
                    safeSet('birthdate', p.birthdate || p.birth_date || p.dob || p.dateOfBirth || p.age || '');
                    safeSet('email', p.email || '');
                    safeSet('phone', p.phone || p.mobile || '');
                    safeSet('address', p.address || '');
                    safeSet('username', parsed.username || p.username || '');

                    // dsType if present
                    const dsVal = parsed.dsType || parsed.ds_type || p.dsType || p.ds_type || parsed.r_dsType || '';
                    if (dsVal) safeSet('dsType', dsVal);

                    // guardian
                    safeSet('guardian_first', (parsed.guardian_first || p.guardian_first || p.guardian_first_name || ''));
                    safeSet('guardian_last', (parsed.guardian_last || p.guardian_last || p.guardian_last_name || ''));
                    safeSet('guardian_email', (parsed.guardian_email || p.guardian_email || ''));
                    safeSet('guardian_phone', (parsed.guardian_phone || p.guardian_phone || ''));
                    safeSet('guardian_relationship', (parsed.guardian_relationship || p.guardian_relationship || p.relationship || ''));
                                    // additional guardian fields
                                    safeSet('guardian_middle', (parsed.guardian_middle || p.guardian_middle || parsed.guardian_middle_name || ''));
                                    safeSet('guardian_birthdate', (parsed.guardian_birthdate || parsed.guardian_birth_date || p.guardian_birthdate || ''));
                                    safeSet('guardian_home_phone', (parsed.guardian_home_phone || p.guardian_home_phone || ''));
                                    safeSet('guardian_work_phone', (parsed.guardian_work_phone || p.guardian_work_phone || ''));
                                    safeSet('guardian_work_address', (parsed.guardian_work_address || p.guardian_work_address || ''));

                                    // spouse
                                    safeSet('spouse_first', (parsed.spouse_first || p.spouse_first || ''));
                                    safeSet('spouse_last', (parsed.spouse_last || p.spouse_last || ''));
                                    safeSet('spouse_middle', (parsed.spouse_middle || p.spouse_middle || ''));
                                    safeSet('spouse_email', (parsed.spouse_email || p.spouse_email || ''));
                                    safeSet('spouse_phone', (parsed.spouse_phone || p.spouse_phone || ''));
                                    safeSet('spouse_home_phone', (parsed.spouse_home_phone || p.spouse_home_phone || ''));
                                    safeSet('spouse_work_phone', (parsed.spouse_work_phone || p.spouse_work_phone || ''));
                                    safeSet('spouse_birthdate', (parsed.spouse_birthdate || p.spouse_birthdate || ''));
                                    safeSet('spouse_relationship', (parsed.spouse_relationship || p.spouse_relationship || ''));
                                    safeSet('spouse_work_address', (parsed.spouse_work_address || p.spouse_work_address || ''));

                    // password + confirm
                    const pwd = parsed.password || p.password || '';
                    if (pwd) {
                        safeSet('password', pwd);
                        safeSet('confirmPassword', pwd);
                    }

                    // If uploads stored under admin keys, ensure previews are initialized by re-calling setupUpload
                    try { if (typeof setupUpload === 'function') { setupUpload('proofFile','proofDisplay','proofLabel','proofHint'); setupUpload('pwdidFile','pwdidDisplay','pwdidLabel','pwdidHint'); setupUpload('medFile','medDisplay','medLabel','medHint'); } } catch(e){}
                } catch(e) {
                    console.warn('[restore] could not apply draft', e);
                }
            });
            </script>

</body>

</html>
