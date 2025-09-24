@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-orange-200 to-white py-16">
    <div class="container mx-auto flex flex-col md:flex-row items-center px-6">
        <div class="flex-1 mb-8 md:mb-0">
            <h1 class="text-5xl font-bold text-blue-800 mb-4">WELCOME to <br><span class="text-blue-500">MyVerySpecialGuide</span></h1>
            <p class="text-lg text-gray-700 mb-6">We believe everyone deserves the chance to work, grow, and shine. At the Down Syndrome Work Society, we open doors for people with Down syndrome to share their talents and build brighter futures.</p>
            <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white px-6 py-3 rounded text-lg font-semibold">Get Started</a>
        </div>
        <div class="flex-1 flex justify-center">
            <div class="flex flex-wrap gap-4">
                <img src="/mascot1.png" alt="Mascot" class="w-20 h-20 rounded-full shadow-lg">
                <img src="/mascot2.png" alt="Mascot" class="w-20 h-20 rounded-full shadow-lg">
                <img src="/mascot3.png" alt="Mascot" class="w-20 h-20 rounded-full shadow-lg">
                <img src="/mascot4.png" alt="Mascot" class="w-20 h-20 rounded-full shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Info Card Section -->
<section class="container mx-auto px-6 py-12 flex flex-col md:flex-row items-center gap-8">
    <div class="md:w-1/2">
        <img src="/down-syndrome-group.jpg" alt="Group" class="rounded-lg shadow-lg w-full object-cover h-64">
    </div>
    <div class="md:w-1/2 bg-white rounded-lg shadow p-8 relative">
        <h2 class="text-2xl font-bold mb-4">What is Down Syndrome?</h2>
        <p class="text-gray-700 mb-4">
            Down syndrome (or Trisomy 21) is a naturally occurring chromosomal arrangement that has always been a part of the human condition.
        </p>
        <p class="text-gray-700 mb-6">
            This difference may affect learning, growth, and development, but it does not define a person's potential.
        </p>
        <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white px-5 py-2 rounded font-medium">Learn More</a>
        <img src="/flower-mascot.png" alt="Mascot" class="absolute top-4 right-4 w-12 h-12">
    </div>
</section>

<!-- Colorful Mascots Section -->
<section class="bg-yellow-200 py-8">
    <div class="container mx-auto flex flex-wrap justify-center gap-6">
        <img src="/mascot-square.png" alt="Mascot" class="w-16 h-16">
        <img src="/mascot-circle.png" alt="Mascot" class="w-16 h-16">
        <img src="/mascot-triangle.png" alt="Mascot" class="w-16 h-16">
        <img src="/mascot-flower.png" alt="Mascot" class="w-16 h-16">
        <img src="/mascot-oval.png" alt="Mascot" class="w-16 h-16">
    </div>
</section>
@endsection
</body>
</html>