<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Izin;

class VerifikatorController extends Controller
{
    public function users(Request $req)
    {
        // filter ?verified=1 atau 0
        $q = User::where('role', 'user');
        if ($req->has('verified')) {
            $v = $req->query('verified') == '1' ? true : false;
            $q->where('is_verified', $v);
        }
        return response()->json($q->get());
    }

    public function verifyUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_verified = true;
        $user->save();
        return response()->json([
            'message' => 'User terverifikasi',
            'user' => $user
        ]);
    }

    public function izins(Request $req)
    {
        // filter status ?status=diajukan/diterima/ditolak/direvisi
        $q = Izin::with('user');
        if ($req->has('status')) {
            $q->where('status', $req->query('status'));
        }
        return response()->json($q->get());
    }

    public function accIzin(Request $req, $id)
    {
        $req->validate(['komentar' => 'nullable|string']);
        $izin = Izin::findOrFail($id);
        if ($izin->status !== 'diajukan' && $izin->status !== 'direvisi') {
            return response()->json([
                'message' => 'Izin sudah diproses'
            ], 400);
        }
        $izin->status = 'diterima';
        $izin->komentar = $req->komentar ?? null;
        $izin->save();
        return response()->json([
            'message' => 'Izin diterima',
            'izin' => $izin
        ]);
    }

    public function tolakIzin(Request $req, $id)
    {
        $req->validate(['komentar' => 'required|string']);
        $izin = Izin::findOrFail($id);
        if ($izin->status !== 'diajukan' && $izin->status !== 'direvisi') {
            return response()->json([
                'message' => 'Izin sudah diproses'
            ], 400);
        }
        $izin->status = 'ditolak';
        $izin->komentar = $req->komentar;
        $izin->save();
        return response()->json([
            'message' => 'Izin ditolak',
            'izin' => $izin
        ]);
    }
}
