<?php

namespace App\Http\Controllers;

use App\Models\CetakDokumenModel;
use Illuminate\Http\Request;


class CetakDokumenController extends Controller
{
    //untuk mendefinisikan model pegawai
    protected $modelcetak;

    public function __construct()
    {
        $this->modelcetak = new CetakDokumenModel();
    }

    public function cetak_bast_barang_masuk($id_permintaan)
    {
        $data_bast_masuk = $this->modelcetak->get_bast_by_id_permintaan($id_permintaan);

        if ($data_bast_masuk->isNotEmpty()) {
            $tanggal_bast = $data_bast_masuk[0]->tanggal_bast;
            $date = \Carbon\Carbon::parse($tanggal_bast);
            $namahari = $date->isoFormat('dddd');

            $tanggal = $date->isoFormat('D MMMM Y');
        }


        return view('cetak.form_bast_barang_masuk', [
            'data_bast_masuk' => $data_bast_masuk,
            'hari' => $namahari,
            'tanggal' => $tanggal
        ]);
    }
}
