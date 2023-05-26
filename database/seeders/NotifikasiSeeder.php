<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Util\LinkParserHelper;

class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notif = [
            [
                'user_id' => 4,
                'role_id' => null,
                'pesan' => 'Ini adalah pesan otomatis dari sistem untuk pegawai 1.',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => 5,
                'role_id' => null,
                'pesan' => 'Ini adalah pesan otomatis kedua dari sistem.',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => null,
                'role_id' => 2,
                'pesan' => 'Pemberitahuan untuk admin',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => null,
                'role_id' => 2,
                'pesan' => 'Pemberitahuan untuk admin 2',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
        ];

        // Memasukkan data pegawai ke dalam tabel pegawai
        DB::table('notifikasi')->insert($notif);
    }
}
