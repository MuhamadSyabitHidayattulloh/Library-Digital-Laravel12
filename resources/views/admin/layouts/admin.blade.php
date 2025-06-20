@extends('layouts.app')

@section('content')
<div x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        sidebarCollapsed: false,
        notifications: []
     }"
     @resize.window="sidebarOpen = window.innerWidth >= 1024"
     @keydown.window.escape="sidebarOpen = false"
     class="flex h-[calc(100vh-4rem)] bg-gray-50 overflow-hidden">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-gray-900/50 z-20 lg:hidden backdrop-blur-sm"></div>

    <!-- Enhanced Sidebar -->
    <div x-cloak
         :class="{
            'translate-x-0': sidebarOpen,
            '-translate-x-full': !sidebarOpen,
            'w-64': !sidebarCollapsed,
            'w-16': sidebarCollapsed && sidebarOpen
         }"
         class="fixed inset-y-0 left-0 z-30 bg-white border-r border-gray-200 transform lg:translate-x-0 lg:relative transition-all duration-300 ease-in-out flex flex-col shadow-xl lg:shadow-none">

        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3" x-show="!sidebarCollapsed || !sidebarOpen">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="ph-books-bold text-xl text-white"></i>
                    </div>
                    <div x-show="!sidebarCollapsed">
                        <h2 class="text-xl font-bold text-gray-900 font-['Poppins']">Admin Panel</h2>
                        <p class="text-sm text-gray-500">Management System</p>
                    </div>
                </div>
                <!-- Collapse Button (Desktop) -->
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                        class="hidden lg:flex p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i :class="sidebarCollapsed ? 'ph-caret-right-bold' : 'ph-caret-left-bold'"
                       class="text-gray-400 text-sm"></i>
                </button>
            </div>
            <div x-show="!sidebarCollapsed && sidebarOpen" class="mt-3 px-3 py-2 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
               x-tooltip="sidebarCollapsed ? 'Dashboard' : ''">
                <div class="flex items-center justify-center w-6 h-6 mr-3">
                    <i class="ph-chart-bar-bold text-lg"></i>
                </div>
                <span x-show="!sidebarCollapsed" class="transition-opacity">Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                    <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full" x-show="!sidebarCollapsed"></div>
                @endif
            </a>

            <!-- Books Management -->
            <a href="{{ route('admin.books.index') }}"
               class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
               x-tooltip="sidebarCollapsed ? 'Books Management' : ''">
                <div class="flex items-center justify-center w-6 h-6 mr-3">
                    <i class="ph-books-bold text-lg"></i>
                </div>
                <span x-show="!sidebarCollapsed" class="transition-opacity">Books Management</span>
                @if(request()->routeIs('admin.books.*'))
                    <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full" x-show="!sidebarCollapsed"></div>
                @endif
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}"
               class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
               x-tooltip="sidebarCollapsed ? 'Categories' : ''">
                <div class="flex items-center justify-center w-6 h-6 mr-3">
                    <i class="ph-tag-bold text-lg"></i>
                </div>
                <span x-show="!sidebarCollapsed" class="transition-opacity">Categories</span>
                @if(request()->routeIs('admin.categories.*'))
                    <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full" x-show="!sidebarCollapsed"></div>
                @endif
            </a>

            <!-- Borrow Requests -->
            <a href="{{ route('admin.borrows.index') }}"
               class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.borrows.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
               x-tooltip="sidebarCollapsed ? 'Borrow Requests' : ''">
                <div class="flex items-center justify-center w-6 h-6 mr-3 relative">
                    <i class="ph-calendar-bold text-lg"></i>
                    @php
                    $pendingCount = \App\Models\Borrow::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                            {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                        </span>
                    @endif
                </div>
                <span x-show="!sidebarCollapsed" class="transition-opacity flex-1">Borrow Requests</span>
                @if($pendingCount > 0)
                    <span x-show="!sidebarCollapsed" class="ml-auto px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                        {{ $pendingCount }}
                    </span>
                @endif
                @if(request()->routeIs('admin.borrows.*'))
                    <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full" x-show="!sidebarCollapsed"></div>
                @endif
            </a>

            <!-- Divider -->
            <hr class="my-4 border-gray-200">

            <!-- Settings Section -->
            <div x-show="!sidebarCollapsed" class="px-3 py-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">System</h3>
            </div>

            <!-- System Settings (Example) -->
            <a href="#" class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200"
               x-tooltip="sidebarCollapsed ? 'Settings' : ''">
                <div class="flex items-center justify-center w-6 h-6 mr-3">
                    <i class="ph-gear-bold text-lg"></i>
                </div>
                <span x-show="!sidebarCollapsed" class="transition-opacity">Settings</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center px-3 py-3 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200 group"
                        x-tooltip="sidebarCollapsed ? 'Logout' : ''">
                    <i class="ph-sign-out-bold text-lg" :class="sidebarCollapsed ? '' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="transition-opacity">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header Bar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between lg:justify-end">
            <!-- Mobile Menu Button -->
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="ph-list-bold text-xl text-gray-600"></i>
            </button>

            <!-- Header Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="hidden md:block relative">
                    <input type="text"
                           placeholder="Search..."
                           class="w-64 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="ph-magnifying-glass-bold absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative">
                        <i class="ph-bell-bold text-xl text-gray-600"></i>
                        @if($pendingCount > 0)
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        @endif
                    </button>

                    <div x-show="open"
                         x-transition
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Notifications</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @if($pendingCount > 0)
                                <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <i class="ph-clock-bold text-yellow-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Pending Borrow Requests</p>
                                            <p class="text-sm text-gray-500">{{ $pendingCount }} request(s) waiting for approval</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-8 text-center">
                                    <i class="ph-bell-slash-bold text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-500">No new notifications</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <i class="ph-caret-down-bold text-gray-400"></i>
                    </button>

                    <div x-show="open"
                         x-transition
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-2">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="ph-user-bold mr-3"></i>
                                Profile Settings
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="ph-gear-bold mr-3"></i>
                                Account Settings
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="ph-sign-out-bold mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-6">
                <!-- Enhanced Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm"
                         x-data="{ show: true }"
                         x-show="show"
                         x-transition>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="ph-check-circle-bold text-green-400 text-xl mr-3"></i>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-green-400 hover:text-green-600">
                                <i class="ph-x-bold"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm"
                         x-data="{ show: true }"
                         x-show="show"
                         x-transition>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="ph-x-circle-bold text-red-400 text-xl mr-3"></i>
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="text-red-400 hover:text-red-600">
                                <i class="ph-x-bold"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm"
                         x-data="{ show: true }"
                         x-show="show"
                         x-transition>
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <i class="ph-warning-bold text-red-400 text-xl mr-3 mt-0.5"></i>
                                <div>
                                    <p class="text-red-700 font-medium mb-2">Please fix the following errors:</p>
                                    <ul class="list-disc list-inside text-red-600 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button @click="show = false" class="text-red-400 hover:text-red-600 ml-4">
                                <i class="ph-x-bold"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </main>
    </div>
</div>

<style>
/* Custom tooltip styles */
[x-tooltip] {
    position: relative;
}

[x-tooltip]:hover::after {
    content: attr(x-tooltip);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: 8px;
    padding: 4px 8px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    font-size: 12px;
    border-radius: 4px;
    white-space: nowrap;
    z-index: 1000;
    pointer-events: none;
}
</style>
@endsection
