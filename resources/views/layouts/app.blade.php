<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyVerySpecialGuide</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full">
                <span class="font-bold text-xl text-blue-600">MyVerySpecialGuide</span>
            </div>

            <!-- Menu -->
            <div class="flex items-center space-x-6">
                <a href="/" class="text-gray-700 hover:text-blue-600">Home</a>
                <a href="/about-mvsg" class="text-gray-700 hover:text-blue-600">About MVSG</a>
                <a href="/about-down-syndrome" class="text-gray-700 hover:text-blue-600">About Down Syndrome</a>
            </div>

            <!-- Right Buttons -->
            <div>
                <a href="/login" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Log In</a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>
