@extends('user.layouts.user')

@section('title', 'My Borrows')

@section('user-content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">My Borrow History</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-wrap gap-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'pending' ? 'bg-yellow-50 text-yellow-800' : 'bg-gray-50 text-gray-600' }}">
                <i class="ph-clock-bold mr-2"></i>
                Pending ({{ Auth::user()->borrows()->where('status', 'pending')->count() }})
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'borrowed' ? 'bg-green-50 text-green-800' : 'bg-gray-50 text-gray-600' }}">
                <i class="ph-book-open-bold mr-2"></i>
                Active ({{ Auth::user()->borrows()->where('status', 'borrowed')->count() }})
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'returned' ? 'bg-blue-50 text-blue-800' : 'bg-gray-50 text-gray-600' }}">
                <i class="ph-check-circle-bold mr-2"></i>
                Returned ({{ Auth::user()->borrows()->where('status', 'returned')->count() }})
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'overdue' ? 'bg-red-50 text-red-800' : 'bg-gray-50 text-gray-600' }}">
                <i class="ph-warning-bold mr-2"></i>
                Overdue ({{ Auth::user()->borrows()->where('status', 'overdue')->count() }})
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($borrows as $borrow)
                <tr class="hover:bg-gray-50 transition-all">
                    <td class="px-6 py-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</h3>
                            <p class="text-sm text-gray-500">by {{ $borrow->book->author }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $borrow->borrow_date->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $borrow->borrow_date->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $borrow->return_date->format('M d, Y') }}</div>
                        @if($borrow->status === 'borrowed')
                            <div class="text-sm {{ $borrow->isOverdue() ? 'text-red-600' : 'text-gray-500' }}">
                                {{ $borrow->isOverdue() ? 'Overdue by ' : 'Due in ' }} {{ abs($borrow->getDaysRemainingAttribute()) }} days
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('user.borrows.show', $borrow) }}"
                                class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                                <i class="ph-eye-bold mr-1"></i>
                                View Details
                            </a>
                            @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                                <form action="{{ route('user.borrows.return', $borrow) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all">
                                        <i class="ph-arrow-counter-clockwise-bold mr-1"></i>
                                        Return Book
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="p-3 bg-gray-50 rounded-full mb-4">
                                <i class="ph-books-bold text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900">No borrow history yet</h3>
                            <p class="text-sm text-gray-500 mt-1">Start by browsing our collection of books</p>
                            <a href="{{ route('user.books.index') }}"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all">
                                Browse Books
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($borrows->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $borrows->links() }}
        </div>
    @endif
</div>
@endsection
