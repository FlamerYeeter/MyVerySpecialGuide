<aside class="w-64 bg-white shadow-md flex flex-col justify-between">
    <div>
        <h1 class="text-2xl font-bold text-sky-600 p-6">AdminHub</h1>
        <nav class="px-4 space-y-2">
            <a href="#" class="flex items-center space-x-2 p-2 rounded-md hover:bg-sky-100">
                <span><img src="{{ asset('image/dashboard.png') }}" alt="Info" class="w-5 h-5"></span><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-2 p-2 rounded-md hover:bg-sky-100">
                <span><img src="{{ asset('image/moderation.png') }}" alt="Info" class="w-5 h-5"></span><span>Moderation</span>
            </a>
            <a href="#" class="flex items-center space-x-2 p-2 rounded-md bg-sky-500 text-white">
                <span><img src="{{ asset('image/approval.png') }}" alt="Info" class="w-5 h-5"></span><span>Approval Workflow</span>
            </a>
            <a href="#" class="flex items-center space-x-2 p-2 rounded-md hover:bg-sky-100">
                <span><img src="{{ asset('image/compliance.png') }}" alt="Info" class="w-5 h-5"></span><span>Compliance & Reports</span>
            </a>
        </nav>
    </div>

    <div class="p-4">
        <button class="flex items-center space-x-2 text-gray-600 hover:text-red-600">
            <span><img src="{{ asset('image/logout.png') }}" alt="Info" class="w-5 h-5"></span><span>Logout</span>
        </button>
    </div>
</aside>
