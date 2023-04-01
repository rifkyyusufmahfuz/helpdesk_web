<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {

          // Membuat data roles
          $roles = [
            ['nama_role' => 'superadmin'],
            ['nama_role' => 'admin'],
            ['nama_role' => 'manager'],
            ['nama_role' => 'pegawai'],
        ];

        // Memasukkan data roles ke dalam tabel roles
        Role::insert($roles);

        // Membuat data user dengan menggunakan kolom yang diubah
        $users = [
            [
                'nip' => '12121',
                'nama' => 'John Doe',
                'password' => Hash::make('123'),
                'role_id' => Role::where('nama_role', 'superadmin')->first()->id
            ],
            [
                'nip' => '12122',
                'nama' => 'Jane Doe',
                'password' => Hash::make('123'),
                'role_id' => Role::where('nama_role', 'admin')->first()->id
            ],
            [
                'nip' => '12123',
                'nama' => 'John Smith',
                'password' => Hash::make('123'),
                'role_id' => Role::where('nama_role', 'manager')->first()->id
            ],
            [
                'nip' => '12124',
                'nama' => 'Jane Smith',
                'password' => Hash::make('123'),
                'role_id' => Role::where('nama_role', 'pegawai')->first()->id
            ],
        ];

        // Memasukkan data user ke dalam tabel users
        User::insert($users);


    }
}
