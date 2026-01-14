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
                    <h2
                        class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-blue-700 mb-6 leading-tight drop-shadow-sm">
                        Down Syndrome Association of the Philippines, Inc.
                    </h2>

                    <div class="text-justify text-base md:text-lg text-gray-700 leading-relaxed space-y-4">
                        <p>
                            The <span class="font-semibold text-blue-600">DSAPI</span>
                            is a non-profit organization, founded in 1991 by a group of dedicated and committed parents and
                            concerned physicians.
                        </p>

                        <p>
                            It aims to offer support to families who have a child with Down Syndrome and to initiate,
                            develop, promote, encourage and support programs and projects concerning <span
                                class="font-semibold text-blue-700">Down Syndrome</span>.
                        </p>

                        <p>
                            DSAPI believes that the initial reactions of new parents that typically bear disappointment,
                            sorrow, fear, guilt, confusion and anger can be replaced with positive attitudes of warmth,
                            love, understanding and hope.
                        </p>

                        <p class="font-medium italic">
                            “Celebrating abilities, nurturing potential, and embracing families — together, we rise for
                            inclusion.”
                        </p>
                    </div>
                </div>

                <!-- Organization Logo -->
                <div class="flex justify-center">
                    <img src="{{ asset('image/orglogo.jpg') }}" alt="DSAPI Logo"
                        class="w-72 sm:w-80 md:w-96 drop-shadow-2xl hover:scale-105 transition-transform duration-300 rounded-xl bg-white/70 p-4">
                </div>
            </div>
        </section>


        <!-- Facebook Link Section -->
        <section class="py-12 sm:py-16 md:py-20 px-4 sm:px-8 md:px-12">
            <div class="max-w-6xl mx-auto flex flex-col justify-start h-full">

                <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-blue-700 mb-6 leading-snug">
                    Connect with DSAPI
                </h3>

                <p class="text-blue-600 mb-8 text-sm sm:text-base md:text-lg leading-relaxed text-justify">
                    To learn more about the programs, events, and advocacy efforts of the Down Syndrome Association of the
                    Philippines, Inc., feel free to visit their official pages and online community.
                </p>



                <div class="flex flex-col items-center mt-6 space-y-4">

                    <!-- Official Facebook Page -->
                    <a href="https://www.facebook.com/downsyndromeassociationofthephilippinesinc" target="_blank"
                        class="inline-block bg-[#2563EB] hover:bg-blue-600 text-white px-12 sm:px-14 md:px-16 py-3 rounded-lg font-semibold shadow-md transition-transform hover:scale-105 w-full sm:w-auto text-center">
                        Visit DSAPI Official Facebook Page
                    </a>

                    <!-- Facebook Group Page -->
                    <a href="https://www.facebook.com/groups/53343128860" target="_blank"
                        class="inline-block bg-[#008000] hover:bg-green-600 text-white px-10 sm:px-12 md:px-14 py-3 rounded-lg font-semibold shadow-md transition-transform hover:scale-105 w-full sm:w-auto text-center">
                        Join the DSAPI Community Facebook Group
                    </a>

                </div>
            </div>
        </section>

        <!-- Violet Border 
        <div class="relative w-full -mb-14 z-10">
            <img src="{{ asset('image/border5.png') }}" alt="violet border" class="w-full object-cover h-16 md:h-20 block relative z-10">
        </div> -->

    </div>
@endsection
