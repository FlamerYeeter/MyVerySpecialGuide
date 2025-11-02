<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyVerySpecialGuide</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
    </style>

    <?php
        // guard Vite manifest so missing build doesn't throw a 500
        $manifestPath = public_path('build/manifest.json');
    ?>

    <?php if(file_exists($manifestPath)): ?>
        
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <?php endif; ?>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="w-full px-6 md:px-12 py-4 bg-white/80 backdrop-blur-md shadow-md">
        <div class="flex items-center justify-between">
            <!-- Logo (links to home) -->
            <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-3">
                <img src="image/logo.png" alt="MyVerySpecialGuide Logo" class="w-14 h-14 md:w-16 md:h-16 object-contain">
                <span class="text-xl md:text-2xl font-bold text-blue-700">MyVerySpecialGuide</span>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">Home</a>
                <a href="<?php echo e(route('about.us')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">About MVSG</a>
                <a href="<?php echo e(route('about.ds')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-base md:text-lg">About Down Syndrome</a>
            </div>

            <div class="flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                <div class="hidden md:block relative">
                    <button id="desktopProfileBtn" type="button" onclick="document.getElementById('desktopProfileMenu').classList.toggle('hidden')"
                            class="flex items-center gap-2 border px-3 py-1 rounded-full">
                        <img src="<?php echo e(Auth::user()->photo ?? asset('image/avatar.png')); ?>" alt="avatar" class="w-6 h-6 rounded-full">
                        <span class="text-sm"><?php echo e(Auth::user()->name ?? 'Profile'); ?></span>
                    </button>
                    <div id="desktopProfileMenu" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg py-2 z-50">
                        <a href="<?php echo e(route('user.role')); ?>" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="px-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left text-sm text-red-600 px-2 py-2 hover:bg-gray-100 rounded">Sign Out</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Responsive Menu Button -->
                <button id="menu-toggle" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Responsive Dropdown Menu -->
        <div id="mobile-menu" class="hidden flex-col mt-4 space-y-3 md:hidden">
            <a href="<?php echo e(route('home')); ?>" class="block text-gray-700 hover:text-blue-600 font-medium text-base">Home</a>
            <a href="<?php echo e(route('about.us')); ?>" class="block text-gray-700 hover:text-blue-600 font-medium text-base">About MVSG</a>
            <a href="<?php echo e(route('about.ds')); ?>" class="block text-gray-700 hover:text-blue-600 font-medium text-base">About Down Syndrome</a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('user.role')); ?>" class="block text-gray-700 hover:text-blue-600 font-medium text-base">Profile</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="px-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left text-red-600 font-medium py-2">Sign Out</button>
                </form>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow w-full">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div
            class="container mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-4 gap-5 text-center md:text-left items-center md:items-start">

            <!-- Logo -->
            <div class="flex flex-col items-center md:items-start space-y-3">
                <img src="<?php echo e(asset('image/orglogo.png')); ?>" alt="Logo"
                    class="h-28 w-28 object-contain mx-auto md:mx-0">
            </div>

            <!-- Address -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">Address</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Tri-AX One Center,<br>
                    Second Floor, 133 M. Almeda St.,<br>
                    Brgy. San Roque
                </p>
            </div>

            <!-- Socials -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">Socials</h3>
                <ul class="text-gray-600 text-sm space-y-1">
                    <li><a href="#" class="hover:text-blue-500 transition-colors">Facebook</a></li>
                    <li><a href="mailto:info@example.com" class="hover:text-blue-500 transition-colors">Email</a></li>
                </ul>
            </div>

            <!-- About -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">About</h3>
                <ul class="text-gray-600 text-sm space-y-1">
                    <li><a href="#" class="hover:text-blue-500 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-blue-500 text-white text-center py-3 text-sm">
            © 2025 EmpowerPath. All rights reserved.
        </div>
    </footer>

    <!-- Script for Responsive Menu Toggle -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\resources\views/layouts/app.blade.php ENDPATH**/ ?>