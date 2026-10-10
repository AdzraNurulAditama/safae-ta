<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    // Tampilkan halaman Contact Us
    public function index()
    {
        return view('contact.index'); // ← disesuaikan
    }

    // Proses kirim pesan
    public function store(Request $request)
    {
        // Validasi form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:5',
        ]);

        // Simpan ke database
        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        // Redirect balik dengan pesan sukses
        return back()->with('success', 'Pesanmu sudah terkirim! Terima kasih telah menghubungi kami.');
    }
}
