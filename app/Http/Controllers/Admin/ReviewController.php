<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Pin a review
     */
    public function pin(Review $review)
    {
        $review->update(['pinned' => true]);
        return back()->with('success', 'Review pinned successfully');
    }

    /**
     * Unpin a review
     */
    public function unpin(Review $review)
    {
        $review->update(['pinned' => false]);
        return back()->with('success', 'Review unpinned successfully');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully');
    }
}
