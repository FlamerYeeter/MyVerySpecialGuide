@extends('layouts.app')

@section('content')
<div class="font-sans bg-white text-gray-700">


  <!-- Hero Section -->
  <section class="relative bg-gradient-to-b from-blue-50 to-white py-16 text-left px-8 md:px-20">
    <h2 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">What is Down Syndrome?</h2>
    <div class="max-w-4xl mx-auto px-4 text-gray-700 text-base leading-relaxed">
      <p>
        Down syndrome is a natural genetic condition that occurs when a person is born with an extra chromosome. 
        This difference may affect learning, growth, and development, but it does not define a person's potential.
      </p>
      <p class="mt-3">
        Individuals with Down syndrome have their own unique personalities, strengths, and dreams—just like everyone else. 
        With understanding, acceptance, and opportunities, they can thrive, contribute to their communities, 
        and live meaningful, fulfilling lives.
      </p>
    </div>
  </section>

  <!-- Personalities Section -->
  <section class="py-12 text-center relative">
    <h3 class="text-xl font-semibold mb-8">Personalities</h3>
    <div class="flex justify-center space-x-6 overflow-x-auto px-6">
      <!-- Card 1 -->
      <div class="bg-white shadow rounded-2xl w-60 flex-shrink-0">
        <img src="/images/affectionate.jpg" alt="Affectionate" class="rounded-t-2xl w-full h-36 object-cover">
        <p class="py-3 font-medium">Affectionate</p>
      </div>
      <!-- Card 2 -->
      <div class="bg-white shadow rounded-2xl w-60 flex-shrink-0">
        <img src="/images/outgoing.jpg" alt="Outgoing" class="rounded-t-2xl w-full h-36 object-cover">
        <p class="py-3 font-medium">Outgoing</p>
      </div>
      <!-- Card 3 -->
      <div class="bg-white shadow rounded-2xl w-60 flex-shrink-0">
        <img src="/images/sociable.jpg" alt="Sociable" class="rounded-t-2xl w-full h-36 object-cover">
        <p class="py-3 font-medium">Sociable</p>
      </div>
    </div>
  </section>

  <!-- Just Like You Section -->
  <section class="bg-green-500 text-white py-16 px-6 relative">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h2 class="text-3xl font-bold mb-4">Just like you</h2>
        <p class="text-lg leading-relaxed">
          People with Down syndrome have the right to be accepted and treated as equal members of the community. <br><br>
          They should have the chance to use their skills, follow their dreams, and find meaningful work. 🌈<br><br>
          When given opportunities and support, they can grow, succeed, and work alongside others—showing us that
          true inclusion is about fairness and respect.
        </p>
      </div>
      <div class="flex justify-center">
        <img src="/images/justlike.png" alt="Just like you" class="rounded-2xl w-80 shadow-lg">
      </div>
    </div>

    <!-- Decorative emojis -->
    <div class="absolute top-6 left-10 text-4xl">😊</div>
    <div class="absolute bottom-8 right-8 text-4xl">💙</div>
  </section>

  <!-- Sign Up Section -->
  <section class="text-center py-16 px-6 bg-blue-50">
    <h3 class="text-2xl md:text-3xl font-bold text-blue-700 mb-4">
      Sign up to hear from the MyVerySpecialGuide team and discover how you can be part of the journey.
    </h3>
    <p class="max-w-3xl mx-auto text-gray-600 mb-6 leading-relaxed">
      Together, we are building a digital platform to support individuals with Down Syndrome 
      in finding meaningful employment.
    </p>
    <p class="max-w-3xl mx-auto text-gray-600 mb-8 leading-relaxed">
      With the right support and inclusive workplaces, they can thrive, contribute, and work 
      side by side with everyone else.
    </p>
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium shadow-md transition">
      Sign Up
    </button>
  </section>

  <!-- Footer -->
  <footer class="bg-pink-100 border-t-4 border-blue-400 py-10">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-10 px-6">
      <!-- Logo and tagline -->
      <div>
        <img src="/images/mindfultots-logo.png" alt="Mindful Tots" class="h-12 mb-3">
        <p class="text-sm text-gray-600 font-medium">Growth in Progress</p>
      </div>

      <!-- Address -->
      <div>
        <h4 class="font-semibold text-gray-800 mb-2">Address</h4>
        <p class="text-sm text-gray-600">
          Tri-AX One Center,<br>
          Second Floor, 133 M. Almeda St., Brgy. San Roque
        </p>
      </div>

      <!-- Socials -->
      <div>
        <h4 class="font-semibold text-gray-800 mb-2">Socials</h4>
        <ul class="text-sm text-blue-700 space-y-1">
          <li><a href="#" class="hover:underline">Facebook</a></li>
          <li><a href="#" class="hover:underline">Email</a></li>
        </ul>
      </div>
    </div>

    <div class="text-center text-sm text-gray-500 mt-8 border-t pt-4">
      © 2025 EmpowerPath | <a href="#" class="underline hover:text-blue-600">Privacy Policy</a>
    </div>
  </footer>
</div>
@endsection
