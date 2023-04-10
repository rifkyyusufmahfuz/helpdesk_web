<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function dologin(Request $request)
    {
        // validasi
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {

            // buat ulang session login
            $request->session()->regenerate();

            // cek apakah akun aktif
            if (auth()->user()->status) {
                if (auth()->user()->id_role === 1) { // jika user = superadmin
                    return redirect()->intended('/superadmin');
                } else if (auth()->user()->id_role === 2) { // jika user = admin
                    return redirect()->intended('/admin');
                } else if (auth()->user()->id_role === 3) { // jika user = manager
                    return redirect()->intended('/manager');
                } else if (auth()->user()->id_role === 4) { // Jika user = pegawai
                    return redirect()->intended('/pegawai');
                } else { // jika user tidak memiliki role yang valid
                    return redirect()->intended('/');
                }
            } else {
                // jika akun tidak aktif
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('toast_warning', 'Akun belum aktif, silakan tunggu beberapa saat lagi!');
            }
        }

        // jika email atau password salah
        // kirimkan session error
        return back()->with('toast_error', 'Username atau Password salah!');
    }


    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
