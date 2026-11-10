<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GenreOnboardingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $profilLengkap =
            !empty($user->nama_depan) &&
            !empty($user->nama_belakang) &&
            !empty($user->jurusan) &&
            !empty($user->semester);

        if ($profilLengkap) {
            return redirect()->route('genre.index');
        }

        $genres = Book::where('status', 'approved')
            ->whereNotNull('genre')
            ->where('genre', '!=', '')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        return view('user.onboarding', compact('genres'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',

            'genres' => ['required', 'array', 'size:3'],
            'genres.*' => [
                'required',
                'string',
                'distinct',
                Rule::exists('books', 'genre')->where(function ($query) {
                    $query->where('status', 'approved');
                }),
            ],
        ], [
            'jurusan.required' => 'Silakan isi jurusan terlebih dahulu.',
            'semester.required' => 'Silakan pilih semester.',
            'semester.min' => 'Semester minimal adalah 1.',
            'semester.max' => 'Semester maksimal adalah 14.',
            'genres.required' => 'Silakan pilih 3 genre terlebih dahulu.',
            'genres.size' => 'Kamu harus memilih tepat 3 genre.',
            'genres.*.distinct' => 'Genre tidak boleh dipilih dua kali.',
            'genres.*.exists' => 'Genre yang dipilih tidak tersedia.',
        ]);

        DB::transaction(function () use ($user, $request) {
            $user->update([
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
            ]);

            DB::table('user_genres')
                ->where('user_id', $user->id)
                ->delete();

            foreach ($request->genres as $genre) {
                DB::table('user_genres')->insert([
                    'user_id' => $user->id,
                    'genre' => $genre,
                ]);
            }
        });

        return redirect()
            ->route('genre.index')
            ->with('success', 'Profil dan pilihan genre berhasil dilengkapi!');
    }
}
