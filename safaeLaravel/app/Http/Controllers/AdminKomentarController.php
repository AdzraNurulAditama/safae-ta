<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKomentarController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = Komentar::with(['user', 'book']);

        // SEARCH HANYA BERDASARKAN USERNAME
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('username', 'like', '%' . $search . '%');
                })
                ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $komentar = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalKomentar = Komentar::count();
        $totalPengguna = Komentar::whereNotNull('user_id')
            ->distinct()
            ->count('user_id');

        return view('admin.komentar.index', compact(
            'komentar',
            'totalKomentar',
            'totalPengguna',
            'search'
        ));
    }

    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);
        $gambar = $komentar->image_path;

        // HAPUS KOMENTAR DARI DATABASE
        $komentar->delete();

        // HAPUS GAMBAR DARI STORAGE
        if ($gambar) {
            $path = preg_replace(
                '#^(public/|storage/)+#',
                '',
                $gambar
            );

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        return redirect()
            ->route('admin.komentar.index', request()->only('search', 'page'))
            ->with('success', 'Komentar berhasil dihapus!');
    }
}
