<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <style>
    :root {
      color-scheme: light;
    }
    body {
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background-color: #f8fafc;
      color: #0f172a;
      min-height: 100vh;
      line-height: 1.6;
    }
    button, input, select, textarea {
      font: inherit;
    }
    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0,0,0,0);
      white-space: nowrap;
      border: 0;
    }
    button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible, a:focus-visible {
      outline: 3px solid #2563eb;
      outline-offset: 3px;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.24);
    }
    input, select, textarea {
      min-height: 3rem;
      border-width: 1px;
      border-style: solid;
      border-color: #cbd5e1;
    }
    .main-container h1 {
      font-size: clamp(1.8rem, 3.6vw, 3rem);
      line-height: 1.05;
    }
    .main-container h2, .main-container h3 {
      font-size: clamp(1.2rem, 2.2vw, 1.6rem);
    }
    .main-container .text-gray-600.italic {
      font-size: 0.95rem;
    }
    .main-container .bg-white.rounded-2xl {
      padding: 1.25rem;
    }
    .main-container .upload-error {
      font-size: 0.95rem;
      min-height: 1.25rem;
    }
    .tts-btn {
      padding: 0.65rem 0.75rem;
      border-radius: 9999px;
      transition: transform 0.2s ease, background-color 0.2s ease;
    }
    .tts-btn:hover,
    .tts-btn:focus-visible {
      transform: scale(1.05);
    }
    .help-text {
      font-size: 0.95rem;
      color: #475569;
    }
    .help-text.italic {
      font-style: italic;
    }
    .card-note {
      font-size: 0.95rem;
      color: #334155;
    }
    .button-primary {
      transition: transform 0.2s ease, background-color 0.2s ease;
    }
    .button-primary:hover {
      transform: translateY(-1px);
    }
    .button-primary:focus-visible {
      outline: 3px solid #2563eb;
      outline-offset: 3px;
    }
    .section-card,
    .resume-card,
    .pwdid-card,
    .medical-card,
    .fit-card {
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      gap: 0.75rem;
      min-height: auto;
      padding: 1.25rem;
      background-color: #ffffff;
      border-radius: 1.5rem;
      border: 1px solid #e2e8f0;
    }
    .section-card {
      box-shadow: 0 12px 24px rgba(15, 23, 42, 0.05);
    }
    .info-card,
    .resume-card,
    .pwdid-card,
    .medical-card,
    .fit-card {
      background-color: #eff6ff;
      border-color: #bfdbfe;
    }
    @media (max-width: 640px) {
      body {
        font-size: 15px;
      }
      .main-container {
        padding: 0.75rem;
      }
      .section-card {
        width: calc(100% + 2rem);
        max-width: none;
        margin-left: -1rem;
        margin-right: -1rem;
        padding: 1rem;
      }
      .tts-btn {
        padding: 0.8rem;
        font-size: 1rem;
      }
      input, select, textarea {
        font-size: 1rem;
        padding: 0.75rem 0.9rem;
      }
    }
    </style>

</head>

<body class="bg-slate-50">

    <!-- Skip to main content link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50 focus:outline-none focus:ring-2 focus:ring-blue-300">Skip to main content</a>

    <!-- BACK BUTTON -->
    <nav class="bg-sky-50 border-b border-sky-100 py-4 px-6 sm:px-10 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('dataprivacy') }}"
               class="inline-flex items-center gap-3 text-blue-700 font-semibold text-base sm:text-lg hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
               aria-label="Go back">
                <img src="https://img.icons8.com/ios-filled/24/1E40AF/left.png" alt="" aria-hidden="true"/>
                <span>Back</span>
            </a>
        </div>
    </nav>


    <!-- JOB HEADER -->
    <main id="main-content" role="main" aria-labelledby="job-title" class="main-container max-w-7xl mx-auto w-full px-6 sm:px-10 lg:px-12 py-8 sm:py-10">

        <!-- HEADER CARD -->
        <article class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm mb-8">

            <div class="flex flex-col lg:flex-row justify-between gap-8 items-start lg:items-center">

                <!-- COMPANY & JOB INFO -->
                <div class="flex items-start gap-5 flex-1">

                    <!-- LOGO -->
                    <div class="flex-shrink-0">
                        <img id="job-logo-img"
                             class="w-20 h-20 rounded-xl border border-slate-300 object-cover hidden"
                             alt="Company logo">

                        <div id="job-logo-fallback"
                             class="w-20 h-20 bg-sky-100 rounded-xl flex items-center justify-center border border-slate-200">
                            <i class="ri-user-line text-sky-600 text-3xl" aria-hidden="true"></i>
                        </div>
                    </div>

                    <!-- JOB DETAILS -->
                    <div class="flex-1 min-w-0">
                        <h1 id="job-title" class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                            Account Registration
                        </h1>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-lg text-slate-700">
                                <span class="font-semibold">Create your account and save your profile</span>
                            </div>

                            <div class="flex flex-wrap gap-4 text-lg text-slate-600">
                                <div class="flex items-center gap-2">
                                    <i class="ri-time-line text-slate-500 text-xl" aria-hidden="true"></i>
                                    <span>Complete all sections</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-sky-50 border border-sky-100 rounded-3xl p-5 mt-6">
                        <p class="text-slate-700 text-base sm:text-lg">
                            <strong>Note:</strong> Fields marked with a star <span aria-hidden="true">⭐</span> are required.
                        </p>
                        <p class="text-slate-600 text-sm sm:text-base mt-2">
                            Please fill in all required fields before moving to the next step.
                        </p>
                    </div>
                </div>
            </article>

        <!-- FORM CONTENT -->
        <div class="grid grid-cols-1 gap-8">

            <!-- LEFT COLUMN - FORM SECTIONS -->
            <div class="space-y-8">

            <!-- Resume Upload Section -->
            <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Section Title with TTS -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl sm:text-2xl font-bold text-blue-600">
                        Resume Upload
                    </h3>
                    <button type="button" aria-label="Play audio for resume upload section"
                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                        data-tts-en="Upload your resume to help auto-fill the registration form."
                        data-tts-tl="I-upload ang iyong resume upang makatulong sa automatic na paglagay ng mga impormasyon sa pagpaparehistro.">
                        🔊
                    </button>
                </div>

                <!-- Instruction -->
                <p class="text-gray-700 font-semibold text-lg mb-2">
                    Upload your resume to help fill in your information. 
                </p>
                <p class="text-blue-700 text-md mb-2">
                    If you do not have a resume, that is okay. You can type your details instead.
                </p>
                <p class="text-gray-700 italic text-md mb-4">
                    (Kung walang resume, okay lang. Pwede mong ilagay ang iyong impormasyon sa susunod na mga tanong.)
                </p>

                <!-- Resume Upload Card -->
                <div class="mt-4 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-8 resume-card">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">

                        <!-- Upload Info -->
                        <div class="flex-1 text-center sm:text-left">
                            <p class="text-gray-700 text-lg sm:text-base mb-1">
                                Upload or capture your resume (PDF, DOC, DOCX, or image).
                            </p>
                            <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                                (Mag-upload o kumuha ng larawan ng iyong resume sa PDF, DOC, DOCX, o image.)
                            </p>
                            <p class="text-gray-600 text-sm sm:text-base">
                                Accepted: <b>.pdf .doc .docx .jpg .jpeg .png</b> • Max size: <b>5MB</b>
                            </p>
<div id="resumeDisplay" class="mt-2 help-text" aria-live="polite"></div>
                        </div>

                        <!-- Upload Button -->
                        <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-3">
                            <div class="w-full sm:w-auto text-center sm:text-right">
                                <label id="resumeLabel" for="resumeFile" class="inline-flex items-center justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-4 py-2 rounded-lg transition shadow-md cursor-pointer">
                                    📁 Upload/Capture Resume
                                </label>
                                <input id="resumeFile" name="resume" type="file" accept=".pdf,.doc,.docx,image/*" capture="environment" class="hidden" />
                                <div id="resumeHint" class="text-gray-500 text-sm italic mt-1">Please upload or capture your resume.</div>
                            </div>
                            <div class="upload-error text-sm text-red-600 w-full text-center sm:text-right"></div>
                        </div>

                    </div>

                </div>

            </div>



