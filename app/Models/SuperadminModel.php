<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuperadminModel extends Model
{
    use HasFactory;

    public function get_data_user()
    {
        return DB::table('users')
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->get();
    }

    public function data_user_lengkap()
    {
        return DB::table('users')
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->select('users.*', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.lokasi', 'roles.nama_role')
            ->get();
    }

    public function get_data_role()
    {
        return DB::table('roles')
            ->get();
    }

    public function hitung_user_by_role()
    {
        $usersByRole = DB::table('users')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->select('roles.nama_role', DB::raw('count(*) as total'))
            ->groupBy('roles.nama_role')
            ->get();

        return $usersByRole;
    }

    public function data_pegawai()
    {
        return DB::table('pegawai')
            ->leftJoin('users', 'pegawai.nip', '=', 'users.nip')
            ->select('pegawai.nip', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.lokasi', 'users.id')
            ->orderBy('pegawai.created_at', 'desc')
            ->get();
    }

    public function data_pegawai_by_nip($nip)
    {
        return DB::table('pegawai')
            ->where('nip', $nip)
            ->get();
    }

    public function get_nip_unregistered()
    {
        // Mengambil NIP dari tabel pegawai yang belum memiliki akun user
        $nip = DB::table('pegawai')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('users')
                    ->whereColumn('users.nip', 'pegawai.nip');
            })
            ->pluck('nip');

        return $nip;
    }

    //Tambah Data User
    public function insert_datauser($data)
    {
        if (DB::table('users')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_datapegawai($data)
    {
        if (DB::table('pegawai')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }
}
