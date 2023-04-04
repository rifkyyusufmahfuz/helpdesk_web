<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiModel extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $primaryKey = 'nip';

    protected $fillable = [
        'nama',
        'bagian',
        'jabatan',
        'lokasi',
    ];

    //
    public function users()
    {
        return $this->hasMany(User::class, 'nip');
    }
}
