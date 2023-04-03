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

    public function data_pegawai_by_nip($nip)
    {
        return DB::table('pegawai')
            ->where('nip', $nip)
            ->get();
    }
}
