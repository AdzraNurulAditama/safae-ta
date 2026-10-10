<?php

namespace App\Http\Controllers;

use App\Models\ReadingHistory;
use Illuminate\Support\Facades\Auth;

class ReadingHistoryController extends Controller
{
    public function index()
    {
        $histories = ReadingHistory::with('book')
            ->where('user_id', auth::id())
            ->orderBy('last_read_at', 'desc')
            ->get();

        return view('readinghistories.index', [
            'histories' => $histories
        ]);
    }

    public function destroy($id)
    {
        $history = ReadingHistory::where('id', $id)
            ->where('user_id', auth::id())
            ->firstOrFail();

        $history->delete();

        return redirect()->route('reading.history')->with('success', 'Riwayat berhasil dihapus.');
    }
}
