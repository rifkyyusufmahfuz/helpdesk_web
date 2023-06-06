<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ManagerModel extends Model
{
    use HasFactory;


    public function get_data_permintaan()
    {
        return DB::table('permintaan')
        ->where('tipe_permintaan', 'software')->get();
    }
}
