<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\ChapterUnlock;
use App\Models\ReadingProgress;
use App\Models\PointHistory;
use App\Models\PenukaranPoint;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    private function getLevel(int $points): string
    {
        return match (true) {
            $points >= 1000 => 'Diamond',
            $points >= 500 => 'Silver',
            default => 'Bronze',
        };
    }

    // Halaman utama Reward
    public function index()
    {
        $ranking = User::orderBy('points', 'desc')->take(3)->get();
        $topUsers = User::orderBy('points', 'desc')->take(5)->get();
        $currentUser = Auth::user();
        $level = $this->getLevel($currentUser->points ?? 0);

        return view('reward.reward', compact(
            'ranking',
            'topUsers',
            'currentUser',
            'level'
        ));
    }

    // Detail Reward dan History Transaksi
    public function detail()
    {
        $user = Auth::user();
        $level = $this->getLevel($user->points ?? 0);

        // Riwayat penukaran reward
        $riwayat = PenukaranPoint::where('user_id', $user->id)
            ->latest()
            ->get();

        // Riwayat perolehan poin dari resume
        $riwayatPoin = PointHistory::where('user_id', $user->id)
            ->latest()
            ->get();

        // Riwayat membuka bab premium
        $riwayatBab = ChapterUnlock::where('user_id', $user->id)
            ->latest()
            ->get();

        // Ambil judul buku untuk riwayat resume
        $bookIds = $riwayatPoin->pluck('book_id')
            ->filter()
            ->unique();

        $books = Book::whereIn('id', $bookIds)
            ->get()
            ->keyBy('id');

        // Ambil data bab premium dan buku terkait
        $chapterIds = $riwayatBab->pluck('chapter_id')
            ->filter()
            ->unique();

        $chapters = Chapter::whereIn('id', $chapterIds)
            ->get()
            ->keyBy('id');

        $premiumBookIds = $chapters->pluck('book_id')
            ->filter()
            ->unique();

        $premiumBooks = Book::whereIn('id', $premiumBookIds)
            ->get()
            ->keyBy('id');

        $transaksi = collect();

        // Transaksi poin masuk dari resume
        foreach ($riwayatPoin as $item) {
            $book = $books->get($item->book_id);

            $transaksi->push([
                'id' => 'point-'.$item->id,
                'judul' => 'Reward Resume Buku',
                'deskripsi' => 'Resume buku: '.($book->title ?? 'Buku tidak tersedia'),
                'jenis' => 'masuk',
                'poin' => (int) $item->points,
                'tanggal' => $item->created_at,
                'status' => 'Berhasil',
                'icon' => 'ti-file-text',
            ]);
        }

        // Transaksi poin keluar untuk bab premium
        foreach ($riwayatBab as $item) {
            $chapter = $chapters->get($item->chapter_id);
            $book = $chapter
                ? $premiumBooks->get($chapter->book_id)
                : null;

            $transaksi->push([
                'id' => 'chapter-'.$item->id,
                'judul' => 'Buka Bab Premium',
                'deskripsi' => ($book->title ?? 'Buku tidak tersedia').
                    ' — '.($chapter->title ?? 'Bab tidak tersedia'),
                'jenis' => 'keluar',
                'poin' => (int) $item->points_spent,
                'tanggal' => $item->created_at,
                'status' => 'Berhasil',
                'icon' => 'ti-crown',
            ]);
        }

        // Riwayat penukaran reward
        foreach ($riwayat as $item) {
            $transaksi->push([
                'id' => 'reward-'.$item->id,
                'judul' => $item->nama_reward ?? 'Penukaran Reward',
                'deskripsi' => 'Riwayat penukaran reward',
                'jenis' => 'reward',
                'poin' => null,
                'tanggal' => $item->created_at,
                'status' => ucfirst($item->status ?? 'Berhasil'),
                'icon' => 'ti-gift',
            ]);
        }

        // Urutkan transaksi terbaru
        $transaksi = $transaksi
            ->sortByDesc('tanggal')
            ->values();

        $totalMasuk = $transaksi
            ->where('jenis', 'masuk')
            ->sum('poin');

        $totalKeluar = $transaksi
            ->where('jenis', 'keluar')
            ->sum('poin');

        $totalTransaksi = $transaksi->count();
        $totalPenukaran = $riwayat->count();

        return view('reward.detail', compact(
            'user',
            'level',
            'riwayat',
            'transaksi',
            'totalMasuk',
            'totalKeluar',
            'totalTransaksi',
            'totalPenukaran'
        ));
    }

    // Menyimpan durasi membaca
    public function saveDuration(Book $book)
    {
        $user = Auth::user();

        ReadingProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'duration' => 600,
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    // Pemberian poin melalui aktivitas membaca (fitur lama)
    // Perlu disesuaikan dengan controller resume agar tidak ada poin ganda
    public function finishReading(Book $book)
    {
        return back()->with(
            'info',
            'Poin diberikan setelah kamu berhasil menyelesaikan resume buku.'
        );
    }
}