<!-- Personal Information -->
<div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

    <!-- Section Title with TTS -->
    <div class="flex justify-between items-center mb-4">
        <h3 id="personal-info-heading" class="text-xl sm:text-2xl font-bold text-blue-600">
            Personal Information
        </h3>
        <button type="button" aria-label="Play audio for personal information section"
            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
            data-tts-en="Fill out your personal information including name, birthdate, contact details, and address."
            data-tts-tl="Punan ang iyong personal na impormasyon kabilang ang pangalan, petsa ng kapanganakan, detalye ng contact, at address.">
            🔊
        </button>
    </div>

    <!-- English Instruction -->
    <p class="text-gray-700 font-semibold text-lg mb-2">
        Please upload your PWD ID for verification.<span>⭐</span>
    </p>

    <!-- Tagalog Instruction -->
    <p class="text-gray-700 italic text-md flex items-center gap-2">
        (Mag upload ng iyong PWD ID para sa verification.)
        <button type="button"
            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-2 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
            data-tts-en="Please upload your PWD ID for verification."
            data-tts-tl="Mag upload ng iyong PWD ID para sa verification.">
            🔊
        </button>
    </p>


            <!-- PWD ID Upload Card -->
            <div class="mt-4 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-8 pwdid-card">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">

                    <!-- Upload Info -->
                    <div class="flex-1 text-center sm:text-left">
                        <p class="text-gray-700 text-lg sm:text-base mb-1">
                            Upload or capture an image or PDF of the front and back of your PWD ID.
                        </p>

                        <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                            (Mag-upload o kumuha ng larawan o PDF ng harap at likod ng iyong PWD ID.)
                        </p>

                        <p class="text-gray-600 text-sm sm:text-base">
                            Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                        </p>

                        <div id="pwdidDisplay" class="mt-2 help-text" aria-live="polite"></div>
                    </div>

                    <!-- Upload Button: Front/Back combined (allow 1 or 2 files) -->
                    <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-3">

                        <div class="w-full sm:w-auto text-center sm:text-right">
                            <label id="pwdidLabel" for="pwdidFile" class="inline-flex items-center justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-4 py-2 rounded-lg transition shadow-md cursor-pointer">
                                📁 Upload/Capture Front/Back of ID (1-2 files)
                            </label>
                            <input id="pwdidFile" name="pwd_id[]" type="file" accept=".jpg,.jpeg,.png,.pdf" multiple capture="environment" class="hidden" />
                            <div id="pwdidFileInfo" class="upload-info text-sm text-gray-700 mt-2 justify-center sm:justify-end" aria-live="polite"></div>
                            <p id="pwdidHint" class="text-gray-600 text-xs mt-1">You may upload or capture either the front only, or both front and back (max 2 files).</p>
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
            <fieldset id="type_of_down_syndrome_container" class="mt-8 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm" aria-labelledby="down_syndrome_legend">
                <legend id="down_syndrome_legend" class="font-semibold text-gray-800 text-sm sm:text-lg">
                    What is your Karyotype Result? <span aria-hidden="true">⭐</span>
                </legend>

                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="mt-2 text-gray-700 text-md">
                            Choose the best result from your medical record or doctor's information.
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
                <div class="flex flex-col sm:flex-row sm:gap-6 gap-4" role="radiogroup" aria-labelledby="down_syndrome_legend" aria-describedby="down_syndrome_helper">

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

                <p id="down_syndrome_helper" class="sr-only">Select one option that matches your karyotype result.</p>
            </fieldset>

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
                                        Upload or capture an image or PDF of your Medical Certificate.
                                    </p>
                                    <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                                        (Mag-upload o kumuha ng larawan o PDF ng iyong Medical Certificate.)
                                    </p>
                                    <p class="text-gray-600 text-sm sm:text-base">
                                        Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                                    </p>

                                    <!-- File Info Display -->
                                    <div id="medDisplay" class="mt-2 help-text" aria-live="polite"></div>
                                </div>

                    <!-- Upload Button Section -->
                    <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-2">

                        <label
                            for="medFile"
                            class="block w-full text-center sm:inline-flex sm:w-auto justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-5 py-3 rounded-lg transition shadow-md"
                        >
                            📁 Upload/Capture File / Pumili ng File
                        </label>

                        <input id="medFile" name="medical_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" capture="environment" class="hidden"/>

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
                                                            Upload or capture an image or PDF of your Fit-To-Work Certificate.
                                                        </p>
                                                        <p class="text-gray-700 italic text-sm sm:text-base mb-1">
                                                            (Mag-upload o kumuha ng larawan o PDF ng iyong Fit-To-Work Certificate.)
                                                        </p>
                                                        <p class="text-gray-600 text-sm sm:text-base">
                                                            Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                                                        </p>

                                                        <!-- File Info Display -->
                                                        <div id="fitDisplay" class="mt-2 help-text" aria-live="polite"></div>
                                                    </div>

                                        <!-- Upload Button Section -->
                                        <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-2">

                                            <label
                                                for="fitFile"
                                                id="fitLabel"
                                                class="block w-full text-center sm:inline-flex sm:w-auto justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-5 py-3 rounded-lg transition shadow-md"
                                            >
                                                📁 Upload/Capture File / Pumili ng File
                                            </label>

                                            <input id="fitFile" name="fit_to_work_certificate" type="file" accept=".jpg,.jpeg,.png,.pdf" capture="environment" class="hidden"/>

                                            <div id="fitHint" class="text-gray-500 text-sm italic mt-1">Please upload or capture your Fit-To-Work Certificate.</div>

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
                                                combineGuardianAddressFields();
                                                combineSpouseAddressFields();
                                            });
                                        }
                                    }catch(e){console.warn('address init failed', e);} 
                                });
                            })();
                            
                            // Helper functions for guardian and spouse addresses
                            (function(){
                                function combineGuardianAddressFields(){
                                    try{
                                        const parts = [];
                                        const n = document.getElementById('guardian_address_number');
                                        const s = document.getElementById('guardian_address_street');
                                        const b = document.getElementById('guardian_address_barangay');
                                        const c = document.getElementById('guardian_address_city');
                                        if(n && n.value.trim()) parts.push(n.value.trim());
                                        if(s && s.value.trim()) parts.push(s.value.trim());
                                        if(b && b.value.trim()) parts.push(b.value.trim());
                                        if(c && c.value.trim()) parts.push(c.value.trim());
                                        const combined = parts.join(' ');
                                        const hidden = document.getElementById('guardian_home_address');
                                        if(hidden) hidden.value = combined;
                                        return combined;
                                    }catch(e){ console.warn('combineGuardianAddressFields error', e); return ''; }
                                }

                                function combineSpouseAddressFields(){
                                    try{
                                        const parts = [];
                                        const n = document.getElementById('spouse_address_number');
                                        const s = document.getElementById('spouse_address_street');
                                        const b = document.getElementById('spouse_address_barangay');
                                        const c = document.getElementById('spouse_address_city');
                                        if(n && n.value.trim()) parts.push(n.value.trim());
                                        if(s && s.value.trim()) parts.push(s.value.trim());
                                        if(b && b.value.trim()) parts.push(b.value.trim());
                                        if(c && c.value.trim()) parts.push(c.value.trim());
                                        const combined = parts.join(' ');
                                        const hidden = document.getElementById('spouse_home_address');
                                        if(hidden) hidden.value = combined;
                                        return combined;
                                    }catch(e){ console.warn('combineSpouseAddressFields error', e); return ''; }
                                }

                                document.addEventListener('DOMContentLoaded', function(){
                                    try{
                                        // Guardian address: update hidden whenever any component changes
                                        ['guardian_address_number','guardian_address_street','guardian_address_barangay','guardian_address_city'].forEach(id=>{
                                            const el = document.getElementById(id);
                                            if(!el) return;
                                            el.addEventListener('input', combineGuardianAddressFields);
                                        });

                                        // Spouse address: update hidden whenever any component changes
                                        ['spouse_address_number','spouse_address_street','spouse_address_barangay','spouse_address_city'].forEach(id=>{
                                            const el = document.getElementById(id);
                                            if(!el) return;
                                            el.addEventListener('input', combineSpouseAddressFields);
                                        });
                                        
                                        // Copy address from Personal Information checkbox handler for Guardian
                                        const copyGuardianCheckbox = document.getElementById('copyGuardianAddressFromPersonal');
                                        if(copyGuardianCheckbox){
                                            copyGuardianCheckbox.addEventListener('change', function(){
                                                if(this.checked){
                                                    // Copy personal address to guardian address
                                                    const pNum = document.getElementById('address_number')?.value || '';
                                                    const pStr = document.getElementById('address_street')?.value || '';
                                                    const pBar = document.getElementById('address_barangay')?.value || '';
                                                    const pCit = document.getElementById('address_city')?.value || '';
                                                    
                                                    document.getElementById('guardian_address_number').value = pNum;
                                                    document.getElementById('guardian_address_street').value = pStr;
                                                    document.getElementById('guardian_address_barangay').value = pBar;
                                                    document.getElementById('guardian_address_city').value = pCit;
                                                    combineGuardianAddressFields();
                                                } else {
                                                    // Clear guardian address when unchecked
                                                    document.getElementById('guardian_address_number').value = '';
                                                    document.getElementById('guardian_address_street').value = '';
                                                    document.getElementById('guardian_address_barangay').value = '';
                                                    document.getElementById('guardian_address_city').value = '';
                                                    combineGuardianAddressFields();
                                                }
                                            });
                                        }
                                        
                                        // Copy address from Personal Information checkbox handler for Spouse
                                        const copySpouseCheckbox = document.getElementById('copySpouseAddressFromPersonal');
                                        if(copySpouseCheckbox){
                                            copySpouseCheckbox.addEventListener('change', function(){
                                                if(this.checked){
                                                    // Copy personal address to spouse address
                                                    const pNum = document.getElementById('address_number')?.value || '';
                                                    const pStr = document.getElementById('address_street')?.value || '';
                                                    const pBar = document.getElementById('address_barangay')?.value || '';
                                                    const pCit = document.getElementById('address_city')?.value || '';
                                                    
                                                    document.getElementById('spouse_address_number').value = pNum;
                                                    document.getElementById('spouse_address_street').value = pStr;
                                                    document.getElementById('spouse_address_barangay').value = pBar;
                                                    document.getElementById('spouse_address_city').value = pCit;
                                                    combineSpouseAddressFields();
                                                } else {
                                                    // Clear spouse address when unchecked
                                                    document.getElementById('spouse_address_number').value = '';
                                                    document.getElementById('spouse_address_street').value = '';
                                                    document.getElementById('spouse_address_barangay').value = '';
                                                    document.getElementById('spouse_address_city').value = '';
                                                    combineSpouseAddressFields();
                                                }
                                            });
                                        }
                                    }catch(e){console.warn('guardian/spouse address init failed', e);} 
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

                <h2 class="text-xl font-bold text-blue-600 mb-6 flex justify-between items-center">
                    Parent / Guardian Information
                    <button type="button" aria-label="Play audio for parents guardian section"
                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                        data-tts-en="Provide information about your parents or guardian."
                        data-tts-tl="Magbigay ng impormasyon tungkol sa iyong mga magulang o guardian.">
                        🔊
                    </button>
                </h2>

                <!-- ================= Parents / Guardian ================= -->

                                <!-- Parent / Guardian ID Upload -->
                <div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div>
                            <label class="font-semibold text-gray-800 text-sm sm:text-lg" for="guardianIdFile">
                                Parent / Guardian ID Upload <span>⭐</span>
                            </label>
                            <p class="mt-2 text-gray-700 text-md">
                                Upload or capture a parent/guardian ID for verification.
                            </p>
                            <p class="mt-1 text-gray-600 italic text-sm">
                                (Mag-upload o kumuha ng larawan ng ID ng magulang/guardian para sa verification.)
                            </p>
                        </div>
                        <button type="button" aria-label="Play audio for guardian ID upload section"
                            class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                            data-tts-en="Upload or capture a parent or guardian ID for verification."
                            data-tts-tl="Mag-upload o kumuha ng larawan ng ID ng magulang o guardian para sa verification.">
                            🔊
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                        <div class="flex-1 text-center sm:text-left">
                            <p class="text-gray-700 text-lg sm:text-base mb-1">
                                Accepted: <b>.jpg .jpeg .png .pdf</b> • Max size: <b>5MB</b>
                            </p>
                            <div id="guardianIdDisplay" class="mt-2 help-text" aria-live="polite"></div>
                        </div>

                        <div class="flex-shrink-0 flex flex-col items-center sm:items-end gap-2">
                            <label id="guardianIdLabel" for="guardianIdFile" class="block w-full text-center sm:inline-flex sm:w-auto justify-center bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-semibold px-4 py-3 rounded-lg transition shadow-md cursor-pointer">
                                📁 Upload/Capture Parent ID
                            </label>
                            <input id="guardianIdFile" name="guardian_id" type="file" accept=".jpg,.jpeg,.png,.pdf" capture="environment" class="hidden" />
                            <div id="guardianIdHint" class="text-gray-500 text-sm italic mt-1">Please upload or capture a clear parent/guardian ID.</div>
                            <div class="upload-error text-sm text-red-600"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">

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


                <!-- Home Address -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="font-semibold flex items-center gap-1">
                           Home Address
                        </label>
                    </div>

                    <p class="text-gray-500 italic flex text-sm mt-1">
                        Tirahan (No./Blk/Lot, Street, Barangay, City)
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mt-2">

                        <input id="guardian_address_number" type="text" placeholder="No./Blk/Lot"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="guardian_address_street" type="text" placeholder="Street"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="guardian_address_barangay" type="text" placeholder="Barangay"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="guardian_address_city" type="text" placeholder="City / Municipality"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                    </div>
                        <!-- Checkbox -->
                        <div class="flex justify-end mt-3">
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" id="copyGuardianAddressFromPersonal" class="h-4 w-4 accent-blue-600" />
                                <span class="text-gray-700">Same address from personal information</span>
                            </label>
                        </div>
                        <input id="guardian_home_address" name="g_home_address" type="hidden"/>
                </div>

                {{-- <!-- Divider -->
                <div class="border-t my-8"></div> --}}

                {{-- <!-- ================= Spouse ================= -->
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

                <!-- Home Address -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="font-semibold flex items-center gap-1">Home Address</label>
                    </div>
                    <p class="text-gray-500 italic flex text-sm mt-1">
                        Tirahan (No./Blk/Lot, Street, Barangay, City)
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mt-2">

                        <input id="spouse_address_number" type="text" placeholder="No./Blk/Lot"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="spouse_address_street" type="text" placeholder="Street"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="spouse_address_barangay" type="text" placeholder="Barangay"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                        <input id="spouse_address_city" type="text" placeholder="City / Municipality"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"/>

                    </div>
                        <!-- Checkbox -->
                        <div class="flex justify-end mt-3">
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" id="copySpouseAddressFromPersonal" class="h-4 w-4 accent-blue-600" />
                                <span class="text-gray-700">Same address from personal information</span>
                            </label>
                        </div>
                        <input id="spouse_home_address" name="spouse_home_address" type="hidden"/>
                </div> --}}

            </div>

            <!-- Education Section -->
            <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Section Title with TTS -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl sm:text-2xl font-bold text-blue-600">
                        Education
                    </h3>
                    <button type="button" aria-label="Play audio for education section"
                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                        data-tts-en="Tell us about your education background."
                        data-tts-tl="Sabihin sa amin ang tungkol sa iyong background sa edukasyon.">
                        🔊
                    </button>
                </div>

                <p class="text-gray-700 text-sm sm:text-base mb-4">
                    Please include your school or training history. You may add more than one school or training program if needed.
                    <span class="italic">(Mangyaring ilahad ang iyong kasaysayan sa paaralan o pagsasanay. Maaari kang magdagdag ng higit sa isang paaralan o programang pagsasanay kung kinakailangan.)</span>
                </p>

                <!-- Education Item Container -->
                <div id="educationContainer" class="space-y-6">
                    <div class="education-item bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <div class="flex justify-end mb-4">
                            <button type="button" onclick="removeEducation(this)"
                                class="remove-education bg-red-100 text-red-700 px-3 py-1.5 rounded-lg text-xs sm:text-sm font-medium hover:bg-red-200 transition"
                                aria-label="Remove this education entry">
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/graduation-cap.png" alt="Education level icon" class="w-5 h-5" />
                                    Education Level
                                </label>
                                <select name="education_level[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                    <option value="" disabled selected class="text-gray-400">Select Level</option>
                                    <option>Elementary</option>
                                    <option>Highschool</option>
                                    <option>College</option>
                                    <option>Vocational / Training</option>
                                    <option>SPED Program</option>
                                </select>
                            </div>

                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/company.png" alt="School icon" class="w-5 h-5" />
                                    School / Training Center
                                </label>
                                <input type="text" name="education_school[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="Enter school name" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/book.png" alt="Course icon" class="w-5 h-5" />
                                    Course / Program
                                </label>
                                <input type="text" name="education_program[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="Example: Food Preparation Training" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">
                                <div>
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/calendar.png" alt="Start year icon" class="w-5 h-5" />
                                        Year Started
                                    </label>
                                    <input type="number" name="education_start[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="e.g. 2018" min="1900" max="2100" />
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/calendar.png" alt="End year icon" class="w-5 h-5" />
                                        Year Completed
                                    </label>
                                    <input type="number" name="education_end[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="e.g. 2022" min="1900" max="2100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="button" onclick="addEducation()" class="bg-[#2E2EFF] text-white font-medium text-xs sm:text-base px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-600 transition inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another School / Training
                    </button>
                </div>

                <div class="mt-8">
                    <div class="text-left px-2 sm:px-4">
                        <label class="text-xl sm:text-2xl font-bold text-blue-600 flex items-center justify-between gap-2">
                            <span>Do you have any certificates or special trainings?</span>
                            <button type="button"
                                class="bg-[#1E40AF] hover:bg-blue-700 text-white p-2 sm:p-3 rounded-full shadow-md tts-btn text-base sm:text-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400"
                                data-tts-en="Do you have any certificates or special trainings?"
                                data-tts-tl="May mga certificate o special training ka ba?"
                                aria-label="Play audio for other option">🔊</button>
                        </label>

                        <p class="text-gray-700 italic text-md flex items-center gap-2">(May mga certificate o special training ka ba?)</p>

                        <div class="flex items-center gap-6 mt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" id="certYes" name="certs" value="yes"
                                    class="text-blue-600 focus:ring-blue-400 w-5 h-5" />
                                <span class="text-gray-800 text-sm sm:text-base">Yes</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" id="certNo" name="certs" value="no"
                                    class="text-blue-600 focus:ring-blue-400 w-5 h-5" />
                                <span class="text-gray-800 text-sm sm:text-base">No</span>
                            </label>
                        </div>
                    </div>

                    <div id="cert_section" class="hidden mt-6 bg-gray-50 border border-gray-200 rounded-2xl p-6">
                        <p class="text-gray-700 text-sm sm:text-base mb-3">
                            Please upload your certificates or training documents to help verify your qualifications.
                        </p>

                        <div class="flex items-center justify-between gap-4 mb-2">
                            <div class="text-sm font-semibold text-gray-800">Upload Certificate / Training Document</div>
                            <div class="flex-shrink-0">
                                <label id="educationCertLabel" for="education_cert_file" class="cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 sm:w-5 sm:h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Choose File</span>
                                </label>
                                <input id="education_cert_file" name="education_cert_file" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" />
                            </div>
                        </div>

                        <div id="educationCertDisplay" class="mt-3"></div>
                        <p id="educationCertHint" class="text-gray-500 italic text-xs mt-2">Supported formats: PDF, JPG, JPEG, PNG.</p>
                    </div>
                </div>

                <template id="education_template">
                    <div class="education-item bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <div class="flex justify-end mb-4">
                            <button type="button" onclick="removeEducation(this)"
                                class="remove-education bg-red-100 text-red-700 px-3 py-1.5 rounded-lg text-xs sm:text-sm font-medium hover:bg-red-200 transition"
                                aria-label="Remove this education entry">
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/graduation-cap.png" alt="Education level icon" class="w-5 h-5" />
                                    Education Level
                                </label>
                                <select name="education_level[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                    <option value="" disabled selected class="text-gray-400">Select Level</option>
                                    <option>Elementary</option>
                                    <option>Highschool</option>
                                    <option>College</option>
                                    <option>Vocational / Training</option>
                                    <option>SPED Program</option>
                                </select>
                            </div>

                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/company.png" alt="School icon" class="w-5 h-5" />
                                    School / Training Center
                                </label>
                                <input type="text" name="education_school[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="Enter school name" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/book.png" alt="Course icon" class="w-5 h-5" />
                                    Course / Program
                                </label>
                                <input type="text" name="education_program[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="Example: Food Preparation Training" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">
                                <div>
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/calendar.png" alt="Start year icon" class="w-5 h-5" />
                                        Year Started
                                    </label>
                                    <input type="number" name="education_start[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="e.g. 2018" min="1900" max="2100" />
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-800 flex items-center gap-2">
                                        <img src="https://img.icons8.com/fluency/24/calendar.png" alt="End year icon" class="w-5 h-5" />
                                        Year Completed
                                    </label>
                                    <input type="number" name="education_end[]" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="e.g. 2022" min="1900" max="2100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <script>
                    window.addEducation = function() {
                        const container = document.getElementById('educationContainer');
                        const template = document.getElementById('education_template');
                        if (!container || !template) return;
                        const clone = template.content.firstElementChild.cloneNode(true);
                        container.appendChild(clone);
                    };

                    window.removeEducation = function(button) {
                        const item = button.closest('.education-item');
                        const container = document.getElementById('educationContainer');
                        if (!item || !container) return;
                        if (container.children.length > 1) {
                            item.remove();
                        }
                    };

                    document.addEventListener('change', function(event) {
                        if (!event.target.matches('input[name="certs"]')) return;
                        const certSection = document.getElementById('cert_section');
                        if (!certSection) return;
                        certSection.classList.toggle('hidden', event.target.value !== 'yes');
                    });
                </script>

            </div>

            <!-- Work Experience Section -->
            <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Section Title with TTS -->
                <div class="mb-3 flex items-start justify-between">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-blue-600">Work Experiences</h3>
                        <p class="text-gray-600 italic text-sm sm:text-base mt-1">(Add all your work experiences)</p>
                    </div>
                    <button type="button" class="hidden sm:inline-block bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-md tts-btn" data-tts-en="Add details about your work experiences. You can add multiple entries." data-tts-tl="Maglagay ng impormasyon tungkol sa iyong mga karanasan sa trabaho." aria-label="Play audio for work experiences">🔊</button>
                </div>

                <p class="text-gray-700 text-sm sm:text-base mb-4">
                    Please add your previous work experiences below. Include your job title, employer, location, the period you worked there, and a brief description.
                </p>

                <div id="job_experiences_container" class="space-y-6">
                    <div class="job_exp_item bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-sm text-gray-600 italic">Fill in one entry per work experience</div>
                            <button type="button" onclick="removeJobExperience(this)" class="remove-job text-[#A21A1A] text-xs sm:text-sm bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg font-medium transition-colors duration-200">Remove</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/briefcase.png" alt="Job title icon" class="w-5 h-5" />
                                    Job Title
                                </label>
                                <input list="job-title-options" name="job_title[]" class="job_title w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="Select or type your job (e.g. Kitchen Helper)" />
                            </div>

                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/company.png" alt="Company icon" class="w-5 h-5" />
                                    Company Name
                                </label>
                                <input name="company_name[]" class="company_name w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="e.g., McDonald's" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/map-pin.png" alt="Location icon" class="w-5 h-5" />
                                    Company Location
                                </label>
                                <input type="text" name="company_location[]" class="company_location w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="e.g., Taguig City" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/calendar.png" alt="Calendar icon" class="w-5 h-5" />
                                    Work Period
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <p class="text-xs text-gray-600 mb-2">Start</p>
                                        <div class="flex gap-2">
                                            <select name="job_start_month[]" class="job_start_month w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                                <option>Month</option>
                                                <option>January</option><option>February</option><option>March</option>
                                                <option>April</option><option>May</option><option>June</option>
                                                <option>July</option><option>August</option><option>September</option>
                                                <option>October</option><option>November</option><option>December</option>
                                            </select>
                                            <input type="text" name="job_start_year[]" placeholder="Year" class="job_start_year w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" />
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-600 mb-2">End</p>
                                        <div class="flex gap-2">
                                            <select name="job_end_month[]" class="job_end_month w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                                <option>Month</option>
                                                <option>January</option><option>February</option><option>March</option>
                                                <option>April</option><option>May</option><option>June</option>
                                                <option>July</option><option>August</option><option>September</option>
                                                <option>October</option><option>November</option><option>December</option>
                                            </select>
                                            <input type="text" name="job_end_year[]" placeholder="Year / Present" class="job_end_year w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/document.png" alt="Document icon" class="w-5 h-5" />
                                    Job Description
                                </label>
                                <textarea name="job_description[]" class="job_description w-full border border-gray-300 rounded-lg p-3 h-20 resize-none focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="What you did (e.g. cleaned tables, organized shelves)"></textarea>
                            </div>

                            <div class="md:col-span-2 mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5">
                                <div class="flex flex-col gap-3">
                                    <div class="sm:flex sm:items-start sm:justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <label class="text-gray-700 text-md flex items-center gap-2">
                                                Upload an image or PDF of your Certificates.<span class="font-semibold italic text-sm sm:text-md text-red-600">*required</span>
                                            </label>
                                            <p class="text-gray-700 italic text-md mt-1 leading-relaxed">
                                                (Mag-upload ng larawan o PDF ng iyong Certificates)
                                            </p>
                                            <p class="text-gray-600 text-md mt-4 leading-relaxed">
                                                Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b>
                                            </p>
                                            <div class="job_cert_display mt-3 text-sm text-gray-700"></div>
                                        </div>

                                        <div class="flex-shrink-0">
                                            <label class="inline-flex items-center justify-center w-full sm:w-auto mt-2 cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
                                                📁 Choose File / Pumili ng File
                                                <input type="file" name="job_cert_file[]" accept=".jpg,.jpeg,.png,.pdf" class="job_cert_file hidden" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <template id="job_exp_template">
                    <div class="job_exp_item bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-sm text-gray-600 italic">Fill in one entry per work experience</div>
                            <button type="button" onclick="removeJobExperience(this)" class="remove-job text-[#A21A1A] text-xs sm:text-sm bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg font-medium transition-colors duration-200">Remove</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/briefcase.png" alt="Job title icon" class="w-5 h-5" />
                                    Job Title
                                </label>
                                <input list="job-title-options" name="job_title[]" class="job_title w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="Select or type your job (e.g. Kitchen Helper)" />
                            </div>

                            <div>
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/company.png" alt="Company icon" class="w-5 h-5" />
                                    Company Name
                                </label>
                                <input name="company_name[]" class="company_name w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="e.g., McDonald's" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/map-pin.png" alt="Location icon" class="w-5 h-5" />
                                    Company Location
                                </label>
                                <input type="text" name="company_location[]" class="company_location w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="e.g., Taguig City" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/calendar.png" alt="Calendar icon" class="w-5 h-5" />
                                    Work Period
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <p class="text-xs text-gray-600 mb-2">Start</p>
                                        <div class="flex gap-2">
                                            <select name="job_start_month[]" class="job_start_month w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                                <option>Month</option>
                                                <option>January</option><option>February</option><option>March</option>
                                                <option>April</option><option>May</option><option>June</option>
                                                <option>July</option><option>August</option><option>September</option>
                                                <option>October</option><option>November</option><option>December</option>
                                            </select>
                                            <input type="text" name="job_start_year[]" placeholder="Year" class="job_start_year w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" />
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-600 mb-2">End</p>
                                        <div class="flex gap-2">
                                            <select name="job_end_month[]" class="job_end_month w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800">
                                                <option>Month</option>
                                                <option>January</option><option>February</option><option>March</option>
                                                <option>April</option><option>May</option><option>June</option>
                                                <option>July</option><option>August</option><option>September</option>
                                                <option>October</option><option>November</option><option>December</option>
                                            </select>
                                            <input type="text" name="job_end_year[]" placeholder="Year / Present" class="job_end_year w-1/2 border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-gray-800 flex items-center gap-2">
                                    <img src="https://img.icons8.com/fluency/24/document.png" alt="Document icon" class="w-5 h-5" />
                                    Job Description
                                </label>
                                <textarea name="job_description[]" class="job_description w-full border border-gray-300 rounded-lg p-3 h-20 resize-none focus:ring-2 focus:ring-blue-200 focus:outline-none text-gray-800" placeholder="What you did (e.g. cleaned tables, organized shelves)"></textarea>
                            </div>

                            <div class="md:col-span-2 mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5">
                                <div class="flex flex-col gap-3">
                                    <div class="sm:flex sm:items-start sm:justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <label class="text-gray-700 text-md flex items-center gap-2">
                                                Upload an image or PDF of your Certificates.<span class="font-semibold italic text-sm sm:text-md text-red-600">*required</span>
                                            </label>
                                            <p class="text-gray-700 italic text-md mt-1 leading-relaxed">
                                                (Mag-upload ng larawan o PDF ng iyong Certificates)
                                            </p>
                                            <p class="text-gray-600 text-md mt-4 leading-relaxed">
                                                Accepted file types: <b>.jpg, .jpeg, .png, .pdf</b> — Max size: <b>5MB</b>
                                            </p>
                                            <div class="job_cert_display mt-3 text-sm text-gray-700"></div>
                                        </div>

                                        <div class="flex-shrink-0">
                                            <label class="inline-flex items-center justify-center w-full sm:w-auto mt-2 cursor-pointer bg-[#2E2EFF] hover:bg-blue-700 text-white text-sm sm:text-base font-medium px-4 py-2 sm:px-6 sm:py-3 rounded-lg transition">
                                                📁 Choose File / Pumili ng File
                                                <input type="file" name="job_cert_file[]" accept=".jpg,.jpeg,.png,.pdf" class="job_cert_file hidden" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="mt-4 text-center">
                    <button type="button" onclick="addJobExperience()" class="bg-[#2E2EFF] text-white font-medium text-xs sm:text-base px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-600 transition inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another Work Experience
                    </button>
                </div>

                <datalist id="job-title-options">
                    <option value="Customer Assistant"></option>
                    <option value="Merchandising Assistant"></option>
                    <option value="Stockroom Helper"></option>
                    <option value="Office Helper"></option>
                    <option value="Service Crew"></option>
                    <option value="Store Utility / Cleaner"></option>
                    <option value="Front Desk Helper"></option>
                    <option value="Housekeeping Assistant"></option>
                </datalist>

                <script>
                    window.addJobExperience = function() {
                        const container = document.getElementById('job_experiences_container');
                        const template = document.getElementById('job_exp_template');
                        if (!container || !template) return;
                        const clone = template.content.firstElementChild.cloneNode(true);
                        container.appendChild(clone);
                    };

                    window.removeJobExperience = function(button) {
                        const item = button.closest('.job_exp_item');
                        const container = document.getElementById('job_experiences_container');
                        if (!item || !container) return;
                        if (container.children.length > 1) {
                            item.remove();
                        }
                    };

                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('job_experiences_container');
                        if (container && container.children.length === 0) {
                            window.addJobExperience();
                        }
                    });
                </script>

            </div>

            <!-- Account Details -->
             <div class="section-card bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-gray-200">

                <!-- Section Title with TTS -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl sm:text-2xl font-bold text-blue-600">
                       Account Details
                    </h3>
                    <button type="button" aria-label="Play audio for account details section"
                        class="bg-[#1E40AF] hover:bg-blue-700 text-white text-lg p-3 rounded-full shadow-lg transition-transform hover:scale-110 focus:ring-2 focus:ring-blue-400 tts-btn"
                        data-tts-en="Create your account username and password."
                        data-tts-tl="Gumawa ng iyong username at password para sa account.">
                        🔊
                    </button>
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
                    <div class="relative">
                        <label for="password" class="font-semibold flex items-center gap-1">Create Password
                            <span>⭐</span></label>
                        <input   id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="Enter your password"
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                                    title="Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and be 8+ characters long."
                                    class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                            <button type="button" id="showCreatePassword"
                                class="toggle-password absolute right-2 top-9 bg-transparent text-sm text-gray-600 px-3 py-1 rounded"
                                data-target="password" aria-pressed="false">Show</button>
                            <p id="passwordMessage" class="mt-1 text-sm text-red-500 italic hidden">
                                Password must have at least 1 uppercase, 1 lowercase, 1 number, and be 8+ characters long.
                            </p>
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
                <div class="mt-6 relative">
                    <label for="confirmPassword" class="font-semibold text-base flex items-center gap-1">Confirm
                        Password <span>⭐</span></label>
                    <input id="confirmPassword" name="confirmPassword" type="password"
                        placeholder="Re-enter your password"
                        class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 focus:ring-2 focus:ring-blue-300 focus:outline-none shadow-sm transition" />
                    <button type="button" id="showConfirmPassword"
                        class="toggle-password absolute right-2 top-9 bg-transparent text-sm text-gray-600 px-3 py-1 rounded"
                        data-target="confirmPassword" aria-pressed="false">Show</button>
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
        // Success: no intrusive alert — caller will show confirmation via modal
        return true; 
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setupUpload('proofFile', 'proofDisplay', 'proofLabel', 'proofHint');
    setupUpload('pwdidFile', 'pwdidDisplay', 'pwdidLabel', 'pwdidHint');
    setupUpload('medFile', 'medDisplay', 'medLabel', 'medHint');
    setupUpload('fitFile', 'fitDisplay', 'fitLabel', 'fitHint');
    setupUpload('guardianIdFile', 'guardianIdDisplay', 'guardianIdLabel', 'guardianIdHint');
    try {
        // Password toggle handlers (Show/Hide text buttons)
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (!input) return;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.textContent = 'Hide';
                    this.setAttribute('aria-pressed', 'true');
                } else {
                    input.type = 'password';
                    this.textContent = 'Show';
                    this.setAttribute('aria-pressed', 'false');
                }
            });
        });
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
    // Try native Date parse first (handles many ISO and text formats)
    try {
        const d = new Date(raw);
        if (!Number.isNaN(d.getTime())) {
            const dd = d.getDate();
            const mm = months[d.getMonth()];
            const yyyy = d.getFullYear();
            return `${mm} ${dd}, ${yyyy}`;
        }
    } catch(e) {}

    const s = String(raw).trim();
    // ISO-like yyyy-mm-dd
    const mIso = s.match(/^(\d{4})-(\d{2})-(\d{2})/);
    if (mIso) {
        const yyyy = mIso[1];
        const mmIdx = parseInt(mIso[2],10) - 1;
        const dd = parseInt(mIso[3],10);
        const mm = months[mmIdx] || mIso[2];
        return `${mm} ${dd}, ${yyyy}`;
    }

    // Common numeric formats: assume dd/mm/yyyy or dd-mm-yyyy (Philippine-style)
    const mDMY = s.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
    if (mDMY) {
        let day = parseInt(mDMY[1],10);
        let mon = parseInt(mDMY[2],10);
        const year = parseInt(mDMY[3],10);
        // Heuristic: if first part > 12, treat as day; otherwise assume day-first (dd/mm/yyyy)
        if (day <= 12 && mon > 12) {
            // unlikely, swap to keep valid month
            const tmp = day; day = mon; mon = tmp;
        }
        const mm = months[(mon - 1)] || mon;
        return `${mm} ${day}, ${year}`;
    }

    // Numeric US-style mm/dd/yyyy
    const mMDY = s.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
    if (mMDY) {
        const mon = parseInt(mMDY[1],10);
        const day = parseInt(mMDY[2],10);
        const year = parseInt(mMDY[3],10);
        if (mon >=1 && mon <=12 && day >=1 && day <=31) {
            const mm = months[(mon - 1)] || mon;
            return `${mm} ${day}, ${year}`;
        }
    }

    // Month name formats: e.g. "February 24, 2004" or "24 February 2004"
    try {
        const monthNames = {
            jan:1, feb:2, mar:3, apr:4, may:5, jun:6, jul:7, aug:8, sep:9, sept:9, oct:10, nov:11, dec:12
        };
        // Normalize: remove extra dots and unify spaces
        const t = s.replace(/\./g,'').replace(/\s+/g,' ').trim();

        // Pattern: MonthName DD, YYYY  (e.g., February 24, 2004) or MonthName D YYYY
        const pat1 = t.match(/^([A-Za-z]+)\s+(\d{1,2})(?:st|nd|rd|th)?,?\s*(\d{4})$/i);
        if (pat1) {
            const mStr = pat1[1].toLowerCase().slice(0,3);
            const mon = monthNames[mStr] || NaN;
            const day = parseInt(pat1[2],10);
            const year = parseInt(pat1[3],10);
            if (!Number.isNaN(mon)) return `${months[mon-1]} ${day}, ${year}`;
        }

        // Pattern: DD MonthName YYYY (e.g., 24 February 2004 or 24th Feb 2004)
        const pat2 = t.match(/^(\d{1,2})(?:st|nd|rd|th)?[\s,\-]+([A-Za-z]+),?\s*(\d{4})$/i);
        if (pat2) {
            const day = parseInt(pat2[1],10);
            const mStr = pat2[2].toLowerCase().slice(0,3);
            const mon = monthNames[mStr] || NaN;
            const year = parseInt(pat2[3],10);
            if (!Number.isNaN(mon)) return `${months[mon-1]} ${day}, ${year}`;
        }
    } catch(e) {}

    // Fallback: return first 10 chars
    return s.slice(0,10);
}

