@extends('user.layouts.user')

@section('title', 'Browse Books')

@section('user-content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Browse Books</h1>
    <div class="flex items-center gap-4">
        <!-- Search Bar -->
        <div class="relative">
            <input type="text" id="search" name="search"
                class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                placeholder="Search books..."
                value="{{ request('search') }}">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <i class="ph-magnifying-glass-bold"></i>
            </div>
        </div>

        <!-- Category Filter -->
        <select id="category-filter"
            class="pl-4 pr-10 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
            <option value="">All Categories</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($books as $book)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all">
        <div class="p-6">
            <!-- Book Header -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-600">by {{ $book->author }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800">
                    {{ $book->category->name }}
                </span>
            </div>

            <!-- Book Details -->
            <div class="space-y-3">
                <p class="text-sm text-gray-600 line-clamp-2">{{ $book->description }}</p>

                <div class="flex items-center text-sm text-gray-500">
                    <i class="ph-books-bold mr-2"></i>
                    <span>{{ $book->stock }} copies available</span>
                </div>

                <div class="flex items-center text-sm text-gray-500">
                    <i class="ph-calendar-bold mr-2"></i>
                    <span>Published: {{ $book->publication_year }}</span>
                </div>

                @if($book->publisher)
                <div class="flex items-center text-sm text-gray-500">
                    <i class="ph-building-bold mr-2"></i>
                    <span>{{ $book->publisher }}</span>
                </div>
                @endif
            </div>

            <!-- Action Button -->
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('user.books.show', $book) }}"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                    <i class="ph-eye-bold mr-2"></i>
                    View Details
                </a>
                @if($book->stock > 0)
                    <button onclick="showBorrowModal({{ $book->id }})"
                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all">
                        <i class="ph-bookmark-simple-bold mr-2"></i>
                        Borrow
                    </button>
                @else
                    <button disabled
                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-400 text-sm font-medium rounded-lg cursor-not-allowed">
                        <i class="ph-prohibit-bold mr-2"></i>
                        Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-3 bg-gray-50 rounded-full inline-flex mb-4">
                <i class="ph-books-bold text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No books found</h3>
            <p class="text-sm text-gray-500 mt-1">Try adjusting your search or filter criteria</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $books->appends(request()->query())->links() }}
</div>

<!-- Borrow Modal -->
<div id="borrowModal" class="fixed inset-0 bg-gray-900/50 hidden" x-data="{ open: false }">
    <div class="bg-white rounded-xl max-w-md mx-auto mt-20 p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Borrow Book</h3>
            <button onclick="hideBorrowModal()" class="text-gray-400 hover:text-gray-500">
                <i class="ph-x-bold text-xl"></i>
            </button>
        </div>

        <form id="borrowForm" method="POST" action="{{ route('user.borrows.store') }}">
            @csrf
            <input type="hidden" name="book_id" id="borrowBookId">

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional Notes (Optional)
                </label>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                    placeholder="Any special requests or notes..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="hideBorrowModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all">
                    Confirm Borrow
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('search').addEventListener('input', debounce(applyFilters, 300));
document.getElementById('category-filter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('search').value;
    const category = document.getElementById('category-filter').value;

    const params = new URLSearchParams(window.location.search);
    params.set('search', search);
    params.set('category', category);

    window.location.search = params.toString();
}

function showBorrowModal(bookId) {
    document.getElementById('borrowModal').classList.remove('hidden');
    document.getElementById('borrowBookId').value = bookId;
    document.body.style.overflow = 'hidden';
}

function hideBorrowModal() {
    document.getElementById('borrowModal').classList.add('hidden');
    document.getElementById('borrowForm').reset();
    document.body.style.overflow = 'auto';
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endsection
