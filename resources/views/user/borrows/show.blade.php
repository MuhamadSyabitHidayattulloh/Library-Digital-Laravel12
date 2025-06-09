@extends('user.layouts.user')

@section('title', 'Borrow Details')

@section('user-content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Borrow Details</h1>
        <a href="{{ route('user.borrows') }}" class="text-gray-600 hover:text-gray-800">Back to My Borrows</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Borrow Status -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Borrow Status</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Current Status</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                                    {{ $borrow->status === 'pending' ? 'bg-yellow-50 text-yellow-800' : '' }}
                                    {{ $borrow->status === 'borrowed' ? 'bg-green-50 text-green-800' : '' }}
                                    {{ $borrow->status === 'returned' ? 'bg-blue-50 text-blue-800' : '' }}
                                    {{ $borrow->status === 'overdue' ? 'bg-red-50 text-red-800' : '' }}">
                                    <i class="mr-1
                                        {{ $borrow->status === 'pending' ? 'ph-clock-bold' : '' }}
                                        {{ $borrow->status === 'borrowed' ? 'ph-book-open-bold' : '' }}
                                        {{ $borrow->status === 'returned' ? 'ph-check-circle-bold' : '' }}
                                        {{ $borrow->status === 'overdue' ? 'ph-warning-bold' : '' }}">
                                    </i>
                                    {{ ucfirst($borrow->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Borrow Date</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->borrow_date->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Return Date</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->return_date->format('M d, Y') }}</p>
                            @if($borrow->status === 'borrowed')
                                <p class="mt-1 text-sm {{ $borrow->isOverdue() ? 'text-red-600' : 'text-gray-500' }}">
                                    {{ $borrow->isOverdue() ? 'Overdue by ' : 'Due in ' }} {{ abs($borrow->getDaysRemainingAttribute()) }} days
                                </p>
                            @endif
                        </div>

                        @if($borrow->actual_return_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Actual Return Date</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->actual_return_date->format('M d, Y') }}</p>
                        </div>
                        @endif

                        @if($borrow->notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Notes</label>
                            <p class="mt-1 text-gray-600 bg-gray-50 rounded p-3">{{ $borrow->notes }}</p>
                        </div>
                        @endif
                    </div>

                    @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                    <div class="mt-6">
                        <form action="{{ route('user.borrows.return', $borrow) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                                <i class="ph-arrow-counter-clockwise-bold mr-2"></i>
                                Return Book
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Book Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Book Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Title</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->book->title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Author</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->book->author }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Category</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-50 text-blue-800">
                                    {{ $borrow->book->category->name }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">ISBN</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->book->isbn }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('user.books.show', $borrow->book) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all">
                            <i class="ph-book-bold mr-2"></i>
                            View Book Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
