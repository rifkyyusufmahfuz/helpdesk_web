<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleModel;
use App\Models\SuperadminModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $modeluser;
    protected $modelsuperadmin;

    public function __construct()
    {
        $this->modeluser = new User();
        $this->modelsuperadmin = new SuperadminModel();
    }

    public function index()
    {
        $data = [
            'data_user' => $this->modelsuperadmin->get_data_user(),
            'data_role' => $this->modelsuperadmin->get_data_role(),
            'roleCounts' => $this->modelsuperadmin->hitung_user_by_role(),
            'activeUser' => $this->modelsuperadmin->hitung_data_user_aktif(),
            'inactiveUser' => $this->modelsuperadmin->hitung_data_user_nonaktif(),
            'totalUser' => $this->modelsuperadmin->hitung_semua_user(),
        ];

        return view('superadmin.index', $data);
    }

    public function halaman_datauser()
    {
        $data = [
            'data_user' => $this->modelsuperadmin->data_user_aktif(),
            'data_role' => $this->modelsuperadmin->get_data_role(),
            'roleCounts' => $this->modelsuperadmin->hitung_user_by_role(),
            'nip_pegawai' => $this->modelsuperadmin->get_nip_unregistered(),
        ];

        return view('superadmin.datauser', $data);
    }

    public function halaman_datauser_nonaktif()
    {
        $data = [
            'data_user' => $this->modelsuperadmin->data_user_nonaktif(),
            'data_role' => $this->modelsuperadmin->get_data_role(),
            'roleCounts' => $this->modelsuperadmin->hitung_user_by_role(),
            'nip_pegawai' => $this->modelsuperadmin->get_nip_unregistered(),
        ];

        return view('superadmin.datauser_nonaktif', $data);
    }

    public function halaman_datapegawai()
    {
        $data = [
            'data_pegawai' => $this->modelsuperadmin->data_pegawai(),
            'data_stasiun' => $this->modelsuperadmin->data_stasiun(),
        ];

        return view('superadmin.datapegawai', $data);
    }

    public function getPegawaiData($nip)
    {
        $pegawai = $this->modelsuperadmin->data_pegawai_by_nip($nip);

        if ($pegawai) {
            $nama = $pegawai['nama'];
            $bagian = $pegawai['bagian'];
            $jabatan = $pegawai['jabatan'];
            $lokasi = $pegawai['lokasi'];

            return response()->json([
                'nama' => $nama,
                'bagian' => $bagian,
                'jabatan' => $jabatan,
                'lokasi' => $lokasi
            ]);
        } else {
            return response()->json(null);
        }
    }

    // fungsi untuk mengaktivasi semua user yang nonaktif
    public function aktivasi_semua_user()
    {
        $users = User::where('status', false)->get();
        User::where('status', false)->update(['status' => true]);

        foreach ($users as $user) {
            // Ambil data nama dari tabel pegawai
            $pegawai = $this->modelsuperadmin->get_data_pegawai($user->nip);
            $nama = $pegawai->nama;

            // Buat entri notifikasi untuk pengguna yang diaktifkan
            $pesan = "Halo " . $nama . "! Selamat datang di Sistem Informasi IT Helpdesk! Akun Anda telah aktif dan dapat menggunakan fitur-fitur yang telah disediakan. Terima kasih!";

            $notifikasi = [
                'pesan' => $pesan,
                'tautan' => '#',
                'user_id' => $user->id,
                'created_at' => now()
            ];

            $this->modelsuperadmin->input_notifikasi($notifikasi);
        }

        return redirect()->back()->with('toast_success', 'Semua user berhasil diaktivasi!');
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
        if ($request->has('email')) {
            $request->validate(
                [
                    //data user
                    'email' => 'required|unique:users,email',
                    'password' => 'required',
                    'confirm_password' => 'required',
                    'role' => 'required',

                    //data pegawai
                    'nip_pegawai'  => 'required',

                ],
                [
                    'password.required' => 'Password tidak boleh kosong!',
                    'confirm_password.required' => 'Konfirmasi Password tidak boleh kosong!',
                    'confirm_password.same' => 'Password tidak cocok!',
                    'role.required' => 'Role tidak boleh kosong!',
                    'nip_pegawai.required' => 'NIK tidak boleh kosong!',
                ]
            );

            $data_user = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => $request->role,
                'status' => true,
                'nip'  => $request->nip_pegawai,
                'created_at' => \Carbon\Carbon::now(),
            ];

            // melakukan proses penyimpanan data user
            if ($this->modelsuperadmin->insert_datauser($data_user)) {
                return redirect('/superadmin/datauseraktif')->with('toast_success', 'Data user berhasil ditambahkan!');
            } else {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Data user gagal ditambahkan!');
            }
        } else {
            // jika jenis input tidak valid, lakukan sesuai kebutuhan
            // return redirect('/superadmin/datauseraktif')->with('toast_error', 'Data gagal ditambahkan!');
            $request->validate([
                //data pegawai
                'nip_pegawai'  => 'required|unique:pegawai,nip|numeric|digits_between:1,5',
                'nama_pegawai' => 'required',
                'bagian_pegawai' => 'required',
                'jabatan_pegawai' => 'required',
                'lokasi_pegawai' => 'required',
            ], [
                'nip_pegawai.required' => 'NIK tidak boleh kosong!',
                'nip_pegawai.numeric' => 'NIK harus angka!',
                'nip_pegawai.digits_between' => 'Jumlah NIK minimal 4 dan maksimal 5 digit!',

                'nama_pegawai.required' => 'Nama tidak boleh kosong!',
                'bagian_pegawai.required' => 'Bagian tidak boleh kosong!',
                'jabatan_pegawai.required' => 'Jabatan tidak boleh kosong!',
                'lokasi_pegawai.required' => 'Lokasi tidak boleh kosong!',
            ]);

            // untuk mengubah nama stasiun menjadi id_stasiun
            $nama_stasiun = $request->input('lokasi_pegawai');
            $id_stasiun = $this->modelsuperadmin->getIdStasiun($nama_stasiun);


            $data = [
                'nip'  => $request->input('nip_pegawai'),
                'nama' => $request->input('nama_pegawai'),
                'bagian' => $request->input('bagian_pegawai'),
                'jabatan' => $request->input('jabatan_pegawai'),
                'id_stasiun' => $id_stasiun,
                'created_at' => \Carbon\Carbon::now(),
            ];
            // melakukan proses penyimpanan data pegawai
            if ($this->modelsuperadmin->insert_datapegawai($data)) {
                return redirect('/superadmin/datapegawai')->with('toast_success', 'Data pegawai berhasil ditambahkan!');
            } else {
                return redirect('/superadmin/datapegawai')->with('toast_error', 'Data pegawai gagal ditambahkan!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $nip = $user->nip;
        $pegawai = $this->modelsuperadmin->data_pegawai_by_nip($nip);

        // $role = RoleModel::find($user->id_role);

        return response()->json([
            'nip' => $nip,
            'nama' => $pegawai['nama'],
            'bagian' => $pegawai['bagian'],
            'jabatan' => $pegawai['jabatan'],
            'nama_stasiun' => $pegawai['lokasi'],
            // 'role' => $role->nama_role
        ]);
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
    // COPYRIGHT OF RIFKY YUSUF MAHFUZ - UNIVERSITAS BINA INSANI - PROJECT AKHIR SKRIPSI

    public function update(Request $request, $id)
    {
        // Ambil data user yang akan diupdate
        $user = $this->modelsuperadmin->get_user_by_id($id);

        // Jika melakukan update data user
        if ($request->has('email2') || $request->has('role')) {

            // Pencegahan jika superadmin mencoba mengupdate rolenya sendiri
            if ($user->id == Auth::user()->id && $request->has('role')) {
                $superadminRoleId = RoleModel::where('nama_role', 'superadmin')->first()->id_role;
                if (Auth::user()->id_role == $superadminRoleId && $request->input('role') != $superadminRoleId) {
                    return redirect('/superadmin/datauseraktif')->with('toast_error', 'Tidak dapat mengubah role sendiri menjadi role selain superadmin!');
                }
            }

            // Validasi form
            $request->validate(
                [
                    'email2' => 'required|unique:users,email,' . $id,
                    'role' => $request->filled('role') ? 'required|exists:roles,id_role' : ''
                ],
                [
                    'email2.required' => 'Email wajib diisi!',
                    'email2.unique' => 'Email sudah terdaftar!',
                    'role.required' => 'Role wajib dipilih!'
                ]

            );
            // data yang telah divalidasi
            $data = [
                'email' => $request->input('email2'),
                'id_role' => $user->id_role, // nilai awal diambil dari user yang diupdate
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Jika superadmin mengubah role user lain
            if ($request->has('role') && Auth::user()->id_role == 1 && $user->id_role != $request->input('role')) {
                $data['id_role'] = $request->input('role');
            }

            // Kirim data ke model update data user
            if ($this->modelsuperadmin->update_user($data, $id)) {
                return redirect('/superadmin/datauseraktif')->with('toast_success', 'Data user berhasil diupdate!');
            } else {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Data user gagal diupdate!');
            }
        }

        // Jika melakukan update password
        if ($request->has('ganti_password')) {
            $request->validate(
                [
                    'ganti_password' => 'required|min:6',
                    'konfirmasi_password2' => 'required|same:ganti_password'
                ],
                [
                    'ganti_password.required' => 'Password wajib diisi!',
                    'ganti_password.min' => 'Password minimal 5 karakter!',
                    'ganti_password.confirmed' => 'Konfirmasi password tidak cocok!',
                    'konfirmasi_password2.required' => 'Konfirmasi password wajib diisi!',
                    'konfirmasi_password2.same' => 'Konfirmasi password tidak cocok!',
                ]

            );  

            // input data yang telah divalidasi
            $data = [
                'password' => Hash::make($request->input('ganti_password')),
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Kirim data ke model update data user
            if ($this->modelsuperadmin->update_user($data, $id)) {
                return redirect('/superadmin/datauseraktif')->with('toast_success', 'Password user berhasil diupdate!');
            } else {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Password user gagal diupdate!');
            }
        }

        // aktivasi atau nonaktifkan user
        if ($request->has('aktivasi')) {
            $aktivasi = $request->input('aktivasi');
            $data = [
                'status' => $aktivasi,
                'updated_at' => \Carbon\Carbon::now(),
            ];
            $user = $this->modelsuperadmin->get_user_by_id($id);

            // kondisi untuk memeriksa pengguna yang sedang login sama dengan pengguna yang akan diaktifkan atau dinonaktifkan
            if ($user->id == Auth::user()->id) {
                return back()->with('toast_error', 'Akun Anda tidak bisa dinonaktifkan!');
            }

            // kirim data ke model update user 
            if ($this->modelsuperadmin->update_user($data, $id)) {
                if ($aktivasi == 1) {
                    // Ambil data nama dari tabel pegawai
                    $pegawai = $this->modelsuperadmin->get_data_pegawai($user->nip);
                    $nama = $pegawai->nama;
                    // Buat entri notifikasi untuk pengguna yang diaktifkan
                    $pesan = "Halo " . $nama . "! Selamat datang di Sistem Informasi IT Helpdesk! Akun Anda telah aktif dan dapat menggunakan fitur-fitur yang telah disediakan. Terima kasih!";

                    $notifikasi = [
                        'pesan' => $pesan,
                        'tautan' => '#',
                        'user_id' => $user->id,
                        'created_at' => now()
                    ];

                    $this->modelsuperadmin->input_notifikasi($notifikasi);

                    return redirect('/superadmin/datausernonaktif')->with('toast_success', 'User telah diaktivasi!');
                } elseif ($aktivasi == 0) {
                    return redirect('/superadmin/datauseraktif')->with('toast_success', 'User telah dinonaktifkan!');
                }
            } else {
                return back()->with('toast_error', 'Ubah status user gagal dilakukan!');
            }
        }

        //Untuk update data pegawai
        if ($request->has('nip_pegawai')) {

            $request->validate(
                [
                    'nip_pegawai' => 'required|min:5',
                    'nama_pegawai' => 'required',
                    'bagian_pegawai' => 'required',
                    'jabatan_pegawai' => 'required',
                    'lokasi_pegawai' => 'required',

                ],
                [
                    'nip_pegawai.required' => 'Nip wajib diisi!',
                    'nip_pegawai.min' => 'Nip minimal 5 angka!',
                    'nama_pegawai.required' => 'Nama pegawai wajib diisi!',
                    'bagian_pegawai.required' => 'Unit/bagian pegawai wajib diisi!',
                    'jabatan_pegawai.required' => 'Jabatan pegawai wajib diisi!',
                    'lokasi_pegawai.required' => 'Pilih lokasi pegawai!',
                ]

            );

            // untuk mengubah nama stasiun menjadi id_stasiun
            $nama_stasiun = $request->input('lokasi_pegawai');
            $id_stasiun = $this->modelsuperadmin->getIdStasiun($nama_stasiun);

            // input data yang telah divalidasi
            $data = [
                'nip' => $request->nip_pegawai,
                'nama' => $request->nama_pegawai,
                'bagian' => $request->bagian_pegawai,
                'jabatan' => $request->jabatan_pegawai,
                'id_stasiun' => $id_stasiun,

                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Kirim data ke model update data user
            if ($this->modelsuperadmin->update_pegawai($data, $id)) {
                return redirect('/superadmin/datapegawai')->with('toast_success', 'Data pegawai berhasil diupdate!');
            } else {
                return redirect('/superadmin/datapegawai')->with('toast_error', 'Data pegawai gagal diupdate!');
            }
        }

        return back()->with('toast_error', 'Gagal melakukan update data user!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->has('hapus_user')) {
            //fungsi untuk mencegah superadmin menghapus akunnya sendiri
            $superadminlogin = Auth::user()->id;
            if ($id == $superadminlogin) {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Akun Anda tidak diizinkan untuk dihapus!');
            }

            //jika hapus user lain maka diizinkan termasuk superadmin lain
            if ($this->modeluser->delete_datauser($id)) {
                return back()->with('toast_success', 'User berhasil dihapus!');
            } else {
                return back()->with('toast_error', 'User gagal dihapus!');
            }
        } else if ($request->has('hapus_pegawai')) {
            //fungsi untuk mencegah pegawai menghapus datanya sendiri
            $pegawaiLogin = Auth::user()->nip;
            if ($id == $pegawaiLogin) {
                return back()->with('toast_error', 'Data Anda tidak diizinkan untuk dihapus!');
            }

            //jika hapus data pegawai lain maka diizinkan termasuk superadmin lain
            if ($this->modelsuperadmin->delete_datapegawai($id)) {
                return back()->with('toast_success', 'User berhasil dihapus!');
            } else {
                return back()->with('toast_error', 'User gagal dihapus!');
            }
        } else {
            return back()->with('toast_error', 'Tidak ada data yang dihapus!');
        }
    }
}
