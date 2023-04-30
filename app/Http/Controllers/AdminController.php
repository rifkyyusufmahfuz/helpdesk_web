<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\OtorisasiModel;
use App\Models\PermintaanModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $modeladmin;

    public function __construct()
    {
        $this->modeladmin = new AdminModel();
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

        return view('admin.index', compact('instalasi_total', 'instalasi_pending', 'instalasi_revisi', 'instalasi_diterima', 'instalasi_ditolak', 'hardware_total', 'hardware_pending', 'hardware_proses', 'hardware_selesai', 'total', 'pending', 'revisi', 'diproses', 'diterima', 'selesai', 'ditolak'));
    }

    public function permintaan_software()
    {
        $permintaan = $this->modeladmin->get_permintaan_software();

        return view(
            'admin.software.permintaan_software',
            [
                'permintaan' => $permintaan
            ]
        );
    }

    public function tambah_software($id_permintaan)
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

        $permintaan = $this->modeladmin->get_permintaan_software_by_id($id_permintaan);
        $software = $this->modeladmin->get_software_by_id($id_permintaan);

        return view(
            'admin.software.tindak_lanjut_software',
            [
                'permintaan' => $permintaan,
                'software' => $software,
                'list_software' => $list_software,
            ]
        );
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
        $request->validate(
            // validasi form 
            [
                'id_permintaan' => 'required',
                'nama_software' => 'required',
                'versi_software' => 'required',
                // 'notes' => 'required',
            ],
            // custom error notifikasi
            [
                'id_permintaan.required' => 'ID Permintaan wajib diisi!',
                'nama_software.required' => 'Nama software wajib diisi!',
                'versi_software.required' => 'Versi software wajib diisi!',
                // 'notes' => 'Notes wajib diisi!',
            ]
        );


        $catatan = $request->notes ?: '-';

        $data = [
            'id_permintaan' => $request->id_permintaan,
            'nama_software' => $request->nama_software,
            'versi_software' => $request->versi_software,
            'notes' => $catatan,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

        if ($this->modeladmin->input_software($data)) {
            return back()->with('toast_success', 'Tambah software berhasil!');
        } else {
            return back()->with('toast_error', 'Tambah software gagal!');
        }
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
        if ($this->modeladmin->hapus_software($id)) {
            return back()->with('toast_success', 'Software berhasil dihapus!');
        } else {
            return back()->with('toast_error', 'Software gagal dihapus!');
        }
    }
}
