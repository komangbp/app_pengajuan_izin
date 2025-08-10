<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Izin;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function createVerifikator(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role' => 'verifikator',
            'is_verified' => true
        ]);

        return response()->json([
            'message' => 'Verifikator dibuat',
            'user' => $user
        ], 201);
    }

    public function changeToVerifikator($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'verifikator';
        $user->is_verified = true;
        $user->save();

        return response()->json([
            'message' => 'User diubah menjadi verifikator',
            'user' => $user
        ]);
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $new = 'password123';
        $user->password = Hash::make($new);
        $user->save();

        return response()->json([
            'message' => 'Password direset',
            'new_password' => $new
        ]);
    }

    public function allIzin()
    {
        $izins = Izin::with('user')->get();
        return response()->json($izins);
    }
}
