<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $req)
    {
        $data = $req->validated();
        $user = User::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'  => 'user',
            'is_verified' => false
        ]);

        return response()->json([
            'message' => 'Registrasi sukses. Menunggu verifikasi',
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $user->createToken('api-token', [$user->role])->plainTextToken;

        return response()->json([
            'message' => 'Login sukses',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $req)
    {
        $user = $req->user();
        if ($user) {
            $user->tokens->delete();
        }

        return response()->json([
            'message' => 'Logout sukses'
        ]);
    }
}
