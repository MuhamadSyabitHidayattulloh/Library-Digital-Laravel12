@extends('user.layouts.user')

@section('title', 'Browse Books')

@section('user-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header with Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Digital Library Collection</h1>
            <p class="mt-1 text-sm text-gray-600">Discover and borrow from our collection of books</p>
        </div>

        <!-- Search and Filters -->
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative">
                <input type="text" id="search"
                    class="w-full sm:w-64 pl-10 pr-4 py-2 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                    placeholder="Search books...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph-magnifying-glass-bold text-gray-400"></i>
                </div>
            </div>
            <select id="category-filter"
                class="pl-4 pr-10 py-2 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($books as $book)
        <a href="{{ route('user.books.show', $book) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden cursor-pointer focus:ring-2 focus:ring-blue-400 outline-none">
            <!-- Book Cover with Gradient Overlay -->
            <div class="relative aspect-[4/5] bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden">
                @if($book->cover_url)
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="flex flex-col items-center text-gray-400 transform transition-transform group-hover:scale-110">
                            <i class="ph-book-bold text-6xl mb-2"></i>
                            <span class="text-sm font-medium">No Cover</span>
                        </div>
                    </div>
                @endif

                <!-- Status Badge -->
                <div class="absolute top-3 right-3">
                    @if($book->stock > 0)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-lg backdrop-blur-sm bg-opacity-90">
                            Available
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 shadow-lg backdrop-blur-sm bg-opacity-90">
                            Borrowed
                        </span>
                    @endif
                </div>

                <!-- Category Badge -->
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 shadow-lg backdrop-blur-sm bg-opacity-90">
                        {{ $book->category->name }}
                    </span>
                </div>

                <!-- Quick Info Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-white text-sm line-clamp-3">{{ $book->description ?: 'No description available.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Book Info -->
            <div class="p-4 flex-1 flex flex-col">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $book->title }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">by {{ $book->author }}</p>
                </div>

                <!-- Stats -->
                <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                    <span class="flex items-center">
                        <i class="ph-books-bold mr-1"></i>
                        {{ $book->stock }} copies
                    </span>
                    <span class="flex items-center">
                        <i class="ph-calendar-bold mr-1"></i>
                        {{ $book->publication_year }}
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ph-books-bold text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No books found</h3>
                <p class="text-gray-500 mt-2">Try adjusting your search or filter criteria</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $books->links() }}
    </div>
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
