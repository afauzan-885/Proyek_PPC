<?php
namespace App\Models\POCostumer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO_PM_WipProduct extends Model
{
    use HasFactory;
    protected $table = 'po__pm__produk_wip';
    protected $fillable = [
        'nama_produk',
        'tanggal_produksi',
        'shift',
        'no_mesin',
        'proses_produksi',
        'hasil_ok',
        'hasil_ng',
    ];
}


