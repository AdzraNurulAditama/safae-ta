<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ReadingHistory;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class KelolaRiwayatBacaController extends Controller
{
    public function index()
    {
        $histories = ReadingHistory::with(['user', 'book'])->get();

        return view('admin.readinghistories.index', [
            'histories' => $histories,
        ]);
    }

    public function create()
    {
        $users = User::all();
        $books = Book::all();

        return view('admin.readinghistories.create', [
            'users' => $users,
            'books' => $books,
        ]);
    }

    // store itu nyimpen data baru setelah create kelola history
    public function store(Request $request) //dia make request $request karena ngambil data dari form
    {
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
            'progress' => 'required|integer',
            'last_read_at' => 'required|date',
            'bukti_progress' => 'nullable|file|mimes:jpg,png,pdf,jpeg'
        ]);

        $filename = null; //bikin variabel awal yang di mana variabel awal nantinya tuh boleh null boleh ngga, makannya diisi null (kalo misal admin gamau upload apa2 tetep bisa)

        if ($request->hasFile('bukti_progress')) {
            $filename = time() . '_' . $request->file('bukti_progress')->getClientOriginalName();
            $request->file('bukti_progress')->move(public_path('uploads/bukti_progress'), $filename);
        }

        ReadingHistory::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'progress' => $request->progress,
            'last_read_at' => $request->last_read_at,
            'bukti_progress' => $filename,
        ]);

        // SUDAH DI-FIX: Ditambahkan prefiks 'admin.' agar searah dengan web.php
        return redirect()->route('admin.kelolariwayat.index')
            ->with('success', 'Riwayat baca berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $history = ReadingHistory::findOrFail($id);
        $users = User::all();
        $books = Book::all();

        return view('admin.readinghistories.edit', [
            'history' => $history,
            'users' => $users,
            'books' => $books,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
            'progress' => 'required|integer',
            'last_read_at' => 'required|date',
            'bukti_progress' => 'nullable|file|mimes:jpg,png,pdf,jpeg'
        ]);

        $history = ReadingHistory::findOrFail($id);

        if ($request->hasFile('bukti_progress')) {

            if ($history->bukti_progress && file_exists(public_path('uploads/bukti_progress/' . $history->bukti_progress))) {
                unlink(public_path('uploads/bukti_progress/' . $history->bukti_progress));
            }

            $filename = time() . '_' . $request->file('bukti_progress')->getClientOriginalName();
            $request->file('bukti_progress')->move(public_path('uploads/bukti_progress'), $filename);

            $history->bukti_progress = $filename;
        }

        $history->update([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'progress' => $request->progress,
            'last_read_at' => $request->last_read_at,
        ]);

        return redirect()->route('admin.kelolariwayat.index')
            ->with('success', 'Riwayat baca berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $history = ReadingHistory::findOrFail($id);

        if ($history->bukti_progress &&
            file_exists(public_path('uploads/bukti_progress/' . $history->bukti_progress))) {

            unlink(public_path('uploads/bukti_progress/' . $history->bukti_progress));
        }

        $history->delete();

        return redirect()->route('admin.kelolariwayat.index')
            ->with('success', 'Riwayat baca berhasil dihapus!');
    }
}