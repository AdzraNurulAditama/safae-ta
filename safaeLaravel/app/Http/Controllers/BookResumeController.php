<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class BookResumeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE RESUME PAGE
    |--------------------------------------------------------------------------
    |*/
    public function create(Book $book)
    {
        return view('bookresume.create', compact('book'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE RESUME
    |--------------------------------------------------------------------------
    |*/
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'nullable|max:255',
            'content' => 'required'
        ]);

        // Bersihkan HTML dari Quill editor
        $cleanContent = Purifier::clean(
            $request->input('content')
        );

        // Simpan resume
        BookResume::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'title' => $request->input('title'),
            'content' => $cleanContent,
            'has_spoiler' => $request->has('has_spoiler'),
            'is_public' => true
        ]);

        return redirect()
            ->route('resume.my')
            ->with('success', '🎉 Resume berhasil dipublikasikan!');
    }

    /*
    |--------------------------------------------------------------------------
    | MY RESUMES
    |--------------------------------------------------------------------------
    |*/
    public function myResumes()
    {
        $resumes = BookResume::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(9);

        return view(
            'bookresume.my-resumes',
            compact('resumes')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT RESUME PAGE (BARU)
    |--------------------------------------------------------------------------
    |*/
    public function edit($id)
    {
        // Cari resume beserta data bukunya
        $resume = BookResume::with('book')->findOrFail($id);

        // Validasi: Pastikan resume ini memang milik user yang sedang login
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk mengedit resume ini.');
        }

        $book = $resume->book;

        // Mengarah ke folder bookresume/edit.blade.php
        return view('bookresume.edit', compact('resume', 'book'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE RESUME PROCESS (BARU)
    |--------------------------------------------------------------------------
    |*/
    public function update(Request $request, $id)
    {
        $resume = BookResume::findOrFail($id);

        // Validasi kepemilikan
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk mengubah resume ini.');
        }

        $request->validate([
            'title' => 'nullable|max:255',
            'content' => 'required'
        ]);

        // Bersihkan HTML dari Quill editor hasil edit
        $cleanContent = Purifier::clean($request->input('content'));

        // Update data di database
        $resume->update([
            'title' => $request->input('title'),
            'content' => $cleanContent,
            'has_spoiler' => $request->has('has_spoiler')
        ]);

        return redirect()
            ->route('resume.my')
            ->with('success', '🎉 Resume berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY/DELETE RESUME (BARU)
    |--------------------------------------------------------------------------
    |*/
    public function destroy($id)
    {
        $resume = BookResume::findOrFail($id);

        // Validasi kepemilikan
        if ($resume->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk menghapus resume ini.');
        }

        // Hapus data dari database
        $resume->delete();

        return redirect()
            ->route('resume.my')
            ->with('success', '🗑 Resume berhasil dihapus!');
    }
        /*
    |--------------------------------------------------------------------------
    | SHOW FULL RESUME PAGE
    |--------------------------------------------------------------------------
    |*/
    public function show($id)
    {
        // Cari resume yang ingin dibaca beserta bukunya
        $resume = BookResume::with('book')->findOrFail($id);
        
        // Lempar ke file view bookresume/show.blade.php
        return view('bookresume.show', compact('resume'));
    }
}

