<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        $users = User::select(
            'id',
            'username',
            'social_media',
            'foto_profil'
        )->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $u = User::select(
            'id',
            'username',
            'social_media',
            'foto_profil'
        )->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $u->id,
                'username' => $u->username,
                'social_media' => $u->social_media,
                'foto_profil' => $u->foto_profil ?? '',
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username'     => 'required|string|max:50|unique:users,username,' . $id,
            'social_media' => 'nullable|string|max:100',
            'foto_profil'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->username = $request->username;
        $user->social_media = $request->social_media;

        if ($request->hasFile('foto_profil')) {

            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')
                ->store('foto_profil', 'public');

            $user->foto_profil = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'social_media' => $user->social_media,
                'foto_profil' => $user->foto_profil ?? '',
            ]
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
