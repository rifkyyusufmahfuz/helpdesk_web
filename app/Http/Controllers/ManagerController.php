<?php

namespace App\Http\Controllers;

use App\Models\ManagerModel;
use Illuminate\Http\Request;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\DumpHandler;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $modelmanager;

    public function __construct()
    {
        $this->modelmanager = new ManagerModel();
    }

    public function index()
    {
        return view('manager.index');
    }


    public function getData()
    {
        $softwareRequests = $this->modelmanager->get_data_permintaan();

        return response()->json($softwareRequests);
    }


    public function permintaan_software()
    {
        $permintaan = $this->modelmanager->get_permintaan_software_by_otorisasi();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'manager.otorisasi.permintaan_software',
            [
                'permintaan' => $permintaan,
                'list_software' => $list_software
            ]
        );
    }

    public function permintaan_revisi()
    {
        $permintaan = $this->modelmanager->get_permintaan_revisi();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'manager.otorisasi.software_revisi',
            [
                'permintaan' => $permintaan,
                'list_software' => $list_software
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
        if ($request->has('id_otorisasi')) {
            $request->validate(
                [
                    'id_otorisasi' => 'required',
                    'catatan_manager' => 'required'
                ]
            );

            //untuk input ke table otorisasi
            $id_manager = auth()->user()->id;
            $id_otorisasi = $request->id_otorisasi;

            $data = [
                'catatan' => $request->catatan_manager,
                'status_approval' => 'revision',
                'id' => $id_manager,
                'updated_at' => now()
            ];

            // untuk input ke table notifikasi
            $id_permintaan = $request->id_permintaan;
            $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
            // $id_admin = $permintaan->id;
            $notifikasi = [
                'pesan' => 'Manager mengajukan revisi pada permintaan ' . $id_permintaan . '.',
                'tautan' => '/admin/permintaan_software',
                'created_at' => now(),
                'role_id' => 2,
            ];

            // kirim data ke model
            $update_otorisasi = $this->modelmanager->update_otorisasi($data, $id_otorisasi);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);

            return $update_otorisasi && $kirim_notifikasi ? back()->with('toast_success', 'Revisi berhasil diajukan ke Admin!') : back()->with('toast_error', 'Pengajuan revisi gagal, silakan coba lagi!');
        } elseif ($request->has('status_approval')) {
            $request->validate(
                [
                    'status_approval' => 'required',
                    'status_permintaan' => 'required',
                    'id_permintaan' => 'required',
                ]
            );

            //Tanda tangan yang menyerahkan barang / Pihak Pertama / P1
            $folderPath_p1 = public_path('tandatangan/manager/setujui_permintaan/');
            if (!is_dir($folderPath_p1)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p1, 0777, true);
            }
            $filename_ttd_p1 = "setujui_permintaan_" . uniqid() . ".png";
            $nama_file_ttd_p1 = $folderPath_p1 . $filename_ttd_p1;
            file_put_contents($nama_file_ttd_p1, file_get_contents($request->input('signature')));



            //untuk input ke table otorisasi
            $id_manager = auth()->user()->id;
            $id_otorisasi = $request->id_otorisasi;

            $data = [
                'catatan' => $request->catatan_manager,
                'status_approval' => 'revision',
                'id' => $id_manager,
                'updated_at' => now()
            ];

            // untuk input ke table notifikasi
            $id_permintaan = $request->id_permintaan;
            $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
            // $id_admin = $permintaan->id;
            $notifikasi = [
                'pesan' => 'Manager mengajukan revisi pada permintaan ' . $id_permintaan . '.',
                'tautan' => '/admin/permintaan_software',
                'created_at' => now(),
                'role_id' => 2,
            ];

            // kirim data ke model
            $update_otorisasi = $this->modelmanager->update_otorisasi($data, $id_otorisasi);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);

            return $update_otorisasi && $kirim_notifikasi ? back()->with('toast_success', 'Revisi berhasil diajukan ke Admin!') : back()->with('toast_error', 'Pengajuan revisi gagal, silakan coba lagi!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
