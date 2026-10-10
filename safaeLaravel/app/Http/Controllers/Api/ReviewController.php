<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Get all reviews for a book
     */
    public function index(Request $request)
    {
        $bookId = $request->get('book_id');

        $query = Review::with(['user', 'book']);

        if ($bookId) {
            $query->where('book_id', $bookId);
        }

        $reviews = $query->orderBy('created_at', 'desc')->get();

        return ResponseHelper::success($reviews, 'Reviews retrieved successfully');
    }

    /**
     * Get review by ID
     */
    public function show($id)
    {
        $review = Review::with(['user', 'book'])->findOrFail($id);

        return ResponseHelper::success($review, 'Review retrieved successfully');
    }

    /**
     * Create new review
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        // Check if user already reviewed this book
        $existingReview = Review::where('book_id', $request->book_id)
                                ->where('user_id', $request->user()->id)
                                ->first();

        if ($existingReview) {
            return ResponseHelper::error('You have already reviewed this book', 400);
        }

        $review = Review::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        $review->load(['user', 'book']);

        return ResponseHelper::success($review, 'Review created successfully', 201);
    }

    /**
     * Update review
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Check if user is owner
        if ($review->user_id !== $request->user()->id) {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|integer|min:1|max:5',
            'komentar' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $review->update($request->only(['rating', 'komentar']));
        $review->load(['user', 'book']);

        return ResponseHelper::success($review, 'Review updated successfully');
    }

    /**
     * Delete review
     */
    public function destroy(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Check if user is owner or admin
        if ($review->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $review->delete();

        return ResponseHelper::success(null, 'Review deleted successfully');
    }

    /**
     * Get user's reviews
     */
    public function myReviews(Request $request)
    {
        $reviews = Review::with(['book'])
                         ->where('user_id', $request->user()->id)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return ResponseHelper::success($reviews, 'Your reviews retrieved successfully');
    }
}
