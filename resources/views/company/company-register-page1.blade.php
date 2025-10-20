{{--Will move to the company folder tas route niyo ng maayos yan Thomas--}}
{{--gagawin kong responsive mamaya--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyVerySpecialGuide: Company Register - Page 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#ffffff] min-h-screen flex justify-center py-12 font-sans">
  <div class="bg-[#FFF4CC] rounded-3xl shadow-md w-[900px] px-10 py-10 relative border border-yellow-100">

    <!-- Step Info -->
    <div class="absolute top-6 right-8 text-gray-800 text-sm font-medium">
      Step 1 out of 2
    </div>

    <!-- Header -->
    <div class="text-center mb-6">
      <h1 class="text-3xl font-bold text-[#2563EB]">Create An Account</h1>
      <div class="flex justify-center mt-3">
        <img src="/image/obj6.png" alt="Monster Icon" class="w-14 h-14">
      </div>
    </div>

    <!-- For Admin Approval Notice -->
    <div class="border border-[#2563EB] bg-white rounded-md p-4 mb-8 text-left">
      <h2 class="text-[#2563EB] font-semibold mb-1">For Admin Approval</h2>
      <p class="text-sm text-gray-700">
        Please enter your information in the box below accurately. Fields marked with an asterisk (<span class="text-red-500">*</span>) are required. 
        The details you provide help our administrators verify your account, confirm your eligibility, and ensure proper communication during the approval process. 
        Also, attach a valid proof of employment from the organization.
      </p>
    </div>

    <!-- Personal Information Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <h3 class="text-[#2563EB] font-semibold border-b border-gray-200 pb-2 mb-4">Personal Information</h3>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold mb-1">First Name <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="First Name">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Last Name <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Last Name">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Email <span class="text-red-500">*</span></label>
          <input type="email" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Email">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Contact Number <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="+63 9XX XXX XXXX">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Date of Birth <span class="text-red-500">*</span></label>
          <input type="date" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Gender <span class="text-red-500">*</span></label>
          <select class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none">
            <option value="">Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Prefer not to say</option>
          </select>
        </div>
        <div class="col-span-2">
          <label class="block text-sm font-semibold mb-1">Complete Address <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Address">
        </div>
      </div>
    </div>

    <!-- Company Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <h3 class="text-[#2563EB] font-semibold border-b border-gray-200 pb-2 mb-4">Company Information</h3>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold mb-1">Company Name <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Company Name">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Business Permit <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Business Permit">
        </div>
        <div class="col-span-2">
          <label class="block text-sm font-semibold mb-1">Position/Designation</label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="e.g. Representative, Care Manager">
        </div>
        <div class="col-span-2">
          <label class="block text-sm font-semibold mb-1">Work Address <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Address">
        </div>
      </div>

      <!-- File Upload -->
    <div class="mt-4">
        <label class="block text-sm font-semibold mb-1">Proof of Company's Authorization <span class="text-red-500">*</span></label>
        <p class="text-xs text-gray-500 mb-2">
            Please note: When uploading your authorization letter, it must be duly signed by your company’s authorized signatory to confirm that
            you are an official and approved company representative.
        </p>
        <div class="flex items-center justify-between border border-blue-100 bg-blue-50 rounded-md p-3">
            <p class="text-sm text-gray-700">Upload Proof (JPG, PNG, or PDF)</p>
            <label for="proof-upload" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md font-medium flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-folder-open"></i> Choose File
            </label>
            <input type="file" id="proof-upload" class="hidden">
        </div>
    </div>
    </div>

    <!-- Account Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <h3 class="text-[#2563EB] font-semibold border-b border-gray-200 pb-2 mb-4">Account Details</h3>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold mb-1">Username <span class="text-red-500">*</span></label>
          <input type="text" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Username">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Password <span class="text-red-500">*</span></label>
          <input type="password" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Password">
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1">Confirm Password <span class="text-red-500">*</span></label>
          <input type="password" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-red-50 focus:ring-2 focus:ring-blue-300 focus:outline-none" placeholder="Confirm Password">
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Valid ID Upload <span class="text-gray-600 text-xs">(for identity verification)</span></label>
            <div class="flex items-center justify-between border border-blue-100 bg-blue-50 rounded-md p-3">
                <p class="text-sm text-gray-700">Upload Proof (JPG, PNG, or PDF)</p>
                <label for="valid-id-upload" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md font-medium flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-folder-open"></i> Choose File
                </label>
                <input type="file" id="valid-id-upload" class="hidden">
            </div>
        </div>
    </div>
    </div>

    <!-- Privacy Agreement -->
    <div class="flex items-center gap-2 mb-6">
      <input type="checkbox" id="privacy" class="h-4 w-4">
      <label for="privacy" class="text-sm">I have read and agree to the 
        <a href="#" class="text-blue-600 font-medium">Data Privacy Policy</a>
      </label>
    </div>

    <!-- Submit Button -->
    <div class="text-center mb-10">
      <button type="button" class="bg-[#2563EB] text-white font-semibold py-3 px-10 rounded-md hover:bg-[#1D4ED8] transition">
        Submit for Approval
      </button>
    </div>

    <!-- Next Step Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
      <h4 class="font-semibold text-gray-800 mb-2">NEXT STEP</h4>
      <p class="text-sm text-gray-600 mb-4">
        Check your email inbox for the approval confirmation message to proceed to the next step.
      </p>
      <hr class="my-4 border-gray-300">
      <p class="text-sm text-gray-600">Didn’t receive confirmation? 
        <a href="#" class="text-blue-600 font-medium">Resend</a>
      </p>
    </div>
  </div>
</body>
</html>
