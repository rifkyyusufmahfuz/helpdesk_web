<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use App\Models\RegisterModel;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{

    protected $modelregister;
    public function __construct()
    {
        $this->modelregister = new RegisterModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_stasiun = $this->modelregister->data_stasiun();

        return view('auth.register', [
            'data_stasiun' => $data_stasiun,
        ]);
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
        // validate form input
        $request->validate([
            'nip' => 'required|unique:pegawai',
            'nama' => 'required',
            'bagian' => 'required',
            'jabatan' => 'required',
            'lokasi' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:3'
        ]);

        // ubah value nama stasiun menjadi id_stasiun
        $nama_stasiun = $request->input('lokasi');
        $id_stasiun = $this->modelregister->getIdStasiun($nama_stasiun);

        // tambah ke tabel pegawai
        $data = [
            'nip' => $request->nip,
            'nama' => $request->nama,
            'bagian' => $request->bagian,
            'jabatan' => $request->jabatan,
            'id_stasiun' => $id_stasiun,
            'create_at' => \Carbon\Carbon::now(),
        ];
        $this->modelregister->registrasi_pegawai($data);


        // tambah ke tabel users
        $data2 = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'id_role' => 4,
            'create_at' => \Carbon\Carbon::now(),
        ];
        $this->modelregister->registrasi_user($data2);


        return redirect('/')->with('toast_success', 'Registrasi berhasil! Akun Anda akan segera diaktifkan oleh Administrator!');
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
