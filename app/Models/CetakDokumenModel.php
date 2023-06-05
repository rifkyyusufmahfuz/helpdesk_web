<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CetakDokumenModel extends Model
{
    use HasFactory;

    public function get_bast_by_id_permintaan($id_permintaan)
    {
        return DB::table('bast')
            ->join('permintaan', 'permintaan.id_permintaan', '=', 'bast.id_permintaan')
            ->join('barang', 'barang.kode_barang', '=', 'permintaan.kode_barang')
            ->leftJoin('pegawai as pegawai_menyerahkan', 'bast.yang_menyerahkan', '=', 'pegawai_menyerahkan.nip')
            ->leftJoin('pegawai as pegawai_menerima', 'bast.yang_menerima', '=', 'pegawai_menerima.nip')
            ->leftJoin('stasiun as stasiun_menyerahkan', 'pegawai_menyerahkan.id_stasiun', '=', 'stasiun_menyerahkan.id_stasiun')
            ->leftJoin('stasiun as stasiun_menerima', 'pegawai_menerima.id_stasiun', '=', 'stasiun_menerima.id_stasiun')
            ->where('bast.id_permintaan', $id_permintaan)
            ->select(
                'permintaan.*',
                'bast.*',
                'barang.*',

                //data yang menyerahkan / pihak pertama
                'pegawai_menyerahkan.nip as nip_p1',
                'pegawai_menyerahkan.nama as nama_p1',
                'pegawai_menyerahkan.bagian as bagian_p1',
                'pegawai_menyerahkan.jabatan as jabatan_p1',
                'stasiun_menyerahkan.nama_stasiun as lokasi_p1',

                //data yang menerima / pihak kedua
                'pegawai_menerima.nip as nip_p2',
                'pegawai_menerima.nama as nama_p2',
                'pegawai_menerima.bagian as bagian_p2',
                'pegawai_menerima.jabatan as jabatan_p2',
                'stasiun_menerima.nama_stasiun as lokasi_p2'
            )
            ->get();
    }

    // public function get_software_by_id_permintaan($id_permintaan)
    // {
    //     return DB::table('bast')
    //         ->join('permintaan', 'permintaan.id_permintaan', '=', 'bast.id_permintaan')
    //         ->leftJoin('software', 'software.id_permintaan', '=', 'permintaan.id_permintaan')
    //         ->where('bast.id_permintaan', $id_permintaan)
    //         ->select('software.*')
    //         ->get();
    // }
}
