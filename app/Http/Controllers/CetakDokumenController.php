<?php

namespace App\Http\Controllers;

use App\Models\CetakDokumenModel;
use Illuminate\Http\Request;
use Nasution\Terbilang;

class CetakDokumenController extends Controller
{
    //untuk mendefinisikan model pegawai
    protected $modelcetak;

    public function __construct()
    {
        $this->modelcetak = new CetakDokumenModel();
    }

    public function cetak_bast_barang_masuk($id_permintaan)
    {
        $terbilang = new Terbilang();

        $data_bast_masuk = $this->modelcetak->get_bast_by_id_permintaan($id_permintaan);
        // $data_software = $this->modelcetak->get_software_by_id_permintaan($id_permintaan);

        if ($data_bast_masuk->isNotEmpty()) {
            $tanggal_bast = $data_bast_masuk[0]->tanggal_bast;
            $date = \Carbon\Carbon::parse($tanggal_bast);
            $namahari = $date->isoFormat('dddd');

            $tanggal = ucfirst($terbilang->convert($date->isoFormat('DD')));
            $bulan = $date->isoFormat('MMMM');
            $tahun = ucfirst($terbilang->convert($date->isoFormat('Y')));

            $tanggal_ttd = $date->isoFormat('DD MMMM YYYY');
        }


        return view('cetak.form_bast_barang_masuk', [
            'data_bast_masuk' => $data_bast_masuk,
            'hari' => $namahari,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_ttd' => $tanggal_ttd,
            // 'data_software' => $data_software
        ]);
    }


    public function cetak_bast_barang_keluar($id_permintaan)
    {
        $terbilang = new Terbilang();

        $data_bast_masuk = $this->modelcetak->get_bast_by_id_permintaan_2($id_permintaan);
        // $data_software = $this->modelcetak->get_software_by_id_permintaan($id_permintaan);

        if ($data_bast_masuk->isNotEmpty()) {
            $tanggal_bast = $data_bast_masuk[0]->tanggal_bast;
            $date = \Carbon\Carbon::parse($tanggal_bast);
            $namahari = $date->isoFormat('dddd');

            $tanggal = ucfirst($terbilang->convert($date->isoFormat('DD')));
            $bulan = $date->isoFormat('MMMM');
            $tahun = ucfirst($terbilang->convert($date->isoFormat('Y')));

            $tanggal_ttd = $date->isoFormat('DD MMMM YYYY');
        }


        return view('cetak.form_bast_barang_keluar', [
            'data_bast_masuk' => $data_bast_masuk,
            'hari' => $namahari,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_ttd' => $tanggal_ttd,
            // 'data_software' => $data_software
        ]);
    }



