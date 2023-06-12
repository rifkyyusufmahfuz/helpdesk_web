<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\OtorisasiModel;
use App\Models\PermintaanModel;
use Illuminate\Http\Request;
use App\Utils\RomanNumberConverter;

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
        // $bast = $this->modeladmin->get_bast_by_id_permintaan($id_permintaan);

        return view(
            'admin.software.bast_software',
            [
                'permintaan' => $permintaan,
                'barang' => $barang,
                // 'bast' => $bast,
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
        // fungsi untuk tambah software 
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
        }
        //fungsi untuk BAST Barang Masuk
        else if ($request->has('nip_p1')) {
            //Tanda tangan yang menyerahkan barang / Pihak Pertama / P1
            $folderPath_p1 = public_path('tandatangan/bast/yang_menyerahkan/');
            if (!is_dir($folderPath_p1)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p1, 0777, true);
            }
            $filename_ttd_p1 = "bast_pihakpertama_" . uniqid() . ".png";
            $nama_file_ttd_p1 = $folderPath_p1 . $filename_ttd_p1;
            file_put_contents($nama_file_ttd_p1, file_get_contents($request->input('signature')));

            //Tanda tangan yang menerima barang / Pihak kedua / P2
            $folderPath_p2 = public_path('tandatangan/bast/yang_menerima/');
            if (!is_dir($folderPath_p2)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p2, 0777, true);
            }

            $filename_ttd_p2 = "bast_pihakkedua_" . uniqid() . ".png";
            $nama_file_ttd_p2 = $folderPath_p2 . $filename_ttd_p2;
            file_put_contents($nama_file_ttd_p2, file_get_contents($request->input('ttd_bast')));

            // generate id_bast / nomor bast
            //membuat id permintaan
            $bast_terbaru = $this->modeladmin->cari_id_bast();

            $bulanSebelumnya = $bast_terbaru ? substr($bast_terbaru->id_bast, 14, 1) : '';
            $tahunSebelumnya = $bast_terbaru ? substr($bast_terbaru->id_bast, 16, 4) : '';

            $bulanSekarang = date('n');
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman($bulanSekarang);
            // || $tahunSebelumnya !== date('Y')

            if ($bulanSebelumnya !== $kodeBulanSekarang || $tahunSebelumnya !== date('Y')) {
                $id_bast_baru = '0001-KCI-BAST-' . $kodeBulanSekarang . '-' . date('Y');
            } else {
                $nomorUrut = substr($bast_terbaru->id_bast, 0, 4) + 1;
                $id_bast_baru = sprintf('%04d', $nomorUrut) . '-KCI-BAST-' . $kodeBulanSekarang . '-' . date('Y');
            }

            $data_bast = [
                'id_bast' => $id_bast_baru,
                'tanggal_bast' => now(),
                'jenis_bast' => $request->jenis_bast,
                'perihal' => 'Instalasi software dengan software berikut ini: ',
                'ttd_menyerahkan' => $filename_ttd_p1,
                'yang_menyerahkan' => $request->nip_p1,
                'ttd_menerima' => $filename_ttd_p2,
                'yang_menerima' => $request->nip_pegawai,
                'id_permintaan' => $request->id_permintaan,
                'id_stasiun' => 'JUA',
                'created_at' => now(),
            ];

            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $id_permintaan = $request->id_permintaan;

            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            $notifikasi = [
                'pesan' => 'Anda baru saja melakukan Serah Terima Barang dengan Nomor BAST : ' . $id_bast_baru . '.',
                'tautan' => '/pegawai/bast',
                'created_at' => now(),
                'user_id' => $pegawaiId,
            ];

            $data_permintaan = [
                'status_permintaan' => 4,
                'updated_at' => now(),
            ];

            $kode_barang = $request->kode_barang;

            $data_barang = [
                'status_barang' => 'diterima',
                'updated_at' => now(),
            ];

            $update_permintaan = $this->modeladmin->update_permintaan($data_permintaan, $id_permintaan);
            $update_barang = $this->modeladmin->update_barang($data_barang, $kode_barang);
            $input_bast_barang_masuk = $this->modeladmin->input_bast($data_bast);
            $kirim_notifikasi = $this->modeladmin->input_notifikasi($notifikasi);

            // menggunakan operator ternary (pengganti kondisi dengan if else)
            //untuk mengembalikan pesan apakah berhasil atau tidak
            return ($input_bast_barang_masuk && $kirim_notifikasi && $update_permintaan && $update_barang)
                ? back()->with('toast_success', 'Input BAST berhasil!')
                : back()->with('toast_error', 'Input BAST gagal!');
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
        if ($request->has('status_permintaan')) {
            //update table permintaan
            $data = [
                'status_permintaan' => $request->status_permintaan,
                'updated_at' => now()
            ];
            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $id_permintaan = $request->id_permintaan;

            //update table barang
            $kode_barang = $request->kode_barang;
            $data_barang = [
                'status_barang' => 'siap diambil',
                'updated_at' => now()
            ];

            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            $notifikasi = [
                'pesan' => 'Permintaan instalasi software Anda dengan ID Permintaan = ' . $id_permintaan . ' telah selesai. Silakan ambil PC / Laptop Anda di NOC. Terima kasih!',
                'tautan' => '/pegawai/permintaan_software',
                'created_at' => now(),
                'user_id' => $pegawaiId,
            ];

            $update_permintaan = $this->modeladmin->update_permintaan($data, $id);
            $update_barang = $this->modeladmin->update_barang($data_barang, $kode_barang);
            $kirim_notifikasi = $this->modeladmin->input_notifikasi($notifikasi);


            return $update_permintaan && $update_barang && $kirim_notifikasi ? back()->with('toast_success', 'Status permintaan telah diubah!') : back()->with('toast_success', 'Status permintaan gagal diubah!');
        } else {
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
