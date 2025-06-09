@extends('admin.layouts.admin')

@section('title', 'Borrow Details')

@section('admin-content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Borrow Request Details</h1>
        <a href="{{ route('admin.borrows.index') }}" class="text-gray-600 hover:text-gray-800">Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                @switch($borrow->status)
                                    @case('pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-yellow-50 text-yellow-800">
                                            <i class="ph-clock-bold mr-1"></i> Pending Approval
                                        </span>
                                        @break
                                    @case('borrowed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-50 text-green-800">
                                            <i class="ph-book-open-bold mr-1"></i> Currently Borrowed
                                        </span>
                                        @break
                                    @case('returned')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-gray-50 text-gray-800">
                                            <i class="ph-check-circle-bold mr-1"></i> Returned
                                        </span>
                                        @break
                                    @case('overdue')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-50 text-red-800">
                                            <i class="ph-warning-bold mr-1"></i> Overdue
                                        </span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Borrow Date</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->borrow_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Return Date</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->return_date->format('M d, Y') }}</p>
                        </div>
                        @if($borrow->actual_return_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Actual Return Date</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->actual_return_date->format('M d, Y') }}</p>
                        </div>
                        @endif
                        @if($borrow->approved_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Approved At</label>
                            <p class="mt-1 text-gray-800">{{ $borrow->approved_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif
                        @if($borrow->notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Notes</label>
                            <p class="mt-1 text-gray-600 bg-gray-50 rounded p-3">{{ $borrow->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">User & Book Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">User</label>
                            <div class="mt-1">
                                <p class="text-gray-800 font-medium">{{ $borrow->user->name }}</p>
                                <p class="text-gray-600 text-sm">{{ $borrow->user->email }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Book</label>
                            <div class="mt-1">
                                <p class="text-gray-800 font-medium">{{ $borrow->book->title }}</p>
                                <p class="text-gray-600 text-sm">By {{ $borrow->book->author }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Category</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-50 text-blue-800">
                                    {{ $borrow->book->category->name }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($borrow->status === 'pending')
                <div class="mt-6 border-t border-gray-100 pt-6">
                    <div class="flex justify-end space-x-3">
                        <form action="{{ route('admin.borrows.approve', $borrow) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                <i class="ph-check-bold mr-2"></i>
                                Approve Request
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                <div class="mt-6 border-t border-gray-100 pt-6">
                    <div class="flex justify-end space-x-3">
                        <form action="{{ route('admin.borrows.return', $borrow) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                <i class="ph-arrow-counter-clockwise-bold mr-2"></i>
                                Mark as Returned
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
