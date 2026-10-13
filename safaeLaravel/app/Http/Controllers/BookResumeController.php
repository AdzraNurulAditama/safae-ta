<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookResume;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookResumeController extends Controller
{
    /**
     * Menampilkan Daftar Resume Saya (Tampilan Modern + Offcanvas Detail)
     */
    public function myResumes(Request $request)
    {
        $userId = Auth::id();
        $statusFilter = $request->input('status', 'Semua');
        $search = $request->input('search', '');

        $query = BookResume::with(['book', 'user'])
            ->where('user_id', $userId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('book', function ($b) use ($search) {
                      $b->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                  });
            });
        }

        $resumes = $query->latest()->get();

        // Ambil data progres membaca tiap buku untuk melengkapi kartu detail
        $histories = ReadingHistory::where('user_id', $userId)
            ->get()
            ->keyBy('book_id');

        // Metrik Ringkasan Top Cards
        $totalResume = $resumes->count();
        $lastUpdated = $resumes->first() ? $resumes->first()->updated_at->isoFormat('D MMM YYYY') : '-';
        $connectedBooks = $resumes->pluck('book_id')->unique()->count();

        return view('bookresume.my-resumes', compact(
            'resumes',
            'histories',
            'totalResume',
            'lastUpdated',
            'connectedBooks',
            'statusFilter',
            'search'
        ));
    }

    public function create(Book $book)
    {
        return view('bookresume.create', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_spoiler' => 'nullable|boolean',
        ]);

        BookResume::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'title' => $request->title,
            'content' => $request->content,
            'is_spoiler' => $request->has('is_spoiler'),
        ]);

        return redirect()->route('resume.my')->with('success', 'Resume berhasil dibuat!');
    }

    public function edit($id)
{
    $resume = BookResume::with('book')->where('user_id', Auth::id())->findOrFail($id);
    return view('bookresume.edit', compact('resume'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_spoiler' => 'nullable|boolean',
        ]);

        $resume = BookResume::where('user_id', Auth::id())->findOrFail($id);
        $resume->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_spoiler' => $request->has('is_spoiler'),
        ]);

        return redirect()->route('resume.my')->with('success', 'Resume berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $resume = BookResume::where('user_id', Auth::id())->findOrFail($id);
        $resume->delete();

        return redirect()->route('resume.my')->with('success', 'Resume berhasil dihapus.');
    }
}