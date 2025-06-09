@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }"
     @resize.window="sidebarOpen = window.innerWidth >= 768"
     @keydown.window.escape="sidebarOpen = false"
     class="flex h-[calc(100vh-4rem)] bg-gray-50 overflow-hidden">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen && window.innerWidth < 768"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-gray-900/50 z-20 lg:hidden"></div>

    <!-- Sidebar with improved transitions -->
    <div x-cloak
         :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
         class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 transform lg:translate-x-0 lg:relative lg:w-64 transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-6">
            <div class="flex items-center space-x-3">
                <i class="ph-books-bold text-2xl text-blue-400"></i>
                <h2 x-show="sidebarOpen" class="text-xl font-bold font-['Poppins'] text-white transition-opacity">Admin Panel</h2>
            </div>
            <div x-show="sidebarOpen" class="mt-2 text-sm text-gray-400 transition-opacity">
                Welcome, {{ Auth::user()->name }}
            </div>
        </div>
        <nav class="mt-6 px-4 flex-1">
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center py-3 px-4 rounded-lg mb-2 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-300 hover:bg-gray-800/50' }}">
                    <i class="ph-chart-bar-bold text-xl" :class="{'mr-3': sidebarOpen}"></i>
                    <span x-show="sidebarOpen" class="transition-opacity">Dashboard</span>
                </a>
                <a href="{{ route('admin.books.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg mb-2 transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-300 hover:bg-gray-800/50' }}">
                    <i class="ph-books-bold text-xl" :class="{'mr-3': sidebarOpen}"></i>
                    <span x-show="sidebarOpen" class="transition-opacity">Books</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg mb-2 transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-300 hover:bg-gray-800/50' }}">
                    <i class="ph-tag-bold text-xl" :class="{'mr-3': sidebarOpen}"></i>
                    <span x-show="sidebarOpen" class="transition-opacity">Categories</span>
                </a>
                <a href="{{ route('admin.borrows.index') }}"
                    class="flex items-center py-3 px-4 rounded-lg mb-2 transition-all duration-200 {{ request()->routeIs('admin.borrows.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-gray-300 hover:bg-gray-800/50' }}">
                    <i class="ph-calendar-bold text-xl" :class="{'mr-3': sidebarOpen}"></i>
                    <span x-show="sidebarOpen" class="transition-opacity">Borrow Requests</span>
                    @php
                    $pendingCount = \App\Models\Borrow::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span x-show="sidebarOpen" class="ml-auto px-2 py-1 text-xs bg-red-500 text-white rounded-full shadow transition-opacity">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="absolute -right-3 top-20 bg-gray-900 rounded-full p-1.5 shadow-lg border border-gray-700">
                <i :class="sidebarOpen ? 'ph-caret-left-bold' : 'ph-caret-right-bold'" class="text-gray-300 text-sm"></i>
            </button>
        </nav>

        <div class="absolute bottom-0 w-64 p-4 bg-gray-800">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center py-2 px-4 rounded-lg text-gray-300 hover:bg-gray-700">
                    <i class="ph-sign-out-bold text-xl mr-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Mobile Header -->
        <div class="lg:hidden flex items-center justify-between p-4 border-b bg-white sticky top-0 z-10">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100">
                <i class="ph-list-bold text-xl"></i>
            </button>
            <h1 class="text-lg font-semibold">@yield('title', 'Admin Dashboard')</h1>
        </div>

        <div class="p-4 lg:p-8">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('admin-content')
        </div>
    </div>
</div>
@endsection
