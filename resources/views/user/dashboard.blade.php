@extends('user.layouts.user')

@section('title', 'My Library Dashboard')

@section('user-content')
<!-- Welcome Section -->
<div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 mb-8 text-white shadow-lg shadow-blue-500/10">
    <h1 class="text-2xl font-semibold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
    <p class="text-blue-100">Manage your library activities and discover new books.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Active Borrows Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">My Active Borrows</h3>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <i class="ph-book-open-bold text-2xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">
            {{ Auth::user()->borrows()->where('status', 'borrowed')->count() }}
        </p>
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Books currently borrowed</p>
            <a href="{{ route('user.borrows') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1 transition-colors">
                View all <i class="ph-arrow-right-bold"></i>
            </a>
        </div>
    </div>

    <!-- Pending Requests Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Requests</h3>
            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                <i class="ph-clock-bold text-2xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">
            {{ Auth::user()->borrows()->where('status', 'pending')->count() }}
        </p>
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Awaiting approval</p>
            <a href="{{ route('user.borrows') }}" class="text-sm text-yellow-600 hover:text-yellow-700 flex items-center gap-1 transition-colors">
                Check status <i class="ph-arrow-right-bold"></i>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity with better styling -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
            <a href="{{ route('user.borrows') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                View all <i class="ph-arrow-right-bold"></i>
            </a>
        </div>
    </div>

    <div class="divide-y divide-gray-100">
        @foreach(Auth::user()->borrows()->with('book')->latest()->take(5)->get() as $borrow)
        <div class="p-6 hover:bg-gray-50 transition-colors">
            <div class="flex items-start">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg mr-4">
                    <i class="ph-book-bold text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</h4>
                    <p class="text-sm text-gray-500">
                        @if($borrow->status === 'pending')
                            Requested to borrow
                        @elseif($borrow->status === 'borrowed')
                            Currently borrowing
                        @elseif($borrow->status === 'returned')
                            Returned the book
                        @elseif($borrow->status === 'overdue')
                            Book is overdue
                        @endif
                    </p>
                    <div class="mt-1 flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $borrow->status === 'pending' ? 'bg-yellow-50 text-yellow-800' : '' }}
                            {{ $borrow->status === 'borrowed' ? 'bg-green-50 text-green-800' : '' }}
                            {{ $borrow->status === 'returned' ? 'bg-gray-50 text-gray-800' : '' }}
                            {{ $borrow->status === 'overdue' ? 'bg-red-50 text-red-800' : '' }}">
                            {{ ucfirst($borrow->status) }}
                        </span>
                        <span class="text-xs text-gray-500 ml-2">
                            {{ $borrow->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @if($borrow->status === 'borrowed')
                    <div class="text-sm text-gray-500">
                        Due: {{ $borrow->return_date->format('M d, Y') }}
                    </div>
                @endif
            </div>
        </div>
        @endforeach

        @if(Auth::user()->borrows()->count() === 0)
        <div class="text-center py-12">
            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ph-books-bold text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No borrowing activity yet</h3>
            <p class="text-sm text-gray-500 mb-4">Start your reading journey today!</p>
            <a href="{{ route('user.books.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow-md">
                Browse Books <i class="ph-arrow-right-bold ml-2"></i>
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Reading Suggestions with improved cards -->
<div class="mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Recommended Books</h2>
        <a href="{{ route('user.books.index') }}" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
            View all books <i class="ph-arrow-right-bold"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach(\App\Models\Book::inRandomOrder()->take(3)->get() as $book)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-500">by {{ $book->author }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800">
                        {{ $book->category->name }}
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $book->description }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        {{ $book->stock }} copies available
                    </span>
                    <a href="{{ route('user.books.show', $book) }}"
                        class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                        View details <i class="ph-arrow-right-bold ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
