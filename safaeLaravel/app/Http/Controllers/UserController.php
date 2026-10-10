<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{   
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }
    //untuk menyimpan hasil akun user yg baru dibuat
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'role'     => 'required|in:user,admin',
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username'    => 'required|string|max:50|unique:users,username,' . $id,
            'role'        => 'required|in:user,admin',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        //ngambil  user dengan id itu dari database
        $user = User::findOrFail($id);

        //ngambil username lama dari db, trs diganti sama username baru yg diisi dari form
        $user->username = $request->username;
        $user->role     = $request->role;

        //upload foto profil
        if ($request->hasFile('foto_profil')) {

            if ($user->foto_profil && file_exists(public_path('storage/' . $user->foto_profil))) {
                unlink(storage_path('app/public/' . $user->foto_profil));
            }

            $file = $request->file('foto_profil');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/foto_profil'), $name);
            
        //ni nyimpen path foto profil ke database sesuai nama file yang sudah ditentukan sebelumnya
            $user->foto_profil = 'foto_profil/' . $name;
            }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
            if ($user->foto_profil && file_exists(public_path('storage/' . $user->foto_profil))) {
                unlink(storage_path('app/public/' . $user->foto_profil));
            }
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
