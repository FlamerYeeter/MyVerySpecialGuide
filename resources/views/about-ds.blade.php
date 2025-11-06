@extends('layouts.app')

@section('content')
    <div class="font-sans bg-white text-gray-700">

        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-b from-blue-50/80 to-white py-12 sm:py-16 md:py-20 lg:py-24 px-4 sm:px-8 md:px-12 lg:px-20 text-left bg-center bg-cover"
            style="background-image: url('image/herobg.png');">

            <!-- Overlay for readability -->
            <div class="absolute inset-0 bg-white/60 md:bg-white/40 lg:bg-transparent"></div>

            <!-- Content Wrapper -->
            <div class="relative z-10 max-w-5xl mx-auto px-4 md:px-6">

                <!-- Hero Text -->
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-blue-700 mb-4">
                        What is Down Syndrome?
                    </h2>

                    <div class="text-gray-700 text-sm sm:text-base md:text-lg leading-relaxed">
                        <p style="text-align: justify;">
                            Down syndrome is a natural genetic condition that occurs when a person is born with an extra
                            chromosome. This difference may affect learning, growth, and development, but it does not define
                            a person's potential.
                        </p>
                        <p class="mt-3" style="text-align: justify;">
                            Individuals with Down syndrome have their own unique personalities, strengths, and dreams—just
                            like everyone else. With understanding, acceptance, and opportunities, they can thrive,
                            contribute to their communities, and live meaningful, fulfilling lives.
                        </p>
                    </div>
                </div>

        <!-- Just Like You Section -->
        <section
            class="relative bg-cover bg-center bg-no-repeat text-white py-20 sm:py-24 md:py-28 lg:py-32 px-4 sm:px-8 md:px-12 overflow-hidden"
            style="background-image: url('image/border4.png'); background-size: 100% 110%;">
            <div
                class="absolute inset-0 bg-gradient-to-b from-green-800/40 via-green-700/20 to-transparent md:from-transparent">
            </div>

            <!-- Mascots -->
            <img src="image/obj3.png" alt="Blue Mascot"
                class="absolute top-6 left-4 sm:top-10 sm:left-10 w-8 sm:w-12 md:w-20 lg:w-24 opacity-90">
            <img src="image/obj9.png" alt="Dark Yellow Mascot"
                class="absolute bottom-6 left-10 sm:bottom-10 sm:left-20 w-8 sm:w-12 md:w-20 lg:w-24 opacity-90">
            <img src="image/obj4.png" alt="Yellow Mascot"
                class="absolute top-16 right-8 sm:top-20 sm:right-20 w-8 sm:w-12 md:w-20 lg:w-24 opacity-90">
            <img src="image/obj10.png" alt="Pink Mascot"
                class="absolute bottom-10 right-4 sm:bottom-14 sm:right-10 w-8 sm:w-12 md:w-20 lg:w-24 opacity-90">
            <img src="image/obj10.png" alt="Pink Mascot"
                class="absolute top-1/2 left-2 sm:left-4 w-6 sm:w-10 md:w-14 lg:w-16 opacity-90 transform -translate-y-1/2">
            <img src="image/obj3.png" alt="Blue Mascot"
                class="absolute top-1/2 right-2 sm:right-6 w-6 sm:w-10 md:w-14 lg:w-16 opacity-90 transform -translate-y-1/2">

            <!-- Main Content -->
            <div class="relative z-10 max-w-5xl mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-center px-2 md:px-6">

                <!-- Text Content -->
                <div class="text-center md:text-left">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 drop-shadow-lg text-white">
                        Just like you
                    </h2>

                    <p class="text-sm sm:text-base md:text-lg leading-relaxed text-white/90" style="text-align: justify;">
                        People with Down syndrome have the right to be accepted and treated as equal members of the
                        community. <br><br>
                        They should have the chance to use their skills, follow their dreams, and find meaningful work.
                        🌈<br><br>
                        When given opportunities and support, they can grow, succeed, and work alongside others—showing us
                        that
                        true inclusion is about fairness and respect.
                    </p>
                </div>

                <!-- Image -->
                <div class="flex justify-center">
                    <img src="/image/img6.png" alt="Just like you"
                        class="rounded-2xl w-64 sm:w-72 md:w-80 lg:w-96 shadow-lg object-cover transition-transform duration-300 hover:scale-105">
                </div>
            </div>
        </section>

        <!-- Sign Up Section -->
        <section class="py-12 sm:py-16 md:py-20 px-4 sm:px-8 md:px-12">
            <div class="max-w-5xl mx-auto text-left md:px-6">
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-blue-700 mb-6 leading-snug">
                    Sign up to hear from the MyVerySpecialGuide team and discover how you can be part of the journey.
                </h3>

                <p class="text-blue-400 mb-8 text-sm sm:text-base md:text-lg leading-relaxed" style="text-align: justify;">
                    Together, we are building a digital platform to support individuals with Down Syndrome
                    in finding meaningful employment. With the right support and inclusive workplaces, they
                    can thrive, contribute, and work side by side with everyone else.
                </p>

                <!-- Button -->
                <div class="text-center">
                    <a href="{{ route('user.role') }}"
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-10 sm:px-12 md:px-14 py-3 rounded-lg font-semibold shadow-md transition-transform hover:scale-105">
                        Sign Up
                    </a>
                </div>
            </div>
        </section>

        <!-- Violet Border -->
        <div class="relative w-full -mb-14 z-10">
            <img src="image/border5.png" alt="Violet Border" class="w-full object-cover h-16 md:h-20 block relative z-10">
        </div>

    </div>
@endsection
