<?php

namespace Database\Seeders;

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
                'user_id' => 4,
                'role_id' => null,
                'pesan' => 'Selamat datang di Sistem Informasi IT Helpdesk!',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => 5,
                'role_id' => null,
                'pesan' => 'Selamat datang di Sistem Informasi IT Helpdesk!',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => null,
                'role_id' => 2,
                'pesan' => 'Pemberitahuan untuk admin (Test)',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'user_id' => null,
                'role_id' => 2,
                'pesan' => 'Pemberitahuan untuk admin 2 (Test)',
                'tautan' => '#',
                'created_at' => \Carbon\Carbon::now(),
            ],
        ];

        // Memasukkan data pegawai ke dalam tabel pegawai
        DB::table('notifikasi')->insert($notif);
    }
}
