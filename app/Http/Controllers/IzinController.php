<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIzinRequest;
use App\Http\Requests\UpdateIzinRequest;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Hash;

class IzinController extends Controller
{
    public function store(StoreIzinRequest $req)
    {
        $user = $req->user();

        if (!$user->is_verified) {
            return response()->json([
                'message' => 'Akun belum terverifikasi'
            ], 403);
        }

        $data = $req->validated();
        $izin = Izin::create([
            'user_id' => $user->id,
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'status' => 'diajukan'
        ]);

        return response()->json([
            'message' => 'Izin diajukan',
            'izin' => $izin
        ], 201);
    }

    public function index(Request $req)
    {
        $user = $req->user();
        // list izin milik user
        $izins = $user->izins()->get();
        return response()->json($izins);
    }

    public function show(Request $req, $id)
    {
        $izin = Izin::with('user')->findOrFail($id);
        if ($req->user()->id !== $izin->user_id && $req->user()->role !== 'admin' && $req->user()->role !== 'verifikator') {
            return response()->json([
                'message' => 'Akses ditolak'
            ], 403);
        }
        return response()->json($izin);
    }

    public function update(UpdateIzinRequest $req, $id)
    {
        $izin = Izin::findOrFail($id);
        if ($req->user()->id !== $izin->user_id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ], 403);
        }
        if ($izin->status !== 'diajukan' && $izin->status !== 'direvisi') {
            return response()->json([
                'message' => 'Tidak dapat mengubah, izin sudah diproses'
            ], 400);
        }
        $izin->update($req->validated());
        return response()->json([
            'message' => 'Izin diperbarui',
            'izin' => $izin
        ]);
    }

    public function cancel(Request $req, $id)
    {
        $izin = Izin::findOrFail($id);
        if ($req->user()->id !== $izin->user_id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ], 403);
        }
        if ($izin->status !== 'diajukan') {
            return response()->json([
                'message' => 'Hanya izin status diajukan yang bisa dibatalkan'
            ], 400);
        }
        $izin->is_canceled = true;
        $izin->save();
        return response()->json([
            'message' => 'Izin dibatalkan',
            'izin' => $izin
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $izin = Izin::findOrFail($id);
        if ($req->user()->id !== $izin->user_id && $req->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak'
            ], 403);
        }
        $izin->delete();
        return response()->json([
            'message' => 'Izin dihapus'
        ]);
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = $req->user();
        if (!Hash::check($req->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password sekarang salah'
            ], 400);
        }

        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            'message' => 'Password diperbarui'
        ]);
    }
}
