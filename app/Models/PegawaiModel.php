<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Utils\RomanNumberConverter;

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
        return DB::table('permintaan')->where('id', $id)
        ->get();
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


        $latestPermintaan = DB::table('permintaan')->orderByDesc('id_permintaan')->first();

        if ($latestPermintaan) {
            $latestId = $latestPermintaan->id_permintaan;
            $lastIdParts = explode('-', $latestId);
            $lastUrutan = intval($lastIdParts[0]);
            $lastBulan = $lastIdParts[3];
            $lastTahun = $lastIdParts[4];

            $bulanSekarang = date('n');
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman($bulanSekarang);
            $tahunSekarang = date('Y');

            if ($lastBulan !== $kodeBulanSekarang || $lastTahun !== $tahunSekarang) {
                $urutanBaru = 1;
            } else {
                $urutanBaru = $lastUrutan + 1;
            }
        } else {
            $urutanBaru = 1;
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman(date('n'));
            $tahunSekarang = date('Y');
        }

        $newIdPermintaan = sprintf('%04d', $urutanBaru) . '-KCI-ITHELPDESK-' . $kodeBulanSekarang . '-' . $tahunSekarang;



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
            'created_at' => $now,
            'updated_at' => $now
        ]);



        // simpan software
        $softwareData = [];
        foreach ($selectedSoftware as $software) {
            $softwareData[] = [
                'nama_software' => $software,
                'id_permintaan' => $newIdPermintaan,
            ];
        }
        $simpan_software = DB::table('software')->insert($softwareData);

        //kirim notifikasi ke admin
        $nama = ucwords(auth()->user()->pegawai->nama);
        $simpan_notifikasi = DB::table('notifikasi')->insert([
            'role_id' => 2,
            'pesan' => 'Permintaan instalasi software baru dari pegawai ' . $nama,
            'tautan' => '/admin/permintaan_software',
            'created_at' => now()
        ]);


        if ($simpan_kategori && $simpan_otorisasi && $simpan_permintaan && $simpan_barang && $simpan_software && $simpan_notifikasi) {
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
