@extends('admin.layouts.admin')

@section('title', 'Books Management')

@section('admin-content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Books Collection</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your library's book collection</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.books.print.list') }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="ph-printer-bold mr-2"></i>
                Print List
            </a>
            <a href="{{ route('admin.books.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="ph-plus-bold mr-2"></i>
                Add New Book
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4">
            <form action="{{ route('admin.books.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="search">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="text" name="search" id="search"
                            class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Search books..." value="{{ request('search') }}">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="ph-magnifying-glass text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="category">Category</label>
                    <select name="category" id="category"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="stock">Stock Status</label>
                    <select name="stock" id="stock"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">All Status</option>
                        <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="out_of_stock" {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-gray-100 py-2 px-4 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
        @foreach($books as $book)
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
            <!-- Book Cover -->
            <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" alt="{{ $book->title }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         style="object-position: center;">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <div class="flex flex-col items-center text-gray-400 transform transition-transform group-hover:scale-110">
                            <i class="ph-book-bold text-6xl mb-2"></i>
                            <span class="text-sm font-medium">No Cover</span>
                        </div>
                    </div>
                @endif

                <!-- Overlay Information -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-white text-sm line-clamp-3">{{ $book->description ?: 'No description available.' }}</p>
                    </div>
                </div>

                <!-- Top Badges -->
                <div class="absolute top-3 left-3 right-3 flex justify-between items-start gap-2">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 shadow-lg backdrop-blur-sm bg-opacity-90">
                        {{ $book->category->name }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium shadow-lg backdrop-blur-sm bg-opacity-90
                        {{ $book->stock > 5 ? 'bg-green-100 text-green-800' : '' }}
                        {{ $book->stock <= 5 && $book->stock > 0 ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $book->stock === 0 ? 'bg-red-100 text-red-800' : '' }}">
                        {{ $book->stock }} copies
                    </span>
                </div>
            </div>

            <!-- Book Info -->
            <div class="p-4 flex flex-col flex-1 space-y-3">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 text-lg leading-tight group-hover:text-blue-600 transition-colors duration-200">
                        {{ $book->title }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">by {{ $book->author }}</p>
                </div>

                <!-- Additional Info -->
                <div class="flex items-center text-sm text-gray-500 gap-4">
                    <span class="flex items-center">
                        <i class="ph-calendar-bold mr-1"></i>
                        {{ $book->publication_year }}
                    </span>
                    <span class="flex items-center">
                        <i class="ph-bookmark-bold mr-1"></i>
                        {{ $book->borrows_count ?? 0 }} borrows
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.books.show', $book) }}"
                        class="flex-1 inline-flex justify-center items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                        <i class="ph-eye-bold mr-1.5"></i> View
                    </a>
                    <a href="{{ route('admin.books.edit', $book) }}"
                        class="flex-1 inline-flex justify-center items-center px-3 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="ph-pencil-bold mr-1.5"></i> Edit
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>

@push('styles')
<style>
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Improved hover effects */
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    /* Text truncation */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
