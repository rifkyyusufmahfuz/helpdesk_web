<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $modeluser;

    public function __construct(User $user)
    {
        $this->modeluser = $user;
    }

    public function index()
    {
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.nama_role')
            ->get();

        $roleCounts = [
            'superadmin' => User::where('role_id', 1)->count(),
            'admin' => User::where('role_id', 2)->count(),
            'manager' => User::where('role_id', 3)->count(),
            'pegawai' => User::where('role_id', 4)->count()
        ];

        $roles = Role::all();

        return view('superadmin.index', compact('roleCounts', 'users', 'roles'));
    }

    public function halaman_datauser()
    {
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.nama_role')
            ->get();

        $roleCounts = [
            'superadmin' => User::where('role_id', 1)->count(),
            'admin' => User::where('role_id', 2)->count(),
            'manager' => User::where('role_id', 3)->count(),
            'pegawai' => User::where('role_id', 4)->count()
        ];

        $roles = Role::all();

        return view('superadmin.datauser', compact('roleCounts', 'users', 'roles'));
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
            [
                'nip'  => 'required|unique:users,nip|numeric|digits_between:4,16',
                'nama' => 'required',
                'password' => 'required',
                'role_id' => 'required',
            ],
            [
                'nip.required' => 'NIK tidak boleh kosong!',
                'nip.numeric' => 'NIK harus angka!',
                'nip.digits_between' => 'Jumlah NIK minimal 4 dan maksimal 16 digit!',
                'nama.required' => 'Nama tidak boleh kosong!',
                'password.required' => 'Password tidak boleh kosong!',
                'role_id.required' => 'Role tidak boleh kosong!',
            ]
        );

        $data = [
            'nama' => $request->input('nama'),
            'nip'  => $request->input('nip'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id'),
            'created_at' => \Carbon\Carbon::now(),
        ];

        if ($this->modeluser->insert_datauser($data)) {
            return redirect('/superadmin')->with('toast_success', 'Data user berhasil ditambahkan!');
        } else {
            return redirect('/superadmin')->with('toast_error', 'Data user gagal ditambahkan!');
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
            $superadminRoleId = Role::where('nama_role', 'superadmin')->first()->id;
            if (Auth::user()->role_id == $superadminRoleId && $request->input('role') != $superadminRoleId) {
                return redirect('/superadmin')->with('toast_error', 'Tidak dapat mengubah role sendiri menjadi role selain superadmin!');
            }
        }

        // Jika melakukan update data user
        if ($request->has('nip') || $request->has('nama') || $request->has('role')) {
            // Validasi form
            $request->validate([
                'nip' => 'required|unique:users,nip,' . $id,
                'nama' => 'required',
                'role' => $request->filled('role') ? 'required|exists:roles,id' : ''
            ]);

            $data = [
                'nama' => $request->input('nama'),
                'nip'  => $request->input('nip'),
                'role_id' => $user->role_id, // nilai awal diambil dari user yang diupdate
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Jika superadmin mengubah role user lain
            if ($request->has('role') && Auth::user()->role_id == 1 && $user->role_id != $request->input('role')) {
                $data['role_id'] = $request->input('role');
            }

            // Kirim ke model update data user
            if ($this->modeluser->update_user($data, $id)) {
                return redirect('/superadmin')->with('toast_success', 'Data user berhasil diupdate!');
            } else {
                return redirect('/superadmin')->with('toast_error', 'Data user gagal diupdate!');
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
                return redirect('/superadmin')->with('toast_success', 'Password user berhasil diupdate!');
            } else {
                return redirect('/superadmin')->with('toast_error', 'Password user gagal diupdate!');
            }
        }

        return redirect('/superadmin')->with('error', 'Gagal melakukan update data user atau password!');
    }









    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //fungsi untuk mencegah superadmin menghapus akunnya sendiri
        $superadminlogin = Auth::user()->id;
        if ($id == $superadminlogin) {
            return redirect('/superadmin')->with('toast_error', 'Anda tidak diizinkan untuk menghapus akun sendiri!');
        }

        //jika hapus user lain maka bisa
        if ($this->modeluser->delete_datauser($id)) {
            return redirect('/superadmin')->with('toast_success', 'User berhasil dihapus!');
        } else {
            return redirect('/superadmin')->with('toast_error', 'User gagal dihapus!');
        }
    }
}