// Apply OCR'd AI data into matching form fields when possible
function applyOcrDataToForm(aiData, detectedType, ocrtype) {
    try {
        if (!aiData || typeof aiData !== 'object') return;

        // SECURITY: Do NOT autofill form fields from PWD ID OCR results.
        // Only allow autofill from resume OCR. PWD ID is for verification only.
        try {
            const ot = String(ocrtype || '').toLowerCase();
            const dt = String(detectedType || '').toLowerCase();
            if (ot.includes('pwd') || dt.includes('pwd')) {
                console.info('applyOcrDataToForm: skipping autofill for PWD ID', ocrtype, detectedType);
                return;
            }
        } catch (e) { /* ignore and proceed only if values are present */ }

        // Name -> first / last / middle (accept many possible keys)
        try {
            const firstEl = document.getElementById('first_name');
            const lastEl = document.getElementById('last_name');
            const midEl = document.getElementById('middle_name');

            // possible name keys returned by various OCR heuristics/models
            const firstKeys = ['first_name','given_name','givenName','forename','firstname'];
            const lastKeys = ['last_name','family_name','familyName','surname','lastname'];
            const fullKeys = ['name','full_name','fullname','fullName','candidate_name','applicant_name'];
            const middleKeys = ['middle_name','middle','mname','middle_initial','mi'];

            // helper to pick first present key
            const pick = (keys) => { for (const k of keys) if (aiData[k]) return aiData[k]; return null; };

            // heuristic to detect and reject section-heading-like strings (e.g. SUMMARY, CAREER)
            const STOP_WORDS = ['summary','career','objective','profile','experience','education','skills','references','contact','contacts','email','phone','address'];
            const isLikelyName = (s) => {
                if (!s) return false;
                const raw = String(s).trim();
                if (!raw) return false;
                const low = raw.toLowerCase();
                // reject if contains any stopword as a whole token
                for (const w of STOP_WORDS) if (new RegExp('\\b'+w+'\\b').test(low)) return false;
                // If the text is ALL UPPERCASE it may be either a heading or a name in uppercase.
                // Accept uppercase when it looks like a multi-word person name (e.g. "JOHN A DOE").
                if (raw === raw.toUpperCase()) {
                    const parts = raw.split(/\s+/).filter(Boolean);
                    // require at least two words and alphabetic-like tokens to accept as a name
                    const allAlpha = parts.length >= 2 && parts.every(p => /^[A-Z][A-Z'\-]+$/.test(p));
                    if (!allAlpha) return false;
                }
                // otherwise accept (basic check: at least one alphabetic char)
                return /[A-Za-z]/.test(raw);
            };

            const fvalRaw = pick(firstKeys);
            const lvalRaw = pick(lastKeys);
            const mvalRaw = pick(middleKeys);
            const fullRaw = pick(fullKeys) || aiData.name || null;

            let fval = fvalRaw ? String(fvalRaw).trim() : null;
            let lval = lvalRaw ? String(lvalRaw).trim() : null;
            let mval = mvalRaw ? String(mvalRaw).trim() : null;
            let full = fullRaw ? String(fullRaw).trim() : null;

            // If OCR returned an address-like value as `name`, treat it as invalid and
            // attempt to extract a proper person-name from raw_text/pages instead.
            try {
                if (full && /\b(brgy|barangay|street|road|lane|blk|lot|philippines|province|municipality)\b/i.test(full)) {
                    full = null;
                }
            } catch (e) {}

            // Fallback: search raw_text or page texts for an UPPERCASE name line (common OCR pattern)
            if (!full) {
                try {
                    const rawText = (aiData.raw_text || (Array.isArray(aiData.pages) ? aiData.pages.map(p=>p.text||'').join('\n') : '')) || '';
                    if (rawText) {
                        const lines = rawText.split(/\r?\n/).map(l=>l.trim()).filter(Boolean);
                        for (const ln of lines) {
                            if (/\b(brgy|barangay|street|philippine|philippines|phone:|email:)/i.test(ln)) continue;
                            // pick lines that are ALL CAPS, alphabetic tokens and 2-4 words long
                            if (ln === ln.toUpperCase() && !/[0-9@]/.test(ln)) {
                                const parts = ln.split(/\s+/).filter(Boolean);
                                if (parts.length >= 2 && parts.length <= 4 && parts.every(p => /^[A-Z'\-\u2019]+$/.test(p))) {
                                    full = ln;
                                    break;
                                }
                            }
                        }
                    }
                } catch(e) {}
            }

            // Validate candidates (reject likely headings)
            if (fval && !isLikelyName(fval)) fval = null;
            if (lval && !isLikelyName(lval)) lval = null;
            if (mval && !isLikelyName(mval)) mval = null;
            if (full && !isLikelyName(full)) full = null;

            if (fval && firstEl) firstEl.value = fval;
            if (lval && lastEl) lastEl.value = lval;
            if (mval && midEl && !midEl.value) midEl.value = mval;

            // If we still lack parts, try to split full name (if full looks valid)
            if ((full && ( (firstEl && !firstEl.value) || (lastEl && !lastEl.value) || (midEl && !midEl.value) ))) {
                const parts = full.split(/\s+/).filter(Boolean);
                if (parts.length === 1) {
                    if (firstEl && !firstEl.value) firstEl.value = parts[0];
                } else if (parts.length === 2) {
                    if (firstEl && !firstEl.value) firstEl.value = parts[0];
                    if (lastEl && !lastEl.value) lastEl.value = parts[1];
                } else if (parts.length >= 3) {
                    if (firstEl && !firstEl.value) firstEl.value = parts[0];
                    if (midEl && !midEl.value) midEl.value = parts.slice(1, parts.length-1).join(' ');
                    if (lastEl && !lastEl.value) lastEl.value = parts[parts.length-1];
                }
            }

            // If still no plausible name, try inferring from email local-part (e.g. john.doe@example.com)
            if ((!firstEl.value || !lastEl.value) && aiData.email) {
                try {
                    const e = String(aiData.email || '').trim();
                    const local = e.split('@')[0];
                    if (local) {
                        const tokens = local.split(/[\.\-_\+]/).map(s=>s.trim()).filter(Boolean);
                        if (tokens.length >= 2) {
                            if (firstEl && !firstEl.value) firstEl.value = tokens[0].charAt(0).toUpperCase() + tokens[0].slice(1);
                            if (lastEl && !lastEl.value) lastEl.value = tokens.slice(1).join(' ').replace(/\d+/g,'');
                        }
                    }
                } catch(e){}
            }
        } catch (e) { /* non-fatal */ }

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

        // Phone: prefer mobile numbers (starts with 09 or +63) when multiple phones present
        try {
            let phone = null;
            if (Array.isArray(aiData.phones) && aiData.phones.length) {
                const cleanPhones = aiData.phones.map(p => String(p||'').trim()).filter(Boolean);
                const preferred = cleanPhones.find(p => /^\+?63|^09/.test(p.replace(/[\s\-\.\(\)]/g, '')));
                phone = preferred || cleanPhones[0];
            } else {
                phone = aiData.phone || aiData.mobile || aiData.contact || aiData.tel || aiData.phone_number || null;
            }
            if (phone) {
                const el = document.getElementById('phone');
                if (el) {
                    const normalized = String(phone).replace(/[^\d+]/g, '');
                    el.value = normalized;
                }
            }
        } catch(e) { /* non-fatal */ }

        // Email: populate only if empty to avoid overwriting user input
        try {
            const emailsArr = aiData.emails || aiData.email || aiData.emails_list || null;
            const firstEmail = Array.isArray(emailsArr) && emailsArr.length ? emailsArr[0] : (typeof emailsArr === 'string' ? emailsArr : null);
            if (firstEmail) {
                const emailEl = document.getElementById('email') || document.querySelector('input[name="email"]');
                if (emailEl && !emailEl.value) emailEl.value = String(firstEmail).trim();
            }
        } catch(e) { /* non-fatal */ }

        // Middle name / initial: accept several keys and also try to extract from full name
        try {
            const midVal = aiData.middle_name || aiData.middle || aiData.mname || aiData.mi || aiData.middle_initial || aiData.m_i || aiData.m;
            const midEl = document.getElementById('middle_name');
            if (midVal && midEl && !midEl.value) {
                midEl.value = String(midVal).trim();
            } else if (!midVal && aiData.name && midEl && !midEl.value) {
                // try to infer middle initial from full name (e.g. "Juan B. Dela Cruz" or "Juan B Dela Cruz")
                const full = String(aiData.name).trim();
                const parts = full.split(/\s+/).filter(Boolean);
                if (parts.length >= 3) {
                    const candidate = parts[1].replace(/\./g, '');
                    if (/^[A-Za-z]$/.test(candidate)) {
                        midEl.value = candidate;
                    }
                }
            }
        } catch (e) { /* non-fatal */ }

        // Email autofill from OCR is intentionally disabled for privacy.
        // (Do not populate email fields from OCR results.)

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

        // Address → try to fill common address inputs (address, street, barangay, city).
        // Accept many possible address keys returned by resume OCR.
        const rawAddress = aiData.address || aiData.home_address || aiData.contact_address || aiData.location || aiData.address_line || aiData.street_address || aiData.homeAddress || aiData.mailing_address || null;
        if (rawAddress) {
            const raw = String(rawAddress).trim();
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
                const barangayEl = document.getElementById('barangay') || document.getElementById('address_barangay') || document.querySelector('[name="barangay"]') || null;
                const cityEl = document.getElementById('city') || document.getElementById('address_city') || document.getElementById('municipality') || document.querySelector('[name="city"]') || null;
                const numberEl = document.getElementById('address_number') || document.querySelector('[name="address_number"]') || null;

                // If street contains a leading house/lot number (including alphanumeric tokens like "B27"), split to number + street
                if (streetEl && streetEl.value === '') {
                    const streetTrim = String(street || '').trim();
                    const tokens = streetTrim.split(/\s+/).filter(Boolean);
                    if (tokens.length > 1) {
                        const first = tokens[0];
                        // heuristics: treat first token as number/unit when it contains any digit
                        // or is short (like 'B27', '327', '#12')
                        if (/[0-9]/.test(first) || /^[#\-A-Za-z0-9]{1,4}$/.test(first)) {
                            if (numberEl && !numberEl.value) numberEl.value = first;
                            streetEl.value = tokens.slice(1).join(' ');
                        } else {
                            streetEl.value = streetTrim;
                        }
                    } else {
                        streetEl.value = streetTrim;
                    }
                }
                if (barangayEl && barangayEl.value === '') barangayEl.value = barangay;
                if (cityEl && cityEl.value === '') cityEl.value = city;
            }
        }

        // --- Resume-specific structured fields ---
        try {
            // Education: populate first education entry if present
            if (Array.isArray(aiData.education) && aiData.education.length) {
                const eduContainer = document.getElementById('educationContainer');
                // ensure at least one education block exists, but avoid creating a blank one if form already has entries
                try {
                    if (eduContainer && eduContainer.children.length === 0 && typeof window.addEducation === 'function') {
                        window.addEducation();
                    }
                } catch(e){}
                if (eduContainer) {
                    // target first set of inputs
                    const levelEl = eduContainer.querySelector('select[name="education_level[]"]');
                    const schoolEl = eduContainer.querySelector('input[name="education_school[]"]');
                    const programEl = eduContainer.querySelector('input[name="education_program[]"]');
                    const startEl = eduContainer.querySelector('input[name="education_start[]"]');
                    const endEl = eduContainer.querySelector('input[name="education_end[]"]');
                    const e0 = String(aiData.education[0] || '').trim();
                    if (schoolEl && !schoolEl.value) schoolEl.value = e0;
                    // try to infer level from text
                    if (levelEl && !levelEl.value) {
                        const s = e0.toLowerCase();
                        if (s.includes('bachelor') || s.includes('bsc') || s.includes('ba') || s.includes('college')) levelEl.value = 'College';
                        else if (s.includes('high') || s.includes('secondary')) levelEl.value = 'Highschool';
                        else if (s.includes('vocational') || s.includes('training')) levelEl.value = 'Vocational / Training';
                    }
                    // optionally split year tokens
                    const yMatch = e0.match(/(19|20)\d{2}/g);
                    if (yMatch && yMatch.length) {
                        if (startEl && !startEl.value) startEl.value = yMatch[0];
                        if (endEl && !endEl.value && yMatch[1]) endEl.value = yMatch[1];
                    }
                    if (programEl && !programEl.value) programEl.value = aiData.certifications && aiData.certifications[0] ? aiData.certifications[0] : '';
                }
            }

            // Work experience: populate first job entry — join unstructured lines into one description
            if (Array.isArray(aiData.work_experience) && aiData.work_experience.length) {
                const jobContainer = document.getElementById('job_experiences_container');
                // only add a job entry if none exists to avoid blank entries
                try {
                    if (jobContainer && jobContainer.children.length === 0 && typeof window.addJobExperience === 'function') {
                        window.addJobExperience();
                    }
                } catch(e){}
                if (jobContainer) {
                    const first = jobContainer.querySelector('.job_exp_item') || jobContainer.firstElementChild;
                    if (first) {
                        const titleEl = first.querySelector('input[name="job_title[]"]') || first.querySelector('.job_title');
                        const companyEl = first.querySelector('input[name="company_name[]"]') || first.querySelector('.company_name');
                        const locEl = first.querySelector('input[name="company_location[]"]') || first.querySelector('.company_location');
                        const descEl = first.querySelector('textarea[name="job_description[]"]') || first.querySelector('.job_description');
                        // join all unstructured work_experience lines and try to extract company, location and years
                        const allLines = aiData.work_experience.map(s => String(s||'').trim()).filter(Boolean);
                        const combined = allLines.join('\n');
                        const w0 = allLines[0] || '';
                        if (titleEl && !titleEl.value) {
                            const parts = w0.split(/[,\-\n]/)[0].split(/\s+/).slice(0,4).join(' ');
                            titleEl.value = parts;
                        }

                        // attempt to parse subsequent lines for company, location and year range
                        let company = aiData.company_name || '';
                        let location = '';
                        let startYear = '';
                        let endYear = '';
                        const descLines = [];
                        for (let li = 1; li < allLines.length; li++) {
                            const line = allLines[li];
                            // year detection
                            const years = (line.match(/(19|20)\d{2}/g) || []).map(s=>s.trim());
                            if (years.length) {
                                startYear = years[0] || '';
                                endYear = years[1] || years[0] || '';
                                continue;
                            }
                            // company + location separator heuristics (em-dash, en-dash, hyphen, comma)
                            const sepMatch = line.match(/\s+[—–\-]\s+|\s*,\s*/);
                            if (sepMatch) {
                                // split by first separator into two parts
                                const parts = line.split(/\s+[—–\-]\s+|\s*,\s*/);
                                if (!company) company = parts[0].trim();
                                if (parts[1]) location = parts[1].trim();
                                continue;
                            }
                            // company-like keywords
                            if (!company && /\b(Inc|Ltd|Co|Store|Company|Corporation|LLC|Shop|Services|Enterprise)\b/i.test(line)) {
                                company = line;
                                continue;
                            }
                            // otherwise treat as part of description
                            descLines.push(line);
                        }

                        if (companyEl && !companyEl.value) companyEl.value = company || '';
                        if (locEl && !locEl.value) locEl.value = location || '';
                        if (descEl && !descEl.value) descEl.value = (descLines.length ? descLines.join('\n') : combined || w0);

                        // try to populate start/end year inputs if present within this job item
                        try {
                            const startYearEl = first.querySelector('input[name="job_start_year[]"], input.job_start_year');
                            const endYearEl = first.querySelector('input[name="job_end_year[]"], input.job_end_year');
                            if (startYear && startYearEl && !startYearEl.value) startYearEl.value = startYear;
                            if (endYear && endYearEl && !endYearEl.value) endYearEl.value = endYear;
                        } catch(e){}
                    }
                }
            }

            // Certifications: show summary in the certificate display elements (can't set file inputs)
            if (Array.isArray(aiData.certifications) && aiData.certifications.length) {
                const certs = aiData.certifications.map(c => String(c).trim()).filter(Boolean).slice(0,5).join(' • ');
                const eduDisp = document.getElementById('educationCertDisplay');
                if (eduDisp && !eduDisp.textContent) eduDisp.textContent = certs;
                const jobCertDisp = document.querySelector('.job_cert_display');
                if (jobCertDisp && !jobCertDisp.textContent) jobCertDisp.textContent = certs;
            }

            // --- Map structured fields (new in OCR) ---
            // Work experience structured mapping (fills multiple entries)
            if (Array.isArray(aiData.work_experience_structured) && aiData.work_experience_structured.length) {
                try { if (typeof window.addJobExperience === 'function') {
                    const need = aiData.work_experience_structured.length;
                    const existingTitles = document.querySelectorAll('input[name="job_title[]"]');
                    for (let i = existingTitles.length; i < need; i++) window.addJobExperience();
                } } catch(e) {}

                const titleNodes = Array.from(document.querySelectorAll('input[name="job_title[]"], input.job_title'));
                const companyNodes = Array.from(document.querySelectorAll('input[name="company_name[]"], input.company_name'));
                const locNodes = Array.from(document.querySelectorAll('input[name="company_location[]"], input.company_location'));
                const descNodes = Array.from(document.querySelectorAll('textarea[name="job_description[]"], textarea.job_description'));
                const startMonthNodes = Array.from(document.querySelectorAll('select[name="job_start_month[]"], select.job_start_month'));
                const startYearNodes = Array.from(document.querySelectorAll('input[name="job_start_year[]"], input.job_start_year'));
                const endMonthNodes = Array.from(document.querySelectorAll('select[name="job_end_month[]"], select.job_end_month'));
                const endYearNodes = Array.from(document.querySelectorAll('input[name="job_end_year[]"], input.job_end_year'));

                const monthNames = { '01':'January','02':'February','03':'March','04':'April','05':'May','06':'June','07':'July','08':'August','09':'September','10':'October','11':'November','12':'December' };

                // Pre-merge structured entries that look like continuations (to avoid split entries)
                try {
                    const wes = aiData.work_experience_structured.slice();
                    for (let j = 0; j < wes.length - 1; j++) {
                        const a = wes[j];
                        const b = wes[j+1];
                        const aTitle = (a.title||'').trim();
                        const aCompany = (a.company||'').trim();
                        const bTitle = (b.title||'').trim();
                        const bCompany = (b.company||'').trim();
                        const aDesc = (a.description||'').trim();
                        const bDesc = (b.description||b.raw||'').trim();
                        let shouldMerge = false;
                        if ((!bTitle && !bCompany) || (!aCompany && bCompany) ) shouldMerge = true;
                        if (aDesc && bDesc && (aDesc.length + bDesc.length) < 240) shouldMerge = true;
                        if (shouldMerge) {
                            a.description = (a.description||'') + '\n' + (b.description||b.raw||'');
                            a.raw = (a.raw||'') + '\n' + (b.raw||'');
                            wes.splice(j+1, 1);
                            j--; // re-evaluate current index with new next
                        }
                    }
                    wes.forEach((we, idx) => {
                        try {
                            if (titleNodes[idx] && !titleNodes[idx].value) titleNodes[idx].value = we.title || '';
                            // if company contains a location (e.g. "Company — Cavite"), split it
                            try {
                                let comp = we.company || '';
                                let loc = we.location || '';
                                if (comp && /[—–\-]/.test(comp)) {
                                    const parts = comp.split(/[—–\-]/).map(p => p.trim()).filter(Boolean);
                                    if (parts.length >= 2) { comp = parts[0]; if (!loc) loc = parts.slice(1).join(' '); }
                                } else if (!comp && we.raw && /[—–\-]/.test(we.raw)) {
                                    const m = we.raw.split(/\n/).map(r=>r.trim()).filter(Boolean);
                                    for (let x of m) {
                                        if (/[—–\-]/.test(x)) { const p = x.split(/[—–\-]/).map(s=>s.trim()); comp = comp || p[0]; loc = loc || (p[1]||''); break; }
                                    }
                                }
                                if (companyNodes[idx] && !companyNodes[idx].value) companyNodes[idx].value = comp || '';
                                if (locNodes[idx] && !locNodes[idx].value) locNodes[idx].value = loc || '';
                            } catch(e) { if (companyNodes[idx] && !companyNodes[idx].value) companyNodes[idx].value = we.company || ''; if (locNodes[idx] && !locNodes[idx].value) locNodes[idx].value = we.location || ''; }
                            if (descNodes[idx] && !descNodes[idx].value) descNodes[idx].value = we.description || we.raw || '';

                            // set start month/year
                            if (startYearNodes[idx] && !startYearNodes[idx].value) {
                                if (we.start_year) startYearNodes[idx].value = we.start_year;
                                else if (we.start_iso) startYearNodes[idx].value = (we.start_iso||'').slice(0,4);
                            }
                            if (startMonthNodes[idx] && !startMonthNodes[idx].value) {
                                if (we.start_month) {
                                    const m = (''+we.start_month).padStart(2,'0');
                                    const name = monthNames[m] || null;
                                    if (name) startMonthNodes[idx].value = name;
                                } else if (we.start_iso) {
                                    const mm = (we.start_iso||'').slice(5,7);
                                    const name = monthNames[mm] || null;
                                    if (name) startMonthNodes[idx].value = name;
                                }
                            }

                            // set end month/year
                            if (endYearNodes[idx] && !endYearNodes[idx].value) {
                                if (we.end_year) endYearNodes[idx].value = we.end_year;
                                else if (we.end_iso) endYearNodes[idx].value = (we.end_iso||'').slice(0,4);
                            }
                            if (endMonthNodes[idx] && !endMonthNodes[idx].value) {
                                if (we.end_month) {
                                    const m = (''+we.end_month).padStart(2,'0');
                                    const name = monthNames[m] || null;
                                    if (name) endMonthNodes[idx].value = name;
                                } else if (we.end_iso) {
                                    const mm = (we.end_iso||'').slice(5,7);
                                    const name = monthNames[mm] || null;
                                    if (name) endMonthNodes[idx].value = name;
                                }
                            }
                        } catch(e) {}
                    });
                } catch(e) {
                    // fallback to direct mapping
                    aiData.work_experience_structured.forEach((we, idx) => {
                        try {
                            if (titleNodes[idx] && !titleNodes[idx].value) titleNodes[idx].value = we.title || '';
                            if (companyNodes[idx] && !companyNodes[idx].value) companyNodes[idx].value = we.company || '';
                            if (locNodes[idx] && !locNodes[idx].value) locNodes[idx].value = we.location || '';
                            if (descNodes[idx] && !descNodes[idx].value) descNodes[idx].value = we.description || we.raw || '';

                            if (startYearNodes[idx] && !startYearNodes[idx].value) {
                                if (we.start_year) startYearNodes[idx].value = we.start_year;
                                else if (we.start_iso) startYearNodes[idx].value = (we.start_iso||'').slice(0,4);
                            }
                            if (startMonthNodes[idx] && !startMonthNodes[idx].value) {
                                if (we.start_month) {
                                    const m = (''+we.start_month).padStart(2,'0');
                                    const name = monthNames[m] || null;
                                    if (name) startMonthNodes[idx].value = name;
                                } else if (we.start_iso) {
                                    const mm = (we.start_iso||'').slice(5,7);
                                    const name = monthNames[mm] || null;
                                    if (name) startMonthNodes[idx].value = name;
                                }
                            }
                            if (endYearNodes[idx] && !endYearNodes[idx].value) {
                                if (we.end_year) endYearNodes[idx].value = we.end_year;
                                else if (we.end_iso) endYearNodes[idx].value = (we.end_iso||'').slice(0,4);
                            }
                            if (endMonthNodes[idx] && !endMonthNodes[idx].value) {
                                if (we.end_month) {
                                    const m = (''+we.end_month).padStart(2,'0');
                                    const name = monthNames[m] || null;
                                    if (name) endMonthNodes[idx].value = name;
                                } else if (we.end_iso) {
                                    const mm = (we.end_iso||'').slice(5,7);
                                    const name = monthNames[mm] || null;
                                    if (name) endMonthNodes[idx].value = name;
                                }
                            }
                        } catch(e) {}
                    });
                }
            }

            // Helper: determine education level option text from program or school keywords
            function determineEducationLevel(text) {
                if (!text) return '';
                const s = String(text).toLowerCase();
                if (/\b(sped|special education|special education program)\b/i.test(text)) return 'SPED Program';
                if (/\b(college|university|bs\.|bachelor|bsc|ba\.|ba )\b/i.test(s)) return 'College';
                if (/\b(highschool|high school|secondary|senior high|jr high|junior high)\b/i.test(s)) return 'Highschool';
                if (/\b(elementary|primary|grade)\b/i.test(s)) return 'Elementary';
                if (/\b(vocational|training|tesda|certificate|short course|technical)\b/i.test(s)) return 'Vocational / Training';
                return '';
            }

            // Education structured mapping
            if (Array.isArray(aiData.education_structured) && aiData.education_structured.length) {
                const schoolNodes = Array.from(document.querySelectorAll('input[name="education_school[]"], input[name*="school"], input[name*="education_school"], input[name*="school_name"]'));
                const programNodes = Array.from(document.querySelectorAll('input[name="education_program[]"], input[name*="course"], input[name*="program"]'));
                const startNodes = Array.from(document.querySelectorAll('input[name="education_start[]"], input[name*="year_started"], input[name*="education_start_year"]'));
                const endNodes = Array.from(document.querySelectorAll('input[name="education_end[]"], input[name*="year_completed"], input[name*="education_end_year"]'));

                aiData.education_structured.forEach((ed, idx) => {
                    try {
                        if (schoolNodes[idx] && !schoolNodes[idx].value) schoolNodes[idx].value = ed.school || '';
                        if (programNodes[idx] && !programNodes[idx].value) programNodes[idx].value = ed.degree || '';
                        // set education level select for this item if present
                        try {
                            const container = schoolNodes[idx] ? schoolNodes[idx].closest('.education-item') : null;
                            const selectEl = container ? container.querySelector('select[name="education_level[]"]') : document.querySelector('select[name="education_level[]"]');
                            const lvl = determineEducationLevel((ed.degree||'') + ' ' + (ed.school||''));
                            if (selectEl && lvl) {
                                // set by matching option text
                                const opt = Array.from(selectEl.options).find(o => String(o.text||o.value).trim().toLowerCase() === lvl.toLowerCase());
                                if (opt) selectEl.value = opt.value || opt.text;
                                else selectEl.value = lvl;
                            }
                        } catch(e){}
                        if (startNodes[idx] && ed.start_year) startNodes[idx].value = ed.start_year;
                        if (endNodes[idx] && ed.end_year) endNodes[idx].value = ed.end_year;
                    } catch(e) {}
                });

                // Persist a canonical education draft to localStorage (mirror ds_register_education behavior)
                try {
                    function saveEducationDraft() {
                        try {
                            const eduObj = {};
                            const eduLevelEl = document.querySelector('select[name="edu_level"], input[name="edu_level"], select[id="edu_level"], input[id="edu_level"]');
                            eduObj.edu_level = eduLevelEl ? (eduLevelEl.value || '') : '';
                            const schoolEl = document.querySelector('input[name="school_name"], input[id="school_name"], input[name*="school"]');
                            eduObj.school_name = schoolEl ? (schoolEl.value || '') : '';
                            const programEl = document.querySelector('input[name="education_program[]"], input[name*="course"], input[name*="program"], input[id*="program"]');
                            eduObj.course = programEl ? (programEl.value || '') : '';

                            // read hidden serialized certificates if present
                            try {
                                const raw = document.getElementById('certificates') ? document.getElementById('certificates').value : null;
                                eduObj.certificates = raw ? JSON.parse(raw || '[]') : [];
                            } catch (e) { eduObj.certificates = []; }

                            eduObj.certs = (Array.isArray(eduObj.certificates) && eduObj.certificates.length) ? 'yes' : 'no';

                            localStorage.setItem('education_profile', JSON.stringify(eduObj));
                            localStorage.setItem('edu_level', eduObj.edu_level || '');
                            localStorage.setItem('school_name', eduObj.school_name || '');
                            localStorage.setItem('review_certs', eduObj.certs || 'no');
                            localStorage.setItem('education_certificates', JSON.stringify(eduObj.certificates || []));
                        } catch (err) { console.warn('saveEducationDraft failed', err); }
                    }

                    // attach listeners so edits persist
                    const watchNodes = [].concat(schoolNodes || [], programNodes || [], startNodes || [], endNodes || []);
                    watchNodes.forEach(n => { try { if (n) n.addEventListener('input', saveEducationDraft); } catch(e){} });

                    // call once after OCR fill
                    saveEducationDraft();
                    // also populate top-level hidden canonical `job`/draft key used by Final Step
                    try { localStorage.setItem('education_profile', JSON.stringify(eduObj)); } catch(e) {}
                } catch(e) { console.warn('education draft persist init failed', e); }
            }

            // If unstructured education lines present, try to fill primary education fields
            if (Array.isArray(aiData.education) && aiData.education.length) {
                try {
                    const lines = aiData.education.map(s => String(s||'').trim()).filter(Boolean);
                    if (lines.length) {
                        const schoolNodes = Array.from(document.querySelectorAll('input[name="education_school[]"], input[name*="school"], input[name*="school_name"]'));
                        const programNodes = Array.from(document.querySelectorAll('input[name="education_program[]"], input[name*="program"], input[name*="course"]'));
                        const startNodes = Array.from(document.querySelectorAll('input[name="education_start[]"], input[name*="year_started"], input[name*="education_start_year"]'));
                        const endNodes = Array.from(document.querySelectorAll('input[name="education_end[]"], input[name*="year_completed"], input[name*="education_end_year"]'));
                        // Common pattern: program line then school line then year line
                        let program = lines[0] || '';
                        let school = lines[1] || lines[0] || '';
                        let yearsLine = lines.find(l => /(19|20)\d{2}/.test(l)) || '';
                        // if first line looks like a school (contains 'School' or 'Center' or 'College'), swap
                        if (/\b(School|Center|College|University|Institute|Learning)\b/i.test(program) && program && school && program !== school) {
                            const tmp = program; program = school; school = tmp;
                        }
                        if (schoolNodes[0] && !schoolNodes[0].value) schoolNodes[0].value = school;
                        if (programNodes[0] && !programNodes[0].value) programNodes[0].value = program;
                        // set education level select for the first education item
                        try {
                            const selectEl = document.querySelector('select[name="education_level[]"]');
                            const lvl = determineEducationLevel(program + ' ' + school + ' ' + (yearsLine||''));
                            if (selectEl && lvl) {
                                const opt = Array.from(selectEl.options).find(o => String(o.text||o.value).trim().toLowerCase() === lvl.toLowerCase());
                                if (opt) selectEl.value = opt.value || opt.text;
                                else selectEl.value = lvl;
                            }
                        } catch(e){}
                        if (yearsLine) {
                            const ys = yearsLine.match(/(19|20)\d{2}/g) || [];
                            if (ys[0] && startNodes[0] && !startNodes[0].value) startNodes[0].value = ys[0];
                            if (ys[1] && endNodes[0] && !endNodes[0].value) endNodes[0].value = ys[1];
                        }
                        // update canonical localStorage draft
                        try { saveEducationDraft(); } catch(e) {}
                    }
                } catch(e) { console.warn('unstructured education fill failed', e); }
            }

            // Summary / profile
            if (aiData.summary) {
                const summaryEl = document.querySelector('textarea[name="summary"], textarea[id*="summary"], textarea[name*="profile"], textarea[id*="personal_profile"]');
                if (summaryEl && !summaryEl.value) summaryEl.value = aiData.summary;
                const resumeDisplay = document.getElementById('resumeDisplay');
                if (resumeDisplay && !resumeDisplay.textContent) resumeDisplay.textContent = aiData.summary;
            }

            // Skills & languages
            if (Array.isArray(aiData.skills) && aiData.skills.length) {
                const skillsEl = document.querySelector('input[name="skills"], textarea[name="skills"], input[name*="skills_list"], input[id*="skills"]');
                if (skillsEl && !skillsEl.value) skillsEl.value = aiData.skills.join(', ');
            }
            if (Array.isArray(aiData.languages) && aiData.languages.length) {
                const langEl = document.querySelector('input[name="languages"], textarea[name="languages"], input[name*="language"], input[id*="languages"]');
                if (langEl && !langEl.value) langEl.value = aiData.languages.join(', ');
            }

            // Hide empty sections per presence flags
            try {
                const hideIfEmpty = (flag, selectors) => { if (typeof flag === 'boolean' && flag === false) selectors.forEach(s => document.querySelectorAll(s).forEach(el => el.style.display='none')); };
                hideIfEmpty(aiData.has_work_experience, ['[data-section="work_experience"]', '#work_experience_section', '.work-experience-section', '#workExperience']);
                hideIfEmpty(aiData.has_education, ['[data-section="education"]', '#education_section', '.education-section', '#Education']);
                hideIfEmpty(aiData.has_skills, ['[data-section="skills"]', '#skills_section', '.skills-section']);
                hideIfEmpty(aiData.has_certifications, ['[data-section="certifications"]', '#certifications_section', '.certifications-section']);
            } catch(e) { /* non-fatal */ }
        } catch(e) { console.warn('resume-field-mapping failed', e); }

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

// Map OCR data specifically into Parent/Guardian fields
function applyOcrDataToGuardianForm(aiData) {
    try {
        if (!aiData || typeof aiData !== 'object') return;

        // Name mapping
        try {
            const lastEl = document.getElementById('guardian_last');
            const firstEl = document.getElementById('guardian_first');
            const midEl = document.getElementById('guardian_middle');

            // accept many possible shapes: aiData.guardian, aiData.guardianInfo, or flat keys
            let src = aiData;
            if (aiData.guardian && typeof aiData.guardian === 'object') src = aiData.guardian;
            else if (aiData.guardianInfo && typeof aiData.guardianInfo === 'object') src = aiData.guardianInfo;

            const full = src.name || src.full_name || src.fullName || aiData.name || aiData.full_name || null;
            const first = src.first_name || src.given_name || src.givenName || src.firstname || aiData.first_name || null;
            const last = src.last_name || src.family_name || src.familyName || src.surname || aiData.last_name || null;
            const middle = src.middle_name || src.middle || src.mname || src.mi || aiData.middle_name || null;

            if (first && firstEl) firstEl.value = String(first).trim();
            if (last && lastEl) lastEl.value = String(last).trim();
            if (middle && midEl && !midEl.value) midEl.value = String(middle).trim();

            if (full && (!firstEl.value || !lastEl.value)) {
                const parts = String(full).trim().split(/\s+/).filter(Boolean);
                if (parts.length === 1) {
                    if (firstEl && !firstEl.value) firstEl.value = parts[0];
                } else if (parts.length === 2) {
                    if (firstEl && !firstEl.value) firstEl.value = parts[0];
                    if (lastEl && !lastEl.value) lastEl.value = parts[1];
                } else if (parts.length >= 3) {
                    if (firstEl && !firstEl.value) firstEl.value = parts[0];
                    if (midEl && !midEl.value) midEl.value = parts.slice(1, parts.length-1).join(' ');
                    if (lastEl && !lastEl.value) lastEl.value = parts[parts.length-1];
                }
            }
        } catch (e) { console.warn('guardian name mapping failed', e); }

        // Email
        try {
            const emailEl = document.getElementById('guardian_email');
            let email = null;
            if (aiData.guardian && aiData.guardian.emails && aiData.guardian.emails.length) email = aiData.guardian.emails[0];
            else if (aiData.guardian && aiData.guardian.email) email = aiData.guardian.email;
            else if (aiData.emails && aiData.emails.length) email = aiData.emails[0];
            else email = aiData.email || aiData.email_address || aiData.emailAddress || null;
            if (emailEl && !emailEl.value && email) emailEl.value = String(email).trim();
        } catch(e){}

        // Phone
        try {
            const phoneEl = document.getElementById('guardian_phone');
            let phone = null;
            if (aiData.guardian && Array.isArray(aiData.guardian.phones) && aiData.guardian.phones.length) phone = aiData.guardian.phones[0];
            else if (aiData.guardian && aiData.guardian.phone) phone = aiData.guardian.phone;
            else if (Array.isArray(aiData.phones) && aiData.phones.length) phone = aiData.phones[0];
            else phone = aiData.phone || aiData.mobile || aiData.contact || null;
            if (phone && phoneEl) phoneEl.value = String(phone).replace(/[^\d+]/g, '');
        } catch(e){}

        // Address: fill guardian address hidden and split into components
        try {
            const rawAddr = aiData.address || aiData.home_address || aiData.mailing_address || aiData.location || null;
            if (rawAddr) {
                const hidden = document.getElementById('guardian_home_address');
                if (hidden) hidden.value = String(rawAddr).trim();
                // try to split into components using existing helper logic: populate guardian_address_* fields
                const n = document.getElementById('guardian_address_number');
                const s = document.getElementById('guardian_address_street');
                const b = document.getElementById('guardian_address_barangay');
                const c = document.getElementById('guardian_address_city');
                const raw = String(rawAddr).trim();
                if (raw.indexOf(',') !== -1) {
                    const parts = raw.split(',').map(s=>s.trim()).filter(Boolean);
                    if (parts.length===1){ if(c) c.value = parts[0]; }
                    else if (parts.length===2){ if(b) b.value = parts[0]; if(c) c.value = parts[1]; }
                    else if (parts.length===3){ if(s) s.value = parts[0]; if(b) b.value = parts[1]; if(c) c.value = parts[2]; }
                    else { if(n) n.value = parts[0]; if(s) s.value = parts[1]; if(b) b.value = parts[2]; if(c) c.value = parts.slice(3).join(', '); }
                } else {
                    const words = raw.split(/\s+/).filter(Boolean);
                    if (words.length<=1){ if(c) c.value = raw; }
                    else if (words.length<=4){ if(n) n.value = words[0]||''; if(s) s.value = words[1]||''; if(b) b.value = words[2]||''; if(c) c.value = words[3]||''; }
                    else { if(n) n.value = words[0]; if(c) c.value = words[words.length-1]; const middle = words.slice(1, words.length-1); if(middle.length<=1){ if(s) s.value = middle.join(' '); } else if (middle.length===2){ if(s) s.value = middle[0]; if(b) b.value = middle[1]; } else { if(s) s.value = middle.slice(0, middle.length-1).join(' '); if(b) b.value = middle.slice(-1)[0]; } }
                }
                try { combineGuardianAddressFields(); } catch(e){}
            }
        } catch(e){}

    } catch (e) { console.warn('applyOcrDataToGuardianForm failed', e); }
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

    // Determine if this input should skip OCR (education/work-experience certificates)
    const _lcInputId = String(inputId || '').toLowerCase();
    const skipOcr = _lcInputId.includes('education_cert') || _lcInputId.startsWith('jobcertfile_') || _lcInputId.includes('jobcert') || _lcInputId.includes('workexp') || _lcInputId.includes('work_cert');

    // If label exists for education certificate, make it the blue upload button style
    try {
        if (labelEl && _lcInputId.includes('education_cert')) {
                labelEl.setAttribute('for', inputId);
                labelEl.classList.add('inline-flex','items-center','justify-center','bg-[#2E2EFF]','hover:bg-blue-700','text-white','text-sm','sm:text-base','font-medium','px-4','py-2','sm:px-6','sm:py-3','rounded-lg','transition','shadow-md','cursor-pointer');
                // ensure input is hidden (button handles file selection)
                try { fileInput.classList.add('hidden'); } catch(e){}
        }
    } catch(e){}

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

    // Use a non-dataset flag to track whether we've attached the generic listener.
    // This avoids accidental collisions with other code that may touch `dataset`.
    if (!fileInput._ocr_listener_attached) {
        fileInput.addEventListener('change', async function (e) {
            // If this is the resume input, let the dedicated resume handler manage it.
            if (String(inputId).toLowerCase().includes('resume')) {
                console.log('[upload] Generic handler ignoring resume input; resume-specific handler will run');
                return;
            }
            
            // existing handler body follows
            
            
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
                // local flags to handle uploads that the server does not accept as dedicated types
                let isFitUpload = false;
                let isGuardianUpload = false;
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
                    // server-side OCR validator currently rejects a raw 'fit_to_work' type
                    // so send as 'medical_certificate' (accepted) and mark locally as a Fit-To-Work upload
                    ocrtype = 'medical_certificate';
                    isFitUpload = true;
                } else if (String(inputId).toLowerCase().includes('guardian')) {
                    nameKey = 'admin_uploaded_guardian_name';
                    dataKey = 'admin_uploaded_guardian_data';
                    typeKey = 'admin_uploaded_guardian_type';
                    // server does not accept 'guardian_id' — request personal ID parsing using 'pwd_id'
                    ocrtype = 'pwd_id';
                    isGuardianUpload = true;
                } else if (String(inputId).toLowerCase().includes('resume')) {
                    nameKey = 'admin_uploaded_resume_name';
                    dataKey = 'admin_uploaded_resume_data';
                    typeKey = 'admin_uploaded_resume_type';
                    ocrtype = 'resume';
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

                // Defer PWD icon verification to the OCR service; do not run client-side detection here.
                // Do not show the verification hint for guardian uploads (they reuse 'pwd_id' for parsing).
                try {
                    if (ocrtype === 'pwd_id' && !isGuardianUpload) {
                        try { const errEl = fileInput.parentNode && fileInput.parentNode.querySelector('.upload-error'); if (errEl) errEl.textContent = 'Verifying PWD icon via OCR...'; } catch(e){}
                    }
                } catch (e) { console.warn('pwd icon early-guard noop failed', e); }

                // Save to localStorage
                localStorage.setItem(nameKey, file.name);
                localStorage.setItem(dataKey, dataUrl);
                localStorage.setItem(typeKey, ext);
                console.info('[adminapprove] saved upload to localStorage', nameKey);

                // Create and show loading indicator (skip for resume and for skipOcr inputs)
                let loadingDiv = null;
                if (!skipOcr && ocrtype !== 'resume') {
                    loadingDiv = document.createElement('div');
                    loadingDiv.className = 'ocr-loading-container';
                    loadingDiv.id = `ocr-loading-${inputId}`;
                    loadingDiv.innerHTML = `
                        <div class="ocr-spinner"></div>
                        <span class="ocr-loading-text">Processing OCR... Please wait</span>
                    `;
                    display.appendChild(loadingDiv);
                }

                // Prepare and send to backend. If user selected multiple files (front+back),
                // send both images in a single payload so the OCR can consider them together.
                const filesAll = Array.from(fileInput.files || []);
                let payload;
                if (filesAll.length > 1) {
                    // read second file synchronously so we can send both in one request
                    const file2 = filesAll[1];
                    const dataUrl2 = await new Promise((resolve, reject) => {
                        const reader2 = new FileReader();
                        reader2.onload = () => resolve(reader2.result);
                        reader2.onerror = () => reject(reader2.error || new Error('FileReader failed'));
                        reader2.readAsDataURL(file2);
                    });

                    payload = {
                        type: ocrtype,
                        ocr_name: [file.name, file2.name],
                        ocr_data: [dataUrl, dataUrl2],
                        ocr_type: [ext, (file2.name.split('.').pop()||'').toLowerCase()]
                    };

                    // store arrays into localStorage for multi-file uploads
                    try {
                        localStorage.setItem(nameKey, JSON.stringify([file.name, file2.name]));
                        localStorage.setItem(dataKey, JSON.stringify([dataUrl, dataUrl2]));
                        localStorage.setItem(typeKey, JSON.stringify([ext, (file2.name.split('.').pop()||'').toLowerCase()]));
                    } catch(e){ console.warn('storing multi-file upload failed', e); }
                } else {
                    payload = {
                        type: ocrtype,
                        ocr_name: file.name,
                        ocr_data: dataUrl,
                        ocr_type: ext
                    };
                }

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

                // Only send to the generic OCR validator for non-resume uploads and when OCR is enabled for this input.
                if (!skipOcr && ocrtype !== 'resume') {
                    console.log("[upload] Sending OCR request for:", file.name);
                    // debugger;   // ← keep if you need to inspect payload

                    let response;
                    try {
                        // show global OCR overlay
                        try { if (typeof window.showOcrOverlay === 'function') window.showOcrOverlay('Scanning document...'); } catch(e){}
                        response = await fetch('db/ocr-validation.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(payload)
                        });
                    } catch (fetchErr) {
                        // Remove loading indicator on network error
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                        console.error('[upload] Fetch failed:', fetchErr);
                        showOcrModal({
                            type: 'error',
                            title: 'Scan Failed',
                            message: 'Network error: Failed to connect to OCR service.',
                            note: 'Please try again.',
                            showRetry: true
                        });
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
                        try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                        console.warn("Invalid JSON from server", jsonErr);
                        result = { message: 'Invalid response format' };
                    }

                    if (response.ok) {
                        console.log('OCR Result:', result);

                        const detectedType = result.data?.ocrtype;
                        const aiData = result.data?.ai_data || {};

                    if (detectedType === 'pwd_id' && ocrtype === 'pwd_id' && !isGuardianUpload) {
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

                        // --- New: detect whether this PWD image is the front or back side ---
                        function detectPwdSide(ai, meta) {
                            try {
                                // Strong indicators for front side: name, dob, id/pwd number
                                const frontKeys = ['first_name','last_name','date_of_birth','dob','birthdate','id_number','pwd_number','idno','idno'];
                                for (const k of frontKeys) {
                                    if (ai && ai[k]) return 'front';
                                }

                                // Server-side hints (if provided)
                                if (meta && (meta.contains_qr_code || meta.contains_barcode || meta.detected_qr || meta.detected_barcode)) return 'back';

                                // Back-side hints: membership, issuer, expiry, card-specific fields
                                const backKeys = ['is_membership','issuer','issuing_authority','expiry_date','valid_until','membership_no','membership_number'];
                                for (const k of backKeys) {
                                    if (ai && (typeof ai[k] !== 'undefined')) return 'back';
                                }

                                // Fallback: if OCR text contains words like 'issued by', 'valid until', 'member', treat as back
                                const txt = (JSON.stringify(ai) + ' ' + JSON.stringify(meta || {})).toLowerCase();
                                if (/issued by|valid until|valid thru|member(ship)?|authority|expiry|expiration|issuer/.test(txt)) return 'back';

                                return 'unknown';
                            } catch (e) { return 'unknown'; }
                        }

                        const pwdSide = detectPwdSide(aiData, result.data);
                        // PWD side detection retained internally but UI badge removed per request

                        // If OCR couldn't detect a meaningful disability (unknown/empty),
                        // require a clear server-side icon flag or explicit PWD keywords in OCR text.
                        (function(){
                            try {
                                const detNorm = (String(detectedDisability||'').trim()).toLowerCase();
                                const missingDisability = (!detectedDisability || detNorm === 'unknown' || detNorm.indexOf('unknown') !== -1 || detNorm === 'undetected' || detNorm === 'not detected' || detNorm === 'null');

                                // Robust server-icon detection: search common flag names in multiple locations
                                const meta = result.data || {};
                                function findIconFlag(obj) {
                                    if (!obj || typeof obj !== 'object') return null;
                                    const keys = ['contains_pwd_icon','has_pwd_icon','detected_pwd_icon','icon_detected','contains_icon','containsPWDIcon','pwd_icon','hasIcon'];
                                    for (const k of keys) {
                                        if (typeof obj[k] !== 'undefined') return !!obj[k];
                                    }
                                    return null;
                                }

                                let serverSaysHasIcon = findIconFlag(meta);
                                // also check nested ai_data and per-image metadata
                                try {
                                    if (serverSaysHasIcon !== true && meta.ai_data) serverSaysHasIcon = findIconFlag(meta.ai_data) ?? serverSaysHasIcon;
                                } catch(e){}
                                try {
                                    if (serverSaysHasIcon !== true && meta.per_image && typeof meta.per_image === 'object') {
                                        for (const p in meta.per_image) {
                                            if (!Object.prototype.hasOwnProperty.call(meta.per_image,p)) continue;
                                            const v = findIconFlag(meta.per_image[p]);
                                            if (v === true) { serverSaysHasIcon = true; break; }
                                            if (v === false && serverSaysHasIcon === null) serverSaysHasIcon = false;
                                        }
                                    }
                                } catch(e){}

                                const combinedText = (JSON.stringify(aiData || '') + ' ' + JSON.stringify(result.data || '')).toLowerCase();
                                const pwdKeywords = /\b(pwd|pwd id|pwdid|wheelchair|person with disability|persons with disability|people with disabilities|pwds?)\b/;
                                const hasKeywords = pwdKeywords.test(combinedText);

                                console.debug('[ocr] server icon flag:', serverSaysHasIcon, 'detectedDisability:', detectedDisability, 'hasKeywords:', hasKeywords, 'meta:', result.data);

                                // Reject when neither the server nor OCR text provides a PWD indicator
                                if (missingDisability && serverSaysHasIcon !== true && !hasKeywords) {
                                    const loading = document.getElementById(`ocr-loading-${inputId}`);
                                    if (loading) loading.remove();
                                    if (errorBox) errorBox.textContent = 'Unable to verify PWD status from the uploaded ID. Upload rejected.';
                                    try { localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey); } catch(e){}
                                    try { resetDisplay(); } catch(e){}
                                    try {
                                        showOcrModal({
                                            type: 'error',
                                            title: 'Scan Rejected',
                                            message: 'Uploaded image appears not to be a valid PWD ID. Please upload a clearer or different PWD ID.',
                                            confirmText: 'OK'
                                        });
                                    } catch(e) { try{ alert('Unable to detect a valid PWD ID from the upload.'); }catch(_){} }
                                    try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                                    isProcessing = false;
                                    return;
                                }

                                // If missing disability but server/icon or keywords present, accept but show a warning to review.
                                if (missingDisability && (serverSaysHasIcon === true || hasKeywords)) {
                                    try { if (errorBox) errorBox.textContent = 'No explicit disability detected; please review the uploaded ID details.'; } catch(e){}
                                }
                            } catch(e) { console.warn('pwd verification check failed', e); }
                        })();

                        if (!isMatch) {
                            // Don't block the upload for missing/mismatched disability — treat as a bonus.
                            let warnMsg;
                            if (!detectedDisability) {
                                warnMsg = 'No disability detected in the uploaded PWD ID. The upload will still be accepted and any extracted info will be applied.';
                            } else {
                                warnMsg = `Detected disability "${detectedDisability}" does not match the selected disability. The upload will still be accepted; please review the extracted info.`;
                            }
                            if (errorBox) errorBox.textContent = warnMsg;
                            try {
                                showOcrModal({
                                    type: 'error',
                                    title: 'Invalid Scan',
                                    message: 'Uploaded ID appears to be invalid and will not be accepted.',
                                    showRetry: true,
                                    confirmText: 'Retry'
                                });
                            } catch (e) { console.warn('showOcrModal failed for non-matching scan', e); }
                            try { console.warn('[upload] Non-blocking PWD mismatch:', warnMsg); } catch(e){}
                            try { const loading = document.getElementById(`ocr-loading-${inputId}`); if (loading) loading.remove(); } catch(e){}
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            // Treat non-matching scans as invalid: clean up and stop processing
                            try { localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey); } catch(e){}
                            try { resetDisplay(); } catch(e){}
                            isProcessing = false;
                            return;
                        }

                        // If match, autofill and persist
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        // Remove loading indicator and hide overlay
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                        if (pwdDisplayEl) {
                            const _e = pwdDisplayEl.querySelector('.ocr-error');
                            if (_e) _e.textContent = '';
                        }
                        // Try to extract a 'date issued' value from AI/server results
                        // Robust extraction: check common keys first, then scan free-form text for 'date issued' patterns
                        function extractDateIssued(ai, meta) {
                            try {
                                const candidates = [];
                                const keyNames = ['issue_date','issued_date','date_issued','date issued','dateofissue','date_of_issue','issued','issuance_date','issueDate','issuedDate','issuanceDate','issue'];
                                for (const k of keyNames) {
                                    if (ai && (ai[k] || ai[k] === 0)) return ai[k];
                                    if (meta && (meta[k] || meta[k] === 0)) return meta[k];
                                }

                                // Search flat fields in ai for any value that looks like a date
                                if (ai && typeof ai === 'object') {
                                    for (const k in ai) {
                                        if (!Object.prototype.hasOwnProperty.call(ai,k)) continue;
                                        const v = ai[k];
                                        if (!v) continue;
                                        const s = String(v);
                                        if (/\b(date\s*(issued|of issue|issued on)|date issued|date of issue)[:\s]/i.test(k + ' ' + s)) return s;
                                        if (/\d{4}[\-\/]\d{2}[\-\/]\d{2}|\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}|\b(?:jan|feb|mar|apr|may|jun|jul|aug|sep|sept|oct|nov|dec)[a-z]*\b/i.test(s)) {
                                            // candidate value
                                            candidates.push(s);
                                        }
                                    }
                                }

                                // Look into meta/raw combined text
                                const big = (JSON.stringify(ai || '') + ' ' + JSON.stringify(meta || '')).replace(/\\\s+/g,' ');
                                const m = big.match(/(?:date\s*(?:issued|of issue|issued on|issued:?)[:\s]*)([^\\n\\r,]{3,60})/i);
                                if (m && m[1]) return m[1].trim();

                                // fallback to first candidate that looks date-like
                                if (candidates.length) return candidates[0];
                            } catch(e){}
                            return null;
                        }

                        let _dateIssuedRaw = extractDateIssued(aiData, result.data);
                        if (!_dateIssuedRaw) {
                            // also try some generic aiData.summary or aiData.raw_text fields
                            try {
                                const txtFields = ['raw_text','raw_text_pages','text','ocr_text','ocr_text_raw','summary','result','content','ocrResult'];
                                for (const f of txtFields) {
                                    const v = aiData && aiData[f] ? aiData[f] : (result.data && result.data[f] ? result.data[f] : null);
                                    if (v && typeof v === 'string') {
                                        const m2 = String(v).match(/(?:date\s*(?:issued|of issue|issued on|issued:?)[:\s]*)([^\n\r,]{3,60})/i);
                                        if (m2 && m2[1]) { _dateIssuedRaw = m2[1].trim(); break; }
                                    }
                                }
                            } catch(e){}
                        }

                        let _dateIssuedFormatted = '';
                        try {
                            if (_dateIssuedRaw) _dateIssuedFormatted = window.formatDateWords(_dateIssuedRaw) || String(_dateIssuedRaw);
                        } catch(e) { _dateIssuedFormatted = String(_dateIssuedRaw || ''); }

                        showOcrModal({
                            type: 'success',
                            title: 'Scan Successful',
                            message: 'We’ve successfully processed the uploaded PWD ID.',
                            // include the parsed AI data so modal can surface id_number
                            aiData: aiData,
                            details: [
                                { label: 'Disability', value: aiData.type_of_disability || 'Unknown' },
                                { label: 'Date Issued', value: _dateIssuedFormatted || 'Unknown' }
                            ],
                            note: 'Please review the information for accuracy.',
                            confirmText: 'Confirm & Continue'
                        });
                    
                    // Parent / Guardian ID: handle guardian uploads using local flag
                    } else if (isGuardianUpload) {
                        try {
                            applyOcrDataToGuardianForm(aiData);
                            try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        } catch(e) { console.warn('guardian-id mapping failed', e); }
                        const loadingGuardian = document.getElementById(`ocr-loading-${inputId}`);
                        if (loadingGuardian) loadingGuardian.remove();
                        try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                        try {
                            showOcrModal({
                                type: 'success',
                                title: 'Parent / Guardian ID Processed',
                                message: 'We’ve successfully processed the uploaded Parent / Guardian ID.',
                                details: [
                                    { label: 'Name', value: aiData.name || [aiData.first_name, aiData.last_name].filter(Boolean).join(' ') || 'Unknown' }
                                ],
                                note: 'Please review the extracted information for accuracy.',
                                confirmText: 'Confirm & Continue'
                            });
                        } catch(e) {
                            showOcrModal({ type: 'success', title: 'Parent / Guardian ID Processed', message: 'Document processed.', confirmText: 'Confirm & Continue' });
                        }

                    } else if (isFitUpload) {
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
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            if (errorBox) errorBox.textContent = "Fit-To-Work statement not detected in this document. Upload rejected.";
                            try { localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey); } catch(e){}
                            try { resetDisplay(); } catch(e){}
                            alert('The uploaded Fit-To-Work document does not indicate fitness to work. Please upload a valid Fit-To-Work certificate.');
                            isProcessing = false;
                            return;
                        }

                        // Also enforce the 3-month validity rule on Fit-To-Work certificates
                        const isDateValid = validateMedicalCertificateDate(aiData.date, errorBox, 'Fit-To-Work certificate');
                        if (!isDateValid) {
                            const loading2 = document.getElementById(`ocr-loading-${inputId}`);
                            if (loading2) loading2.remove();
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            try { localStorage.removeItem(nameKey); localStorage.removeItem(dataKey); localStorage.removeItem(typeKey); } catch(e){}
                            try { resetDisplay(); } catch(e){}
                            showOcrModal({ type: 'error', title: 'Fit-To-Work Rejected', message: 'Detected Fit-To-Work date is older than 3 months or missing.', details: [ { label: 'Detected Date', value: aiData.date || 'Unknown' } ], confirmText: 'OK' });
                            isProcessing = false;
                            return;
                        }

                        // Do NOT autofill form fields from Fit-To-Work OCR results.
                        // Keep validation and modal feedback, but avoid applying parsed data to user fields.
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        if (fitDisplayEl) {
                            const _e = fitDisplayEl.querySelector('.ocr-error'); if (_e) _e.textContent = '';
                        }
                        // Show modal with parsed details instead of a simple alert
                        try {
                            const storedName = localStorage.getItem(nameKey) || null;
                            const fname = storedName || (fileInput && fileInput.files && fileInput.files[0] && fileInput.files[0].name) || 'uploaded document';
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            showOcrModal({
                                type: 'success',
                                title: 'Fit-To-Work Processed',
                                message: `Fit-To-Work (${fname}) has been processed.`,
                                details: [
                                    { label: 'Contains Fit Statement', value: result.data?.contains_fit_to_work ? 'Yes' : 'No' },
                                    { label: 'Parsed Summary', value: aiData.summary || aiData.result || 'N/A' }
                                ],
                                note: 'Please review the extracted information for accuracy.',
                                confirmText: 'Confirm & Continue'
                            });
                        } catch(e) {
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            showOcrModal({
                                type: 'success',
                                title: 'Fit-To-Work Processed',
                                message: 'Fit-To-Work document processed successfully.',
                                details: [],
                                confirmText: 'Confirm & Continue'
                            });
                        }

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

                        // Do NOT autofill form fields from Medical Certificate OCR results.
                        // Keep validation and modal feedback, but avoid applying parsed data to user fields.

                        // For pure medical certificates we enforce the 3-month date rule
                        const isValid = validateMedicalCertificateDate(aiData.date, errorBox, 'Medical certificate');
                        // Remove loading indicator
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        
                        if (isValid) {
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            showOcrModal({
                                type: 'success',
                                title: 'Medical Certificate Accepted',
                                message: 'The uploaded medical certificate is within the acceptable 3-month window.',
                                details: [
                                    { label: 'Medical Date', value: aiData.date || '?' }
                                ],
                                note: 'Please review the extracted date and information for accuracy.',
                                confirmText: 'Confirm & Continue'
                            });
                        } else {
                            // Enforce strict 3-month rule: do not accept expired medical certificates.
                            if (errorBox && errorBox.textContent) {
                                console.warn('Rejected medical certificate date (older than 3 months):', aiData.date);
                            }
                            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                            showOcrModal({
                                type: 'error',
                                title: 'Medical Certificate Rejected',
                                message: `Detected medical date ${aiData.date || '?'} is older than 3 months and cannot be accepted.`,
                                details: [ { label: 'Detected Date', value: aiData.date || 'Unknown' } ],
                                note: 'Please upload a valid medical certificate dated within the last 3 months.',
                                confirmText: 'OK'
                            });
                        }
                    } else if (detectedType === 'membership_proof' && ocrtype === 'membership_proof') {
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        // Remove loading indicator and show result modal (membership)
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                        showOcrModal({
                            type: 'success',
                            title: 'Membership Proof Processed',
                            message: `Membership proof has been processed.`,
                            details: [ { label: 'Is Member', value: aiData.is_membership || '?' } ],
                            confirmText: 'Confirm & Continue'
                        });
                    } else {
                        // generic autofill attempt
                        applyOcrDataToForm(aiData, detectedType, ocrtype);
                        try { localStorage.setItem('education_ocr', JSON.stringify({ data: aiData })); } catch(e){}
                        // Remove loading indicator and show generic result modal (no OCR Type)
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        showOcrModal({
                            type: 'success',
                            title: 'Document Processed',
                            message: 'The uploaded document was processed successfully.',
                            details: [],
                            confirmText: 'Confirm & Continue'
                        });
                    }
                    } else {
                        // Remove loading indicator on error
                        const loading = document.getElementById(`ocr-loading-${inputId}`);
                        if (loading) loading.remove();
                        alert(`Error ${response.status}: ${result.message || 'Unknown server error'}`);
                    }
                } else if (skipOcr) {
                    // This input intentionally skips OCR (education/work-experience certificates).
                    console.log('[upload] Skipping OCR for input:', inputId);
                    // remove any loading indicator (if any) and continue to attach View/Remove behavior
                    const loading = document.getElementById(`ocr-loading-${inputId}`);
                    if (loading) loading.remove();
                } else {
                    // For resume uploads we do not send to db/ocr-validation here.
                    console.log('[upload] Resume upload: skipping generic OCR validator; resume-specific handler will run.');
                }

                // Multi-file uploads are handled earlier (sent together in one request).

                // Attach button listeners (only once per file selection)
                const viewBtn = display.querySelector('.viewBtn');
                const removeBtn = display.querySelector('.removeBtn');

                if (viewBtn) {
                    viewBtn.addEventListener('click', (ev) => {
                        ev.preventDefault();
                        // prefer any stored data (supports multi-file arrays); fall back to object URL
                        try {
                            const stored = localStorage.getItem(dataKey);
                            const storedType = localStorage.getItem(typeKey);
                            if (stored) {
                                // if stored is JSON array, pass array and parsed types
                                try {
                                    const parsed = JSON.parse(stored);
                                    if (Array.isArray(parsed)) {
                                        let parsedTypes = [];
                                        try { parsedTypes = JSON.parse(storedType || '[]'); } catch(e) { parsedTypes = [] }
                                        openModal(parsed, parsedTypes.length ? parsedTypes : parsed.map(() => ext));
                                        return;
                                    }
                                } catch(e) {}
                                openModal(stored, storedType || ext);
                                return;
                            }
                        } catch(e){}
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

        fileInput._ocr_listener_attached = true;
        console.log("[upload] Generic change listener attached (one-time)");
    } else {
        console.log("[upload] Generic change listener already attached – skipped re-attachment");
    }
    
  // Modal preview
    function openModal(urlOrArray, extOrArray) {
        // urlOrArray: string (data URL or object URL) or Array of strings or JSON array string
        // extOrArray: string ext or Array of ext strings (parallel to urls)
        let items = [];
        try {
            if (!urlOrArray) return;
            if (Array.isArray(urlOrArray)) items = urlOrArray.slice();
            else if (typeof urlOrArray === 'string' && /^\s*\[/.test(urlOrArray)) {
                // JSON array string
                try { items = JSON.parse(urlOrArray); } catch (e) { items = [urlOrArray]; }
            } else {
                items = [urlOrArray];
            }
        } catch (e) { items = [urlOrArray]; }

        let exts = [];
        try {
            if (Array.isArray(extOrArray)) exts = extOrArray.slice();
            else if (typeof extOrArray === 'string' && /^\s*\[/.test(extOrArray)) exts = JSON.parse(extOrArray);
            else exts = [extOrArray];
        } catch (e) { exts = [extOrArray]; }

        // normalize lengths
        while (exts.length < items.length) exts.push(exts[0] || '');

        let idx = 0;

        function render() {
            const url = items[idx];
            const ext = (exts[idx] || '').toLowerCase();
            let inner = '';
            if (['jpg','jpeg','png'].includes(ext) || (typeof url === 'string' && url.startsWith('data:image'))) {
                inner = `<img src="${url}" class="max-h-[80vh] mx-auto rounded-lg">`;
            } else if (ext === 'pdf' || (typeof url === 'string' && url.endsWith('.pdf'))) {
                inner = `<iframe src="${url}" class="w-full h-[80vh] rounded-lg border-0"></iframe>`;
            } else {
                inner = `<p class="text-gray-700 text-center">This file type cannot be previewed.<br>(Hindi maaaring i-preview ang file na ito.)</p>`;
            }

            modalContent.innerHTML = `
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm text-slate-600">${idx+1} / ${items.length}</div>
                    <div class="flex gap-2">
                        <button id="modalPrev" class="px-3 py-1 rounded bg-slate-100">Prev</button>
                        <button id="modalNext" class="px-3 py-1 rounded bg-slate-100">Next</button>
                    </div>
                </div>
                <div class="modal-body">${inner}</div>
            `;

            // disable buttons when single
            try {
                const prev = document.getElementById('modalPrev');
                const next = document.getElementById('modalNext');
                if (prev) prev.disabled = items.length <= 1;
                if (next) next.disabled = items.length <= 1;
                if (prev) prev.onclick = (e) => { e.preventDefault(); idx = (idx - 1 + items.length) % items.length; render(); };
                if (next) next.onclick = (e) => { e.preventDefault(); idx = (idx + 1) % items.length; render(); };
            } catch (e) {}
        }

        modal.classList.remove('hidden');
        render();
        document.body.classList.add('overflow-hidden');
    }

  closeModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.add('hidden');
    modalContent.innerHTML = '';
        document.body.classList.remove('overflow-hidden');
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add('hidden');
      modalContent.innerHTML = '';
            document.body.classList.remove('overflow-hidden');
    }
  });

  function resetDisplay() {
    display.innerHTML = '';
    safeSetText(labelEl, (labelEl && labelEl.dataset ? (labelEl.dataset.original || 'Upload File') : 'Upload File'));
        if (hintEl) hintEl.style.display = '';
  }
}
</script>

<script>
// Ensure certificate file inputs show filenames and work with dynamic entries
document.addEventListener('DOMContentLoaded', function() {
    // Education certificate (single file input) — use setupUpload to get consistent UI
    const eduInput = document.getElementById('education_cert_file');
    if (eduInput) {
        // ensure a display container exists
        let disp = document.getElementById('educationCertDisplay');
        if (!disp) {
            disp = document.createElement('div');
            disp.id = 'educationCertDisplay';
            eduInput.parentNode.insertBefore(disp, eduInput.nextSibling);
        }
        // attach setupUpload (safe to call multiple times)
        try { if (typeof setupUpload === 'function') setupUpload('education_cert_file','educationCertDisplay','educationCertLabel','educationCertHint'); } catch(e) { console.warn('setupUpload not available for education_cert_file', e); }
    }

    // Job certificates inside work experiences (multiple dynamic inputs)
    function jobCertChangeHandler(e) {
        const input = e.target;
        if (!input || !input.classList || !input.classList.contains('job_cert_file')) return;
        // find closest display container in the same experience block
        let display = null;
        const block = input.closest('.job_exp_item');
        if (block) display = block.querySelector('.job_cert_display');
        if (!display) display = input.closest('label')?.parentNode?.querySelector('.job_cert_display') || document.querySelector('.job_cert_display');
        const names = Array.from(input.files || []).map(f => f.name).join(', ');
        if (display) display.textContent = names || '';
    }

    // For job experience certificate inputs, wire each input into setupUpload so they show the same card UI.
    let jobCounter = 0;
    function wireJobCertInput(inp) {
        if (!inp || inp._job_cert_wired) return;
        // ensure it has an id
        if (!inp.id) inp.id = 'jobCertFile_' + (jobCounter++);
        const idx = inp.id.replace(/[^a-z0-9_\-]/gi, '');
        const dispId = 'jobCertDisplay_' + idx;
        const labelId = 'jobCertLabel_' + idx;
        const hintId = 'jobCertHint_' + idx;

        // create display container if missing — place it inside the nearest upload/info box (blue area) when possible
        const wrapper = inp.closest('.job_exp_item') || inp.parentNode;
        // prefer to place preview inside a surrounding upload/info card (blue box)
        const preferredContainer = inp.closest('.bg-blue-50, .section-card, .info-card, .resume-card, .pwdid-card, .medical-card, .fit-card');
        const container = preferredContainer || wrapper;
        if (!document.getElementById(dispId)) {
            const d = document.createElement('div'); d.id = dispId; d.className = 'job_cert_display mt-2 text-sm text-gray-700';
            try { container.appendChild(d); } catch(e) { inp.parentNode.insertBefore(d, inp.nextSibling); }
        }

        // try to find an adjacent label to attach an id, else create a hidden label anchor
        let lab = inp.closest('label') || inp.previousElementSibling;
        if (lab && lab.tagName && lab.tagName.toLowerCase() === 'label') {
            lab.id = lab.id || labelId;
        } else {
            // create a small invisible label anchor to satisfy setupUpload signature
            if (!document.getElementById(labelId)) {
                const anchor = document.createElement('div'); anchor.id = labelId; anchor.style.display = 'none';
                try { container.appendChild(anchor); } catch(e) { inp.parentNode.insertBefore(anchor, inp); }
            }
        }

        // create hint element if missing
        if (!document.getElementById(hintId)) {
            const hn = document.createElement('div'); hn.id = hintId; hn.style.display = 'none';
            try { container.appendChild(hn); } catch(e) { inp.parentNode.insertBefore(hn, inp.nextSibling); }
        }

        try { if (typeof setupUpload === 'function') setupUpload(inp.id, dispId, labelId, hintId); } catch(e) { console.warn('setupUpload failed for job cert', inp.id, e); }
        inp._job_cert_wired = true;
    }

    // Wire existing inputs
    document.querySelectorAll('.job_cert_file').forEach(inp => wireJobCertInput(inp));

    // Also wire inputs when new job experiences are added
    if (typeof window.addJobExperience === 'function') {
        const orig = window.addJobExperience;
        window.addJobExperience = function() {
            orig();
            // wire any newly-added inputs inside the job_experiences_container
            const container = document.getElementById('job_experiences_container');
            if (!container) return;
            container.querySelectorAll('.job_cert_file').forEach(inp => wireJobCertInput(inp));
        };
    }
});
</script>
            
            <!-- Submit Button -->
            <div class="flex flex-col items-center mt-12 sm:mt-16 w-full px-4 sm:px-0">
                <button 
                id="createAccountBtn" 
                type="button" class="w-full sm:w-auto bg-[#2E2EFF] text-white text-lg sm:text-2xl font-semibold px-6 sm:px-16 md:px-28 py-3 sm:py-4 rounded-2xl shadow-lg hover:bg-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Next
                </button>
                <p class="text-gray-700 text-sm sm:text-base md:text-lg mt-4 text-center leading-relaxed px-4 sm:px-0">
                    Click <span class="text-[#1E40AF] font-bold">"Next"</span> to continue to the next step <br class="hidden sm:block">
                    <span class="italic text-[#4B4F58] block sm:inline">(Pindutin ang "Next" upang magpatuloy sa susunod na hakbang)</span>
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
    <!-- Global OCR Loading Overlay (hidden by default) -->
    <div id="ocrGlobalOverlay" class="hidden fixed inset-0 z-[110000] flex items-center justify-center" aria-hidden="true" style="backdrop-filter: blur(3px); -webkit-backdrop-filter: blur(3px);">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 flex flex-col items-center gap-3 p-4">
            <div class="ocr-overlay-spinner w-16 h-16 rounded-full border-4 border-t-transparent border-white/90 animate-spin"></div>
            <div class="ocr-loading-message text-white text-lg font-medium">Processing document...</div>
        </div>
    </div>

    <div id="fileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[100000]" style="z-index:100000;">
    <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-[90%] relative">
        <button id="closeModalBtn" type="button" style="z-index:100001;pointer-events:auto;" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 text-2xl">×</button>
        <div id="modalContent" class="p-2 text-center"></div>
    </div>
    </div>

    <script>
        // Global OCR overlay controls
        window.showOcrOverlay = function(message) {
            try {
                const ov = document.getElementById('ocrGlobalOverlay');
                if (!ov) return;
                const msg = ov.querySelector('.ocr-loading-message');
                if (msg) msg.textContent = message || 'Processing document...';
                ov.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } catch(e) { console.warn('showOcrOverlay failed', e); }
        };

        window.hideOcrOverlay = function() {
            try {
                const ov = document.getElementById('ocrGlobalOverlay');
                if (!ov) return;
                ov.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } catch(e) { console.warn('hideOcrOverlay failed', e); }
        };
    </script>

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
                try {
                    // If a combined hidden address was applied, also populate the address subfields
                    if (address && typeof splitAddressToFields === 'function') {
                        splitAddressToFields(address);
                    }
                    // ensure hidden combined is consistent with subfields
                    if (typeof combineAddressFields === 'function') combineAddressFields();
                } catch(e) { console.warn('address applySync failed', e); }
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
                    // Also accept a rendered preview in the UI as evidence of upload (more robust)
                    try {
                        const displayEl = document.getElementById('pwdidDisplay');
                        if (displayEl) {
                            // presence of action buttons (View/Remove) indicates a rendered uploaded preview
                            if (displayEl.querySelector('button')) return true;
                            const txt = (displayEl.textContent || '').trim();
                            if (txt && txt.length > 5 && txt.toLowerCase().indexOf('please upload') === -1) return true;
                        }
                    } catch(e) {}
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

            // If any OCR processing indicators are present, prevent premature submission
            try {
                const anyLoading = document.querySelector('[id^="ocr-loading-"]');
                if (anyLoading) {
                    alert('OCR is still processing one or more uploads. Please wait a moment and try again.');
                    return false;
                }
            } catch(e) {}

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
                    // Collect Education entries from the Education section and include in draft
                    try {
                        const eduContainer = document.getElementById('educationContainer');
                        const educationArr = [];
                        if (eduContainer) {
                            const items = Array.from(eduContainer.querySelectorAll('.education-item'));
                            items.forEach(it => {
                                try {
                                    const level = (it.querySelector('select[name="education_level[]"]') || {}).value || '';
                                    const school = (it.querySelector('input[name="education_school[]"]') || {}).value || '';
                                    const program = (it.querySelector('input[name="education_program[]"]') || {}).value || '';
                                    const start = (it.querySelector('input[name="education_start[]"]') || {}).value || '';
                                    const end = (it.querySelector('input[name="education_end[]"]') || {}).value || '';
                                    // only include entries with some content
                                    if (level || school || program || start || end) {
                                        educationArr.push({ level, school, program, start, end });
                                    }
                                } catch(e){}
                            });
                        }
                        if (educationArr.length) draft.education = JSON.stringify(educationArr);
                    } catch(e) { console.warn('collect education failed', e); }

                    // Collect Work Experience entries and include in draft
                    try {
                        const jobContainer = document.getElementById('job_experiences_container');
                        const workArr = [];
                        if (jobContainer) {
                            const items = Array.from(jobContainer.querySelectorAll('.job_exp_item'));
                            items.forEach(it => {
                                try {
                                    const title = (it.querySelector('input[name="job_title[]"]') || {}).value || '';
                                    const company = (it.querySelector('input[name="company_name[]"]') || {}).value || '';
                                    const location = (it.querySelector('input[name="company_location[]"]') || {}).value || '';
                                    const start_month = (it.querySelector('select[name="job_start_month[]"]') || {}).value || '';
                                    const start_year = (it.querySelector('input[name="job_start_year[]"]') || {}).value || '';
                                    const end_month = (it.querySelector('select[name="job_end_month[]"]') || {}).value || '';
                                    const end_year = (it.querySelector('input[name="job_end_year[]"]') || {}).value || '';
                                    const description = (it.querySelector('textarea[name="job_description[]"]') || {}).value || '';
                                    // job cert files are optional; we don't inline binaries here
                                    if (title || company || location || start_month || start_year || end_month || end_year || description) {
                                        workArr.push({ title, company, location, start_month, start_year, end_month, end_year, description });
                                    }
                                } catch(e){}
                            });
                        }
                        if (workArr.length) draft.job_experiences = JSON.stringify(workArr);
                    } catch(e) { console.warn('collect work experience failed', e); }

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

               window.location.href = '{{ route("registerworkplace") }}';
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
                try {
                    if (typeof setupUpload === 'function') {
                        setupUpload('proofFile','proofDisplay','proofLabel','proofHint');
                        setupUpload('pwdidFile','pwdidDisplay','pwdidLabel','pwdidHint');
                        setupUpload('medFile','medDisplay','medLabel','medHint');
                        setupUpload('fitFile','fitDisplay','fitLabel','fitHint');
                        setupUpload('guardianIdFile','guardianIdDisplay','guardianIdLabel','guardianIdHint');
                        setupUpload('resumeFile','resumeDisplay','resumeLabel','resumeHint');
                    }
                } catch(e){}
            });
            </script>

<script>
// Resume OCR hookup: on resume file change, POST to server OCR endpoint and autofill fields
document.addEventListener('DOMContentLoaded', function() {
    const resumeInput = document.getElementById('resumeFile');
    const resumeDisplay = document.getElementById('resumeDisplay');
    if (!resumeInput) return;

    resumeInput.addEventListener('change', async function (evt) {
        const file = (this.files && this.files[0]) ? this.files[0] : null;
        if (!file) return;
        try {
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            const storedNameKey = 'admin_uploaded_resume_name';
            const storedDataKey = 'admin_uploaded_resume_data';
            const storedTypeKey = 'admin_uploaded_resume_type';

            // Ensure file card exists (create if missing) and persist the file data
            if (resumeDisplay && !resumeDisplay.querySelector('.filename')) {
                const icon = ['jpg','jpeg','png'].includes(ext) ? '🖼️' : (ext === 'pdf' ? '📄' : '📁');
                resumeDisplay.innerHTML = `
                    <div class="w-full bg-white border border-gray-200 rounded-lg px-3 py-3 shadow-sm mt-3">
                        <div class="flex items-start gap-4">
                            <div class="thumb">${['jpg','jpeg','png'].includes(ext) ? `<img src="" alt="thumb" class="max-w-[110px] max-h-[88px] rounded-md object-cover">` : `<div class="pdf-icon inline-flex items-center justify-center w-[80px] h-[64px] bg-[#eff6ff] text-[#1e40af] font-bold rounded-md">PDF</div>`}</div>
                            <div class="flex-1 min-w-0">
                                <div class="filename text-sm text-gray-700 break-words truncate">${file.name}</div>
                                <div class="ocr-summary-small mt-1 text-sm text-gray-600"></div>
                            </div>
                            <div class="flex-shrink-0 flex flex-col items-center gap-2">
                                <button type="button" class="viewBtn bg-[#2E2EFF] hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-md">View / Tingnan</button>
                                <button type="button" class="removeBtn bg-[#D20103] hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Remove / Alisin</button>
                            </div>
                        </div>
                    </div>
                `;

                // attach view/remove handlers (prefer stored data URL like other uploads)
                const viewBtn = resumeDisplay.querySelector('.viewBtn');
                const removeBtn = resumeDisplay.querySelector('.removeBtn');
                if (viewBtn) viewBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    try {
                        const modalEl = document.getElementById('fileModal');
                        const modalContentEl = document.getElementById('modalContent');
                        if (!modalEl || !modalContentEl) {
                            // fallback to open in new tab
                            const objUrl = URL.createObjectURL(file);
                            window.open(objUrl, '_blank');
                            return;
                        }

                        const stored = localStorage.getItem(storedDataKey);
                        const storedType = localStorage.getItem(storedTypeKey) || ext;

                        let url = null;
                        let fileExt = (storedType || '').toLowerCase();

                        if (stored) {
                            try {
                                const parsed = JSON.parse(stored);
                                if (Array.isArray(parsed) && parsed.length) {
                                    url = parsed[0];
                                    fileExt = (Array.isArray(JSON.parse(storedType || '[]')) ? (JSON.parse(storedType || '[]')[0] || ext) : ext);
                                } else if (typeof parsed === 'string') {
                                    url = parsed;
                                }
                            } catch(e) {
                                url = stored;
                            }
                        }

                        if (!url) url = URL.createObjectURL(file);

                        let inner = '';
                        if (['jpg','jpeg','png'].includes(fileExt) || (typeof url === 'string' && url.startsWith('data:image'))) {
                            inner = `<img src="${url}" class="max-h-[80vh] mx-auto rounded-lg">`;
                        } else if (fileExt === 'pdf' || (typeof url === 'string' && url.endsWith('.pdf')) || (typeof url === 'string' && url.startsWith('data:application/pdf')) ) {
                            inner = `<iframe src="${url}" class="w-full h-[80vh] rounded-lg border-0"></iframe>`;
                        } else {
                            inner = `<p class="text-gray-700 text-center">This file type cannot be previewed.<br>(Hindi maaaring i-preview ang file na ito.)</p>`;
                        }

                        modalContentEl.innerHTML = `
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm text-slate-600">1 / 1</div>
                            </div>
                            <div class="modal-body">${inner}</div>
                        `;
                        modalEl.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                        return;
                    } catch (err) {
                        console.warn('resume view failed', err);
                        try { const objUrl = URL.createObjectURL(file); window.open(objUrl, '_blank'); } catch(e){}
                    }
                });

                if (removeBtn) removeBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    try { resetDisplay(); } catch(e) { resumeDisplay.innerHTML = ''; }
                    try { resumeInput.value = ''; } catch(e) {}
                    try { localStorage.removeItem(storedNameKey); localStorage.removeItem(storedDataKey); localStorage.removeItem(storedTypeKey); } catch(e) {}
                    try { cleanupUploadedFileByName(file.name); } catch(e) {}
                });

                // persist data URL for reload/restore and populate thumb if image
                const rdr = new FileReader();
                rdr.onload = function(ev) {
                    try {
                        localStorage.setItem(storedNameKey, file.name);
                        localStorage.setItem(storedDataKey, ev.target.result);
                        localStorage.setItem(storedTypeKey, ext);
                        const img = resumeDisplay.querySelector('.thumb img');
                        if (img && ev.target && ev.target.result && ['jpg','jpeg','png'].includes(ext)) img.src = ev.target.result;
                    } catch(e) { console.warn('persist resume data failed', e); }
                };
                rdr.readAsDataURL(file);
            }

            // show inline loading inside the card (or fallback text)
            if (resumeDisplay) {
                const fnameEl = resumeDisplay.querySelector && resumeDisplay.querySelector('.filename');
                if (fnameEl) {
                    let loading = resumeDisplay.querySelector('.ocr-loading-container');
                    if (!loading) {
                        loading = document.createElement('div');
                        loading.className = 'ocr-loading-container mt-2 text-sm text-gray-500';
                        loading.innerHTML = `<span class="ocr-loading-text">Processing resume (OCR)...</span>`;
                        fnameEl.parentNode.appendChild(loading);
                    } else {
                        const txtEl = loading.querySelector('.ocr-loading-text'); if (txtEl) txtEl.textContent = 'Processing resume (OCR)...';
                        loading.style.display = '';
                    }
                } else {
                    resumeDisplay.textContent = 'Processing resume (OCR)...';
                }
            }

            const fd = new FormData(); fd.append('file', file);
            try { const uid = (typeof window !== 'undefined' && window.LARAVEL_USER_ID) ? String(window.LARAVEL_USER_ID) : (localStorage.getItem('user_id') || ''); if (uid) fd.append('user_id', uid); } catch(e){}

            try { if (typeof window.showOcrOverlay === 'function') window.showOcrOverlay('Processing resume (OCR)...'); } catch(e){}
            const res = await fetch('/db/resume-ocr.php', { method: 'POST', credentials: 'same-origin', body: fd });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const json = await res.json();
            if (!json || json.success !== true) {
                try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                throw new Error(json && json.message ? json.message : 'OCR failed');
            }

            const aiData = json.data || json.structured || null;
            if (aiData && typeof applyOcrDataToForm === 'function') {
                try { applyOcrDataToForm(aiData, 'resume', 'resume'); } catch (e) { console.warn('applyOcrDataToForm failed', e); }
            }

            // append summary into the card and hide loading
            if (resumeDisplay) {
                let summary = '';
                if (aiData) {
                    if (aiData.name) summary += aiData.name + ' ';
                    if (Array.isArray(aiData.emails) && aiData.emails[0]) summary += ' • ' + aiData.emails[0];
                    if (Array.isArray(aiData.phones) && aiData.phones[0]) summary += ' • ' + aiData.phones[0];
                }
                const txt = summary.trim() || 'OCR completed — fields populated where possible.';
                try {
                    const fnameEl = resumeDisplay.querySelector && resumeDisplay.querySelector('.filename');
                    if (fnameEl) {
                        let note = resumeDisplay.querySelector('.ocr-summary-small');
                        if (!note) {
                            note = document.createElement('div');
                            note.className = 'ocr-summary-small mt-1 text-sm text-gray-600';
                            fnameEl.parentNode.appendChild(note);
                        }
                        note.textContent = txt;
                        const loading = resumeDisplay.querySelector('.ocr-loading-container'); if (loading) loading.style.display = 'none';
                        try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
                    } else {
                        const loading = resumeDisplay.querySelector && resumeDisplay.querySelector('.ocr-loading-container'); if (loading) loading.style.display = 'none';
                        resumeDisplay.textContent = txt;
                    }
                } catch(e) { resumeDisplay.textContent = txt; }

                // show confirmation modal
                try {
                    showOcrModal({
                        type: 'success',
                        title: 'Resume Processed',
                        message: 'Your resume was scanned and information was applied to the form where possible.',
                        details: [
                            { label: 'Name', value: aiData.name || '' },
                            { label: 'Email', value: (Array.isArray(aiData.emails) && aiData.emails[0]) || '' }
                        ],
                        note: 'Please review and adjust any fields as needed.',
                        confirmText: 'OK'
                    });
                } catch(e) { console.warn('showOcrModal failed for resume', e); }
            }

        } catch (err) {
            try { if (typeof window.hideOcrOverlay === 'function') window.hideOcrOverlay(); } catch(e){}
            console.error('Resume OCR error', err);
            if (resumeDisplay) {
                const fnameEl = resumeDisplay.querySelector && resumeDisplay.querySelector('.filename');
                const loading = resumeDisplay.querySelector && resumeDisplay.querySelector('.ocr-loading-container');
                if (loading) loading.style.display = 'none';
                if (fnameEl) {
                    let errEl = resumeDisplay.querySelector('.ocr-error');
                    if (!errEl) { errEl = document.createElement('div'); errEl.className = 'ocr-error mt-1 text-sm text-red-600'; fnameEl.parentNode.appendChild(errEl); }
                    errEl.textContent = 'Resume OCR failed. Please try again.';
                } else {
                    resumeDisplay.textContent = 'Resume OCR failed. Please try again.';
                }
            }
        }
    });
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

