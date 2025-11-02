<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyVerySpecialGuide</title>
    <link rel="stylesheet" href="<?php echo e(asset('build/app.css')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
    <div id="app">
        <h1>Welcome to MyVerySpecialGuide</h1>
        <p>This is a lightweight placeholder home view used during tests.</p>
    </div>
</body>
</html>


  <?php $__env->startSection('content'); ?>
      <!-- Hero Section -->
      <section class="w-full relative overflow-hidden bg-cover bg-center" style="background-image: url('image/herobg.png');">
          <div
              class="flex flex-col md:flex-row items-center justify-between px-6 sm:px-10 md:px-20 lg:px-32 pt-12 md:pt-16 lg:pt-20 relative z-10">

              <!-- Left Text -->
              <div class="flex-1 max-w-2xl text-center md:text-left mb-10 md:mb-0">
                  <h1
                      class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-blue-800 leading-tight mb-6 sm:mb-8 drop-shadow-lg">
                      WELCOME to<br>
                      <span class="text-blue-600">MyVerySpecialGuide</span>
                  </h1>
                  <a href="<?php echo e(route('login')); ?>"
                     class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-8 sm:px-10 py-3 sm:py-4 rounded-xl text-base sm:text-lg font-semibold shadow-lg transition-transform transform hover:scale-105">
                     Get Started
                 </a>
              </div>

              <!-- Right Object -->
              <div class="flex-1 flex justify-center md:justify-end">
                  <img src="image/obj1.png" alt="Object1"
                      class="w-56 sm:w-72 md:w-96 lg:w-[28rem] object-contain drop-shadow-xl">
              </div>
          </div>
      </section>

      <!-- About Section -->
      <section class="w-full bg-white py-16 sm:py-20 relative overflow-hidden">
          <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center relative z-10">
              <p class="text-base sm:text-lg md:text-xl text-gray-700 leading-relaxed mb-10 sm:mb-12">
                  We believe everyone deserves the chance to work, grow, and shine.
                  At the <span class="font-semibold text-blue-600">Down Syndrome Work Society</span>,
                  we open doors for people with Down syndrome to share their talents and build brighter futures.
              </p>
             
          </div>

          <!-- Image with Borders -->
          <div class="relative w-full">
              <img src="image/img1.png" alt="indiv with ds" class="w-full h-[300px] sm:h-[400px] md:h-[500px] object-cover">

              <!-- Top Border -->
              <img src="image/border1.png" alt="Top border decoration"
                  class="absolute -top-2 sm:-top-4 left-0 w-full h-8 sm:h-12 md:h-16 object-cover">

              <!-- Bottom Border -->
              <img src="image/border2.png" alt="Bottom border decoration"
                  class="absolute bottom-0 left-0 w-full h-8 sm:h-12 md:h-16 object-cover translate-y-4 sm:translate-y-8 md:translate-y-12">
          </div>
      </section>

      <!-- Info Section -->
      <section class="w-full py-12 sm:py-16 md:py-20 relative bg-transparent !bg-none">
          <!-- Mascots -->
          <img src="image/obj3.png" alt="Blue Circle Mascot"
              class="hidden lg:block absolute top-6 lg:top-12 left-6 lg:left-12 w-12 sm:w-14 md:w-16 lg:w-20 xl:w-24 opacity-90">
          <img src="image/obj5.png" alt="Green Square Mascot"
              class="hidden lg:block absolute bottom-8 sm:bottom-12 lg:bottom-16 left-6 lg:left-10 w-12 sm:w-14 md:w-16 lg:w-20 xl:w-24 opacity-90">
          <img src="image/obj4.png" alt="Yellow Mascot"
              class="hidden lg:block absolute bottom-10 sm:bottom-14 lg:bottom-20 right-12 sm:right-16 lg:right-24 w-14 sm:w-16 md:w-20 lg:w-24 xl:w-28 opacity-90">
          <img src="image/obj2.png" alt="Pink Flower Mascot"
              class="hidden lg:block absolute top-12 sm:top-16 lg:top-24 right-8 lg:right-16 w-12 sm:w-14 md:w-16 lg:w-20 xl:w-24 opacity-90">

          <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center gap-8 md:gap-12">
              <!-- Image -->
              <div class="w-full md:w-1/2">
                  <img src="image/img2.png" alt="b&w img"
                      class="rounded-lg shadow-xl w-full h-60 sm:h-72 md:h-80 object-cover">
              </div>

              <!-- Text Content -->
              <div class="w-full md:w-1/2 rounded-xl shadow-lg p-6 sm:p-8 md:p-10 relative bg-white/90">
                  <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 text-gray-800">What is Down Syndrome?</h2>
                  <p class="text-sm sm:text-base text-gray-700 mb-3 sm:mb-4 leading-relaxed">
                      Down syndrome (or Trisomy 21) is a naturally occurring chromosomal arrangement that has always been a
                      part of the human condition.
                  </p>
                  <p class="text-sm sm:text-base text-gray-700 mb-6 sm:mb-8 leading-relaxed">
                      This difference may affect learning, growth, and development, but it does not define a person's full
                      potential.
                  </p>
                  <a href="<?php echo e(route('about.ds')); ?>"
                      class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-semibold shadow-md transition-transform hover:scale-105 text-sm sm:text-base">
                      Learn More
                  </a>
              </div>
          </div>
      </section>

      <!-- Yellow Border -->
      <div class="relative w-full -mb-14 z-10">
          <img src="image/border3.png" alt="Yellow Border" class="w-full object-cover h-16 md:h-20 block relative z-10">
      </div>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\MyVerySpecialGuide\resources\views/home.blade.php ENDPATH**/ ?>