<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;

class PembayaranAdminController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pembayaran.index', [
            'pembayarans' => $pembayarans
        ]);
    }
}
