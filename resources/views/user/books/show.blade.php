@extends('user.layouts.user')

@section('title', $book->title)

@section('user-content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="{{ route('user.books.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <i class="ph-arrow-left-bold mr-2"></i>
            Back to Browse
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
            <!-- Book Cover & Quick Actions -->
            <div class="space-y-6">
                <!-- Cover Image -->
                <div class="aspect-[3/4] rounded-xl overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 shadow-lg">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <i class="ph-book-bold text-6xl mb-2"></i>
                                <span class="text-sm font-medium">No Cover</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Status</span>
                        @if($book->stock > 0)
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $book->stock }} copies available
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Currently Unavailable
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $book->category->name }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Published</span>
                        <span class="text-sm font-medium text-gray-900">{{ $book->publication_year }}</span>
                    </div>
                </div>
            </div>

            <!-- Book Details -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                    <p class="text-lg text-gray-600">by {{ $book->author }}</p>
                </div>

                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold text-gray-900">About this book</h3>
                    <p class="text-gray-600">{{ $book->description ?: 'No description available.' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Publisher</h3>
                        <p class="text-gray-900">{{ $book->publisher }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">ISBN</h3>
                        <p class="text-gray-900">{{ $book->isbn }}</p>
                    </div>
                </div>

                @if($book->stock > 0)
                    <div class="bg-blue-50 rounded-xl p-6 mt-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Borrow this book</h3>
                        <form action="{{ route('user.borrows.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="borrow_date">
                                        Borrow Date
                                    </label>
                                    <input type="date" id="borrow_date" name="borrow_date" required
                                        min="{{ now()->format('Y-m-d') }}"
                                        class="w-full px-4 py-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="return_date">
                                        Return Date
                                    </label>
                                    <input type="date" id="return_date" name="return_date" required
                                        min="{{ now()->addDay()->format('Y-m-d') }}"
                                        class="w-full px-4 py-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="notes">
                                    Notes (Optional)
                                </label>
                                <textarea id="notes" name="notes" rows="3"
                                    class="w-full px-4 py-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                    placeholder="Any special requests or notes..."></textarea>
                            </div>

                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                                Request to Borrow
                            </button>
                        </form>
                    </div>
                @endif
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
