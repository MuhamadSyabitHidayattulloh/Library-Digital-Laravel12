<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Display a listing of all borrows for admin.
     */
    public function index()
    {
        $borrows = Borrow::with(['user', 'book', 'book.category'])->latest()->paginate(10);
        return view('admin.borrows.index', compact('borrows'));
    }

    public function show(Borrow $borrow)
    {
        $borrow->load(['user', 'book', 'book.category']);
        return view('admin.borrows.show', compact('borrow'));
    }

    /**
     * Store a newly created borrow request in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => [
                'required',
                'date',
                'after:borrow_date',
                function ($attribute, $value, $fail) use ($request) {
                    $borrowDate = Carbon::parse($request->borrow_date);
                    $returnDate = Carbon::parse($value);

                    if ($returnDate->gt($borrowDate->copy()->addDays(30))) {
                        $fail('Tanggal pengembalian tidak boleh lebih dari 30 hari setelah tanggal peminjaman.');
                    }
                },
            ],
            'notes' => 'nullable|string|max:500'
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->stock < 1) {
            return back()->withErrors(['error' => 'Book is out of stock!']);
        }

        $borrow = Borrow::create([
            'user_id' => Auth::id(),
            'book_id' => $validated['book_id'],
            'borrow_date' => $validated['borrow_date'],
            'return_date' => $validated['return_date'],
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        return redirect()->route('user.borrows')->with('success', 'Borrow request submitted successfully!');
    }

    /**
     * Approve a pending borrow request.
     */
    public function approve(Borrow $borrow)
    {
        if ($borrow->status !== 'pending') {
            return back()->withErrors(['error' => 'Can only approve pending requests!']);
        }

        $book = $borrow->book;
        if ($book->stock < 1) {
            return back()->withErrors(['error' => 'Book is out of stock!']);
        }

        // Check if user has any overdue books
        if ($borrow->user->borrows()->where('status', 'overdue')->exists()) {
            return back()->withErrors(['error' => 'User has overdue books!']);
        }

        $borrow->update([
            'status' => 'borrowed',
            'approved_at' => now()
        ]);
        $book->decrement('stock');

        return back()->with('success', 'Borrow request approved!');
    }

    /**
     * Return a borrowed book.
     */
    public function return(Borrow $borrow)
    {
        if ($borrow->status !== 'borrowed' && $borrow->status !== 'overdue') {
            return back()->withErrors(['error' => 'Invalid borrow status for return!']);
        }

        if ($borrow->user_id !== Auth::id() && !Auth::user()->role === 'admin') {
            return back()->withErrors(['error' => 'Unauthorized action!']);
        }

        $borrow->update([
            'status' => 'returned',
            'actual_return_date' => now()
        ]);

        $borrow->book->increment('stock');

        $message = 'Book returned successfully!';
        if ($borrow->actual_return_date > $borrow->return_date) {
            $message .= ' Note: This book was returned late.';
        }

        return back()->with('success', $message);
    }

    /**
     * Display a listing of the user's borrows.
     */
    public function userBorrows()
    {
        $borrows = Borrow::where('user_id', Auth::id())
            ->with(['book', 'book.category'])
            ->latest()
            ->paginate(10);

        return view('user.borrows.index', compact('borrows'));
    }

    /**
     * Display the details of a specific borrow for the user.
     */
    public function userShow(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $borrow->load(['book', 'book.category']);
        return view('user.borrows.show', compact('borrow'));
    }

    public function printHistory()
    {
        $borrows = Borrow::with(['user', 'book'])->latest()->get();
        return view('admin.borrows.print-history', compact('borrows'));
    }
}
