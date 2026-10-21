<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PointHistory;
use App\Models\ChapterUnlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRewardController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $users = User::where('role', 'user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('points')
            ->paginate(10)
            ->withQueryString();

        $totalUsers = User::where('role', 'user')->count();

        $totalPoints = User::where('role', 'user')->sum('points');

        $totalTransactions = PointHistory::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();

        $totalUnlocks = ChapterUnlock::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();

        return view('admin.rewards.index', compact(
            'users',
            'totalUsers',
            'totalPoints',
            'totalTransactions',
            'totalUnlocks'
        ));
    }

    // TAMBAH POIN PENGGUNA
    public function add(Request $request, User $user)
    {
        $data = $request->validate([
            'points' => 'required|integer|min:1|max:1000000'
        ]);

        abort_unless($user->role === 'user', 403);

        DB::transaction(function () use ($user, $data) {
            $locked = User::whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $locked->points = (int) ($locked->points ?? 0) + (int) $data['points'];
            $locked->save();

            PointHistory::create([
                'user_id' => $locked->id,
                'points' => (int) $data['points'],
                'type' => 'admin_add',
                'description' => 'Penambahan poin oleh admin'
            ]);
        });

        return back()->with('success', 'Poin berhasil ditambahkan.');
    }

    // KURANGI POIN PENGGUNA
    public function remove(Request $request, User $user)
    {
        $data = $request->validate([
            'points' => 'required|integer|min:1|max:1000000'
        ]);

        abort_unless($user->role === 'user', 403);

        $success = DB::transaction(function () use ($user, $data) {
            $locked = User::whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) ($locked->points ?? 0) < (int) $data['points']) {
                return false;
            }

            $locked->points = (int) $locked->points - (int) $data['points'];
            $locked->save();

            PointHistory::create([
                'user_id' => $locked->id,
                'points' => -(int) $data['points'],
                'type' => 'admin_remove',
                'description' => 'Pengurangan poin oleh admin'
            ]);

            return true;
        });

        return $success
            ? back()->with('success', 'Poin berhasil dikurangi.')
            : back()->with('error', 'Saldo poin pengguna tidak mencukupi.');
    }

    // DETAIL HISTORY REWARD PENGGUNA
    public function history(User $user)
    {
        abort_unless($user->role === 'user', 403);

        $level = ($user->points ?? 0) >= 1000
            ? 'Diamond'
            : (($user->points ?? 0) >= 500 ? 'Silver' : 'Bronze');

        // RIWAYAT POIN MASUK DAN KELUAR
        $points = PointHistory::with('book')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $title = match ($item->type) {
                    'resume' => 'Reward Resume Buku',
                    'admin_add' => 'Penambahan Poin Admin',
                    'admin_remove' => 'Pengurangan Poin Admin',
                    default => 'Riwayat Poin'
                };

                $bookTitle = $item->book?->title;

                $description = $item->description
                    ?: ($bookTitle
                        ? 'Buku: '.$bookTitle
                        : 'Transaksi poin tercatat');

                return [
                    'title' => $title,
                    'description' => $description,
                    'book_title' => $bookTitle,
                    'chapter_number' => null,
                    'chapter_title' => null,
                    'points' => (int) $item->points,
                    'type' => $item->type ?: 'legacy',
                    'date' => $item->created_at
                ];
            });

        // RIWAYAT PEMBUKAAN BAB PREMIUM
        $unlocks = ChapterUnlock::with(['chapter.book'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $chapter = $item->chapter;
                $book = $chapter?->book;

                $bookTitle = $book?->title ?? 'Buku tidak ditemukan';
                $chapterNumber = $chapter?->chapter_number ?? '-';
                $chapterTitle = $chapter?->title ?? 'Judul bab tidak ditemukan';

                return [
                    'title' => 'Membuka Bab Premium',
                    'description' => 'Buku: '.$bookTitle
                        .' | Bab '.$chapterNumber
                        .' - '.$chapterTitle,
                    'book_title' => $bookTitle,
                    'chapter_number' => $chapterNumber,
                    'chapter_title' => $chapterTitle,
                    'points' => -(int) $item->points_spent,
                    'type' => 'unlock',
                    'date' => $item->created_at
                ];
            });

        // GABUNGKAN SELURUH RIWAYAT TRANSAKSI
        $transactions = $points
            ->concat($unlocks)
            ->sortByDesc('date')
            ->values();

        // TOTAL POIN MASUK
        $totalIn = $points
            ->filter(fn($item) => $item['points'] > 0)
            ->sum('points');

        // TOTAL POIN KELUAR
        $totalOut = abs(
            $points
                ->filter(fn($item) => $item['points'] < 0)
                ->sum('points')
        ) + abs($unlocks->sum('points'));

        return view('admin.rewards.history', compact(
            'user',
            'level',
            'transactions',
            'totalIn',
            'totalOut'
        ));
    }
}
