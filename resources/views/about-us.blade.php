@extends('layouts.app')

@section('content')
    <div class="font-sans bg-white text-gray-700">

        <!-- HERO / ABOUT SECTION -->
        <section class="relative bg-cover bg-center py-16 px-8 md:px-16 overflow-hidden"
            style="background-image: url('{{ asset('image/herobg.png') }}');">

            <!-- Overlay -->
            <div class="absolute inset-0"></div>

            <!-- Content -->
            <div class="relative z-10 max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-blue-700 mb-6 leading-tight drop-shadow-sm">
                        About Us
                    </h2>
                    <div class="text-justify text-base md:text-lg text-gray-700 leading-relaxed space-y-4">
                        <p>
                            Welcome to <span class="font-semibold text-blue-600">MyVerySpecialGuide (MVSG)</span> —
                            an inclusive digital platform dedicated to empowering individuals with
                            <span class="font-semibold text-blue-700">Down Syndrome</span> by guiding them toward
                            meaningful and fulfilling careers.
                        </p>

                        <p>
                            At MVSG, we believe everyone deserves more than limited opportunities —
                            they deserve <span class="text-blue-600 font-medium">careers that match their strengths, skills,
                                and aspirations.</span>
                        </p>

                        <p>
                            By combining <span class="font-medium text-blue-700">therapeutic insights</span> with
                            <span class="font-medium text-blue-700">smart job-matching technology</span>,
                            we help create personalized career pathways that open real possibilities.
                        </p>

                        <p>
                            Our mission is to empower individuals to thrive, gain independence,
                            and work side by side with everyone else — because inclusion is not just a goal,
                            it’s a shared responsibility.
                        </p>

                        <p class="font-medium italic">
                            Together, we are building a future where inclusion means opportunity, dignity, and fairness for
                            all.
                        </p>
                    </div>
                </div>


            <!-- Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('image/logo.png') }}" alt="MVSG Logo"
                    class="w-72 sm:w-80 md:w-96 drop-shadow-2xl hover:scale-105 transition-transform duration-300 rounded-xl bg-white/70 p-4">
            </div>
        </div>
        </section>


        <!-- WHAT WE DO SECTION -->
        <section class="relative py-16 sm:py-20 bg-white overflow-hidden">

            <!-- Floating Mascots -->
            <img src="image/obj3.png" alt="Blue Circle Mascot"
                class="absolute top-4 sm:top-8 left-4 sm:left-8 w-8 sm:w-12 md:w-16 opacity-90" />
            <img src="image/obj9.png" alt="Yellow Dark Mascot"
                class="absolute top-6 sm:top-10 right-4 sm:right-10 w-8 sm:w-12 md:w-16 opacity-90" />
            <img src="image/obj4.png" alt="Yellow Circle Mascot"
                class="absolute bottom-4 sm:bottom-10 left-6 sm:left-16 w-12 sm:w-16 md:w-20 opacity-90" />
            <img src="image/obj10.png" alt="Pink Mascot"
                class="absolute top-12 sm:top-16 md:top-12 left-1/2 transform -translate-x-1/2 w-8 sm:w-12 md:w-16 opacity-90" />
            <img src="image/obj11.png" alt="Green Mascot"
                class="absolute bottom-2 sm:bottom-4 right-2 sm:right-6 md:right-10 w-12 sm:w-16 md:w-20 opacity-90" />

            <!-- Content -->
            <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-8 md:px-16 text-left">
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-blue-700 mb-6">
                    WHAT WE DO
                </h3>
                <p class="text-gray-700 leading-relaxed text-justify text-sm sm:text-base md:text-lg">
                    MVSG is built to assist both users and their guardians in navigating the journey toward employment and
                    personal development.
                    By analyzing strengths, aspirations, and evolving abilities, our system provides tailored job insights
                    and training suggestions
                    that open doors to brighter futures.
                </p>
            </div>
        </section>

        <!-- MISSION / VISION SECTION -->
        <section class="relative py-16 sm:py-20 px-4 sm:px-8 md:px-16 bg-blue-50 overflow-hidden">
            <!-- Mission / Vision Cards -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10 items-stretch relative z-10">

                <!-- Mission -->
                <div
                    class="relative bg-[url('/image/border6.png')] bg-cover bg-center text-white-800 rounded-2xl shadow-lg px-10 sm:px-12 md:px-16 pt-20 sm:pt-32 pb-10 flex flex-col justify-start min-h-[450px] sm:min-h-[500px]">
                    <h3 class="text-2xl sm:text-3xl font-extrabold mb-3 sm:mb-4 text-white drop-shadow-sm">MISSION</h3>
                    <p class="leading-relaxed text-black text-justify text-base sm:text-lg">
                        Our mission is to bridge the gap between potential and opportunity by using the power of
                        machine learning to deliver personalized job recommendations. We believe that every individual
                        deserves a career path that not only matches their skills and interests but also nurtures growth,
                        confidence, and independence.
                    </p>
                </div>

                <!-- Vision -->
                <div
                    class="relative bg-[url('/image/border7.png')] bg-cover bg-center text-white-800 rounded-2xl shadow-lg px-10 sm:px-12 md:px-16 pt-20 sm:pt-32 pb-10 flex flex-col justify-start min-h-[450px] sm:min-h-[500px]">

                    <h3 class="text-2xl sm:text-3xl font-extrabold mb-3 sm:mb-4 text-white drop-shadow-sm">VISION</h3>
                    <p class="leading-relaxed text-black text-justify text-base sm:text-lg">
                        MVSG envisions a world where neurodivergent individuals thrive in careers tailored to their
                        unique strengths and potential. Through innovation, compassion, and inclusivity, we aim to create
                        not just a recommendation system—but a personalized guide that nurtures lifelong growth.
                    </p>
                </div>

            </div>
        </section>



        <!-- Sign Up Section -->
        <section class="py-12 sm:py-16 md:py-20 px-4 sm:px-8 md:px-12">
            <div class="max-w-5xl mx-auto text-left md:px-6">
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-blue-700 mb-6 leading-snug">
                    Sign up to hear from the MyVerySpecialGuide team and discover how you can be part of the journey.
                </h3>

                <p class="text-blue-600 mb-8 text-sm sm:text-base md:text-lg leading-relaxed" style="text-align: justify;">
                    Together, we are building a digital platform to support individuals with Down Syndrome
                    in finding meaningful employment. With the right support and inclusive workplaces, they
                    can thrive, contribute, and work side by side with everyone else.
                </p>

                <!-- Button -->
                <div class="text-center">
                    <a href="{{ route('user.role') }}"
                       class="inline-block bg-[#2563EB] hover:bg-blue-600 text-white px-10 sm:px-12 md:px-14 py-3 rounded-lg font-semibold shadow-md transition-transform hover:scale-105">
                        Sign Up
                    </a>
                </div>
            </div>
        </section>

        <!-- Violet Border
        <div class="relative w-full -mb-14 z-10">
            <img src="image/border5.png" alt="Violet Border" class="w-full object-cover h-16 md:h-20 block relative z-10">
        </div>  -->
    @endsection
