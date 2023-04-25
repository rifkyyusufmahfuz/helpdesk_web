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
            'admin.permintaan_software',
            [
                'permintaan' => $permintaan
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
