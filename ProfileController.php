<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Menggunakan data user yang sedang login, atau dummy admin jika menggunakan sistem single-user sederhana
        $user = Auth::user() ?? (object)[
            'name' => 'Administrator',
            'email' => 'admin@pkbmpunsujaya.sch.id',
            'role' => 'Super Administrator'
        ];

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        // Logika pembaruan profil (bisa disesuaikan dengan tabel users database Anda)
        return back()->with('success', 'Pengaturan akun berhasil diperbarui!');
    }
}