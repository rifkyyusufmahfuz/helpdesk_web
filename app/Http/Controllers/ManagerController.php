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

    public function riwayat_otorisasi()
    {
        $permintaan = $this->modelmanager->get_riwayat_permintaan_software();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'manager.otorisasi.riwayat_otorisasi_software',
            [
                'permintaan' => $permintaan,
                'list_software' => $list_software
            ]
        );
    }


    public function permintaan_hardware()
    {
        $permintaan = $this->modelmanager->get_permintaan_hardware_by_otorisasi();
        $list_hardware = $this->modelmanager->get_list_hardware();

        return view(
            'manager.otorisasi.permintaan_hardware',
            [
                'permintaan' => $permintaan,
                'list_hardware' => $list_hardware
            ]
        );
    }

    public function riwayat_validasi()
    {
        $permintaan = $this->modelmanager->get_riwayat_permintaan_hardware();
        $list_hardware = $this->modelmanager->get_list_hardware();

        return view(
            'manager.otorisasi.riwayat_validasi_hardware',
            [
                'permintaan' => $permintaan,
                'list_hardware' => $list_hardware
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
    public function update(Request $request, string $id_permintaan)
    {
        //untuk input ke table otorisasi
        $id_manager = auth()->user()->id;
        $id_otorisasi = $request->id_otorisasi;

        if ($request->has('revisi')) {
            $request->validate(
                [
                    'id_otorisasi' => 'required',
                    'catatan_manager' => 'required'
                ]
            );
            $data_otorisasi = [
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
            $update_otorisasi = $this->modelmanager->update_otorisasi($data_otorisasi, $id_otorisasi);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);

            return $update_otorisasi && $kirim_notifikasi ? back()->with('toast_success', 'Revisi berhasil diajukan ke Admin!') : back()->with('toast_error', 'Pengajuan revisi gagal, silakan coba lagi!');
        } elseif ($request->has('otorisasi_manager')) {
            $request->validate(
                [
                    'otorisasi_manager' => 'required'
                ]
            );

            if ($request->otorisasi_manager == 'disetujui') {
                // Validasi data yang diterima dari form
                $request->validate([
                    'catatan_manager_' . $id_permintaan => 'required',
                    'ttd_manager_' . $id_permintaan => 'required',
                ]);

                //Tanda tangan manager untuk menyetujui permintaan
                $lokasi_simpan_ttd = public_path('tandatangan/instalasi_software/manager/');
                if (!is_dir($lokasi_simpan_ttd)) {
                    //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                    mkdir($lokasi_simpan_ttd, 0777, true);
                }
                $nama_file_ttd_manager = "approve_" . $id_permintaan . ".png";
                $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
                file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_' . $id_permintaan)));


                $data_permintaan = [
                    'status_permintaan' => '3',
                    'updated_at' => now(),
                ];


                // Update data pada tabel otorisasi
                $data_otorisasi = [
                    'status_approval' => 'approved',
                    'catatan' => $request->input('catatan_manager_' . $id_permintaan),
                    'tanggal_approval' => now(),
                    'ttd_manager' => $nama_file_ttd_manager,
                    'id' => $id_manager,
                    'updated_at' => now(),
                ];

                //kirim notifikasi ke requestor / pegawai
                $permintaan = $this->modelmanager->cari_requestor($id_permintaan);
                $pegawaiId = $permintaan->id;
                $notifikasi = [
                    'pesan' => 'Permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" telah disetujui. Silakan bawa unit yang akan diinstalasi. Terima kasih!',
                    'tautan' => '/pegawai/permintaan_software',
                    'created_at' => now(),
                    'user_id' => $pegawaiId,
                ];

                // kirim notifikasi ke admin
                $id_permintaan = $request->id_permintaan;
                $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
                $notifikasi_admin = [
                    'pesan' => 'Permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" telah disetujui oleh Manager. Requestor telah diberitahukan untuk menyerahkan unit ke NOC.',
                    'tautan' => '/admin/permintaan_hardware',
                    'created_at' => now(),
                    'role_id' => 2,
                ];
            } elseif ($request->otorisasi_manager == 'ditolak') {
                // Validasi data yang diterima dari form
                $request->validate([
                    'catatan_manager_2_' . $id_permintaan => 'required',
                    'ttd_manager_2_' . $id_permintaan => 'required',
                ]);

                //Tanda tangan manager untuk menyetujui permintaan
                $lokasi_simpan_ttd = public_path('tandatangan/instalasi_software/manager/');
                if (!is_dir($lokasi_simpan_ttd)) {
                    //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                    mkdir($lokasi_simpan_ttd, 0777, true);
                }
                $nama_file_ttd_manager = "rejected_" . $id_permintaan . ".png";
                $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
                file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_2_' . $id_permintaan)));


                $data_permintaan = [
                    'status_permintaan' => '0',
                    'updated_at' => now(),
                ];

                // Update data pada tabel otorisasi
                $data_otorisasi = [
                    'status_approval' => 'rejected',
                    'catatan' => $request->input('catatan_manager_2_' . $id_permintaan),
                    'tanggal_approval' => now(),
                    'ttd_manager' => $nama_file_ttd_manager,
                    'id' => $id_manager,
                    'updated_at' => now(),
                ];


                // kirim notifikasi ke requestor / pegawai 
                $permintaan = $this->modelmanager->cari_requestor($id_permintaan);
                $pegawaiId = $permintaan->id;
                $notifikasi = [
                    'pesan' => 'Maaf permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" ditolak karena tidak sesuai ketentuan. Silakan ajukan permintaan lain. Terima kasih!',
                    'tautan' => '/pegawai/permintaan_software',
                    'created_at' => now(),
                    'user_id' => $pegawaiId,
                ];

                // kirim notifikasi ke admin
                $id_permintaan = $request->id_permintaan;
                $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
                $notifikasi_admin = [
                    'pesan' => 'Permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" ditolak manager.',
                    'tautan' => '/admin/permintaan_hardware',
                    'created_at' => now(),
                    'role_id' => 2,
                ];

                $kode_barang = $request->kode_barang;
                $data_barang = [
                    'status_barang' => 'dikembalikan',
                    'updated_at' => now()
                ];
                $update_barang = $this->modelmanager->update_barang($data_barang, $kode_barang);
            }

            $update_otorisasi = $this->modelmanager->update_otorisasi($data_otorisasi, $id_otorisasi);
            $update_permintaan = $this->modelmanager->update_permintaan($data_permintaan, $id_permintaan);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);
            $kirim_notifikasi_admin = $this->modelmanager->input_notifikasi($notifikasi_admin);

            if ($request->otorisasi_manager == 'disetujui') {
                return $update_otorisasi && $update_permintaan && $kirim_notifikasi && $kirim_notifikasi_admin
                    ? back()->with('success', 'Permintaan telah disetujui dan akan segera diproses oleh Admin!')
                    : back()->with('error', 'Otorisasi permintaan gagal, silakan coba lagi!');
            } elseif ($request->otorisasi_manager == 'ditolak') {
                return $update_otorisasi && $update_permintaan && $update_barang && $kirim_notifikasi && $kirim_notifikasi_admin
                    ? back()->with('warning', 'Permintaan ditolak dan proses Instalasi Software tidak akan dilanjutkan.')
                    : back()->with('error', 'Otorisasi permintaan gagal, silakan coba lagi!');
            }
        } elseif ($request->has('divalidasi')) {

            // Validasi data yang diterima dari form
            $request->validate([
                // 'catatan_manager_' . $id_permintaan => 'required',
                'ttd_manager_' . $id_permintaan => 'required',
            ]);

            //Tanda tangan manager untuk menyetujui permintaan
            $lokasi_simpan_ttd = public_path('tandatangan/pengecekan_hardware/manager/');
            if (!is_dir($lokasi_simpan_ttd)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($lokasi_simpan_ttd, 0777, true);
            }
            $nama_file_ttd_manager = "validasi_" . $id_permintaan . ".png";
            $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
            file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_' . $id_permintaan)));

            $data_permintaan = [
                'status_permintaan' => '4',
                'updated_at' => now(),
            ];

            // Update data pada tabel otorisasi
            $data_otorisasi = [
                'status_approval' => 'approved',
                'catatan' => '-',
                'tanggal_approval' => now(),
                'ttd_manager' => $nama_file_ttd_manager,
                'id' => $id_manager,
                'updated_at' => now(),
            ];

            // untuk input ke table notifikasi
            $id_permintaan = $request->id_permintaan;
            $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
            // $id_admin = $permintaan->id;
            $notifikasi = [
                'pesan' => 'Rekomendasi pengecekan hardware dengan ID Permintaan "' . $id_permintaan . '" telah divalidasi!',
                'tautan' => '/admin/permintaan_hardware',
                'created_at' => now(),
                'role_id' => 2,
            ];



            $update_otorisasi = $this->modelmanager->update_otorisasi($data_otorisasi, $id_otorisasi);
            $update_permintaan = $this->modelmanager->update_permintaan($data_permintaan, $id_permintaan);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);

            return $update_otorisasi && $update_permintaan && $kirim_notifikasi ?
                back()->with('success', 'Rekomendasi pengecekan hardware telah divalidasi!')
                : back()->with('error', 'Validasi gagal, silakan coba lagi!');
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
