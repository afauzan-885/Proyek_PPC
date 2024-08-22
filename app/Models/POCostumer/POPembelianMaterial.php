<?php

namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBWarehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POPembelianMaterial extends Model
{
    use HasFactory;
    protected $table = 'po__pembelian_material';
    protected $fillable = [
        'nama_material',
        'ukuran',
        'qty',
        'no_po',
        'harga_material',
        'kode_material',
        'total_amount',
      ];

      public function Warehouse()
    {
        return $this->belongsTo(PBWarehouse::class);
    }
}
