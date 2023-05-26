<?php

namespace App\Http\Controllers;

use App\Models\OtorisasiModel;
use App\Models\PegawaiModel;
use App\Models\PermintaanModel;
use Illuminate\Http\Request;
use app\Models\KategoriSoftwareModel;
use App\Models\TindakLanjutModel;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //untuk mendefinisikan model pegawai
    protected $modelpegawai;

    public function __construct()
    {
        $this->modelpegawai = new PegawaiModel();
    }

    //fungsi-fungsi 

    public function index()
    {
        $id_user = auth()->user()->id;

        $software_total = PermintaanModel::where('tipe_permintaan', '=', 'software')
            ->where('id', '=', $id_user)
            ->count();
        $software_pending = PermintaanModel::where('tipe_permintaan', '=', 'software')
            ->where('status_permintaan', '=', '1')
            ->orwhere('status_permintaan', '=', '2')
            ->orwhere('status_permintaan', '=', '3')
            ->where('id', '=', $id_user)
            ->count();
        $software_diproses = PermintaanModel::where('tipe_permintaan', '=', 'software')
            ->where('status_permintaan', '=', '4')
            ->where('id', '=', $id_user)
            ->count();
        $software_ditolak = PermintaanModel::where('tipe_permintaan', '=', 'software')
            ->where('status_permintaan', '=', '7')
            ->where('id', '=', $id_user)
            ->count();

        $hardware_total = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('id', '=', $id_user)
            ->count();
        $hardware_pending = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('status_permintaan', '=', 'pending')
            ->where('id', '=', $id_user)
            ->count();
        $hardware_proses = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('status_permintaan', '=', 'proses')
            ->where('id', '=', $id_user)
            ->count();
        $hardware_selesai = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('status_permintaan', '=', 'selesai')
            ->where('id', '=', $id_user)
            ->count();

        $total = $software_total + $hardware_total;
        $pending = $software_pending + $hardware_pending;
        $diproses = $hardware_proses + $software_diproses;
        $selesai = $hardware_selesai;

        return view('pegawai.index', compact(
            'software_total',
            'software_pending',
            'software_diproses',
            'software_ditolak',
            'hardware_total',
            'hardware_pending',
            'hardware_proses',
            'hardware_selesai',
            'total',
            'pending',
            'diproses',
            'selesai',
        ));
    }

    public function permintaan_software()
    {
        $id = auth()->user()->id;
        $permintaan = $this->modelpegawai->get_permintaan_software_by_id($id);

        return view('pegawai.permintaan.instalasi_software', ['permintaan' => $permintaan]);
    }

    public function simpan_software(Request $request)
    {
        if ($this->modelpegawai->simpan_permintaan_software($request)) {
            return redirect('/pegawai/permintaan_software')->with('toast_success', 'Permintaan berhasil ditambahkan!');
        } else {
            return redirect('/pegawai/permintaan_software')->with('toast_error', 'Permintaan gagal ditambahkan!');
        }
    }

    // fungsi untuk form permintaan instalasi software
    public function getDataRequest($id_permintaan)
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

        // Ambil data permintaan
        $permintaan = PermintaanModel::findOrFail($id_permintaan);

        // Ambil data pegawai berdasarkan nip pada tabel users
        $pegawai = PegawaiModel::where('nip', $permintaan->user->nip)->firstOrFail();

        // Ambil data kategori software berdasarkan id_permintaan
        $kategori = DB::table('kategori_software')->where('id_kategori', $permintaan->id_kategori)->first();
        $table_software = DB::table('software')->where('id_permintaan', $id_permintaan)->get();

        $otorisasi = OtorisasiModel::where('id_otorisasi', $permintaan->id_otorisasi)->first();

        // Ambil data software yang telah dipilih
        $selectedSoftware = $table_software->pluck('nama_software')->toArray();

        // Ambil data dari table tindak lanjut admin
        $tindaklanjut = TindakLanjutModel::where('id_permintaan', $id_permintaan)->first();

        // Ambil data admin berdasarkan id pada tabel users
        $data_admin = null;
        if ($tindaklanjut) {
            $data_admin = PegawaiModel::where('nip', $tindaklanjut->user->nip)->first();
        }

        return view('pegawai.permintaan.cetak.form_permintaan_instalasi_software', [
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
            'ttd_admin' => $tindaklanjut ? $tindaklanjut->ttd_admin : null,
            'nama_admin' => $data_admin ? $data_admin->nama : null,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function getDataBarang($kodebarang)
    {
        // $barang = DB::table('barang')->find($kodebarang);
        $barang = $this->modelpegawai->data_barang_by_kode_barang($kodebarang);

        if ($barang) {
            $nama_barang = $barang['nama_barang'];
            $prosesor = $barang['prosesor'];
            $ram = $barang['ram'];
            $penyimpanan = $barang['penyimpanan'];

            return response()->json([
                'nama_barang' => $nama_barang,
                'prosesor' => $prosesor,
                'ram' => $ram,
                'penyimpanan' => $penyimpanan
            ]);
        } else {
            return response()->json(null);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
