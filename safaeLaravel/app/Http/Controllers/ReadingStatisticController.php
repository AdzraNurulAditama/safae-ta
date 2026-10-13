<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingHistory;
use App\Models\BookResume;
use App\Models\ReadingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReadingStatisticController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $now = Carbon::now();

        // 1. KARTU METRIK UTAMA
        $histories = ReadingHistory::with('book')->where('user_id', $userId)->get();
        $totalDibaca = $histories->count();
        $totalSelesai = $histories->where('status', 'Selesai Dibaca')->count();
        
        $totalMinutes = ReadingSession::where('user_id', $userId)->sum('duration_minutes');
        $jam = floor($totalMinutes / 60);
        $menit = $totalMinutes % 60;
        $waktuMembacaFormatted = "{$jam}j {$menit}m";

        $totalResume = BookResume::where('user_id', $userId)->count();

        // 2. KALENDER MEMBACA (INFO BULAN & TAHUN)
        $namaBulanTahun = $now->isoFormat('MMMM YYYY'); // Contoh: Oktober 2026
        $currentMonth = $now->month;
        $currentYear = $now->year;
        
        $datesRead = ReadingSession::where('user_id', $userId)
            ->whereYear('read_date', $currentYear)
            ->whereMonth('read_date', $currentMonth)
            ->pluck('read_date')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        $datesResume = BookResume::where('user_id', $userId)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->pluck('created_at')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        // 3. KONSISTENSI MEMBACA (7 HARI TERAKHIR)
        $last7DaysData = [];
        $last7DaysLabels = [];
        $activeDaysThisWeek = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayLabel = $date->isoFormat('dd');
            $dateStr = $date->format('Y-m-d');

            $sessionCount = ReadingSession::where('user_id', $userId)
                ->whereDate('read_date', $dateStr)
                ->count();

            $last7DaysLabels[] = $dayLabel;
            $last7DaysData[] = $sessionCount;

            if ($sessionCount > 0) {
                $activeDaysThisWeek++;
            }
        }

        // 4. INDIKATOR LITERASI
        $pemahamanSkor = 82;
        $konsistensiSkor = "{$activeDaysThisWeek}/5";
        $kualitasResumeSkor = number_format(min(4.2, 3.0 + ($totalResume * 0.2)), 1);

        // 5. AKTIVITAS TERBARU
        $recentActivities = ReadingHistory::with('book')
            ->where('user_id', $userId)
            ->orderBy('last_read_at', 'desc')
            ->take(3)
            ->get();

        // 6. TARGET BULAN INI (DENGAN DEFAULTS ATAU INPUT SEMENTARA SESSION)
        $targetBuku = session('target_buku_' . $userId, 5); // Default 5 buku
        $progressTarget = min($totalSelesai, $targetBuku);
        $sisaHari = $now->daysInMonth - $now->day;
        $persenTarget = round(($progressTarget / max($targetBuku, 1)) * 100);

        $userBooks = Book::whereIn('id', $histories->pluck('book_id'))->get();

        return view('readingstats.index', compact(
            'totalDibaca',
            'totalSelesai',
            'waktuMembacaFormatted',
            'totalResume',
            'namaBulanTahun',
            'datesRead',
            'datesResume',
            'last7DaysLabels',
            'last7DaysData',
            'activeDaysThisWeek',
            'pemahamanSkor',
            'konsistensiSkor',
            'kualitasResumeSkor',
            'recentActivities',
            'targetBuku',
            'progressTarget',
            'persenTarget',
            'sisaHari',
            'userBooks'
        ));
    }

    public function storeActivity(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'duration_minutes' => 'required|numeric|min:1',
            'pages_read' => 'nullable|numeric|min:0',
            'read_date' => 'required|date',
        ]);

        ReadingSession::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'duration_minutes' => $request->duration_minutes,
            'pages_read' => $request->pages_read ?? 0,
            'read_date' => $request->read_date,
        ]);

        return redirect()->back()->with('success', '🎉 Aktivitas membaca berhasil dicatat!');
    }

    // UPDATE TARGET BULANAN
    public function updateTarget(Request $request)
    {
        $request->validate([
            'target_buku' => 'required|numeric|min:1|max:100',
        ]);

        session(['target_buku_' . Auth::id() => $request->target_buku]);

        return redirect()->back()->with('success', '🎯 Target bulanan berhasil diperbarui!');
    }
}