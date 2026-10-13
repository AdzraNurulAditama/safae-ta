<?php

namespace App\Http\Controllers;

use App\Models\ReadingHistory;
use App\Models\BookResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingHistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedGenre = $request->input('genre', 'Semua');
        $statusFilter = $request->input('status', 'Semua');

        $query = ReadingHistory::with('book')->where('user_id', $userId);

        // Filter berdasarkan Status jika ada
        if ($statusFilter !== 'Semua') {
            $query->where('status', $statusFilter);
        }

        $allHistories = $query->orderBy('last_read_at', 'desc')->get();

        // Kelompokkan riwayat baca berdasarkan Genre Buku
        $groupedHistories = $allHistories->groupBy(function ($item) {
            return $item->book->genre ?? 'Lainnya';
        });

        // Ambil daftar genre unik yang dimiliki user sebelum difilter
        $availableGenres = $groupedHistories->keys();

        // Filter jika genre spesifik dipilih (Perbaikan di baris ini)
        if ($selectedGenre !== 'Semua') {
            $groupedHistories = $groupedHistories->filter(function ($value, $key) use ($selectedGenre) {
                return $key === $selectedGenre;
            });
        }

        // Ambil ID buku yang sudah memiliki resume
        $resumesBookIds = BookResume::where('user_id', $userId)
            ->pluck('book_id')
            ->toArray();

        // Kirim semua variabel ke view
        return view('readinghistories.index', compact(
            'groupedHistories',
            'availableGenres',
            'selectedGenre',
            'statusFilter',
            'resumesBookIds'
        ));
    }

    public function markAsFinished($id)
    {
        $history = ReadingHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $totalHalaman = $history->book->chapters()->count() ?: ($history->book->jumlah_halaman ?? 1);

        $history->update([
            'progress' => $totalHalaman,
            'progress_percentage' => 100.00,
            'status' => 'Selesai Dibaca',
            'last_read_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Buku berhasil ditandai sebagai Selesai Dibaca!');
    }

    public function destroy($id)
    {
        $history = ReadingHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $history->delete();

        return redirect()->route('reading.history')->with('success', 'Riwayat berhasil dihapus.');
    }
}