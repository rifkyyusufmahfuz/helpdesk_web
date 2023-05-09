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
        $simpan_kategori = DB::table('kategori_software')->insert([
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
        $simpan_otorisasi = DB::table('otorisasi')->insert([
            'id_otorisasi' => $newIdOtorisasi,
            'tanggal_approval' => null,
            'status_approval' => 'pending',
            'catatan' => '',
            'id' => null,
            'created_at' => now()
        ]);

        //Tanda tangan
        $folderPath = public_path('tandatangan/requestor/');
        if (!is_dir($folderPath)) {
            //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
            mkdir($folderPath, 0777, true);
        }

        $filename = "requestor_" . uniqid() . ".png";
        $nama_file = $folderPath . $filename;
        file_put_contents($nama_file, file_get_contents($request->input('signature')));


        //fungsi untuk simpan ke table barang
        $kode_barang = $request->input('kode_barang');

        // cek apakah kode_barang sudah ada di dalam tabel
        $count = DB::table('barang')->where('kode_barang', $kode_barang)->count();

        if ($count > 0) {
            // jika sudah ada, update data barang yang sudah ada
            $simpan_barang = DB::table('barang')
                ->where('kode_barang', $kode_barang)
                ->update([
                    'nama_barang' => $request->input('nama_barang'),
                    'prosesor' => $request->input('prosesor'),
                    'ram' => $request->input('ram'),
                    'penyimpanan' => $request->input('penyimpanan'),
                    'status_barang' => 1,
                    'jumlah_barang' => 1,
                    'updated_at' => now()
                ]);
        } else {
            // jika belum ada, simpan data
            $simpan_barang = DB::table('barang')->insert([
                'kode_barang' => $kode_barang,
                'nama_barang' => $request->input('nama_barang'),
                'prosesor' => $request->input('prosesor'),
                'ram' => $request->input('ram'),
                'penyimpanan' => $request->input('penyimpanan'),
                'status_barang' => 1,
                'jumlah_barang' => 1,
                'created_at' => now()
            ]);
        }

        // simpan ke table permintaan
        $now = now();
        $id = auth()->user()->id;

        // mengambil record terbaru dan nilai id_permintaan tertinggi
        // $permintaanterbaru = DB::table('permintaan')->orderByDesc('id_permintaan')->first();

        // mengambil nilai id_permintaan dari record terbaru jika tersedia, jika tidak ada set nilai id_permintaan menjadi 1
        // $newIdPermintaan = $permintaanterbaru ? $permintaanterbaru->id_otorisasi + 1 : 1;

        //simpan permintaan
        $simpan_permintaan = DB::table('permintaan')->insert([
            // 'id_permintaan' => $newIdPermintaan,
            'keluhan_kebutuhan' => $request->input('uraian_kebutuhan'),
            'tipe_permintaan' => "software",
            'status_permintaan' => 1,
            'tanggal_permintaan' => $now,
            'ttd_requestor' => $filename,
            'id' => $id,
            'id_kategori' => $id_cat,
            'id_otorisasi' => $newIdOtorisasi,
            'kode_barang' => $kode_barang,
            'created_at' => $now,
            'updated_at' => $now
        ]);



        if ($simpan_kategori && $simpan_otorisasi && $simpan_permintaan && $simpan_barang) {
            return true;
        } else {
            return false;
        }
    }

    public function data_barang_by_kode_barang($kodebarang)
    {
        $barang = DB::table('barang')
            ->where('kode_barang', $kodebarang)
            ->first();

        if ($barang) {
            return [
                'nama_barang' => $barang->nama_barang,
                'prosesor' => $barang->prosesor,
                'ram' => $barang->ram,
                'penyimpanan' => $barang->penyimpanan,
            ];
        } else {
            return null;
        }
    }
}
