<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KomentarController extends Controller
{
    public function index($bookId, $page)
    {
        $komentar = Komentar::where('book_id', $bookId)->where('page', $page)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $komentar
        ], 200);
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

        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
        }

        $user = Auth::user();
        $username = $user->username ?? $user->name ?? 'Anonymous';

        $komentar = Komentar::create([
            'user_id' => $user->id,
            'book_id' => $r->book_id,
            'page' => $r->page,
            'username' => $username,
            'komentar' => $r->komentar,
            'image_path' => $namaFile
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'data' => $komentar
        ], 201);
    }
    public function update(Request $r, $id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() !== $komentar->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak punya akses'
            ], 403);
        }

        $r->validate([
            'komentar' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = $komentar->image_path;

        if ($r->hasFile('image')) {
            if ($namaFile) {
                $path = public_path('uploads/' . $namaFile);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $file = $r->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
        }

        $komentar->update([
            'komentar' => $r->komentar,
            'image_path' => $namaFile
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil diperbarui',
            'data' => $komentar
        ], 200);
    }

    public function hapus($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() !== $komentar->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak punya akses'
            ], 403);
        }

        if ($komentar->image_path) {
            $path = public_path('uploads/' . $komentar->image_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $komentar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus'
        ], 200);
    }
}
