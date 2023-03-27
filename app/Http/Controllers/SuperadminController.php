<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

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
            ->select('users.*', 'roles.role_name')
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
