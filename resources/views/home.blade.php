@extends('layouts.app')

@section('content')
  
   <!-- Hero Section -->
   <section 
    class="w-full relative overflow-hidden"
    style="background-image: url('image/herobg.png'); background-size: cover; background-position: center;"
   >
     <div class="flex flex-col md:flex-row items-center justify-between px-8 md:px-20 lg:px-32 pt-12 md:pt-16 lg:pt-20">
    
    <!-- Left Text -->
    <div class="flex-1 max-w-xl text-center md:text-left mb-12 md:mb-0">
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-blue-800 leading-tight mb-8 drop-shadow-lg">
        WELCOME to<br>
        <span class="text-blue-600">MyVerySpecialGuide</span>
      </h1>
      <button class="bg-blue-500 hover:bg-blue-600 text-white px-10 py-4 rounded-xl text-lg font-semibold shadow-lg transition-transform transform hover:scale-105">
        Get Started
      </button>
    </div>

    <!-- Right Object -->
    <div class="flex-1 flex justify-center md:justify-end">
      <img src="image/obj1.png" alt="Object1" class="w-72 md:w-96 lg:w-[28rem] object-contain drop-shadow-xl">
    </div>

  </div>
</section>

  <!-- About Section -->
<section class="w-full bg-white py-20">
  <div class="max-w-5xl mx-auto px-6 text-center">
    <p class="text-xl text-gray-700 leading-relaxed mb-12">
      We believe everyone deserves the chance to work, grow, and shine. At the 
      <span class="font-semibold text-blue-600">Down Syndrome Work Society</span>, we open doors for people with Down syndrome 
      to share their talents and build brighter futures.
    </p>
  </div>

  <div class="relative w-full">
    <!-- Main background image -->
    <img src="image/img1.png" 
         alt="Child with painting" 
         class="w-full h-[500px] object-cover">

    <!-- Top border-->
    <img src="image/border1.png" 
         alt="Top border decoration"
         class="absolute -top-4 left-0 w-full h-16 object-cover">

    <!-- Bottom border-->
    <img src="image/border2.png" 
     alt="Bottom border decoration"
     class="absolute bottom-0 left-0 w-full h-16 object-cover translate-y-16">
  </div>
</section>

  <!-- Info Section -->
  <section class="w-full py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
      <!-- Image -->
      <div class="md:w-1/2">
        <img src="image/img2.png" 
             alt="b&w img" 
             class="rounded-lg shadow-xl w-full h-80 object-cover">
      </div>
      
      <!-- Text Content -->
      <div class="md:w-1/2 bg-white rounded-xl shadow-lg p-10 relative">
        <div class="absolute -top-6 -right-6">
          <img src="image/obj2.png" alt="Pink Flower Mascot" class="w-20 h-20 object-contain">
        </div>
        
        <h2 class="text-3xl font-bold mb-6 text-gray-800">What is Down Syndrome?</h2>
        <p class="text-gray-700 mb-4 leading-relaxed">
          Down syndrome (or Trisomy 21) is a naturally occurring chromosomal arrangement that has always been a part of the human condition.
        </p>
        <p class="text-gray-700 mb-8 leading-relaxed">
          This difference may affect learning, growth, and development, but it does not define a person’s full potential.
        </p>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow-md transition-transform hover:scale-105">
          Learn More
        </button>
      </div>
    </div>
  </section>

  <!-- Mascots Row -->
  <section class="w-full py-8">
    <div class="flex justify-center items-center gap-10">
      <img src="image/obj3.png" alt="Blue Circle Mascot" class="w-16 h-16 object-contain">
      <img src="image/obj5.png" alt="Green Square Mascot" class="w-16 h-16 object-contain">
      <img src="image/obj4.png" alt="Yellow Sad Mascot" class="w-16 h-16 object-contain">
    </div>
  </section>
@endsection
</body>
</html>