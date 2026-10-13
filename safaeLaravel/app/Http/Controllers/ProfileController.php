<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Topic;
use App\Models\Comments;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user;

        // 1. PESAN / DISKUSI TERAKHIR FORUM (Bisa dari Komentar/Balasan atau Topik buatan user)
        $latestComment = Comments::where('user_id', $user->id)
            ->with('topic')
            ->latest()
            ->first();

        $latestTopic = Topic::where('user_id', $user->id)
            ->latest()
            ->first();

        $lastForumComment = null;

        // Bandingkan mana aktivitas forum terbaru (Komentar vs Topik Baru)
        if ($latestComment && $latestTopic) {
            if ($latestComment->created_at >= $latestTopic->created_at) {
                $lastForumComment = (object)[
                    'isi' => $latestComment->isi,
                    'created_at' => $latestComment->created_at,
                    'topic_id' => $latestComment->topic_id,
                    'topic' => $latestComment->topic
                ];
            } else {
                $lastForumComment = (object)[
                    'isi' => $latestTopic->isi,
                    'created_at' => $latestTopic->created_at,
                    'topic_id' => $latestTopic->id,
                    'topic' => (object)['judul' => $latestTopic->judul]
                ];
            }
        } elseif ($latestComment) {
            $lastForumComment = (object)[
                'isi' => $latestComment->isi,
                'created_at' => $latestComment->created_at,
                'topic_id' => $latestComment->topic_id,
                'topic' => $latestComment->topic
            ];
        } elseif ($latestTopic) {
            $lastForumComment = (object)[
                'isi' => $latestTopic->isi,
                'created_at' => $latestTopic->created_at,
                'topic_id' => $latestTopic->id,
                'topic' => (object)['judul' => $latestTopic->judul]
            ];
        }

        // 2. DAFTAR BACAAN (Buku yang sedang/pernah dibaca user dari ReadingHistory)
        $readingList = ReadingHistory::where('user_id', $user->id)
            ->whereHas('book')
            ->with('book')
            ->latest('last_read_at')
            ->get()
            ->unique('book_id')
            ->take(6);

        // 3. KARYA SAYA (Buku yang ditulis/diunggah user)
        $myBooks = Book::where('user_id', $user->id)
            ->withCount('chapters')
            ->latest()
            ->get();

        $karyaCount = $myBooks->count();

        return view('profile.show', compact('profile', 'user', 'lastForumComment', 'readingList', 'myBooks', 'karyaCount'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user;

        return view('profile.edit', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'     => 'required|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'jurusan'      => 'nullable|string|max:255',
            'semester'     => 'nullable|string|max:50',
            'bio'          => 'nullable|string',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = $request->file('foto_profil')->store('profile_photos', 'public');
        }

        $user->username     = $request->username;
        $user->social_media = $request->social_media;
        $user->jurusan      = $request->jurusan;
        $user->semester     = $request->semester;
        $user->bio          = $request->bio;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}