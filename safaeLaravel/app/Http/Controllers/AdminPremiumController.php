<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PremiumRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPremiumController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');

        $query = PremiumRequest::with(['user', 'book']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($book) use ($search) {
                    $book->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                })->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%{$search}%");
                });
            });
        }

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        $totalRequests = PremiumRequest::count();
        $totalPending = PremiumRequest::where('status', 'pending')->count();
        $totalApproved = PremiumRequest::where('status', 'approved')->count();
        $totalRejected = PremiumRequest::where('status', 'rejected')->count();

        return view('admin.premium.index', compact(
            'requests',
            'totalRequests',
            'totalPending',
            'totalApproved',
            'totalRejected'
        ));
    }

    public function books(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = Book::with('user')
            ->withCount([
                'chapters',
                'chapters as published_chapters_count' => function ($q) {
                    $q->where('status', 'published');
                }
            ])
            ->where('is_premium', true);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('username', 'like', "%{$search}%");
                    });
            });
        }

        $books = $query->latest()->paginate(9)->withQueryString();

        $totalPremium = Book::where('is_premium', true)->count();
        $totalRegular = Book::where('is_premium', false)->count();
        $totalPending = PremiumRequest::where('status', 'pending')->count();

        return view('admin.premium.books', compact(
            'books',
            'totalPremium',
            'totalRegular',
            'totalPending'
        ));
    }

    public function approve($id)
    {
        $result = DB::transaction(function () use ($id) {
            $premium = PremiumRequest::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($premium->status !== 'pending') {
                return 'processed';
            }

            $book = Book::whereKey($premium->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!in_array($book->status, ['approved', 'published'], true)) {
                return 'book_not_approved';
            }

            $premium->update(['status' => 'approved']);
            $book->update(['is_premium' => true]);

            Notification::create([
                'user_id' => $premium->user_id,
                'title' => 'Pengajuan Premium Disetujui',
                'message' => 'Buku "'.$book->title.'" berhasil menjadi Buku Premium.'
            ]);

            return 'success';
        });

        if ($result === 'processed') {
            return back()->with('info', 'Pengajuan ini sudah diproses.');
        }

        if ($result === 'book_not_approved') {
            return back()->with('error', 'Buku harus disetujui sebelum menjadi premium.');
        }

        return back()->with('success', 'Pengajuan disetujui. Penulis dapat mengatur bab premium.');
    }

    public function reject($id)
    {
        $result = DB::transaction(function () use ($id) {
            $premium = PremiumRequest::with('book')
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($premium->status !== 'pending') {
                return false;
            }

            $premium->update(['status' => 'rejected']);

            Notification::create([
                'user_id' => $premium->user_id,
                'title' => 'Pengajuan Premium Ditolak',
                'message' => 'Pengajuan premium untuk buku "'.
                    ($premium->book?->title ?? 'yang diajukan').
                    '" ditolak admin.'
            ]);

            return true;
        });

        return $result
            ? back()->with('success', 'Pengajuan berhasil ditolak.')
            : back()->with('info', 'Pengajuan ini sudah diproses.');
    }

    public function setPremium($book)
    {
        $book = Book::findOrFail($book);

        if (!in_array($book->status, ['approved', 'published'], true)) {
            return back()->with('error', 'Buku belum disetujui untuk publikasi.');
        }

        if ($book->is_premium) {
            return back()->with('info', 'Buku ini sudah premium.');
        }

        return back()->with(
            'error',
            'Buku harus melalui proses pengajuan premium dan persetujuan admin.'
        );
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $book = Book::whereKey($id)->lockForUpdate()->firstOrFail();

            $book->update(['is_premium' => false]);

            // Sinkronkan riwayat persetujuan agar penulis bisa mengajukan ulang.
            PremiumRequest::where('book_id', $book->id)
                ->where('status', 'approved')
                ->update(['status' => 'rejected']);

            Notification::create([
                'user_id' => $book->user_id,
                'title' => 'Status Premium Dicabut',
                'message' => 'Status premium buku "'.$book->title.
                    '" telah dicabut oleh admin.'
            ]);
        });

        return back()->with('success', 'Status premium berhasil dicabut. Buku tidak dihapus.');
    }
}
