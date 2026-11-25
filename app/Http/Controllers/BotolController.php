<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BotolController extends Controller
{
    const POIN_PER_BOTOL  = 10;
    const BERAT_PER_BOTOL = 0.05;

    private static function berkas() { return storage_path('app/mesin.json'); }

    private static function kosong()
    {
        return ['layar' => 'awal', 'botol' => 0, 'poin' => 0, 'id_user' => null];
    }

    private static function muat()
    {
        if (! file_exists(self::berkas())) {
            return self::kosong();
        }
        return array_merge(self::kosong(), json_decode(file_get_contents(self::berkas()), true) ?: []);
    }

    private static function tulis($d)
    {
        file_put_contents(self::berkas(), json_encode($d), LOCK_EX);
    }

    public static function mulaiSesi($idUser)
    {
        self::tulis(['layar' => 'botol', 'botol' => 0, 'poin' => 0, 'id_user' => $idUser]);
    }

    public static function resetJikaMilik($idUser)
    {
        if ($idUser !== null && (string) (self::muat()['id_user'] ?? '') === (string) $idUser) {
            self::tulis(self::kosong());
        }
    }

    private function poinAkun()
    {
        return (int) DB::table('akun')->where('id_user', session('akun_id'))->value('poin_tersisa');
    }

    private function kirimData($d)
    {
        return response()->json($d + ['poin_akun' => $this->poinAkun()]);
    }

    public function index()
    {
        return view('mesin', [
            'nama'     => session('akun_nama'),
            'poinAkun' => $this->poinAkun(),
        ]);
    }

    public function data()
    {
        return $this->kirimData(self::muat());
    }

    public function mulai()
    {
        self::mulaiSesi(session('akun_id'));
        return $this->kirimData(self::muat());
    }

    public function status()
    {
        $d = self::muat();
        return response()->json([
            'status' => $d['layar'] === 'botol' ? 'jalan' : 'berhenti',
        ]);
    }

    public function tambah()
    {
        $d = self::muat();
        if ($d['layar'] === 'botol' && $d['botol'] < 99) {
            $d['botol']++;
            $d['poin'] += self::POIN_PER_BOTOL;
            self::tulis($d);
        }
        return response()->json($d);
    }

    public function ambil()
    {
        $d = self::muat();

        if ($d['layar'] !== 'botol' || $d['botol'] < 1) {
            return $this->kirimData($d);
        }

        $idUser = $d['id_user'] ?? session('akun_id');
        $sekarang = now();

        DB::transaction(function () use ($d, $idUser, $sekarang) {
            $idSampah = DB::table('data_sampah')->insertGetId([
                'berat_botol' => round($d['botol'] * self::BERAT_PER_BOTOL, 2),
                'total_botol' => $d['botol'],
                'poin_dapat'  => $d['poin'],
                'waktu_scan'  => $sekarang->toDateString(),
                'status_scan' => 'success',
            ]);

            DB::table('mencatat')->insert([
                'tanggal'      => $sekarang->toDateString(),
                'waktu'        => $sekarang->format('H:i:s'),
                'jumlah_botol' => $d['botol'],
                'id_user'      => $idUser,
                'id_sampah'    => $idSampah,
            ]);

            DB::table('akun')->where('id_user', $idUser)->increment('poin_tersisa', $d['poin']);
            DB::table('akun')->where('id_user', $idUser)->increment('total_poin', $d['poin']);
        });

        // KUNCI: Ubah state ke 'selesai' agar JS menampilkan layar Terima Kasih
        $d['layar'] = 'selesai'; 
        $d['poin_akun'] = $this->poinAkun();
        self::tulis(self::kosong()); // Reset mesin setelah diambil

        return response()->json($d);
    }

    public function batal()
    {
        $d = self::muat();
        $d['layar'] = 'awal';
        $d['botol'] = 0;
        $d['poin'] = 0;
        self::tulis($d);
        
        return response()->json($d);
    }
}