<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Utils\RomanNumberConverter;
use Illuminate\Support\Facades\DB;


class PermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_software')->insert([
            'operating_system' => true,
            'microsoft_office' => true,
            'software_design' => true,
            'software_lainnya' => true,
        ]);

        //A
        DB::table('otorisasi')->insert([
            'id_otorisasi' => 1,
            'tanggal_approval' => null,
            'status_approval' => 'pending',
            'catatan' => '',
            'id' => null,
            'created_at' => now(),
        ]);


        //B
        for ($i = 1; $i <= 10292; $i++) {
            DB::table('barang')->insert([
                'kode_barang' => 'ABC' . $i,
                'nama_barang' => 'Nama Barang ' . $i,
                'prosesor' => 'Prosesor ' . $i,
                'ram' => 'RAM ' . $i,
                'penyimpanan' => $i . 'GB',
                'status_barang' => 1,
                'jumlah_barang' => 1,
                'created_at' => now(),
            ]);
        }

        //C
        $latestPermintaan = DB::table('permintaan')->orderByDesc('id_permintaan')->first();

        if ($latestPermintaan) {
            $latestId = $latestPermintaan->id_permintaan;
            $lastIdParts = explode('-', $latestId);
            $lastUrutan = intval($lastIdParts[0]);
            $lastBulan = $lastIdParts[3];
            $lastTahun = $lastIdParts[4];

            $bulanSekarang = date('n');
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman($bulanSekarang);
            $tahunSekarang = date('Y');

            if ($lastBulan !== $kodeBulanSekarang || $lastTahun !== $tahunSekarang) {
                $urutanBaru = 1;
            } else {
                $urutanBaru = $lastUrutan + 1;
            }
        } else {
            $urutanBaru = 1;
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman(date('n'));
            $tahunSekarang = date('Y');
        }

        for ($i = 1; $i <= 10292; $i++) {
            $newIdPermintaan = sprintf('%04d', $urutanBaru) . '-KCI-ITHELPDESK-' . $kodeBulanSekarang . '-' . $tahunSekarang;

            $randomDate = \Carbon\Carbon::now()->subDays(rand(1, 365));
            $randomTipePermintaan = (rand(0, 1) == 0) ? 'software' : 'hardware';
            $randomStatusPermintaan = (string) rand(0, 6);

            DB::table('permintaan')->insert([
                'id_permintaan' => $newIdPermintaan,
                'keluhan_kebutuhan' => 'Uraian Kebutuhan ' . $i,
                'tipe_permintaan' => $randomTipePermintaan,
                'status_permintaan' => $randomStatusPermintaan,
                'tanggal_permintaan' => $randomDate,
                'ttd_requestor' => 'requestor_' . $i . '.png',
                'id' => 1,
                'id_kategori' => 1,
                'id_otorisasi' => 1,
                'kode_barang' => 'ABC' . $i,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            $urutanBaru++;
        }


        //D
        $selectedSoftware = [
            'Microsoft Windows',
            'Linux OS',
            'Mac OS',
            'Microsoft Office Standar',
            'Microsoft Office For Mac',
            'Adobe Photoshop',
            'Adobe After Effect',
            'Adobe Premiere',
            'Adobe Ilustrator',
            'Autocad',
            'Sketch Up Pro',
            'Corel Draw',
            'Microsoft Project',
            'Microsoft Visio',
            'Vray Fr Sketchup',
            'Antivirus',
            'Nitro PDF Pro',
            'Open Office',
            'SAP',
            'Lainnya',
        ];

        $permintaan = DB::table('permintaan')->get();

        $softwareData = [];
        foreach ($selectedSoftware as $software) {
            foreach ($permintaan as $item) {
                $randomDate = \Carbon\Carbon::now()->subDays(rand(1, 365));

                $softwareData[] = [
                    'nama_software' => $software,
                    'id_permintaan' => $item->id_permintaan,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ];
            }
        }

        DB::table('software')->insert($softwareData);
    }
}
