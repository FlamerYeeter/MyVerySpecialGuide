@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Navigation -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4">
            <div class="flex items-center space-x-2">
                <img src="image/logo.png" alt="Logo" class="w-16 h-16 object-contain">
                <h1 class="text-2xl font-bold text-blue-700">MyVerySpecialGuide</h1>
            </div>
            <nav class="mt-3 md:mt-0 space-x-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm">Job Matches</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Goals & Progress</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Why This Job & How to Get There</button>
                <button class="bg-gray-100 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Guardian Review</button>
            </nav>
            <div class="relative mt-3 md:mt-0">
                <button class="border px-3 py-1 rounded-full text-sm">Profile ▾</button>
            </div>
        </div>
    </header>

    <!-- Info -->
    <div class="text-center mt-3 text-sm underline text-gray-600">
        <a href="#" class="hover:text-blue-600 font-medium">Click to know about the navigation buttons above</a>
        <p class="italic text-xs">(pindutin upang malaman ang tungkol sa navigation buttons sa taas)</p>
    </div>

    <!-- Job Recommendations -->
    <section class="bg-yellow-400 py-10 mt-4">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center space-x-4 mb-6">
                <img src="{{ asset('images/job-search.png') }}" class="w-20 h-20"> <!-- will export the image -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Job Recommended For You</h2>
                    <p class="text-sm text-gray-600 italic">(Mga Trabahong Para sa Iyo)</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap justify-center gap-3">
                <select class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                    <option>Industry</option>
                </select>
                <select class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                    <option>Job Fit Level</option>
                </select>
                <select class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                    <option>Growth Potential</option>
                </select>
                <select class="px-4 py-2 rounded-lg bg-yellow-400 border-2 border-blue-500 text-sm">
                    <option>Work Environment</option>
                </select>
            </div>


            <p class="text-center text-xs mt-3 italic text-gray-600">(i-click ang dropdown arrow sa itaas...)</p>
        </div>
    </section>

    <!-- Match Notice -->
    <div class="container mx-auto mt-6 px-4">
        <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-gray-800 font-medium flex items-center">
                💡 These jobs match your skills and preferences!
            </p>
            <p class="italic text-sm text-gray-600">(Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan!)</p>
        </div>

        <div class="mt-4 flex flex-col md:flex-row md:space-x-4">
            <div class="bg-white p-4 rounded-lg shadow w-full md:w-1/2">
                <h3 class="text-blue-600 font-semibold">Saved Jobs</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Click the “Save” button on any job listing to keep it for later. <br>
                    <span class="italic text-xs">(-I-click ang Save button sa anumang job listing upang mai-save ito para sa susunod.)</span>
                </p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow w-full md:w-1/2 mt-4 md:mt-0">
                <p class="text-sm text-gray-600">
                    Click the “View Details” button to view more information about the Job. <br>
                    <span class="italic text-xs">(-I-click ang button na “View Details” para makita ang karagdagang impormasyon tungkol sa trabaho.)</span>
                </p>
            </div>
        </div>
        <br>
        <div class="flex items-center gap-3 mt-4 md:mt-0">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">All Matches (2)</button>
        </div>
    </div>

    <!-- Job Cards -->
    <div class="container mx-auto mt-8 px-4 space-y-6">
        <!-- Pet Care Assistant -->
        <div class="bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">Pet Care Assistant</h3>
                <p class="text-gray-600">iPet Club</p>
                <p class="text-sm text-gray-500">Taguig City, Metro Manila</p>
                <div class="flex gap-2 text-xs mt-2">
                    <span class="bg-gray-100 px-2 py-1 rounded">Healthcare</span>
                    <span class="bg-gray-100 px-2 py-1 rounded">Quiet</span>
                </div>
                <p class="text-sm mt-3">Help feed animals, clean spaces, and provide companionship.</p>
                <div class="flex gap-2 mt-2">
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Excellent Fit</span>
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">High Potential</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">4d ago</p>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">View Details</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Saved</button>
            </div>
        </div>

        <!-- Kitchen Helper -->
        <div class="bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">Kitchen Helper</h3>
                <p class="text-gray-600">KFC</p>
                <p class="text-sm text-gray-500">Makati City, Metro Manila</p>
                <div class="flex gap-2 text-xs mt-2">
                    <span class="bg-gray-100 px-2 py-1 rounded">Hospitality</span>
                    <span class="bg-gray-100 px-2 py-1 rounded">Busy</span>
                </div>
                <p class="text-sm mt-3">Supports the cooks and staff by keeping the kitchen clean and organized.</p>
                <div class="flex gap-2 mt-2">
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Good Fit</span>
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Medium Potential</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">23h ago</p>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">View Details</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Saved</button>
            </div>
        </div>
    </div>
</div>
@endsection
