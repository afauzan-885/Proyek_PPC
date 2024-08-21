<?php

namespace App\Models\POCostumer;

use App\Models\PersediaanBarang\PBWarehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POPembelianMaterial extends Model
{
    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'po__pembelian_material';
    use HasFactory;
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
