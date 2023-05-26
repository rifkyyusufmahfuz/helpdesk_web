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
        $software_total = OtorisasiModel::count();
        $software_pending = OtorisasiModel::where('status_approval', '=', 'pending')->count();
        $software_waiting = OtorisasiModel::where('status_approval', '=', 'waiting')->count();
        $software_revisi = OtorisasiModel::where('status_approval', '=', 'revision')->count();
        $software_diterima = OtorisasiModel::where('status_approval', '=', 'approved')->count();
        $software_ditolak = OtorisasiModel::where('status_approval', '=', 'rejected')->count();

        $hardware_total = PermintaanModel::where('tipe_permintaan', '=', 'hardware')->count();
        $hardware_pending = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('status_permintaan', '=', 'pending')
            ->count();
        $hardware_proses = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('status_permintaan', '=', 'proses')
            ->count();
        $hardware_selesai = PermintaanModel::where('tipe_permintaan', '=', 'hardware')
            ->where('status_permintaan', '=', 'selesai')
            ->count();


        $total = $software_total + $hardware_total;
        $pending = $software_pending + $hardware_pending;
        $revisi = $software_revisi;
        $diproses = $hardware_proses;
        $diterima = $software_diterima + $hardware_selesai;
        $selesai = $hardware_selesai;
        $ditolak = $software_ditolak;

        return view('admin.index', compact('software_total', 'software_pending', 'software_revisi', 'software_diterima', 'software_ditolak', 'hardware_total', 'hardware_pending', 'hardware_proses', 'hardware_selesai', 'total', 'pending', 'revisi', 'diproses', 'diterima', 'selesai', 'ditolak'));
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

        $isSoftwareFilled = false;
        if ($software) {
            foreach ($software as $sw) {
                if (!empty($sw->versi_software) && !empty($sw->notes)) {
                    $isSoftwareFilled = true;
                    break;
                }
            }
        }

        return view(
            'admin.software.tindak_lanjut_software',
            [
                'permintaan' => $permintaan,
                'software' => $software,
                'list_software' => $list_software,
                'isSoftwareFilled' => $isSoftwareFilled,
            ]
        );
    }


    public function bast_software($id_permintaan)
    {
        $permintaan = $this->modeladmin->get_permintaan_software_by_id($id_permintaan);
        $barang = $this->modeladmin->get_barang_by_id_permintaan($id_permintaan);
        return view(
            'admin.software.bast_software',
            [
                'permintaan' => $permintaan,
                'barang' => $barang,
            ]
        );
    }

    public function tindak_lanjut_software(Request $request)
    {
        if ($this->modeladmin->tindak_lanjut_permintaan_software($request)) {
            return redirect('/admin/permintaan_software')->with('toast_success', 'Permintaan berhasil diajukan ke manager!');
        } else {
            return redirect('/admin/permintaan_software')->with('toast_error', 'Permintaan gagal ditambahkan!');
        }
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
        if ($request->has('nama_software')) {
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
        } else if ($request->has('kode_barang')) {
            $request->validate(
                // validasi form 
                [
                    'kode_barang' => 'required',
                    'nama_barang' => 'required',
                    'perihal' => 'required',
                ],
                // custom error notifikasi
                [
                    'kode_barang.required' => 'ID Barang wajib diisi!',
                    'nama_barang.required' => 'Nama Barang wajib diisi!',
                    'perihal.required' => 'Perihal wajib diisi!',
                ]
            );

            $data2 = [
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'jumlah_barang' => 1,
                'perihal' => $request->perihal,
                'id_permintaan' => $request->id_permintaan,
                'updated_at' => \Carbon\Carbon::now(),
            ];

            if ($this->modeladmin->input_barang($data2)) {
                return back()->with('toast_success', 'Tambah barang berhasil!');
            } else {
                return back()->with('toast_error', 'Tambah barang gagal!');
            }
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
        $request->validate([
            'versi_software' => 'required',

        ], [
            'versi_software.required' => 'Isi versi software!',
        ]);

        $catatan = $request->notes ?: '-';
        $data = [
            'versi_software' => $request->versi_software,
            'notes' => $catatan,
            'updated_at' => now(),
        ];

        return $this->modeladmin->update_software($data, $id) ? back()->with('toast_success', 'Versi software dan catatan berhasil diinput!') : back()->with('toast_success', 'Versi software dan catatan gagal diinput!');
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
