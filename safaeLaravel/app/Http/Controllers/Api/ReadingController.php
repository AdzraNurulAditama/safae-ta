<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReadingHistory;
use App\Models\ReadingProgress;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReadingController extends Controller
{
    /**
     * Get user's reading history
     */
    public function history(Request $request)
    {
        $histories = ReadingHistory::with(['book'])
                                   ->where('user_id', $request->user()->id)
                                   ->orderBy('last_read_at', 'desc')
                                   ->get();

        return ResponseHelper::success($histories, 'Reading history retrieved successfully');
    }

    /**
     * Get reading history for a specific book
     */
    public function getBookHistory(Request $request, $bookId)
    {
        $history = ReadingHistory::with(['book'])
                                 ->where('user_id', $request->user()->id)
                                 ->where('book_id', $bookId)
                                 ->first();

        if (!$history) {
            return ResponseHelper::error('Reading history not found', 404);
        }

        return ResponseHelper::success($history, 'Reading history retrieved successfully');
    }

    /**
     * Create or update reading history
     */
    public function updateHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'progress' => 'required|integer|min:0|max:100',
            'bukti_progress' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $history = ReadingHistory::where('user_id', $request->user()->id)
                                 ->where('book_id', $request->book_id)
                                 ->first();

        $data = [
            'progress' => $request->progress,
            'last_read_at' => now(),
        ];

        // Handle image upload
        if ($request->hasFile('bukti_progress')) {
            if ($history && $history->bukti_progress) {
                Storage::disk('public')->delete($history->bukti_progress);
            }
            $data['bukti_progress'] = $request->file('bukti_progress')->store('reading-progress', 'public');
        }

        if ($history) {
            $history->update($data);
        } else {
            $data['user_id'] = $request->user()->id;
            $data['book_id'] = $request->book_id;
            $history = ReadingHistory::create($data);
        }

        $history->load('book');

        return ResponseHelper::success($history, 'Reading history updated successfully');
    }

    /**
     * Delete reading history
     */
    public function deleteHistory(Request $request, $id)
    {
        $history = ReadingHistory::where('user_id', $request->user()->id)
                                 ->where('id', $id)
                                 ->first();

        if (!$history) {
            return ResponseHelper::error('Reading history not found', 404);
        }

        if ($history->bukti_progress) {
            Storage::disk('public')->delete($history->bukti_progress);
        }

        $history->delete();

        return ResponseHelper::success(null, 'Reading history deleted successfully');
    }

    /**
     * Get user's reading progress
     */
    public function progress(Request $request)
    {
        $progress = ReadingProgress::with(['book'])
                                   ->where('user_id', $request->user()->id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return ResponseHelper::success($progress, 'Reading progress retrieved successfully');
    }

    /**
     * Record reading duration
     */
    public function recordDuration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'duration' => 'required|integer|min:1', // in seconds
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $progress = ReadingProgress::create([
            'user_id' => $request->user()->id,
            'book_id' => $request->book_id,
            'duration' => $request->duration,
        ]);

        $progress->load('book');

        return ResponseHelper::success($progress, 'Reading duration recorded successfully', 201);
    }

    /**
     * Get total reading duration
     */
    public function totalDuration(Request $request)
    {
        $bookId = $request->get('book_id');

        $query = ReadingProgress::where('user_id', $request->user()->id);

        if ($bookId) {
            $query->where('book_id', $bookId);
        }

        $totalDuration = $query->sum('duration');

        return ResponseHelper::success([
            'total_duration_seconds' => $totalDuration,
            'total_duration_minutes' => round($totalDuration / 60, 2),
            'total_duration_hours' => round($totalDuration / 3600, 2),
        ], 'Total reading duration retrieved successfully');
    }
}
