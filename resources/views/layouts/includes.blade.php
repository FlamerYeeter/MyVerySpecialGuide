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
<body>
<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
            <div class="flex items-center space-x-2">
                <img src="image/logo.png" alt="Logo" class="w-16 h-16 object-contain">
                <h1 class="text-2xl font-bold text-blue-700">MyVerySpecialGuide</h1>
            </div>
            <nav class="mt-3 md:mt-0 space-x-3">
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Job Matches</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Goals & Progress</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Why This Job & How to Get There</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Guardian Review</button>
            </nav>
            <div class="relative mt-3 md:mt-0">
                <button class="border px-3 py-1 rounded-full text-sm">Profile ▾</button>
            </div>
        </div>
    </header>
    <!-- Info -->
    <div class="text-center mt-3 text-sm underline text-gray-600">
        <a href="#" class="hover:text-blue-600 font-medium">Click to know about the navigation buttons above</a>
        <p class="italic text-xs">(pindutin upang malaman ang tungkol sa navigation buttons sa taas)</p>
    </div>
    <!-- Page Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

</body>