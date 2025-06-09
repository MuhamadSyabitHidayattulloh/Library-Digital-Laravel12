@extends('admin.layouts.admin')

@section('title', 'Add New Book')

@section('admin-content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Add New Book</h1>
        <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800">Back to List</a>
    </div>

    <form action="{{ route('admin.books.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-gray-700 font-medium mb-2" for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="author">Author</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" required
                    class="w-full px-3 py-2 border rounded-lg @error('author') border-red-500 @enderror">
                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="publisher">Publisher</label>
                <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"
                    class="w-full px-3 py-2 border rounded-lg @error('publisher') border-red-500 @enderror">
                @error('publisher')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required
                    class="w-full px-3 py-2 border rounded-lg @error('isbn') border-red-500 @enderror">
                @error('isbn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="publication_year">Publication Year</label>
                <input type="number" name="publication_year" id="publication_year" 
                    value="{{ old('publication_year') }}" required min="1900" max="{{ date('Y') }}"
                    class="w-full px-3 py-2 border rounded-lg @error('publication_year') border-red-500 @enderror">
                @error('publication_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="category_id">Category</label>
                <select name="category_id" id="category_id" required 
                    class="w-full px-3 py-2 border rounded-lg @error('category_id') border-red-500 @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="stock">Stock</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" required min="0"
                    class="w-full px-3 py-2 border rounded-lg @error('stock') border-red-500 @enderror">
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-gray-700 font-medium mb-2" for="description">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-3 py-2 border rounded-lg @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.books.index') }}" 
                class="px-4 py-2 text-gray-700 hover:text-gray-900">
                Cancel
            </a>
            <button type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Add Book
            </button>
        </div>
    </form>
</div>
@endsection
