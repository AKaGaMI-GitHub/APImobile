<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NamaPenjual extends Model
{
    use HasFactory;
    public $primaryKey = 'idPenjual';
    protected $fillable = [
        'namaPenjual', 'alamatPenjual', 'noPenjual'
    ];
    static function getNamaPenjual()
    {
        $return=DB::table('nama_penjuals');
        return $return;
    }
}
