<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Your Role</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen flex flex-col justify-center items-center p-4 sm:p-6">

  <!-- Logo (Top Left) -->
  <div class="absolute top-3 left-3 sm:top-4 sm:left-4">
    <img src="image/logo.png" alt="MVSG Logo" class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 object-contain">
  </div>

  <?php if(auth()->guard()->check()): ?>
  <!-- Profile (Top Right) -->
  <div class="absolute top-3 right-3 sm:top-4 sm:right-4">
    <div class="relative">
      <button id="profileToggle" type="button" onclick="document.getElementById('profileMenu').classList.toggle('hidden')"
              class="flex items-center gap-2 bg-white border border-gray-200 rounded-full px-3 py-1 shadow-sm hover:shadow-md">
        <img src="<?php echo e(Auth::user()->photo ?? asset('image/avatar.png')); ?>" alt="avatar" class="w-8 h-8 rounded-full object-cover">
        <span class="hidden sm:inline text-sm font-medium text-gray-700"><?php echo e(Auth::user()->name ?? 'Profile'); ?></span>
      </button>

      <div id="profileMenu" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg py-2 z-50">
        <a href="<?php echo e(route('user.role')); ?>" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="px-2">
          <?php echo csrf_field(); ?>
          <button type="submit" class="w-full text-left text-sm text-red-600 px-2 py-2 hover:bg-gray-100 rounded">Sign Out</button>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Header -->
  <div class="text-center mb-6 sm:mb-8 mt-20 sm:mt-0">
    <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-900">Select your role</h1>
    <img src="image/obj13.png" alt="Mascot" class="mx-auto mt-3 sm:mt-4 w-12 sm:w-16 md:w-20">
  </div>

  <!-- Role Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 max-w-6xl w-full px-4 sm:px-8">
    
    <!-- User / Guardian -->
    <a href="<?php echo e(route('login')); ?>" 
       class="block border border-gray-300 rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-lg hover:border-blue-500 hover:bg-blue-50 transition duration-300">
      <img src="image/role1.png" alt="User / Guardian" class="mx-auto mb-4 w-20 sm:w-24 md:w-28">
      <h3 class="text-blue-700 font-semibold text-lg mb-2">Applicant</h3>
      <p class="text-gray-600 text-sm md:text-base leading-relaxed">
        Individual with Down syndrome seeking employment opportunities, with guardian support 
        for profile setup, career exploration, and job search assistance.
      </p>
    </a>

    <!-- Expert (Therapist) -->
    

    <!-- Company -->
    <a href="<?php echo e(route('company.login')); ?>" 
        class="border border-gray-300 rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-lg hover:border-blue-500 hover:bg-blue-50 transition duration-300">
      <img src="image/role3.png" alt="Company" class="mx-auto mb-4 w-20 sm:w-24 md:w-28">
      <h3 class="text-blue-700 font-semibold text-lg mb-2">Company</h3>
      <p class="text-gray-600 text-sm md:text-base leading-relaxed">
        Post available job opportunities, manage job listings, review candidate applications, 
        and connect with potential employees for career opportunities.
      </p>
    </a>

    <!-- Admin -->
  <a href="http://103.38.251.55/_/r/mvsg/adminhub"
       class="block border border-gray-300 rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-lg hover:border-blue-500 hover:bg-blue-50 transition duration-300">
      <img src="image/role4.png" alt="Admin" class="mx-auto mb-4 w-20 sm:w-24 md:w-28">
      <h3 class="text-blue-700 font-semibold text-lg mb-2">Admin</h3>
      <p class="text-gray-600 text-sm md:text-base leading-relaxed">
        Manages system moderation and approval workflows. Reviews and approves new employer
        entries, user feedback, flagged content, and training materials to ensure safety,
        relevance, and accessibility.
      </p>
    </a>
  </div>

  <!-- Back Button -->
  <div class="mt-10 flex justify-center w-full px-4">
    <a href="<?php echo e(route('login')); ?>"
       class="flex items-center justify-center gap-3 bg-blue-500 hover:bg-blue-600 
              text-white font-bold text-lg sm:text-xl py-3 px-10 sm:px-14 rounded-lg 
              shadow-md transition-all w-full sm:w-auto max-w-xs sm:max-w-sm">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
           stroke-width="2.5" stroke="currentColor" class="w-6 h-6 sm:w-7 sm:h-7">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back</span>
    </a>
  </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\resources\views/user_role.blade.php ENDPATH**/ ?>