<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // HALAMAN PEMBAYARAN USER
    public function index()
    {
        $user = Auth::user();

        return view('pembayaran.index', [
            'saldoPoin' => $user->points
        ]);
    }

    // PROSES PEMBAYARAN
    public function proses(Request $request)
    {
        // validasi sederhana
        $request->validate([
            'points' => 'required|integer|min:1',
            'price'  => 'required|integer|min:0',
            'metode' => 'required'
        ]);

        // 1. tambah poin user
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'points' => DB::raw('points` + ' . (int) $request->points)
            ]);

        // 2. simpan ke tabel pembayarans (buat admin)
        DB::table('pembayarans')->insert([
            'user_id'    => Auth::id(),
            'points'     => (int) $request->points,
            'price'      => (int) $request->price,
            'metode'     => $request->metode,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. redirect balik
        return redirect('/pembayaran')
            ->with('success', 'Pembayaran berhasil! Poin kamu bertambah 🎉');
    }
}
