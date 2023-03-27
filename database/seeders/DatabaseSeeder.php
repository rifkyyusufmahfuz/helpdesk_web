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
            ['role_name' => 'superadmin'],
            ['role_name' => 'admin'],
            ['role_name' => 'manager'],
            ['role_name' => 'pegawai'],
        ];

        // Memasukkan data roles ke dalam tabel roles
        Role::insert($roles);

        // Membuat data user dengan menggunakan kolom yang diubah
        $users = [
            [
                'nip' => '12121',
                'nama' => 'John Doe',
                'password' => Hash::make('123'),
                'role_id' => Role::where('role_name', 'superadmin')->first()->id
            ],
            [
                'nip' => '12122',
                'nama' => 'Jane Doe',
                'password' => Hash::make('123'),
                'role_id' => Role::where('role_name', 'admin')->first()->id
            ],
            [
                'nip' => '12123',
                'nama' => 'John Smith',
                'password' => Hash::make('123'),
                'role_id' => Role::where('role_name', 'manager')->first()->id
            ],
            [
                'nip' => '12124',
                'nama' => 'Jane Smith',
                'password' => Hash::make('123'),
                'role_id' => Role::where('role_name', 'pegawai')->first()->id
            ],
        ];

        // Memasukkan data user ke dalam tabel users
        User::insert($users);


    }
}
