<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreAdminController extends Controller
{
    private $genre_options = [
        'Pemrograman',
        'Novel',
        'Hobi',
        'Horror',
        'Romance',
        'Action',
        'Komedi',
        'Sci-Fi',
        'Fiksi',
        'Mystery'
    ];

    public function daftarBuku(Request $request)
    {
        $semua_genre = Book::where('status', 'approved')
            ->select('genre')
            ->distinct()
            ->pluck('genre');

        $filter_genre = $request->input('genre');

        $query_buku = Book::where('status', 'approved')
            ->orderBy('created_at', 'desc');

        $buku_tampil = collect();
        $buku_per_genre = collect();

        if (!empty($filter_genre)) {

            $buku_tampil = $query_buku
                ->where('genre', $filter_genre)
                ->paginate(8);

        } else {

            $semua_buku = $query_buku->get();

            $buku_per_genre = $semua_buku->groupBy('genre');
        }

        return view('admin.books.genre', [
            'all_genres' => $semua_genre,
            'current_genre' => $filter_genre,
            'books_to_show' => $buku_tampil,
            'grouped_books' => $buku_per_genre,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN TAMBAH
    |--------------------------------------------------------------------------
    */
    public function halamanTambah()
    {
        return view('admin.books.create-book', [
            'genre_options' => $this->genre_options
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN BUKU
    |--------------------------------------------------------------------------
    */
    public function simpanBuku(Request $request)
    {
        $data_valid = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('covers', 'public');

            $data_valid['image_path'] = '/storage/' . $path;
        }

        $data_valid['status'] = 'approved';

        Book::create($data_valid);

        return redirect('/admin/genre')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL BUKU
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $buku = Book::findOrFail($id);

        $arrayKonten = explode("\n", $buku->content);

        $itemPerHalaman = 20;

        $dataPaginasi = new LengthAwarePaginator(
            collect($arrayKonten)->forPage(
                request()->get('page', 1),
                $itemPerHalaman
            ),
            count($arrayKonten),
            $itemPerHalaman,
            request()->get('page', 1),
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        $kontenAkhir = nl2br(
            e(
                implode("\n", $dataPaginasi->items())
            )
        );

        return view('admin.books.show-book', [
            'book' => $buku,
            'paginatedData' => $dataPaginasi,
            'finalContent' => $kontenAkhir,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN EDIT
    |--------------------------------------------------------------------------
    */
    public function halamanEdit($id)
    {
        $buku = Book::findOrFail($id);

        return view('admin.books.edit', [
            'book' => $buku,
            'genre_options' => $this->genre_options
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE BUKU
    |--------------------------------------------------------------------------
    */
    public function perbaruiBuku(Request $request, $id)
    {
        $buku = Book::findOrFail($id);

        $data_valid = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($buku->image_path) {

                $path_lama = str_replace(
                    '/storage/',
                    '',
                    $buku->image_path
                );

                Storage::disk('public')->delete($path_lama);
            }

            $path = $request->file('image')->store('covers', 'public');

            $data_valid['image_path'] = '/storage/' . $path;
        }

        $buku->update($data_valid);

        return redirect('/admin/genre?genre=' . urlencode($request->genre))
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS BUKU
    |--------------------------------------------------------------------------
    */
    public function hapusBuku(Request $request)
    {
        $buku = Book::findOrFail($request->id);

        if ($buku->image_path) {

            $path_gambar = str_replace(
                '/storage/',
                '',
                $buku->image_path
            );

            Storage::disk('public')->delete($path_gambar);
        }

        $buku->delete();

        return back()->with(
            'success',
            'Buku berhasil dihapus permanen dari database!'
        );
    }
}