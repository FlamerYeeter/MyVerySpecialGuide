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

    <!-- Back Button -->
    <div class="absolute top-6 left-6">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold text-xl py-2 px-5 rounded-lg shadow transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="currentColor" class="w-8 h-8 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <!-- Login Card -->
    <div class="bg-yellow-100 bg-opacity-90 rounded-2xl shadow-md p-8 sm:p-10 w-11/12 max-w-md text-center">
        <!-- Header -->
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">LOG IN</h2>

        <!-- Form -->
        <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="redirect" value="/navigation-buttons" />
            <?php if($errors->any()): ?>
                <div class="text-red-600 text-sm"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>
            <input name="email" type="text" placeholder="Email"
                value="<?php echo e(old('email')); ?>"
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
            <a href="<?php echo e(route('user.role')); ?>" class="text-blue-600 font-semibold hover:underline">Create Account</a>
        </p>
    </div>
<!-- Modal (hidden by default) -->
<div id="verifyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl shadow-lg p-8 w-11/12 max-w-md text-center">
    <h3 class="text-2xl font-bold mb-4 text-gray-900">Email Verification Required</h3>
    <p class="text-gray-700 mb-6">
      Please verify your email before you can log in. We have sent a verification link to your Gmail account.
    </p>
    <button id="resendEmail" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md transition-all duration-300 mb-4">
      Resend Verification Email
    </button>
    <button id="closeModal" class="text-gray-500 hover:text-gray-700 underline font-medium">
      Close
    </button>
  </div>
</div>

</body>
</html>


<?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\MyVerySpecialGuide\resources\views/user_login.blade.php ENDPATH**/ ?>