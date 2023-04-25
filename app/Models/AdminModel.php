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
        // return DB::table('permintaan')
        //     ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
        //     ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
        //     ->join('users', 'permintaan.id', '=',  'users.id')
        //     ->select('permintaan.*', 'otorisasi.*', 'kategori_software.*')
        //     ->orderBy('permintaan.updated_at', 'desc')
        //     ->get()
        //     ->toArray();

        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            // Join dengan tabel otorisasi berdasarkan id_otorisasi
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            // Join dengan tabel kategori_software berdasarkan id_kategori
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            // Join dengan tabel users berdasarkan id
            ->join('users', 'permintaan.id', '=', 'users.id')
            // Join dengan tabel roles berdasarkan id_role
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            // Join dengan tabel pegawai berdasarkan nip
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            // Join dengan tabel stasiun berdasarkan id_stasiun
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')

            // Pilih kolom yang ingin ditampilkan
            ->select('permintaan.*', 'otorisasi.*', 'kategori_software.*', 'users.*', 'roles.*', 'pegawai.*', 'stasiun.*')
            // Urutkan data berdasarkan updated_at secara descending
            ->orderBy('permintaan.updated_at', 'desc')
            // Dapatkan semua data sebagai array
            ->get()
            ->toArray();
    }
}
