<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FavoriteBook;
use App\Models\PointHistory;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Get user's favorite books
     */
    public function index(Request $request)
    {
        $favorites = FavoriteBook::with(['book'])
                                 ->where('user_id', $request->user()->id)
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        return ResponseHelper::success($favorites, 'Favorite books retrieved successfully');
    }

    /**
     * Add book to favorites
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        // Check if already favorited
        $existing = FavoriteBook::where('user_id', $request->user()->id)
                                ->where('book_id', $request->book_id)
                                ->first();

        if ($existing) {
            return ResponseHelper::error('Book already in favorites', 400);
        }

        $favorite = FavoriteBook::create([
            'user_id' => $request->user()->id,
            'book_id' => $request->book_id,
        ]);

        $favorite->load('book');

        return ResponseHelper::success($favorite, 'Book added to favorites successfully', 201);
    }

    /**
     * Remove book from favorites
     */
    public function destroy(Request $request, $id)
    {
        $favorite = FavoriteBook::where('user_id', $request->user()->id)
                                ->where('id', $id)
                                ->first();

        if (!$favorite) {
            return ResponseHelper::error('Favorite not found', 404);
        }

        $favorite->delete();

        return ResponseHelper::success(null, 'Book removed from favorites successfully');
    }

    /**
     * Check if book is favorited
     */
    public function check(Request $request, $bookId)
    {
        $isFavorite = FavoriteBook::where('user_id', $request->user()->id)
                                  ->where('book_id', $bookId)
                                  ->exists();

        return ResponseHelper::success(['is_favorite' => $isFavorite], 'Favorite status checked');
    }
}
