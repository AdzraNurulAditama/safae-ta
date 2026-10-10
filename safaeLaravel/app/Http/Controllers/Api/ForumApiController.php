<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumApiController extends Controller
{
    // =====================
    // GET /api/forum
    // =====================
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Topic::with('user')->latest()->get()
        ]);
    }

    // =====================
    // GET /api/forum/{id}
    // DETAIL + KOMENTAR + BALASAN
    // =====================
    public function show($id)
{
    $topic = Topic::with([
        'user',
        'comments.user' // 🔥 PENTING
    ])->findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $topic
    ]);
}


    // =====================
    // POST /api/forum
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'genre_id' => 'required|exists:genres,id',
            'judul'    => 'required',
            'isi'      => 'required'
        ]);

        $topic = Topic::create([
            'genre_id' => $request->genre_id,
            'user_id'  => $request->user()->id,
            'judul'    => $request->judul,
            'isi'      => $request->isi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Forum berhasil dibuat',
            'data'    => $topic
        ], 201);
    }

    // =====================
    // PUT /api/forum/{id}
    // =====================
    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        if ($topic->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak punya akses'
            ], 403);
        }

        $topic->update($request->only(['judul', 'isi']));

        return response()->json([
            'success' => true,
            'message' => 'Forum berhasil diupdate'
        ]);
    }

    // =====================
    // DELETE /api/forum/{id}
    // =====================
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        if ($topic->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak punya akses'
            ], 403);
        }

        $topic->delete();

        return response()->json([
            'success' => true,
            'message' => 'Forum berhasil dihapus'
        ]);
    }

    // =====================
    // POST /api/forum/comment
    // KOMENTAR & BALASAN
    // =====================
    public function comment(Request $request)
    {
        $request->validate([
            'topic_id'  => 'required|exists:topics,id',
            'isi'       => 'required',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comments::create([
            'topic_id'  => $request->topic_id,
            'user_id'   => $request->user()->id,
            'parent_id' => $request->parent_id, // 🔥 INI PENTING
            'isi'       => $request->isi,
        ]);

        return response()->json([
            'success' => true,
            'data' => $comment
        ], 201);
    }
}
