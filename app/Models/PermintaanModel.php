<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanModel extends Model
{
    use HasFactory;

    protected $table = 'permintaan';

    protected $primaryKey = 'id_permintaan';

    protected $fillable = [
        'keluhan_kebutuhan',
        'no_aset',
        'tipe_permintaan',
        'status_permintaan',
        'tanggal_permintaan',
        'ttd_requestor',
        'id',
        'id_otorisasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function otorisasi()
    {
        return $this->belongsTo(OtorisasiModel::class, 'id_otorisasi', 'id_otorisasi');
    }

    public function kategoriSoftware()
    {
        return $this->hasOne(KategoriSoftwareModel::class, 'id_kategori', 'id_kategori');
    }
}