@extends('user.layouts.user')

@section('title', $book->title)

@section('user-content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('user.books.index') }}"
                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <i class="ph-arrow-left-bold mr-2"></i>
                Back to Browse
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
                <!-- Book Cover & Quick Actions -->
                <div class="space-y-6">
                    <!-- Cover Image -->
                    <div
                        class="aspect-[3/4] rounded-xl overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 shadow-lg">
                        @if ($book->cover_url)
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
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
                            @if ($book->stock > 0)
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

                    @if ($book->stock > 0)
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

            <!-- Reviews Section -->
            <div class="border-t border-gray-200 mt-8 pt-8 px-6 pb-6">
                <div class="max-w-3xl mx-auto">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Reviews & Ratings</h2>
                        <div class="flex items-center gap-2">
                            <div class="flex text-yellow-400 text-xl">
                                @php
                                    $avgRating = $book->reviews->avg('rating') ?? 0;
                                    $fullStars = floor($avgRating);
                                    $halfStar = $avgRating - $fullStars > 0.5;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $fullStars)
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

                    <!-- Review Form -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8 transition-all duration-300 hover:shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Write a Review</h3>
                        <form action="{{ route('user.reviews.store', $book) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    How would you rate this book?
                                </label>
                                <div class="flex items-center space-x-2" id="star-rating" role="radiogroup">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer transform hover:scale-110 transition-transform"
                                            title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden peer"
                                                required>
                                            <i
                                                class="ph-star-bold text-3xl text-gray-300 hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors"></i>
                                        </label>
                                    @endfor
                                </div>
                                <span id="rating-value"
                                    class="mt-2 text-sm font-medium text-blue-600 opacity-0 transition-opacity duration-300">
                                    <i class="ph-hand-pointing-right mr-1"></i>
                                    Your rating: <span id="selected-rating">0</span> stars
                                </span>
                                @error('rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="comment">
                                    Share your thoughts about this book
                                </label>
                                <div class="relative">
                                    <textarea id="comment" name="comment" rows="4" required
                                        class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                        placeholder="What did you like or dislike? What should other readers know?"></textarea>
                                    <div class="absolute bottom-3 right-3 text-sm text-gray-400">
                                        <span id="charCount">0</span>/500
                                    </div>
                                </div>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between pt-2">
                                <p class="text-sm text-gray-500">
                                    <i class="ph-info-bold mr-1"></i>
                                    Your review will help other readers
                                </p>
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-300 flex items-center gap-2 shadow-md">
                                    <i class="ph-paper-plane-right-bold"></i>
                                    Submit Review
                                </button>
                            </div>
                        </form>
                    </div>



                    <!-- Reviews List -->
                    <div class="space-y-6">
                        <!-- Pinned Reviews -->
                        @foreach ($book->reviews()->with('user')->where('pinned', true)->get() as $review)
                            <div class="bg-blue-50 border border-blue-100 rounded-xl shadow-sm p-6 transition-all hover:shadow-md"
                                id="review-{{ $review->id }}">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-3">
                                            <i class="ph-push-pin-fill mr-1"></i>
                                            Featured Review
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <!-- Stars -->
                                            <div class="flex text-yellow-400">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="ph-star-fill"></i>
                                                    @else
                                                        <i class="ph-star text-gray-300"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <input type="hidden" class="review-rating" value="{{ $review->rating }}">
                                            <div class="flex items-center gap-2 text-sm text-blue-600">
                                                <i class="ph-clock text-blue-500"></i>
                                                {{ $review->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                            @if ($review->user_id === auth()->id())
                                                <span
                                                    class="px-2 py-0.5 text-xs bg-blue-100 text-blue-600 rounded-full">Your
                                                    Review</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($review->user_id === auth()->id())
                                        <div class="flex items-center gap-2">
                                            <button onclick="editReview({{ $review->id }})"
                                                class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                <i class="ph-pencil-simple mr-1"></i>
                                                Edit
                                            </button>
                                            <form action="{{ route('user.reviews.destroy', $review) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this review?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                                    <i class="ph-trash-simple mr-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div class="review-content">
                                    <p class="text-gray-600 review-comment">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Regular Reviews -->
                        @forelse($book->reviews()->with('user')->where('pinned', false)->latest()->get() as $review)
                            <div class="bg-white rounded-xl shadow-sm p-6 transition-all hover:shadow-md"
                                id="review-{{ $review->id }}">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-1">
                                            <!-- Stars -->
                                            <div class="flex text-yellow-400">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="ph-star-fill"></i>
                                                    @else
                                                        <i class="ph-star text-gray-300"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <input type="hidden" class="review-rating" value="{{ $review->rating }}">
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <i class="ph-clock text-gray-400"></i>
                                                {{ $review->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                            @if ($review->user_id === auth()->id())
                                                <span
                                                    class="px-2 py-0.5 text-xs bg-blue-50 text-blue-600 rounded-full">Your
                                                    Review</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($review->user_id === auth()->id())
                                        <div class="flex items-center gap-2">
                                            <button onclick="editReview({{ $review->id }})"
                                                class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                <i class="ph-pencil-simple mr-1"></i>
                                                Edit
                                            </button>
                                            <form action="{{ route('user.reviews.destroy', $review) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this review?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                                    <i class="ph-trash-simple mr-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div class="review-content">
                                    <p class="text-gray-600 review-comment">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 rounded-xl">
                                <div class="text-gray-500 mb-2">No reviews yet</div>
                                <p class="text-sm text-gray-400 mb-4">Be the first to share your thoughts about this book!
                                </p>
                                <button onclick="document.querySelector('#comment').focus()"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="ph-pencil-simple-line-bold mr-2"></i>
                                    Write a Review
                                </button>
                            </div>
                        @endforelse
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

        function editReview(reviewId) {
            const reviewElement = document.querySelector(`#review-${reviewId}`);
            const comment = reviewElement.querySelector('.review-comment').textContent;
            const rating = reviewElement.querySelector('.review-rating').value;

            // Create edit form
            const form = document.createElement('form');
            form.action = `/user/reviews/${reviewId}`;
            form.method = 'POST';
            form.className = 'space-y-4';
            form.innerHTML = `
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <div class="flex items-center space-x-2">
                    ${Array.from({length: 5}, (_, i) => `
                        <label class="cursor-pointer">
                            <input type="radio"
                                name="rating"
                                value="${i + 1}"
                                ${rating == i + 1 ? 'checked' : ''}
                                class="hidden peer"
                                required>
                            <i class="ph-star-bold text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition-colors"></i>
                        </label>
                    `).join('')}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                <textarea name="comment" rows="4" required
                    class="w-full px-4 py-2 rounded-lg border-gray-300 focus:border-blue-500
                    focus:ring-2 focus:ring-blue-200">${comment}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg
                    hover:bg-blue-700 transition-colors flex items-center">
                    <i class="ph-check-bold mr-2"></i>
                    Update Review
                </button>
                <button type="button" onclick="cancelEdit(${reviewId})"
                    class="px-4 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg
                    hover:bg-gray-300 transition-colors flex items-center">
                    <i class="ph-x-bold mr-2"></i>
                    Cancel
                </button>
            </div>
        </div>
    `;

            reviewElement.querySelector('.review-content').replaceWith(form);
        }

        function cancelEdit(reviewId) {
            location.reload();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const starContainer = document.getElementById('star-rating');
            const stars = starContainer.querySelectorAll('i[data-star]');
            const ratingInputs = starContainer.querySelectorAll('input[name="rating"]');
            const ratingValueDisplay = document.getElementById('rating-value');
            const selectedRating = document.getElementById('selected-rating');
            const commentTextarea = document.getElementById('comment');
            const charCount = document.getElementById('charCount');

            // Character count functionality
            commentTextarea.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count;

                if (count > 450) {
                    charCount.classList.add('text-yellow-600');
                } else if (count > 490) {
                    charCount.classList.add('text-red-600');
                } else {
                    charCount.classList.remove('text-yellow-600', 'text-red-600');
                }

                if (count > 500) {
                    this.value = this.value.substring(0, 500);
                    charCount.textContent = 500;
                }
            });

            function updateStars(rating) {
                stars.forEach(star => {
                    const starValue = parseInt(star.dataset.star);
                    if (starValue <= rating) {
                        star.classList.add('text-yellow-400', 'transform', 'scale-110');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400', 'transform', 'scale-110');
                        star.classList.add('text-gray-300');
                    }
                });

                if (rating > 0) {
                    ratingValueDisplay.classList.remove('opacity-0');
                    selectedRating.textContent = rating;

                    // Add emoji based on rating
                    const emoji = rating >= 4 ? '🌟' : rating >= 3 ? '👍' : '😊';
                    selectedRating.textContent = `${rating} ${emoji}`;
                } else {
                    ratingValueDisplay.classList.add('opacity-0');
                }
            }

            // Star rating hover and click effects
            starContainer.querySelectorAll('label').forEach((label, index) => {
                const rating = index + 1;

                label.addEventListener('mouseover', () => {
                    updateStars(rating);
                });

                label.addEventListener('click', () => {
                    label.querySelector('input').checked = true;
                    updateStars(rating);

                    // Add animation effect
                    label.classList.add('animate-pulse');
                    setTimeout(() => label.classList.remove('animate-pulse'), 300);
                });
            });

            starContainer.addEventListener('mouseleave', () => {
                const selectedInput = Array.from(ratingInputs).find(input => input.checked);
                updateStars(selectedInput ? parseInt(selectedInput.value) : 0);
            });

            // Initialize with any existing rating
            const initialRating = Array.from(ratingInputs).find(input => input.checked);
            if (initialRating) {
                updateStars(parseInt(initialRating.value));
            }
        });
    </script>
@endsection
