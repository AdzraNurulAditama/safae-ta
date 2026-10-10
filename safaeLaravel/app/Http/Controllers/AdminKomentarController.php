<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Support\Facades\File;

class AdminKomentarController extends Controller
{

    public function index()
    {
        $komentar = Komentar::with('user', 'book')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.komentar.index', ['komentar' => $komentar]);
    }

  
    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);

        if (!empty($komentar->image_path)) {
            $path = public_path('uploads/' . $komentar->image_path);

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $komentar->delete();

        return redirect()->route('admin.komentar.index')->with('success', 'Komentar berhasil dihapus');
    }
}
