@extends('admin.layouts.admin')

@section('title', $book->title)

@section('admin-content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Book Details</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.books.edit', $book) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class="ph-pencil-bold mr-2"></i>
                Edit Book
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                <i class="ph-printer-bold mr-2"></i>
                Print Details
            </button>
            <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800">Back to List</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cover Image -->
                <div>
                    @if($book->cover_url)
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-lg">
                    @else
                        <div class="w-full aspect-[3/4] rounded-lg bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <i class="ph-book-bold text-5xl mb-2"></i>
                                <p class="text-sm">No Cover</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Basic Information -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Book Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Title</label>
                            <p class="mt-1 text-gray-800 font-medium">{{ $book->title }}</p>
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
                            <label class="block text-sm font-medium text-gray-500">Description</label>
                            <p class="mt-1 text-gray-600">{{ $book->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Category</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-50 text-blue-800">
                                    {{ $book->category->name }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Stock Status</label>
                            <p class="mt-1">
                                @if($book->stock > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-50 text-green-800">
                                        <i class="ph-check-circle-bold mr-1"></i> {{ $book->stock }} copies available
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-50 text-red-800">
                                        <i class="ph-x-circle-bold mr-1"></i> Out of Stock
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Borrow Statistics</label>
                            <div class="mt-1 grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded p-3">
                                    <p class="text-sm text-gray-500">Active Borrows</p>
                                    <p class="text-xl font-semibold text-gray-800 mt-1">
                                        {{ $book->borrows()->where('status', 'borrowed')->count() }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <p class="text-sm text-gray-500">Total Borrows</p>
                                    <p class="text-xl font-semibold text-gray-800 mt-1">
                                        {{ $book->borrows()->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Borrows -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Borrows</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($book->borrows as $borrow)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $borrow->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $borrow->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $borrow->borrow_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $borrow->return_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($borrow->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-800">
                                                Pending
                                            </span>
                                            @break
                                        @case('borrowed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-800">
                                                Borrowed
                                            </span>
                                            @break
                                        @case('returned')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-800">
                                                Returned
                                            </span>
                                            @break
                                        @case('overdue')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800">
                                                Overdue
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.borrows.show', $borrow) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No borrow records found for this book.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Book Reviews -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Book Reviews</h3>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400 text-xl">
                            @php
                                $avgRating = $book->reviews->avg('rating') ?? 0;
                                $fullStars = floor($avgRating);
                                $halfStar = $avgRating - $fullStars > 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="ph-star-fill"></i>
                                @elseif($i == $fullStars + 1 && $halfStar)
                                    <i class="ph-star-half-fill"></i>
                                @else
                                    <i class="ph-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-lg font-medium text-gray-900">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-sm text-gray-500">({{ $book->reviews->count() }} reviews)</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Pinned Reviews -->
                    @forelse($book->reviews->where('pinned', true) as $review)
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Pinned Badge -->
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-3">
                                        <i class="ph-push-pin-fill mr-1"></i>
                                        Pinned Review
                                    </div>

                                    <!-- Rating and Date -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="ph-star-fill"></i>
                                                @else
                                                    <i class="ph-star text-gray-300"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- User Info -->
                                    <div class="mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">{{ $review->user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $review->user->email }}</span>
                                        </div>
                                    </div>

                                    <!-- Review Text -->
                                    <p class="text-gray-600">{{ $review->comment }}</p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-start gap-2">
                                    <form action="{{ route('admin.reviews.unpin', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-blue-600 hover:text-blue-800" title="Unpin Review">
                                            <i class="ph-push-pin-slash-bold text-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Review">
                                            <i class="ph-trash-bold text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    <!-- Unpinned Reviews -->
                    @forelse($book->reviews->where('pinned', false) as $review)
                        <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Rating and Date -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="ph-star-fill"></i>
                                                @else
                                                    <i class="ph-star text-gray-300"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- User Info -->
                                    <div class="mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">{{ $review->user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $review->user->email }}</span>
                                        </div>
                                    </div>

                                    <!-- Review Text -->
                                    <p class="text-gray-600">{{ $review->comment }}</p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-start gap-2">
                                    <form action="{{ route('admin.reviews.pin', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-400 hover:text-blue-600" title="Pin Review">
                                            <i class="ph-push-pin-bold text-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600" title="Delete Review">
                                            <i class="ph-trash-bold text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 bg-gray-50 rounded-xl">
                            <div class="text-gray-500 mb-1">No reviews yet</div>
                            <p class="text-sm text-gray-400">This book hasn't received any reviews</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    nav, footer, .no-print { display: none !important; }
    .shadow-sm { box-shadow: none !important; }
    .border { border: none !important; }
}
</style>
@endsection
