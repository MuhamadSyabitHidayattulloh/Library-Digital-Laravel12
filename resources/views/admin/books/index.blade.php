@extends('admin.layouts.admin')

@section('title', 'Books Management')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Books Management</h1>
    <div class="flex gap-3">
        <a href="{{ route('admin.books.print.list') }}" target="_blank"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-all">
            <i class="ph-printer-bold mr-2"></i>
            Print List
        </a>
        <a href="{{ route('admin.books.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all">
            <i class="ph-plus-bold mr-2"></i>
            Add New Book
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2" for="search">
                Search Books
            </label>
            <div class="relative">
                <input type="text" id="search" name="search"
                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                    placeholder="Search by title or author..."
                    value="{{ request('search') }}">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                    <i class="ph-magnifying-glass-bold"></i>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2" for="category_filter">
                Filter by Category
            </label>
            <select id="category_filter" name="category"
                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2" for="stock_filter">
                Stock Status
            </label>
            <select id="stock_filter" name="stock"
                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                <option value="">All</option>
                <option value="in" {{ request('stock') === 'in' ? 'selected' : '' }}>In Stock</option>
                <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
            </select>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Title</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Author</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Category</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Stock</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($books as $book)
            <tr class="hover:bg-gray-50 transition-all">
                <td class="px-6 py-4">
                    <div>
                        <a href="{{ route('admin.books.show', $book) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ $book->title }}</a>
                        <p class="text-sm text-gray-500">ISBN: {{ $book->isbn }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm text-gray-700">{{ $book->author }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                        {{ $book->category->name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $book->stock > 5 ? 'bg-green-50 text-green-700' : '' }}
                        {{ $book->stock <= 5 && $book->stock > 0 ? 'bg-yellow-50 text-yellow-700' : '' }}
                        {{ $book->stock === 0 ? 'bg-red-50 text-red-700' : '' }}">
                        {{ $book->stock }} copies
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.books.show', $book) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="ph-eye-bold"></i>
                        </a>
                        <a href="{{ route('admin.books.edit', $book) }}"
                            class="text-blue-600 hover:text-blue-800 transition-all">
                            <i class="ph-pencil-bold"></i>
                        </a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition-all"
                                onclick="return confirm('Are you sure you want to delete this book?')">
                                <i class="ph-trash-bold"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $books->links() }}
    </div>
</div>

<script>
document.getElementById('search').addEventListener('input', debounce(applyFilters, 300));
document.getElementById('category_filter').addEventListener('change', applyFilters);
document.getElementById('stock_filter').addEventListener('change', applyFilters);

function applyFilters() {
    const search = document.getElementById('search').value;
    const category = document.getElementById('category_filter').value;
    const stock = document.getElementById('stock_filter').value;

    const params = new URLSearchParams(window.location.search);
    params.set('search', search);
    params.set('category', category);
    params.set('stock', stock);

    window.location.search = params.toString();
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
