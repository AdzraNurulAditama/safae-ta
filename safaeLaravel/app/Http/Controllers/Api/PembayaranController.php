<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Get user's payment history
     */
    public function index(Request $request)
    {
        $payments = Pembayaran::where('user_id', $request->user()->id)
                              ->orderBy('created_at', 'desc')
                              ->get();

        return ResponseHelper::success($payments, 'Payment history retrieved successfully');
    }

    /**
     * Get all payments (Admin only)
     */
    public function all()
    {
        $payments = Pembayaran::with('user')
                              ->orderBy('created_at', 'desc')
                              ->get();

        return ResponseHelper::success($payments, 'All payments retrieved successfully');
    }

    /**
     * Get payment by ID
     */
    public function show($id)
    {
        $payment = Pembayaran::with('user')->findOrFail($id);

        return ResponseHelper::success($payment, 'Payment retrieved successfully');
    }

    /**
     * Create new payment / purchase points
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'points' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'metode' => 'required|string|in:transfer,e-wallet,credit_card,other',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        DB::beginTransaction();
        try {
            // Create payment record
            $payment = Pembayaran::create([
                'user_id' => $request->user()->id,
                'points' => $request->points,
                'price' => $request->price,
                'metode' => $request->metode,
            ]);

            // Add points to user
            $user = $request->user();
            $user->increment('points', $request->points);

            DB::commit();

            return ResponseHelper::success([
                'payment' => $payment,
                'new_total_points' => $user->points,
            ], 'Payment successful and points added', 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Payment failed', 500);
        }
    }

    /**
     * Delete payment (Admin only)
     */
    public function destroy($id)
    {
        $payment = Pembayaran::findOrFail($id);
        $payment->delete();

        return ResponseHelper::success(null, 'Payment record deleted successfully');
    }

    /**
     * Get payment statistics (Admin only)
     */
    public function statistics()
    {
        $totalPayments = Pembayaran::count();
        $totalRevenue = Pembayaran::sum('price');
        $totalPointsSold = Pembayaran::sum('points');

        $paymentsByMethod = Pembayaran::select('metode', DB::raw('count(*) as count'), DB::raw('sum(price) as total'))
                                      ->groupBy('metode')
                                      ->get();

        return ResponseHelper::success([
            'total_payments' => $totalPayments,
            'total_revenue' => $totalRevenue,
            'total_points_sold' => $totalPointsSold,
            'by_method' => $paymentsByMethod,
        ], 'Payment statistics retrieved successfully');
    }
}
