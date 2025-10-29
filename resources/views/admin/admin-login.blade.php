{{--Will move to the admin folder tas route niyo ng maayos yan Thomas--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col justify-center items-center bg-cover bg-center relative"
    style="background-image: url('image/herobg.png');">


    <!-- Login Card -->
<div class="bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md p-10 sm:p-14 w-11/12 max-w-md text-center min-h-[500px] flex flex-col justify-center">
        <!-- Header -->
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">LOG IN</h2>

        <!-- Form -->
        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf
            <!-- After successful login, send user to the admin approval view -->
            <input type="hidden" name="redirect" value="{{ route('admin.approval') }}">
            @if($errors->any())
                <div class="text-red-600 text-sm">{{ $errors->first() }}</div>
            @endif
            <input name="email" type="text" placeholder="Email"
                value="{{ old('email') }}"
                class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input name="password" type="password" placeholder="Password"
                class="w-full px-4 py-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-md transition-all duration-300">
                Log In
            </button>
        </form>

        <!-- Forgot Password -->
        <div class="mt-4">
            <a href="#" class="text-sm text-gray-700 hover:underline font-medium">
                Forgot your password?
            </a>
        </div>
    </div>

       <!-- ✅ Notification Modal (Place this before </body>) -->
    <div id="notificationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between bg-yellow-400 px-6 py-3">
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                    </svg>
                    <h2 class="text-white font-semibold text-lg">Notification</h2>
                </div>
                <button onclick="closeModal()" class="text-white text-2xl leading-none hover:text-gray-200">&times;</button>
            </div>

            <!-- Body -->
            <div class="bg-rose-50 px-6 py-6 text-center">
                <p class="text-lg text-gray-900 font-medium">
                    Only authorized administrators can log in account.
                </p>
            </div>
        </div>
    </div>

    <!-- JS for Modal -->
    <script>
        function openModal() {
            document.getElementById('notificationModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('notificationModal').classList.add('hidden');
        }

        // Example: automatically open modal if error exists
        @if($errors->any())
            openModal();
        @endif
    </script>
    

</body>
</html>
