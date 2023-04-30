<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    use HasFactory;

    public function get_permintaan_software()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->select('permintaan.*', 'otorisasi.*', 'kategori_software.*', 'users.*', 'roles.*', 'pegawai.*', 'stasiun.*')
            ->orderBy('permintaan.updated_at', 'desc')
            ->get()
            ->toArray();
    }

    public function get_permintaan_software_by_id($id_permintaan)
    {
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->select('permintaan.*', 'otorisasi.*', 'kategori_software.*', 'users.*', 'roles.*', 'pegawai.*', 'stasiun.*')
            ->where('permintaan.id_permintaan', '=', $id_permintaan)
            ->orderBy('permintaan.updated_at', 'desc')
            ->get();
    }

    public function get_software_by_id($id_permintaan)
    {
        return DB::table('software')
            ->where('id_permintaan', '=', $id_permintaan)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function input_software($data)
    {

        if (DB::table('software')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function hapus_software($id)
    {
        if (DB::table('software')->where('id_software', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }
}
