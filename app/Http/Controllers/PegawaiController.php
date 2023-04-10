<?php

namespace App\Http\Controllers;

use App\Models\OtorisasiModel;
use App\Models\PegawaiModel;
use App\Models\PermintaanModel;
use Illuminate\Http\Request;
use app\Models\KategoriSoftwareModel;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $modelpegawai;

    public function __construct()
    {
        $this->modelpegawai = new PegawaiModel();
    }

    public function index()
    {
        $instalasi_total = OtorisasiModel::count();
        $instalasi_pending = OtorisasiModel::where('status_approval', '=', 'pending')->count();
        $instalasi_revisi = OtorisasiModel::where('status_approval', '=', 'revision')->count();
        $instalasi_diterima = OtorisasiModel::where('status_approval', '=', 'approved')->count();
        $instalasi_ditolak = OtorisasiModel::where('status_approval', '=', 'rejected')->count();

        $hardware_total = PermintaanModel::count();
        $hardware_pending = PermintaanModel::where('status_permintaan', '=', 'pending')->count();
        $hardware_proses = PermintaanModel::where('status_permintaan', '=', 'proses')->count();
        $hardware_selesai = PermintaanModel::where('status_permintaan', '=', 'selesai')->count();

        $total = $instalasi_total + $hardware_total;
        $pending = $instalasi_pending + $hardware_pending;
        $revisi = $instalasi_revisi;
        $diproses = $hardware_proses;
        $diterima = $instalasi_diterima + $hardware_selesai;
        $selesai = $hardware_selesai;
        $ditolak = $instalasi_ditolak;

        return view('pegawai.index', compact('instalasi_total', 'instalasi_pending', 'instalasi_revisi', 'instalasi_diterima', 'instalasi_ditolak', 'hardware_total', 'hardware_pending', 'hardware_proses', 'hardware_selesai', 'total', 'pending', 'revisi', 'diproses', 'diterima', 'selesai', 'ditolak'));
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

    public function getDataRequest($id_permintaan)
    {

        $list_software = array(
            "Microsoft Windows",
            "Microsoft Office Standart",
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

        return view('pegawai.permintaan.cetak.form_permintaan_instalasi_software', [
            'id_permintaan' => $permintaan->id_permintaan,
            'tanggal_permintaan' => date('d/m/Y', strtotime($permintaan->tanggal_permintaan)),
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'bagian' => $pegawai->bagian,
            'jabatan' => $pegawai->jabatan,
            'kategori' => $kategori,
            'keluhan' => $permintaan->keluhan_kebutuhan,
            'no_aset' => $permintaan->no_aset,
            'ttd_requestor' => $permintaan->ttd_requestor,
            'list_software' => $list_software,
            'table_software' => $table_software,
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
