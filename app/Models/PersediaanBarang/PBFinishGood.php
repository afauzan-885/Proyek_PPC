<?php

namespace App\Models\PersediaanBarang;
use App\Models\CostumerSupplier;
use App\Models\POCostumer\PO_PM_FgProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PBFinishGood extends Model
{
    use HasFactory;
    protected $table = 'pb__finish_goods';
    protected $fillable = [
        // 'kode_costumer', 
        'kode_barang',
        'nama_barang',
        'no_part',
        'stok_material',
        'harga',
        'tipe_barang',
        'status',
    ];
    public function costumerSupplier()
    {
        return $this->belongsTo(CostumerSupplier::class);
    }
    public function popmprodukfg()
    {
        return $this->hasMany(PO_PM_FgProduct::class);
    }
}
