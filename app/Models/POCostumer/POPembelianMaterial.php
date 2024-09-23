<?php

namespace App\Models\POCostumer;

use App\Models\PelangganPemasok\Supplier;
use App\Models\PersediaanBarang\PBWarehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POPembelianMaterial extends Model
{
    use HasFactory;
    protected $table = 'po__pembelian_material';
    protected $fillable = [
        'kode_material',
        'nama_material',
        'kode_supplier',
        'ukuran',
        'qty',
        'no_po',
        'harga_material',
        'total_amount',
    ];

    public function Warehouse()
    {
        return $this->belongsTo(PBWarehouse::class);
    }
    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }
}
