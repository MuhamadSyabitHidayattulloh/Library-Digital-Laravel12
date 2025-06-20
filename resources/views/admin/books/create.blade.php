@extends('admin.layouts.admin')

@section('title', 'Tambah Buku Baru')

@section('admin-content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-card border border-gray-100 p-8 mt-8 animate-fade-in">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 flex items-center gap-2">
        <i class="ph-book-open-bold text-blue-600"></i> Tambah Buku Baru
    </h2>
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
        @csrf
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-book-bold text-blue-500"></i> Judul Buku <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Masukkan judul buku" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
            <span class="text-xs text-gray-400">Judul harus unik dan jelas.</span>
            @error('title')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div>
            <label for="author" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-user-bold text-blue-500"></i> Penulis <span class="text-red-500">*</span>
            </label>
            <input type="text" name="author" id="author" value="{{ old('author') }}" required placeholder="Nama penulis" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
            @error('author')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div>
            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-buildings-bold text-blue-500"></i> Penerbit
            </label>
            <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" placeholder="Nama penerbit" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
            @error('publisher')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="ph-calendar-bold text-blue-500"></i> Tahun Terbit <span class="text-red-500">*</span>
                </label>
                <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year') }}" required min="1000" max="9999" placeholder="Contoh: 2024" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
                @error('publication_year')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
            </div>
            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="ph-barcode-bold text-blue-500"></i> ISBN <span class="text-red-500">*</span>
                </label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required placeholder="Nomor ISBN" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
                <span class="text-xs text-gray-400">ISBN harus valid dan sesuai standar.</span>
                @error('isbn')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-text-align-left-bold text-blue-500"></i> Deskripsi
            </label>
            <textarea name="description" id="description" rows="3" placeholder="Deskripsi singkat buku" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="ph-stack-bold text-blue-500"></i> Stok <span class="text-red-500">*</span>
                </label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required placeholder="Jumlah stok" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
                @error('stock')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <i class="ph-tag-bold text-blue-500"></i> Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category_id" id="category_id" required class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-image-bold text-blue-500"></i> Tipe Cover <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center gap-1">
                    <input type="radio" name="cover_type" value="url" {{ old('cover_type', 'url') == 'url' ? 'checked' : '' }} required class="form-radio text-blue-600">
                    <i class="ph-link-bold text-blue-400"></i> <span class="ml-1">URL</span>
                </label>
                <label class="inline-flex items-center gap-1">
                    <input type="radio" name="cover_type" value="file" {{ old('cover_type') == 'file' ? 'checked' : '' }} required class="form-radio text-blue-600">
                    <i class="ph-upload-simple-bold text-blue-400"></i> <span class="ml-1">Upload File</span>
                </label>
            </div>
            @error('cover_type')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div id="cover-url-input" class="mt-2 transition-smooth" style="display: {{ old('cover_type', 'url') == 'url' ? 'block' : 'none' }};">
            <label for="cover_url" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-link-bold text-blue-400"></i> Cover URL
            </label>
            <input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url') }}" placeholder="https://..." class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 shadow-sm transition-smooth">
            @error('cover_url')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div id="cover-file-input" class="mt-2 transition-smooth" style="display: {{ old('cover_type') == 'file' ? 'block' : 'none' }};">
            <label for="cover_file" class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                <i class="ph-upload-simple-bold text-blue-400"></i> Upload Cover
            </label>
            <input type="file" name="cover_file" id="cover_file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-smooth">
            @error('cover_file')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="ph-warning-bold"></i> {{ $message }}</p>@enderror
        </div>
        <div class="flex items-center gap-3 mt-8">
            <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-card hover:bg-blue-700 transition-smooth gap-2">
                <i class="ph-floppy-disk-bold"></i> Simpan
            </button>
            <a href="{{ route('admin.books.index') }}" class="inline-flex items-center px-5 py-2 bg-gray-200 text-gray-700 font-semibold rounded-md hover:bg-gray-300 transition-smooth gap-2">
                <i class="ph-arrow-u-left-bold"></i> Batal
            </a>
        </div>
    </form>
</div>
<script>
    // Toggle cover input
    document.addEventListener('DOMContentLoaded', function() {
        const urlRadio = document.querySelector('input[name="cover_type"][value="url"]');
        const fileRadio = document.querySelector('input[name="cover_type"][value="file"]');
        const urlInput = document.getElementById('cover-url-input');
        const fileInput = document.getElementById('cover-file-input');
        function toggleCoverInput() {
            if(urlRadio.checked) {
                urlInput.style.display = 'block';
                fileInput.style.display = 'none';
            } else {
                urlInput.style.display = 'none';
                fileInput.style.display = 'block';
            }
        }
        urlRadio.addEventListener('change', toggleCoverInput);
        fileRadio.addEventListener('change', toggleCoverInput);
        toggleCoverInput();
    });
</script>
@endsection
