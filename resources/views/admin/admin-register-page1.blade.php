{{--Will move to the admin folder tas route niyo ng maayos yan Thomas--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-[url('/images/background-pattern.png')] bg-cover bg-center">

    <!-- Main Container -->
    <div class="bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md w-[750px] p-10 text-center relative border border-yellow-200">

        <!-- Step Info -->
        <div class="absolute top-6 right-8 text-gray-700 text-sm">
            Step 1 out of 2
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-sans text-gray-800 mb-2">Create An Account</h1>
        <div class="flex justify-center mb-4">
            <img src="/image/obj6.png" alt="icon" class="w-16 h-16">
        </div>

        <!-- Section Label -->
        <h2 class="text-left text-sm font-semibold text-blue-600 mb-1">For Admin Approval</h2>
        <p class="text-left text-xs text-gray-600 mb-4">Please type your information inside the box.</p>

        <!-- Form Box -->
        <div class="bg-white p-6 rounded-md shadow-sm border border-gray-200 mb-5 text-left">
            <form class="space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-800 mb-1">First Name<span class="text-red-500">*</span></label>
                        <input type="text" placeholder="First name" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-800 mb-1">Last Name<span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Last name" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-800 mb-1">Email Address<span class="text-red-500">*</span></label>
                    <input type="email" placeholder="Email Address" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>
            </form>
        </div>

        <!-- Click to Submit Label -->
        <p class="text-xs text-blue-500 mb-2">Click to Submit for Approval</p>

        <!-- Submit Button -->
        <button class="w-[320px] bg-blue-500 text-white py-2 rounded-md font-semibold hover:bg-blue-600 transition">
            Submit for Approval
        </button>

        <!-- Info Text -->
        <p class="text-xs text-gray-700 mt-3">
            Check your email inbox for the approval confirmation message to verify and complete the registration.
        </p>

        <!-- Resend -->
        <p class="text-xs text-gray-800 mt-8">
            Didn’t receive confirmation? Click 
            <a href="#" class="text-blue-500 underline">Resend</a>
        </p>
    </div>

</body>
</html>
