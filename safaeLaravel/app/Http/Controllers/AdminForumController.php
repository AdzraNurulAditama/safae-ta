<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Comments;

class AdminForumController extends Controller
{
    // =====================================================
    // HALAMAN INDEX ADMIN (LIST SEMUA TOPIK)
    // =====================================================
    public function index()
    {
        $topics = Topic::with(['user', 'comments'])->latest()->get();
        return view('admin.forum.index', compact('topics'));
    }


    // =====================================================
    // DETAIL TOPIK (ADMIN MELIHAT ISI + KOMENTAR)
    // =====================================================
    public function detail($id)
    {
        $topic = Topic::with(['user', 'comments.user'])->findOrFail($id);

        return view('admin.forum.detail', compact('topic'));
    }


    // =====================================================
    // HAPUS SELURUH TOPIK (BESERTA KOMENTAR)
    // =====================================================
    public function hapusTopik($id)
    {
        $topic = Topic::findOrFail($id);

        // hapus semua komentar dulu
        $topic->comments()->delete();

        // hapus topik
        $topic->delete();

        return back()->with('success', 'Topik berhasil dihapus!');
    }


    // =====================================================
    // HAPUS KOMENTAR SATUAN
    // =====================================================
    public function hapusKomentar($id)
    {
        Comments::findOrFail($id)->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }


    // =====================================================
    // HAPUS TOPIK (ROUTE /admin/forum/{id}/delete)
    // =====================================================
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        // hapus komentar
        $topic->comments()->delete();

        // hapus topik
        $topic->delete();

        return redirect()->route('admin.forum.index')
                         ->with('success', 'Topik berhasil dihapus!');
    }
}
