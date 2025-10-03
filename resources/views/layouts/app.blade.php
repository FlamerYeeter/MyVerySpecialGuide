<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyVerySpecialGuide</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; padding: 0; min-height: 100vh; }
  </style>
</head>

<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="w-full px-8 py-4 flex items-center justify-between bg-white/80 backdrop-blur-md shadow-md">
      <!-- Logo -->
      <div class="flex items-center space-x-3">
        <img src="image/logo.png" alt="MyVerySpecialGuide Logo" class="w-16 h-16 object-contain">
        <span class="text-2xl font-bold text-blue-700">MyVerySpecialGuide</span>
      </div>
      <!-- Links -->
      <div class="flex items-center space-x-8">
        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-lg">Home</a>
        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-lg">About MVSG</a>
        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-lg">About Down Syndrome</a>
      </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

   <!-- Footer -->
<footer class="bg-white border-t mt-12">
  <div class="container mx-auto px-6 py-8 flex flex-col md:flex-row justify-between items-start md:items-center">
    
    <div class="flex items-center space-x-3 mb-6 md:mb-0">
      <img src="{{ asset('image/orglogo.png') }}" alt="Logo" class="h-28 w-28 object-contain">
    </div>

            <div class="flex flex-col md:flex-row md:space-x-16 text-center md:text-left">
                <div class="mb-4 md:mb-0">
                    <h3 class="font-semibold text-gray-800 mb-1">Address</h3>
                    <p class="text-gray-600 text-sm">Tri-AX One Center,<br>Second Floor, 133 M. Almeda St., Brgy. San Roque</p>
                </div>
                <div class="mb-4 md:mb-0">
                    <h3 class="font-semibold text-gray-800 mb-1">Socials</h3>
                    <p class="text-gray-600 text-sm">Facebook<br>Email</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">About</h3>
                    <p class="text-gray-600 text-sm">Privacy Policy</p>
                </div>
            </div>
        </div>
        <div class="bg-blue-400 text-black text-center py-2 text-sm">
            © 2025 EmpowerPath
        </div>
    </footer>
</body>
</html>
