@extends('admin.layouts.admin')

@section('title', 'Manage Borrows')

@section('admin-content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Borrow Requests</h1>
        <a href="{{ route('admin.borrows.print.history') }}" target="_blank"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-all">
            <i class="ph-printer-bold mr-2"></i>
            Print History
        </a>
    </div>
    <p class="mt-2 text-sm text-gray-600">Manage book borrowing requests and returns</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="border-b border-gray-100">
        <div class="flex items-center p-4 space-x-4">
            <button class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ !request('status') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-gray-50' }}"
                onclick="window.location.href='{{ route('admin.borrows.index') }}'">
                All Requests
            </button>
            <button class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') === 'pending' ? 'bg-yellow-50 text-yellow-700' : 'text-gray-500 hover:bg-gray-50' }}"
                onclick="window.location.href='{{ route('admin.borrows.index', ['status' => 'pending']) }}'">
                Pending
            </button>
            <button class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') === 'borrowed' ? 'bg-green-50 text-green-700' : 'text-gray-500 hover:bg-gray-50' }}"
                onclick="window.location.href='{{ route('admin.borrows.index', ['status' => 'borrowed']) }}'">
                Borrowed
            </button>
            <button class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') === 'overdue' ? 'bg-red-50 text-red-700' : 'text-gray-500 hover:bg-gray-50' }}"
                onclick="window.location.href='{{ route('admin.borrows.index', ['status' => 'overdue']) }}'">
                Overdue
            </button>
            <button class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('status') === 'returned' ? 'bg-gray-50 text-gray-700' : 'text-gray-500 hover:bg-gray-50' }}"
                onclick="window.location.href='{{ route('admin.borrows.index', ['status' => 'returned']) }}'">
                Returned
            </button>
        </div>
    </div>

    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">User</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Book</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Borrow Date</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Return Date</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Status</th>
                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($borrows as $borrow)
            <tr class="hover:bg-gray-50 transition-all">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 mr-3">
                            <i class="ph-user-bold"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $borrow->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $borrow->user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</div>
                        <div class="text-sm text-gray-500">by {{ $borrow->book->author }}</div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $borrow->borrow_date->format('M d, Y') }}</div>
                    <div class="text-xs text-gray-500">{{ $borrow->borrow_date->diffForHumans() }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $borrow->return_date->format('M d, Y') }}</div>
                    @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                        <div class="text-xs {{ $borrow->isOverdue() ? 'text-red-500' : 'text-gray-500' }}">
                            {{ $borrow->isOverdue() ? 'Overdue by ' . $borrow->getDaysOverdueAttribute() . ' days' : $borrow->getDaysRemainingAttribute() . ' days remaining' }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $borrow->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                        {{ $borrow->status === 'borrowed' ? 'bg-green-50 text-green-700' : '' }}
                        {{ $borrow->status === 'returned' ? 'bg-gray-50 text-gray-700' : '' }}
                        {{ $borrow->status === 'overdue' ? 'bg-red-50 text-red-700' : '' }}">
                        <i class="ph-circle-bold mr-1 text-xs"></i>
                        {{ ucfirst($borrow->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.borrows.show', $borrow) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="ph-eye-bold mr-1"></i> View Details
                        </a>
                        @if($borrow->status === 'pending')
                            <form action="{{ route('admin.borrows.approve', $borrow) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-all">
                                    <i class="ph-check-bold mr-1"></i> Approve
                                </button>
                            </form>
                        @endif
                        @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                            <form action="{{ route('admin.borrows.return', $borrow) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-all">
                                    <i class="ph-arrow-counter-clockwise-bold mr-1"></i> Return
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $borrows->links() }}
    </div>
</div>
@endsection
