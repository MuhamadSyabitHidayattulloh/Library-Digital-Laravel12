@extends('admin.layouts.admin')

@section('title', 'Edit Book')

@section('admin-content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Edit Book</h1>
        <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800">Back to List</a>
    </div>

    <form action="{{ route('admin.books.update', $book) }}" method="POST" class="bg-white rounded-lg shadow p-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-gray-700 font-medium mb-2" for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="author">Author</label>
                <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                    class="w-full px-3 py-2 border rounded-lg @error('author') border-red-500 @enderror">
                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="publisher">Publisher</label>
                <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                    class="w-full px-3 py-2 border rounded-lg @error('publisher') border-red-500 @enderror">
                @error('publisher')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" required
                    class="w-full px-3 py-2 border rounded-lg @error('isbn') border-red-500 @enderror">
                @error('isbn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="publication_year">Publication Year</label>
                <input type="number" name="publication_year" id="publication_year"
                    value="{{ old('publication_year', $book->publication_year) }}" required min="1900" max="{{ date('Y') }}"
                    class="w-full px-3 py-2 border rounded-lg @error('publication_year') border-red-500 @enderror">
                @error('publication_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2" for="category_id">Category</label>
                <select name="category_id" id="category_id" required class="w-full px-3 py-2 border rounded-lg @error('category_id') border-red-500 @enderror">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
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
                <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required min="0"
                    class="w-full px-3 py-2 border rounded-lg @error('stock') border-red-500 @enderror">
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-gray-700 font-medium mb-2" for="description">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-3 py-2 border rounded-lg @error('description') border-red-500 @enderror">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-gray-700 font-medium mb-2">Cover Image</label>
                <div class="space-y-4">
                    @if($book->cover_url)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Cover:</p>
                            <img src="{{ $book->cover_url }}" alt="Current cover" class="h-40 object-contain rounded-lg border">
                        </div>
                    @endif

                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="cover_type" value="keep" class="form-radio"
                                {{ old('cover_type', 'keep') === 'keep' ? 'checked' : '' }}>
                            <span class="ml-2">Keep Current</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="cover_type" value="url" class="form-radio"
                                {{ old('cover_type') === 'url' ? 'checked' : '' }}>
                            <span class="ml-2">New URL</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="cover_type" value="file" class="form-radio"
                                {{ old('cover_type') === 'file' ? 'checked' : '' }}>
                            <span class="ml-2">Upload New</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="cover_type" value="none" class="form-radio"
                                {{ old('cover_type') === 'none' ? 'checked' : '' }}>
                            <span class="ml-2">Remove Cover</span>
                        </label>
                    </div>

                    <div id="urlInput" class="{{ old('cover_type') !== 'url' ? 'hidden' : '' }}">
                        <input type="url" name="cover_url" value="{{ old('cover_url') }}"
                            class="w-full px-3 py-2 border rounded-lg @error('cover_url') border-red-500 @enderror"
                            placeholder="https://example.com/book-cover.jpg">
                        @error('cover_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="fileInput" class="{{ old('cover_type') !== 'file' ? 'hidden' : '' }}">
                        <input type="file" name="cover_file" accept="image/*"
                            class="w-full px-3 py-2 border rounded-lg @error('cover_file') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Max file size: 2MB. Supported formats: JPG, PNG, GIF</p>
                        @error('cover_file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.books.index') }}"
                class="px-4 py-2 text-gray-700 hover:text-gray-900">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Update Book
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const coverTypeInputs = document.querySelectorAll('input[name="cover_type"]');
    const urlInput = document.getElementById('urlInput');
    const fileInput = document.getElementById('fileInput');

    function toggleInputs() {
        const selectedType = document.querySelector('input[name="cover_type"]:checked').value;
        urlInput.classList.toggle('hidden', selectedType !== 'url');
        fileInput.classList.toggle('hidden', selectedType !== 'file');
    }

    coverTypeInputs.forEach(input => {
        input.addEventListener('change', toggleInputs);
    });
});
</script>
@endpush

@endsection
