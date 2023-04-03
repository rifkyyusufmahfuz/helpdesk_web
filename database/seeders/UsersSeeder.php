<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'superadmin',
                'password' => Hash::make('123'),
                'id_role' => Role::where('nama_role', 'superadmin')->first()->id_role,
                'nip'=> '12121'
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('123'),
                'id_role' => Role::where('nama_role', 'admin')->first()->id_role,
                'nip'=> '12122'
            ],
            [
                'username' => 'manager',
                'password' => Hash::make('123'),
                'id_role' => Role::where('nama_role', 'manager')->first()->id_role,
                'nip'=> '12123'
            ],
            [
                'username' => 'pegawai',
                'password' => Hash::make('123'),
                'id_role' => Role::where('nama_role', 'pegawai')->first()->id_role,
                'nip'=> '12124'
            ],
        ];

        // Memasukkan data user ke dalam tabel users
        User::insert($users);
    }
}
