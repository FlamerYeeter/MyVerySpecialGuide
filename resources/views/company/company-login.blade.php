{{--Will move to the company folder tas route niyo ng maayos yan Thomas--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyVerySpecialGuide: Company Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col justify-center items-center bg-cover bg-center relative"
    style="background-image: url('image/herobg.png');">


    <!-- Login Card -->
    <div class="bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md p-8 sm:p-10 w-11/12 max-w-md text-center">
        <!-- Header -->
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">LOG IN</h2>

        <!-- Form -->
        <form method="POST" action="#" class="space-y-5">
            @csrf
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

    <!-- Create Account Card -->
    <div class="mt-4 bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md p-6 w-11/12 max-w-md text-center">
        <p class="text-gray-800 text-base">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Create Account</a>
        </p>
    </div>

</body>
</html>
