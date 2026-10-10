<?php

namespace App\Http\Controllers;

use App\Models\FavoriteBook;

class AdminBukuFavoritController extends Controller
{

    public function index()
    {
        $favorites = FavoriteBook::with(['user', 'book'])->get();

        return view('admin.bukufav.index', ['favorites' => $favorites]);
    }

    public function show($id)
    {
        $favorite = FavoriteBook::with(['user', 'book'])->findOrFail($id);

        return view('admin.bukufav.show', ['favorite' => $favorite]);
    }

    public function destroy($id)
    {
        $bukufav = FavoriteBook::findOrFail($id);

        $bukufav->delete();

        return redirect()->route('admin.favorit.index')->with('success', 'Buku favorit user berhasil dihapus');
    }
}
