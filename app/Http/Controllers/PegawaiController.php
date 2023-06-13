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
            $kode_barang_table = $barang['kode_barang'];
            $nama_barang = $barang['nama_barang'];
            $prosesor = $barang['prosesor'];
            $ram = $barang['ram'];
            $penyimpanan = $barang['penyimpanan'];
            $status_barang = $barang['status_barang'];

            return response()->json([
                'kode_barang_table' => $kode_barang_table,
                'nama_barang' => $nama_barang,
                'prosesor' => $prosesor,
                'ram' => $ram,
                'penyimpanan' => $penyimpanan,
                'status_barang' => $status_barang,
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