<script>
(function(){
    function setModalVisibility(modal, visible) {
        const panel = modal.querySelector('[data-modal-panel]');
        if (!panel) return;
        if (visible) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                panel.classList.remove('opacity-0','scale-95');
                panel.classList.add('opacity-100','scale-100');
            }, 10);
            document.body.classList.add('overflow-hidden');
        } else {
            panel.classList.remove('opacity-100','scale-100');
            panel.classList.add('opacity-0','scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
            document.body.classList.remove('overflow-hidden');
        }
    }

    window.showOcrModal = function(opts) {
        const modal = document.getElementById('ocrResultModal');
        if (!modal) return;
        const titleEl = document.getElementById('ocrModalTitle');
        const messageEl = document.getElementById('ocrModalMessage');
        const detailsEl = document.getElementById('ocrModalDetails');
        const noteEl = document.getElementById('ocrModalNote');
        const iconEl = document.getElementById('ocrModalIcon');
        const primaryBtn = document.getElementById('ocrModalPrimaryBtn');

        const type = opts && opts.type === 'error' ? 'error' : 'success';
        const colorClasses = type === 'error'
            ? ['bg-red-100','text-red-700']
            : ['bg-emerald-100','text-emerald-700'];

        iconEl.className = `mb-4 flex h-14 w-14 items-center justify-center rounded-full ${colorClasses.join(' ')}`;
        iconEl.innerHTML = type === 'error'
            ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7"><path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5zm.75 6.75a.75.75 0 10-1.5 0v4.5a.75.75 0 001.5 0V9zm0 7.5a.75.75 0 10-1.5 0 .75.75 0 001.5 0z" clip-rule="evenodd"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7"><path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5zm4.03 7.03a.75.75 0 00-1.06-1.06L10.5 12.69l-1.47-1.47a.75.75 0 10-1.06 1.06l2 2a.75.75 0 001.06 0l4-4z" clip-rule="evenodd"/></svg>';

        titleEl.textContent = opts.title || (type === 'error' ? 'Scan Failed' : 'Scan Successful');
        messageEl.textContent = opts.message || (type === 'error' ? 'We couldn’t complete the scan.' : 'We’ve successfully processed the uploaded PWD ID.');

        // Build details array (prefer explicit opts.details) and inject detected ID when available
        (function(){
            const escapeHtml = (s) => String(s === null || s === undefined ? '' : s)
                .replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;').replaceAll("'", '&#39;');

            const detailsArr = Array.isArray(opts.details) ? opts.details.slice() : [];

            // Look for common ID fields in aiData (pwd-specific sources)
            const ai = opts.aiData || opts.ai || null;
            let foundId = null;
            if (ai) {
                const idCandidates = [ai.id_number, ai.pwd_number, ai.idno, ai.identification_number, ai.identity_number, ai.card_number];
                foundId = idCandidates.find(v => v !== undefined && v !== null && String(v).trim() !== '') || null;
            }

            // If no aiData ID, inspect provided details for ID-like entries (label contains "id" or value matches alphanumeric pattern)
            if (!foundId && Array.isArray(detailsArr) && detailsArr.length) {
                for (const d of detailsArr) {
                    try {
                        const lab = (d && d.label) ? String(d.label).toLowerCase() : '';
                        const val = (d && d.value) ? String(d.value).trim() : '';
                        if (lab.includes('id') && val) { foundId = val; break; }
                        // common ID patterns: sequence of 4+ alphanum chars (avoid short numbers like dates)
                        if (val && /[A-Za-z0-9\-]{4,}/.test(val) && !/\b\d{1,2}[:\/\-]\d{1,2}[:\/\-]\d{2,4}\b/.test(val)) { foundId = val; break; }
                    } catch (e) { /* ignore */ }
                }
            }

            if (foundId) {
                const hasId = detailsArr.some(d => (d && d.label && String(d.label).toLowerCase().includes('id')) || (d && d.value && String(d.value).includes(String(foundId))));
                if (!hasId) detailsArr.unshift({ label: 'ID Number', value: escapeHtml(String(foundId)) });
            }

            if (detailsArr.length) {
                detailsEl.innerHTML = detailsArr.map(detail => `
                    <div class="rounded-2xl bg-slate-50 p-3">
                        <div class="text-xs uppercase tracking-wide text-slate-500">${escapeHtml(detail.label)}</div>
                        <div class="mt-1 text-sm font-medium text-slate-900">${escapeHtml(detail.value)}</div>
                    </div>
                `).join('');
                detailsEl.classList.remove('hidden');
            } else {
                detailsEl.classList.add('hidden');
                detailsEl.innerHTML = '';
            }
        })();

        noteEl.textContent = opts.note || 'Please review the information for accuracy.';
        primaryBtn.textContent = opts.confirmText || (opts.showRetry ? 'Try Again' : 'Confirm & Continue');
        primaryBtn.dataset.action = opts.showRetry ? 'retry' : 'confirm';

        setModalVisibility(modal, true);
    };

    window.closeOcrModal = function() {
        const modal = document.getElementById('ocrResultModal');
        if (!modal) return;
        setModalVisibility(modal, false);
    };

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('ocrResultModal');
        if (!modal) return;

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeOcrModal();
            }
        });

        const closeBtn = document.getElementById('ocrModalCloseBtn');
        if (closeBtn) closeBtn.addEventListener('click', closeOcrModal);

        const primaryBtn = document.getElementById('ocrModalPrimaryBtn');
        if (primaryBtn) {
            primaryBtn.addEventListener('click', function() {
                const action = this.dataset.action;
                closeOcrModal();
                if (action === 'retry') {
                    document.dispatchEvent(new CustomEvent('ocrRetryRequested'));
                }
            });
        }
    });
})();
</script>

