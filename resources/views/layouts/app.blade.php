<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Enhanced transitions */
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale {
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Improved shadows */
        .shadow-soft {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .shadow-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
        }

        .shadow-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive breakpoints */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        @media (min-width: 1280px) {
            .container {
                max-width: 1200px;
            }
        }

        /* Animation keyframes */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        /* Better focus states */
        *:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        *:focus:not(:focus-visible) {
            outline: none;
        }

        /* Fixed sidebar transition */
        @media (max-width: 768px) {
            .fixed {
                transition: transform 0.3s ease-in-out;
            }
        }

        /* Hide scrollbar when sidebar is open on mobile */
        .sidebar-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col"
      x-data
      :class="{'sidebar-open': $store.sidebar.isOpen && window.innerWidth < 768}">
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                isOpen: window.innerWidth >= 768,
                toggle() {
                    this.isOpen = !this.isOpen
                }
            })
        })
    </script>
    <!-- Navigation with better mobile response -->
    <nav class="bg-white shadow-soft sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-blue-600 flex items-center hover-scale">
                        <i class="ph-books-bold text-3xl mr-2"></i>
                        <span class="font-['Poppins'] hidden sm:inline">Library Digital</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition-smooth">
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
        </div>
    </nav>

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
