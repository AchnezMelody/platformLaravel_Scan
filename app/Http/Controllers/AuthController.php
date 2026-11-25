<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /** Layar "Mulai" (sebelum login). Sesi pengguna sebelumnya selalu diakhiri di sini. */
    public function beranda(Request $request)
    {
        BotolController::resetJikaMilik($request->session()->get('akun_id'));
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('mulai');
    }

    public function form(Request $request)
    {
        if ($request->session()->has('akun_id')) {
            return redirect('/mesin');
        }

        return view('login');
    }

    public function masuk(Request $request)
    {
        $data = $request->validate([
            'id_user'  => 'required|string',
            'password' => 'required|string',
        ], [
            'id_user.required'  => 'ID User / email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // batasi percobaan: 5x per menit
        $kunci = Str::lower($data['id_user']) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($kunci, 5)) {
            $detik = RateLimiter::availableIn($kunci);
            return back()->withErrors(['id_user' => "Terlalu banyak percobaan. Coba lagi dalam $detik detik."])
                         ->onlyInput('id_user');
        }

        $akun = DB::table('akun')
            ->where('id_user', $data['id_user'])
            ->orWhere('email', $data['id_user'])
            ->first();

        if (! $akun || ! Hash::check($data['password'], $akun->password)) {
            RateLimiter::hit($kunci, 60);
            return back()->withErrors(['id_user' => 'ID User/email atau password salah.'])
                         ->onlyInput('id_user');
        }

        if ($akun->role !== 'warga') {
            return back()->withErrors(['id_user' => 'Akun ini bukan akun warga, tidak bisa memakai mesin penukaran.'])
                         ->onlyInput('id_user');
        }

        RateLimiter::clear($kunci);
        $request->session()->regenerate();
        $request->session()->put([
            'akun_id'   => $akun->id_user,
            'akun_nama' => $akun->nama,
        ]);

        // login berhasil -> langsung ke layar "Masukkan Botol"
        BotolController::mulaiSesi($akun->id_user);

        return redirect('/mesin');
    }

    public function keluar(Request $request)
    {
        BotolController::resetJikaMilik($request->session()->get('akun_id'));
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
