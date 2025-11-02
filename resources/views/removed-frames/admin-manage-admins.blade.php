<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage Admins</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    @include('layouts.adminsidebar')
    <main class="ml-64 p-6">
        <h1 class="text-2xl font-semibold mb-4">Admin Assignments</h1>

        @if(session('status'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white p-4 rounded shadow mb-6">
            <form method="POST" action="{{ route('admin.admins.store') }}" class="flex gap-2 items-center">
                @csrf
                <input name="firebase_uid" placeholder="Firebase UID" required class="border p-2 rounded w-72">
                <input name="email" placeholder="Email (optional)" class="border p-2 rounded w-64">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Assign</button>
            </form>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-medium mb-3">Existing assignments</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-sm text-gray-600 border-b">
                        <th class="p-2">UID</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Assigned By</th>
                        <th class="p-2">Assigned At</th>
                        <th class="p-2">Active</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $a)
                        <tr class="border-b">
                            <td class="p-2 text-sm">{{ $a['firebase_uid'] }}</td>
                            <td class="p-2 text-sm">{{ $a['email'] }}</td>
                            <td class="p-2 text-sm">{{ $a['assigned_by'] }}</td>
                            <td class="p-2 text-sm">{{ $a['assigned_at'] }}</td>
                            <td class="p-2 text-sm">{{ $a['active'] ? 'Yes' : 'No' }}</td>
                            <td class="p-2 text-sm">
                                <form method="POST" action="{{ route('admin.admins.destroy', ['uid' => $a['docId']]) }}" onsubmit="return confirm('Revoke admin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Revoke</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
