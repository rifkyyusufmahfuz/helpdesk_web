<?php

namespace App\Http\Controllers;

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
        ];

        return view('superadmin.index', $data);
    }

    public function halaman_datauser()
    {
        $data = [
            'data_user' => $this->modelsuperadmin->data_user_lengkap(),
            'data_role' => $this->modelsuperadmin->get_data_role(),
            'roleCounts' => $this->modelsuperadmin->hitung_user_by_role(),
            'nip_pegawai' => $this->modelsuperadmin->get_nip_unregistered(),
        ];

        return view('superadmin.datauser', $data);
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
        if ($request->input('jenis_input') == 'data_pegawai') {
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
        } else if ($request->input('jenis_input') == 'data_user') {
            $request->validate([
                //data user
                'username' => 'required|unique:users,username',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'id_role' => 'required',

                //data pegawai
                'nip_pegawai'  => 'required',
                'nama_pegawai' => 'required',
                'bagian_pegawai' => 'required',
                'jabatan_pegawai' => 'required',
                'lokasi_pegawai' => 'required',
            ], [
                'password.required' => 'Password tidak boleh kosong!',
                'confirm_password.required' => 'Konfirmasi Password tidak boleh kosong!',
                'confirm_password.same' => 'Password tidak cocok!',
                'id_role.required' => 'Role tidak boleh kosong!',

                'nip_pegawai.required' => 'NIK tidak boleh kosong!',
                'nama_pegawai.required' => 'Nama tidak boleh kosong!',
                'bagian_pegawai.required' => 'Bagian tidak boleh kosong!',
                'jabatan_pegawai.required' => 'Jabatan tidak boleh kosong!',
                'lokasi_pegawai.required' => 'Lokasi tidak boleh kosong!',
            ]);

            $data = [
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'id_role' => $request->input('role'),
                'nip'  => $request->input('nip_pegawai'),
                'created_at' => \Carbon\Carbon::now(),
            ];

            // melakukan proses penyimpanan data user
            if ($this->modelsuperadmin->insert_datauser($data)) {
                return redirect('/superadmin/datauser')->with('toast_success', 'Data user berhasil ditambahkan!');
            } else {
                return redirect('/superadmin/datauser')->with('toast_error', 'Data user gagal ditambahkan!');
            }
        } else {
            // jika jenis input tidak valid, lakukan sesuai kebutuhan
            return redirect('/superadmin/datauser')->with('toast_error', 'Data gagal ditambahkan!');
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

    public function update(Request $request, $id)
    {
        // Ambil data user yang akan diupdate
        $user = $this->modeluser->get_user_by_id($id);

        // Jika superadmin mencoba mengupdate rolenya sendiri
        if ($user->id == Auth::user()->id && $request->has('role')) {
            $superadminRoleId = RoleModel::where('nama_role', 'superadmin')->first()->id_role;
            if (Auth::user()->id_role == $superadminRoleId && $request->input('role') != $superadminRoleId) {
                return redirect('/superadmin/datauser')->with('toast_error', 'Tidak dapat mengubah role sendiri menjadi role selain superadmin!');
            }
        }

        // Jika melakukan update data user
        if ($request->has('nip') || $request->has('nama') || $request->has('role')) {
            // Validasi form
            $request->validate([
                'nip' => 'required|unique:users,nip,' . $id,
                'nama' => 'required',
                'role' => $request->filled('role') ? 'required|exists:roles,id_role' : ''
            ]);

            $data = [
                'nama' => $request->input('nama'),
                'nip'  => $request->input('nip'),
                'id_role' => $user->id_role, // nilai awal diambil dari user yang diupdate
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Jika superadmin mengubah role user lain
            if ($request->has('role') && Auth::user()->id_role == 1 && $user->id_role != $request->input('role')) {
                $data['id_role'] = $request->input('role');
            }

            // Kirim ke model update data user
            if ($this->modeluser->update_user($data, $id)) {
                return redirect('/superadmin/datauser')->with('toast_success', 'Data user berhasil diupdate!');
            } else {
                return redirect('/superadmin/datauser')->with('toast_error', 'Data user gagal diupdate!');
            }
        }

        // Jika melakukan update password
        if ($request->has('password')) {
            $request->validate([
                'password' => 'required|min:3'
            ]);

            $data = [
                'password' => $request->input('password'),
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Kirim ke model update data user
            if ($this->modeluser->update_user($data, $id)) {
                return redirect('/superadmin/datauser')->with('toast_success', 'Password user berhasil diupdate!');
            } else {
                return redirect('/superadmin/datauser')->with('toast_error', 'Password user gagal diupdate!');
            }
        }

        return redirect('/superadmin/datauser')->with('error', 'Gagal melakukan update data user atau password!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //fungsi untuk mencegah superadmin menghapus akunnya sendiri
        $superadminlogin = Auth::user()->id;
        if ($id == $superadminlogin) {
            return redirect('/superadmin/datauser')->with('toast_error', 'Anda tidak diizinkan untuk menghapus akun sendiri!');
        }

        //jika hapus user lain maka bisa
        if ($this->modeluser->delete_datauser($id)) {
            return redirect('/superadmin/datauser')->with('toast_success', 'User berhasil dihapus!');
        } else {
            return redirect('/superadmin/datauser')->with('toast_error', 'User gagal dihapus!');
        }
    }
}
