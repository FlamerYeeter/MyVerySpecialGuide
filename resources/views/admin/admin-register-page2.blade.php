{{--Will move to the admin folder tas route niyo ng maayos yan Thomas--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-[url('/images/background-pattern.png')] bg-cover bg-center">

    <!-- Main Container -->
    <div class="bg-[#FFF4CC] bg-opacity-90 rounded-3xl shadow-md w-[750px] p-10 text-center relative border border-yellow-200">

        <!-- Step Info -->
        <div class="absolute top-6 right-8 text-gray-700 text-sm">
            Step 2 out of 2
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-sans text-gray-800 mb-2">Create An Account</h1>
        <div class="flex justify-center mb-4">
            <img src="/image/obj6.png" alt="icon" class="w-16 h-16">
        </div>

        <!-- Section Header -->
        <h2 class="text-left text-lg font-semibold text-sky-500 mb-1">Complete the registration</h2>
        <p class="text-left text-xs text-gray-600 mb-6">Please type your information inside the box.</p>

        <!-- Form -->
        <form class="space-y-4 text-left">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-800 mb-1">First Name<span class="text-red-500">*</span></label>
                    <input type="text" placeholder="First name" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-800 mb-1">Last Name<span class="text-red-500">*</span></label>
                    <input type="text" placeholder="Last name" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-800 mb-1">Email Address<span class="text-red-500">*</span></label>
                <input type="email" placeholder="Email Address" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-800 mb-1">Contact Number<span class="text-red-500">*</span></label>
                    <input type="text" placeholder="Contact Number" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-800 mb-1">Birthday<span class="text-red-500">*</span></label>
                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-800 mb-1">Password<span class="text-red-500">*</span></label>
                    <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-800 mb-1">Re-Type Password<span class="text-red-500">*</span></label>
                    <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-[#FFF6F6] focus:ring-2 focus:ring-sky-400 focus:outline-none">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button class="w-[320px] bg-sky-400 text-white py-2 rounded-md font-semibold hover:bg-sky-500 transition">
                    Create My Account
                </button>
            </div>
        </form>

        <!-- Info Text -->
        <p class="text-xs text-gray-700 mt-4">
            Click <span class="text-sky-500 font-semibold">“Create My Account”</span> to create your account
        </p>
    </div>

</body>
</html>
