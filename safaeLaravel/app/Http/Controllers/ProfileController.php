<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    
    public function show()
    {
        return view('profile.show', [
            'profile' => Auth::user()
        ]); 
    }

    public function edit()
    {
        return view('profile.edit', [
            'profile' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'username'    => 'required',
            'social_media'=> 'nullable',
            'bio'         => 'nullable',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        //buat nyimpen path foto lama milik user yang sedang login dari database, supaya kalau user tidak meng-update foto profil, data foto lamanya tetap dipakai dan tidak ke-reset.
        $fotoPath = Auth::user()->foto_profil;

        // upload foto profil
        if ($request->hasFile('foto_profil')) {

            // hapus foto lama
            if ($fotoPath && file_exists(public_path('storage/' . $fotoPath))) {
                unlink(public_path('storage/' . $fotoPath));
            }

            $file = $request->file('foto_profil');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/foto_profil'), $name);

            //ngeganti dengan foto baru yg dmn fotonya itu diambil dr folder foto_profil
            $fotoPath = 'foto_profil/' . $name;
        }

        User::where('id', Auth::id())->update([
            'username'     => $request->username,
            'social_media' => $request->social_media,
            'bio'          => $request->bio,
            'foto_profil'  => $fotoPath,
        ]);

        return redirect('/profile')->with('success', 'Profil berhasil diperbarui');
    }

}
