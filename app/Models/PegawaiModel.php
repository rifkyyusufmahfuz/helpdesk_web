<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

    //Relasi
    public function users()
    {
        return $this->hasMany(User::class, 'nip');
    }
    //Relasi
    public function stasiun()
    {
        return $this->belongsTo(StasiunModel::class, 'id_stasiun');
    }

    // fungsi-fungsi

    public function get_permintaan_software_by_id($id)
    {
        return DB::table('permintaan')->where('id', $id)->get();
    }


    public function simpan_permintaan_software(Request $request)
    {

        //definisi untuk simpan kategori
        $os = 0;
        $mo = 0;
        $sd = 0;
        $sl = 0;

        if ($request->has('os')) {
            $os++;
        }
        if ($request->has('mo')) {
            $mo++;
        }
        if ($request->has('sd')) {
            $sd++;
        }
        if ($request->has('sl')) {
            $sl++;
        }

        // simpan ke table kategori
        DB::table('kategori_software')->insert([
            'operating_system' => $os,
            'microsoft_office' => $mo,
            'software_design' => $sd,
            'software_lainnya' => $sl
        ]);


        // ambil kode id_kategori untuk disimpan di table permintaan
        $id_cat = KategoriSoftwareModel::orderBy('id_kategori', 'desc')->limit(1)->pluck('id_kategori')->first();

        //fungsi untuk simpan ke table otorisasi

        // mengambil record terbaru dan nilai id_otorisasi tertinggi
        $latestOtorisasi = DB::table('otorisasi')->orderByDesc('id_otorisasi')->first();

        // mengambil nilai id_otorisasi dari record terbaru jika tersedia, jika tidak ada set nilai id_otorisasi menjadi 1
        $newIdOtorisasi = $latestOtorisasi ? $latestOtorisasi->id_otorisasi + 1 : 1;

        // simpan data baru ke tabel otorisasi dengan nilai id_otorisasi yang baru
        DB::table('otorisasi')->insert([
            'id_otorisasi' => $newIdOtorisasi,
            'tanggal_approval' => null,
            'status_approval' => 'pending',
            'catatan' => '',
            'id' => null,
        ]);

        //Tanda tangan
        $folderPath = public_path('tandatangan/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        // $file = $folderPath . uniqid() . '.'.$image_type;
        $filename = uniqid() . '.' . $image_type;
        $file = $folderPath . $filename;

        file_put_contents($file, $image_base64);

        // simpan ke table permintaan
        $now = now();
        $id = auth()->user()->id;

        DB::table('permintaan')->insert([
            'id_kategori' => $id_cat,
            'no_aset' => $request->input('no_aset'),
            'keluhan_kebutuhan' => $request->input('uraian_kebutuhan'),
            'tipe_permintaan' => "software",
            'status_permintaan' => 1,
            'tanggal_permintaan' => $now,
            'id' => $id,
            'id_otorisasi' => $newIdOtorisasi,
            'ttd_requestor' => $filename,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        if (DB::getPdo()->lastInsertId()) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataRequest($id)
    {
        //
    }
}
