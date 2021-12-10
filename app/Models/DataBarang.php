<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataBarang extends Model
{
    use HasFactory;
    public $primaryKey = 'idBarang';
    protected $fillable = [
        'namaBarang', 'idPenjual', 'foto', 'hargaBarang'
    ];
    static function getDataBarang($s=null)
    {
        $return=DB::table('data_barangs')
        ->where('namaBarang','like',"%$s%")
        ->join('nama_penjuals','data_barangs.idPenjual','nama_penjuals.idPenjual');
        return $return;
    }

}
