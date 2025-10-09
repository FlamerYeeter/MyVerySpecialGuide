@extends('layouts.app')

@section('content')
<div class="font-sans bg-white text-gray-700">


  <!-- HERO / ABOUT SECTION -->
  <section class="relative bg-[url('/images/background-pattern.png')] bg-cover bg-center py-16 px-8 md:px-16">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-4xl md:text-5xl font-bold text-blue-700 mb-6">About us</h2>
        <p class="leading-relaxed text-gray-700 mb-4">
          Welcome to <span class="font-semibold">MyVerySpecialGuide (MVSG)</span> an inclusive platform dedicated to empowering individuals with Down Syndrome by guiding them toward meaningful and fulfilling careers.
        </p>
        <p class="leading-relaxed mb-4">
          At MVSG, we believe people with Down Syndrome deserve more than limited opportunities they deserve careers that match their true strengths.
        </p>
        <p class="leading-relaxed mb-4">
          By combining therapy insights with smart job matching tools, we create personalized career pathways that go beyond traditional roles.
        </p>
        <p class="leading-relaxed">
          Our platform empowers individuals to thrive, achieve independence, and work side by side with everyone else.
        </p>
        <p class="leading-relaxed mt-4">
          Together, we are building a future where inclusion means opportunity, dignity, and fairness for all.
        </p>
      </div>
      <div class="flex justify-center">
        <img src="image/logo.png" alt="MVSG Logo" class="w-80 md:w-96 drop-shadow-lg">
      </div>
    </div>
  </section>

  <!-- WHAT WE DO SECTION -->
  <section class="py-16 bg-white relative text-center">
    <div class="max-w-4xl mx-auto px-6">
      <h3 class="text-2xl font-bold text-blue-700 mb-4">WHAT WE DO</h3>
      <p class="text-gray-600 leading-relaxed">
        MVSG is built to assist both users and their guardians in navigating the journey toward employment and personal development.
        By analyzing strengths, aspirations, and evolving abilities, our system provides tailored job insights and training suggestions
        that open doors to brighter futures.
      </p>
    </div>
  </section>

  <!-- MISSION / VISION SECTION -->
  <section class="py-10 px-8 md:px-16 bg-white">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10">
      
      <!-- Mission -->
      <div class="bg-[url('/images/paint-red.png')] bg-cover bg-center rounded-2xl text-black p-8 shadow-lg"> <!--Change niyo nlang na orange bg dyan -->
        <h3 class="text-2xl font-bold mb-4">MISSION</h3>
        <p class="leading-relaxed">
          Our mission is to bridge the gap between potential and opportunity by using the power of machine learning 
          to deliver personalized job recommendations. We believe that every individual deserves a career path that 
          not only matches their skills and interests but also nurtures growth, confidence, and independence.
        </p>
      </div>

      <!-- Vision -->
      <div class="bg-[url('/images/paint-yellow.png')] bg-cover bg-center rounded-2xl text-gray-800 p-8 shadow-lg"> <!--Change niyo nlang na yellow bg dyan -->
        <h3 class="text-2xl font-bold mb-4">VISION</h3>
        <p class="leading-relaxed">
          MVSG envisions a world where neurodivergent individuals thrive in careers tailored to their unique strengths and potential. 
          Through innovation, compassion, and inclusivity, we aim to create not just a recommendation system—but a personalized guide 
          that nurtures lifelong growth.
        </p>
      </div>

    </div>
  </section>

  <!-- SIGN UP SECTION -->
  <section class="bg-blue-50 py-16 px-8 text-center">
    <div class="max-w-5xl mx-auto">
      <h3 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4">
        Sign up to hear from the MyVerySpecialGuide team and discover how you can be part of the journey.
      </h3>
      <p class="text-gray-600 mb-4 leading-relaxed">
        Together, we are building a digital platform to support individuals with Down Syndrome in finding meaningful employment.
      </p>
      <p class="text-gray-600 mb-8 leading-relaxed">
        With the right support and inclusive workplaces, they can thrive, contribute, and work side by side with everyone else.
      </p>
      <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium shadow-md transition">
        Sign Up
      </button>
    </div>
  </section>

  
@endsection
