<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Utils\RomanNumberConverter;

class PermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoriSoftwareId = DB::table('kategori_software')->insertGetId([
            'operating_system' => true,
            'microsoft_office' => true,
            'software_design' => true,
            'software_lainnya' => true,
        ]);

        $otorisasiId = DB::table('otorisasi')->insertGetId([
            'id_otorisasi' => 1,
            'tanggal_approval' => null,
            'status_approval' => 'pending',
            'catatan' => '',
            'id' => null,
            'created_at' => now(),
        ]);

        $barangData = [];
        $bastData = [];
        $permintaanData = [];

        for ($i = 1; $i <= 200; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 365));
            $randomStatus = (rand(0, 1) == 0) ? 'diterima' : 'dikembalikan';

            $barangData[] = [
                'kode_barang' => 'KCI-213' . $i,
                'nama_barang' => 'Nama Barang ' . $i,
                'prosesor' => 'Prosesor ' . $i,
                'ram' =>  $i . 'GB',
                'penyimpanan' => $i . 'GB',
                'status_barang' => $randomStatus,
                'jumlah_barang' => 1,
                'created_at' => $randomDate,
            ];

            $newIdPermintaan = sprintf('%04d', $i) . '-KCI-ITHELPDESK-' . RomanNumberConverter::convertMonthToRoman(date('n')) . '-' . date('Y');

            $randomTipePermintaan = (rand(0, 1) == 0) ? 'software' : 'hardware';
            $randomStatusPermintaan = (string) rand(0, 6);

            $permintaanData[] = [
                'id_permintaan' => $newIdPermintaan,
                'keluhan_kebutuhan' => 'Uraian Kebutuhan ' . $i,
                'tipe_permintaan' => $randomTipePermintaan,
                'status_permintaan' => $randomStatusPermintaan,
                'tanggal_permintaan' => $randomDate,
                'ttd_requestor' => 'requestor_' . $i . '.png',
                'id' => 1,
                'id_kategori' => $kategoriSoftwareId,
                'id_otorisasi' => $otorisasiId,
                'kode_barang' => 'KCI-213' . $i,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ];

            $stasiunIds = DB::table('stasiun')->pluck('id_stasiun')->toArray();
            $pegawaiNips = DB::table('pegawai')->pluck('nip')->toArray();

            if ($randomStatus == 'dikembalikan') {
                $bastData[] = [
                    'id_bast' => 'BAST-' . sprintf('%03d', $i),
                    'tanggal_bast' => $randomDate,
                    'jenis_bast' => 'barang_keluar',
                    'perihal' => 'Perihal ' . $i,
                    'ttd_menyerahkan' => 'Penyerah ' . $i,
                    'ttd_menerima' => 'Penerima ' . $i,
                    'yang_menyerahkan' => $pegawaiNips[array_rand($pegawaiNips)],
                    'yang_menerima' => $pegawaiNips[array_rand($pegawaiNips)],
                    'id_permintaan' => $newIdPermintaan,
                    'id_stasiun' => $stasiunIds[array_rand($stasiunIds)],
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ];
            } else {
                $bastData[] = [
                    'id_bast' => 'BAST-' . sprintf('%03d', $i),
                    'tanggal_bast' => $randomDate,
                    'jenis_bast' => 'barang_masuk',
                    'perihal' => 'Perihal ' . $i,
                    'ttd_menyerahkan' => 'Penyerah ' . $i,
                    'ttd_menerima' => 'Penerima ' . $i,
                    'yang_menyerahkan' => $pegawaiNips[array_rand($pegawaiNips)],
                    'yang_menerima' => $pegawaiNips[array_rand($pegawaiNips)],
                    'id_permintaan' => $newIdPermintaan,
                    'id_stasiun' => $stasiunIds[array_rand($stasiunIds)],
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ];
            }
        }

        DB::table('barang')->insert($barangData);
        DB::table('permintaan')->insert($permintaanData);
        DB::table('bast')->insert($bastData);
    }
}
