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

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array
     */
    use HasFactory;
    protected $fillable = [
        'nama_material',
        'ukuran',
        'quantity',
        'no_po',
        'harga',
        'kode_barang',
        'total_amount',
      ];

      public function Warehouse()
    {
        return $this->belongsTo(PBWarehouse::class, 'kode_material', 'kode_material');
    }
}
