<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KomentarController extends Controller
{

    public function index($bookId, $page)
    {
        $komentar = Komentar::where('book_id', $bookId)->where('page', $page)->orderBy('created_at', 'desc')->get();

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

        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
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
    ]);


    }

    
    public function edit($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
            abort(403);
        }

        return view('books.edit_komentar', ['komentar' => $komentar ]);
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

    
    return redirect()->route('komentar.index', [
        $r->book_id,
        $r->page
    ]);
}


    
    public function hapus($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (Auth::id() != $komentar->user_id) {
            abort(403, 'Kamu tidak berhak menghapus komentar ini');
        }

        if ($komentar->image_path) {
            $path = public_path('uploads/' . $komentar->image_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $komentar->delete();

      return redirect()->route('komentar.index', [
    'book' => $komentar->book_id,
    'page' => $komentar->page
]);

    }
}
