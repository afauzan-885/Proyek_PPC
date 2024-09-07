<?php
namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBFinishGood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO_PM_FgProduct extends Model
{     
    use HasFactory;
    protected $table = 'po__pm__produk_fg';
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'shift_produksi',
        'qty_awal',
        'qty_in',
        // 'qty_out',
    ];
    public function finishgood()
    {
        return $this->belongsTo(PBFinishGood::class); // Hubungkan berdasarkan kode_material
    }
}


