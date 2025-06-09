@extends('user.layouts.user')

@section('title', $book->title)

@section('user-content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Book Details</h1>
        <a href="{{ route('user.books.index') }}" class="text-gray-600 hover:text-gray-800">Back to Browse</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Book Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">Book Information</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Title</label>
                        <p class="mt-1 text-gray-800 text-lg font-medium">{{ $book->title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Author</label>
                        <p class="mt-1 text-gray-800">{{ $book->author }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Publisher</label>
                        <p class="mt-1 text-gray-800">{{ $book->publisher }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Publication Year</label>
                        <p class="mt-1 text-gray-800">{{ $book->publication_year }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">ISBN</label>
                        <p class="mt-1 text-gray-800">{{ $book->isbn }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Category</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-50 text-blue-800">
                                {{ $book->category->name }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Description</label>
                        <p class="mt-1 text-gray-600">{{ $book->description }}</p>
                    </div>
                </div>

                <!-- Borrow Section -->
                <div class="bg-gray-50 rounded-lg p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800">Borrow Information</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Availability</label>
                        <p class="mt-1">
                            @if($book->stock > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-50 text-green-800">
                                    <i class="ph-check-circle-bold mr-1"></i> Available ({{ $book->stock }} copies)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-50 text-red-800">
                                    <i class="ph-x-circle-bold mr-1"></i> Out of Stock
                                </span>
                            @endif
                        </p>
                    </div>

                    @if($book->stock > 0)
                        <form action="{{ route('user.borrows.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="borrow_date">
                                    Borrow Date
                                </label>
                                <input type="date" id="borrow_date" name="borrow_date" required
                                    min="{{ now()->format('Y-m-d') }}"
                                    value="{{ old('borrow_date', now()->format('Y-m-d')) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="return_date">
                                    Return Date
                                </label>
                                <input type="date" id="return_date" name="return_date" required
                                    min="{{ now()->addDay()->format('Y-m-d') }}"
                                    value="{{ old('return_date', now()->addDays(7)->format('Y-m-d')) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="notes">
                                    Notes (Optional)
                                </label>
                                <textarea id="notes" name="notes" rows="3"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Add any special notes or requests...">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="ph-book-bookmark-bold mr-2"></i>
                                Request to Borrow
                            </button>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">This book is currently unavailable.</p>
                            <p class="text-sm text-gray-400 mt-1">Please check back later.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const borrowDateInput = document.getElementById('borrow_date');
    const returnDateInput = document.getElementById('return_date');

    borrowDateInput?.addEventListener('change', function() {
        // Set minimum return date to be one day after borrow date
        const borrowDate = new Date(this.value);
        const minReturnDate = new Date(borrowDate);
        minReturnDate.setDate(minReturnDate.getDate() + 1);
        returnDateInput.min = minReturnDate.toISOString().split('T')[0];

        // If current return date is before new minimum, update it
        if (new Date(returnDateInput.value) < minReturnDate) {
            returnDateInput.value = minReturnDate.toISOString().split('T')[0];
        }
    });
});
</script>
@endsection
