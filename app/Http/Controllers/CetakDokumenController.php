<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CetakDokumenController extends Controller
{
    public function cetak_bast_barang_masuk()
    {
        return view('cetak.form_bast_barang_masuk');
    }
}
