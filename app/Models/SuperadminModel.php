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

    public function hitung_semua_user()
    {
        return DB::table('users')
            ->count();
    }

    public function get_user_by_id($id)
    {
        $user = DB::table('users')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->select('users.id', 'users.email', 'users.id_role', 'roles.nama_role', 'pegawai.nama', 'pegawai.nip', 'pegawai.bagian', 'pegawai.jabatan')
            ->where('users.id', '=', $id)
            ->first();
        return $user;
    }

    public function get_user_by_id2($id)
    {
        return DB::table('users')
            ->where('id', $id)
            ->first();
    }

    public function data_user_lengkap()
    {
        return DB::table('users')
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->select('users.*', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.id_stasiun', 'roles.nama_role')
            ->get();
    }

    public function data_user_aktif()
    {
        return DB::table('users')
            ->where('status', '=', true)
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->select('users.*', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.id_stasiun', 'roles.nama_role')
            // order by kolom updated_at
            ->orderBy('updated_at', 'desc')
            ->get();
    }


    public function hitung_data_user_aktif()
    {
        return DB::table('users')
            ->where('status', '=', true)
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->select('users.*', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.id_stasiun', 'roles.nama_role')
            ->count();
    }

    public function data_user_nonaktif()
    {
        return DB::table('users')
            ->where('status', '=', false)
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->select('users.*', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.id_stasiun', 'roles.nama_role')
            // order by kolom updated_at
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function hitung_data_user_nonaktif()
    {
        return DB::table('users')
            ->where('status', '=', false)
            ->leftJoin('pegawai', 'pegawai.nip', '=', 'users.nip')
            ->leftJoin('roles', 'roles.id_role', '=', 'users.id_role')
            ->select('users.*', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.id_stasiun', 'roles.nama_role')
            ->count();
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
            ->leftJoin('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->select('pegawai.nip', 'pegawai.nama', 'pegawai.bagian', 'pegawai.jabatan', 'pegawai.id_stasiun', 'users.id', 'users.status', 'stasiun.id_stasiun', 'stasiun.nama_stasiun')
            ->orderBy('pegawai.updated_at', 'desc')
            ->get();
    }

    public function data_stasiun()
    {
        return DB::table('stasiun')
            ->get();
    }

    public function getIdStasiun($nama_stasiun)
    {
        $stasiun = DB::table('stasiun')->where('nama_stasiun', $nama_stasiun)->first();
        if ($stasiun) {
            return $stasiun->id_stasiun;
        } else {
            return null;
        }
    }

    public function data_pegawai_by_nip($nip)
    {
        $pegawai = DB::table('pegawai')
            ->leftJoin('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->where('nip', $nip)
            ->first();

        if ($pegawai) {
            return [
                'nama' => $pegawai->nama,
                'bagian' => $pegawai->bagian,
                'jabatan' => $pegawai->jabatan,
                'lokasi' => DB::table('stasiun')->where('id_stasiun', $pegawai->id_stasiun)->value('nama_stasiun')
            ];
        } else {
            return null;
        }
    }

    public function get_data_pegawai($nip)
    {
        return DB::table('pegawai')->where('nip', $nip)->first();
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
            ->pluck('nip')
            ->toArray();

        return $nip;
    }


    //Tambah Data User baru
    public function insert_datauser($data_user)
    {
        if (DB::table('users')->insert($data_user)) {
            return true;
        } else {
            return false;
        }
    }

    //Tambah data pegawai baru
    public function insert_datapegawai($data)
    {
        if (DB::table('pegawai')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }


    // Update data user
    public function update_user($data, $id)
    {
        if (DB::table('users')->where('id', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    // update data pegawai
    public function update_pegawai($data, $id)
    {
        if (DB::table('pegawai')->where('nip', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    // hapus data pegawai
    public function delete_datapegawai($id)
    {
        if (DB::table('pegawai')->where('nip', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function input_notifikasi($notifikasi)
    {
        return DB::table('notifikasi')->insert($notifikasi) ? true : false;
    }
}
