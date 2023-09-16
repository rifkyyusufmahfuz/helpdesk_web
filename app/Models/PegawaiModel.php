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
    //Relasi ke ke tabel stasiun
    public function stasiun()
    {
        return $this->belongsTo(StasiunModel::class, 'id_stasiun');
    }

    // fungsi-fungsi

    public function get_permintaan_software_by_id($id)
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'roles.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
            )
            ->where('permintaan.id', $id)
            ->where('tipe_permintaan', 'software')
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }


    public function simpan_permintaan_software(Request $request)
    {
        //ambil data array checkbox software yang dipilih
        $selectedSoftware = $request->input('software', []);

        // Tentukan kategori software berdasarkan nilai checkbox yang dipilih
        $kategoriData = [
            'operating_system' =>
            in_array('Microsoft Windows', $selectedSoftware)
                || in_array('Linux OS', $selectedSoftware)
                || in_array('Mac OS', $selectedSoftware),

            'microsoft_office' =>
            in_array('Microsoft Office Standar', $selectedSoftware)
                || in_array('Microsoft Office For Mac', $selectedSoftware),

            'software_design' =>
            in_array('Adobe Photoshop', $selectedSoftware)
                || in_array('Adobe After Effect', $selectedSoftware)
                || in_array('Adobe Premiere', $selectedSoftware)
                || in_array('Adobe Ilustrator', $selectedSoftware)
                || in_array('Autocad', $selectedSoftware)
                || in_array('Sketch Up Pro', $selectedSoftware)
                || in_array('Corel Draw', $selectedSoftware)
                || in_array('Microsoft Project', $selectedSoftware)
                || in_array('Microsoft Visio', $selectedSoftware)
                || in_array('Vray Fr Sketchup', $selectedSoftware),

            'software_lainnya' =>
            in_array('Antivirus', $selectedSoftware)
                || in_array('Nitro PDF Pro', $selectedSoftware)
                || in_array('Open Office', $selectedSoftware)
                || in_array('SAP', $selectedSoftware)
                || in_array('Lainnya', $selectedSoftware),
        ];

        // Simpan data ke tabel kategori_software
        $simpan_kategori = DB::table('kategori_software')->insert($kategoriData);


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
        $folderPath = public_path('tandatangan/instalasi_software/requestor/');
        if (!is_dir($folderPath)) {
            //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
            mkdir($folderPath, 0777, true);
        }

        //fungsi untuk simpan ke table barang
        $kode_barang = strtoupper($request->kode_barang);
        $nama_barang =  ucwords(strtolower($request->nama_barang));
        $prosesor = strtoupper($request->prosesor);
        $ram = strtoupper($request->ram);
        $penyimpanan = strtoupper($request->penyimpanan);

        // cek apakah kode_barang sudah ada di dalam tabel
        $count = DB::table('barang')->where('kode_barang', $kode_barang)->count();

        if ($count > 0) {
            // jika sudah ada, update data barang yang sudah ada
            $simpan_barang = DB::table('barang')
                ->where('kode_barang', $kode_barang)
                ->update([
                    'nama_barang' => $nama_barang,
                    'prosesor' => $prosesor,
                    'ram' => $ram,
                    'penyimpanan' => $penyimpanan,
                    'status_barang' => 'belum diterima',
                    'jumlah_barang' => 1,
                    'updated_at' => now()
                ]);
        } else {
            // jika belum ada, simpan data
            $simpan_barang = DB::table('barang')->insert([
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'prosesor' => $prosesor,
                'ram' => $ram,
                'penyimpanan' => $penyimpanan,
                'status_barang' => 'belum diterima',
                'jumlah_barang' => 1,
                'created_at' => now()
            ]);
        }


        //simpan data pegawai
        // ubah value nama stasiun menjadi id_stasiun
        $nama_stasiun = $request->input('lokasi');
        $stasiun = DB::table('stasiun')->where('nama_stasiun', $nama_stasiun)->first();
        $id_stasiun = $stasiun->id_stasiun;

        //fungsi untuk simpan ke table barang
        $nama_pegawai =  ucwords(strtolower($request->nama));
        $bagian = strtoupper($request->bagian);
        $jabatan = $request->jabatan;

        // cek apakah kode_barang sudah ada di dalam tabel
        $count = DB::table('pegawai')->where('nip', $request->nip)->count();

        if ($count > 0) {
            // jika sudah ada, update data barang yang sudah ada
            $simpan_pegawai = DB::table('pegawai')
                ->where('nip', $request->nip)
                ->update([
                    'nip' => $request->nip,
                    'nama' => $nama_pegawai,
                    'bagian' => $bagian,
                    'jabatan' => $jabatan,
                    'id_stasiun' => $id_stasiun,
                    'updated_at' => now()
                ]);
        } else {
            // jika belum ada, simpan data
            $simpan_pegawai = DB::table('pegawai')->insert([
                'nip' => $request->nip,
                'nama' => $nama_pegawai,
                'bagian' => $bagian,
                'jabatan' => $jabatan,
                'id_stasiun' => $id_stasiun,
                'created_at' => now(),
            ]);
        }

        $newIdPermintaan = $request->no_tiket;

        //simpan tanda tangan
        $filename = "requestor_" . $newIdPermintaan . ".png";
        $nama_file = $folderPath . $filename;
        file_put_contents($nama_file, file_get_contents($request->input('signature')));


        // simpan ke table permintaan
        $now = now();
        $id = auth()->user()->id;

        //simpan permintaan
        $simpan_permintaan = DB::table('permintaan')->insert([
            'id_permintaan' => $newIdPermintaan,
            'keluhan_kebutuhan' => $request->input('uraian_kebutuhan'),
            'tipe_permintaan' => "software",
            'status_permintaan' => 1,
            'tanggal_permintaan' => $now,
            'ttd_requestor' => $filename,
            'id' => $id,
            'id_kategori' => $id_cat,
            'id_otorisasi' => $newIdOtorisasi,
            'kode_barang' => $kode_barang,
            'nip' => $request->nip,
            'created_at' => $now,
            'updated_at' => $now
        ]);


        if ($simpan_kategori && $simpan_otorisasi && $simpan_permintaan && $simpan_barang && $simpan_pegawai) {
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
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'prosesor' => $barang->prosesor,
                'ram' => $barang->ram,
                'penyimpanan' => $barang->penyimpanan,
                'status_barang' => $barang->status_barang,
            ];
        } else {
            return null;
        }
    }

    public function data_permintaan_by_id($no_tiket)
    {
        $data_permintaan = DB::table('permintaan')
            ->where('id_permintaan', $no_tiket)
            ->first();

        if ($data_permintaan) {
            return [
                'id_permintaan' => $data_permintaan->id_permintaan,
            ];
        } else {
            return null;
        }
    }

    public function get_list_software()
    {
        return DB::table('permintaan')
            ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->select(
                'permintaan.*',
                'software.*',
            )
            ->get();
    }


    // UNTUK PERMINTAAN HARDWARE

    public function get_permintaan_hardware_by_id($id)
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->select(
                'permintaan.*',
                'otorisasi.*',
                'permintaan.created_at as permintaan_created_at',
                'users.*',
                'roles.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
            )
            ->where('permintaan.id', $id)
            ->where('tipe_permintaan', 'hardware')
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }


    public function simpan_permintaan_hardware(Request $request)
    {
        //fungsi untuk simpan ke table barang
        $kode_barang = strtoupper($request->kode_barang);
        $nama_barang =  ucwords(strtolower($request->nama_barang));

        // cek apakah kode_barang sudah ada di dalam tabel
        $count = DB::table('barang')->where('kode_barang', $kode_barang)->count();

        if ($count > 0) {
            // jika sudah ada, update data barang yang sudah ada
            $simpan_barang = DB::table('barang')
                ->where('kode_barang', $kode_barang)
                ->update([
                    'nama_barang' => $nama_barang,
                    'prosesor' => '-',
                    'ram' => '-',
                    'penyimpanan' => '-',
                    'status_barang' => 'belum diterima',
                    'jumlah_barang' => 1,
                    'updated_at' => now()
                ]);
        } else {
            // jika belum ada, simpan data
            $simpan_barang = DB::table('barang')->insert([
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'prosesor' => '-',
                'ram' => '-',
                'penyimpanan' => '-',
                'status_barang' => 'belum diterima',
                'jumlah_barang' => 1,
                'created_at' => now()
            ]);
        }


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


        //simpan data pegawai
        // ubah value nama stasiun menjadi id_stasiun
        $nama_stasiun = $request->input('lokasi');
        $stasiun = DB::table('stasiun')->where('nama_stasiun', $nama_stasiun)->first();
        $id_stasiun = $stasiun->id_stasiun;

        //fungsi untuk simpan ke table barang
        $nama_pegawai =  ucwords(strtolower($request->nama));
        $bagian = strtoupper($request->bagian);

        // cek apakah kode_barang sudah ada di dalam tabel
        $count = DB::table('pegawai')->where('nip', $request->nip)->count();

        if ($count > 0) {
            // jika sudah ada, update data barang yang sudah ada
            $simpan_pegawai = DB::table('pegawai')
                ->where('nip', $request->nip)
                ->update([
                    'nip' => $request->nip,
                    'nama' => $nama_pegawai,
                    'bagian' => $bagian,
                    'jabatan' => $request->jabatan,
                    'id_stasiun' => $id_stasiun,
                    'updated_at' => now()
                ]);
        } else {
            // jika belum ada, simpan data
            $simpan_pegawai = DB::table('pegawai')->insert([
                'nip' => $request->nip,
                'nama' => $nama_pegawai,
                'bagian' => $bagian,
                'jabatan' => $request->jabatan,
                'id_stasiun' => $id_stasiun,
                'created_at' => now(),
            ]);
        }


        $newIdPermintaan = $request->no_tiket;


        //Tanda tangan
        $folderPath = public_path('tandatangan/pengecekan_hardware/requestor/');
        if (!is_dir($folderPath)) {
            //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
            mkdir($folderPath, 0777, true);
        }

        //simpan tanda tangan
        $filename = "requestor_" . $newIdPermintaan . ".png";
        $nama_file = $folderPath . $filename;
        file_put_contents($nama_file, file_get_contents($request->input('signature')));


        // simpan ke table permintaan
        $now = now();
        $id = auth()->user()->id;

        //simpan permintaan
        $simpan_permintaan = DB::table('permintaan')->insert([
            'id_permintaan' => $newIdPermintaan,
            'keluhan_kebutuhan' => ucwords($request->input('uraian_keluhan')),
            'tipe_permintaan' => "hardware",
            'status_permintaan' => 3,
            'tanggal_permintaan' => $now,
            'ttd_requestor' => $filename,
            'id' => $id,
            'nip' => $request->nip,
            'id_kategori' => null,
            'id_otorisasi' => $newIdOtorisasi,
            'kode_barang' => $kode_barang,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        if ($simpan_otorisasi && $simpan_barang && $simpan_permintaan && $simpan_pegawai) {
            return true;
        } else {
            return false;
        }
    }

    public function get_list_hardware()
    {
        return DB::table('permintaan')
            ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->select(
                'permintaan.*',
                'software.*',
            )
            ->get();
    }


    public function get_bast_barang_diterima_by_nip($nip)
    {
        return DB::table('bast')
            ->where('jenis_bast', 'barang_keluar')
            ->where('yang_menerima', $nip)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function get_bast_barang_diserahkan_by_nip($nip)
    {
        return DB::table('bast')
            ->where('jenis_bast', 'barang_masuk')
            ->where('yang_menyerahkan', $nip)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
