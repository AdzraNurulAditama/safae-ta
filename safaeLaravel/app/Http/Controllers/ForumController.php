<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Genre;
use App\Models\Comment;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function __construct()
{
    // Semua method kecuali index & detail harus login
    $this->middleware('auth')->except(['index', 'detail']);
}


    public function index(Request $r)
{
    $genres = Genre::all();
    $selectedGenre = $r->genre_id;

    $topics = $selectedGenre
        ? Topic::where('genre_id', $selectedGenre)->with('user')->latest()->get()
        : collect();

    return view('forum.index', [
        'genres' => $genres,
        'topics' => $topics,
        'currentGenre' => $selectedGenre ? Genre::find($selectedGenre) : null,
        'selectedGenre' => $selectedGenre
    ]);
}

    public function create($genre_id)
{
    $genre = Genre::findOrFail($genre_id);

    return view('forum.create', [
        'genre_id' => $genre_id,
        'genre_name' => $genre->nama_genre
    ]);
}

    public function detail($id)
{
    $topic = Topic::with('user', 'comments.user')->findOrFail($id);

    return view('forum.detail', compact('topic'));
}


    public function store(Request $r)
{
    $r->validate([
        'genre_id' => 'required',
        'judul' => 'required',
        'isi' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'file' => 'nullable|mimes:pdf,doc,docx|max:5120'
    ]);

    $data = $r->only(['genre_id', 'judul', 'isi']);
    $data['user_id'] = Auth::id();

    $data['gambar'] = $this->uploadFile($r, 'gambar');
    $data['file'] = $this->uploadFile($r, 'file');

    // 🔥 SIMPAN KE VARIABEL
    $topic = Topic::create($data);

    // 🔔 BUAT NOTIFIKASI
    \App\Models\Notification::create([
    'user_id' => Auth::id(),
    'title'   => 'Forum',
    'message' => 'Topik "' . $topic->judul . '" berhasil dibuat',
    'url'     => route('forum.detail', $topic->id)
]);

    return redirect()->route('forum.index', ['genre_id' => $r->genre_id])
        ->with('success', 'Topik berhasil dibuat!');
}


    public function comment(Request $r)
    {
        $r->validate([
            'topic_id' => 'required',
            'isi' => 'required'
        ]);

        Comments::create([
            'topic_id' => $r->topic_id,
            'user_id' => Auth::id(),
            'isi' => $r->isi
        ]);

        return back();
    }

    public function edit($id)
    {
        return view('forum.edit', [
            'topic' => Topic::findOrFail($id)
        ]);
    }

    public function update(Request $r, $id)
    {
        $topic = Topic::findOrFail($id);

        $topic->update($r->only(['judul', 'isi']));

        if ($file = $this->uploadFile($r, 'gambar', $topic->gambar)) {
            $topic->update(['gambar' => $file]);
        }

        if ($file = $this->uploadFile($r, 'file', $topic->file)) {
            $topic->update(['file' => $file]);
        }

        return redirect()->route('forum.detail', $id)
            ->with('success', 'Topik berhasil diupdate!');
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        if (Auth::id() == $topic->user_id) {

            $this->deleteFile($topic->gambar);
            $this->deleteFile($topic->file);

            $topic->delete();
        }

        return redirect()->route('forum.index')
            ->with('success', 'Topik berhasil dihapus!');
    }



    private function uploadFile(Request $r, $key, $oldFile = null)
    {
        if (!$r->hasFile($key)) return null;

        if ($oldFile) $this->deleteFile($oldFile);

        $fileName = time() . '_' . $r->file($key)->getClientOriginalName();
        $r->file($key)->move(public_path('uploads/topics'), $fileName);

        return $fileName;
    }

    private function deleteFile($file)
    {
        if ($file && file_exists(public_path('uploads/topics/' . $file))) {
            unlink(public_path('uploads/topics/' . $file));
        }
    }
}
