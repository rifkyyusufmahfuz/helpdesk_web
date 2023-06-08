<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ManagerModel extends Model
{
    use HasFactory;


    public function get_data_permintaan()
    {
        return DB::table('permintaan')->get();
    }

    public function get_permintaan_software_by_otorisasi()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            // ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->join('tindak_lanjut', 'permintaan.id_permintaan', '=', 'tindak_lanjut.id_permintaan')
            ->join('users AS users_admin', 'tindak_lanjut.id', '=', 'users_admin.id')
            ->join('pegawai AS pegawai_admin', 'users_admin.nip', '=', 'pegawai_admin.nip')
            ->join('stasiun AS stasiun_admin', 'pegawai_admin.id_stasiun', '=', 'stasiun_admin.id_stasiun')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                // 'software.*',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
                'tindak_lanjut.*',
                'users_admin.nip AS nip_admin',
                'pegawai_admin.nama AS nama_admin',
                'pegawai_admin.bagian AS bagian_admin',
                'pegawai_admin.jabatan AS jabatan_admin',
                'stasiun_admin.nama_stasiun AS lokasi_admin'
            )
            ->where('status_approval', '=', 'waiting')
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }

    public function get_permintaan_revisi()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            // ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->join('tindak_lanjut', 'permintaan.id_permintaan', '=', 'tindak_lanjut.id_permintaan')
            ->join('users AS users_admin', 'tindak_lanjut.id', '=', 'users_admin.id')
            ->join('pegawai AS pegawai_admin', 'users_admin.nip', '=', 'pegawai_admin.nip')
            ->join('stasiun AS stasiun_admin', 'pegawai_admin.id_stasiun', '=', 'stasiun_admin.id_stasiun')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                // 'software.*',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
                'tindak_lanjut.*',
                'users_admin.nip AS nip_admin',
                'pegawai_admin.nama AS nama_admin',
                'pegawai_admin.bagian AS bagian_admin',
                'pegawai_admin.jabatan AS jabatan_admin',
                'stasiun_admin.nama_stasiun AS lokasi_admin'
            )
            ->where('status_approval', '=', 'revision')
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }

    public function get_list_software()
    {
        return DB::table('permintaan')
            ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->select(
                'permintaan.*',
                'software.*',
            )
            ->get();
    }

    public function get_admin_by_id_tindaklanjut($id_permintaan)
    {
        return DB::table('tindak_lanjut')
            ->where('id_permintaan', $id_permintaan)
            ->select('id')
            ->first();
    }

    public function update_otorisasi($data, $id_otorisasi)
    {
        return DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update($data) ? true : false;
    }

    public function input_notifikasi($notifikasi)
    {
        return DB::table('notifikasi')->insert($notifikasi) ? true : false;
    }
}
