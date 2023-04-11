<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\StasiunModel;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyiapkan data pegawai
        $stasiun = StasiunModel::all();

        $pegawai = [
            [
                'nip' => '12121',
                'nama' => 'John Doe',
                'bagian' => 'IT',
                'jabatan' => 'Programmer',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12122',
                'nama' => 'Sigit',
                'bagian' => 'IT Support',
                'jabatan' => 'IT Junior Manager',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12123',
                'nama' => 'Ramli',
                'bagian' => 'IT Support',
                'jabatan' => 'Manager',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12124',
                'nama' => 'Nardi',
                'bagian' => 'Marketing',
                'jabatan' => 'Marketing Manager',
                'id_stasiun' => 'CYR',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12125',
                'nama' => 'Rifky YM',
                'bagian' => 'CTIO',
                'jabatan' => 'Programmer',
                'id_stasiun' => 'BKS',
                'created_at' => \Carbon\Carbon::now(),
            ]
        ];

        // Memasukkan data pegawai ke dalam tabel pegawai
        DB::table('pegawai')->insert($pegawai);
    }
}
