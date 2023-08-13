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

        // $pegawai = [
        //     [
        //         'nip' => '12121',
        //         'nama' => 'Super Admin',
        //         'bagian' => 'IT Support Team',
        //         'jabatan' => 'IT Support Level 3',
        //         'id_stasiun' => 'JUA',
        //         'created_at' => \Carbon\Carbon::now(),
        //     ],
        //     [
        //         'nip' => '1985',
        //         'nama' => 'Sigit Ardiansyah',
        //         'bagian' => 'IT Support Team',
        //         'jabatan' => 'IT Support Level 6',
        //         'id_stasiun' => 'JUA',
        //         'created_at' => \Carbon\Carbon::now(),
        //     ],
        //     [
        //         'nip' => '1360',
        //         'nama' => 'Ongky Sulistyo Wibowo',
        //         'bagian' => 'IT Support Team',
        //         'jabatan' => 'IT Support Level 5',
        //         'id_stasiun' => 'JUA',
        //         'created_at' => \Carbon\Carbon::now(),
        //     ],
        //     [
        //         'nip' => '41249',
        //         'nama' => 'Ramli',
        //         'bagian' => 'IT Support Team',
        //         'jabatan' => 'IT Support Level 3',
        //         'id_stasiun' => 'JUA',
        //         'created_at' => \Carbon\Carbon::now(),
        //     ],
        //     [
        //         'nip' => '12124',
        //         'nama' => 'Nardi',
        //         'bagian' => 'Commercial Division',
        //         'jabatan' => 'Staff',
        //         'id_stasiun' => 'CYR',
        //         'created_at' => \Carbon\Carbon::now(),
        //     ],
        //     [
        //         'nip' => '12125',
        //         'nama' => 'Rifky YM',
        //         'bagian' => 'Information System Planning & Development Departement',
        //         'jabatan' => 'IT Specialist Level 4',
        //         'id_stasiun' => 'BKS',
        //         'created_at' => \Carbon\Carbon::now(),
        //     ]
        // ];

        $pegawai = [
            [
                'nip' => '12121',
                'nama' => 'Super Admin',
                'bagian' => 'IT Support Team',
                'jabatan' => 'IT Support Level 3',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12122',
                'nama' => 'Admin IT Support',
                'bagian' => 'IT Support Team',
                'jabatan' => 'IT Support Level 6',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12123',
                'nama' => 'Admin IT Support 2',
                'bagian' => 'IT Support Team',
                'jabatan' => 'IT Support Level 5',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12124',
                'nama' => 'Manajer IT Support',
                'bagian' => 'IT Support Team',
                'jabatan' => 'IT Support Level 3',
                'id_stasiun' => 'JUA',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12125',
                'nama' => 'Nardi',
                'bagian' => 'Commercial Division',
                'jabatan' => 'Staff',
                'id_stasiun' => 'CYR',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'nip' => '12126',
                'nama' => 'Rifky YM',
                'bagian' => 'CTIP',
                'jabatan' => 'IT Specialist Level 4',
                'id_stasiun' => 'BKS',
                'created_at' => \Carbon\Carbon::now(),
            ]
        ];

        // Memasukkan data pegawai ke dalam tabel pegawai
        DB::table('pegawai')->insert($pegawai);
    }
}
