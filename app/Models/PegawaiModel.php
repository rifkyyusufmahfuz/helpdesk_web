<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $category = new KategoriSoftwareModel();
        $category->operating_system = $os;
        $category->microsoft_office = $mo;
        $category->software_design = $sd;
        $category->software_lainnya = $sl;
        $category->save();

        // ambil kode id_kategori untuk disimpan di table permintaan
        $id_cat = KategoriSoftwareModel::orderBy('id_kategori', 'desc')->limit(1)->pluck('id_kategori')->first();


        // mengambil record terbaru dan nilai id_otorisasi tertinggi
        $latestOtorisasi = OtorisasiModel::orderByDesc('id_otorisasi')->first();

        // mengambil nilai id_otorisasi dari record terbaru jika tersedia, jika tidak ada set nilai id_otorisasi menjadi 1
        $newIdOtorisasi = $latestOtorisasi ? $latestOtorisasi->id_otorisasi + 1 : 1;

        // simpan data baru ke tabel otorisasi dengan nilai id_otorisasi yang baru
        $otorisasi = new OtorisasiModel();
        $otorisasi->id_otorisasi = $newIdOtorisasi;
        $otorisasi->tanggal_approval = null;
        $otorisasi->status_approval = 'pending';
        $otorisasi->catatan = '';
        $otorisasi->id = null;
        $otorisasi->save();

        //Tanda tangan
        $folderPath = public_path('tandatangan/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        // $file = $folderPath . uniqid() . '.'.$image_type;
        $filename = uniqid() . '.'.$image_type;
        $file = $folderPath . $filename;

        file_put_contents($file, $image_base64);

        // simpan ke table permintaan
        $permintaan = new PermintaanModel();
        // $permintaan->nip = $request->input('nip');
        $permintaan->id_kategori = $id_cat;
        $permintaan->no_aset = $request->input('no_aset');
        $permintaan->keluhan_kebutuhan = $request->input('uraian_kebutuhan');
        $permintaan->tipe_permintaan = "software";
        $permintaan->status_permintaan = "pending";
        $permintaan->tanggal_permintaan = now();
        $permintaan->id = auth()->user()->id;
        $permintaan->id_otorisasi = $newIdOtorisasi; // menetapkan nilai id_otorisasi di PermintaanModel
        // tambahkan kode berikut untuk menyimpan tanda tangan
        $permintaan->ttd_requestor = $filename;

        $permintaan->save();

        if ($permintaan->save()) {
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
