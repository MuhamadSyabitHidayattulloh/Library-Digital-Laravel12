@extends('admin.layouts.admin')

@section('title', 'Categories Management')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Categories Management</h1>
    <button onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" 
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
        Add Category
    </button>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Books Count</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($categories as $category)
            <tr>
                <td class="px-6 py-4">{{ $category->name }}</td>
                <td class="px-6 py-4">{{ $category->books_count }}</td>
                <td class="px-6 py-4 flex space-x-2">
                    <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')"
                        class="text-blue-600 hover:text-blue-800">
                        Edit
                    </button>
                    @if($category->books_count === 0)
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="relative p-8 bg-white w-96 mx-auto mt-20 rounded-lg">
        <h2 class="text-xl font-bold mb-4">Add New Category</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="name">Category Name</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addCategoryModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Add Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="relative p-8 bg-white w-96 mx-auto mt-20 rounded-lg">
        <h2 class="text-xl font-bold mb-4">Edit Category</h2>
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="edit_name">Category Name</label>
                <input type="text" name="name" id="edit_name" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('editCategoryModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(id, name) {
    document.getElementById('edit_name').value = name;
    document.getElementById('editCategoryForm').action = `{{ route('admin.categories.index') }}/${id}`;x    
    document.getElementById('editCategoryModal').classList.remove('hidden');
}

// Show modals if there are validation errors
@if($errors->any() && old('_method') === 'PUT')
    document.getElementById('editCategoryModal').classList.remove('hidden');
@elseif($errors->any())
    document.getElementById('addCategoryModal').classList.remove('hidden');
@endif
</script>
@endsection
