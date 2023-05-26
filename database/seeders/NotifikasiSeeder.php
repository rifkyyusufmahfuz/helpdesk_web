<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notif = [
            [
                'user_id' => 5,
                'tipe_pesan' => 'high',
                'pesan' => 'Ini adalah pesan otomatis dari sistem.',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => 5,
                'tipe_pesan' => 'med',
                'pesan' => 'Ini adalah pesan otomatis kedua dari sistem.',
                'created_at' => \Carbon\Carbon::now(),
            ],
        ];

        // Memasukkan data pegawai ke dalam tabel pegawai
        DB::table('notifikasi')->insert($notif);
    }
}
