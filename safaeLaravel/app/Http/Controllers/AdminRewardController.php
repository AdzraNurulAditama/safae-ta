<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\PointHistory;
use Illuminate\Http\Request;

class AdminRewardController extends Controller
{
  
    public function index()
    {
        $users = User::where('role', 'user')->orderBy('points', 'desc')->get();

        return view('admin.rewards.index', ['users' => $users]);
    }

    // tambah point

    public function add(Request $request, User $user)
    {
        $request->validate(['points' => 'required|integer|min:1']);

        $user->points = $user->points + $request->points;
        $user->save();
        
        PointHistory::Create(
    [
        'user_id' => $user->id,
        'points' => $request->points,
    ]
);


        return redirect('/rewards')->with('success', 'Poin berhasil ditambahkan');
    }

   // kurangi point
    public function remove(Request $request, User $user)
    {
        $request->validate(['points' => 'required|integer|min:1']);

       
        $user->points = $user->points - $request->points;

        if ($user->points < 0) {
            $user->points = 0;
        }

        $user->save();

        PointHistory::Create(
    [
        'user_id' => $user->id,
        'points' => $request->points,
    ]
);


        return back()->with('success', 'Poin berhasil dikurangi');
    }
}
