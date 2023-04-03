<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyiapkan data pegawai
        $pegawai = [
            [
                'nip' => '12121',
                'nama' => 'John Doe',
                'bagian' => 'IT',
                'jabatan' => 'Programmer',
                'lokasi' => 'Jakarta'
            ],
            [
                'nip' => '12122',
                'nama' => 'Sigit',
                'bagian' => 'IT Support',
                'jabatan' => 'IT Junior Manager',
                'lokasi' => 'Juanda'
            ],
            [
                'nip' => '12123',
                'nama' => 'Ramli',
                'bagian' => 'IT Support',
                'jabatan' => 'Manager',
                'lokasi' => 'Juanda'
            ],
            [
                'nip' => '12124',
                'nama' => 'Nardi',
                'bagian' => 'Marketing',
                'jabatan' => 'Marketing Manager',
                'lokasi' => 'Bogor'
            ]
        ];

        // Memasukkan data pegawai ke dalam tabel pegawai
        DB::table('pegawai')->insert($pegawai);
    }
}
