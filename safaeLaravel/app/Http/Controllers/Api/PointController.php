<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    /**
     * Get user's point history
     */
    public function history(Request $request)
    {
        $history = PointHistory::where('user_id', $request->user()->id)
                               ->orderBy('created_at', 'desc')
                               ->get();

        return ResponseHelper::success($history, 'Point history retrieved successfully');
    }

    /**
     * Get user's total points
     */
    public function total(Request $request)
    {
        $user = $request->user();

        return ResponseHelper::success([
            'total_points' => $user->points,
        ], 'Total points retrieved successfully');
    }

    /**
     * Add points to user (Admin or system action)
     */
    public function addPoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'points' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $userId = $request->get('user_id', $request->user()->id);

        DB::beginTransaction();
        try {
            // Add points to user
            $user = User::findOrFail($userId);
            $user->increment('points', $request->points);

            // Create history record
            $history = PointHistory::create([
                'user_id' => $userId,
                'points' => $request->points,
            ]);

            DB::commit();

            return ResponseHelper::success([
                'history' => $history,
                'total_points' => $user->points,
            ], 'Points added successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Failed to add points', 500);
        }
    }

    /**
     * Deduct points from user
     */
    public function deductPoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'points' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $user = $request->user();

        if ($user->points < $request->points) {
            return ResponseHelper::error('Insufficient points', 400);
        }

        DB::beginTransaction();
        try {
            // Deduct points from user
            $user->decrement('points', $request->points);

            // Create history record (negative value)
            $history = PointHistory::create([
                'user_id' => $user->id,
                'points' => -$request->points,
            ]);

            DB::commit();

            return ResponseHelper::success([
                'history' => $history,
                'total_points' => $user->points,
            ], 'Points deducted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Failed to deduct points', 500);
        }
    }

    /**
     * Get leaderboard (top users by points)
     */
    public function leaderboard(Request $request)
    {
        $limit = $request->get('limit', 10);

        $users = User::select('id', 'nama_depan', 'nama_belakang', 'username', 'points')
                     ->orderBy('points', 'desc')
                     ->limit($limit)
                     ->get();

        return ResponseHelper::success($users, 'Leaderboard retrieved successfully');
    }
}
