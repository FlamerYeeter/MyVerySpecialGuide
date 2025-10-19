@extends('layouts.includes')

@section('content')

    {{-- Main Content --}}
    <main class="px-8 py-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">The Navigation Buttons</h2>

        {{-- Green Info Box --}}
        <div class="bg-green-100 border border-green-500 rounded-md p-5 mb-6">
            <h3 class="font-semibold text-lg mb-2">What is the Navigation Buttons?</h3>
            <p class="text-gray-700 text-sm leading-relaxed">
                The navigation buttons is the color blue bar at the top of the page. It helps you move around the website and find different pages quickly!
            </p>
        </div>

        {{--Kindly add image nlang mga beh--}}
        {{-- Navigation Card 1 --}}
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center">
            <div class="bg-orange-200 p-3 rounded-md">
                <img src="{{ asset('images/jobmatches.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Job Matches</h4>
                <p class="text-sm text-gray-700">Click here to see jobs that are perfect for you! This page shows jobs that match your skills and interests.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>

        {{-- Navigation Card 2 --}}
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center">
            <div class="bg-red-200 p-3 rounded-md">
                <img src="{{ asset('images/goals.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Goals and Progress</h4>
                <p class="text-sm text-gray-700">See your goals and track how you're doing! This page shows what you want to achieve and how close you are to reaching your goals.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>

        {{-- Navigation Card 3 --}}
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center">
            <div class="bg-pink-200 p-3 rounded-md">
                <img src="{{ asset('images/whythisjob.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Why This Job & How to Get There</h4>
                <p class="text-sm text-gray-700">This button explains why a job is a good match for you. It shows you what skills you already have, what you can learn, and gives you a plan to prepare for the job.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>

        {{-- Navigation Card 4 --}}
        <div class="bg-blue-50 rounded-lg flex p-5 mb-4 items-center">
            <div class="bg-blue-200 p-3 rounded-md">
                <img src="{{ asset('images/guardian.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Guardian Review</h4>
                <p class="text-sm text-gray-700">A page for your parent, guardian, or helper to see your progress and help you with your job search.</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>

        {{-- Navigation Card 5 --}}
        <div class="bg-blue-50 rounded-lg flex p-5 mb-8 items-center">
            <div class="bg-purple-200 p-3 rounded-md">
                <img src="{{ asset('images/profile.png') }}" class="w-10 h-10" alt="">
            </div>
            <div class="ml-4">
                <h4 class="text-blue-600 font-semibold">Profile</h4>
                <p class="text-sm text-gray-700">This button shows your name and picture. Click it to see more options!</p>
                <p class="text-xs text-gray-400 mt-1">(tagalog)</p>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="flex justify-start">
            <a href="#" class="flex items-center space-x-2 bg-sky-500 hover:bg-sky-600 text-white px-6 py-2 rounded-lg shadow-md">
                <span class="text-lg">←</span>
                <span>Back</span>
            </a>
        </div>
    </main>
</div>


@endsection