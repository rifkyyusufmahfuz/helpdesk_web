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

        $permintaanData = DB::table('permintaan')
            ->where('id', auth()->user()->id)
            ->select('tipe_permintaan', DB::raw('COUNT(id_permintaan) as jumlah_permintaan'))
            ->groupBy('tipe_permintaan')
            ->get();


        $statusPermintaanData = DB::table('permintaan')
            ->where('id', auth()->user()->id)
            ->select('status_permintaan', DB::raw('COUNT(id_permintaan) as jumlah_permintaan'))
            ->groupBy('status_permintaan')
            ->get();


        $allData = PermintaanModel::where('id', auth()->user()->id)
            ->groupBy(['tipe_permintaan', 'status_permintaan'])
            ->selectRaw('tipe_permintaan, status_permintaan, COUNT(*) as count')
            ->get()
            ->groupBy('tipe_permintaan')
            ->map(function ($group) {
                return $group->pluck('count', 'status_permintaan')->toArray();
            })
            ->toArray();

        return view('pegawai.index', compact(
            'permintaanData',
            'statusPermintaanData',
            'allData'
        ));
    }








    public function permintaan_software()
    {
        $id = auth()->user()->id;
        $permintaan = $this->modelpegawai->get_permintaan_software_by_id($id);
        $list_software = $this->modelpegawai->get_list_software();
        return view('pegawai.permintaan.instalasi_software', [
            'permintaan' => $permintaan,
            'list_software' => $list_software
        ]);
    }

    public function simpan_software(Request $request)
    {
        if ($this->modelpegawai->simpan_permintaan_software($request)) {
            return redirect('/pegawai/permintaan_software')->with('toast_success', 'Permintaan instalasi software berhasil diajukan!');
        } else {
            return redirect('/pegawai/permintaan_software')->with('toast_error', 'Permintaan gagal diajukan, silakan coba lagi!');
        }
    }

    public function permintaan_hardware()
    {
        $id = auth()->user()->id;
        $permintaan = $this->modelpegawai->get_permintaan_hardware_by_id($id);
        $list_hardware = $this->modelpegawai->get_list_hardware();
        return view('pegawai.permintaan.pengecekan_hardware', [
            'permintaan' => $permintaan,
            'list_hardware' => $list_hardware
        ]);
    }

    public function simpan_hardware(Request $request)
    {
        return $this->modelpegawai->simpan_permintaan_hardware($request)
            ? redirect('/pegawai/permintaan_hardware')->with('toast_success', 'Permintaan pengecekan hardware berhasil diajukan!')
            : redirect('/pegawai/permintaan_hardware')->with('toast_error', 'Permintaan gagal ditambahkan, silakan coba lagi!');
    }



    public function halaman_barang_diterima_pegawai()
    {
        $nip = auth()->user()->pegawai->nip;

        $bast_barang_diterima = $this->modelpegawai->get_bast_barang_diterima_by_nip($nip);

        return view(
            'pegawai.halaman_bast.barang_diterima',
            [
                'bast_barang_diterima' => $bast_barang_diterima,
            ]
        );
    }

    public function halaman_barang_diserahkan_pegawai()
    {
        $nip = auth()->user()->pegawai->nip;

        $bast_barang_diserahkan = $this->modelpegawai->get_bast_barang_diserahkan_by_nip($nip);

        return view(
            'pegawai.halaman_bast.barang_diserahkan',
            [
                'bast_barang_diserahkan' => $bast_barang_diserahkan,
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