    // fungsi untuk form permintaan instalasi software
    public function cetak_form_instalasi_software($id_permintaan)
    {
        $list_software = array(
            "Microsoft Windows",
            "Microsoft Office Standar",
            "Microsoft Visio",
            "Microsoft Project",
            "Autocad",
            "Corel Draw",
            "Adobe Photoshop",
            "Adobe Premiere",
            "Adobe Ilustrator",
            "Adobe After Effect",
            "Antivirus",
            "Sketch Up Pro",
            "Vray Fr Sketchup",
            "Nitro PDF Pro",
            "Linux OS",
            "Open Office",
            "Mac OS",
            "Microsoft Office For Mac",
            "SAP",
            "Software Lainnya"
        );

        // // Ambil data permintaan
        // $permintaan = PermintaanModel::findOrFail($id_permintaan);

        // // Ambil data pegawai berdasarkan nip pada tabel users
        // $pegawai = PegawaiModel::where('nip', $permintaan->user->nip)->firstOrFail();

        // // Ambil data kategori software berdasarkan id_permintaan
        // $kategori = DB::table('kategori_software')->where('id_kategori', $permintaan->id_kategori)->first();
        // $table_software = DB::table('software')->where('id_permintaan', $id_permintaan)->get();

        // $otorisasi = OtorisasiModel::where('id_otorisasi', $permintaan->id_otorisasi)->first();

        // // Ambil data software yang telah dipilih
        // $selectedSoftware = $table_software->pluck('nama_software')->toArray();

        // // Ambil data dari table tindak lanjut admin
        // $tindaklanjut = TindakLanjutModel::where('id_permintaan', $id_permintaan)->first();

        // // Ambil data admin berdasarkan id pada tabel users
        // $data_admin = null;
        // if ($tindaklanjut) {
        //     $data_admin = PegawaiModel::where('nip', $tindaklanjut->user->nip)->first();
        // }

        //BARU
        // Ambil data permintaan
        // $permintaan = DB::table('permintaan')->findOrFail($id_permintaan);
        $permintaan = $this->modelcetak->get_table_permintaan_by_id($id_permintaan);

        // Ambil data pegawai berdasarkan nip pada tabel users
        $get_nip = $permintaan->nip;
        $pegawai = $this->modelcetak->get_pegawai_by_nip($get_nip);

        // $pegawai = DB::table('pegawai')->where('nip', $permintaan->user->nip)->firstOrFail();

        // Ambil data kategori software berdasarkan id_permintaan
        // $kategori = DB::table('kategori_software')->where('id_kategori', $permintaan->id_kategori)->first();
        $get_id_kategori = $permintaan->id_kategori;
        $kategori = $this->modelcetak->get_kategori_by_id_kategori($get_id_kategori);

        // $table_software = DB::table('software')->where('id_permintaan', $id_permintaan)->get();
        $table_software = $this->modelcetak->get_software_by_id_permintaan($id_permintaan);

        $get_id_otorisasi = $permintaan->id_otorisasi;
        // $otorisasi = DB::table('otorisasi')->where('id_otorisasi', $permintaan->id_otorisasi)->first();
        $otorisasi = $this->modelcetak->get_otorisasi_by_id_otorisasi($get_id_otorisasi);

        // Ambil data software yang telah dipilih
        $selectedSoftware = $table_software->pluck('nama_software')->toArray();

        // Ambil data dari table tindak lanjut admin
        // $tindaklanjut = DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->first();
        $tindaklanjut = $this->modelcetak->get_tindak_lanjut_by_id_permintaan($id_permintaan);

        // Ambil data admin berdasarkan id pada tabel users
        $data_admin = null;
        if ($tindaklanjut) {
            $get_nip_tindak_lanjut = $tindaklanjut->nip;
            // $data_admin = DB::table('pegawai')->where('nip', $tindaklanjut->user->nip)->first();
            $data_admin = $this->modelcetak->get_data_admin($get_nip_tindak_lanjut);
        }


        return view('cetak.form_permintaan_instalasi_software', [
            'id_permintaan' => $id_permintaan,
            'tanggal_permintaan' => $permintaan->tanggal_permintaan,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'bagian' => $pegawai->bagian,
            'jabatan' => $pegawai->jabatan,
            'kategori' => $kategori,
            'keluhan' => $permintaan->keluhan_kebutuhan,
            'kode_barang' => $permintaan->kode_barang,
            'ttd_requestor' => $permintaan->ttd_requestor,
            'list_software' => $list_software,
            'table_software' => $table_software,
            'otorisasi' => $otorisasi,
            'selectedSoftware' => $selectedSoftware, // Untuk Tambahkan data software yang telah dipilih
            'ttd_tindak_lanjut' => $tindaklanjut ? $tindaklanjut->ttd_tindak_lanjut : null,
            'nama_admin' => $data_admin ? $data_admin->nama : null,
        ]);
    }


    // fungsi untuk form permintaan instalasi software
    public function cetak_form_pengecekan_hardware($id_permintaan)
    {
        $list_hardware = array(
            "Hardisk",
            "Memory",
            "Monitor",
            "Keyboard",
            "Mouse",
            "Software",
            "Adaptor/Power Supply",
            "Processor",
            "Fan/Heatsink",
            "Lainnya..."
        );

        //BARU
        // Ambil data permintaan
        $permintaan = $this->modelcetak->get_table_permintaan_by_id($id_permintaan);

        // Ambil data pegawai berdasarkan nip pada tabel users
        $get_nip = $permintaan->nip;
        $pegawai = $this->modelcetak->get_pegawai_by_nip($get_nip);


        $table_hardware = $this->modelcetak->get_hardware_by_id_permintaan($id_permintaan);

        $get_id_otorisasi = $permintaan->id_otorisasi;
        $otorisasi = $this->modelcetak->get_otorisasi_by_id_otorisasi($get_id_otorisasi);

        // Ambil data software yang telah dipilih
        $selectedHardware = $table_hardware->pluck('komponen')->toArray();

        // Ambil data dari table tindak lanjut admin
        $tindaklanjut = $this->modelcetak->get_tindak_lanjut_by_id_permintaan($id_permintaan);

        // Ambil data admin berdasarkan id pada tabel users
        $data_admin = null;
        if ($tindaklanjut) {
            $get_nip_tindak_lanjut = $tindaklanjut->nip;
            $data_admin = $this->modelcetak->get_data_admin($get_nip_tindak_lanjut);
        }


        return view('cetak.form_pengecekan_hardware', [
            'id_permintaan' => $id_permintaan,
            'tanggal_permintaan' => $permintaan->tanggal_permintaan,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'bagian' => $pegawai->bagian,
            'jabatan' => $pegawai->jabatan,
            'keluhan' => $permintaan->keluhan_kebutuhan,
            'kode_barang' => $permintaan->kode_barang,
            'ttd_requestor' => $permintaan->ttd_requestor,
            'list_hardware' => $list_hardware,
            'table_hardware' => $table_hardware,
            'otorisasi' => $otorisasi,

            'ttd_tindak_lanjut' => $tindaklanjut ? $tindaklanjut->ttd_tindak_lanjut : null,
            'rekomendasi' => $tindaklanjut ? $tindaklanjut->rekomendasi : null,
            'nama_admin' => $data_admin ? $data_admin->nama : null,
        ]);
    }
}
