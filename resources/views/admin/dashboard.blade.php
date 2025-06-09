@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
<!-- Welcome Section -->
<div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-6 mb-8 text-white shadow-lg">
    <h1 class="text-2xl font-semibold mb-2">Library Administration</h1>
    <p class="text-gray-300">Monitor and manage library activities.</p>
</div>

<!-- Stats Grid with hover effects -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Total Books</h3>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <i class="ph-books-bold text-2xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\Book::count() }}</p>
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Books in library</p>
            <a href="{{ route('admin.books.index') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                Manage <i class="ph-arrow-right-bold"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Active Borrows</h3>
            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                <i class="ph-book-open-bold text-2xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\Borrow::where('status', 'borrowed')->count() }}</p>
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Currently borrowed books</p>
            <a href="{{ route('admin.borrows.index') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                View all <i class="ph-arrow-right-bold"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Requests</h3>
            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                <i class="ph-clock-bold text-2xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\Borrow::where('status', 'pending')->count() }}</p>
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Awaiting approval</p>
            <a href="{{ route('admin.borrows.pending') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                View all <i class="ph-arrow-right-bold"></i>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activities with better table styling -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Recent Activities</h2>
                <a href="{{ route('admin.borrows.index') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    View all <i class="ph-arrow-right-bold"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left pb-3 px-2 text-sm font-medium text-gray-500">User</th>
                        <th class="text-left pb-3 px-2 text-sm font-medium text-gray-500">Book</th>
                        <th class="text-left pb-3 px-2 text-sm font-medium text-gray-500">Action</th>
                        <th class="text-left pb-3 px-2 text-sm font-medium text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach(\App\Models\Borrow::with(['user', 'book'])->latest()->take(5)->get() as $borrow)
                    <tr>
                        <td class="py-3 px-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 mr-3">
                                    <i class="ph-user-bold"></i>
                                </div>
                                <span class="text-sm text-gray-700">{{ $borrow->user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-2">
                            <span class="text-sm text-gray-700">{{ $borrow->book->title }}</span>
                        </td>
                        <td class="py-3 px-2">
                            <span class="inline-flex px-2 py-1 text-xs rounded-full
                                {{ $borrow->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                {{ $borrow->status === 'borrowed' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $borrow->status === 'returned' ? 'bg-gray-50 text-gray-700' : '' }}
                                {{ $borrow->status === 'overdue' ? 'bg-red-50 text-red-700' : '' }}">
                                {{ ucfirst($borrow->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-2">
                            <span class="text-sm text-gray-500">{{ $borrow->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats with improved card design -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Quick Statistics</h2>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <!-- Total Users -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg mr-4">
                            <i class="ph-users-bold text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-lg font-semibold text-gray-800">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Books Out -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg mr-4">
                            <i class="ph-book-bookmark-bold text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Books Borrowed</p>
                            <p class="text-lg font-semibold text-gray-800">{{ \App\Models\Borrow::where('status', 'borrowed')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg mr-4">
                            <i class="ph-clock-countdown-bold text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Overdue Books</p>
                            <p class="text-lg font-semibold text-gray-800">{{ \App\Models\Borrow::where('status', 'overdue')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg mr-4">
                            <i class="ph-tags-bold text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Categories</p>
                            <p class="text-lg font-semibold text-gray-800">{{ \App\Models\Category::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
