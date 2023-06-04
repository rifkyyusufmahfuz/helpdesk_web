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
            ->leftJoin('pegawai as pegawai_menyerahkan', 'bast.yang_menyerahkan', '=', 'pegawai_menyerahkan.nip')
            ->leftJoin('pegawai as pegawai_menerima', 'bast.yang_menerima', '=', 'pegawai_menerima.nip')
            ->where('bast.id_permintaan', $id_permintaan)
            ->select(
                'permintaan.*',
                'bast.*',
                'pegawai_menyerahkan.nama as nama_menyerahkan',
                'pegawai_menerima.nama as nama_menerima'
            )
            ->get();
    }
}
