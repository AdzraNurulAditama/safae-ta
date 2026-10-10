<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\ReadingHistory;
use App\Models\Review;
use App\Models\Komentar;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Umum
        $totalBooks = Book::where('status', 'approved')->count();
        $totalUsers = User::count();
        $totalReviews = Review::count();
        $totalComments = Komentar::count();

        // Statistik User yang Login
        $userBooksRead = ReadingHistory::where('user_id', $user->id)
            ->distinct('book_id')
            ->count();

        $userReviews = Review::where('user_id', $user->id)->count();
        $userComments = Komentar::where('user_id', $user->id)->count();
        $userPoints = $user->points ?? 0;

        // Buku yang sedang dibaca user
        $recentBooks = ReadingHistory::where('user_id', $user->id)
            ->with('book')
            ->orderBy('last_read_at', 'desc')
            ->take(5)
            ->get();

        // Buku terpopuler
        $popularBooks = Book::where('status', 'approved')
            ->withCount('readingHistories')
            ->orderBy('reading_histories_count', 'desc')
            ->take(5)
            ->get();

        // Buku terbaru
        $latestBooks = Book::where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Genre terpopuler
        $popularGenres = Book::where('status', 'approved')
            ->select('genre', DB::raw('count(*) as total'))
            ->groupBy('genre')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Aktivitas membaca terbaru
        $recentReading = ReadingHistory::where('user_id', $user->id)
            ->with('book')
            ->orderBy('last_read_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'reading',
                    'icon' => 'fa-book-open',
                    'color' => 'primary',
                    'message' => 'Membaca buku "' . $item->book->title . '"',
                    'time' => $item->last_read_at
                ];
            });

        // Aktivitas review terbaru
        $recentReviewActivity = Review::where('user_id', $user->id)
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'review',
                    'icon' => 'fa-star',
                    'color' => 'warning',
                    'message' => 'Memberikan review untuk "' . $item->book->title . '"',
                    'time' => $item->created_at
                ];
            });

        // Gabungkan aktivitas
        $recentActivities = $recentReading
            ->merge($recentReviewActivity)
            ->sortByDesc('time')
            ->take(5);

        // Data Promosi / Berita
        $promotions = Promotion::latest()
            ->take(3)
            ->get();

        return view('user.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalReviews',
            'totalComments',
            'userBooksRead',
            'userReviews',
            'userComments',
            'userPoints',
            'recentBooks',
            'popularBooks',
            'latestBooks',
            'popularGenres',
            'recentActivities',
            'promotions'
        ));
    }
}