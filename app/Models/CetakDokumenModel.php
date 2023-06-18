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
            ->where('jenis_bast', 'barang_masuk')

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

    public function get_bast_by_id_permintaan_2($id_permintaan)
    {
        return DB::table('bast')
            ->join('permintaan', 'permintaan.id_permintaan', '=', 'bast.id_permintaan')
            ->join('barang', 'barang.kode_barang', '=', 'permintaan.kode_barang')
            ->leftJoin('pegawai as pegawai_menyerahkan', 'bast.yang_menyerahkan', '=', 'pegawai_menyerahkan.nip')
            ->leftJoin('pegawai as pegawai_menerima', 'bast.yang_menerima', '=', 'pegawai_menerima.nip')
            ->leftJoin('stasiun as stasiun_menyerahkan', 'pegawai_menyerahkan.id_stasiun', '=', 'stasiun_menyerahkan.id_stasiun')
            ->leftJoin('stasiun as stasiun_menerima', 'pegawai_menerima.id_stasiun', '=', 'stasiun_menerima.id_stasiun')
            ->where('bast.id_permintaan', $id_permintaan)
            ->where('jenis_bast', 'barang_keluar')

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

    public function get_table_permintaan_by_id($id_permintaan)
    {
        return DB::table('permintaan')
            ->join('users', 'users.id', '=', 'permintaan.id')
            ->join('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->where('id_permintaan', $id_permintaan)
            ->select(
                'permintaan.*',
                'users.*',
                'pegawai.*',
            )
            ->first();
    }

    public function get_pegawai_by_nip($get_nip)
    {
        return DB::table('pegawai')->where('nip', $get_nip)->first();
    }

    public function get_kategori_by_id_kategori($get_id_kategori)
    {
        return DB::table('kategori_software')->where('id_kategori', $get_id_kategori)->first();
    }

    public function get_software_by_id_permintaan($id_permintaan)
    {
        return DB::table('software')->where('id_permintaan', $id_permintaan)->get();
    }

    public function get_otorisasi_by_id_otorisasi($id_otorisasi)
    {
        return DB::table('otorisasi')
            ->join('users', 'users.id', '=', 'otorisasi.id')
            ->join('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->select(
                'otorisasi.*',
                'users.*',
                'pegawai.*',
            )
            ->where('id_otorisasi', $id_otorisasi)
            ->first();
    }

    public function get_tindak_lanjut_by_id_permintaan($id_permintaan)
    {
        return DB::table('tindak_lanjut')
            ->join('users', 'users.id', '=', 'tindak_lanjut.id')
            ->join('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->where('id_permintaan', $id_permintaan)
            ->select(
                'tindak_lanjut.*',
                'users.*',
                'pegawai.*',
            )
            ->first();
    }

    public function get_data_admin($get_nip_tindak_lanjut)
    {
        return DB::table('pegawai')->where('nip', $get_nip_tindak_lanjut)->first();
    }

    public function get_hardware_by_id_permintaan($id_permintaan)
    {
        return DB::table('hardware')->where('id_permintaan', $id_permintaan)->get();
    }
}
