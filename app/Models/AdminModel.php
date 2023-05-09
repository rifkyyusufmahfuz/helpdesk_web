<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminModel extends Model
{
    use HasFactory;

    public function get_permintaan_software()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'roles.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
            )
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }

    public function get_permintaan_software_by_id($id_permintaan)
    {
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->select('permintaan.*', 'otorisasi.*', 'kategori_software.*', 'users.*', 'roles.*', 'pegawai.*', 'stasiun.*')
            ->where('permintaan.id_permintaan', '=', $id_permintaan)
            ->orderBy('permintaan.updated_at', 'desc')
            ->get();
    }

    public function get_software_by_id($id_permintaan)
    {
        return DB::table('software')
            ->where('id_permintaan', '=', $id_permintaan)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function input_software($data)
    {
        if (DB::table('software')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function hapus_software($id)
    {
        if (DB::table('software')->where('id_software', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_permintaan($data, $id)
    {
        return DB::table('permintaan')->where('id_permintaan', $id)->update($data) ? true : false;
    }

    // public function get_data_barang()
    // {
    //     return DB::table('barang')->get();
    // }

    public function get_barang_by_id_permintaan($id)
    {
        return DB::table('barang')->where('id_permintaan', $id)->get();
    }


    public function input_barang($data2)
    {
        if (DB::table('barang')->insert($data2)) {
            return true;
        } else {
            return false;
        }
    }

    public function tindak_lanjut_permintaan_software(Request $request)
    {
        //Tanda tangan
        $folderPath = public_path('tandatangan/admin/');
        if (!is_dir($folderPath)) {
            //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
            mkdir($folderPath, 0777, true);
        }

        $filename = "admin_" . uniqid() . ".png";
        $nama_file = $folderPath . $filename;
        file_put_contents($nama_file, file_get_contents($request->input('signature')));


        //Mendefinisikan beberapa data utama
        $id_permintaan = $request->input('id_permintaan');
        $id_otorisasi = $request->input('id_otorisasi');
        $id = auth()->user()->id;

        $tindak_lanjut_software = DB::table('tindak_lanjut')->insert([
            'tanggal_penanganan' => null,
            'ttd_admin' => $filename,
            'id' => $id,
            'id_permintaan' => $id_permintaan,
            'created_at' => now(),
        ]);

        $ajukan_ke_manager = DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update([
            'status_approval' => 'waiting',
            'updated_at' => now()
        ]);

        $update_permintaan = DB::table('permintaan')->where('id_permintaan', $id_permintaan)->update([
            'status_permintaan' => 2,
            'updated_at' => now(),
        ]);


        if ($ajukan_ke_manager && $tindak_lanjut_software && $update_permintaan) {
            return true;
        } else {
            return false;
        }
    }
}