<script>
// Global close handler for file preview modal (covers cases where iframe/pdf steals pointer events)
document.addEventListener('DOMContentLoaded', function(){
    try {
        const btn = document.getElementById('closeModalBtn');
        const fileModal = document.getElementById('fileModal');
        const modalContent = document.getElementById('modalContent');
        if (btn && fileModal && modalContent && !btn._global_wired) {
            btn.addEventListener('click', function(e){ e.preventDefault(); try{ fileModal.classList.add('hidden'); modalContent.innerHTML = ''; document.body.classList.remove('overflow-hidden'); }catch(e){} });
            btn._global_wired = true;
        }
    } catch(e) { console.warn('global close handler attach failed', e); }
});
</script>

<div id="ocrResultModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm">
    <div data-modal-panel class="w-full max-w-lg transform overflow-hidden rounded-3xl bg-white p-6 shadow-2xl transition duration-200 ease-out opacity-0 scale-95">
        <button id="ocrModalCloseBtn" type="button" class="absolute right-4 top-4 text-gray-400 hover:text-gray-700">
            <span class="sr-only">Close</span>×
        </button>
        <div id="ocrModalIcon" class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                <path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5zm4.03 7.03a.75.75 0 00-1.06-1.06L10.5 12.69l-1.47-1.47a.75.75 0 10-1.06 1.06l2 2a.75.75 0 001.06 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 id="ocrModalTitle" class="text-2xl font-semibold text-gray-900 mb-2">Scan Successful</h2>
        <p id="ocrModalMessage" class="text-gray-600 mb-4">We’ve successfully processed the uploaded PWD ID.</p>
        <div id="ocrModalDetails" class="space-y-2 text-sm text-gray-700 mb-4"></div>
        <p id="ocrModalNote" class="text-sm text-gray-500 mb-6">Please review the information for accuracy.</p>
        <div class="flex justify-end">
            <button id="ocrModalPrimaryBtn" type="button" data-action="confirm" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">Confirm & Continue</button>
        </div>
    </div>
</div>

</body>

</html>
