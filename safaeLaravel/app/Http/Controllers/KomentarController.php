<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KomentarController extends Controller
{
    public function index($bookId, $page)
    {
        $komentar = Komentar::with('user')
            ->where('book_id', $bookId)
            ->where('page', $page)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('books.komentar', [
            'komentar' => $komentar,
            'bookId' => $bookId,
            'page' => $page
        ]);
    }

    public function simpan(Request $r)
    {
        $r->validate([
            'book_id' => 'required',
            'page' => 'required',
            'komentar' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        // SIMPAN GAMBAR KE STORAGE
        if ($r->hasFile('image')) {
            $namaFile = $r->file('image')->store('komentar', 'public');
        }

        $user = Auth::user();
        $username = $user->username ?? $user->name ?? 'Anonymous';

        Komentar::create([
            'user_id' => $user->id,
            'book_id' => $r->book_id,
            'page' => $r->page,
            'username' => $username,
            'komentar' => $r->komentar,
            'image_path' => $namaFile
        ]);

        return redirect()->route('komentar.index', [
            'bookId' => $r->book_id,
            'page' => $r->page
        ])->with('success', 'Komentar berhasil dikirim!');
    }

    public function edit($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
            abort(403);
        }

        return view('books.edit_komentar', [
            'komentar' => $komentar
        ]);
    }

    public function update(Request $r, $id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
            abort(403, 'Kamu tidak berhak mengedit komentar ini');
        }

        $r->validate([
            'komentar' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = $komentar->image_path;

        // GANTI GAMBAR KOMENTAR
        if ($r->hasFile('image')) {
            $gambarBaru = $r->file('image')->store('komentar', 'public');

            $komentar->update([
                'komentar' => $r->komentar,
                'image_path' => $gambarBaru
            ]);

            // HAPUS GAMBAR LAMA DARI STORAGE
            if ($namaFile) {
                $pathLama = preg_replace(
                    '#^(public/|storage/)+#',
                    '',
                    $namaFile
                );

                if (Storage::disk('public')->exists($pathLama)) {
                    Storage::disk('public')->delete($pathLama);
                }
            }
        } else {
            $komentar->update([
                'komentar' => $r->komentar
            ]);
        }

        return redirect()->route('komentar.index', [
            'bookId' => $komentar->book_id,
            'page' => $komentar->page
        ])->with('success', 'Komentar berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
            abort(403, 'Kamu tidak berhak menghapus komentar ini');
        }

        $bookId = $komentar->book_id;
        $page = $komentar->page;
        $namaFile = $komentar->image_path;

        $komentar->delete();

        // HAPUS GAMBAR KOMENTAR DARI STORAGE
        if ($namaFile) {
            $path = preg_replace(
                '#^(public/|storage/)+#',
                '',
                $namaFile
            );

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        return redirect()->route('komentar.index', [
            'bookId' => $bookId,
            'page' => $page
        ])->with('success', 'Komentar berhasil dihapus!');
    }
}
