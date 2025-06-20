<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Library Digital - Your Gateway to Knowledge')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        .font-heading {
            font-family: 'Poppins', sans-serif;
        }

        /* Enhanced transitions and animations */
        .transition-smooth {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .transition-fast {
            transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
        }

        .hover-scale {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        /* Advanced shadows */
        .shadow-soft {
            box-shadow: 0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04);
        }

        .shadow-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
        }

        .shadow-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .shadow-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }

        /* Gradient backgrounds */
        .bg-gradient-primary {
            background: var(--gradient-1);
        }

        .bg-gradient-secondary {
            background: var(--gradient-2);
        }

        .bg-gradient-accent {
            background: var(--gradient-3);
        }

        /* Enhanced scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #94a3b8, #64748b);
        }

        /* Loading spinner */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Animation keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-fade-in-scale {
            animation: fadeInScale 0.4s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Better focus states */
        .focus-ring {
            outline: 2px solid transparent;
            outline-offset: 2px;
            transition: all 0.2s;
        }

        .focus-ring:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Navigation enhancement */
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        /* Mobile responsive improvements */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Better button styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 0.75rem 1.5rem;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }
    </style>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'display': ['Playfair Display', 'serif'],
                        'heading': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'fade-in-scale': 'fadeInScale 0.4s ease-out',
                        'slide-in-right': 'slideInRight 0.5s ease-out',
                        'pulse-slow': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col transition-colors duration-300"
      x-data="{
        isLoading: false,
        showScrollTop: false,
        notifications: []
      }"
      @scroll.window="showScrollTop = window.pageYOffset > 300"
      @notify.window="notifications.push($event.detail); setTimeout(() => notifications.shift(), 5000)">

    <!-- Loading Overlay -->
    <div x-show="isLoading"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="loading-spinner w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full mx-auto mb-4"></div>
            <p class="text-gray-600">Loading...</p>
        </div>
    </div>

    <!-- Enhanced Navigation -->
    @php
        $isAdmin = request()->is('admin*');
        $isUser = request()->is('user*');
    @endphp
    @if(!$isAdmin && !$isUser)
    <nav class="bg-white/95 backdrop-blur-md shadow-soft sticky top-0 z-40 border-b border-gray-100" x-data="{ openNav: false }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent flex items-center hover-scale group">
                        <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center mr-3 shadow-lg group-hover:shadow-glow transition-all">
                            <i class="ph-books-bold text-xl text-white"></i>
                        </div>
                        <span class="font-heading hidden sm:inline">Library Digital</span>
                    </a>
                </div>
                <!-- Hamburger Button (Mobile) -->
                <div class="flex md:hidden">
                    <button @click="openNav = !openNav" :aria-expanded="openNav ? 'true' : 'false'" aria-label="Open main menu"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-smooth">
                        <svg x-show="!openNav" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="openNav" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="nav-link text-gray-800 font-medium transition-colors">Home</a>
                    <a href="{{ route('about') }}" class="nav-link text-gray-800 font-medium transition-colors">About</a>
                    <a href="{{ route('services') }}" class="nav-link text-gray-800 font-medium transition-colors">Services</a>
                    <a href="{{ route('contact') }}" class="nav-link text-gray-800 font-medium transition-colors">Contact</a>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-blue-700 font-semibold transition-colors flex items-center gap-1">
                                <i class="ph-gauge-bold"></i> Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'user')
                            <a href="{{ route('user.dashboard') }}" class="nav-link text-blue-700 font-semibold transition-colors flex items-center gap-1">
                                <i class="ph-gauge-bold"></i> Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
                <!-- User Account (Desktop) -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-smooth">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="ph-user-bold"></i>
                                </div>
                                <span class="text-sm font-medium hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="ph-caret-down-bold"></i>
                            </button>
                            <div x-show="open"
                                 x-transition
                                 @click.away="open = false"
                                 class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-lg shadow-card border border-gray-100 animate-slide-in">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-red-600 transition-colors">
                                        <i class="ph-sign-out-bold mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Auth Links -->
                        <a href="{{ route('login') }}"
                           class="text-gray-600 hover:text-blue-600 font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition-smooth hidden sm:inline-block">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-smooth font-medium shadow-sm hover:shadow-md">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
            <!-- Mobile Navigation Menu -->
            <div x-show="openNav" x-transition class="md:hidden mt-2 bg-white rounded-lg shadow-card border border-gray-100 p-4">
                <div class="flex flex-col gap-4">
                    <a href="{{ route('home') }}" class="nav-link text-gray-800 font-medium transition-colors">Home</a>
                    <a href="{{ route('about') }}" class="nav-link text-gray-800 font-medium transition-colors">About</a>
                    <a href="{{ route('services') }}" class="nav-link text-gray-800 font-medium transition-colors">Services</a>
                    <a href="{{ route('contact') }}" class="nav-link text-gray-800 font-medium transition-colors">Contact</a>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-blue-700 font-semibold transition-colors flex items-center gap-1">
                                <i class="ph-gauge-bold"></i> Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'user')
                            <a href="{{ route('user.dashboard') }}" class="nav-link text-blue-700 font-semibold transition-colors flex items-center gap-1">
                                <i class="ph-gauge-bold"></i> Dashboard
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-red-600 transition-colors flex items-center gap-2 mt-2">
                                <i class="ph-sign-out-bold"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition-smooth">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-smooth font-medium shadow-sm hover:shadow-md">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endif

    <!-- Flash Messages with animations -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex items-center animate-slide-in"
                 role="alert">
                <i class="ph-check-circle-bold text-xl mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex items-center" role="alert">
                <i class="ph-x-circle-bold text-xl mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4" role="alert">
                <div class="flex items-center mb-2">
                    <i class="ph-warning-bold text-xl mr-2"></i>
                    <span class="font-medium">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside pl-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content with better spacing -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @yield('content')
    </main>

    <!-- Footer with responsive design -->
    <footer class="bg-white border-t border-gray-100 mt-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-gray-600">
                <p class="mb-2">&copy; {{ date('Y') }} Library Digital. All rights reserved.</p>
                <p class="text-sm flex items-center justify-center gap-1">
                    Made with <i class="ph-heart-fill text-red-500"></i> for book lovers
                </p>
            </div>
        </div>
    </footer>

    <!-- Minnit Chat Widget with Toggle -->
    <div class="fixed bottom-4 right-4 z-50"
         x-data="{
            isOpen: localStorage.getItem('chatOpen') === 'true',
            toggleChat() {
                this.isOpen = !this.isOpen;
                localStorage.setItem('chatOpen', this.isOpen);
            }
         }">
        <!-- Chat Toggle Button -->
        <button @click="toggleChat()"
                class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 mb-2"
                :class="{ 'rotate-45': isOpen }">
            <i class="ph-chat-circle-text-fill text-2xl" x-show="!isOpen"></i>
            <i class="ph-x-bold text-2xl" x-show="isOpen"></i>
        </button>

        <!-- Chat Widget -->
        <template x-if="isOpen">
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <div id="chat-container">
                    <iframe src="https://organizations.minnit.chat/436870699504787/Main?embed"
                            class="shadow-lg rounded-lg"
                            style="width:400px; height:500px; border:none;"
                            allowtransparency="true"></iframe>
                </div>
            </div>
        </template>
    </div>
</body>
</html>
